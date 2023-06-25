@extends('layouts.app')
@section('content')
<?php $selected = 0; ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

            <h5 class="card-title"></h5>
            <div class="card-text">
                <fieldset style="width:500px">
                    <form name="mainmodule_1" id="mainmodule_1" autocomplete="off">
                        <legend>Menu Management</legend>
                        <table width="480">
                            <tr>
                                <td width="100" class="must_entry_caption">Main Module Name</td>
                                <td >
                                    <?php echo create_drop_down( "cbo_module_name", 150, "select m_mod_id, main_module from main_module where status=1 order by main_module","m_mod_id,main_module", 1, "-- Select Module --", '0', "" );
                                    //load_drop_down( 'requires/menu_create_controller', this.value, 'cbo_root_menu', 'root_menu_div' )
                                    ?>

                                </td>
                                <td width="100"> Approval Menu</td>
                                <td width="130"><input type="checkbox" id="chk_report_menu" name="chk_report_menu" ></td>
                            </tr>
                            <tr>
                                <td>Menu Name</td>
                                <td colspan="3"><input type="text" name="txt_menu_name" id="txt_menu_name" class="text_boxes" style="width:250px" /></td>
                            </tr>
                            <tr>
                                <td>Menu Link</td>
                                <td colspan="3"><input type="text" name="txt_menu_link" id="txt_menu_link" class="text_boxes" style="width:250px" /></td>
                            </tr>
                            <tr>
                                <td>Root Menu</td>
                                <td id="root_menu_div" colspan="3"><?php echo create_drop_down( "cbo_root_menu", 250, "select m_menu_id,menu_name from main_menu where position='1' order by menu_name","m_menu_id,menu_name", 1, "-- Select Menu Name --", $selected, "load_drop_down( 'tools/root_menu_under', this.value, 'tools/root_menu_under', 'subrootdiv' )" ); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Root Menu Under</td>
                                <td id="subrootdiv" colspan="3"><?php echo create_drop_down( "cbo_root_menu_under", 250, "select m_menu_id,menu_name from main_menu where position='2' order by menu_name","m_menu_id,menu_name", 1, "-- Select Menu Name --", $selected, "" ); ?></td>
                            </tr>
                            <tr>
                                <td>Product Nature</td>
                                <td id="subrootdiv" colspan="3"><?php echo create_drop_down( "cbo_fabric_nature", 250, get_item_category(),"", 1,"--All Fabrics--",$selected, "","","113" ); ?></td>
                            </tr>
                            <tr>
                                <td>Sequence</td>
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td>
                                                <input type="text" name="txt_menu_seq" id="txt_menu_seq" class="text_boxes_numeric" style="width:115px" />
                                            </td>
                                            <td>Status</td>
                                            <td><?php echo create_drop_down( "cbo_menu_sts", 103, get_row_status(),'', '', '', 1 ); ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td >

                                </td>
                            </tr>
                            <tr>
                                <td>Mobile Menu</td>
                                <td colspan="3"><input type="checkbox" id="chk_mobile_menu" name="chk_mobile_menu" ></td>
                            </tr>
                            <tr>
                                <td>Page Link</td>
                                <td colspan="3"><input type="text" name="txt_page_link" id="txt_page_link" class="text_boxes" style="width:238px" /></td>
                            </tr>
                            <tr>
                                <td>Page Short Name</td>
                                <td colspan="3"><input type="text" name="txt_short_name" id="txt_short_name" class="text_boxes" style="width:238px" /></td>
                            </tr>

                            <tr>

                                <td align="center"  colspan="4">
                                    <input type="hidden" value="" name="update_id" id="update_id"/>
                                    <input type="hidden" value="" name="hidden_m_mod_id" id="hidden_m_mod_id"/>
                                    <input type="hidden" value="" name="id" id="id"/>
                                    <?php
                                        echo load_submit_buttons( $permission, "fnc_menu_create", 0,0 ,"reset_form('mainmodule_1','','',1)");
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
                <div style="width:750px; float:left; margin:auto;" align="center" id="list_view_div">
                    <fieldset style="width:750px">
                        <input type="text" id="txt_search" class="form-control" style="width: 200px;" placeholder="Search" onkeyup="loadList(this.value)">
                        <div align="center" style="padding-top:10px;" id="search_div"></div>
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
    function fnc_menu_create( operation )
    {
        if (form_validation('cbo_module_name*txt_menu_name*txt_menu_seq*cbo_menu_sts','Module Name*Menu Name*Menu Sequence*Menu Status')==false)
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
                console.log(`param = ${param} and id = ${document.getElementById('update_id').value}`);
            }

            if( $("#chk_report_menu").attr("checked") ) var chk_report_menu=1; else var chk_report_menu=0;

		    if( $("#chk_mobile_menu").attr("checked") ) var chk_mobile_menu=1; else var chk_mobile_menu=0;

            fetch(`/tools/create_menu${param}`, {
                method: method ,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'// Add the CSRF token to the headers
                },
                body: JSON.stringify({
                    cbo_module_name:$("#cbo_module_name").val(),
                    cbo_root_menu:$("#cbo_root_menu").val(),
                    txt_menu_name:$("#txt_menu_name").val(),
                    txt_menu_link:$("#txt_menu_link").val(),
                    cbo_root_menu_under:$("#cbo_root_menu_under").val(),
                    txt_menu_seq:$("#txt_menu_seq").val(),
                    txt_page_link:$("#txt_page_link").val(),
                    txt_short_name:$("#txt_short_name").val(),
                    cbo_menu_sts:$("#cbo_menu_sts").val(),
                    cbo_fabric_nature:$("#cbo_fabric_nature").val(),
                    update_id:$("#update_id").val(),
                    chk_report_menu:chk_report_menu,
                    chk_mobile_menu:chk_mobile_menu,
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
                showNotification(operation_success_msg[operation]);
                load_php_data_to_form(data.m_menu_id,'tools/create_menu/get_data_by_id');
                loadList();
            })
            .catch(error => {
                showNotification(error,'error');
                console.error(error);
            });
        }
    }
    var permission ='{{$permission}}';


    function loadList(search='')
    {
        show_list_view (search+'_'+document.getElementById('cbo_module_name').value, 'create_menu_search_list_view', 'search_div', '/tools/create_menu_search_list_view', '','','list_view');
    }
    const load_php_data_to_form = (menuId,url) =>{
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
                    if(data.root_menu==1) $('#chk_report_menu').attr('checked',true);
                    else  $('#chk_report_menu').attr('checked',false);

                    document.getElementById('txt_menu_name').value = data.menu_name;
                    document.getElementById('txt_menu_link').value = data.f_location;
                    document.getElementById('cbo_root_menu').value = data.root_menu;
                    document.getElementById('cbo_root_menu_under').value = data.sub_root_menu;
                    document.getElementById('txt_menu_seq').value = data.slno;
                    document.getElementById('cbo_menu_sts').value = data.status;
                    document.getElementById('update_id').value = menuId;
                    document.getElementById('cbo_fabric_nature').value = data.fabric_nature;
                    console.log(`id = ${document.getElementById('update_id').value}`);
                    set_button_status(1, permission, 'fnc_menu_create',1);
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
