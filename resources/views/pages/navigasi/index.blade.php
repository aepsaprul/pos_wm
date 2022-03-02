@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jabatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Jabatan</li>
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
                            <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="sub-tab" data-toggle="tab" href="#sub" role="tab" aria-controls="sub" aria-selected="true">Sub Menu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="main-tab" data-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="false">Main Menu</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="sub" role="tabpanel" aria-labelledby="sub-tab">
                                    <button
                                        id="sub-button-create"
                                        type="button"
                                        class="btn btn-primary btn-sm text-white pl-3 pr-3 my-4"
                                        title="Tambah">
                                            <i class="fa fa-plus"></i> Tambah
                                    </button>
                                    <table id="table_two" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-info">
                                            <tr>
                                                <th class="text-center text-light">No</th>
                                                <th class="text-center text-light">Title</th>
                                                <th class="text-center text-light">Link</th>
                                                <th class="text-center text-light">Nav Main</th>
                                                <th class="text-center text-light">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nav_subs as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="sub_title_{{ $item->id }}">{{ $item->title }}</td>
                                                <td class="sub_link_{{ $item->id }}">{{ $item->link }}</td>
                                                <td class="sub_nav_main_{{ $item->id }}">
                                                    @if ($item->navMain)
                                                        {{ $item->navMain->title }}
                                                    @else
                                                        Data tidak ada
                                                    @endif
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
                                                                class="dropdown-item sub-btn-edit"
                                                                href="#"
                                                                data-id="{{ $item->id }}">
                                                                    <i class="fa fa-pencil-alt px-2"></i> Ubah
                                                            </a>
                                                            <a
                                                                class="dropdown-item sub-btn-delete"
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
                                <div class="tab-pane fade" id="main" role="tabpanel" aria-labelledby="main-tab">
                                    <button
                                        id="main-button-create"
                                        type="button"
                                        class="btn btn-primary btn-sm text-white pl-3 pr-3 my-4"
                                        title="Tambah">
                                            <i class="fa fa-plus"></i> Tambah
                                    </button>
                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-info">
                                            <tr>
                                                <th class="text-center text-light">No</th>
                                                <th class="text-center text-light">Title</th>
                                                <th class="text-center text-light">Link</th>
                                                <th class="text-center text-light">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nav_mains as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="main_title_{{ $item->id }}">{{ $item->title }}</td>
                                                <td class="main_link_{{ $item->id }}">{{ $item->link }}</td>
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
                                                                class="dropdown-item main-btn-edit"
                                                                href="#"
                                                                data-id="{{ $item->id }}">
                                                                    <i class="fa fa-pencil-alt px-2"></i> Ubah
                                                            </a>
                                                            <a
                                                                class="dropdown-item main-btn-delete"
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
    </section>
</div>

{{-- main modal create  --}}
<div class="modal fade main-modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Menu Utama</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="main_create_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_create_title"
                            name="main_create_title"
                            maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label for="main_create_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_create_link"
                            name="main_create_link"
                            maxlength="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-main-create-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-main-create-save" style="width: 130px;"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal create  --}}
<div class="modal fade sub-modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Menu Sub</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sub_create_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_create_title"
                            name="sub_create_title"
                            maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_create_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_create_link"
                            name="sub_create_link"
                            maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_create_link" class="form-label">Menu Utama</label>
                        <select name="sub_create_nav_main" id="sub_create_nav_main" class="form-control form-control-sm" required>

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sub-create-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-sub-create-save" style="width: 130px;"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- main modal edit  --}}
<div class="modal fade main-modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_edit">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="main_edit_id"
                    name="main_edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Menu Utama</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="main_edit_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_edit_title"
                            name="main_edit_title"
                            maxlength="30"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="main_edit_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_edit_link"
                            name="main_edit_link"
                            maxlength="100"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-main-edit-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-main-edit-save" style="width: 130px;"><i class="fa fa-save"></i> Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal edit  --}}
<div class="modal fade sub-modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_edit">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="sub_edit_id"
                    name="sub_edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Menu Sub</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sub_edit_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_edit_title"
                            name="sub_edit_title"
                            maxlength="30"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_edit_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_edit_link"
                            name="sub_edit_link"
                            maxlength="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_edit_nav_main" class="form-label">Menu Utama</label>
                        <select class="form-control form-control-sm" name="sub_edit_nav_main" id="sub_edit_nav_main">

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sub-edit-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-sub-edit-save" style="width: 130px;"><i class="fa fa-save"></i> Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- main modal delete  --}}
<div class="modal fade main-modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_delete">

                {{-- id  --}}
                <input type="hidden" id="main_delete_id" name="main_delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="main_delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 130px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-main-delete-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-main-delete-yes text-center" style="width: 130px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal delete  --}}
<div class="modal fade sub-modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_delete">

                {{-- id  --}}
                <input type="hidden" id="sub_delete_id" name="sub_delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="sub_delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 130px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-sub-delete-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-sub-delete-yes text-center" style="width: 130px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<!-- DataTables  & Plugins -->
<script src="{{ asset('themes/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('themes/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('themes/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

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

        $("#table_two").DataTable({
            'responsive': true
        });

        // main create
        $('#main-button-create').on('click', function() {
            $('.main-modal-create').modal('show');
        });

        $(document).on('shown.bs.modal', '.main-modal-create', function() {
            $('#main_create_title').focus();
        });

        $('#main_form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                title: $('#main_create_title').val(),
                link: $('#main_create_link').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('nav.main_store') }} ",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-main-create-spinner').css("display", "block");
                    $('.btn-main-create-save').css("display", "none");
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
                    var errorMessage = xhr.status + ': ' + xhr.error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // sub create
        $('#sub-button-create').on('click', function() {
            $('#sub_create_nav_main').empty();

            $.ajax({
                url: "{{ URL::route('nav.sub_create') }}",
                type: 'GET',
                success: function(response) {
                    var nav_main_value = "<option value=\"\">--Pilih Menu Utama--</option>";

                    $.each(response.nav_mains, function(index, value) {
                        nav_main_value += "<option value=\"" + value.id + "\">" + value.title + "</option>";
                    });

                    $('#sub_create_nav_main').append(nav_main_value);
                    $('.sub-modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.sub-modal-create', function() {
            $('#sub_create_title').focus();
        });

        $('#sub_form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                title: $('#sub_create_title').val(),
                link: $('#sub_create_link').val(),
                nav_main_id: $('#sub_create_nav_main').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('nav.sub_store') }} ",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-sub-create-spinner').css("display", "block");
                    $('.btn-sub-create-save').css("display", "none");
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
                    var errorMessage = xhr.status + ': ' + xhr.error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // main edit
        $('body').on('click', '.main-btn-edit', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("nav.main_edit", ":id") }}';
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
                    $('#main_edit_id').val(response.id);
                    $('#main_edit_title').val(response.title);
                    $('#main_edit_link').val(response.link);

                    $('.main-modal-edit').modal('show');
                }
            })
        });

        $('#main_form_edit').submit(function(e) {
            e.preventDefault();

            $('.main_title_' + $('#main_edit_id').val()).empty();
            $('.main_link_' + $('#main_edit_id').val()).empty();

            var formData = {
                id: $('#main_edit_id').val(),
                title: $('#main_edit_title').val(),
                link: $('#main_edit_link').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('nav.main_update') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-main-edit-spinner').css("display", "block");
                    $('.btn-main-edit-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui.'
                    });

                    $('.main_title_' + response.id).append(response.title);
                    $('.main_link_' + response.id).append(response.link);

                    setTimeout(() => {
                        $('.btn-main-edit-spinner').css("display", "none");
                        $('.btn-main-edit-save').css("display", "block");
                        $('.main-modal-edit').modal('hide');
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // sub edit
        $('body').on('click', '.sub-btn-edit', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("nav.sub_edit", ":id") }}';
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
                    $('#sub_edit_id').val(response.id);
                    $('#sub_edit_title').val(response.title);
                    $('#sub_edit_link').val(response.link);

                    var nav_main_value = "<option value=\"\">--Pilih Menu Utama--</option>";

                    $.each(response.nav_mains, function(index, value) {
                        nav_main_value += "<option value=\"" + value.id + "\"";

                        if (value.id == response.nav_main_id) {
                            nav_main_value += "selected";
                        }

                        nav_main_value += ">" + value.title + "</option>";
                    });

                    $('#sub_edit_nav_main').append(nav_main_value);
                    $('.sub-modal-edit').modal('show');
                }
            })
        });

        $('#sub_form_edit').submit(function(e) {
            e.preventDefault();

            $('.sub_title_' + $('#sub_edit_id').val()).empty();
            $('.sub_link_' + $('#sub_edit_id').val()).empty();
            $('.sub_nav_main_' + $('#sub_edit_id').val()).empty();

            var formData = {
                id: $('#sub_edit_id').val(),
                title: $('#sub_edit_title').val(),
                link: $('#sub_edit_link').val(),
                nav_main_id: $('#sub_edit_nav_main').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('nav.sub_update') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-sub-edit-spinner').css("display", "block");
                    $('.btn-sub-edit-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui.'
                    });

                    $('.sub_title_' + response.id).append(response.title);
                    $('.sub_link_' + response.id).append(response.link);
                    $('.sub_nav_main_' + response.id).append(response.nav_main_title);

                    setTimeout(() => {
                        $('.btn-sub-edit-spinner').css("display", "none");
                        $('.btn-sub-edit-save').css("display", "block");
                        $('.sub-modal-edit').modal('hide');
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // main delete
        $('body').on('click', '.main-btn-delete', function(e) {
            e.preventDefault();
            $('.main_delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("nav.main_delete_btn", ":id") }}';
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
                    $('.main_delete_title').append(response.title);
                    $('#main_delete_id').val(response.id);
                    $('.main-modal-delete').modal('show');
                }
            });
        });

        $('#main_form_delete').submit(function(e) {
            e.preventDefault();

            var formData = {
                id: $('#main_delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('nav.main_delete') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-main-delete-spinner').css("display", "block");
                    $('.btn-main-delete-yes').css("display", "none");
                },
                success: function(response) {
                    if (response.status == "false") {
                        alert('Menu utama \"' + response.title + '\" terdapat di menu sub, hapus menu sub yg terdapat menu utama \"' + response.title + '\" terlebih dahulu ');
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus.'
                        });
                        setTimeout(() => {
                            window.location.reload(1);
                        }, 1000);
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // sub delete
        $('body').on('click', '.sub-btn-delete', function(e) {
            e.preventDefault();
            $('.sub_delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("nav.sub_delete_btn", ":id") }}';
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
                    $('.sub_delete_title').append(response.title);
                    $('#sub_delete_id').val(response.id);
                    $('.sub-modal-delete').modal('show');
                }
            });
        });

        $('#sub_form_delete').submit(function(e) {
            e.preventDefault();

            var formData = {
                id: $('#sub_delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('nav.sub_delete') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-sub-delete-spinner').css("display", "block");
                    $('.btn-sub-delete-yes').css("display", "none");
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
    } );
</script>
@endsection
