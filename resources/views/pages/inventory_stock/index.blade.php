@extends('layouts.app')

@section('style')

<link href="{{ asset('lib/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('lib/select2/css/select2.min.css') }}">

<style>
    .col-md-12,
    .col-md-12 button,
    .col-md-12 a {
        font-size: 12px;
    }
    .fas {
        font-size: 14px;
    }
    .btn {
        padding: .2rem .6rem;
    }
</style>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h6 class="text-uppercase text-center">Data Stok Gudang</h6>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row mb-2 mt-1">
                <div class="col-md-2">
                    <select name="opsi" id="opsi" class="form-control form-control-sm">
                        <option value="">--Pilih Opsi--</option>
                        <option value="1">Stok Keseluruhan</option>
                        <option value="2">Stok Hampir Habis</option>
                        <option value="3">Stok Kosong</option>
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="mb-5"></div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('lib/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/jszip.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        productAll();
        function productAll() {
            $('.card-body').empty();
            $.ajax({
                url: '{{ URL::route('inventory_stock.get_data') }}',
                type: 'GET',
                success: function(response) {
                    var stock_val = "" +
                    "<table id=\"table_one\" class=\"table table-bordered\">" +
                        "<thead style=\"background-color: #32a893;\">" +
                            "<tr>" +
                                "<th class=\"text-white text-center fw-bold\">No</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nama Product</th>" +
                                "<th class=\"text-white text-center fw-bold\">Stok</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.stocks, function(index, item) {
                                if (item.stock <= 20 && item.stock > 0) {
                                    var text_color = "style=\"color: #F3950D;\"";
                                }
                                if (item.stock <= 0) {
                                    var text_color = "class=\"text-danger\"";
                                }

                                stock_val += "" +
                                    "<tr";
                                    if (index % 2 == 1) {
                                       stock_val += " class=\"tabel_active\"";
                                    }
                                    stock_val += ">" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td>";
                                        if (item.product) {
                                            stock_val += "<span " + text_color + ">" + item.product.product_name + "</span>";
                                        } else {
                                            stock_val += "<span " + text_color + ">Produk Tidak Ada</span>";
                                        }
                                    stock_val += "</td>" +
                                        "<td class=\"text-center\"><span " + text_color + ">" + item.stock + "</span></td>" +
                                    "</tr>";
                            });
                        stock_val += "</tbody>" +
                    "</table>";

                    $('.card-body').append(stock_val);

                    $('#table_one').DataTable({
                        'ordering': false
                    });
                }
            });
        }

        function productLow() {
            $('.card-body').empty();
            $.ajax({
                url: '{{ URL::route('inventory_stock.low') }}',
                type: 'GET',
                success: function(response) {
                    var stock_val = "" +
                    "<table id=\"table_one\" class=\"table table-bordered\">" +
                        "<thead style=\"background-color: #32a893;\">" +
                            "<tr>" +
                                "<th class=\"text-white text-center fw-bold\">No</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nama Product</th>" +
                                "<th class=\"text-white text-center fw-bold\">Stok</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.stocks, function(index, item) {
                                stock_val += "" +
                                    "<tr";
                                    if (index % 2 == 1) {
                                       stock_val += " class=\"tabel_active\"";
                                    }
                                    stock_val += ">" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td>";
                                        if (item.product) {
                                            stock_val += "<span style=\"color: #F3950D;\">" + item.product.product_name + "</span>";
                                        } else {
                                            stock_val += "<span style=\"color: #F3950D;\">Produk Tidak Ada</span>";
                                        }
                                    stock_val += "</td>" +
                                        "<td class=\"text-center\"><span style=\"color: #F3950D;\">" + item.stock + "</span></td>" +
                                    "</tr>";
                            });
                        stock_val += "</tbody>" +
                    "</table>";

                    $('.card-body').append(stock_val);

                    $('#table_one').DataTable({
                        'ordering': false
                    });
                }
            });
        }

        function productEmpty() {
            $('.card-body').empty();
            $.ajax({
                url: '{{ URL::route('inventory_stock.empty') }}',
                type: 'GET',
                success: function(response) {
                    var stock_val = "" +
                    "<table id=\"table_one\" class=\"table table-bordered\">" +
                        "<thead style=\"background-color: #32a893;\">" +
                            "<tr>" +
                                "<th class=\"text-white text-center fw-bold\">No</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nama Product</th>" +
                                "<th class=\"text-white text-center fw-bold\">Stok</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.stocks, function(index, item) {
                                stock_val += "" +
                                    "<tr";
                                    if (index % 2 == 1) {
                                       stock_val += " class=\"tabel_active\"";
                                    }
                                    stock_val += ">" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td>";
                                        if (item.product) {
                                            stock_val += "<span class=\"text-danger\">" + item.product.product_name + "</span>";
                                        } else {
                                            stock_val += "<span class=\"text-danger\">Produk Tidak Ada</span>";
                                        }
                                    stock_val += "</td>" +
                                        "<td class=\"text-center\"><span class=\"text-danger\">" + item.stock + "</span></td>" +
                                    "</tr>";
                            });
                        stock_val += "</tbody>" +
                    "</table>";

                    $('.card-body').append(stock_val);

                    $('#table_one').DataTable({
                        'ordering': false
                    });
                }
            });
        }

        $('#opsi').on('change', function() {
            if ($(this).val() == 1) {
                productAll();
            }
            else if ($(this).val() == 2) {
                productLow();
            }
            else if ($(this).val() == 3) {
                productEmpty();
            }
            else {
                productAll();
            }

        });
    } );
</script>
@endsection
