<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'User Management';
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12 d-flex justify-content-center align-items-center text-center">
        <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'User Management'}}</strong></h1>
    </div>
</div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                        <a href="{{ url('/user_import') }}" class="btn btn-info">Download Format</a>
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                            @csrf
                            <input type="file" name="file" required class="form-control me-2">
                            <button type="submit" class="btn btn-info">Import</button>
                        </form>
                    </h5>
                    <div class="card-text">
                        <div class="card p-4" style="background-color:rgb(241, 241, 241)">
                            <form name="usermanagement_1" id="usermanagement_1" autocomplete="off">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_name" id="txt_name" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_email" class="col-sm-2 col-form-label fw-bold text-start">Email</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="email" name="txt_email" id="txt_email" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_password" class="col-sm-2 col-form-label fw-bold text-start">Password</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="password" name="txt_password" id="txt_password" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_phone_no" class="col-sm-2 col-form-label fw-bold text-start">Phone No</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_phone_no" id="txt_phone_no" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <label for="cbo_user_type" class="col-sm-2 col-form-label fw-bold text-start">User Type</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <?php $user_type = user_type(); ?>
                                                <select name="cbo_user_type" id="cbo_user_type" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($user_type as $key=>$value)
                                                    <option value="{{$key}}" {{$key==1 ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex justify-content-center">
                                    <div class="col-sm-2">
                                        <input type="hidden" value="" name="update_id" id="update_id" />
                                    </div>
                                    <div class="col-sm-6">
                                        <?php echo load_submit_buttons($permission, "fnc_user_management", 0, 0, "reset_form('usermanagement_1','','',1)"); ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card table-responsive table-info mx-auto p-3 mt-4" style=" background-color:rgb(241, 241, 241);" id="list_view_div">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-secondary">
                                <tr>
                                    <th width="10%">Sl</th>
                                    <th width="25%">Name</th>
                                    <th width="25%">Email</th>
                                    <th width="20%">Phone</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody id="list_view">
                                <?php
                                $sl = 1;
                                $users = App\Models\User::get();
                                ?>
                                @foreach($users as $user)
                                <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$user->id}}')" style="cursor:pointer">
                                    <td>{{$sl++}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user_type[$user->type] ?? ''}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function fnc_user_management(operation) {
        var val_col = 'txt_name*txt_email*txt_password';
        var val_msg = 'Name*Email*Password';
        if (operation != 0) {
            val_col = 'txt_name*txt_email';
            val_msg = 'Name*Email';
        }
        if (form_validation(val_col, val_msg) == false) {
            return;
        } else {
            var formData = get_form_data('txt_name,txt_email,txt_password,txt_phone_no,cbo_user_type,update_id');
            var method = "POST";
            var param = "";
            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
                if (operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/tools/user_management${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData, 'id', 'show_user_list_view', 'list_view_div', 'usermanagement_1');
        }
    }
    var permission = '{{$permission}}';
    const load_php_data_to_form = async (user_id) => {
        reset_form('usermanagement_1', '', '', 1);
        var columns = 'name*email*phone*type*id';
        var fields = 'txt_name*txt_email*txt_phone_no*cbo_user_type*update_id';
        var get_return_value = await populate_form_data('id', user_id, 'users', columns, fields, '{{csrf_token()}}');
        if (get_return_value == 1) {
            set_button_status(1, permission, 'fnc_user_management', 1);
        }
    }
    setFilterGrid("list_view", -1);
</script>
@endsection