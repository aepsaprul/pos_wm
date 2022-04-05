@extends('layouts.app')

@section('style')

{{-- select2 --}}
<link rel="stylesheet" href="{{ asset('public/themes/vendors/select2/dist/css/select2.min.css') }}">

@endsection

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="container mt-2">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-1 row">
                                        <label for="product_code" class="col-sm-4 col-form-label"><strong>Kode Produk</strong></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="product_code" name="product_code" autocomplete="off" autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label for="product_manual" class="col-sm-4 col-form-label"><strong>Nama Produk</strong></label>
                                        <div class="col-sm-8">
                                            <select name="product_manual" id="product_manual" class="form-control form-control-sm product_manual_select2">
                                                <option value="">Manual Produk</option>
                                                @foreach ($products as $item)
                                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label for="quantity" class="col-sm-4 col-form-label"><strong>Quantity</strong></label>
                                        <div class="col-sm-8">
                                            <input type="number" min="0" class="form-control form-control-sm" id="quantity" name="quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-1 row">
                                        <label for="shop_id" class="col-sm-2 col-form-label"><strong>Toko</strong></label>
                                        <div class="col-sm-10">
                                            <select name="shop_id" id="shop_id" class="form-control form-control-sm select_shop" autofocus>
                                                <option value="0">--Pilih Toko--</option>
                                                @foreach ($shops as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="hidden" class="form-control form-control-sm" id="discount" name="discount">
                                            <input type="hidden" class="form-control form-control-sm" id="before_discount" name="before_discount" value="{{ $total_price }}">
                                            <input type="hidden" name="total_price" id="total_price" value="{{ $total_price }}">
                                            <div class="p-3 text-center h3">Rp. <span class="total_price_show">{{ rupiah($total_price) }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="row">
                                        <input type="hidden" class="form-control" id="product_id" name="product_id">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control form-control-sm" id="product_name" name="product_name" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="stock" class="form-label">Stok</label>
                                                <input type="text" class="form-control form-control-sm" id="stock" name="stock" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="product_price" class="form-label">Harga Satuan (Rp)</label>
                                                <input type="text" class="form-control form-control-sm" id="product_price" name="product_price" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="final_price" class="form-label">Harga Akhir (Rp)</label>
                                                <input type="text" class="form-control form-control-sm" id="final_price" name="final_price" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-success py-3 px-4 btn-print">PRINT</button>
                                        <button type="button" class="btn btn-outline-danger py-3 px-4 btn-reset">RESET</button>
                                    </div>
                                </div>
                            </div>
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color: #2A3F54;">
                                    <tr>
                                        <th class="text-center text-white">No</th>
                                        <th class="text-center text-white">Kode Produk</th>
                                        <th class="text-center text-white">Nama Produk</th>
                                        <th class="text-center text-white">Harga Satuan</th>
                                        <th class="text-center text-white">Qty</th>
                                        <th class="text-center text-white">Harga Akhir</th>
                                        <th class="text-center text-white">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_outs as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $item->product->product_code }}</td>
                                            <td>{{ $item->product->product_name }}</td>
                                            <td class="text-end">{{ rupiah($item->product->product_price_selling) }}</td>
                                            <td class="text-center">{{ rupiah($item->quantity) }}</td>
                                            <td class="text-end">{{ rupiah($item->product->product_price_selling * $item->quantity) }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <form
                                                        action="{{ route('inventory_cashier.delete', [$item->id]) }}"
                                                        method="POST"
                                                        class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                                <button
                                                                    class="border-0 bg-transparent"
                                                                    onclick="return confirm('Yakin akan dihapus?')"
                                                                    title="Hapus">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- invoice --}}
                        <div class="container-fluid invoice">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-4 border border-1">
                                    <h3 class="h3 text-center">Nama Toko</h3>
                                    <p class="text-center">Jl. Pahlawan Tanpa Tanda Jasa No 2 Timur Masjid Agung</p>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <span>Kode Nota</span>
                                            <span class="invoice_code"></span>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-6 text-end">
                                            <span class="invoice_date"></span>
                                            <span class="invoice_time"></span>
                                        </div>
                                    </div>
                                    <hr style="border: 2px dashed #000;">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-12 invoice_data">
                                            <table width="100%">
                                                @foreach ($product_outs as $key => $item)
                                                <tr>
                                                    <td>{{ $item->product->product_name }}</td>
                                                    <td>{{ rupiah($item->quantity) }}</td>
                                                    <td class="text-end">{{ rupiah($item->product->product_price_selling * $item->quantity) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr class="nego_layout">
                                                    {{-- content in jquery --}}
                                                </tr>
                                                <tr>
                                                    <td class="text-end">Total</td>
                                                    <td>:</td>
                                                    <td class="text-end print_total_price" style="border-top: 1px dashed #000;">{{ rupiah($total_price) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <hr style="border: 2px dashed #000;">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-12 text-center footer">
                                            <span class="text-center">Telp: 081234567890</span><br>
                                            <span class="text-center">Wa: 081234567890</span><br>
                                            <span class="text-center">Email: toko@gmail.com</span>
                                        </div>
                                    </div>
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
<script src="{{ asset('public/themes/vendors/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('.invoice').hide();
        $('.select_customer').select2();
        $('.product_manual_select2').select2();

        $('#product_code').on('keyup change', function() {
            var product_code = $('#product_code').val();
            var formData = {
                product_code: product_code,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('inventory_cashier.product') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#product_id').val(response.product_id);
                    $('#product_name').val(response.product_name);
                    $('#stock').val(response.stock);
                    $('#quantity').val('1');

                    var product_price = format_rupiah(response.product_price);
                    $('#product_price').val(product_price);
                    $('#final_price').val(product_price);
                }
            });
        });

        $('#product_code').on('keypress', function(event) {
            if (event.keyCode === 13) {
                var product_id = $('#product_id').val();
                var quantity = $('#quantity').val();
                var product_price = $('#product_price').val();
                var product_price_replace = product_price.replace('.', '');
                var final_price = quantity * product_price_replace;

                var formData = {
                    quantity: quantity,
                    product_id: product_id,
                    sub_total: final_price,
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: '{{ URL::route('inventory_cashier.product_out_save') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        setTimeout(() => {
                            window.location.reload(1);
                        }, 100);
                    }
                });
            }
        });

        // product manual
        $('#product_manual').on('keyup change', function() {
            var product_manual = $('#product_manual').val();
            var formData = {
                product_manual: product_manual,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('inventory_cashier.product') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#product_id').val(response.product_id);
                    $('#product_name').val(response.product_name);
                    $('#stock').val(response.stock);
                    $('#quantity').val('1');

                    var product_price = format_rupiah(response.product_price);
                    $('#product_price').val(product_price);
                    $('#final_price').val(product_price);
                }
            });
        });

        $('#quantity').on('keyup change', function() {
            var quantity = $('#quantity').val();
            var product_price = $('#product_price').val();
            var product_price_replace = product_price.replace('.', '');

            var final_price = quantity * product_price_replace;
            var final_price_rp = format_rupiah(final_price);
            $('#final_price').val(final_price_rp);
        });

        $('#quantity').on('keypress', function(event) {
            if (event.keyCode === 13) {
                var product_id = $('#product_id').val();
                var quantity = $('#quantity').val();
                var product_price = $('#product_price').val();
                var product_price_replace = product_price.replace('.', '');
                var final_price = quantity * product_price_replace;
                var shop_id = $('#shop_id').val();

                var formData = {
                    quantity: quantity,
                    product_id: product_id,
                    sub_total: final_price,
                    shop_id: shop_id,
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: '{{ URL::route('inventory_cashier.product_out_save') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        setTimeout(() => {
                            window.location.reload(1);
                        }, 100);
                    }
                });
            }
        });

        $('.btn-print').on('click', function() {
            if ($('#total_price').val() == 0 || $('#shop_id').val() == 0) {
                alert('Toko harus dipilih dan Total Harga tidak boleh kosong');
            } else {

                var formData = {
                    total_amount: $('#total_price').val(),
                    shop_id: $('#shop_id').val(),
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: '{{ URL::route('inventory_cashier.print') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $('.invoice_code').append(response.invoice_code);
                        $('.invoice_date').append(response.invoice_date);
                        $('.invoice_time').append(response.invoice_time);

                        $('.justify-content-center').hide();
                        $('nav').hide();
                        $('.invoice').show();
                        window.print();
                        window.onafterprint = window.location.href = '{{ URL::route('inventory_invoice.index') }}';
                    }
                });
            }
        });

        $('.btn-reset').on('click', function() {
            window.location.reload(1);
        });
    });
</script>
@endsection
