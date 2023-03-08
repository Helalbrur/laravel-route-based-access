<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'route_name'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
