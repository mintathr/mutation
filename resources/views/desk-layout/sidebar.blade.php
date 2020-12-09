<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/assets-template/img/default.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if((auth()->user()->role == 'admin') OR (auth()->user()->role == 'user'))
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mutation') }}" class="nav-link {{ request()->is('mutation') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>Mutations</p>
                    </a>
                </li>


                <li class="nav-header">SOURCE FUND</li>

                <li class="nav-item has-treeview 
                {{ request()->is('mutasi-bca/1') ? 'menu-open' : '' }} 
                {{ request()->is('mutasi-bni/2') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-cimb/3') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-dbs/4') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-danamon/5') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-panin/6') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-cc-bca/7') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-cc-niaga-master/8') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-cc-niaga-syariah/9') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-cc-panin/10') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-cash/11') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-gopay/12') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-ovo/13') ? 'menu-open' : '' }}
                {{ request()->is('mutasi-shopee-pay/14') ? 'menu-open' : '' }}
                ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-alt"></i>
                        <p>
                            Banks
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/mutasi-bca/1" class="nav-link {{ request()->is('mutasi-bca/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BCA</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-bni/2" class="nav-link {{ request()->is('mutasi-bni/2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BNI</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-cimb/3" class="nav-link {{ request()->is('mutasi-cimb/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CIMB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-dbs/4" class="nav-link {{ request()->is('mutasi-dbs/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DBS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-danamon/5" class="nav-link {{ request()->is('mutasi-danamon/5') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danamon</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-panin/6" class="nav-link {{ request()->is('mutasi-panin/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Panin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-cc-bca/7" class="nav-link {{ request()->is('mutasi-cc-bca/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CC BCA</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-cc-niaga-master/8" class="nav-link {{ request()->is('mutasi-cc-niaga-master/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CC Niaga Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-cc-niaga-syariah/9" class="nav-link {{ request()->is('mutasi-cc-niaga-syariah/9') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CC Niaga Syariah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-cc-panin/10" class="nav-link {{ request()->is('mutasi-cc-panin/10') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CC Panin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-cash/11" class="nav-link {{ request()->is('mutasi-cash/11') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>CASH</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-gopay/12" class="nav-link {{ request()->is('mutasi-gopay/12') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>GoPay</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-ovo/13" class="nav-link {{ request()->is('mutasi-ovo/13') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>OVO</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mutasi-shopee-pay/14" class="nav-link {{ request()->is('mutasi-shopee-pay/14') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ShopeePay</p>
                            </a>
                        </li>

                    </ul>
                </li>
                @endif

                @if(auth()->user()->role == 'admin')
                <li class="nav-header">ADMIN</li>
                <li class="nav-item">
                    <a href="{{ route('user') }}" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User</p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>