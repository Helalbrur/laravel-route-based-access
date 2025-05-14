<?php
    $data = json_decode($data,true);
    
    $category_id = $data['category_id'];
    $on_change = $data['onchange'] ?? '';
    $class = $data['class'] ?? '';

    $row_id = $data['row_id'] ?? '';
    $name_extra = "";
    if(!empty($row_id))
    {
        $name_extra = "_".$row_id;
    }
    
    $lib_product = App\Models\ProductDetailsMaster::where('item_category_id',$category_id)->pluck('item_description', 'id');
?>
<select name="cbo_product{{ $name_extra }}" id="cbo_product{{ $name_extra }}"  class="form-control {{ $class }}" onchange="<?php echo $on_change;?>">
    <option value="0">SELECT</option>
    @foreach($lib_product as $id => $item_description)
        <option value="{{ $id }}">{{ $item_description }}</option>
    @endforeach
</select>