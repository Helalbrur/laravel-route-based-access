<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'permission_id'
    ];
    protected $table = "permission_user";
    public function permission()
    {
        return $this->belongsTo('App\Post', 'foreign_key');
    }
}
