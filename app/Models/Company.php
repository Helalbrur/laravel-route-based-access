<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_company';
    protected $fillable = [
       'group_id', 'company_name','company_short_name','address','website','email','contact_no','created_by','updated_by'
    ];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function buyers()
    {
        return $this->belongsToMany(LibBuyer::class, 'lib_buyer_tag_company');
    }
}
