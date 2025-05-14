<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibDepartment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_department';
    protected $fillable = [
       'department_name', 'company_id','created_by','updated_by'
    ];
}