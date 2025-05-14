<?php
$permission = '0_1_0_0';
$title = getMenuName(request('mid') ?? 0) ?? 'User Profile';
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12 d-flex justify-content-center align-items-center text-center">
        <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'User Profile'}}</strong></h1>
    </div>
</div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="card pt-4 px-4" style="background-color:rgb(241, 241, 241)">
                            <form name="userProfile_1" id="userProfile_1" autocomplete="off">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_name" id="txt_name" class="form-control" value="{{Auth::user()->name}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_email" class="col-sm-2 col-form-label fw-bold text-start">Email</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="email" name="txt_email" id="txt_email" class="form-control" value="{{Auth::user()->email}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_password" class="col-sm-2 col-form-label fw-bold text-start">Password</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="password" name="txt_password" id="txt_password" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_phone_no" class="col-sm-2 col-form-label fw-bold text-start">Phone No</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_phone_no" id="txt_phone_no" class="form-control" value="{{Auth::user()->phone}}">
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
                                                    <option value="{{$key}}" {{$key== Auth::user()->type ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_profile_photo" class="col-sm-2 col-form-label fw-bold text-start">Photo</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="file" name="files[]" id="txt_profile_photo" multiple class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row d-flex justify-content-center">
                                        <div class="col-sm-6 d-flex justify-content-center">
                                            <img src="" width="150" height="150" id="displayImage" style="display: none;">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="mb-3 row d-flex justify-content-center">
                                    <div class="col-sm-2">
                                        <input type="hidden" name="update_id" id="update_id" value="{{Auth::user()->id}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <?php echo load_submit_buttons($permission, "fnc_user_management", 1, 0, "reset_form('userProfile_1','','',1)"); ?>
                                    </div>
                                </div>
                            </form>
                        </div>
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

            param = `/${document.getElementById('update_id').value}`;
            formData.append('_method', 'PUT');

            formData.append('_token', '{{csrf_token()}}');
            var url = `/tools/user_profile${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData, 'id', '', '', '');
        }
    }
    var permission = '{{$permission}}';
    const load_php_data_to_form = async (user_id) => {
        location.reload();
    }
    $("#txt_profile_photo").change(function() {
        readImage(this, 'displayImage');
    });
</script>
@endsection