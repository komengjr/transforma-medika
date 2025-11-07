<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ambil Tiket Antrian | Innoventra Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #15154bff, #283046);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            padding: 20px;
        }

        h2 {
            font-weight: 700;
            color: #00e0ff;
            text-align: center;
            margin-bottom: 40px;
        }

        .loket-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
        }

        .loket-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            width: 280px;
            padding: 25px;
            text-align: center;
            transition: all 0.4s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            animation: fadeInUp 0.8s ease;
        }

        .loket-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 15px 30px rgba(0, 224, 255, 0.3);
        }

        .loket-title {
            font-size: 1.4rem;
            color: #00e0ff;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .loket-desc {
            font-size: 0.95rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .btn-antrian {
            background: linear-gradient(135deg, #00e0ff, #00bcd4);
            color: #000;
            border: none;
            font-weight: bold;
            border-radius: 10px;
            padding: 10px 0;
            width: 100%;
            transition: 0.3s;
        }

        .btn-antrian:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px #00e0ff;
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Area cetak */
        .print-area {
            display: none;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_kkflmtur.json" background="transparent" speed="1"
        style="width: 250px; height: 250px;" loop autoplay></lottie-player>

    <h2>🎫 Ambil Tiket Antrian Anda</h2>

    <div class="loket-container">
        <div class="loket-card" onclick="ambilAntrian(1)">
            <div class="loket-title">Loket 1</div>
            <div class="loket-desc">Customer Service</div>
            <button class="btn-antrian">Ambil Antrian</button>
        </div>

        <div class="loket-card" onclick="ambilAntrian(2)">
            <div class="loket-title">Loket 2</div>
            <div class="loket-desc">Pembayaran</div>
            <button class="btn-antrian">Ambil Antrian</button>
        </div>

        <div class="loket-card" onclick="ambilAntrian(3)">
            <div class="loket-title">Loket 3</div>
            <div class="loket-desc">Informasi</div>
            <button class="btn-antrian">Ambil Antrian</button>
        </div>
    </div>

    <!-- Area untuk cetak struk -->
    <div class="print-area text-center p-4">
        <h2 style="color:#000;">INNOVENTRA QUEUE</h2>
        <hr>
        <h1 id="printNomor" style="font-size:4rem; color:#000;"></h1>
        <p id="printLoket" style="color:#000;"></p>
        <p style="font-size:0.9rem; color:#000;">
            Terima kasih telah menggunakan layanan kami.<br>
            Harap menunggu nomor Anda dipanggil di layar.
        </p>
        <hr>
        <p style="font-size:0.8rem; color:#000;" id="printWaktu"></p>
    </div>

    <script>
        // Simulasi penyimpanan nomor terakhir per loket
        let nomorTerakhir = { 1: 0, 2: 0, 3: 0 };

        function ambilAntrian(loket) {
            nomorTerakhir[loket]++;
            const nomorBaru = "A" + nomorTerakhir[loket].toString().padStart(3, "0");

            // Isi struk cetak
            document.getElementById("printNomor").textContent = nomorBaru;
            document.getElementById("printLoket").textContent = "Loket " + loket;
            document.getElementById("printWaktu").textContent = new Date().toLocaleString("id-ID");

            // Simpan ke localStorage untuk display antrian
            localStorage.setItem("loket" + loket, nomorBaru);

            // Auto print setelah jeda singkat
            setTimeout(() => window.print(), 500);
        }
    </script>
</body>

</html>
