@extends('layouts.app')

@section('style')

@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <img src="{{ asset('public/assets/icon.png') }}" alt="icon wm" style="max-width: 50px;"> Warung Mitra.
                                    <small class="float-right">Date: {{ tgl_indo(date('Y-m-d')) }}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>Warung Mitra</strong><br>
                                    Jl Nusantara No. 20<br>
                                    Cilacap Utara<br>
                                    Telepon: (804) 123-5432<br>
                                    Email: info@gmail.com
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{ Auth::user()->employee->shop->name }}</strong><br>
                                    {{ Auth::user()->employee->shop->address }} <br>
                                    Telepon : {{ Auth::user()->employee->shop->contact }} <br>
                                    Email: {{ Auth::user()->employee->shop->email }}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Invoice <b>{{ $invoices->code }}</b><br>
                                Tempo Bayar: <b>{{ $invoices->tanggal_tempo }}</b><br>
                                Waktu Pengiriman: <br><b>{{ $invoices->waktu_pengiriman }}</b>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Produk</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices->productOut as $item)
                                            <tr>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->product->product_name }}</td>
                                                <td>{{ rupiah($item->sub_total) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Metode Pembayaran:</p>

                                @if ($invoices->payment_methods == "cod")
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        <ul>
                                            <li>Pembayaran COD, silahkan membayar ketika barang sudah sampai</li>
                                        </ul>
                                    </p>
                                @elseif ($invoices->payment_methods == "bca")
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        <ul>
                                            <li>Transfer Via Bank BCA, 434-0071-439 a.n Endro prasetyo,se</li>
                                        </ul>
                                    </p>

                                    <p class="lead">Setelah Pembayaran:</p>

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        <ol>
                                            <li>Buka Aplikasi Whatsapp</li>
                                            <li>Kirim pesan dengan format seperti di bawah, ke nomor 08123567788</li>
                                        </ol>
                                    </p>

                                    <p class="lead">Format Pesan:</p>

                                    Nama: _____<br>
                                    Kode Invoice: _____<br>
                                    Nominal Transfer: _____
                                @else
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        <ul>
                                            <li>Transfer Via Bank Mandiri, 434-0071-439 a.n Endro prasetyo,se</li>
                                        </ul>
                                    </p>

                                    <p class="lead">Setelah Pembayaran:</p>

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        <ol>
                                            <li>Buka Aplikasi Whatsapp</li>
                                            <li>Kirim pesan dengan format seperti di bawah, ke nomor 08123567788</li>
                                        </ol>
                                    </p>

                                    <p class="lead">Format Pesan:</p>

                                    Nama: _____<br>
                                    Kode Invoice: _____<br>
                                    Nominal Transfer: _____
                                @endif
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <table class="">
                                    <tr>
                                        <th style="width:50%">Total:</th>
                                        <td>Rp. {{ rupiah($invoices->total_amount) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{{ route('shop_buy.cart.invoice_print', [$invoices->code]) }}" rel="noopener" target="_blank" class="btn btn-default float-right"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')

@endsection
