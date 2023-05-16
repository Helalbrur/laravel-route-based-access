@extends('layouts.app')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 align-center">Permission Page</h1>
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

            <h5 class="card-title"></h5>
            <div class="card-text">
                <fieldset style="width:500px">
                    <form name="mainmodule_1" id="mainmodule_1" autocomplete="off">
                        <legend>Main Module</legend>
                        <table width="480">
                            <tr>
                                <td class="must_entry_caption">Main Module Name</td>
                                <td colspan="3">
                                    <input type="text" name="txt_module_name" id="txt_module_name" class="form-control" style="width:350px" />

                                </td>
                            </tr>
                            <tr>
                                <td>Main Module Link</td>
                                <td colspan="3"><input type="text" name="txt_module_link" id="txt_module_link" class="form-control" style="width:350px" /></td>
                            </tr>
                            <tr>
                                <td>Sequence</td>
                                <td>
                                    <input type="text" name="txt_module_seq" id="txt_module_seq" class="form-control" onKeyDown="javascript:checkKeycode(this.event,2)" style="width:100px" />
                                </td>
                                <td >Status</td>
                                <td>

                                    <?php
                                    $vissible_arr = array(1=>"Visible",2=>"Not visible");
                                    echo create_drop_down( "cbo_module_sts", 145, $vissible_arr,"", 1, "--Select--","","","","","","","","","","",""); ?>

                                </td>
                            </tr>
                            <tr>

                                <td align="center"  colspan="2" height="20">
                                </td>
                            </tr>
                            <tr>

                                <td align="center"  colspan="2">
                                    <input type="hidden" value="" name="update_id" id="update_id"/>
                                    <input type="hidden" value="" name="hidden_m_mod_id" id="hidden_m_mod_id"/>
                                    <?php
                                        echo load_submit_buttons( $permission, "fnc_main_module", 0,0 ,"reset_form('mainmodule_1','','',1)");
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
                <div style="width:650px; float:left; margin:auto;" align="center" id="list_view_div">
                    <fieldset style="width:650px">
                        <input type="text" id="txt_search" class="form-control" style="width: 200px;" placeholder="Search" onkeyup="searchTableWithRowspan('list_view', 'txt_search')">
                            <?php
                            $yes_no = array(1 => "Yes", 2 => "No");
                            $arr=array(3=>$yes_no);
                            echo  create_list_view ( "list_view", " Module Name,File Location,Sequence,Visiblity", "150,100,150","600","220",0, "select  main_module,file_name,mod_slno,status,m_mod_id from main_module order by mod_slno", "load_php_data_to_form", "m_mod_id", "", 1, "0,0,0,status", $arr , "main_module,file_name,mod_slno,status", "tools/create_main_module/get_data_by_id", 'setFilterGrid("list_view",-1);','0,0,0,0' ) ;
                        ?>

                    </fieldset>
                </div>
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
