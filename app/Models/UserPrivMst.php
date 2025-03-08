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
    //UserPrivMst has many UserPrivModule
    public function mainMenu()
    {
        return $this->belongsTo(MainMenu::class, 'main_menu_id', 'm_menu_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
