<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Work Order';
?>
@extends('layouts.app')
@section('content_header')
<div class="row">
    <div class="col-sm-12">
        <center><h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Requisition'}}</strong></h1></center>
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
                                            <?php $store_dep_arr=[1=>'Store', 2=>'Department']; ?>
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
                                            <?php //$departments = App\Models\LibDepartment::get(); ?>
                                            <select style="width: 100%" name="cbo_department" id="cbo_department" class="form-control">
                                                <option value="0">SELECT</option>
                                                {{-- @foreach($departments as $department)
                                                    <option value="{{$department->id}}">{{$department->department_name}}</option>
                                                @endforeach --}}
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

    function open_item_popup() 
    {
        var param = JSON.stringify({
            'location_id': $("#cbo_location").val(),
            'company_id': $("#cbo_company_name").val()
        });
        console.log(param);
        var title = 'Item List View';
        var page_link = '/show_common_popup_view?page=/item_search&param=' + param;
        emailwindow = dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=800px,height=370px,center=1,resize=1,scrolling=1', '../');

        emailwindow.onclose = function() 
        {
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