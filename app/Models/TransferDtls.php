<?php

namespace App\Models;

use App\Models\TransferMst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferDtls extends Model
{
    use HasFactory;

    protected $table = 'transfer_dtls';

    protected $fillable = [
        'mst_id',
        'trans_from_id',
        'trans_to_id',
        'category_id',
        'product_id',
        'transfer_qty',
        'created_by',
        'updated_by'
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

    public function transferMst()
    {
        return $this->belongsTo(TransferMst::class, 'mst_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductDetailsMaster::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(LibCategory::class, 'category_id', 'id');
    }
}
