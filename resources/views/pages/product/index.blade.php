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
                    <h1 class="m-0">Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Produk</li>
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
                            <button id="button-create" type="button" class="btn bg-gradient-primary btn-sm pl-3 pr-3">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead class="bg-info">
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
                                        <td>
                                            <a href="#" class="btn-detail" data-id="{{ $item->id }}">{{ $item->product_name }}</a>
                                        </td>
                                        <td>
                                            @if ($item->category)
                                                {{ $item->category->category_name }}
                                            @endif
                                        </td>
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
                                                            <i class="fa fa-pencil-alt px-2"></i> Ubah
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
    </section>
</div>

<!-- Modal -->
<div class="modal fade modal-form" id="modal-default" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form" method="post" enctype="multipart/form-data" class="form-create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Produk</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- id --}}
                    <input type="hidden" id="id" name="id">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile pb-3">
                                    <div class="text-center profile_img">
                                        <img
                                            class="profile-user-img img-fluid img-circle"
                                            src="{{ asset('public/assets/image_not_found.jpg') }}"
                                            alt="User profile picture">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Gambar</label>
                                        <input type="file" id="image" name="image" class="form-control" >
                                        <small id="error_image" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code">Kode Produk</label>
                                        <input type="text" id="product_code" name="product_code" class="form-control" readonly>
                                        <small id="error_product_code" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="video">Video</label>
                                        <input type="text" id="video" name="video" class="form-control" maxlength="30" >
                                        <small id="error_video" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-primary card-outline pb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="product_master">Nama Produk</label>
                                                <select name="product_master" id="product_master" class="form-control">
                                                </select>
                                                <small id="error_product_master" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="category_id">Kategori Produk</label>
                                                <select name="category_id" id="category_id" class="form-control select_category">
                                                </select>
                                                <small id="error_category_id" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                                            <label for="parameter">Tambah Parameter</label><br>
                                            <button type="button" class="btn btn-outline-success btn-paramater-plus" id="parameter"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-outline-danger btn-paramater-cancel" id="parameter"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                        {{-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="product_price">HPP</label>
                                                <input type="text" id="product_price" name="product_price" class="form-control" maxlength="16" >
                                                <small id="error_product_price" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="product_price_selling">Harga Jual</label>
                                                <input type="text" id="product_price_selling" name="product_price_selling" class="form-control">
                                                <small id="error_product_price_selling" class="form-text text-danger"></small>
                                            </div>
                                        </div> --}}
                                        <div id="form_parameter" class="form_parameter col-12 row"></div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 form-weight">
                                            <div class="form-group">
                                                <label for="weight">Bobot</label>
                                                <input type="text" id="weight" name="weight" class="form-control" maxlength="16" >
                                                <small id="error_weight" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 form-unit">
                                            <div class="form-group">
                                                <label for="unit">Satuan</label>
                                                <input type="text" id="unit" name="unit" class="form-control" maxlength="30" >
                                                <small id="error_unit" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="description">Deskripsi</label>
                                                <textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
                                                <small id="error_description" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button type="submit" class="btn btn-primary btn-save" style="width: 130px;">
                        <i class="fas fa-save"></i> <span class="modal-btn">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-form-product-master" id="modal-default" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_product_master" method="post" enctype="multipart/form-data" class="form-product-master">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Produk</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="product_master_name">Nama Produk</label>
                            <input type="text" name="product_master_name" id="product_master_name" class="form-control">
                            <small id="error_product_master_name" class="form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-product-master-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button type="submit" class="btn btn-primary btn-product-master-save" style="width: 130px;">
                        <i class="fas fa-save"></i> <span class="modal-btn">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal delete --}}
<div class="modal fade modal-delete" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-delete">
                <input type="hidden" id="delete_id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger" type="button" data-dismiss="modal" style="width: 130px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-delete-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button type="submit" class="btn btn-primary btn-delete-save text-center" style="width: 130px;">
                        Ya
                    </button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });

        $('input[type="file"][name="image"]').on('change', function() {
            var img_path = $(this)[0].value;
            var img_holder = $('.profile_img');
            var currentImagePath = $(this).data('value');
            var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
            if (extension == 'jpg' || extension == 'jpeg' || extension == 'png') {
                if (typeof(FileReader) != 'undefind') {
                    img_holder.empty();
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('<img/>', {'src':e.target.result, 'class':'profile-user-img img-fluid img-circle'}).appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    $(img_holder).html('Browser tidak support FileReader');
                }
            } else {
                $(img_holder).html(currentImagePath);
            }
        });

        $("#datatable").DataTable({
            'responsive': true
        });

        // create product master
        $(document).on('change', '#product_master', function() {
            if ($(this).val() == "add_product_master") {
                $('.modal-form-product-master').modal('show');
            }
        })

        $(document).on('submit', '#form_product_master', function (e) {
            e.preventDefault();

            let formData = new FormData($('#form_product_master')[0]);

            $.ajax({
                url: "{{ URL::route('product.product_master_store') }} ",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.btn-product-master-spinner').removeClass('d-none');
                    $('.btn-product-master-save').addClass('d-none');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_product_master_name').append(response.errors.product_master_name);

                        setTimeout(() => {
                            $('.btn-product-master-spinner').addClass('d-none');
                            $('.btn-product-master-save').removeClass('d-none');
                        }, 1000);
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data behasil ditambah'
                        });

                        setTimeout(() => {
                            window.location.reload(1);
                        }, 1000);
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
        })

        // add parameter
        $(document).on('click', '.btn-paramater-plus', function(e) {
            e.preventDefault();
            $('.form-weight').addClass('d-none');
            $('.form-unit').addClass('d-none');

            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="row">';
            html += '<div class="col-lg-3 col-md-3 col-12 mb-3">';
            html += '<label>Nama Parameter</label>';
            html += '<input type="text" name="parameter_name[]" class="form-control" autocomplete="off">';
            html += '</div>';
            html += '<div class="col-lg-3 col-md-3 col-12 mb-3">';
            html += '<label>Bobot</label>';
            html += '<input type="text" name="parameter_weight[]" class="form-control" autocomplete="off">';
            html += '</div>';
            html += '<div class="col-lg-3 col-md-3 col-12 mb-3">';
            html += '<label>Satuan</label>';
            html += '<input type="text" name="parameter_unit[]" class="form-control" autocomplete="off">';
            html += '</div>';
            html += '<div class="col-lg-3 col-md-3 col-12 mb-3 text-right">';
            html += '<label>Aksi</label><br>';
            html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>';
            html += '</div>';
            html += '</div>';

            $('.form_parameter').append(html);
        });

        // remove parameter
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });

        // cancel parameter
        $(document).on('click', '.btn-paramater-cancel', function () {
            window.location.reload(1);
        });

        // create
        $('#button-create').on('click', function() {
            $('#category_id').empty();
            $('#product_master').empty();
            $('.modal-title').empty();
            $('.modal-btn').empty();

            $.ajax({
                url: "{{ URL::route('product.create') }}",
                type: 'GET',
                success: function(response) {
                    $('#form').removeClass('form-edit');
                    $('#form').addClass('form-create');
                    $('.modal-title').append("Tambah Data Produk");
                    $('.modal-btn').append("Simpan");
                    $('.modal-footer').removeClass("d-none");

                    $('#product_code').val(response.product_code);
                    $('#id').val("");
                    $('#product_name').val("");
                    $('#product_price').val("");
                    $('#product_price_selling').val("");
                    $('#weight').val("");
                    $('#unit').val("");
                    $('#description').val("");
                    $('#video').val("");
                    $('#image').val("");

                    $('#id').prop('readonly', false);
                    $('#product_name').prop('readonly', false);
                    $('#product_price').prop('readonly', false);
                    $('#product_price_selling').prop('readonly', false);
                    $('#weight').prop('readonly', false);
                    $('#unit').prop('readonly', false);
                    $('#description').prop('readonly', false);
                    $('#video').prop('readonly', false);
                    $('#category_id').prop('disabled', false);
                    $('#image').prop('disabled', false);

                    var value_product_master = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.product_masters, function(index, item) {
                        value_product_master += "<option value=\"" + item.id + "\">" + item.name + "</option>";
                    });
                    value_product_master += "<option value=\"add_product_master\" class=\"font-weight-bold\">Tambah</option>";
                    $('#product_master').append(value_product_master);

                    var value = "<option value=\"\">--Pilih Kategori--</option>";
                    $.each(response.categories, function(index, item) {
                        value += "<option value=\"" + item.id + "\">" + item.category_name + "</option>";
                    });
                    $('#category_id').append(value);

                    $('.modal-form').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-form', function() {
            $('#product_name').focus();

            $('.select_category').select2({
                theme: 'bootstrap4',
                dropdownParent: $('.modal-form')
            });
        });

        $(document).on('submit', '.form-create', function (e) {
            e.preventDefault();

            $('#error_product_code').empty();
            $('#error_category_id').empty();
            $('#error_description').empty();
            $('#error_video').empty();
            $('#error_image').empty();

            let formData = new FormData($('#form')[0]);

            $.ajax({
                url: "{{ URL::route('product.store') }} ",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.btn-spinner').removeClass('d-none');
                    $('.btn-save').addClass('d-none');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_product_code').append(response.errors.product_code);
                        $('#error_category_id').append(response.errors.product_category_id);
                        $('#error_description').append(response.errors.description);
                        $('#error_video').append(response.errors.video);
                        $('#error_image').append(response.errors.image);

                        setTimeout(() => {
                            $('.btn-spinner').addClass('d-none');
                            $('.btn-save').removeClass('d-none');
                        }, 1000);
                    } else {
                        console.log(response);
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // edit
        $('body').on('click', '.btn-edit', function(e) {
            e.preventDefault();
            $('.modal-title').empty();
            $('.modal-btn').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product.edit", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('#form').removeClass('form-create');
                    $('#form').addClass('form-edit');
                    $('.modal-title').append("Ubah Data Produk");
                    $('.modal-btn').append("Perbaharui");
                    $('.modal-footer').removeClass("d-none");

                    $('#id').val(response.product.id);
                    $('#product_code').val(response.product.product_code);
                    $('#product_name').val(response.product.product_name);
                    $('#product_price').val(format_rupiah(response.product.product_price));
                    $('#product_price_selling').val(format_rupiah(response.product.product_price_selling));
                    $('#weight').val(response.product.weight);
                    $('#unit').val(response.product.unit);
                    $('#description').val(response.product.description);
                    $('#video').val(response.product.video);

                    $('#id').prop('readonly', false);
                    $('#product_name').prop('readonly', false);
                    $('#product_price').prop('readonly', false);
                    $('#product_price_selling').prop('readonly', false);
                    $('#weight').prop('readonly', false);
                    $('#unit').prop('readonly', false);
                    $('#description').prop('readonly', false);
                    $('#video').prop('readonly', false);
                    $('#category_id').prop('disabled', false);
                    $('#image').prop('disabled', false);

                    $('.profile_img img').prop("src", "{{ URL::to('') }}" + "/public/image/" + response.product.image);

                    var value = "<option value=\"\">-- Pilih Kategori --</option>";
                    $.each(response.categories, function(index, item) {
                        value += "<option value=\"" + item.id + "\"";
                        // sesuai kategori yg terpilih
                        if (item.id === response.product.product_category_id) {
                            value += "selected";
                        }
                        value += ">" + item.category_name + "</option>";
                    });
                    value += "</select>";
                    $('#category_id').append(value);

                    $('.modal-form').modal('show');
                }
            })
        });

        $(document).on('shown.bs.modal', '.modal-form', function() {
            $('#edit_product_name').focus();

            $('.select_category').select2({
                theme: 'bootstrap4',
                dropdownParent: $('.modal-form')
            });
        });

        $(document).on('submit', '.form-edit', function (e) {
            e.preventDefault();

            let formData = new FormData($('#form')[0]);

            $.ajax({
                url: "{{ URL::route('product.update') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.btn-spinner').removeClass('d-none');
                    $('.btn-save').addClass('d-none');
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
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // detail
        $('body').on('click', '.btn-detail', function(e) {
            e.preventDefault();
            $('.modal-title').empty();
            $('.modal-btn').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product.show", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('#form').removeClass('form-create');
                    $('#form').addClass('form-edit');
                    $('.modal-title').append("Detail Data Produk");
                    $('.modal-footer').addClass("d-none");

                    $('#id').val(response.product.id);
                    $('#product_code').val(response.product.product_code);
                    $('#product_name').val(response.product.product_name);
                    $('#product_price').val(format_rupiah(response.product.product_price));
                    $('#product_price_selling').val(format_rupiah(response.product.product_price_selling));
                    $('#weight').val(response.product.weight);
                    $('#unit').val(response.product.unit);
                    $('#description').val(response.product.description);
                    $('#video').val(response.product.video);

                    $('#id').prop('readonly', true);
                    $('#product_code').prop('readonly', true);
                    $('#product_name').prop('readonly', true);
                    $('#product_price').prop('readonly', true);
                    $('#product_price_selling').prop('readonly', true);
                    $('#weight').prop('readonly', true);
                    $('#unit').prop('readonly', true);
                    $('#description').prop('readonly', true);
                    $('#video').prop('readonly', true);
                    $('#category_id').prop('disabled', true);
                    $('#image').prop('disabled', true);

                    $('.profile_img img').prop("src", "{{ URL::to('') }}" + "/public/image/" + response.product.image);

                    var value = "<option value=\"\">-- Pilih Kategori --</option>";
                    $.each(response.categories, function(index, item) {
                        value += "<option value=\"" + item.id + "\"";
                        // sesuai kategori yg terpilih
                        if (item.id === response.product.product_category_id) {
                            value += "selected";
                        }
                        value += ">" + item.category_name + "</option>";
                    });
                    value += "</select>";
                    $('#category_id').append(value);

                    $('.modal-form').modal('show');
                }
            })
        });

        // delete
        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();

            $('.delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product.delete_btn", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
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
                id: $('#delete_id').val()
            }

            $.ajax({
                url: "{{ URL::route('product.delete') }}",
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
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
        });
    } );
</script>
@endsection
