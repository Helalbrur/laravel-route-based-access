<?php
$permission = getPagePermission(request('mid') ?? 0);
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Company Profile'}}</strong></h1>
        </div>
        <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
            </ol>
        </div> -->
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                
                <div class="card-text">
                    <form name="mainform_1" id="mainform_1" autocomplete="off">
                        
                        <div class="form-group row">
                            <label for="cbo_group_name"  class="col-sm-2 col-form-label must_entry_caption">Group Name</label>
                            <div class="col-sm-4">
                                <select name="cbo_group_name" id="cbo_group_name" class="form-control">
                                    <option value="0">SELECT</option>
                                    <?php
                                        $groups = App\Models\Group::pluck('group_name', 'id');
                                    ?>
                                    @foreach($groups as $id => $group_name)
                                        <option value="{{ $id }}">{{ $group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="txt_company_name" class="col-sm-2 col-form-label must_entry_caption">Company Name</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_company_name" class="form-control" name="txt_company_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txt_company_short_name" class="col-sm-2 col-form-label must_entry_caption">Company Short Name</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_company_short_name" class="form-control" name="txt_company_short_name">
                            </div>
                            <label for="txt_email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" id="txt_email" class="form-control" name="txt_email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txt_website_name" class="col-sm-2 col-form-label">Website</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_website_name" class="form-control" name="txt_website_name">
                            </div>
                            <label for="txt_contact_no" class="col-sm-2 col-form-label">Contact No</label>
                            <div class="col-sm-4">
                                <input type="email" id="txt_contact_no" class="form-control" name="txt_contact_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txt_company_address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-6">
                                <input type="text" id="txt_company_address" class="form-control" name="txt_company_address">
                            </div>
                            <label for="txt_logo" class="col-sm-2 col-form-label">Logo</label>
                            <div class="col-sm-2">
                                <input type="file" name="files[]" id="txt_file" multiple   class="form-control" >
                            </div>
                        </div>
                        <div class="from-group row">
                            <div class="col-sm-2">
                                <input type="hidden" name="update_id" id="update_id">
                            </div>
                            <div class="col-sm-5">
                                <?php
                                    echo load_submit_buttons( $permission, "fnc_company_name", 0,0 ,"reset_form('mainform_1','','',1)");
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <input type="button" class="btn btn-sm btn-info" value="Show Files" onclick="show_files('update_id','company_profile','','show_company_list_view','list_view_div');">
                            </div>
                            <div class="col-sm-3">
                                <img src="" width="150" height="150" id="displayImage" style="display: none;">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card table-responsive table-info"  id="list_view_div" style="background-color:#F5FFFA">
                    <table class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th width="3%">Sl</th>
                                <th width="12%">Group Name</th>
                                <th width="15%">Company Name</th>
                                <th width="10%">Short Name</th>
                                <th width="12%">Email</th>
                                <th width="13%">Website</th>
                                <th width="13%">Contact No</th>
                                <th >Address</th>
                            </tr>
                        </thead>
                        <tbody id="list_view">
                            <?php
                                $sl = 1;
                                $companies = App\Models\Company::get();
                            
                            ?>
                            @foreach($companies as $company)
                                <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$company->id}}')" style="cursor:pointer">
                                    <td>{{$sl++}}</td>
                                    <td>{{$company->company_name}}</td>
                                    <td>{{$company->group->group_name ?? ''}}</td>
                                    <td>{{$company->company_short_name}}</td>
                                    <td>{{$company->email}}</td>
                                    <td>{{$company->website}}</td>
                                    <td>{{$company->contact_no}}</td>
                                    <td>{{$company->address}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
     var permission ='{{$permission}}';
    function fnc_company_name( operation )
    {
        if (form_validation('cbo_group_name*txt_company_name*txt_company_short_name','Group Name*Company Name*Company Short Name')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('cbo_group_name,txt_company_name,txt_company_short_name,txt_email,txt_website_name,txt_contact_no,txt_company_address,update_id','txt_file');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/company${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_company_list_view','list_view_div','mainform_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        var columns = 'group_id*company_name*company_short_name*email*website*contact_no*address*id';
        var fields = 'cbo_group_name*txt_company_name*txt_company_short_name*txt_email*txt_website_name*txt_contact_no*txt_company_address*update_id';
        var others = 'image_uploads,sys_no,id,file_name,displayImage,company_profile';
       var get_return_value = await populate_form_data('id',menuId,'lib_company',columns,fields,'{{csrf_token()}}');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_company_name',1);
       }
    }

    $("#txt_file").change(function() {
        readImage(this,'displayImage');
    });
    setFilterGrid("list_view",-1);
</script>
@endsection
