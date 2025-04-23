<?php
    $data = json_decode($data,true);
    $on_change = $data['onchange'] ?? '';
    $bin_id = $data['bin_id'];

    $bins = App\Models\LibFloorRoomRackMst::whereHas('bin_details', function ($query) use ($bin_id) {
        $query->where('bin_id', $bin_id);
    })->get();


?>
<select name="cbo_bin_no" id="cbo_bin_no" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($bins as $bin)
        <option value="{{$bin->id}}" >{{$bin->floor_room_rack_name}}</option>
    @endforeach
</select>