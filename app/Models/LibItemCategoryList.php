<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibItemCategoryList extends Model
{
    use HasFactory;
    protected $table = 'lib_item_category_list';
    protected $fillable = [
        'category_id','actual_category_name','short_name','category_type','inserted_by','insert_date','updated_by','update_date','status_active','is_deleted','is_inventory','ac_period_dtls_id','period_ending_date'
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
