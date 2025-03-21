<?php
    $data = json_decode($data,true);
    $on_change = $data['onchange'] ?? '';
    $rack_id = $data['rack_id'];

    $shelves = App\Models\LibFloorRoomRackMst::whereHas('shelf_details', function ($query) use ($rack_id) {
        $query->where('rack_id', $rack_id);
    })->get();


?>
<select name="cbo_shelf_no" id="cbo_shelf_no" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($shelves as $shelf)
        <option value="{{$shelf->id}}" >{{$shelf->floor_room_rack_name}}</option>
    @endforeach
</select>