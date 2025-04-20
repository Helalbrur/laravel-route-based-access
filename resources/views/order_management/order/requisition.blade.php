<?php

use App\Models\LibFloorRoomRackMst;

$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Work Order';
?>
@extends('layouts.app')
@section('content_header')
<div class="row">
    <div class="col-sm-12">
        <center>
            <h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Requisition'}}</strong></h1>
        </center>
    </div>
</div>
@endsection()
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-text">
                    <div class="card pt-4 px-4" style="background-color: rgb(241, 241, 241);">
                        <form name="requisition_1" id="requisition_1" autocomplete="off">

                            <div class="row justify-content-center">
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="txt_sys_no" class="col-sm-4 col-form-label fw-bold text-start must_entry_caption">Requisition No</label>
                                    <div class="col-sm-6 d-flex align-items-center">
                                        <input id="txt_sys_no" name="txt_sys_no" placeholder="Browse" ondblclick="fnc_sys_no_popup()" class="form-control">
                                        <input type="hidden" name="update_id" id="update_id">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_company_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Company</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <select style="width: 100%" name="cbo_company_name" id="cbo_company_name" onchange="load_company_config()" class="form-control">
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
                                        <label for="cbo_location" class="col-sm-6 col-form-label">Location</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <?php $locations = App\Models\LibLocation::get(); ?>
                                            <select style="width: 100%" name="cbo_location" id="cbo_location" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach($locations as $location)
                                                <option value="{{$location->id}}">{{$location->location_name}}</option>
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
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_requisition_date" class="col-sm-6 col-form-label fw-bold text-start">Date</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="date" id="txt_requisition_date" class="form-control flatpickr" name="txt_requisition_date" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_item_category" class="col-sm-6 col-form-label">Item Category</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <?php $categories = App\Models\LibCategory::get(); ?>
                                            <select style="width: 100%" name="cbo_item_category" id="cbo_item_category" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_item_name" class="col-sm-6 col-form-label">Item Name</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" id="txt_item_name" name="txt_item_name" class="form-control" placeholder="Browse" onclick="open_item_popup()">
                                            <input type="hidden" name="txt_item_id" id="txt_item_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_item_code" class="col-sm-6 col-form-label">Item Code</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <?php $item_codes = App\Models\ProductDetailsMaster::pluck('item_code', 'id'); ?>
                                            <select style="width: 100%" name="cbo_item_code" id="cbo_item_code" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach($item_codes as $id => $item_code)
                                                <option value="{{$id}}">{{$item_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="cbo_uom" class="col-sm-6 col-form-label">Cons UOM</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <select name="cbo_uom" id="cbo_uom" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach(get_uom() as $id => $name)
                                                <option value="{{$id}}">{{$name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_stock_qty" class="col-sm-6 col-form-label">Stock Qty</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" id="txt_stock_qty" name="txt_stock_qty" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                    <div class="row">
                                        <label for="txt_requisition_qty" class="col-sm-6 col-form-label">Requisition Qty</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" id="txt_requisition_qty" name="txt_requisition_qty" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="div_dtls_list_view">
                                <table class="table table-bordered table-striped text-center" id="dtls_list_view">
                                    <thead>
                                        <tr>
                                            <th class="form-group" width="3%">Sl</th>
                                            <th class="form-group" width="8%">Item Name</th>
                                            <th class="form-group" width="8%">Item Code</th>
                                            <th class="form-group" width="7%">Item Category</th>
                                            <th class="form-group" width="7%">UOM</th>
                                            <th class="form-group" width="">Required QTY</th>
                                            <th class="form-group" width="">WO Qty</th>
                                            <th class="form-group" width="">Balance Qty</th>
                                            <th class="form-group" width="">Receive Qty</th>
                                            <th class="form-group" width="">Lot/Batch No.</th>
                                            <th class="form-group" width="">Expire Date</th>
                                            <th class="form-group" width="7%">Rack</th>
                                            <th class="form-group" width="7%">Self</th>
                                            <th class="form-group" width="7%">Bin</th>
                                            <th class="form-group">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr_1">
                                            <td class="form-group align-middle" id="sl_1">1</td>
                                            <td class="form-group">
                                                <input type="text" name="txt_item_name_1" id="txt_item_name_1" class="form-control">
                                                <input type="hidden" name="hidden_product_id_1" id="hidden_product_id_1" class="form-control">
                                                <input type="hidden" name="hidden_conversion_fac_1" id="hidden_conversion_fac_1" class="form-control">
                                                <input type="hidden" name="hidden_consuption_uom_1" id="hidden_consuption_uom_1" class="form-control">
                                                <input type="hidden" name="hidden_dtls_id_1" id="hidden_dtls_id_1" class="form-control">
                                            </td>
                                            <td class="form-group"><input type="text" name="txt_item_code_1" id="txt_item_code_1" class="form-control"></td>
                                            <td class="form-group">
                                                <select name="cbo_item_category_1" id="cbo_item_category_1" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach(get_item_category() as $id => $name)
                                                    <option value="{{$id}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="form-group">
                                                <select name="cbo_order_uom_1" id="cbo_order_uom_1" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach(get_uom() as $id => $name)
                                                    <option value="{{$id}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="form-group"><input type="text" name="txt_required_qty_1" id="txt_required_qty_1" class="form-control"></td>
                                            <td class="form-group">
                                                <input type="text" name="txt_work_order_qty_1" id="txt_work_order_qty_1" class="form-control">
                                                <input type="hidden" name="txt_work_order_rate_1" id="txt_work_order_rate_1" class="form-control">
                                                <input type="hidden" name="txt_work_order_amount_1" id="txt_work_order_amount_1" class="form-control">
                                            </td>
                                            <td class="form-group">
                                                <input type="text" name="txt_balance_qty_1" id="txt_balance_qty_1" class="form-control">
                                            </td>
                                            <td class="form-group">
                                                <input type="text" name="txt_receive_qty_1" id="txt_receive_qty_1" class="form-control">
                                            </td>
                                            <td class="form-group">
                                                <input type="text" name="txt_lot_batch_no_1" id="txt_lot_batch_no_1" class="form-control">
                                            </td>
                                            <td class="form-group">
                                                <input type="text" name="txt_expire_date_1" id="txt_expire_date_1" class="form-control flatpickr">
                                            </td>
                                            <td class="form-group">
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
                                            <td class="form-group">
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
                                            <td class="form-group">
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
                                            <td class="form-group" width="100">
                                                <button type="button" class="btn btn-success" name="btn_add_row_1" id="btn_add_row_1" onclick="add_row(1)"><i class="fa fa-plus"></i></button>
                                                <button type="button" class="btn btn-danger" name="btn_remove_row_1" id="btn_remove_row_1" onclick="remove_row(1)"><i class="fa fa-minus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="mb-3 row d-flex justify-content-center mt-2">
                                    <div class="col-sm-2">
                                        <input type="hidden" name="update_id" id="update_id">
                                    </div>
                                    <div class="col-sm-6">
                                        <?php echo load_submit_buttons($permission, "fnc_work_order", 0, 0, "reset_form('requisition_1','','',1)"); ?>
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
@endsection

@section('script')
<script>
    var permission = '{{$permission}}';

    function open_item_popup() {
        var param = JSON.stringify({
            'location_id': $("#cbo_location").val(),
            'company_id': $("#cbo_company_name").val()
        });
        console.log(param);
        var title = 'Item List View';
        var page_link = '/show_common_popup_view?page=/item_search&param=' + param;
        emailwindow = dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1', '../');

        emailwindow.onclose = function() {
            var item_id = this.contentDoc.getElementById('item_id').value;
            var item_description = this.contentDoc.getElementById('item_name').value;
            $("#txt_item_id").val(item_id);
            $("#txt_item_name").val(item_description);
            //fn_set_item(entry_form_id);
        }
    }

    function fnc_work_order(operation) {
        if (form_validation('txt_name', 'Name') == false) {
            return;
        } else {
            var formData = get_form_data('txt_name,txt_short_name,update_id');
            var method = "POST";
            var param = "";
            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
                if (operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/other_company${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData, 'id', 'show_other_company_list_view', 'list_view_div', 'requisition_1');
        }
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
            $('#btn_add_row_' + i).removeAttr("onclick").attr("onclick", "add_row(" + i + ")");
            $('#btn_remove_row_' + i).removeAttr("onclick").attr("onclick", "remove_row(" + i + ")");

            i++;
        });
        initializeSelect2();
    }

    function fnc_sys_no_popup() {
        if(form_validation('cbo_company_name','Company Name')==false)
        {
            return;
        }
        
        var param = JSON.stringify({
            'supplier_id': $("#cbo_supplier").val(),
            'company_id': $("#cbo_company_name").val()
        });
        console.log(param);
		var title = 'Work Order Search';
		var page_link='/show_common_popup_view?page=work_order_search&param='+param;
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1','../');
		emailwindow.onclose= async function()
		{
			
			try {
                var popup_value=this.contentDoc.getElementById("popup_value").value;	 //Access form field
                console.log(popup_value);
                if (popup_value == '') {
                    return;
                }
                var data = JSON.parse(popup_value);
                console.log(data);
                if (data) {
                    $('#update_id').val(data.id);
                    //txt_sys_no,update_id,cbo_company_name,cbo_location_name,cbo_supplier,cbo_pay_mode,txt_work_order_date,txt_delivery_date,cbo_source,txt_remarks
                    $('#txt_sys_no').val(data.wo_no);
                    document.getElementById('cbo_company_name').value = data.company_id;
                    await handleCompanyChange(); // Await the company change
                    $('#cbo_location_name').val(data.location_id).trigger('change');
                    $('#cbo_supplier').val(data.supplier_id).trigger('change');
                    $('#cbo_pay_mode').val(data.pay_mode).trigger('change');
                    $('#txt_work_order_date').val(data.wo_date);
                    $('#txt_delivery_date').val(data.delivery_date);
                    $('#cbo_source').val(data.source).trigger('change');
                    $('#txt_remarks').val(data.remarks);
                    load_details();
                    set_button_status(1, permission, 'fnc_work_order', 1);
                }
            } catch (error) {
                console.error('Error:', error);
                
            }
		}
    }


    const load_php_data_to_form = async (menuId) => {
        var columns = 'name*short_name*id';
        var fields = 'txt_name*txt_short_name*update_id';
        var others = '';
        var get_return_value = await populate_form_data('id', menuId, 'other_companies', columns, fields, '{{csrf_token()}}');
        if (get_return_value == 1) {
            set_button_status(1, permission, 'fnc_work_order', 1);
        }
    }

    async function load_company_config() {
        // var company = document.getElementById('cbo_company_name').value;
    }
</script>
@endsection
