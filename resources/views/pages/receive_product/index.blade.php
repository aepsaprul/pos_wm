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
                    <h1 class="m-0">Produk Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Produk Masuk</li>
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
                        @if (in_array("tambah", $data_navigasi))
                            <div class="card-header">
                                <button id="button-create" type="button" class="btn bg-gradient-primary btn-sm pl-3 pr-3">
                                    <i class="fa fa-plus"></i> Tambah
                                </button>
                            </div>
                        @endif
                        <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead class="bg-info">
                                    <tr>
                                        <th class="text-center text-light">No</th>
                                        <th class="text-center text-light">User</th>
                                        <th class="text-center text-light">Nama Produk</th>
                                        <th class="text-center text-light">Harga Produk</th>
                                        <th class="text-center text-light">Qty</th>
                                        <th class="text-center text-light">Sub Total</th>
                                        <th class="text-center text-light">Stok</th>
                                        <th class="text-center text-light">Saldo</th>
                                        <th class="text-center text-light">Tanggal</th>
                                        <th class="text-center text-light">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($receive_products as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>
                                                @if ($item->user)
                                                    {{ $item->user->name }}
                                                @else
                                                    <span class="text-danger">User Tidak Ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->product)
                                                  {{ $item->product->productMaster->name }} - {{ $item->product->product_name }}
                                                @else
                                                    <span class="text-danger">Product Tidak Ada</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if ($item->product)
                                                    {{ rupiah($item->price) }}
                                                @else
                                                    <span class="text-danger">Product Tidak Ada</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-right">{{ rupiah($item->sub_total) }}</td>
                                            <td class="text-center">{{ $item->stock }}</td>
                                            @php
                                                $stock_sold = $item->quantity - $item->stock;
                                                $saldo = $stock_sold * $item->price;
                                            @endphp
                                            <td class="text-center">{{ rupiah($saldo) }}</td>
                                            <td class="text-center">{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    @if (in_array("ubah", $data_navigasi) || in_array("hapus", $data_navigasi))
                                                        <a
                                                            class="dropdown-toggle"
                                                            data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                                <i class="fa fa-cog"></i>
                                                        </a>
                                                    @endif
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if (in_array("ubah", $data_navigasi))
                                                            <a
                                                                class="dropdown-item btn-edit"
                                                                href="#"
                                                                data-id="{{ $item->id }}">
                                                                    <i class="fa fa-pencil-alt px-2"></i> Ubah
                                                            </a>
                                                        @endif
                                                        @if (in_array("hapus", $data_navigasi))
                                                            <a
                                                                class="dropdown-item btn-delete"
                                                                href="#"
                                                                data-id="{{ $item->id }}">
                                                                    <i class="fa fa-trash px-2"></i> Hapus
                                                            </a>
                                                        @endif
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
    </section>
</div>

{{-- modal create  --}}
<div class="modal fade modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk Masuk</h5>
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
                        <select name="create_product_id" id="create_product_id" class="form-control form-control-sm" name="create_product_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_quantity" class="form-label">Quantity</label>
                        <input type="text" class="form-control form-control-sm" id="create_quantity" name="create_quantity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-create-spinner" disabled style="width: 120px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-create-save" style="width: 120px;"><i class="fa fa-save"></i> Simpan</button>
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

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Produk Masuk</h5>
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
                        <select name="edit_product_id" id="edit_product_id" class="form-control form-control-sm" name="edit_product_id" required disabled>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_quantity" class="form-label">Quantity</label>
                        <input type="text" class="form-control form-control-sm" id="edit_quantity" name="edit_quantity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-edit-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-edit-save" style="width: 130px;"><i class="fa fa-save"></i> Perbaharui</button>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 120px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-delete-spinner" disabled style="width: 120px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-delete-yes text-center" style="width: 120px;">Ya</button>
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
<!-- Select2 -->
<script src="{{ asset('public/themes/plugins/select2/js/select2.full.min.js') }}"></script>

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

        $('#button-create').on('click', function() {
            $('#create_product_id').empty();

            var formData = {
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('received_product.create') }}",
                type: 'GET',
                data: formData,
                success: function(response) {
                    // product query
                    var value = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.products, function(index, item) {
                        if (item.product) {
                            value += "<option value=\"" + item.product.id + "\">" + item.product.product_master.name + " - " + item.product.product_name + "</option>";
                        }
                    });
                    $('#create_product_id').append(value);

                    $('.modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_product_name').focus();

            $('#create_product_id').select2({
                dropdownParent: $('.modal-create')
            });
        });


        $('#form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                product_id: $('#create_product_id').val(),
                quantity: $('#create_quantity').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('received_product.store') }} ",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-create-spinner').css("display", "block");
                    $('.btn-create-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil ditambah.'
                    });

                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }
            });
        });

        $('body').on('click', '.btn-edit', function(e) {
            e.preventDefault();

            $('#edit_product_id').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("received_product.edit", ":id") }}';
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
                    console.log(response);
                    $('#edit_id').val(response.id);
                    $('#edit_quantity').val(response.quantity);

                    // product query
                    var value = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.products, function(index, item) {
                        value += "<option value=\"" + item.product_id + "\"";
                            if (item.product_id == response.product_id) {
                                value += " selected";
                            }
                        value += ">" + item.product.product_name + "</option>";
                    });
                    $('#edit_product_id').append(value);

                    $('.modal-edit').modal('show');
                }
            })
        });

        $(document).on('shown.bs.modal', '.modal-edit', function() {
            $('#edit_product_name').focus();

            $('#edit_product_id').select2({
                dropdownParent: $('.modal-edit')
            });
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            var formData = {
                id: $('#edit_id').val(),
                product_id: $('#edit_product_id').val(),
                quantity: $('#edit_quantity').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('received_product.update') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-edit-spinner').css("display", "block");
                    $('.btn-edit-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui.'
                    });

                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }
            });
        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault()
            $('.delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("received_product.delete_btn", ":id") }}';
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

            var formData = {
                id: $('#delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('received_product.delete') }}",
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
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }
            });
        });
    } );
</script>
@endsection
