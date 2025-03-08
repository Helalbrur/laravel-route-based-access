<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibStoreTagCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id','category_id'
    ];
}
