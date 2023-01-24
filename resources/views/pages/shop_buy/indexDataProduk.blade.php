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
{{ $products->links() }}