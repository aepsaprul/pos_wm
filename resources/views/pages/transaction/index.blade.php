@extends('layouts.app')

@section('style')

@endsection

@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          @if (count($transactions) > 0)
            @foreach ($transactions as $item)
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Kode Transaksi : <strong><a href="{{ route('shop_buy.cart.invoice_print', [$item->code]) }}" target="_blank">{{ $item->code }}</a></strong> <span class="ml-3">{{ $item->created_at }}</span></h3>
                  <div class="card-tools">
                    <span class="font-weight-bold h3 mr-3">Rp. {{ rupiah($item->total_amount) }}</span>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th colspan="2">Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($item->productOut as $item_product)
                        <tr style="border-top: hidden;">
                          <td style="width: 100px;">
                            @if($item_product->product)
                              <img src="{{ asset('public/image/' . $item_product->product->productMaster->image) }}" alt="" class="img-circle" style="max-width: 80px;">
                            @endif
                          </td>
                          <td>
                            @if($item_product->product)
                              <p class="p-0 m-0"><b>{{ $item_product->product->product_name }}</b></p>
                              <p class="text-sm">Rp. {{ rupiah($item_product->product->product_price_selling) }} / {{ $item_product->product->unit }}</p>
                            @endif
                          </td>
                          <td class="text-center">{{ $item_product->quantity }}</td>
                          <td class="text-right">Rp. {{ rupiah($item_product->sub_total) }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endforeach
          @else
            <div class="card">
              <div class="card-body">
                <h5 class="text-center"><i class="fas fa-ban"></i> Transaksi Kosong</h5>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
</div>

<!-- modal delete all -->
<div class="modal fade modal-delete-all" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <form id="form_delete_all">

        <!-- id -->
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

<!-- modal delete -->
<div class="modal fade modal-delete" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <form id="form_delete">

        <!-- id -->
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

@endsection

@section('script')

@endsection
