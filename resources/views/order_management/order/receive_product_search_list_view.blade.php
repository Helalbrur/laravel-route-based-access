<?php
use App\Models\ProductDetailsMaster;

$data = json_decode($param, true);

$category_id    = $data['category_id'] ?? null;
$product_id     = $data['product_id'] ?? null;
$item_code      = $data['item_code'] ?? null;
$supplier_id    = $data['supplier_id'] ?? null;
$item_origin    = $data['item_origin'] ?? null;
$generic_id     = $data['generic_id'] ?? null;
$reorder_level  = $data['reorder_level'] ?? 0;

// Base query with relation preloaded
$query = ProductDetailsMaster::with('FloorRoomRackSelfBin')->whereNull('deleted_at');

if (!empty($category_id)) {
    $query->where('item_category_id', $category_id);
}

if (!empty($product_id)) {
    $query->where('id', $product_id);
}

if (!empty($item_code)) {
    $query->where('item_code', $item_code);
}

if (!empty($supplier_id)) {
    $query->where('supplier_id', $supplier_id);
}

if (!empty($item_origin)) {
    $query->where('item_origin', 'like', '%' . trim($item_origin) . '%');
}

if (!empty($generic_id)) {
    $query->where('generic_id', $generic_id);
}

if (!empty($reorder_level)) {
    $query->whereColumn('consuption_uom_qty', '>', 'current_stock');
}

$lib_product = $query->get();
?>

<table id="list_view" class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th>Item Category</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th>UOM</th>
            <th>Current Stock</th>
        </tr>
    </thead>
    <tbody id="tbl_po_list">
        <?php $sl = 1; ?>
        @foreach($lib_product as $product)
            <?php
                $class = $sl % 2 == 0 ? 'even' : 'odd';
                $sl++;

                // Use your computed accessors and safe null handling
                $floor_id   = $product->default_location->floor_id ?? null;
                $room_id    = $product->default_location->room_id ?? null;
                $rack_id    = $product->default_location->rack_id ?? null;
                $shelf_id   = $product->default_location->shelf_id ?? null;
                $bin_id     = $product->default_location->bin_id ?? null;
                $balance    = $product->location_balance_qnty ?? $product->current_stock ?? 0;

                $param = json_encode([
                    'product_id'     => $product->id,
                    'item_code'      => $product->item_code,
                    'item_name'      => $product->item_description,
                    'category_id'    => $product->item_category_id,
                    'uom_id'         => $product->order_uom,
                    'current_rate'   => $product->avg_rate_per_unit,
                    'floor_id'       => $floor_id,
                    'room_id'        => $room_id,
                    'rack_id'        => $rack_id,
                    'shelf_id'       => $shelf_id,
                    'bin_id'         => $bin_id,
                    'balance'        => $balance,
                ]);
            ?>
            <tr id="tr_{{ $product->id }}" onclick="js_set_value('{{ $param }}')" style="cursor: pointer;">
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
                <button type="button" class="btn btn-primary" onclick="parent.emailwindow.hide()">
                    <i class="fa fa-close"></i> Close
                </button>
            </td>
        </tr>
    </tfoot>
</table>
