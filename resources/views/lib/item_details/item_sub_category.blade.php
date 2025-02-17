<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Item Sub Category';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Item Sub Category'}}</strong></h1></center>
        </div>
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <center>
            <div class="card" style="justify-content:center;width: 80%;">
                <div class="card-body" style="justify-content:center;">
                    <h4 class="card-title">{{getMenuName(request('mid') ?? 0) ?? 'Item Sub Category'}}</h4>
                    <div class="card-text" style="justify-content:center;">
                        <!-- #EBF4FA; -->
                        <div class="card" style="background-color: #F5FFFA;justify-content:center;text-align:center">
                            <form name="itemsubcategoryentry_1" id="itemsubcategoryentry_1" autocomplete="off" style="padding: 10px;">
                                <div class="form-group row">
                                    <label for="cbo_category_id" class="col-sm-3 col-form-label must_entry_caption"> Category</label>
                                    <div class="col-sm-3">
                                        <?php
                                            $categories = App\Models\LibCategory::get();
                                        ?>
                                        <select name="cbo_category_id" id="cbo_category_id" onchange="load_drop_down( 'load_drop_down', this.value, 'item_group_under_category', 'item_category_div' )"  class="form-control">
                                            <option value="0">SELECT</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{$category->id==1 ? 'selected' : ''}}>{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="txt_item_sub_category_name" class="col-sm-3 col-form-label must_entry_caption">Item Sub Category Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="txt_item_sub_category_name" id="txt_item_sub_category_name" class="form-control"  />
                                    </div>
                                    </div>
                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id"/>
                                    
                                        <?php
                                            echo load_submit_buttons( $permission, "fnc_lib_item_sub_category", 0,0 ,"reset_form('itemsubcategoryentry_1','','',1,'')");
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
                                        <th width="30%">Category Name</th>
                                        <th width="25%">Sub Category Name</th>
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                        $sl = 1;
                                        $item_sub_category = DB::table('lib_item_sub_category as a')
                                                    ->leftJoin('lib_category as b','a.item_category_id','b.id')
                                                    ->whereNull('a.deleted_at')
                                                    ->select('a.id','a.sub_category_name','b.category_name')
                                                    ->get();
                                    ?>

                                    @foreach($item_sub_category as $sub_category)
                                        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$sub_category->id}}')" style="cursor:pointer">
                                            <td>{{$sl++}}</td>
                                            <td>{{$sub_category->category_name}}</td>
                                            <td>{{$sub_category->sub_category_name}}</td>
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
    function fnc_lib_item_sub_category( operation )
    {
        if (form_validation('cbo_category_id*txt_item_sub_category_name','Category Name*Sub Category Name')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('cbo_category_id,txt_item_sub_category_name,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/item_details/item_sub_category${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_sub_category_list_view','list_view_div','itemsubcategoryentry_1'); 
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        
       // reset_form('itemsubcategoryentry_1','','',1);
        var columns = 'item_category_id*sub_category_name*id';
        var fields = 'cbo_category_id*txt_item_sub_category_name*update_id';
        var get_return_value = await populate_form_data('id',menuId,'lib_item_sub_category',columns,fields,'{{csrf_token()}}');
        if(get_return_value == 1)
        {
         set_button_status(1, permission, 'fnc_lib_item_sub_category',1);
        }
    }

    $("#txt_file").change(function() {
        readImage(this,'displayImage');
    });
    setFilterGrid("list_view",-1);
</script>
@endsection
