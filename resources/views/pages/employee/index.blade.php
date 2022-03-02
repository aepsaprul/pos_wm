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
                    <h1 class="m-0">Karyawan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Karyawan</li>
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
                                        <th class="text-center text-light">Nama</th>
                                        <th class="text-center text-light">Email</th>
                                        <th class="text-center text-light">Telepon</th>
                                        <th class="text-center text-light">Kantor</th>
                                        <th class="text-center text-light">Jabatan</th>
                                        <th class="text-center text-light">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $key => $item)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="full_name_{{ $item->id }}">{{ $item->full_name }}</td>
                                        <td class="email_{{ $item->id }}">{{ $item->email }}</td>
                                        <td class="contact_{{ $item->id }}">{{ $item->contact }}</td>
                                        <td class="shop_{{ $item->id }}">
                                            @if ($item->shop)
                                                {{ $item->shop->name }}
                                            @else
                                                Kantor kosong
                                            @endif
                                        </td>
                                        <td class="position_{{ $item->id }}">
                                            @if ($item->position)
                                                {{ $item->position->name }}
                                            @else
                                                Jabatan kosong
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
                                                        class="dropdown-item btn-view"
                                                        href="#"
                                                        data-id="{{ $item->id }}">
                                                            <i class="fa fa-eye px-2"></i> Lihat
                                                    </a>
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

{{-- modal create  --}}
<div class="modal fade modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Karyawan</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_full_name" class="form-label">Nama Lengkap</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="create_full_name"
                            name="create_full_name"
                            maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_nickname" class="form-label">Nama Panggilan</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="create_nickname"
                            name="create_nickname"
                            maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_email" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control form-control-sm"
                            id="create_email"
                            name="create_email"
                            maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_contact" class="form-label">Telepon</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="create_contact"
                            name="create_contact"
                            maxlength="15" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_address" class="form-label">Alamat</label>
                        <textarea class="form-control" name="create_address" id="create_address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="create_shop_id" class="form-label">Kantor</label>
                        <select name="create_shop_id" id="create_shop_id" class="form-control form-control-sm">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_position_id" class="form-label">Jabatan</label>
                        <select name="create_position_id" id="create_position_id" class="form-control form-control-sm">

                        </select>
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

{{-- modal view  --}}
<div class="modal fade modal-view" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_view">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="view_id"
                    name="view_id">

                <div class="modal-header">
                    <h5 class="modal-title">Detail Karyawan</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="view_full_name" class="form-label">Nama Lengkap</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="view_full_name"
                            name="view_full_name"
                            maxlength="50"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="view_nickname" class="form-label">Nama Panggilan</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="view_nickname"
                            name="view_nickname"
                            maxlength="30"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="view_email" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control form-control-sm"
                            id="view_email"
                            name="view_email"
                            maxlength="50"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="view_contact" class="form-label">Telepon</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="view_contact"
                            name="view_contact"
                            maxlength="15"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="view_address" class="form-label">Alamat</label>
                        <textarea class="form-control" name="view_address" id="view_address" rows="3" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="view_shop" class="form-label">Kantor</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="view_shop"
                            name="view_shop"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="view_position" class="form-label">Jabatan</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="view_position"
                            name="view_position"
                            readonly>
                    </div>
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
                <input
                    type="hidden"
                    id="edit_id"
                    name="edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Karyawan</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_full_name" class="form-label">Nama Lengkap</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="edit_full_name"
                            name="edit_full_name"
                            maxlength="50"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nickname" class="form-label">Nama Panggilan</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="edit_nickname"
                            name="edit_nickname"
                            maxlength="30"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control form-control-sm"
                            id="edit_email"
                            name="edit_email"
                            maxlength="50"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_contact" class="form-label">Telepon</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="edit_contact"
                            name="edit_contact"
                            maxlength="15"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_address" class="form-label">Alamat</label>
                        <textarea class="form-control" name="edit_address" id="edit_address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_shop_id" class="form-label">Kantor</label>
                        <select name="edit_shop_id" id="edit_shop_id" class="form-control form-control-sm">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_position_id" class="form-label">Jabatan</label>
                        <select name="edit_position_id" id="edit_position_id" class="form-control form-control-sm">

                        </select>
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

        $('#button-create').on('click', function() {
            $('#create_shop_id').empty();
            $('#create_position_id').empty();

            $.ajax({
                url: "{{ URL::route('employee.create') }}",
                type: 'GET',
                success: function(response) {
                    var shop_value = "<option value=\"\">--Pilih Kantor--</option>";

                    $.each(response.shops, function(index, value) {
                        shop_value += "<option value=\"" + value.id + "\">" + value.name + "</option>";
                    });


                    var position_value = "<option value=\"\">--Pilih Jabatan--</option>";

                    $.each(response.positions, function(index, value) {
                        position_value += "<option value=\"" + value.id + "\">" + value.name + "</option>";
                    });

                    $('#create_shop_id').append(shop_value);
                    $('#create_position_id').append(position_value);
                    $('.modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_full_name').focus();
        });

        $('#form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                full_name: $('#create_full_name').val(),
                nickname: $('#create_nickname').val(),
                email: $('#create_email').val(),
                contact: $('#create_contact').val(),
                address: $('#create_address').val(),
                shop_id: $('#create_shop_id').val(),
                position_id: $('#create_position_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('employee.store') }} ",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-create-spinner').css("display", "block");
                    $('.btn-create-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil disimpan.'
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

        $('body').on('click', '.btn-view', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("employee.show", ":id") }}';
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
                    $('#view_id').val(response.id);
                    $('#view_full_name').val(response.full_name);
                    $('#view_nickname').val(response.nickname);
                    $('#view_email').val(response.email);
                    $('#view_contact').val(response.contact);
                    $('#view_address').val(response.address);
                    $('#view_shop').val(response.shop);
                    $('#view_position').val(response.position);

                    $('.modal-view').modal('show');
                }
            })
        });

        $('body').on('click', '.btn-edit', function(e) {
            e.preventDefault();
            $('#edit_shop_id').empty();
            $('#edit_position_id').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("employee.edit", ":id") }}';
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
                    $('#edit_full_name').val(response.full_name);
                    $('#edit_nickname').val(response.nickname);
                    $('#edit_email').val(response.email);
                    $('#edit_contact').val(response.contact);
                    $('#edit_address').val(response.address);

                    // shop
                    var shop_value = "<option value=\"\">--Pilih Kantor--</option>";

                    $.each(response.shops, function(index, item) {
                        shop_value += "<option value=\"" + item.id + "\"";

                        if (item.id == response.shop_id) {
                            shop_value += "selected";
                        }

                        shop_value += ">" + item.name + "</option>";
                    });

                    // position
                    var position_value = "<option value=\"\">--Pilih Jabatan--</option>";

                    $.each(response.positions, function(index, item) {
                        position_value += "<option value=\"" + item.id + "\"";

                        if (item.id == response.position_id) {
                            position_value += "selected";
                        }

                        position_value += ">" + item.name + "</option>";
                    });

                    $('#edit_shop_id').append(shop_value);
                    $('#edit_position_id').append(position_value);
                    $('.modal-edit').modal('show');
                }
            })
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            $('.full_name_' + $('#edit_id').val()).empty();
            $('.email_' + $('#edit_id').val()).empty();
            $('.contact_' + $('#edit_id').val()).empty();
            $('.shop_' + $('#edit_id').val()).empty();
            $('.position_' + $('#edit_id').val()).empty();

            var formData = {
                id: $('#edit_id').val(),
                full_name: $('#edit_full_name').val(),
                nickname: $('#edit_nickname').val(),
                email: $('#edit_email').val(),
                contact: $('#edit_contact').val(),
                address: $('#edit_address').val(),
                shop_id: $('#edit_shop_id').val(),
                position_id: $('#edit_position_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('employee.update') }}",
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

                    $('.full_name_' + response.id).append(response.full_name);
                    $('.email_' + response.id).append(response.email);
                    $('.contact_' + response.id).append(response.contact);
                    $('.shop_' + response.id).append(response.shop);
                    $('.position_' + response.id).append(response.position);

                    setTimeout(() => {
                        $('.modal-edit').modal('hide');
                        $('.btn-edit-spinner').css("display", "none");
                        $('.btn-edit-save').css("display", "block");
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault()
            $('.delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("employee.delete_btn", ":id") }}';
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
                    $('.delete_title').append(response.full_name);
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
                url: "{{ URL::route('employee.delete') }}",
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
    } );
</script>
@endsection
