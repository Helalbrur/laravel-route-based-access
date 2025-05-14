<?php

namespace App\Models;

use Exception;
use App\Models\LibUom;
use App\Models\Company;
use App\Models\LibSize;
use App\Models\LibBrand;
use App\Models\LibColor;
use App\Models\LibGeneric;
use App\Models\LibCategory;
use App\Models\LibItemGroup;
use App\Models\LibItemSubGroup;
use App\Models\VariableSetting;
use App\Models\LibItemSubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        'consuption_uom_qty', 'conversion_fac', 'size_id', 'power', 'created_by', 'updated_by','is_system_generated_item_code','item_group_id', 'item_sub_group_id'
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
                $item->item_code = self::generate_item_code($item);
                $item->is_system_generated_item_code = 1;
            }

            if(empty($item->product_name_details))
            {
                $item->product_name_details = $item->item_description ?? '';
            }
            //self::updateProductInventory($item);
        });

        // Automatically update updated_by when updating
        static::updating(function ($item) {
            $item->updated_by = Auth::id();
             // Get variable setting value in one query
             $is_item_code_system_generated = VariableSetting::where('company_id', $item->company_id)
             ->where('variable_id', 1)
             ->value('variable_value') ?? 0;

            if (($is_item_code_system_generated == 1 || $item->is_system_generated_item_code == 1) && empty($item->item_code)) {
                $item->item_code = self::generate_item_code($item);
                $item->is_system_generated_item_code = 1;
            }

            if(empty($item->product_name_details))
            {
                $item->product_name_details = $item->item_description ?? '';
            }
            //self::updateProductInventory($item);
        });
    }

    protected static function generate_item_code($item)
    {
        // Get Company Short Name (First 3 letters)
        $company_short = Company::where('id', $item->company_id)->value('company_short_name');
        $company_short = strtoupper(substr($company_short, 0, 3));

        // Get Category Short Name (First 3 letters)
        $category_short = LibCategory::where('id', $item->category_id)->value('short_name');
        $category_short = strtoupper(substr($category_short, 0, 3));

        $sub_category_name = LibItemSubCategory::where('id', $item->item_sub_category_id)->value('sub_category_name');
        $sub_category_name = strtoupper(substr($sub_category_name, 0, 3));


        $brand_name = LibBrand::where('id', $item->brand_id)->value('brand_name');
        $brand_name = strtoupper(substr($brand_name, 0, 3));

        $dosage_form = strtoupper(substr($item->dosage_form, 0, 3));
        

        // Define Prefix
        $prefix = "{$company_short}-{$category_short}-{$sub_category_name}-{$brand_name}-{$dosage_form}";

        // Get the latest item code matching the prefix
        $last_item = self::where('company_id', $item->company_id)
        ->where('item_category_id', $item->category_id)
        ->where('item_sub_category_id', $item->item_sub_category_id)
        ->where('brand_id', $item->brand_id)
        ->where('dosage_form', $item->dosage_form)
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function supplier()
    {
        return $this->belongsTo(LibSupplier::class);
    }


    public function itemCategory()
    {
        return $this->belongsTo(LibCategory::class);
    }

    public function itemGroup()
    {
        return $this->belongsTo(LibItemGroup::class);
    }

    public function itemSubGroup()
    {
        return $this->belongsTo(LibItemSubGroup::class);
    }

    public function itemSubCategory()
    {
        return $this->belongsTo(LibItemSubCategory::class, 'item_sub_category_id', 'id');
    }

    public function productUom()
    {
        return $this->belongsTo(LibUom::class, 'uom', 'id');
    }

    public function generic()
    {
        return $this->belongsTo(LibGeneric::class, 'generic_id', 'id');
    }
    
    //created_by
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    //updated_by
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    //color
    public function color()
    {
        return $this->belongsTo(LibColor::class);
    }
    //size
    public function size()
    {
        return $this->belongsTo(LibSize::class);
    }

    //orderUom
    public function orderUom()
    {
        return $this->belongsTo(LibUom::class, 'order_uom', 'id');
    }

    //consuptionUom
    public function consuptionUom()
    {
        return $this->belongsTo(LibUom::class, 'consuption_uom', 'id');
    }

    //brand
    public function brand()
    {
        return $this->belongsTo(LibBrand::class, 'brand_id', 'id');
    }


    protected static function updateProductInventory($product)
    {
        try {
            $transSummary = DB::table('inv_transaction as a')
                ->selectRaw('
                    SUM(
                        CASE
                            WHEN a.transaction_type IN (1, 4, 5) THEN a.cons_qnty
                            ELSE 0
                        END)
                    - SUM(
                        CASE
                            WHEN a.transaction_type IN (2, 3, 6) THEN a.cons_qnty
                            ELSE 0
                        END) AS balance,
                    SUM(
                        CASE
                            WHEN a.transaction_type IN (1, 4, 5) THEN a.cons_amount
                            ELSE 0
                        END)
                    - SUM(
                        CASE
                            WHEN a.transaction_type IN (2, 3, 6) THEN a.cons_amount
                            ELSE 0
                        END) AS amount,
                    a.product_id')
                ->whereNull('a.deleted_at')
                ->where('a.product_id', $product->id)
                ->groupBy('a.product_id')
                ->first();

            if ($transSummary) {
                // Update the product inventory details
                $product->current_stock = $transSummary->balance ?? 0;
                $product->stock_value = $transSummary->amount ?? 0;
                $product->avg_rate_per_unit = ($transSummary->balance ?? 0) > 0 
                    ? ($transSummary->amount ?? 0) / ($transSummary->balance ?? 1) 
                    : 0;
                $product->save();
            }
        } catch (Exception $e) {
            // Log the error or handle it appropriately
            Log::error('Failed to update product inventory: ' . $e->getMessage());
        }
    }

    public function transactions()
    {
        return $this->hasMany(InvTransaction::class, 'product_id')
                    ->whereNull('deleted_at');
    }


    public function getBalanceQntyAttribute()
    {
        $addQty = $this->transactions()
            ->whereIn('transaction_type', [1, 4, 5])
            ->sum('cons_qnty');

        $lessQty = $this->transactions()
            ->whereIn('transaction_type', [2, 3, 6])
            ->sum('cons_qnty');

        return $addQty - $lessQty;
    }

    public function getBalanceAmountAttribute()
    {
        $addAmt = $this->transactions()
            ->whereIn('transaction_type', [1, 4, 5])
            ->sum('cons_amount');

        $lessAmt = $this->transactions()
            ->whereIn('transaction_type', [2, 3, 6])
            ->sum('cons_amount');

        return $addAmt - $lessAmt;
    }

    public function getAvgRateAttribute()
    {
        $balanceQty = $this->balance_qnty;
        $balanceAmt = $this->balance_amount;

        return $balanceQty > 0 ? $balanceAmt / $balanceQty : 0;
    }


    /*
        $product = ProductDetailsMaster::find($id);
        echo $product->balance_qnty;
        echo $product->balance_amount;
        echo $product->avg_rate;
    */

    
}
