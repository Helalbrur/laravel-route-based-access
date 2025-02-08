<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LibUom extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_uom';
    protected $fillable = [
        'uom_name'
    ];
}