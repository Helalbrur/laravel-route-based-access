<?php

$permission = getPagePermission(request('mid') ?? 0);
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Bin'}}</strong></h1></center>
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
                        <!-- #EBF4FA; -->
                        <div class="card" style="background-color: #F5FFFA;justify-content:center;text-align:center">
                            <form name="libfloor_1" id="libfloor_1" autocomplete="off" style="padding: 10px;">
                                <div class="form-group row">
                                    <label for="txt_floor_name"  class="col-sm-2 col-form-label must_entry_caption">Floor Name</label>
                                    <div class="col-sm-4" >
                                        <input type="text" class="form-control" id="txt_floor_name" name="txt_floor_name">
                                    </div>
                                    <label for="cbo_company_name"  class="col-sm-2 col-form-label must_entry_caption">Company Name</label>
                                    <div class="col-sm-4">
                                        <select name="cbo_company_name" id="cbo_company_name" onchange="load_drop_down( 'load_drop_down', this.value+'*store_under_location*store_div', 'location_under_company', 'location_div' )" class="form-control">
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
                                                $lib_location = App\Models\LibLocation::pluck('location_name','id');
                                            ?>
                                            @foreach($lib_location as $id => $location_name)
                                                <option value="{{ $id }}">{{ $location_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="cbo_store_name" class="col-sm-2 col-form-label must_entry_caption"> Store Name</label>
                                    <div class="col-sm-4" id="store_div">
                                        <?php
                                            $stores = App\Models\LibStoreLocation::get();
                                            ?>
                                        <select name="cbo_store_name" id="cbo_store_name" class="form-control">
                                            <option value="0">SELECT</option>
                                            @foreach($stores as $store)
                                                <option value="{{$store->id}}" >{{$store->store_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="txt_floor_seq"  class="col-sm-2 col-form-label ">Floor Seq</label>
                                    <div class="col-sm-4" >
                                        <input type="text" class="form-control" id="txt_floor_seq" name="txt_floor_seq">
                                    </div>
                                    
                                    
                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id"/>
                                    
                                        <?php
                                            echo load_submit_buttons( $permission, "fnc_lib_floor", 0,0 ,"reset_form('libfloor_1','','',1,'')");
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
                                    <th width="20%">Floor Name</th>
                                    <th width="25%">Company Name</th>
                                    <th width="25%">Location Name</th>
                                    <th >Store</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="list_view">
                                <?php
                                    $sl = 1;
                                    $floors = DB::table('lib_floor as a')
                                                ->leftJoin('lib_company as b','a.company_id','b.id')
                                                ->leftJoin('lib_location as c','a.location_id','c.id')
                                                ->leftJoin('lib_store_location as d','a.store_id','d.id')
                                                ->select('a.id','d.store_name','b.company_name','c.location_name','a.floor_name')
                                                ->get();
                                ?>

                                @foreach($floors as $floor)
                                    <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$floor->id}}')" style="cursor:pointer">
                                        <td>{{$sl++}}</td>
                                        <td>{{$floor->floor_name}}</td>
                                        <td>{{$floor->company_name}}</td>
                                        <td>{{$floor->location_name}}</td>
                                        <td>{{$floor->store_name}}</td>
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
    function fnc_lib_floor( operation )
    {
        if (form_validation('txt_floor_name*cbo_company_name*cbo_location_name*cbo_store_name','Floor Name* Company Name*Location*Store Name')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('txt_floor_name,cbo_company_name,cbo_location_name,cbo_store_name,txt_floor_seq,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/inventory/floor${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_floor_list_view','list_view_div','libfloor_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        reset_form('libfloor_1','','',1);
        var columns = 'floor_name*company_id*location_id*store_id*seq*id';
        var fields = 'txt_floor_name*cbo_company_name*cbo_location_name*cbo_store_name*txt_floor_seq*update_id';
        var func_name = `load_drop_down( 'load_drop_down', ${$("#cbo_company_name").val()}+'*store_under_location*store_div', 'location_under_company', 'location_div' )`;
       var get_return_value = await populate_form_data('id',menuId,'lib_floor',columns,fields,'{{csrf_token()}}','','','');
       if(get_return_value == 1)
       {
          set_button_status(1, permission, 'fnc_lib_floor',1);
       }
    }
    setFilterGrid("list_view",-1);
   
</script>
@endsection
