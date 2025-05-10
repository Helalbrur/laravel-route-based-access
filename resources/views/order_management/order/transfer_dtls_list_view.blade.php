<table id="dtls_list_view" class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr class="table-secondary">
            <th width="10%">SL</th>
            <th width="35%">Product</th>
            <th width="35%">Category</th>
            <th>Transfer Qty</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transfer_dtls as $trans_dtls)
        <?php
        $param = json_encode([
            'id' => $trans_dtls->id,
            'trans_from_id' => $trans_dtls->trans_from_id,
            'trans_to_id' => $trans_dtls->trans_to_id,
            'category_id' => $trans_dtls->category_id,
            'product_id' => $trans_dtls->product_id,
            'item_description' => optional($trans_dtls->product)->item_description,
            'transfer_qty' => $trans_dtls->transfer_qty
        ]);
        ?>
        <tr id="tr_{{$trans_dtls->id}}" onclick="set_transfer_dtls_data('{{ $param }}')" style="cursor: pointer;">
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($trans_dtls->product)->item_description }}</td>
            <td>{{ optional($trans_dtls->category)->category_name }}</td>
            <td>{{ $trans_dtls->transfer_qty }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No data found</td>
        </tr>
        @endforelse
    </tbody>
</table>