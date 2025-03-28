<?php
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
                                    <label for="txt_sys_no" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Work Order No</label>
                                    <div class="col-sm-3 d-flex align-items-center">
                                        <input id="txt_sys_no" name="txt_sys_no" placeholder="Browse" ondbclick="fnc_sys_no_popup()" class="form-control">
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
                                            <label for="cbo_location_name" class="col-sm-6 col-form-label fw-bold text-start">Location</label>
                                            <div class="col-sm-6 d-flex align-items-center" id="location_div">
                                                <select name="cbo_location_name" id="cbo_location_name" class="form-control">
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
                                            <label for="txt_work_order_date" class="col-sm-6 col-form-label fw-bold text-start">Work Order Date</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="date" id="txt_work_order_date" class="form-control flatpickr" name="txt_work_order_date" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_item_group_code" class="col-sm-6 col-form-label">Supplier</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <?php $suppliers = App\Models\LibSupplier::get(); ?>
                                                <select style="width: 100%" name="cbo_supplier" id="cbo_supplier" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="txt_delivery_date" class="col-sm-6 col-form-label fw-bold text-start">Delivery Date</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="date" id="txt_delivery_date" class="form-control flatpickr" name="txt_delivery_date" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_pay_mode" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Pay Mode</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_pay_mode" id="cbo_pay_mode"  class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach(get_pay_mode() as $id => $name)
                                                        @if(!in_array($id, [2,3,5]))  <!-- Exclude unwanted options -->
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_source" class="col-sm-6 col-form-label">Source</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select style="width: 100%" name="cbo_source" id="cbo_source" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach(get_source() as $id => $name)
                                                        <option value="{{$id}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
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
                                                <th width="3%">Sl</th>
                                                <th width="10%">Item Name</th>
                                                <th width="10%">Item Code</th>
                                                <th width="10%">Item Category</th>
                                                <th width="10%">UOM</th>
                                                <th width="10%">Required QTY</th>
                                                <th width="10%">Work Order Qty</th>
                                                <th width="10%">Previous Rate</th>
                                                <th width="10%">Cur. Rate</th>
                                                <th width="10%">Item Total Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr id="tr_1">
                                                <td id="sl_1">1</td>
                                                <td>
                                                    <input type="text" name="txt_item_name_1" id="txt_item_name_1" class="form-control" value="" ondbclick="fn_item_popup(1)">
                                                    <input type="hidden" name="txt_item_id_1" id="txt_item_id_1" class="form-control" value="">
                                                </td>
                                                <td><input type="text" name="txt_item_code_1" id="txt_item_code_1" class="form-control" value=""></td>
                                                <td>
                                                    <select name="cbo_item_category_1" id="cbo_item_category_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach(get_item_category() as $id => $name)
                                                            <option value="{{$id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="cbo_uom_1" id="cbo_uom_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach(get_uom() as $id => $name)
                                                            <option value="{{$id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" name="txt_required_qty_1" id="txt_required_qty_1" class="form-control" value=""></td>
                                                <td><input type="text" name="txt_work_order_qty_1" id="txt_work_order_qty_1" onkeyup="calculate_amount(1)" class="form-control" value=""></td>
                                                <td><input type="text" name="txt_previous_rate_1" id="txt_previous_rate_1" class="form-control" value=""></td>
                                                <td><input type="text" name="txt_cur_rate_1" id="txt_cur_rate_1" onkeyup="calculate_amount(1)" class="form-control" value=""></td>
                                                <td><input type="text" name="txt_item_total_amount_1" id="txt_item_total_amount_1" class="form-control" value=""></td>
                                                <td>
                                                    <button type="button" class="btn btn-success" name="btn_add_row_1"  id="btn_add_row_1" onclick="add_row(1)"><i class="fa fa-plus"></i></button> 
                                                    <button type="button" class="btn btn-danger" name="btn_remove_row_1" id="btn_remove_row_1" onclick="remove_row(1)"><i class="fa fa-minus"></i></button>
                                                </td>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="mb-3 row d-flex justify-content-center mt-2">
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo load_submit_buttons($permission, "fnc_work_order", 0, 0, "reset_form('workorder_1','','',1)"); ?>
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

            save_update_delete(operation, url, requestData, 'id', 'show_other_company_list_view', 'list_view_div', 'workorder_1');
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

    async function handleCompanyChange() {
        try {
            await load_drop_down_v2('load_drop_down',JSON.stringify({'company_id':document.getElementById('cbo_company_name').value,'onchange':''}), 'location_under_company', 'location_div');

        } catch (error) {
            console.error('Error loading dropdown:', error);
        }
    }

    

    function add_row(insertIndex) {
        var row_num = $('#dtls_list_view tbody tr').length;
        var newRow = $("#dtls_list_view tbody tr:last").clone();
        newRow.find("input,select,button").each(function() {
            $(this).attr({
                'id': function(_, id) {
                    var idParts = id.split("_");
                    idParts.pop();
                    return idParts.join("_") + "_" + (insertIndex + 1);
                },
                'name': function(_, name) {
                    
                    var nameParts = name.split("_");
                    nameParts.pop();
                    return nameParts.join("_") + "_"+(insertIndex + 1);
                },
                'value': function(_, value) {
                    return value;
                }
            });
        });

        newRow.removeAttr('id').attr('id', 'tr_' + (insertIndex + 1));

        // Insert the new row at the specified index
        var rows = $("#dtls_list_view tbody tr");
        if (insertIndex <= row_num - 1) {
            rows.eq(insertIndex).before(newRow);
        } else {
            rows.eq(row_num - 1).after(newRow);
        }
        assign_id();
    }

    function remove_row(rowNo) {
        var update_id = $("#update_id").val();
        if (update_id != "") {
            var index = rowNo - 1;

        } else {
            var index = rowNo;
        }
        if (rowNo == 1) {
            return;
        }
        $("#dtls_list_view tbody tr:eq(" + index + ")").remove();
        assign_id();
    }

    const assign_id = () => {
        var i = 1;
        $("#dtls_list_view tbody").find('tr').each(function() {
            $(this).removeAttr('id').attr('id', 'tr_' + i);

            var tr_id = $(this).attr('id');
            // console.log('tr => ' + tr_id);

            $("#" + tr_id).find("input,select,button").each(function() {
                $(this).attr({
                    'id': function(_, id) {
                        var id = id.split("_");
                        id.pop();
                        return id.join("_") + "_" + i;
                    },
                    'name': function(_, name) {
                        var nameParts = name.split("_");
                        nameParts.pop();
                        return nameParts.join("_") + "_"+i;
                    }
                });
            });
            $("#" + tr_id).find("td").each(function() {
                var td_id = $(this).attr('id');
                if (td_id) {
                    var td_id = td_id.split("_");
                    td_id = td_id[0] + "_" + i;
                    $(this).attr('id', td_id);
                }
            });

           
            $('#sl_' + i).text(i);
            $('#txt_cur_rate_' + i).removeAttr("onkeyup").attr("onkeyup", "calculate_amount(" + i + ");");
            $('#txt_work_order_qty_' + i).removeAttr("onkeyup").attr("onkeyup", "calculate_amount(" + i + ");");
            $('#txt_item_name_' + i).removeAttr("ondbclick").attr("ondbclick", "fn_item_popup(" + i + ");");
            $('#btn_add_row_' + i).removeAttr("onClick").attr("onClick", "add_row(" + i + ");");
            $('#btn_remove_row_' + i).removeAttr("onClick").attr("onClick", "remove_row(" + i + ");");
            i++;
        });
    }

    function calculate_amount(row_id) {
        var rate = $('#txt_cur_rate_' + row_id).val() * 1;
        var order_qty = $('#txt_work_order_qty_' + row_id).val() * 1;
        var amount = (rate * order_qty * 1000000) / 1000000;
        $("#txt_item_total_amount_"+row_id).val(amount);
    }

    function fnc_sys_no_popup() {
        
    }
</script>
@endsection