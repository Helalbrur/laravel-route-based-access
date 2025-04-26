<?php

use Illuminate\Support\Facades\DB;

$data = json_decode($param, true);

$category_id    = $data['category_id'];
$product_id     = $data['product_id'];
$item_code      = $data['item_code'];
$item_origin    = $data['item_origin'];
$generic_id     = $data['generic_id'];


$query_builder = DB::table('product_details_master')->whereNull('deleted_at');
if (!empty($category_id)) {
    $query_builder = $query_builder->where('item_category_id', $category_id);
}

if (!empty($product_id)) {
    $query_builder = $query_builder->where('id', $product_id);
}

if (!empty($item_code)) {
    $query_builder = $query_builder->where('item_code', $item_code);
}

if (!empty($item_origin)) {
    $query_builder = $query_builder->where('item_origin', 'like', '%' . trim($item_origin) . '%');
}

if (!empty($generic_id)) {
    $query_builder = $query_builder->where('generic_id', $generic_id);
}

//$products = $query_builder->ddRawSql();
$products = $query_builder->get();

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
    <tbody>
        <?php $sl = 1; ?>
        @foreach($products as $product)
        <?php
        $sl++;
        $param = json_encode($product);
        ?>
        <tr id="tr_{{$product->id}}" onclick="js_set_value('{{ $param }}' )" style="cursor: pointer;">
            <td>{{ get_item_category()[$product->item_category_id] ?? '' }}</td>
            <td>{{ $product->item_description }}</td>
            <td>{{ $product->item_code }}</td>
            <td>{{ get_uom()[$product->order_uom] ?? '' }}</td>
            <td>{{ $product->current_stock ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>
</table>