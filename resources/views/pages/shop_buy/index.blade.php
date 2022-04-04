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
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="search" class="form-control" placeholder="Caru produk disini">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-12 mt-3">
                                    <div class="elevation-1">
                                        <a href="#" class="text-secondary">
                                            <img src="{{ asset('assets/image_not_found.jpg') }}" alt="" style="width: 100%;">
                                            <div class="py-1 px-3">
                                                <h6 class="mb-0 text-center">
                                                    <small class="brand-text font-weight-bold">Nama Produk</small>
                                                </h6>
                                                <h6 class="mt-0 text-center">
                                                    <small>Rp. 140.000</small>
                                                </h6>
                                            </div>
                                        </a>
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

<script>
    $(document).ready(function() {

    });
</script>
@endsection
