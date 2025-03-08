<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
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

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($item) {
            $item->created_by = Auth::id();
            if ($item->company_short_name == null || $item->company_short_name == '') {
                //generate short name from company name 
                $item->company_short_name = substr($item->company_name, 0, 3);
            }
        });

        // Automatically update updated_by when updating
        static::updating(function ($item) {
            $item->updated_by = Auth::id();
            if ($item->company_short_name == null || $item->company_short_name == '') {
                //generate short name from company name 
                $item->company_short_name = substr($item->company_name, 0, 3);
            }
        });
    }
}
