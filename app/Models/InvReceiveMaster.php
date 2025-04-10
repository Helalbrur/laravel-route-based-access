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
        'receive_date',
        'company_id',
        'supplier_id',
        'location_id',
        'store_id',
        'created_by',
        'updated_by',
    ];
    
}
