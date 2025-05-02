<?php
$data = json_decode($data, true);
$location_id = $data['location_id'];
$on_change = $data['onchange'] ?? '';
$row_id = $data['row_id'] ?? '';
$field_name = $data['field_name'] ?? '';
$field_id = $data['field_id'] ?? '';

$name_extra = "";
if (!empty($row_id)) {
    $name_extra = "_" . $row_id;
}
if (empty($field_id)) {
    $field_id = "cbo_store_name" . $name_extra;
}
if (empty($field_name)) {
    $field_name = "cbo_store_name" . $name_extra;
}
$stores = App\Models\LibStoreLocation::where('location_id', $location_id)->get();
?>
<select name="{{ $field_name }}" id="{{ $field_id }}" class="form-control" onchange="<?php echo $on_change; ?>">
    <option value="0">SELECT</option>
    @foreach($stores as $store)
    <option value="{{$store->id}}">{{$store->store_name}}</option>
    @endforeach
</select>