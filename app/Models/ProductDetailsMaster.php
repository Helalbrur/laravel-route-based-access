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
    protected $fillable = ['company_id','supplier_id','store_id','item_category_id','detarmination_id','item_group_id','item_description','product_name_details','lot','item_code','item_account','packing_type','uom','avg_rate_per_unit','current_stock','stock_value','generic_id','item_sub_category_id','item_type','item_origin','brand_id','dosage_form','color_id','order_uom','order_uom_qty','consuption_uom','consuption_uom_qty','conversion_fac','size_id','power','created_by','updated_by'];  
}