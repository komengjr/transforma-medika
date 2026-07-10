<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Label Thermal</title>
    <style>
        /* Mengunci ukuran kertas printer thermal 76,20 mm x 50,80 mm */
        @page {
            size: 76.2mm 50.8mm;
            margin: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 4mm;
            width: 76.2mm;
            height: 50.8mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: #fff;
        }

        .toko {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .produk {
            font-size: 11px;
            margin-bottom: 3px;
            color: #222;
        }

        .harga {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Struktur garis Barcode menggunakan CSS murni */
        .barcode-container {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            height: 30px;
            margin-bottom: 2px;
        }

        .bar {
            width: 2px;
            height: 100%;
            background: black;
            margin-right: 1px;
        }

        .bar.thin {
            width: 1px;
        }

        .bar.thick {
            width: 4px;
        }

        .bar.space {
            background: transparent;
            width: 3px;
        }

        .barcode-text {
            font-size: 10px;
            letter-spacing: 2px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="toko">Toko Rezeki Lareh</div>
    <div class="produk">PRODUK: {{ $namaProduk }}</div>
    <div class="harga">HARGA: Rp. {{ $harga }}</div>

    <div class="barcode-container">
        <div class="bar thick"></div>
        <div class="bar"></div>
        <div class="bar space"></div>
        <div class="bar thin"></div>
        <div class="bar thick"></div>
        <div class="bar"></div>
        <div class="bar space"></div>
        <div class="bar thick"></div>
        <div class="bar thin"></div>
        <div class="bar"></div>
        <div class="bar thick"></div>
        <div class="bar space"></div>
        <div class="bar thin"></div>
        <div class="bar thick"></div>
        <div class="bar"></div>
    </div>
    <div class="barcode-text">{{ $barcode }}</div>

    <script>
        // Trigger cetak otomatis seketika halaman selesai dimuat dalam iframe
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
