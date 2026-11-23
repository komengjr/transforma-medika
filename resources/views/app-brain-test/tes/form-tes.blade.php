<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Online - {{ $paket->nama_test }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ent-indigo: #4f46e5;
            --ent-indigo-dark: #3730a3;
            --ent-grid-border: rgba(99, 102, 241, 0.25);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
            user-select: none;
            -webkit-user-select: none;
        }

        .font-mono-code {
            font-family: 'JetBrains Mono', monospace;
        }

        .navbar-exam {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
            color: #ffffff;
            box-shadow: 0 8px 24px -6px rgba(15, 23, 42, 0.25);
            border-bottom: 1px solid rgba(129, 140, 248, 0.25);
        }

        .ent-card {
            background: #ffffff;
            border: 1px solid var(--ent-grid-border);
            border-radius: 16px;
            box-shadow: 0 8px 24px -8px rgba(15, 23, 42, 0.08);
        }

        .form-control {
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.86rem;
            min-height: 42px;
        }

        .form-control:focus {
            border-color: var(--ent-indigo);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14);
        }

        .timer-pill {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(8px);
        }

        .kat-pill {
            border: 1px solid var(--ent-grid-border);
            border-radius: 9999px;
            padding: 5px 14px;
            font-size: 0.78rem;
            font-weight: 700;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .kat-pill:hover {
            border-color: var(--ent-indigo);
            color: var(--ent-indigo);
        }

        .kat-pill.active {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
        }

        .btn-nav-panel {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: #ffffff;
            border: 1px solid rgba(99, 102, 241, 0.35);
            border-radius: 12px;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 6px 16px -6px rgba(15, 23, 42, 0.35);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-nav-panel:hover,
        .btn-nav-panel.is-open {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            box-shadow: 0 10px 22px -6px rgba(79, 70, 229, 0.45);
        }

        .mobile-nav-drawer {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 320px;
            max-width: calc(100vw - 1.5rem);
            z-index: 1050;
            background: #ffffff;
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 18px;
            box-shadow: 0 22px 48px -12px rgba(15, 23, 42, 0.28);
            padding: 16px;
            opacity: 0;
            transform: translateY(-8px) scale(0.98);
            pointer-events: none;
            transition: opacity 0.2s cubic-bezier(0.22, 1, 0.36, 1), transform 0.2s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .mobile-nav-drawer.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .nav-box {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.18s ease;
            border: 1.5px solid #cbd5e1;
            background-color: #ffffff;
            color: #334155;
        }

        .nav-box:hover {
            transform: translateY(-2px);
            border-color: var(--ent-indigo);
        }

        .nav-box.answered {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        .nav-box.doubtful {
            background-color: #fef3c7;
            border-color: #f59e0b;
            color: #92400e;
        }

        .nav-box.active {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.22);
        }

        .option-label {
            cursor: pointer;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.18s ease;
            background-color: #ffffff;
        }

        .option-label:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
        }

        .option-input:checked+.option-label {
            background-color: #eef2ff;
            border-color: var(--ent-indigo);
            color: #312e81;
            font-weight: 600;
        }

        .option-img {
            max-height: 180px;
            object-fit: contain;
        }

        .exam-locked .option-label,
        .exam-locked #clearAnswerBtn,
        .exam-locked #doubtCheck {
            pointer-events: none;
            opacity: 0.65;
            cursor: not-allowed;
        }

        .wrong-detail-card {
            background: #fff8f8;
            border: 1px solid #fecaca;
            border-left: 4px solid #dc2626;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 12px;
        }

        .wrong-explanation-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 0.84rem;
            line-height: 1.55;
            color: #1e293b;
        }

        /* Ukuran gambar responsif - Mode Desktop (>= 992px) */
        .exam-question-img {
            max-height: 280px;
            max-width: 100%;
            object-fit: contain;
        }

        .option-img {
            max-height: 170px;
            max-width: 100%;
            object-fit: contain;
        }

        .wrong-img-thumb {
            max-height: 120px;
            max-width: 220px;
            object-fit: contain;
            border-radius: 8px;
            border: 1px solid #fecaca;
            background-color: #ffffff;
        }

        .wrong-img-thumb-correct {
            border-color: #bbf7d0;
        }

        /* Ukuran gambar responsif - Mode Mobile (< 992px) */
        @media (max-width: 991.98px) {
            .exam-question-img {
                max-height: 185px;
            }

            .option-img {
                max-height: 115px;
            }

            .wrong-img-thumb {
                max-height: 90px;
                max-width: 150px;
            }
        }

        /* Tombol navigasi soal melayang transparan di bawah pada mode mobile (< 992px) */
        @media (max-width: 991.98px) {
            body.exam-active-mobile {
                padding-bottom: 84px;
            }

            .question-action-bar {
                position: fixed;
                bottom: 14px;
                left: 14px;
                right: 14px;
                z-index: 1040;
                background: transparent !important;
                backdrop-filter: none !important;
                border: none !important;
                border-top: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin-top: 0 !important;
                pointer-events: none;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
            }

            .question-action-bar .btn-label-text {
                display: none;
            }

            .question-action-bar .btn {
                pointer-events: auto;
                width: 48px;
                height: 48px;
                padding: 0 !important;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 14px !important;
                box-shadow: 0 8px 20px rgba(15, 23, 42, 0.22);
            }

            .question-action-bar .btn i {
                margin: 0 !important;
                font-size: 1.05rem;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-exam py-3 px-3 px-md-4">
        <div class="container-fluid d-flex justify-content-between align-items-start align-items-sm-center gap-2">
            <!-- KIRI: Badge SESI TES (hanya desktop/sm+) + Nama Tes & Klasifikasi -->
            <div class="d-flex align-items-center gap-3 min-w-0">
                <span class="d-none d-sm-inline-flex align-items-center badge bg-white text-dark px-3 py-2 rounded-3 fw-bold shadow-sm shrink-0">
                    <i class="fa-solid fa-clipboard-question me-1 text-primary"></i> SESI TES
                </span>
                <div class="min-w-0">
                    <h5 class="mb-0 fw-bold text-truncate" style="letter-spacing: -0.01em;">{{ $paket->nama_test }}</h5>
                    <small class="text-white-50 d-block text-truncate">
                        Klasifikasi: <strong class="text-white">{{ $paket->klasifikasi->nama_klasifikasi ?? '-' }}</strong>
                    </small>
                </div>
            </div>

            <!-- KANAN: Waktu Berjalan & Email/Identitas Peserta -->
            <div class="d-flex flex-column align-items-end gap-2 shrink-0">
                <div class="timer-pill px-3 py-2 rounded-pill d-flex align-items-center gap-2 text-white fw-bold">
                    <i class="fa-regular fa-clock text-warning"></i>
                    <span id="countdown" class="font-mono-code small fs-sm-6">--:--:--</span>
                </div>
                <span id="pesertaBadge" class="badge bg-info text-dark text-truncate" style="display: none; max-width: 190px;"></span>
            </div>
        </div>
    </nav>

    <div class="container-fluid my-4 px-3 px-md-5 flex-grow-1">

        <!-- STEP 1: FORM IDENTITAS RESPONDEN (EMAIL / NO HP SEBAGAI UNIQUE ID) -->
        <div class="row justify-content-center" id="identitySection">
            <div class="col-lg-7 col-xl-6">
                <div class="ent-card p-4 p-md-5">
                    <div class="mb-4">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 mb-2 fw-bold">
                            Langkah 1 &bull; Identitas Peserta
                        </span>
                        <h4 class="fw-bold mb-1">Formulir Mengikuti Tes</h4>
                        <p class="text-secondary small mb-0">
                            Isi data diri dan keterangan mengikuti tes. <strong>Email atau No. HP</strong> digunakan sebagai ID unik untuk mengakses dan melanjutkan sesi tes pada paket <strong>{{ $paket->nama_test }}</strong>.
                        </p>
                    </div>

                    <form id="formIdentitasTes" action="{{ route('brain-test.tes.mulai', $paket->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_responden" id="inputNamaResponden" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email <span class="text-primary">(ID Unik)</span></label>
                                <input type="email" name="email" id="inputEmailResponden" class="form-control" placeholder="nama@email.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">No. HP / WhatsApp <span class="text-primary">(ID Unik)</span></label>
                                <input type="text" name="no_hp" id="inputNoHpResponden" class="form-control font-mono-code" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="form-text text-secondary mb-3" style="font-size: 0.76rem;">
                            <i class="fa-solid fa-circle-info me-1 text-primary"></i> Isi minimal salah satu antara <strong>Email</strong> atau <strong>No. HP</strong> (boleh keduanya).
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Keterangan Mengikuti Tes</label>
                            <textarea name="keterangan" id="inputKeteranganTes" class="form-control" rows="2" placeholder="Contoh: Seleksi tahap 1 / Asal instansi / Tujuan latihan..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="btnMulaiTes" class="btn btn-primary py-3 fw-bold rounded-3 shadow-sm">
                                <i class="fa-solid fa-play me-2"></i> Lanjut &amp; Mulai Tes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- STEP 2: TAMPILAN UJIAN -->
        <div id="examWrapper" style="display: none;">
            <!-- Filter Kategori pada Paket -->
            <div class="ent-card p-3 mb-3 position-relative" style="overflow: visible; z-index: 30;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-2" id="kategoriFilterGroup">
                        <span class="small fw-bold text-secondary me-1">
                            <i class="fa-solid fa-filter me-1 text-primary"></i> Kategori:
                        </span>
                        <button type="button" class="kat-pill active" data-kategori-id="" onclick="switchKategori(this, '')">
                            Semua Kategori
                        </button>
                        @foreach($paket->kategoris as $kat)
                        <button type="button" class="kat-pill" data-kategori-id="{{ $kat->id }}" onclick="switchKategori(this, {{ $kat->id }})">
                            {{ $kat->nama_kategori }}
                        </button>
                        @endforeach
                    </div>

                    <!-- Durasi (Desktop tetap seperti semula) -->
                    <div class="d-none d-lg-block small text-secondary font-mono-code">
                        Durasi: {{ $paket->durasi_menit }} Menit
                    </div>

                    <!-- Durasi di Sebelah Kategori + Button Panel Nomor Soal (Khusus Mode Mobile < lg) -->
                    <div class="d-flex d-lg-none align-items-center justify-content-between w-100 pt-2 mt-1 border-top position-relative" id="mobileNavPanelWrapper">
                        <div class="small text-secondary font-mono-code">
                            Durasi: <strong>{{ $paket->durasi_menit }} Menit</strong>
                        </div>

                        <button type="button" id="btnToggleNavPanelMobile" class="btn-nav-panel" onclick="toggleMobileNavPanel(event)">
                            <i class="fa-solid fa-grip"></i>
                            <span>No. Soal</span>
                            <span class="badge bg-white text-dark font-mono-code rounded-pill" id="navPanelCounterMobile">0/0</span>
                            <i class="fa-solid fa-chevron-down" id="navPanelChevronMobile" style="font-size: 0.68rem; transition: transform 0.2s ease;"></i>
                        </button>

                        <!-- Floating Navigation Pop-Over Panel Mobile -->
                        <div id="mobileNavDrawer" class="mobile-nav-drawer">
                            <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                                <span class="fw-bold small d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-list-check text-primary"></i>
                                    Navigasi Nomor Soal
                                </span>
                                <button type="button" class="btn-close" style="font-size: 0.7rem;" onclick="closeMobileNavPanel()"></button>
                            </div>

                            <div class="row g-2 mb-3 text-secondary" style="font-size: 0.72rem;">
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <div style="width: 13px; height: 13px; background: #10b981; border-radius: 4px;"></div> Dijawab
                                </div>
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <div style="width: 13px; height: 13px; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 4px;"></div> Belum
                                </div>
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <div style="width: 13px; height: 13px; background: #f59e0b; border-radius: 4px;"></div> Ragu-ragu
                                </div>
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <div style="width: 13px; height: 13px; background: #4f46e5; border-radius: 4px;"></div> Aktif
                                </div>
                            </div>

                            <div id="nav-grid-mobile" class="d-flex flex-wrap gap-2 overflow-auto align-content-start mb-3" style="max-height: 220px;"></div>

                            <div class="pt-2 border-top">
                                <button type="button" class="btn btn-danger w-100 py-2 fw-bold rounded-3 shadow-sm" style="font-size: 0.8rem;" onclick="closeMobileNavPanel()" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                    <i class="fa-solid fa-paper-plane me-2"></i> Selesai &amp; Kirim Ujian
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4" id="examContainer">
                <!-- Kolom Soal Utama -->
                <div class="col-lg-8">
                    <div class="ent-card p-4 h-100 d-flex flex-column justify-content-between" id="questionCard">
                        <div>
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-3 mb-3 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary px-3 py-2 font-mono-code" id="question-number-badge">Soal No. 1</span>
                                    <span class="badge bg-light text-primary border px-3 py-2" id="question-kategori-badge">-</span>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="doubtCheck" onchange="toggleDoubt()">
                                    <label class="form-check-label fw-semibold text-warning" for="doubtCheck">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Ragu-ragu
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 lh-base" id="question-text" style="display: none;"></h5>
                                <div id="question-image-wrapper" class="mb-3" style="display: none;">
                                    <img id="question-image" src="" alt="Gambar Soal" class="img-fluid rounded-3 border exam-question-img">
                                </div>
                                <div id="options-container" class="d-flex flex-column gap-3"></div>
                            </div>
                        </div>

                        <div class="question-action-bar d-flex justify-content-between align-items-center gap-2 pt-3 border-top mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 fw-semibold rounded-3" id="prevBtn" title="Sebelumnya" onclick="prevQuestion()">
                                <i class="fa-solid fa-arrow-left me-2"></i><span class="btn-label-text">Sebelumnya</span>
                            </button>

                            <button type="button" class="btn btn-warning text-dark px-3 fw-semibold rounded-3" id="clearAnswerBtn" title="Kosongkan" onclick="clearAnswer()">
                                <i class="fa-solid fa-eraser me-1"></i><span class="btn-label-text">Kosongkan</span>
                            </button>

                            <button type="button" class="btn btn-primary px-4 fw-semibold rounded-3" id="nextBtn" title="Selanjutnya" onclick="nextQuestion()">
                                <span class="btn-label-text">Selanjutnya </span><i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kolom Panel Navigasi Nomor Soal (Mode Desktop) -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="ent-card p-4 h-100 d-flex flex-column">
                        <h6 class="fw-bold mb-3">
                            <i class="fa-solid fa-list-check me-2 text-primary"></i>Navigasi Nomor Soal
                        </h6>

                        <div class="row g-2 mb-3 text-secondary small">
                            <div class="col-6 d-flex align-items-center gap-2">
                                <div style="width: 15px; height: 15px; background: #10b981; border-radius: 4px;"></div> Dijawab
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <div style="width: 15px; height: 15px; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 4px;"></div> Belum
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2 mt-1">
                                <div style="width: 15px; height: 15px; background: #f59e0b; border-radius: 4px;"></div> Ragu-ragu
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2 mt-1">
                                <div style="width: 15px; height: 15px; background: #4f46e5; border-radius: 4px;"></div> Aktif
                            </div>
                        </div>
                        <hr class="my-2">

                        <div id="nav-grid" class="d-flex flex-wrap gap-2 overflow-auto align-content-start my-2" style="max-height: 320px;"></div>

                        <div class="mt-auto pt-3 border-top">
                            <button type="button" class="btn btn-danger w-100 py-3 fw-bold rounded-3 shadow-sm" id="btnOpenConfirmModal" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                <i class="fa-solid fa-paper-plane me-2"></i> Selesai &amp; Kirim Ujian
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Konfirmasi Selesai -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title fw-bold mb-0">
                        <i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>Konfirmasi Selesai Ujian
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="fw-semibold mb-3">Apakah Anda yakin ingin mengakhiri dan mengirim jawaban ujian ini?</p>
                    <div class="bg-light p-3 rounded-3 text-start mb-2 border">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Total Soal:</span> <span class="fw-bold font-mono-code" id="summary-total">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 text-success">
                            <span>Sudah Dijawab:</span> <span class="fw-bold font-mono-code" id="summary-answered">0</span>
                        </div>
                        <div class="d-flex justify-content-between text-warning">
                            <span>Ragu-ragu:</span> <span class="fw-bold font-mono-code" id="summary-doubt">0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-success px-4 fw-bold rounded-3" onclick="submitExam()">Ya, Kirim Ujian</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let allQuestions = [];
        let questions = [];
        let currentIdx = 0;
        let tokenSesi = null;
        let countdownInterval = null;
        let mobileNavPanelOpen = false;
        let isSubmittingExam = false;
        let isTimeExpired = false;
        const defaultDurasiDetik = `{{(int)($paket->durasi_menit ?? 60)}}` * 60;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        const SESI_CACHE_KEY = `brain_test_sesi_cache_{{ $paket->id }}`;
        const URL_MULAI_TES = "{{ route('brain-test.tes.mulai', $paket->id) }}";
        const URL_RESUME_TES_BASE = "{{ url('tes/' . $paket->id . '/sesi') }}";
        const URL_JAWAB_TEMPLATE = "{{ route('brain-test.tes.jawab', ['tokenSesi' => '__TOKEN__']) }}";
        const URL_SELESAI_TEMPLATE = "{{ route('brain-test.tes.selesai', ['tokenSesi' => '__TOKEN__']) }}";

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function resolveStorageUrl(path) {
            if (!path) return '';
            if (String(path).startsWith('http://') || String(path).startsWith('https://')) {
                return path;
            }
            const cleanPath = String(path).replace(/^\/+/, '');
            return `{{ asset('storage') }}/${cleanPath}`;
        }

        function lockExamInputs() {
            isTimeExpired = true;
            const qCard = document.getElementById('questionCard');
            if (qCard) qCard.classList.add('exam-locked');

            const doubtCheck = document.getElementById('doubtCheck');
            if (doubtCheck) doubtCheck.disabled = true;

            const clearBtn = document.getElementById('clearAnswerBtn');
            if (clearBtn) clearBtn.disabled = true;

            document.querySelectorAll('#options-container input[type="radio"]').forEach(radio => {
                radio.disabled = true;
            });
        }

        function unlockExamInputs() {
            isTimeExpired = false;
            const qCard = document.getElementById('questionCard');
            if (qCard) qCard.classList.remove('exam-locked');

            const doubtCheck = document.getElementById('doubtCheck');
            if (doubtCheck) doubtCheck.disabled = false;

            const clearBtn = document.getElementById('clearAnswerBtn');
            if (clearBtn) clearBtn.disabled = false;
        }

        function simpanCacheSesi(payload) {
            try {
                if (!tokenSesi) return;
                const progress = {};
                allQuestions.forEach(q => {
                    progress[q.id] = {
                        answer: q.answer,
                        doubt: q.doubt
                    };
                });

                const existingRaw = localStorage.getItem(SESI_CACHE_KEY);
                const existing = existingRaw ? JSON.parse(existingRaw) : {};

                const dataToSave = {
                    token_sesi: tokenSesi,
                    nama_responden: payload?.sesi?.nama_responden || existing.nama_responden || '',
                    unique_id: payload?.unique_id || existing.unique_id || '',
                    sisa_detik: typeof payload?.sisa_detik === 'number' ? payload.sisa_detik : (existing.sisa_detik || defaultDurasiDetik),
                    saved_at: Date.now(),
                    soals: (Array.isArray(payload?.soals) && payload.soals.length > 0) ? payload.soals : (existing.soals || []),
                    progress: progress
                };

                localStorage.setItem(SESI_CACHE_KEY, JSON.stringify(dataToSave));
            } catch (err) {
                console.warn('Gagal menyimpan cache sesi ke localStorage:', err);
            }
        }

        function updateCacheProgressSaja(sisaDetik = null) {
            try {
                const raw = localStorage.getItem(SESI_CACHE_KEY);
                if (!raw || !tokenSesi) return;
                const cached = JSON.parse(raw);
                if (cached.token_sesi !== tokenSesi) return;

                const progress = {};
                allQuestions.forEach(q => {
                    progress[q.id] = {
                        answer: q.answer,
                        doubt: q.doubt
                    };
                });

                cached.progress = progress;
                cached.saved_at = Date.now();
                if (typeof sisaDetik === 'number' && sisaDetik >= 0) {
                    cached.sisa_detik = sisaDetik;
                }
                localStorage.setItem(SESI_CACHE_KEY, JSON.stringify(cached));
            } catch (err) {
                console.warn('Gagal memperbarui progress cache:', err);
            }
        }

        function hapusCacheSesi() {
            try {
                localStorage.removeItem(SESI_CACHE_KEY);
            } catch (err) {
                console.warn('Gagal menghapus cache sesi:', err);
            }
        }

        function aktifkanSesiUjian(data, localProgress = null) {
            const soalsData = data.soals || [];
            if (soalsData.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Soal Belum Tersedia',
                    text: 'Belum ada soal pada paket tes ini.'
                });
                return;
            }

            isSubmittingExam = false;
            unlockExamInputs();
            tokenSesi = data.sesi.token_sesi;
            const jawabanMap = data.jawaban_map || {};

            allQuestions = soalsData.map(item => {
                const opsiList = item.opsi_jawabans || item.opsiJawabans || [];
                const optionIds = opsiList.map(opt => opt.id);

                let answerIdx = null;
                let isDoubt = false;

                if (jawabanMap && Object.prototype.hasOwnProperty.call(jawabanMap, item.id)) {
                    const saved = jawabanMap[item.id];
                    if (saved && saved.opsi_jawaban_id) {
                        const foundIdx = optionIds.findIndex(id => Number(id) === Number(saved.opsi_jawaban_id));
                        if (foundIdx !== -1) answerIdx = foundIdx;
                    }
                    isDoubt = Boolean(saved?.is_ragu);
                } else if (localProgress && Object.prototype.hasOwnProperty.call(localProgress, item.id)) {
                    const lp = localProgress[item.id];
                    answerIdx = typeof lp.answer === 'number' ? lp.answer : null;
                    isDoubt = Boolean(lp.doubt);
                }

                return {
                    id: item.id,
                    kategoriId: item.kategori_id,
                    kategoriNama: item.kategori?.nama_kategori || '{{ $paket->nama_test }}',
                    question: item.pertanyaan || '',
                    image: item.gambar || null,
                    options: opsiList.map(opt => ({
                        id: opt.id,
                        teks: opt.teks_jawaban || '',
                        gambar: opt.gambar || null
                    })),
                    optionIds: optionIds,
                    answer: answerIdx,
                    doubt: isDoubt
                };
            });

            const badge = document.getElementById('pesertaBadge');
            if (badge) {
                const namaPeserta = data.sesi?.nama_responden || '';
                const uidPeserta = data.unique_id || '';
                badge.textContent = uidPeserta ? `${namaPeserta} (${uidPeserta})` : namaPeserta;
                badge.style.display = badge.textContent ? 'inline-block' : 'none';
            }

            document.getElementById('identitySection').style.display = 'none';
            document.getElementById('examWrapper').style.display = 'block';
            document.body.classList.add('exam-active-mobile');

            document.querySelectorAll('#kategoriFilterGroup .kat-pill').forEach((pill, i) => {
                pill.classList.toggle('active', i === 0);
            });

            questions = [...allQuestions];
            renderNavGrid();
            loadQuestion(0);
            updateSummaryModal();
            simpanCacheSesi(data);
            startCountdown(data.sisa_detik || defaultDurasiDetik);
        }

        function cekDanLanjutkanDariCache() {
            let cached = null;
            try {
                const raw = localStorage.getItem(SESI_CACHE_KEY);
                if (raw) cached = JSON.parse(raw);
            } catch (e) {
                cached = null;
            }

            if (!cached || !cached.token_sesi) return;

            const elapsedSeconds = cached.saved_at ? Math.floor((Date.now() - cached.saved_at) / 1000) : 0;
            const estimatedSisa = Math.max(0, (cached.sisa_detik || defaultDurasiDetik) - elapsedSeconds);
            const checkedToken = cached.token_sesi;

            fetch(`${URL_RESUME_TES_BASE}/${encodeURIComponent(checkedToken)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json().then(body => ({
                    status: response.status,
                    body
                })))
                .then(res => {
                    if (tokenSesi && tokenSesi !== checkedToken) return;

                    if (res.status === 200 && res.body && res.body.status === 'success') {
                        aktifkanSesiUjian(res.body, cached.progress || null);
                    } else if (
                        res.body?.status === 'reset' ||
                        res.status === 409 ||
                        res.body?.status === 'completed'
                    ) {
                        hapusCacheSesi();
                        kembaliKeFormDataDiri();
                    } else if (res.status === 410 || res.body?.status === 'expired') {
                        tokenSesi = checkedToken;
                        handleWaktuHabis();
                    } else if (Array.isArray(cached.soals) && cached.soals.length > 0 && estimatedSisa > 0) {
                        aktifkanSesiUjian({
                            sesi: {
                                token_sesi: cached.token_sesi,
                                nama_responden: cached.nama_responden || ''
                            },
                            unique_id: cached.unique_id || '',
                            sisa_detik: estimatedSisa,
                            soals: cached.soals
                        }, cached.progress || null);
                    }
                })
                .catch(() => {
                    if (tokenSesi) return;
                    if (Array.isArray(cached.soals) && cached.soals.length > 0 && estimatedSisa > 0) {
                        aktifkanSesiUjian({
                            sesi: {
                                token_sesi: cached.token_sesi,
                                nama_responden: cached.nama_responden || ''
                            },
                            unique_id: cached.unique_id || '',
                            sisa_detik: estimatedSisa,
                            soals: cached.soals
                        }, cached.progress || null);
                    }
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            initSecurityFeatures();
            cekDanLanjutkanDariCache();

            document.addEventListener('click', function(e) {
                const wrapper = document.getElementById('mobileNavPanelWrapper');
                if (mobileNavPanelOpen && wrapper && !wrapper.contains(e.target)) {
                    closeMobileNavPanel();
                }
            });

            document.getElementById('formIdentitasTes').addEventListener('submit', function(e) {
                e.preventDefault();

                const nama = document.getElementById('inputNamaResponden').value.trim();
                const email = document.getElementById('inputEmailResponden').value.trim();
                const noHp = document.getElementById('inputNoHpResponden').value.trim();
                const keterangan = document.getElementById('inputKeteranganTes').value.trim();

                if (!nama) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Nama Wajib Diisi',
                        text: 'Silakan isi nama lengkap Anda terlebih dahulu.'
                    });
                    return;
                }

                if (!email && !noHp) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ID Unik Wajib Diisi',
                        text: 'Silakan isi Email atau No. HP sebagai ID unik untuk mengikuti tes.'
                    });
                    return;
                }

                const btn = document.getElementById('btnMulaiTes');
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> Memeriksa Data...`;

                fetch(URL_MULAI_TES, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            nama_responden: nama,
                            email: email,
                            no_hp: noHp,
                            keterangan: keterangan
                        })
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        body: data
                    })))
                    .then(res => {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;

                        if (res.body && (res.body.already_taken || res.body.status === 'already_taken' || res.status === 409)) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Sudah Melakukan Tes Sebelumnya',
                                html: `
                                    <div class="text-start" style="font-size: 0.9rem;">
                                        <p class="mb-2">${escapeHtml(res.body.message || 'Data tersebut sudah melakukan tes sebelumnya.')}</p>
                                        ${res.body.responden_nama ? `<div class="small text-secondary">Terdaftar atas nama: <strong>${escapeHtml(res.body.responden_nama)}</strong></div>` : ''}
                                    </div>
                                `,
                                confirmButtonText: 'Mengerti',
                                confirmButtonColor: '#4f46e5'
                            });
                            return;
                        }

                        if (res.status !== 200 || res.body.status !== 'success') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tidak Dapat Memulai',
                                text: res.body.message || 'Gagal memulai sesi tes.'
                            });
                            return;
                        }

                        aktifkanSesiUjian(res.body);
                        requestFullScreen();
                    })
                    .catch(err => {
                        console.error(err);
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Jaringan',
                            text: 'Gagal menghubungi server.'
                        });
                    });
            });
        });

        function toggleMobileNavPanel(e) {
            if (e) e.stopPropagation();
            mobileNavPanelOpen = !mobileNavPanelOpen;
            const drawer = document.getElementById('mobileNavDrawer');
            const btn = document.getElementById('btnToggleNavPanelMobile');
            const chevron = document.getElementById('navPanelChevronMobile');
            if (drawer) drawer.classList.toggle('show', mobileNavPanelOpen);
            if (btn) btn.classList.toggle('is-open', mobileNavPanelOpen);
            if (chevron) chevron.style.transform = mobileNavPanelOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        }

        function closeMobileNavPanel() {
            mobileNavPanelOpen = false;
            const drawer = document.getElementById('mobileNavDrawer');
            const btn = document.getElementById('btnToggleNavPanelMobile');
            const chevron = document.getElementById('navPanelChevronMobile');
            if (drawer) drawer.classList.remove('show');
            if (btn) btn.classList.remove('is-open');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }

        function kembaliKeFormDataDiri() {
            closeMobileNavPanel();
            hapusCacheSesi();
            unlockExamInputs();
            document.body.classList.remove('exam-active-mobile');

            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }

            if (document.fullscreenElement && document.exitFullscreen) {
                document.exitFullscreen().catch(() => {});
            }

            tokenSesi = null;
            allQuestions = [];
            questions = [];
            currentIdx = 0;
            isSubmittingExam = false;

            document.getElementById('countdown').textContent = '--:--:--';
            const badge = document.getElementById('pesertaBadge');
            if (badge) {
                badge.textContent = '';
                badge.style.display = 'none';
            }

            document.getElementById('formIdentitasTes').reset();
            document.getElementById('examWrapper').style.display = 'none';
            document.getElementById('identitySection').style.display = 'flex';
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function switchKategori(el, kategoriId) {
            document.querySelectorAll('#kategoriFilterGroup .kat-pill').forEach(btn => btn.classList.remove('active'));
            el.classList.add('active');

            questions = kategoriId === '' ? [...allQuestions] :
                allQuestions.filter(q => Number(q.kategoriId) === Number(kategoriId));

            currentIdx = 0;
            renderNavGrid();
            if (questions.length > 0) {
                loadQuestion(0);
            } else {
                document.getElementById('question-number-badge').innerText = '0 Soal';
                document.getElementById('question-kategori-badge').innerText = '-';
                const qTextEl = document.getElementById('question-text');
                qTextEl.style.display = 'block';
                qTextEl.innerText = 'Tidak ada soal pada kategori ini.';
                document.getElementById('question-image-wrapper').style.display = 'none';
                document.getElementById('options-container').innerHTML = '';
            }
            updateSummaryModal();
        }

        function requestFullScreen() {
            const elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(() => {});
            }
        }

        function renderNavGrid() {
            const containers = [
                document.getElementById('nav-grid'),
                document.getElementById('nav-grid-mobile')
            ].filter(Boolean);

            const answeredCount = questions.filter(q => q.answer !== null).length;
            const counterMobile = document.getElementById('navPanelCounterMobile');
            if (counterMobile) {
                counterMobile.textContent = `${answeredCount}/${questions.length}`;
            }

            containers.forEach(grid => {
                grid.innerHTML = '';
                questions.forEach((q, index) => {
                    const box = document.createElement('div');
                    box.className = `nav-box font-mono-code ${index === currentIdx ? 'active' : ''}`;
                    if (q.doubt) {
                        box.classList.add('doubtful');
                    } else if (q.answer !== null) {
                        box.classList.add('answered');
                    }
                    box.innerText = index + 1;
                    box.onclick = () => {
                        currentIdx = index;
                        loadQuestion(currentIdx);
                        closeMobileNavPanel();
                    };
                    grid.appendChild(box);
                });
            });
        }

        function loadQuestion(idx) {
            if (!questions[idx]) return;
            currentIdx = idx;
            const q = questions[idx];

            document.getElementById('question-number-badge').innerText = `Soal No. ${idx + 1} / ${questions.length}`;
            document.getElementById('question-kategori-badge').innerText = q.kategoriNama;

            const qTextEl = document.getElementById('question-text');
            if (q.question && String(q.question).trim() !== '') {
                qTextEl.innerText = q.question;
                qTextEl.style.display = 'block';
            } else {
                qTextEl.innerText = '';
                qTextEl.style.display = 'none';
            }

            const imgWrapper = document.getElementById('question-image-wrapper');
            const imgEl = document.getElementById('question-image');
            if (q.image) {
                imgEl.src = resolveStorageUrl(q.image);
                imgWrapper.style.display = 'block';
            } else {
                imgWrapper.style.display = 'none';
                imgEl.src = '';
            }

            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';

            q.options.forEach((opt, oIdx) => {
                const isChecked = q.answer === oIdx ? 'checked' : '';
                const disabledAttr = isTimeExpired ? 'disabled' : '';
                const optionId = `opt_${oIdx}`;
                const optTeks = typeof opt === 'object' ? (opt.teks || '') : (opt || '');
                const optGambar = typeof opt === 'object' ? (opt.gambar || null) : null;

                const teksHtml = optTeks.trim() !== '' ?
                    `<div class="fs-6">${escapeHtml(optTeks)}</div>` :
                    '';

                const gambarHtml = optGambar ?
                    `<div class="${optTeks.trim() !== '' ? 'mt-2' : ''}"><img src="${escapeHtml(resolveStorageUrl(optGambar))}" alt="Opsi ${String.fromCharCode(65 + oIdx)}" class="img-fluid rounded-3 border option-img"></div>` :
                    '';

                const html = `
                    <div class="form-check p-0 m-0">
                        <input class="form-check-input option-input d-none" type="radio" name="examOption" id="${optionId}" value="${oIdx}" ${isChecked} ${disabledAttr} onchange="selectAnswer(${oIdx})">
                        <label class="option-label p-3 d-flex align-items-start w-100" for="${optionId}">
                            <span class="badge bg-secondary rounded-circle me-3 mt-1 d-flex align-items-center justify-content-center font-mono-code shrink-0" style="width: 28px; height: 28px;">${String.fromCharCode(65 + oIdx)}</span>
                            <div class="flex-grow-1 min-w-0">
                                ${teksHtml}
                                ${gambarHtml}
                            </div>
                        </label>
                    </div>
                `;
                optionsContainer.insertAdjacentHTML('beforeend', html);
            });

            if (isTimeExpired) {
                lockExamInputs();
            }

            document.getElementById('prevBtn').disabled = idx === 0;
            document.getElementById('nextBtn').innerHTML = idx === questions.length - 1 ?
                '<span class="btn-label-text">Selesai / Cek </span><i class="fa-solid fa-check ms-2"></i>' :
                '<span class="btn-label-text">Selanjutnya </span><i class="fa-solid fa-arrow-right ms-2"></i>';

            renderNavGrid();
            updateSummaryModal();
        }

        function syncAnswerToServer(q) {
            if (!tokenSesi || !q || isTimeExpired) return;
            updateCacheProgressSaja();
            const selectedOpsiId = q.answer !== null ? (q.optionIds[q.answer] || null) : null;
            const urlJawab = URL_JAWAB_TEMPLATE.replace('__TOKEN__', encodeURIComponent(tokenSesi));

            fetch(urlJawab, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    soal_id: q.id,
                    opsi_jawaban_id: selectedOpsiId,
                    is_ragu: q.doubt
                })
            }).catch(err => console.error('Gagal menyimpan jawaban:', err));
        }

        function selectAnswer(optIdx) {
            if (isTimeExpired) return;
            const q = questions[currentIdx];
            if (!q) return;
            q.answer = optIdx;
            syncAnswerToServer(q);
            renderNavGrid();
            updateSummaryModal();
            loadQuestion(currentIdx);
        }

        function clearAnswer() {
            if (isTimeExpired) return;
            const q = questions[currentIdx];
            if (!q) return;
            q.answer = null;
            q.doubt = false;
            syncAnswerToServer(q);
            renderNavGrid();
            updateSummaryModal();
            loadQuestion(currentIdx);
        }

        function toggleDoubt() {
            if (isTimeExpired) {
                const doubtCheck = document.getElementById('doubtCheck');
                if (doubtCheck && questions[currentIdx]) {
                    doubtCheck.checked = questions[currentIdx].doubt;
                }
                return;
            }
            const q = questions[currentIdx];
            if (!q) return;
            q.doubt = document.getElementById('doubtCheck').checked;
            syncAnswerToServer(q);
            renderNavGrid();
            updateSummaryModal();
        }

        function prevQuestion() {
            if (currentIdx > 0) {
                currentIdx--;
                loadQuestion(currentIdx);
            }
        }

        function nextQuestion() {
            if (currentIdx < questions.length - 1) {
                currentIdx++;
                loadQuestion(currentIdx);
            } else {
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
            }
        }

        function updateSummaryModal() {
            document.getElementById('summary-total').innerText = allQuestions.length;
            document.getElementById('summary-answered').innerText = allQuestions.filter(q => q.answer !== null).length;
            document.getElementById('summary-doubt').innerText = allQuestions.filter(q => q.doubt).length;
        }

        function handleWaktuHabis() {
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
            document.getElementById('countdown').textContent = '00:00:00';
            lockExamInputs();
            closeMobileNavPanel();

            const modalEl = document.getElementById('confirmModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            }

            Swal.fire({
                icon: 'warning',
                title: 'Waktu Habis!',
                html: 'Waktu pengerjaan tes telah berakhir. Jawaban Anda dikunci dan tes akan segera diselesaikan otomatis.',
                confirmButtonText: 'Lihat Hasil & Pembahasan',
                confirmButtonColor: '#4f46e5',
                allowOutsideClick: false
            }).then(() => {
                submitExam(true);
            });
        }

        function startCountdown(duration) {
            let timer = Math.max(0, Number(duration) || 0);
            const display = document.getElementById('countdown');

            if (countdownInterval) clearInterval(countdownInterval);

            if (timer <= 0) {
                handleWaktuHabis();
                return;
            }

            const renderTime = (sec) => {
                const hours = String(Math.floor(sec / 3600)).padStart(2, '0');
                const minutes = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
                const seconds = String(sec % 60).padStart(2, '0');
                display.textContent = `${hours}:${minutes}:${seconds}`;
            };

            renderTime(timer);

            countdownInterval = setInterval(function() {
                timer--;
                if (timer < 0) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                    handleWaktuHabis();
                    return;
                }

                renderTime(timer);

                if (timer > 0 && timer % 5 === 0) {
                    updateCacheProgressSaja(timer);
                }
            }, 1000);
        }

        function findMatchingQuestionForWrongItem(item) {
            if (!Array.isArray(allQuestions) || allQuestions.length === 0 || !item) return null;

            if (item.soal_id !== undefined && item.soal_id !== null) {
                const byId = allQuestions.find(q => Number(q.id) === Number(item.soal_id));
                if (byId) return byId;
            }

            const nomor = Number(item.nomor);
            if (!Number.isNaN(nomor) && nomor >= 1 && nomor <= allQuestions.length) {
                return allQuestions[nomor - 1];
            }

            return null;
        }

        function findCorrectOptionFromQuestion(matchedQ, item) {
            if (!matchedQ || !Array.isArray(matchedQ.options)) return null;

            if (item && (item.opsi_jawaban_benar_id !== undefined || item.kunci_opsi_id !== undefined)) {
                const targetId = Number(item.opsi_jawaban_benar_id ?? item.kunci_opsi_id);
                const idxById = matchedQ.options.findIndex(opt => Number(opt.id) === targetId);
                if (idxById !== -1) {
                    return {
                        huruf: String.fromCharCode(65 + idxById),
                        opt: matchedQ.options[idxById]
                    };
                }
            }

            if (item && typeof item.jawaban_benar === 'string') {
                const cleanLabel = item.jawaban_benar.trim().toUpperCase();
                if (/^[A-E]$/.test(cleanLabel)) {
                    const idxByLetter = cleanLabel.charCodeAt(0) - 65;
                    if (matchedQ.options[idxByLetter]) {
                        return {
                            huruf: cleanLabel,
                            opt: matchedQ.options[idxByLetter]
                        };
                    }
                }
            }

            return null;
        }

        function buildWrongAnswersHtml(wrongList) {
            if (!Array.isArray(wrongList) || wrongList.length === 0) {
                return `
                    <div class="alert alert-success rounded-3 mb-0 text-start" style="font-size: 0.88rem;">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        <strong>Luar biasa!</strong> Tidak ada jawaban yang salah pada tes ini.
                    </div>
                `;
            }

            return wrongList.map(item => {
                const matchedQ = findMatchingQuestionForWrongItem(item);
                const matchedCorrect = findCorrectOptionFromQuestion(matchedQ, item);

                const nomor = escapeHtml(item.nomor ?? '-');
                const kategori = escapeHtml(item.kategori ?? matchedQ?.kategoriNama ?? '');
                const pertanyaanRaw = item.pertanyaan ?? matchedQ?.question ?? '';
                const pertanyaan = escapeHtml(pertanyaanRaw);

                const rawSoalImg = item.gambar_soal ?? item.gambar ?? matchedQ?.image ?? null;
                const soalImgHtml = rawSoalImg ?
                    `<div class="mb-2"><img src="${escapeHtml(resolveStorageUrl(rawSoalImg))}" alt="Gambar Soal No. ${nomor}" class="wrong-img-thumb"></div>` :
                    '';

                const matchedUserOpt = (matchedQ && typeof matchedQ.answer === 'number' && Array.isArray(matchedQ.options)) ?
                    matchedQ.options[matchedQ.answer] :
                    null;

                const userLetter = (matchedQ && typeof matchedQ.answer === 'number') ?
                    `Opsi ${String.fromCharCode(65 + matchedQ.answer)}` :
                    '';

                const jawabanUserRaw = item.jawaban_user ??
                    (matchedUserOpt ?
                        (matchedUserOpt.teks ? `${userLetter}: ${matchedUserOpt.teks}` : `${userLetter} (Gambar)`) :
                        'Tidak dijawab');
                const jawabanUser = escapeHtml(jawabanUserRaw);

                const rawUserImg = item.gambar_jawaban_user ?? item.gambar_user ?? matchedUserOpt?.gambar ?? null;
                const userImgHtml = rawUserImg ?
                    `<div class="mt-1 mb-1"><img src="${escapeHtml(resolveStorageUrl(rawUserImg))}" alt="Gambar Jawaban Anda" class="wrong-img-thumb"></div>` :
                    '';

                const correctOpt = matchedCorrect?.opt ?? null;
                const correctLetter = matchedCorrect?.huruf ? `Opsi ${matchedCorrect.huruf}` : '';

                const jawabanBenarRaw = item.jawaban_benar ??
                    (correctOpt ?
                        (correctOpt.teks ? `${correctLetter}: ${correctOpt.teks}` : `${correctLetter} (Gambar)`) :
                        '-');
                const jawabanBenar = escapeHtml(jawabanBenarRaw);

                const rawCorrectImg = item.gambar_jawaban_benar ?? item.gambar_benar ?? correctOpt?.gambar ?? null;
                const correctImgHtml = rawCorrectImg ?
                    `<div class="mt-1 mb-1"><img src="${escapeHtml(resolveStorageUrl(rawCorrectImg))}" alt="Gambar Jawaban Benar" class="wrong-img-thumb wrong-img-thumb-correct"></div>` :
                    '';

                const soalLabel = pertanyaanRaw || (rawSoalImg ? `Soal Bergambar No. ${nomor}` : `Soal No. ${nomor}`);
                const penjelasanRaw = item.penjelasan ||
                    `Pada ${soalLabel}, pilihan Anda (${jawabanUserRaw}) belum tepat. Jawaban yang benar adalah ${jawabanBenarRaw}${rawCorrectImg ? ' (lihat gambar jawaban benar di atas)' : ''}.`;
                const penjelasan = escapeHtml(penjelasanRaw);

                return `
                    <div class="wrong-detail-card text-start">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-danger font-mono-code">Soal No. ${nomor}</span>
                            ${kategori ? `<span class="badge bg-light text-secondary border">${kategori}</span>` : ''}
                        </div>
                        ${pertanyaan ? `<div class="fw-bold mb-2" style="font-size: 0.9rem; color: #0f172a;">${pertanyaan}</div>` : ''}
                        ${soalImgHtml}
                        <div class="small mb-1 text-danger">
                            <strong>Jawaban Anda:</strong> ${jawabanUser}
                            ${userImgHtml}
                        </div>
                        <div class="small mb-2 text-success">
                            <strong>Jawaban Benar:</strong> ${jawabanBenar}
                            ${correctImgHtml}
                        </div>
                        <div class="wrong-explanation-box">
                            <div class="fw-bold text-primary mb-1">
                                <i class="fa-solid fa-circle-info me-1"></i> Penjelasan Jawaban:
                            </div>
                            <div>${penjelasan}</div>
                            ${rawCorrectImg ? `<div class="mt-2"><img src="${escapeHtml(resolveStorageUrl(rawCorrectImg))}" alt="Gambar Jawaban Benar" class="wrong-img-thumb wrong-img-thumb-correct"></div>` : ''}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function showCompletionResultSwal(res) {
            const totalSkor = escapeHtml(res?.total_skor ?? 0);
            const wrongList = Array.isArray(res?.jawaban_salah) ? res.jawaban_salah : [];
            const wrongHtml = buildWrongAnswersHtml(wrongList);

            Swal.fire({
                icon: 'success',
                title: 'Tes Telah Selesai!',
                width: '720px',
                html: `
                    <div class="text-start" style="max-height: 68vh; overflow-y: auto; padding-right: 4px;">
                        <div class="bg-light border rounded-3 p-3 mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <div class="small text-secondary">Total Skor Anda</div>
                                <div class="fs-4 fw-bold font-mono-code text-primary">${totalSkor}</div>
                            </div>
                            <div class="text-end">
                                <div class="small text-secondary">Jumlah Jawaban Salah</div>
                                <div class="fs-5 fw-bold font-mono-code text-danger">${wrongList.length} Soal</div>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2 text-danger">
                            <i class="fa-solid fa-xmark-circle me-1"></i> Rincian Jawaban Salah &amp; Penjelasan Detail
                        </h6>
                        ${wrongHtml}
                    </div>
                `,
                confirmButtonText: 'Selesai & Kembali ke Form',
                confirmButtonColor: '#4f46e5',
                allowOutsideClick: false
            }).then(() => {
                kembaliKeFormDataDiri();
            });
        }

        function submitExam(fromTimeout = false) {
            if (isSubmittingExam) return;
            isSubmittingExam = true;
            lockExamInputs();

            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
            hapusCacheSesi();

            const modalEl = document.getElementById('confirmModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            }

            if (!tokenSesi) {
                Swal.fire({
                    icon: fromTimeout ? 'warning' : 'success',
                    title: fromTimeout ? 'Waktu Habis & Sesi Berakhir' : 'Selesai!',
                    text: 'Sesi tes telah berakhir.',
                    confirmButtonColor: '#4f46e5'
                }).then(() => kembaliKeFormDataDiri());
                return;
            }

            const urlSelesai = URL_SELESAI_TEMPLATE.replace('__TOKEN__', encodeURIComponent(tokenSesi));

            fetch(urlSelesai, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        waktu_habis: Boolean(fromTimeout)
                    })
                })
                .then(response => response.json())
                .then(res => {
                    showCompletionResultSwal(res);
                })
                .catch(() => {
                    const fallbackWrong = [];
                    allQuestions.forEach((q, idx) => {
                        if (q.answer === null) {
                            fallbackWrong.push({
                                nomor: idx + 1,
                                kategori: q.kategoriNama,
                                pertanyaan: q.question || 'Soal Bergambar',
                                jawaban_user: 'Tidak dijawab',
                                jawaban_benar: '-',
                                penjelasan: `Soal nomor ${idx + 1} belum dijawab sebelum ujian berakhir/waktu habis.`
                            });
                        }
                    });
                    showCompletionResultSwal({
                        total_skor: 0,
                        jawaban_salah: fallbackWrong
                    });
                });
        }

        function initSecurityFeatures() {
            document.addEventListener('contextmenu', e => e.preventDefault());
            document.addEventListener('keydown', e => {
                if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key)) || (e.ctrlKey && e.key === 'U')) {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>

</html>
