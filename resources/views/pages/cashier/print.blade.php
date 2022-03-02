<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur</title>

    <!-- Styles -->
    <link href="{{ asset('lib/bootstrap-5/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        .invoice_code,
        .date,
        table tr td,
        .footer {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-4 border border-1">
                <h3 class="h3 text-center">Nama Toko</h3>
                <p class="text-center">Jl. Pahlawan Tanpa Tanda Jasa No 2 Timur Masjid Agung</p>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-6">
                        <span class="invoice_code">Kode Nota</span>
                        <span class="invoice_code">1234567890</span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-6 text-end">
                        <span class="date">10-10-2021</span>
                        <span class="invoice_code">10:00:00</span>
                    </div>
                </div>
                <hr style="border: 2px dashed #000;">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <table width="100%">
                            <tr>
                                <td>Sikat Gigi</td>
                                <td>3</td>
                                <td class="text-end">10.000</td>
                            </tr>
                            <tr>
                                <td>Biskuit Roma 2 liter</td>
                                <td>3</td>
                                <td class="text-end">10.000</td>
                            </tr>
                            <tr>
                                <td>Susu saya susu bendera enak dan lezat</td>
                                <td>3</td>
                                <td class="text-end">10.000</td>
                            </tr>
                            <tr>
                                <td class="text-end">Total</td>
                                <td>:</td>
                                <td class="text-end" style="border-top: 2px dashed #000;">1.110.000</td>
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


    <script src="{{ asset('lib/bootstrap-5/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/datatables/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('lib/fontawesome-5/js/fontawesome.min.js') }}"></script>

    <script>
        window.print();
        window.onafterprint = back;

        function back() {
            $('.footer').hide();
        }
    </script>
</body>
</html>
