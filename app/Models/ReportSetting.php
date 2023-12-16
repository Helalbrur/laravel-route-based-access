<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportSetting extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'company_id',
        'module_id',
        'report_id',
        'format_id',
        'user_id',
        'created_by',
        'updated_by'
    ];
    protected $table = "lib_report_template";
}
