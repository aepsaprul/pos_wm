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
                <h3>Tambah Data User</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 mb-5">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-4">
                            <div class="mb-1 row">
                                <label for="shop_id" class="col-sm-6 col-form-label">Nama Karyawan</label>
                                <div class="col-sm-6">
                                    <select name="employee_id" id="employee_id" class="form-control select-employee">
                                        <option value="0">--Pilih Karyawan--</option>
                                        @foreach ($employees as $item)
                                            <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1 row">
                                <label for="shop_id" class="col-sm-4 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="text" name="password" id="password" class="form-control">
                                </div>
                            </div>
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
                                                <th class="text-center text-light">Tambah</th>
                                                <th class="text-center text-light">Ubah</th>
                                                <th class="text-center text-light">Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subs as $key => $item)
                                                <tr>
                                                    <td rowspan="{{ $item->total }}">{{ $item->navMain->title }}</td>
                                                    @foreach ($menus as $item_menu)
                                                        @if ($item_menu->nav_main_id == $item->nav_main_id)
                                                                <td>{{ $item_menu->title }}</td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="index[]" id="index_{{ $item_menu->id }}" data-id="{{ $item_menu->id }}" value="{{ $item_menu->id }}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="create[]" id="create_{{ $item_menu->id }}" data-id="{{ $item_menu->id }}" value="{{ $item_menu->id }}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="edit[]" id="edit_{{ $item_menu->id }}" data-id="{{ $item_menu->id }}" value="{{ $item_menu->id }}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="delete[]" id="delete_{{ $item_menu->id }}" data-id="{{ $item_menu->id }}" value="{{ $item_menu->id }}">
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" id="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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

{{-- select2 --}}
<script src="{{ asset('theme/vendors/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('.select-employee').select2();

        $('#save').on('click', function() {
            var formData = {

            }
        });
    } );
</script>
@endsection
