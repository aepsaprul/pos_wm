@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Laba Rugi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Laba Rugi</li>
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
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead class="bg-info">
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
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        salesAll();
        function salesAll() {
            $('.table_data').empty();
            $.ajax({
                url: "{{ URL::route('report.income_get_data') }}",
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
                    url: "{{ URL::route('report.income_filter') }}",
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
