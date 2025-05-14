<?php

namespace App\Models;

use App\Models\RequisitionDtls;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequisitionMst extends Model
{
    use HasFactory, SoftDeletes;
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
        static::creating(function ($requisition) {
            $requisition->created_by = Auth::id();
        });

        // Automatically update updated_by when updating
        static::updating(function ($requisition) {
            $requisition->updated_by = Auth::id();
        });
    }

    // Define relationship with RequisitionDtls
    public function requisitionDtls()
    {
        return $this->hasMany(RequisitionDtls::class, 'mst_id');
    }

    // Define relationship with LibCompany
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
