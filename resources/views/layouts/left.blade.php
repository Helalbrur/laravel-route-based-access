
<div class="vertical-menu">

<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">

        <?php
                //$routes = getPermissionBasedAllRoutes();
                $m_id = Session::get('module_id');
                $uid = Auth::user()->id;
                DB::enableQueryLog();
                $level_one=sql_select( "SELECT a.m_menu_id,a.menu_name,a.f_location,a.route_name,a.fabric_nature, b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv FROM main_menu a,user_priv_mst b where a.m_module_id='$m_id' and a.position='1' and a.status='1' and a.m_menu_id=b.main_menu_id and a.status_active = 1 and a.is_deleted = 0  and b.valid=1 and a.is_mobile_menu not in (1)   and b.user_id=".$uid." and b.show_priv=1 order by a.slno" );
			          $i = 0;
			           $leve1counter = count( $level_one );

                $module_menu_arr=array();
                foreach ($level_one as $r_sql)
                {
                    $module_menu_arr[$r_sql[csf('M_MENU_ID')]] = $r_sql[csf('M_MENU_ID')];
                }

                $child_menu1_arr = array();

                if(!empty($module_menu_arr))
                {
                    $child_level2=sql_select("SELECT a.root_menu,a.m_menu_id,a.menu_name,a.f_location,a.fabric_nature,a.position,b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv FROM main_menu a,user_priv_mst b where a.m_module_id=$m_id and a.root_menu in(".implode(",",$module_menu_arr).")  and a.position=2 and a.status=1 and a.is_mobile_menu not in (1) and a.status_active = 1 and a.is_deleted = 0  and a.m_menu_id=b.main_menu_id and b.valid=1 and b.user_id=$uid and b.show_priv=1 order by a.slno");
                    foreach ($child_level2 as $r_sql)
                    {
                        $child_menu1_arr[$m_id][$uid][$r_sql[csf('ROOT_MENU')]][] = $r_sql[csf('M_MENU_ID')]."**".$r_sql[csf('MENU_NAME')]."**".$r_sql[csf('F_LOCATION')]."**".$r_sql[csf('SAVE_PRIV')]."**".$r_sql[csf('EDIT_PRIV')]."**".$r_sql[csf('DELETE_PRIV')]."**".$r_sql[csf('APPROVE_PRIV')]."**".$r_sql[csf('fabric_nature')];
                        $module_sub_menu_arr[$r_sql[csf('M_MENU_ID')]] = $r_sql[csf('M_MENU_ID')];
                    }
                }

                $child_menu2_arr = array();

                if(!empty($module_sub_menu_arr))
                {
                    $child_level3=sql_select("SELECT a.root_menu,a.sub_root_menu,a.m_menu_id,a.menu_name,a.f_location,a.fabric_nature, b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv  FROM main_menu a,user_priv_mst b where a.m_module_id=$m_id and a.sub_root_menu  in(".implode(",",$module_sub_menu_arr).") and a.position=3 and a.is_mobile_menu not in (1)  and a.status_active = 1 and a.is_deleted = 0  and a.status=1 and a.m_menu_id=b.main_menu_id and b.valid=1 and b.user_id=$uid and b.show_priv=1 order by a.slno");
                    foreach ($child_level3 as $r_sql)
                    {
                        $child_menu2_arr[$m_id][$uid][$r_sql[csf('ROOT_MENU')]][$r_sql[csf('SUB_ROOT_MENU')]][] = $r_sql[csf('M_MENU_ID')]."**".$r_sql[csf('MENU_NAME')]."**".$r_sql[csf('F_LOCATION')]."**".$r_sql[csf('SAVE_PRIV')]."**".$r_sql[csf('EDIT_PRIV')]."**".$r_sql[csf('DELETE_PRIV')]."**".$r_sql[csf('APPROVE_PRIV')]."**".$r_sql[csf('fabric_nature')];
                    }
                }

                foreach ($level_one as $r_sql)
                {
                    $i++;
                    $level2 = $child_menu1_arr[$m_id][$uid][$r_sql[csf('M_MENU_ID')]] ?? array();
                    if( count( $level2 ) < 1)
                    {
                        $url = URL::to("/{$r_sql[csf('f_location')]}?mid={$r_sql[csf('M_MENU_ID')]}");
                        echo '<ul class="sub-menu" aria-expanded="false">';
                        ?>
                        <li >
                            <a
                                id="lid<?php echo $r_sql[csf('M_MENU_ID')]; ?>"
                                href="<?php if( trim( $r_sql[csf('F_LOCATION')] ) == "" ) echo "#"; else { echo $url; } ?>"
                            >
                                <?php echo $r_sql[csf('MENU_NAME')]; ?>
                            </a>
                        </li>
                        <?php
                        echo '</ul>';
                    }
                    else
                    {
                        echo '<li><a href="javascript: void(0);" class="has-arrow waves-effect">
                        
                        <svg fill="#d6d6d6"height="13px" width="13px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-51.19 -51.19 614.27 614.27" xml:space="preserve" stroke="#d6d6d6"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#969696" stroke-width="64.498518"> <g> <g> <path d="M476.84,248.107L233.64,3.2c-2.027-2.027-4.693-3.2-7.573-3.2H42.6c-5.867,0-10.667,4.8-10.667,10.667 c0,2.88,1.173,5.547,3.093,7.573l237.76,237.44L35.24,493.76c-4.16,4.16-4.16,10.88,0,15.04c2.027,2.027,4.693,3.093,7.573,3.093 H226.28c2.88,0,5.547-1.173,7.573-3.2L476.84,263.04C481,258.987,481,252.267,476.84,248.107z M221.8,490.667H68.52 l226.987-227.52c4.16-4.16,4.16-10.88,0-15.04L68.413,21.333h153.28l232.64,234.347L221.8,490.667z"></path> </g> </g> </g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M476.84,248.107L233.64,3.2c-2.027-2.027-4.693-3.2-7.573-3.2H42.6c-5.867,0-10.667,4.8-10.667,10.667 c0,2.88,1.173,5.547,3.093,7.573l237.76,237.44L35.24,493.76c-4.16,4.16-4.16,10.88,0,15.04c2.027,2.027,4.693,3.093,7.573,3.093 H226.28c2.88,0,5.547-1.173,7.573-3.2L476.84,263.04C481,258.987,481,252.267,476.84,248.107z M221.8,490.667H68.52 l226.987-227.52c4.16-4.16,4.16-10.88,0-15.04L68.413,21.333h153.28l232.64,234.347L221.8,490.667z"></path> </g> </g> </g></svg>

                        <span key="t-dashboards">'.$r_sql[csf('MENU_NAME')].'</span>

                        </a> <ul class="sub-menu" aria-expanded="false">';
                        foreach ($level2 as $level2_menu)
                        {
                            $i++;
                            $r_sql2 		= explode("**",$level2_menu);
                            $menu_id 		= $r_sql2[0];
                            $menu_name 		= $r_sql2[1];
                            $f_location 	= $r_sql2[2];
                            $save_priv 		= $r_sql2[3];
                            $edit_priv 		= $r_sql2[4];
                            $delete_priv 	= $r_sql2[5];
                            $approve_priv 	= $r_sql2[6];
                            $fabric_nature 	= $r_sql2[7];

                            $level3 = $child_menu2_arr[$m_id][$uid][$r_sql[csf('M_MENU_ID')]][$menu_id] ?? array();
                            if( count( $level3 ) < 1)
                            {
                                $url = URL::to("/{$f_location}?mid={$menu_id}");
                                ?>
                                <li>
                                    <a
                                    id="lid<?php echo $menu_id; ?>"
                                    href="<?php if( trim( $f_location ) == "" ) echo "#"; else { echo $url; } ?>"
                                    >
                                        <?php echo  $menu_name; ?>
                                    </a>
                                </li>
                                <?php
                            }
                            else
                            {
                                echo '<li><span class="toggle">'.$menu_name.'</span> <ul>';
                                foreach ($level3 as $level3_menu)
                                {
                                    $r_sql3 		= explode("**",$level3_menu);
                                    $menu_id 		= $r_sql3[0];
                                    $menu_name 		= $r_sql3[1];
                                    $f_location 	= $r_sql3[2];
                                    $save_priv 		= $r_sql3[3];
                                    $edit_priv 		= $r_sql3[4];
                                    $delete_priv 	= $r_sql3[5];
                                    $approve_priv 	= $r_sql3[6];
                                    $fabric_nature 	= $r_sql3[7];
                                    $url = URL::to("/{$f_location}?mid={$menu_id}");
                                    ?>
                                     <li>
                                        <a
                                        id="lid<?php echo $menu_id; ?>"
                                        href="<?php if( trim( $f_location ) == "" ) echo "#"; else { echo $url; } ?>"
                                        >
                                            {{$menu_name}}
                                        </a>
                                    </li>
                                    <?php
                                }
                                echo '</ul></li>';
                            }

                        }
                        echo '</ul></li>';
                    }
                }

             ?>

        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>