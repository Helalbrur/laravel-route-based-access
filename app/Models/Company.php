<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_company';
    protected $fillable = [
        'comapnay_name','company_short_name','address','website','email','image'
    ];
}
