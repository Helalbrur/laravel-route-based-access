
<?php
    $data = explode("*",$data);
    $store_id = $data[0];
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
    $flores = App\Models\LibFloor::where('store_id',$store_id)->get();
?>
<select name="cbo_floor_name" id="cbo_floor_name" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($flores as $flore)
        <option value="{{$flore->id}}" >{{$flore->floor_name}}</option>
    @endforeach
</select>