@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 align-center"><strong>Company Profile</strong></h1>
        </div>
        <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
            </ol>
        </div> -->
    </div><!-- /.row -->
@endsection()
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                
                <div class="card-text">
                    <form name="mainmodule_1" id="mainmodule_1" autocomplete="off">
                        
                        <div class="form-group row">
                            <label for="cbo_group_name"  class="col-sm-2 col-form-label must_entry_caption">Group Name</label>
                            <div class="col-sm-4">
                                <select name="cbo_group_name" id="cbo_group_name" class="form-control">
                                    <option value="0">SELECT</option>
                                    <?php
                                        $groups = array();
                                    ?>
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="txt_company_name" class="col-sm-2 col-form-label must_entry_caption">Company Name</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_company_name" class="form-control" name="txt_company_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txt_company_short_name" class="col-sm-2 col-form-label must_entry_caption">Company Short Name</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_company_short_name" class="form-control" name="txt_company_short_name">
                            </div>
                            <label for="txt_email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" id="txt_email" class="form-control" name="txt_email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txt_website_name" class="col-sm-2 col-form-label">Website</label>
                            <div class="col-sm-4">
                                <input type="text" id="txt_website_name" class="form-control" name="txt_website_name">
                            </div>
                            <label for="txt_contact_no" class="col-sm-2 col-form-label">Contact No</label>
                            <div class="col-sm-4">
                                <input type="email" id="txt_contact_no" class="form-control" name="txt_contact_no">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txt_company_address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-6">
                                <input type="text" id="txt_company_address" class="form-control" name="txt_company_address">
                            </div>
                            <label for="txt_logo" class="col-sm-2 col-form-label">Logo</label>
                            <div class="col-sm-2">
                                <input type="file" id="txt_logo" class="form-control" name="txt_logo">
                            </div>
                        </div>
                        <div class="from-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                                <?php
                                    echo load_submit_buttons( $permission, "fnc_main_module", 0,0 ,"reset_form('mainmodule_1','','',1)");
                                ?>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-text"  id="list_view_div">
                    <input type="text" id="txt_search" class="form-control" style="width: 200px;" placeholder="Search" onkeyup="searchTableWithRowspan('list_view', 'txt_search')">
                        <table class="table table-bordered table-striped rpt_table" >
                            <thead>
                                <tr>
                                    <th width="3%">Sl</th>
                                    <th width="12%">Group Name</th>
                                    <th width="15%">Company Name</th>
                                    <th width="10%">Short Name</th>
                                    <th width="12%">Email</th>
                                    <th width="13%">Website</th>
                                    <th width="13%">Contact No</th>
                                    <th >Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //$companies = App\Models\Company::get();
                                    $companies = array();
                                ?>
                                @foreach($companies as $company)
                                    <tr>
                                        <td>{{++$sl}}</td>
                                        <td>{{$company->company_name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function fnc_main_module( operation )
    {
        if (form_validation('txt_module_name*txt_module_seq','Module Name*Module Sequence')==false)
        {
            return;
        }
        else
        {
            var method ="";
            if(operation==0)  method ="POST";
            else if(operation==1)  method ="PUT";
            else if(operation==2)  method ="DELETE";
            var param = "";
            if(operation == 1 || operation == 2)
            {
                param = `/${document.getElementById('update_id').value}`;
            }
            var data=get_submitted_data_string('txt_module_name*txt_module_link*txt_module_seq*cbo_module_sts*update_id');
            console.log(data);
            fetch(`/tools/create_main_module${param}`, {
                method: method ,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
                },
                body: JSON.stringify({
                    txt_module_name:$("#txt_module_name").val(),
                    txt_module_link:$("#txt_module_link").val(),
                    txt_module_seq:$("#txt_module_seq").val(),
                    cbo_module_sts:$("#cbo_module_sts").val(),
                    update_id:$("#update_id").val(),
                    hidden_m_mod_id:$("#hidden_m_mod_id").val(),
                    _token:'{{csrf_token()}}'
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                load_php_data_to_form(data.m_mod_id,'tools/create_main_module/get_data_by_id');
                show_list_view(0,'show_module_list_view','list_view_div','tools/show_module_list_view','setFilterGrid("list_view",-1)');
            })
            .catch(error => {
                console.error(error);
            });
        }
    }
    var permission ='{{$permission}}';
    const load_php_data_to_form = (menuId,url) =>{
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
                set_button_status(1, permission, 'fnc_main_module',1);
            })
            .catch(error => {
                //toastr.error(error, 'Oops!');
                console.log(error);
            });
    }
    setFilterGrid("list_view",-1);
</script>
@endsection
