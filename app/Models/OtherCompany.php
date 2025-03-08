<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherCompany extends Model
{
    use HasFactory;
    use SoftDeletes;
    //set fillable property
    protected $fillable = [
        'name',
        'short_name'
    ];
}
