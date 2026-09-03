<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Foto - {{ $result->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #121212;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #1e1e1e;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        h2 {
            color: #ff4081;
            margin-bottom: 5px;
        }

        .merged-box {
            margin: 20px 0;
            padding: 15px;
            background: #2a2a2a;
            border-radius: 12px;
        }

        .merged-box img {
            width: 100%;
            max-width: 350px;
            border-radius: 8px;
            border: 2px solid #fff;
        }

        .singles-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .single-item {
            background: #2a2a2a;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
        }

        .single-item img {
            width: 100%;
            border-radius: 6px;
        }

        .btn {
            display: inline-block;
            background: #ff4081;
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            margin-top: 8px;
        }

        .btn-main {
            padding: 12px 24px;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Hasil Foto Photobooth</h2>
        <p style="color: #aaa;">Nama: <strong>{{ $result->name }}</strong> | Kode: <strong>{{ $result->code }}</strong></p>

        <!-- FOTO GABUNGAN (PHOTO STRIP) -->
        <div class="merged-box">
            <h3 style="margin-bottom: 10px; font-size: 1.1rem;">Foto Strip Gabungan</h3>
            <img src="{{ route('photobooth.image', ['code' => $result->code, 'type' => 'merged']) }}" alt="Foto Strip">
            <br><br>
            <a href="{{ route('photobooth.image', ['code' => $result->code, 'type' => 'merged']) }}" download="Photobooth_Strip_{{ $result->code }}.png" class="btn btn-main">Unduh Foto Strip</a>
        </div>

        <!-- FOTO SATUAN (POSE 1 - 4) -->
        <h3 style="margin-top: 30px; text-align: left; color: #ff4081;">Foto Satuan (Per Pose):</h3>
        <div class="singles-grid">
            @if($result->single_images && is_array($result->single_images))
            @foreach($result->single_images as $index => $single)
            <div class="single-item">
                <img src="{{ route('photobooth.image', ['code' => $result->code, 'type' => 'single', 'index' => $index]) }}" alt="Pose {{ $index + 1 }}">
                <a href="{{ route('photobooth.image', ['code' => $result->code, 'type' => 'single', 'index' => $index]) }}" download="Pose_{{ $index + 1 }}_{{ $result->code }}.png" class="btn">Unduh Pose {{ $index + 1 }}</a>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</body>

</html>
