<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibFloorRoomRackMst extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_floor_room_rack_mst';
    protected $fillable = ['company_id','floor_room_rack_name','created_by','updated_by'];

    public function room_details()
    {
        return $this->hasOne(LibFloorRoomRackDtls::class, 'room_id', 'id');
    }

    public function rack_details()
    {
        return $this->hasOne(LibFloorRoomRackDtls::class, 'rack_id', 'id');
    }

    public function shelf_details()
    {
        return $this->hasOne(LibFloorRoomRackDtls::class, 'shelf_id', 'id');
    }

    public function bin_details()
    {
        return $this->hasOne(LibFloorRoomRackDtls::class, 'bin_id', 'id');
    }
}
