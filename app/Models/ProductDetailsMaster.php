<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetailsMaster extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_details_master';
    protected $fillable = ['company_id','supplier_id','store_id','item_category_id','detarmination_id','item_group_id','item_description','product_name_details','lot','item_code','item_account','packing_type','uom','avg_rate_per_unit','current_stock','stock_value'];
}