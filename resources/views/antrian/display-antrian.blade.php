<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Display Antrian Modern - Innoventra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #1e1e2f, #283046);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-x: hidden;
        }

        header {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            text-align: center;
            font-size: 1.8rem;
            font-weight: 600;
            color: #00e0ff;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            z-index: 2;
        }

        .content-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            flex: 1;
            padding: 40px 60px;
            gap: 40px;
            position: relative;
        }

        .lottie-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.25;
            pointer-events: none;
        }

        /* Promo Kiri */
        .promo-section {
            flex: 1.2;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            z-index: 2;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeInLeft 1s ease;
            position: relative;
        }

        .promo-section h3 {
            color: #00e0ff;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .promo-section p {
            font-size: 1.1rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        /* Running Text */
        .running-text {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: #00e0ff;
            font-size: 1rem;
            font-weight: 500;
            padding: 8px 0;
            overflow: hidden;
            border-radius: 0 0 20px 20px;
        }

        .running-text span {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 15s linear infinite;
        }

        @keyframes marquee {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(-100%);
            }
        }

        /* Loket Kanan */
        .loket-section {
            flex: 0.8;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 25px;
            z-index: 2;
            animation: fadeInRight 1s ease;
        }

        .loket-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 20px 30px;
            width: 100%;
            text-align: center;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .loket-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            background: rgba(255, 255, 255, 0.15);
        }

        .loket-title {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 10px;
            color: #00e0ff;
        }

        .nomor-antrian {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .btn-call {
            background: linear-gradient(135deg, #00e0ff, #00bcd4);
            color: #000;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-call:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px #00e0ff;
        }

        footer {
            background: rgba(0, 0, 0, 0.7);
            text-align: center;
            padding: 10px 0;
            font-size: 0.9rem;
            position: static;
            bottom: 0;
            width: 100%;
            color: #bbb;
        }

        @keyframes fadeInLeft {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <header>Display Antrian Innoventra</header>

    <div class="content-wrapper">
        <lottie-player class="lottie-bg" src="https://assets7.lottiefiles.com/packages/lf20_kkflmtur.json"
            background="transparent" speed="1" loop autoplay>
        </lottie-player>

        <!-- PROMO (KIRI) -->
        <div class="promo-section">
            <h3>✨ Layanan Cepat & Efisien</h3>
            <p>Selamat datang di sistem antrian <strong>Innoventra by Transforma</strong> — solusi digital untuk
                meningkatkan efisiensi pelayanan publik & bisnis Anda.</p>
            <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_t24tpvcu.json" background="transparent"
                speed="1" style="width: 100%; height: 300px; margin: auto;" loop autoplay>
            </lottie-player>

            <div class="running-text">
                <span>🚀 Promo Spesial: Gunakan aplikasi Innoventra Queue dan nikmati layanan prioritas pelanggan! | 💡
                    Efisiensi pelayanan dimulai dari sistem antrian digital! | 🎉 Terima kasih telah mempercayai
                    Innoventra by Transforma!</span>
            </div>
        </div>

        <!-- LOKET (KANAN) -->
        <div class="loket-section">
            <div class="loket-card" id="loket1">
                <div class="loket-title">Loket 1</div>
                <div class="nomor-antrian" id="nomor1">A001</div>
                <button class="btn btn-call mt-2" onclick="panggil('A001', 1)">Panggil</button>
            </div>

            <div class="loket-card" id="loket2">
                <div class="loket-title">Loket 2</div>
                <div class="nomor-antrian" id="nomor2">A002</div>
                <button class="btn btn-call mt-2" onclick="panggil('A002', 2)">Panggil</button>
            </div>

            <div class="loket-card" id="loket3">
                <div class="loket-title">Loket 3</div>
                <div class="nomor-antrian" id="nomor3">A003</div>
                <button class="btn btn-call mt-2" onclick="panggil('A003', 3)">Panggil</button>
            </div>
        </div>
    </div>

    <footer>© 2025 Innoventra by Transforma. All rights reserved.</footer>

    <!-- Suara panggilan -->
    <audio id="suaraPanggilan" src="https://www.soundjay.com/button/sounds/button-09.mp3"></audio>
    <audio id="suaraNomorBaru" src="https://www.soundjay.com/phone/sounds/telephone-ring-03a.mp3"></audio>

    <script>
        function panggil(nomor, loket) {
            const suaraPanggilan = document.getElementById('suaraPanggilan');
            const suaraNomorBaru = document.getElementById('suaraNomorBaru');

            // Putar dua efek suara: notif + panggilan
            suaraNomorBaru.play();
            setTimeout(() => suaraPanggilan.play(), 1200);

            const el = document.getElementById(`loket${loket}`);
            el.style.transform = 'scale(1.1)';
            el.style.boxShadow = '0 0 30px #00e0ff';

            setTimeout(() => {
                el.style.transform = 'scale(1)';
                el.style.boxShadow = '0 5px 20px rgba(0,0,0,0.2)';
            }, 1000);

            alert(`Memanggil nomor ${nomor} ke Loket ${loket}`);
        }
    </script>
</body>

</html>
