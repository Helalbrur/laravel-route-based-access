<?php
    $data = json_decode($data,true);
    $on_change = $data['onchange'] ?? '';
    $shelf_id = $data['shelf_id'] ?? '';
    $row_id = $data['row_id'] ?? '';
    $name_extra = "";
    if(!empty($row_id))
    {
        $name_extra = "_".$row_id;
    }
    $bins = App\Models\LibFloorRoomRackMst::whereHas('bin_details', function ($query) use ($shelf_id) {
        $query->where('shelf_id', $shelf_id);
    })->get();


?>
<select name="cbo_bin_no{{ $name_extra }}" id="cbo_bin_no{{ $name_extra }}" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($bins as $bin)
        <option value="{{$bin->id}}" >{{$bin->floor_room_rack_name}}</option>
    @endforeach
</select>