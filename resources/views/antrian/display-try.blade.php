<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Display Antrian - Innoventra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1e1e2f, #283046);
            color: #fff;
            overflow: hidden;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
        }

        header {
            text-align: center;
            padding: 1rem;
            font-size: 2rem;
            font-weight: 600;
            color: #00e0ff;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            position: relative;
        }

        #clock {
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 1rem;
            color: #ccc;
        }

        .content {
            flex: 1;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            align-items: center;
            padding: 2rem 3rem;
            gap: 3rem;
            position: relative;
        }

        /* PROMO (KIRI) */
        .promo {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            padding: 30px;
            text-align: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            animation: fadeInLeft 1s ease;
        }

        .promo h3 {
            color: #00e0ff;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .promo p {
            color: #ddd;
            font-size: 1.1rem;
        }

        .running-text {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            padding: 8px 0;
            color: #00e0ff;
            font-weight: 500;
            overflow: hidden;
            border-radius: 0 0 20px 20px;
        }

        .running-text span {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 18s linear infinite;
        }

        @keyframes marquee {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(-100%);
            }
        }

        /* LOKET (KANAN) */
        .loket-section {
            display: flex;
            flex-direction: column;
            gap: 25px;
            align-items: center;
            justify-content: center;
            animation: fadeInRight 1s ease;
        }

        .loket-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 20px 30px;
            width: 100%;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .loket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px #00e0ff;
        }

        .nomor {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
        }

        .loket {
            font-size: 1.2rem;
            color: #00e0ff;
            margin-bottom: 8px;
        }

        /* LOTTIE BACKGROUND */
        lottie-player.bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.25;
            z-index: -1;
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

        footer {
            text-align: center;
            padding: 8px;
            font-size: 0.9rem;
            color: #bbb;
            background: rgba(0, 0, 0, 0.6);
        }
    </style>
</head>

<body>
    <header>Display Antrian Innoventra
        <div>
            <button id="enableSound" style="
  position: fixed;
  bottom: 20px; right: 20px;
  background: #00e0ff;
  color: #000;
  font-weight: bold;
  border: none;
  border-radius: 10px;
  padding: 10px 20px;
  cursor: pointer;
  box-shadow: 0 0 15px rgba(0,224,255,0.8);
  z-index: 9999;
">🔊 Aktifkan Suara</button>
        </div>
    </header>

    <div class="content">
        <!-- ANIMASI LATAR -->
        <lottie-player class="bg" src="https://assets7.lottiefiles.com/packages/lf20_kkflmtur.json"
            background="transparent" speed="1" loop autoplay></lottie-player>

        <!-- PROMO KIRI -->
        <div class="promo">
            <h3>✨ Layanan Cepat & Modern</h3>
            <p>Selamat datang di sistem antrian digital <strong>Innoventra by Transforma</strong> — solusi efisiensi dan
                pelayanan terbaik untuk pelanggan Anda.</p>
            <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_t24tpvcu.json" background="transparent"
                speed="1" style="width:100%;height:280px;margin:auto;" loop autoplay></lottie-player>
            <div class="running-text">
                <span>🚀 Gunakan sistem antrian digital & nikmati pelayanan cepat! | 🎉 Terima kasih telah mempercayai
                    Innoventra!</span>
            </div>
        </div>

        <!-- LOKET KANAN -->
        <div class="loket-section">
            <div class="loket-card" id="loket1">
                <div class="loket">Loket 1</div>
                <div id="nomor1" class="nomor">A000</div>
            </div>
            <div class="loket-card" id="loket2">
                <div class="loket">Loket 2</div>
                <div id="nomor2" class="nomor">A000</div>
            </div>
            <div class="loket-card" id="loket3">
                <div class="loket">Loket 3</div>
                <div id="nomor3" class="nomor">A000</div>
            </div>
        </div>
    </div>

    <footer>© 2025 Innoventra by Transforma. All rights reserved.</footer>

    <audio id="tingtong" src="{{ asset('sound/tingtong.mp3') }}"></audio>
    <script>
        const enableBtn = document.getElementById('enableSound');
        const ting = document.getElementById('tingtong');

        enableBtn.addEventListener('click', async () => {
            try {
                await ting.play(); // Mainkan 1x pendek untuk izin audio
                ting.pause();
                ting.currentTime = 0;
                speechSynthesis.cancel();
                alert("✅ Suara berhasil diaktifkan!");
                enableBtn.remove(); // Hapus tombol setelah aktif
            } catch (err) {
                console.error("Gagal aktifkan suara:", err);
                alert("⚠️ Browser menolak memutar suara. Coba klik ulang tombol ini.");
            }
        });
    </script>
    <script>
        const clock = document.getElementById('clock');
        setInterval(() => {
            const now = new Date();
            clock.textContent = now.toLocaleString('id-ID', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }, 1000);

        let lastAntrian = { 1: null, 2: null, 3: null };

        async function fetchAntrian() {
            try {
                // 🔁 Ganti dengan endpoint API kamu
                const res = await fetch("{{route('data_antrian')}}"); // GANTI dengan endpoint kamu
                const data = await res.json();
                updateLoket(1, data.loket1);
                updateLoket(2, data.loket2);
                updateLoket(3, data.loket3);
            } catch (err) {
                console.error("Gagal ambil data:", err);
            }
        }

        async function updateLoket(loket, nomor) {
            const nomorEl = document.getElementById(`nomor${loket}`);
            if (nomor && nomor !== lastAntrian[loket]) {
                lastAntrian[loket] = nomor;
                nomorEl.textContent = nomor;

                const card = document.getElementById(`loket${loket}`);
                card.style.transform = 'scale(1.1)';
                setTimeout(() => card.style.transform = 'scale(1)', 600);

                const ting = document.getElementById('tingtong');
                await ting.play();

                setTimeout(() => {
                    const speech = new SpeechSynthesisUtterance(`Nomor antrian ${formatNomor(nomor)} silakan menuju loket ${loket}`);
                    speech.lang = 'id-ID';
                    speech.pitch = 1.05;
                    speech.rate = 0.95;
                    const voices = speechSynthesis.getVoices();
                    const femaleVoice = voices.find(v => v.lang === 'id-ID' && v.name.toLowerCase().includes('female'))
                        || voices.find(v => v.lang === 'id-ID');
                    if (femaleVoice) speech.voice = femaleVoice;
                    speechSynthesis.speak(speech);
                }, 1200);
            }
        }

        function formatNomor(nomor) {
            return nomor.replace(/([A-Z])/g, ' $1 ');
        }

        setInterval(fetchAntrian, 5000);
    </script>
</body>

</html>
