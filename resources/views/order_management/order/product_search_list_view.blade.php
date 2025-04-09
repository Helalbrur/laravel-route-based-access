<?php
    $data = json_decode($param,true);
    
    $category_id    = $data['category_id'];
    $product_id     = $data['product_id'];
    $item_code      = $data['item_code'];
    $supplier_id    = $data['supplier_id'];
    
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
    
    if(!empty($supplier_id))
    {
        $query_builder = $query_builder->where('supplier_id', $supplier_id);
    }
    
    $lib_product = $query_builder->get();
    
?>
<table id="list_view" class="table table-striped" style="width: 100%">
    <thead>
        <tr>
            <th>Item Category</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th>Uom</th>
        </tr>
    </thead>
    <tbody id="tbl_po_list">
        <?php $sl = 1;?>
        @foreach($lib_product as $product)
            <?php 
                if($sl % 2 == 0)
                {
                    $class = 'even';
                }
                else
                {
                    $class = 'odd';
                }
                $sl++;
                $param = json_encode(array('product_id'=>$product->id,
                                          'item_code'=>$product->item_code,
                                          'item_name'=>$product->item_description,
                                          'category_id'=>$product->item_category_id,
                                          'uom_id'=>$product->uom_id,
                                          'current_rate'=>$product->avg_rate_per_unit));
            ?>
            <tr id="tr_{{$product->id}}" onclick="js_set_value('{{ $param }}' )" style="cursor: pointer;" class="{{ $class }}">
                <td>{{ get_item_category()[$product->item_category_id] ?? '' }}</td>
                <td>{{ $product->item_description }}</td>
                <td>{{ $product->item_code }}</td>
                <td>{{ get_uom()[$product->uom_id] ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-center">
                <button type="button" class="btn btn-primary" onclick="parent.emailwindow.hide()"><i class="fa fa-close"></i> Close</button>
            </td>
        </tr>
    </tfoot>
</table>