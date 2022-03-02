@extends('layouts.app')

@section('style')

<!-- Datatables -->
<link href="{{ asset('theme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

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
                                <label for="start_date">Tanggal Awal</label>
                                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label for="end_date">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-1">
                                <label for="start_date"></label>
                                <button class="btn btn-primary btn-sm btn-search text-white pl-3 pr-3 mt-4 btn-search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead style="background-color: #2A3F54;">
                                            <tr>
                                                <th class="text-center text-light">Tanggal</th>
                                                <th class="text-center text-light">Omset</th>
                                                <th class="text-center text-light">Total HPP</th>
                                                <th class="text-center text-light">Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td id="raw_date" class="text-center"></td>
                                                <td id="raw_revenue" class="text-right"></td>
                                                <td id="raw_total_price" class="text-right"></td>
                                                <td id="raw_profit" class="text-right"></td>
                                            </tr>
                                        </tbody>
                                    </table>
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

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        salesAll();
        function salesAll() {
            $('.table_data').empty();
            $.ajax({
                url: '{{ URL::route('report.income_get_data') }}',
                type: 'GET',
                success: function(response) {
                    var sum_product_price = 0;
                    var sum_sub_total = 0;

                    $.each(response.sales, function(index, item) {
                        sum_product_price += parseFloat(item.quantity * item.product.product_price);
                        sum_sub_total += parseFloat(item.sub_total);
                        var total_profit =  sum_sub_total - sum_product_price;

                        $('#raw_date').html(tanggal(item.invoice.date_recorded));
                        $('#raw_revenue').html(format_rupiah(sum_product_price));
                        $('#raw_total_price').html(format_rupiah(sum_sub_total));
                        $('#raw_profit').html(format_rupiah(total_profit));
                    });
                }
            });
        }

        $('.btn-search').on('click', function(e) {
            e.preventDefault();
            $('.table_data').empty();

            if ($('#start_date').val() == "" || $('#end_date').val() == "") {
                alert('Tanggal harus diisi');
            } else {
                var formData = {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: '{{ URL::route('report.income_filter') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                    var sum_product_price = 0;
                    var sum_sub_total = 0;

                    $.each(response.sales, function(index, item) {
                        sum_product_price += parseFloat(item.quantity * item.product.product_price);
                        sum_sub_total += parseFloat(item.sub_total);
                        var total_profit =  sum_sub_total - sum_product_price;

                        var start_date = tanggal(response.start_date);
                        var end_date = tanggal(response.end_date);

                        $('#raw_date').html(start_date + " s/d " + end_date);
                        $('#raw_revenue').html(format_rupiah(sum_product_price));
                        $('#raw_total_price').html(format_rupiah(sum_sub_total));
                        $('#raw_profit').html(format_rupiah(total_profit));
                    });
                    }
                });
            }
        });
    } );
</script>
@endsection
