<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Transfer';
?>
@extends('layouts.app')
@section('content_header')
<div class="row">
    <div class="col-sm-12">
        <center>
            <h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Transfer'}}</strong></h1>
        </center>
    </div>
</div>
@endsection()
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        <form name="transfer_1" id="transfer_1" autocomplete="off">

            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card pt-4 px-4" style="background-color: rgb(241, 241, 241);">

                            <div class="row justify-content-center">
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="txt_sys_no" class="col-sm-4 col-form-label fw-bold text-start must_entry_caption">Transfer No</label>
                                    <div class="col-sm-6 d-flex align-items-center">
                                        <input id="txt_sys_no" name="txt_sys_no" placeholder="Browse" ondblclick="fnc_transfer_popup()" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_company_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Company</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <select style="width: 100%" name="cbo_company_name" id="cbo_company_name" class="form-control" onchange="handleCompanyChange()">
                                                <option value="0">SELECT</option>
                                                <?php $lib_company = App\Models\Company::pluck('company_name', 'id'); ?>
                                                @foreach($lib_company as $id => $company_name)
                                                <option value="{{ $id }}">{{ $company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_transfer_date" class="col-sm-6 col-form-label fw-bold text-start">Transfer Date</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="date" id="txt_transfer_date" class="form-control flatpickr" name="txt_transfer_date" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_requisition_no" class="col-sm-6 col-form-label fw-bold text-start">Requisition No</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input id="txt_requisition_no" name="txt_requisition_no" placeholder="Browse" ondblclick="fnc_requisition_popup()" class="form-control">
                                            <input type="hidden" name="hidden_requisition_id" id="hidden_requisition_id" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_item_category" class="col-sm-6 col-form-label fw-bold text-start">Category</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <select name="cbo_item_category" id="cbo_item_category" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach(get_item_category() as $id => $name)
                                                <option value="{{$id}}">{{$name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_item_name" class="col-sm-6 col-form-label fw-bold text-start">Product</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" name="txt_item_name" id="txt_item_name" class="form-control" placeholder="Browse" ondblclick="fn_item_popup(1)">
                                            <input type="hidden" name="hidden_product_id" id="hidden_product_id" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_current_stock" class="col-sm-6 col-form-label fw-bold text-start">Current Stock</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="number" id="txt_current_stock" name="txt_current_stock" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_avg_rate" class="col-sm-6 col-form-label fw-bold text-start">Average Rate</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="number" id="txt_avg_rate" name="txt_avg_rate" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_transfer_qty" class="col-sm-6 col-form-label fw-bold text-start">Transfer Qty</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="number" id="txt_transfer_qty" name="txt_transfer_qty" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="row" id="transaction_dtls_div">

                            {{-- Transfer From Card --}}
                            <input type="hidden" name="hidden_trans_from_id" id="hidden_trans_from_id">
                            <input type="hidden" name="hidden_req_dtls_id" id="hidden_req_dtls_id">
                            <div class="col-md-6">
                                <div class="card h-100" style="background-color: rgb(241, 241, 241);">
                                    <div class="card-header fw-bold" style="background-color: rgb(226, 226, 226);">Transfer From</div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="cbo_location_from" class="col-sm-4 col-form-label">Location</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="location_div_from">
                                                <select name="cbo_location_from" id="cbo_location_from" class="form-control w-100" onchange="handle_location_from_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibLocation::pluck('location_name', 'id') as $id => $location_name)
                                                    <option value="{{ $id }}">{{ $location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_store_from" class="col-sm-4 col-form-label">Store</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="store_div_from">
                                                <select name="cbo_store_from" id="cbo_store_from" class="form-control w-100" onchange="handle_store_from_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibStoreLocation::get() as $store)
                                                    <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_floor_name_from" class="col-sm-4 col-form-label">Floor</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="floor_div_from">
                                                <select name="cbo_floor_name_from" id="cbo_floor_name_from" class="form-control w-100" onchange="handle_floor_from_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibFloor::get() as $floor)
                                                    <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_room_no_from" class="col-sm-4 col-form-label">Room</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="room_div_from">
                                                <select name="cbo_room_no_from" id="cbo_room_no_from" class="form-control w-100" onchange="handle_room_from_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('room_details')->get() as $room)
                                                    <option value="{{ $room->id }}">{{ $room->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_rack_no_from" class="col-sm-4 col-form-label">Rack</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="rack_div_from">
                                                <select name="cbo_rack_no_from" id="cbo_rack_no_from" class="form-control w-100" onchange="handle_rack_from_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('rack_details')->get() as $rack)
                                                    <option value="{{ $rack->id }}">{{ $rack->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_shelf_no_from" class="col-sm-4 col-form-label">Shelf</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="shelf_div_from" onchange="handle_shelf_from_change()">
                                                <select name="cbo_shelf_no_from" id="cbo_shelf_no_from" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('shelf_details')->get() as $shelf)
                                                    <option value="{{ $shelf->id }}">{{ $shelf->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_bin_no_from" class="col-sm-4 col-form-label">Bin</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="bin_div_from">
                                                <select name="cbo_bin_no_from" id="cbo_bin_no_from" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('bin_details')->get() as $bin)
                                                    <option value="{{ $bin->id }}">{{ $bin->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Transfer To Card --}}
                            <input type="hidden" name="hidden_trans_to_id" id="hidden_trans_to_id">
                            <div class="col-md-6">
                                <div class="card h-100" style="background-color: rgb(241, 241, 241);">
                                    <div class="card-header fw-bold" style="background-color: rgb(226, 226, 226);">Transfer To</div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="cbo_location_to" class="col-sm-4 col-form-label">Location</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="location_div_to">
                                                <select name="cbo_location_to" id="cbo_location_to" class="form-control w-100" onchange="handle_location_to_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibLocation::pluck('location_name', 'id') as $id => $location_name)
                                                    <option value="{{ $id }}">{{ $location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_store_to" class="col-sm-4 col-form-label">Store</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="store_div_to">
                                                <select name="cbo_store_to" id="cbo_store_to" class="form-control w-100" onchange="handle_store_to_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibStoreLocation::get() as $store)
                                                    <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_floor_name_to" class="col-sm-4 col-form-label">Floor</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="floor_div_to">
                                                <select name="cbo_floor_name_to" id="cbo_floor_name_to" class="form-control w-100" onchange="handle_floor_to_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibFloor::get() as $floor)
                                                    <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_room_no_to" class="col-sm-4 col-form-label">Room</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="room_div_to">
                                                <select name="cbo_room_no_to" id="cbo_room_no_to" class="form-control w-100" onchange="handle_room_to_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('room_details')->get() as $room)
                                                    <option value="{{ $room->id }}">{{ $room->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_rack_no_to" class="col-sm-4 col-form-label">Rack</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="rack_div_to">
                                                <select name="cbo_rack_no_to" id="cbo_rack_no_to" class="form-control w-100" onchange="handle_rack_to_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('rack_details')->get() as $rack)
                                                    <option value="{{ $rack->id }}">{{ $rack->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_shelf_no_to" class="col-sm-4 col-form-label">Shelf</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="shelf_div_to">
                                                <select name="cbo_shelf_no_to" id="cbo_shelf_no_to" class="form-control w-100" onchange="handle_shelf_to_change()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('shelf_details')->get() as $shelf)
                                                    <option value="{{ $shelf->id }}">{{ $shelf->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_bin_no_to" class="col-sm-4 col-form-label">Bin</label>
                                            <div class="col-sm-8 d-flex align-items-center" id="bin_div_to">
                                                <select name="cbo_bin_no_to" id="cbo_bin_no_to" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('bin_details')->get() as $bin)
                                                    <option value="{{ $bin->id }}">{{ $bin->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-auto">
                    <input type="hidden" name="update_id" id="update_id">
                    <input type="hidden" name="hidden_transfer_dtls_id" id="hidden_transfer_dtls_id">
                </div>
                <div class="col-auto">
                    <?php echo load_submit_buttons($permission, "fnc_transfer", 0, 0, "reset_form('transfer_1','','',1)"); ?>
                </div>
            </div>

            <div class="card col-md-10 mx-auto" style="background-color: rgb(241, 241, 241);">
                <div class="card-body">
                    <div class="card-text">
                        <div class="row justify-content-center" id="requisition_dtls_div">

                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-md-10 mx-auto" style="background-color: rgb(241, 241, 241);">
                <div class="card-body">
                    <div class="card-text">
                        <div class="row justify-content-center" id="transfer_dtls_div">

                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    var permission = '{{$permission}}';
    // var setup_data = load_all_setup();

    $('#txt_transfer_qty').on('keyup', function() {
        let currentStock = parseFloat($('#txt_current_stock').val()) || 0;
        let transferQty = parseFloat($(this).val()) || 0;

        if (transferQty > currentStock) {
            $(this).val(''); // Clear the input if transfer quantity exceeds current stock
            alert('Transfer quantity cannot exceed current stock.');
        }
    });

    function fnc_transfer_popup() {
        if (form_validation('cbo_company_name', 'Company Name') == false) {
            return;
        }

        var param = JSON.stringify({
            'company_id': $("#cbo_company_name").val()
        });
        //console.log(param);
        var title = 'Transfer Search';
        var page_link = '/show_common_popup_view?page=transfer_search&param=' + param;
        emailwindow = dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=1000px,height=370px,center=1,resize=1,scrolling=1', '../');
        emailwindow.onclose = async function() {

            try {
                let popupField = this.contentDoc?.getElementById("popup_value");
                if (!popupField || popupField.value === '') return;

                let data = JSON.parse(popupField.value);
                //console.log(data);

                if (data) {
                    $('#txt_sys_no').val(data.transfer_no);
                    $('#txt_sys_no').prop('readonly', true);
                    $('#update_id').val(data.id);
                    $('#cbo_company_name').val(data.company_id).trigger('change');
                    $('#txt_transfer_date').val(data.transfer_date);
                    $('#txt_requisition_no').val(data.requisition_no);
                    $('#hidden_requisition_id').val(data.requisition_id);
                    $('#cbo_item_category').val(0).trigger('change');
                    $('#txt_item_name').val('');
                    $('#hidden_product_id').val('');
                    $('#txt_current_stock').val();
                    $('#txt_avg_rate').val();
                    $('#txt_transfer_qty').val();

                    await load_tranfer_dtls(data.id);
                    await load_requisition_dtls_list_view(data.requisition_id);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }

    async function handleCompanyChange() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'company_id': document.getElementById('cbo_company_name').value,
                'onchange': 'handle_location_from_change()',
                'field_name': 'cbo_location_from',
                'field_id': 'cbo_location_from',
            }), 'location_under_company', 'location_div_from');

            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'company_id': document.getElementById('cbo_company_name').value,
                'onchange': 'handle_location_from_change()',
                'field_name': 'cbo_location_to',
                'field_id': 'cbo_location_to',
            }), 'location_under_company', 'location_div_to');
            await calculateStock();

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    function fnc_transfer(operation) {
        if (form_validation('cbo_company_name*txt_item_name*txt_transfer_date', 'Company Name*Item Name*Transfer Date') == false) {
            return;
        } else {
            var formData = get_form_data('txt_sys_no,update_id,cbo_company_name,txt_transfer_date,hidden_requisition_id,cbo_item_category,hidden_product_id,txt_current_stock,txt_avg_rate,txt_transfer_qty,cbo_location_from,cbo_store_from,cbo_floor_name_from,cbo_room_no_from,cbo_rack_no_from,cbo_shelf_no_from,cbo_bin_no_from,cbo_location_to,cbo_store_to,cbo_floor_name_to,cbo_room_no_to,cbo_rack_no_to,cbo_shelf_no_to,cbo_bin_no_to,hidden_trans_from_id,hidden_trans_to_id,hidden_req_dtls_id,hidden_transfer_dtls_id');

            var method = "POST";
            var param = "";

            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
                if (operation == 1) {
                    formData.append('_method', 'PUT');
                } else {
                    formData.append('_method', 'DELETE');
                }
            }

            formData.append('_token', '{{csrf_token()}}');
            formData.append('operation', operation);

            var url = `/order/transfer${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData, 'id', '', '', 'transfer_1');
        }
    }

    const load_php_data_to_form = async (update_id) => {
        freeze_window(3);
        try {
            reset_form('transfer_1', '', '', 1);

            const response = await fetch(`get_transfer_mst_data/${update_id}`);
            const result = await response.json();

            if (result.code === 200 && result.data) {
                const data = result.data;
                $('#txt_sys_no').val(data.transfer_no);
                $('#txt_sys_no').prop('readonly', true);
                $('#update_id').val(data.id);
                $('#cbo_company_name').val(data.company_id).trigger('change');
                $('#txt_transfer_date').val(data.transfer_date);
                $('#txt_requisition_no').val(data.requisition_no);
                $('#hidden_requisition_id').val(data.requisition_id);
                $('#cbo_item_category').val(0).trigger('change');
                $('#txt_item_name').val('');
                $('#hidden_product_id').val('');
                $('#txt_current_stock').val();
                $('#txt_avg_rate').val();
                $('#txt_transfer_qty').val();

                await load_tranfer_dtls(data.id);
                await load_requisition_dtls_list_view(data.requisition_id);

            } else {
                console.warn("Unexpected response:", result);
            }

        } catch (error) {
            console.error('Error in load_php_data_to_form:', error);
            showNotification('An unexpected error occurred.', 'warning');
            await calculateStock();
        } finally {
            release_freezing();
        }
    }

    function fn_item_popup(row_id) {

        var param = JSON.stringify({
            'item_category_id': $("#cbo_item_category").val()
        });

        var title = 'Item Search';
        var page_link = '/show_common_popup_view?page=transfer_item_search&param=' + param;
        emailwindow = dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1', '../');
        emailwindow.onclose = function() {

            try {

                let popupField = this.contentDoc?.getElementById("popup_value");
                if (!popupField || popupField.value === '') {
                    return;
                }

                let data = JSON.parse(popupField.value);
                console.log(data);

                if (data) {
                    let {
                        id,
                        item_category_id,
                        item_description,
                        current_stock
                    } = data;

                    $('#hidden_product_id').val(id);
                    $('#cbo_item_category').val(item_category_id).trigger('change');
                    $('#txt_item_name').val(item_description);
                    $('#txt_current_stock').val(current_stock);
                }

            } catch (error) {
                console.error('Error:', error);
            }
        }
    }

    async function load_tranfer_dtls(mst_id) {
        await fetch(`/order/transfer_dtls/${mst_id}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('transfer_dtls_div').innerHTML = html;
                initializeSelect2();
            })
            .catch(error => console.error('Error loading details:', error));
    }

    async function load_transaction_dtls(mst_id) {
        await fetch(`/order/transaction_dtls/${mst_id}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('transaction_dtls_div').innerHTML = html;
                initializeSelect2();
            })
            .catch(error => console.error('Error loading details:', error));
    }

    function fnc_requisition_popup() {
        if (form_validation('cbo_company_name', 'Company Name') == false) {
            return;
        }

        var param = JSON.stringify({
            'company_id': $("#cbo_company_name").val()
        });
        //console.log(param);
        var title = 'Transfer Search';
        var page_link = '/show_common_popup_view?page=requisition_search&param=' + param;
        emailwindow = dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1', '../');
        emailwindow.onclose = async function() {

            try {
                let popupField = this.contentDoc?.getElementById("popup_value");
                if (!popupField || popupField.value === '') {
                    return;
                }

                let data = JSON.parse(popupField.value);
                console.log(data);

                if (data) {
                    let {
                        id,
                        requisition_no
                    } = data;

                    $('#hidden_requisition_id').val(id);
                    $('#txt_requisition_no').val(requisition_no);

                    load_requisition_dtls_list_view(id);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }

    async function load_requisition_dtls_list_view(requisition_id) {
        await fetch(`/order/show_requisition_dtls_list_view/${requisition_id}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('requisition_dtls_div').innerHTML = html;
            })
            .catch(error => console.error('Error loading requisition details:', error));
    }

    async function set_transfer_dtls_data(param) {
        try {
            const data = typeof param === 'string' ? JSON.parse(param) : param;
            $('#hidden_transfer_dtls_id').val(data.id);
            $('#cbo_item_category').val(data.category_id).trigger('change');
            $('#txt_item_name').val(data.item_description);
            $('#hidden_product_id').val(data.product_id);
            $('#txt_avg_rate').val(data.avg_rate);
            $('#txt_transfer_qty').val(data.transfer_qty);

            await load_transaction_dtls(data.mst_id);

            stockParams['product_id'] = data.product_id;
            stockParams['location_id'] = document.getElementById('cbo_location_from').value;
            stockParams['store_id'] = document.getElementById('cbo_store_from').value;
            stockParams['floor_id'] = document.getElementById('cbo_floor_name_from').value;
            stockParams['room_id'] = document.getElementById('cbo_room_no_from').value;
            stockParams['room_rack_id'] = document.getElementById('cbo_rack_no_from').value;
            stockParams['room_self_id'] = document.getElementById('cbo_shelf_no_from').value;
            stockParams['room_bin_id'] = document.getElementById('cbo_bin_no_from').value;

            await calculateStock();

            set_button_status(1, permission, 'fnc_transfer', 1);

        } catch (e) {
            console.error('Error processing parameter:', e);
        }
    }

   async function set_requisition_dtls_data(param) {
        try {
            const data = typeof param === 'string' ? JSON.parse(param) : param;
            $('#hidden_req_dtls_id').val(data.id);
            $('#cbo_item_category').val(data.category_id).trigger('change');
            $('#txt_item_name').val(data.item_description);
            $('#hidden_product_id').val(data.product_id);
            $('#txt_avg_rate').val(data.avg_rate);
            stockParams['product_id'] = data.product_id;
            stockParams['location_id'] = document.getElementById('cbo_location_from').value;
            stockParams['store_id'] = document.getElementById('cbo_store_from').value;
            stockParams['floor_id'] = document.getElementById('cbo_floor_name_from').value;
            stockParams['room_id'] = document.getElementById('cbo_room_no_from').value;
            stockParams['room_rack_id'] = document.getElementById('cbo_rack_no_from').value;
            stockParams['room_self_id'] = document.getElementById('cbo_shelf_no_from').value;
            stockParams['room_bin_id'] = document.getElementById('cbo_bin_no_from').value;
            await calculateStock();
        } catch (e) {
            console.error('Error processing parameter:', e);
        }
    }

    // Store selected values globally
    let stockParams = {
        product_id: 0,
        location_id: 0,
        store_id: 0,
        floor_id: 0,
        room_id: 0,
        room_rack_id: 0,
        room_self_id: 0,
        room_bin_id: 0
    };

    function handleDropdownChange(element, paramName) {
        const field_value = element;
        stockParams[paramName] = field_value;
        // console.log(`${paramName} : ${field_value}`);
        calculateStock();
    }

    function calculateStock() {
        // Only proceed if we have a product_id
        stockParams['product_id'] = document.getElementById('hidden_product_id').value;
        stockParams['location_id'] = document.getElementById('cbo_location_from').value;
        stockParams['store_id'] = document.getElementById('cbo_store_from').value;
        stockParams['floor_id'] = document.getElementById('cbo_floor_name_from').value;
        stockParams['room_id'] = document.getElementById('cbo_room_no_from').value;
        stockParams['room_rack_id'] = document.getElementById('cbo_rack_no_from').value;
        stockParams['room_self_id'] = document.getElementById('cbo_shelf_no_from').value;
        stockParams['room_bin_id'] = document.getElementById('cbo_bin_no_from').value;
        console.log('Calculating stock with params:', stockParams);
        if (!stockParams.product_id) return;

        const url = '{{ URL::to("order/calculate-stock") }}';

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(stockParams)
            })
            .then(response => {
                console.log('Raw response:', response);
                return response.json();
            })
            .then(data => {
                console.log('Current stock:', data);
                document.getElementById('txt_current_stock').value = data.current_stock;
            })
            .catch(error => console.error('Error:', error));
    }

    async function handle_location_from_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'location_id': document.getElementById('cbo_location_from').value,
                'onchange': 'handle_store_from_change()',
                'field_id': 'cbo_store_from',
                'field_name': 'cbo_store_from'
            }), 'store_under_location', 'store_div_from');

            handleDropdownChange(document.getElementById('cbo_location_from').value, 'location_id');

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    async function handle_store_from_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'store_id': document.getElementById('cbo_store_from').value,
                'onchange': 'handle_floor_from_change()',
                'field_id': 'cbo_floor_name_from',
                'field_name': 'cbo_floor_name_from'
            }), 'floor_under_store', 'floor_div_from');

            handleDropdownChange(document.getElementById('cbo_store_from').value, 'store_id');

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    async function handle_floor_from_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'floor_id': document.getElementById('cbo_floor_name_from').value,
                'onchange': 'handle_room_from_change()',
                'field_id': 'cbo_room_no_from',
                'field_name': 'cbo_room_no_from'
            }), 'room_under_floor', 'room_div_from');

            handleDropdownChange(document.getElementById('cbo_floor_name_from').value, 'floor_id');

        } catch (error) {
            console.error('Error loading room dropdown:', error);
        }
    }

    async function handle_room_from_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'room_id': document.getElementById('cbo_room_no_from').value,
                'onchange': 'handle_rack_from_change()',
                'field_id': 'cbo_rack_no_from',
                'field_name': 'cbo_rack_no_from'
            }), 'rack_under_room', 'rack_div_from');

            handleDropdownChange(document.getElementById('cbo_room_no_from').value, 'room_id');

        } catch (error) {
            console.error('Error loading rack dropdown:', error);
        }
    }

    async function handle_rack_from_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'rack_id': document.getElementById('cbo_rack_no_from').value,
                'onchange': 'handle_shelf_from_change()',
                'field_id': 'cbo_shelf_no_from',
                'field_name': 'cbo_shelf_no_from'
            }), 'shelf_under_rack', 'shelf_div_from');

            handleDropdownChange(document.getElementById('cbo_rack_no_from').value, 'room_rack_id');

        } catch (error) {
            console.error('Error loading shelf dropdown:', error);
        }
    }

    async function handle_shelf_from_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'shelf_id': document.getElementById('cbo_shelf_no_from').value,
                'onchange': 'handle_bin_from_change()',
                'field_id': 'cbo_bin_no_from',
                'field_name': 'cbo_bin_no_from'
            }), 'bin_under_shelf', 'bin_div_from');

            handleDropdownChange(document.getElementById('cbo_shelf_no_from').value, 'room_self_id');

        } catch (error) {
            console.error('Error loading bin dropdown:', error);
        }
    }

    async function handle_bin_from_change() {
        try {
            handleDropdownChange(document.getElementById('cbo_bin_no_from').value, 'room_bin_id');
        } catch (error) {
            console.error('Error loading bin dropdown:', error);
        }
    }

    async function handle_location_to_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'location_id': document.getElementById('cbo_location_to').value,
                'onchange': 'handle_store_to_change()',
                'field_id': 'cbo_store_to',
                'field_name': 'cbo_store_to'
            }), 'store_under_location', 'store_div_to');

        } catch (error) {
            console.error('Error loading store dropdown (to):', error);
        }
    }

    async function handle_store_to_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'store_id': document.getElementById('cbo_store_to').value,
                'onchange': 'handle_floor_to_change()',
                'field_id': 'cbo_floor_name_to',
                'field_name': 'cbo_floor_name_to'
            }), 'floor_under_store', 'floor_div_to');

        } catch (error) {
            console.error('Error loading floor dropdown (to):', error);
        }
    }

    async function handle_floor_to_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'floor_id': document.getElementById('cbo_floor_name_to').value,
                'onchange': 'handle_room_to_change()',
                'field_id': 'cbo_room_no_to',
                'field_name': 'cbo_room_no_to'
            }), 'room_under_floor', 'room_div_to');

        } catch (error) {
            console.error('Error loading room dropdown (to):', error);
        }
    }

    async function handle_room_to_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'room_id': document.getElementById('cbo_room_no_to').value,
                'onchange': 'handle_rack_to_change()',
                'field_id': 'cbo_rack_no_to',
                'field_name': 'cbo_rack_no_to'
            }), 'rack_under_room', 'rack_div_to');

        } catch (error) {
            console.error('Error loading rack dropdown (to):', error);
        }
    }

    async function handle_rack_to_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'rack_id': document.getElementById('cbo_rack_no_to').value,
                'onchange': 'handle_shelf_to_change()',
                'field_id': 'cbo_shelf_no_to',
                'field_name': 'cbo_shelf_no_to'
            }), 'shelf_under_rack', 'shelf_div_to');

        } catch (error) {
            console.error('Error loading shelf dropdown (to):', error);
        }
    }

    async function handle_shelf_to_change() {
        try {
            await load_drop_down_v2('load_drop_down', JSON.stringify({
                'shelf_id': document.getElementById('cbo_shelf_no_to').value,
                'field_id': 'cbo_bin_no_to',
                'field_name': 'cbo_bin_no_to'
            }), 'bin_under_shelf', 'bin_div_to');

        } catch (error) {
            console.error('Error loading bin dropdown (to):', error);
        }
    }
</script>
@endsection