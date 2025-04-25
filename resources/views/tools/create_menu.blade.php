<?php
use Illuminate\Support\Facades\Route;
$permission = getPagePermission(request('mid') ?? 0);
$title = getMenuName(request('mid') ?? 0) ?? 'Color Entry';
// dd(get_available_route());
?>
@extends('layouts.app')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12 d-flex justify-content-center align-items-center text-center">
        <h1 class="m-0 align-center"><strong>{{getMenuName(request('mid') ?? 0) ?? 'Menu Management'}}</strong></h1>
    </div>
</div>
@endsection()
@section('content')
<?php $selected = 0; ?>
<div class="container mt-1">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="card-text">
                        <div class="card p-4" style="background-color:rgb(241, 241, 241)">

                            <form name="main_menu_1" id="main_menu_1" autocomplete="off" style="padding: 10px;">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="cbo_module_name" class="col-sm-2 col-form-label fw-bold text-start must_entry_caption">Main Module Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <?php
                                                $modules = App\Models\MainModule::get();
                                                ?>
                                                <select name="cbo_module_name" id="cbo_module_name" class="form-control" onchange="load_drop_down('tools/load_main_menu', this.value, 'tools/load_main_menu', 'root_menu_div')">
                                                    <option value="0">SELECT</option>
                                                    @foreach($modules as $module)
                                                    <option value="{{$module->m_mod_id}}">{{$module->main_module}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <label for="chk_report_menu" class="col-sm-2 col-form-label fw-bold text-start">Approval Menu</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="checkbox" id="chk_report_menu" name="chk_report_menu">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_menu_name" class="col-sm-2 col-form-label fw-bold text-start">Menu Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_menu_name" id="txt_menu_name" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_menu_link" class="col-sm-2 col-form-label fw-bold text-start">Menu Link</label>
                                            <div class="col-sm-6 d-flex align-items-center" id="menu_link_div">
                                                <select name="txt_menu_link" id="txt_menu_link" class="form-control select2">
                                                    <option value="">Select a Route</option>
                                                    @foreach(get_available_route() as $route)
                                                        <option value="{{ $route }}">{{ $route }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="cbo_root_menu" class="col-sm-2 col-form-label fw-bold text-start">Root Menu</label>
                                            <div class="col-sm-6 d-flex align-items-center" id="root_menu_div">
                                                <select name="cbo_root_menu" id="cbo_root_menu" class="form-control" onchange="load_drop_down( 'tools/load_sub_menu_under_menu', this.value, 'tools/load_sub_menu_under_menu', 'subrootdiv' )">
                                                    <?php
                                                    $menus = DB::table('main_menu')->where('position', 1)->orderBy('menu_name', 'asc')->get();
                                                    ?>
                                                    <option value="0">SELECT</option>
                                                    @foreach($menus as $menu)
                                                    <option value="{{$menu->m_menu_id}}">{{$menu->menu_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="cbo_root_menu" class="col-sm-2 col-form-label fw-bold text-start">Root Menu Under</label>
                                            <div class="col-sm-6 d-flex align-items-center" id="subrootdiv">
                                                <select name="cbo_root_menu_under" id="cbo_root_menu_under" class="form-control">
                                                    <?php
                                                    $sub_menus = DB::table('main_menu')->where('position', 2)->orderBy('menu_name', 'asc')->get();
                                                    ?>
                                                    <option value="0">SELECT</option>
                                                    @foreach($sub_menus as $menu)
                                                    <option value="{{$menu->m_menu_id}}">{{$menu->menu_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="cbo_fabric_nature" class="col-sm-2 col-form-label fw-bold text-start">Product Nature</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select name="cbo_fabric_nature" id="cbo_fabric_nature" class="form-control">
                                                    <?php
                                                    $sub_menus = DB::table('main_menu')->where('position', 2)->orderBy('menu_name', 'asc')->get();
                                                    ?>
                                                    <option value="0">SELECT</option>
                                                    @foreach(get_item_category() as $category_id =>$category_name)
                                                    <option value="{{$category_id}}">{{$category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_menu_seq" class="col-sm-2 col-form-label fw-bold text-start">Sequence</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="number" name="txt_menu_seq" id="txt_menu_seq" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="cbo_menu_sts" class="col-sm-2 col-form-label fw-bold text-start">Status</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <select name="cbo_menu_sts" id="cbo_menu_sts" class="form-control">
                                                    <option value="0">SELECT</option>
                                                    @foreach(get_row_status() as $status_id =>$status_name)
                                                    <option value="{{$status_id}}" {{ $status_id == 1 ? 'selected' : ''}}>{{$status_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="chk_mobile_menu" class="col-sm-2 col-form-label fw-bold text-start">Mobile Menu</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="checkbox" id="chk_mobile_menu" name="chk_mobile_menu">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="chk_mobile_menu" class="col-sm-2 col-form-label fw-bold text-start">Page Link</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_page_link" id="txt_page_link" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <label for="txt_short_name" class="col-sm-2 col-form-label fw-bold text-start">Page Short Name</label>
                                            <div class="col-sm-6 d-flex align-items-center">
                                                <input type="text" name="txt_short_name" id="txt_short_name" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-sm-2">
                                                <input type="hidden" value="" name="update_id" id="update_id" />
                                                <input type="hidden" value="" name="hidden_m_mod_id" id="hidden_m_mod_id" />
                                                <input type="hidden" value="" name="id" id="id" />
                                            </div>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <?php
                                                echo load_submit_buttons($permission, "fnc_menu_create", 0, 0, "reset_form('main_menu_1','','',1)");
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="container mt-4 col-sm-9" id="list_view_div">
                                <div class="card p-3" style="background-color: lightgray;">
                                    <div class="d-flex justify-content-center">
                                        <input type="text" id="txt_search" class="form-control w-50" placeholder="Search" onkeyup="loadList(this.value)">
                                    </div>
                                    <div id="search_div" class="text-center mt-3"></div>
                                </div>
                            </div>

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
    function fnc_menu_create(operation) {
        if (form_validation('cbo_module_name*txt_menu_name*txt_menu_seq*cbo_menu_sts', 'Module Name*Menu Name*Menu Sequence*Menu Status') == false) {
            return;
        } else {
            var method = "";
            if (operation == 0) method = "POST";
            else if (operation == 1) method = "POST";
            else if (operation == 2) method = "POST";
            var param = "";
            var input_method = "POST";
            if (operation == 1 || operation == 2) {
                param = `/${document.getElementById('update_id').value}`;
                console.log(`param = ${param} and id = ${document.getElementById('update_id').value}`);
                if (operation == 1) input_method = "PATCH";
                else input_method = "DELETE";
            }

            if ($("#chk_report_menu").attr("checked")) var chk_report_menu = 1;
            else var chk_report_menu = 0;

            if ($("#chk_mobile_menu").attr("checked")) var chk_mobile_menu = 1;
            else var chk_mobile_menu = 0;

            fetch(`/tools/create_menu${param}`, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{csrf_token()}}' // Add the CSRF token to the headers
                    },
                    body: JSON.stringify({
                        cbo_module_name: $("#cbo_module_name").val(),
                        cbo_root_menu: $("#cbo_root_menu").val(),
                        txt_menu_name: $("#txt_menu_name").val(),
                        txt_menu_link: $("#txt_menu_link").val(),
                        cbo_root_menu_under: $("#cbo_root_menu_under").val(),
                        txt_menu_seq: $("#txt_menu_seq").val(),
                        txt_page_link: $("#txt_page_link").val(),
                        txt_short_name: $("#txt_short_name").val(),
                        cbo_menu_sts: $("#cbo_menu_sts").val(),
                        cbo_fabric_nature: $("#cbo_fabric_nature").val(),
                        update_id: $("#update_id").val(),
                        chk_report_menu: chk_report_menu,
                        chk_mobile_menu: chk_mobile_menu,
                        _token: '{{csrf_token()}}',
                        _method: input_method
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
                    if (operation == 2) {
                        reset_form('main_menu_1', '', '', 1);
                        set_button_status(1, permission, 'fnc_menu_create', 1);
                    } else {
                        load_php_data_to_form(data.m_menu_id, 'tools/create_menu/get_data_by_id');
                    }
                    loadList();
                })
                .catch(error => {
                    showNotification(error, 'error');
                    console.error(error);
                });
        }
    }
    var permission = '{{$permission}}';


    function loadList(search = '') {
        var param = JSON.stringify({
            "search": search,
            "cbo_module_name": document.getElementById('cbo_module_name').value,
            'blade': 'create_menu_search_list_view'
        });
        show_list_view(param, 'tools/create_menu_search_list_view', 'search_div', '', '', '', 'list_view');
    }
    const load_php_data_to_form = (menuId, url) => {
        //toastr.success('Welcome to load_php_data_to_form !', 'Congrats');
        var base_url = getBaseUrl();
        var url = `${base_url}/${url}/${menuId}`;
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Do something with the response data
                try {
                    document.getElementById('cbo_module_name').value = data.m_module_id;
                    if (data.root_menu == 1) $('#chk_report_menu').attr('checked', true);
                    else $('#chk_report_menu').attr('checked', false);

                    document.getElementById('txt_menu_name').value = data.menu_name;
                    document.getElementById('txt_menu_link').value = data.f_location;
                    document.getElementById('cbo_root_menu').value = data.root_menu;
                    document.getElementById('cbo_root_menu_under').value = data.sub_root_menu;
                    document.getElementById('txt_menu_seq').value = data.slno;
                    document.getElementById('cbo_menu_sts').value = data.status;
                    document.getElementById('update_id').value = menuId;
                    document.getElementById('cbo_fabric_nature').value = data.fabric_nature;
                    console.log(`id = ${document.getElementById('update_id').value}`);

                    load_drop_down( 'load_drop_down',menuId+'**'+data.f_location, 'load_available_route', 'menu_link_div' );
                    set_button_status(1, permission, 'fnc_menu_create', 1);
                } catch (error) {
                    console.log(error);
                }
            })
            .catch(error => {
                //toastr.error(error, 'Oops!');
                console.log(error);
            });
    }
</script>
@endsection