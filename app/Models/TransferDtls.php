<?php

namespace App\Models;

use App\Models\TransferMst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferDtls extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inv_transaction';

    protected $fillable =  [
        'mst_id',
        'transaction_type',
        'location_id',
        'store_id',
        'floor_id',
        'room_id',
        'room_rack_id',
        'room_bin_id',
        'room_self_id',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($transaction) {
            $transaction->created_by = Auth::id();
        });

        // Automatically update updated_by when updating
        static::updating(function ($transaction) {
            $transaction->updated_by = Auth::id();
        });
    }

    // Define relationship with TransferMst
    public function transferMst()
    {
        return $this->belongsTo(TransferMst::class, 'mst_id');
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
}
