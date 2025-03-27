<?php
    $data = json_decode($data,true);
    
    $group_id = $data['group_id'];
    $on_change = $data['onchange'] ?? '';
    
    $lib_sub_group_name = App\Models\LibItemSubGroup::where('item_group_id',$group_id)->pluck('sub_group_name', 'id');
?>
<select name="cbo_sub_group_name" id="cbo_sub_group_name" class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($lib_sub_group_name as $id => $lib_sub_group_name)
        <option value="{{ $id }}">{{ $lib_sub_group_name }}</option>
    @endforeach
</select>