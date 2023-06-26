<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibColor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_color';
    protected $fillable = [
        'color_name'
    ];
}
