<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barcode Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('public/themes/plugins/font-google/font-google.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('public/themes/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/themes/dist/css/adminlte.min.css') }}">
</head>
<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice m-3">
            <div class="row">
                @for ($i = 0; $i < 80; $i++)
                    <div class="col-2 m-3 text-center">
                        @php
                            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product->product_code, $generator::TYPE_CODE_128)) . '">';
                        @endphp
                        {{ $product->product_code }}
                    </div>
                @endfor
            </div>
        </section>
    </div>

    <script>
    window.addEventListener("load", window.print());
    </script>
</body>
</html>
