<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12">
        <center><h1 class="m-0 align-center"><strong>{{ getMenuName(request('mid') ?? 0) ?? 'Group Profile'}}</strong></h1></center>
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
                        <div class="card p-4" style="background-color:rgb(241, 241, 241)">
                            <form name="groupForm_1" id="groupForm_1" autocomplete="off">
                                <div class="row">
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="txt_group_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Group Name</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" name="txt_group_name" id="txt_group_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="txt_group_short" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Group Short Name</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" name="txt_group_short" id="txt_group_short" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="txt_contact_no" class="col-sm-2 col-form-label fw-bold text-start">Contact Number</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" name="txt_contact_no" id="txt_contact_no" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="cbo_country_id" class="col-sm-2 col-form-label fw-bold text-start">Country</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <?php $countryies = App\Models\LibCountry::get(); ?>
                                            <select name="cbo_country_id" id="cbo_country_id" class="form-control">
                                                <option value="0">SELECT</option>
                                                @foreach($countryies as $country)
                                                <option value="{{$country->id}}" {{$country->id==1 ? 'selected' : ''}}>{{$country->country_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="txt_website" class="col-sm-2 col-form-label fw-bold text-start">Website</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" name="txt_website" id="txt_website" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="txt_email" class="col-sm-2 col-form-label fw-bold text-start">Email</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="email" name="txt_email" id="txt_email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="txt_contact_person" class="col-sm-2 col-form-label fw-bold text-start">Contact Person</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="text" name="txt_contact_person" id="txt_contact_person" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="txt_file" class="col-sm-2 col-form-label fw-bold text-start">Image</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <input type="file" name="files[]" id="txt_file" multiple class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <label for="txt_address" class="col-sm-2 col-form-label fw-bold text-start">Address</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            <textarea name="txt_address" id="txt_address" cols="30" rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <div class="col-sm-6 d-flex justify-content-center">
                                            <img src="" width="150" height="150" id="displayImage" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="mb-3 row d-flex justify-content-center mt-2">
                                        <div class="col-sm-2">
                                            <input type="hidden" value="" name="update_id" id="update_id">
                                        </div>
                                        <div class="col-sm-6">
                                            <?php echo load_submit_buttons($permission, "fnc_lib_group", 0, 0, "reset_form('groupForm_1','','',1)"); ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="button" class="btn btn-md btn-info" value="Show Files" onclick="show_files('update_id','group_profile','','show_group_list_view','list_view_div');">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="margin:auto;padding:10px;background-color:rgb(241, 241, 241)" class="card table-responsive table-info" align="center" id="list_view_div">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="3%">Sl</th>
                                        <th width="25%">Group Name</th>
                                        <th width="10%">Short Name</th>
                                        <th width="20%">Contact No</th>
                                        <th width="25%">Address</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody id="list_view">
                                    <?php
                                    $sl = 1;
                                    $images = DB::table('image_uploads as b')
                                        ->where('b.page_name', '=', 'group_profile')
                                        ->select('b.sys_no', 'b.file_name', 'b.file_type', 'b.id')
                                        ->get();
                                    $group_images = array();
                                    foreach ($images as $image) {
                                        $group_images[$image->sys_no][$image->id]['file_name'] = $image->file_name;
                                        $group_images[$image->sys_no][$image->id]['file_type'] = $image->file_type;
                                    }

                                    $groups = DB::table('lib_group as a')
                                        ->whereNull('a.deleted_at')
                                        ->select('a.*')
                                        ->get();
                                    ?>

                                    @foreach($groups as $group)
                                    <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$group->id}}')" style="cursor:pointer">
                                        <td>{{$sl++}}</td>
                                        <td>{{$group->group_name}}</td>
                                        <td>{{$group->group_short_name}}</td>
                                        <td>{{$group->contact_no}}</td>
                                        <td>{{$group->address}}</td>
                                        <td>
                                            @if(isset($group_images[$group->id]) && count($group_images[$group->id]) > 0)
                                            @foreach($group_images[$group->id] as $imageUpload)
                                            @if(!empty($imageUpload['file_name']) && $imageUpload['file_type'] == 1)
                                            <a href="{{asset($imageUpload['file_name'])}}" download>
                                                <img src="{{asset($imageUpload['file_name'])}}" height="100" width="100" download>
                                            </a>
                                            @elseif(!empty($imageUpload['file_name']))
                                            <a href="{{asset($imageUpload['file_name'])}}" download>
                                                <img src="{{asset('image/download.png')}}" height="45" width="55">
                                            </a>
                                            @endif
                                            @endforeach
                                            @endif
                                        </td>
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
</div>
@endsection

@section('script')
<script>
    var permission = '{{$permission}}';

    function fnc_lib_group(operation) {
        if (form_validation('txt_group_name*txt_group_short', 'Group Name*Group Short Name') == false) {
            return;
        } else {

            var formData = get_form_data('txt_group_name,txt_group_short,txt_contact_no,cbo_country_id,txt_website,txt_email,txt_contact_person,txt_address,update_id', 'txt_file');
            var method = "POST";
            var param = "";
            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
                if (operation == 1) formData.append('_method', 'PUT');
                else formData.append('_method', 'DELETE');
            }
            formData.append('_token', '{{csrf_token()}}');
            var url = `/lib/group${param}`;
            var requestData = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            };

            save_update_delete(operation, url, requestData, 'id', 'show_group_list_view', 'list_view_div', 'groupForm_1');
        }
    }

    const load_php_data_to_form = async (menuId) => {
        reset_form('groupForm_1', '', '', 1);
        var columns = 'group_name*group_short_name*website*address*email*contact_no*contact_person*country_id*id';
        var fields = 'txt_group_name*txt_group_short*txt_website*txt_address*txt_email*txt_contact_no*txt_contact_person*cbo_country_id*update_id';
        var others = 'image_uploads,sys_no,id,file_name,displayImage,group_profile';
        var get_return_value = await populate_form_data('id', menuId, 'lib_group', columns, fields, '{{csrf_token()}}');
        if (get_return_value == 1) {
            set_button_status(1, permission, 'fnc_lib_group', 1);
        }
    }

    $("#txt_file").change(function() {
        readImage(this, 'displayImage');
    });
    setFilterGrid("list_view", -1);
</script>
@endsection