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
                    <h1 class="m-0">Laporan Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Customer</li>
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
                                    <select name="opsi" id="opsi" class="form-control form-control-sm">
                                        <option value="">--Pilih Opsi--</option>
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}">{{ $item->customer_name }}</option>
                                        @endforeach
                                    </select>
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

        $('#opsi').select2();

        invoiceCustomerAll();
        function invoiceCustomerAll() {
            $('.data-table').empty();
            $.ajax({
                url: "{{ URL::route('report.customer_get_data') }}",
                type: 'GET',
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead class=\"bg-info\">" +
                            "<tr>" +
                                "<th class=\"text-center text-light\">No</th>" +
                                "<th class=\"text-center text-light\">Customer</th>" +
                                "<th class=\"text-center text-light\">Jumlah Transaksi</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr>" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td>";

                                        if (item.customer) {
                                            invoice_val += item.customer.customer_name;
                                        } else {
                                            invoice_val += "Customer Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.transactions + "</td>" +
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

        $('#opsi').on('change', function() {
            if ($(this).val() == "") {
                invoiceCustomerAll();
            }
            else {
                $('.data-table').empty();

                var id = $(this).val();
                var url = '{{ route("report.customer_detail", ":id") }}';
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
                                            invoice_val += item.customer.customer_name;
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
