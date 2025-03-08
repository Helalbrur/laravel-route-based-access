<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibSize extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_size';
    protected $fillable = [
        'size_name'
    ];
}
