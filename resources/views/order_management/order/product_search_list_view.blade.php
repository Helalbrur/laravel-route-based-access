<?php
    $data = json_decode($param,true);
    
    $category_id    = $data['category_id'];
    $product_id     = $data['product_id'];
    $item_code      = $data['item_code'];
    
    $query_builder = App\Models\ProductDetailsMaster::query();
    if(!empty($category_id))
    {
        $query_builder = $query_builder->where('item_category_id', $category_id);
    }
    
    if(!empty($product_id))
    {
        $query_builder = $query_builder->where('id', $product_id);
    }
    
    if(!empty($item_code))
    {
        $query_builder = $query_builder->where('item_code', $item_code);
    }
    
    $lib_product = $query_builder->get();
    
?>
<table id="list_view" class="table table-striped" style="width: 100%">
    <thead>
        <tr>
            <th>Item Category</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($lib_product as $product)
            <tr>
                <td>{{ get_item_category()[$product->item_category_id] }}</td>
                <td>{{ $product->item_description }}</td>
                <td>{{ $product->item_code }}</td>
                <td><input type="button" name="button2" class="formbutton" value="Select" onClick="selectProduct({{ $product->id }}, '{{ $product->item_description }}', '{{ $product->item_code }}')" style="width:70px;" /></td>
            </tr>
        @endforeach
    </tbody>
</table>