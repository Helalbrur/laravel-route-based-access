<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{URL::to('/')}}" class="nav-link">Home</a>
      </li>
      <?php
       if (Auth::check())
       {
            //DB::enableQueryLog();
            $modules = DB::table('main_module as a')
            ->join('user_priv_module as b', 'a.m_mod_id', '=', 'b.module_id')
            ->select('a.m_mod_id', 'a.main_module')
            ->where('b.user_id', Auth::user()->id)
            ->where('b.valid', 1)
            ->where('a.status', 1)
            ->orderBy('a.mod_slno','ASC')
            ->get();
            //dd(DB::getQueryLog());
            foreach ($modules as $module)
            {
                ?>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route('dashboard', ['module_id' => $module->m_mod_id])}}" class="nav-link">{{$module->main_module}}</a>
                </li>
                <?php
            }
       }
      ?>
      @if (Auth::check() && Auth::user()->hasAccess('View Permission'))
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('permission.index')}}" class="nav-link">{{__('Permission')}}</a>
        </li>
      @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span class="badge badge-warning navbar-badge">{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{ Auth::user()->name }}</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="route('logout')" class="dropdown-item dropdown-footer"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
</nav>
