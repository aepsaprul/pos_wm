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
                    <h1 class="m-0">User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                                        <th class="text-center text-light">Toko</th>
                                        <th class="text-center text-light">Jabatan</th>
                                        <th class="text-center text-light">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @if ($item->employee)
                                                    {{ $item->employee->email }}
                                                @else
                                                    Email tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->employee)
                                                    @if ($item->employee->shop)
                                                        {{ $item->employee->shop->name }}
                                                    @else
                                                        Toko tidak ada
                                                    @endif
                                                @else
                                                    Karyawan tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->employee)
                                                    @if ($item->employee->position)
                                                        {{ $item->employee->position->name }}
                                                    @else
                                                        Jabatan tidak ada
                                                    @endif
                                                @else
                                                    Karyawan tidak ada
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
                                                            class="dropdown-item"
                                                            href="{{ route('user.akses', [$item->id]) }}">
                                                                <i class="fa fa-key px-2"></i> Akses
                                                        </a>
                                                        <a
                                                            class="dropdown-item btn-ubah"
                                                            href="#"
                                                            data-id="{{ $item->id }}">
                                                                <i class="fa fa-lock px-2"></i> Ubah Password
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
                    <h5 class="modal-title">Tambah User</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_employee_id" class="form-label">Nama Karyawan</label>
                        <select name="create_employee_id" id="create_employee_id" class="form-control form-control-sm select2_employee">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_password" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control form-control-sm"
                            id="create_password"
                            name="create_password"
                            maxlength="100"
                            required>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="" id="view_password">
                            <label class="form-check-label" for="view_password" style="font-size: 12px;">
                                Lihat Password
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-create-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-create-save" style="width: 130px;"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal ubah  --}}
<div class="modal fade modal-ubah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_ubah">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Password User</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">

                  {{-- id  --}}
                  <input type="hidden" id="ubah_id" name="ubah_id">

                    <div class="mb-3">
                        <label for="ubah_employee_id" class="form-label">Nama Karyawan</label>
                        <input type="text" name="ubah_employee_id" id="ubah_employee_id" class="form-control form-control-sm">
                    </div>
                    <div class="mb-3">
                        <label for="ubah_password" class="form-label">Ubah Password</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="ubah_password"
                            name="ubah_password"
                            maxlength="100"
                            required>
                        <div class="form-check mt-2">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-ubah-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-ubah-save" style="width: 130px;"><i class="fa fa-save"></i> Simpan</button>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 100px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-delete-spinner" disabled style="width: 120px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-delete-yes text-center" style="width: 100px;">Ya</button>
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
            $('#create_roles').empty();
            $('#create_employee_id').empty();

            $.ajax({
                url: "{{ URL::route('user.create') }}",
                type: 'GET',
                success: function(response) {
                    var employee_val = "<option value=\"\">--Pilih Karyawan--</option>";

                    $.each(response.employees, function(index, value) {
                        employee_val += "<option value=\"" + value.id + "\">" + value.full_name + "</option>";
                    });

                    $('#create_employee_id').append(employee_val);
                    $('.modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_employee_id').focus();

            $('.select2_employee').select2({
                dropdownParent: $('.modal-create')
            });
        });

        $('#view_password').on('change', function() {
            if ($('#view_password').is(":checked")) {
                $('#create_password').attr('type', 'text');
            } else {
                $('#create_password').attr('type', 'password');
            }
        });

        $('#form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                employee_id: $('#create_employee_id').val(),
                email: $('#create_email').val(),
                password: $('#create_password').val(),
                roles: $('#create_roles').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('user.store') }} ",
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
                    var errorMessage = xhr.status + ': ' + xhr.error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // ubah password
        $('body').on('click', '.btn-ubah', function(e) {
          e.preventDefault()

          var id = $(this).attr('data-id');
          var url = '{{ route("user.ubahPasswordForm", ":id") }}';
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
              $('#ubah_id').val(response.user.id);
              $('#ubah_employee_id').val(response.user.name);
              $('.modal-ubah').modal('show');
            }
          });
        });

        $('#form_ubah').submit(function(e) {
            e.preventDefault();

            var formData = {
                id: $('#ubah_id').val(),
                password: $('#ubah_password').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('user.ubahPasswordStore') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-ubah-spinner').css("display", "block");
                    $('.btn-ubah-save').css("display", "none");
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

        // delete
        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault()

            var id = $(this).attr('data-id');
            var url = '{{ route("user.delete_btn", ":id") }}';
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
                    $('.delete_title').append(response.name);
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
                url: "{{ URL::route('user.delete') }}",
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
