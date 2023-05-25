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
          <h1 class="m-0">Produk Keluar</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Produk Keluar</li>
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
            @if (Auth::user()->employee_id != null)
                <div class="card-header">
                    <a
                        href="{{ url('inventory_cashier') }}"
                        class="btn btn-primary btn-sm text-white pl-3 pr-3"
                        title="Tambah">
                            <i class="fa fa-plus"></i> Tambah Transaksi
                    </a>
                </div>
            @endif
            <div class="card-body">
              <table id="datatable" class="table table-striped table-bordered" style="width:100%; font-size: 14px;">
                <thead class="bg-info">
                  <tr>
                    <th class="text-center text-light">No</th>
                    <th class="text-center text-light">Tanggal</th>
                    <th class="text-center text-light">Toko</th>
                    <th class="text-center text-light">Nama Kasir</th>
                    <th class="text-center text-light">Kode Nota</th>
                    <th class="text-center text-light">Total</th>
                    <th class="text-center text-light">Qty</th>
                    <th class="text-center text-light">Metode Bayar</th>
                    <th class="text-center text-light">Status Bayar</th>
                    <th class="text-center text-light">Status Transaksi</th>
                    @if (Auth::user()->employee_id != null)
                      <th class="text-center text-light">Aksi</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach ($invoices as $key => $item)
                    <tr>
                      <td class="text-center">{{ $key + 1 }}</td>
                      <td class="text-center">{{ date('d-m-Y', strtotime($item->date_recorded)) }}</td>
                      <td>
                          @if ($item->shop)
                              {{ $item->shop->name }}
                          @endif
                      </td>
                      <td>
                          @if ($item->user)
                              {{ $item->user->name }}
                          @else
                              User Tidak Ada
                          @endif
                      </td>
                      <td class="text-center"><a href="#" class="btn-detail" data-id="{{ $item->id }}">{{ $item->code }}</a></td>
                      <td class="text-right">{{ rupiah($item->total_amount) }}</td>
                      <td class="text-center">
                          @foreach ($item->productOut as $item_product_out)
                              {{ $item_product_out->qty }}
                          @endforeach
                      </td>
                      <td class="text-center"><span class="text-uppercase">{{ $item->payment_methods }}</span></td>
                      <td class="text-center">
                          @if ($item->status == "unpaid")
                              <button type="button" id="btn-cancel-{{ $item->id }}" class="btn text-capitalize rounded bg-gradient-warning px-3 btn-cancel" data-id="{{ $item->id }}" style="width: 120px;">cancel</button>
                              <button class="btn btn-default btn-unpaid-spinner-{{ $item->id }} d-none" disabled style="width: 120px;">
                                  <span class="spinner-grow spinner-grow-sm"></span>
                                  Loading..
                              </button>
                              <button type="button" id="btn-unpaid-{{ $item->id }}" class="btn text-capitalize rounded bg-gradient-danger px-3 btn-unpaid" data-id="{{ $item->id }}" style="width: 120px;">{{ $item->status }}</button>
                          @else
                              <button type="button" class="btn text-capitalize rounded bg-gradient-default px-3 btn-paid" data-id="{{ $item->id }}" style="width: 120px;">{{ $item->status }}</button>
                          @endif
                      </td>
                      <td class="text-center">
                        <a href="#" class="text-uppercase" id="status_transaksi" data-id="{{ $item->id }}">
                          @if ($item->statusTransaksi)
                            {{ $item->statusTransaksi->nama }}
                          @endif
                        </span>
                      </td>
                      @if (Auth::user()->employee_id != null)
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
                                          class="dropdown-item btn-print"
                                          href="{{ route('inventory_invoice.print', [$item->id]) }}"
                                          target="_blank">
                                              <i class="fa fa-print px-2"></i> Print
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
                      @endif
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
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal status transaksi  --}}
<div class="modal fade modal-status" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="form_status">
        <div class="modal-header">
          <h5 class="modal-title">Status Transaksi</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal">
              <span aria-hidden="true">x</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="invoice_id" id="invoice_id">
          <div class="mb-1 row d-flex justify-content-center">
            <div class="col-2">
              <button id="btn-transaksi" data-id="1" class="btn btn-primary">DIPROSES</button>
            </div>
            <div class="col-2">
              <button id="btn-transaksi" data-id="2" class="btn btn-primary">DIKEMAS</button>
            </div>
            <div class="col-2">
              <button id="btn-transaksi" data-id="3" class="btn btn-primary">DIKIRIM</button>
            </div>
            <div class="col-2">
              <button id="btn-transaksi" data-id="4" class="btn btn-primary">SELESAI</button>
            </div>
            <div class="col-2">
              <button id="btn-transaksi" data-id="5" class="btn btn-primary">BATAL</button>
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

        // btn detail
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
                                "<td class=\"text-right\">" + format_rupiah(item.sub_total) + "</td>" +
                            "</tr>";
                        $('#table_two tbody').append(inventory_product_out_val);
                    });

                    $('.modal-detail').modal('show');
                }
            });

        });

        // btn delete
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

            var formData = {
                id: $('#delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('inventory_invoice.delete') }}",
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

        // btn unpaid
        $(document).on('click', '.btn-unpaid', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("inventory_invoice.unpaid", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                beforeSend: function () {
                    $('.btn-unpaid-spinner-' + id).removeClass('d-none');
                    $('#btn-unpaid-' + id).addClass('d-none');
                },
                success: function(response) {
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
        })

        // btn cancel
        $(document).on('click', '.btn-cancel', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("inventory_invoice.cancel", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                beforeSend: function () {
                    $('.btn-unpaid-spinner-' + id).removeClass('d-none');
                    $('#btn-cancel-' + id).addClass('d-none');
                },
                success: function(response) {
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
        })

        // status transaksi
        $(document).on('click', '#status_transaksi', function (e) {
          e.preventDefault();
          let id = $(this).attr('data-id');
          $('#invoice_id').val(id);
          $('.modal-status').modal('show');
        })

        $(document).on('click', '#btn-transaksi', function (e) {
          e.preventDefault();

          let formData = {
            id: $('#invoice_id').val(),
            status_id: $(this).attr('data-id'),
            _token: CSRF_TOKEN
          }
          
          $.ajax({
            url: "{{ URL::route('inventory_invoice.status_transaksi') }}",
            type: "post",
            data: formData,
            success: function (response) {
              Toast.fire({
                icon: 'success',
                title: 'Status berhasil diperbaharui.'
              });
              setTimeout(() => {
                window.location.reload(1);
              }, 1000);
            }
          })
        })
    } );
</script>
@endsection
