<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Uom Entry';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Uom Entry'}}</strong></h1></center>
        </div>
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">    
        <center>
            <div class="card" style="width: 60%">
                <div class="card-body" style="justify-content:center;">
                    <h4 class="card-title">{{getMenuName(request('mid') ?? 0) ?? 'Uom Entry'}}</h4>
                    <div class="card-text" style="justify-content:center;">
                        <!-- #EBF4FA; -->
                        <div class="card" style="background-color: #F5FFFA;justify-content:center;text-align:center">
                            <form name="uomentry_1" id="uomentry_1" autocomplete="off" style="padding: 10px;">
                                
                                <div class="form-group row">
                                    <label for="txt_uom_name" class="col-sm-5 col-form-label must_entry_caption">Uom Name</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="txt_uom_name" id="txt_uom_name" class="form-control"  />
                                    </div>
                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id"/>
                                    
                                        <?php
                                            echo load_submit_buttons( $permission, "fnc_lib_uom", 0,0 ,"reset_form('uomentry_1','','',1,'')");
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
                                        <th>Uom Name</th>
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                        $sl = 1;
                                        $uoms = DB::table('lib_uom as a')
                                                  ->whereNull('a.deleted_at')
                                                  ->select('a.*')
                                                  ->get();
                                    ?>

                                    @foreach($uoms as $uom)
                                        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$uom->id}}')" style="cursor:pointer">
                                            <td>{{$sl++}}</td>
                                            <td>{{$uom->uom_name}}</td>
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
    function fnc_lib_uom( operation )
    {
        if (form_validation('txt_uom_name','Uom Name')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('txt_uom_name,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/general/uom${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_uom_list_view','list_view_div','uomentry_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        reset_form('uomentry_1','','',1);
        var columns = 'uom_name*id';
        var fields = 'txt_uom_name*update_id';
        var get_return_value = await populate_form_data('id',menuId,'lib_uom',columns,fields,'{{csrf_token()}}');
        if(get_return_value == 1)
        {
         set_button_status(1, permission, 'fnc_lib_uom',1);
        }
    }

    $("#txt_file").change(function() {
        readImage(this,'displayImage');
    });
    setFilterGrid("list_view",-1);
</script>
@endsection
