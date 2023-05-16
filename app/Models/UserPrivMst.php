<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPrivMst extends Model
{
    use HasFactory;
    protected $table = 'user_priv_mst';
    protected $fillable = [
        'user_id','main_menu_id','show_priv','delete_priv','save_priv','edit_priv','approve_priv','user_only','last_updated_by','inserted_by','last_update_date','valid','entry_date'
    ];
}
