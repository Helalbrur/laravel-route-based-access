<?php
$data = json_decode($data, true);
$on_change = $data['onchange'] ?? '';
$room_id = $data['room_id'];
$row_id = $data['row_id'] ?? '';
$field_name = $data['field_name'] ?? '';
$field_id = $data['field_id'] ?? '';

$name_extra = "";
if (!empty($row_id)) {
    $name_extra = "_" . $row_id;
}
if (empty($field_id)) {
    $field_id = "cbo_rack_no" . $name_extra;
}
if (empty($field_name)) {
    $field_name = "cbo_rack_no" . $name_extra;
}

$racks = App\Models\LibFloorRoomRackMst::whereHas('rack_details', function ($query) use ($room_id) {
    $query->where('room_id', $room_id);
})->get();

?>
<select name="{{ $field_name }}" id="{{ $field_id }}" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($racks as $rack)
    <option value="{{$rack->id}}">{{$rack->floor_room_rack_name}}</option>
    @endforeach
</select>