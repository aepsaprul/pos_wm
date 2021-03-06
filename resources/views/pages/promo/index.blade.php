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
                    <h1 class="m-0">Promo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Promo</li>
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
                                        <th class="text-center text-light">Nama Promo</th>
                                        <th class="text-center text-light">Metode Bayar</th>
                                        <th class="text-center text-light">Nominal</th>
                                        <th class="text-center text-light">Kode</th>
                                        <th class="text-center text-light">Minimal Belanja</th>
                                        <th class="text-center text-light">Publish</th>
                                        <th class="text-center text-light">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promos as $key => $item)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $item->promo_name }}</td>
                                        <td>{{ $item->pay_method }}</td>
                                        <td class="text-right">
                                            @if ($item->discount_value)
                                                {{ rupiah($item->discount_value) }}
                                            @endif

                                            @if ($item->discount_percent)
                                                {{ $item->discount_percent }} %
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->coupon_code }}</td>
                                        <td class="text-right">
                                            @if ($item->minimum_order)
                                                {{ rupiah($item->minimum_order) }}
                                            @endif

                                            @if ($item->minimum_order_qty)
                                                {{ $item->minimum_order_qty }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="index_publish[]" id="index_publish_{{ $item->id }}" data-id="{{ $item->id }}" value="{{ $item->publish }}"
                                                @if ($item->publish == "y")
                                                    checked
                                                @endif
                                            >
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
                                                        class="dropdown-item btn-add-product"
                                                        href="{{ route('promo.add_product', [$item->id]) }}"
                                                        data-id="{{ $item->id }}">
                                                            <i class="fa fa-box-open px-2"></i> Produk
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
                    <h5 class="modal-title">Tambah Promo</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_promo_name" class="form-label">Nama Promo</label>
                        <input type="text" class="form-control form-control-sm" id="create_promo_name" name="create_promo_name">
                    </div>
                    <div class="mb-3">
                        <label for="create_promo_method" class="form-label">Metode Promo</label>
                        <select name="create_promo_method" id="create_promo_method" class="form-control form-control-sm">
                            <option value="semua_produk">Semua Produk</option>
                            <option value="per_produk">Per Produk</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_pay_method" class="form-label">Metode Bayar</label>
                        <select name="create_pay_method" id="create_pay_method" class="form-control form-control-sm">
                            <option value="cash">Cash</option>
                            <option value="edc">EDC</option>
                            <option value="warungmitra">Warung Mitra</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_discount_value" class="form-label">Diskon Nominal (Angka)</label>
                        <input type="text" class="form-control form-control-sm" id="create_discount_value" name="create_discount_value">
                    </div>
                    <div class="mb-3">
                        <label for="create_discount_percent" class="form-label">Diskon Nominal (Percent)</label>
                        <input type="text" class="form-control form-control-sm" id="create_discount_percent" name="create_discount_percent">
                    </div>
                    <div class="mb-3">
                        <label for="create_minimum_order" class="form-label">Minimal Belanja</label>
                        <input type="text" class="form-control form-control-sm" id="create_minimum_order" name="create_minimum_order">
                    </div>
                    <div class="mb-3">
                        <label for="create_minimum_order_qty" class="form-label">Jumlah Minimal Belanja</label>
                        <input type="text" class="form-control form-control-sm" id="create_minimum_order_qty" name="create_minimum_order_qty">
                    </div>
                    <div class="mb-3">
                        <label for="create_coupon_code" class="form-label">Kode</label>
                        <input type="text" class="form-control form-control-sm" id="create_coupon_code" name="create_coupon_code">
                    </div>
                    <div class="mb-3">
                        <label for="create_publish" class="form-label">Publish</label>
                        <select name="create_publish" id="create_publish" class="form-control form-control-sm">
                            <option value="y">Y</option>
                            <option value="n">N</option>
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

{{-- modal edit  --}}
<div class="modal fade modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_edit">

                {{-- id  --}}
                <input type="hidden" id="edit_id" name="edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Promo</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_promo_name" class="form-label">Nama Promo</label>
                        <input type="text" class="form-control form-control-sm" id="edit_promo_name" name="edit_promo_name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_pay_method" class="form-label">Metode Bayar</label>
                        <select name="edit_pay_method" id="edit_pay_method" class="form-control form-control-sm">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_promo_method" class="form-label">Metode Bayar</label>
                        <select name="edit_promo_method" id="edit_promo_method" class="form-control form-control-sm">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_discount_value" class="form-label">Diskon Nominal (Angka)</label>
                        <input type="text" class="form-control form-control-sm" id="edit_discount_value" name="edit_discount_value">
                    </div>
                    <div class="mb-3">
                        <label for="edit_discount_percent" class="form-label">Diskon Nominal (Percent)</label>
                        <input type="text" class="form-control form-control-sm" id="edit_discount_percent" name="edit_discount_percent">
                    </div>
                    <div class="mb-3">
                        <label for="edit_minimum_order" class="form-label">Minimal Belanja</label>
                        <input type="text" class="form-control form-control-sm" id="edit_minimum_order" name="edit_minimum_order">
                    </div>
                    <div class="mb-3">
                        <label for="edit_minimum_order_qty" class="form-label">Jumlah Minimal Belanja</label>
                        <input type="text" class="form-control form-control-sm" id="edit_minimum_order_qty" name="edit_minimum_order_qty">
                    </div>
                    <div class="mb-3">
                        <label for="edit_coupon_code" class="form-label">Kode</label>
                        <input type="text" class="form-control form-control-sm" id="edit_coupon_code" name="edit_coupon_code">
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
            $('.modal-create').modal('show');
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_promo_name').focus();

            var discount_value = document.getElementById("create_discount_value");
            discount_value.addEventListener("keyup", function(e) {
                discount_value.value = formatRupiah(this.value, "");
            });

            var minimum_order = document.getElementById("create_minimum_order");
            minimum_order.addEventListener("keyup", function(e) {
                minimum_order.value = formatRupiah(this.value, "");
            });
        });

        $('#form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                promo_name: $('#create_promo_name').val(),
                promo_method: $('#create_promo_method').val(),
                pay_method: $('#create_pay_method').val(),
                discount_value: $('#create_discount_value').val().replace(/\./g,''),
                discount_percent: $('#create_discount_percent').val().replace(/\./g,''),
                minimum_order: $('#create_minimum_order').val().replace(/\./g,''),
                minimum_order_qty: $('#create_minimum_order_qty').val().replace(/\./g,''),
                coupon_code: $('#create_coupon_code').val(),
                publish: $('#create_publish').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('promo.store') }} ",
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
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }
            });
        });

        $('body').on('click', '.btn-edit', function(e) {
            e.preventDefault();

            $('#edit_pay_method').empty();
            $('#edit_discount_value').empty();
            $('#edit_discount_percent').empty();
            $('#edit_minimum_order').empty();
            $('#edit_minimum_order_qty').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("promo.edit", ":id") }}';
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
                    $('#edit_promo_name').val(response.promo_name);
                    $('#edit_pay_method').val(response.pay_method);
                    if (response.discount_value != null) {
                        $('#edit_discount_value').val(format_rupiah(response.discount_value));
                    } else {
                        $('#edit_discount_value').val('0');
                    }
                    $('#edit_discount_percent').val(response.discount_percent);
                    if (response.minimum_order != null) {
                        $('#edit_minimum_order').val(format_rupiah(response.minimum_order));
                    } else {
                        $('#edit_minimum_order').val('0');
                    }
                    $('#edit_minimum_order_qty').val(response.minimum_order_qty);
                    $('#edit_coupon_code').val(response.coupon_code);

                    var value_promo_method = "" +
                        "<option value=\"semua_produk\"";
                        if (response.promo_method == "semua_produk") {
                            value_promo_method += " selected";
                        }
                        value_promo_method += ">Semua Produk</option>" +
                        "<option value=\"per_produk\"";
                        if (response.promo_method == "per_produk") {
                            value_promo_method += " selected";
                        }
                        value_promo_method += ">Per Produk</option>";
                    $('#edit_promo_method').append(value_promo_method);

                    var value_pay_method = "" +
                        "<option value=\"cash\"";
                        if (response.pay_method == "cash") {
                            value_pay_method += " selected";
                        }
                        value_pay_method += ">Cash</option>" +
                        "<option value=\"edc\"";
                        if (response.pay_method == "edc") {
                            value_pay_method += " selected";
                        }
                        value_pay_method += ">EDC</option>" +
                        "<option value=\"warungmitra\"";
                        if (response.pay_method == "warungmitra") {
                            value_pay_method += " selected";
                        }
                        value_pay_method += ">Warung Mitra</option>";
                    $('#edit_pay_method').append(value_pay_method);

                    $('.modal-edit').modal('show');
                }
            })
        });

        $(document).on('shown.bs.modal', '.modal-edit', function() {
            $('#edit_promo_name').focus();

            var discount_value = document.getElementById("edit_discount_value");
            discount_value.addEventListener("keyup", function(e) {
                discount_value.value = formatRupiah(this.value, "");
            });

            var minimum_order = document.getElementById("edit_minimum_order");
            minimum_order.addEventListener("keyup", function(e) {
                minimum_order.value = formatRupiah(this.value, "");
            });
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            var id = $('#edit_id').val();
            var url = '{{ route("promo.update", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id,
                promo_name: $('#edit_promo_name').val(),
                promo_method: $('#edit_promo_method').val(),
                pay_method: $('#edit_pay_method').val(),
                discount_value: $('#edit_discount_value').val().replace(/\./g,''),
                discount_percent: $('#edit_discount_percent').val().replace(/\./g,''),
                minimum_order: $('#edit_minimum_order').val().replace(/\./g,''),
                minimum_order_qty: $('#edit_minimum_order_qty').val().replace(/\./g,''),
                coupon_code: $('#edit_coupon_code').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: url,
                type: 'PUT',
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
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }
            });
        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            $('.delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("promo.delete_btn", ":id") }}';
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
                    $('.delete_title').append(response.promo_name);
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
                url: "{{ URL::route('promo.delete') }}",
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
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // update publish
        $('input[name="index_publish[]"]').on('change', function() {
            var id = $(this).attr('data-id');
            var formData;

            var id = $(this).attr('data-id');
            var url = '{{ route("promo.publish", ":id") }}';
            url = url.replace(':id', id );

            if($('#index_publish_' + id).is(":checked")) {
                formData = {
                    id: id,
                    publish: "y",
                    _token: CSRF_TOKEN
                }
            } else {
                formData = {
                    id: id,
                    publish: "n",
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
                        title: 'Data berhasil diubah.'
                    });
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }
            });
        });
    } );
</script>
@endsection
