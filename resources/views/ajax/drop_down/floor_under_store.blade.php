
<?php
    $data = json_decode($data,true);
    $store_id = $data['store_id'];
    $on_change = $data['onchange'] ?? '';
    $row_id = $data['row_id'] ?? '';
    $field_name = $data['field_name'] ?? '';
    $field_id = $data['field_id'] ?? '';
    
    $name_extra = "";
    if (!empty($row_id)) {
        $name_extra = "_" . $row_id;
    }
    if (empty($field_id)) {
        $field_id = "cbo_floor_name" . $name_extra;
    }
    if (empty($field_name)) {
        $field_name = "cbo_floor_name" . $name_extra;
    }
    $flores = App\Models\LibFloor::where('store_id',$store_id)->get();
?>
<select name="{{ $field_name }}" id="{{ $field_id }}" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($flores as $flore)
        <option value="{{$flore->id}}" >{{$flore->floor_name}}</option>
    @endforeach
</select>