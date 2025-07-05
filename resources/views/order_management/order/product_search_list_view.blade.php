<?php
    $data = json_decode($param,true);
    
    $category_id    = $data['category_id'];
    $product_id     = $data['product_id'];
    $item_code      = $data['item_code'];
    $supplier_id    = $data['supplier_id'];
    $item_origin    = $data['item_origin'];
    $generic_id     = $data['generic_id'];
    $reorder_level  = $data['reorder_level'] ?? 0;

  
    
    $query_builder = DB::table('product_details_master')->whereNull('deleted_at');
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

    if(!empty($item_origin))
    {
        $query_builder = $query_builder->where('item_origin' ,'like', '%'.trim($item_origin).'%');
    }

    if(!empty($generic_id))
    {
        $query_builder = $query_builder->where('generic_id', $generic_id);
    }

    if(!empty($reorder_level)) {
        $query_builder = $query_builder->whereColumn('consuption_uom_qty', '>', 'current_stock');
    }

    
    //$lib_product = $query_builder->ddRawSql();
    $lib_product = $query_builder->get();

    
?>
<table id="list_view" class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th>Item Category</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th>Uom</th>
            <th>Current Stock</th>
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
                                          'uom_id'=>$product->order_uom,
                                          'current_rate'=>$product->avg_rate_per_unit,
                                          'required_qty'=>calculate_required($product->id)
                                        ));
            ?>
            <tr id="tr_{{$product->id}}" onclick="js_set_value('{{ $param }}' )" style="cursor: pointer;" >
                <td>{{ get_item_category()[$product->item_category_id] ?? '' }}</td>
                <td>{{ $product->item_description }}</td>
                <td>{{ $product->item_code }}</td>
                <td>{{ get_uom()[$product->order_uom] ?? '' }}</td>
                <td>{{ $product->current_stock ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-center">
                <button type="button" class="btn btn-primary" onclick="parent.emailwindow.hide()"><i class="fa fa-close"></i> Close</button>
            </td>
        </tr>
    </tfoot>
</table>