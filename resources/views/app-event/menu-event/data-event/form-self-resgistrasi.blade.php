<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Event - {{ $event->event_data_tittle }}</title>
    <!-- Font Jakarta Sans & Bootstrap 5 -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --accent-glow: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --bg-dark: #0f172a;
            --bg-glass: rgba(255, 255, 255, 0.88);
        }

        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--bg-dark);
            overflow-x: hidden;
        }

        .full-page-container {
            min-height: 100vh;
            display: flex;
        }

        /* ================= SISI KIRI: HERO & SUB EVENT ================= */
        .image-side {
            /* Latar belakang diperjelas tanpa overlay gradien/opacity gelap */
            background-image: url('{{ $event->event_data_cover ? asset("storage/".$event->event_data_template) : "https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80" }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 50%;
            position: relative;
            padding: 3.5rem;
            color: #ffffff;
        }

        .event-badge {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-title {
            font-size: 2.85rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1px;
            color: #ffffff;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.8);
        }

        /* GRID CARD SUB EVENT (POSISI BOTTOM) */
        .sub-event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.75rem;
            margin-top: 0.75rem;
            max-height: 200px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .sub-event-grid::-webkit-scrollbar {
            width: 4px;
        }

        .sub-event-grid::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 4px;
        }

        .sub-event-card-item {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .sub-event-card-item:hover {
            background: rgba(15, 23, 42, 0.85);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .sub-event-badge-time {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.5) 0%, rgba(139, 92, 246, 0.5) 100%);
            color: #ffffff;
            border: 1px solid rgba(147, 197, 253, 0.4);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            width: fit-content;
        }

        .sub-event-title-text {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.3;
            margin-top: 0.6rem;
            margin-bottom: 0.4rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .feature-list {
            display: flex;
            gap: 1.25rem;
        }

        .feature-item {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            flex: 1;
        }

        /* ================= SISI KANAN: KIOSK & BOUNCING ORBS ================= */
        .form-side {
            width: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            overflow: hidden;
            position: relative;
        }

        /* Bouncing Orbs Animation */
        .bounce-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(50px);
            z-index: 1;
            opacity: 0.6;
            animation: bounceMotion 8s infinite alternate ease-in-out;
        }

        .orb-1 {
            width: 280px;
            height: 280px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            top: 10%;
            left: 10%;
            animation-duration: 7s;
        }

        .orb-2 {
            width: 320px;
            height: 320px;
            background: linear-gradient(135deg, #a855f7, #ec4899);
            bottom: 10%;
            right: 10%;
            animation-duration: 9s;
            animation-delay: -3s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #10b981, #06b6d4);
            bottom: 30%;
            left: 20%;
            animation-duration: 6s;
            animation-delay: -1.5s;
        }

        @keyframes bounceMotion {
            0% {
                transform: translateY(0px) scale(1) rotate(0deg);
            }

            50% {
                transform: translateY(-40px) scale(1.1) rotate(10deg);
            }

            100% {
                transform: translateY(30px) scale(0.95) rotate(-10deg);
            }
        }

        .kiosk-card {
            width: 100%;
            max-width: 620px;
            background: var(--bg-glass);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.6) inset;
            padding: 3rem;
            position: relative;
            z-index: 2;
        }

        .scan-input-wrapper {
            position: relative;
            border-radius: 16px;
            padding: 6px;
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .scan-input-wrapper:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }

        .form-control-kiosk {
            border: none !important;
            box-shadow: none !important;
            font-size: 1.1rem;
            padding: 0.85rem 1.25rem;
            font-weight: 600;
            color: #1e293b;
            background: transparent;
        }

        .btn-scan-trigger {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.85rem 1.75rem;
            transition: all 0.2s ease;
        }

        .btn-scan-trigger:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .scan-loading-box {
            display: none;
            background: #ffffff;
            border-radius: 18px;
            padding: 2.5rem;
            text-align: center;
            margin-top: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .scanner-line {
            width: 100%;
            height: 4px;
            background: var(--accent-glow);
            border-radius: 4px;
            animation: scanAnimation 1.5s infinite ease-in-out;
            margin-bottom: 1.5rem;
        }

        @keyframes scanAnimation {
            0% {
                transform: scaleX(0.1);
                opacity: 0.3;
            }

            50% {
                transform: scaleX(1);
                opacity: 1;
            }

            100% {
                transform: scaleX(0.1);
                opacity: 0.3;
            }
        }

        .result-box {
            display: none;
            margin-top: 1.5rem;
            animation: fadeInUp 0.4s ease-out;
        }

        .id-badge-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .id-badge-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .badge-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--accent-glow);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .btn-print-custom {
            background: var(--success-gradient);
            border: none;
            color: white;
            font-weight: 700;
            padding: 1rem 1.5rem;
            border-radius: 14px;
            font-size: 1.05rem;
            transition: all 0.25s ease;
        }

        .btn-print-custom:hover {
            transform: translateY(-2px);
            color: white;
        }

        .print-toast {
            display: none;
            background: #10b981;
            color: white;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 992px) {
            .full-page-container {
                flex-direction: column;
            }

            .image-side {
                width: 100%;
                min-height: auto;
                padding: 2rem;
            }

            .form-side {
                width: 100%;
                padding: 1.5rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .kiosk-card {
                padding: 1.75rem;
            }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

    <div class="full-page-container">
        <!-- Sisi Kiri: Hero Banner & Agenda Sub Event di Posisi Bawah -->
        <div class="image-side d-flex flex-column justify-content-between">

            <!-- Top Header Badge -->
            <div>
                <span class="event-badge text-uppercase">
                    <i class="bi bi-shield-check text-warning"></i> Official Event
                </span>
            </div>

            <!-- Content & Agenda Sub Event Card di Posisi Bawah -->
            <div class="mt-auto pt-4 pb-2">

                <h1 class="hero-title mb-2">{{ $event->event_data_tittle }}</h1>
                <p class="lead text-white mb-3" style="font-size: 0.95rem; max-width: 480px; text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
                    {{ Str::limit(strip_tags($event->event_data_desc ?? 'Platform pendaftaran & presensi event otomatis.'), 100) }}
                </p>

                <!-- Header Title Sub Event -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="event-badge text-uppercase">
                            <i class="bi bi-grid-fill text-warning"></i>
                            <span class="fw-bold text-white text-uppercase fs-7" style="letter-spacing: 0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
                                Agenda Sub Event
                            </span>
                        </span>
                    </div>
                    @if(count($sub_events) > 0)
                    <span class="badge bg-dark bg-opacity-50 text-white border border-white border-opacity-25 rounded-pill px-2.5 py-1 fs-8">
                        {{ count($sub_events) }} Sesi
                    </span>
                    @endif
                </div>

                <!-- Grid Card Sub Event -->
                <div class="sub-event-grid py-2">
                    @forelse($sub_events as $sub)
                    <div class="sub-event-card-item">
                        <div>
                            <span class="sub-event-badge-time">
                                <i class="bi bi-clock-fill"></i>
                                {{ \Carbon\Carbon::parse($sub->event_data_sub_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($sub->event_data_sub_end)->format('H:i') }}
                            </span>

                            <h6 class="sub-event-title-text" title="{{ $sub->event_data_sub_name }}">
                                {{ $sub->event_data_sub_name }}
                            </h6>
                        </div>

                        <div class="pt-2 border-top border-white border-opacity-20 mt-2 d-flex align-items-center justify-content-between">
                            <small class="text-white fs-8" style="text-shadow: 0 1px 2px rgba(0,0,0,0.8);">
                                <i class="bi bi-calendar3 me-1 text-info"></i>
                                {{ \Carbon\Carbon::parse($sub->event_data_sub_start)->translatedFormat('d M Y') }}
                            </small>
                            <i class="bi bi-arrow-right-short text-white"></i>
                        </div>
                    </div>
                    @empty
                    <div class="w-100">
                        <div class="p-3 text-center rounded-4 border border-danger border-opacity-50"
                            style="background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(10px);">
                            <i class="bi bi-calendar-x-fill text-danger fs-3 d-block mb-1"></i>
                            <strong class="d-block text-white fs-6">Sub Event Tidak Ada</strong>
                            <small class="text-white-50 fs-8">Belum ada agenda atau jadwal sub event yang ditambahkan.</small>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Bottom Info Footer -->
            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-white border-opacity-25 mt-2">
                <span class="event-badge text-uppercase">
                    <small class="text-white fw-semibold" style="text-shadow: 0 1px 3px rgba(0,0,0,0.9);">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $event->event_data_venue }}, {{ $event->event_data_city }}
                    </small>
                </span>
                <span class="event-badge text-uppercase">
                    <small class="text-white fw-semibold" style="text-shadow: 0 1px 3px rgba(0,0,0,0.9);">
                        <i class="bi bi-calendar-event-fill text-info me-1"></i> {{ \Carbon\Carbon::parse($event->event_data_start_date)->format('d M Y, H:i') }} WIB
                    </small>
                </span>
            </div>
        </div>

        <!-- Sisi Kanan: Self Register Kiosk -->
        <div class="form-side">
            <!-- Animated Bouncing Orbs -->
            <div class="bounce-orb orb-1"></div>
            <div class="bounce-orb orb-2"></div>
            <div class="bounce-orb orb-3"></div>

            <div class="kiosk-card">

                <div id="printToast" class="print-toast">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i> Perintah Cetak Berhasil! Memuat Ulang Kiosk...
                </div>

                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 68px; height: 68px;">
                        <i class="bi bi-qr-code-scan fs-2"></i>
                    </div>
                    <h2 class="fw-bold text-dark m-0">Self Check-In</h2>
                    <p class="text-muted small mt-1 mb-0">Tempelkan QR Code / Ketik ID Card pada form di bawah lalu tekan <kbd class="bg-light text-dark border">Enter</kbd></p>
                </div>

                <!-- Alert Error -->
                <div id="errorAlert" class="alert alert-danger d-none align-items-center rounded-3 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <span id="errorMessage">Kode QR tidak ditemukan!</span>
                </div>

                <!-- Form Input Scanner -->
                <form id="scanForm" onsubmit="event.preventDefault(); startScanProcess();">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary fs-6 mb-2">Kode Tiket / ID Card</label>
                        <div class="scan-input-wrapper d-flex align-items-center">
                            <i class="bi bi-search text-muted fs-5 ms-3"></i>
                            <input type="text" id="idInput" class="form-control form-control-kiosk" placeholder="Scan Barcode / Ketik ID di sini..." required autocomplete="off" autofocus>
                            <button class="btn btn-scan-trigger ms-2" type="submit">
                                Scan <i class="bi bi-arrow-right-short ms-1"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Loading State -->
                <div class="scan-loading-box" id="loadingContainer">
                    <div class="scanner-line"></div>
                    <div class="spinner-border text-primary mb-2" style="width: 2.2rem; height: 2.2rem;" role="status"></div>
                    <h6 class="fw-bold text-dark mb-1">Membaca Data Peserta...</h6>
                    <small class="text-muted">Menghubungkan ke sistem verifikasi tiket</small>
                </div>

                <!-- Result Box -->
                <div class="result-box" id="resultContainer">
                    <div class="id-badge-card mb-4">
                        <div class="id-badge-header">
                            <span class="badge bg-success border border-light-subtle rounded-pill px-3 py-2 fs--2 fw-bold">
                                <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi
                            </span>
                            <small class="text-white-50"><i class="bi bi-clock me-1"></i> <span id="resTime">--:-- WIB</span></small>
                        </div>

                        <div class="p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="badge-avatar" id="avatarLetter">R</div>
                                <div>
                                    <small class="text-muted text-uppercase fw-bold fs--2" id="resInstansi">Instansi</small>
                                    <h4 class="fw-bold text-dark mb-0" id="resName">--</h4>
                                </div>
                            </div>

                            <!-- Detail Event, Sub Event, dan Kelas -->
                            <div class="row g-2 bg-light p-3 rounded-3 border">
                                <div class="col-12 mb-2 pb-2 border-bottom">
                                    <small class="text-muted d-block fs--2">Nama Event</small>
                                    <span class="fw-bold text-dark" id="resEventName">--</span>
                                </div>
                                <div class="col-12 mb-2 pb-2 border-bottom">
                                    <small class="text-muted d-block fs--2">Sub Event</small>
                                    <span class="fw-bold text-dark" id="resSubEventName">--</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block fs--2">Kategori / Kelas</small>
                                    <span class="fw-bold text-primary" id="resStatus">--</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block fs--2">Status Cetak</small>
                                    <span class="fw-bold text-success"><i class="bi bi-printer me-1"></i> Ready to Print</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-print-custom w-100 d-flex align-items-center justify-content-center gap-2 mb-3" id="btnPrint" onclick="processBackgroundPrint()">
                        <i class="bi bi-printer-fill fs-5"></i> <span id="printBtnText">Cetak Badge Registrasi</span>
                    </button>

                    <button class="btn btn-light w-100 border text-secondary fw-semibold py-2" id="btnReset" onclick="resetScan()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Scan Ulang / Batal
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const idInput = document.getElementById('idInput');
        const btnPrint = document.getElementById('btnPrint');
        const printBtnText = document.getElementById('printBtnText');
        const printToast = document.getElementById('printToast');
        const resultBox = document.getElementById('resultContainer');
        const loadingBox = document.getElementById('loadingContainer');
        const errorAlert = document.getElementById('errorAlert');

        let currentParticipantData = null;

        window.onload = () => {
            if (idInput) idInput.focus();
        };

        if (idInput) {
            idInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    startScanProcess();
                }
            });
        }

        function startScanProcess() {
            const token = idInput.value.trim();
            if (!token) return;

            errorAlert.classList.add('d-none');
            resultBox.style.display = 'none';
            loadingBox.style.display = 'block';

            $.ajax({
                url: "{{ route('menu_event_data_form_registrasi_event_cek_booking') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "token": token,
                    "code": "{{ $kode }}",
                },
                dataType: "json"
            }).done(function(response) {
                loadingBox.style.display = 'none';

                if (response.status === 'success') {
                    currentParticipantData = response.data;

                    // Mapping Data Peserta & Event ke HTML
                    document.getElementById('resName').innerText = currentParticipantData.full_name || '-';
                    document.getElementById('resInstansi').innerText = currentParticipantData.institution || '-';
                    document.getElementById('resEventName').innerText = currentParticipantData.event_name || '-';
                    document.getElementById('resSubEventName').innerText = currentParticipantData.sub_event_name || '-';
                    document.getElementById('resStatus').innerText = currentParticipantData.event_data_sub_class_name || currentParticipantData.class_name || '-';
                    document.getElementById('avatarLetter').innerText = (currentParticipantData.full_name || 'P').charAt(0).toUpperCase();

                    const now = new Date();
                    document.getElementById('resTime').innerText = now.toLocaleTimeString('id-ID') + ' WIB';

                    resultBox.style.display = 'block';
                }
            }).fail(function(xhr) {
                loadingBox.style.display = 'none';
                let msg = 'Kode QR / Token tidak valid atau tidak ditemukan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                document.getElementById('errorMessage').innerText = msg;
                errorAlert.classList.remove('d-none');

                idInput.select();
            });
        }

        function processBackgroundPrint() {
            if (!currentParticipantData) return;

            btnPrint.disabled = true;
            if (printBtnText) printBtnText.innerText = "Memproses Cetak...";
            btnPrint.innerHTML = `<div class="spinner-border spinner-border-sm text-light" role="status"></div> Mengirim Data ke Printer...`;

            // STEP 1: Ambil kode ZPL dari Server Cloud Laravel
            $.ajax({
                url: "{{ route('menu_event_data_form_registrasi_event_test_print') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "nama_peserta": currentParticipantData.full_name,
                    "nama_event": currentParticipantData.event_name,
                    "id_event": currentParticipantData.id_event,
                    "kode_booking": currentParticipantData.qr_code_token,
                    "registration_code": currentParticipantData.registration_code,
                    "class_name": currentParticipantData.class_name
                },
                dataType: 'json',
            }).done(function(response) {
                if (response.status && response.zpl) {

                    // STEP 2: Tembakkan ZPL ke Print Agent Lokal di PC Kasir
                    $.ajax({
                        url: "http://localhost:8080/print", // URL Agent lokal PC kasir
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            zpl: response.zpl,
                            printer_name: "Zebra_USB" // Sesuai nama share printer lokal Anda
                        }),
                        dataType: 'json'
                    }).done(function(localResponse) {

                        if (localResponse.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Dicetak!',
                                text: localResponse.message || 'Badge registrasi telah berhasil dikirim ke printer.',
                                timer: 2000,
                                showConfirmButton: false,
                                timerProgressBar: true
                            }).then(() => {
                                resetScan();
                            });

                            if (printToast) printToast.style.display = 'block';
                            setTimeout(() => {
                                if (printToast) printToast.style.display = 'none';
                            }, 1500);

                        } else {
                            showPrintErrorAlert(localResponse.message || 'Agent lokal gagal mencetak ke printer.');
                        }

                    }).fail(function() {
                        showPrintErrorAlert('Gagal terhubung ke Print Agent Lokal! Pastikan agent.php sudah berjalan di PC ini.');
                    });

                } else {
                    showPrintErrorAlert(response.message || 'Terjadi kesalahan saat memproses printer.');
                }

            }).fail(function(xhr) {
                let errorMessage = 'Gagal menyambungkan ke server cloud!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showPrintErrorAlert(errorMessage);
            });
        }

        // Helper function untuk menampilkan alert error SweetAlert
        function showPrintErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mencetak!',
                text: message,
                confirmButtonText: 'Coba Lagi',
                confirmButtonColor: '#d33'
            }).then(() => {
                resetScan();
            });

            if (printToast) printToast.style.display = 'none';
            btnPrint.disabled = false;
            if (printBtnText) printBtnText.innerText = "Cetak Badge";
        }

        function resetScan() {
            if (idInput) idInput.value = "";
            currentParticipantData = null;

            if (resultBox) resultBox.style.display = 'none';
            if (loadingBox) loadingBox.style.display = 'none';
            if (errorAlert) errorAlert.classList.add('d-none');

            if (btnPrint) {
                btnPrint.disabled = false;
                btnPrint.innerHTML = `<i class="bi bi-printer-fill fs-5"></i> Cetak Badge Registrasi`;
            }

            if (idInput) idInput.focus();
        }
    </script>
</body>

</html>
