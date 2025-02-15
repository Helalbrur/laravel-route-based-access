<?php

use App\Models\LibLocation;
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Store Location'}}</strong></h1></center>
        </div>
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <center>
            <div class="card" style="justify-content:center;width: 80%;">
                <div class="card-body" style="justify-content:center;">
                    <div class="card-text" style="justify-content:center;">
                        <!-- #EBF4FA; -->
                        <div class="card" style="background-color: #F5FFFA;justify-content:center;text-align:center">
                            <form name="libstorelocation_1" id="libstorelocation_1" autocomplete="off" style="padding: 10px;">
                                <div class="form-group row">
                                    <label for="txt_store_name"  class="col-sm-2 col-form-label must_entry_caption">Store Name</label>
                                    <div class="col-sm-4" >
                                        <input type="text" class="form-control" id="txt_store_name" name="txt_store_name">
                                    </div>
                                    <label for="cbo_company_name"  class="col-sm-2 col-form-label must_entry_caption">Company Name</label>
                                    <div class="col-sm-4">
                                        <select name="cbo_company_name" id="cbo_company_name" onchange="load_drop_down( 'load_drop_down', this.value, 'location_under_company', 'location_div' )" class="form-control">
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
                                    <label for="cbo_location_name"  class="col-sm-2 col-form-label must_entry_caption">Location</label>
                                    <div class="col-sm-4" id="location_div">
                                        <select name="cbo_location_name" id="cbo_location_name"  class="form-control">
                                            <option value="0">SELECT</option>
                                            <?php
                                                $lib_location = LibLocation::pluck('location_name','id');
                                            ?>
                                            @foreach($lib_location as $id => $location_name)
                                                <option value="{{ $id }}">{{ $location_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="cbo_category_id" class="col-sm-2 col-form-label must_entry_caption"> Category</label>
                                    <div class="col-sm-4">
                                        <?php
                                            $categories = App\Models\LibCategory::get();
                                        ?>
                                        <select name="cbo_category_id[]" id="cbo_category_id" class="form-control" multiple="multiple">
                                            <option value="0" selected>SELECT</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id"/>
                                    
                                        <?php
                                            echo load_submit_buttons( $permission, "fnc_lib_store_location", 0,0 ,"reset_form('libstorelocation_1','','',1,'')");
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="margin:auto;padding:10px;background-color:#F5FFFA;justify-content:center;text-align:center" class="card table-responsive table-info" align="center" id="list_view_div">
                            <table class="table table-bordered table-striped" >
                                <thead>
                                    <tr>
                                        <th width="10%">Sl</th>
                                        <th width="20%">Store Name</th>
                                        <th width="25%">Company Name</th>
                                        <th width="25%">Location Name</th>
                                        <th >Category</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                        $sl = 1;
                                        $stores = DB::table('lib_store_location as a')
                                                    ->leftJoin('lib_company as b','a.company_id','b.id')
                                                    ->leftJoin('lib_location as c','a.location_id','c.id')
                                                    ->whereNull('a.deleted_at')
                                                    ->select('a.id','a.store_name','b.company_name','c.location_name')
                                                    ->get();
                                    ?>

                                    @foreach($stores as $store)
                                        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$store->id}}')" style="cursor:pointer">
                                            <td>{{$sl++}}</td>
                                            <td>{{$store->store_name}}</td>
                                            <td>{{$store->company_name}}</td>
                                            <td>{{$store->location_name}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    function fnc_lib_store_location( operation )
    {
        if (form_validation('txt_store_name*cbo_company_name*cbo_location_name*cbo_category_id',' Store Name* Company Name*Location*Category')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('txt_store_name,cbo_company_name,cbo_location_name,cbo_category_id,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/general/store${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_store_list_view','list_view_div','libstorelocation_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        reset_form('libstorelocation_1','','',1);
        var columns = 'store_name*company_id*location_id*item_category_id*id';
        var fields = 'txt_store_name*cbo_company_name*cbo_location_name*cbo_category_id*update_id';
        var func_name = `load_drop_down( 'load_drop_down', document.getElementById('cbo_company_name').value, 'location_under_company', 'location_div' )`;
       var get_return_value = await populate_form_data('id',menuId,'lib_store_location',columns,fields,'{{csrf_token()}}','','','');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_lib_store_location',1);
       }
    }

    //set_multiselect('cbo_category_id','0','0','','0');
    setFilterGrid("list_view",-1);
   
</script>
@endsection
