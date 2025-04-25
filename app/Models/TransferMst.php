<?php

namespace App\Models;

use App\Models\TransferDtls;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferMst extends Model
{
    use HasFactory;
    protected $table = 'requisition_mst';
    protected $fillable = [
        'requisition_no_prefix',
        'requisition_no_prefix_num',
        'requisition_no',
        'company_id',
        'location_id',
        'store_dept',
        'store_id',
        'department_id',
        'requisition_date',
        'created_by',
        'updated_by'
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

    // Define relationship with TransferDtls
    public function TransferDtls()
    {
        return $this->hasMany(TransferDtls::class, 'mst_id');
    }

    // Define relationship with LibCompany
    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
