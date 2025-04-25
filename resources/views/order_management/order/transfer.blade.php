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
        <form name="requisition_1" id="requisition_1" autocomplete="off">

            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card pt-4 px-4" style="background-color: rgb(241, 241, 241);">

                            <div class="row justify-content-center">
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="txt_sys_no" class="col-sm-4 col-form-label fw-bold text-start must_entry_caption">Transfer No</label>
                                    <div class="col-sm-6 d-flex align-items-center">
                                        <input id="txt_sys_no" name="txt_sys_no" placeholder="Browse" ondblclick="fnc_sys_no_popup()" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_company_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Company</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <select style="width: 100%" name="cbo_company_name" id="cbo_company_name" onchange="handleCompanyChange()" class="form-control">
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
                                        <label for="txt_sys_no" class="col-sm-6 col-form-label fw-bold text-start">Transfer No</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input id="txt_sys_no" name="txt_sys_no" placeholder="Browse" ondblclick="fnc_sys_no_popup()" class="form-control">
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
                                <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_location_name" class="col-sm-6 col-form-label fw-bold text-start">Location</label>
                                        <div class="col-sm-6 d-flex align-items-center" id="location_div">
                                            <select style="width: 100%" name="cbo_location_name" id="cbo_location_name" class="form-control">
                                                <option value="0">SELECT</option>
                                                <?php
                                                $lib_location = App\Models\LibLocation::pluck('location_name', 'id');
                                                ?>
                                                @foreach($lib_location as $id => $location_name)
                                                <option value="{{ $id }}">{{ $location_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_store_dept" class="col-sm-6 col-form-label">Store/Dept.</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <?php $store_dep_arr = [1 => 'Store', 2 => 'Department']; ?>
                                            <select style="width: 100%" name="cbo_store_dept" id="cbo_store_dept" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach($store_dep_arr as $id => $name)
                                                <option value="{{$id}}">{{$name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_store" class="col-sm-6 col-form-label">Store</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <?php $stores = App\Models\LibStoreLocation::get(); ?>
                                            <select style="width: 100%" name="cbo_store" id="cbo_store" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach($stores as $store)
                                                <option value="{{$store->id}}">{{$store->store_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_department" class="col-sm-6 col-form-label">Department</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <?php $departments = App\Models\LibDepartment::get(); ?>
                                            <select style="width: 100%" name="cbo_department" id="cbo_department" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->department_name}}</option>
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

            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="row">

                            {{-- Transfer From Card --}}
                            <div class="col-md-6">
                                <div class="card h-100" style="background-color: rgb(241, 241, 241);">
                                    <div class="card-header fw-bold" style="background-color: rgb(226, 226, 226);">Transfer From</div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="cbo_location_from" class="col-sm-4 col-form-label fw-bold text-start">Location</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_location_from" id="cbo_location_from" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibLocation::pluck('location_name', 'id') as $id => $location_name)
                                                    <option value="{{ $id }}">{{ $location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_store_from" class="col-sm-4 col-form-label">Store</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_store_from" id="cbo_store_from" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibStoreLocation::get() as $store)
                                                    <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_floor_name_from" class="col-sm-4 col-form-label">Floor</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_floor_name_from" id="cbo_floor_name_from" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibFloor::get() as $floor)
                                                    <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_room_no_from" class="col-sm-4 col-form-label">Room</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_room_no_from" id="cbo_room_no_from" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('room_details')->get() as $room)
                                                    <option value="{{ $room->id }}">{{ $room->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_rack_no_from" class="col-sm-4 col-form-label">Rack</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_rack_no_from" id="cbo_rack_no_from" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('rack_details')->get() as $rack)
                                                    <option value="{{ $rack->id }}">{{ $rack->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_shelf_no_from" class="col-sm-4 col-form-label">Shelf</label>
                                            <div class="col-sm-8 d-flex align-items-center">
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
                                            <div class="col-sm-8 d-flex align-items-center">
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
                            <div class="col-md-6">
                                <div class="card h-100" style="background-color: rgb(241, 241, 241);">
                                    <div class="card-header fw-bold" style="background-color: rgb(226, 226, 226);">Transfer To</div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="cbo_location_to" class="col-sm-4 col-form-label fw-bold text-start">Location</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_location_to" id="cbo_location_to" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibLocation::pluck('location_name', 'id') as $id => $location_name)
                                                    <option value="{{ $id }}">{{ $location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_store_to" class="col-sm-4 col-form-label">Store</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_store_to" id="cbo_store_to" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibStoreLocation::get() as $store)
                                                    <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_floor_name_to" class="col-sm-4 col-form-label">Floor</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_floor_name_to" id="cbo_floor_name_to" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(App\Models\LibFloor::get() as $floor)
                                                    <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_room_no_to" class="col-sm-4 col-form-label">Room</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_room_no_to" id="cbo_room_no_to" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('room_details')->get() as $room)
                                                    <option value="{{ $room->id }}">{{ $room->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_rack_no_to" class="col-sm-4 col-form-label">Rack</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_rack_no_to" id="cbo_rack_no_to" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('rack_details')->get() as $rack)
                                                    <option value="{{ $rack->id }}">{{ $rack->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_shelf_no_to" class="col-sm-4 col-form-label">Shelf</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select name="cbo_shelf_no_to" id="cbo_shelf_no_to" class="form-control w-100">
                                                    <option value="0">SELECT</option>
                                                    @foreach(\App\Models\LibFloorRoomRackMst::whereHas('shelf_details')->get() as $shelf)
                                                    <option value="{{ $shelf->id }}">{{ $shelf->floor_room_rack_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cbo_bin_no_to" class="col-sm-4 col-form-label">Bin</label>
                                            <div class="col-sm-8 d-flex align-items-center">
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

            <div class="row">
                <div class="mb-3 row d-flex justify-content-center mt-2">
                    <div class="col-sm-2">
                        <input type="hidden" name="update_id" id="update_id">
                    </div>
                    <div class="col-sm-6">
                        <?php echo load_submit_buttons($permission, "fnc_requisition", 0, 0, "reset_form('requisition_1','','',1)"); ?>
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
    var setup_data = load_all_setup(12); // Pass the entry_form dynamically

    function fnc_requisition(operation) {
        if (form_validation('cbo_company_name*cbo_location_name*cbo_store_dept*txt_transfer_date', 'Company Name*Location*Store/Department*Transfer Date') == false) {
            return;
        } else {
            var formData = get_form_data('txt_sys_no,update_id,cbo_company_name,cbo_location_name,cbo_store_dept,cbo_store,cbo_department,txt_transfer_date');
            var method = "POST";
            var param = "";
            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
                if (operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var rows = $("#dtls_list_view tbody tr");
            var row_num = rows.length;
            formData.append('row_num', row_num);
            formData.append('operation', operation);

            var flag = 0;
            for (var i = 1; i <= row_num; i++) {
                if (form_validation('txt_item_name_' + i + '*txt_requisition_qty_' + i, 'Item Name*Transfer Qty') == false) {
                    flag = i;
                    break;
                }
                formData.append(`hidden_product_id_${i}`, document.getElementById(`hidden_product_id_${i}`).value);
                formData.append(`txt_item_name_${i}`, document.getElementById(`txt_item_name_${i}`).value);
                formData.append(`hidden_dtls_id_${i}`, document.getElementById(`hidden_dtls_id_${i}`).value);
                formData.append(`txt_item_code_${i}`, document.getElementById(`txt_item_code_${i}`).value);
                formData.append(`cbo_item_category_${i}`, document.getElementById(`cbo_item_category_${i}`).value);
                formData.append(`cbo_uom_${i}`, document.getElementById(`cbo_uom_${i}`).value);
                formData.append(`txt_requisition_qty_${i}`, document.getElementById(`txt_requisition_qty_${i}`).value);
            }

            if (flag > 0) {
                alert('Please fill up item name and requisition qty for row ' + flag);
                return;
            }

            var url = `/order/requisition${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData, 'id', '', '', 'requisition_1');
        }
    }

    const load_php_data_to_form = async (update_id) => {
        alert(update_id);
        freeze_window(3);
        reset_form('requisition_1', '', '', 1);
        var columns = 'requisition_no*id*company_id*location_id*store_dept*store_id*department_id*requisition_date';
        var response = await populate_field_data('id', update_id, 'requisition_mst', columns, '{{csrf_token()}}', '');
        if (response.code === 18 && response.data) {
            var data = response.data;
            // console.table(data);
            // alert(data)
            document.getElementById('txt_sys_no').value = data.requisition_no;
            document.getElementById('update_id').value = data.id;
            document.getElementById('cbo_company_name').value = data.company_id;
            await handleCompanyChange(); // Await the company change
            $('#cbo_location_name').val(data.location_id);
            document.getElementById('cbo_store_dept').value = data.store_dept;
            document.getElementById('cbo_store').value = data.store_id;
            document.getElementById('cbo_department').value = data.department_id;
            document.getElementById('txt_transfer_date').value = data.requisition_date;
            document.getElementById('txt_sys_no').readOnly = true;
            set_button_status(1, permission, 'fnc_requisition', 1);
            load_details();
        } else {
            console.warn("Unexpected data format:", response);
        }
        release_freezing();
    }

    function add_row(insertIndex) {

        var rows = $("#dtls_list_view tbody tr");
        var row_num = rows.length;

        if (insertIndex < 0 || insertIndex >= row_num) {
            var newRow = $("#dtls_list_view tbody tr:last").clone(false);
        } else {
            var newRow = rows.eq(insertIndex).clone(false);
        }


        // Clean up Select2 artifacts from the clone
        newRow.find('select').each(function() {
            $(this).removeClass('select2-hidden-accessible');
            $(this).next('.select2-container').remove();
            $(this).removeAttr('data-select2-id');
        });

        // Update IDs and names
        newRow.find("input, select, button").each(function() {
            var oldId = $(this).attr('id');
            var oldName = $(this).attr('name');

            if (oldId) {
                var idParts = oldId.split("_");
                idParts.pop();
                var newId = idParts.join("_") + "_" + (insertIndex + 1);
                $(this).attr('id', newId);
            }

            if (oldName) {
                var nameParts = oldName.split("_");
                nameParts.pop();
                var newName = nameParts.join("_") + "_" + (insertIndex + 1);
                $(this).attr('name', newName);
            }

            if ($(this).is('input')) {
                $(this).val(''); // Reset input values
            } else if ($(this).is('select')) {
                $(this).val('0'); // Reset select values
            }
        });

        newRow.removeAttr('id').attr('id', 'tr_' + (insertIndex + 1));

        // Insert the new row
        var rows = $("#dtls_list_view tbody tr");
        if (insertIndex <= row_num - 1) {
            rows.eq(insertIndex).before(newRow);
        } else {
            rows.eq(row_num - 1).after(newRow);
        }

        // Initialize Select2 for the new selects
        newRow.find('select').select2({
            width: '100%',
            dropdownParent: newRow.closest('.modal').length ? newRow.closest('.modal') : document.body
        });

        assign_id(); // Renumber rows and update attributes
    }

    function remove_row(rowNo) {
        var row_num = $('#dtls_list_view tbody tr').length;
        if (row_num == 1) return;
        var rowToRemove = $("#tr_" + rowNo);
        rowToRemove.remove();
        assign_id();
    }

    const assign_id = () => {
        var i = 1;
        $("#dtls_list_view tbody").find('tr').each(function() {
            $(this).removeAttr('id').attr('id', 'tr_' + i);
            var tr_id = $(this).attr('id');

            $("#" + tr_id).find("input,select,button").each(function() {
                $(this).attr({
                    'id': function(_, id) {
                        if (!id) return;
                        var idParts = id.split("_");
                        idParts.pop();
                        return idParts.join("_") + "_" + i;
                    },
                    'name': function(_, name) {
                        if (!name) return;
                        var nameParts = name.split("_");
                        nameParts.pop();
                        return nameParts.join("_") + "_" + i;
                    }
                });
            });

            $("#" + tr_id).find("td").each(function() {
                var td_id = $(this).attr('id');
                if (td_id) {
                    var tdParts = td_id.split("_");
                    tdParts.pop();
                    $(this).attr('id', tdParts.join("_") + "_" + i);
                }
            });

            $('#sl_' + i).text(i);
            $('#txt_item_name_' + i).removeAttr("ondblclick").attr("ondblclick", "fn_item_popup(" + i + ")");
            $('#btn_add_row_' + i).removeAttr("onclick").attr("onclick", "add_row(" + i + ")");
            $('#btn_remove_row_' + i).removeAttr("onclick").attr("onclick", "remove_row(" + i + ")");
            i++;
        });
        initializeSelect2();
    }

    function fnc_sys_no_popup() {
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
                const popupField = this.contentDoc?.getElementById("popup_value");
                if (!popupField || popupField.value === '') {
                    return;
                }

                const data = JSON.parse(popupField.value);
                console.log(data);

                if (data) {
                    const {
                        id,
                        requisition_no,
                        company_id,
                        location_id,
                        store_dept,
                        store_id,
                        department_id,
                        requisition_date
                    } = data;
                    console.log(`location = ${location_id}`)
                    $('#update_id').val(id);
                    $('#txt_sys_no').val(requisition_no);
                    document.getElementById('cbo_company_name').value = company_id;
                    await handleCompanyChange();
                    $('#cbo_location_name').val(location_id).trigger('change');
                    $('#cbo_store_dept').val(store_dept).trigger('change');
                    $('#cbo_store').val(store_id).trigger('change');
                    $('#cbo_department').val(department_id).trigger('change');
                    $('#txt_transfer_date').val(requisition_date);
                    load_details();
                    set_button_status(1, permission, 'fnc_requisition', 1);
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
                'onchange': ''
            }), 'location_under_company', 'location_div');

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    function fn_item_popup(row_id) {

        var item_id = $('#hidden_product_id_' + row_id).val();
        var item_name = $('#txt_item_name_' + row_id).val();
        var item_code = $('#txt_item_code_' + row_id).val();
        var item_category = $('#txt_item_category_' + row_id).val();

        var param = JSON.stringify({
            'item_id': item_id,
            'item_name': item_name,
            'category_id': item_category,
            'item_code': item_code
        });
        console.log(param);

        var title = 'Item Search';
        var page_link = '/show_common_popup_view?page=requisition_item_search&param=' + param;
        emailwindow = dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1', '../');
        emailwindow.onclose = function() {

            try {
                var popup_value = this.contentDoc.getElementById("popup_value").value; //Access form field
                console.log(popup_value);
                if (popup_value == '') {
                    return;
                }
                var product_arr = JSON.parse(popup_value);

                var row_num = $('#dtls_list_view tbody tr').length;

                for (let index = 1; index <= row_num; index++) {
                    var product_id = $('#hidden_product_id_' + index).val() * 1;
                    if (product_id == 0 && row_id > 1) {
                        remove_row(index);
                        row_id--;
                    }
                }
                var row_num = $('#dtls_list_view tbody tr').length;
                for (let index = row_id + 1; index <= row_num; index++) {
                    var product_id = $('#hidden_product_id_' + index).val() * 1;
                    if (product_id == 0) {
                        remove_row(index);
                    }
                }
                //iterate product_arr using foreach and extrat data

                var cur_row_id = row_id;
                product_arr.forEach(data => {
                    console.log(data);
                    if (data) {
                        if (cur_row_id > row_id) {
                            add_row((cur_row_id * 1) - 1);
                        }

                        $('#hidden_product_id_' + cur_row_id).val(data.product_id).trigger('change');
                        $('#txt_item_name_' + cur_row_id).val(data.item_name);
                        $('#txt_item_code_' + cur_row_id).val(data.item_code);
                        $('#cbo_item_category_' + cur_row_id).val(data.category_id).trigger('change');
                        $('#cbo_uom_' + cur_row_id).val(data.uom_id).trigger('change');
                        cur_row_id++;
                    } else {
                        if (cur_row_id > row_id) {
                            add_row((cur_row_id * 1) - 1);
                        }
                        $('#hidden_product_id_' + cur_row_id).val(0).trigger('change');
                        $('#txt_item_name_' + cur_row_id).val('');
                        $('#txt_item_code_' + cur_row_id).val('');
                        $('#cbo_item_category_' + cur_row_id).val(0).trigger('change');
                        $('#cbo_uom_' + cur_row_id).val(0).trigger('change');
                    }
                });
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }

    async function load_details() {
        //fetch data from server as html and put in a div that id div_dtls_list_view
        await fetch(`/order/requisition_details/${$('#update_id').val()}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('div_dtls_list_view').innerHTML = html;
                initializeSelect2();
                // field_manager(12);
            })
            .catch(error => console.error('Error loading details:', error));

    }
</script>
@endsection