<?php
$data = json_decode($param, true);

$company_id     = $data['company_id'];
$transfer_no    = $data['transfer_no'];
$category_id    = $data['category_id'];
$product_id     = $data['product_id'];
$from_date      = $data['from_date'] ?? '';
$to_date        = $data['to_date'] ?? '';

$query_builder = App\Models\TransferMst::query();

if (!empty($company_id)) {
    $query_builder = $query_builder->where('company_id', $company_id);
}

if (!empty($transfer_no)) {
    $query_builder = $query_builder->where('transfer_no', 'like', '%' . trim($transfer_no) . '%');
}

if (!empty($category_id)) {
    $query_builder = $query_builder->where('category_id', $category_id);
}

if (!empty($product_id)) {
    $query_builder = $query_builder->where('product_id', $product_id);
}

if (!empty($from_date) && !empty($to_date)) {
    $query_builder = $query_builder->whereBetween('transfer_date', [$from_date, $to_date]);
}

$transfers = $query_builder->with(['requisition', 'product'])->get();

?>
<table id="list_view" class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th>Company</th>
            <th>Transfer No</th>
            <th>Category</th>
            <th>Product</th>
            <th>Transfer Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $sl = 1; ?>
        @foreach($transfers as $transfer)
        <?php
        $sl++;
        $param = json_encode(array(
            'id' => $transfer->id,
            'company_id' => $transfer->company_id,
            'transfer_no' => $transfer->transfer_no,
            'transfer_date' => $transfer->transfer_date,
            'requisition_id' => $transfer->requisition_id,
            'requisition_no' => optional($transfer->requisition)->requisition_no,
            'category_id' => $transfer->category_id,
            'product_id' => $transfer->product_id,
            'item_description' => optional($transfer->product)->item_description,
            'current_stock' => $transfer->current_stock,
            'avg_rate' => $transfer->avg_rate,
            'transfer_qty' => $transfer->transfer_qty
        ));
        ?>
        <tr id="tr_{{$transfer->id}}" onclick="js_set_value('{{ $param }}' )" style="cursor: pointer;">
            <td>{{ get_all_company()[$transfer->company_id] ?? '' }}</td>
            <td>{{ $transfer->transfer_no }}</td>
            <td>{{ get_item_category()[$transfer->category_id] ?? '' }}</td>
            <td>{{ get_all_product()[$transfer->product_id] ?? '' }}</td>
            <td>{{ $transfer->transfer_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>