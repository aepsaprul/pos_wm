@extends('layouts.app')

@section('style')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-default">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="product_manual">Nama Produk</label>
                                                <select name="product_manual" id="product_manual" class="form-control form-control-sm product_manual_select2" style="width: 100%;">
                                                    <option value="">--Pilih Produk--</option>
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->id }}">{{ $item->product_code }} - {{ $item->product_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" min="0" class="form-control form-control-sm" id="quantity" name="quantity">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" id="product_id" name="product_id">
                                    <input type="hidden" class="form-control form-control-sm" id="product_name" name="product_name" disabled>
                                    <input type="hidden" class="form-control form-control-sm" id="product_price" name="product_price" disabled>
                                    <input type="hidden" class="form-control form-control-sm" id="final_price" name="final_price" disabled>

                                    <input type="hidden" class="form-control form-control-sm" id="discount" name="discount">
                                    <input type="hidden" class="form-control form-control-sm" id="before_discount" name="before_discount" value="{{ $total_price }}">
                                    <input type="hidden" name="total_price" id="total_price" value="{{ $total_price }}">

                                    <div class="d-flex flex-row-reverse">
                                        <div class="p-2">
                                            <button class="btn btn-primary btn-cart-spinner d-none" disabled style="width: 130px;">
                                                <span class="spinner-grow spinner-grow-sm"></span>
                                                Loading..
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-sm btn-cart-save" style="width: 130px;"><i class="fa fa-cart-plus"></i> Keranjang</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="pay">Bayar</label>
                                                <input type="text" class="form-control form-control-sm" id="pay" name="pay">
                                                <small class="form-text text-muted">tekan ENTER untuk melihat kembalian</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="change">Kembalian</label>
                                                <input type="text" class="form-control form-control-sm" id="change" name="change" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row-reverse">
                                        <div class="p-2">
                                            <button class="btn btn-primary btn-cart-spinner" disabled style="width: 130px; display: none;">
                                                <span class="spinner-grow spinner-grow-sm"></span>
                                                Loading..
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-sm btn-print" style="width: 130px;"><i class="fa fa-print"></i> Cetak</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-default">
                                <div class="card-header">
                                    <input
                                        type="hidden"
                                        class="form-control form-control-sm"
                                        id="discount"
                                        name="discount">
                                    <input
                                        type="hidden"
                                        class="form-control form-control-sm"
                                        id="before_discount"
                                        name="before_discount"
                                        value="{{ $total_price }}">
                                    <input
                                        type="hidden"
                                        name="total_price"
                                        id="total_price"
                                        value="{{ $total_price }}">
                                    <div class="card-title">
                                        <div class="form-group">
                                            <label for="shop_id">Toko</label>
                                            <select name="shop_id" id="shop_id" class="form-control form-control-sm select_customer" style="width: 100%;" autofocus>
                                                <option value="">--Pilih Toko--</option>
                                                @foreach ($shops as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-tools">
                                        Rp. <span class="total_price_show font-weight-bold" style="font-size: 30px">{{ rupiah($total_price) }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="overflow-auto" style="max-height: 420px;">
                                        <ul class="products-list product-list-in-card pl-2 pr-2">
                                            @foreach ($product_outs as $key => $item)
                                                <li class="item">
                                                    <div class="product-info" style="margin-left: 0px;">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <div class="product-title">{{ $item->product->product_name }}
                                                                    {{-- <span class="badge badge-danger float-right"><i class="fas fa-times p-1"></i></span> --}}
                                                                    <form
                                                                        action="{{ route('inventory_cashier.delete', [$item->id]) }}"
                                                                        method="POST"
                                                                        class="d-inline">
                                                                            @method('delete')
                                                                            @csrf
                                                                                <button
                                                                                    class="badge badge-danger float-right"
                                                                                    onclick="return confirm('Yakin akan dihapus?')"
                                                                                    title="Hapus">
                                                                                    <i class="fa fa-times"></i>
                                                                                </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                Rp. {{ rupiah($item->product->product_price_selling) }}
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                                                <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                                <strong>Rp {{ rupiah($item->product->product_price_selling * $item->quantity) }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid invoice">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12 border border-1">
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
    </section>
</div>

@endsection

@section('script')

<!-- Select2 -->
<script src="{{ asset('public/themes/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('.select_customer').select2();
        $('.product_manual_select2').select2();

        $('#product_code').on('keyup change', function() {
            var product_code = $('#product_code').val();
            var formData = {
                product_code: product_code,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('inventory_cashier.product') }}",
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

        // product manual
        $('#product_manual').on('keyup change', function() {
            var product_manual = $('#product_manual').val();
            var formData = {
                product_manual: product_manual,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: "{{ URL::route('inventory_cashier.product') }}",
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
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }
            });
        });

        $('.btn-cart-save').on('click', function (e) {
            e.preventDefault();

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
                url: "{{ URL::route('inventory_cashier.product_out_save') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-cart-spinner').removeClass("d-none");
                    $('.btn-cart-save').addClass("d-none");
                },
                success: function(response) {
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 100);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
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

                var formData = {
                    quantity: quantity,
                    product_id: product_id,
                    sub_total: final_price,
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: "{{ URL::route('inventory_cashier.product_out_save') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        setTimeout(() => {
                            window.location.reload(1);
                        }, 100);
                    },
                    error: function(xhr, status, error){
                        var errorMessage = xhr.status + ': ' + xhr.statusText
                        alert('Error - ' + errorMessage);
                    }
                });
            }
        });

        var payRupiah = document.getElementById("pay");
        payRupiah.addEventListener("keyup", function(e) {
            payRupiah.value = formatRupiah(this.value, "");
        });

        $('#pay').on('keypress change', function(event) {
            if (event.keyCode === 13) {
                var pay = $('#pay').val();
                var pay_int = pay.replace(/\./g,'');
                var total_price = $('#total_price').val();

                if (parseInt(pay_int) < parseInt(total_price)) {
                    var money_min = total_price - pay_int;
                    $('#change').val("Bayar kurang " + format_rupiah(money_min));
                } else if (pay == "") {
                    alert('Kolom bayar harus diisi');
                } else {
                    var calculate = pay_int - total_price;
                    $('#change').val(format_rupiah(calculate));
                }

            }
        });

        $('.invoice').hide();

        $('.btn-print').on('click', function() {
            if ($('#total_price').val() == 0) {
                alert('Data Pembelian Kosong');
            } else if ($('#shop_id').val() == "") {
                alert('Toko harus diisi');
            } else {

                var formData = {
                    total_amount: $('#total_price').val(),
                    promo: $('#promo').val(),
                    discount: $('#discount').val(),
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: "{{ URL::route('inventory_cashier.print') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('.invoice_code').append(response.invoice_code);
                        $('.invoice_date').append(response.invoice_date);
                        $('.invoice_time').append(response.invoice_time);

                        var id = response.invoice_id;
                        var url = '{{ route("inventory_cashier.print_result", ":id") }}';
                        url = url.replace(':id', id );

                        window.open(url);
                        window.location.reload(1);
                    }
                });
            }
        });

        $('#btn-reset').on('click', function() {
            window.location.reload(1);
        });
    });
</script>

@endsection
