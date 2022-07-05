@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bayar Angsuran: {{ $nasabah->nama }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Nasabah</li>
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
                            <div class="d-flex justify-content-between">
                                <button id="button-create" type="button" class="btn bg-gradient-primary btn-sm pl-3 pr-3" data-id="{{ $nasabah->id }}">
                                    <i class="fa fa-plus"></i> Tambah Data Bayar
                                </button>
                                <a href="{{ route('angsuran.index') }}" class="btn bg-gradient-danger btn-sm pl-3 pr-3">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead class="bg-info">
                                    <tr>
                                        <th class="text-center text-light">No</th>
                                        <th class="text-center text-light">Nama Angsuran</th>
                                        <th class="text-center text-light">Angsuran Ke</th>
                                        <th class="text-center text-light">Nominal</th>
                                        <th class="text-center text-light">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($angsuran_details as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $item->angsuran->nama }}</td>
                                            <td class="text-center">{{ $item->angsuran_ke }}</td>
                                            <td class="text-right">{{ $item->nominal }}</td>
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

{{-- modal create  --}}
<div class="modal fade modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Bayar</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_nama_angsuran" class="form-label">Nama Angsuran</label>
                        <select name="create_nama_angsuran" id="create_nama_angsuran" class="form-control"></select>
                    </div>
                    <div class="mb-3">
                        <label for="create_angsuran_ke" class="form-label">Angsuran Ke</label>
                        <select name="create_angsuran_ke" id="create_angsuran_ke" class="form-control">
                            <option value="">--Pilih Angsuran Ke--</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_nominal" class="form-label">Nominal</label>
                        <input type="text" class="form-control form-control-sm" id="create_nominal" name="create_nominal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-create-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-create-save" style="width: 130px;"><i class="fa fa-save"></i> Simpan</button>
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
            timer: 3000
        });

        $("#datatable").DataTable({
            'responsive': true
        });

        // create
        $('#button-create').on('click', function() {
            let id = $(this).attr('data-id');
            let url = '{{ route("angsuran.bayar_angsuran.create", ":id") }}';
            url = url.replace(':id', id );

            $.ajax({
                url: url,
                type: 'get',
                success: function (response) {
                    let val_angsuran = '<option value="0">--Pilih Angsuran--</option>';
                    $.each(response.angsurans, function (index, item) {
                        val_angsuran += '<option value="' + item.id + '">' + item.nama + '</option>';
                    })
                    $('#create_nama_angsuran').append(val_angsuran);

                    $('.modal-create').modal('show');
                }
            })
        });

        $(document).on('change', '#create_nama_angsuran', function () {
            $('#create_angsuran_ke').empty();

            let angsuran_id = $('#create_nama_angsuran').val();
            let url = '{{ route("angsuran.bayar_angsuran.create_angsuran_ke", ":id") }}';
            url = url.replace(':id', angsuran_id );

            $.ajax({
                url: url,
                type: 'get',
                success: function (response) {
                    console.log(response);
                    let array = response.angsuran_ke;
                    let val_angsuran_ke = '<option value="0">--Pilih Angsuran Ke--</option>';
                    for (let index = 0; index < array; index++) {
                        val_angsuran_ke += '<option value="' + (index + 1) + '">Angsuran Ke - ' + (index + 1) + '</option>';
                    }
                    $('#create_angsuran_ke').append(val_angsuran_ke);
                }
            })
        })

        $('#form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                nama_angsuran: $('#create_nama_angsuran').val(),
                angsuran_ke: $('#create_angsuran_ke').val(),
                nominal: $('#create_nominal').val()
            }

            $.ajax({
                url: "{{ URL::route('angsuran.bayar_angsuran.store') }} ",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-create-spinner').removeClass("d-none");
                    $('.btn-create-save').addClass("d-none");
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
            });
        });
    } );
</script>
@endsection
