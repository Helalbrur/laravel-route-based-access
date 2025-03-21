
<?php
    $data = json_decode($data,true);
    $category_id    = $data['category_id'];
    $on_change      = $data['onchange'] ?? '';
    $item_groups = App\Models\LibItemGroup::where('item_category_id',$category_id)->get();
?>
<select name="cbo_item_group_id" id="cbo_item_group_id" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($item_groups as $item_group)
        <option value="{{$item_group->id}}" >{{$item_group->item_name}}</option>
    @endforeach
</select>