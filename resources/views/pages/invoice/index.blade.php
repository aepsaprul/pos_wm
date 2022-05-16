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
                    <h1 class="m-0">Data Penjualan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Penjualan</li>
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
                                        <th class="text-center text-light">Aksi</th>
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
                                            <td class="text-center">
                                                <a
                                                    class="text-danger btn-delete"
                                                    href="#"
                                                    data-id="{{ $item->id }}">
                                                        <i class="fa fa-trash px-2"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- modal delete  --}}
<div class="modal fade modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_delete">

                {{-- id  --}}
                <input type="hidden" id="delete_id" name="delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 130px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-delete-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-delete-yes text-center" style="width: 130px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
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

{{-- modal bayar  --}}
<div class="modal fade modal-bayar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_bayar">
                <div class="modal-header">
                    <h5 class="modal-title">Update Piutang</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bayar_id" id="bayar_id">
                    <div class="form-group">
                        <label for="bayar_customer_id">Nama Customer</label>
                        <input type="text" name="bayar_customer_id" id="bayar_customer_id" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="bayar_debt">Piutang</label>
                        <input type="text" name="bayar_debt" id="bayar_debt" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="bayar_price">Nominal Bayar</label>
                        <input type="text" name="bayar_price" id="bayar_price" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-bayar-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-bayar-yes text-center" style="width: 130px;"><i class="fas fa-save"></i> Simpan</button>
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
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
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
                id: id,
                _token: CSRF_TOKEN
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

        // delete
        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault()

            var id = $(this).attr('data-id');
            var url = '{{ route("sales.delete_btn", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('.delete_title').append(response.code);
                    $('#delete_id').val(response.id);
                    $('.modal-delete').modal('show');
                }
            });
        });

        $('#form_delete').submit(function(e) {
            e.preventDefault();

            var formData = {
                id: $('#delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('sales.delete') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-delete-spinner').css("display", "block");
                    $('.btn-delete-yes').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil dihapus.'
                    });
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // btn bayar
        $(document).on('click', '.btn_bayar', function (e) {
            e.preventDefault();

            let id = $(this).attr('data-id');
            let url = '{{ route("invoice.bayar", ":id") }}';
            url = url.replace(':id', id );

            $.ajax({
                url: url,
                type: "get",
                success: function (response) {
                    console.log(response);
                    $('#bayar_id').val(response.credit.id);
                    $('#bayar_debt').val(format_rupiah(response.invoice.debt));
                    $('#bayar_customer_id').val(response.invoice.customer.customer_name);
                    $('.modal-bayar').modal('show');
                }
            })
        })

        $(document).on('shown.bs.modal', '.modal-bayar', function() {
            $('#bayar_price').focus();

            var bayar = document.getElementById("bayar_price");
            bayar.addEventListener("keyup", function(e) {
                bayar.value = formatRupiah(this.value, "");
            });
        });

        $(document).on('submit', '#form_bayar', function (e) {
            e.preventDefault();

            var formData = {
                id: $('#bayar_id').val(),
                price: $('#bayar_price').val().replace(/\./g,''),
                debt: $('#bayar_debt').val().replace(/\./g,''),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('invoice.bayar_save') }}",
                type: "post",
                data: formData,
                beforeSend: function() {
                    $('.btn-bayar-spinner').removeClass('d-none');
                    $('.btn-bayar-yes').addClass('d-none');
                },
                success: function (response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui.'
                    });
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            })
        })
    } );
</script>
@endsection
