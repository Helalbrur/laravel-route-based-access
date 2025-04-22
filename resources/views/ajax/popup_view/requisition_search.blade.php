@extends('layouts.popup')

@section('content')
<?php
$param = json_decode($param, true);
$company_id         = $param['company_id'] ?? '';
$store_id           = $param['store_id'] ?? '';
$department_id      = $param['department_id'] ?? '';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Requisition Search</h5>
                <div class="card-text">
                    <input type="hidden" id="popup_value" name="popup_value" value="" />
                    <table id="list_view" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="15%">Company Name</th>
                                <th width="15%">Requisition No</th>
                                <th width="15%">Store</th>
                                <th width="15%">Department</th>
                                <th width="25%">Requisition Date</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="cbo_company_name" id="cbo_company_name" class="form-control form-control-sm">
                                        <option value="0">SELECT</option>
                                        <?php $lib_company = App\Models\Company::pluck('company_name', 'id'); ?>
                                        @foreach($lib_company as $id => $company_name)
                                        <option value="{{ $id }}" {{ $id == $company_id ? 'selected' : '' }}>{{ $company_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="txt_requisition_no" name="txt_requisition_no" placeholder="Requisition No">
                                </td>
                                <td>
                                    <select name="cbo_store" id="cbo_store" class="form-control form-control-sm">
                                        <option value="0">SELECT</option>
                                        <?php $stores = App\Models\LibStoreLocation::pluck('store_name', 'id'); ?>
                                        @foreach($stores as $id => $store_name)
                                        <option value="{{ $id }}" {{ $id == $store_id ? 'selected' : '' }}>{{ $store_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="cbo_department" id="cbo_department" class="form-control form-control-sm">
                                        <option value="0">SELECT</option>
                                        <?php $departments = App\Models\LibDepartment::pluck('department_name', 'id'); ?>
                                        @foreach($departments as $id => $department_name)
                                        <option value="{{ $id }}" {{ $id == $department_id ? 'selected' : '' }}>{{ $department_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <input type="text" class="form-control form-control-sm flatpickr mr-2" id="txt_from_date" name="txt_from_date" value="{{ date('Y-m-1') }}" placeholder="From Date">
                                        <input type="text" class="form-control form-control-sm flatpickr" id="txt_to_date" name="txt_to_date" value="{{ date('Y-m-t') }}" placeholder="To Date">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-info"
                                        onclick="show_list_view(
                                            JSON.stringify({
                                                company_id: document.getElementById('cbo_company_name').value,
                                                requisition_no: document.getElementById('txt_requisition_no').value,
                                                store_id: document.getElementById('cbo_store').value,
                                                department_id: document.getElementById('cbo_department').value,
                                                from_date: document.getElementById('txt_from_date').value,
                                                to_date: document.getElementById('txt_to_date').value
                                            }),
                                            'order/requisition_search_list_view',
                                            'search_div',
                                            '',
                                            'setFilterGrid(\'tbl_po_list\', -1)'
                                        )">
                                        Show
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="search_div" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function js_set_value(param) {
        $('#popup_value').val(param);
        console.log(param);
        parent.emailwindow.hide();
    }
</script>
@endsection