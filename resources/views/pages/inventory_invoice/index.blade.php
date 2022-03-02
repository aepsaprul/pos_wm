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
                <h3>Data Produk Keluar</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <a
                            href="{{ url('inventory_cashier') }}"
                            class="btn btn-primary btn-sm text-white pl-3 pr-3"
                            title="Tambah">
                                <i class="fa fa-plus"></i> Tambah Transaksi
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead style="background-color: #2A3F54;">
                                            <tr>
                                                <th class="text-center text-light">No</th>
                                                <th class="text-center text-light">Tanggal</th>
                                                <th class="text-center text-light">Nama Kasir</th>
                                                <th class="text-center text-light">Kode Nota</th>
                                                <th class="text-center text-light">Toko</th>
                                                <th class="text-center text-light">Qty</th>
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
                                                    <td class="text-center">{{ $item->code }}</td>
                                                    <td class="text-right">{{ rupiah($item->total_amount) }}</td>
                                                    <td class="text-center">
                                                        @foreach ($item->productOut as $item_product_out)
                                                            {{ $item_product_out->qty }}
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a
                                                                class="dropdown-toggle"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                                        <i class="fa fa-cog"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a
                                                                    class="dropdown-item btn-detail"
                                                                    href="#"
                                                                    data-id="{{ $item->id }}">
                                                                        <i class="fa fa-eye px-2"></i> Detail
                                                                </a>
                                                                <a
                                                                    class="dropdown-item btn-delete"
                                                                    href="#"
                                                                    data-id="{{ $item->id }}">
                                                                        <i class="fa fa-trash px-2"></i> Hapus
                                                                </a>
                                                            </div>
                                                        </div>
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
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

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
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true">Tidak</span></button>
                    <button type="submit" class="btn btn-primary text-center" style="width: 100px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal detail  --}}
<div class="modal fade modal-detail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_detail">
                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Detail Penjualan</h5>
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
                                <thead style="background-color: #32a893;">
                                    <tr>
                                        <th class="text-white text-center fw-bold">No</th>
                                        <th class="text-white text-center fw-bold">Nama Produk</th>
                                        <th class="text-white text-center fw-bold">Quantity</th>
                                        <th class="text-white text-center fw-bold">Sub Total</th>
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
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal proses berhasil  --}}
<div class="modal fade modal-proses" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                Proses sukses.... <i class="fa fa-check" style="color: #32a893;"></i>
            </div>
        </div>
    </div>
</div>

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

        $('body').on('click', '.btn-detail', function(e) {
            e.preventDefault();
            $('#table_two tbody').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("inventory_invoice.show", ":id") }}';
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

                    $.each(response.inventory_product_outs, function(index, item) {
                        var inventory_product_out_val = "" +
                            "<tr>" +
                                "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                "<td>" + item.product.product_name + "</td>" +
                                "<td class=\"text-center\">" + item.quantity + "</td>" +
                                "<td class=\"text-end\">" + format_rupiah(item.sub_total) + "</td>" +
                            "</tr>";
                        $('#table_two tbody').append(inventory_product_out_val);
                    });

                    $('.modal-detail').modal('show');
                }
            });

        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault()

            var id = $(this).attr('data-id');
            var url = '{{ route("inventory_invoice.delete_btn", ":id") }}';
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

            $('.modal-delete').modal('hide');

            var formData = {
                id: $('#delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('inventory_invoice.delete') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.modal-proses').modal('show');
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                }
            });
        });
    } );
</script>
@endsection
