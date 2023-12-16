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
                        <!-- #EBF4FA; -->
                        <div class="card" style="background-color: #F5FFFA;justify-content:center;text-align:center">
                            <form name="reportsetting_1" id="reportsetting_1" autocomplete="off" style="padding: 10px;">
                                <div class="form-group row">
                                    
                                    <label for="cbo_company_name"  class="col-sm-3 col-form-label must_entry_caption">Company Name</label>
                                    <div class="col-sm-6">
                                        <select name="cbo_company_name" id="cbo_company_name"  class="form-control">
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
                                    <label for="cbo_module_name"  class="col-sm-3 col-form-label must_entry_caption">Module</label>
                                    <div class="col-sm-6" id="location_div">
                                        <select name="cbo_module_name" id="cbo_module_name"  class="form-control" >
                                            <option value="0">SELECT</option>
                                            <?php
                                                $lib_module = App\Models\MainModule::pluck('main_module','m_mod_id');
                                            ?>
                                            @foreach($lib_module as $m_mod_id => $main_module)
                                                <option value="{{ $m_mod_id }}">{{ $main_module }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cbo_report_name" class="col-sm-3 col-form-label must_entry_caption"> Report Name</label>
                                    <div class="col-sm-6" id="report_div">
                                        <?php
                                            $report_name = report_name();
                                            ?>
                                        <select name="cbo_report_name" id="cbo_report_name" class="form-control">
                                            <option value="0">SELECT</option>
                                            @foreach($report_name as $rpt_id => $rpt_name)
                                                <option value="{{$rpt_id}}" >{{$rpt_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cbo_format_name" class="col-sm-3 col-form-label must_entry_caption">Format Name</label>
                                    <div class="col-sm-6" id="format_div">
                                        <?php
                                            echo create_drop_down( "cbo_format_name", "100%", blank_array(),'', 1, '--- Select Format ---', 0, "","",""  );
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cbo_user_id" class="col-sm-3 col-form-label must_entry_caption">User Name</label>
                                    <div class="col-sm-6" >
                                    <?php echo create_drop_down("cbo_user_id", "100%", "select name,id from users  order by name ASC",'id,name', 0, '--Select--', 0, "",""); ?> 
                                    </div>
                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id"/>
                                    
                                        <?php
                                            echo load_submit_buttons( $permission, "fnc_report_setting", 0,0 ,"reset_form('reportsetting_1','','',1,'')");
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
    function fnc_report_setting( operation )
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

            save_update_delete(operation,url,requestData,'id','show_floor_list_view','list_view_div','reportsetting_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        reset_form('reportsetting_1','','',1);
        var columns = 'floor_name*company_id*location_id*store_id*seq*id';
        var fields = 'txt_floor_name*cbo_company_name*cbo_location_name*cbo_store_name*txt_floor_seq*update_id';
        var func_name = `load_drop_down( 'load_drop_down', ${$("#cbo_company_name").val()}+'*store_under_location*store_div', 'location_under_company', 'location_div' )`;
       var get_return_value = await populate_form_data('id',menuId,'lib_floor',columns,fields,'{{csrf_token()}}','','','');
       if(get_return_value == 1)
       {
          set_button_status(1, permission, 'fnc_report_setting',1);
       }
    }
    setFilterGrid("list_view",-1);
    set_multiselect('cbo_format_name*cbo_user_id','0*0','0*0','','0*0');
    
    var documentElement = document.documentElement;
    // Add a keypress event listener
    documentElement.addEventListener("change", function(event) 
    {
        // Get the event target
        var target = event.target;
        try {
            console.log(`target.id=${target.id}`)
            if (target.id =="cbo_module_name") {
                load_drop_down( "load_drop_down", target.value, "report_name_under_module", "report_div" )
            }
            if(target.id =="cbo_report_name")
            {
                load_drop_down( 'load_drop_down', target.value, 'report_formate_under_report_name', 'format_div',
                    function() {
                        console.log('hello');
                        set_multiselect('cbo_format_name*cbo_user_id','0*0','0*0','','0*0');
                    }
                );
            }
        } catch (error) {
            console.log(error)
        }
    });
   
    /*
   
    // Add a click event listener to the button
    document.getElementById("cbo_module_name").addEventListener("change", function() {
        load_drop_down( "load_drop_down", this.value, "report_name_under_module", "report_div" ) ;
    });
    document.getElementById("cbo_report_name").addEventListener("change", function() {
        console.log(1);
        load_drop_down( 'load_drop_down', this.value, 'report_formate_under_report_name', 'format_div' );
        console.log(2);
        set_multiselect('cbo_format_name','0','0','','0');
        console.log(3);
    });
    */
</script>
@endsection
