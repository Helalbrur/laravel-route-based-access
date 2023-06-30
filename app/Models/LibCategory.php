<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_category';
    protected $fillable = ['category_name','short_name','created_by','updated_by'];
}
