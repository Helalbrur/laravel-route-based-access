<?php
$data=explode("_", $data);
?>
<table width="100%" height="123" border="0" cellpadding="0" cellspacing="2">
    <tr>
        <td height="29" colspan="2">
            <b style="visibility:hidden">Set Admin Priviledge for this Module</b>&nbsp;
            <input type="checkbox" style="visibility:hidden" name="admin_privilege_all" id="admin_privilege_all" value="1">
        </td>
        <td colspan="4" align="left">
            <input type="button" name="load_data" id="load_data" class="formbutton" value="Load Data" tabindex="10" onclick="show_list_view(document.getElementById('cbo_user_name').value+'_'+document.getElementById('cbo_main_module').value,'load_priv_list_view','load_list_priv','../tools/requires/user_priviledge_controller','')" />
        </td>
        <td colspan="3">Permission Level&nbsp;<?=create_drop_down( "cbo_set_module_privt", 162, mod_permission_type(),'', '', '',0 ); ?></td>
    </tr>
    <tr><td colspan="9" height="10"></td></tr>
    <tr>
        <th rowspan="2" style="border:thin solid #000000;">Menu Name</th>
        <th rowspan="2" style="border:thin solid #000000;">Sub Main Menu</th>
        <th rowspan="2" style="border:thin solid #000000;">Sub Menu Name</th>
        <th colspan="5" style="border:thin solid #000000;">Permission</th>
        <th rowspan="2" style="border:thin solid #000000;">Action<input type="hidden" name="update_id" id="update_id" /></th>
    </tr>
    <tr>
        <th style="border:thin solid #000000;">Visibility</th>
        <th style="border:thin solid #000000;">Insert</th>
        <th style="border:thin solid #000000;">Edit</th>
        <th style="border:thin solid #000000;">Delete</th>
        <th style="border:thin solid #000000;">Approve</th>
    </tr>
    <tr>
        <td><?=create_drop_down( "cbo_main_menu_name", 260, "select m_menu_id,menu_name from main_menu where position='1' and m_module_id='".$data[1]."' and status = 1 and status_active=1 and is_deleted=0 order by m_menu_id","m_menu_id,menu_name", 1, "-- Select Menu --", selected(), "load_drop_down( 'tools/root_menu_under', this.value+'_'+260, 'cbo_root_menu_under', 'subrootdiv' )" ); ?></td>
        <td id="subrootdiv"><?=create_drop_down( "cbo_sub_main_menu_name", 155, blank_array(),'', 1, '--- Select ---',1 ); ?></td>
        <td id="sub_subrootdiv"><?=create_drop_down( "cbo_sub_menu_name", 155, blank_array(),'', 1, '--- Select ---',1 ); ?></td>
        <td><?=create_drop_down( "cbo_visibility", 85, form_permission_type(),'', '', '',1 ); ?></td>
        <td><?=create_drop_down( "cbo_insert", 85, form_permission_type(),'', '', '',1 ); ?></td>
        <td><?=create_drop_down( "cbo_edit", 85, form_permission_type(),'', '', '',1 ); ?></td>
        <td><?=create_drop_down( "cbo_delete", 85, form_permission_type(),'', '', '',1 ); ?></td>
        <td><?=create_drop_down( "cbo_approve", 85, form_permission_type(),'', '', '',1 ); ?></td>
        <td><input type="hidden" id="update_id" /><input type="button" name="save" id="save" tabindex="11" class="formbutton" onclick="fnc_set_priviledge(0);" value="Set Priviledge" /></td>
    </tr>
    <tr><td colspan="9" style="padding-top:10px;" id="load_list_priv"></td></tr>
</table>
