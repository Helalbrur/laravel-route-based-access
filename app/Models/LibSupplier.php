<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibSupplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_supplier';
    protected $fillable = [
        'supplier_name','short_name','party_type','tag_company','contact_person','contact_no','web_site','email','address'
    ];
}
