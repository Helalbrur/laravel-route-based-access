<?php
    $data = json_decode($data,true);
    $on_change = $data['onchange'] ?? '';
    $room_id = $data['room_id'];

    $racks = App\Models\LibFloorRoomRackMst::whereHas('rack_details', function ($query) use ($room_id) {
        $query->where('room_id', $room_id);
    })->get();


?>
<select name="cbo_rack_no" id="cbo_rack_no" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($racks as $rack)
        <option value="{{$rack->id}}" >{{$rack->floor_room_rack_name}}</option>
    @endforeach
</select>