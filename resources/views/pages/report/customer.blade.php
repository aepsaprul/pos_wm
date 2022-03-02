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
                <h3>Data Laporan Customer</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
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

        $('#opsi').select2();

        invoiceCustomerAll();
        function invoiceCustomerAll() {
            $('.data-table').empty();
            $.ajax({
                url: '{{ URL::route('report.customer_get_data') }}',
                type: 'GET',
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"datatable\" class=\"table table-striped table-bordered\" style=\"width:100%\">" +
                        "<thead style=\"background-color: #2A3F54;\">" +
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

                    $('#datatable').DataTable();
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

                        $('#datatable').DataTable();
                    }
                });
            }
        });
    } );
</script>
@endsection
