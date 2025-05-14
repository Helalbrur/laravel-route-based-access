<table class="table table-bordered table-striped text-center" id="dtls_list_view">
    <thead>
        <tr>
            <th class="form-group" width="2%">Sl</th>
            <th class="form-group" width="6%">Item</th>
            <th class="form-group" width="6%">Item Category</th>
            <th class="form-group" width="5%">Lot/Batch No.</th>
            <th class="form-group" width="5%">UOM</th>
            <th class="form-group" width="5%">Avl. Stock Qty</th>
            <th class="form-group" width="5%">Issue Qty</th>
            <th class="form-group" width="5%">Weighted Rate</th>
            <th class="form-group" width="5%">Actual Rate</th>
            <th class="form-group" width="5%">Item Total Amount</th>
            <th class="form-group" width="5%">Expire Date</th>
            <th class="form-group" width="6%">Floor Name</th>
            <th class="form-group" width="5%">Room No</th>
            <th class="form-group" width="5%">Rack</th>
            <th class="form-group" width="5%">Self</th>
            <th class="form-group" width="5%">Bin</th>
            <th class="form-group">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach ($requisitions as $requisition)
            <tr id="tr_{{ $i }}">
                <td class="form-group" id="sl_{{ $i }}"> {{ $i }}</td>
                <td class="form-group">
                    <input type="text" name="txt_item_name_{{ $i }}" id="txt_item_name_{{ $i }}" class="form-control" value="{{ $requisition->product->item_description ?? '' }}" placeholder="Browse" ondblclick="fn_item_popup({{ $i }})">
                    <input type="hidden" name="hidden_product_id_{{ $i }}" id="hidden_product_id_{{ $i }}" class="form-control" value="{{ $requisition->product_id }}">
                    <input type="hidden" name="hidden_dtls_id_{{ $i }}" id="hidden_dtls_id_{{ $i }}" class="form-control" value="">
                    <input type="hidden" name="req_dtls_id_{{ $i }}" id="req_dtls_id_{{ $i }}" class="form-control" value="{{ $requisition->id ?? '' }}">
                </td>
            
                <td class="form-group">
                    <select name="cbo_item_category_{{ $i }}" id="cbo_item_category_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach(get_item_category() as $id => $name)
                            <option value="{{$id}}" {{ $id == $requisition->category_id ? 'selected' : '' }}>{{$name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <input type="text" name="txt_lot_batch_no_{{ $i }}" id="txt_lot_batch_no_{{ $i }}" class="form-control" value="">
                </td>
                <td class="form-group">
                    <select name="cbo_uom_{{ $i }}" id="cbo_uom_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach(get_uom() as $id => $name)
                            <option value="{{$id}}" {{ $id == $requisition->product->cons_uom ? 'selected' : '' }}>{{$name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group">
                    <input type="text" name="txt_available_qty_{{ $i }}" id="txt_available_qty_{{ $i }}" class="form-control" readonly disabled value="{{ min($requisition->balance,$requisition->product->balance_qnty ?? 0)  }}">
                </td>
                <td class="form-group" title="requsition balance = {{ $requisition->balance }} , product balance = {{ $requisition->product->balance_qnty ?? 0 }} , min = {{ min($requisition->balance,$requisition->product->balance_qnty ?? 0) }}">
                    <input type="text" name="txt_issue_qty_{{ $i }}" id="txt_issue_qty_{{ $i }}" onkeyup="calculate_amount({{ $i }})" class="form-control" value="{{  min($requisition->balance,$requisition->product->balance_qnty ?? 0) }}">
                </td>
                <td class="form-group">
                    <input type="text" name="txt_weighted_rate_{{ $i }}" id="txt_weighted_rate_{{ $i }}" class="form-control" value="{{ $requisition->product->avg_rate ?? 0 }}">
                </td>
                <td class="form-group" title="requsition avg rate = {{ $requisition->product->avg_rate ?? 0 }} , product avg rate = {{ $requisition->product->avg_rate_per_unit ?? 0 }} ">
                    <input type="text" name="txt_cur_rate_{{ $i }}" id="txt_cur_rate_{{ $i }}" onkeyup="calculate_amount({{ $i }})" class="form-control" value="{{ $requisition->product->avg_rate ?? 0 }}">
                </td>
                <td class="form-group">
                    <input type="text" name="txt_item_total_amount_{{ $i }}" id="txt_item_total_amount_{{ $i }}" class="form-control" value="">
                </td>
                <td class="form-group">
                    <input type="text" name="txt_expire_date_{{ $i }}" id="txt_expire_date_{{ $i }}" class="form-control flatpickr" value="">
                </td>

                <td class="form-group" id="floor_div_{{ $i }}">
                    <?php 
                        $floors = App\Models\LibFloor::get();
                    ?>
                    <select name="cbo_floor_name_{{ $i }}" id="cbo_floor_name_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach($floors as $floor)
                            <option value="{{$floor->id}}">{{$floor->floor_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group" id="room_div_{{ $i }}">
                    <?php 
                        $rooms = App\Models\LibFloorRoomRackMst::whereHas('room_details')->get(); 
                    ?>
                    <select name="cbo_room_no_{{ $i }}" id="cbo_room_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach($rooms as $room)
                            <option value="{{$room->id}}">{{$room->floor_room_rack_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group" id="rack_div_{{ $i }}">
                    <?php 
                        $racks = App\Models\LibFloorRoomRackMst::whereHas('rack_details')->get(); 
                    ?>
                    <select name="cbo_rack_no_{{ $i }}" id="cbo_rack_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach($racks as $rack)
                            <option value="{{$rack->id}}">{{$rack->floor_room_rack_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group" id="shelf_div_{{ $i }}">
                    <?php 
                        $shelfs = App\Models\LibFloorRoomRackMst::whereHas('shelf_details')->get(); 
                    ?>
                    <select name="cbo_shelf_no_{{ $i }}" id="cbo_shelf_no_{{ $i }}" class="form-control">
                        <option value="0">SELECT</option>
                        @foreach($shelfs as $shelf)
                            <option value="{{$shelf->id}}">{{$shelf->floor_room_rack_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="form-group" id="bin_div_{{ $i }}">
                    <?php 
                        $bins = App\Models\LibFloorRoomRackMst::whereHas('bin_details')->get(); 
                    ?>
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
        <?php $i++; ?>
        @endforeach
    </tbody>
</table>