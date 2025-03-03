<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Other Company';
?>
@extends('layouts.app')
@section('content_header')
<div class="row">
    <div class="col-sm-12">
        <center><h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Other Company'}}</strong></h1></center>
    </div>
</div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card p-4" style="background-color: rgb(241, 241, 241);">
                            <form name="companyForm_1" id="companyForm_1" autocomplete="off">
                                <div class="row">
                                   
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_company_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_name" class="form-control" name="txt_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_company_short_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Company Short Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" id="txt_short_name" class="form-control" name="txt_short_name">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row d-flex justify-content-center mt-2">
                                        <div class="col-sm-2">
                                            <input type="hidden" name="update_id" id="update_id">
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo load_submit_buttons($permission, "fnc_company_name", 0, 0, "reset_form('companyForm_1','','',1)"); ?>
                                        </div>
                                       
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="card table-responsive table-info" id="list_view_div" style="background-color: rgb(241, 241, 241);">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="3%">Sl</th>
                                        
                                        <th width="50%">Company Name</th>
                                        <th >Short Name</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                    $sl = 1;
                                    $companies = App\Models\OtherCompany::get();

                                    ?>
                                    @foreach($companies as $company)
                                    <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$company->id}}')" style="cursor:pointer">
                                        <td>{{$sl++}}</td>
                                        <td>{{$company->name}}</td>
                                        <td>{{$company->short_name}}</td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

    function fnc_company_name(operation) {
        if (form_validation('txt_name*txt_short_name', 'Company Name*Company Short Name') == false) {
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

            save_update_delete(operation, url, requestData, 'id', 'show_other_company_list_view', 'list_view_div', 'companyForm_1');
        }
    }

    const load_php_data_to_form = async (menuId) => {
        var columns = 'name*short_name*id';
        var fields = 'txt_name*txt_short_name*update_id';
        var others = '';
        var get_return_value = await populate_form_data('id', menuId, 'other_companies', columns, fields, '{{csrf_token()}}');
        if (get_return_value == 1) {
            set_button_status(1, permission, 'fnc_company_name', 1);
        }
    }
    setFilterGrid("list_view", -1);
</script>
@endsection