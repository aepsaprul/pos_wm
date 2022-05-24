@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Promo Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Promo Produk</li>
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
                            <div class="d-flex justify-content-between">
                                <div>
                                    <form action="{{ route('promo.add_product_save') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="promo_id" id="promo_id" value="{{ $promo->id }}">
                                        <div class="row">
                                            <div class="col-8">
                                                <select name="product_id" id="product_id" class="form-control">
                                                    <option value="">--Pilih Produk--</option>
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->id }}">{{ $item->productMaster->name }} - {{ $item->product_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div>
                                    <a href="{{ route('promo.index') }}" id="button-create" class="btn bg-gradient-danger btn-sm pl-3 pr-3">
                                        <i class="fa fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead class="bg-info">
                                    <tr>
                                        <th class="text-center text-light">No</th>
                                        <th class="text-center text-light">Nama Promo</th>
                                        <th class="text-center text-light">Nama Produk</th>
                                        <th class="text-center text-light">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promo_products as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $item->promo->promo_name }}</td>
                                            <td>{{ $item->product->productMaster->name }} - {{ $item->product->product_name }}</td>
                                            <td class="text-center"><a href="{{ route('promo.delete_promo_product', [$item->id]) }}" class="text-danger"><i class="fas fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')

<!-- DataTables  & Plugins -->
<script src="{{ asset('public/themes/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    })
</script>
@endsection
