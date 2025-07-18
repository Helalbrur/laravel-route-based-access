<?php
use App\Models\LibFloorRoomRackMst;
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Work Order';
?>
@extends('layouts.app')
@section('content_header')
<div class="row">
    <div class="col-sm-12">
        <center><h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Work Order'}}</strong></h1></center>
    </div>
</div>
@endsection()
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card p-4" style="background-color: rgb(241, 241, 241);">
                            <form name="workorder_1" id="workorder_1" autocomplete="off">
                                <div class="row d-flex align-items-center">
                                    <label for="txt_sys_no" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Issue No</label>
                                    <div class="col-sm-3 d-flex align-items-center">
                                        <input id="txt_sys_no" name="txt_sys_no" placeholder="Browse" ondblclick="fnc_sys_no_popup()" class="form-control">
                                        <input type="hidden" name="update_id" id="update_id">
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_company_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Company Name</label>
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
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_location_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Location</label>
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
                                            <label for="cbo_store_name" class="col-sm-6 col-form-label must_entry_caption">Store</label>
                                            <div class="col-sm-6 d-flex align-items-center" id="store_div">
                                                <?php $stores = App\Models\LibStoreLocation::get(); ?>
                                                <select style="width: 100%" name="cbo_store_name" id="cbo_store_name" class="form-control">
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
                                            <label for="txt_issue_date" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Issue Date</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="date" id="txt_issue_date" class="form-control flatpickr" name="txt_issue_date" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                   
                                   
                                    <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_issue_basis" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Issue Basis</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_issue_basis" id="cbo_issue_basis"  class="form-control" onchange="handleIssueBasisChange()">
                                                    <option value="0">SELECT</option>
                                                    @foreach(get_issue_basis() as $id => $name)
                                                        @if(!in_array($id, [3]))
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_requisition_no" class="col-sm-6 col-form-label">Requisition</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input id="txt_requisition_no" name="txt_requisition_no" placeholder="Browse" ondblclick="fnc_requisition_popup()" class="form-control">
                                                <input type="hidden" name="requisition_id" id="requisition_id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_remarks" class="col-sm-6 col-form-label fw-bold text-start">Remarks</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_remarks" class="form-control" name="txt_remarks" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               <div class="row" id="div_dtls_list_view">
                                    <table class="table table-bordered table-striped text-center" id="dtls_list_view">
                                        <thead>
                                            <tr>
                                                <th class="form-group" width="2%">Sl</th>
                                                <th class="form-group" width="6%">Item</th>
                                                <th class="form-group" width="6%">Item Category</th>
                                                <th class="form-group" width="6%">Lot/Batch No.</th>
                                                <th class="form-group" width="6%">UOM</th>
                                                <th class="form-group" width="5%">Avl. Stock Qty</th>
                                                <th class="form-group" width="5%">Issue Qty</th>
                                                <th class="form-group" width="5%">Weighted Rate</th>
                                                <th class="form-group" width="5%">Actual Rate</th>
                                                <th class="form-group" width="6%">Item Total Amount</th>
                                                <th class="form-group" width="5%">Expire Date</th>
                                                <th class="form-group" width="6%">Floor Name</th>
                                                <th class="form-group" width="6%">Room No</th>
                                                <th class="form-group" width="6%">Rack</th>
                                                <th class="form-group" width="6%">Self</th>
                                                <th class="form-group" width="6%">Bin</th>
                                                <th class="form-group">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr id="tr_1">
                                                <td class="form-group" id="sl_1">1</td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_item_name_1" id="txt_item_name_1" class="form-control" value="" placeholder="Browse" ondblclick="fn_item_popup(1)">
                                                    <input type="hidden" name="hidden_product_id_1" id="hidden_product_id_1" class="form-control" value="">
                                                    <input type="hidden" name="hidden_dtls_id_1" id="hidden_dtls_id_1" class="form-control" value="">
                                                    <input type="hidden" name="req_dtls_id_1" id="req_dtls_id_1" class="form-control" value="">
                                                </td>
                                                
                                                <td class="form-group">
                                                    <select name="cbo_item_category_1" id="cbo_item_category_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach(get_item_category() as $id => $name)
                                                            <option value="{{$id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_lot_batch_no_1" id="txt_lot_batch_no_1" class="form-control" value="">
                                                </td>
                                                <td class="form-group">
                                                    <select name="cbo_uom_1" id="cbo_uom_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach(get_uom() as $id => $name)
                                                            <option value="{{$id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_available_qty_1" id="txt_available_qty_1" class="form-control" value="">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_issue_qty_1" id="txt_issue_qty_1" onkeyup="calculate_amount(1)" class="form-control" value="">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_weighted_rate_1" id="txt_weighted_rate_1" class="form-control" value="">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_cur_rate_1" id="txt_cur_rate_1" onkeyup="calculate_amount(1)" class="form-control" value="">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_item_total_amount_1" id="txt_item_total_amount_1" class="form-control" value="">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_expire_date_1" id="txt_expire_date_1" class="form-control flatpickr" value="">
                                                </td>
                                                <td class="form-group" id="floor_div_1">
                                                    <?php 
                                                        $floors = App\Models\LibFloor::get();
                                                    ?>
                                                    <select name="cbo_floor_name_1" id="cbo_floor_name_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach($floors as $floor)
                                                            <option value="{{$floor->id}}">{{$floor->floor_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group" id="room_div_1">
                                                    <?php 
                                                        $rooms = LibFloorRoomRackMst::whereHas('room_details')->get(); 
                                                    ?>
                                                    <select name="cbo_room_no_1" id="cbo_room_no_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach($rooms as $room)
                                                            <option value="{{$room->id}}">{{$room->floor_room_rack_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group" id="rack_div_1">
                                                    <?php 
                                                        $racks = LibFloorRoomRackMst::whereHas('rack_details')->get(); 
                                                    ?>
                                                    <select name="cbo_rack_no_1" id="cbo_rack_no_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach($racks as $rack)
                                                            <option value="{{$rack->id}}">{{$rack->floor_room_rack_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group" id="shelf_div_1">
                                                    <?php 
                                                         $shelfs = LibFloorRoomRackMst::whereHas('shelf_details')->get(); 
                                                    ?>
                                                    <select name="cbo_shelf_no_1" id="cbo_shelf_no_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach($shelfs as $shelf)
                                                            <option value="{{$shelf->id}}">{{$shelf->floor_room_rack_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group" id="bin_div_1">
                                                    <?php 
                                                        $bins = LibFloorRoomRackMst::whereHas('bin_details')->get(); 
                                                    ?>
                                                    <select name="cbo_bin_no_1" id="cbo_bin_no_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach($bins as $bin)
                                                            <option value="{{$bin->id}}">{{$bin->floor_room_rack_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group">
                                                    <button type="button" class="btn btn-success" name="btn_add_row_1"  id="btn_add_row_1" onclick="add_row(1)"><i class="fa fa-plus"></i></button> 
                                                    <button type="button" class="btn btn-danger" name="btn_remove_row_1" id="btn_remove_row_1" onclick="remove_row(1)"><i class="fa fa-minus"></i></button>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="mb-3 row d-flex justify-content-center mt-2">
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo load_submit_buttons($permission, "fnc_issue_dtls", 0, 0, "reset_form('workorder_1','','',1)"); ?>
                                        </div>
                                       
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var permission = '{{$permission}}';
    var setup_data = load_all_setup(15); // Pass the entry_form dynamically
    var mandatoryField = setup_data.mandatoryField;
    var mandatoryMessage = setup_data.mandatoryMessage;
    function fnc_issue_dtls(operation) {
        if (form_validation('cbo_company_name*cbo_location_name*cbo_store_name*txt_issue_date*cbo_issue_basis', 'Company Name*Location*Store Name*Date*Issue Basis') == false) {
            return;
        } else {

            // Check if mandatoryField is not empty
            if (mandatoryField)
            {
                // Call the form_validation function passing mandatoryField and mandatoryMessage
                if (form_validation(mandatoryField, mandatoryMessage) == false)
                {
                    return;
                }
            }
            
            var formData = get_form_data('txt_sys_no,update_id,cbo_company_name,cbo_location_name,cbo_store_name,txt_issue_date,cbo_issue_basis,txt_requisition_no,requisition_id,txt_remarks');
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
            for (var i = 1; i <=row_num; i++) {
                if(form_validation('txt_item_name_'+i+'*txt_issue_qty_'+i+'*txt_cur_rate_'+i,'Item Name*Issue Qty*Cur. Rate')==false)
                {
                    flag = i;
                    break;
                }
                formData.append(`hidden_product_id_${i}`, document.getElementById(`hidden_product_id_${i}`).value);
                formData.append(`txt_item_name_${i}`, document.getElementById(`txt_item_name_${i}`).value);
                formData.append(`hidden_dtls_id_${i}`, document.getElementById(`hidden_dtls_id_${i}`).value);
                formData.append(`req_dtls_id_${i}`, document.getElementById(`req_dtls_id_${i}`).value);
                formData.append(`cbo_item_category_${i}`, document.getElementById(`cbo_item_category_${i}`).value);
                formData.append(`txt_lot_batch_no_${i}`, document.getElementById(`txt_lot_batch_no_${i}`).value);
                formData.append(`cbo_uom_${i}`, document.getElementById(`cbo_uom_${i}`).value);
                formData.append(`txt_available_qty_${i}`, document.getElementById(`txt_available_qty_${i}`).value);
                formData.append(`txt_issue_qty_${i}`, document.getElementById(`txt_issue_qty_${i}`).value);
                formData.append(`txt_weighted_rate_${i}`, document.getElementById(`txt_weighted_rate_${i}`).value);
                formData.append(`txt_cur_rate_${i}`, document.getElementById(`txt_cur_rate_${i}`).value);
                formData.append(`txt_item_total_amount_${i}`, document.getElementById(`txt_item_total_amount_${i}`).value);
                formData.append(`txt_expire_date_${i}`, document.getElementById(`txt_expire_date_${i}`).value);
                formData.append(`cbo_floor_name_${i}`, document.getElementById(`cbo_floor_name_${i}`).value);
                formData.append(`cbo_room_no_${i}`, document.getElementById(`cbo_room_no_${i}`).value);
                formData.append(`cbo_rack_no_${i}`, document.getElementById(`cbo_rack_no_${i}`).value);
                formData.append(`cbo_shelf_no_${i}`, document.getElementById(`cbo_shelf_no_${i}`).value);
                formData.append(`cbo_bin_no_${i}`, document.getElementById(`cbo_bin_no_${i}`).value);
            }

            if(flag > 0)
            {
                alert('Please fill up item name, Issue qty and cur. rate for row '+flag);
                return;
            }

            var url = `/order/issue${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData, 'id', '', '', 'workorder_1');
        }
    }

    const load_php_data_to_form = async (update_id) => {
       
        freeze_window(3);
        reset_form('workorder_1', '', '', 1);
        var columns = 'sys_number*id*company_id*location_id*store_id*date*issue_basis*requisition_no*requisition_id*remarks';
        var response = await populate_field_data('id', update_id, 'inv_issue_master', columns, '{{csrf_token()}}', '');
        if (response.code === 18 && response.data) {
            var data = response.data;
            $('#update_id').val(data.id);
            $('#txt_sys_no').val(data.sys_number);
            document.getElementById('cbo_company_name').value = data.company_id;
            await handleCompanyChange(); // Await the company change
            $('#cbo_location_name').val(data.location_id);
            await handleLocationChange();
            $('#cbo_store_name').val(data.store_id).trigger('change');
            $('#cbo_issue_basis').val(data.issue_basis).trigger('change');
            $('#txt_issue_date').val(data.date);
            $('#txt_requisition_no').val(data.requisition_no);
            $('#requisition_id').val(data.requisition_id);
            $('#txt_remarks').val(data.remarks);
            load_details();
            set_button_status(1, permission, 'fnc_issue_dtls', 1);
        } else {
            console.warn("Unexpected data format:", response);
        }
        release_freezing();
    }

    async function handleCompanyChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'company_id':document.getElementById('cbo_company_name').value,'onchange':''}), 'location_under_company', 'location_div');

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }


    function add_row(insertIndex) {

        var rows = $("#dtls_list_view tbody tr");
        var row_num = rows.length;
        
        if (insertIndex < 0 || insertIndex >= row_num) {
            var newRow = $("#dtls_list_view tbody tr:last").clone(false);
        }
        else
        {
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

        newRow.find("td").each(function() {
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

        // Re-initialize flatpickr for the newly cloned date picker
        newRow.find('.flatpickr').flatpickr();

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
            $('#txt_cur_rate_' + i).removeAttr("onkeyup").attr("onkeyup","calculate_amount("+i+")");
            $('#txt_issue_qty_' + i).removeAttr("onkeyup").attr("onkeyup","calculate_amount("+i+")");
            $('#txt_item_name_' + i).removeAttr("ondblclick").attr("ondblclick","fn_item_popup("+i+")");
            $('#btn_add_row_' + i).removeAttr("onclick").attr("onclick", "add_row(" + i + ")");
            $('#btn_remove_row_' + i).removeAttr("onclick").attr("onclick", "remove_row(" + i + ")");
            i++;
        });
        initializeSelect2();
    }


    function calculate_amount(row_id) {
        var rate = $('#txt_cur_rate_' + row_id).val() * 1;
        var available_qty = $('#txt_available_qty_' + row_id).val() * 1;
        var order_qty = $('#txt_issue_qty_' + row_id).val() * 1;
        if (order_qty > available_qty) {
            alert('Issue quantity cannot be greater than available quantity');
            $('#txt_issue_qty_' + row_id).val(available_qty);
            order_qty = available_qty;
        }
        var amount = (rate * order_qty * 1000000) / 1000000;
        $("#txt_item_total_amount_"+row_id).val(amount);
    }

    async function fnc_sys_no_popup() {
        if(form_validation('cbo_company_name','Company Name')==false)
        {
            return;
        }
        
        var param = JSON.stringify({
            'company_id': $("#cbo_company_name").val()
        });
        //console.log(param);
		var title = 'Issue Search';
		var page_link='/show_common_popup_view?page=issue_search&param='+param;
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1','../');
		emailwindow.onclose=async function()
		{
			
			try {
                var popup_value=this.contentDoc.getElementById("popup_value").value;	 //Access form field
                console.log(popup_value);
                if (popup_value == '') {
                    return;
                }
                var data = JSON.parse(popup_value);
                console.log(data);
               
                $('#update_id').val(data.id);
                $('#txt_sys_no').val(data.sys_number);
                $('#cbo_company_name').val(data.company_id);
                console.log('company_id=',data.company_id);
                await handleCompanyChange();
                console.log('location_id=',data.location_id);
                $('#cbo_location_name').val(data.location_id);
                await handleLocationChange();
                $('#cbo_store_name').val(data.store_id);
                await multirowStoreChange();
                $('#txt_issue_date').val(data.date);
                $('#cbo_issue_basis').val(data.issue_basis).trigger('change');
                $('#txt_requisition_no').val(data.requisition_no);
                $('#requisition_id').val(data.requisition_id);
                $('#txt_remarks').val(data.remarks);
                await load_issue_details();
                setup_date();
                set_button_status(1, permission, 'fnc_issue_dtls', 1);
                
            } catch (error) {
                console.error('Error:', error);
            }
		}
    }

    async function load_issue_details() {
        //fetch data from server as html and put in a div that id div_dtls_list_view
        await fetch(`/order/isssue_details/${$('#update_id').val()}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('div_dtls_list_view').innerHTML = html;
                initializeSelect2();
                field_manager(15);
                var row_num = $('#dtls_list_view tbody tr').length;
                for (let index = 1; index <= row_num; index++) {
                    calculate_amount(index);
                }
            })
            .catch(error => console.error('Error loading details:', error));
            
    }


    function setup_date() {
        
        var row_num = $('#dtls_list_view tbody tr').length;
        console.log('Test'+row_num);  
        for (let index = 1; index <= row_num; index++) {
            var input = $('#txt_expire_date_' + index);
            if (input.length && !input[0]._flatpickr) { // Check element exists and flatpickr is not already initialized
                flatpickr(input[0], {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    altInput: true,
                    altFormat: "F j, Y",
                    defaultDate: new Date()
                });
            }
        }
    }

    function fn_item_popup(row_id) {
        // if(form_validation('cbo_supplier','Supplier')==false)
        // {
        //     return;
        // }
        var item_id = $('#hidden_product_id_' + row_id).val();
        var item_name = $('#txt_item_name_' + row_id).val();
        var item_code = $('#txt_item_code_' + row_id).val();
        //var item_category = $('#txt_item_category_' + row_id).val();

       
        var param = JSON.stringify({
            //'supplier_id': supplier_id,
            'item_id': item_id,
            'item_name': item_name,
            //'category_id': item_category,
            'item_code': item_code
           
        });
        console.log(param);
		var title = 'Item Search';
		var page_link='/show_common_popup_view?page=issue_item_search&param='+param;
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1','../');
		emailwindow.onclose=function()
		{
			
			try {
                var popup_value=this.contentDoc.getElementById("popup_value").value;	 //Access form field
                console.log(popup_value);
                if (popup_value == '') {
                    return;
                }
                var product_arr = JSON.parse(popup_value);

                var row_num = $('#dtls_list_view tbody tr').length;

                for (let index = 1; index <= row_num; index++) {
                   var product_id = $('#hidden_product_id_' + index).val() * 1;
                   if(product_id == 0 && row_id > 1) {
                       remove_row(index);
                       row_id--;
                   }
                }
                var row_num = $('#dtls_list_view tbody tr').length;
                for (let index = row_id + 1; index <= row_num; index++) {
                    var product_id = $('#hidden_product_id_' + index).val() * 1;
                    if(product_id == 0 ) {
                        remove_row(index);
                    }
                }
                //iterate product_arr using foreach and extrat data

                var cur_row_id = row_id;
                product_arr.forEach(data => {
                    console.log(data);
                    if (data) {
                        if(cur_row_id> row_id) {
                            add_row((cur_row_id * 1) - 1);
                        }

                        $('#hidden_product_id_' + cur_row_id).val(data.product_id).trigger('change');
                        $('#txt_item_name_' + cur_row_id).val(data.item_name);
                        $('#txt_item_code_' + cur_row_id).val(data.item_code);
                        $('#cbo_item_category_' + cur_row_id).val(data.category_id).trigger('change');
                        $('#cbo_uom_' + cur_row_id).val(data.uom_id).trigger('change');
                        $('#txt_previous_rate_' + cur_row_id).val(data.current_rate);
                        cur_row_id++;
                    }
                    else
                    {
                        if(cur_row_id> row_id) {
                            add_row((cur_row_id * 1) - 1);
                        }
                        $('#hidden_product_id_' + cur_row_id).val(0).trigger('change');
                        $('#txt_item_name_' + cur_row_id).val('');
                        $('#txt_item_code_' + cur_row_id).val('');
                        $('#cbo_item_category_' + cur_row_id).val(0).trigger('change');
                        $('#cbo_uom_' + cur_row_id).val(0).trigger('change');
                        $('#txt_previous_rate_' + cur_row_id).val(0);
                    }
                });
            } catch (error) {
                console.error('Error:', error);
                
            }
		}
    }

    async function fnc_requisition_popup() {
        if (form_validation('cbo_company_name*cbo_issue_basis', 'Company Name*Issue Basis') == false) {
            return;
        }
        var param = JSON.stringify({
            'company_id': $("#cbo_company_name").val(),
            'location_id': $("#cbo_location_name").val(),
            'store_id': $("#cbo_store_name").val()
        });
        var title = 'Requisition Search';
        var page_link = '/show_common_popup_view?page=requisition_search&param=' + param;
        emailwindow = dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1', '../');
        emailwindow.onclose =async function () {
            try {
                var popup_value = this.contentDoc.getElementById("popup_value").value; //Access form field
                console.log(popup_value);
                if (popup_value == '') {
                    return;
                }
                var data = JSON.parse(popup_value);
                console.log(data);
                $('#txt_requisition_no').val(data.requisition_no);
                $('#requisition_id').val(data.id);
                await load_requisition_details();
                setup_date();
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }

    async function load_requisition_details() {
        //fetch data from server as html and put in a div that id div_dtls_list_view
        await fetch(`/order/req_details_from_issue/${$('#requisition_id').val()}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('div_dtls_list_view').innerHTML = html;
                initializeSelect2();
                field_manager(15);
                var row_num = $('#dtls_list_view tbody tr').length;
                for (let index = 1; index <= row_num; index++) {
                    calculate_amount(index);
                }
            })
            .catch(error => console.error('Error loading details:', error));
            
    }

   async function load_details() {
        //fetch data from server as html and put in a div that id div_dtls_list_view
        await fetch(`/order/isssue_details/${$('#update_id').val()}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('div_dtls_list_view').innerHTML = html;
                initializeSelect2();
                field_manager(15);
            })
            .catch(error => console.error('Error loading details:', error));
            
    }

    async function handleCompanyChange(row_id = '') {
        try {
            var container = "location_div";
            if(row_id) {
                container = "location_div_"+row_id;
            }
            await load_drop_down_v2('load_drop_down',JSON.stringify({'company_id':document.getElementById('cbo_company_name').value,'onchange':'handleLocationChange('+row_id+')','row_id':row_id}), 'location_under_company', container);
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    async function handleLocationChange(row_id = '') {
        try {
            var container = "store_div";
            if(row_id) {
                container = "store_div_"+row_id;
            }
            await load_drop_down_v2('load_drop_down',JSON.stringify({'location_id':document.getElementById('cbo_location_name').value,'onchange':'multirowStoreChange()','row_id':row_id}), 'store_under_location', container);

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    async function multirowStoreChange() {
        var row_num = $('#dtls_list_view tbody tr').length;
        for (let index = 1; index <= row_num; index++) {
           await handleStoreChange(index);
        }
    }

    async function handleStoreChange(row_id = '') {
        try {
            var container = "floor_div";
            if(row_id) {
                container = "floor_div_"+row_id;
            }
            await load_drop_down_v2('load_drop_down', JSON.stringify({'store_id':document.getElementById('cbo_store_name').value,'onchange':'handleFloorChange('+row_id+')','row_id':row_id}), 'floor_under_store', container);
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    async function handleFloorChange(row_id = '') {
        try {
            var name_extra = '';
            var container = "room_div";
            if(row_id) {
                container = "room_div_"+row_id;
                name_extra = "_"+row_id;
            }
            await load_drop_down_v2('load_drop_down', JSON.stringify({'floor_id':document.getElementById('cbo_floor_name'+name_extra).value,'onchange':'handleRoomChange('+row_id+')','row_id':row_id}), 'room_under_floor', container);
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    async function handleRoomChange(row_id = '') {
        try {
            var container = "rack_div";
            var name_extra = '';
            if(row_id) {
                container = "rack_div_"+row_id;
                name_extra = "_"+row_id;
            }
            await load_drop_down_v2('load_drop_down', JSON.stringify({'room_id':document.getElementById('cbo_room_no'+name_extra).value,'onchange':'handleRackChange('+row_id+')','row_id':row_id}), 'rack_under_room', container);
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    async function handleRackChange(row_id = '') {
        try {
            var name_extra = '';
            var container = "shelf_div";
            if(row_id) {
                container = "shelf_div_"+row_id;
                name_extra = "_"+row_id;
            }
            await load_drop_down_v2('load_drop_down', JSON.stringify({'rack_id':document.getElementById('cbo_rack_no'+name_extra).value,'onchange':'handleShelfChange('+row_id+')','row_id':row_id}), 'shelf_under_rack', container);
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }
    async function handleShelfChange(row_id = '') {
        try {
            var name_extra = '';
            var container = "bin_div";
            if(row_id) {
                container = "bin_div_"+row_id;
                name_extra = "_"+row_id;
            }
            await load_drop_down_v2('load_drop_down', JSON.stringify({'shelf_id':document.getElementById('cbo_shelf_no'+name_extra).value,'onchange':'','row_id':row_id}), 'bin_under_shelf', container);
        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    async function handleIssueBasisChange() {
        var issue_basis = document.getElementById('cbo_issue_basis').value * 1;
        if(issue_basis == 1) {
            document.getElementById('txt_requisition_no').value = '';
            document.getElementById('requisition_id').value = '';
            document.getElementById('txt_requisition_no').readOnly = true;
            document.getElementById('txt_requisition_no').disabled = true;
        } else {
            document.getElementById('txt_requisition_no').readOnly = false;
            document.getElementById('txt_requisition_no').disabled = false;
        }

        var row_num = $('#dtls_list_view tbody tr').length;
        for (let index = 1; index <= row_num; index++) {
            const itemInput = document.getElementById(`txt_item_name_${index}`);
            
            if (issue_basis == 1) {
                itemInput.readOnly = true;
                itemInput.disabled = false;
                itemInput.setAttribute('ondblclick',`fn_item_popup(${index})`);
                itemInput.placeholder = 'Browse';

            } else {
                itemInput.readOnly = true;
                itemInput.disabled = false;
                itemInput.removeAttribute('ondblclick');
                itemInput.placeholder = '';
            }
        }

    }
    field_manager(15);
</script>
@endsection