<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Warung Mitra</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body translate="no" >
    <div style="width: 200px;">
        <div class="info">
            <h2 style="text-align: center;">{{ $shop->name }}</h2>
            <p style="text-align: center;">
                {{ $shop->address }}</br>
            </p>
            Kode : {{ $invoice->code }}
        </div>

        <div id="bot">
            <div id="table">
                <table>
                    <tr>
                        <td><h4>Item</h4></td>
                        <td style="text-align: center;"><h4>Qty</h4></td>
                        <td style="text-align: center;"><h4>Total</h4></td>
                    </tr>

                    @foreach ($product_outs as $item)
                        <tr class="service">
                            <td style="font-size: 12px;">{{ $item->product->productMaster->name }} - {{ $item->product->product_name }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right;">{{ rupiah($item->sub_total + $item->promo_total) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td></td>
                        <td>Total</td>
                        <td style="font-weight: bold; font-size: 25px;">{{ rupiah($invoice->total_amount) }}</td>
                    </tr>
                </table>
                <hr>
                <table style="width: 100%;">
                    <tr>
                        <td>Bayar</td>
                        <td style="text-align: right;">
                            @if ($invoice->bayar)
                                {{ rupiah($invoice->bayar) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>Kembalian</td>
                        <td style="text-align: right;">
                            @if ($invoice->kembalian)
                                {{ rupiah($invoice->kembalian) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    <tr>
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
                        <tr>
                            <td>Poin Anda Sekarang</td>
                            <td style="text-align: right;">{{ $customer->poin }}</td>
                        </tr>
                    @endif
                </table>
            </div>

            <div>
                <p style="text-align: center; font-size: 12px;"><strong>Terimakasih Telah Berbelanja!</strong> Jangan lupa berkunjung kembali</p>
            </div>

        </div><!--End InvoiceBot-->
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
