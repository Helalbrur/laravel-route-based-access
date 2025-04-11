<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvReceiveMaster extends Model
{
    use HasFactory;
    protected $table = 'inv_receive_master';
    protected $fillable = [
        'sys_number_prefix',
        'sys_number_prefix_num',
        'sys_number',
        'company_id',
        'location_id',
        'store_id',
        'receive_date',
        'work_order_no',
        'work_order_id',
        'supplier_id',
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
