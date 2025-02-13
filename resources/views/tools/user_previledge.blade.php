<?php
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
?>
@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 align-center">{{getMenuName(request('mid') ?? 0) ?? 'Permission Page'}}</h1>
        </div>
    </div>
@endsection()
@section('content')
<div class="container mt-1">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card p-4 shadow-sm" style="background-color:rgb(241, 241, 241);">
                <div class="card-body">
                    <h3 class="text-center mb-4" style="color: black !important;">Select User and Module</h3>
                    <form name="userpriv_1" id="userpriv_1" autocomplete="off">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">User ID</label>
                                <?= create_drop_down("cbo_user_name", "form-select", "select name,id from users order by name ASC", 'id,name', 1, '--- Select User ---', 0, ""); ?>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Main Module Name</label>
                                <?= create_drop_down("cbo_main_module", "form-select", "select main_module,m_mod_id from main_module where status=1 order by main_module", 'm_mod_id,main_module', 1, '--- Select Module ---', 0, "load_drop_down( 'tools/load_priviledge_list', document.getElementById('cbo_user_name').value+'_'+this.value, 'tools/load_priviledge_list', 'load_priviledge');load_prev_list();"); ?>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Copy To User ID</label>
                                <?= create_drop_down("cbo_copyuser_name", "form-select", "select name,id from users order by name ASC", 'id,name', 1, '--Select To User--', 0, ""); ?>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">&nbsp;</label>
                                <button type="button" class="btn btn-info w-100" onclick="fnc_copy_previledge(0);">
                                    Copy Privilege for New User
                                </button>
                            </div>
                        </div>

                        <div class="mt-4" id="load_priviledge"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function openmypage_item()
	{

		var user_id = $("#txt_user_id").val();
		var title = 'Email Window Popup';
		var page_link='/popup?user_id='+user_id+'&about='+$('#sys_no').val();
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', page_link, title, 'width=600px,height=370px,center=1,resize=1,scrolling=1','../');
		emailwindow.onclose=function()
		{
			var theform=this.contentDoc.forms[0];
			var user_id=this.contentDoc.getElementById("txt_selected_id").value; // product ID
			var user_description=this.contentDoc.getElementById("txt_selected").value; // product Description
			$("#txt_user").val(user_description);
			$("#txt_user_id").val(user_id);
		}
	}
    function fnc_set_priviledge(operation)
    {
        if (form_validation('cbo_main_module*cbo_main_menu_name','Module Name*Menu Name')==false)
        {
            return;
        }
        else
        {
            var method ="";
            if(operation==0)  method ="POST";
            else if(operation==1)  method ="PATCH";
            else if(operation==2)  method ="DELETE";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
                console.log(`param=${param}`);
            }
            try {
                var data = JSON.stringify({
                    cbo_main_module:$("#cbo_main_module").val(),
                    cbo_user_name:$("#cbo_user_name").val(),
                    cbo_set_module_privt:$("#cbo_set_module_privt").val(),
                    cbo_main_menu_name:$("#cbo_main_menu_name").val(),
                    cbo_sub_main_menu_name:$("#cbo_root_menu_under").val(),
                    cbo_sub_menu_name:$("#cbo_sub_menu_name").val(),
                    cbo_visibility:$("#cbo_visibility").val(),
                    cbo_insert:$("#cbo_insert").val(),
                    cbo_edit:$("#cbo_edit").val(),
                    cbo_delete:$("#cbo_delete").val(),
                    cbo_approve:$("#cbo_approve").val(),
                    update_id:$("#update_id").val(),
                    _token:'{{csrf_token()}}'
                });
                console.log(data);
            } catch (error) {
                console.log(error);
                showNotification(error,'error');
                return;
            }
            fetch(`/tools/user_previledge${param}`, {
                method: method ,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
                },
                body: data
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                showNotification(operation_success_msg[operation]);
                var param = document.getElementById('cbo_user_name').value+'_'+document.getElementById('cbo_main_module').value
                //load_php_data_to_form(param,'tools/create_menu/get_data_by_id');
                //loadList(search);
            })
            .catch(error => {
                console.error(error);
                showNotification(error,'error');
            });
        }
    }
    function fnc_copy_previledge(operation)
    {
        if (form_validation('cbo_user_name*cbo_copyuser_name','User Name*Copy To User ID')==false)
		{
			return;
		}
        else
        {
            try {
                var data = JSON.stringify({
                    cbo_main_module:$("#cbo_main_module").val(),
                    cbo_user_name:$("#cbo_user_name").val(),
                    cbo_copyuser_name:$("#cbo_copyuser_name").val(),
                    _token:'{{csrf_token()}}'
                });
                console.log(data);
            } catch (error) {
                console.log(error);
                showNotification(error,'error');
                return;
            }
            fetch(`/tools/copy_user_previledge`, {
                method: 'POST' ,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
                },
                body: data
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                showNotification(operation_success_msg[operation]);
                var param = document.getElementById('cbo_user_name').value+'_'+document.getElementById('cbo_main_module').value;
            })
            .catch(error => {
                console.error(error);
                showNotification(error,'error');
            });
        }
    }
    function load_prev_list()
    {
        try {
            $("#load_list_priv").html("");
        } catch (error) {
            console.log(error);
        }
    }
</script>
<script>set_multiselect('cbo_user_name*cbo_copyuser_name','0*0','0*0','','0');</script>
@endsection
