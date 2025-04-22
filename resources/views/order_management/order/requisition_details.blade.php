<table class="table table-bordered table-striped text-center" id="dtls_list_view">
    <thead>
        <tr>
            <th class="form-group" width="3%">Sl</th>
            <th class="form-group" width="20%">Item Name</th>
            <th class="form-group" width="20%">Item Code</th>
            <th class="form-group" width="15%">Item Category</th>
            <th class="form-group" width="15%">UOM</th>
            <th class="form-group" width="15%">Requisition Qty</th>
            <th class="form-group">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach ($requisitions as $requisition)
        <tr id="tr_{{ $i }}">
            <td class="form-group" id="sl_{{ $i }}">{{ $i }}</td>
            <td class="form-group">
                <input type="text" name="txt_item_name_{{ $i }}" id="txt_item_name_{{ $i }}" class="form-control" value="{{ $requisition->product->item_description ?? '' }}" ondblclick="fn_item_popup({{ $i }})" readonly>
                <input type="hidden" name="hidden_product_id_{{ $i }}" id="hidden_product_id_{{ $i }}" class="form-control" value="{{ $requisition->product_id }}">
                <input type="hidden" name="hidden_dtls_id_{{ $i }}" id="hidden_dtls_id_{{ $i }}" class="form-control" value="{{ $requisition->id }}">
            </td>
            <td class="form-group">
                <input type="text" name="txt_item_code_{{ $i }}" id="txt_item_code_{{ $i }}" class="form-control" value="{{ $requisition->product->item_code ?? '' }}" readonly>
            </td>
            <td class="form-group">
                <select name="cbo_item_category_{{ $i }}" id="cbo_item_category_{{ $i }}" class="form-control">
                    <option value="0">SELECT</option>
                    @foreach(get_item_category() as $id => $name)
                    <option value="{{$id}}" {{ $id == $requisition->category_id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="form-group">
                <select name="cbo_uom_{{ $i }}" id="cbo_uom_{{ $i }}" class="form-control">
                    <option value="0">SELECT</option>
                    @foreach(get_uom() as $id => $name)
                    <option value="{{$id}}" {{ $id == $requisition->uom ? 'selected' : '' }}>{{$name}}</option>
                    @endforeach
                </select>
            </td>
            <td class="form-group">
                <input type="text" name="txt_requisition_qty_{{ $i }}" id="txt_requisition_qty_{{ $i }}" class="form-control" value="{{ $requisition->requisition_qty }}">
            </td>
            <td class="form-group">
                <button type="button" class="btn btn-success" name="btn_add_row_{{ $i }}" id="btn_add_row_{{ $i }}" onclick="add_row({{ $i }})">
                    <i class="fa fa-plus"></i>
                </button>
                <button type="button" class="btn btn-danger" name="btn_remove_row_{{ $i }}" id="btn_remove_row_{{ $i }}" onclick="remove_row({{ $i }})">
                    <i class="fa fa-minus"></i>
                </button>
            </td>
        </tr>
        <?php $i++; ?>
        @endforeach
    </tbody>
</table>