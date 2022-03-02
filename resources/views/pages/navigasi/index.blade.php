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
                <h3>Data Navigasi</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_content">

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
                                <div class="x_title">
                                    <button
                                        id="sub-button-create"
                                        type="button"
                                        class="btn btn-primary btn-sm text-white pl-3 pr-3"
                                        title="Tambah">
                                            <i class="fa fa-plus"></i> Tambah
                                    </button>
                                </div>
                                <table id="table_two" class="table table-striped table-bordered" style="width:100%">
                                    <thead style="background-color: #2A3F54;">
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
                                                                <i class="fa fa-pencil px-2"></i> Ubah
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
                                <div class="x_title">
                                    <button
                                        id="main-button-create"
                                        type="button"
                                        class="btn btn-primary btn-sm text-white pl-3 pr-3"
                                        title="Tambah">
                                            <i class="fa fa-plus"></i> Tambah
                                    </button>
                                </div>
                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead style="background-color: #2A3F54;">
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
                                                                <i class="fa fa-pencil px-2"></i> Ubah
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
</div>

{{-- main modal create  --}}
<div class="modal fade main-modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_create">
                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Tambah Menu Utama</h5>
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
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;"><i class="fa fa-save"></i> Simpan</button>
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
                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Tambah Menu Sub</h5>
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
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;"><i class="fa fa-save"></i> Simpan</button>
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

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Menu Utama</h5>
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
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;"><i class="fa fa-save"></i> Perbaharui</button>
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

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Menu Sub</h5>
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
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;"><i class="fa fa-save"></i> Perbaharui</button>
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
                    <button type="button" class="btn btn-danger text-center" data-dismiss="modal" style="width: 100px;">Tidak</button>
                    <button type="submit" class="btn btn-primary text-center" style="width: 100px;">Ya</button>
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
                    <button type="button" class="btn btn-danger text-center" data-dismiss="modal" style="width: 100px;">Tidak</button>
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

        $('#table_two').DataTable({
            'ordering': false
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

            $('.main-modal-create').modal('hide');

            var formData = {
                title: $('#main_create_title').val(),
                link: $('#main_create_link').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.main_store') }} ',
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

        // sub create

        $('#sub-button-create').on('click', function() {
            $('#sub_create_nav_main').empty();

            $.ajax({
                url: '{{ URL::route('nav.sub_create') }}',
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

            $('.sub-modal-create').modal('hide');

            var formData = {
                title: $('#sub_create_title').val(),
                link: $('#sub_create_link').val(),
                nav_main_id: $('#sub_create_nav_main').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.sub_store') }} ',
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

            $('.main-modal-edit').modal('hide');
            $('.main_title_' + $('#main_edit_id').val()).empty();
            $('.main_link_' + $('#main_edit_id').val()).empty();

            var formData = {
                id: $('#main_edit_id').val(),
                title: $('#main_edit_title').val(),
                link: $('#main_edit_link').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.main_update') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.modal-proses').modal('show');

                    $('.main_title_' + response.id).append(response.title);
                    $('.main_link_' + response.id).append(response.link);

                    setTimeout(() => {
                        $('.modal-proses').modal('hide');
                    }, 1000);
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

            $('.sub-modal-edit').modal('hide');
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
                url: '{{ URL::route('nav.sub_update') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.modal-proses').modal('show');

                    $('.sub_title_' + response.id).append(response.title);
                    $('.sub_link_' + response.id).append(response.link);
                    $('.sub_nav_main_' + response.id).append(response.nav_main_title);

                    setTimeout(() => {
                        $('.modal-proses').modal('hide');
                    }, 1000);
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

            $('.main-modal-delete').modal('hide');

            var formData = {
                id: $('#main_delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.main_delete') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == "false") {
                        alert('Menu utama \"' + response.title + '\" terdapat di menu sub, hapus menu sub yg terdapat menu utama \"' + response.title + '\" terlebih dahulu ');
                    } else {
                        $('.modal-proses').modal('show');
                        setTimeout(() => {
                            window.location.reload(1);
                        }, 1000);
                    }
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

            $('.sub-modal-delete').modal('hide');

            var formData = {
                id: $('#sub_delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.sub_delete') }}',
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
