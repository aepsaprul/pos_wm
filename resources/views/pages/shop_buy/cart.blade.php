@extends('layouts.app')

@section('style')

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('shop_buy.index') }}" class="btn bg-gradient-primary btn_belanja_lagi"><i class="fas fa-shopping-bag"></i> Belanja Lagi</a></h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Keranjang</h3>
                            <div class="card-tools">
                                <a href="#" class="btn bg-gradient-danger btn-sm mr-2 btn_delete_all" data-id="{{ $shop_id }}"><i class="fas fa-trash-alt"></i> Hapus Semua</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    @foreach ($carts as $item)
                                        <tr style="border-top: hidden;">
                                            <td style="width: 100px;"><img src="{{ asset('public/image/' . $item->product->image) }}" alt="" class="img-circle" style="max-width: 80px;"></td>
                                            <td>
                                                <p class="p-0 m-0"><b>{{ $item->product->product_name }}</b></p>
                                                <p class="text-sm">Rp. {{ rupiah($item->product->product_price_selling) }} / {{ $item->product->unit }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between quantity buttons_added">
                                                    <button type="button" id="minus_{{ $item->id }}" class="minus btn btn-outline-primary rounded-0" data-id="{{ $item->id }}" data-value="minus" style="font-size: 10px;" {{ $item->qty < 2 ? 'disabled' : '' }}><i class="fas fa-minus"></i></button>
                                                    <input type="text" id="qty_{{ $item->id }}" step="1" min="1" max="30" name="quantity" data-id="{{ $item->id }}" value="{{ $item->qty }}" title="Qty" class="form-control rounded-0 text-center qty text" size="4" onkeyup="if(this.value<0){this.value= this.value * -1}" />
                                                    <button type="button" class="plus btn btn-outline-primary rounded-0" data-id="{{ $item->id }}" data-value="plus" style="font-size: 10px;"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </td>
                                            <td><a href="#" class="btn_delete text-danger" data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ringkasan Belanja</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p>Total Belanja</p>
                                <p id="total_price" class="font-weight-bold text-lg">Rp. <span class="total_price_text">{{ rupiah($total_price) }}</span></p>
                            </div>
                            <button type="button" id="btn_metode_bayar" data-id="{{ $shop_id }}" class="btn btn-primary btn-block elevation-1">Pilih Metode Pembayaran</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- modal delete all --}}
<div class="modal fade modal-delete-all" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form id="form_delete_all">

                {{-- id  --}}
                <input type="hidden" id="delete_id" name="delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 120px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-delete-all-spinner d-none" disabled style="width: 120px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-delete-all text-center" style="width: 120px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal delete --}}
<div class="modal fade modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form id="form_delete">

                {{-- id  --}}
                <input type="hidden" id="delete_id" name="delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 120px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-delete-spinner d-none" disabled style="width: 120px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-delete text-center" style="width: 120px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal metode bayar  --}}
<div class="modal fade modal-metode-bayar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_metode_bayar">
                <div class="modal-header">
                    <h5 class="modal-title">Metode Pembayaran</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- id --}}
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <select name="metode_bayar" id="metode_bayar" class="form-control">
                            <option value="1">COD (Cash On Delivery)</option>
                            <option value="1">Transfer Bank BCA</option>
                            <option value="2">Transfer Bank Mandiri</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-metode-bayar-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary btn-metode-bayar" style="width: 130px;"><i class="fas fa-angle-double-right"></i> Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

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

        // quantity
        function wcqib_refresh_quantity_increments() {
            jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
                var c = jQuery(b);
                c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
            })
        }
        String.prototype.getDecimals || (String.prototype.getDecimals = function() {
            var a = this,
                b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
        }), jQuery(document).ready(function() {
            wcqib_refresh_quantity_increments()
        }), jQuery(document).on("updated_wc_div", function() {
            wcqib_refresh_quantity_increments()
        }), jQuery(document).on("click", ".plus, .minus", function() {

            $('#total_price').empty();
            let id = $(this).attr('data-id');

            let formData = {
                id: id,
                value: $(this).attr('data-value'),
                qty: $('#qty_' + id).val()
            }

            $.ajax({
                url: "{{ URL::route('shop_buy.cart.qty') }}",
                type: "post",
                data: formData,
                success: function (response) {
                    if (response.cart.qty < 2) {
                        $('#minus_' + response.cart.id).prop("disabled", true);
                    } else {
                        $('#minus_' + response.cart.id).prop("disabled", false);
                    }

                    $('#total_price').append("Rp. " + format_rupiah(response.total_price));
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            })

            var a = jQuery(this).closest(".quantity").find(".qty"),
                b = parseFloat(a.val()),
                c = parseFloat(a.attr("max")),
                d = parseFloat(a.attr("min")),
                e = a.attr("step");
            b && "" !== b && "NaN" !== b || (b = 0),
            "" !== c && "NaN" !== c || (c = ""),
            "" !== d && "NaN" !== d || (d = 0),
            "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1),
            jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
        });

        let timer = null;
        $('input[name="quantity"]').on('keyup', function () {
            $('#total_price').empty();
            let id = $(this).attr('data-id');

            clearTimeout(timer);

            timer = setTimeout(() => {
                let formData = {
                    id: id,
                    value: "input",
                    qty: $('#qty_' + id).val()
                }

                $.ajax({
                    url: "{{ URL::route('shop_buy.cart.qty') }}",
                    type: "post",
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        if (response.cart.qty < 2) {
                            $('#minus_' + response.cart.id).prop("disabled", true);
                        } else {
                            $('#minus_' + response.cart.id).prop("disabled", false);
                        }

                        $('#total_price').append("Rp. " + format_rupiah(response.total_price));
                    },
                    error: function(xhr, status, error){
                        var errorMessage = xhr.status + ': ' + error
                        alert('Error - ' + errorMessage);
                    }
                })
            }, 1000);
        })

        // delete all
        $('.btn_delete_all').on('click', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            $('#delete_id').val(id);
            $('.modal-delete-all').modal('show');
        })

        $('#form_delete_all').submit(function(e) {
            e.preventDefault();

            var formData = {
                id: $('#delete_id').val()
            }

            $.ajax({
                url: "{{ URL::route('shop_buy.cart.delete_all') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-delete-all-spinner').removeClass("d-none");
                    $('.btn-delete-all').addClass("d-none");
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
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        // delete
        $('.btn_delete').on('click', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            $('#delete_id').val(id);
            $('.modal-delete').modal('show');
        })

        $('#form_delete').submit(function(e) {
            e.preventDefault();

            var formData = {
                id: $('#delete_id').val()
            }

            $.ajax({
                url: "{{ URL::route('shop_buy.cart.delete') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.btn-delete-spinner').removeClass("d-none");
                    $('.btn-delete').addClass("d-none");
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
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            });
        });

        $('#btn_metode_bayar').on('click', function (e) {
            e.preventDefault();
            let id = $(this).attr('data-id');

            $('#id').val(id);
            $('.modal-metode-bayar').modal('show');
        })

        $('#form_metode_bayar').on('submit', function (e) {
            e.preventDefault();

            let formData = {
                shop_id: $('#id').val(),
                total_price: $('.total_price_text').text().replace(/\./g,''),
                payment_methods: $("#metode_bayar").val()
            }

            $.ajax({
                url: "{{ URL::route('shop_buy.cart.finish') }}",
                type: "post",
                data: formData,
                beforeSend: function() {
                    $('.btn-metode-bayar-spinner').removeClass("d-none");
                    $('.btn-metode-bayar').addClass("d-none");
                },
                success: function (response) {
                    console.log(response)
                    window.location.href = "cart/" + response.code + "/invoice";
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                }
            })
        })
    });
</script>
@endsection
