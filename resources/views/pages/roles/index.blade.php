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
                <h3>Data Roles</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        @if (Auth::user()->roles_id == 0)
                        <button
                            id="button-create"
                            type="button"
                            class="btn btn-primary btn-sm text-white pl-3 pr-3"
                            title="Tambah">
                                <i class="fa fa-plus"></i> Tambah
                        </button>
                        @endif
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
                                                <th class="text-center text-light">Nama Roles</th>
                                                <th class="text-center text-light">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $key => $item)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
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
                                                                <a
                                                                    class="dropdown-item btn-access"
                                                                    href="#"
                                                                    data-id="{{ $item->id }}">
                                                                        <i class="fa fa-key px-2"></i> Akses
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
                    <h5 class="modal-title text-white">Tambah Roles</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_name" class="form-label">Nama</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="create_name"
                            name="create_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;">Simpan</button>
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

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Roles</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="edit_name"
                            name="edit_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;">Simpan</button>
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
                    <button type="button" class="btn btn-danger text-center" data-dismiss="modal" style="width: 100px;">Tidak</button>
                    <button type="submit" class="btn btn-primary text-center" style="width: 100px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal access  --}}
<div class="modal fade modal-access" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_access">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="access_id"
                    name="access_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Hak Akses Roles</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div id="navigation"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;">Simpan</button>
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
            $('.modal-create').modal('show');
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_name').focus();

        });

        $('#form_create').submit(function(e) {
            e.preventDefault();

            $('.modal-create').modal('hide');

            var formData = {
                name: $('#create_name').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('roles.store') }} ',
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

            var id = $(this).attr('data-id');
            var url = '{{ route("roles.edit", ":id") }}';
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
                    $('#edit_name').val(response.name);

                    $('.modal-edit').modal('show');
                }
            })
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            $('.modal-edit').modal('hide');

            var formData = {
                id: $('#edit_id').val(),
                name: $('#edit_name').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('roles.update') }}',
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

            var id = $(this).attr('data-id');
            var url = '{{ route("roles.delete_btn", ":id") }}';
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

            $('.modal-delete').modal('hide');

            var formData = {
                id: $('#delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('roles.delete') }}',
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

        $('body').on('click', '.btn-access', function(e) {
            e.preventDefault();
            $('#navigation').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("roles.access", ":id") }}';
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
                    $('#access_id').val(response.id);

                    $.each(response.nav_mains, function(index, value) {
                        if (value.nav_sub.length == 0) {
                            var nav_main_value = "" +
                                "<div class=\"form-check\">" +
                                    "<input class=\"form-check-input check_nav_main\" type=\"checkbox\" value=\"" + value.id + "\" name=\"check_nav_main[]\" id=\"check_nav_main_" + value.id + "\" data-id=\"" + value.id + "\"";

                                    $.each(response.roles_nav_mains, function(index, val) {
                                        if (val.nav_main_id == value.id) {
                                            nav_main_value += " checked";
                                        }
                                    });

                                    nav_main_value += ">" +
                                    "<label class=\"form-check-label\" for=\"check_nav_main_" + value.id + "\">" +
                                        value.title
                                    "</label>" +
                                "</div>";
                            $('#navigation').append(nav_main_value);
                        } else {
                            var nav_main_value = "" +
                                "<div class=\"form-check\">" +
                                    "<input class=\"form-check-input check_nav_main\" type=\"checkbox\" value=\"" + value.id + "\" name=\"check_nav_main[]\" id=\"check_nav_main_" + value.id + "\" data-id=\"" + value.id + "\"";

                                    $.each(response.roles_nav_mains, function(index, val) {
                                        if (val.nav_main_id == value.id) {
                                            nav_main_value += " checked";
                                        }
                                    });

                                    nav_main_value += ">" +
                                    "<label class=\"form-check-label\" for=\"check_nav_main_" + value.id + "\">" +
                                        value.title
                                    "</label>" +
                                "</div>" +
                                "<ul class=\"list-group\">";
                                $.each(value.nav_sub, function(index, value) {
                                    nav_main_value += "" +
                                        "<li class=\"list-group-item p-0 border-0\">" +
                                            "<div class=\"form-check\">" +
                                                "<input class=\"form-check-input check_nav_sub\" type=\"checkbox\" value=\"" + value.id + "\" name=\"check_nav_sub[]\" id=\"check_nav_sub_" + value.id + "\" data-main=\"" + value.nav_main_id + "\"";

                                                $.each(response.roles_nav_subs, function(index, val) {
                                                    if (val.nav_sub_id == value.id) {
                                                        nav_main_value += " checked";
                                                    }
                                                });

                                                nav_main_value += ">" +
                                                "<label class=\"form-check-label\" for=\"check_nav_sub_" + value.id + "\">" +
                                                    value.title
                                                "</label>" +
                                            "</div>" +
                                        "</li>";
                                });
                                nav_main_value += "</ul>";
                            $('#navigation').append(nav_main_value);
                        }
                    });

                    $('.modal-access').modal('show');
                }
            });
        });

        $('#form_access').submit(function(e) {
            e.preventDefault();

            $('.modal-access').modal('hide');

            const check_nav_main = [];
            const check_nav_sub = [];

            $('.check_nav_main').each(function() {
                if ($(this).is(":checked")) {
                    check_nav_main.push($(this).val());
                }
            });

            $('.check_nav_sub').each(function() {
                if ($(this).is(":checked")) {
                    check_nav_sub.push($(this).val());
                }
            });

            var formData = {
                id: $('#access_id').val(),
                nav_main: check_nav_main,
                nav_sub: check_nav_sub,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('roles.access_save') }}',
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
