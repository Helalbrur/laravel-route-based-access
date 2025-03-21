
<?php
    $data = json_decode($data,true);
    $location_id = $data['location_id'];
    $on_change = $data['onchange'] ?? '';
    $stores = App\Models\LibStoreLocation::where('location_id',$location_id)->get();
?>
<select name="cbo_store_name" id="cbo_store_name" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($stores as $store)
        <option value="{{$store->id}}" >{{$store->store_name}}</option>
    @endforeach
</select>