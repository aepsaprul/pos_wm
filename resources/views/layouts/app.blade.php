@guest

@yield('content')

@else

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('themes/dist/img/logo-daun.png') }}" rel="icon" type="image/x-icon">
    <title>{{ config('app.name', 'E - SPK') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('themes/plugins/font-google/font-google.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('themes/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('themes/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('themes/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('themes/dist/css/adminlte.min.css') }}">

    @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed skin-blue">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('assets/store.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-exsand-angle-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                            <i class="fa fa-user-circle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a
                            class="dropdown-item main-btn-delete"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt px-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-2">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('themes/dist/img/logo-daun.png') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">Abata Group</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/user.png') }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
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
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        @if (Auth::user()->employee_id == null)
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link {{ request()->is(['home', 'home/*']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('master/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('master/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i><p>Master<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('employee.index') }}" class="nav-link {{ request()->is('master/employee') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Karyawan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('position.index') }}" class="nav-link {{ request()->is('master/position') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Jabatan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('nav.index') }}" class="nav-link {{ request()->is('master/nav') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Navigasi</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('master/user') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('product_category.index') }}" class="nav-link {{ request()->is('master/product_category') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Kategori Produk</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('product.index') }}" class="nav-link {{ request()->is('master/product') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Produk</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('shop.index') }}" class="nav-link {{ request()->is('master/shop') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Toko</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ request()->is('inventory_transaction/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('inventory_transaction/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-arrows-alt-h"></i><p>Transaksi Gudang<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('product_in.index') }}" class="nav-link {{ request()->is('inventory_transaction/product_in') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Produk Masuk</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('inventory_invoice.index') }}" class="nav-link {{ request()->is('inventory_transaction/inventory_invoice') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Produk Keluar</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('supplier.index') }}" class="nav-link {{ request()->is(['supplier', 'supplier/*']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-hand-holding-usd"></i><p>Supplier</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('promo.index') }}" class="nav-link {{ request()->is(['promo', 'promo/*']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-bullhorn"></i><p>Promo</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('report/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('report/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-clipboard"></i><p>Laporan<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('report.index') }}" class="nav-link {{ request()->is('report/index') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Penjualan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('report.customer_index') }}" class="nav-link {{ request()->is('report/customer_index') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Customer</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('report.product_index') }}" class="nav-link {{ request()->is('report/product_index') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Produk</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('report.income_index') }}" class="nav-link {{ request()->is('report/product_index') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Laba Rugi</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product_shop.index') }}" class="nav-link {{ request()->is(['product_shop', 'product_shop/*']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box-open"></i><p>Produk</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('shop_transaction/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('shop_transaction/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-arrows-alt-h"></i><p>Transaksi Toko<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('received_product.index') }}" class="nav-link {{ request()->is('shop_transaction/received_product') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Produk Masuk</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('invoice.index') }}" class="nav-link {{ request()->is('shop_transaction/invoice') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Penjualan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customer.index') }}" class="nav-link {{ request()->is(['customer', 'customer/*']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-child"></i><p>Customer</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('cashier/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('cashier/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cash-register"></i><p>Kasir<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('cashier.index') }}" class="nav-link {{ request()->is('cashier/cashier') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Cash</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('cashier.credit') }}" class="nav-link {{ request()->is('cashier/credit') ? 'active' : '' }}">
                                            <i class="fas fa-angle-right nav-icon"></i><p>Tempo</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif (Auth::user()->roles == "admin")

                        @else
                            @foreach ($current_nav_mains as $item)
                                @if ($item->link == '#')
                                    <li class="nav-item {{ request()->is(''.$item->request.'/*') ? 'menu-open' : '' }}">
                                        <a href="#" class="nav-link {{ request()->is(''.$item->request.'/*') ? 'active' : '' }}">
                                            <i class="{{ $item->icon }}"></i> <p>{{ $item->title }}<i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @foreach ($current_menus as $item_menu)
                                                @if ($item_menu->main_id == $item->id)
                                                    <li class="nav-item">
                                                        <a href="{{ url($item_menu->navSub->link) }}" class="nav-link {{ request()->is([''.$item_menu->navSub->link.'', ''.$item_menu->navSub->link.'/*']) ? 'active' : '' }}">
                                                            <i class="fas fa-angle-right nav-icon"></i> <p>{{ $item_menu->navSub->title }}</p>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ url($item->link) }}" class="nav-link {{ request()->is([''.$item->request.'', ''.$item->request.'/*']) ? 'active' : '' }}">
                                            <i class="{{ $item->icon }}"></i> <p>{{ $item->title }}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        <!-- Main Footer -->
        <footer class="main-footer">
          <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
          All rights reserved.
          <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0
          </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('themes/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('themes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('themes/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('themes/dist/js/adminlte.js') }}"></script>

    @yield('script')
</body>
</html>

@endguest
