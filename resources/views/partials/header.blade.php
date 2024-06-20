<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="#">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="#">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover d-flex align-items-center " href="#" id="drop2" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{asset('assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
                        <span class="mb-0 fs-3 ms-3">
                            @auth
                                {{ auth()->user()->name }}
                            @endauth
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <form class="w-100" action="{{ route('logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="btn w-80 btn-outline-primary mx-3 mt-2 d-block" style="width: 85%;">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
