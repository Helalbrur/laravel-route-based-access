
<?php
    $data = explode("*",$data);
    $location_id = $data[0];
    $is_loaded = "";
    $on_change = "";
    if(count($data) > 1)
    {
        $is_loaded = $data[1];
    }
    if(!empty($is_loaded))
    {
       $on_change ="load_drop_down('load_drop_down',this.value, '".$data[1]."', '".$data[2]."' )" ;
    }
    $stores = App\Models\LibStoreLocation::where('location_id',$location_id)->get();
?>
<select name="cbo_store_name" id="cbo_store_name" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($stores as $store)
        <option value="{{$store->id}}" >{{$store->store_name}}</option>
    @endforeach
</select>