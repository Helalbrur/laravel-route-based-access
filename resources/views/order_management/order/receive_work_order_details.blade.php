<table class="table table-bordered table-striped text-center" id="dtls_list_view">
    <thead> 
        <tr>
            <th class="form-group" width="3%">Sl</th>
            <th class="form-group" width="10%">Item Name</th>
            <th class="form-group" width="10%">Item Code</th>
            <th class="form-group" width="10%">Item Category</th>
            <th class="form-group" width="10%">UOM</th>
            <th class="form-group" width="10%">Required QTY</th>
            <th class="form-group" width="10%">Work Order Qty</th>
            <th class="form-group" width="10%">Balance Qty</th>
            <th class="form-group" width="10%">Receive Qty</th>
            <th class="form-group" width="10%">Lot/Batch No.</th>
            <th class="form-group" width="10%">Expire Date</th>
            <th class="form-group" width="10%">Rack</th>
            <th class="form-group" width="10%">Self</th>
            <th class="form-group" width="10%">Bin</th>
            <th class="form-group">Action</th>
        </tr>
    </thead>
    <tbody >
        <?php $i = 1;?>
        @foreach ($orders as $order)
        <tr id="tr_1">
                <td class="form-group" id="sl_{{ $i }}">{{ $i }}</td>
                <td class="form-group">
                    <input type="text" name="txt_item_name_{{ $i }}" id="txt_item_name_{{ $i }}" class="form-control" value="{{ $order->product->item_description }}">
                    <input type="hidden" name="hidden_product_id_{{ $i }}" id="hidden_product_id_{{ $i }}" class="form-control" value="{{ $order->product_id }}">
                    <input type="hidden" name="hidden_dtls_id_{{ $i }}" id="hidden_dtls_id_{{ $i }}" class="form-control" value="">
                </td>
                <td class="form-group"><input type="text" name="txt_item_code_{{ $i }}" id="txt_item_code_{{ $i }}" class="form-control" value="{{ $order->product->item_code }}"></td>
                <td class="form-group">
                    <select name="cbo_item_category_{{ $i }}" id="cbo_item_category_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach(get_item_category() as $id => $name)
                            <option value="{{$id}}" {{ $id == $order->category_id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_uom_{{ $i }}" id="cbo_uom_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach(get_uom() as $id => $name)
                            <option value="{{$id}}" {{ $id == $order->uom ? 'selected' : '' }}>{{$name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group"><input type="text" name="txt_required_qty_{{ $i }}" id="txt_required_qty_{{ $i }}" class="form-control" value="{{ $order->required_quantity }}"></td>
                <td class="form-group"><input type="text" name="txt_work_order_qty_{{ $i }}" id="txt_work_order_qty_{{ $i }}" class="form-control" value="{{ $order->quantity }}"></td>
                <td class="form-group"><input type="text" name="txt_balance_qty_{{ $i }}" id="txt_balance_qty_{{ $i }}" class="form-control" value=""></td>
                <td class="form-group"><input type="text" name="txt_receive_qty_{{ $i }}" id="txt_receive_qty_{{ $i }}" class="form-control" value=""></td>
                <td class="form-group"><input type="text" name="txt_lot_batch_no_{{ $i }}" id="txt_lot_batch_no_{{ $i }}" class="form-control" value=""></td>
                <td class="form-group"><input type="text" name="txt_expire_date_{{ $i }}" id="txt_expire_date_{{ $i }}" class="form-control" value=""></td>
                <td class="form-group">
               
                    <select name="cbo_rack_no_{{ $i }}" id="cbo_rack_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            <option value=""></option>
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_shelf_no_{{ $i }}" id="cbo_shelf_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            <option value=""></option>
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_bin_no_{{ $i }}" id="cbo_bin_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            <option value=""></option>
                    </select>
                </td>

                <td class="form-group">
                    <button type="button" class="btn btn-success" name="btn_add_row_{{ $i }}"  id="btn_add_row_{{ $i }}" onclick="add_row({{ $i }})"><i class="fa fa-plus"></i></button> 
                    <button type="button" class="btn btn-danger" name="btn_remove_row_{{ $i }}" id="btn_remove_row_{{ $i }}" onclick="remove_row({{ $i }})"><i class="fa fa-minus"></i></button>
                </td>
            </tr>
            <?php $i++;?>
        @endforeach
    </tbody>
</table>