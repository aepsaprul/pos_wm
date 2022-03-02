@extends('layouts.app')

@section('style')
<link href="{{ asset('lib/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

<style>
    .col-md-12,
    .col-md-12 button {
        font-size: 12px;
    }
    .fas {
        font-size: 14px;
    }
    .btn {
        padding: .2rem .6rem;
    }
    input[type="text"] {
        border-top: none;
        border-right: none;
        border-bottom: 1px solid rgb(85, 85, 85);
        border-left: none;
        padding: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h6 class="text-uppercase text-center">Detail Penjualan</h6>

            <div class="row mb-5 mt-5">
                <div class="col-md-4">
                    <div class="mb-1 row">
                        <label for="invoice_code" class="col-sm-4 col-form-label"><strong>Kode Nota</strong></label>
                        <div class="col-sm-8">
                            <input type="text"
                                class="form-control form-control-sm"
                                value="{{ $invoice->code }}"
                                readonly
                                style="background-color: #fff;">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="date_recorded" class="col-sm-4 col-form-label"><strong>Tanggal</strong></label>
                        <div class="col-sm-8">
                            <input type="text"
                                class="form-control form-control-sm"
                                value="{{ date('d-m-Y', strtotime($invoice->date_recorded)) }}"
                                readonly
                                style="background-color: #fff;">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="total_amount" class="col-sm-4 col-form-label"><strong>Total Penjualan</strong></label>
                        <div class="col-sm-8">
                            <input type="text"
                                class="form-control form-control-sm"
                                value="{{ rupiah($invoice->total_amount) }}"
                                readonly
                                style="background-color: #fff;">
                        </div>
                    </div>
                </div>
            </div>

            <table id="table_one" class="table table-bordered">
                <thead style="background-color: #32a893;">
                    <tr>
                        <th class="text-white text-center fw-bold">No</th>
                        <th class="text-white text-center fw-bold">Nama Produk</th>
                        <th class="text-white text-center fw-bold">Quantity</th>
                        <th class="text-white text-center fw-bold">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $item->product->product_name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ rupiah($item->sub_total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('lib/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/jszip.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/buttons.html5.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#table_one').DataTable({
            'ordering': false
        });
    } );
</script>
@endsection
