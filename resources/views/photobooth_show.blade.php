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
            /* Padding bawah ditambah agar konten tidak tertutup floating bar */
            padding-bottom: 100px;
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
            transition: background 0.2s;
        }

        .btn:hover {
            background: #e0356d;
        }

        .btn-main {
            padding: 12px 24px;
            font-size: 1rem;
        }

        /* Styling untuk Floating Bar Donasi / Saweria di Bawah */
        .donation-floating-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(30, 30, 30, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 20px;
            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            z-index: 999;
            box-sizing: border-box;
        }

        .donation-text {
            font-size: 0.9rem;
            color: #ddd;
            margin: 0;
            text-align: left;
        }

        .donation-text span {
            color: #ffc107;
            font-weight: bold;
        }

        .btn-saweria {
            background: #ffc107;
            color: #121212;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: bold;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
            transition: transform 0.2s, background 0.2s;
        }

        .btn-saweria:hover {
            background: #ffb300;
            transform: translateY(-2px);
        }

        /* Responsif untuk layar HP kecil */
        @media (max-width: 480px) {
            .donation-floating-bar {
                flex-direction: column;
                gap: 8px;
                padding: 10px;
                text-align: center;
            }

            .donation-text {
                font-size: 0.8rem;
                text-align: center;
            }

            body {
                padding-bottom: 120px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Hasil Foto Photobooth</h2>
        <p style="color: #aaa;">Nama: <strong>{{ $result->name }}</strong> | Kode: <strong>{{ $result->code }}</strong></p>

        <!-- FOTO GABUNGAN / GIF (PHOTO STRIP / ANIMATED) -->
        <div class="merged-box">
            <h3 style="margin-bottom: 10px; font-size: 1.1rem;">Hasil Foto Anda</h3>
            <img src="{{ route('photobooth.image', ['code' => $result->code, 'type' => 'merged']) }}" alt="Foto Photobooth">
            <br><br>
            <a href="{{ route('photobooth.image', ['code' => $result->code, 'type' => 'merged']) }}" download="Photobooth_{{ $result->code }}" class="btn btn-main">Unduh Hasil Foto</a>
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

    <!-- FLOATING BAR DONASI / SAWERIA DI BAGIAN BAWAH -->
    <div class="donation-floating-bar">
        <p class="donation-text">Suka dengan hasilnya? <span>Dukung kami</span> agar terus berkarya! ✨</p>
        <!-- Ganti link '#' di bawah dengan link Saweria atau Sociabuzz Anda -->
        <a href="https://saweria.co/agusraharjo" target="_blank" class="btn-saweria">
            ☕ Traktir / Sawer
        </a>
    </div>
</body>

</html>
