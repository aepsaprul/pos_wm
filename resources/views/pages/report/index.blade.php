@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Penjualan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Penjualan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-2 mt-1">
                                <div class="col-md-2">
                                    <label for="select_shop">Pilih Toko</label>
                                    <select name="select_shop" id="select_shop" class="form-control form-control-sm select_shop">
                                        <option value="0">--Pilih Toko--</option>
                                        @foreach ($shops as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="select_cashier">Pilih Kasir</label>
                                    <select name="select_cashier" id="select_cashier" class="form-control form-control-sm select_cashier">
                                        <option value="0">--Pilih Kasir--</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="opsi">Pilih Opsi</label>
                                    <select name="opsi" id="opsi" class="form-control form-control-sm">
                                        <option value="0">--Pilih Opsi--</option>
                                        <option value="1">Data Keseluruhan</option>
                                        <option value="2">Data Bukan Customer</option>
                                        <option value="3">Data Customer</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="start_date">Tanggal Awal</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2">
                                    <label for="start_date"></label>
                                    <button
                                        class="btn btn-primary btn-sm btn-search text-white pl-3 pr-3 pt-2 pb-2 mt-4"
                                        title="Tambah">
                                            <i class="fa fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="data-table">
                            </div>
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
<!-- Select2 -->
<script src="{{ asset('public/themes/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('.select_cashier').select2();

        invoiceSalesCurrent();
        function invoiceSalesCurrent() {
            $('.data-table').empty();
            $.ajax({
                url: "{{ URL::route('report.sales_get_data_current') }}",
                type: 'GET',
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead class=\"bg-info\">" +
                            "<tr>" +
                                "<th class=\"text-center text-light\">No</th>" +
                                "<th class=\"text-center text-light\">Tanggal</th>" +
                                "<th class=\"text-center text-light\">Nama Kasir</th>" +
                                "<th class=\"text-center text-light\">Customer</th>" +
                                "<th class=\"text-center text-light\">Nego</th>" +
                                "<th class=\"text-center text-light\">Kode Nota</th>" +
                                "<th class=\"text-center text-light\">Total</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr>" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                        "<td>";

                                        if (item.user) {
                                            invoice_val += item.user.name;
                                        } else {
                                            invoice_val += "User Tidak Ada";
                                        }

                                        invoice_val += "</td><td>";

                                        if (item.customer) {
                                            invoice_val += "<span class=\"text-primary\">" + item.customer.customer_name + "</span>";
                                        } else {
                                            invoice_val += "Customer Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.bid + "</td>" +
                                        "<td class=\"text-center\">" + item.code + "</td>" +
                                        "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                    "</tr>";
                            });
                        invoice_val += "</tbody>" +
                    "</table>";

                    $('.data-table').append(invoice_val);

                    $('#datatable').DataTable({
                        'responsive': true
                    });
                }
            });
        }

        function invoiceSalesAll() {
            $('.data-table').empty();

            var formData = {
                opsi: $('#opsi').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('report.sales_get_data') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response.invoices);
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead class=\"bg-info\">" +
                            "<tr>" +
                                "<th class=\"text-center text-light\">No</th>" +
                                "<th class=\"text-center text-light\">Tanggal</th>" +
                                "<th class=\"text-center text-light\">Nama Kasir</th>" +
                                "<th class=\"text-center text-light\">Customer</th>" +
                                "<th class=\"text-center text-light\">Nego</th>" +
                                "<th class=\"text-center text-light\">Kode Nota</th>" +
                                "<th class=\"text-center text-light\">Total</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr";
                                    if (index % 2 == 1) {
                                       invoice_val += " class=\"tabel_active\"";
                                    }
                                    invoice_val += ">" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                        "<td class=\"text-center\">";

                                        if (item.user) {
                                            invoice_val += item.user.name;
                                        } else {
                                            invoice_val += "User Tidak Ada";
                                        }

                                        invoice_val += "</td><td>";

                                        if (item.customer) {
                                            invoice_val += "<span class=\"text-primary\">" + item.customer.customer_name + "</span>";
                                        } else {
                                            invoice_val += "Customer Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.bid + "</td>" +
                                        "<td class=\"text-center\">" + item.code + "</td>" +
                                        "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                    "</tr>";
                            });
                        invoice_val += "</tbody>" +
                    "</table>";

                    $('.data-table').append(invoice_val);

                    $('#datatable').DataTable({
                        'responsive': true
                    });
                }
            });
        }

        function invoiceSalesNotCustomer() {
            $('.data-table').empty();

            var formData = {
                opsi: $('#opsi').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('report.sales_not_customer') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead class=\"bg-info\">" +
                            "<tr>" +
                                "<th class=\"text-center text-light\">No</th>" +
                                "<th class=\"text-center text-light\">Tanggal</th>" +
                                "<th class=\"text-center text-light\">Nama Kasir</th>" +
                                "<th class=\"text-center text-light\">Nego</th>" +
                                "<th class=\"text-center text-light\">Kode Nota</th>" +
                                "<th class=\"text-center text-light\">Total</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr>" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                        "<td>";

                                        if (item.user) {
                                            invoice_val += item.user.name;
                                        } else {
                                            invoice_val += "User Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.bid + "</td>" +
                                        "<td class=\"text-center\">" + item.code + "</td>" +
                                        "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                    "</tr>";
                            });
                        invoice_val += "</tbody>" +
                    "</table>";

                    $('.data-table').append(invoice_val);

                    $('#datatable').DataTable({
                        'responsive': true
                    });
                }
            });
        }

        function invoiceSalesCustomer() {
            $('.card-body').empty();

            var formData = {
                opsi: $('#opsi').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('report.sales_customer') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead class=\"bg-info\">" +
                            "<tr>" +
                                "<th class=\"text-center text-light\">No</th>" +
                                "<th class=\"text-center text-light\">Tanggal</th>" +
                                "<th class=\"text-center text-light\">Nama Kasir</th>" +
                                "<th class=\"text-center text-light\">Customer</th>" +
                                "<th class=\"text-center text-light\">Diskon</th>" +
                                "<th class=\"text-center text-light\">Nego</th>" +
                                "<th class=\"text-center text-light\">Kode Nota</th>" +
                                "<th class=\"text-center text-light\">Total</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr>" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                        "<td>";

                                        if (item.user) {
                                            invoice_val += item.user.name;
                                        } else {
                                            invoice_val += "User Tidak Ada";
                                        }

                                        invoice_val += "</td><td>";

                                        if (item.customer) {
                                            invoice_val += item.customer.customer_name;
                                        } else {
                                            invoice_val += "Customer Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.discount + "</td>" +
                                        "<td class=\"text-center\">" + item.bid + "</td>" +
                                        "<td class=\"text-center\">" + item.code + "</td>" +
                                        "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                    "</tr>";
                            });
                        invoice_val += "</tbody>" +
                    "</table>";

                    $('.data-table').append(invoice_val);

                    $('#datatable').DataTable({
                        'responsive': true
                    });
                }
            });
        }

        $('#select_shop').on('change', function() {

            $('#select_cashier').empty();

            var id = $(this).val();
            var url = '{{ route("report.sales_shop", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: url,
                data: formData,
                type: 'GET',
                success: function(response) {
                    var value_employee = "<option value=\"0\">--Pilih Kasir--</option>"
                    $.each(response.cashiers, function(index, item) {
                        value_employee += "<option value=\"" + item.id + "\">" + item.full_name + "</option>";
                    });
                    $('#select_cashier').append(value_employee);
                }
            });
        });

        $('.btn-search').on('click', function() {
            if ($('#start_date').val() == "" || $('#end_date').val() == "") {
                alert('Tanggal harus diisi!');
            } else {
                var shop_id = $('#select_shop').val();
                var cashier_id = $('#select_cashier').val();
                var opsi = $('#opsi').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();

                var formData = {
                    shop_id: shop_id,
                    cashier_id: cashier_id,
                    opsi: opsi,
                    start_date: start_date,
                    end_date: end_date,
                    _token: CSRF_TOKEN
                }

                $('.data-table').empty();

                $.ajax({
                    url: "{{ URL::route('report.sales_search') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var invoice_val = "" +
                        "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                            "<thead class=\"bg-info\">" +
                                "<tr>" +
                                    "<th class=\"text-center text-light\">No</th>" +
                                    "<th class=\"text-center text-light\">Tanggal</th>" +
                                    "<th class=\"text-center text-light\">Nama Kasir</th>" +
                                    "<th class=\"text-center text-light\">Customer</th>" +
                                    "<th class=\"text-center text-light\">Nego</th>" +
                                    "<th class=\"text-center text-light\">Kode Nota</th>" +
                                    "<th class=\"text-center text-light\">Total</th>" +
                                "</tr>" +
                            "</thead>" +
                            "<tbody>";
                                $.each(response.invoices, function(index, item) {
                                    invoice_val += "" +
                                        "<tr>" +
                                            "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                            "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                            "<td class=\"text-center\">";

                                            if (item.user) {
                                                invoice_val += item.user.name;
                                            } else {
                                                invoice_val += "User Tidak Ada";
                                            }

                                            invoice_val += "</td><td>";

                                            if (item.customer) {
                                                invoice_val += "<span class=\"text-primary\">" + item.customer.customer_name + "</span>";
                                            } else {
                                                invoice_val += "Customer Tidak Ada";
                                            }

                                        invoice_val += "</td>" +
                                            "<td class=\"text-center\">" + item.bid + "</td>" +
                                            "<td class=\"text-center\">" + item.code + "</td>" +
                                            "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                        "</tr>";
                                });
                            invoice_val += "</tbody>" +
                        "</table>";

                        $('.data-table').append(invoice_val);

                        $('#datatable').DataTable({
                            'responsive': true
                        });
                    }
                });
            }
        });
    } );
</script>
@endsection
