<?php
$data = json_decode($data, true);
$on_change = $data['onchange'] ?? '';
$floor_id = $data['floor_id'];
$row_id = $data['row_id'] ?? '';
$field_name = $data['field_name'] ?? '';
$field_id = $data['field_id'] ?? '';

$name_extra = "";
if (!empty($row_id)) {
    $name_extra = "_" . $row_id;
}
if (empty($field_id)) {
    $field_id = "cbo_room_no" . $name_extra;
}
if (empty($field_name)) {
    $field_name = "cbo_room_no" . $name_extra;
}

$rooms = App\Models\LibFloorRoomRackMst::whereHas('room_details', function ($query) use ($floor_id) {
    $query->where('floor_id', $floor_id);
})->get();
?>
<select name="{{ $field_name }}" id="{{ $field_id }}" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($rooms as $room)
    <option value="{{$room->id}}">{{$room->floor_room_rack_name}}</option>
    @endforeach
</select>