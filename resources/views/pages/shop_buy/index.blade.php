@extends('layouts.app')

@section('style')
<style>
  .data-kategori {
    border: 1px solid #a0a0a0;
    border-radius: 5px;
    position: absolute;
    width: 100%;
    z-index: 1;
    margin-top: 70px;
    background-color: #fff;
    display: none;
  }
  .data-kategori-toggle {
    display: block;
  }
  .kolom {
    padding: 10px;
    width: 150px;
    float: left;
  }
</style>
@endsection

@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Belanja</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right"></ol>
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
              <div id="data-kategori" class="data-kategori">
                @foreach ($kategoris as $item)
                  <div class="kolom"><a href="{{ route('shop_buy.kategori', [$item->id]) }}">{{ $item->category_name }}</a></div>                            
                @endforeach
              </div>
              <div class="row mb-3 d-flex justify-content-center">
                <div class="col-sm-3 text-right d-flex justify-content-center">
                  <a href="{{ route('shop_buy.index') }}" class="btn btn-outline-secondary mr-2">Semua Produk</a>
                  <button id="btn-kategori" class="btn btn-outline-secondary">Kategori</button>
                </div>
                <div class="col-lg-4 col-md-4">
                  <form action="{{ route('shop_buy.search') }}" method="POST">
                    @csrf
                    <div class="input-group">
                      <input type="text" id="search" name="search" class="form-control" placeholder="Cari produk disini">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                          <i class="fa fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row product_data">
                @foreach ($products as $item)
                  <div class="col-lg-2 col-md-3 col-sm-4 col-12 mt-3">
                    <div class="elevation-1">
                      <div class="overlay-wrapper">
                        <div id="overlay_{{ $item->id }}" class="overlay d-none"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                        <a href="#" class="text-secondary product" data-id="{{ $item->id }}">
                          @if (file_exists("public/image/" . $item->productMaster->image))
                            <img src="{{ asset('public/image/' . $item->productMaster->image) }}" alt="" width="100%" height="180px;" style="object-fit: cover;">
                          @else
                            <img src="{{ asset('public/assets/image_not_found.jpg') }}" alt="" width="100%" height="180px;" style="object-fit: cover;">
                          @endif
                          <div class="py-1 px-3">
                            <h6 class="mb-0 text-center">
                              <small class="font-weight-bold">{{ substr($item->product_name, 0, 20) }}</small>
                            </h6>
                            <h6 class="mt-0 text-center">
                              <small>Rp. {{ rupiah($item->product_price_selling) }}</small>
                            </h6>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <div style="margin-top: 30px; display: flex; justify-content: center;">
                {{ $products->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade modal-form" id="modal-default" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form" method="post" enctype="multipart/form-data" class="form-create">
                <div class="modal-body">

                    {{-- id --}}
                    <input type="hidden" id="id" name="id">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-center profile_img mt-5">
                                <img
                                    style="max-width: 70%;"
                                    src="{{ asset('public/assets/image_not_found.jpg') }}"
                                    alt="User profile picture">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <button
                                type="button"
                                class="close mr-0"
                                data-dismiss="modal">
                                    <span aria-hidden="true" class="bg-gradient-danger px-2 pb-1 rounded-circle">x</span>
                            </button>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h3 id="product_name"></h3>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
                                    <h3>Rp. <span id="product_price_selling"></span> / <span id="unit"></span></h3>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card card-primary card-outline card-tabs">
                                        <div class="card-header p-0 border-bottom-0">
                                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Spesifikasi</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                    <textarea name="detail" id="detail" class="form-control rounded-0 border-0" cols="30" rows="9"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                                    <medium>Quantity</medium>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-3 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <div style="width: 150px;">
                                            <div class="d-flex justify-content-between quantity buttons_added">
                                                <button type="button" class="minus btn btn-outline-primary rounded-0" style="font-size: 10px;"><i class="fas fa-minus"></i></button>
                                                <input type="text" id="qty" step="1" min="1" max="30" name="quantity" value="1" title="Qty" class="form-control rounded-0 text-center qty text" size="4" pattern="" inputmode="" />
                                                <button type="button" class="plus btn btn-outline-primary rounded-0" style="font-size: 10px;"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" id="btn_cart" class="btn bg-gradient-primary rounded-0" style="width: 130px;"><i class="fas fa-shopping-cart"></i> Keranjang</button>
                                                <button class="btn bg-gradient-info btn-spinner rounded-0 d-none ml-3" disabled style="width: 130px;">
                                                    <span class="spinner-grow spinner-grow-sm"></span>
                                                    Loading...
                                                </button>
                                                <button type="button" id="btn_buy" class="btn btn-outline-primary rounded-0 ml-3" style="width: 130px;">Beli Langsung</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });

    // detail produk
    $('.product').on('click', function (e) {
      e.preventDefault();

      var id = $(this).attr('data-id');
      var url = '{{ route("shop_buy.detail", ":id") }}';
      url = url.replace(':id', id );

      $('#product_name').empty();
      $('#product_price_selling').empty();
      $('#unit').empty();
      $('#detail').empty();

      var formData = {
        id: id
      }

      $.ajax({
        url: url,
        type: 'GET',
        data: formData,
        beforeSend: function () {
          $('#overlay_' + id).removeClass('d-none');
        },
        success: function (response) {
          $('.overlay').addClass('d-none');
          $('#id').val(response.product.id);
          $('#product_name').append(response.product.product_name);
          $('#product_price_selling').append(format_rupiah(response.product.product_price_selling));
          $('#unit').append(response.product.unit);
          $('#detail').val(response.product.product_master.description);
          $('.profile_img img').prop("src", "{{ URL::to('') }}" + "/public/image/" + response.product.product_master.image);

          $('.modal-form').modal('show');
        }
      })
    })

    // quantity
    function wcqib_refresh_quantity_increments() {
      jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
        var c = jQuery(b);
        c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
      })
    }
    String.prototype.getDecimals || (String.prototype.getDecimals = function() {
      var a = this, b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
      return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
    }), jQuery(document).ready(function() {
      wcqib_refresh_quantity_increments()
    }), jQuery(document).on("updated_wc_div", function() {
      wcqib_refresh_quantity_increments()
    }), jQuery(document).on("click", ".plus, .minus", function() {
      var a = jQuery(this).closest(".quantity").find(".qty"),
          b = parseFloat(a.val()),
          c = parseFloat(a.attr("max")),
          d = parseFloat(a.attr("min")),
          e = a.attr("step");
      b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
    });

    // cart
    $(document).on('click', '#btn_cart', function (e) {
      e.preventDefault();
      $('.badge').empty();

      var shop_id = "{{ Auth::user()->employee->shop_id }}";

      let formData = {
        product_id: $('#id').val(),
        qty: $('#qty').val(),
        price: $('#product_price_selling').text().replace(/\./g,''),
        shop_id: shop_id,
      }

      $.ajax({
        url: "{{ URL::route('shop_buy.cart.store') }}",
        type: "POST",
        data: formData,
        beforeSend: function () {
          $('.btn-spinner').removeClass('d-none');
          $('#btn_cart').addClass('d-none');
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Berhasil ditambahkan ke keranjang'
          });

          setTimeout(() => {
            $('.btn-spinner').addClass('d-none');
            $('#btn_cart').removeClass('d-none');
            $('.badge').append(response.count_cart);
            window.location.reload(1);
          }, 1000);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + error
          alert('Error - ' + errorMessage);
        }
      })
    })

    // btn buy
    $(document).on('click', '#btn_buy', function (e) {
      var shop_id = "{{ Auth::user()->employee->shop_id }}";

      let formData = {
        product_id: $('#id').val(),
        qty: $('#qty').val(),
        price: $('#product_price_selling').text().replace(/\./g,''),
        shop_id: shop_id,
      }

      $.ajax({
        url: "{{ URL::route('shop_buy.cart.store') }}",
        type: "POST",
        data: formData,
        beforeSend: function () {
          $('.btn-spinner').removeClass('d-none');
          $('#btn_buy').addClass('d-none');
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Berhasil'
          });

          setTimeout(() => {
            $('.btn-spinner').addClass('d-none');
            $('#btn_buy').removeClass('d-none');
            $('.badge').append(response.count_cart);
            window.location.href = "{{ URL::route('shop_buy.cart') }}";
          }, 1000);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + error
          alert('Error - ' + errorMessage);
        }
      })
    })
  });

  $('#btn-kategori').on('click', function (e) {
    e.preventDefault();
    kategori();
  })

  function kategori() {
    let element = document.getElementById("data-kategori");
    element.classList.toggle('data-kategori-toggle');
  }
</script>

@endsection
