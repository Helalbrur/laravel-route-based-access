<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportSetting extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'module_id',
        'report_id',
        'format_id',
        'user_id'
    ];
    protected $table = "lib_report_template";
}
