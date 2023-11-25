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
        'supplier_name','short_name','country_id','party_type','tag_company','contact_person','contact_no','web_site','email','address'
    ];

    public function company()
    {
        return $this->belongsToMany(Company::class, 'lib_supplier_tag_company','supplier_id','company_id');
        //->ddRawSql()
    }
    public function country()
    {
        return $this->belongsTo(LibCountry::class);
    }
    public function tagCompany()
    {
        return $this->hasMany(LibSupplierTagCompany::class,'supplier_id','id');//->ddRawSql();
    }
}
