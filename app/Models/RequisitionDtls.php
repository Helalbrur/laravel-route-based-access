<?php

namespace App\Models;

use App\Models\RequisitionMst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequisitionDtls extends Model
{
    use HasFactory;

    protected $table = 'requisition_dtls';
    protected $fillable =  [
        'mst_id',
        'product_id',
        'item_code',
        'category_id',
        'uom',
        'requisition_qty',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($requisition) {
            $requisition->created_by = Auth::id();
        });

        // Automatically update updated_by when updating
        static::updating(function ($requisition) {
            $requisition->updated_by = Auth::id();
        });
    }

    // Define relationship with RequisitionMst
    public function requisitionMst()
    {
        return $this->belongsTo(RequisitionMst::class, 'mst_id');
    }

    // Define relationship with ProductDetailsMaster
    public function product()
    {
        return $this->belongsTo(ProductDetailsMaster::class, 'product_id');
    }

    // Define relationship with LibCategory
    public function category()
    {
        return $this->belongsTo(LibCategory::class, 'category_id');
    }

    // Define relationship with LibUom
    public function uom()
    {
        return $this->belongsTo(LibUom::class, 'uom');
    }

    // Define relationship with User
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // Define relationship with User
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function transactions()
    {
        return $this->hasMany(InvTransaction::class, 'ref_dtls_id')
                    ->whereIn('transaction_type', [2, 3, 6])
                    ->whereNull('deleted_at');
    }

    public function getBalanceAttribute()
    {
        $consumedQty = $this->transactions()->sum('cons_qnty');
        return $this->requisition_qty - $consumedQty;
    }

    public function getIssueQtyAttribute()
    {
        return $this->transactions()->sum('cons_qnty');
    }

    /*
        $requisition = RequisitionDtls::with('transactions')->find($id);
        $balance = $requisition->balance;
        $issue_qty = $requisition->issue_qty;
    */
}
