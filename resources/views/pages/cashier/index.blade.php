<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/maskot.png') }}">

    <title>{{ config('app.name', 'POS') }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('theme/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('theme/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{ asset('theme/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet"/>
    <!-- NProgress -->
    <link href="{{ asset('theme/vendors/nprogress/nprogress.css') }}" rel="stylesheet">

    <!-- PNotify -->
    <link href="{{ asset('theme/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('theme/build/css/custom.min.css') }}" rel="stylesheet">

    {{-- select2 --}}
    <link rel="stylesheet" href="{{ asset('theme/vendors/select2/dist/css/select2.min.css') }}">

    <style>
        .table,
        .col-form-label,
        .total_price_show,
        .promo-row {
            color: #fff;
        }
    </style>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
        <!-- page content -->
        <div class="col-md-12 page-content">
            <div class="x_title text-center mt-2">
                <a
                    href="{{ route('home') }}"
                    class="btn btn-primary btn-sm text-white pl-3 pr-3"
                        title="Tambah">
                            <i class="fa fa-home"></i> Kembali Ke Halaman Home
                </a>
            </div>
            <div class="container mt-3">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                        <div class="mb-1 row">
                            <label for="product_code" class="col-sm-4 col-form-label"><strong>Kode Produk</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="product_code" name="product_code" autocomplete="off" autofocus>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="product_manual" class="col-sm-4 col-form-label"><strong>Nama Produk</strong></label>
                            <div class="col-sm-8">
                                <select name="product_manual" id="product_manual" class="form-control form-control-sm product_manual_select2" style="width: 100%;">
                                    <option value="">Manual</option>
                                    @foreach ($product_manuals as $item)
                                        <option value="{{ $item->product->id }}">{{ $item->product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="quantity" class="col-sm-4 col-form-label"><strong>Quantity</strong></label>
                            <div class="col-sm-8">
                                <input type="number" min="0" class="form-control form-control-sm" id="quantity" name="quantity">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-1 row">
                            <label for="pay_method" class="col-sm-4 col-form-label"><strong>Metode Bayar</strong></label>
                            <div class="col-sm-8">
                                <select name="pay_method" id="pay_method" class="form-control form-control-sm">
                                    <option value="0">--Pilih Metode--</option>
                                    <option value="cash">Cash</option>
                                    <option value="edc">EDC</option>
                                    <option value="warungmitra">Warung Mitra</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-1 row promo-row">

                        </div>
                        <div class="mb-1 row" id="div_pay">
                            <label for="pay" class="col-sm-4 col-form-label"><strong>Bayar</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="pay" name="pay">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="change" class="col-sm-4 col-form-label">Kembalian</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="change" name="change" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-1 row">
                            <label for="product_code" class="col-sm-4 col-form-label"><strong>Customer</strong></label>
                            <div class="col-sm-8">
                                <select name="customer_id" id="customer_id" class="form-control form-control-sm select_customer" style="width: 100%;" autofocus>
                                    <option value="">--Pilih Customer--</option>
                                    @foreach ($customers as $item)
                                        <option value="{{ $item->id }}">{{ $item->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="bid" class="col-sm-4 col-form-label"><strong>Nego</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="bid" name="bid">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="row">
                            <input type="hidden" class="form-control" id="product_id" name="product_id">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control form-control-sm" id="product_name" name="product_name" disabled>
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stok</label>
                                    <input type="text" class="form-control form-control-sm" id="stock" name="stock" disabled>
                                </div>
                            </div> --}}
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="product_price" class="form-label">Harga Satuan (Rp)</label>
                                    <input type="text" class="form-control form-control-sm" id="product_price" name="product_price" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="final_price" class="form-label">Harga Akhir (Rp)</label>
                                    <input type="text" class="form-control form-control-sm" id="final_price" name="final_price" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <input
                                        type="hidden"
                                        class="form-control form-control-sm"
                                        id="discount"
                                        name="discount">
                                    <input
                                        type="hidden"
                                        class="form-control form-control-sm"
                                        id="before_discount"
                                        name="before_discount"
                                        value="{{ $total_price }}">
                                    <input
                                        type="hidden"
                                        name="total_price"
                                        id="total_price"
                                        value="{{ $total_price }}">
                                    <div class="p-3 text-center h5">
                                        Rp. <span class="total_price_show">{{ rupiah($total_price) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button type="button" class="btn btn-success py-3 px-4 btn-print">PRINT</button>
                            <button type="button" class="btn btn-outline-danger py-3 px-4 btn-reset">RESET</button>
                        </div>
                    </div>
                </div>
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead style="background-color: #828282;">
                        <tr>
                            <th class="text-center text-white">No</th>
                            <th class="text-center text-white">Kode Produk</th>
                            <th class="text-center text-white">Nama Produk</th>
                            <th class="text-center text-white">Harga Satuan</th>
                            <th class="text-center text-white">Qty</th>
                            <th class="text-center text-white">Harga Akhir</th>
                            <th class="text-center text-white">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $item->product->product_code }}</td>
                                <td>{{ $item->product->product_name }}</td>
                                <td class="text-right">{{ rupiah($item->product->product_price_selling) }}</td>
                                <td class="text-center">{{ rupiah($item->quantity) }}</td>
                                <td class="text-right">{{ rupiah($item->product->product_price_selling * $item->quantity) }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <form
                                            action="{{ route('cashier.delete', [$item->id]) }}"
                                            method="POST"
                                            class="d-inline">
                                                @method('delete')
                                                @csrf
                                                    <button
                                                        class="border-0 bg-transparent text-white"
                                                        onclick="return confirm('Yakin akan dihapus?')"
                                                        title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!-- /page content -->
        {{-- invoice --}}
        <div class="container-fluid invoice">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-4 border border-1">
                    <h3 class="h3 text-center">Nama Toko</h3>
                    <p class="text-center">Jl. Pahlawan Tanpa Tanda Jasa No 2 Timur Masjid Agung</p>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-6">
                            <span>Kode Nota</span>
                            <span class="invoice_code"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6 text-end">
                            <span class="invoice_date"></span>
                            <span class="invoice_time"></span>
                        </div>
                    </div>
                    <hr style="border: 2px dashed #000;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12 invoice_data">
                            <table width="100%">
                                @foreach ($sales as $key => $item)
                                <tr>
                                    <td>{{ $item->product->product_name }}</td>
                                    <td>{{ rupiah($item->quantity) }}</td>
                                    <td class="text-end">{{ rupiah($item->product->product_price_selling * $item->quantity) }}</td>
                                </tr>
                                @endforeach
                                <tr class="nego_layout">
                                    {{-- content in jquery --}}
                                </tr>
                                <tr>
                                    <td class="text-end">Total</td>
                                    <td>:</td>
                                    <td class="text-end print_total_price" style="border-top: 1px dashed #000;">{{ rupiah($total_price) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr style="border: 2px dashed #000;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12 text-center footer">
                            <span class="text-center">Telp: 081234567890</span><br>
                            <span class="text-center">Wa: 081234567890</span><br>
                            <span class="text-center">Email: toko@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('theme/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('theme/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery custom content scroller -->
    <script src="{{ asset('theme/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('theme/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('theme/vendors/nprogress/nprogress.js') }}"></script>

    <!-- PNotify -->
    <script src="{{ asset('theme/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('theme/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('theme/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('theme/build/js/custom.min.js') }}"></script>

    {{-- select2 --}}
    <script src="{{ asset('theme/vendors/select2/dist/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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

                return tampilTanggal = tanggal + "-" + nomorbulan + "-" + tahun;
                // var tampilWaktu = "Jam: " + jam + ":" + menit + ":" + detik;
                // console.log(tampilTanggal);
                // console.log(tampilWaktu);
            }

            $('.select_customer').select2();
            $('.product_manual_select2').select2();

            $('#product_code').on('keyup change', function() {
                var product_code = $('#product_code').val();
                var formData = {
                    product_code: product_code,
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: "{{ URL::route('cashier.product') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#product_id').val(response.product_id);
                        $('#product_name').val(response.product_name);
                        $('#stock').val(response.stock);
                        $('#quantity').val('1');

                        var product_price = format_rupiah(response.product_price);
                        $('#product_price').val(product_price);
                        $('#final_price').val(product_price);
                    }
                });
            });

            $('#product_code').on('keypress', function(event) {
                if (event.keyCode === 13) {
                    var product_id = $('#product_id').val();
                    var quantity = $('#quantity').val();
                    var product_price = $('#product_price').val();
                    var product_price_replace = product_price.replace('.', '');
                    var final_price = quantity * product_price_replace;

                    var formData = {
                        quantity: quantity,
                        product_id: product_id,
                        sub_total: final_price,
                        _token: CSRF_TOKEN
                    }

                    $.ajax({
                        url: '{{ URL::route('cashier.sales_save') }}',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            setTimeout(() => {
                                window.location.reload(1);
                            }, 100);
                        },
                        error: function(xhr, status, error){
                            var errorMessage = xhr.status + ': ' + xhr.statusText
                            alert('Error - ' + errorMessage);
                        }
                    });
                }
            });

            // product manual
            $('#product_manual').on('keyup change', function() {
                var product_manual = $('#product_manual').val();
                var formData = {
                    product_manual: product_manual,
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: '{{ URL::route('cashier.product') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#product_id').val(response.product_id);
                        $('#product_name').val(response.product_name);
                        $('#stock').val(response.stock);
                        $('#quantity').val('1');

                        var product_price = format_rupiah(response.product_price);
                        $('#product_price').val(product_price);
                        $('#final_price').val(product_price);
                    },
                    error: function(xhr, status, error){
                        var errorMessage = xhr.status + ': ' + xhr.statusText
                        alert('Error - ' + errorMessage);
                    }
                });
            });

            $('#quantity').on('keyup change', function() {
                var quantity = $('#quantity').val();
                var product_price = $('#product_price').val();
                var product_price_replace = product_price.replace('.', '');

                var final_price = quantity * product_price_replace;
                var final_price_rp = format_rupiah(final_price);
                $('#final_price').val(final_price_rp);
            });

            $('#quantity').on('keypress', function(event) {
                if (event.keyCode === 13) {
                    var product_id = $('#product_id').val();
                    var quantity = $('#quantity').val();
                    var product_price = $('#product_price').val();
                    var product_price_replace = product_price.replace('.', '');
                    var final_price = quantity * product_price_replace;

                    var formData = {
                        quantity: quantity,
                        product_id: product_id,
                        sub_total: final_price,
                        _token: CSRF_TOKEN
                    }

                    $.ajax({
                        url: '{{ URL::route('cashier.sales_save') }}',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            setTimeout(() => {
                                window.location.reload(1);
                            }, 100);
                        },
                        error: function(xhr, status, error){
                            var errorMessage = xhr.status + ': ' + xhr.statusText
                            alert('Error - ' + errorMessage);
                        }
                    });
                }
            });

            var payRupiah = document.getElementById("pay");
            payRupiah.addEventListener("keyup", function(e) {
                payRupiah.value = formatRupiah(this.value, "");
            });

            $('#pay_method').on('change', function() {
                $('.promo-row').empty();

                var pay_method = "";
                if ($(this).val() == "cash") {
                    pay_method += "cash";
                } else if ($(this).val() == "edc") {
                    pay_method += "edc";
                } else if ($(this).val() == "warungmitra") {
                    pay_method += "warungmitra";
                } else {
                    pay_method += "cash";
                }

                var formData = {
                    pay_method: pay_method,
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: '{{ URL::route('cashier.promo') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.promo != null) {
                            var value_promo = "" +
                                "<input type=\"hidden\" name=\"coupon_code\" id=\"coupon_code\" value=\"" + response.promo.coupon_code + "\">" +
                                "<label class=\"col-md-4 col-sm-4  control-label\">Promo</label>" +
                                "<div class=\"col-md-8 col-sm-8 \">" +
                                    "<label>" +
                                        "<input type=\"radio\" name=\"promo\" id=\"promo\" value=\"" + response.promo.discount_value + "\" checked> " + response.promo.coupon_code +
                                    "</label>" +
                                "</div>";
                            $('.promo-row').append(value_promo);

                            var total_sales = $('#total_price').val();
                            var promo = total_sales - response.promo.discount_value;
                            var promo_rp = format_rupiah(promo);
                            $('.total_price_show').text(promo_rp);
                            $('#total_price').val(promo);
                        }
                    },
                    error: function(xhr, status, error){
                        var errorMessage = xhr.status + ': ' + xhr.statusText
                        alert('Error - ' + errorMessage);
                    }
                });
            });

            $('#pay').on('keypress change', function(event) {
                if (event.keyCode === 13) {
                    var pay = $('#pay').val();
                    var pay_int = pay.replace(/\./g,'');
                    var total_price = $('#total_price').val();

                    if (parseInt(pay_int) < parseInt(total_price)) {
                        var money_min = total_price - pay_int;
                        $('#change').val("Bayar kurang " + format_rupiah(money_min));
                    } else if (pay == "") {
                        alert('Kolom bayar harus diisi');
                    } else {
                        var calculate = pay_int - total_price;
                        $('#change').val(format_rupiah(calculate));
                    }

                }
            });

            var bidRupiah = document.getElementById("bid");
            bidRupiah.addEventListener("keyup", function(e) {
                bidRupiah.value = formatRupiah(this.value, "");
            });

            $('#bid').on('keypress', function(event) {
                if (event.keyCode === 13) {
                    var bid = $('#bid').val().replace(/\./g,'');
                    var total_price = $('#total_price').val();
                    var nego = total_price - bid;
                    var negoRp = format_rupiah(nego);

                    var nego_val = "" +
                            "<td class=\"text-end\">Nego</td>" +
                            "<td>:</td>" +
                            "<td class=\"text-end print_harga_nego\" style=\"border-top: 1px dashed #000;\">" + $('#bid').val() + "</td>";

                    $('.nego_layout').append(nego_val);
                    $('.print_total_price').text(negoRp);
                    $('.total_price_show').text(negoRp);
                    $('#total_price').val(nego);
                }
            });

            $('.invoice').hide();

            $('#customer_id').on('change', function() {
                var total_price = $('#total_price').val();
                var before_discount = $('#before_discount').val();
                var discount = before_discount * 0.05;
                if ($(this).val() != "") {
                    var discount_total = before_discount - discount;
                    var discount_total_rp = format_rupiah(discount_total);

                    $('.total_price_show').text(discount_total_rp);
                    $('#total_price').val(discount_total);
                    $('#discount').val(discount);
                } else {
                    var discount_total = parseInt(total_price) + parseInt(discount);
                    var discount_total_rp = format_rupiah(discount_total);

                    $('.total_price_show').text(discount_total_rp);
                    $('#total_price').val(before_discount);
                }
            });

            $('.btn-print').on('click', function() {
                if ($('#total_price').val() == 0) {
                    alert('Data Pembelian Kosong');
                } else {

                    var formData = {
                        bid: $('#bid').val().replace(/\./g,''),
                        total_amount: $('#total_price').val(),
                        customer_id: $('#customer_id').val(),
                        promo: $('#promo').val(),
                        coupon_code: $('#coupon_code').val(),
                        discount: $('#discount').val(),
                        _token: CSRF_TOKEN
                    }

                    $.ajax({
                        url: '{{ URL::route('cashier.print') }}',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $('.invoice_code').append(response.invoice_code);
                            $('.invoice_date').append(response.invoice_date);
                            $('.invoice_time').append(response.invoice_time);

                            $('.page-content').hide();
                            $('nav').hide();
                            $('.invoice').show();
                            window.print();
                            window.onafterprint = window.location.reload(1);
                        }
                    });
                }
            });

            $('.btn-reset').on('click', function() {
                window.location.reload(1);
            });
        });
    </script>
</body>
</html>
