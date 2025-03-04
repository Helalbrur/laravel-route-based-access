<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
?>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <?php

                $company_logo = "";
                $company = \App\Models\Company::first();
                if (!empty($company)) {
                    $images = App\Models\ImageUpload::where('sys_no', $company->id)
                        ->where('page_name', 'company_profile')
                        ->where('file_type', 1)->first();
                    //dd($images);
                    if (!empty($images)) {
                        $company_logo = $images->file_name;
                        //dd($company_logo);
                    }
                }

                if (!empty($company_logo)) 
                {
                    ?>
                    <a href="{{URL::to('/')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{asset($company_logo)}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset($company_logo)}}" alt="" height="22">
                        </span>
                    </a>
                    <a href="{{URL::to('/')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset($company_logo)}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset($company_logo)}}" alt="" height="22">
                        </span>
                    </a>
                    <?php
                } 
                else 
                {
                    ?>
                    <a href="{{URL::to('/')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="skote/assets/images/logo.svg" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="skote/assets/images/logo-dark.png" alt="" height="17">
                        </span>
                    </a>

                    <a href="{{URL::to('/')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="skote/assets/images/logo-light.svg" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="skote/assets/images/logo-light.png" alt="" height="19">
                        </span>
                    </a>
                    <?php
                }
                ?>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                <div class="collapse navbar-collapse active" id="topnav-menu-content">
                    <ul class="navbar-nav active">

                        <li class="nav-item">
                            <a class="nav-link" href="{{URL::to('/')}}" id="topnav-dashboard" role="button">
                                <span key="t-dashboards">Dashboard</span>
                            </a>
                        </li>

                        <?php
                        if (Auth::check()) {
                            //DB::enableQueryLog();
                            $modules = DB::table('main_module as a')
                                ->join('user_priv_module as b', 'a.m_mod_id', '=', 'b.module_id')
                                ->select('a.m_mod_id', 'a.main_module')
                                ->where('b.user_id', Auth::user()->id)
                                ->where('b.valid', 1)
                                ->where('a.status', 1)
                                ->orderBy('a.mod_slno', 'ASC')
                                ->get();
                            //dd(DB::getQueryLog());
                            foreach ($modules as $module) {
                                ?>
                                <li class="nav-item d-none d-sm-inline-block">
                                    <a href="{{route('dashboard', ['module_id' => $module->m_mod_id])}}" class="nav-link">{{$module->main_module}}</a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                        @if (Auth::check())
                        @endif
                    </ul>
                </div>
            </nav>
        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
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
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{URL::asset('skote/assets/images/users/avatar-1.jpg') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">@if (Auth::check()){{ Auth::user()->name }} @endif</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a>
                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
                    <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="route('logout')" class="dropdown-item dropdown-footer"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();"><i class="bx bx-log-out font-size-16 align-middle me-1"></i>
                            {{ __('Log Out') }}
                        </a>

                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div>

        </div>
    </div>
</header>