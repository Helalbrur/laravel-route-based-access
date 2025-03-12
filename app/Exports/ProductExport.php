<?php

namespace App\Exports;

use App\Models\ProductDetailsMaster;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements  FromCollection, WithHeadings
{
    public function collection()
    {
        return ProductDetailsMaster::all()->map(function ($product) {
            return [
                'company_id'     => $product->company->company_name ?? '',
                'supplier_id'    => $product->supplier->supplier_name ?? '',
                'item_category_id' => $product->itemCategory->category_name ?? '',
                // 'item_group_id'   => $product->itemGroup->group_name ?? '',
                'item_description' => $product->item_description,
                // 'product_name_details' => $product->product_name_details,
                // 'lot'            => $product->lot,
                'item_code'      => $product->item_code,
                // 'item_account'   => $product->item_account,
                'packing_type'   => $product->packing_type,
                // 'uom'            => $product->productUom->uom_name ?? '',
                // 'avg_rate_per_unit' => $product->avg_rate_per_unit,
                // 'current_stock'  => $product->current_stock,
                // 'stock_value'    => $product->stock_value,
                'generic_id'     => $product->generic->generic_name ?? '',
                'item_sub_category_id' => $product->itemSubCategory->sub_category_name ?? '',
                'item_type'      => $product->item_type,
                'item_origin'    => $product->item_origin,
                'brand_id'       => $product->brand->brand_name ?? '',
                'dosage_form'    => $product->dosage_form,
                'color_id'       => $product->color->color_name ?? '',
                'order_uom'      => $product->orderUom->uom_name ?? '',
                // 'order_uom_qty'  => $product->order_uom_qty,
                'consuption_uom' => $product->consuptionUom->uom_name ?? '',
                'consuption_uom_qty' => $product->consuption_uom_qty,
                'conversion_fac' => $product->conversion_fac,
                'size_id'        => $product->size->size_name ?? '',
                'power'          => $product->power,
                'created_by'     => $product->createdBy->name ?? '',
                'updated_by'     => $product->updatedBy->name ?? ''
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Company',
            'Supplier',
            'Item Category',
            // 'Item Group',
            'Item Description',
            // 'Product Name Details',
            // 'Lot',
            'Item Code',
            // 'Item Account',
            'Type',
            // 'UOM',
            // 'Rate',
            // 'Current Stock',
            // 'Stock Value',
            'Generic',
            'Item Sub Category',
            'Item Type',
            'Item Origin',
            'Brand',
            'Dosage Form',
            'Color',
            'Order UOM',
            // 'Order UOM Qty',
            'Consuption UOM',
            'Re Order Level',
            'Conversion Fac',
            'Size',
            'Power',
            'Created By',
            'Updated By'
        ];
    }
}

?>