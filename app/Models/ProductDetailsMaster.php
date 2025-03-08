<?php

namespace App\Models;

use App\Models\Company;
use App\Models\LibCategory;
use App\Models\VariableSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetailsMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_details_master';
    protected $fillable = [
        'company_id', 'supplier_id', 'store_id', 'item_category_id', 'detarmination_id', 'item_group_id',
        'item_description', 'product_name_details', 'lot', 'item_code', 'item_account', 'packing_type', 'uom',
        'avg_rate_per_unit', 'current_stock', 'stock_value', 'generic_id', 'item_sub_category_id', 'item_type',
        'item_origin', 'brand_id', 'dosage_form', 'color_id', 'order_uom', 'order_uom_qty', 'consuption_uom',
        'consuption_uom_qty', 'conversion_fac', 'size_id', 'power', 'created_by', 'updated_by','is_system_generated_item_code'
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($item) {
            $item->created_by = Auth::id();
            
            // Get variable setting value in one query
            $is_item_code_system_generated = VariableSetting::where('company_id', $item->company_id)
                ->where('variable_id', 1)
                ->value('variable_value') ?? 0;

            if ($is_item_code_system_generated == 1) {
                $item->item_code = self::generate_item_code($item->company_id, $item->item_category_id);
                $item->is_system_generated_item_code = 1;
            }
        });

        // Automatically update updated_by when updating
        static::updating(function ($item) {
            $item->updated_by = Auth::id();
             // Get variable setting value in one query
             $is_item_code_system_generated = VariableSetting::where('company_id', $item->company_id)
             ->where('variable_id', 1)
             ->value('variable_value') ?? 0;

            if ($is_item_code_system_generated == 1) {
                $item->item_code = self::generate_item_code($item->company_id, $item->item_category_id);
                $item->is_system_generated_item_code = 1;
            }
        });
    }

    protected static function generate_item_code($company_id, $category_id)
    {
        // Get Company Short Name (First 3 letters)
        $company_short = Company::where('id', $company_id)->value('company_short_name');
        $company_short = strtoupper(substr($company_short, 0, 3));

        // Get Category Short Name (First 3 letters)
        $category_short = LibCategory::where('id', $category_id)->value('short_name');
        $category_short = strtoupper(substr($category_short, 0, 3));

        // Get Current Year
        $year = now()->format('Y');

        // Define Prefix
        $prefix = "{$company_short}-{$category_short}-{$year}-";

        // Get the latest item code matching the prefix
        $last_item = self::where('company_id', $company_id)
        ->where('item_category_id', $category_id)
        ->whereYear('created_at', $year)
        ->where('is_system_generated_item_code',1)
        ->orderBy('item_code', 'desc')
        ->first();

        // Extract the last used number and increment it
        $next_number = 1;
        if ($last_item) {
            $last_code = substr($last_item->item_code, -5); // Extract last 5-digit number
            $next_number = (int) $last_code + 1;
        }

        // Format new code (padded with 5 digits)
        return $prefix . str_pad($next_number, 5, '0', STR_PAD_LEFT);
    }
}
