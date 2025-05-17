<style>
/* Force horizontal layout for module list */
.navbar-nav {
  display: flex !important;
  flex-wrap: nowrap !important;
  gap: 15px !important;
  padding-left: 0 !important;
  margin: 0 !important;
  list-style: none !important;
  background: #222 !important;
  border-radius: 6px !important;
  overflow: visible !important;
  flex-direction: row !important;
}

/* Each module item */
.navbar-nav > li.nav-item {
  flex-shrink: 0 !important;
  position: relative !important;
  display: block !important;
  white-space: nowrap !important;
}

/* Module links */
.navbar-nav > li.nav-item > a.nav-link {
  white-space: nowrap !important;
  color: #eee !important;
  padding: 12px 20px !important;
  display: block !important;
  font-weight: 600 !important;
  text-transform: uppercase !important;
  transition: background-color 0.3s ease, color 0.3s ease !important;
  border-radius: 4px !important;
  cursor: pointer;
}

/* Hover/focus effect */
.navbar-nav > li.nav-item > a.nav-link:hover,
.navbar-nav > li.nav-item > a.nav-link:focus {
  background-color: #0d6efd !important;
  color: #fff !important;
  text-decoration: none !important;
}

/* Dropdown menu */
.dropdown-menu {
  background: #333 !important;
  border-radius: 6px !important;
  min-width: 200px !important;
  padding: 0 !important;
  margin-top: 8px !important;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25) !important;
  display: none !important;
  position: absolute !important;
  z-index: 1050 !important;
}

/* Show dropdown on hover or focus */
.nav-item.dropdown:hover > .dropdown-menu,
.nav-item.dropdown:focus-within > .dropdown-menu {
  display: block !important;
}

/* Submenu wrapper */
.dropdown-submenu {
  position: relative !important;
}

/* Submenu dropdown positioning */
.dropdown-submenu > .dropdown-menu {
  top: 0 !important;
  left: 100% !important;
  margin-left: 0.1rem !important;
  margin-right: 0.1rem !important;
  border-radius: 6px !important;
}

/* Show submenu on hover/focus */
.dropdown-submenu:hover > .dropdown-menu,
.dropdown-submenu:focus-within > .dropdown-menu {
  display: block !important;
}

/* Dropdown items */
.dropdown-menu > li > a.dropdown-item {
  color: #ddd !important;
  padding: 10px 16px !important;
  display: block !important;
  font-weight: 500 !important;
  transition: background-color 0.2s ease !important;
  white-space: nowrap !important;
}

/* Dropdown item hover */
.dropdown-menu > li > a.dropdown-item:hover,
.dropdown-menu > li > a.dropdown-item:focus {
  background-color: #0d6efd !important;
  color: #fff !important;
  text-decoration: none !important;
  cursor: pointer !important;
}

/* Arrow for submenu */
.dropdown-submenu > a::after {
  content: "▶";
  float: right;
  margin-left: 5px;
  font-size: 12px;
  color: #ccc;
}

/* Responsive: stack vertically on small screens */
@media (max-width: 768px) {
  .navbar-nav {
    flex-direction: column !important;
  }
  .dropdown-menu {
    position: static !important;
    box-shadow: none !important;
    margin-top: 0 !important;
  }
  .dropdown-submenu > .dropdown-menu {
    left: 0 !important;
  }
}

.custom-navbar {
    background: #222;
    padding: 0.5rem 1rem;
    color: white;
}

.navbar-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-nav-left,
.navbar-nav-right {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.navbar-nav-left li,
.navbar-nav-right li {
    margin: 0 10px;
}

.navbar-nav-left li a,
.navbar-nav-right li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.header-profile-user {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 5px;
}

</style>


<nav class="custom-navbar">
    <div class="navbar-wrapper">
        <!-- Left-aligned main menu -->
        <ul class="navbar-nav active">

            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('/') }}" id="topnav-dashboard" role="button">
                    <span key="t-dashboards">Dashboard</span>
                </a>
            </li>

            <?php
            if (Auth::check()) {
                $modules = DB::table('main_module as a')
                    ->join('user_priv_module as b', 'a.m_mod_id', '=', 'b.module_id')
                    ->select('a.m_mod_id', 'a.main_module')
                    ->where('b.user_id', Auth::user()->id)
                    ->where('b.valid', 1)
                    ->where('a.status', 1)
                    ->orderBy('a.mod_slno', 'ASC')
                    ->get();

                foreach ($modules as $module) {
                    $m_id = $module->m_mod_id;
                    $uid = Auth::user()->id;

                    // Level 1 menus
                    $level_one = sql_select("SELECT a.m_menu_id,a.menu_name,a.f_location,a.route_name,a.fabric_nature, b.save_priv,b.edit_priv,b.delete_priv,b.approve_priv FROM main_menu a,user_priv_mst b WHERE a.m_module_id='$m_id' AND a.position='1' AND a.status='1' AND a.m_menu_id=b.main_menu_id AND a.status_active = 1 AND a.is_deleted = 0 AND b.valid=1 AND a.is_mobile_menu NOT IN (1) AND b.user_id=$uid AND b.show_priv=1 ORDER BY a.slno,a.menu_name");

                    echo '<li class="nav-item dropdown">';
                    echo '<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo e($module->main_module);
                    echo '</a>';

                    echo '<ul class="dropdown-menu">';

                    foreach ($level_one as $lvl1) {
                        $lvl1_id = $lvl1[csf('M_MENU_ID')];
                        $lvl1_name = $lvl1[csf('MENU_NAME')];
                        $lvl1_loc = $lvl1[csf('F_LOCATION')];

                        // Level 2
                        $level_two = sql_select("SELECT a.m_menu_id,a.menu_name,a.f_location,a.fabric_nature FROM main_menu a,user_priv_mst b WHERE a.m_module_id=$m_id AND a.root_menu=$lvl1_id AND a.position=2 AND a.status=1 AND a.is_mobile_menu NOT IN (1) AND a.status_active=1 AND a.is_deleted=0 AND a.m_menu_id=b.main_menu_id AND b.valid=1 AND b.user_id=$uid AND b.show_priv=1 ORDER BY a.slno,a.menu_name");

                        if (count($level_two) > 0) {
                            echo '<li class="dropdown-submenu">';
                            echo '<a class="dropdown-item dropdown-toggle" href="javascript:void(0);">' . e($lvl1_name) . '</a>';
                            echo '<ul class="dropdown-menu">';

                            foreach ($level_two as $lvl2) {
                                $lvl2_id = $lvl2[csf('M_MENU_ID')];
                                $lvl2_name = $lvl2[csf('MENU_NAME')];
                                $lvl2_loc = $lvl2[csf('F_LOCATION')];

                                // Level 3
                                $level_three = sql_select("SELECT a.m_menu_id,a.menu_name,a.f_location FROM main_menu a,user_priv_mst b WHERE a.m_module_id=$m_id AND a.sub_root_menu=$lvl2_id AND a.position=3 AND a.status=1 AND a.is_mobile_menu NOT IN (1) AND a.status_active=1 AND a.is_deleted=0 AND a.m_menu_id=b.main_menu_id AND b.valid=1 AND b.user_id=$uid AND b.show_priv=1 ORDER BY a.slno,a.menu_name");

                                if (count($level_three) > 0) {
                                    echo '<li class="dropdown-submenu">';
                                    echo '<a class="dropdown-item dropdown-toggle" href="javascript:void(0);">' . e($lvl2_name) . '</a>';
                                    echo '<ul class="dropdown-menu">';

                                    foreach ($level_three as $lvl3) {
                                        $lvl3_id = $lvl3[csf('M_MENU_ID')];
                                        $lvl3_name = $lvl3[csf('MENU_NAME')];
                                        $lvl3_loc = $lvl3[csf('F_LOCATION')];

                                        // Level 4
                                        $level_four = sql_select("SELECT a.m_menu_id,a.menu_name,a.f_location FROM main_menu a,user_priv_mst b WHERE a.m_module_id=$m_id AND a.sub_sub_root_menu=$lvl3_id AND a.position=4 AND a.status=1 AND a.is_mobile_menu NOT IN (1) AND a.status_active=1 AND a.is_deleted=0 AND a.m_menu_id=b.main_menu_id AND b.valid=1 AND b.user_id=$uid AND b.show_priv=1 ORDER BY a.slno,a.menu_name");

                                        if (count($level_four) > 0) {
                                            echo '<li class="dropdown-submenu">';
                                            echo '<a class="dropdown-item dropdown-toggle" href="javascript:void(0);">' . e($lvl3_name) . '</a>';
                                            echo '<ul class="dropdown-menu">';
                                            foreach ($level_four as $lvl4) {
                                                $lvl4_id = $lvl4[csf('M_MENU_ID')];
                                                $lvl4_name = $lvl4[csf('MENU_NAME')];
                                                $lvl4_loc = $lvl4[csf('F_LOCATION')];
                                                $url4 = URL::to("/{$lvl4_loc}?mid={$lvl4_id}");
                                                echo '<li><a class="dropdown-item" href="' . e($url4) . '">' . e($lvl4_name) . '</a></li>';
                                            }
                                            echo '</ul></li>';
                                        } else {
                                            $url3 = URL::to("/{$lvl3_loc}?mid={$lvl3_id}");
                                            echo '<li><a class="dropdown-item" href="' . e($url3) . '">' . e($lvl3_name) . '</a></li>';
                                        }
                                    }
                                    echo '</ul></li>';
                                } else {
                                    $url2 = URL::to("/{$lvl2_loc}?mid={$lvl2_id}");
                                    echo '<li><a class="dropdown-item" href="' . e($url2) . '">' . e($lvl2_name) . '</a></li>';
                                }
                            }
                            echo '</ul></li>';
                        } else {
                            $url1 = URL::to("/{$lvl1_loc}?mid={$lvl1_id}");
                            echo '<li><a class="dropdown-item" href="' . e($url1) . '">' . e($lvl1_name) . '</a></li>';
                        }
                    }

                    echo '</ul>';
                    echo '</li>';
                }
            }
            ?>
            
        </ul>

        <!-- Right-aligned icons/profile/settings -->
        <ul class="navbar-nav-right">
            <li>
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </li>
            <li class="nav-item dropdown">
               <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    <!-- <span class="badge bg-danger rounded-pill">3</span> -->
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0" key="t-notifications"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small" key="t-view-all"> View All</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" key="t-your-order">Your order is placed</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="{{URL::asset('skote/assets/images/users/avatar-3.jpg') }}"
                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-simplified">It will seem like simplified English.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" key="t-shipped">Your item is shipped</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="{{URL::asset('skote/assets/images/users/avatar-4.jpg') }}"
                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Salena Layfield</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-occidental">As a skeptical Cambridge friend of mine occidental.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{URL::asset('skote/assets/images/users/avatar-1.jpg') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">@if (Auth::check()){{ Auth::user()->name }} @endif</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <a class="dropdown-item" href="{{url('tools/user_profile')}}">
                        <i class="bx bx-user font-size-16 align-middle me-1"></i> 
                        <span key="t-profile">Profile</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="route('logout')" class="dropdown-item dropdown-footer"
                            onclick="event.preventDefault();this.closest('form').submit();">
                            <i class="bx bx-log-out font-size-16 align-middle me-1"></i>
                            {{ __('Log Out') }}
                        </a>

                    </form>
                </div>
            </li>
            <li class="nav-item dropdown">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </li>
        </ul>
    </div>
</nav>

