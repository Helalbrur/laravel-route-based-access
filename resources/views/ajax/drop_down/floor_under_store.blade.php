
<?php
    $data = json_decode($data,true);
    $store_id = $data['store_id'];
    $on_change = $data['onchange'] ?? '';
    $flores = App\Models\LibFloor::where('store_id',$store_id)->get();
?>
<select name="cbo_floor_name" id="cbo_floor_name" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($flores as $flore)
        <option value="{{$flore->id}}" >{{$flore->floor_name}}</option>
    @endforeach
</select>