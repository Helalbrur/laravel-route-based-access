<?php

use Illuminate\Support\Facades\Session;
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Lib Group'}}</strong></h1></center>
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
                            <form name="itemgroupentry_1" id="itemgroupentry_1" autocomplete="off" style="padding: 10px;">
                                
                                <div class="form-group row">
                                    <label for="cbo_category_id" class="col-sm-3 col-form-label must_entry_caption"> Category</label>
                                    <div class="col-sm-3">
                                        <?php
                                            $categories = App\Models\LibCategory::get();
                                        ?>
                                        <select name="cbo_category_id" id="cbo_category_id" class="select2 form-control" style="width: 100%;">
                                            <option value="0">SELECT</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{$category->id==1 ? 'selected' : ''}}>{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="txt_item_group_name" class="col-sm-3 col-form-label must_entry_caption">Item Group Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="txt_item_group_name" id="txt_item_group_name" class="form-control"  />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    
                                    <label for="txt_item_group_code" class="col-sm-3 col-form-label">Item Group Code</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="txt_item_group_code" id="txt_item_group_code" class="form-control"  />
                                    </div>
                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id"/>
                                    
                                        <?php
                                            echo load_submit_buttons( $permission, "fnc_lib_item_group", 0,0 ,"reset_form('itemgroupentry_1','','',1,'')");
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
                                    <th width="25%">Category Name</th>
                                    <th width="35%">Item Group Name</th>
                                    <th >Item Group Code</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="list_view">
                                <?php
                                    $sl = 1;
                                    $item_groups = DB::table('lib_item_group as a')
                                                ->leftJoin('lib_category as b','a.item_category_id','b.id')
                                                ->whereNull('a.deleted_at')
                                                ->select('a.id','a.item_name','a.item_group_code','b.category_name')
                                                ->get();
                                ?>

                                @foreach($item_groups as $group)
                                    <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$group->id}}')" style="cursor:pointer">
                                        <td>{{$sl++}}</td>
                                        <td>{{$group->category_name}}</td>
                                        <td>{{$group->item_name}}</td>
                                        <td>{{$group->item_group_code}}</td>
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
     /*
     var field_level_data = "";
     @if(session()->has('laravel_stater.data_arr.3'))
        @php
            $dataArr = json_encode(session('laravel_stater.data_arr.3'));
            echo "field_level_data = ".$dataArr.";\n";
        @endphp
    @endif
    */

    var setup_data = load_all_setup(3); // Pass the entry_form dynamically
    console.log(setup_data);

    var field_level_data = setup_data.field_level_data;
    var mandatoryField = setup_data.mandatoryField;
    var mandatoryMessage = setup_data.mandatoryMessage;

    function fnc_lib_item_group( operation )
    {
        if(form_validation('cbo_category_id*txt_item_group_name','Category Name*Item Group Name')==false)
        {
            return;
        }
        else
        {
            /*
            var mandatoryField = "";
            var mandatoryMessage = "";
            @if(session()->has('laravel_stater.mandatory_field.3'))
                mandatoryField = '<?php //echo implode('*', session('laravel_stater.mandatory_field.3')); ?>';
                mandatoryMessage = '<?php //echo implode('*', session('laravel_stater.mandatory_message.3')); ?>';
            @endif
            */

            // Check if mandatoryField is not empty
            if (mandatoryField)
            {
                // Call the form_validation function passing mandatoryField and mandatoryMessage
                if (form_validation(mandatoryField, mandatoryMessage) == false)
                {
                    return;
                }
            }

            var formData = get_form_data('cbo_category_id,txt_item_group_name,txt_item_group_code,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/item_details/item_group${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_item_group_list_view','list_view_div','itemgroupentry_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        reset_form('itemgroupentry_1','','',1);
        var columns = 'item_category_id*item_name*item_group_code*id';
        var fields = 'cbo_category_id*txt_item_group_name*txt_item_group_code*update_id';
       var get_return_value = await populate_form_data('id',menuId,'lib_item_group',columns,fields,'{{csrf_token()}}');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_lib_item_group',1);
       }
    }

    $("#txt_file").change(function() {
        readImage(this,'displayImage');
    });
    setFilterGrid("list_view",-1);
    // make_mandatory(3);
    // field_manager(3);
   
</script>
@endsection
