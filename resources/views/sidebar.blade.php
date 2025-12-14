<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{URL::to('/dashboard')}}" class="brand-link">
        <img src="{{asset('back/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Hotel Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('back/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="/dashboard" class="d-block">{{ Session::get('user')['full_name'] ?? '' }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item  {{ Request::is('dashboard') ? 'menu-open' : '' }}">
                    <a href="{{URL::to('/dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>

                </li>

                <li class="nav-item  {{ (
                        Request::is('packages*') ||
                        Request::is('popularPlaces*') ||
                        Request::is('withdraws*') ||
                        Request::is('propertyTypes*')
                        )
                        ? 'menu-open' : ''
                        }}"
                >
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Hotel
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('packages.index') }}" class="nav-link {{ request()->routeIs('packages.*') ? 'active_nav_menu' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Packages</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('popularPlaces.index') }}" class="nav-link {{ request()->routeIs('popularPlaces.*') ? 'active_nav_menu' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Popular Place</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('withdraws.index') }}" class="nav-link {{ request()->routeIs('withdraws.*') ? 'active_nav_menu' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Withdraw</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('propertyTypes.index') }}" class="nav-link {{ request()->routeIs('propertyTypes.*') ? 'active_nav_menu' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Property Types</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!--
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
                -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
