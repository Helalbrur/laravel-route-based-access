<?php

namespace App\Models;

use App\Models\Company;
use App\Models\LibCountry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibLocation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_location';
    protected $fillable = ['location_name','contact_person','contact_no','company_id','website','address','email','country_id','created_by','updated_by'];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function country()
    {
        return $this->belongsTo(LibCountry::class);
    }
}
