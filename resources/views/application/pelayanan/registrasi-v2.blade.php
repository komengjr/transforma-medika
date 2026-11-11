<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TAMBAHKAN CSRF TOKEN UNTUK AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Pasien - Retro UI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- Select2 CSS & Select2 Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- SWEETALERT 2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* =========================================
           RETRO / NEUBRUTALISM THEME STYLES
           ========================================= */
        :root {
            --retro-dark: #1e1e24;
            --retro-yellow: #ffde59;
            --retro-pink: #ffa6c9;
            --retro-cyan: #8bf0fa;
            --retro-orange: #ff914d;
            --retro-green: #c1ff72;
            --retro-purple: #c8b6ff;
            --retro-bg: #f4f0ea;
            --retro-border: 3px solid var(--retro-dark);
            --retro-shadow: 5px 5px 0px var(--retro-dark);
            --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--retro-dark);
            background-color: var(--retro-bg);
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--retro-dark);
        }

        /* Stepper Navigation */
        .nav-pills {
            gap: 15px;
        }

        .nav-pills .nav-item {
            flex: 1;
        }

        .nav-pills .nav-link {
            background: #ffffff;
            border-radius: 10px;
            color: var(--retro-dark);
            font-weight: 800;
            padding: 16px 20px;
            border: 2px solid var(--retro-dark);
            box-shadow: var(--retro-shadow-sm);
            transition: all 0.1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .nav-pills .nav-link:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(100%);
            background: #e2e8f0;
            box-shadow: none;
        }

        .nav-pills .nav-link i {
            font-size: 1.2rem;
        }

        .nav-pills .nav-link:not(:disabled):hover {
            transform: translate(-2px, -2px);
            box-shadow: 5px 5px 0px var(--retro-dark);
            background: var(--retro-cyan);
        }

        .nav-pills .nav-link.active.step-1 {
            background: var(--retro-cyan);
            color: var(--retro-dark);
        }

        .nav-pills .nav-link.active.step-2 {
            background: var(--retro-yellow);
            color: var(--retro-dark);
        }

        .nav-pills .nav-link.active.step-3 {
            background: var(--retro-green);
            color: var(--retro-dark);
        }

        /* Card Styles */
        .card {
            border-radius: 12px;
            border: 2px solid var(--retro-dark);
            background: #ffffff;
            box-shadow: var(--retro-shadow);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--retro-dark);
            padding: 16px 20px;
            font-size: 0.9rem;
        }

        .header-blue {
            background-color: var(--retro-cyan);
            color: var(--retro-dark);
        }

        .header-teal {
            background-color: var(--retro-green);
            color: var(--retro-dark);
        }

        .header-purple {
            background-color: var(--retro-purple);
            color: var(--retro-dark);
        }

        /* Form Inputs & Select2 */
        .input-group-text {
            background-color: var(--retro-bg);
            border: 2px solid var(--retro-dark);
            border-right: none;
            color: var(--retro-dark);
            font-weight: bold;
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        .form-control,
        .form-select {
            border: 2px solid var(--retro-dark) !important;
            border-radius: 6px !important;
            background-color: #ffffff;
            font-weight: 700;
            color: var(--retro-dark);
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 2px 2px 0px var(--retro-dark);
            border-color: var(--retro-dark) !important;
            background-color: #fff;
        }

        .input-group {
            border-radius: 6px;
            transition: all 0.2s;
        }

        .input-group:focus-within {
            box-shadow: 3px 3px 0px var(--retro-dark);
            transform: translateY(-1px);
        }

        .select2-container--bootstrap-5 .select2-selection {
            border: 2px solid var(--retro-dark) !important;
            border-radius: 6px !important;
            background-color: #ffffff !important;
            min-height: 45px;
            font-weight: 700;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            box-shadow: 2px 2px 0px var(--retro-dark) !important;
            border-color: var(--retro-dark) !important;
        }

        .input-group>.select2-container--bootstrap-5 {
            flex: 1 1 auto;
            width: 1% !important;
        }

        .avatar-wrapper {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            border-radius: 50%;
            background: var(--retro-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--retro-dark);
            box-shadow: var(--retro-shadow-sm);
            position: relative;
        }

        .table-custom thead {
            background: var(--retro-dark);
            color: var(--retro-green);
        }

        .table-custom th {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 14px 10px;
            border: 2px solid var(--retro-dark);
        }

        .table-custom tbody tr {
            transition: all 0.1s;
            background: #ffffff;
        }

        .table-custom tbody tr:hover {
            background-color: var(--retro-cyan);
            cursor: pointer;
        }

        .table-custom td {
            padding: 14px 10px;
            vertical-align: middle;
            border: 2px solid var(--retro-dark);
            font-weight: 700;
            color: var(--retro-dark);
        }

        .btn {
            font-weight: 800;
            letter-spacing: 0.3px;
            border-radius: 6px;
            border: 2px solid var(--retro-dark);
            box-shadow: var(--retro-shadow-sm);
            transition: all 0.1s ease-in-out;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .btn:active,
        .btn:hover {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px var(--retro-dark);
        }

        .btn-primary {
            background-color: var(--retro-cyan);
            color: var(--retro-dark);
        }

        .btn-success {
            background-color: var(--retro-green);
            color: var(--retro-dark);
        }

        .btn-warning {
            background-color: var(--retro-yellow);
            color: var(--retro-dark);
        }

        .btn-danger {
            background-color: var(--retro-pink);
            color: var(--retro-dark);
        }

        .btn-info {
            background-color: var(--retro-purple);
            color: var(--retro-dark);
        }

        .btn-light {
            background-color: #ffffff;
            color: var(--retro-dark);
        }

        .req-field {
            display: none;
            color: #d90429;
            font-size: 0.75rem;
            font-weight: 800;
            margin-top: 4px;
        }

        .form-control.border-danger,
        .form-select.border-danger {
            border: 2px solid #d90429 !important;
        }

        .camera-box {
            width: 100%;
            max-width: 220px;
            height: 220px;
            background: var(--retro-bg);
            border-radius: 10px;
            margin: 0 auto;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border: 3px solid var(--retro-dark);
            box-shadow: var(--retro-shadow-sm);
        }

        .camera-box video,
        .camera-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* CUSTOM NOTA PREVIEW DESIGN */
        .invoice-paper {
            background-color: #fff;
            border-radius: 4px;
            padding: 20px;
            border: 3px solid var(--retro-dark);
            box-shadow: var(--retro-shadow);
            position: relative;
            font-family: 'Space Mono', monospace;
            color: #000;
        }

        .invoice-paper table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }

        .invoice-paper table td,
        .invoice-paper table th {
            padding: 3px 0;
            vertical-align: top;
        }

        .invoice-line-solid {
            border-top: 2px solid #000;
            margin: 6px 0;
        }

        .invoice-line-dashed {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        /* METODE PEMBAYARAN CARD */
        .payment-method-card {
            border: 2px solid var(--retro-dark);
            border-radius: 10px;
            padding: 16px;
            background: #fff;
            cursor: pointer;
            box-shadow: var(--retro-shadow-sm);
            transition: all 0.1s ease-in-out;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-method-card:hover {
            transform: translate(-2px, -2px);
            box-shadow: 5px 5px 0px var(--retro-dark);
        }

        .payment-method-icon {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            border: 2px solid var(--retro-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            background-color: var(--retro-yellow);
        }

        .btn-check:checked+.payment-method-card {
            border-color: var(--retro-dark);
            background-color: var(--retro-cyan);
            box-shadow: 4px 4px 0px var(--retro-dark);
        }

        .btn-check:checked+.payment-method-card .check-indicator {
            opacity: 1;
            transform: scale(1);
        }

        .check-indicator {
            margin-left: auto;
            color: var(--retro-dark);
            font-size: 1.3rem;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.2s;
        }

        /* MEMBER CARD */
        .member-card-container {
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
            border-radius: 16px;
            background: var(--retro-yellow);
            color: var(--retro-dark);
            position: relative;
            overflow: hidden;
            border: 3px solid var(--retro-dark);
            box-shadow: var(--retro-shadow);
            padding: 20px;
        }

        .member-card-photo {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            border: 2px solid var(--retro-dark);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 2px 2px 0px var(--retro-dark);
            flex-shrink: 0;
        }
    </style>
</head>

<body>

    <div class="container-fluid py-4 px-4 px-md-5">
        <!-- Title Area, User Login, Real-time Clock & Reset -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="bg-white p-3 rounded-3 shadow-sm me-3 text-dark d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark); background-color: var(--retro-yellow);">
                    <i class="fas fa-hospital fa-2x"></i>
                </div>
                <div>
                    <h3 class="mb-0 fw-bolder text-dark">Registrasi Pasien Satu Pintu</h3>
                    <span class="text-dark fw-bold opacity-75">Sistem Informasi Manajemen Rumah Sakit (SIMRS)</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="bg-white px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                    <i class="fas fa-user-circle text-dark fs-5"></i>
                    <span class="fw-bolder text-dark">{{ Auth::user()->name ?? 'Agus Prasetyo R.' }}</span>
                </div>
                <div class="bg-white px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark); background-color: var(--retro-cyan);">
                    <i class="fas fa-clock text-dark"></i>
                    <span id="realtimeClock" class="fw-bolder fs-5 text-dark" style="font-variant-numeric: tabular-nums;">00:00:00</span>
                </div>
                <button class="btn btn-danger px-4 py-2 fw-bold" onclick="konfirmasiReset()" title="Mulai Registrasi Baru">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </button>
            </div>
        </div>

        <!-- Stepper Navigation -->
        <ul class="nav nav-pills mb-4" id="registrationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active step-1 w-100" id="tab-demografi" data-bs-toggle="pill" data-bs-target="#demografi" type="button" role="tab">
                    <i class="fas fa-user-edit"></i> <span>1. Demografi</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link step-2 w-100" id="tab-pemeriksaan" data-bs-toggle="pill" data-bs-target="#pemeriksaan" type="button" role="tab" disabled>
                    <i class="fas fa-microscope"></i> <span>2. Layanan Medis</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link step-3 w-100" id="tab-pembayaran" data-bs-toggle="pill" data-bs-target="#pembayaran" type="button" role="tab" disabled>
                    <i class="fas fa-file-invoice-dollar"></i> <span>3. Administrasi</span>
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="registrationTabsContent">

            <!-- ============================================== -->
            <!-- STEP 1: DEMOGRAFI -->
            <!-- ============================================== -->
            <div class="tab-pane fade show active" id="demografi" role="tabpanel">
                <div class="card border-0 mb-4" style="background: #ffffff; border: 2px solid var(--retro-dark); box-shadow: var(--retro-shadow-sm);">
                    <div class="card-body p-3 d-flex flex-wrap align-items-center justify-content-between gap-3">

                        <!-- SISI KIRI: Aksi Pasien & Pencarian -->
                        <div class="d-flex flex-wrap align-items-center gap-2" style="flex: 1; min-width: 300px;">
                            <button class="btn btn-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width:45px; height:45px; flex-shrink: 0;" data-bs-toggle="modal" data-bs-target="#modalPasien" onclick="resetForm('modalPasien')" title="Tambah Pasien Baru">
                                <i class="fas fa-plus"></i>
                            </button>

                            <button class="btn btn-info text-dark rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width:45px; height:45px; flex-shrink: 0;" title="Scan KTP / E-KTP">
                                <i class="fas fa-id-card"></i>
                            </button>
                            <button class="btn btn-warning text-dark rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width:45px; height:45px; flex-shrink: 0;" title="Panggil Antrian" data-bs-toggle="modal" data-bs-target="#modalAntrian">
                                <i class="fas fa-bullhorn"></i>
                            </button>

                            <div class="input-group shadow-sm" style="flex: 1;">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="searchKeyword" class="form-control" placeholder="Cari Nama / No. HP / NIK... (Min. 3 huruf)" onkeyup="if(event.keyCode === 13) cariPasien()">
                                <button class="btn btn-primary px-4" type="button" onclick="cariPasien()">Cari</button>
                            </div>
                        </div>

                        <!-- SISI KANAN: Laporan & Tutup Kasir -->
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <button class="btn btn-light shadow-sm fw-bold d-flex align-items-center gap-2" onclick="bukaLaporanPendaftaran()" title="Lihat daftar pasien yang didaftarkan akun ini">
                                <i class="fas fa-clipboard-list"></i> Laporan Pendaftaran
                            </button>
                            <button class="btn btn-danger shadow-sm fw-bold d-flex align-items-center gap-2" onclick="bukaModalCetakSetoran()" title="Cetak laporan setoran ke keuangan">
                                <i class="fas fa-print"></i> Cetak Laporan Setor ke Keuangan
                            </button>
                        </div>

                    </div>
                </div>

                <div class="row g-4">
                    <!-- KIRI: PROFIL PASIEN -->
                    <div class="col-lg-7">
                        <div class="card h-100">
                            <div class="card-header header-blue d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-id-card me-2"></i> Data Profil Pasien</span>
                                <span class="badge bg-white text-dark border border-dark rounded-2 px-2 py-1 shadow-sm fw-bold"><i class="fas fa-check-circle me-1 text-success"></i> Terverifikasi</span>
                            </div>
                            <div class="card-body p-3 p-xl-4">
                                <div class="row align-items-start pt-2">
                                    <div class="col-md-3 text-center mb-4 mb-md-0">
                                        <div class="avatar-wrapper mb-3">
                                            <img id="displayFoto" src="" alt="Foto Pasien" style="width:100%; height:100%; border-radius:50%; object-fit:cover; display:none;">
                                            <i id="displayIcon" class="fas fa-user-tie fa-3x text-dark opacity-50"></i>
                                        </div>
                                        <div class="d-grid gap-2 px-1">
                                            <button class="btn btn-light btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalPasien" onclick="populateEditForm()"><i class="fas fa-edit me-1"></i> Perbarui</button>
                                            <button class="btn btn-warning btn-sm fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#modalCetakKartu">
                                                <i class="fas fa-print me-1"></i> Cetak Kartu
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row g-2 form-control-sm">
                                            <div class="col-md-8">
                                                <label class="form-label small fw-bold text-dark mb-0">Nama Lengkap & Title</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" id="displayNama" class="form-control fw-bold text-dark" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold text-dark mb-0">PID Pasien</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                    <input type="text" id="displayPid" class="form-control text-dark fw-bold bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold text-dark mb-0">No. ID (NIK/SIM/Paspor)</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                                    <input type="text" id="displayNik" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold text-dark mb-0">Tempat, Tanggal Lahir (Umur)</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    <input type="text" id="displayTglLahir" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small fw-bold text-dark mb-0">Gender</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                                    <input type="text" id="displayJk" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-bold text-dark mb-0">Agama</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-pray"></i></span>
                                                    <input type="text" id="displayAgama" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-bold text-dark mb-0">Pekerjaan (NIP)</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    <input type="text" id="displayPekerjaan" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-bold text-dark mb-0">No. Telepon / HP</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="text" id="displayNoHp" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small fw-bold text-dark mb-0">Email</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    <input type="text" id="displayEmail" class="form-control bg-light" readonly>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text align-items-start pt-2"><i class="fas fa-map-marker-alt"></i></span>
                                                    <textarea id="displayAlamat" class="form-control bg-light" rows="2" placeholder="Alamat Lengkap" readonly></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text align-items-start pt-2"><i class="fas fa-sticky-note"></i></span>
                                                    <textarea id="displayCatatan" class="form-control bg-light" rows="1" placeholder="Catatan Tambahan Pasien" readonly></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3 pt-3 border-top border-dark">
                                                <label class="form-label small fw-bold text-dark mb-1">Keluhan Medis / Diagnosa Awal</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                                    <input type="text" id="input_keluhan" class="form-control" placeholder="Ketik keluhan di sini...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KANAN: REFERENSI, BAHASA & PENGIRIMAN -->
                    <div class="col-lg-5">
                        <div class="card mb-3">
                            <div class="card-header header-teal"><i class="fas fa-hospital-user me-2"></i> Referensi & Penjamin</div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase mb-1">Tipe FPP</label>
                                        <div class="mb-3 input-group">
                                            <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            <select class="form-select select2-init" name="tipe_fpp_id" id="tipe_fpp_id">
                                                <option value="" disabled selected>Pilih Tipe FPP...</option>
                                                <option value="1">Rujukan Internal</option>
                                                <option value="2">Rujukan Eksternal / Luar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase mb-1">Dokter Pengirim</label>
                                        <div class="mb-3 input-group">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                            <select class="form-select select2-dokter-pengirim" name="dokter_id" id="input_dokter" style="width: 100%;">
                                                <option value="" disabled selected>Pilih atau Cari Dokter Pengirim...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- UPDATE: PENJAMIN UTAMA & SUB PENJAMIN DIPINDAH KESINI -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase mb-1">Tipe Penjamin Utama</label>
                                        <div class="mb-3 input-group">
                                            <span class="input-group-text"><i class="fas fa-hand-holding-heart"></i></span>
                                            <select class="form-select select2-init fw-bold text-dark" id="pilih_penjamin" name="penjamin_id" onchange="toggleSubPenjamin()">
                                                <option value="" disabled selected>Memuat penjamin...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="wrapper_sub_penjamin" style="display: none;">
                                            <label class="form-label fw-bold text-dark small text-uppercase mb-1">Sub Penjamin</label>
                                            <div class="mb-3 input-group">
                                                <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                                <select class="form-select select2-init fw-bold text-dark" id="pilih_sub_penjamin" name="sub_penjamin_id" onchange="handleSubPenjaminChange()">
                                                    <option value="" disabled selected>Pilih Sub Penjamin...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END UPDATE -->

                                <div class="mt-4 pt-3 border-top border-dark">
                                    <label class="form-label fw-bold text-dark small text-uppercase mb-2">Bahasa Hasil (Pilih > 1)</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check custom-checkbox">
                                            <input class="form-check-input cursor-pointer shadow-sm border-2 border-dark" type="checkbox" name="bahasa_hasil[]" value="ID" id="lang_id" checked>
                                            <label class="form-check-label cursor-pointer fw-bold" for="lang_id">Indonesia</label>
                                        </div>
                                        <div class="form-check custom-checkbox">
                                            <input class="form-check-input cursor-pointer shadow-sm border-2 border-dark" type="checkbox" name="bahasa_hasil[]" value="EN" id="lang_en">
                                            <label class="form-check-label cursor-pointer fw-bold" for="lang_en">English</label>
                                        </div>
                                        <div class="form-check custom-checkbox">
                                            <input class="form-check-input cursor-pointer shadow-sm border-2 border-dark" type="checkbox" name="bahasa_hasil[]" value="CN" id="lang_cn">
                                            <label class="form-check-label cursor-pointer fw-bold" for="lang_cn">Mandarin</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header header-blue"><i class="fas fa-paper-plane me-2"></i> Pengiriman Hasil</div>
                            <div class="card-body p-3">
                                <div class="row g-2">
                                    <div class="col-3">
                                        <label class="form-check p-2 rounded-2 d-flex flex-column align-items-center justify-content-center text-center h-100 mb-0" style="cursor: pointer; border: 2px solid var(--retro-dark); background: #fff;">
                                            <input class="form-check-input ms-0 mb-1 mt-0 border-2 border-dark" type="checkbox" name="pengiriman[]" value="whatsapp" checked>
                                            <i class="fab fa-whatsapp text-success mb-1 fs-5"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.65rem;">WhatsApp</span>
                                        </label>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-check p-2 rounded-2 d-flex flex-column align-items-center justify-content-center text-center h-100 mb-0" style="cursor: pointer; border: 2px solid var(--retro-dark); background: #fff;">
                                            <input class="form-check-input ms-0 mb-1 mt-0 border-2 border-dark" type="checkbox" name="pengiriman[]" value="email">
                                            <i class="fas fa-envelope text-danger mb-1 fs-5"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.65rem;">Email</span>
                                        </label>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-check p-2 rounded-2 d-flex flex-column align-items-center justify-content-center text-center h-100 mb-0" style="cursor: pointer; border: 2px solid var(--retro-dark); background: #fff;">
                                            <input class="form-check-input ms-0 mb-1 mt-0 border-2 border-dark" type="checkbox" name="pengiriman[]" value="satusehat" checked>
                                            <i class="fas fa-heartbeat text-info mb-1 fs-5"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.65rem;">Satu Sehat</span>
                                        </label>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-check p-2 rounded-2 d-flex flex-column align-items-center justify-content-center text-center h-100 mb-0" style="cursor: pointer; border: 2px solid var(--retro-dark); background: #fff;">
                                            <input class="form-check-input ms-0 mb-1 mt-0 border-2 border-dark" type="checkbox" name="pengiriman[]" value="cetak_fisik">
                                            <i class="fas fa-print text-secondary mb-1 fs-5"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.65rem;">Cetak Kertas</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-primary btn-lg px-5 py-3 d-flex align-items-center gap-2 fw-bold" onclick="nextTab('tab-pemeriksaan')">
                        Lanjutkan ke Pemeriksaan <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- STEP 2: PEMERIKSAAN -->
            <!-- ============================================== -->
            <div class="tab-pane fade" id="pemeriksaan" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header header-purple"><i class="fas fa-briefcase-medical me-2"></i> Penjamin & Layanan Medis</div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase">Jenis Layanan</label>
                                        <div class="mb-3 input-group">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                            <select class="form-select fw-bold text-dark" name="jenis_layanan" id="input_jenis_layanan" onchange="toggleJenisLayanan()">
                                                <option value="RAWAT_JALAN" selected>RAWAT JALAN / POLIKLINIK</option>
                                                <option value="IGD">IGD (GAWAT DARURAT)</option>
                                                <option value="RAWAT_INAP">RAWAT INAP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase">Tanggal Periksa</label>
                                        <div class="mb-3 input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                            <!-- UPDATE: Ditambahkan value otomatis ke hari ini -->
                                            <input type="date" id="input_tanggal_periksa" class="form-control" value="{{ date('Y-m-d') }}" onchange="loadDokterBerjadwal(); loadDokterIgd();">
                                        </div>
                                    </div>
                                </div>

                                <!-- WRAPPER RAWAT JALAN -->
                                <div id="wrapper_rawat_jalan">
                                    <label class="form-label fw-bold text-dark small text-uppercase">Poliklinik Tujuan</label>
                                    <div class="mb-3 input-group">
                                        <span class="input-group-text"><i class="fas fa-clinic-medical"></i></span>
                                        <select class="form-select select2-init" name="poli_id" id="input_poli_id" onchange="loadDokterBerjadwal(); handlePoliChange();">
                                            <option value="" disabled selected>Pilih Poli...</option>
                                            @if(isset($polis) && count($polis) > 0)
                                            @foreach($polis as $poli)
                                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                            @endforeach
                                            @else
                                            <option value="1">Poli Umum</option>
                                            <option value="2">Poli Gigi dan Mulut</option>
                                            <option value="3">Poli Penyakit Dalam</option>
                                            <option value="4">Poli Mata</option>
                                            @endif
                                        </select>
                                    </div>

                                    <label class="form-label fw-bold text-dark small text-uppercase">Dokter Pemeriksa (Berjadwal)</label>
                                    <div class="mb-3 input-group">
                                        <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        <select class="form-select select2-init" name="doctor_poli_id" id="input_doctor_poli">
                                            <option value="" disabled selected>Pilih Poli & Tanggal Terlebih Dahulu...</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- WRAPPER IGD -->
                                <div id="wrapper_igd" style="display: none;">
                                    <label class="form-label fw-bold text-dark small text-uppercase">Dokter Jaga IGD</label>
                                    <div class="mb-3 input-group">
                                        <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        <select class="form-select select2-init" name="doctor_igd_id" id="input_doctor_igd">
                                            <option value="" disabled selected>Pilih Tanggal Periksa Terlebih Dahulu...</option>
                                            @if(isset($jadwalIgds) && count($jadwalIgds) > 0)
                                            @foreach($jadwalIgds as $j)
                                            <option value="{{ $j->doctor_id }}">{{ $j->nama_lengkap }} (Shift: {{ $j->shift }} | {{ $j->jam_mulai }} - {{ $j->jam_selesai }})</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- WRAPPER RAWAT INAP -->
                                <div id="wrapper_rawat_inap" style="display: none;">
                                    <label class="form-label fw-bold text-dark small text-uppercase">Pilih Ruangan</label>
                                    <div class="mb-3 input-group">
                                        <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                                        <select class="form-select select2-init" name="ruangan_id" id="input_ruangan_id" onchange="loadBedTersedia()">
                                            <option value="" disabled selected>Pilih Ruangan...</option>
                                            @if(isset($ruangans) && count($ruangans) > 0)
                                            @foreach($ruangans as $r)
                                            <option value="{{ $r->id }}">{{ $r->nama_ruangan }} — Kelas {{ $r->kelas }}</option>
                                            @endforeach
                                            @else
                                            <option value="1">Ruang Melati — Kelas 1</option>
                                            <option value="2">Ruang Anggrek — VIP</option>
                                            @endif
                                        </select>
                                    </div>

                                    <label class="form-label fw-bold text-dark small text-uppercase">Pilih Bed (Tempat Tidur)</label>
                                    <div class="mb-3 input-group">
                                        <span class="input-group-text"><i class="fas fa-bed"></i></span>
                                        <select class="form-select select2-init" name="bed_id" id="input_bed_id">
                                            <option value="" disabled selected>Pilih Ruangan Terlebih Dahulu...</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- BLOK PENJAMIN DARI SINI TELAH DIHAPUS DAN DIPINDAHKAN KE STEP 1 -->
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header header-purple"><i class="fas fa-search-plus me-2"></i> Input Tindakan</div>
                            <div class="card-body p-4">
                                <div class="input-group input-group-lg shadow-sm align-items-center">
                                    <span class="input-group-text" style="border-right: none; z-index: 10;"><i class="fas fa-search"></i></span>
                                    <select class="form-select fs-6" id="input_pemeriksaan" disabled>
                                        <option value="" disabled selected>Pilih Sub Penjamin Dulu...</option>
                                    </select>
                                    <button class="btn btn-primary px-4 ms-1 rounded-end" style="z-index: 10;" onclick="tambahKeOrder()"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-header header-blue d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-shopping-cart me-2"></i> Rincian Tindakan (Order)</span>
                                <span class="badge bg-white text-dark border border-dark rounded-2 px-3 py-1 shadow-sm fw-bold" id="badge_order_count"><i class="fas fa-vial me-1"></i> 0 Item Dipilih</span>
                            </div>

                            <div class="flex-grow-1" style="min-height: 300px;">
                                <table class="table table-custom mb-0 text-center align-middle" id="tabel_order_tindakan">
                                    <thead>
                                        <tr>
                                            <th style="width: 8%;">CITO</th>
                                            <th class="text-start" style="width: 42%;">NAMA LAYANAN / PEMERIKSAAN</th>
                                            <th>TARIF (RP)</th>
                                            <th>DISKON</th>
                                            <th>SUBTOTAL</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Javascript Rows -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-white border-top border-dark d-flex justify-content-between align-items-center py-3 px-4">
                                <span class="fw-bolder text-dark fs-5 text-uppercase">Estimasi Total:</span>
                                <span class="fw-bolder text-dark fs-3" id="estimasi_total">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-light shadow-sm px-4 text-dark fw-bold" onclick="prevTab('tab-demografi')">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Demografi
                    </button>
                    <button class="btn btn-primary btn-lg shadow px-5 py-3 d-flex align-items-center gap-2 fw-bold" onclick="prosesKePembayaran()">
                        Proses Pembayaran <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- STEP 3: ADMINISTRASI / PEMBAYARAN -->
            <!-- ============================================== -->
            <div class="tab-pane fade" id="pembayaran" role="tabpanel">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-print text-dark me-2"></i>
                            <span class="text-dark fw-bold text-uppercase small">Preview Struk Cetak</span>
                        </div>

                        <!-- CUSTOM NOTA PREVIEW DESIGN -->
                        <div class="invoice-paper" id="area-cetak-nota">
                            <div class="text-end" style="font-size: 9px; margin-bottom: 2px;">XXX-XX-XX-01.1/05</div>
                            <div class="text-center" style="margin-bottom: 10px;">
                                <div style="font-size: 14px; font-weight: bold; letter-spacing: 0.5px;">NOTA PEMBAYARAN</div>
                                <div style="font-size: 10px;">No. Nota : <span id="invoice-no">REG-XXXXXXXX</span></div>
                            </div>

                            <table style="width: 100%; font-size: 10px; margin-bottom: 8px;">
                                <tr>
                                    <td style="width: 18%;">Nama Pelanggan</td>
                                    <td style="width: 2%;">:</td>
                                    <td style="width: 30%;" class="fw-bold" id="invoice-pasien">Sdr XXXXXXX</td>
                                    <td style="width: 18%;">ID Pelanggan</td>
                                    <td style="width: 2%;">:</td>
                                    <td style="width: 30%;" id="invoice-pid">XXXXXXX</td>
                                </tr>
                                <tr>
                                    <td>Umur/J. Kelamin</td>
                                    <td>:</td>
                                    <td id="invoice-umur">xxx tahun / X</td>
                                    <td>No. Reg</td>
                                    <td>:</td>
                                    <td id="invoice-noreg">REG-XXXXXXXX</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td id="invoice-alamat">xxxxxxx xxxxxxx</td>
                                    <td>Pengirim</td>
                                    <td>:</td>
                                    <td id="invoice-pengirim">xxxxxxx xxxxxxx</td>
                                </tr>
                                <tr>
                                    <td>Kel. Pelanggan</td>
                                    <td>:</td>
                                    <td id="invoice-kel-pelanggan">xxxxxxx xxxxxxx</td>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td id="invoice-date">xx-xx-xxxx xx:xx:xx</td>
                                </tr>
                            </table>

                            <table style="width: 100%; font-size: 10px; border-collapse: collapse; margin-bottom: 5px;">
                                <thead>
                                    <tr style="border-top: 2px solid #000; border-bottom: 2px solid #000;">
                                        <th class="text-start fst-italic py-1" style="width: 52%;">PEMERIKSAAN</th>
                                        <th class="text-end fst-italic py-1" style="width: 16%;">BRUTO</th>
                                        <th class="text-end fst-italic py-1" style="width: 16%;">DISKON</th>
                                        <th class="text-end fst-italic py-1" style="width: 16%;">HARGA</th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-table-body">
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>

                            <div class="invoice-line-dashed"></div>

                            <table style="width: 100%; font-size: 10px;">
                                <tr>
                                    <td class="fw-bold fst-italic" style="width: 52%;">Sub Total</td>
                                    <td class="text-end fw-bold" style="width: 16%;" id="invoice-subtotal-bruto">xxx.xxx</td>
                                    <td class="text-end fw-bold" style="width: 16%;" id="invoice-subtotal-diskon">0</td>
                                    <td class="text-end fw-bold" style="width: 16%;" id="invoice-subtotal">xxx.xxx</td>
                                </tr>
                            </table>

                            <div class="invoice-line-dashed"></div>
                            <table style="width: 100%; font-size: 10px;">
                                <tr>
                                    <td class="fw-bold fst-italic">Pembulatan</td>
                                    <td class="text-end">0</td>
                                </tr>
                            </table>
                            <div class="invoice-line-dashed"></div>
                            <table style="width: 100%; font-size: 10px;">
                                <tr>
                                    <td class="fw-bold fst-italic">Grand Total</td>
                                    <td class="text-end fw-bold" id="invoice-grandtotal">xxx.xxx</td>
                                </tr>
                            </table>
                            <div class="invoice-line-dashed"></div>
                            <table style="width: 100%; font-size: 10px;">
                                <tr>
                                    <td class="fw-bold fst-italic">Pembayaran</td>
                                    <td class="text-end"></td>
                                </tr>
                                <tr>
                                    <td id="invoice-metode-bayar">Cash</td>
                                    <td class="text-end" id="invoice-total-bayar">xxx.xxx</td>
                                </tr>
                            </table>
                            <div class="invoice-line-dashed"></div>
                            <table style="width: 100%; font-size: 10px;">
                                <tr>
                                    <td class="fw-bold fst-italic text-uppercase">TOTAL PEMBAYARAN</td>
                                    <td class="text-end fw-bold" id="invoice-total-pembayaran">xxx.xxx</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold fst-italic">Kembalian</td>
                                    <td class="text-end" id="invoice-kembalian">0</td>
                                </tr>
                            </table>

                            <div style="font-size: 10px; margin-top: 10px;">
                                <div class="fw-bold fst-italic">Hasil Pemeriksaan :</div>
                                <div>Ambil Sendiri</div>
                                <div><span class="fw-bold">Whatsapp Pasien :</span> <span id="invoice-wa">-</span></div>
                                <div class="fw-bold fst-italic mt-1">Hasil Selesai :</div>
                                <div id="invoice-janji-hasil">xx-xx-xxxx xx:xx:xx</div>

                                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 8px;">
                                    <div style="text-align: right; font-size: 9px;">Pontianak, <span id="invoice-now">xx-xx-xxxx xx:xx:xx</span></div>
                                </div>

                                <div style="font-size: 8.5px; margin-top: 4px;">
                                    Kami menyetujui bahwa hasil pemeriksaan dikirim melalui media elektronik WhatsApp No. <span id="invoice-wa-2"></span>
                                </div>

                                <table style="width: 100%; text-align: center; margin-top: 25px; font-size: 10px;">
                                    <tr>
                                        <td style="width: 50%;">
                                            <span style="text-decoration: underline; font-weight: bold;" id="invoice-ttd-pasien">Sdr XXXXXXX</span>
                                        </td>
                                        <td style="width: 50%;">
                                            <span style="text-decoration: underline; font-weight: bold;" id="invoice-ttd-kasir">Petugas Kasir</span>
                                        </td>
                                    </tr>
                                </table>

                                <div class="text-center fst-italic" style="font-size: 8.5px; margin-top: 15px; border-top: 1px solid #ddd; padding-top: 4px;">
                                    xxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxxx xxxxxxx
                                </div>

                                <div style="display: flex; justify-content: space-between; font-size: 8px; margin-top: 4px;">
                                    <div>Dicetak Oleh : <span id="invoice-kasir-footer">Petugas</span></div>
                                    <div>1 / 1</div>
                                    <div id="invoice-print-date">xx xxx xxxx xx.xx</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="card border-0 shadow-lg p-4 p-xl-5 h-100">
                            <h4 class="fw-bolder mb-1">Metode Pembayaran</h4>
                            <p class="text-dark mb-4 fw-bold opacity-75">Pilih metode pembayaran yang digunakan oleh pasien.</p>

                            <div class="d-flex flex-column gap-3 mb-5">
                                <label class="position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" value="Cash" id="pay-cash" autocomplete="off" checked onchange="updateBayarDisplay()">
                                    <div class="payment-method-card">
                                        <div class="payment-method-icon"><i class="fas fa-money-bill-wave text-dark"></i></div>
                                        <div>
                                            <h6 class="mb-0 fw-bolder">Tunai (Cash)</h6><small class="text-dark fw-bold opacity-75">Pembayaran menggunakan uang fisik</small>
                                        </div>
                                        <i class="fas fa-check-circle check-indicator"></i>
                                    </div>
                                </label>

                                <label class="position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" value="QRIS" id="pay-qris" autocomplete="off" onchange="updateBayarDisplay()">
                                    <div class="payment-method-card">
                                        <div class="payment-method-icon" style="background-color: var(--retro-cyan);"><i class="fas fa-qrcode text-dark"></i></div>
                                        <div>
                                            <h6 class="mb-0 fw-bolder">QRIS (E-Wallet/M-Banking)</h6><small class="text-dark fw-bold opacity-75">Gopay, OVO, Dana, ShopeePay, dll</small>
                                        </div>
                                        <i class="fas fa-check-circle check-indicator"></i>
                                    </div>
                                </label>

                                <label class="position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" value="EDC" id="pay-edc" autocomplete="off" onchange="updateBayarDisplay()">
                                    <div class="payment-method-card">
                                        <div class="payment-method-icon" style="background-color: var(--retro-purple);"><i class="fas fa-credit-card text-dark"></i></div>
                                        <div>
                                            <h6 class="mb-0 fw-bolder">Kartu Debit / Kredit (EDC)</h6><small class="text-dark fw-bold opacity-75">Mesin EDC BCA, Mandiri, BNI, dll</small>
                                        </div>
                                        <i class="fas fa-check-circle check-indicator"></i>
                                    </div>
                                </label>

                                <label class="position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" value="Piutang" id="pay-piutang" autocomplete="off" onchange="updateBayarDisplay()">
                                    <div class="payment-method-card">
                                        <div class="payment-method-icon" style="background-color: var(--retro-orange);"><i class="fas fa-building text-dark"></i></div>
                                        <div>
                                            <h6 class="mb-0 fw-bolder">Piutang (Perusahaan)</h6><small class="text-dark fw-bold opacity-75">Tagihan dibebankan ke instansi/perusahaan</small>
                                        </div>
                                        <i class="fas fa-check-circle check-indicator"></i>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-auto">
                                <div class="p-3 rounded-3 d-flex justify-content-between align-items-center mb-4" style="background-color: var(--retro-cyan); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                                    <span class="fw-bolder text-dark">Tagihan Akhir:</span>
                                    <span class="fw-bolder text-dark fs-4" id="tagihan-akhir-display">Rp 0</span>
                                </div>

                                <button class="btn btn-success btn-lg w-100 py-3 fw-bold fs-5 d-flex justify-content-center align-items-center gap-2"
                                    onclick="prosesBayar()">
                                    <i class="fas fa-print"></i> PROSES & CETAK STRUK
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-start mt-4">
                    <button class="btn btn-light shadow-sm px-4 text-dark fw-bold" onclick="prevTab('tab-pemeriksaan')">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Pemeriksaan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PENCARIAN PASIEN -->
    <div class="modal fade" id="modalPencarianPasien" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: 3px solid var(--retro-dark); box-shadow: var(--retro-shadow); overflow: hidden;">
                <div class="modal-header text-dark" style="background: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark); padding: 20px 25px;">
                    <h5 class="modal-title fw-bolder d-flex align-items-center">
                        <i class="fas fa-users me-3 fa-lg"></i> Hasil Pencarian Pasien
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-hover table-custom mb-0 text-center align-middle" id="tableHasilPencarian" style="display: none;">
                        <thead>
                            <tr>
                                <th>PID</th>
                                <th class="text-start">NAMA PASIEN</th>
                                <th>TGL LAHIR</th>
                                <th>NIK</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div id="pencarianLoading" class="text-center p-5" style="display: none;">
                        <div class="spinner-border text-dark" role="status"></div>
                        <p class="mt-2 text-dark fw-bold">Mencari data pasien...</p>
                    </div>
                    <div id="pencarianKosong" class="text-center p-5" style="display: none;">
                        <i class="fas fa-folder-open fa-4x text-dark mb-3 opacity-50"></i>
                        <h5 class="text-dark fw-bold">Data pasien tidak ditemukan.</h5>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top border-dark p-3">
                    <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH & PERBARUI PASIEN -->
    <div class="modal fade" id="modalPasien" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: 3px solid var(--retro-dark); box-shadow: var(--retro-shadow); overflow: hidden;">
                <div class="modal-header text-dark" style="background: var(--retro-cyan); border-bottom: 3px solid var(--retro-dark); padding: 20px 25px;">
                    <h5 class="modal-title fw-bolder d-flex align-items-center" id="modalPasienTitle">
                        <i class="fas fa-user-plus me-3 fa-lg"></i> Form Data Pasien
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white modal-minimal-input">
                    <form id="formPasien">
                        <input type="hidden" name="pasien_id" id="form_pasien_id" value="">
                        <div class="row g-5">
                            <div class="col-lg-7">
                                <div class="row g-4 align-items-start">
                                    <div class="col-md-3"><input type="text" name="awalan" id="form_awalan" class="form-control" placeholder="Awalan"></div>
                                    <div class="col-md-6">
                                        <input type="text" name="nama" id="form_nama" class="form-control" placeholder="Nama Pasien" required>
                                        <span class="req-field">Harus diisi !</span>
                                    </div>
                                    <div class="col-md-3"><input type="text" name="akhiran" id="form_akhiran" class="form-control" placeholder="Akhiran"></div>

                                    <div class="col-md-6 mt-4">
                                        <select name="jk" id="form_jk" class="form-select" required>
                                            <option value="" disabled selected>Jenis Kelamin</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        <span class="req-field">Harus diisi !</span>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <select name="title" id="form_title" class="form-select" required>
                                            <option value="" disabled selected>Title</option>
                                            <option value="tn">Tn.</option>
                                            <option value="ny">Ny.</option>
                                            <option value="nn">Nn.</option>
                                            <option value="an">An.</option>
                                            <option value="by">By.</option>
                                        </select>
                                        <span class="req-field">Harus diisi !</span>
                                    </div>

                                    <div class="col-md-4 mt-4"><input type="text" name="tempat_lahir" id="form_tempat_lahir" class="form-control" placeholder="Tempat Lahir"></div>
                                    <div class="col-md-4 mt-4"><input type="number" name="umur" id="form_umur" class="form-control" placeholder="Umur"></div>
                                    <div class="col-md-4 mt-4">
                                        <input type="date" name="tgl_lahir" id="form_tgl_lahir" class="form-control" required>
                                        <span class="req-field">Harus diisi !</span>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <select name="agama" id="form_agama" class="form-select">
                                            <option value="" disabled selected>Agama</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen Protestan">Kristen Protestan</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <input type="text" name="no_hp" id="form_no_hp" class="form-control" placeholder="No HP" required>
                                        <span class="req-field">Harus diisi !</span>
                                    </div>

                                    <div class="col-md-12 mt-4"><input type="email" name="email" id="form_email" class="form-control" placeholder="Email"></div>
                                    <div class="col-md-12 mt-4"><input type="text" name="pekerjaan" id="form_pekerjaan" class="form-control" placeholder="Pekerjaan"></div>
                                    <div class="col-md-12 mt-4"><input type="text" name="nip" id="form_nip" class="form-control" placeholder="Nomor Induk Pegawai"></div>

                                    <div class="col-md-4 mt-4">
                                        <select name="tipe_id" id="form_tipe_id" class="form-select">
                                            <option value="" disabled selected>Tipe ID</option>
                                            <option value="KTP">KTP</option>
                                            <option value="SIM">SIM</option>
                                            <option value="Paspor">Paspor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8 mt-4"><input type="text" name="no_id" id="form_no_id" class="form-control" placeholder="Nomor ID"></div>
                                    <div class="col-md-12 mt-4 mb-4"><input type="text" name="catatan" id="form_catatan" class="form-control" placeholder="Catatan Pasien"></div>
                                </div>
                            </div>

                            <div class="col-lg-5 border-start border-dark" style="border-left-width: 2px !important;">
                                <div class="row g-3 mb-4">
                                    <div class="col-12 mt-4">
                                        <label class="text-dark fw-bold mb-2" style="font-size: 1.1rem;">Alamat Lengkap</label>
                                        <textarea name="alamat" id="form_alamat" class="form-control" rows="4" placeholder="Masukkan alamat lengkap..." required></textarea>
                                        <span class="req-field">Harus diisi !</span>
                                    </div>
                                </div>

                                <h6 class="fw-bolder mb-3 mt-5 text-dark">Ambil Foto Pasien</h6>
                                <div class="text-center">
                                    <div class="camera-box shadow-sm mb-3" id="camera-container">
                                        <i class="fas fa-camera fa-3x text-dark opacity-25" id="camera-placeholder"></i>
                                        <video id="video-stream" autoplay playsinline style="display: none;"></video>
                                        <img id="photo-result" src="" style="display: none;">
                                    </div>
                                    <canvas id="canvas-capture" style="display: none;"></canvas>
                                    <input type="hidden" name="patient_photo_base64" id="patient_photo_base64">

                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-light btn-sm fw-bold" id="btn-open-cam" onclick="startCamera()"><i class="fas fa-video me-1"></i> Buka Kamera</button>
                                        <button type="button" class="btn btn-primary btn-sm fw-bold shadow" id="btn-capture" style="display:none;" onclick="capturePhoto()"><i class="fas fa-camera me-1"></i> Jepret</button>
                                        <button type="button" class="btn btn-warning btn-sm fw-bold text-dark" id="btn-retake" style="display:none;" onclick="retakePhoto()"><i class="fas fa-redo me-1"></i> Ulangi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-white border-top border-dark p-3 justify-content-between" style="border-top-width: 2px !important;">
                    <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal" onclick="stopCamera()">Batal</button>
                    <button type="button" class="btn btn-success px-5 fw-bold shadow-sm" onclick="simpanDataPasien()">
                        Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CETAK KARTU MEMBER -->
    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: transparent; border: none;">
                <div class="modal-body p-0">
                    <div class="member-card-container">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h5 class="mb-0 fw-bolder" style="letter-spacing: 1px;">PRAMITA LAB</h5>
                                <small class="fw-bold" style="opacity: 0.8; font-size: 0.75rem;">MEMBER CARD IDENTITY</small>
                            </div>
                            <i class="fas fa-heartbeat fa-2x text-dark opacity-75"></i>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="member-card-photo">
                                <i class="fas fa-user-tie fa-2x text-dark opacity-50"></i>
                            </div>
                            <div>
                                <h6 class="fw-bolder mb-1 text-uppercase text-dark">Bambang Junaidi</h6>
                                <div class="d-flex align-items-center gap-2 mb-1 fw-bold text-dark" style="font-size: 0.85rem;">
                                    <i class="fas fa-qrcode"></i> <span>PID: P-1002</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn btn-light fw-bold px-4 shadow" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-success fw-bold px-4 shadow" onclick="Swal.fire({icon: 'success', title: 'Sedang Memproses', text: 'Mencetak Kartu ke Printer PVC...', showConfirmButton: false, timer: 1500})">
                            <i class="fas fa-print me-2"></i> Print Kartu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL LAPORAN KEUANGAN / BELUM DILAPORKAN -->
    <div class="modal fade" id="modalLaporanPendaftaran" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 95%;">
            <div class="modal-content" style="border-radius: 12px; border: 3px solid var(--retro-dark); box-shadow: var(--retro-shadow); overflow: hidden;">

                <!-- HEADER MODAL -->
                <div class="modal-header text-dark" style="background: var(--retro-yellow); padding: 20px 25px; border-bottom: 3px solid var(--retro-dark);">
                    <h5 class="modal-title fw-bolder d-flex align-items-center" style="letter-spacing: 0.5px;">
                        <i class="fas fa-file-invoice-dollar me-3 fa-lg"></i> Rekap Transaksi Belum Dilaporkan ke Accounting
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- BODY MODAL -->
                <div class="modal-body p-4" style="background-color: var(--retro-bg);">
                    <div class="bg-white shadow-sm" style="border-radius: 8px; border: 2px solid var(--retro-dark); overflow: hidden;">
                        <div style="max-height: 60vh; overflow-y: auto; overflow-x: hidden;">
                            <table class="table table-hover align-middle mb-0 table-custom" id="tableLaporan" style="display: none; width: 100%; font-size: 0.9rem;">
                                <thead class="sticky-top" style="z-index: 2;">
                                    <tr>
                                        <th class="text-center" style="width: 5%; padding: 14px;">
                                            <input type="checkbox" id="selectAllCheckbox" class="form-check-input shadow-sm border-2 border-dark" style="cursor: pointer; transform: scale(1.2);" onclick="toggleSelectAll(this)">
                                        </th>
                                        <th class="small fw-bold" style="width: 14%;">TGL REGISTRASI</th>
                                        <th class="small fw-bold" style="width: 16%;">NO. REGISTRASI</th>
                                        <th class="small fw-bold text-start" style="width: 20%;">NAMA PASIEN (PID)</th>
                                        <th class="small fw-bold" style="width: 15%;">JENIS LAYANAN</th>
                                        <th class="small fw-bold" style="width: 10%;">DOKTER</th>
                                        <th class="small fw-bold text-center" style="width: 5%;">METODE</th>
                                        <th class="small fw-bold text-end" style="width: 15%; padding-right: 20px;">TOTAL TAGIHAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>

                        <div id="laporanLoading" class="text-center py-5">
                            <div class="spinner-border text-dark mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
                            <h6 class="text-dark fw-bold">Menyiapkan data transaksi...</h6>
                        </div>

                        <div id="laporanKosong" class="text-center py-5" style="display: none;">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                                <i class="fas fa-check-double fa-2x text-success"></i>
                            </div>
                            <h4 class="text-dark fw-bolder mb-1">Semua Bersih!</h4>
                            <p class="text-dark fw-bold mb-0 opacity-75">Seluruh transaksi pendaftaran Anda sudah dilaporkan ke bagian keuangan.</p>
                        </div>
                    </div>
                </div>

                <!-- FOOTER MODAL -->
                <div class="modal-footer bg-white border-top border-dark p-4 d-flex justify-content-between align-items-center" style="border-top-width: 2px !important;">
                    <div class="d-flex align-items-center gap-4">
                        <div class="bg-white rounded-3 px-3 py-2" style="border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                            <span class="text-dark small fw-bold d-block mb-1 text-uppercase">Total Dipilih</span>
                            <span class="fw-bolder text-dark fs-5"><span id="selectedCount">0</span> <small class="text-dark fs-6 fw-normal">Transaksi</small></span>
                        </div>
                        <div>
                            <span class="text-dark small fw-bold d-block mb-1 text-uppercase">Total Setoran</span>
                            <span id="totalPendapatanShift" class="fw-bolder text-dark fs-3">Rp 0</span>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-light px-4 py-2 fw-bold" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="button" class="btn btn-success px-5 py-2 fw-bold shadow-sm d-flex align-items-center gap-2" id="btnKirimLaporan" onclick="kirimLaporanKeAccounting()" disabled>
                            <i class="fas fa-paper-plane"></i> Buat Nota Laporan
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL PILIH NOTA LAPORAN UNTUK DICETAK -->
    <div class="modal fade" id="modalCetakSetoran" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: 3px solid var(--retro-dark); box-shadow: var(--retro-shadow); overflow: hidden;">
                <div class="modal-header text-dark" style="background: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark); padding: 20px 25px;">
                    <h5 class="modal-title fw-bolder d-flex align-items-center">
                        <i class="fas fa-print me-3 fa-lg"></i> Cetak Nota Setoran Laporan Keuangan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <p class="text-dark fw-bold mb-3">Pilih nomor nota laporan setoran yang ingin dicetak untuk diserahkan ke bagian keuangan:</p>

                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                        <select id="selectNoLaporan" class="form-select fw-bold">
                            <option value="" disabled selected>Memuat daftar nota laporan...</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top border-dark p-3" style="border-top-width: 2px !important;">
                    <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary px-4 fw-bold shadow-sm" onclick="prosesPrintLaporan()">
                        <i class="fas fa-print me-1"></i> Cetak Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL SIMULASI ANTRIAN -->
    <div class="modal fade" id="modalAntrian" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: 3px solid var(--retro-dark); box-shadow: var(--retro-shadow); overflow: hidden;">
                <div class="modal-header text-dark" style="background: var(--retro-orange); border-bottom: 3px solid var(--retro-dark); padding: 20px 25px;">
                    <h5 class="modal-title fw-bolder d-flex align-items-center">
                        <i class="fas fa-bullhorn me-3 fa-lg"></i> Panggil Antrian Pendaftaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="table-responsive border-2 border-dark rounded-3 overflow-hidden shadow-sm">
                        <table class="table table-hover table-custom mb-0 text-center align-middle">
                            <thead>
                                <tr>
                                    <th>NO. ANTRIAN</th>
                                    <th>POLI TUJUAN</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="fw-bolder fs-5 text-dark">A-001</span></td>
                                    <td class="fw-bold">Poli Umum</td>
                                    <td><span class="badge bg-warning text-dark border border-dark px-2 py-1 shadow-sm">Menunggu</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary fw-bold shadow-sm" onclick="simulasiPanggilAntrian('A-001')">
                                            <i class="fas fa-volume-up me-1"></i> Panggil
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="fw-bolder fs-5 text-dark">B-012</span></td>
                                    <td class="fw-bold">Poli Gigi</td>
                                    <td><span class="badge bg-warning text-dark border border-dark px-2 py-1 shadow-sm">Menunggu</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary fw-bold shadow-sm" onclick="simulasiPanggilAntrian('B-012')">
                                            <i class="fas fa-volume-up me-1"></i> Panggil
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top border-dark p-3" style="border-top-width: 2px !important;">
                    <button type="button" class="btn btn-light px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- JQuery & Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2-init').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            $('#input_dokter').select2({
                theme: 'bootstrap-5',
                placeholder: 'Ketik nama atau pilih dokter pengirim...',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ url('/master/doctors-json') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                }
            });

            $('#input_pemeriksaan').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Sub Penjamin Dulu...',
                width: '100%'
            });

            toggleJenisLayanan();
            loadPenjaminUtama();
        });

        let orderItems = [];
        let pasienAktif = null;
        let dataPencarianGlobal = [];
        let stream = null;
        let totalTagihanGlobal = 0;

        function tampilkanDataProfil(dataPasien) {
            pasienAktif = dataPasien;

            document.getElementById('displayNama').value = `${pasienAktif.title || ''} ${pasienAktif.awalan || ''} ${pasienAktif.nama || ''} ${pasienAktif.akhiran || ''}`.trim();
            document.getElementById('displayPid').value = pasienAktif.pid || '-';
            document.getElementById('displayJk').value = (pasienAktif.jk === 'L' ? 'Laki-Laki' : (pasienAktif.jk === 'P' ? 'Perempuan' : '-'));
            document.getElementById('displayNik').value = pasienAktif.no_id || '-';
            document.getElementById('displayAgama').value = pasienAktif.agama || '-';

            let tempatLahir = pasienAktif.tempat_lahir ? pasienAktif.tempat_lahir + ', ' : '';
            let tglLahir = pasienAktif.tgl_lahir || '-';
            let umur = pasienAktif.umur ? ` (${pasienAktif.umur} Thn)` : '';
            document.getElementById('displayTglLahir').value = `${tempatLahir}${tglLahir}${umur}`;

            let pekerjaan = pasienAktif.pekerjaan || '-';
            let nip = pasienAktif.nip ? ` (NIP: ${pasienAktif.nip})` : '';
            document.getElementById('displayPekerjaan').value = `${pekerjaan}${nip}`;

            document.getElementById('displayNoHp').value = pasienAktif.no_hp || '-';
            document.getElementById('displayEmail').value = pasienAktif.email || '-';
            document.getElementById('displayAlamat').value = pasienAktif.alamat || '-';
            document.getElementById('displayCatatan').value = pasienAktif.catatan || '-';

            if (pasienAktif.foto) {
                document.getElementById('displayIcon').style.display = 'none';
                document.getElementById('displayFoto').style.display = 'block';
                document.getElementById('displayFoto').src = pasienAktif.foto;
            } else {
                document.getElementById('displayFoto').style.display = 'none';
                document.getElementById('displayIcon').style.display = 'block';
            }
        }

        function toggleJenisLayanan() {
            const layanan = document.getElementById('input_jenis_layanan').value;
            const wrapRajal = document.getElementById('wrapper_rawat_jalan');
            const wrapIgd = document.getElementById('wrapper_igd');
            const wrapRanap = document.getElementById('wrapper_rawat_inap');

            wrapRajal.style.display = 'none';
            wrapIgd.style.display = 'none';
            wrapRanap.style.display = 'none';

            if (layanan === 'RAWAT_JALAN') {
                wrapRajal.style.display = 'block';
            } else if (layanan === 'IGD') {
                wrapIgd.style.display = 'block';
                $('#input_poli_id').val('').trigger('change');
                document.getElementById('input_doctor_poli').innerHTML = '<option value="" disabled selected>Pilih Poli & Tanggal Terlebih Dahulu...</option>';
                $('#input_ruangan_id').val('').trigger('change');
                loadDokterIgd();
            } else if (layanan === 'RAWAT_INAP') {
                wrapRanap.style.display = 'block';
                $('#input_poli_id').val('').trigger('change');
                document.getElementById('input_doctor_poli').innerHTML = '<option value="" disabled selected>Pilih Poli & Tanggal Terlebih Dahulu...</option>';
                $('#input_doctor_igd').val('').trigger('change');
            }

            muatTarifOtomatisPoli();
        }

        function loadBedTersedia() {
            const ruanganId = document.getElementById('input_ruangan_id').value;
            const selectBed = document.getElementById('input_bed_id');

            selectBed.innerHTML = '<option value="" disabled selected>Memuat daftar bed tersedia...</option>';
            $('#input_bed_id').trigger('change');

            if (!ruanganId) {
                selectBed.innerHTML = '<option value="" disabled selected>Pilih Ruangan Terlebih Dahulu...</option>';
                $('#input_bed_id').trigger('change');
                return;
            }

            fetch(`/ruangan/bed-tersedia/${ruanganId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    selectBed.innerHTML = '<option value="" disabled selected>Pilih Bed Tersedia...</option>';
                    if (data.success && data.data.length > 0) {
                        data.data.forEach(bed => {
                            const opt = document.createElement('option');
                            opt.value = bed.id;
                            if (bed.status === 'TERSEDIA') {
                                opt.text = `${bed.nomor_bed} — [TERSEDIA]`;
                            } else {
                                opt.text = `${bed.nomor_bed} — [${bed.status}]`;
                                opt.disabled = true;
                            }
                            selectBed.appendChild(opt);
                        });
                    } else {
                        selectBed.innerHTML = '<option value="" disabled selected>Tidak ada bed yang tersedia di ruangan ini</option>';
                    }
                    $('#input_bed_id').trigger('change');
                })
                .catch(err => {
                    selectBed.innerHTML = `
                    <option value="" disabled selected>Pilih Bed (Contoh Dummy)</option>
                    <option value="1">Bed 01 — [TERSEDIA]</option>
                    <option value="2">Bed 02 — [TERSEDIA]</option>
                `;
                    $('#input_bed_id').trigger('change');
                });
        }

        // --- 4. UPDATE FUNGSI FETCH JADWAL DOKTER RAWAT JALAN ---
        function loadDokterBerjadwal() {
            const poliId = document.getElementById('input_poli_id').value;
            const tanggalPeriksa = document.getElementById('input_tanggal_periksa').value;
            const selectDokterPoli = document.getElementById('input_doctor_poli');

            selectDokterPoli.innerHTML = '<option value="" disabled selected>Memuat dokter berjadwal...</option>';
            $('#input_doctor_poli').trigger('change');

            if (!poliId || !tanggalPeriksa) {
                selectDokterPoli.innerHTML = '<option value="" disabled selected>Pilih Poli & Tanggal Terlebih Dahulu...</option>';
                $('#input_doctor_poli').trigger('change');
                return;
            }

            // Pastikan URL mengarah ke Route Controller yang benar
            fetch(`/poli/dokter-berjadwal?poli_id=${poliId}&tanggal=${tanggalPeriksa}`)
                .then(response => response.json())
                .then(res => {
                    selectDokterPoli.innerHTML = '<option value="" disabled selected>Pilih Dokter Pemeriksa...</option>';
                    if (res.success && res.data.length > 0) {
                        res.data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.doctor_id;

                            // Format Jam Mulai dan Jam Selesai (Hanya ambil HH:MM)
                            let tStart = item.time_start ? item.time_start.substring(0, 5) : '00:00';
                            let tEnd = item.time_end ? item.time_end.substring(0, 5) : '00:00';
                            let quota = item.quota || 0;

                            // PERBAIKAN DI SINI: Gunakan item.nama_lengkap (bukan item.nama_dokter)
                            let namaDokter = item.nama_lengkap || item.nama_dokter || 'Nama Dokter Tidak Diketahui';

                            opt.text = `${namaDokter} (${tStart} - ${tEnd} | Kuota: ${quota})`;
                            selectDokterPoli.appendChild(opt);
                        });
                    } else {
                        selectDokterPoli.innerHTML = `<option value="" disabled selected>Tidak ada jadwal dokter hari ${res.hari || 'ini'}</option>`;
                    }
                    $('#input_doctor_poli').trigger('change');
                })
                .catch(err => {
                    selectDokterPoli.innerHTML = `
                <option value="" disabled selected>Gagal memuat jadwal...</option>
            `;
                    $('#input_doctor_poli').trigger('change');
                });
        }

        function loadDokterIgd() {
            const tanggalPeriksa = document.getElementById('input_tanggal_periksa').value;
            const selectDokterIgd = document.getElementById('input_doctor_igd');

            selectDokterIgd.innerHTML = '<option value="" disabled selected>Memuat dokter jaga IGD...</option>';
            $('#input_doctor_igd').trigger('change');

            if (!tanggalPeriksa) {
                selectDokterIgd.innerHTML = '<option value="" disabled selected>Pilih Tanggal Periksa Terlebih Dahulu...</option>';
                $('#input_doctor_igd').trigger('change');
                return;
            }

            fetch(`/igd/dokter-jaga?tanggal=${tanggalPeriksa}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    selectDokterIgd.innerHTML = '<option value="" disabled selected>Pilih Dokter Jaga IGD...</option>';
                    if (res.success && res.data.length > 0) {
                        res.data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.doctor_id;
                            opt.text = `${item.nama_lengkap} (Shift: ${item.shift} | ${item.jam_mulai} - ${item.jam_selesai})`;
                            selectDokterIgd.appendChild(opt);
                        });
                    } else {
                        selectDokterIgd.innerHTML = '<option value="" disabled selected>Tidak ada dokter jaga IGD pada tanggal ini</option>';
                    }
                    $('#input_doctor_igd').trigger('change');
                })
                .catch(err => {
                    selectDokterIgd.innerHTML = '<option value="" disabled selected>Gagal memuat data dokter jaga</option>';
                    $('#input_doctor_igd').trigger('change');
                });
        }

        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const clockEl = document.getElementById('realtimeClock');
            if (clockEl) clockEl.innerText = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        function konfirmasiReset() {
            Swal.fire({
                title: 'Mulai Registrasi Baru?',
                text: "Semua data yang belum diproses akan hilang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffa6c9',
                cancelButtonColor: '#1e1e24',
                confirmButtonText: 'Ya, Reset Halaman!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) window.location.reload();
            });
        }

        function checkRequired(element) {
            if (!element.value.trim()) {
                element.classList.add('border-danger');
                if (element.nextElementSibling && element.nextElementSibling.classList.contains('req-field')) element.nextElementSibling.style.display = 'block';
                return false;
            } else {
                element.classList.remove('border-danger');
                if (element.nextElementSibling && element.nextElementSibling.classList.contains('req-field')) element.nextElementSibling.style.display = 'none';
                return true;
            }
        }
        document.querySelectorAll('#formPasien [required]').forEach(element => {
            element.addEventListener('input', () => checkRequired(element));
            element.addEventListener('change', () => checkRequired(element));
            element.addEventListener('blur', () => checkRequired(element));
        });

        function nextTab(tabId) {
            var triggerEl = document.getElementById(tabId);
            triggerEl.removeAttribute('disabled');
            var tabInstance = new bootstrap.Tab(triggerEl);
            tabInstance.show();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function prevTab(tabId) {
            var triggerEl = document.getElementById(tabId);
            var tabInstance = new bootstrap.Tab(triggerEl);
            tabInstance.show();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        function cariPasien() {
            const keyword = document.getElementById('searchKeyword').value;
            if (!keyword || keyword.length < 3) return Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Minimal 3 karakter'
            });

            var modalSearch = new bootstrap.Modal(document.getElementById('modalPencarianPasien'));
            modalSearch.show();

            const tbody = document.querySelector('#tableHasilPencarian tbody');
            tbody.innerHTML = '';
            document.getElementById('tableHasilPencarian').style.display = 'none';
            document.getElementById('pencarianKosong').style.display = 'none';
            document.getElementById('pencarianLoading').style.display = 'block';

            fetch(`/pasien/search?q=${keyword}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('pencarianLoading').style.display = 'none';
                    if (data.success && data.data.length > 0) {
                        dataPencarianGlobal = data.data;
                        document.getElementById('tableHasilPencarian').style.display = 'table';
                        data.data.forEach((pasien, index) => {
                            const jk = pasien.jk === 'L' ? 'Laki-laki' : 'Perempuan';
                            const noHp = pasien.no_hp || '-';
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="fw-bold text-dark">${pasien.pid}</td>
                                <td class="text-start fw-bold text-dark">${pasien.nama} <br><small class="text-dark fw-bold opacity-75">${jk} &bull; ${noHp}</small></td>
                                <td>${pasien.tgl_lahir}</td>
                                <td>${pasien.no_id || '-'}</td>
                                <td><button class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm fw-bold" onclick="pilihPasien(${index})">Pilih <i class="fas fa-check ms-1"></i></button></td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        document.getElementById('pencarianKosong').style.display = 'block';
                    }
                })
                .catch(error => {
                    document.getElementById('pencarianLoading').style.display = 'none';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan server.'
                    });
                });
        }

        function pilihPasien(index) {
            // Gunakan fungsi reusable
            tampilkanDataProfil(dataPencarianGlobal[index]);
            bootstrap.Modal.getInstance(document.getElementById('modalPencarianPasien')).hide();
        }

        function resetForm(modalId) {
            document.getElementById('modalPasienTitle').innerHTML = '<i class="fas fa-user-plus me-3 fa-lg"></i> Form Registrasi Pasien Baru';
            document.getElementById('formPasien').reset();
            document.getElementById('form_pasien_id').value = "";
            retakePhoto();
        }

        function populateEditForm() {
            if (!pasienAktif) return Swal.fire({
                icon: 'info',
                title: 'Pilih Pasien'
            });
            document.getElementById('modalPasienTitle').innerHTML = '<i class="fas fa-user-edit me-3 fa-lg"></i> Form Perbarui Data Pasien';
            document.getElementById('form_pasien_id').value = pasienAktif.id;
            ['awalan', 'nama', 'akhiran', 'jk', 'title', 'tempat_lahir', 'umur', 'tgl_lahir', 'agama', 'no_hp', 'email', 'pekerjaan', 'nip', 'tipe_id', 'no_id', 'catatan', 'alamat'].forEach(field => {
                const el = document.getElementById('form_' + field);
                if (el) el.value = pasienAktif[field] || '';
            });
        }

        function simpanDataPasien() {
            let isFormValid = true;
            document.querySelectorAll('#formPasien [required]').forEach(el => {
                if (!checkRequired(el)) isFormValid = false;
            });

            if (!isFormValid) return Swal.fire({
                icon: 'error',
                title: 'Form Tidak Lengkap'
            });

            const formData = new FormData(document.getElementById('formPasien'));
            const idPasien = document.getElementById('form_pasien_id').value;

            fetch(idPasien ? `/pasien/update/${idPasien}` : `/pasien/store`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Menyimpan Data!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    stopCamera();
                    bootstrap.Modal.getInstance(document.getElementById('modalPasien')).hide();

                    // Gunakan fungsi reusable agar seluruh form langsung terisi otomatis
                    tampilkanDataProfil(data.data);
                }
            });
        }

        const video = document.getElementById('video-stream');
        const canvas = document.getElementById('canvas-capture');
        const photoResult = document.getElementById('photo-result');
        const cameraPlaceholder = document.getElementById('camera-placeholder');
        const inputBase64 = document.getElementById('patient_photo_base64');
        const btnOpen = document.getElementById('btn-open-cam');
        const btnCapture = document.getElementById('btn-capture');
        const btnRetake = document.getElementById('btn-retake');

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                });
                video.srcObject = stream;
                video.style.display = 'block';
                cameraPlaceholder.style.display = 'none';
                photoResult.style.display = 'none';
                btnOpen.style.display = 'none';
                btnCapture.style.display = 'inline-block';
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: err.message
                });
            }
        }

        function capturePhoto() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            let data_url = canvas.toDataURL('image/jpeg');
            photoResult.src = data_url;
            inputBase64.value = data_url;
            video.style.display = 'none';
            photoResult.style.display = 'block';
            btnCapture.style.display = 'none';
            btnRetake.style.display = 'inline-block';
        }

        function retakePhoto() {
            inputBase64.value = '';
            video.style.display = 'none';
            photoResult.style.display = 'none';
            cameraPlaceholder.style.display = 'block';
            btnOpen.style.display = 'inline-block';
            btnCapture.style.display = 'none';
            btnRetake.style.display = 'none';
        }

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            retakePhoto();
        }

        function resetRincianOrder() {
            if (orderItems.length > 0) {
                orderItems = [];
                renderTableOrder();
            }
        }

        function loadPenjaminUtama() {
            const selectPenjamin = $('#pilih_penjamin');
            selectPenjamin.html('<option value="" disabled selected>Memuat penjamin...</option>');

            fetch('/penjamin/get-utama', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    selectPenjamin.html('<option value="" disabled selected>Pilih Penjamin...</option>');
                    if (res.success && res.data.length > 0) {
                        res.data.forEach(item => {
                            // Sesuaikan property objek dari database (misal: id / nama_penjamin)
                            const option = new Option(item.nama_penjamin || item.penjamin, item.id || item.penjamin, false, false);
                            selectPenjamin.append(option);
                        });
                    } else {
                        // Fallback jika data kosong
                        selectPenjamin.append(new Option('UMUM / PRIBADI', 'UMUM'));
                        selectPenjamin.append(new Option('BPJS Kesehatan', 'BPJS'));
                    }
                    selectPenjamin.trigger('change');
                })
                .catch(err => {
                    selectPenjamin.html('<option value="" disabled selected>Pilih Penjamin...</option>');
                    selectPenjamin.append(new Option('UMUM / PRIBADI', 'UMUM'));
                    selectPenjamin.append(new Option('BPJS Kesehatan', 'BPJS'));
                    selectPenjamin.trigger('change');
                });
        }

        function toggleSubPenjamin() {
            resetRincianOrder();
            const penjaminId = document.getElementById('pilih_penjamin').value;
            const wrapperSub = document.getElementById('wrapper_sub_penjamin');
            const selectSub = $('#pilih_sub_penjamin');

            // Kosongkan dulu pilihan sub penjamin
            selectSub.html('<option value="" disabled selected>Memuat sub penjamin...</option>').trigger('change');

            if (penjaminId) {
                // Fetch sub penjamin berdasarkan penjamin utama yang dipilih
                fetch(`/penjamin/get-sub?penjamin_id=${penjaminId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        selectSub.html('<option value="" disabled selected>Pilih Sub Penjamin...</option>');
                        if (res.success && res.data.length > 0) {
                            wrapperSub.style.display = 'block';
                            res.data.forEach(sub => {
                                const option = new Option(sub.nama_sub_penjamin, sub.id, false, false);
                                selectSub.append(option);
                            });
                        } else {
                            // Jika tidak ada sub penjamin, sembunyikan wrapper
                            wrapperSub.style.display = 'none';
                        }
                        selectSub.trigger('change');
                    })
                    .catch(err => {
                        wrapperSub.style.display = 'none';
                        selectSub.html('<option value="" disabled selected>Pilih Sub Penjamin...</option>').trigger('change');
                    });
            } else {
                wrapperSub.style.display = 'none';
                selectSub.html('<option value="" disabled selected>Pilih Sub Penjamin...</option>').trigger('change');
                document.getElementById('input_pemeriksaan').innerHTML = '<option value="" disabled selected>Pilih Sub Penjamin Dulu...</option>';
                document.getElementById('input_pemeriksaan').disabled = true;
                $('#input_pemeriksaan').trigger('change');
            }
            muatTarifOtomatisPoli();
        }

        function handleSubPenjaminChange() {
            loadPemeriksaanData();
            muatTarifOtomatisPoli();
        }

        function handlePoliChange() {
            muatTarifOtomatisPoli();
        }

        function muatTarifOtomatisPoli() {
            const jenisLayanan = document.getElementById('input_jenis_layanan').value;
            const poliId = document.getElementById('input_poli_id').value;
            const ruanganId = document.getElementById('input_ruangan_id') ? document.getElementById('input_ruangan_id').value : '';
            const subPenjaminId = document.getElementById('pilih_sub_penjamin').value;

            orderItems = orderItems.filter(item => item.kategori_biaya !== 'ADMINISTRASI' && item.kategori_biaya !== 'JASA_DOKTER' && item.kategori_biaya !== 'KAMAR_INAP' && item.kategori_biaya !== 'KEPERAWATAN');

            if (!subPenjaminId || (jenisLayanan === 'RAWAT_JALAN' && !poliId) || (jenisLayanan === 'RAWAT_INAP' && !ruanganId)) {
                renderTableOrder();
                return;
            }

            fetch(`/tarif/get-otomatis?jenis_layanan=${jenisLayanan}&poli_id=${poliId}&ruangan_id=${ruanganId}&sub_penjamin_id=${subPenjaminId}`)
                .then(res => res.json())
                .then(res => {
                    if (res.success && res.data.length > 0) {
                        res.data.forEach(tarifItem => {
                            orderItems.push({
                                id: 'tarif_' + tarifItem.id,
                                nama_layanan: tarifItem.nama_tarif,
                                harga_dasar: parseFloat(tarifItem.tarif),
                                diskon: 0,
                                is_cito: 0,
                                biaya_cito: 0,
                                harga_akhir: parseFloat(tarifItem.tarif),
                                harga_akhir_normal: parseFloat(tarifItem.tarif),
                                kategori_biaya: tarifItem.kategori_biaya,
                                is_paket: 0
                            });
                        });
                    }
                    renderTableOrder();
                });
        }

        function loadPemeriksaanData() {
            const subPenjaminId = document.getElementById('pilih_sub_penjamin').value;
            const inputPemeriksaan = document.getElementById('input_pemeriksaan');

            inputPemeriksaan.innerHTML = '<option value="" disabled selected>Memuat data...</option>';
            inputPemeriksaan.disabled = true;
            $('#input_pemeriksaan').trigger('change');

            if (subPenjaminId) {
                fetch(`/pemeriksaan/by-sub-penjamin/${subPenjaminId}`).then(res => res.json()).then(res => {
                    inputPemeriksaan.innerHTML = '<option value="" disabled selected>Pilih Pemeriksaan / Layanan...</option>';
                    if (res.success && res.data.length > 0) {
                        inputPemeriksaan.disabled = false;
                        res.data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            item.kategori_biaya = item.kategori_biaya || 'TINDAKAN';
                            option.setAttribute('data-obj', JSON.stringify(item));
                            option.text = `${item.kode_layanan} - ${item.nama_layanan} (Rp ${parseFloat(item.harga_akhir).toLocaleString('id-ID')})`;
                            inputPemeriksaan.appendChild(option);
                        });
                        $('#input_pemeriksaan').trigger('change');
                    }
                });
            }
        }

        function tambahKeOrder() {
            const select = document.getElementById('input_pemeriksaan');
            if (!select.value) return Swal.fire({
                icon: 'warning',
                text: 'Pilih layanan terlebih dahulu!'
            });

            const selectedOption = select.options[select.selectedIndex];
            const dataObj = JSON.parse(selectedOption.getAttribute('data-obj'));

            if (orderItems.some(item => String(item.id) === String(dataObj.id))) {
                return Swal.fire({
                    icon: 'error',
                    text: 'Sudah ada dalam rincian!'
                });
            }

            dataObj.is_cito = 0;
            dataObj.biaya_cito = 0;
            dataObj.kategori_biaya = dataObj.kategori_biaya || 'TINDAKAN';
            dataObj.harga_akhir_normal = dataObj.harga_akhir;
            orderItems.push(dataObj);
            renderTableOrder();
            $('#input_pemeriksaan').val('').trigger('change');
        }

        function hapusOrder(id) {
            orderItems = orderItems.filter(item => String(item.id) !== String(id));
            renderTableOrder();
        }

        function toggleCito(id, isChecked) {
            let item = orderItems.find(x => String(x.id) === String(id));
            if (item) {
                if (isChecked) {
                    item.is_cito = 1;
                    item.biaya_cito = parseFloat(item.harga_dasar) * 0.25;
                    item.harga_akhir = (parseFloat(item.harga_dasar) - parseFloat(item.diskon)) + item.biaya_cito;
                } else {
                    item.is_cito = 0;
                    item.biaya_cito = 0;
                    item.harga_akhir = parseFloat(item.harga_akhir_normal);
                }
                renderTableOrder();
            }
        }

        function renderTableOrder() {
            const tbody = document.querySelector('#tabel_order_tindakan tbody');
            tbody.innerHTML = '';
            let totalHarga = 0;

            orderItems.forEach(item => {
                const hargaDasar = parseFloat(item.harga_dasar) || 0;
                const diskon = parseFloat(item.diskon) || 0;
                const hargaAkhir = parseFloat(item.harga_akhir) || 0;
                totalHarga += hargaAkhir;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><div class="form-check d-flex justify-content-center m-0"><input class="form-check-input border-2 border-dark" type="checkbox" onchange="toggleCito('${item.id}', this.checked)" ${item.is_cito == 1 ? 'checked' : ''} ${item.kategori_biaya === 'ADMINISTRASI' || item.kategori_biaya === 'JASA_DOKTER' ? 'disabled' : ''}></div></td>
                    <td class="text-start fw-bold text-dark">
                        ${item.nama_layanan}
                        ${item.kategori_biaya === 'ADMINISTRASI' ? '<span class="badge bg-secondary ms-2">ADMINISTRASI</span>' : ''}
                        ${item.is_cito == 1 ? '<span class="badge bg-danger ms-1">CITO</span>' : ''}
                    </td>
                    <td>${hargaDasar.toLocaleString('id-ID')}</td>
                    <td>${diskon > 0 ? '-' + diskon.toLocaleString('id-ID') : '-'}</td>
                    <td class="fw-bold text-dark">${hargaAkhir.toLocaleString('id-ID')} ${item.is_cito == 1 ? `<br><small class="text-danger fw-bold">+Rp ${item.biaya_cito.toLocaleString('id-ID')}</small>` : ''}</td>
                    <td><button class="btn btn-light text-danger shadow-sm rounded-circle fw-bold" onclick="hapusOrder('${item.id}')"><i class="fas fa-trash-alt"></i></button></td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('estimasi_total').innerText = 'Rp ' + totalHarga.toLocaleString('id-ID');
            document.getElementById('badge_order_count').innerHTML = `<i class="fas fa-vial me-1"></i> ${orderItems.length} Item Dipilih`;
        }

        function prosesKePembayaran() {
            if (!pasienAktif) return Swal.fire({
                icon: 'error',
                text: 'Pilih pasien pada Tahap 1 terlebih dahulu.'
            }).then(() => prevTab('tab-demografi'));
            if (orderItems.length === 0) return Swal.fire({
                icon: 'warning',
                text: 'Tambahkan minimal 1 pemeriksaan.'
            });

            renderInvoice();
            nextTab('tab-pembayaran');
        }

        function updateBayarDisplay() {
            const method = document.querySelector('input[name="payment_method"]:checked').value;
            document.getElementById('invoice-metode-bayar').innerText = method;
        }

        function renderInvoice() {
            const now = new Date();
            const invNo = `REG-${now.getFullYear()}${(now.getMonth()+1).toString().padStart(2,'0')}${now.getDate().toString().padStart(2,'0')}-${Math.floor(Math.random() * 1000).toString().padStart(4,'0')}`;
            const timeStrFull = `${now.getDate().toString().padStart(2,'0')}-${(now.getMonth()+1).toString().padStart(2,'0')}-${now.getFullYear()} ${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}:${now.getSeconds().toString().padStart(2,'0')}`;

            document.getElementById('invoice-no').innerText = invNo;
            document.getElementById('invoice-noreg').innerText = invNo;
            document.getElementById('invoice-date').innerText = timeStrFull;
            document.getElementById('invoice-now').innerText = timeStrFull;

            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            document.getElementById('invoice-print-date').innerText = `${now.getDate().toString().padStart(2,'0')} ${monthNames[now.getMonth()]} ${now.getFullYear()} ${now.getHours().toString().padStart(2,'0')}.${now.getMinutes().toString().padStart(2,'0')}`;

            document.getElementById('invoice-pasien').innerText = `Sdr ${pasienAktif.nama}`;
            document.getElementById('invoice-ttd-pasien').innerText = `Sdr ${pasienAktif.nama}`;
            document.getElementById('invoice-pid').innerText = pasienAktif.pid;
            const jk = pasienAktif.jk === 'L' ? 'L' : 'P';
            document.getElementById('invoice-umur').innerText = `${pasienAktif.umur || '-'} tahun / ${jk}`;
            document.getElementById('invoice-alamat').innerText = pasienAktif.alamat || '-';

            const pengirimText = $("#input_dokter option:selected").text();
            document.getElementById('invoice-pengirim').innerText = (pengirimText && pengirimText !== 'Pilih atau Cari Dokter Pengirim...') ? pengirimText : '-';

            const kelPelangganText = $("#pilih_sub_penjamin option:selected").text();
            document.getElementById('invoice-kel-pelanggan').innerText = (kelPelangganText && kelPelangganText !== 'Pilih Sub Penjamin...') ? kelPelangganText : 'PASIEN UMUM REGULER';

            document.getElementById('invoice-wa').innerText = pasienAktif.no_hp || '-';
            document.getElementById('invoice-wa-2').innerText = pasienAktif.no_hp || '-';
            document.getElementById('invoice-kasir-footer').innerText = '{{ Auth::user()->name ?? "Petugas Kasir" }}';
            document.getElementById('invoice-ttd-kasir').innerText = '{{ Auth::user()->name ?? "Petugas Kasir" }}';

            const tbody = document.getElementById('invoice-table-body');
            tbody.innerHTML = '';
            totalTagihanGlobal = 0;
            let totalBruto = 0;
            let totalDiskon = 0;

            orderItems.forEach(item => {
                const hargaDasar = parseFloat(item.harga_dasar) || 0;
                const diskon = parseFloat(item.diskon) || 0;
                const hargaAkhir = parseFloat(item.harga_akhir) || 0;
                totalTagihanGlobal += hargaAkhir;
                totalBruto += hargaDasar;
                totalDiskon += diskon;

                tbody.innerHTML += `<tr>
                    <td class="text-start py-1">${item.nama_layanan}</td>
                    <td class="text-end py-1">${hargaDasar.toLocaleString('id-ID')}</td>
                    <td class="text-end py-1">${diskon > 0 ? diskon.toLocaleString('id-ID') : '0'}</td>
                    <td class="text-end py-1">${hargaAkhir.toLocaleString('id-ID')}</td>
                </tr>`;
            });

            const formattedTotal = totalTagihanGlobal.toLocaleString('id-ID');
            document.getElementById('invoice-subtotal-bruto').innerText = totalBruto.toLocaleString('id-ID');
            document.getElementById('invoice-subtotal-diskon').innerText = totalDiskon > 0 ? totalDiskon.toLocaleString('id-ID') : '0';
            document.getElementById('invoice-subtotal').innerText = formattedTotal;
            document.getElementById('invoice-grandtotal').innerText = formattedTotal;
            document.getElementById('invoice-total-pembayaran').innerText = formattedTotal;
            document.getElementById('invoice-total-bayar').innerText = formattedTotal;
            document.getElementById('tagihan-akhir-display').innerText = 'Rp ' + formattedTotal;
            updateBayarDisplay();
        }

        function prosesBayar() {
            const method = document.querySelector('input[name="payment_method"]:checked').value;
            const formattedTagihan = totalTagihanGlobal.toLocaleString('id-ID');

            if (method === 'Cash') {
                Swal.fire({
                    title: 'Pembayaran Tunai',
                    html: `
                        <h3 class="text-dark fw-bold mb-3">Rp ${formattedTagihan}</h3>
                        <label class="form-label fw-bold">Nominal Uang Pasien</label>
                        <div class="input-group input-group-lg mb-2">
                            <span class="input-group-text fw-bold">Rp</span>
                            <input type="text" id="uang_pasien_formatted" class="form-control fw-bold text-center fs-4" placeholder="0" autocomplete="off">
                        </div>
                        <input type="hidden" id="uang_pasien" value="0">
                        <small id="info_kembalian" class="text-dark fw-bold">Kembalian: Rp 0</small>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Bayar',
                    confirmButtonColor: '#c1ff72',
                    cancelButtonColor: '#1e1e24',
                    didOpen: () => {
                        const inputFormatted = document.getElementById('uang_pasien_formatted');
                        const inputHidden = document.getElementById('uang_pasien');
                        const infoKembalian = document.getElementById('info_kembalian');

                        inputFormatted.addEventListener('input', function(e) {
                            let angka = this.value.replace(/[^0-9]/g, '');
                            if (angka) {
                                let parsedAngka = parseInt(angka, 10);
                                inputHidden.value = parsedAngka;
                                this.value = parsedAngka.toLocaleString('id-ID');
                                let kembalian = parsedAngka - totalTagihanGlobal;
                                if (kembalian >= 0) {
                                    infoKembalian.innerHTML = `Kembalian: <span class="text-success fw-bold">Rp ${kembalian.toLocaleString('id-ID')}</span>`;
                                } else {
                                    infoKembalian.innerHTML = `Uang pasien kurang Rp ${Math.abs(kembalian).toLocaleString('id-ID')}`;
                                }
                            } else {
                                inputHidden.value = 0;
                                this.value = '';
                                infoKembalian.innerHTML = 'Kembalian: Rp 0';
                            }
                        });
                    },
                    preConfirm: () => {
                        const uang = parseInt(document.getElementById('uang_pasien').value) || 0;
                        if (uang < totalTagihanGlobal) {
                            Swal.showValidationMessage('Uang pasien kurang!');
                        }
                        return uang;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const kembalian = result.value - totalTagihanGlobal;
                        Swal.fire({
                            icon: 'success',
                            title: 'LUNAS',
                            html: `<h5>Kembalian: <b>Rp ${kembalian.toLocaleString('id-ID')}</b></h5>`,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => cetakNotaResmi());
                    }
                });
            } else if (method === 'QRIS') {
                Swal.fire({
                    title: 'Scan QRIS',
                    html: `<h4 class="text-dark fw-bold mb-3">Rp ${formattedTagihan}</h4><i class="fas fa-qrcode fa-5x mb-3"></i>`,
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi Sukses',
                    confirmButtonColor: '#8bf0fa'
                }).then((res) => {
                    if (res.isConfirmed) cetakNotaResmi();
                });
            } else if (method === 'EDC') {
                Swal.fire({
                    title: 'Memuat Mesin EDC...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('/master/edc-list', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        let optionsHtml = '<option value="" disabled selected>Pilih Mesin / Bank EDC...</option>';
                        if (res.success && res.data.length > 0) {
                            res.data.forEach(item => {
                                optionsHtml += `<option value="${item.id}">${item.nama_bank} — Rek: ${item.no_rekening || '-'} (${item.nama_pemilik || 'EDC Utama'})</option>`;
                            });
                        } else {
                            optionsHtml += '<option value="BCA">BCA — 1234567890</option><option value="Mandiri">Mandiri — 0987654321</option>';
                        }

                        Swal.fire({
                            title: 'Mesin EDC',
                            html: `
                            <div class="text-start mb-3">
                                <label class="form-label fw-bold small text-uppercase">Pilih Bank / Mesin EDC</label>
                                <select id="edc_bank_id" class="form-select mb-3">${optionsHtml}</select>
                                <label class="form-label fw-bold small text-uppercase">Nomor Approval / Trace Number</label>
                                <input type="text" id="edc_approval" class="form-control" placeholder="Masukkan No Approval">
                            </div>
                        `,
                            showCancelButton: true,
                            confirmButtonText: 'Proses Pembayaran',
                            confirmButtonColor: '#8bf0fa',
                            preConfirm: () => {
                                const edcId = document.getElementById('edc_bank_id').value;
                                const approval = document.getElementById('edc_approval').value;
                                if (!edcId) {
                                    Swal.showValidationMessage('Silakan pilih Bank / Mesin EDC!');
                                    return false;
                                }
                                if (!approval.trim()) {
                                    Swal.showValidationMessage('Nomor Approval wajib diisi!');
                                    return false;
                                }
                                return {
                                    edc_id: edcId,
                                    edc_bank_text: document.getElementById('edc_bank_id').options[document.getElementById('edc_bank_id').selectedIndex].text,
                                    approval: approval
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.currentEdcData = result.value;
                                cetakNotaResmi();
                            }
                        });
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal memuat daftar mesin EDC dari server.'
                        });
                    });
            } else if (method === 'Piutang') {
                Swal.fire({
                    title: 'Piutang Perusahaan',
                    html: `<h4 class="text-dark fw-bold mb-3">Rp ${formattedTagihan}</h4><p class="text-dark">Transaksi ini akan dicatat sebagai piutang instansi/perusahaan.</p>`,
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi Piutang',
                    confirmButtonColor: '#ffde59'
                }).then((res) => {
                    if (res.isConfirmed) cetakNotaResmi();
                });
            }
        }

        function cetakNotaResmi() {
            const subPenjaminId = document.getElementById('pilih_sub_penjamin').value ? parseInt(document.getElementById('pilih_sub_penjamin').value) : null;
            const jenisLayanan = document.getElementById('input_jenis_layanan').value;
            const tipeFppId = document.getElementById('tipe_fpp_id').value ? parseInt(document.getElementById('tipe_fpp_id').value) : null;
            const rawDokterPengirim = document.getElementById('input_dokter').value;
            const dokterPengirimId = rawDokterPengirim ? parseInt(rawDokterPengirim) : null;

            let poliId = null;
            let dokterPemeriksaId = null;
            let ruanganId = null;
            let bedId = null;
            let dokterIgdId = null;

            if (jenisLayanan === 'RAWAT_JALAN') {
                poliId = document.getElementById('input_poli_id').value ? parseInt(document.getElementById('input_poli_id').value) : null;
                dokterPemeriksaId = document.getElementById('input_doctor_poli').value ? parseInt(document.getElementById('input_doctor_poli').value) : null;
            } else if (jenisLayanan === 'IGD') {
                dokterIgdId = document.getElementById('input_doctor_igd').value ? parseInt(document.getElementById('input_doctor_igd').value) : null;
                dokterPemeriksaId = document.getElementById('input_doctor_igd').value ? parseInt(document.getElementById('input_doctor_igd').value) : null;
            } else if (jenisLayanan === 'RAWAT_INAP') {
                ruanganId = document.getElementById('input_ruangan_id').value ? parseInt(document.getElementById('input_ruangan_id').value) : null;
                bedId = document.getElementById('input_bed_id').value ? parseInt(document.getElementById('input_bed_id').value) : null;
            }

            const tanggalPeriksa = document.getElementById('input_tanggal_periksa').value || null;
            const bahasaHasilArray = Array.from(document.querySelectorAll('input[name="bahasa_hasil[]"]:checked')).map(cb => cb.value);
            const pengirimanArray = Array.from(document.querySelectorAll('input[name="pengiriman[]"]:checked')).map(cb => cb.value);
            const isCitoGlobal = orderItems.some(item => item.is_cito == 1) || jenisLayanan === 'IGD' ? 1 : 0;

            const payload = {
                pasien_id: pasienAktif.id,
                jenis_layanan: jenisLayanan,
                poli_id: poliId,
                ruangan_id: ruanganId,
                bed_id: bedId,
                sub_penjamin_id: subPenjaminId,
                tipe_fpp_id: tipeFppId,
                doctor_id: dokterPengirimId,
                doctor_poli_id: dokterPemeriksaId,
                doctor_igd_id: dokterIgdId,
                tanggal_periksa: tanggalPeriksa,
                bahasa_hasil: bahasaHasilArray,
                pengiriman: pengirimanArray,
                keluhan_medis: document.getElementById('input_keluhan').value || null,
                is_cito: isCitoGlobal,
                items: orderItems,
                total_tagihan: totalTagihanGlobal,
                metode_bayar: document.querySelector('input[name="payment_method"]:checked').value,
                edc_data: window.currentEdcData || null
            };

            fetch('/pembayaran/proses-cetak', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Transaksi Disimpan!',
                        text: 'Pilih aksi selanjutnya:',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-print"></i> Print Nota & Selesai',
                        cancelButtonText: 'Tutup & Mulai Baru',
                        confirmButtonColor: '#8bf0fa',
                        cancelButtonColor: '#1e1e24',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed && data.redirect_url) {
                            const printWindow = window.open(data.redirect_url, '_blank');
                            if (printWindow) {
                                const checkWindowClosed = setInterval(() => {
                                    if (printWindow.closed) {
                                        clearInterval(checkWindowClosed);
                                        window.location.reload();
                                    }
                                }, 500);
                            } else {
                                window.location.reload();
                            }
                        } else {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message
                    });
                }
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Server'
                });
            });
        }

        function simulasiPanggilAntrian(noAntrian) {
            Swal.fire({
                title: 'Memanggil Antrian',
                html: `<h1 class="fw-bolder text-dark" style="font-size: 3rem;">${noAntrian}</h1><p class="fw-bold">Suara panggilan sedang diputar di ruang tunggu...</p>`,
                icon: 'info',
                timer: 3000,
                showConfirmButton: false,
                timerProgressBar: true
            });
        }
    </script>
    <script>
        let transaksiDataGlobal = [];

        function bukaLaporanPendaftaran() {
            var modalLaporan = new bootstrap.Modal(document.getElementById('modalLaporanPendaftaran'));
            modalLaporan.show();

            const tbody = document.querySelector('#tableLaporan tbody');
            tbody.innerHTML = '';
            document.getElementById('tableLaporan').style.display = 'none';
            document.getElementById('laporanKosong').style.display = 'none';
            document.getElementById('laporanLoading').style.display = 'block';
            document.getElementById('selectedCount').innerText = '0';
            document.getElementById('totalPendapatanShift').innerText = 'Rp 0';
            document.getElementById('btnKirimLaporan').disabled = true;

            fetch('/laporan/belum-dilaporkan', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('laporanLoading').style.display = 'none';
                    if (data.success && data.data.length > 0) {
                        transaksiDataGlobal = data.data;
                        document.getElementById('tableLaporan').style.display = 'table';
                        data.data.forEach((row) => {
                            const tr = document.createElement('tr');
                            const datetime = row.tanggal_registrasi ? row.tanggal_registrasi.split(' ') : ['-', ''];
                            const datePart = datetime[0];
                            const timePart = datetime[1] ? datetime[1] : '';

                            tr.innerHTML = `
                            <td class="text-center py-3">
                                <input type="checkbox" class="form-check-input row-checkbox shadow-sm border-2 border-dark" value="${row.transaksi_id}" data-harga="${row.total_tagihan}" onchange="hitungTotalTerpilih()" style="cursor: pointer; transform: scale(1.2);">
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark"><i class="far fa-calendar-alt text-muted me-1"></i> ${datePart}</span>
                                    <span class="text-dark small fw-bold opacity-75">${timePart}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-white text-dark border border-dark fw-bold px-2 py-1">${row.no_registrasi || '-'}</span>
                            </td>
                            <td class="text-start">
                                <div class="fw-bold text-dark text-wrap">${row.nama_pasien}</div>
                                <div class="text-dark small fw-bold opacity-75"><i class="fas fa-qrcode me-1"></i>${row.pid}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-wrap">${row.layanan}</div>
                                ${row.poli && row.poli !== '-' ? `<small class="text-dark fw-bold opacity-75">${row.poli}</small>` : ''}
                            </td>
                            <td class="text-wrap fw-bold">${row.nama_dokter || '-'}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-white text-dark border border-dark fw-bold px-3 py-1">${row.metode_bayar}</span>
                            </td>
                            <td class="fw-bolder text-dark text-end fs-6" style="padding-right: 20px;">
                                Rp ${parseFloat(row.total_tagihan).toLocaleString('id-ID')}
                            </td>
                        `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        document.getElementById('laporanKosong').style.display = 'block';
                    }
                })
                .catch(err => {
                    document.getElementById('laporanLoading').style.display = 'none';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat data transaksi.'
                    });
                });
        }

        function toggleSelectAll(source) {
            checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = source.checked);
            hitungTotalTerpilih();
        }

        function hitungTotalTerpilih() {
            const checkboxes = document.querySelectorAll('.row-checkbox:checked');
            let total = 0;
            checkboxes.forEach(cb => {
                total += parseFloat(cb.getAttribute('data-harga')) || 0;
            });
            document.getElementById('selectedCount').innerText = checkboxes.length;
            document.getElementById('totalPendapatanShift').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('btnKirimLaporan').disabled = checkboxes.length === 0;
        }

        function kirimLaporanKeAccounting() {
            const checkboxes = document.querySelectorAll('.row-checkbox:checked');
            let transaksiIds = Array.from(checkboxes).map(cb => cb.value);

            if (transaksiIds.length === 0) return;

            Swal.fire({
                title: 'Kirim Laporan ke Accounting?',
                text: `Anda akan menggabungkan ${transaksiIds.length} transaksi ini ke dalam 1 nomor nota setoran kasir.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Buat Nota!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#c1ff72',
                cancelButtonColor: '#1e1e24'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/laporan/simpan-setoran', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                transaksi_ids: transaksiIds
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    timer: 2500,
                                    showConfirmButton: false
                                }).then(() => {
                                    bootstrap.Modal.getInstance(document.getElementById('modalLaporanPendaftaran')).hide();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan Server'
                            });
                        });
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#selectNoLaporan').select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#modalCetakSetoran')
            });
        });

        function bukaModalCetakSetoran() {
            var modal = new bootstrap.Modal(document.getElementById('modalCetakSetoran'));
            modal.show();

            const select = $('#selectNoLaporan');
            select.html('<option value="" disabled selected>Memuat daftar nota laporan...</option>').trigger('change');

            fetch('/laporan/daftar-nota', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    select.empty();
                    if (data.success && data.data.length > 0) {
                        select.append('<option value="" disabled selected>Pilih Nomor Nota Laporan...</option>');
                        data.data.forEach(item => {
                            let tanggalFormatted = '-';
                            if (item.created_at) {
                                let dateObj = new Date(item.created_at);
                                let day = String(dateObj.getDate()).padStart(2, '0');
                                let month = String(dateObj.getMonth() + 1).padStart(2, '0');
                                let year = dateObj.getFullYear();
                                let hours = String(dateObj.getHours()).padStart(2, '0');
                                let minutes = String(dateObj.getMinutes()).padStart(2, '0');
                                tanggalFormatted = `${day}-${month}-${year} ${hours}:${minutes}`;
                            }
                            const textLabel = `${item.no_laporan} — [Tgl: ${tanggalFormatted}] — (Total: Rp ${parseFloat(item.total_setoran).toLocaleString('id-ID')} | ${item.jumlah_transaksi} Transaksi)`;
                            const newOption = new Option(textLabel, item.no_laporan, false, false);
                            select.append(newOption);
                        });
                        select.trigger('change');
                    } else {
                        select.append('<option value="" disabled selected>Belum ada nota laporan yang dibuat.</option>').trigger('change');
                    }
                })
                .catch(err => {
                    select.html('<option value="" disabled selected>Gagal memuat data nota.</option>').trigger('change');
                });
        }

        function prosesPrintLaporan() {
            const noLaporan = $('#selectNoLaporan').val();
            if (!noLaporan) return Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih nomor nota laporan terlebih dahulu!'
            });
            window.open(`/laporan/print-setoran/${noLaporan}`, '_blank');
        }
    </script>
</body>

</html>
