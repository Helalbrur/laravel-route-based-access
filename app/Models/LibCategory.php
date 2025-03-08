<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_category';
    protected $fillable = ['category_name','short_name','created_by','updated_by'];

    protected static function boot()
    {
        parent::boot();

        // Automatically set created_by when creating
        static::creating(function ($item) {
            $item->created_by = Auth::id();
            if ($item->short_name == null || $item->short_name == '') {
                //generate short name from company name 
                $item->short_name = substr($item->category_name, 0, 3);
            }
        });

        // Automatically update updated_by when updating
        static::updating(function ($item) {
            $item->updated_by = Auth::id();
            if ($item->short_name == null || $item->short_name == '') {
                //generate short name from company name 
                $item->short_name = substr($item->category_name, 0, 3);
            }
        });
    }
}
