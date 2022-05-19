@guest

@yield('content')

@else

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('public/assets/icon.png') }}" rel="icon" type="image/x-icon">
    <title>{{ config('app.name', 'E - SPK') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('public/themes/plugins/font-google/font-google.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('public/themes/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('public/themes/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('public/themes/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/themes/dist/css/adminlte.min.css') }}">

    @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed
        @php
            if (request()->is('cashier')) {
                echo "sidebar-collapse";
            }
            if (request()->is('inventory_cashier')) {
                echo "sidebar-collapse";
            }
        @endphp
    ">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('public/assets/icon.png') }}" alt="AdminLTELogo" height="60" width="60">
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
                    <a
                        class="nav-link text-lg"
                        data-toggle="dropdown">
                            <i class="fas fa-shopping-cart"></i>
                            @if ($current_carts != null)
                                @if ($current_count_carts != 0)
                                    <span
                                        id="badge"
                                        class="badge badge-danger navbar-badge rounded-circle px-1 font-weight-bold"
                                        style="border: 2px solid #fff; margin-top: -10px; font-size: 10px; font-family:Arial, Helvetica, sans-serif">
                                            {{ $current_count_carts }}
                                    </span>
                                @endif
                            @endif
                    </a>
                    @if ($current_carts != null)
                        @if ($current_count_carts != 0)
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('shop_buy.cart') }}" class="dropdown-item dropdown-header p-0">Lihat Semuanya</a>
                                @foreach ($current_carts as $item)
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item py-0">
                                        <div class="media">
                                            <img src="{{ asset('public/image/' . $item->product->productMaster->image) }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                            <div class="media-body">
                                                <h3 class="dropdown-item-title">{{ $item->product->product_name }}</h3>
                                                <small>Rp. {{ rupiah($item->product->product_price_selling) }} / {{ $item->product->unit }}</small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-lg" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        @if ($current_notifs != null)
                            @if ($current_count_notifs != 0)
                            <span
                                id="badge"
                                class="badge badge-danger navbar-badge rounded-circle px-1 font-weight-bold"
                                style="border: 2px solid #fff; margin-top: -5px; font-size: 10px; font-family:Arial, Helvetica, sans-serif">
                                    {{ $current_count_notifs }}
                            </span>
                            @endif
                        @endif
                    </a>
                    @if (Auth::user()->employee_id != null)
                        @if (Auth::user()->employee->shop->category == "gudang")
                            @if (count($current_notif_transactions) > 0)
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <a href="{{ route('inventory_invoice.index') }}" class="dropdown-item">
                                    Transaksi
                                    @if ($current_count_notif_transactions != 0)
                                        <span class="float-right text-sm rounded-circle bg-danger px-2">{{ $current_count_notif_transactions }}</span>
                                    @endif
                                    </a>
                                </div>
                            @endif
                        @else
                            @if (count($current_notif_transactions) > 0)
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <a href="{{ route('transaction.index') }}" class="dropdown-item">
                                    Transaksi
                                    @if ($current_count_notif_transactions != 0)
                                        <span class="float-right text-sm rounded-circle bg-danger px-2">{{ $current_count_notif_transactions }}</span>
                                    @endif
                                    </a>
                                </div>
                            @endif
                        @endif
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link text-lg" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle text-lg"
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
                <img src="{{ asset('public/assets/icon.png') }}" alt="WM Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">Aplikasi POS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('public/assets/user.png') }}" class="img-circle" alt="User Image">
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
                <nav class="mt-2 pb-3">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        @if (Auth::user()->employee_id == null)
                            <li class="nav-item">
                                <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->is(['dashboard', 'dashboard/*']) ? 'active' : '' }}">
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
                                        <a href="{{ route('user.index') }}" class="nav-link {{ request()->is(['master/user', 'master/user/*']) ? 'active' : '' }}">
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
                            <li class="nav-item">
                                <a href="{{ route('shop_buy.index') }}" class="nav-link {{ request()->is(['shop_buy', 'shop_buy/*']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-shopping-bag"></i><p>Belanja</p>
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
                        @else
                            @foreach ($current_nav_mains as $item)
                                @if ($item->link == '#')
                                    <li class="nav-item {{ request()->is(''.$item->request.'/*') ? 'menu-open' : '' }}">
                                        <a href="#" class="nav-link {{ request()->is(''.$item->request.'/*') ? 'active' : '' }}">
                                            <i class="nav-icon {{ $item->icon }}"></i> <p>{{ $item->title }}<i class="right fas fa-angle-left"></i></p>
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
                                            <i class="nav-icon {{ $item->icon }}"></i> <p>{{ $item->title }}</p>
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
          <strong>Copyright &copy; 2014-2021 <a href="#">Warung Mitra</a>.</strong>
          All rights reserved.
          <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0
          </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('public/themes/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('public/themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('public/themes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('public/themes/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('public/themes/dist/js/adminlte.js') }}"></script>

    <script>
        function format_rupiah(bilangan) {
            var	number_string = bilangan.toString(),
                split	= number_string.split(','),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            return rupiah;
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
        }

        function tanggal(date) {
            var date = new Date(date);
            var tahun = date.getFullYear();
            var nomorbulan = date.getMonth() + 1;
            var bulan = date.getMonth();
            var tanggal = date.getDate();
            var hari = date.getDay();
            var jam = date.getHours();
            var menit = date.getMinutes();
            var detik = date.getSeconds();
            switch(hari) {
            case 0: hari = "Minggu"; break;
            case 1: hari = "Senin"; break;
            case 2: hari = "Selasa"; break;
            case 3: hari = "Rabu"; break;
            case 4: hari = "Kamis"; break;
            case 5: hari = "Jum'at"; break;
            case 6: hari = "Sabtu"; break;
            }
            switch(bulan) {
            case 0: bulan = "Januari"; break;
            case 1: bulan = "Februari"; break;
            case 2: bulan = "Maret"; break;
            case 3: bulan = "April"; break;
            case 4: bulan = "Mei"; break;
            case 5: bulan = "Juni"; break;
            case 6: bulan = "Juli"; break;
            case 7: bulan = "Agustus"; break;
            case 8: bulan = "September"; break;
            case 9: bulan = "Oktober"; break;
            case 10: bulan = "November"; break;
            case 11: bulan = "Desember"; break;
            }

            let no_bln;
            if (nomorbulan < 10) {
                no_bln = "0" + nomorbulan;
            } else {
                no_bln = nomorbulan;
            }

            let no_tgl;

            if (tanggal < 10) {
                no_tgl = "0" + tanggal;
            } else {
                no_tgl = tanggal;
            }

            return tampilTanggal = no_tgl + "-" + no_bln + "-" + tahun;
            // var tampilWaktu = "Jam: " + jam + ":" + menit + ":" + detik;
            // console.log(tampilTanggal);
            // console.log(tampilWaktu);
        }
    </script>

    @yield('script')
</body>
</html>

@endguest
