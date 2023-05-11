@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            {{-- stok --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase font-weight-bold">stok</h5>
                            <hr>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4">
                                    <a href="{{ route('dashboard.show', ["tersedia"]) }}" id="btn_stok_tersedia" class="text-secondary">
                                        <div class="info-box">
                                            <div class="overlay spin_tersedia d-none"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box-open"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Tersedia</span>
                                                <span class="info-box-number">{{ $count_stok_tersedia }} item</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4">
                                    <a href="{{ route('dashboard.show', ["sedikit"]) }}" id="btn_stok_sedikit" class="text-secondary">
                                        <div class="info-box mb-3">
                                            <div class="overlay spin_sedikit d-none"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-box-open"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Sedikit</span>
                                                <span class="info-box-number">{{ $count_stok_sedikit }} item</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- fix for small devices only -->
                                <div class="clearfix hidden-md-up"></div>

                                <div class="col-12 col-sm-6 col-md-4">
                                    <a href="{{ route('dashboard.show', ["habis"]) }}" id="btn_stok_habis" class="text-secondary">
                                        <div class="info-box mb-3">
                                            <div class="overlay spin_habis d-none"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-box-open"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Habis</span>
                                                <span class="info-box-number">{{ $count_stok_habis }} item</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- produk terlaris --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase font-weight-bold">produk terlaris</h5>
                            <hr>
                            <table id="tabel_produk" class="table table-bordered" style="font-size: 13px; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center text-indigo">No</th>
                                        <th class="text-center text-indigo">Nama Produk</th>
                                        <th class="text-center text-indigo">Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk_terlaris as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>
                                                @if ($item->product)
                                                    @if ($item->product->productMaster)
                                                        {{ $item->product->productMaster->name }} - {{ $item->product->product_name }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->total_qty }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- performa kasir --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase font-weight-bold">performa kasir</h5>
                            <hr>
                            <table id="tabel_kasir" class="table table-bordered" style="font-size: 13px; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center text-indigo">No</th>
                                        <th class="text-center text-indigo">Nama</th>
                                        <th class="text-center text-indigo">Toko</th>
                                        <th class="text-center text-indigo">Jumlah Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi_kasir as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>
                                              @if ($item->user)
                                                {{ $item->user->name }}                                                  
                                              @endif
                                            </td>
                                            <td>
                                              @if ($item->shop)
                                                {{ $item->shop->name }}                                                  
                                              @endif
                                              </td>
                                            <td class="text-center">{{ $item->total_transaksi }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')

<!-- DataTables  & Plugins -->
<script src="{{ asset('public/themes/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
$(document).ready(function () {
    $('#tabel_produk').DataTable();
    $('#tabel_kasir').DataTable();
});
</script>
@endsection
