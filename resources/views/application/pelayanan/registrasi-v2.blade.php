<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TAMBAHKAN CSRF TOKEN UNTUK AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Pasien - Premium UI</title>
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
        :root {
            --primary-gradient: linear-gradient(135deg, #4361ee, #3a0ca3);
            --teal-gradient: linear-gradient(135deg, #2a9d8f, #217a6f);
            --purple-gradient: linear-gradient(135deg, #7209b7, #560bad);
            --success-gradient: linear-gradient(135deg, #28a745, #1e7e34);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2d3748;
            background-color: #f0f4f8;
            background-image:
                radial-gradient(at 0% 0%, hsla(217, 100%, 94%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225, 100%, 95%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(253, 100%, 94%, 1) 0, transparent 50%),
                radial-gradient(at 100% 100%, hsla(177, 100%, 92%, 1) 0, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* Stepper Navigation */
        .nav-pills {
            gap: 15px;
        }

        .nav-pills .nav-item {
            flex: 1;
        }

        .nav-pills .nav-link {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            color: #718096;
            font-weight: 600;
            padding: 16px 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .nav-pills .nav-link:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(100%);
            background: rgba(230, 235, 240, 0.5);
        }

        .nav-pills .nav-link i {
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .nav-pills .nav-link:not(:disabled):hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .nav-pills .nav-link.active.step-1 {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
        }

        .nav-pills .nav-link.active.step-2 {
            background: var(--teal-gradient);
            color: white;
            border-color: transparent;
        }

        .nav-pills .nav-link.active.step-3 {
            background: var(--success-gradient);
            color: white;
            border-color: transparent;
        }

        .nav-pills .nav-link.active i {
            transform: scale(1.2);
        }

        /* Card Styles */
        .card {
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: none;
            padding: 18px 24px;
            font-size: 0.9rem;
        }

        .header-blue {
            background: var(--primary-gradient);
            color: white;
        }

        .header-teal {
            background: var(--teal-gradient);
            color: white;
        }

        .header-purple {
            background: var(--purple-gradient);
            color: white;
        }

        /* Form Inputs */
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #a0aec0;
        }

        .form-control,
        .form-select {
            border-left: none;
            background-color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #cbd5e0;
            box-shadow: none;
            border-left: none;
            background-color: #fff;
        }

        .input-group {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
            border-color: #4361ee;
            transform: translateY(-1px);
        }

        .input-group:focus-within .input-group-text {
            color: #4361ee;
        }

        /* Penyesuaian Select2 agar menyatu dengan Input Group Bootstrap */
        .select2-container--bootstrap-5 .select2-selection {
            border-left: none !important;
            border: none;
            background-color: transparent !important;
            min-height: 45px;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            box-shadow: none !important;
        }

        .input-group>.select2-container--bootstrap-5 {
            flex: 1 1 auto;
            width: 1% !important;
        }

        .avatar-wrapper {
            width: 140px;
            height: 140px;
            margin: 0 auto;
            border-radius: 50%;
            background: linear-gradient(135deg, #f6f9fc, #e2e8f0);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .table-custom thead {
            background: var(--primary-gradient);
            color: white;
        }

        .table-custom th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 16px 12px;
            border: none;
        }

        .table-custom tbody tr {
            transition: all 0.2s;
            background: rgba(255, 255, 255, 0.5);
        }

        .table-custom tbody tr:hover {
            background-color: #fff;
            transform: scale(1.005);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            cursor: pointer;
        }

        .table-custom td {
            padding: 16px 12px;
            vertical-align: middle;
            border-bottom: 1px dashed #e2e8f0;
        }

        .btn {
            font-weight: 600;
            letter-spacing: 0.3px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-pill {
            border-radius: 50px;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* MODAL PASIEN & KAMERA */
        .req-field {
            display: none;
            color: #dc3545;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 4px;
        }

        .form-control.border-danger,
        .form-select.border-danger {
            border: 1px solid #dc3545 !important;
        }

        .modal-minimal-input .form-control,
        .modal-minimal-input .form-select {
            border: none;
            border-bottom: 1px solid #cbd5e0;
            border-radius: 0;
            background-color: transparent;
            padding-left: 0;
            padding-right: 0;
            box-shadow: none;
        }

        .modal-minimal-input .form-control:focus,
        .modal-minimal-input .form-select:focus {
            border-bottom-color: #4361ee;
        }

        .camera-box {
            width: 100%;
            max-width: 250px;
            height: 250px;
            background: #e2e8f0;
            border-radius: 15px;
            margin: 0 auto;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border: 2px dashed #cbd5e0;
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

        /* INVOICE & PEMBAYARAN */
        .invoice-paper {
            background-color: #fff;
            border-radius: 4px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.02);
            position: relative;
            font-family: 'Space Mono', monospace;
            color: #1a1a1a;
        }

        .invoice-paper::before,
        .invoice-paper::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 10px;
            background-size: 20px 20px;
            z-index: 10;
        }

        .invoice-paper::before {
            top: -5px;
            background-image: radial-gradient(circle at 10px 0, transparent 11px, #fff 12px);
        }

        .invoice-paper::after {
            bottom: -5px;
            background-image: radial-gradient(circle at 10px 10px, transparent 11px, #fff 12px);
        }

        .invoice-dashed-line {
            border-top: 2px dashed #cbd5e0;
            margin: 15px 0;
        }

        .invoice-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            letter-spacing: 1px;
            color: #000;
        }

        .invoice-table {
            width: 100%;
            font-size: 0.85rem;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 6px 0;
        }

        .invoice-table th {
            border-bottom: 2px dashed #cbd5e0;
            font-weight: bold;
        }

        .payment-method-card {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            background: #fff;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-method-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .payment-method-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .btn-check:checked+.payment-method-card {
            border-color: #4361ee;
            background-color: rgba(67, 97, 238, 0.04);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.15);
        }

        .btn-check:checked+.payment-method-card .payment-method-icon {
            background-color: #4361ee !important;
            color: #fff !important;
        }

        .btn-check:checked+.payment-method-card .check-indicator {
            opacity: 1;
            transform: scale(1);
        }

        .check-indicator {
            margin-left: auto;
            color: #4361ee;
            font-size: 1.5rem;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s;
        }

        /* MODAL MEMBER CARD */
        .member-card-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            border-radius: 20px;
            background: var(--primary-gradient);
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 25px;
        }

        .member-card-container::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .member-card-container::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .member-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .member-card-photo {
            width: 90px;
            height: 90px;
            border-radius: 15px;
            border: 3px solid rgba(255, 255, 255, 0.8);
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .member-card-body {
            position: relative;
            z-index: 2;
        }

        .member-card-barcode {
            background: white;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            color: black;
            margin-top: 20px;
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>

    <div class="container-fluid py-4 px-4 px-md-5">
        <!-- Title Area, User Login, Real-time Clock & Reset -->
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="bg-white p-3 rounded-circle shadow-sm me-3 text-primary d-flex align-items-center justify-content-center" style="width: 65px; height: 65px;">
                    <i class="fas fa-hospital fa-2x" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                </div>
                <div>
                    <h3 class="mb-0 fw-bold text-dark">Registrasi Pasien Terpadu</h3>
                    <span class="text-secondary fw-medium">Sistem Informasi Manajemen Rumah Sakit (SIMRS)</span>
                </div>
            </div>

            <!-- KELOMPOK KANAN: User, Waktu, Tombol Reset -->
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="bg-white px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2 border border-light">
                    <i class="fas fa-user-circle text-primary fs-5"></i>
                    <span class="fw-bold text-dark">{{ Auth::user()->name ?? 'Agus Prasetyo R.' }}</span>
                </div>

                <div class="bg-white px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2 border border-light">
                    <i class="fas fa-clock text-primary"></i>
                    <span id="realtimeClock" class="fw-bold fs-5 text-dark" style="font-variant-numeric: tabular-nums;">00:00:00</span>
                </div>

                <button class="btn btn-danger rounded-pill shadow-sm px-4 py-2 d-flex align-items-center gap-2 fw-bold" onclick="konfirmasiReset()" title="Mulai Registrasi Baru">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
            </div>
        </div>

        <!-- Stepper Navigation -->
        <ul class="nav nav-pills mb-3" id="registrationTabs" role="tablist">
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
                <div class="card border-0 mb-3" style="background: rgba(255,255,255,0.6);">
                    <div class="card-body p-3 d-flex flex-wrap align-items-center gap-3">
                        <button class="btn btn-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width:48px; height:48px; flex-shrink: 0;" data-bs-toggle="modal" data-bs-target="#modalPasien" onclick="resetForm('modalPasien')" title="Tambah Pasien Baru">
                            <i class="fas fa-plus"></i>
                        </button>

                        <div class="input-group shadow-sm" style="flex: 2; min-width: 300px;">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchKeyword" class="form-control" placeholder="Cari berdasarkan Nama / No. HP / NIK... (Min. 3 huruf)" onkeyup="if(event.keyCode === 13) cariPasien()">
                            <button class="btn btn-primary px-4" type="button" onclick="cariPasien()">Cari</button>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-header header-blue d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-id-card me-2"></i> Data Profil Pasien</span>
                                <span class="badge bg-white text-primary rounded-pill px-3 py-2 shadow-sm"><i class="fas fa-check-circle me-1"></i> Terverifikasi</span>
                            </div>
                            <div class="card-body p-3 p-xl-3">
                                <div class="row align-items-start pt-3">
                                    <div class="col-md-3 text-center mb-4 mb-md-0">
                                        <div class="avatar-wrapper mb-4">
                                            <img id="displayFoto" src="" alt="Foto Pasien" style="width:100%; height:100%; border-radius:50%; object-fit:cover; display:none;">
                                            <i id="displayIcon" class="fas fa-user-tie fa-4x text-secondary opacity-50"></i>
                                        </div>
                                        <div class="d-grid gap-2 px-1">
                                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPasien" onclick="populateEditForm()"><i class="fas fa-edit me-1"></i> Perbarui</button>
                                            <button class="btn btn-light btn-sm text-secondary border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCetakKartu">
                                                <i class="fas fa-print me-1"></i> Cetak Kartu
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row g-2 form-control-sm">
                                            <div class="col-md-8">
                                                <label class="form-label small text-muted mb-0">Nama Lengkap & Title</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" id="displayNama" class="form-control fw-bold text-dark" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small text-muted mb-0">PID Pasien</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                    <input type="text" id="displayPid" class="form-control text-primary fw-bold bg-light" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label small text-muted mb-0">No. ID (NIK/SIM/Paspor)</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                                    <input type="text" id="displayNik" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted mb-0">Tempat, Tanggal Lahir (Umur)</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    <input type="text" id="displayTglLahir" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small text-muted mb-0">Jenis Kelamin</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                                    <input type="text" id="displayJk" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small text-muted mb-0">Agama</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-pray"></i></span>
                                                    <input type="text" id="displayAgama" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small text-muted mb-0">Pekerjaan (NIP)</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    <input type="text" id="displayPekerjaan" class="form-control bg-light" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label small text-muted mb-0">No. Telepon / HP</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="text" id="displayNoHp" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small text-muted mb-0">Email</label>
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
                                            <div class="col-12 mt-3 pt-3 border-top">
                                                <label class="form-label small fw-bold text-primary mb-1">Keluhan Medis / Diagnosa Awal</label>
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

                    <!-- BAGIAN KANAN: REFERENSI, BAHASA & PENGIRIMAN -->
                    <div class="col-lg-4">
                        <!-- 1. REFERENSI & RUJUKAN -->
                        <div class="card mb-3">
                            <div class="card-header header-teal"><i class="fas fa-hospital-user me-2"></i> Referensi & Rujukan</div>
                            <div class="card-body p-4">

                                <label class="form-label fw-bold text-secondary small text-uppercase mb-1">Tipe FPP</label>
                                <div class="mb-3 input-group">
                                    <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                    <!-- Menggunakan ID untuk di-binding dengan Tabel Master FPP (Internal/Eksternal) -->
                                    <select class="form-select" name="tipe_fpp_id" id="tipe_fpp_id">
                                        <option value="" disabled selected>Pilih Tipe FPP...</option>
                                        <option value="1">Rujukan Internal</option>
                                        <option value="2">Rujukan Eksternal / Luar</option>
                                    </select>
                                </div>

                                <label class="form-label fw-bold text-secondary small text-uppercase mb-1">Dokter Pengirim</label>
                                <div class="mb-3 input-group">
                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                    <!-- INPUT DOKTER PENGIRIM TERHUBUNG KE ID -->
                                    <select class="form-select" name="dokter_id" id="input_dokter">
                                        <option value="" disabled>Pilih Dokter...</option>
                                        <option value="Dr. Andi Wijaya, Sp.PD" selected>Dr. Andi Wijaya, Sp.PD</option>
                                        <option value="Dr. Siti Aminah, Sp.A">Dr. Siti Aminah, Sp.A</option>
                                        <option value="Dr. Budi Santoso, Sp.OT">Dr. Budi Santoso, Sp.OT</option>
                                    </select>
                                </div>

                                <div class="mt-4 pt-3 border-top">
                                    <label class="form-label fw-bold text-secondary small text-uppercase mb-2">Bahasa Hasil (Pilih > 1)</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check custom-checkbox">
                                            <input class="form-check-input cursor-pointer shadow-sm" type="checkbox" name="bahasa_hasil[]" value="ID" id="lang_id" checked>
                                            <label class="form-check-label cursor-pointer" for="lang_id">Indonesia</label>
                                        </div>
                                        <div class="form-check custom-checkbox">
                                            <input class="form-check-input cursor-pointer shadow-sm" type="checkbox" name="bahasa_hasil[]" value="EN" id="lang_en">
                                            <label class="form-check-label cursor-pointer" for="lang_en">English</label>
                                        </div>
                                        <div class="form-check custom-checkbox">
                                            <input class="form-check-input cursor-pointer shadow-sm" type="checkbox" name="bahasa_hasil[]" value="CN" id="lang_cn">
                                            <label class="form-check-label cursor-pointer" for="lang_cn">Mandarin</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. METODE PENGIRIMAN HASIL (BARU MINIMALIS) -->
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-header bg-primary border-bottom pt-3 pb-2">
                                <h6 class="fw-bold text-white mb-0"><i class="fas fa-paper-plane text-white me-2"></i> Pengiriman Hasil</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-2">
                                    <div class="col-3">
                                        <label class="form-check p-2 border rounded-2 d-flex flex-column align-items-center justify-content-center text-center h-100 mb-0" style="cursor: pointer;">
                                            <input class="form-check-input ms-0 mb-1 mt-0" type="checkbox" name="pengiriman[]" value="whatsapp" checked>
                                            <i class="fab fa-whatsapp text-success mb-1 fs-5"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.65rem;">WhatsApp</span>
                                        </label>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-check p-2 border rounded-2 d-flex flex-column align-items-center justify-content-center text-center h-100 mb-0" style="cursor: pointer;">
                                            <input class="form-check-input ms-0 mb-1 mt-0" type="checkbox" name="pengiriman[]" value="email">
                                            <i class="fas fa-envelope text-danger mb-1 fs-5"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.65rem;">Email</span>
                                        </label>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-check p-2 border rounded-2 d-flex flex-column align-items-center justify-content-center text-center h-100 mb-0" style="cursor: pointer;">
                                            <input class="form-check-input ms-0 mb-1 mt-0" type="checkbox" name="pengiriman[]" value="satusehat" checked>
                                            <i class="fas fa-heartbeat text-info mb-1 fs-5"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.65rem;">Satu Sehat</span>
                                        </label>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-check p-2 border rounded-2 d-flex flex-column align-items-center justify-content-center text-center h-100 mb-0" style="cursor: pointer;">
                                            <input class="form-check-input ms-0 mb-1 mt-0" type="checkbox" name="pengiriman[]" value="cetak_fisik">
                                            <i class="fas fa-print text-secondary mb-1 fs-5"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.65rem;">Cetak Kertas</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. KEAMANAN DATA -->
                        <!-- <div class="card border-0" style="background: linear-gradient(135deg, #fff3cd, #ffe69c); box-shadow: 0 8px 20px rgba(255, 193, 7, 0.15);">
                            <div class="card-body d-flex align-items-center gap-3 py-4 px-4">
                                <div class="bg-warning text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width:50px; height:50px; flex-shrink: 0;">
                                    <i class="fas fa-shield-alt fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">Keamanan Data</h6>
                                    <small class="text-dark opacity-75">Pastikan mencocokkan identitas dengan KTP asli pasien.</small>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-primary btn-lg btn-pill shadow px-5 py-3 d-flex align-items-center gap-2" style="background: var(--primary-gradient); border: none;" onclick="nextTab('tab-pemeriksaan')">
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
                            <div class="card-header header-purple"><i class="fas fa-briefcase-medical me-2"></i> Penjamin & Layanan</div>
                            <div class="card-body p-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Tipe Penjamin Utama</label>
                                <div class="mb-3 input-group">
                                    <span class="input-group-text"><i class="fas fa-hand-holding-heart"></i></span>
                                    <select class="form-select fw-bold text-primary" id="pilih_penjamin" onchange="toggleSubPenjamin()">
                                        <option value="" disabled selected>Pilih Penjamin...</option>
                                        <option value="UMUM">UMUM / PRIBADI</option>
                                        <option value="BPJS">BPJS Kesehatan</option>
                                    </select>
                                </div>

                                <!-- Input Sub Penjamin -->
                                <div id="wrapper_sub_penjamin" style="display: none;">
                                    <label class="form-label fw-bold text-secondary small text-uppercase mt-2">Sub Penjamin</label>
                                    <div class="mb-4 input-group">
                                        <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                        <select class="form-select fw-bold text-success" id="pilih_sub_penjamin" onchange="loadPemeriksaanData()">
                                            <option value="" disabled selected>Pilih Sub Penjamin...</option>
                                            <option value="1">Pasien Umum Reguler</option>
                                            <option value="2">Pasien Umum VIP</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- TAMBAHAN INPUT ESTIMASI JANJI HASIL LAB -->
                                <label class="form-label fw-bold text-secondary small text-uppercase mt-2">Estimasi Janji Hasil</label>
                                <div class="mb-3 input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                    <input type="datetime-local" id="input_janji_hasil" class="form-control">
                                </div>

                                <div class="alert alert-warning d-flex align-items-center gap-3 mb-0 py-3 border-0 shadow-sm rounded-3">
                                    <i class="fas fa-exclamation-circle fa-2x"></i>
                                    <div>
                                        <h6 class="fw-bold mb-0">Penjamin Harus Dipilih Sesuai Kriteria</h6>
                                        <small>Wajib memilih Penjamin & Sub Penjamin.</small>
                                    </div>
                                </div>
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
                                <span class="badge bg-white text-primary rounded-pill px-3 py-2 shadow-sm" id="badge_order_count"><i class="fas fa-vial me-1"></i> 0 Item Dipilih</span>
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
                                        <!-- Data akan masuk ke sini via Javascript -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-light border-top d-flex justify-content-between align-items-center py-3 px-4">
                                <span class="fw-bold text-dark fs-5 text-uppercase">Estimasi Total:</span>
                                <span class="fw-bolder text-success fs-3" id="estimasi_total">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-white shadow-sm btn-pill px-4 text-secondary fw-bold bg-white" onclick="prevTab('tab-demografi')">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Demografi
                    </button>
                    <button class="btn btn-primary btn-lg btn-pill shadow px-5 py-3 d-flex align-items-center gap-2" style="background: var(--primary-gradient); border: none;" onclick="prosesKePembayaran()">
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
                            <i class="fas fa-print text-secondary me-2"></i>
                            <span class="text-muted fw-bold text-uppercase small">Preview Struk Cetak</span>
                        </div>

                        <div class="invoice-paper" id="area-cetak-nota">
                            <div class="text-center mb-4">
                                <h3 class="invoice-title mb-1 text-uppercase">INNOVENTRA DIGITAL SOLUSI</h3>
                                <div class="small">Cabang Pontianak<br>Jl. Jendral Sudirman No. 12</div>
                            </div>

                            <div class="invoice-dashed-line"></div>

                            <div class="row small mb-2">
                                <div class="col-4">No. INV</div>
                                <div class="col-8" id="invoice-no">: INV-AUTOGENERATE</div>
                                <div class="col-4">Tanggal</div>
                                <div class="col-8" id="invoice-date">: -</div>
                                <div class="col-4">Kasir</div>
                                <div class="col-8">: {{ Auth::user()->name ?? 'Agus Prasetyo R.' }}</div>
                                <div class="col-4">Pasien</div>
                                <div class="col-8 fw-bold" id="invoice-pasien">: -</div>
                            </div>

                            <div class="invoice-dashed-line"></div>

                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th class="text-start">LAYANAN</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-end">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-table-body">
                                    <!-- Data order disuntik dari Javascript -->
                                </tbody>
                            </table>

                            <div class="invoice-dashed-line"></div>
                            <div class="d-flex justify-content-between fs-5 mb-1" style="font-weight: 700;">
                                <span>TOTAL BAYAR</span>
                                <span id="invoice-total">Rp 0</span>
                            </div>
                            <div class="invoice-dashed-line"></div>

                            <div class="text-center mt-4">
                                <i class="fas fa-barcode fa-4x mb-2 opacity-75"></i>
                                <div class="small">Terima Kasih Atas Kunjungan Anda</div>
                                <div class="small fw-bold mt-1">Semoga Lekas Sembuh</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="card border-0 shadow-lg p-4 p-xl-5 h-100">
                            <h4 class="fw-bold mb-1">Metode Pembayaran</h4>
                            <p class="text-muted mb-4">Pilih metode pembayaran yang digunakan oleh pasien.</p>

                            <div class="d-flex flex-column gap-3 mb-5">
                                <label class="position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" value="CASH" id="pay-cash" autocomplete="off" checked>
                                    <div class="payment-method-card">
                                        <div class="payment-method-icon bg-success bg-opacity-10 text-success"><i class="fas fa-money-bill-wave"></i></div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Tunai (Cash)</h6><small class="text-muted">Pembayaran menggunakan uang fisik</small>
                                        </div>
                                        <i class="fas fa-check-circle check-indicator"></i>
                                    </div>
                                </label>

                                <label class="position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" value="QRIS" id="pay-qris" autocomplete="off">
                                    <div class="payment-method-card">
                                        <div class="payment-method-icon bg-info bg-opacity-10 text-info"><i class="fas fa-qrcode"></i></div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">QRIS (E-Wallet/M-Banking)</h6><small class="text-muted">Gopay, OVO, Dana, ShopeePay, dll</small>
                                        </div>
                                        <i class="fas fa-check-circle check-indicator"></i>
                                    </div>
                                </label>

                                <label class="position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" value="EDC" id="pay-edc" autocomplete="off">
                                    <div class="payment-method-card">
                                        <div class="payment-method-icon bg-secondary bg-opacity-10 text-secondary"><i class="fas fa-credit-card"></i></div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Kartu Debit / Kredit (EDC)</h6><small class="text-muted">Mesin EDC BCA, Mandiri, BNI, dll</small>
                                        </div>
                                        <i class="fas fa-check-circle check-indicator"></i>
                                    </div>
                                </label>

                                <label class="position-relative">
                                    <input type="radio" class="btn-check" name="payment_method" value="PIUTANG" id="pay-piutang" autocomplete="off">
                                    <div class="payment-method-card">
                                        <div class="payment-method-icon bg-warning bg-opacity-10 text-warning"><i class="fas fa-building"></i></div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Piutang (Perusahaan)</h6><small class="text-muted">Tagihan dibebankan ke instansi/perusahaan</small>
                                        </div>
                                        <i class="fas fa-check-circle check-indicator"></i>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-auto">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 d-flex justify-content-between align-items-center mb-4">
                                    <span class="fw-bold text-primary">Tagihan Akhir:</span>
                                    <span class="fw-bolder text-primary fs-4" id="tagihan-akhir-display">Rp 0</span>
                                </div>

                                <button class="btn btn-primary btn-lg w-100 btn-pill shadow-lg py-3 fw-bold fs-5 d-flex justify-content-center align-items-center gap-2"
                                    style="background: var(--primary-gradient); border: none;" onclick="prosesBayar()">
                                    <i class="fas fa-print"></i> PROSES & CETAK STRUK
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-start mt-4">
                    <button class="btn btn-white shadow-sm btn-pill px-4 text-secondary fw-bold bg-white" onclick="prevTab('tab-pemeriksaan')">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Pemeriksaan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PENCARIAN PASIEN -->
    <div class="modal fade" id="modalPencarianPasien" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.2);">
                <div class="modal-header text-white" style="background: var(--primary-gradient); border-bottom: none; padding: 20px 25px;">
                    <h5 class="modal-title fw-bold d-flex align-items-center">
                        <i class="fas fa-users me-3 fa-lg"></i> Hasil Pencarian Pasien
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted fw-bold">Mencari data pasien...</p>
                    </div>
                    <div id="pencarianKosong" class="text-center p-5" style="display: none;">
                        <i class="fas fa-folder-open fa-4x text-muted mb-3 opacity-50"></i>
                        <h5 class="text-muted fw-bold">Data pasien tidak ditemukan.</h5>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH & PERBARUI PASIEN -->
    <div class="modal fade" id="modalPasien" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.2);">
                <div class="modal-header text-white" style="background: var(--primary-gradient); border-bottom: none; padding: 20px 25px;">
                    <h5 class="modal-title fw-bold d-flex align-items-center" id="modalPasienTitle">
                        <i class="fas fa-user-plus me-3 fa-lg"></i> Form Data Pasien
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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

                            <div class="col-lg-5 border-start">
                                <div class="row g-3 mb-4">
                                    <div class="col-12 mt-4">
                                        <label class="text-danger mb-2" style="font-size: 1.1rem;">Alamat Lengkap</label>
                                        <textarea name="alamat" id="form_alamat" class="form-control" rows="4" placeholder="Masukkan alamat lengkap..." required></textarea>
                                        <span class="req-field">Harus diisi !</span>
                                        <div class="border-bottom border-danger pb-1"></div>
                                    </div>
                                </div>

                                <h6 class="fw-bold mb-3 mt-5 text-secondary">Ambil Foto Pasien</h6>
                                <div class="text-center">
                                    <div class="camera-box shadow-sm mb-3" id="camera-container">
                                        <i class="fas fa-camera fa-4x text-secondary opacity-25" id="camera-placeholder"></i>
                                        <video id="video-stream" autoplay playsinline style="display: none;"></video>
                                        <img id="photo-result" src="" style="display: none;">
                                    </div>
                                    <canvas id="canvas-capture" style="display: none;"></canvas>
                                    <input type="hidden" name="patient_photo_base64" id="patient_photo_base64">

                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" id="btn-open-cam" onclick="startCamera()"><i class="fas fa-video me-1"></i> Buka Kamera</button>
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow" id="btn-capture" style="display:none;" onclick="capturePhoto()"><i class="fas fa-camera me-1"></i> Jepret</button>
                                        <button type="button" class="btn btn-warning btn-sm text-dark rounded-pill px-3" id="btn-retake" style="display:none;" onclick="retakePhoto()"><i class="fas fa-redo me-1"></i> Ulangi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-top-0 p-3 justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal" onclick="stopCamera()">Batal</button>
                    <button type="button" class="btn btn-primary px-5 fw-bold shadow-sm rounded-pill" style="background: var(--primary-gradient); border: none;" onclick="simpanDataPasien()">
                        Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CETAK KARTU MEMBER -->
    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; background: transparent; border: none;">
                <div class="modal-body p-0">
                    <div class="member-card-container">
                        <div class="member-card-header">
                            <div>
                                <h5 class="mb-0 fw-bold" style="letter-spacing: 1px;">PRAMITA LAB</h5>
                                <small style="opacity: 0.8; font-size: 0.75rem;">MEMBER CARD IDENTITY</small>
                            </div>
                            <i class="fas fa-heartbeat fa-2x" style="color: rgba(255,255,255,0.5);"></i>
                        </div>
                        <div class="d-flex gap-3 align-items-center member-card-body">
                            <div class="member-card-photo">
                                <i class="fas fa-user-tie fa-3x text-secondary opacity-50"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-uppercase">Bambang Junaidi</h5>
                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 0.85rem; opacity: 0.9;">
                                    <i class="fas fa-qrcode"></i> <span>PID: P-1002</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4 shadow" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-success rounded-pill px-4 shadow" style="background: var(--success-gradient); border:none;" onclick="Swal.fire({icon: 'success', title: 'Sedang Memproses', text: 'Mencetak Kartu ke Printer PVC...', showConfirmButton: false, timer: 1500})">
                            <i class="fas fa-print me-2"></i> Print Kartu
                        </button>
                    </div>
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
            $('#input_pemeriksaan').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Sub Penjamin Dulu...',
                width: '100%'
            });
        });

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
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Reset Halaman!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }

        function checkRequired(element) {
            if (!element.value.trim()) {
                element.classList.add('border-danger');
                if (element.nextElementSibling && element.nextElementSibling.classList.contains('req-field')) {
                    element.nextElementSibling.style.display = 'block';
                }
                return false;
            } else {
                element.classList.remove('border-danger');
                if (element.nextElementSibling && element.nextElementSibling.classList.contains('req-field')) {
                    element.nextElementSibling.style.display = 'none';
                }
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

        let pasienAktif = null;
        let dataPencarianGlobal = [];

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        function cariPasien() {
            const keyword = document.getElementById('searchKeyword').value;
            if (!keyword || keyword.length < 3) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Pencarian Terlalu Singkat',
                    text: 'Silakan masukkan minimal 3 karakter untuk melakukan pencarian!',
                    confirmButtonColor: '#4361ee'
                });
            }

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
                            const nik = pasien.no_id || '-';

                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="fw-bold text-primary">${pasien.pid}</td>
                                <td class="text-start fw-bold text-dark">
                                    ${pasien.nama} <br>
                                    <small class="text-muted fw-normal">${jk} &bull; ${noHp}</small>
                                </td>
                                <td>${pasien.tgl_lahir}</td>
                                <td>${nik}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm" style="background: var(--primary-gradient); border:none;" onclick="pilihPasien(${index})">
                                        Pilih <i class="fas fa-check ms-1"></i>
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        document.getElementById('pencarianKosong').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('pencarianLoading').style.display = 'none';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan pada server.'
                    });
                });
        }

        function pilihPasien(index) {
            pasienAktif = dataPencarianGlobal[index];
            const fullname = `${pasienAktif.title || ''} ${pasienAktif.awalan || ''} ${pasienAktif.nama || ''} ${pasienAktif.akhiran || ''}`.trim();
            document.getElementById('displayNama').value = fullname;
            document.getElementById('displayPid').value = pasienAktif.pid || '-';
            document.getElementById('displayJk').value = (pasienAktif.jk === 'L' ? 'Laki-Laki' : (pasienAktif.jk === 'P' ? 'Perempuan' : '-'));
            document.getElementById('displayNik').value = pasienAktif.no_id || '-';
            document.getElementById('displayAgama').value = pasienAktif.agama || '-';

            const tempatLahir = pasienAktif.tempat_lahir ? pasienAktif.tempat_lahir + ', ' : '';
            const umurStr = pasienAktif.umur ? ` (${pasienAktif.umur} Thn)` : '';
            document.getElementById('displayTglLahir').value = `${tempatLahir}${pasienAktif.tgl_lahir || '-'}${umurStr}`;

            const nipStr = pasienAktif.nip ? ` (NIP: ${pasienAktif.nip})` : '';
            document.getElementById('displayPekerjaan').value = `${pasienAktif.pekerjaan || '-'}${nipStr}`;

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

            var modal = bootstrap.Modal.getInstance(document.getElementById('modalPencarianPasien'));
            modal.hide();
        }

        function resetForm(modalId) {
            document.getElementById('modalPasienTitle').innerHTML = '<i class="fas fa-user-plus me-3 fa-lg"></i> Form Registrasi Pasien Baru';
            document.getElementById('formPasien').reset();
            document.getElementById('form_pasien_id').value = "";
            retakePhoto();
        }

        function populateEditForm(modalId) {
            if (!pasienAktif) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('modalPasien'));
                modal.hide();
                return Swal.fire({
                    icon: 'info',
                    title: 'Pilih Pasien',
                    text: 'Silakan pilih pasien terlebih dahulu!'
                });
            }
            document.getElementById('modalPasienTitle').innerHTML = '<i class="fas fa-user-edit me-3 fa-lg"></i> Form Perbarui Data Pasien';
            document.getElementById('form_pasien_id').value = pasienAktif.id;
            document.getElementById('form_awalan').value = pasienAktif.awalan || '';
            document.getElementById('form_nama').value = pasienAktif.nama || '';
            document.getElementById('form_akhiran').value = pasienAktif.akhiran || '';
            document.getElementById('form_jk').value = pasienAktif.jk || '';
            document.getElementById('form_title').value = pasienAktif.title || '';
            document.getElementById('form_tempat_lahir').value = pasienAktif.tempat_lahir || '';
            document.getElementById('form_umur').value = pasienAktif.umur || '';
            document.getElementById('form_tgl_lahir').value = pasienAktif.tgl_lahir || '';
            document.getElementById('form_agama').value = pasienAktif.agama || '';
            document.getElementById('form_no_hp').value = pasienAktif.no_hp || '';
            document.getElementById('form_email').value = pasienAktif.email || '';
            document.getElementById('form_pekerjaan').value = pasienAktif.pekerjaan || '';
            document.getElementById('form_nip').value = pasienAktif.nip || '';
            document.getElementById('form_tipe_id').value = pasienAktif.tipe_id || '';
            document.getElementById('form_no_id').value = pasienAktif.no_id || '';
            document.getElementById('form_catatan').value = pasienAktif.catatan || '';
            document.getElementById('form_alamat').value = pasienAktif.alamat || '';
        }

        function simpanDataPasien() {
            let isFormValid = true;
            document.querySelectorAll('#formPasien [required]').forEach(element => {
                if (!checkRequired(element)) isFormValid = false;
            });

            if (!isFormValid) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Form Tidak Lengkap',
                    text: 'Isi semua kolom wajib!'
                });
            }

            const form = document.getElementById('formPasien');
            const formData = new FormData(form);
            const idPasien = document.getElementById('form_pasien_id').value;
            const url = idPasien ? `/pasien/update/${idPasien}` : `/pasien/store`;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        stopCamera();
                        var modal = bootstrap.Modal.getInstance(document.getElementById('modalPasien'));
                        modal.hide();
                        pasienAktif = data.data;
                        document.getElementById('displayNama').value = `${pasienAktif.title || ''} ${pasienAktif.nama || ''}`.trim();
                        document.getElementById('displayPid').value = pasienAktif.pid || '-';
                        document.getElementById('displayNoHp').value = pasienAktif.no_hp || '-';
                        document.getElementById('displayAlamat').value = pasienAktif.alamat || '-';
                    }
                });
        }

        let stream = null;
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

        let orderItems = [];

        function resetRincianOrder() {
            if (orderItems.length > 0) {
                orderItems = [];
                renderTableOrder();
            }
        }

        function toggleSubPenjamin() {
            resetRincianOrder();
            const penjamin = document.getElementById('pilih_penjamin').value;
            const wrapperSub = document.getElementById('wrapper_sub_penjamin');
            const inputPemeriksaan = document.getElementById('input_pemeriksaan');

            if (penjamin === 'UMUM') {
                wrapperSub.style.display = 'block';
            } else {
                wrapperSub.style.display = 'none';
                document.getElementById('pilih_sub_penjamin').value = "";
                inputPemeriksaan.innerHTML = '<option value="" disabled selected>Pilih Sub Penjamin Dulu...</option>';
                inputPemeriksaan.disabled = true;
                $('#input_pemeriksaan').trigger('change');
            }
        }

        function loadPemeriksaanData() {
            resetRincianOrder();
            const subPenjaminId = document.getElementById('pilih_sub_penjamin').value;
            const inputPemeriksaan = document.getElementById('input_pemeriksaan');

            inputPemeriksaan.innerHTML = '<option value="" disabled selected>Memuat data...</option>';
            inputPemeriksaan.disabled = true;
            $('#input_pemeriksaan').trigger('change');

            if (subPenjaminId) {
                fetch(`/pemeriksaan/by-sub-penjamin/${subPenjaminId}`)
                    .then(response => response.json())
                    .then(res => {
                        inputPemeriksaan.innerHTML = '<option value="" disabled selected>Pilih Pemeriksaan / Layanan...</option>';
                        if (res.success && res.data.length > 0) {
                            inputPemeriksaan.disabled = false;
                            res.data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
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
            if (!select.value) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih layanan terlebih dahulu!'
                });
            }

            const selectedOption = select.options[select.selectedIndex];
            const dataObj = JSON.parse(selectedOption.getAttribute('data-obj'));

            // 1. Cek apakah item ini persis sudah ada di order (Pencegahan duplikat standar)
            if (orderItems.some(item => item.id === dataObj.id)) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Sudah Ada',
                    text: 'Pemeriksaan / Paket ini sudah ada dalam rincian!'
                });
            }

            // 2. Cek Tumpang Tindih (Konflik Paket vs Satuan)
            let isConflict = false;
            let conflictMsg = '';

            if (dataObj.is_paket == 1 && dataObj.detail_paket) {
                // JIKA INPUT ADALAH PAKET:
                // Cek apakah isi dari paket ini bertabrakan dengan item satuan / paket lain yang sudah di order
                for (let subItem of dataObj.detail_paket) {
                    // Cek tabrakan dengan item satuan di keranjang
                    if (orderItems.some(item => item.id === subItem.id)) {
                        isConflict = true;
                        conflictMsg = `Paket ini mengandung pemeriksaan <b>${subItem.nama_layanan}</b> yang sebelumnya sudah Anda tambahkan secara satuan.`;
                        break;
                    }
                    // Cek tabrakan dengan isi paket lain di keranjang
                    for (let existingItem of orderItems) {
                        if (existingItem.is_paket == 1 && existingItem.detail_paket) {
                            if (existingItem.detail_paket.some(existSub => existSub.id === subItem.id)) {
                                isConflict = true;
                                conflictMsg = `Paket ini mengandung pemeriksaan <b>${subItem.nama_layanan}</b> yang tumpang tindih dengan isi <b>${existingItem.nama_layanan}</b>.`;
                                break;
                            }
                        }
                    }
                    if (isConflict) break;
                }
            } else {
                // JIKA INPUT ADALAH SATUAN:
                // Cek apakah item satuan ini sudah *include* di dalam salah satu paket yang ada di keranjang
                for (let existingItem of orderItems) {
                    if (existingItem.is_paket == 1 && existingItem.detail_paket) {
                        if (existingItem.detail_paket.some(existSub => existSub.id === dataObj.id)) {
                            isConflict = true;
                            conflictMsg = `Pemeriksaan <b>${dataObj.nama_layanan}</b> sudah otomatis termasuk di dalam <b>${existingItem.nama_layanan}</b> yang telah Anda pilih sebelumnya.`;
                            break;
                        }
                    }
                }
            }

            // 3. Eksekusi Notifikasi Jika Terjadi Konflik
            if (isConflict) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Tumpang Tindih Pemeriksaan',
                    html: conflictMsg,
                    confirmButtonColor: '#4361ee'
                });
            }

            // 4. Lolos Validasi -> Masukkan ke Order
            dataObj.is_cito = 0;
            dataObj.biaya_cito = 0;
            // Backup harga akhir asli jika sewaktu-waktu CITO dibatalkan
            dataObj.harga_akhir_normal = dataObj.harga_akhir;

            orderItems.push(dataObj);
            renderTableOrder();
            $('#input_pemeriksaan').val('').trigger('change');
        }

        function hapusOrder(id) {
            orderItems = orderItems.filter(item => item.id !== id);
            renderTableOrder();
        }

        // ==========================================
        // FUNGSI MENGHITUNG BIAYA CITO PER ITEM
        // ==========================================
        function toggleCito(id, isChecked) {
            // Cari item berdasarkan ID
            let item = orderItems.find(x => x.id === id);
            if (item) {
                if (isChecked) {
                    item.is_cito = 1;
                    // Contoh markup CITO 25% dari Harga Dasar
                    item.biaya_cito = parseFloat(item.harga_dasar) * 0.25;
                    // Update harga akhir baru
                    item.harga_akhir = (parseFloat(item.harga_dasar) - parseFloat(item.diskon)) + item.biaya_cito;
                } else {
                    item.is_cito = 0;
                    item.biaya_cito = 0;
                    // Kembalikan ke harga normal
                    item.harga_akhir = parseFloat(item.harga_akhir_normal);
                }
                // Render ulang tabel untuk mengupdate total estimasi biaya
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

                let detailPaketHtml = '';
                if (item.is_paket == 1 && item.detail_paket && item.detail_paket.length > 0) {
                    detailPaketHtml = `<ul class="text-muted small ms-4 mb-0 mt-1" style="list-style-type: circle;">`;
                    item.detail_paket.forEach(detail => {
                        detailPaketHtml += `<li>${detail.kode_layanan} - ${detail.nama_layanan}</li>`;
                    });
                    detailPaketHtml += `</ul>`;
                }

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <div class="form-check d-flex justify-content-center m-0">
                            <!-- TAMBAHAN ONCHANGE DI SINI -->
                            <input class="form-check-input" type="checkbox" onchange="toggleCito(${item.id}, this.checked)" ${item.is_cito == 1 ? 'checked' : ''}>
                        </div>
                    </td>
                    <td class="text-start fw-bold text-dark">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary bg-opacity-10 text-primary rounded p-2"><i class="${item.is_paket == 1 ? 'fas fa-box-open' : 'fas fa-vial'}"></i></div>
                            <div>
                                ${item.nama_layanan}
                                ${item.is_paket == 1 ? '<span class="badge bg-warning text-dark ms-2">PAKET</span>' : ''}
                                <!-- TAMBAHAN BADGE CITO -->
                                ${item.is_cito == 1 ? '<span class="badge bg-danger ms-1">CITO</span>' : ''}
                                ${detailPaketHtml}
                            </div>
                        </div>
                    </td>
                    <td>${hargaDasar.toLocaleString('id-ID')}</td>
                    <td>${diskon > 0 ? '-' + diskon.toLocaleString('id-ID') : '-'}</td>
                    <td class="fw-bold text-primary">
                        ${hargaAkhir.toLocaleString('id-ID')}
                        <!-- MUNCULKAN TAMBAHAN BIAYA JIKA CITO -->
                        ${item.is_cito == 1 ? `<br><small class="text-danger fw-normal">+Rp ${item.biaya_cito.toLocaleString('id-ID')}</small>` : ''}
                    </td>
                    <td><button class="btn btn-light text-danger shadow-sm rounded-circle" onclick="hapusOrder(${item.id})"><i class="fas fa-trash-alt"></i></button></td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('estimasi_total').innerText = 'Rp ' + totalHarga.toLocaleString('id-ID');
            document.getElementById('badge_order_count').innerHTML = `<i class="fas fa-vial me-1"></i> ${orderItems.length} Item Dipilih`;
        }

        let totalTagihanGlobal = 0;

        function prosesKePembayaran() {
            if (!pasienAktif) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Pasien Belum Dipilih!',
                    text: 'Pilih pasien pada Tahap 1 terlebih dahulu.'
                }).then(() => prevTab('tab-demografi'));
            }
            if (orderItems.length === 0) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Rincian Kosong!',
                    text: 'Tambahkan minimal 1 pemeriksaan.'
                });
            }
            renderInvoice();
            nextTab('tab-pembayaran');
        }

        function renderInvoice() {
            document.getElementById('invoice-pasien').innerText = `: ${pasienAktif.nama} (${pasienAktif.pid})`;
            const now = new Date();
            const timeStr = `${now.getDate().toString().padStart(2,'0')}/${(now.getMonth()+1).toString().padStart(2,'0')}/${now.getFullYear()} ${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}`;
            document.getElementById('invoice-date').innerText = `: ${timeStr}`;
            document.getElementById('invoice-no').innerText = `: INV-${now.getFullYear()}${now.getMonth()+1}${now.getDate()}-${Math.floor(Math.random() * 1000)}`;

            const tbody = document.getElementById('invoice-table-body');
            tbody.innerHTML = '';
            totalTagihanGlobal = 0;

            orderItems.forEach(item => {
                const hargaAkhir = parseFloat(item.harga_akhir) || 0;
                totalTagihanGlobal += hargaAkhir;
                tbody.innerHTML += `<tr><td class="text-start">${item.nama_layanan}</td><td class="text-center">1</td><td class="text-end">${hargaAkhir.toLocaleString('id-ID')}</td></tr>`;
            });

            const formattedTotal = 'Rp ' + totalTagihanGlobal.toLocaleString('id-ID');
            document.getElementById('invoice-total').innerText = formattedTotal;
            document.getElementById('tagihan-akhir-display').innerText = formattedTotal;
        }

        function prosesBayar() {
            const method = document.querySelector('input[name="payment_method"]:checked').value;
            const formattedTagihan = totalTagihanGlobal.toLocaleString('id-ID');

            if (method === 'CASH') {
                Swal.fire({
                    title: 'Pembayaran Tunai',
                    html: `
                        <h3 class="text-primary fw-bold mb-3">Rp ${formattedTagihan}</h3>
                        <label class="form-label fw-bold">Nominal Uang Pasien</label>
                        <input type="number" id="uang_pasien" class="form-control form-control-lg fw-bold text-center" placeholder="0" min="${totalTagihanGlobal}">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Bayar',
                    confirmButtonColor: '#28a745',
                    preConfirm: () => {
                        const uang = document.getElementById('uang_pasien').value;
                        if (!uang || parseInt(uang) < totalTagihanGlobal) {
                            Swal.showValidationMessage('Uang pasien kurang!');
                        }
                        return parseInt(uang);
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
                    html: `<h4 class="text-primary fw-bold mb-3">Rp ${formattedTagihan}</h4><i class="fas fa-qrcode fa-5x mb-3"></i>`,
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi Sukses',
                    confirmButtonColor: '#4361ee'
                }).then((res) => {
                    if (res.isConfirmed) cetakNotaResmi();
                });
            } else if (method === 'EDC') {
                Swal.fire({
                    title: 'Mesin EDC',
                    html: `<select id="edc_bank" class="form-select mb-3"><option value="BCA">BCA</option><option value="Mandiri">Mandiri</option></select><input type="text" id="edc_approval" class="form-control" placeholder="No Approval">`,
                    showCancelButton: true,
                    confirmButtonText: 'Proses',
                    preConfirm: () => document.getElementById('edc_approval').value || Swal.showValidationMessage('Wajib diisi!')
                }).then((res) => {
                    if (res.isConfirmed) cetakNotaResmi();
                });
            } else if (method === 'PIUTANG') {
                Swal.fire({
                    title: 'Piutang Perusahaan',
                    html: `<h4 class="text-primary fw-bold mb-3">Rp ${formattedTagihan}</h4><p class="text-muted">Transaksi ini akan dicatat sebagai piutang instansi/perusahaan.</p>`,
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi Piutang',
                    confirmButtonColor: '#ffc107' // warna warning untuk piutang
                }).then((res) => {
                    if (res.isConfirmed) cetakNotaResmi();
                });
            }
        }

        function cetakNotaResmi() {
            if (!pasienAktif || orderItems.length === 0) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Data Kosong'
                });
            }

            const subPenjaminId = document.getElementById('pilih_sub_penjamin').value || null;
            const dokter = document.getElementById('input_dokter').value || null;
            const janjiHasil = document.getElementById('input_janji_hasil').value || null;
            const bahasaHasilArray = Array.from(document.querySelectorAll('input[name="bahasa_hasil[]"]:checked')).map(cb => cb.value);
            const pengirimanArray = Array.from(document.querySelectorAll('input[name="pengiriman[]"]:checked')).map(cb => cb.value);

            // DETEKSI CITO: Cek apakah ada minimal 1 layanan di keranjang yang berstatus CITO
            const isCitoGlobal = orderItems.some(item => item.is_cito == 1) ? 1 : 0;

            const payload = {
                pasien_id: pasienAktif.id,
                sub_penjamin_id: subPenjaminId,
                tipe_fpp_id: document.getElementById('tipe_fpp_id').value || null,
                dokter: dokter,
                bahasa_hasil: bahasaHasilArray,
                pengiriman: pengirimanArray,
                janji_hasil: janjiHasil,
                keluhan_medis: document.getElementById('input_keluhan').value || null,
                is_cito: isCitoGlobal, // <--- FLAG CITO GLOBAL DIKIRIM KE CONTROLLER
                items: orderItems, // (Ini juga sudah membawa is_cito dan biaya_cito per item dari fungsi toggleCito)
                total_tagihan: totalTagihanGlobal,
                metode_bayar: document.querySelector('input[name="payment_method"]:checked').value
            };

            fetch('/pembayaran/proses-cetak', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaksi Disimpan!',
                            text: 'Pilih aksi selanjutnya:',
                            showCancelButton: true,
                            confirmButtonText: '<i class="fas fa-print"></i> Print Nota & Selesai',
                            cancelButtonText: 'Tutup & Mulai Baru',
                            confirmButtonColor: '#4361ee',
                            cancelButtonColor: '#6c757d',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed && data.redirect_url) {
                                // Buka tab nota
                                const printWindow = window.open(data.redirect_url, '_blank');

                                // Auto refresh halaman utama setelah tab nota ditutup
                                if (printWindow) {
                                    const checkWindowClosed = setInterval(() => {
                                        if (printWindow.closed) {
                                            clearInterval(checkWindowClosed);
                                            window.location.reload();
                                        }
                                    }, 500);
                                } else {
                                    // Fallback jika popup blocker aktif
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
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Server'
                    });
                });
        }
    </script>
</body>

</html>
