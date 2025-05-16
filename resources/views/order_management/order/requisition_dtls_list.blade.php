<table id="list_view" class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th colspan="6">
                <h4>Requisition Details List</h4>
            </th>
        </tr>
        <tr class="table-secondary">
            <th width="10%">SL</th>
            <th width="20%">Product</th>
            <th width="20%">Category</th>
            <th width="17%">Requisition Qty</th>
            <th width="17%">Issue Qty</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @forelse($requisition_dtls as $req_dtls)
        <?php
        $param = json_encode([
            'id' => $req_dtls->id,
            'category_id' => $req_dtls->category_id,
            'product_id' => $req_dtls->product_id,
            'item_description' => optional($req_dtls->product)->item_description,
            'avg_rate' => round(optional($req_dtls->product)->avg_rate,6)
        ]);
        ?>
        <tr id="tr_{{$req_dtls->id}}" onclick="set_requisition_dtls_data('{{ $param }}')" style="cursor: pointer;">
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($req_dtls->product)->item_description }}</td>
            <td>{{ optional($req_dtls->category)->category_name }}</td>
            <td>{{ $req_dtls->requisition_qty }}</td>
            <td>{{ $req_dtls->issue_qty ?? 0 }}</td>
            <td>{{ $req_dtls->balance ?? 0 }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No data found</td>
        </tr>
        @endforelse
    </tbody>
</table>