<?php
    $data = json_decode($data,true);
    
    $category_id = $data['category_id'];
    $on_change = $data['onchange'] ?? '';
    
    $lib_sub_category = App\Models\LibItemSubCategory::where('item_category_id',$category_id)->pluck('sub_category_name', 'id');
?>
<select name="cbo_sub_category_name" id="cbo_sub_category_name"  class="form-control" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($lib_sub_category as $id => $sub_category_name)
        <option value="{{ $id }}">{{ $sub_category_name }}</option>
    @endforeach
</select>