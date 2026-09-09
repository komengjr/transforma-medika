<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian Pemanggilan | Ocean Breeze Queue</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
        }

        /* Mengunci layar penuh 100vh tanpa scrollbar utama */
        html,
        body {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0284c7 0%, #0d9488 50%, #0f766e 100%);
        }

        body {
            color: #0f172a;
            display: grid;
            grid-template-rows: auto 1fr auto;
            gap: 12px;
            padding: 12px;
        }

        /* Header Navigation Bar - Coastal Elegance */
        .header-bar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 10px 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .brand-title {
            font-size: 1.3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #0284c7, #0d9488);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
        }

        .clock-badge {
            background: linear-gradient(135deg, #e0f2fe, #ccfbf1);
            color: #0369a1;
            font-weight: 800;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 1rem;
            border: 1px solid #7dd3fc;
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.8);
        }

        /* Layout Grid Utama Presisi 1 Halaman */
        .main-grid {
            display: grid;
            grid-template-columns: 38% 1fr;
            gap: 12px;
            min-height: 0;
            height: 100%;
        }

        /* Frame Video / Iklan (Sisi Kiri) */
        .card-ad {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 2px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: grid;
            grid-template-rows: auto 1fr;
            height: 100%;
        }

        .ad-header {
            background: linear-gradient(135deg, #0891b2, #0d9488);
            color: #ffffff;
            padding: 10px 18px;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .ad-content-wrapper {
            position: relative;
            background: #000;
            width: 100%;
            height: 100%;
        }

        .ad-content-wrapper video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Kontainer Sisi Kanan (Panggilan + Grid Antrian) */
        .right-section {
            display: grid;
            grid-template-rows: 45% 1fr;
            gap: 12px;
            height: 100%;
            min-height: 0;
        }

        /* CARD PANGGILAN UTAMA - Sunset / Ocean Vibe */
        .card-main {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(240, 253, 250, 0.9));
            border-radius: 20px;
            border: 3px solid #38bdf8;
            box-shadow: 0 15px 35px rgba(2, 132, 199, 0.25);
            padding: 12px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .card-main::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .call-header-badge {
            background: linear-gradient(135deg, #fef08a, #fde047);
            color: #854d0e;
            font-weight: 800;
            padding: 4px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            box-shadow: 0 4px 10px rgba(234, 179, 8, 0.3);
        }

        .nomor-utama {
            font-size: 4.2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #0284c7 0%, #0f766e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin: 4px 0;
            letter-spacing: 2px;
        }

        .loket-utama {
            font-size: 1.4rem;
            font-weight: 800;
            color: #334155;
            line-height: 1.1;
            margin-bottom: 6px;
        }

        .counter-utama {
            font-size: 1.15rem;
            font-weight: 900;
            color: #ffffff;
            background: linear-gradient(135deg, #10b981, #059669);
            padding: 6px 24px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
        }

        /* GRID PANEL ANTRAIN BAWAH */
        .bottom-panels {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            min-height: 0;
            height: 100%;
        }

        .bg-side {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            padding: 10px 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            display: grid;
            grid-template-rows: auto 1fr;
            height: 100%;
            overflow: hidden;
        }

        .side-title {
            font-size: 0.88rem;
            font-weight: 800;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }

        /* AREA SCROLL KONSISTEN */
        .scroll-container {
            overflow-y: auto;
            padding-right: 4px;
            height: 100%;
        }

        .scroll-container::-webkit-scrollbar {
            width: 4px;
        }

        .scroll-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background: #38bdf8;
            border-radius: 10px;
        }

        /* GRID CARD KECIL */
        .grid-riwayat {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            gap: 8px;
        }

        /* CARD UNTUK BELUM DIPANGGIL (Pasir Pantai) */
        .card-antrian-menunggu {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1.5px solid #fde68a;
            border-radius: 10px;
            padding: 6px 4px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(217, 119, 6, 0.08);
        }

        .no-antrian-menunggu {
            font-size: 1.25rem;
            font-weight: 900;
            color: #d97706;
            line-height: 1;
        }

        /* CARD UNTUK SUDAH DIPANGGIL (Biru Laut) */
        .card-antrian-kecil {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1.5px solid #bae6fd;
            border-radius: 10px;
            padding: 6px 4px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(2, 132, 199, 0.08);
        }

        .no-antrian-kecil {
            font-size: 1.25rem;
            font-weight: 900;
            color: #0284c7;
            line-height: 1;
        }

        .nama-loket-kecil {
            font-size: 0.62rem;
            font-weight: 700;
            color: #475569;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 2px 0;
        }

        .badge-loket-kecil {
            background: #0284c7;
            color: #ffffff;
            font-size: 0.58rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .badge-waiting-kecil {
            background: #d97706;
            color: #ffffff;
            font-size: 0.58rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        /* Running Text Bar */
        .running-text-bar {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(10px);
            color: #ffffff;
            border-radius: 12px;
            padding: 6px 16px;
            font-size: 0.88rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <!-- Header Navigation Bar -->
    <div class="header-bar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-water-ladders fs-4 text-info me-3"></i>
            <div>
                <div class="brand-title">RSUD INNOVENTRA HEALTHCARE</div>
                <small class="text-secondary fw-semibold" style="font-size: 0.72rem;">Sistem Informasi Pelayanan Antrian Pasien Modern</small>
            </div>
        </div>
        <div class="clock-badge">
            <i class="fa-regular fa-clock me-2"></i><span id="liveClock">00:00:00 WIB</span>
        </div>
    </div>

    <!-- Main Grid Layout (Presisi Fit Screen) -->
    <div class="main-grid">

        <!-- FRAME IKLAN / VIDEO (SISI KIRI) -->
        <div class="card-ad">
            <div class="ad-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-umbrella-beach me-2"></i> Informasi Health Care</span>
                <span class="badge bg-light text-dark">LOCAL MP4</span>
            </div>
            <div class="ad-content-wrapper">
                <video autoplay loop muted playsinline id="videoIklan">
                    <source src="{{ asset('storage/display/antrian.mp4') }}" type="video/mp4">
                    Browser Anda tidak mendukung pemutar video.
                </video>
            </div>
        </div>

        <!-- SISI KANAN: CARD PANGGILAN & DAFTAR ANTRIAN -->
        <div class="right-section">

            <!-- CARD PANGGILAN UTAMA -->
            <div class="card-main">
                <div class="call-header-badge">
                    <i class="fa-solid fa-bullhorn me-1"></i> SEDANG DIPANGGIL
                </div>

                <div class="nomor-utama" id="displayNomor">---</div>
                <div class="loket-utama" id="displayLoket">Silakan Menunggu</div>

                <div>
                    <div class="counter-utama" id="displayCounter">
                        <i class="fa-solid fa-arrow-right-to-city me-2"></i>Menunggu...
                    </div>
                </div>
            </div>

            <!-- GRID PANEL DAFTAR ANTRIAN -->
            <div class="bottom-panels">

                <!-- PANEL 1: BELUM DIPANGGIL -->
                <div class="bg-side">
                    <div class="side-title d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-hourglass-half me-1 text-warning"></i>Belum Dipanggil</span>
                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1" id="totalMenunggu">0 Antrian</span>
                    </div>

                    <div class="scroll-container">
                        <div class="grid-riwayat" id="listMenunggu">
                            <!-- Data antrian menunggu diisi via JS -->
                        </div>
                    </div>
                </div>

                <!-- PANEL 2: SUDAH DIPANGGIL -->
                <div class="bg-side">
                    <div class="side-title d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-circle-check me-1 text-primary"></i>Sudah Dipanggil</span>
                        <span class="badge bg-primary rounded-pill px-2 py-1">Riwayat</span>
                    </div>

                    <div class="scroll-container">
                        <div class="grid-riwayat" id="listRiwayat">
                            <!-- Data riwayat panggilan diisi via JS -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- RUNNING TEXT BAWAH -->
    <div class="running-text-bar d-flex align-items-center">
        <span class="badge bg-danger fs-6 me-3 px-3 py-1 text-uppercase"><i class="fa-solid fa-bullhorn me-1"></i> Pengumuman</span>
        <marquee behavior="scroll" direction="left" scrollamount="5">
            Selamat Datang di RSUD Innoventra Healthcare. Jagalah kebersihan lingkungan rumah sakit. Harap menyiapkan kartu identitas dan BPJS/Asuransi sebelum menuju loket pendaftaran.
        </marquee>
    </div>

    <!-- JavaScript Logic -->
    <script>
        let lastCalledId = null;
        let lastCalledTime = null;

        // Jam Digital Real-Time
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('liveClock').textContent = timeString + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Autoplay Video
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('videoIklan');
            if (video) {
                video.play().catch(error => {
                    console.log('Autoplay ditahan oleh browser:', error);
                });
            }
        });

        // FUNGSI SUARA PEMANGGILAN DENGAN CHIME BANDARA & VOICE FEMALE NATURAL
        function panggilSuaraAntrian(nomorAntrian, nomorLoket) {
            const bellAudio = new Audio("{{ asset('storage/display/sound.mp3') }}");

            bellAudio.play().then(() => {
                bellAudio.onended = function() {
                    if ('speechSynthesis' in window) {
                        let ejaNomor = nomorAntrian.split('').join(' ');
                        let teksPanggilan = `Panggilan nomor antrian, ${ejaNomor}. Silakan menuju ke loket, ${nomorLoket}.`;

                        let utterance = new SpeechSynthesisUtterance(teksPanggilan);
                        utterance.lang = 'id-ID';
                        utterance.rate = 0.80;
                        utterance.pitch = 0.95;
                        utterance.volume = 1;

                        let voices = window.speechSynthesis.getVoices();
                        let selectedVoice = voices.find(voice =>
                            voice.lang.includes('id') && (
                                voice.name.includes('Google') ||
                                voice.name.includes('Female') ||
                                voice.name.includes('Natural') ||
                                voice.name.includes('Gadis')
                            )
                        );

                        if (!selectedVoice) {
                            selectedVoice = voices.find(voice => voice.lang.includes('id') || voice.lang.includes('IND'));
                        }

                        if (selectedVoice) {
                            utterance.voice = selectedVoice;
                        }

                        window.speechSynthesis.speak(utterance);
                    } else {
                        console.log('Browser tidak mendukung Web Speech API');
                    }
                };
            }).catch(e => {
                console.log('Autoplay audio ditahan browser. Klik area layar TV sekali.', e);
            });
        }

        if ('speechSynthesis' in window) {
            window.speechSynthesis.onvoiceschanged = function() {
                window.speechSynthesis.getVoices();
            };
        }

        // Fetch Data Antrian Real-Time
        async function fetchDisplayData() {
            try {
                const res = await fetch("{{ route('antrian.display.data') }}");
                const data = await res.json();

                // 1. Antrian Sedang Dipanggil Utama
                if (data.success && data.sedang_dipanggil) {
                    const item = data.sedang_dipanggil;
                    const nomorLoket = item.nomor_loket_pemanggil || 1;

                    document.getElementById('displayNomor').textContent = item.nomor_antrian;
                    document.getElementById('displayLoket').textContent = item.loket ? item.loket.nama_loket : 'Loket';
                    document.getElementById('displayCounter').innerHTML = `<i class="fa-solid fa-arrow-right-to-city me-2"></i>KE LOKET ${nomorLoket}`;

                    if (lastCalledId !== item.id || lastCalledTime !== item.waktu_panggil) {
                        lastCalledId = item.id;
                        lastCalledTime = item.waktu_panggil;
                        panggilSuaraAntrian(item.nomor_antrian, nomorLoket);
                    }
                } else {
                    document.getElementById('displayNomor').textContent = "---";
                    document.getElementById('displayLoket').textContent = "Silakan Menunggu";
                    document.getElementById('displayCounter').innerHTML = `<i class="fa-solid fa-arrow-right-to-city me-2"></i>Menunggu...`;

                    lastCalledId = null;
                    lastCalledTime = null;
                }

                // 2. Render Antrian BELUM DIPANGGIL (Menunggu)
                let htmlMenunggu = '';
                if (data.antrian_menunggu && data.antrian_menunggu.length > 0) {
                    document.getElementById('totalMenunggu').textContent = `${data.antrian_menunggu.length} Antrian`;
                    data.antrian_menunggu.forEach(row => {
                        const namaLoket = row.loket ? row.loket.nama_loket : 'Loket';
                        htmlMenunggu += `
                            <div class="card-antrian-menunggu">
                                <div class="no-antrian-menunggu">${row.nomor_antrian}</div>
                                <div class="nama-loket-kecil" title="${namaLoket}">${namaLoket}</div>
                                <span class="badge-waiting-kecil">Menunggu</span>
                            </div>
                        `;
                    });
                } else {
                    document.getElementById('totalMenunggu').textContent = `0 Antrian`;
                    htmlMenunggu = '<div class="text-muted text-center w-100 py-2 small">Tidak ada antrian</div>';
                }
                document.getElementById('listMenunggu').innerHTML = htmlMenunggu;

                // 3. Render Antrian SUDAH DIPANGGIL (Riwayat)
                let htmlRiwayat = '';
                if (data.riwayat_panggilan && data.riwayat_panggilan.length > 0) {
                    data.riwayat_panggilan.forEach(row => {
                        const namaLoket = row.loket ? row.loket.nama_loket : 'Loket';
                        htmlRiwayat += `
                            <div class="card-antrian-kecil">
                                <div class="no-antrian-kecil">${row.nomor_antrian}</div>
                                <div class="nama-loket-kecil" title="${namaLoket}">${namaLoket}</div>
                                <span class="badge-loket-kecil">Loket ${row.nomor_loket_pemanggil || 1}</span>
                            </div>
                        `;
                    });
                } else {
                    htmlRiwayat = '<div class="text-muted text-center w-100 py-2 small">Belum ada riwayat</div>';
                }
                document.getElementById('listRiwayat').innerHTML = htmlRiwayat;

            } catch (err) {
                console.error('Error fetching display:', err);
            }
        }

        setInterval(fetchDisplayData, 3000);
        fetchDisplayData();
    </script>
</body>

</html>
