<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPrivModule extends Model
{
    use HasFactory;
    protected $table ='user_priv_module';
    protected $fillable = [
        'user_id','module_id','user_only','valid','entry_date'
    ];
}
