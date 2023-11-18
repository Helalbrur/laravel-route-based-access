<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldLevelAccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'mst_id','company_id','user_id','field_id','page_id','field_name','is_disable','default_value','created_by','updated_by'
    ];
    protected $table = 'field_level_access';
}