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
                <h3>Data Produk Masuk</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <button
                            id="button-create"
                            type="button"
                            class="btn btn-primary btn-sm text-white pl-3 pr-3"
                            title="Tambah">
                                <i class="fa fa-plus"></i> Tambah
                        </button>
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
                                                <th class="text-center text-light">Pengguna</th>
                                                <th class="text-center text-light">Product</th>
                                                <th class="text-center text-light">Supplier</th>
                                                <th class="text-center text-light">Harga</th>
                                                <th class="text-center text-light">Qty</th>
                                                <th class="text-center text-light">Total</th>
                                                <th class="text-center text-light">Stok</th>
                                                <th class="text-center text-light">Saldo</th>
                                                <th class="text-center text-light">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product_ins as $key => $item)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td class="text-center">{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>
                                                        @if ($item->product == null)
                                                            <span class="text-danger">Product Tidak Ada</span>
                                                        @else
                                                            {{ $item->product->product_name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->supplier == null)
                                                            <span class="text-danger">Supplier Tidak Ada</span>
                                                        @else
                                                            {{ $item->supplier->supplier_name }}
                                                        @endif
                                                    </td>
                                                    <td class="text-right">{{ rupiah($item->price) }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-right">{{ rupiah($item->sub_total) }}</td>
                                                    <td class="text-center">{{ $item->stock }}</td>
                                                    @php
                                                        $stock_sold = $item->quantity - $item->stock;
                                                        $saldo = $stock_sold * $item->price;
                                                    @endphp
                                                    <td class="text-right">{{ rupiah($saldo) }}</td>
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
                                                                    class="dropdown-item btn-edit"
                                                                    href="#"
                                                                    data-id="{{ $item->id }}">
                                                                        <i class="fa fa-pencil px-2"></i> Ubah
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

{{-- modal create  --}}
<div class="modal fade modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_create">
                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Tambah Produk Masuk</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_product_id" class="form-label">Nama Produk</label>
                        <select name="create_product_id" id="create_product_id" class="form-control" name="create_product_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_supplier_id" class="form-label">Supplier</label>
                        <select name="create_supplier_id" id="create_supplier_id" class="form-control" name="create_supplier_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_price" class="form-label">Harga</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="create_price"
                            name="create_price"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="create_quantity" class="form-label">Quantity</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="create_quantity"
                            name="create_quantity"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal edit  --}}
<div class="modal fade modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_edit">

                {{-- id  --}}
                <input type="hidden" id="edit_id" name="edit_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Produk Masuk</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_product_id" class="form-label">Nama Produk</label>
                        <select name="edit_product_id" id="edit_product_id" class="form-control" name="edit_product_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_supplier_id" class="form-label">Supplier</label>
                        <select name="edit_supplier_id" id="edit_supplier_id" class="form-control" name="edit_supplier_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Harga</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="edit_price"
                            name="edit_price"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_quantity" class="form-label">Quantity</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="edit_quantity"
                            name="edit_quantity"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;"><i class="fa fa-save"></i> Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true">Tidak</span></button>
                    <button type="submit" class="btn btn-primary text-center" style="width: 100px;">Ya</button>
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

        $('#button-create').on('click', function() {
            $('#create_product_id').empty();
            $('#create_supplier_id').empty();

            var formData = {
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_in.create') }}',
                type: 'GET',
                data: formData,
                success: function(response) {
                    // product query
                    var value = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.products, function(index, item) {
                        value += "<option value=\"" + item.id + "\">" + item.product_name + "</option>";
                    });
                    $('#create_product_id').append(value);

                    // supplier query
                    var value = "<option value=\"\">--Pilih Supplier--</option>";
                    $.each(response.suppliers, function(index, item) {
                        value += "<option value=\"" + item.id + "\">" + item.supplier_name + "</option>";
                    });
                    $('#create_supplier_id').append(value);

                    $('.modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_product_name').focus();

            $('#create_product_id').select2({
                dropdownParent: $('.modal-create')
            });

            $('#create_supplier_id').select2({
                dropdownParent: $('.modal-create')
            });

            var price = document.getElementById("create_price");
            price.addEventListener("keyup", function(e) {
                price.value = formatRupiah(this.value, "");
            });
        });


        $('#form_create').submit(function(e) {
            e.preventDefault();
            $('.modal-create').modal('hide');

            var formData = {
                product_id: $('#create_product_id').val(),
                supplier_id: $('#create_supplier_id').val(),
                price: $('#create_price').val().replace(/\./g,''),
                quantity: $('#create_quantity').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_in.store') }} ',
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

        $('body').on('click', '.btn-edit', function(e) {
            e.preventDefault();

            $('#edit_product_id').empty();
            $('#edit_supplier_id').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product_in.edit", ":id") }}';
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
                    $('#edit_id').val(response.id);
                    $('#edit_price').val(format_rupiah(response.price));
                    $('#edit_quantity').val(response.quantity);

                    // product query
                    var value = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.products, function(index, item) {
                        value += "<option value=\"" + item.id + "\"";
                            if (item.id == response.product_id) {
                                value += "selected";
                            }
                        value += ">" + item.product_name + "</option>";
                    });
                    $('#edit_product_id').append(value);

                    // supplier query
                    var value = "<option value=\"\">--Pilih Supplier--</option>";
                    $.each(response.suppliers, function(index, item) {
                        value += "<option value=\"" + item.id + "\"";
                            if (item.id == response.supplier_id) {
                                value += "selected";
                            }
                        value += ">" + item.supplier_name + "</option>";
                    });
                    $('#edit_supplier_id').append(value);

                    $('.modal-edit').modal('show');
                }
            })
        });

        $(document).on('shown.bs.modal', '.modal-edit', function() {
            $('#edit_product_name').focus();

            $('#edit_product_id').select2({
                dropdownParent: $('.modal-edit')
            });

            $('#edit_supplier_id').select2({
                dropdownParent: $('.modal-edit')
            });

            var price = document.getElementById("edit_price");
            price.addEventListener("keyup", function(e) {
                price.value = formatRupiah(this.value, "");
            });
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            $('.modal-edit').modal('hide');

            var formData = {
                id: $('#edit_id').val(),
                product_id: $('#edit_product_id').val(),
                supplier_id: $('#edit_supplier_id').val(),
                price: $('#edit_price').val().replace(/\./g,''),
                quantity: $('#edit_quantity').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_in.update') }}',
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

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault()
            $('.delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product_in.delete_btn", ":id") }}';
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
                    $('.delete_title').append(response.product_name);
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
                url: '{{ URL::route('product_in.delete') }}',
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
