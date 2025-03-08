<?php

namespace App\Imports;

use App\Models\LibUom;
use App\Models\Company;
use App\Models\LibSize;
use App\Models\LibBrand;
use App\Models\LibColor;
use App\Models\LibGeneric;
use App\Models\LibCategory;
use App\Models\LibSupplier;
use App\Models\LibItemGroup;
use App\Models\LibItemSubCategory;
use App\Models\ProductDetailsMaster;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Define validation rules
        $validator = Validator::make($row, [
            'company'           => 'required|string',
            'supplier'          => 'required|string',
            'item_category'     => 'required|string',
            'item_group'        => 'required|string',
            'item_description'  => 'required|string',
            'uom'               => 'required|string',
            'order_uom'         => 'required|string',
            'consuption_uom'    => 'required|string',
            'conversion_fac'    => 'required|numeric|min:0',
        ]);

        // If validation fails, skip this row
        if ($validator->fails()) {
            return null;
        }

        $company_id        = optional(Company::where('company_name', $row['company'])->first())->id;
        $supplier_id       = $this->getOrCreateModel(LibSupplier::class, 'supplier_name', $row['supplier'])->id ?? null;
        $item_category_id  = $this->getOrCreateModel(LibCategory::class, 'category_name', $row['item_category'])->id ?? null;
        $item_group_id     = $this->getOrCreateModel(LibItemGroup::class, 'item_name', $row['item_group'])->id ?? null;
        $uom_id            = $this->getOrCreateModel(LibUom::class, 'uom_name', $row['uom'])->id ?? null;
        
        // Check if the product already exists
        $existingProduct = ProductDetailsMaster::where([
            'company_id'       => $company_id,
            'supplier_id'      => $supplier_id,
            'item_category_id' => $item_category_id,
            'item_group_id'    => $item_group_id,
            'item_description' => $row['item_description'],
            'uom'              => $uom_id
        ])->exists();

        if ($existingProduct) {
            return null; // Skip creating a duplicate record
        }

        return new ProductDetailsMaster([
            'company_id'        => $company_id,
            'supplier_id'       => $supplier_id,
            'item_category_id'  => $item_category_id,
            'item_group_id'     => $item_group_id,
            'item_sub_category_id' => $this->getOrCreateModel(LibItemSubCategory::class, 'sub_category_name', $row['item_sub_category'])->id ?? null,
            'brand_id'         => $this->getOrCreateModel(LibBrand::class, 'brand_name', $row['brand'])->id ?? null,
            'color_id'         => $this->getOrCreateModel(LibColor::class, 'color_name', $row['color'])->id ?? null,
            'size_id'          => $this->getOrCreateModel(LibSize::class, 'size_name', $row['size'])->id ?? null,
            'generic_id'       => $this->getOrCreateModel(LibGeneric::class, 'generic_name', $row['generic'])->id ?? null,
            'uom'              => $uom_id,
            'order_uom'        => $this->getOrCreateModel(LibUom::class, 'uom_name', $row['order_uom'])->id ?? null,
            'consuption_uom'   => $this->getOrCreateModel(LibUom::class, 'uom_name', $row['consuption_uom'])->id ?? null,

            // Other product fields
            'item_description'  => $row['item_description'] ?? '',
            'product_name_details' => $row['product_name_details'] ?? '', // Prevent null values
            'lot'              => $row['lot'] ?? '',
            'item_code'        => $row['item_code'] ?? '',
            'item_account'     => $row['item_account'] ?? '',
            'packing_type'     => $row['packing_type'] ?? '',
            'avg_rate_per_unit'=> $row['avg_rate_per_unit'] ?? 0,
            'current_stock'    => $row['current_stock'] ?? 0,
            'stock_value'      => $row['stock_value'] ?? 0,
            'item_type'        => $row['item_type'] ?? '',
            'item_origin'      => $row['item_origin'] ?? '',
            'dosage_form'      => $row['dosage_form'] ?? '',
            'order_uom_qty'    => $row['order_uom_qty'] ?? 0,
            'consuption_uom_qty' => $row['consuption_uom_qty'] ?? 0,
            'conversion_fac'   => $row['conversion_fac'] ?? 0,
            'power'            => $row['power'] ?? '',
            'created_by'       => Auth::id(),
            'updated_by'       => Auth::id(),
        ]);
    }

    private function getOrCreateModel($model, $column, $value)
    {
        if (empty($value)) {
            return null;
        }

        return $model::firstOrCreate(
            [$column => $value],
            ['created_by' => Auth::id()]
        );
    }
}


