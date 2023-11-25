<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibStoreLocation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_store_location';
    protected $fillable = ['store_name','company_id','store_location','item_category_id','location_id'];

    public function category()
    {
        return $this->belongsToMany(LibCategory::class, 'lib_store_tag_categories','store_id','category_id');
        //->ddRawSql()
    }
    public function country()
    {
        return $this->belongsTo(LibCountry::class);
    }
    public function tagCategory()
    {
        return $this->hasMany(LibStoreTagCategory::class,'category_id','id');//->ddRawSql();
    }
}
