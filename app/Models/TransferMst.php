<?php

namespace App\Models;

use App\Models\TransferDtls;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferMst extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transfer_mst';
    protected $fillable = [
        'transfer_no_prefix',
        'transfer_no_prefix_num',
        'transfer_no',
        'company_id',
        'transfer_date',
        'requisition_id',
        'category_id',
        'product_id',
        'current_stock',
        'avg_rate',
        'transfer_qty',
        'created_by',
        'updated_by',
    ];


    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($transfer) {
            $transfer->created_by = Auth::id();
        });

        // Automatically update updated_by when updating
        static::updating(function ($transfer) {
            $transfer->updated_by = Auth::id();
        });
    }

    // Define relationship with TransferDtls
    public function transferDtls()
    {
        return $this->hasMany(InvTransaction::class, 'mst_id');
    }

    // Define relationship with LibCompany
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function requisition()
    {
        return $this->belongsTo(RequisitionMst::class, 'requisition_id', 'id');
    }    

    public function product()
    {
        return $this->belongsTo(ProductDetailsMaster::class, 'product_id', 'id');
    }
    
}

