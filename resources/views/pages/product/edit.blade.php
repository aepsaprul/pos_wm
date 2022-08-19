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
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="m-0 font-weight-bold text-uppercase"><i class="fas fa-edit"></i> Ubah Produk</h5>
                </div>
                <div>
                    <div class="float-sm-right">
                        <a href="{{ route('product.index') }}" class="btn bg-gradient-danger btn-sm pl-3 pr-3">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('product.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- id --}}
                <input type="hidden" id="edit_id" name="edit_id" value="{{ $product->id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile pb-3">
                                <div class="text-center edit_profile_img">
                                    <img
                                        class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('public/assets/image_not_found.jpg') }}"
                                        alt="User profile picture">
                                </div>
                                <div class="form-group">
                                    <label for="edit_image" class="font-weight-light">Gambar</label>
                                    <input type="file" id="edit_image" name="edit_image" class="form-control" >
                                    <small id="error_edit_image" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label for="edit_video" class="font-weight-light">Video</label>
                                    <input type="text" id="edit_video" name="edit_video" class="form-control" maxlength="30" >
                                    <small id="error_edit_video" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="edit_product_master" class="font-weight-light">Nama Produk</label>
                                            <select name="edit_product_master" id="edit_product_master" class="form-control select_edit_product_master">
                                                <option value="">--Pilih Produk--</option>
                                                @foreach ($product_masters as $item)
                                                    <option value="{{ $item->id }}" @if ($item->id == $product->id) selected @endif >{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <small id="error_edit_product_master" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="edit_category_id" class="font-weight-light">Kategori Produk</label>
                                            <select name="edit_category_id" id="edit_category_id" class="form-control select_edit_category">
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}" @if ($item->id == $product->product_category_id) selected @endif >{{ $item->category_name }}</option>
                                                @endforeach
                                            </select>
                                            <small id="error_edit_category_id" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 text-center">
                                        <label for="edit_parameter" class="font-weight-light">Tambah Parameter</label><br>
                                        <button type="button" class="btn btn-outline-success btn-edit-paramater-plus" data-id="{{ $product->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                @foreach ($product->product as $item)
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-3">
                                            <label>Nama Parameter</label>
                                            <input type="hidden" name="parameter_id[]" class="form-control" value="{{ $item->id }}" autocomplete="off">
                                            <input type="text" name="parameter_name[]" class="form-control" value="{{ $item->product_name }}" autocomplete="off">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-3">
                                            <label class="font-weight-light">Bobot</label>
                                            <input type="text" name="parameter_weight[]" class="form-control" value="{{ $item->weight }}" autocomplete="off">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-3">
                                            <label class="font-weight-light">Satuan</label>
                                            <input type="text" name="parameter_unit[]" class="form-control" value="{{ $item->unit }}" autocomplete="off">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-3">
                                            <label class="font-weight-light">HPP</label>
                                            <input type="text" name="parameter_hpp[]" class="form-control price_{{ $item->id }}" value="{{ $item->product_price }}" autocomplete="off">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-3">
                                            <label class="font-weight-light">Harga Jual</label>
                                            <input type="text" id="parameter_harga_jual" name="parameter_harga_jual[]" class="form-control price_selling_{{ $item->id }}" data-id="{{ $item->id }}" value="{{ $item->product_price_selling }}" autocomplete="off">
                                            <small id="error_parameter_harga_jual_{{ $item->id }}" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-3">
                                            <label class="font-weight-light">Minimal Grosir</label>
                                            <input type="text" name="parameter_minimal_grosir[]" class="form-control" value="{{ $item->minimal_grosir }}" autocomplete="off">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-3">
                                            <label class="font-weight-light">Harga Grosir</label>
                                            <input type="text" name="parameter_harga_grosir[]" class="form-control" value="{{ $item->harga_grosir }}" autocomplete="off">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-3 text-right">
                                            <label class="font-weight-light">Aksi</label><br>
                                            <button class="btn btn-danger btn-edit-spinner-{{ $item->id }} d-none" disabled><span class="spinner-grow spinner-grow-sm"></span></button>
                                            <button id="edit_remove_row_{{ $item->id }}" type="button" class="btn btn-danger edit_remove_row" data-id="{{ $item->id }}"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="edit_description" class="font-weight-light">Deskripsi</label>
                                            <textarea name="edit_description" id="edit_description" cols="30" rows="4" class="form-control">{{ $product->description }}</textarea>
                                            <small id="error_edit_description" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-edit-spinner d-none" disabled style="width: 130px;">
                                    <span class="spinner-grow spinner-grow-sm"></span>
                                    Loading...
                                </button>
                                <button type="submit" class="btn btn-primary btn-edit-save" style="width: 130px;">
                                    <i class="fas fa-save"></i> <span class="modal-btn">Perbaharui</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- modal create parameter in edit -->
<div class="modal fade modal_form_edit_add_parameter" id="modal-default" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_edit_add_parameter" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Parameter</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- id --}}
                    <input type="hidden" id="edit_add_parameter_id" name="edit_add_parameter_id">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="edit_add_parameter_name" class="font-weight-light">Nama Parameter</label>
                                        <input type="text" name="edit_add_parameter_name" id="edit_add_parameter_name" class="form-control">
                                        <small id="error_edit_add_parameter_name" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="edit_add_parameter_weight" class="font-weight-light">Bobot</label>
                                        <input type="text" name="edit_add_parameter_weight" id="edit_add_parameter_weight" class="form-control">
                                        <small id="error_edit_add_parameter_weight" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="edit_add_parameter_unit" class="font-weight-light">Unit</label>
                                        <input type="text" name="edit_add_parameter_unit" id="edit_add_parameter_unit" class="form-control">
                                        <small id="error_edit_add_parameter_unit" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-edit-add-parameter-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button type="submit" class="btn btn-primary btn-edit-add-parameter-save" style="width: 130px;">
                        <i class="fas fa-save"></i> <span class="modal-btn">Tambah</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

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

    $('.select_edit_product_master').select2({
        theme: 'bootstrap4'
    });

    $('.select_edit_category').select2({
        theme: 'bootstrap4'
    });

    $(document).on('keyup change', '#parameter_harga_jual', function () {
        let id = $(this).attr('data-id');
        let price = parseInt($('.price_' + id).val());
        let price_selling = parseInt($('.price_selling_' + id).val());

        if (price_selling <= price || !price_selling) {
            $('.btn-edit-save').prop('disabled', true);
            $('#error_parameter_harga_jual_' + id).empty();
            $('#error_parameter_harga_jual_' + id).append('harga jual tidak boleh kurang dari HPP');
        } else {
            $('.btn-edit-save').prop('disabled', false);
            $('#error_parameter_harga_jual_' + id).empty();
        }
    })

    // modal create parameter in edit
    $(document).on('click', '.btn-edit-paramater-plus', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');

        $('#edit_add_parameter_id').val(id);
        $('.modal_form_edit_add_parameter').modal('show');
    })

    $(document).on('submit', '#form_edit_add_parameter', function (e) {
        e.preventDefault();

        let formData = new FormData($('#form_edit_add_parameter')[0]);

        $.ajax({
            url: "{{ URL::route('product.add_parameter') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.btn-edit-add-parameter-spinner').removeClass('d-none');
                $('.btn-edit-add-parameter-save').addClass('d-none');
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
                var errorMessage = xhr.status + ': ' + error
                alert('Error - ' + errorMessage);
            }
        })
    })

    $(document).on('click', '.edit_remove_row', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var url = '{{ route("product.remove", ":id") }}';
        url = url.replace(':id', id );

        $.ajax({
            url: url,
            type: "get",
            beforeSend: function() {
                $('.btn-edit-spinner-' + id).removeClass('d-none');
                $('#edit_remove_row_' + id).addClass('d-none');
            },
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil diperbaharui.'
                });

                if (response.products.length == 0) {
                    setTimeout(() => {
                        window.location.href="{{ URL::route('product.index') }}";
                    }, 1000)
                } else {
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000)
                }
            },
            error: function(xhr, status, error){
                var errorMessage = xhr.status + ': ' + error
                alert('Error - ' + errorMessage);
            }
        })
    })

    $(document).on('click', '.btn-edit-save', function (e) {
        $('.btn-edit-spinner').removeClass('d-none');
        $('.btn-edit-save').addClass('d-none');
    })
} );

</script>
@endsection
