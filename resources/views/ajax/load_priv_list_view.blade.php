<?php
$data=json_decode($data,true);
$user_id = $data["user_id"];
$module_id = $data["module_id"];

  
$sql= "SELECT a.menu_name,a.m_menu_id, b.show_priv,b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv,b.id FROM main_menu a, user_priv_mst b WHERE b.user_id='{$user_id}' AND a.m_module_id = '{$module_id}' AND a.m_menu_id = b.main_menu_id and a.status=1 and a.status_active=1 and a.is_deleted=0 ORDER BY main_menu_id ASC";
$result = sql_select($sql);
$sl = 1;
$form_permission_type = form_permission_type();
?>

<table class="table table-bordered table-striped" style="background-color:#F5FFFA;">
    <thead>
        <tr>
            <th width="7%">Sl</th>
            <th width="30%">Menu Name</th>
            <th width="12%">Visibility</th>
            <th width="12%">Insert</th>
            <th width="12%">Update</th>
            <th width="12%">Delete</th>
            <th >Approve</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        @foreach($result as $row)
            <tr id="tr_{{$sl}}"  style="cursor:pointer" >
                <td>{{$sl++}}</td>
                <td>{{$row[csf('menu_name')]}}</td>
                <td>{{$form_permission_type[$row[csf('show_priv')]]}}</td>
                <td>{{$form_permission_type[$row[csf('save_priv')]]}}</td>
                <td>{{$form_permission_type[$row[csf('edit_priv')]]}}</td>
                <td>{{$form_permission_type[$row[csf('delete_priv')]]}}</td>
                <td>{{$form_permission_type[$row[csf('approve_priv')]]}}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    setFilterGrid("list_view",-1);
</script>