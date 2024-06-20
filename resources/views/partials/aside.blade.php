<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="#" class="text-nowrap logo-img">
                <img src="{{asset('assets/images/logos/dark-logo.svg')}}" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ set_active('dashboard') }}" href="{{route("dashboard")}}" aria-expanded="false">
                        <span>
                          <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">ADMIN</span>
                </li>
                @if(auth()->user()->role == \App\Models\User::ADMIN)
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ set_active('users*') }}" href="{{route('users')}}" aria-expanded="false">
                        <span>
                          <i class="ti ti-users"></i>
                        </span>
                            <span class="hide-menu">Members</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item">
                    <a class="sidebar-link {{ set_active('groups*') }}" href="{{route('groups.index')}}" aria-expanded="false">
                        <span>
                          <i class="ti ti-article"></i>
                        </span>
                        <span class="hide-menu">Groups</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ set_active('activities*') }}"  href="{{route('activities')}}" aria-expanded="false">
                        <span>
                          <i class="ti ti-alert-circle"></i>
                        </span>
                        <span class="hide-menu">Activities</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
