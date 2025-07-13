
<table class="table table-bordered table-striped text-center" id="dtls_list_view">
    <thead> 
        <tr>
            <th class="form-group" width="2%">Sl</th>
            <th class="form-group" width="6%">Item Name</th>
            <th class="form-group" width="5%">Item Code</th>
            <th class="form-group" width="6%">Item Category</th>
            <th class="form-group" width="6%">UOM</th>
            <th class="form-group" width="5%">Required QTY</th>
            <th class="form-group" width="5%">WO Qty</th>
            <th class="form-group" width="5%">Rate</th>
            <th class="form-group" width="5%">Balance Qty</th>
            <th class="form-group" width="5%">Receive Qty</th>
            <th class="form-group" width="6%">Lot/Batch No.</th>
            <th class="form-group" width="5%">Expire Date</th>
            <th class="form-group" width="6%">Floor Name</th>
            <th class="form-group" width="6%">Room No</th>
            <th class="form-group" width="6%">Rack</th>
            <th class="form-group" width="6%">Self</th>
            <th class="form-group" width="6%">Bin</th>
            <th class="form-group" width="">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            use App\Models\LibFloorRoomRackMst;
            $floors = App\Models\LibFloor::get();
            $rooms  = LibFloorRoomRackMst::whereHas('room_details')->get(); 
            $racks  = LibFloorRoomRackMst::whereHas('rack_details')->get(); 
            $shelfs = LibFloorRoomRackMst::whereHas('shelf_details')->get(); 
            $bins   = LibFloorRoomRackMst::whereHas('bin_details')->get(); 
            
        ?>
        <?php $i = 1;?>
        @foreach ($orders as $order)
        <tr id="tr_{{ $i }}">
                <td class="form-group" id="sl_{{ $i }}">{{ $i }}</td>
                <td class="form-group" title="{{ $order->product->item_description }}">
                    <input type="text" name="txt_item_name_{{ $i }}" id="txt_item_name_{{ $i }}" class="form-control" value="{{ $order->product->item_description }}" disabled>
                    <input type="hidden" name="hidden_product_id_{{ $i }}" id="hidden_product_id_{{ $i }}" class="form-control" value="{{ $order->product_id }}">
                    <input type="hidden" name="hidden_conversion_fac_{{ $i }}" id="hidden_conversion_fac_{{ $i }}" class="form-control" value="{{ $order->product->conversion_fac }}">
                    <input type="hidden" name="hidden_consuption_uom_{{ $i }}" id="hidden_consuption_uom_{{ $i }}" class="form-control" value="{{ $order->product->consuption_uom }}">
                    <input type="hidden" name="hidden_dtls_id_{{ $i }}" id="hidden_dtls_id_{{ $i }}" class="form-control" value="">
                </td>
                <td class="form-group" title="{{ $order->product->item_code }}">
                    <input type="text" name="txt_item_code_{{ $i }}" id="txt_item_code_{{ $i }}" class="form-control" value="{{ $order->product->item_code }}" disabled>
                </td>
                <td class="form-group">
                    <select name="cbo_item_category_{{ $i }}" id="cbo_item_category_{{ $i }}" class="form-control" disabled>
                        <option value="0">SELECT</option>
                        @foreach(get_item_category() as $id => $name)
                            <option value="{{$id}}" {{ $id == $order->category_id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <select name="cbo_order_uom_{{ $i }}" id="cbo_order_uom_{{ $i }}" class="form-control" disabled>
                        <option value="0">SELECT</option>
                        @foreach(get_uom() as $id => $name)
                            <option value="{{$id}}" {{ $id == $order->uom ? 'selected' : '' }}>{{$name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group" title="{{ $order->required_quantity }}">
                    <input type="text" name="txt_required_qty_{{ $i }}" id="txt_required_qty_{{ $i }}" class="form-control" value="{{ $order->required_quantity }}" disabled>
                </td>
                <td class="form-group" title="{{ $order->quantity }}">
                    <input type="text" name="txt_work_order_qty_{{ $i }}" id="txt_work_order_qty_{{ $i }}" class="form-control" value="{{ $order->quantity }}" disabled>
                    <input type="hidden" name="txt_work_order_rate_{{ $i }}" id="txt_work_order_rate_{{ $i }}" class="form-control" value="{{ $order->rate }}">
                    <input type="hidden" name="txt_work_order_amount_{{ $i }}" id="txt_work_order_amount_{{ $i }}" class="form-control" value="{{ $order->quantity*$order->rate }}">
                    <input type="hidden" name="hidden_work_order_detailsId_{{ $i }}" id="hidden_work_order_detailsId_{{ $i }}" class="form-control" value="{{ $order->id }}">
                </td>
                <td class="form-group" title="{{ $order->rate }}">
                     <input type="text" name="txt_work_order_rate_{{ $i }}" id="txt_work_order_rate_{{ $i }}" class="form-control" value="{{ $order->rate }}" disabled>
                </td>
                <td class="form-group" title="{{ $work_dtls_data[$order->id]['balance'] ?? 0 }}">
                    <input type="text" name="txt_balance_qty_{{ $i }}" id="txt_balance_qty_{{ $i }}" class="form-control" value="{{ $work_dtls_data[$order->id]['balance'] ?? 0 }}" disabled>
                </td>
                <td class="form-group" >
                    <input type="text" name="txt_receive_qty_{{ $i }}" id="txt_receive_qty_{{ $i }}" class="form-control" value="">
                </td>
                <td class="form-group">
                    <input type="text" name="txt_lot_batch_no_{{ $i }}" id="txt_lot_batch_no_{{ $i }}" class="form-control" value="">
                </td>
                <td class="form-group">
                    <input type="text" name="txt_expire_date_{{ $i }}" id="txt_expire_date_{{ $i }}" class="form-control flatpickr" value="">
                </td>
                <td class="form-group" id="floor_div_{{ $i }}">
                    <select name="cbo_floor_name_{{ $i }}" id="cbo_floor_name_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach($floors as $floor)
                            <option value="{{$floor->id}}">{{$floor->floor_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group" id="room_div_{{ $i }}">
                    <select name="cbo_room_no_{{ $i }}" id="cbo_room_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach($rooms as $room)
                            <option value="{{$room->id}}">{{$room->floor_room_rack_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group" id="rack_div_{{ $i }}">
                    <select name="cbo_rack_no_{{ $i }}" id="cbo_rack_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            @foreach($shelfs as $shelf)
                                <option value="{{$shelf->id}}">{{$shelf->floor_room_rack_name}}</option>
                            @endforeach
                    </select>
                </td>
                <td class="form-group" id="shelf_div_{{ $i }}">
                    <select name="cbo_shelf_no_{{ $i }}" id="cbo_shelf_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            @foreach($racks as $rack)
                                <option value="{{$rack->id}}">{{$rack->floor_room_rack_name}}</option>
                            @endforeach
                    </select>
                </td>
                <td class="form-group" id="bin_div_{{ $i }}">
                    <select name="cbo_bin_no_{{ $i }}" id="cbo_bin_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                            @foreach($bins as $bin)
                                <option value="{{$bin->id}}">{{$bin->floor_room_rack_name}}</option>
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