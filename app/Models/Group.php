<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_group';
    protected $fillable = [
        'group_name','group_short_name','website','address','menu_name','email','created_by','updated_by','contact_no','contact_person','country_id','image'
    ];
    
}
