<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Warung Mitra</title>
  <style>
        @media print {
            .page-break { display: block; page-break-before: always; }
        }
        #invoice-POS {
            padding: 2mm;
            margin: 0 auto;
            width: 80mm;
            background: #FFF;
        }
        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }
        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }
        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }
        #invoice-POS h2 {
            font-size: .9em;
        }
        #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }
        #invoice-POS p {
            font-size: .7em;
            color: #666;
            line-height: 1.2em;
        }
        #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }
        #invoice-POS #top {
            min-height: 100px;
        }
        #invoice-POS #mid {
            min-height: 80px;
        }
        #invoice-POS #bot {
            min-height: 50px;
        }
        #invoice-POS .info {
            display: block;
            margin-left: 0;
        }
        #invoice-POS .title {
            float: right;
        }
        #invoice-POS .title p {
            text-align: right;
        }
        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }
        #invoice-POS .tabletitle {
            font-size: 0.8em;
        }
        #invoice-POS .service {
            border-bottom: 1px solid #EEE;
        }
        #invoice-POS .item {
            width: 24mm;
        }
        #invoice-POS .itemtext {
            font-size: 0.8em;
        }
        #invoice-POS #legalcopy {
            margin-top: 5mm;
        }
    </style>
</head>
<body translate="no" >
    <div id="invoice-POS">

        <div id="mid">
            <div class="info">
                <h2 style="text-align: center;">{{ $shop->name }}</h2>
                <p>
                    Alamat : {{ $shop->address }}</br>
                    Kode : {{ $invoice->code }}
                </p>
            </div>
        </div><!--End Invoice Mid-->

        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item"><h2>Item</h2></td>
                        <td class="Hours" style="text-align: center;"><h2>Qty</h2></td>
                        <td class="Rate" style="text-align: right;"><h2>Sub Total</h2></td>
                    </tr>

                    @foreach ($product_outs as $item)
                        <tr class="service">
                            <td class="tableitem"><p>{{ $item->product->productMaster->name }} - {{ $item->product->product_name }}</p></td>
                            <td class="tableitem" style="text-align: center;"><p>{{ $item->quantity }}</p></td>
                            <td class="tableitem" style="text-align: right;"><p>{{ rupiah($item->sub_total + $item->promo_total) }}</p></td>
                        </tr>
                    @endforeach

                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate" style="text-align: right;"><h2>Total</h2></td>
                        <td class="payment" style="text-align: right;"><h2>{{ rupiah($invoice->total_amount) }}</h2></td>
                    </tr>
                </table>
                <hr>
                <table>
                    <tr class="tabletitle">
                        <td>Bayar</td>
                        <td style="text-align: right;">
                            @if ($invoice->bayar)
                                {{ rupiah($invoice->bayar) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td>Kembalian</td>
                        <td style="text-align: right;">
                            @if ($invoice->kembalian)
                                {{ rupiah($invoice->kembalian) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td>Poin Belanja</td>
                        <td style="text-align: right;">
                            @if ($invoice->poin)
                                {{ $invoice->poin }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    @if ($invoice->customer_id)
                        <tr class="tabletitle">
                            <td>Poin Anda Sekarang</td>
                            <td style="text-align: right;">{{ $customer->poin }}</td>
                        </tr>
                    @endif
                </table>
            </div>

            <div id="legalcopy">
                <p class="legal"><strong>Terimakasih Telah Berbelanja!</strong> Jangan lupa berkunjung kembali
                </p>
            </div>

        </div><!--End InvoiceBot-->
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
