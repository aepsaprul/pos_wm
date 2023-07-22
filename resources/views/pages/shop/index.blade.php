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
                    <h1 class="m-0">Toko</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Toko</li>
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
                                        <th class="text-center text-light">Kontak</th>
                                        <th class="text-center text-light">Email</th>
                                        <th class="text-center text-light">Alamat</th>
                                        <th class="text-center text-light">Kategori</th>
                                        <th class="text-center text-light">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shops as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->contact }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td class="text-capitalize">{{ $item->category }}</td>
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
                    <h5 class="modal-title">Tambah Toko</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_name" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control form-control-sm" id="create_name" name="create_name">
                    </div>
                    <div class="mb-3">
                        <label for="create_contact" class="form-label">Kontak</label>
                        <input type="text" class="form-control form-control-sm" id="create_contact" name="create_contact">
                    </div>
                    <div class="mb-3">
                        <label for="create_email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="create_email" name="create_email">
                    </div>
                    <div class="mb-3">
                        <label for="create_address">Alamat</label>
                        <textarea name="create_address" id="create_address" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="create_category" class="form-label">Kategori</label>
                        <select name="create_category" id="create_category" class="form-control">
                            <option value="">--Pilih Kategori--</option>
                            <option value="gudang">Gudang</option>
                            <option value="toko">Toko</option>
                        </select>
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

{{-- modal edit  --}}
<div class="modal fade modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_edit">

                {{-- id  --}}
                <input type="hidden" id="edit_id" name="edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Toko</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control form-control-sm" id="edit_name" name="edit_name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_contact" class="form-label">Kontak</label>
                        <input type="text" class="form-control form-control-sm" id="edit_contact" name="edit_contact">
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="edit_email" name="edit_email">
                    </div>
                    <div class="mb-3">
                        <label for="edit_address">Alamat</label>
                        <textarea name="edit_address" id="edit_address" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Kategori</label>
                        <select name="edit_category" id="edit_category" class="form-control">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 130px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-delete-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-delete-yes text-center" style="width: 130px;">Ya</button>
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

    $('#button-create').on('click', function() {
      $('.modal-create').modal('show');
    });

    $(document).on('shown.bs.modal', '.modal-create', function() {
      $('#create_name').focus();
    });

    $('#form_create').submit(function(e) {
      e.preventDefault();

      var formData = {
        name: $('#create_name').val(),
        contact: $('#create_contact').val(),
        email: $('#create_email').val(),
        address: $('#create_address').val(),
        category: $('#create_category').val()
      }

      $.ajax({
        url: "{{ URL::route('shop.store') }} ",
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

    $('body').on('click', '.btn-edit', function(e) {
      e.preventDefault();

      var id = $(this).attr('data-id');
      var url = '{{ route("shop.edit", ":id") }}';
      url = url.replace(':id', id );

      var formData = {
        id: id
      }

      $.ajax({
        url: url,
        type: 'GET',
        data: formData,
        success: function(response) {
          $('#edit_id').val(response.id);
          $('#edit_name').val(response.name);
          $('#edit_contact').val(response.contact);
          $('#edit_email').val(response.email);
          $('#edit_address').val(response.address);

          let val_category = "<option value=\"\">--Pilih Kategori--</option>" +
          "<option value=\"gudang\"";
          if (response.category == "gudang") {
            val_category += " selected";
          }
          val_category += ">Gudang</option>" +
          "<option value=\"toko\"";
          if (response.category == "toko") {
            val_category += " selected";
          }
          val_category += ">Toko</option>";
          $('#edit_category').append(val_category);

          $('.modal-edit').modal('show');
        }
      })
    });

    $(document).on('shown.bs.modal', '.modal-edit', function() {
      $('#edit_name').focus();
    });

    $('#form_edit').submit(function(e) {
      e.preventDefault();

      var formData = {
        id: $('#edit_id').val(),
        name: $('#edit_name').val(),
        contact: $('#edit_contact').val(),
        email: $('#edit_email').val(),
        address: $('#edit_address').val(),
        category: $('#edit_category').val()
      }

      $.ajax({
        url: "{{ URL::route('shop.update') }}",
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

    $('body').on('click', '.btn-delete', function(e) {
      e.preventDefault()

      var id = $(this).attr('data-id');
      var url = '{{ route("shop.delete_btn", ":id") }}';
      url = url.replace(':id', id );

      var formData = {
        id: id
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
        id: $('#delete_id').val()
      }

      $.ajax({
        url: "{{ URL::route('shop.delete') }}",
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
  });
</script>
@endsection
