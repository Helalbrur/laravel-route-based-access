<?php

use App\Models\Brand;

$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Brand Entry';
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12">
        <center>
            <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Brand Entry'}}</strong></h1>
        </center>
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
                            <form name="libBrand_1" id="libBrand_1" autocomplete="off" style="padding: 10px;">
                                <div class="form-group row">
                                    <label for="txt_brand_name" class="col-sm-2 col-form-label must_entry_caption">Brand Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="txt_brand_name" name="txt_brand_name">
                                    </div>
                                    <label for="cbo_buyer_id" class="col-sm-2 col-form-label must_entry_caption">Buyer Name</label>
                                    <div class="col-sm-4">
                                        <select name="cbo_buyer_id" id="cbo_buyer_id" class="form-control">
                                            <option value="0">SELECT</option>
                                            <?php
                                            $lib_buyer = App\Models\LibBuyer::pluck('buyer_name', 'id');
                                            ?>
                                            @foreach($lib_buyer as $id => $buyer_name)
                                            <option value="{{ $id }}">{{ $buyer_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="from-group row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <input type="hidden" value="" name="update_id" id="update_id" />

                                        <?php
                                        echo load_submit_buttons($permission, "fnc_lib_brand", 0, 0, "reset_form('libBrand_1','','',1,'')");
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="margin:auto;padding:10px;background-color:#F5FFFA;justify-content:center;text-align:center" class="card table-responsive table-info" align="center" id="list_view_div">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">Sl</th>
                                        <th width="45%">Brand Name</th>
                                        <th>Buyer Name</th>
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                    $sl = 1;
                                    $brands = DB::table('lib_brand as a')
                                        ->leftJoin('lib_buyer as b', 'a.buyer_id', 'b.id')
                                        ->whereNull('a.deleted_at')
                                        ->select('a.id', 'a.name', 'b.buyer_name')
                                        ->get();
                                    ?>

                                    @foreach($brands as $brand)
                                    <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$brand->id}}')" style="cursor:pointer">
                                        <td>{{$sl++}}</td>
                                        <td>{{$brand->name}}</td>
                                        <td>{{$brand->buyer_name}}</td>
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
    var permission = '{{$permission}}';

    function fnc_lib_brand(operation) {
        if (form_validation('txt_brand_name*cbo_buyer_id', 'Brand Name* Buyer Name') == false) {
            return;
        } else {
            var formData = get_form_data('txt_brand_name,cbo_buyer_id,update_id');
            var method = "POST";
            var param = "";
            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
                if (operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/general/brand${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData, 'id', 'show_brand_list_view', 'list_view_div', 'libBrand_1');
        }
    }

    const load_php_data_to_form = async (menuId) => {
        reset_form('libBrand_1', '', '', 1);
        var columns = 'id*brand_name*buyer_id';
        var fields = 'update_id*txt_brand_name*cbo_buyer_id';
        var get_return_value = await populate_form_data('id',menuId,'lib_brand',columns,fields,'{{csrf_token()}}');
        if (get_return_value == 1) {
            set_button_status(1, permission, 'fnc_lib_brand', 1);
        }
    }
    setFilterGrid("list_view", -1);
</script>
@endsection