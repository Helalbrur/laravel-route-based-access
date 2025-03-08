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

    public function module()
    {
        return $this->belongsTo(MainModule::class, 'module_id', 'm_mod_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
