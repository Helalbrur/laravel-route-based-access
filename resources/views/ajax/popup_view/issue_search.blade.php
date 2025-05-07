@extends('layouts.popup')

@section('content')
<?php
$param = json_decode($param,true);
$company_id         = $param['company_id'] ?? '';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Issue Search</h5>
                <div class="card-text">
                    <input type="hidden" id="popup_value" name="popup_value" value="" />
                    <table id="list_view" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="20%">Company Name</th>
                                <th width="20%">System No</th>
                                <th width="35%">Issue Date</th>
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
                                    <input type="text" class="form-control form-control-sm" id="txt_issue_no" name="txt_issue_no" value="" placeholder="Issue No">
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <input type="text" class="form-control form-control-sm flatpickr mr-2" id="txt_from_date" name="txt_from_date" value="{{ date('Y-m-1') }}" placeholder="From Date" >
                                        <input type="text" class="form-control form-control-sm flatpickr" id="txt_to_date" name="txt_to_date" value="{{ date('Y-m-t') }}" placeholder="To Date">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-info" onClick="show_list_view( 
                                        JSON.stringify({
                                            company_id: document.getElementById('cbo_company_name').value,
                                            txt_issue_no: document.getElementById('txt_issue_no').value,
                                            'txt_from_date': document.getElementById('txt_from_date').value,
                                            'txt_to_date': document.getElementById('txt_to_date').value
                                        }), 'order/issue_search_list_view', 'search_div', '', 'setFilterGrid(\'tbl_po_list\',-1)')">
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