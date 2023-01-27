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
          <h1 class="m-0">Transaksi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Transaksi</li>
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
            <div class="card-header">
              <div class="row">
                <div class="col-10">
                  <div class="d-flex justify-content-start">
                    <div>Tanggal Mulai <input type="date" name="start_date" id="start_date" class="form-control"></div>
                    <div class="ml-2">Tanggal Selesai <input type="date" name="end_date" id="end_date" class="form-control"></div>
                    <div class="p-4"><button class="btn btn-primary btn-cari" style="width: 100px;">Cari</button></div>
                    <div class="p-4 ml-2 mt-2">Total Belanja</div>
                    <div class="p-4 mt-2 font-weight-bold">Rp <span class="value-total-belanja">{{ rupiah($total_belanja->total_amount_) }}</span></div>
                  </div>
                </div>
                <div class="col-2">
                  <div class="d-flex justify-content-end">
                    {{-- <div>Tanggal Bayar</div>
                    <div class="ml-2 font-weight-bold">20/12/2022</div> --}}
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body data-transaksi"></div>
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
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    dataTransaksi();
    function dataTransaksi() {
      $('.data-transaksi').empty();

      $.ajax({
        url: "{{ URL::route('shop.transaksi.dataTransaksi') }}",
        type: "get",
        success: function (response) {
          console.log(response);
          let data_transaksi = '' +
          '<table id="data_transaksi" class="table table-striped table-bordered" style="width:100%">' +
            '<thead class="bg-info">' +
              '<tr>' +
                '<th class="text-center text-light">Nota</th>' +
                '<th class="text-center text-light">Tanggal</th>' +
                '<th class="text-center text-light">Tanggal Bayar</th>' +
                '<th class="text-center text-light">Metode Bayar</th>' +
                '<th class="text-center text-light">Jumlah Uang</th>' +
                '<th class="text-center text-light">Status</th>' +
              '</tr>' +
            '</thead>' +
            '<tbody>';
              $.each(response.transaksi, function (index, item) {
                let url = '{{ route("shop_buy.cart.invoice", ":id") }}';
                url = url.replace(':id', item.code );
                data_transaksi += '' +
                '<tr>' +
                  '<td><a href="' + url + '" target="_blank">' + item.code + '</a></td>' +
                  '<td class="text-center">' + item.created_at + '</td>' +
                  '<td class="text-center">';
                  if (item.tanggal_tempo == null) {
                    data_transaksi += "";
                  } else {
                    data_transaksi += tanggal(item.tanggal_tempo);
                  }
                  data_transaksi += '</td>' +
                  '<td>' + item.payment_methods + '</td>' +
                  '<td>' + item.total_amount + '</td>' +
                  '<td class="text-center text-uppercase">' + item.status_transaksi.nama + '</td>' +
                '</tr>';
              })
            data_transaksi += '' +
            '</tbody>' +
          '</table>';

          $('.data-transaksi').append(data_transaksi);

          $("#data_transaksi").DataTable({
            "responsive": true,
            "ordering": false
          });
        }
      })
    }

    $(document).on('click', '.btn-cari', function (e) {
      e.preventDefault();

      if ($('#start_date').val() == "" || $('#end_date').val() == "") {
        alert('Tanggal Harus Diisi');
      } else {
        $('.data-transaksi').empty();
        $('.value-total-belanja').empty();

        const start_date = $('#start_date').val();
        const end_date = $('#end_date').val();

        const formData = {
          start_date: start_date,
          end_date: end_date
        }

        $.ajax({
          url: "{{ URL::route('shop.transaksi.dataSearch') }}",
          type: "post",
          data: formData,
          success: function (response) {
            console.log(response);
            let url = '{{ route("shop_buy.cart.invoice", ":id") }}';
            let data_transaksi = '' +
            '<table id="data_transaksi" class="table table-striped table-bordered" style="width:100%">' +
              '<thead class="bg-info">' +
                '<tr>' +
                  '<th class="text-center text-light">Nota</th>' +
                  '<th class="text-center text-light">Tanggal</th>' +
                  '<th class="text-center text-light">Tanggal Bayar</th>' +
                  '<th class="text-center text-light">Metode Bayar</th>' +
                  '<th class="text-center text-light">Jumlah Uang</th>' +
                  '<th class="text-center text-light">Status</th>' +
                '</tr>' +
              '</thead>' +
              '<tbody>';
                $.each(response.transaksi, function (index, item) {
                  url = url.replace(':id', item.code );
                  data_transaksi += '' +
                  '<tr>' +
                    '<td><a href="' + url + '" target="_blank">' + item.code + '</a></td>' +
                    '<td class="text-center">' + item.created_at + '</td>' +
                    '<td class="text-center">';
                    if (item.tanggal_tempo == null) {
                      data_transaksi += "";
                    } else {
                      data_transaksi += tanggal(item.tanggal_tempo);
                    }
                    data_transaksi += '</td>' +
                    '<td>' + item.payment_methods + '</td>' +
                    '<td>' + item.total_amount + '</td>' +
                    '<td class="text-center text-uppercase">' + item.status_transaksi.nama + '</td>' +
                  '</tr>';
                })
              data_transaksi += '' +
              '</tbody>' +
            '</table>';

            $('.data-transaksi').append(data_transaksi);

            // total belanja
            if (response.total_belanja.total_amount_ != null) {
              $('.value-total-belanja').append(format_rupiah(response.total_belanja.total_amount_));              
            }

            $("#data_transaksi").DataTable({
              "responsive": true,
              "ordering": false
            });
          }
        })
      }
    })
  });
</script>
@endsection
