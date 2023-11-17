<?php
$permission = getPagePermission();
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <center><h1 class="m-0 align-center"><strong>Country Entry</strong></h1></center>
        </div>
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <center>
            <div class="card" style="width: 60%">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <div class="card-text">
                        <!-- #EBF4FA; -->
                        <div class="card" style="background-color: #F5FFFA">
                            <form name="countryentry_1" id="countryentry_1" autocomplete="off" style="padding: 10px;">
                                
                                <div class="form-group row">
                                    <label for="txt_country_name" class="col-sm-5 col-form-label must_entry_caption">Country Name</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="txt_country_name" id="txt_country_name" class="form-control"  />
                                    </div>
                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id"/>
                                        <?php
                                            echo load_submit_buttons( $permission, "fnc_lib_country", 0,0 ,"reset_form('countryentry_1','','',1,'')");
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="float:left; margin:auto;padding:10px;background-color:#F5FFFA" class="card table-responsive table-info" align="center" id="list_view_div">
                            <table class="table table-bordered table-striped" >
                                <thead>
                                    <tr>
                                        <th width="10%">Sl</th>
                                        <th >Country Name</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                        $sl = 1;
                                        
                                        
                                        $countries = DB::table('lib_country as a')
                                                    ->whereNull('a.deleted_at')
                                                    ->select('a.*')
                                                    ->get();
                                    ?>

                                    @foreach($countries as $country)
                                        <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$country->id}}')" style="cursor:pointer">
                                            <td>{{$sl++}}</td>
                                            <td>{{$country->country_name}}</td>
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
    function fnc_lib_country( operation )
    {
        if (form_validation('txt_country_name','Country Name')==false)
        {
            return;
        }
        else
        {
            var formData = get_form_data('txt_country_name,update_id');
            var method ="POST";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                if(operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/general/country${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation,url,requestData,'id','show_country_list_view','list_view_div','countryentry_1');
        }
    }

    const load_php_data_to_form =async (menuId) =>
    {
        reset_form('countryentry_1','','',1);
        var columns = 'country_name*id';
        var fields = 'txt_country_name*update_id';
       var get_return_value = await populate_form_data('id',menuId,'lib_country',columns,fields,'{{csrf_token()}}');
       if(get_return_value == 1)
       {
         set_button_status(1, permission, 'fnc_lib_country',1);
       }
    }

    $("#txt_file").change(function() {
        readImage(this,'displayImage');
    });
    setFilterGrid("list_view",-1);
</script>
@endsection
