<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LibGeneric extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_generic';
    protected $fillable = [
        'generic_name'
    ];
}
