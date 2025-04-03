<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FieldManager extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'entry_form','field_id','field_name','field_message','is_hide','user_id','created_by','updated_by'
    ];
    protected $table = 'field_managers';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'is_hide' => 'boolean'
    ];
}
