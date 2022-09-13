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
                    <h1 class="m-0">Data Penjualan Hari Ini</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="javascript:window.open('','_self').close();" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                        <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead class="bg-info">
                                    <tr>
                                        <th class="text-center text-light">No</th>
                                        <th class="text-center text-light">Tanggal</th>
                                        <th class="text-center text-light">Nama Kasir</th>
                                        <th class="text-center text-light">Kode Nota</th>
                                        <th class="text-center text-light">Total</th>
                                        <th class="text-center text-light">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ date('d-m-Y', strtotime($item->date_recorded)) }}</td>
                                            <td>
                                                @if ($item->user)
                                                    {{ $item->user->name }}
                                                @else
                                                    User Tidak Ada
                                                @endif
                                            </td>
                                            <td><a href="#" class="btn-detail" data-id="{{ $item->id }}">{{ $item->code }}</a></td>
                                            <td class="text-right">{{ rupiah($item->total_amount) }}</td>
                                            <td class="text-center">
                                                @if ($item->debt == null || $item->debt == 0)
                                                    <span class="text-capitalize">lunas</span>
                                                @else
                                                    <button type="button" class="btn-danger text-capitalize btn_bayar" data-id="{{ $item->id }}">bayar</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- total hari ini --}}
                            <p class="mt-5 text-capitalize">total penjualan hari ini <span class="font-weight-bold h3">Rp {{ rupiah($total_hari_ini) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- modal detail  --}}
<div class="modal fade modal-detail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="form_detail">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penjualan</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-1 row">
                        <label for="detail_code" class="col-sm-4 col-form-label"><strong>Kode Produk</strong></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="detail_code" name="detail_code" readonly>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="detail_date" class="col-sm-4 col-form-label"><strong>Tanggal</strong></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="detail_date" name="detail_date" readonly>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="detail_total_amount" class="col-sm-4 col-form-label"><strong>Total</strong></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="detail_total_amount" name="detail_total_amount" readonly>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <div class="col-md-12">
                            <table id="table_two" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center fw-bold">No</th>
                                        <th class="text-center fw-bold">Nama Produk</th>
                                        <th class="text-center fw-bold">Quantity</th>
                                        <th class="text-center fw-bold">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <div id="credit" class="col-md-12">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#datatable").DataTable({
            'responsive': true
        });

        // detail
        $('body').on('click', '.btn-detail', function(e) {
            e.preventDefault();
            $('#table_two tbody').empty();
            $('#credit').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("invoice.show", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('#detail_code').val(response.code);
                    $('#detail_date').val(response.date);
                    $('#detail_total_amount').val(format_rupiah(response.total_amount));

                    $.each(response.sales, function(index, item) {
                        var sales_val = "" +
                            "<tr>" +
                                "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                "<td>" + item.product.product_name + "</td>" +
                                "<td class=\"text-center\">" + item.quantity + "</td>" +
                                "<td class=\"text-end\">" + format_rupiah(item.sub_total) + "</td>" +
                            "</tr>";
                        $('#table_two tbody').append(sales_val);
                    });

                    if (response.count_credits != 0) {
                        let val_credit = '<h6 class="font-weight-bold">Tempo ' + response.count_credits + ' Minggu</h6>' +
                            '<table class="table table-bordered">' +
                                '<thead>' +
                                    '<tr>' +
                                        '<th>Nama Customer</th>' +
                                        '<th>Tanggal Bayar</th>' +
                                        '<th>Bayar</th>' +
                                        '<th>Piutang</th>' +
                                    '</tr>' +
                                '</thead>' +
                                '<tbody>';
                        $.each(response.credits, function (index, value) {
                            val_credit += '' +
                                '<tr>' +
                                    '<td>' + (value.customer ? value.customer.customer_name : '') + '</td>' +
                                    '<td>' + (value.pay_date != null ? tanggal(value.pay_date) : '') + '</td>' +
                                    '<td>' + (value.price != null ? format_rupiah(value.price) : '') + '</td>' +
                                    '<td>' + (value.debt != null ? format_rupiah(value.debt) : '') + '</td>' +
                                '</tr>';
                        })
                        val_credit += '</tbody></table>';
                        $('#credit').append(val_credit);
                    }

                    $('.modal-detail').modal('show');
                }
            });

        });
    } );
</script>
@endsection
