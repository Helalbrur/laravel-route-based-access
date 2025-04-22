
<table class="table table-bordered table-striped text-center" id="dtls_list_view">
    <thead> 
        <tr>
            <th class="form-group" width="2%">Sl</th>
            <th class="form-group" width="7%">Item Name</th>
            <th class="form-group" width="7%">Item Code</th>
            <th class="form-group" width="7%">Item Category</th>
            <th class="form-group" width="8%">UOM</th>
            <th class="form-group" width="">Required QTY</th>
            <th class="form-group" width="7%">WO Qty</th>
            <th class="form-group" width="">Balance Qty</th>
            <th class="form-group" width="">Receive Qty</th>
            <th class="form-group" width="8%">Lot/Batch No.</th>
            <th class="form-group" width="8%">Expire Date</th>
            <th class="form-group" width="8%">Floor Name</th>
            <th class="form-group" width="8%">Room No</th>
            <th class="form-group" width="8%">Rack</th>
            <th class="form-group" width="8%">Self</th>
            <th class="form-group" width="8%">Bin</th>
            <th class="form-group" width="9%">Action</th>                              
        </tr>
    </thead>
    <tbody >
        <?php 
            use App\Models\LibFloorRoomRackMst;
            $floors = App\Models\LibFloor::get();
            $rooms  = LibFloorRoomRackMst::whereHas('room_details')->get(); 
            $racks  = LibFloorRoomRackMst::whereHas('rack_details')->get(); 
            $shelfs = LibFloorRoomRackMst::whereHas('shelf_details')->get(); 
            $bins   = LibFloorRoomRackMst::whereHas('bin_details')->get(); 
            
        ?>
        <?php $i = 1;?>
        @foreach ($receives as $receive) 
            <tr id="tr_{{ $i }}">
                <td class="form-group" id="sl_{{ $i }}">{{ $i }}</td>
                <td class="form-group">
                    <input type="text" name="txt_item_name_{{ $i }}" id="txt_item_name_{{ $i }}" class="form-control" value="{{ $receive->product->item_description }}" disabled>
                    <input type="hidden" name="hidden_product_id_{{ $i }}" id="hidden_product_id_{{ $i }}" class="form-control" value="{{ $receive->product_id }}">
                    <input type="hidden" name="hidden_conversion_fac_{{ $i }}" id="hidden_conversion_fac_{{ $i }}" class="form-control" value="{{ $receive->product->conversion_fac }}">
                    <input type="hidden" name="hidden_consuption_uom_{{ $i }}" id="hidden_consuption_uom_{{ $i }}" class="form-control" value="{{ $receive->product->consuption_uom }}">
                    <input type="hidden" name="hidden_dtls_id_{{ $i }}" id="hidden_dtls_id_{{ $i }}" class="form-control" value="{{ $receive->id }}">
                </td>
                <td class="form-group"><input type="text" name="txt_item_code_{{ $i }}" id="txt_item_code_{{ $i }}" class="form-control" value="{{ $receive->product->item_code }}" disabled></td>
                <td class="form-group">
                    <select name="cbo_item_category_{{ $i }}" id="cbo_item_category_{{ $i }}" class="form-control" disabled>
                        <option value="0">SELECT</option>
                        @foreach(get_item_category() as $id => $name)
                            <option value="{{$id}}" {{ $id == $receive->product->item_category_id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_order_uom_{{ $i }}" id="cbo_order_uom_{{ $i }}" class="form-control" disabled>
                        <option value="0">SELECT</option>
                        @foreach(get_uom() as $id => $name)
                            <option value="{{$id}}" {{ $id == $receive->product->order_uom ? 'selected' : '' }}>{{$name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group"><input type="text" name="txt_required_qty_{{ $i }}" id="txt_required_qty_{{ $i }}" class="form-control" value="{{ $receive->required_quantity }}" disabled></td>
                <td class="form-group">
                    <input type="text" name="txt_work_order_qty_{{ $i }}" id="txt_work_order_qty_{{ $i }}" class="form-control" value="{{ $receive->order_qnty }}" disabled>
                    <input type="hidden" name="txt_work_order_rate_{{ $i }}" id="txt_work_order_rate_{{ $i }}" class="form-control" value="{{ $receive->order_rate }}">
                    <input type="hidden" name="txt_work_order_amount_{{ $i }}" id="txt_work_order_amount_{{ $i }}" class="form-control" value="{{ $receive->order_qnty*$receive->order_rate }}">
                </td>
                <td class="form-group"><input type="text" name="txt_balance_qty_{{ $i }}" id="txt_balance_qty_{{ $i }}" class="form-control" value="{{ $receive->order_qnty-$receive->quantity }}" disabled></td>
                <td class="form-group"><input type="text" name="txt_receive_qty_{{ $i }}" id="txt_receive_qty_{{ $i }}" class="form-control" value="{{ $receive->quantity }}"></td>
                <td class="form-group"><input type="text" name="txt_lot_batch_no_{{ $i }}" id="txt_lot_batch_no_{{ $i }}" class="form-control" value="{{ $receive->lot }}"></td>
                <td class="form-group"><input type="text" name="txt_expire_date_{{ $i }}" id="txt_expire_date_{{ $i }}" class="form-control flatpickr" value="{{ $receive->receive_date }}"></td>
                <td class="form-group">
                    <select name="cbo_floor_name_{{ $i }}" id="cbo_floor_name_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach($floors as $id => $floor)
                            <option value="{{$floor->id}}" {{ $id == $receive->floor_id ? 'selected' : ''}}>{{$floor->floor_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_room_no_{{ $i }}" id="cbo_room_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach($rooms as $id => $room)
                            <option value="{{$room->id}}" {{ $id == $receive->room_id ? 'selected' : ''}}>{{$room->floor_room_rack_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_rack_no_{{ $i }}" id="cbo_rack_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            @foreach($racks as $id => $rack)
                                <option value="{{$rack->id}}" {{ $id == $receive->room_rack_id ? 'selected' : ''}}>{{$rack->floor_room_rack_name}}</option>
                            @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_shelf_no_{{ $i }}" id="cbo_shelf_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            @foreach($shelfs as $id => $shelf)
                                <option value="{{$shelf->id}}" {{ $id==$receive->room_self_id ? 'selected' : ''}}>{{$shelf->floor_room_rack_name}}</option>
                            @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_bin_no_{{ $i }}" id="cbo_bin_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            @foreach($bins as $id => $bin)
                                <option value="{{$bin->id}}" {{ $id==$receive->room_bin_id ? 'selected' : ''}}>{{$bin->floor_room_rack_name}}</option>
                            @endforeach
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