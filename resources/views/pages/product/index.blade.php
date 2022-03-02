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
                <h3>Data Produk</h3>
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
                                                <th class="text-center text-light">Kode</th>
                                                <th class="text-center text-light">Nama</th>
                                                <th class="text-center text-light">Kategori</th>
                                                <th class="text-center text-light">HPP</th>
                                                <th class="text-center text-light">Harga Jual</th>
                                                <th class="text-center text-light">Stok</th>
                                                <th class="text-center text-light">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $item->product_code }}</td>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->category->category_name }}</td>
                                                <td class="text-right">{{ rupiah($item->product_price) }}</td>
                                                <td class="text-right">{{ rupiah($item->product_price_selling) }}</td>
                                                <td class="text-center">{{ $item->stock }}</td>
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
                    <h5 class="modal-title text-white">Tambah Produk</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_product_code" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control form-control-sm" id="create_product_code" name="create_product_code" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="create_product_name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control form-control-sm" id="create_product_name" name="create_product_name">
                    </div>
                    <div class="mb-3">
                        <label for="create_product_category_id" class="form-label">Kategori</label>
                        <div class="create_product_category_id">
                            {{-- value in jquery  --}}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="create_product_price" class="form-label">HPP</label>
                        <input type="text" class="form-control form-control-sm" id="create_product_price" name="create_product_price">
                    </div>
                    <div class="mb-3">
                        <label for="create_product_price_selling" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control form-control-sm" id="create_product_price_selling" name="create_product_price_selling">
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
                <input type="hidden" id="edit_product_id" name="edit_product_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Produk</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_product_code" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control form-control-sm" id="edit_product_code" name="edit_product_code" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit_product_name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control form-control-sm" id="edit_product_name" name="edit_product_name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_product_category_id" class="form-label">Kategori</label>
                        <div class="edit_product_category_id">
                            {{-- value in jquery  --}}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_product_price" class="form-label">HPP</label>
                        <input type="text" class="form-control form-control-sm" id="edit_product_price" name="edit_product_price">
                    </div>
                    <div class="mb-3">
                        <label for="edit_product_price_selling" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control form-control-sm" id="edit_product_price_selling" name="edit_product_price_selling">
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
            $('.create_product_category_id').empty();

            var formData = {
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product.create') }}',
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('#create_product_code').val(response.product_code);

                    var value = "<select name=\"create_product_category_id\" id=\"create_product_category_id\" class=\"form-control select_category_create\">";
                    $.each(response.categories, function(index, item) {
                        value += "<option value=\"" + item.id + "\">" + item.category_name + "</option>";
                    });
                    value += "</select>";
                    $('.create_product_category_id').append(value);
                    $('.modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_product_name').focus();

            $('.select_category_create').select2({
                dropdownParent: $('.modal-create')
            });

            var price = document.getElementById("create_product_price");
            price.addEventListener("keyup", function(e) {
                price.value = formatRupiah(this.value, "");
            });

            var price_selling = document.getElementById("create_product_price_selling");
            price_selling.addEventListener("keyup", function(e) {
                price_selling.value = formatRupiah(this.value, "");
            });
        });


        $('#form_create').submit(function(e) {
            e.preventDefault();
            $('.modal-create').modal('hide');

            var formData = {
                product_code: $('#create_product_code').val(),
                product_name: $('#create_product_name').val(),
                product_category_id: $('#create_product_category_id').val(),
                product_price: $('#create_product_price').val().replace(/\./g,''),
                product_price_selling: $('#create_product_price_selling').val().replace(/\./g,''),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product.store') }} ',
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
            $('.edit_product_category_id').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product.edit", ":id") }}';
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
                    $('#edit_product_id').val(response.product_id);
                    $('#edit_product_code').val(response.product_code);
                    $('#edit_product_name').val(response.product_name);
                    $('#edit_product_category_id').val(response.product_category_id);
                    $('#edit_product_price').val(format_rupiah(response.product_price));
                    $('#edit_product_price_selling').val(format_rupiah(response.product_price_selling));

                    var value = "<select name=\"edit_product_category_id\" id=\"edit_product_category_id\" class=\"form-control select_category_edit\">";
                    $.each(response.categories, function(index, item) {
                        value += "<option value=\"" + item.id + "\"";
                        // sesuai kategori yg terpilih
                        if (item.id === response.product_category_id) {
                            value += "selected";
                        }
                        value += ">" + item.category_name + "</option>";
                    });
                    value += "</select>";
                    $('.edit_product_category_id').append(value);

                    $('.modal-edit').modal('show');
                }
            })
        });

        $(document).on('shown.bs.modal', '.modal-edit', function() {
            $('#edit_product_name').focus();

            $('.select_category_edit').select2({
                dropdownParent: $('.modal-edit')
            });

            var price = document.getElementById("edit_product_price");
            price.addEventListener("keyup", function(e) {
                price.value = formatRupiah(this.value, "");
            });

            var price_selling = document.getElementById("edit_product_price_selling");
            price_selling.addEventListener("keyup", function(e) {
                price_selling.value = formatRupiah(this.value, "");
            });
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            $('.modal-edit').modal('hide');

            var formData = {
                id: $('#edit_product_id').val(),
                product_code: $('#edit_product_code').val(),
                product_name: $('#edit_product_name').val(),
                product_category_id: $('#edit_product_category_id').val(),
                product_price: $('#edit_product_price').val().replace(/\./g,''),
                product_price_selling: $('#edit_product_price_selling').val().replace(/\./g,''),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product.update') }}',
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
            e.preventDefault();

            $('.delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product.delete_btn", ":id") }}';
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
                    $('#delete_product_id').val(response.id);
                    $('.modal-delete').modal('show');
                }
            });
        });

        $('#form_delete').submit(function(e) {
            e.preventDefault();

            $('.modal-delete').modal('hide');

            var formData = {
                id: $('#delete_product_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product.delete') }}',
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
