<?php

use App\Models\UserPrivMst;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


function getPermissionBasedAllRoutes()
{
    $routes = collect(Route::getRoutes())->map(function ($route) {
        $middleware = $route->middleware();
        //dd($middleware);
        $permission = '';

        foreach ($middleware as $m) {
            if (preg_match('/^CheckPermission:(.*)$/', $m, $matches)) {
                $permission = $matches[1];
                break;
            }
        }

        return [
            'permission' => $permission,
            'route_name' => $route->getName(),
            'uri' => $route->uri(),
            'method' => implode('|', $route->methods()),
        ];
    })->filter(function($route){
        return (!empty($route['permission']) && ($route['route_name']!='permission.index' &&  $route['route_name']!='permission.store'));
    });
    return $routes;
}

function sql_select($query,$is_single_row="", $new_conn="", $un_buffered="", $connection="")
{
    $results = DB::select($query);
    $rows = array();
    foreach($results as $row)
    {
        $rows[] = (array) $row;
    }
    return $rows;
}

function csf($data) // checked 3
{
    global $db_type;
    if ($db_type == 0 || $db_type == 1) {
        return strtolower($data);
    } else {
        return strtoupper($data);
    }
}

function load_submit_buttons($permission, $sub_func, $is_update, $is_show_print = '', $refresh_function = '', $btn_id = "", $is_show_approve = "")
{
    $permission = explode('_', $permission);
    $perm_str = "";
    if ($btn_id == "") {
        $btn_id = 1;
    }

    if ($permission[0] == 1) // Insert
    {
        if ($is_update == 0) //Entry Mode
        {
            $perm_str = '<input type="button" value="Save" name="save" onclick="' . $sub_func . '(0)" style="width:80px" id="save' . $btn_id . '"   class="formbutton"/>&nbsp;&nbsp;';
        } else {
            $perm_str = '<input type="button" value="Save" name="save" onclick="show_button_disable_msg(0)" style="width:80px" id="save' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
        }

    } else {
        $perm_str = '<input type="button" value="Save" name="save" onclick="show_no_permission_msg(0)" style="width:80px" id="save' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
    }

    if ($permission[1] == 1) // Update
    {
        if ($is_update == 1) //Entry Mode
        {
            $perm_str .= '<input type="button" value="Update" name="update" onclick="' . $sub_func . '(1)" style="width:80px" id="update' . $btn_id . '"   class="formbutton"/>&nbsp;&nbsp;';
        } else {
            $perm_str .= '<input type="button" value="Update" name="update" onclick="show_button_disable_msg(1)" style="width:80px" id="update' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
        }

    } else {
        $perm_str .= '<input type="button" value="Update" name="update" onclick="show_no_permission_msg(1)" style="width:80px" id="update' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
    }

    if ($permission[2] == 1) // Delete
    {
        if ($is_update == 1) //Entry Mode
        {
            $perm_str .= '<input type="button" value="Delete" name="delete" onclick="' . $sub_func . '(2)" style="width:80px" id="Delete' . $btn_id . '"   class="formbutton"/>&nbsp;&nbsp;';
        } else {
            $perm_str .= '<input type="button" value="Delete" name="delete" onclick="show_button_disable_msg(2)" style="width:80px" id="Delete' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
        }

    } else {
        $perm_str .= '<input type="button" value="Delete" name="delete" onclick="show_no_permission_msg(2)" style="width:80px" id="Delete' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
    }

    $perm_str .= '<input type="button" value="Refresh" name="refresh" onclick="' . $refresh_function . '" style="width:80px" id="Refresh' . $btn_id . '"   class="formbutton"/>&nbsp;&nbsp;</br><hr style="height:8px;">';

    if ($is_show_approve == 1) {
        if ($permission[3] == 1) {
            if ($is_update == 1) //Entry Mode
            {
                $perm_str .= '<input type="button" value="Approve" name="approve" onclick="' . $sub_func . '(3)" style="width:80px" id="approve' . $btn_id . '"   class="formbutton"/>&nbsp;&nbsp;';
            } else {
                $perm_str .= '<input type="button" value="Approve" name="approve" onclick="show_button_disable_msg(3)" style="width:80px" id="approve' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
            }

        } else {
            $perm_str .= '<input type="button" value="Approve" name="approve" onclick="show_no_permission_msg(3)" style="width:80px; visibility:hidden" id="approve' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
        }

    }

    if ($is_show_print == 1) {
        if ($permission[4] == 1) {
            if ($is_update == 0) //Entry Mode
            {
                $perm_str .= '<input type="button" value="Print" name="print" onclick="' . $sub_func . '(4)" style="width:80px" id="Print' . $btn_id . '"   class="formbutton"/>&nbsp;&nbsp;';
            } else {
                $perm_str .= '<input type="button" value="Print" name="print" onclick="show_button_disable_msg(4)" style="width:80px" id="Print' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
            }

        } else {
            $perm_str .= '<input type="button" value="Print" name="print" onclick="show_no_permission_msg(4)" style="width:80px" id="Print' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
        }

    } else {
        $perm_str .= '<input type="button" value="Print" name="print" onclick="show_button_disable_msg(4)" style="width:80px; visibility:hidden" id="Print' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
    }

    return $perm_str;die;
}

function getPagePermission($menu_id = '')
{
    $permission = "";
    DB::enableQueryLog();
    if(!empty($menu_id))
    {
        $userPermission = DB::table('main_menu as a')
                      ->join('user_priv_mst as b','a.m_menu_id','=','b.main_menu_id')
                      ->select('b.save_priv','b.edit_priv','b.delete_priv','b.approve_priv')
                      ->where('b.user_id',Auth::user()->id)
                      ->where('a.m_menu_id',$menu_id)->first();
    }
    else
    {
        /*
        $array = explode(".", Route::currentRouteName());
        // Get the subset of the array without the last element
        $subset = array_slice($array, 0,count($array)-1);
        $userPermission = DB::table('main_menu as a')
                      ->join('user_priv_mst as b','a.m_menu_id','=','b.main_menu_id')
                      ->select('b.save_priv','b.edit_priv','b.delete_priv','b.approve_priv')
                      ->where('b.user_id',Auth::user()->id)
                      ->where(function (Builder $query) use ($subset) {
                        $query->where('a.route_name', implode(".", $subset))
                        ->orWhere('a.f_location', Route::getCurrentRoute()->uri);
                      })
                      ->first();
                     // ->ddRawSql();
        */
        $userPermission = DB::table('main_menu as a')
        ->join('user_priv_mst as b','a.m_menu_id','=','b.main_menu_id')
        ->select('b.save_priv','b.edit_priv','b.delete_priv','b.approve_priv')
        ->where('b.user_id',Auth::user()->id)
        ->where('a.f_location', Route::getCurrentRoute()->uri)
        ->first();
    }
    //dd(DB::getQueryLog());
    //dd($userPermission);

    if(isset($userPermission)) $permission = $userPermission->save_priv. "_" .$userPermission->edit_priv. "_" .$userPermission->delete_priv . "_" . $userPermission->approve_priv;
    return $permission;
}

function fn_number_format($val, $after_point = 0, $dot = '', $null = '')
{
    if (is_nan($val) || is_infinite($val)) {return '';} else if ($dot == '') {return number_format($val, $after_point);} else {return number_format($val, $after_point, $dot, $null);}
}

function return_library_array($query, $id_fld_name, $data_fld_name, $new_conn = "")
{
    /*$query=explode("where", $query);
    $nameArray=sql_select( $query[0] );*/
    $new_array = array();
    $nameArray = sql_select($query);
    foreach ($nameArray as $result) {

        if ($result[csf($data_fld_name)] == "MnS") {
            $result[csf($data_fld_name)] = "M&S";
        } else if ($result[csf($data_fld_name)] == "HnM") {
            $result[csf($data_fld_name)] = "H&M";
        } else if ($result[csf($data_fld_name)] == "CnA") {
            $result[csf($data_fld_name)] = "C&A";
        }

        $new_array[$result[csf($id_fld_name)]] = $result[csf($data_fld_name)];
    }
    return $new_array;
}

function change_date_format($date, $new_format = "", $new_sep = "", $on_save = "")
{
    //This function will return newly formatted date String
    // uses  --> echo change_date_format($date,"dd-mm-yyyy","/")
    global $db_type;

    if ($new_sep == "") {
        $new_sep = "-";
    }

    if ($new_format == "") {
        $new_format = "dd-mm-yyyy";
    }

    //if ($date=="" || $date=="0000-00-00") $date="0000-00-00";
    if ($date == "0000-00-00" || $date == "" || $date == 0) {
        return "";
    }

    if ($db_type == 2) {
        if ($date == "0000-00-00" || $date == "" || $date == 0) {
            return "";
        }

        if ($on_save == 0) {
            return date("d-m-Y", strtotime($date));
        } else {
            return date("d-M-Y", strtotime($date));
        }

    }
    $year = date("Y", strtotime($date));
    $mon = date("m", strtotime($date));
    $day = date("d", strtotime($date));

    if ($new_format == "yyyy-mm-dd") // yyyy-mm-dd
    {
        $dd = $year . $new_sep . $mon . $new_sep . $day;
    } else if ($new_format == "dd-mm-yyyy") // dd-mm-yyyy
    {
        $dd = $day . $new_sep . $mon . $new_sep . $year;
    }

    if ($db_type == 0 || $db_type == 1) {
        if ($dd == "1970-01-01" || $dd == "01-01-1970" || $dd == "30-11--0001") {
            return "";
        } else {
            return $dd;
        }
    } else
    if ($dd == "1970-01-01" || $dd == "01-01-1970" || $dd == "30-11--0001") {
        return "";
    } else {
        return date("Y-M-d", strtotime($dd));
    }

    //die;
}

function get_split_length($str, $width)
{
    if ($width == "" || $width == 0) {
        $width = 300;
    }

    $str_w = strlen($str) * 9;

    if ($str_w < $width) {
        return $width;
    } else // if ($str_w<$width)
    {
        return round($width / 10);
    }
}

function create_drop_down($field_id, $field_width, $query, $field_list, $show_select, $select_text_msg = "", $selected_index = "", $onchange_func = "", $is_disabled = "", $array_index = "", $fixed_options = "", $fixed_values = "", $not_show_array_index = "", $tab_index = "", $new_conn = "", $field_name = "", $additionalClass = "", $additionalAttributes = "")
{

    //$drop_down_loader_data=$field_id."*".$field_width."*".$query."*".$field_list."*".$show_select."*".$select_text_msg."*".$selected_index."*".$onchange_func."*". $onchange_func_param_db."*".$onchange_func_param_sttc."*".$add_new_page_lnk."*".$div_id;
    if ($is_disabled == 1) {
        $is_disabled = "disabled";
    } else {
        $is_disabled = "";
    }

    if ($tab_index != "") {
        $tab_index = 'tabindex="' . $tab_index . '"';
    } else {
        $tab_index = "";
    }

    if ($selected_index == "") {
        $selected_index = '0';
    }

    $field_list = explode(",", $field_list);

    $drop_down = '<select ' . $tab_index . ' name="' . ($field_name == "" ? $field_id : $field_name) . '" id="' . $field_id . '" class="form-control ' . $additionalClass . '" ' . $is_disabled . '  style="width:' . $field_width . 'px" onchange="' . $onchange_func . '">\n';

    if ($show_select == 1) {
        $drop_down .= '<option data-attr="" value="0">' . $select_text_msg . '</option>\n';
    }
    if ($fixed_options != "") {
        $fixed_options = explode("*", $fixed_options);
        $fixed_values = explode("*", $fixed_values);
        for ($kk = 0; $kk < count($fixed_options); $kk++) {
            $drop_down .= '<option data-attr="" value="' . $fixed_values[$kk] . ' ">' . $fixed_options[$kk] . '</option>\n';
        }
    }
    $addattr = explode(",", $additionalAttributes);

    if (!is_array($query)) {
        $nameArray = sql_select($query, '', $new_conn);

        foreach ($nameArray as $result) {
            //if(count($nameArray)==1) $selected_index=$result[csf($field_list[0])];
            $attdata = '';
            $m = 0;
            foreach ($addattr as $ak) {
                if(!empty($field_list[$ak]))
                {
                    if ($m == 0) {
                        $attdata = $result[csf($field_list[$ak])];
                    } else {
                        $attdata .= "**" . $result[csf($field_list[$ak])];
                    }
                    $m++;
                }
            }

            $drop_down .= '<option data-attr="' . $attdata . '" value="' . $result[csf($field_list[0])] . '" ';
            if ($selected_index == $result[csf($field_list[0])]) {$drop_down .= 'selected';}
            $drop_down .= '>' . $result[csf($field_list[1])] . '</option>\n';
        }
    } else // List from An Array
    {
        if ($array_index == "") {
            $array_index = "";
        } else {
            $array_index = explode(",", $array_index);
        }

        if ($not_show_array_index == "") {
            $not_show_array_index = "";
        } else {
            $not_show_array_index = explode(",", $not_show_array_index);
        }

        foreach ($query as $key => $value):
            if ($array_index == "") {
                if ($not_show_array_index == "") {
                    $drop_down .= '<option value="' . $key . '" ';
                    if ($selected_index == $key) {$drop_down .= 'selected';}
                    $drop_down .= '>' . $value . '</option>\n';
                } else {
                    if (!in_array($key, $not_show_array_index)) {
                        $drop_down .= '<option value="' . $key . '" ';
                        if ($selected_index == $key) {$drop_down .= 'selected';}
                        $drop_down .= '>' . $value . '</option>\n';
                    }
                }
            } else {
                if (in_array($key, $array_index)) {
                    if ($not_show_array_index == "") {
                        $drop_down .= '<option value="' . $key . '" ';
                        if ($selected_index == $key) {$drop_down .= 'selected';}
                        $drop_down .= '>' . $value . '</option>\n';
                    } else {
                        if (!in_array($key, $not_show_array_index)) {
                            $drop_down .= '<option value="' . $key . '" ';
                            if ($selected_index == $key) {$drop_down .= 'selected';}
                            $drop_down .= '>' . $value . '</option>\n';
                        }
                    }
                }
            }
        endforeach;
    }
    /*
    if($add_new_page_lnk!="")
    {
    $drop_down .='<option value="N">-- Add New --</option>\n';
     */
    $drop_down .= '</select>';
    /*
    if( $_SESSION['logic_erp']["user_level"]==2 )
    {
    if($add_new_page_lnk!="")
    {
    $add_new_page_fnc="add_new_library('".$drop_down_loader_data."','".$add_new_page_lnk."','".$div_id."')";
    $drop_down .='&nbsp;&nbsp; <img src="../../images/add_new.gif" width="27" height="17" onclick="'.$add_new_page_fnc.'"/> ';
    }
     */
    return $drop_down;
    die;
}



function create_list_view($table_id, $tbl_header_arr, $td_width_arr, $tbl_width, $tbl_height, $tbl_border, $query, $onclick_fnc_name, $onclick_fnc_param_db_arr, $onclick_fnc_param_sttc_arr, $show_sl, $field_printed_from_array_arr, $data_array_name_arr, $qry_field_list_array, $controller_file_path = '', $filter_grid_fnc = "", $fld_type_arr = "", $summary_flds = "", $check_box_all = "", $new_conn = "")
{
    $tbl_width = $tbl_width + 10;
    //$fld_type_arr Definition 0=string,1=integer,2=float,3=date, 4=3 digit,5=4 digit,5=5 digit
    $table_id = explode(",", $table_id);
    $tbl_header = explode(',', $tbl_header_arr);
    $td_width = explode(',', $td_width_arr);
    $onclick_fnc_param_db = explode(',', $onclick_fnc_param_db_arr);

    $field_printed_from_array = explode(',', $field_printed_from_array_arr);
    $data_array_name = count($data_array_name_arr);
    $qry_field_list = explode(',', $qry_field_list_array);

    $fld_type_arr = explode(',', $fld_type_arr);
    if ($summary_flds != "") {
        $summary_flds = explode(',', $summary_flds);
        $summary_total = array();} else {
        $summary_flds = array();
    }

    $nameArray = sql_select($query);
   // dd($nameArray);
    //return  $nameArray;

    $table_id1 = "";
    if(count($table_id)>1) $table_id1 = $table_id[1];

    $table_id0 = "";
    if(count($table_id)>0) $table_id0 = $table_id[0];

    $table = '<div><table width="' . $tbl_width . '" cellpadding="0" cellspacing="0" border="' . $tbl_border . '" class="rpt_table" id="rpt_table' .$table_id0. '" rules="all"><thead><tr>';

    if ($show_sl == 1) {
        $table .= '<th width="50">SL No</th>';
    }

    for ($i = 0; $i < count($tbl_header); $i++) {
        if ($i < count($tbl_header) - 1) {
            $table .= '<th width="' . $td_width[$i] . '">' . $tbl_header[$i] . '</th>';
        } else {
            $table .= '<th>' . $tbl_header[$i] . '</th>';
        }

    }
    $table .= '</tr></thead></table>';
    //dd('h');
    //return $table;

    $tbl_width1 = $tbl_width + 18;
    $tbl_width = $tbl_width ;
    $table .= ' <div style="max-height:' . $tbl_height . 'px; width:' . $tbl_width1 . 'px; overflow-y:scroll" id="' . $table_id1. '"><table width="' . $tbl_width . '" height="" cellpadding="0" cellspacing="0" border="' . $tbl_border . '" style="" class="rpt_table" id="' . $table_id0 . '" rules="all"><tbody>';
    $j = 0;

    if ($controller_file_path == "") {
        $controller_file_path = "";
    } else {
        $controller_file_path = ",'" . $controller_file_path . "'";
    }

    if ($onclick_fnc_param_sttc_arr == "") {
        $onclick_fnc_param_sttc_arr = "";
    } else {
        $onclick_fnc_param_sttc_arr = "," . $onclick_fnc_param_sttc_arr . "";
    }

    //return $table .= '</tbody></table></div>';

    foreach ($nameArray as $result) {
        $j++;
        if ($j % 2 == 0) {
            $bgcolor = "#E9F3FF";
        } else {
            $bgcolor = "#FFFFFF";
        }

        $db_param = "";

        //dd($onclick_fnc_param_db_arr);
        if ($onclick_fnc_param_db_arr != "")
        {
            if ($check_box_all != "") {
                $aid = $j . "_";
            } else {
                $aid = "";
            }
            //dd($onclick_fnc_param_db);
            for ($w = 0; $w < count($onclick_fnc_param_db); $w++)
            {
                if (count($onclick_fnc_param_db) < 2)
                {
                    $db_param .= "'" . $aid . $result[csf($onclick_fnc_param_db[$w])] . "'";
                }
                else
                {
                    if ($db_param == "")
                    {
                        $db_param .= "'" . $aid . $result[csf($onclick_fnc_param_db[$w])] . "";
                    }
                    else
                    {
                        $db_param .= "_" . $result[csf($onclick_fnc_param_db[$w])] . "";
                    }

                    if ($w == count($onclick_fnc_param_db) - 1)
                    {
                        $db_param .= "'";
                    }

                }
            }
        }
        else
        {
            $db_param = "";
            $onclick_fnc_param_sttc_arr = str_replace(",", "", $onclick_fnc_param_sttc_arr);
        }
        //return $controller_file_path;

        //$file_path="'".$file_path."'";
        $aid = "";

        if ($onclick_fnc_name != "")
        {
            $table .= '<tr height="20" onclick="' . $onclick_fnc_name . '(' . $db_param . '' . $onclick_fnc_param_sttc_arr . '' . $controller_file_path . ')" bgcolor="' . $bgcolor . '" style="cursor:pointer" id="tr_' . $j . '">';
        }
        else
        {
            $table .= '<tr height="20" bgcolor="' . $bgcolor . '" id="tr_' . $j . '">';
        }

        if ($show_sl == 1) {
            $table .= '<td width="50" >' . $j . '</td>';
        }

        //dd($qry_field_list);
        for ($i = 0; $i < count($qry_field_list); $i++)
        {
            $show_data = "";
            //dd($summary_flds);
            if (in_array($qry_field_list[$i], $summary_flds))
            {
                $summary_total[$qry_field_list[$i]] = $summary_total[$qry_field_list[$i]] + $result[csf($qry_field_list[$i])];
            }
            //dd($fld_type_arr);
            if( count($fld_type_arr)> $i)
            {
                if ($fld_type_arr[$i]== 0)
                {
                    $align = "align='left'";
                    $show_data = ($result[csf($qry_field_list[$i])]);
                } else if ($fld_type_arr[$i] == 1) {
                    $align = "align='right'";
                    $show_data = number_format($result[csf($qry_field_list[$i])], '0');
                } else if ($fld_type_arr[$i] == 2) {
                    $align = "align='right'";
                    $show_data = number_format($result[csf($qry_field_list[$i])], '2');
                } else if ($fld_type_arr[$i]== 3) {
                    $align = "align='left'";
                    $show_data = change_date_format($result[csf($qry_field_list[$i])]);
                } else if ($fld_type_arr[$i]  == 4) {
                    $align = "align='right'";
                    $show_data = number_format($result[csf($qry_field_list[$i])], '3');
                } else if ($fld_type_arr[$i] == 5) {
                    $align = "align='right'";
                    $show_data = number_format($result[csf($qry_field_list[$i])], '4');
                } else if ($fld_type_arr[$i] == 6) {
                    $align = "align='right'";
                    $show_data = number_format($result[csf($qry_field_list[$i])], '5');
                }
                else
                {
                    $align = "align='left'";
                    $show_data = ($result[csf($qry_field_list[$i])]);
                }
            }
            else
            {
                $align = "align='left'";
                $show_data = ($result[csf($qry_field_list[$i])]);
            }

            if ($i < count($qry_field_list) - 1)
            {
                //$split = get_split_length($data_array_name_arr[$i][$show_data] ?? "", $td_width[$i] ?? "");
                if ($field_printed_from_array[$i] == $qry_field_list[$i])
                {
                    $name_from_array = "";
                    if(!empty($data_array_name_arr[$i][$show_data]))
                    {
                        $name_from_array = $data_array_name_arr[$i][$show_data];
                    }
                    $table .= '<td ' . $align . ' width="' . $td_width[$i] . '"><p>' . $name_from_array . '</p></td>';
                }
                else
                {
                    //$split = get_split_length($show_data, $td_width[$i] ?? "");
                    $table .= '<td  ' . $align  . ' width="' . $td_width[$i]  . '"><p>' . $show_data . '</p></td>';
                }
            }
            else
            {
               // $split = get_split_length($data_array_name_arr[$i][$show_data] ?? "", $td_width[$i] ?? "");
              // dd($field_printed_from_array);
              //dd($qry_field_list);
               if ($field_printed_from_array[$i] == $qry_field_list[$i] )
                {
                    $table .= '<td ><p>' . $data_array_name_arr[$i][$show_data] . '</p></td>';
                    //$table .= '<td ><p>Helal</p></td>';
                }
                else
                {
                    //$split = get_split_length($show_data ?? "", $td_width[$i] ?? "");
                    $table .= '<td ' . $align . '><p>' . $show_data ?? "" . '</p></td>';
                }
            }
        }
        $table .= '</tr>';
    }
    $span = 0;
    if (is_array($summary_flds))
    {

        for ($i = 0; $i < count($summary_flds); $i++)
        {
            if ($i == 0)
            {
                $table .= '<tfoot><tr><th colspan="' . $summary_flds[$i] . '">Total</th>';
            }
            else
            {
                if ($summary_total[$summary_flds[$i]] != "" || $summary_total[$summary_flds[$i]] != 0)
                {
                    $tot = number_format($summary_total[$summary_flds[$i]], 2);
                }
                else
                {
                    $tot = "";
                }

                $table .= '<th colspan="' . $span . '" align="right">' . $tot . '</th>'; // $summary_total
            }

        }
        $table .= '</tr></tfoot>';
    }

    if (trim($filter_grid_fnc) != "")
    {
        $js = '<script>';
        $js .= ' ' . $filter_grid_fnc . ' ';
        $js .= '</script>';
    }
    else
    {
        $js = '';
    }

    if ($check_box_all != "")
    {
        $check = '<div class="check_all_container"><div style="width:100%">
		<div style="width:50%; float:left" align="left">
		<input type="checkbox" name="check_all" id="check_all" onClick="check_all_data()" /> Check / Uncheck All
		</div>
		<div style="width:50%; float:left" align="left">
		<input type="button" name="close" id="close"  onClick="parent.emailwindow.hide();" class="formbutton" value="Close" style="width:100px" />
		</div>
		</div></div>';
    }
    else
    {
        $check = "";
    }

    $table .= '</tbody></table></div>' . $check . '</div>' . $js;
    return $table;
    die;
}

function load_freeze_divs($img_path = '', $permission = "", $page_title_off = "", $on_qcf = false)
{
    if ($page_title_off == 1) {
        $title = "";
    } else {
        $title = $_SESSION['page_title'];
    }

    $html = '<div id="boxes">
		<div id="dialog" class="window" >
		<div id="msg" class="msg_header">0
		</div>
		<div style="width:400;padding:20px; height:150px; vertical-align:middle">
		<img src="{{asset(\'images/Loading2.gif\')}}" width="30" height="30" clear="all" style="vertical-align:middle;" /> <span id="msg_text" style="font-size:14px; color:#F00"> </span>
		</div>
		</div>
		<div id="mask"></div>
		</div>
		<div style="margin-top:10px; margin-bottom:10px;"> <input type="hidden" id="active_menu_id" value="' . $_SESSION['menu_id'] . '"><input type="hidden" id="active_module_id" value="' . $_SESSION['module_id'] . '"><input type="hidden" id="garments_nature" value="' . $_SESSION['fabric_nature'] . '"><input type="hidden" id="session_user_id" value="' . $_SESSION['logic_erp']['user_id'] . '">';
    if ($on_qcf == true) {
        $title = "Page On Qc";
        $style = 'style="color:red"';
    }

    if ($permission != "") {
        $html .= '<div ' . $style . ' class="form_caption" title="' . get_button_level_permission($permission) . '">' . $title . '</div>';
    } else {
        $html .= '<div ' . $style . ' class="form_caption"  >' . $title . '</div>';
    }

    $html .= '</div>';
    return $html;
}

function get_button_level_permission($permission)
{

    /*    Added By        :  Helal
    Date Added        :    01-04-2023

    This Function will Return a String with Permission Definition
    Uses            : echo get_button_level_permission($permission);
    */

    $permission = explode('_', $permission);
    $perm_str = "";
    if ($permission[0] == 1) {
        $perm_str = "New Entry permission. ";
    } else {
        $insert = "";
    }

    if ($permission[1] == 1) {
        $perm_str .= "Edit permission. ";
    } else {
        $perm_str .= "";
    }

    if ($permission[2] == 1) {
        $perm_str .= "Delete permission. ";
    } else {
        $perm_str .= "";
    }

    if ($permission[3] == 1) {
        $perm_str .= "Approval permission. ";
    } else {
        $perm_str .= "";
    }

    if ($permission[4] == 1) {
        $perm_str .= "Print permission. ";
    } else {
        $perm_str .= "";
    }

    return $perm_str; //die;
}

function execute_query( $strQuery, $commit="" )
{
	DB::unprepared($strQuery);
}

?>
