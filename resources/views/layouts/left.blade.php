<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
?>
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        @if (Auth::check())
            <div id="sidebar-menu">
                <ul class="metismenu list-unstyled" id="side-menu">
                    <?php
                    $m_id = Session::get('module_id');
                    $uid = Auth::user()->id;
                    DB::enableQueryLog();
                    $level_one = sql_select("SELECT a.m_menu_id,a.menu_name,a.f_location,a.route_name,a.fabric_nature, b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv FROM main_menu a,user_priv_mst b where a.m_module_id='$m_id' and a.position='1' and a.status='1' and a.m_menu_id=b.main_menu_id and a.status_active = 1 and a.is_deleted = 0  and b.valid=1 and a.is_mobile_menu not in (1)   and b.user_id=" . $uid . " and b.show_priv=1 order by a.slno,a.menu_name");
                    $i = 0;
                    $leve1counter = count($level_one);

                    $module_menu_arr = array();
                    foreach ($level_one as $r_sql) {
                        $module_menu_arr[$r_sql[csf('M_MENU_ID')]] = $r_sql[csf('M_MENU_ID')];
                    }

                    $child_menu1_arr = array();
                    if (!empty($module_menu_arr)) {
                        $child_level2 = sql_select("SELECT a.root_menu,a.m_menu_id,a.menu_name,a.f_location,a.fabric_nature,a.position,b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv FROM main_menu a,user_priv_mst b where a.m_module_id=$m_id and a.root_menu in(" . implode(",", $module_menu_arr) . ")  and a.position=2 and a.status=1 and a.is_mobile_menu not in (1) and a.status_active = 1 and a.is_deleted = 0  and a.m_menu_id=b.main_menu_id and b.valid=1 and b.user_id=$uid and b.show_priv=1 order by a.slno,a.menu_name");
                        foreach ($child_level2 as $r_sql) {
                            $child_menu1_arr[$m_id][$uid][$r_sql[csf('ROOT_MENU')]][] = $r_sql[csf('M_MENU_ID')] . "**" . $r_sql[csf('MENU_NAME')] . "**" . $r_sql[csf('F_LOCATION')] . "**" . $r_sql[csf('SAVE_PRIV')] . "**" . $r_sql[csf('EDIT_PRIV')] . "**" . $r_sql[csf('DELETE_PRIV')] . "**" . $r_sql[csf('APPROVE_PRIV')] . "**" . $r_sql[csf('fabric_nature')];
                            $module_sub_menu_arr[$r_sql[csf('M_MENU_ID')]] = $r_sql[csf('M_MENU_ID')];
                        }
                    }

                    $child_menu2_arr = array();
                    if (!empty($module_sub_menu_arr)) {
                        $child_level3 = sql_select("SELECT a.root_menu,a.sub_root_menu,a.m_menu_id,a.menu_name,a.f_location,a.fabric_nature, b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv  FROM main_menu a,user_priv_mst b where a.m_module_id=$m_id and a.sub_root_menu  in(" . implode(",", $module_sub_menu_arr) . ") and a.position=3 and a.is_mobile_menu not in (1)  and a.status_active = 1 and a.is_deleted = 0  and a.status=1 and a.m_menu_id=b.main_menu_id and b.valid=1 and b.user_id=$uid and b.show_priv=1 order by a.slno,a.menu_name");
                        foreach ($child_level3 as $r_sql) {
                            $child_menu2_arr[$m_id][$uid][$r_sql[csf('ROOT_MENU')]][$r_sql[csf('SUB_ROOT_MENU')]][] = $r_sql[csf('M_MENU_ID')] . "**" . $r_sql[csf('MENU_NAME')] . "**" . $r_sql[csf('F_LOCATION')] . "**" . $r_sql[csf('SAVE_PRIV')] . "**" . $r_sql[csf('EDIT_PRIV')] . "**" . $r_sql[csf('DELETE_PRIV')] . "**" . $r_sql[csf('APPROVE_PRIV')] . "**" . $r_sql[csf('fabric_nature')];
                        }
                    }

                    $icons = [
                        'contact' => asset('svg/contact.svg'),
                        'cost' => asset('svg/cost.svg'),
                        'general' => asset('svg/general.svg'),
                        'item' => asset('svg/items.svg'),
                        'inventory' => asset('svg/inventory.svg'),
                        'setting' => asset('svg/settings.svg')
                    ];

                    $iconIndex = 0;

                    foreach ($level_one as $r_sql) {
                        $i++;
                        $level2 = $child_menu1_arr[$m_id][$uid][$r_sql[csf('M_MENU_ID')]] ?? array();
                        
                        $menuName = strtolower($r_sql[csf('MENU_NAME')]);
                        $icon = asset('svg/default.svg');
                        foreach ($icons as $key => $svg) {
                            if (stripos($menuName, $key) !== false) {
                                $icon = $svg;
                                break;
                            }
                        }

                        if (count($level2) < 1) {
                            $url = URL::to("/{$r_sql[csf('f_location')]}?mid={$r_sql[csf('M_MENU_ID')]}");
                            ?>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a id="lid<?php echo $r_sql[csf('M_MENU_ID')]; ?>"
                                       href="<?php echo trim($r_sql[csf('F_LOCATION')]) == "" ? "#" : $url; ?>">
                                        <!-- <img src="<?php //echo $icon; ?>" alt="icon"> -->
                                        <?php echo $r_sql[csf('MENU_NAME')]; ?>
                                    </a>
                                </li>
                            </ul>
                            <?php
                        } 
                        else 
                        {
                            ?>
                            <li>
                                <a href="javascript:void(0);" class="has-arrow waves-effect">
                                    <img src="<?php echo $icon; ?>" width="17" height="17" alt="icon"> 
                                    <span key="t-dashboards" style="color: rgb(202, 202, 202) !important">
                                        <?php echo $r_sql[csf('MENU_NAME')]; ?>
                                    </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php
                                    foreach ($level2 as $level2_menu) 
                                    {
                                        $i++;
                                        $r_sql2 = explode("**", $level2_menu);
                                        $menu_id = $r_sql2[0];
                                        $menu_name = $r_sql2[1];
                                        $f_location = $r_sql2[2];
                                        $level3 = $child_menu2_arr[$m_id][$uid][$r_sql[csf('M_MENU_ID')]][$menu_id] ?? array();

                                        if (count($level3) < 1) {
                                            $url = URL::to("/{$f_location}?mid={$menu_id}");
                                            ?>
                                            <li>
                                                <a id="lid<?php echo $menu_id; ?>" 
                                                style="color: rgb(202, 202, 202) !important;"
                                                href="<?php echo trim($f_location) == "" ? "#" : $url; ?>">
                                                    <?php echo $menu_name; ?>
                                                </a>
                                            </li>
                                            <?php
                                        } 
                                        else 
                                        {
                                            ?>
                                            <li>
                                                <span class="toggle"><?php echo $menu_name; ?></span>
                                                <ul>
                                                    <?php
                                                    foreach ($level3 as $level3_menu) 
                                                    {
                                                        $r_sql3 = explode("**", $level3_menu);
                                                        $menu_id = $r_sql3[0];
                                                        $menu_name = $r_sql3[1];
                                                        $f_location = $r_sql3[2];
                                                        $url = URL::to("/{$f_location}?mid={$menu_id}");
                                                        ?>
                                                            <li>
                                                                <a id="lid<?php echo $menu_id; ?>" 
                                                                style="color: rgb(202, 202, 202) !important;"
                                                                href="<?php echo trim($f_location) == "" ? "#" : $url; ?>">
                                                                    <?php echo $menu_name; ?>
                                                                </a>
                                                            </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        @endif
    </div>
</div>