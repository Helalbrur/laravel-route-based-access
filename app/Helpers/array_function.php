<?php

function get_item_category()
{
    $item_category = return_library_array("select category_id, short_name from  lib_item_category_list where status_active=1 and is_deleted=0 order by short_name", "category_id", "short_name");
    return $item_category;
}

function get_row_status()
{
    $row_status = array(1 => "Active", 2 => "InActive", 3 => "Cancelled");
    return $row_status;
}

function row_status()
{
    return array(1 => "Active", 2 => "InActive", 3 => "Cancelled");
}

function mod_permission_type(){
    return array(0 => "Selective Permission", 1 => "Full Permission", 2 => "No Permission");
}

function selected()
{
    return 0;
}

function blank_array()
{
    return array();
}

function form_permission_type()
{
    return array(1 => "Permitted", 2 => "Not Permitted");
}
?>
