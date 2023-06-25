
<script type="text/javascript">

    $(document).ready(function() {
        console.log('hello');
        // hide all the sub-menus
        $("span.toggle").next().hide();
        // add a link nudging animation effect to each link
        $("#jQ-menu a, #jQ-menu span.toggle").hover(function() {
            $(this).stop().animate( {
                fontSize:"12px",
                paddingLeft:"5px"
                //color:"black"
            }, 100);
        }, function() {
            $(this).stop().animate( {
                fontSize:"12px",
                paddingLeft:"0px"
                //color:"black"
            }, 100);
        });

        // set the cursor of the toggling span elements
        $("span.toggle").css("cursor", "pointer");

        // prepend a plus sign to signify that the sub-menus aren't expanded
        $("span.toggle").prepend("+");

        $("#jQ-menu ul > li").css('border-left','2px solid #FFFFFF'); //F33
        $("#jQ-menu ul > li").css('border-top','0.2px solid #FFFFFF'); //FF0033
        $("#jQ-menu ul > li").css('border-right','2px solid #FFFFFF');
        $("span.toggle > ul li").css('border-bottom-left-radius','50px');
        $("span.toggle > ul li").css('border-top-left-radius','50px');

        // add a click function that toggles the sub-menu when the corresponding
        // span element is clicked
        $("span.toggle").click(function() {
            $(this).next().toggle(500);
            // switch the plus to a minus sign or vice-versa
            var v = $(this).html().substring( 0, 1 );
            if ( v == "+" )
                $(this).html( "-" + $(this).html().substring( 1 ) );
            else if ( v == "-" )
                $(this).html( "+" + $(this).html().substring( 1 ) );
        });
    });

	$(document).ready(function() {
		$('#jQ-menu ul li a').bind("mouseover", function(){
			/* var color  = $(this).css("background-color");*/
			$(this).css("background", "#C2DCFF");
			$(this).bind("mouseout", function(){
				$(this).css("background", 'none');
			})
		})
	})
</script>

<style>

#jQ-menu{
	width:230px;
	overflow:hidden;
	font-size:12px;
	background-color:#ddd;
}
#jQ-menu ul {
	list-style-type: none;
	background-color:#ddd;
    border: 5px solid whitesmoke;
}

#jQ-menu a, #jQ-menu li {
	color:#333;
	text-decoration: none;
	padding-bottom: 5px;
	padding-top: 5px;
	padding-left: 3px;
	border-radius:2px;

    /* background-image: linear-gradient(to top, rgb(230, 230, 230), rgb(240, 240, 240));
    background-image: -webkit-linear-gradient(bottom, rgb(230, 230, 230) 7%, rgb(240, 240, 240) 10%, rgb(230, 230, 230) 96%); */
    background-image: linear-gradient(to top, rgb(240, 240, 240), rgb(250, 250, 250));
    background-image: -webkit-linear-gradient(bottom, rgb(240, 240, 240) 7%, rgb(250, 250, 250) 10%, rgb(240, 240, 240) 96%);

}


</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('adminlte/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('adminlte/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name ?? ''}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <?php /*?>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

                @foreach ($routes as $route)
                    @if (Auth::check() && Auth::user()->hasAccess($route['permission']))
                        <li class="nav-item">
                            <a href="{{route($route['route_name'])}}" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{$route['permission']}}</p>
                            </a>
                        </li>
                    @endif
                @endforeach

            </ul>
          </li>

        </ul>
        <?php */ ?>
        <div id="jQ-menu">
            <ul>
                <?php
                //$routes = getPermissionBasedAllRoutes();
                $m_id = Session::get('module_id');
                $uid = Auth::user()->id;
                DB::enableQueryLog();
                $level_one=sql_select( "SELECT a.m_menu_id,a.menu_name,a.f_location,a.route_name,a.fabric_nature, b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv FROM main_menu a,user_priv_mst b where a.m_module_id='$m_id' and a.position='1' and a.status='1' and a.m_menu_id=b.main_menu_id and b.valid=1 and a.is_mobile_menu not in (1)   and b.user_id=".$uid." and b.show_priv=1 order by a.slno" );
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
                    $child_level2=sql_select("SELECT a.root_menu,a.m_menu_id,a.menu_name,a.f_location,a.fabric_nature,a.position,b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv FROM main_menu a,user_priv_mst b where a.m_module_id=$m_id and a.root_menu in(".implode(",",$module_menu_arr).")  and a.position=2 and a.status=1 and a.is_mobile_menu not in (1)   and a.m_menu_id=b.main_menu_id and b.valid=1 and b.user_id=$uid and b.show_priv=1 order by a.slno");
                    foreach ($child_level2 as $r_sql)
                    {
                        $child_menu1_arr[$m_id][$uid][$r_sql[csf('ROOT_MENU')]][] = $r_sql[csf('M_MENU_ID')]."**".$r_sql[csf('MENU_NAME')]."**".$r_sql[csf('F_LOCATION')]."**".$r_sql[csf('SAVE_PRIV')]."**".$r_sql[csf('EDIT_PRIV')]."**".$r_sql[csf('DELETE_PRIV')]."**".$r_sql[csf('APPROVE_PRIV')]."**".$r_sql[csf('fabric_nature')];
                        $module_sub_menu_arr[$r_sql[csf('M_MENU_ID')]] = $r_sql[csf('M_MENU_ID')];
                    }
                }

                $child_menu2_arr = array();

                if(!empty($module_sub_menu_arr))
                {
                    $child_level3=sql_select("SELECT a.root_menu,a.sub_root_menu,a.m_menu_id,a.menu_name,a.f_location,a.fabric_nature, b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv  FROM main_menu a,user_priv_mst b where a.m_module_id=$m_id and a.sub_root_menu  in(".implode(",",$module_sub_menu_arr).") and a.position=3 and a.is_mobile_menu not in (1)   and a.status=1 and a.m_menu_id=b.main_menu_id and b.valid=1 and b.user_id=$uid and b.show_priv=1 order by a.slno");
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
                        $men=$r_sql[csf('MENU_NAME')]."__".$r_sql[csf('fabric_nature')];
                        $url = URL::to("/{$r_sql[csf('f_location')]}?mid={$r_sql[csf('M_MENU_ID')]}&fnat={$men}");
                        ?>
                        <li>
                            <a
                                id="lid<?php echo $r_sql[csf('M_MENU_ID')]; ?>"
                                href="<?php if( trim( $r_sql[csf('F_LOCATION')] ) == "" ) echo "#"; else { echo $url; } ?>"
                            >
                                <?php echo $r_sql[csf('MENU_NAME')]; ?>
                            </a>
                        </li>
                        <?php
                    }
                    else
                    {
                        echo '<li><span class="toggle">'.$r_sql[csf('MENU_NAME')].'</span> <ul>';
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
                                $men=$menu_name."__".$fabric_nature;
                                $url = URL::to("/{$f_location}?mid={$menu_id}&fnat={$men}");
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
                                    $men=$menu_name."__".$fabric_nature;
                                    $url = URL::to("/{$f_location}?mid={$menu_id}&fnat={$men}");
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
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
