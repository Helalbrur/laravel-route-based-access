<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibLocation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_location';
    protected $fillable = ['location_name','contact_person','contact_no','company_id','website','address','email','country_id'];
}
