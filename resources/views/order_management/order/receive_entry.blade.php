<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Receive Entry';
?>
@extends('layouts.app')
@section('content_header')
<div class="row">
    <div class="col-sm-12">
        <center><h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Receive Entry'}}</strong></h1></center>
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
                                    <label for="txt_sys_no" class="col-sm-3 col-form-label fw-bold text-start must_entry_caption">Receive Id</label>
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
                                            <label for="txt_work_order_date" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Work Order Date</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="date" id="txt_work_order_date" class="form-control flatpickr" name="txt_work_order_date" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                        <div class="row">
                                            <label for="cbo_supplier" class="col-sm-6 col-form-label must_entry_caption">Supplier</label>
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
                                                <th class="form-group" width="3%">Sl</th>
                                                <th class="form-group" width="10%">Item Name</th>
                                                <th class="form-group" width="10%">Item Code</th>
                                                <th class="form-group" width="10%">Item Category</th>
                                                <th class="form-group" width="10%">UOM</th>
                                                <th class="form-group" width="10%">Required QTY</th>
                                                <th class="form-group" width="10%">Work Order Qty</th>
                                                <th class="form-group" width="10%">Previous Rate</th>
                                                <th class="form-group" width="10%">Cur. Rate</th>
                                                <th class="form-group" width="10%">Item Total Amount</th>
                                                <th class="form-group">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr id="tr_1">
                                                <td class="form-group" id="sl_1">1</td>
                                                <td class="form-group">
                                                    <input type="text" name="txt_item_name_1" id="txt_item_name_1" class="form-control" value="" ondblclick="fn_item_popup(1)">
                                                    <input type="hidden" name="hidden_product_id_1" id="hidden_product_id_1" class="form-control" value="">
                                                    <input type="hidden" name="hidden_dtls_id_1" id="hidden_dtls_id_1" class="form-control" value="">
                                                </td>
                                                <td class="form-group"><input type="text" name="txt_item_code_1" id="txt_item_code_1" class="form-control" value=""></td>
                                                <td class="form-group">
                                                    <select name="cbo_item_category_1" id="cbo_item_category_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach(get_item_category() as $id => $name)
                                                            <option value="{{$id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group">
                                                    <select name="cbo_uom_1" id="cbo_uom_1" class="form-control">
                                                        <option value="0">SELECT</option>
                                                        @foreach(get_uom() as $id => $name)
                                                            <option value="{{$id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="form-group"><input type="text" name="txt_required_qty_1" id="txt_required_qty_1" class="form-control" value=""></td>
                                                <td class="form-group"><input type="text" name="txt_work_order_qty_1" id="txt_work_order_qty_1" onkeyup="calculate_amount(1)" class="form-control" value=""></td>
                                                <td class="form-group"><input type="text" name="txt_previous_rate_1" id="txt_previous_rate_1" class="form-control" value=""></td>
                                                <td class="form-group"><input type="text" name="txt_cur_rate_1" id="txt_cur_rate_1" onkeyup="calculate_amount(1)" class="form-control" value=""></td>
                                                <td class="form-group"><input type="text" name="txt_item_total_amount_1" id="txt_item_total_amount_1" class="form-control" value=""></td>
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

</script>
@endsection