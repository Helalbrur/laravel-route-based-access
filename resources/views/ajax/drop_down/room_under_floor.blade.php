<?php
    $data = json_decode($data,true);
    $on_change = $data['onchange'] ?? '';
    $floor_id = $data['floor_id'];

    $rooms = App\Models\LibFloorRoomRackMst::whereHas('room_details', function ($query) use ($floor_id) {
        $query->where('floor_id', $floor_id);
    })->get();


?>
<select name="cbo_room_no" id="cbo_room_no" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($rooms as $room)
        <option value="{{$room->id}}" >{{$room->floor_room_rack_name}}</option>
    @endforeach
</select>