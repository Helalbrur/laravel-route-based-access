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
    protected $fillable = ['company_id','floor_room_rack_name'];
}
