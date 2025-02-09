<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibBrand extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_brand';
    protected $fillable = [
       'brand_name', 'buyer_id','created_by','updated_by'
    ];
}