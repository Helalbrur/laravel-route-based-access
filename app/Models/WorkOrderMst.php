<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderMst extends Model
{
    use HasFactory;
    protected $table = 'work_order_mst';
    protected $fillable = [
        'wo_no_prefix',
        'wo_no_prefix_num',
        'wo_no',
        'wo_date',
        'delivery_date',
        'company_id',
        'supplier_id',
        'location_id',
        'pay_mode',
        'source',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($order) {
            $order->created_by = Auth::id();
        });

        // Automatically update updated_by when updating
        static::updating(function ($order) {
            $order->updated_by = Auth::id();
        });
    }

    // Define relationship with WorkOrderDtls
    public function workOrderDtls()
    {
        return $this->hasMany(WorkOrderDtls::class, 'mst_id');
    }

    // Define relationship with LibCompany
    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Define relationship with LibSupplier
    public function Supplier()
    {
        return $this->belongsTo(LibSupplier::class, 'supplier_id');
    }
}
