<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibItemSubGroup extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_item_sub_group';
    protected $fillable = ['item_category_id','item_group_id','sub_group_name','sub_group_code'];
}
