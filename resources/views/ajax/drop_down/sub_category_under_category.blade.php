<?php
    $data = json_decode($data,true);
    
    $category_id = $data['category_id'];
    $on_change = $data['onchange'] ?? '';
    $row_id = $data['row_id'] ?? '';
    $name_extra = "";
    if(!empty($row_id))
    {
        $name_extra = "_".$row_id;
    }
    
    $lib_sub_category = App\Models\LibItemSubCategory::where('item_category_id',$category_id)->pluck('sub_category_name', 'id');
?>
<select name="cbo_sub_category_name{{ $name_extra }}" id="cbo_sub_category_name{{ $name_extra }}"  class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($lib_sub_category as $id => $sub_category_name)
        <option value="{{ $id }}">{{ $sub_category_name }}</option>
    @endforeach
</select>