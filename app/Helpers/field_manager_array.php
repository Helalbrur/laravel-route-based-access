<?php

// This function will return page-wise array
function get_field_manager_arr($index)
{ 
    $field_arr = array();
    $field_manager_arr=field_manager_arr();
    if (isset($field_manager_arr[$index]))
    {
        foreach ($field_manager_arr[$index] as $key => $val)
        {
            $value = explode("_", $val);
            $i = 0;
            $str = '';
            foreach ($value as $k => $v)
            {
                if (count($value) == 1)
                {
                    $str = " " . ucwords(str_replace(array('cbo', 'txt'), '', $v));
                }
                else if ($i != 0)
                {
                    $str .= " " . ucwords($v);
                }
                $i++;
            }
            $field_arr[$key] = $str;
        }
    }

    return $field_arr;
}

function field_manager_arr()
{
    $field_manager_arr = array();
    $field_manager_arr[2][1] = "txt_email";
    $field_manager_arr[2][2] = "txt_website_name";
    $field_manager_arr[3][1] = "txt_item_group_code";
    $field_manager_arr[8][1] = "cbo_country_name";
    $field_manager_arr[9][1] = "cbo_tag_company_name";
    $field_manager_arr[9][2] = "cbo_tag_party_name";
    $field_manager_arr[10][1] = "cbo_tag_company_name";
    $field_manager_arr[10][2] = "cbo_tag_party_name";
    $field_manager_arr[11][1] = "cbo_buyer_id";
    $field_manager_arr[12][1] = "txt_previous_rate";
    $field_manager_arr[13][1] = "cbo_group_name";
    $field_manager_arr[13][2] = "cbo_sub_group_name";
    return $field_manager_arr;
}


?>
