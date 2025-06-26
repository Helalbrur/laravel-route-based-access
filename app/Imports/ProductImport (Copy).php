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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProductDetailsMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    public $importedCount = 0;
    public $skippedRows = [];
    
    public function collection(Collection $rows)
    {
        DB::beginTransaction(); // Start transaction

        try {
            $insertData = [];
            $rowNumber = 1;
            
              // ✅ Normalize and validate headers from the first row
            $firstRow = $rows->first();
            $normalizedHeaders = [];
            foreach ($firstRow->keys() as $header) {
                $normalizedHeaders[] = strtolower(trim(str_replace('*', '', $header)));
            }
    
            $requiredHeaders = [
                'company', 'supplier', 'item_category', 'item_description',
                'order_uom', 'consuption_uom', 'conversion_fac',
                'item_sub_category', 'brand', 'size', 'dosage_form',
                'color', 'generic'
            ];
    
            $missingHeaders = array_diff($requiredHeaders, $normalizedHeaders);
            if (count($missingHeaders)) {
                Log::info("Missing required columns: " . implode(', ', $missingHeaders));
                throw new \Exception("Missing required columns: " . implode(', ', $missingHeaders));
            }

            foreach ($rows as $row) {
                $rowNumber++;
                
                // ✅ Normalize row keys
                $normalizedRow = [];
                foreach ($row as $key => $value) {
                    $normalizedKey = strtolower(trim(str_replace('*', '', $key)));
                    $normalizedRow[$normalizedKey] = $value;
                }
                $row = collect($normalizedRow);
                Log::info('Import started...');

                // Validate row
                $validator = Validator::make($row->toArray(), [
                    'company'           => 'required|string',
                    'supplier'          => 'required|string',
                    'item_category'     => 'required|string',
                    //'item_group'        => 'required|string',
                    'item_description'  => 'required|string',
                    // 'uom'               => 'required|string',
                    'order_uom'         => 'required|string',
                    'consuption_uom'    => 'required|string',
                    'conversion_fac'    => 'required|numeric|min:0',
                    'item_sub_category' => 'required|string',
                    'brand'             => 'required|string',
                    'size'              => 'required|string',
                    'dosage_form'       => 'required|string',
                    
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors()->all();
                    $this->skippedRows[] = [
                        'row' => $rowNumber,
                        'reason' => $errors
                    ];
                    Log::info("Validation failed at row {$rowNumber}: " . implode(', ', $errors));

                    throw new \Exception("Validation failed at row {$rowNumber}: " . implode(', ', $errors));
                }


                // Get IDs of referenced models
                $company_id        = optional(Company::where('company_name', $row['company'])->first())->id;
                $supplier_id       = $this->getOrCreateModel(LibSupplier::class, 'supplier_name', $row['supplier'])->id ?? 0;
                $item_category_id  = $this->getOrCreateModel(LibCategory::class, 'category_name', $row['item_category'])->id ?? 0;
                $item_group_id     = $this->getOrCreateModel(LibItemGroup::class, 'item_name', ($row['item_group'] ?? 0))->id ?? 0;
                $uom_id            = $this->getOrCreateModel(LibUom::class, 'uom_name', $row['consuption_uom'])->id ?? 0;
                $item_sub_category = $this->getOrCreateModel(LibItemSubCategory::class, 'sub_category_name', $row['item_sub_category'])->id ?? 0;
                $generic_id        = $this->getOrCreateModel(LibGeneric::class, 'generic_name', $row['generic'])->id ?? 0;
                $brand_id          = $this->getOrCreateModel(LibBrand::class, 'brand_name', $row['brand'])->id ?? 0;
                $size_id           = $this->getOrCreateModel(LibSize::class, 'size_name', $row['size'])->id ?? 0;

                // Check for duplicates
                $existingProduct = ProductDetailsMaster::where([
                    'company_id'       => $company_id,
                    'supplier_id'      => $supplier_id,
                    'item_category_id' => $item_category_id,
                    'item_group_id'    => $item_group_id,
                    'item_description' => $row['item_description'],
                    'consuption_uom'   => $uom_id,
                    'item_sub_category_id' => $item_sub_category,
                    'generic_id'       => $generic_id,
                    'brand_id'         => $brand_id,
                    'size_id'          => $size_id,
                    'dosage_form'      => $row['dosage_form'] ?? '',
                    'power'            => $row['power'] ?? '',
                ])->exists();

                if ($existingProduct) {
                    $this->skippedRows[] = [
                        'row' => $rowNumber,
                        'reason' => ['Duplicate entry']
                    ];
                    Log::info("Duplicate entry found at row {$rowNumber}");

                    throw new \Exception("Duplicate entry found at row {$rowNumber}");
                }


                // Prepare data for bulk insertion
                $insertData = [
                    'company_id'        => $company_id,
                    'supplier_id'       => $supplier_id,
                    'item_category_id'  => $item_category_id,
                    'item_group_id'     => $item_group_id,
                    'item_sub_category_id' => $item_sub_category,
                    'brand_id'         => $brand_id,
                    'color_id'         => $this->getOrCreateModel(LibColor::class, 'color_name', $row['color'])->id ?? 0,
                    'size_id'          => $size_id,
                    'generic_id'       => $generic_id,
                    'uom'              => $uom_id,
                    'order_uom'        => $this->getOrCreateModel(LibUom::class, 'uom_name', $row['order_uom'])->id ?? 0,
                    'consuption_uom'   => $this->getOrCreateModel(LibUom::class, 'uom_name', $row['consuption_uom'])->id ?? $uom_id,
        
                    // Other product fields
                    'item_description'  => $row['item_description'] ?? '',
                    'product_name_details' => ($row['product_name_details'] ?? $row['item_description']) ?? '',
                    'lot'              => $row['lot'] ?? '',
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
                ];
                if (!empty($insertData)) {
               
                    $this->importedCount++;
                }
                ProductDetailsMaster::create($insertData);
            }

            // If there are no skipped rows, insert all data at once
            

            DB::commit(); // Commit transaction

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            throw $e; // Throw exception to be handled in the controller
        }
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
