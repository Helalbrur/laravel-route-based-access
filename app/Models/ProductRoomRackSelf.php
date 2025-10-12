<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRoomRackSelf extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'product_id',
        'room_id',
        'floor_id',
        'rack_id',
        'shelf_id',
        'bin_id',
        'created_by',
        'updated_by',
    ];
    
}
