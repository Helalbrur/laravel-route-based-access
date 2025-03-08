<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandatoryField extends Model
{
    use HasFactory;
    protected $fillable = [
        'page_id','field_id','field_name','field_message','is_mandatory','created_by','updated_by'
    ];
    protected $table = 'mandatory_field';
}