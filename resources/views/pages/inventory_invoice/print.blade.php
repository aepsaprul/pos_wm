<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('public/themes/plugins/font-google/font-google.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('public/themes/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/themes/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
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
                                    <small class="float-right">Tanggal: {{ tgl_indo(date('Y-m-d')) }}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-6 invoice-col">
                                To
                                <address>
                                    <strong>{{ Auth::user()->employee->shop->name }}</strong>,
                                    {{ Auth::user()->employee->shop->address }},
                                    {{ Auth::user()->employee->shop->contact }},
                                    {{ Auth::user()->employee->shop->email }}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6 invoice-col">
                                Invoice <b>{{ $invoices->code }}</b>,
                                Tempo Bayar: <b>{{ $invoices->tanggal_tempo }}</b>,
                                Waktu Pengiriman: <b>{{ $invoices->waktu_pengiriman }}</b>
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
                                                <td>
                                                    @if ($item->product)
                                                      {{ $item->product->product_name }}
                                                    @else
                                                      produk tidak ada
                                                    @endif
                                                </td>
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

                                    {{-- <p class="lead">Setelah Pembayaran:</p>

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        <ol>
                                            <li>Buka Aplikasi Whatsapp</li>
                                            <li>Kirim pesan dengan format seperti di bawah, ke nomor 08123567788</li>
                                        </ol>
                                    </p>

                                    <p class="lead">Format Pesan:</p>

                                    Nama: _____<br>
                                    Kode Invoice: _____<br>
                                    Nominal Transfer: _____ --}}
                                @else
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        <ul>
                                            <li>Transfer Via Bank BRI, 0106-0100-0956-568 a.n Endro prasetyo,se</li>
                                        </ul>
                                    </p>

                                    {{-- <p class="lead">Setelah Pembayaran:</p>

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        <ol>
                                            <li>Buka Aplikasi Whatsapp</li>
                                            <li>Kirim pesan dengan format seperti di bawah, ke nomor 08123567788</li>
                                        </ol>
                                    </p>

                                    <p class="lead">Format Pesan:</p>

                                    Nama: _____<br>
                                    Kode Invoice: _____<br>
                                    Nominal Transfer: _____ --}}
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
                    </div>
                    <!-- /.invoice -->
                </div>
            </div>
        </div>
    </section>
</div>

<script>
window.addEventListener("load", window.print());
</script>
</body>
</html>
