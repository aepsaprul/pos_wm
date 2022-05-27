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
                        <div class="col-md-4">
                            <div class="card card-default">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="product_manual">Nama Produk</label>
                                                <select name="product_manual" id="product_manual" class="form-control form-control-sm product_manual_select2" style="width: 100%;">
                                                    <option value="">--Pilih Produk--</option>
                                                    @foreach ($product_manuals as $item)
                                                    @if ($item->product)

                                                    <option value="{{ $item->product->id }}">{{ $item->product->product_code }} - {{ $item->product->productMaster->name }} - {{ $item->product->product_name }}</option>
                                                    @endif
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
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="bid">Nego</label>
                                                <input type="text" class="form-control form-control-sm" id="bid" name="bid">
                                            </div>
                                        </div>
                                    </div>


                                    <input type="hidden" class="form-control" id="product_id" name="product_id">
                                    <input type="hidden" class="form-control form-control-sm" id="product_name" name="product_name" disabled>
                                    <input type="hidden" class="form-control form-control-sm" id="product_price" name="product_price" disabled>
                                    <input type="hidden" class="form-control form-control-sm" id="final_price" name="final_price" disabled>
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
                        <div class="col-md-8">
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
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="customer_id">Customer</label>
                                                    <select name="customer_id" id="customer_id" class="form-control form-control-sm select_customer" style="width: 100%;" autofocus>
                                                        <option value="">--Pilih Customer--</option>
                                                        @foreach ($customers as $item)
                                                            <option value="{{ $item->id }}">{{ $item->customer_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="pay_method">Metode Bayar</label>
                                                    <select name="pay_method" id="pay_method" class="form-control form-control-sm">
                                                        <option value="cash">Cash</option>
                                                        <option value="credit">Tempo</option>
                                                        <option value="edc">EDC</option>
                                                        <option value="warungmitra">Warung Mitra</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="credit">Jumlah Angsuran</label>
                                                    <select name="credit" id="credit" class="form-control form-control-sm" style="width: 100%;" autofocus>
                                                        <option value="">--Pilih Jumlah Angsuran--</option>
                                                        <option value="1">1 Minggu</option>
                                                        <option value="2">2 Minggu</option>
                                                        <option value="3">3 Minggu</option>
                                                        <option value="4">4 Minggu</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-tools">
                                        Rp. <span class="total_price_show font-weight-bold" style="font-size: 30px">{{ rupiah($total_price) }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="overflow-auto" style="max-height: 420px;">
                                        <ul class="products-list product-list-in-card pl-2 pr-2">
                                            @foreach ($sales as $key => $item)
                                                <li class="item">
                                                    <div class="product-info" style="margin-left: 0px;">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <div class="product-title">{{ $item->product->productMaster->name }} - {{ $item->product->product_name }}
                                                                    {{-- <span class="badge badge-danger float-right"><i class="fas fa-times p-1"></i></span> --}}
                                                                    <form
                                                                        action="{{ route('cashier.delete', [$item->id]) }}"
                                                                        method="POST"
                                                                        class="d-inline">
                                                                            @method('delete')
                                                                            @csrf
                                                                                <button
                                                                                    class="badge badge-danger float-right border-0"
                                                                                    onclick="return confirm('Yakin akan dihapus?')"
                                                                                    title="Hapus">
                                                                                    <i class="fa fa-times"></i>
                                                                                </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            @if ($item->promo_id)
                                                            {{-- {{$item->promo->promo->minimum_order_qty}} --}}
                                                                @if ($item->quantity >= $item->promo->promo->minimum_order_qty)
                                                                    @php
                                                                        $discount_produk = $item->product->product_price_selling * ($item->promo->promo->discount_percent / 100);
                                                                        $discount_harga = $item->product->product_price_selling - $discount_produk;
                                                                    @endphp
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                        <span style="text-decoration: line-through;">Rp. {{ rupiah($item->product->product_price_selling) }}</span> <span>Rp. {{ rupiah($discount_harga) }}</span>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                                                        <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}">
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                                        <strong style="text-decoration: line-through;">Rp {{ rupiah($item->product->product_price_selling * $item->quantity) }}</strong> <span>Rp {{ rupiah($discount_harga * $item->quantity) }}</span>
                                                                    </div>

                                                                @else
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                        <span>Rp. {{ rupiah($item->product->product_price_selling) }}</span>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                                                        <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}">
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                                        <strong>Rp {{ rupiah($item->product->product_price_selling * $item->quantity) }}</strong>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                    <span>Rp. {{ rupiah($item->product->product_price_selling) }}</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                                                    <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}">
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                                    <strong>Rp {{ rupiah($item->product->product_price_selling * $item->quantity) }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @foreach ($promos as $item_promo)
                                                        @if ($item_promo->product_id == $item->product_id)
                                                            @php
                                                                $discount = $item->product->product_price_selling * ($item_promo->promo->discount_percent / 100);
                                                            @endphp
                                                            <small class="text-danger"><i>Min beli {{ $item_promo->promo->minimum_order_qty }}, Harga turun jadi <strong>{{  rupiah($item->product->product_price_selling - $discount) }}</strong></i></small>
                                                        @endif
                                                    @endforeach
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
    </section>
</div>

@endsection

@section('script')

<!-- Select2 -->
<script src="{{ asset('public/themes/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select_customer').select2();
        $('.product_manual_select2').select2();

        $('#product_code').on('keyup change', function() {
            var product_code = $('#product_code').val();
            var formData = {
                product_code: product_code
            }

            $.ajax({
                url: "{{ URL::route('cashier.product') }}",
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
                    sub_total: final_price
                }

                $.ajax({
                    url: '{{ URL::route('cashier.sales_save') }}',
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

        // product manual
        $('#product_manual').on('keyup change', function() {
            var product_manual = $('#product_manual').val();
            var formData = {
                product_manual: product_manual
            }

            $.ajax({
                url: '{{ URL::route('cashier.product') }}',
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
                sub_total: final_price
            }

            $.ajax({
                url: "{{ URL::route('cashier.sales_save') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-cart-spinner').removeClass("d-none");
                    $('.btn-cart-save').addClass("d-none");
                },
                success: function(response) {
                    if (response.status == "true") {
                        setTimeout(() => {
                            window.location.reload(1);
                        }, 100);
                    } else {
                        alert('stok barang tidak cukup');
                        setTimeout(() => {
                            $('.btn-cart-spinner').addClass("d-none");
                            $('.btn-cart-save').removeClass("d-none");
                        }, 100);
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
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
                    sub_total: final_price
                }

                $.ajax({
                    url: '{{ URL::route('cashier.sales_save') }}',
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

        $('#pay_method').on('change', function() {
            $('.promo-row').empty();

            var pay_method = "";
            if ($(this).val() == "cash") {
                pay_method += "cash";
            } else if ($(this).val() == "edc") {
                pay_method += "edc";
            } else if ($(this).val() == "warungmitra") {
                pay_method += "warungmitra";
            } else {
                pay_method += "cash";
            }

            var formData = {
                pay_method: pay_method
            }

            $.ajax({
                url: '{{ URL::route('cashier.promo') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.promo != null) {
                        var value_promo = "" +
                            "<input type=\"hidden\" name=\"coupon_code\" id=\"coupon_code\" value=\"" + response.promo.coupon_code + "\">" +
                            "<label class=\"col-md-4 col-sm-4  control-label\">Promo</label>" +
                            "<div class=\"col-md-8 col-sm-8 \">" +
                                "<label>" +
                                    "<input type=\"radio\" name=\"promo\" id=\"promo\" value=\"" + response.promo.discount_value + "\" checked> " + response.promo.coupon_code +
                                "</label>" +
                            "</div>";
                        $('.promo-row').append(value_promo);

                        var total_sales = $('#total_price').val();
                        var promo = total_sales - response.promo.discount_value;
                        var promo_rp = format_rupiah(promo);
                        $('.total_price_show').text(promo_rp);
                        $('#total_price').val(promo);
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
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

        var bidRupiah = document.getElementById("bid");
        bidRupiah.addEventListener("keyup", function(e) {
            bidRupiah.value = formatRupiah(this.value, "");
        });

        $('#bid').on('keypress', function(event) {
            if (event.keyCode === 13) {
                var bid = $('#bid').val().replace(/\./g,'');
                var total_price = $('#total_price').val();
                var nego = total_price - bid;
                var negoRp = format_rupiah(nego);

                var nego_val = "" +
                        "<td class=\"text-end\">Nego</td>" +
                        "<td>:</td>" +
                        "<td class=\"text-end print_harga_nego\" style=\"border-top: 1px dashed #000;\">" + $('#bid').val() + "</td>";

                $('.nego_layout').append(nego_val);
                $('.print_total_price').text(negoRp);
                $('.total_price_show').text(negoRp);
                $('#total_price').val(nego);
            }
        });

        // $('#customer_id').on('change', function() {
        //     var total_price = $('#total_price').val();
        //     var before_discount = $('#before_discount').val();
        //     var discount = before_discount * 0.05;
        //     if ($(this).val() != "") {
        //         var discount_total = before_discount - discount;
        //         var discount_total_rp = format_rupiah(discount_total);

        //         $('.total_price_show').text(discount_total_rp);
        //         $('#total_price').val(discount_total);
        //         $('#discount').val(discount);
        //     } else {
        //         var discount_total = parseInt(total_price) + parseInt(discount);
        //         var discount_total_rp = format_rupiah(discount_total);

        //         $('.total_price_show').text(discount_total_rp);
        //         $('#total_price').val(before_discount);
        //     }
        // });

        $('.btn-print').on('click', function() {
            if ($('#total_price').val() == 0) {
                alert('Data Pembelian Kosong');
            } else {

                var formData = {
                    bid: $('#bid').val().replace(/\./g,''),
                    total_amount: $('#total_price').val(),
                    customer_id: $('#customer_id').val(),
                    credit: $('#credit').val(),
                    promo: $('#promo').val(),
                    coupon_code: $('#coupon_code').val(),
                    discount: $('#discount').val(),
                    pay_method: $('#pay_method').val(),
                    bayar: $('#pay').val().replace(/\./g,''),
                    kembalian: $('#change').val().replace(/\./g,'')
                }

                $.ajax({
                    url: '{{ URL::route('cashier.print') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {

                        var id = response.invoice_id;
                        var url = '{{ route("cashier.print_result", ":id") }}';
                        url = url.replace(':id', id );

                        window.open(url);
                        window.location.reload(1);
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
