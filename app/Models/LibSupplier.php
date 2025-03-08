<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibSupplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_supplier';
    protected $fillable = [
        'supplier_name','short_name','country_id','party_type','tag_company','contact_person','contact_no','web_site','email','address','other_company_id'
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
    public function other_company()
    {
        return $this->belongsTo(OtherCompany::class);
    }
    public function tagCompany()
    {
        return $this->hasMany(LibSupplierTagCompany::class,'supplier_id','id');//->ddRawSql();
    }

    public function tagParty()
    {
        return $this->hasMany(LibSupplierTagParty::class,'supplier_id','id');//->ddRawSql();
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($supplier) {
            if ($supplier->short_name == null || $supplier->short_name == '') {
                //generate short name from supplier name 
                $supplier->short_name = substr($supplier->supplier_name, 0, 3);
            }
        });

        // Automatically update updated_by when updating
        static::updating(function ($supplier) {
            if ($supplier->short_name == null || $supplier->short_name == '') {
                //generate short name from supplier name 
                $supplier->short_name = substr($supplier->supplier_name, 0, 3);
            }
        });
    }
}
