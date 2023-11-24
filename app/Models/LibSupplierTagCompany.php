<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibSupplierTagCompany extends Model
{
    use HasFactory;
    protected $table = 'lib_supplier_tag_company';
    protected $fillable = [
        'supplier_id','company_id'
    ];
}
