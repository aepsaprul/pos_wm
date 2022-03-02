@extends('layouts.app')

@section('style')

{{-- select2 --}}
<link rel="stylesheet" href="{{ asset('theme/vendors/select2/dist/css/select2.min.css') }}">

@endsection

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Hak Akses User</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 mb-5">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-4">
                            <div class="mb-1 row">
                                <h5>
                                    @if (count($syncs) != 0)
                                        <div class="col-sm-8">
                                            {{ $employee->full_name }}
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-success btn-sm btn-sync-spinner" disabled style="width: 120px; display: none;">
                                                <span class="spinner-grow spinner-grow-sm"></span>
                                                Loading..
                                            </button>
                                            <button class="btn btn-success btn-sm btn-sync" data-id="{{ $employee->id }}" style="width: 120px"><i class="fa fa-refresh"></i> Sync</button>
                                        </div>
                                    @else
                                        {{ $employee->full_name }}
                                    @endif
                                </h5>
                            </div>
                        </div>
                            <div class="nav navbar-right panel_toolbox">
                                <a href="{{ route('user.index') }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable" class="table table-bordered" style="width:100%">
                                        <thead style="background-color: #2A3F54;">
                                            <tr>
                                                <th class="text-center text-light">Main</th>
                                                <th class="text-center text-light">Sub</th>
                                                <th class="text-center text-light">Index</th>
                                                {{-- <th class="text-center text-light">Tambah</th>
                                                <th class="text-center text-light">Ubah</th>
                                                <th class="text-center text-light">Hapus</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subs as $key => $item)
                                                <tr>
                                                    <td rowspan="{{ $item->total }}">{{ $item->navMain->title }}</td>
                                                    @foreach ($menus as $item_menu)
                                                        @if ($item_menu->main_id == $item->main_id)
                                                                <td>{{ $item_menu->navSub->title }}</td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="index[]" id="index_{{ $item_menu->id }}" data-id="{{ $item_menu->id }}" value="{{ $item_menu->tampil }}" {{ $item_menu->tampil == "y" ? 'checked' : '' }}>
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <input type="checkbox" name="create[]" id="create_{{ $item_menu->id }}" data-id="{{ $item_menu->id }}" value="{{ $item_menu->create }}" {{ $item_menu->create == "y" ? 'checked' : '' }}>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="edit[]" id="edit_{{ $item_menu->id }}" data-id="{{ $item_menu->id }}" value="{{ $item_menu->edit }}" {{ $item_menu->edit == "y" ? 'checked' : '' }}>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="delete[]" id="delete_{{ $item_menu->id }}" data-id="{{ $item_menu->id }}" value="{{ $item_menu->delete }}" {{ $item_menu->delete == "y" ? 'checked' : '' }}>
                                                                </td> --}}
                                                            </tr>
                                                        @endif
                                                    @endforeach
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

@endsection

@section('script')

{{-- select2 --}}
<script src="{{ asset('theme/vendors/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('.select-employee').select2();

        // index
        $('input[name="index[]"]').on('change', function() {
            var id = $(this).attr('data-id');
            var formData;

            var id = $(this).attr('data-id');
            var url = '{{ route("user.access_save", ":id") }}';
            url = url.replace(':id', id );

            if($('#index_' + id).is(":checked")) {
                formData = {
                    id: id,
                    show: "y",
                    _token: CSRF_TOKEN
                }
            } else {
                formData = {
                    id: id,
                    show: "n",
                    _token: CSRF_TOKEN
                }
            }

            $.ajax({
                url: url,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    var a = new PNotify({
                        title: 'Success',
                        text: 'Data berhasil diubah',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                }
            });
        });

        // create
        $('input[name="create[]"]').on('change', function() {
            var id = $(this).attr('data-id');
            var formData;

            var id = $(this).attr('data-id');
            var url = '{{ route("user.access_save", ":id") }}';
            url = url.replace(':id', id );

            if($('#create_' + id).is(":checked")) {
                formData = {
                    id: id,
                    create: "y",
                    _token: CSRF_TOKEN
                }
            } else {
                formData = {
                    id: id,
                    create: "n",
                    _token: CSRF_TOKEN
                }
            }

            $.ajax({
                url: url,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    var a = new PNotify({
                        title: 'Success',
                        text: 'Data berhasil diubah',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                }
            });
        });

        // edit
        $('input[name="edit[]"]').on('change', function() {
            var id = $(this).attr('data-id');
            var formData;

            var id = $(this).attr('data-id');
            var url = '{{ route("user.access_save", ":id") }}';
            url = url.replace(':id', id );

            if($('#edit_' + id).is(":checked")) {
                formData = {
                    id: id,
                    edit: "y",
                    _token: CSRF_TOKEN
                }
            } else {
                formData = {
                    id: id,
                    edit: "n",
                    _token: CSRF_TOKEN
                }
            }

            $.ajax({
                url: url,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    var a = new PNotify({
                        title: 'Success',
                        text: 'Data berhasil diubah',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                }
            });
        });

        // delete
        $('input[name="delete[]"]').on('change', function() {
            var id = $(this).attr('data-id');
            var formData;

            var id = $(this).attr('data-id');
            var url = '{{ route("user.access_save", ":id") }}';
            url = url.replace(':id', id );

            if($('#delete_' + id).is(":checked")) {
                formData = {
                    id: id,
                    delete: "y",
                    _token: CSRF_TOKEN
                }
            } else {
                formData = {
                    id: id,
                    delete: "n",
                    _token: CSRF_TOKEN
                }
            }

            $.ajax({
                url: url,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    var a = new PNotify({
                        title: 'Success',
                        text: 'Data berhasil diubah',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                }
            });
        });

        // sync
        $('.btn-sync').on('click', function() {
            var formData = {
                id: $(this).attr('data-id'),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('user.sync') }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-sync-spinner').css("display", "block");
                    $('.btn-sync').css("display", "none");
                },
                success: function(response) {
                    var a = new PNotify({
                        title: 'Success',
                        text: 'Data berhasil di sinkronisasi',
                        type: 'success',
                        styling: 'bootstrap3'
                    });

                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                }
            });
        });
    } );
</script>
@endsection
