<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvTransaction extends Model
{
    use HasFactory;
    protected $table = 'inv_receive_master';
    protected $fillable = [
        'mst_id',
        'transaction_type',
        'product_id',
        'required_qty',
        'work_order_qty',
        'quantity',
        'lot',
        'expire_date',
        'room_rack_id',
        'room_self_id',
        'room_bin_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($receive) {
            $receive->created_by = Auth::id();
        });

        // Automatically update updated_by when updating
        static::updating(function ($receive) {
            $receive->updated_by = Auth::id();
        });
    }
}
