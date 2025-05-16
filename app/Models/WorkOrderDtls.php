<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderDtls extends Model
{
    use HasFactory;

    protected $table = 'work_order_dtls';

    protected $fillable =  [
        'mst_id',
        'product_id',
        'uom',
        'category_id',
        'quantity',
        'required_quantity',
        'rate',
        'amount',
        'discount',
        'tax',
        'vat',
        'net_amount',
        'net_rate',
        'date',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($order) {
            $order->net_amount = ($order->amount - $order->discount) + $order->vat + $order->tax;
            $order->net_rate = $order->quantity > 0 ? ($order->net_amount / $order->quantity) : 0;
            $order->created_by = Auth::id();
        });

        // Automatically update updated_by when updating
        static::updating(function ($order) {
            $order->updated_by = Auth::id();
            $order->net_amount = ($order->amount - $order->discount) + $order->vat + $order->tax;
            $order->net_rate = $order->quantity > 0 ? ($order->net_amount / $order->quantity) : 0;
        });
    }

    // Define relationship with WorkOrderMst
    public function workOrderMst()
    {
        return $this->belongsTo(WorkOrderMst::class, 'mst_id');
    }

    // Define relationship with ProductDetailsMaster
    public function product()
    {
        return $this->belongsTo(ProductDetailsMaster::class, 'product_id');
    }

    // Define relationship with LibUom
    public function uom()
    {
        return $this->belongsTo(LibUom::class, 'uom');
    }

    // Define relationship with LibCategory
    public function category()
    {
        return $this->belongsTo(LibCategory::class, 'category_id');
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
                    ->whereIn('transaction_type', [1, 4, 5])
                    ->whereNull('deleted_at');
    }

    public function getBalanceAttribute()
    {
        $consumedQty = $this->transactions()->sum('cons_qnty');
        return $this->quantity - $consumedQty;
    }
    
    public function getRecvQntyAttribute()
    {
        return $this->transactions()->sum('cons_qnty');
    }

     public function getOrderBalanceAttribute()
    {
        $consumedQty = $this->transactions()->sum('order_qnty');
        return $this->quantity - $consumedQty;
    }

     /*
        $work_order_dtls = WorkOrderDtls::find($id);
        $balance = $work_order_dtls->balance;
        $balance = $work_order_dtls->recv_qnty;
    */
}
