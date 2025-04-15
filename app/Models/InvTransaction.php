<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvTransaction extends Model
{
    use HasFactory;
    protected $table = 'inv_transaction';
    protected $fillable = [
        'mst_id',
        'transaction_type',
        'product_id',
        'order_uom',
        'order_qnty',
        'order_rate',
        'order_amount',
        'order_amount',
        'quantity',
        'lot',
        'expire_date',
        'room_rack_id',
        'room_self_id',
        'room_bin_id',
        'cons_uom',
        'cons_qnty',
        'cons_rate',
        'cons_amount',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trans) {
            $trans->created_by = Auth::id();
            self::updateProductInventory($trans);
        });

        static::updating(function ($trans) {
            $trans->updated_by = Auth::id();
            self::updateProductInventory($trans);
        });
    }

    protected static function updateProductInventory($transaction)
    {
        try {
            $transSummary = DB::table('inv_transaction as a')
                ->selectRaw('
                    SUM(
                        CASE
                            WHEN a.transaction_type IN (1, 4, 5) THEN a.cons_qnty
                            ELSE 0
                        END)
                    - SUM(
                        CASE
                            WHEN a.transaction_type IN (2, 3, 6) THEN a.cons_qnty
                            ELSE 0
                        END) AS balance,
                    SUM(
                        CASE
                            WHEN a.transaction_type IN (1, 4, 5) THEN a.cons_amount
                            ELSE 0
                        END)
                    - SUM(
                        CASE
                            WHEN a.transaction_type IN (2, 3, 6) THEN a.cons_amount
                            ELSE 0
                        END) AS amount,
                    a.product_id')
                ->where('a.is_deleted', 0)
                ->where('a.status_active', 1)
                ->where('a.product_id', $transaction->product_id)
                ->groupBy('a.product_id')
                ->first();

            if ($transSummary) {
                $product = ProductDetailsMaster::find($transaction->product_id);
                if ($product) {
                    $product->current_stock = $transSummary->balance ?? 0;
                    $product->stock_value = $transSummary->amount ?? 0;
                    $product->avg_rate_per_unit = ($transSummary->balance ?? 0) > 0 
                        ? ($transSummary->amount ?? 0) / ($transSummary->balance ?? 1) 
                        : 0;
                    $product->save();
                }
            }
        } catch (Exception $e) {
            // Log the error or handle it appropriately
            Log::error('Failed to update product inventory: ' . $e->getMessage());
        }
    }

    // Define relationship with ProductDetailsMaster
    public function product()
    {
        return $this->belongsTo(ProductDetailsMaster::class, 'product_id');
    }
}
