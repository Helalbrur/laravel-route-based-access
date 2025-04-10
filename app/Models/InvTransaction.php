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
        'product_id',
        'transaction_type',
        'required_qty',
        'work_order_qty',
        'quantity',
        'lot',
        'expire_date',
        'rack_no',
        'shelf_no',
        'bin_no',
        'created_by',
        'updated_by',
    ];
}
