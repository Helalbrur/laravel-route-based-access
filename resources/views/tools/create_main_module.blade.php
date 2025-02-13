<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Main Module'}}</strong></h1>
    </div>
</div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Module Management</h3>
                    <div class="card-text">
                        <div class="card p-4" style="background-color:rgb(241, 241, 241)">
                            <form name="mainmodule_1" id="mainmodule_1" autocomplete="off">
                                <div class="row">

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_module_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Main Module Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_module_name" id="txt_module_name" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_module_link" class="col-sm-2 col-form-label fw-bold text-start">Main Module Link</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_module_link" id="txt_module_link" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_module_seq" class="col-sm-2 col-form-label fw-bold text-start">Sequence</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_module_seq" id="txt_module_seq" class="form-control" onkeydown="checkKeycode(this.event,2)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <label for="cbo_module_sts" class="col-sm-2 col-form-label fw-bold text-start">Status</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <?php $visible_arr = array(1 => "Visible", 2 => "Not visible"); ?>
                                                <select name="cbo_module_sts" id="cbo_module_sts" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach($visible_arr as $key=>$value)
                                                    <option value="{{$key}}" {{$key == 1 ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row d-flex justify-content-center">
                                        <div class="col-sm-3">
                                            <input type="hidden" value="" name="update_id" id="update_id">
                                            <input type="hidden" value="" name="hidden_m_mod_id" id="hidden_m_mod_id">
                                        </div>
                                        <div class="col-sm-9">
                                            <?php echo load_submit_buttons($permission, "fnc_main_module", 0, 0, "reset_form('mainmodule_1','','',1)"); ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card table-responsive table-info mx-auto p-3 mt-4" style="background-color:rgb(241, 241, 241);" id="list_view_div">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-secondary">
                                <tr>
                                    <th width="10%">Sl</th>
                                    <th width="40%">Module Name</th>
                                    <th width="20%">File Location</th>
                                    <th width="10%">Sequence</th>
                                    <th>Visibility</th>
                                </tr>
                            </thead>
                            <tbody id="list_view">
                                <?php
                                $sl = 1;
                                $yes_no = array(1 => "Yes", 2 => "No");
                                $mainModules = App\Models\MainModule::get();
                                ?>
                                @foreach($mainModules as $module)
                                <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$module->m_mod_id}}','tools/create_main_module/get_data_by_id')" style="cursor:pointer">
                                    <td>{{$sl++}}</td>
                                    <td>{{$module->main_module}}</td>
                                    <td>{{$module->file_name}}</td>
                                    <td>{{$module->mod_slno}}</td>
                                    <td>{{$yes_no[$module->status]}}</td>
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
    function fnc_main_module(operation) {
        if (form_validation('txt_module_name*txt_module_seq', 'Module Name*Module Sequence') == false) {
            return;
        } else {
            var method = "";
            if (operation == 0) method = "POST";
            else if (operation == 1) method = "PUT";
            else if (operation == 2) method = "DELETE";
            var param = "";
            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
            }
            var data = get_submitted_data_string('txt_module_name*txt_module_link*txt_module_seq*cbo_module_sts*update_id');
            console.log(data);
            fetch(`/tools/create_main_module${param}`, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{csrf_token()}}' // Add the CSRF token to the headers
                    },
                    body: JSON.stringify({
                        txt_module_name: $("#txt_module_name").val(),
                        txt_module_link: $("#txt_module_link").val(),
                        txt_module_seq: $("#txt_module_seq").val(),
                        cbo_module_sts: $("#cbo_module_sts").val(),
                        update_id: $("#update_id").val(),
                        hidden_m_mod_id: $("#hidden_m_mod_id").val(),
                        _token: '{{csrf_token()}}'
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    showNotification(operation_success_msg[operation]);
                    if (operation < 2) {
                        load_php_data_to_form(data.m_mod_id, 'tools/create_main_module/get_data_by_id');
                    } else if (operation == 2) {
                        reset_form('mainmodule_1', '', '', 1);
                    }
                    show_list_view(0, 'show_module_list_view', 'list_view_div', '/tools/show_module_list_view', 'setFilterGrid("list_view",-1)');
                })
                .catch(error => {
                    showNotification(error, 'error');
                    console.error(error);
                });
        }
    }
    var permission = '{{$permission}}';
    const load_php_data_to_form = (menuId, url) => {
        //toastr.success('Welcome to load_php_data_to_form !', 'Congrats');
        var url = `/${url}/${menuId}`;
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Do something with the response data
                document.getElementById('txt_module_name').value = data.main_module;
                document.getElementById('txt_module_link').value = data.file_name;
                document.getElementById('txt_module_seq').value = data.mod_slno;
                document.getElementById('cbo_module_sts').value = data.status;
                document.getElementById('update_id').value = data.id;
                document.getElementById('hidden_m_mod_id').value = data.m_mod_id;
                //toastr.success('Data has been fetched successfully!', 'Congrats');
                set_button_status(1, permission, 'fnc_main_module', 1);
                //showNotification('Data has been fetched successfully!');
            })
            .catch(error => {
                showNotification(error, 'error');
                console.log(error);
            });
    }
    setFilterGrid("list_view", -1);
</script>
@endsection