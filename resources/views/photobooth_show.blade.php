<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Foto - {{ $result->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            background: #121212;
            color: #fff;
            text-align: center;
            padding: 30px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 12px;
        }

        img {
            width: 100%;
            border-radius: 8px;
            margin: 15px 0;
        }

        .btn {
            display: inline-block;
            background: #ff4081;
            color: #fff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Hasil Foto Photobooth</h2>
        <p><strong>Nama:</strong> {{ $result->name }}</p>
        <p style="font-size: 0.8rem; color: #888;">Kode Akses: {{ $result->code }}</p>

        <!-- Gambar diakses via route image berdasarkan 'code' -->
        <img src="{{ route('photobooth.image', $result->code) }}" alt="Hasil Foto">

        <br>
        <a href="{{ route('photobooth.image', $result->code) }}" download="photobooth_{{ $result->code }}.png" class="btn">Unduh Gambar</a>
    </div>
</body>

</html>
