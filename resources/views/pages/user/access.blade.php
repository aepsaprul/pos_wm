@extends('layouts.app')

@section('style')

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
                        <div class="card-header">
                            <h3 class="card-title">
                                @if (count($syncs) != 0)
                                    <div class="row">
                                        <div class="col-sm-8">
                                            {{ $employee->full_name }}
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-success btn-sm btn-sync-spinner" disabled style="width: 130px; display: none;">
                                                <span class="spinner-grow spinner-grow-sm"></span>
                                                Loading..
                                            </button>
                                            <button class="btn btn-success btn-sm btn-sync" data-id="{{ $employee->id }}" style="width: 130px"><i class="fa fa-refresh"></i> Sync</button>
                                        </div>
                                    </div>
                                @else
                                    {{ $employee->full_name }}
                                @endif
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('user.index') }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered" style="width:100%">
                                <thead class="bg-info">
                                    <tr>
                                        <th class="text-center text-light">Main</th>
                                        <th class="text-center text-light">Sub</th>
                                        <th class="text-center text-light">Index</th>
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
    </section>
</div>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

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
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui.'
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
                url: "{{ URL::route('user.sync') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-sync-spinner').css("display", "block");
                    $('.btn-sync').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil di sinkronisasi.'
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
