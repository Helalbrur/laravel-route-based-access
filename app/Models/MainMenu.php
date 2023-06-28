<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainMenu extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'main_menu';
    protected $fillable = [
        'm_menu_id','m_module_id','root_menu','sub_root_menu','menu_name','f_location','fabric_nature','position','status','slno','report_menu','is_mobile_menu','m_page_name','m_page_short_name','inserted_by','insert_date','updated_by','update_date','status_active','is_deleted'
    ];
    public $timestamps = false;

    protected $createdAt = 'insert_date';
    protected $updatedAt = 'update_date';
    protected function performDeleteOnModel()
    {
        // Set the status_active column to 0 and is_deleted column to 1
        $this->{$this->getDeletedAtColumn()} = $time = $this->freshTimestamp();
        $this->status_active = 0;
        $this->is_deleted = 1;
        $this->save();
    }
}
