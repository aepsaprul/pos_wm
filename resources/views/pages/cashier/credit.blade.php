@extends('layouts.app')

@section('style')

{{-- select2 --}}
<link rel="stylesheet" href="{{ asset('theme/vendors/select2/dist/css/select2.min.css') }}">

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
                                <div class="col-sm-3">
                                    <div class="mb-1 row">
                                        <label for="product_code" class="col-sm-4 col-form-label"><strong>Kode Produk</strong></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="product_code" name="product_code">
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
                                        <label for="pay" class="col-sm-4 col-form-label"><strong>Bayar</strong></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="pay" name="pay">
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label for="change" class="col-sm-4 col-form-label">Kembalian</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="change" name="change" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-1 row">
                                        <label for="product_code" class="col-sm-4 col-form-label"><strong>Customer</strong></label>
                                        <div class="col-sm-8">
                                            <select name="customer_id" id="customer_id" class="form-control form-control-sm select_customer" style="width: 100%" autofocus>
                                                <option value="">--Pilih Customer--</option>
                                                @foreach ($customers as $item)
                                                    <option value="{{ $item->id }}">{{ $item->customer_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label for="up_price" class="col-sm-4 col-form-label"><strong>Jasa</strong></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="up_price" name="up_price">
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label for="bid" class="col-sm-4 col-form-label"><strong>Nego</strong></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="bid" name="bid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
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
                            <div class="card">
                                <div class="card-body">
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
                                            @foreach ($sales as $key => $item)
                                                <tr
                                                    @if ($key % 2 == 1)
                                                        echo class="tabel_active";
                                                    @endif
                                                >
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>{{ $item->product->product_code }}</td>
                                                    <td>{{ $item->product->product_name }}</td>
                                                    <td class="text-end">{{ rupiah($item->product->product_price) }}</td>
                                                    <td class="text-center">{{ rupiah($item->quantity) }}</td>
                                                    <td class="text-end">{{ rupiah($item->product->product_price * $item->quantity) }}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <form
                                                                action="{{ route('cashier.delete', [$item->id]) }}"
                                                                method="POST"
                                                                class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                        <button
                                                                            class="border-0 bg-white"
                                                                            onclick="return confirm('Yakin akan dihapus?')"
                                                                            title="Hapus">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                                                @foreach ($sales as $key => $item)
                                                <tr>
                                                    <td>{{ $item->product->product_name }}</td>
                                                    <td>{{ rupiah($item->quantity) }}</td>
                                                    <td class="text-end">{{ rupiah($item->product->product_price * $item->quantity) }}</td>
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
<script src="{{ asset('theme/vendors/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('.select_customer').select2();

        $('#product_code').on('keyup change', function() {
            var product_code = $('#product_code').val();
            var formData = {
                product_code: product_code,
                _token: CSRF_TOKEN
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
                    url: '{{ URL::route('cashier.sales_save') }}',
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
                    url: '{{ URL::route('cashier.sales_save') }}',
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
        })

        $('.invoice').hide();

        $('.btn-print').on('click', function() {
            if ($('#total_price').val() == 0) {
                alert('Data Pembelian Kosong');
            } else {

                var formData = {
                    bid: $('#bid').val().replace(/\./g,''),
                    total_amount: $('#total_price').val(),
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: '{{ URL::route('cashier.print') }}',
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
                        window.onafterprint = window.location.reload(1);
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
