<?php

use App\Models\TransferMst;

$data = json_decode($param, true);

$company_id     = $data['company_id'] ?? null;
$transfer_no    = $data['transfer_no'] ?? null;
$category_id    = $data['category_id'] ?? null;
$product_id     = $data['product_id'] ?? null;
$requisition_no = $data['requisition_no'] ?? null;
$from_date      = $data['from_date'] ?? null;
$to_date        = $data['to_date'] ?? null;

$query_builder = TransferMst::query();

if (!empty($company_id)) {
    $query_builder->where('company_id', $company_id);
}

if (!empty($transfer_no)) {
    $query_builder->where('transfer_no', 'like', '%' . trim($transfer_no) . '%');
}

if (!empty($requisition_no)) {
    $query_builder->whereHas('requisition', function ($query) use ($requisition_no) {
        $query->where('requisition_no', 'like', '%' . $requisition_no . '%');
    });
}

if (!empty($category_id)) {
    $query_builder->whereHas('transferDtls', function ($query) use ($category_id) {
        $query->where('category_id', $category_id);
    });
}

if (!empty($product_id)) {
    $query_builder->whereHas('transferDtls', function ($query) use ($product_id) {
        $query->where('product_id', $product_id);
    });
}

if (!empty($from_date) && !empty($to_date)) {
    $query_builder->whereBetween('transfer_date', [$from_date, $to_date]);
}

$transfers = $query_builder
    ->with(['transferDtls', 'requisition'])
    ->latest()
    ->get();
?>
<table id="list_view" class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th>Company</th>
            <th>Transfer No</th>
            <th>Category</th>
            <th>Product</th>
            <th>Requisition No</th>
            <th>Transfer Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $sl = 1; ?>
        @foreach($transfers as $transfer)
        @foreach($transfer->transferDtls as $dtl)
        <?php
        $sl++;
        $param = json_encode([
            'id' => $transfer->id,
            'company_id' => $transfer->company_id,
            'transfer_no' => $transfer->transfer_no,
            'transfer_date' => $transfer->transfer_date,
            'requisition_id' => $transfer->requisition_id,
            'requisition_no' => optional($transfer->requisition)->requisition_no,
            'category_id' => $dtl->category_id,
            'product_id' => $dtl->product_id,
            'item_description' => optional($dtl->product)->item_description,
            'current_stock' => $dtl->current_stock ?? '',
            'avg_rate' => $dtl->avg_rate ?? '',
            'transfer_qty' => $dtl->transfer_qty,
        ]);
        ?>
        <tr id="tr_{{$transfer->id}}" onclick="js_set_value('{{ $param }}')" style="cursor: pointer;">
            <td>{{ get_all_company()[$transfer->company_id] ?? '' }}</td>
            <td>{{ $transfer->transfer_no }}</td>
            <td>{{ get_item_category()[$dtl->category_id] ?? '' }}</td>
            <td>{{ get_all_product()[$dtl->product_id] ?? '' }}</td>
            <td>{{ optional($transfer->requisition)->requisition_no }}</td>
            <td>{{ $transfer->transfer_date }}</td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>