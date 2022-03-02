@extends('layouts.app')

@section('style')

<!-- Datatables -->
<link href="{{ asset('theme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

{{-- select2 --}}
<link rel="stylesheet" href="{{ asset('theme/vendors/select2/dist/css/select2.min.css') }}">

@endsection

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Data Laporan Penjualan</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="row mb-2 mt-1">
                            <div class="col-md-2">
                                <label for="select_shop">Pilih Toko</label>
                                <select name="select_shop" id="select_shop" class="form-control select_shop">
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
                                <select name="opsi" id="opsi" class="form-control">
                                    <option value="0">--Pilih Opsi--</option>
                                    <option value="1">Data Keseluruhan</option>
                                    <option value="2">Data Bukan Customer</option>
                                    <option value="3">Data Customer</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="start_date">Tanggal Awal</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="end_date">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
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
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <div class="data-table">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

@endsection

@section('script')

<!-- Datatables -->
<script src="{{ asset('theme/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('theme/vendors/jszip/dist/jszip.min.js') }}"></script>
<script src="{{ asset('theme/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('theme/vendors/pdfmake/build/vfs_fonts.js') }}"></script>

{{-- select2 --}}
<script src="{{ asset('theme/vendors/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#select_cashier').select2();

        invoiceSalesCurrent();
        function invoiceSalesCurrent() {
            $('.data-table').empty();
            $.ajax({
                url: '{{ URL::route('report.sales_get_data_current') }}',
                type: 'GET',
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead style=\"background-color: #2A3F54;\">" +
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

                    $('#datatable').DataTable();
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
                url: '{{ URL::route('report.sales_get_data') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response.invoices);
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead style=\"background-color: #2A3F54;\">" +
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

                    $('#datatable').DataTable();
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
                url: '{{ URL::route('report.sales_not_customer') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead style=\"background-color: #2A3F54;\">" +
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

                    $('#datatable').DataTable();
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
                url: '{{ URL::route('report.sales_customer') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead style=\"background-color: #2A3F54;\">" +
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

                    $('#datatable').DataTable();
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
                    url: '{{ URL::route('report.sales_search') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var invoice_val = "" +
                        "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                            "<thead style=\"background-color: #2A3F54;\">" +
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

                        $('#datatable').DataTable();
                    }
                });
            }
        });
    } );
</script>
@endsection
