<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvIssueMaster extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'inv_issue_master';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'sys_number_prefix',
        'sys_number_prefix_num',
        'sys_number',
        'company_id',
        'location_id',
        'store_id',
        'buyer_id',
        'date',
        'requisition_no',
        'requisition_id',
        'issue_basis',
        'created_by',
        'updated_by', 
        'created_at',
        'updated_at',
        'deleted_at',
        'remarks'
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($issue) {
            $issue->created_by = Auth::id();
        });

        // Automatically update updated_by when updating
        static::updating(function ($issue) {
            $issue->updated_by = Auth::id();
        });
    }
}
