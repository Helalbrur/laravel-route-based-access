<?php

$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Report Setting';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Report Setting'}}</strong></h1></center>
        </div>
    </div>
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <center>
            <div class="card" style="justify-content:center;width: 80%;">
                <div class="card-body" style="justify-content:center;">
                    <div class="card-text" style="justify-content:center;">
                        
                        <div class="card" style="background-color: #F5FFFA;justify-content:center;text-align:center">
                            <form name="variablesetting_1" id="variablesetting_1" autocomplete="off" style="padding: 10px;">
                                <div class="form-group row">
                                    
                                    <label for="cbo_company_name"  class="col-sm-3 col-form-label must_entry_caption">Company Name</label>
                                    <div class="col-sm-6">
                                        <select name="cbo_company_name" id="cbo_company_name" onchange="fnc_load_variable_setting();"    class="form-control">
                                            <option value="0">SELECT</option>
                                            <?php
                                                $lib_company = App\Models\Company::pluck('company_name', 'id');
                                            ?>
                                            @foreach($lib_company as $id => $company_name)
                                                <option value="{{ $id }}">{{ $company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cbo_variable_name" class="col-sm-3 col-form-label must_entry_caption"> Setting Name</label>
                                    <div class="col-sm-6" >
                                        <?php
                                            $variable_setting = variable_setting();
                                            ?>
                                        <select name="cbo_variable_name" id="cbo_variable_name" onchange="fnc_load_variable_setting();"   class="form-control">
                                            <option value="0">SELECT</option>
                                            @foreach($variable_setting as $var_id => $variable_name)
                                                <option value="{{$var_id}}" >{{$variable_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div  id="variable_div">
                                    <!-- this will be load from controller with fetch -->
                                    <div class="from-group row" style="margin-top: 20px;">
                                        <div class="col-sm-12">
                                            <input type="hidden" value="" name="update_id" id="update_id" />
                                        
                                            <?php
                                               
                                                $is_update = 0;
                                                
                                                echo load_submit_buttons( $permission, "fnc_variable_setting", $is_update,0 ,"reset_form('variablesetting_1','','',1,'')");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                               
                               
                            </form>
                        </div>
                       
                    </div>
                </div>
            </div>
        </center>
    </div>
</div>

@endsection

@section('script')
<script>
     var permission ='{{$permission}}';
    function fnc_variable_setting( operation )
    {

        if(form_validation('cbo_variable_name*cbo_company_name','Setting Name*Company Name')==false)
        {
            return;
        }
        else
        {
            var formData = '';
            var cbo_variable_name =document.getElementById("cbo_variable_name").value * 1;
            if(cbo_variable_name == 1)
            {
                if (form_validation('cbo_variable_value','System Generated')==false)
                {
                    return;
                }
                else
                {
                    var formData = get_form_data('cbo_variable_value');
                }
            }
            else if(cbo_variable_name == 2)
            {
                if (form_validation('cbo_variable_value','System Generated')==false)
                {
                    return;
                }
                else
                {
                    var formData = get_form_data('cbo_variable_value');
                }
            }

           
           if(formData == '')
           {
               alert('Please Select Setting Name');
               return;
           }

            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            formData.append('cbo_variable_name', document.getElementById('cbo_variable_name').value);
            formData.append('update_id', document.getElementById('update_id').value);
            formData.append('cbo_company_name', document.getElementById('cbo_company_name').value);
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/variable_setting/setting${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','','','variablesetting_1');
        }
        
    }

    const load_php_data_to_form =async (menuId) =>
    {
        reset_form('variablesetting_1','','',1);
        var columns = 'variable_id*company_id';
        var fields = 'cbo_variable_name*cbo_company_name';
        var get_return_value = await populate_form_data('id',menuId,'variable_settings',columns,fields,'{{csrf_token()}}','','','');
       if(get_return_value == 1)
       {
         fnc_load_variable_setting();
       }
    }
    setFilterGrid("list_view",-1);

    function fnc_load_variable_setting()
    {
        var cbo_variable_name =document.getElementById("cbo_variable_name").value;
        var cbo_company_name =document.getElementById("cbo_company_name").value;
        var data = JSON.stringify({variable_name:cbo_variable_name,company_name:cbo_company_name,permission:permission});
        show_list_view('show_variable_setting_list_view','show_common_list_view','variable_div','/show_common_list_view','','','',data);
    }
</script>
@endsection
