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

                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <div class="row">
                                            <label for="cbo_company_name" class="col-sm-6 col-form-label fw-bold text-start must_entry_caption">Company Name</label>
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
                                    <div class="col-md-3 form-group">
                                        <div class="row">
                                            <label for="txt_work_order_date" class="col-sm-6 col-form-label fw-bold text-start">Work Order Date</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="date" id="txt_work_order_date" class="form-control flatpickr" name="txt_work_order_date" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
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
                                    <div class="col-md-3 form-group">
                                        <div class="row">
                                            <label for="txt_delivery_date" class="col-sm-6 col-form-label fw-bold text-start">Delivery Date</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="date" id="txt_delivery_date" class="form-control flatpickr" name="txt_delivery_date" value="{{ date('Y-m-d') }}">
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

    async function load_company_config() {
        // var company = document.getElementById('cbo_company_name').value;
    }
</script>
@endsection