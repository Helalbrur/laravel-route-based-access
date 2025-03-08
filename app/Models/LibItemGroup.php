<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibItemGroup extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_item_group';
    protected $fillable = ['item_name','item_category_id','conversion_factor','cons_uom','item_group_code','order_uom','item_type','created_by','updated_by'];
}
