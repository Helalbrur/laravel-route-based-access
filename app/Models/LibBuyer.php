<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibBuyer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_buyer';
    protected $fillable = [
        'buyer_name','short_name','country_id','party_type','tag_company','contact_person','contact_no','web_site','email','address','created_by','updated_by'
    ];
    public function company()
    {
        return $this->belongsToMany(Company::class, 'lib_buyer_tag_company','buyer_id','company_id');//->ddRawSql();
    }
    public function country()
    {
        return $this->belongsTo(LibCountry::class);
    }
    public function tagCompany()
    {
        return $this->hasMany(LibBuyerTagCompany::class,'buyer_id','id');//->ddRawSql();
    }
}
