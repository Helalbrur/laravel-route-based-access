
<?php
    $data = json_decode($data,true);
    $location_id = $data['location_id'];
    $on_change = $data['onchange'] ?? '';
    $row_id = $data['row_id'] ?? '';
    $name_extra = "";
    if(!empty($row_id))
    {
        $name_extra = "_".$row_id;
    }
    $stores = App\Models\LibStoreLocation::where('location_id',$location_id)->get();
?>
<select name="cbo_store_name{{ $name_extra }}" id="cbo_store_name{{ $name_extra }}" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($stores as $store)
        <option value="{{$store->id}}" >{{$store->store_name}}</option>
    @endforeach
</select>