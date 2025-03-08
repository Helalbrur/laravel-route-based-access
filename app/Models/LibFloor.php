<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibFloor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_floor';
    protected $fillable = ['floor_name','company_id','store_id','seq','location_id','created_by','updated_by'];
}
