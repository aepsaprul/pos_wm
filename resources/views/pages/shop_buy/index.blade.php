@extends('layouts.app')

@section('style')

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
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Belanja</li>
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
                        <div class="card-body">
                            <form action="{{ route('shop_buy.search')  }}" method="POST">
                                <div class="row mb-3 d-flex justify-content-center">
                                    @csrf
                                    <div class="col-lg-4 col-md-4">
                                        <div class="input-group">
                                            <input type="text" id="search" name="search" class="form-control" placeholder="Cari produk disini">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row product_data">
                                @foreach ($products as $item)
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-12 mt-3">
                                        <div class="elevation-1">
                                            <a href="#" class="text-secondary">
                                                @if (file_exists("public/image/" . $item->image))
                                                    <img src="{{ asset('public/image/' . $item->image) }}" alt="" style="width: 100%;">
                                                @else
                                                    <img src="{{ asset('public/assets/image_not_found.jpg') }}" alt="" style="width: 100%;">
                                                @endif
                                                <div class="py-1 px-3">
                                                    <h6 class="mb-0 text-center">
                                                        <small class="brand-text font-weight-bold">{{ substr($item->product_name, 0, 20) }}</small>
                                                    </h6>
                                                    <h6 class="mt-0 text-center">
                                                        <small>Rp. {{ rupiah($item->product_price_selling) }}</small>
                                                    </h6>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')

@endsection
