<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VariableSetting extends Model
{
    use HasFactory;
    protected $table = 'variable_settings';
    protected $fillable = [
        'company_id',
        'variable_id',
        'variable_value',
        'over_receive',
        'created_by',
        'updated_by',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

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
}
