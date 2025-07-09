<?php

use App\Models\Company;
use App\Models\LibLocation;
use App\Models\UserPrivMst;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Database\Query\Builder;


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

function sql_select($query, $is_single_row = false)
{
    $results = DB::select($query);
    $rows = array_map(fn($row) => (array) $row, $results);

    return $is_single_row && !empty($rows) ? $rows[0] : $rows;
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

function load_submit_buttons($permission, $sub_func, $is_update, $is_show_print = '', $refresh_function = '', $btn_id = "", $is_show_approve = "",$is_single_button = 0)
{
    $permission = explode('_', $permission ?? '0_0_0_0');
    
    $perm_str = "";
    if ($btn_id == "") {
        $btn_id = 1;
    }

    if ($permission[0] == 1) // Insert
    {
        if ($is_update == 0) //Entry Mode
        {
            $perm_str = '<button type="button" onclick="' . $sub_func . '(0)"  id="save' . $btn_id . '"   class="formbutton btn btn-success waves-effect btn-label waves-light"><i class="bx bx-save label-icon"></i> Save</button>&nbsp;&nbsp;';
        } else {
            $perm_str = '<button type="button" onclick="show_button_disable_msg(0)" id="save' . $btn_id . '"  class="formbutton_disabled btn btn-success waves-effect btn-label waves-light"><i class="bx bx-save label-icon"></i> Save</button>&nbsp;&nbsp;';
        }

    } else {
        $perm_str = '<button type="button" onclick="show_no_permission_msg(0)" id="save' . $btn_id . '"  class="formbutton_disabled btn btn-success waves-effect btn-label waves-light"><i class="bx bx-save label-icon"></i> Save</button>&nbsp;&nbsp;';
    }

    if($is_single_button == 0)
    {
        if ($permission[1] == 1) // Update
        {
            if ($is_update == 1) //Entry Mode
            {
                $perm_str .= '<button type="button" onclick="' . $sub_func . '(1)" id="update' . $btn_id . '"   class="formbutton btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-edit  label-icon"></i> Update</button>&nbsp;&nbsp;';
            } else {
                $perm_str .= '<button type="button" onclick="show_button_disable_msg(1)" id="update' . $btn_id . '"  class="formbutton_disabled btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-edit  label-icon"></i> Update</button>&nbsp;&nbsp;';
            }
    
        } else {
            $perm_str .= '<button type="button" onclick="show_no_permission_msg(1)" id="update' . $btn_id . '"  class="formbutton_disabled btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-edit  label-icon"></i> Update</button>&nbsp;&nbsp;';
        }
    
        if ($permission[2] == 1) // Delete
        {
            if ($is_update == 1) //Entry Mode
            {
                $perm_str .= '<button type="button" onclick="' . $sub_func . '(2)" id="Delete' . $btn_id . '"   class="formbutton btn btn-danger waves-effect btn-label waves-light"><i class="bx bxs-trash  label-icon"></i> Delete</button>&nbsp;&nbsp;';
            } else {
                $perm_str .= '<button type="button" onclick="show_button_disable_msg(2)" id="Delete' . $btn_id . '"  class="formbutton_disabled btn btn-danger waves-effect btn-label waves-light"><i class="bx bxs-trash  label-icon"></i> Delete</button>&nbsp;&nbsp;';
            }
    
        } else {
            $perm_str .= '<button type="button" onclick="show_no_permission_msg(2)" id="Delete' . $btn_id . '"  class="formbutton_disabled btn btn-danger waves-effect btn-label waves-light"><i class="bx bxs-trash  label-icon"></i> Delete</button>&nbsp;&nbsp;';
        }
    
        $perm_str .= '<button type="button" onclick="' . $refresh_function . '" id="Refresh' . $btn_id . '"   class="formbutton btn btn-warning waves-effect btn-label waves-light"><i class="bx bx-sync   label-icon"></i> Refresh</button>&nbsp;&nbsp;</br><hr style="height:8px;">';
    
        if ($is_show_approve == 1) {
            if ($permission[3] == 1) {
                if ($is_update == 1) //Entry Mode
                {
                    $perm_str .= '<button type="button" value="Approve" name="approve" onclick="' . $sub_func . '(3)" id="approve' . $btn_id . '"   class="formbutton"/>&nbsp;&nbsp;';
                } else {
                    $perm_str .= '<button type="button" value="Approve" name="approve" onclick="show_button_disable_msg(3)" id="approve' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
                }
    
            } else {
                $perm_str .= '<button type="button" value="Approve" name="approve" onclick="show_no_permission_msg(3)" style="width:80px; visibility:hidden" id="approve' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
            }
    
        }
    
        if ($is_show_print == 1) {
            if ($permission[4] == 1) {
                if ($is_update == 0) //Entry Mode
                {
                    $perm_str .= '<button type="button" value="Print" name="print" onclick="' . $sub_func . '(4)" id="Print' . $btn_id . '"   class="formbutton"/>&nbsp;&nbsp;';
                } else {
                    $perm_str .= '<button type="button" value="Print" name="print" onclick="show_button_disable_msg(4)" id="Print' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
                }
    
            } else {
                $perm_str .= '<button type="button" value="Print" name="print" onclick="show_no_permission_msg(4)" id="Print' . $btn_id . '"   class="formbutton_disabled"/>&nbsp;&nbsp;';
            }
    
        } else {
            $perm_str .= '<button type="button" onclick="show_button_disable_msg(4)" style="width:80px; visibility:hidden" id="Print' . $btn_id . '"   class="formbutton_disabled"> Print</button>&nbsp;&nbsp;';
        }
    }
    return $perm_str;die;
}

function getPagePermission($menu_id)
{
    $permission = "";
    DB::enableQueryLog();
   
        /*
         $userPermission = DB::table('main_menu as a')
                      ->join('user_priv_mst as b','a.m_menu_id','=','b.main_menu_id')
                      ->select('b.save_priv','b.edit_priv','b.delete_priv','b.approve_priv')
                      ->where('b.user_id',Auth::user()->id)
                      ->where('a.m_menu_id',$menu_id)->first();

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
        ->where('a.m_menu_id',$menu_id)
        ->first();
    //dd(DB::getQueryLog());
    //dd($userPermission);

    if(isset($userPermission)) return $permission = $userPermission->save_priv. "_" .$userPermission->edit_priv. "_" .$userPermission->delete_priv . "_" . $userPermission->approve_priv;
    return null;
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

function create_drop_down($field_id, $field_width, $query, $field_list, $show_select, $select_text_msg = "", $selected_index = "", $onchange_func = "", $is_disabled = "", $array_index = "", $fixed_options = "", $fixed_values = "", $not_show_array_index = "", $tab_index = "", $new_conn = "", $field_name = "", $additionalClass = "", $additionalAttributes = "",$is_multiple=0)
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
    if($field_width != "100%") $field_width = $field_width."px";

    $multiple = "";
    if($is_multiple == 1) {
        $multiple = 'multiple="multiple[]" ';
    }

    $drop_down = '<select ' . $tab_index . ' ' . $multiple . ' name="' . ($field_name == "" ? $field_id : $field_name) . '" id="' . $field_id . '" class="form-control ' . $additionalClass . '" ' . $is_disabled . '  style="width:' . $field_width . '" onchange="' . $onchange_func . '">\n';

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

    $table = '<div><table width="' . $tbl_width . '" cellpadding="0" cellspacing="0" border="' . $tbl_border . '" class="table table-striped table-bordered" id="rpt_table' . $table_id0 . '" rules="all" style="margin-bottom: 0; background-color:#f1f1f1;"><thead><tr>';

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
            $bgcolor = "#f0f0f0";
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
                else if ($fld_type_arr[$i] == 7)
                {
                    $align = "align='center'";
                    $show_data = ($result[csf($qry_field_list[$i])]);
                }
                else
                {
                    $align = "align='center'";
                    $show_data = ($result[csf($qry_field_list[$i])]);
                }
            }
            else
            {
                $align = "align='center'";
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
		<div style="margin-top:10px; margin-bottom:10px;"> <input type="hidden" id="active_menu_id" value="' . $_SESSION['menu_id'] . '"><input type="hidden" id="active_module_id" value="' . $_SESSION['module_id'] . '"><input type="hidden" id="garments_nature" value="' . $_SESSION['fabric_nature'] . '"><input type="hidden" id="session_user_id" value="' . Auth::user()->id ?? '' . '">';
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

function getMenuName($menu_id)
{  
    $menu = DB::table('main_menu')
        ->where('f_location', Route::getCurrentRoute()->uri)
        ->where('m_menu_id',$menu_id)
        ->first();
    if(!empty($menu->menu_name)) return $menu->menu_name;
    return null;
}

function bn2en($number)
{
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    return str_replace($bn, $en, $number);
}

function en2bn($number)
{
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    return str_replace($en, $bn, $number);
}

function getTotalDay($month,$year)
{

    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

function getDayNUmber($date1,$date2)
{
    $datetime1 = date_create($date1);
    $datetime2 = date_create($date2);
    $interval = date_diff($datetime1, $datetime2);
    return $interval->days;
}

function executeTime()
{
    return (microtime(true) - $_SERVER['REQUEST_TIME']);
}
function get_ip_mac($trace)
{
    ob_start();
    system($trace . ' -h 2' . " yahoo.com");
    $trace = ob_get_contents();
    ob_clean();
    $lines = explode("\n", $trace);
    $lines = explode(" ", $lines[5]);

    foreach ($lines as $line) {
        if (strlen(trim($line)) > 5) {
            $proxy_address = $line;
        }
    }

    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $macAddr = "";

    #run the external command, break output into lines
    ob_start();
    system('arp -a ' . $ipAddress);
    $arp = ob_get_contents();
    ob_clean();
    $lines = explode("\n", $arp);

    #look for the output line describing our IP address
    foreach ($lines as $line) {
        $cols = preg_split('/\s+/', trim($line));
        if ($cols[0] == $ipAddress) {
            $macAddr = $cols[1];
        }
    }
    //return trim($ipAddress)."__".strtoupper(trim($macAddr))."__".trim($proxy_address);
    return trim($proxy_address);
    //echo strtoupper($macAddr)."--".$ipAddress."--".$proxy_address;
}

function add_time($event_time, $event_length)
{
    //This function will return new time after adding a given value with a given time
    // Here $event_time= Time ,$event_length= integer Minutes
    // uses  --> add_time($event_time,50)

    $timestamp = strtotime("$event_time");
    $etime = strtotime("+$event_length minutes", $timestamp);
    $etime = date('H:i:s', $etime);
    return $etime;
}

function add_date($orgDate, $days)
{
    $cd = strtotime($orgDate);
    $retDAY = date('Y-m-d', mktime(0, 0, 0, date('m', $cd), date('d', $cd) + $days, date('Y', $cd)));
    return $retDAY;
}

function GetDays($sStartDate, $sEndDate)
{
    // Retrun array of days

    $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
    $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));

    $aDays[] = $sStartDate;

    $sCurrentDate = $sStartDate;
    while ($sCurrentDate < $sEndDate) {
        $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
        $aDays[] = $sCurrentDate;
    }
    return $aDays;
}

// interval: day or month or year or ........
function datediff($interval, $datefrom, $dateto, $using_timestamps = false)
{
    if ($datefrom != "" and $dateto != "") {
        if (!$using_timestamps) {
            $datefrom = strtotime($datefrom, 0);
            $dateto = strtotime($dateto, 0);
        }
        $difference = $dateto - $datefrom; // Difference in seconds
        switch ($interval) {
            case 'yyyy': // Number of full years
                $years_difference = floor($difference / 31536000);
                if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom) + $years_difference) > $dateto) {
                    $years_difference--;
                }
                if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto) - ($years_difference + 1)) > $datefrom) {
                    $years_difference++;
                }
                $datediff = $years_difference;
                break;
            case "q": // Number of full quarters
                $quarters_difference = floor($difference / 8035200);
                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($quarters_difference * 3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $quarters_difference++;
                }
                $quarters_difference--;
                $datediff = $quarters_difference;
                break;
            case "m": // Number of full months
                $months_difference = floor($difference / 2678400);
                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }
                //$months_difference--;
                $datediff = $months_difference;
                break;
            case 'y': // Difference between day numbers
                $datediff = date("z", $dateto) - date("z", $datefrom);
                break;
            case "d": // Number of full days
                $datediff = (floor($difference / 86400) + 1);
                break;
            case "w": // Number of full weekdays
                $days_difference = floor($difference / 86400);
                $weeks_difference = floor($days_difference / 7); // Complete weeks
                $first_day = date("w", $datefrom);
                $days_remainder = floor($days_difference % 7);
                $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
                if ($odd_days > 7) {
                    $days_remainder--;
                }
                // Sunday
                if ($odd_days > 6) {
                    $days_remainder--;
                }
                // Saturday
                $datediff = ($weeks_difference * 5) + $days_remainder;
                break;
            case "ww": // Number of full weeks
                $datediff = floor($difference / 604800);
                break;
            case "h": // Number of full hours
                $datediff = floor($difference / 3600);
                break;
            case "n": // Number of full minutes
                $datediff = floor($difference / 60);
                break;
            default: // Number of full seconds (default)
                $datediff = $difference;
                break;
        }
        return $datediff;
    }
}

function number_to_words($number = '', $full_unit = '', $half_unit = "")
{
    // This function returns amount in word
    // uses :: echo number_to_words("55555555250", "USD", "CENTS");
    $number = str_replace(",", "", $number);
    if (($number < 0) || ($number > 99999999999)) {
        throw new Exception("Number is out of range");
    }
    $number = explode('.', $number);
    if ($number[1] == "" || $number == 0) {
        $result1 = " " . $full_unit;
        $number = $number[0];
    } else {
        $number[1] = str_pad($number[1], 2, "0", STR_PAD_RIGHT);
        $result1 = " " . $full_unit . " and " . number_to_words($number[1]) . " " . $half_unit;
        $number = $number[0];
    }

    $Cn = floor($number / 10000000); /* Crore (giga) */
    $number -= $Cn * 10000000;

    // $Gn = floor($number / 1000000);  /* Millions (giga) */
    //$number -= $Gn * 1000000;

    $Ln = floor($number / 100000); /* Lacs (giga) */
    $number -= $Ln * 100000;

    $kn = floor($number / 1000); /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100); /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10); /* Tens (deca) */
    $n = $number % 10; /* Ones */

    $result = "";
    if ($Cn) {$result .= number_to_words($Cn) . " Crore ";}

    /* if ($Gn)
    {  $result .= number_to_words($Gn) . " Million ";  }
     */
    if ($Ln) {$result .= number_to_words($Ln) . " Lac ";}

    if ($kn) {$result .= (empty($result) ? "" : " ") . number_to_words($kn) . " Thousand ";}

    if ($Hn) {$result .= (empty($result) ? "" : " ") . number_to_words($Hn) . " Hundred ";}

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty",
        "Seventy", "Eighty", "Ninety");

    if ($Dn || $n) {
        /*if (!empty($result)) {
        $result .= " and ";
        }*/

        if ($Dn < 2) {
            $result .= $ones[$Dn * 10 + $n];
        } else {
            $result .= $tens[$Dn];
            if ($n) {
                $result .= "-" . $ones[$n];
            }
        }
    }

    if (empty($result)) {$result = "Zero";}

    return "$result " . " $result1";
}

function load_month_buttons($show_year = 0)
{
    $month_year="";
    if ($show_year == 1) {
        $month_year = create_drop_down("cbo_year_selection", 65, get_all_year(), "", 0, "-- --", date("Y", time()), "", 0, "");
    }
    $month_btn ="";
    for ($i = 1; $i < 13; $i++) {
        if ($i < 10) {
            $j = "0" . $i;
        } else {
            $j = $i;
        }

        $month_btn .= '<input type="button" name="btn_' . $i . '" style="width:50px;" onclick="set_date_range(\'' . $j . '\')" id="btn_' . $i . '" value="' . getMonth($i). '" class="month_button" />&nbsp;&nbsp;';
    }
    return $month_year . "&nbsp;&nbsp;" . $month_btn;die;
}
function getMonth($month) {
    $months = array(1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7 => 'July',8 => 'August',9 => 'September',10 => 'October',11 => 'November',12 => 'December');
    return $months[$month];
}

function get_available_route($menu_id = null)
{

    if(!empty($menu_id)){
        $existingRoutes = DB::table('main_menu')
        ->where('is_deleted', 0)
        ->where('m_menu_id','!=' ,$menu_id)
        ->pluck('f_location') // Fetch only 'f_location' column
        ->toArray(); // Convert collection to an array
    }
    else
    {
        $existingRoutes = DB::table('main_menu')
        ->where('is_deleted', 0)
        ->pluck('f_location') // Fetch only 'f_location' column
        ->toArray(); // Convert collection to an array
    }
   

    // Get all Laravel routes, but keep only GET requests
    $routes = collect(Route::getRoutes())->filter(function ($route) {
        return in_array('GET', $route->methods()); // Keep only GET routes
    })->map(function ($route) {
        return $route->uri();
    })->unique()->values();

    // Extract base route names (remove leading slash if exists)
    $baseRoutes = collect($existingRoutes)->map(function ($route) {
        return trim($route, '/'); // Normalize route by trimming `/`
    })->toArray();

    // Define Laravel's resource route patterns
    $resourceActions = ['create', '{id}', '{id}/edit', '{id}/show', '{id}/update', '{id}/destroy'];

    // Define additional routes to ignore
    $ignoreRoutes = [
        'login', 'register', 'forgot-password', 'reset-password/{token}', 'verify-email',
        'verify-email/{id}/{hash}', 'confirm-password', '_ignition/health-check', 'api/user',
        'dashboard', 'profile', 'popup', 'show_common_list_view', 'get_field_manager_data',
        'load_drop_down', 'mandatory_field_entry_form', 'load_drop_down_mandatory_field_item',
        'mandatory_action_user_data', 'field_manager_entry_form', 'load_drop_down_field_manager_item',
        'field_manager_action_user_data', 'field_level_access_user', 'field_level_action_user_data',
        'load_drop_down_field_level_access', 'set_field_name', 'common_file_popup',
        'get_mandatory_and_field_level_data', 'tools/create_main_module/get_data_by_id/{id}',
        'tools/create_menu/get_data_by_id/{id}','tools/mandatory_field_entry_form','tools/load_drop_down_mandatory_field_item',
        'tools/mandatory_action_user_data','tools/field_manager_entry_form','tools/load_drop_down_field_manager_item','tools/field_manager_action_user_data','tools/field_level_access_use','tools/show_module_list_view','permission','tools/load_priv_list_view','tools/load_priviledge_list','tools/load_main_menu','tools/root_menu_under','user_import','tools/load_sub_menu_under_menu','tools/sub_root_menu_under','tools/create_menu_search_list_view','tools/set_field_name','tools/load_drop_down_field_level_access','tools/field_level_action_user_data','tools/field_level_access_user','lib_buyer_export','lib_supplier_export'
    ];

    // Normalize routes (replace dynamic params `{xyz}` with `{id}`)
    $normalizedRoutes = collect($routes)->map(function ($route) {
        return preg_replace('/\{[^}]+\}/', '{id}', trim($route, '/'));
    });

    // Extract only the base resource routes
    $baseResourceRoutes = $normalizedRoutes->reject(function ($route) use ($resourceActions) {
        foreach ($resourceActions as $action) {
            if (preg_match("#^(.+)/$action$#", $route, $matches)) {
                return true; // Exclude all variations like 'lib/employee/{id}/edit'
            }
        }
        return false;
    })->unique()->values();

    // Filter routes: Exclude existing base routes, nested resource routes, and ignored routes
    $availableRoutes = $baseResourceRoutes->reject(function ($route) use ($baseRoutes, $ignoreRoutes) {
        return in_array($route, $ignoreRoutes) || in_array($route, $baseRoutes);
    })->values();

    return $availableRoutes;
}

function generate_system_no($company, $location, $category, $year, $num_length, $main_query, $str_fld_name, $num_fld_name = "")
{
    // Fetch the latest entry for the given parameters
    $latestEntry = sql_select($main_query, true);

    // Get company short name
    $companyPrefix = $company ? (Company::find($company)->company_short_name ?? "") : "";

    // Get location short name
    $locationPrefix = $location ? (LibLocation::find($location)->location_name ?? "") : "";

    // Format year as YY (last two digits)
    $year = strlen($year) === 4 ? substr($year, 2, 2) : $year;

    // Construct the prefix
    $systemNoPrefix = implode("-", array_filter([$companyPrefix, $locationPrefix, $category, $year]));

    // Determine the number (start from 1 if no previous entry)
    $nextNumber = $latestEntry ? ($latestEntry[$num_fld_name] + 1) : 1;

    // Generate final system number (padded number part)
    $systemNo = $systemNoPrefix . "-" . str_pad($nextNumber, $num_length, "0", STR_PAD_LEFT);

    return (object) [
        'sys_no' => $systemNo,
        'sys_no_prefix' => $systemNoPrefix,
        'sys_no_prefix_num' => $nextNumber
    ];
}


function calculate_current_stock($param = array(),$is_return_query = 0)
{
    $query = App\Models\InvTransaction::selectRaw('
                SUM(
                    CASE
                        WHEN transaction_type IN (1, 4, 5) THEN cons_qnty
                        ELSE 0
                    END)
                - SUM(
                    CASE
                        WHEN transaction_type IN (2, 3, 6) THEN cons_qnty
                        ELSE 0
                    END) AS current_stock');

    $query->where('product_id', $param['product_id']);

    if (!empty($param['location_id'])) {
        $query->where('location_id', $param['location_id']);
    }
    if (!empty($param['store_id'])) {
        $query->where('store_id', $param['store_id']);
    }
    if (!empty($param['floor_id'])) {
        $query->where('floor_id', $param['floor_id']);
    }
    if (!empty($param['room_id'])) {
        $query->where('room_id', $param['room_id']);
    }
    if (!empty($param['room_rack_id'])) {
        $query->where('room_rack_id', $param['room_rack_id']);
    }
    if (!empty($param['room_self_id'])) {
        $query->where('room_self_id', $param['room_self_id']);
    }
    if (!empty($param['room_bin_id'])) {
        $query->where('room_bin_id', $param['room_bin_id']);
    }

    if ($is_return_query == 1) {
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        // Replace bindings in SQL manually (not safe for production use with user input)
        foreach ($bindings as $binding) {
            $binding = is_numeric($binding) ? $binding : "'" . addslashes($binding) . "'";
            $sql = preg_replace('/\?/', $binding, $sql, 1);
        }

        return ['sql' => $sql];
    }

    return $query->first();
}

function calculate_required($product_id)
{
    $requisition_qnty = App\Models\RequisitionDtls::where('product_id', $product_id)
        ->sum('requisition_qty');

    $work_order_qnty = App\Models\WorkOrderDtls::where('product_id', $product_id)
        ->sum('quantity');

    return max($requisition_qnty - $work_order_qnty, 0);
}