<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainModule extends Model
{
    use HasFactory;
    protected $fillable = [
        'm_mod_id',
        'main_module',
        'file_name',
        'status',
        'mod_slno'
    ];
    protected $table = 'main_module';
}
