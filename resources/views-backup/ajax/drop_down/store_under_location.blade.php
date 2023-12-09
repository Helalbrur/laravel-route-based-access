
<?php
    $data = explode("*",$data);
    $location_id = $data[0];
    $stores = App\Models\LibStoreLocation::where('location_id',$location_id)->get();
?>
<select name="cbo_store_name" id="cbo_store_name" class="form-control">
    <option value="0">SELECT</option>
    @foreach($stores as $store)
        <option value="{{$store->id}}" >{{$store->store_name}}</option>
    @endforeach
</select>