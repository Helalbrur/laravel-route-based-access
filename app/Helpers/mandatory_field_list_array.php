<?php

// This function will return page-wise array
function get_fieldlevel_arr($index)
{ 
    $field_arr = array();
    $fieldlevel_arr=fieldlevel_arr();
    if (isset($fieldlevel_arr[$index]))
    {
        foreach ($fieldlevel_arr[$index] as $key => $val)
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

function fieldlevel_arr()
{
    $fieldlevel_arr = array();
    $fieldlevel_arr[3][1] = "txt_item_group_code";
    $fieldlevel_arr[8][1] = "cbo_country_name";
    return $fieldlevel_arr;
}


?>
