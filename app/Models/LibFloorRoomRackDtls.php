<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibFloorRoomRackDtls extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'lib_floor_room_rack_dtls';
    protected $fillable = ['company_id','location_id','store_id','floor_id','room_id','rack_id','shelf_id','bin_id','serial_no','created_by','updated_by'];

    public function room()
    {
        return $this->belongsTo(LibFloorRoomRackMst::class, 'room_id', 'id');
    }

    public function rack()
    {
        return $this->belongsTo(LibFloorRoomRackMst::class, 'rack_id', 'id');
    }

    public function shelf()
    {
        return $this->belongsTo(LibFloorRoomRackMst::class, 'shelf_id', 'id');
    }

    public function bin()
    {
        return $this->belongsTo(LibFloorRoomRackMst::class, 'bin_id', 'id');
    }
}
