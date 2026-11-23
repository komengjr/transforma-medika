@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (TAGIHAN & LAYANAN)
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card>.card-header {
        border-bottom: 1px solid var(--ent-grid-border) !important;
    }

    .ent-table-surface {
        background-color: var(--ent-surface);
    }

    /* Hero Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* KPI Stat Cards */
    .ent-kpi-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        background-color: var(--ent-surface);
        box-shadow: 0 4px 14px -2px rgba(15, 23, 42, 0.06);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .ent-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.12);
    }

    /* Modern Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    /* Form Controls */
    .ent-form-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-form .form-control,
    .ent-form .form-select,
    .ent-input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--ent-text) !important;
        background-color: var(--ent-surface) !important;
        font-size: 0.82rem !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
    }

    .ent-form .form-control:not(textarea),
    .ent-form .form-select,
    .ent-input {
        height: 40px !important;
    }

    .ent-form .form-control:focus,
    .ent-form .form-select:focus,
    .ent-input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-form .form-control[readonly] {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    /* Select2 Custom Enterprise Integration */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .ent-form .select2-container--bootstrap-5 .select2-selection--single {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--ent-text) !important;
        background-color: var(--ent-surface) !important;
        padding: 6px 34px 6px 12px !important;
        font-size: 0.82rem !important;
        height: 40px !important;
        min-height: 40px !important;
        display: flex !important;
        align-items: center !important;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection--single,
    .select2-container--bootstrap-5.select2-container--open .select2-selection--single {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        padding: 0 !important;
        line-height: 1.25 !important;
        color: var(--ent-text) !important;
        font-weight: 600 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.18) !important;
        overflow: hidden;
        z-index: 1075;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--ent-indigo) !important;
        outline: none;
        box-shadow: 0 0 0 2.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 8px 12px !important;
        color: var(--ent-text) !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--ent-indigo) !important;
    }

    /* Interactive Payment Method Cards */
    .payment-card {
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .payment-card:hover {
        border-color: var(--ent-indigo) !important;
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .btn-check:checked+.payment-card {
        border-color: var(--ent-indigo) !important;
        background-color: rgba(79, 70, 229, 0.1) !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.18) !important;
    }

    /* Journal Preview Box */
    .ent-coa-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        overflow: hidden;
        background-color: rgba(79, 70, 229, 0.04);
    }

    .ent-coa-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #ffffff;
        padding: 10px 14px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    /* Soft Badges */
    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .badge-status-lunas {
        background-color: rgba(16, 185, 129, 0.16) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.38);
    }

    .badge-status-piutang {
        background-color: rgba(2, 132, 199, 0.16) !important;
        color: #0284c7 !important;
        border: 1px solid rgba(2, 132, 199, 0.38);
    }

    .badge-status-pending {
        background-color: rgba(217, 119, 6, 0.16) !important;
        color: #d97706 !important;
        border: 1px solid rgba(217, 119, 6, 0.38);
    }

    .badge-status-batal {
        background-color: rgba(225, 29, 72, 0.16) !important;
        color: #e11d48 !important;
        border: 1px solid rgba(225, 29, 72, 0.38);
    }

    .badge-layanan {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: #6366f1 !important;
        border: 1px solid rgba(79, 70, 229, 0.35);
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--ent-text) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 12px;
        letter-spacing: 0.04em;
    }

    .table-custom thead th:first-child {
        border-left: none !important;
    }

    .table-custom thead th:last-child {
        border-right: none !important;
        padding-right: 16px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--ent-text) !important;
        padding: 10px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 16px !important;
    }

    .ent-card-body-flush {
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Modal Enterprise Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text);
        overflow: hidden;
    }

    .ent-modal-banner {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-9 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-bolt fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-receipt me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} PPOB &amp; VOUCHER
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Layanan Anggota</span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: white;">Tagihan &amp; Layanan Pembelian</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola transaksi tagihan layanan anggota (Listrik, PDAM, Internet, Pulsa, dll) secara langsung.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATISTIK RINGKAS BERDASARKAN STATUS -->
<div class="row g-3 mb-3">
    <!-- Status Pending -->
    <div class="col-xl-3 col-md-6">
        <div class="ent-kpi-card p-3 border-start border-warning border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold text-warning text-uppercase mb-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">Status Pending</div>
                    <div class="mb-0 fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">Rp {{ number_format($totalPending ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="rounded-3 bg-warning bg-opacity-10 p-2 text-white">
                    <i class="fas fa-clock fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Status Piutang -->
    <div class="col-xl-3 col-md-6">
        <div class="ent-kpi-card p-3 border-start border-info border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold text-info text-uppercase mb-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">Status Piutang</div>
                    <div class="mb-0 fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="rounded-3 bg-info bg-opacity-10 p-2 text-white">
                    <i class="fas fa-file-invoice-dollar fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Lunas Bulan Ini -->
    <div class="col-xl-3 col-md-6">
        <div class="ent-kpi-card p-3 border-start border-success border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold text-success text-uppercase mb-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">Total Lunas Bulan Ini</div>
                    <div class="mb-0 fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">Rp {{ number_format($totalLunasBulanIni ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="rounded-3 bg-success bg-opacity-10 p-2 text-white">
                    <i class="fas fa-check-circle fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Status Batal -->
    <div class="col-xl-3 col-md-6">
        <div class="ent-kpi-card p-3 border-start border-danger border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold text-danger text-uppercase mb-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">Status Batal</div>
                    <div class="mb-0 fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">Rp {{ number_format($totalBatal ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="rounded-3 bg-danger bg-opacity-10 p-2 text-white">
                    <i class="fas fa-times-circle fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LAYOUT UTAMA: KIRI (FORM INPUT), KANAN (TABEL DATA) -->
<div class="row g-3">
    <!-- SISI KIRI: Form Input Transaksi -->
    <div class="col-lg-4">
        <div class="ent-card ent-table-surface">
            <div class="card-header py-3 px-3 px-md-4">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-invoice-dollar text-primary me-2"></i>Form Transaksi Baru
                </h6>
            </div>
            <form id="formTagihanLayanan" action="{{ route('menu_koperasi_pembelian_vocher_layanan_save') }}" method="POST" class="ent-form">
                @csrf
                <div class="card-body p-3 p-md-4">
                    <div class="row g-3">
                        <!-- Kode Transaksi -->
                        <div class="col-12">
                            <label class="form-label ent-form-label">Kode Transaksi</label>
                            <input type="text" class="form-control" name="kode_transaksi" value="TRX-{{ date('Ymd') }}-{{ rand(100,999) }}" style="font-family: 'JetBrains Mono', monospace;" readonly required>
                        </div>

                        <!-- Anggota ID -->
                        <div class="col-12">
                            <label class="form-label ent-form-label">Anggota (Peserta)</label>
                            <select class="form-select select2-tagihan" name="anggota_id" required>
                                <option value="" selected>-- Pilih Anggota --</option>
                                @foreach($peserta as $p)
                                <option value="{{ $p->id_kop_master_peserta }}">
                                    {{ $p->kop_master_peserta_code }} - {{ $p->kop_master_peserta_name }} (NIP: {{ $p->kop_master_peserta_nip }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Layanan Enum -->
                        <div class="col-12">
                            <label class="form-label ent-form-label">Jenis Layanan</label>
                            <select class="form-select select2-tagihan" name="jenis_layanan" required>
                                <option value="" selected>-- Pilih Layanan --</option>
                                <option value="LISTRIK">LISTRIK (Token / PLN)</option>
                                <option value="PDAM">PDAM (Air)</option>
                                <option value="INTERNET">INTERNET / WiFi</option>
                                <option value="PULSA">PULSA &amp; Paket Data</option>
                                <option value="LAINNYA">LAINNYA (Voucher Game)</option>
                            </select>
                        </div>

                        <!-- Nomor Tujuan -->
                        <div class="col-12">
                            <label class="form-label ent-form-label">Nomor Tujuan / No. Pelanggan</label>
                            <input type="text" class="form-control" name="nomor_tujuan" placeholder="Cth: 5412893120" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>

                        <!-- Nama Pelanggan -->
                        <div class="col-12">
                            <label class="form-label ent-form-label">Nama Pelanggan (Opsional)</label>
                            <input type="text" class="form-control" name="nama_pelanggan" placeholder="Nama sesuai tagihan asli">
                        </div>

                        <!-- Nominal Tagihan -->
                        <div class="col-6">
                            <label class="form-label ent-form-label">Nominal (Rp)</label>
                            <input type="text" class="form-control" id="inputNominal" name="nominal" placeholder="0" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>

                        <!-- Admin Fee -->
                        <div class="col-6">
                            <label class="form-label ent-form-label">Biaya Admin (Rp)</label>
                            <input type="text" class="form-control" id="inputAdmin" name="admin_fee" value="2.500" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>

                        <div class="col-12">
                            <hr class="my-1" style="border-color: var(--ent-grid-border);">
                        </div>

                        <!-- Pilihan Metode Pembayaran -->
                        <div class="col-12">
                            <label class="form-label ent-form-label mb-2"><i class="fas fa-wallet text-primary me-1"></i> Metode Pembayaran:</label>
                            <div class="row g-2">
                                <!-- Opsi 1: Saldo Anggota (LUNAS) -->
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="metode_pembayaran_pilihan" id="metodeSaldo" value="SALDO" autocomplete="off" checked>
                                    <label class="btn w-100 p-2 text-start d-flex flex-column align-items-center justify-content-center payment-card rounded-3 h-100" for="metodeSaldo">

                                        <i class="fas fa-wallet text-success"></i>
                                        <span class="fw-bold text-center" style="font-size: 0.72rem;">Saldo Anggota</span>
                                        <span class="ent-badge badge-status-lunas mt-1" style="font-size: 0.6rem; padding: 2px 7px;">LUNAS</span>
                                    </label>
                                </div>
                                <!-- Opsi 2: Potong Gaji (PIUTANG) -->
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="metode_pembayaran_pilihan" id="metodePotongGaji" value="POTONG_GAJI" autocomplete="off">
                                    <label class="btn w-100 p-2 text-start d-flex flex-column align-items-center justify-content-center payment-card rounded-3 h-100" for="metodePotongGaji">

                                        <i class="fas fa-file-invoice-dollar text-info"></i>
                                        <span class="fw-bold text-center" style="font-size: 0.72rem;">Potong Gaji</span>
                                        <span class="ent-badge badge-status-piutang mt-1" style="font-size: 0.6rem; padding: 2px 7px;">PIUTANG</span>
                                    </label>
                                </div>
                                <!-- Opsi 3: Tagihan Bulan Ini (PENDING) -->
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="metode_pembayaran_pilihan" id="metodeTagihanBulan" value="TAGIHAN_BULAN" autocomplete="off">
                                    <label class="btn w-100 p-2 text-start d-flex flex-column align-items-center justify-content-center payment-card rounded-3 h-100" for="metodeTagihanBulan">
                                        <i class="fas fa-clock warning"></i>
                                        <span class="fw-bold text-center" style="font-size: 0.72rem;">Tagihan Bulan</span>
                                        <span class="ent-badge badge-status-pending mt-1" style="font-size: 0.6rem; padding: 2px 7px;">PENDING</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="status_tagihan" id="inputStatusTagihan" value="LUNAS">

                        <!-- Pilihan Akun / Rekening COA bergaya Jurnal Akuntansi -->
                        <div class="col-12 mt-3">
                            <div class="ent-coa-box">
                                <div class="ent-coa-header d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-balance-scale me-1 text-info"></i> Akun / Rekening COA</span>
                                    <div>
                                        <span class="me-3 opacity-75">Debit</span>
                                        <span class="opacity-75">Kredit</span>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <!-- Baris 1: Akun Piutang Anggota (Debet) -->
                                    <div class="mb-3 pb-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-bold mb-0" style="font-size: 0.72rem;">Akun Piutang Anggota (Debet)</label>
                                            <span class="text-success fw-bold" id="txtDebitPiutang" style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">Rp 0</span>
                                        </div>
                                        <select class="form-select select2-tagihan" name="piutang_coa" id="selectPiutangCoa" required>
                                            <option value="" selected>-- Pilih COA Piutang --</option>
                                            @foreach($coas as $coa)
                                            <option value="{{ $coa->coa_code }}">
                                                {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Baris 2: Akun Kas/Bank Netto (Kredit) -->
                                    <div class="mb-3 pb-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-bold opacity-75 mb-0 ps-2" style="font-size: 0.72rem;">
                                                <i class="fas fa-level-down-alt fa-rotate-90 me-1"></i> Akun Kas/Bank Netto (Kredit)
                                            </label>
                                            <span class="text-danger fw-bold" id="txtKreditKas" style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">Rp 0</span>
                                        </div>
                                        <div class="ps-2">
                                            <select class="form-select select2-tagihan" name="sumber_dana_coa" id="selectKasCoa" required>
                                                <option value="" selected>-- Pilih COA Kas/Bank --</option>
                                                @foreach($coas as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Baris 3: Akun Pendapatan Biaya Admin (Kredit) -->
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-bold opacity-75 mb-0 ps-2" style="font-size: 0.72rem;">
                                                <i class="fas fa-level-down-alt fa-rotate-90 me-1"></i> Akun Pendapatan Biaya Admin (Kredit)
                                            </label>
                                            <span class="text-danger fw-bold" id="txtKreditAdmin" style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">Rp 0</span>
                                        </div>
                                        <div class="ps-2">
                                            <select class="form-select select2-tagihan" name="pendapatan_admin_coa" id="selectAdminCoa" required>
                                                <option value="">-- Pilih COA Admin --</option>
                                                @foreach($coas as $coa)
                                                <option value="{{ $coa->coa_code }}" {{ $coa->coa_type == 'pendapatan' ? 'selected' : '' }}>
                                                    {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Kotak Ringkasan Total Kalkulasi Debet & Kredit -->
                                    <div id="autoCoaDetails" class="mt-3 pt-2" style="border-top: 1px solid var(--ent-grid-border); font-size: 0.78rem;">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Keseluruhan:</span>
                                            <div style="font-family: 'JetBrains Mono', monospace;">
                                                <span class="text-success me-3" id="sumTotalDebit">Rp 0</span>
                                                <span class="text-danger" id="sumTotalKredit">Rp 0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer px-3 px-md-4 py-3 text-end" style="background-color: rgba(79, 70, 229, 0.04); border-top: 1px solid var(--ent-grid-border);">
                    <button type="reset" class="btn ent-btn btn-outline-secondary me-1 px-3 py-2">Reset</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2"><i class="fas fa-save me-1"></i> Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SISI KANAN: Tabel Data Riwayat Transaksi -->
    <div class="col-lg-8">
        <div class="ent-card ent-table-surface">
            <div class="card-header py-3 px-3 px-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-list text-primary me-2"></i>Daftar Tagihan &amp; Layanan
                </h6>
                <div class="input-group" style="max-width: 280px;">
                    <input type="text" id="searchTagihanInput" class="form-control ent-input" placeholder="Cari Kode / Pelanggan..." style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;">
                    <button class="btn ent-btn ent-btn-primary px-3" type="button" style="border-top-left-radius: 0; border-bottom-left-radius: 0;"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="card-body ent-card-body-flush">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0 w-100" id="tableDaftarTagihan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode &amp; Anggota</th>
                                <th>Layanan &amp; Tujuan</th>
                                <th>Total &amp; COA</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $index => $trx)
                            <tr>
                                <td class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">{{ $trx->kode_transaksi }}</div>
                                    <span class="opacity-75 small fw-semibold">{{ $trx->kop_master_peserta_name }} ({{ $trx->kop_master_peserta_code }})</span>
                                </td>
                                <td>
                                    <span class="ent-badge badge-layanan">{{ $trx->jenis_layanan }}</span>
                                    <div class="fw-semibold mt-1" style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">{{ $trx->nomor_tujuan }}</div>
                                    @if($trx->nama_pelanggan)
                                    <small class="opacity-75">Pelanggan: {{ $trx->nama_pelanggan }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($trx->total_tagihan, 0, ',', '.') }}</div>
                                    <span class="ent-badge mt-1" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35); font-family: 'JetBrains Mono', monospace; font-size: 0.62rem;">
                                        <i class="fas fa-wallet me-1"></i> {{ $trx->sumber_dana_coa }}
                                    </span>
                                </td>
                                <td>
                                    @if($trx->status_tagihan == 'LUNAS')
                                    <span class="ent-badge badge-status-lunas">LUNAS</span>
                                    @elseif($trx->status_tagihan == 'PIUTANG' || $trx->status_tagihan == 'DITAGIHKAN')
                                    <span class="ent-badge badge-status-piutang">{{ $trx->status_tagihan }}</span>
                                    @elseif($trx->status_tagihan == 'PENDING')
                                    <span class="ent-badge badge-status-pending">PENDING</span>
                                    @else
                                    <span class="ent-badge badge-status-batal">{{ $trx->status_tagihan }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($trx->status_tagihan != 'LUNAS')
                                    <button class="btn btn-sm ent-btn ent-btn-success py-1 px-2 btn-lunas"
                                        title="Lunasi Tagihan"
                                        data-id="{{ $trx->id }}"
                                        data-kode="{{ $trx->kode_transaksi }}"
                                        data-total="{{ $trx->total_tagihan }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalPelunasan">
                                        <i class="fas fa-check-circle me-1"></i> Lunasi
                                    </button>
                                    @else
                                    <span class="ent-badge badge-status-lunas"><i class="fas fa-check me-1"></i> Lunas</span>
                                    @endif

                                    @if($trx->status_tagihan != 'LUNAS')
                                    <form action="{{ route('menu_koperasi_pembelian_vocher_layanan_destroy', $trx->id) }}" method="POST" class="d-inline-block ms-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm ent-btn btn-outline-danger py-1 px-2" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center opacity-75 py-4">Belum ada data transaksi tersimpan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer px-3 px-md-4 py-3 d-flex justify-content-between align-items-center" style="background-color: rgba(79, 70, 229, 0.04); border-top: 1px solid var(--ent-grid-border);">
                <span class="opacity-75 small fw-semibold">Menampilkan data transaksi</span>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pelunasan Tagihan -->
<div class="modal fade" id="modalPelunasan" tabindex="-1" aria-labelledby="modalPelunasanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('menu_koperasi_pembelian_vocher_layanan_lunas') }}" method="POST" class="ent-form w-100">
            @csrf
            @method('PUT')
            <div class="modal-content modal-ent-content">
                <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                    <h6 class="modal-title fw-bold text-white mb-0" id="modalPelunasanLabel">
                        <i class="fas fa-money-bill-wave me-2"></i>Form Pelunasan Tagihan Layanan
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id_transaksi" id="lunasIdTransaksi">

                    <div class="mb-3">
                        <label class="form-label ent-form-label">Kode Transaksi</label>
                        <input type="text" class="form-control" id="lunasKodeTransaksi" style="font-family: 'JetBrains Mono', monospace;" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label ent-form-label">Total Tagihan yang Harus Dibayar</label>
                        <input type="text" class="form-control fw-bold text-danger" id="lunasTotalTagihan" style="font-family: 'JetBrains Mono', monospace;" readonly>
                    </div>

                    <div class="mb-2">
                        <label class="form-label ent-form-label">Pilih Akun Kas / Bank Pembayaran (Debet/Kas Masuk)</label>
                        <select class="form-select select2-tagihan-modal" id="selectPelunasanCoa" name="sumber_dana_pelunasan_coa" required>
                            <option value="" selected>-- Pilih COA Kas / Bank --</option>
                            @foreach($coas as $coa)
                            <option value="{{ $coa->coa_code }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn btn-secondary px-3 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-success px-4 py-2"><i class="fas fa-save me-1"></i> Simpan Pelunasan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('base.js')
<script>
    function runWhenSelect2Ready(callback) {
        if (window.jQuery && $.fn.select2) {
            callback();
            return;
        }
        const loadSelect2 = () => {
            const s = document.createElement('script');
            s.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
            s.onload = callback;
            document.head.appendChild(s);
        };
        if (!window.jQuery) {
            const jq = document.createElement('script');
            jq.src = 'https://code.jquery.com/jquery-3.7.1.min.js';
            jq.onload = loadSelect2;
            document.head.appendChild(jq);
        } else {
            loadSelect2();
        }
    }

    function initSelect2Tagihan() {
        if (!(window.jQuery && $.fn.select2)) return;

        const baseOpts = {
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            language: {
                noResults: function() {
                    return 'Data tidak ditemukan';
                },
                searching: function() {
                    return 'Mencari...';
                }
            }
        };

        $('.select2-tagihan').each(function() {
            const $el = $(this);
            const placeholderText = $el.find('option:first').text() || '-- Pilih --';
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            $el.select2({
                ...baseOpts,
                placeholder: placeholderText
            });
        });

        $('.select2-tagihan-modal').each(function() {
            const $el = $(this);
            const placeholderText = $el.find('option:first').text() || '-- Pilih COA Kas / Bank --';
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            $el.select2({
                ...baseOpts,
                placeholder: placeholderText,
                dropdownParent: $('#modalPelunasan')
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const defaultAdminCoaVal = document.getElementById('selectAdminCoa')?.value || '';

        runWhenSelect2Ready(function() {
            initSelect2Tagihan();
        });

        const inputNominal = document.getElementById('inputNominal');
        const inputAdmin = document.getElementById('inputAdmin');

        const txtDebitPiutang = document.getElementById('txtDebitPiutang');
        const txtKreditKas = document.getElementById('txtKreditKas');
        const txtKreditAdmin = document.getElementById('txtKreditAdmin');

        const sumTotalDebit = document.getElementById('sumTotalDebit');
        const sumTotalKredit = document.getElementById('sumTotalKredit');

        let terbilangContainer = document.getElementById('terbilangNominal');
        if (!terbilangContainer && inputNominal) {
            terbilangContainer = document.createElement('div');
            terbilangContainer.id = 'terbilangNominal';
            terbilangContainer.className = 'form-text opacity-75 fst-italic mt-1';
            terbilangContainer.style.fontSize = '0.7rem';
            inputNominal.parentNode.appendChild(terbilangContainer);
        }

        const radioSaldo = document.getElementById('metodeSaldo');
        const radioPotongGaji = document.getElementById('metodePotongGaji');
        const radioTagihanBulan = document.getElementById('metodeTagihanBulan');
        const inputStatusTagihan = document.getElementById('inputStatusTagihan');

        function updateStatusTagihan() {
            if (radioSaldo.checked) {
                inputStatusTagihan.value = 'LUNAS';
            } else if (radioPotongGaji.checked) {
                inputStatusTagihan.value = 'PIUTANG';
            } else if (radioTagihanBulan.checked) {
                inputStatusTagihan.value = 'PENDING';
            }
        }

        if (radioSaldo && radioPotongGaji && radioTagihanBulan) {
            radioSaldo.addEventListener('change', updateStatusTagihan);
            radioPotongGaji.addEventListener('change', updateStatusTagihan);
            radioTagihanBulan.addEventListener('change', updateStatusTagihan);
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(angka);
        }

        function cleanNumber(nilai) {
            if (!nilai) return 0;
            return parseFloat(nilai.toString().replace(/\./g, '').replace(',', '.')) || 0;
        }

        function penyebut(nilai) {
            nilai = Math.abs(nilai);
            var huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
            var temp = "";
            if (nilai < 12) {
                temp = " " + huruf[nilai];
            } else if (nilai < 20) {
                temp = penyebut(nilai - 10) + " Belas";
            } else if (nilai < 100) {
                temp = penyebut(Math.floor(nilai / 10)) + " Puluh" + penyebut(nilai % 10);
            } else if (nilai < 200) {
                temp = " Seratus" + penyebut(nilai - 100);
            } else if (nilai < 1000) {
                temp = penyebut(Math.floor(nilai / 100)) + " Ratus" + penyebut(nilai % 100);
            } else if (nilai < 2000) {
                temp = " Seribu" + penyebut(nilai - 1000);
            } else if (nilai < 1000000) {
                temp = penyebut(Math.floor(nilai / 1000)) + " Ribu" + penyebut(nilai % 1000);
            } else if (nilai < 1000000000) {
                temp = penyebut(Math.floor(nilai / 1000000)) + " Juta" + penyebut(nilai % 1000000);
            } else if (nilai < 1000000000000) {
                temp = penyebut(Math.floor(nilai / 1000000000)) + " Miliar" + penyebut(nilai % 1000000000);
            }
            return temp;
        }

        function terbilang(nilai) {
            if (nilai == 0) return "Nol Rupiah";
            var hasil = penyebut(nilai).trim();
            return hasil + " Rupiah";
        }

        function handleInputFormatting(e) {
            let val = e.target.value.replace(/[^,\d]/g, '').toString();
            let split = val.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            e.target.value = rupiah;
        }

        function calculateJournal() {
            const nominal = cleanNumber(inputNominal.value);
            const admin = cleanNumber(inputAdmin.value);
            const totalTagihan = nominal + admin;

            if (txtDebitPiutang) txtDebitPiutang.textContent = formatRupiah(totalTagihan);
            if (txtKreditKas) txtKreditKas.textContent = formatRupiah(nominal);
            if (txtKreditAdmin) txtKreditAdmin.textContent = formatRupiah(admin);

            if (sumTotalDebit) sumTotalDebit.textContent = formatRupiah(totalTagihan);
            if (sumTotalKredit) sumTotalKredit.textContent = formatRupiah(totalTagihan);

            if (terbilangContainer) {
                if (nominal > 0) {
                    terbilangContainer.textContent = "Terbilang: " + terbilang(nominal);
                } else {
                    terbilangContainer.textContent = "";
                }
            }
        }

        if (inputNominal && inputAdmin) {
            inputNominal.addEventListener('input', function(e) {
                handleInputFormatting(e);
                calculateJournal();
            });

            inputAdmin.addEventListener('input', function(e) {
                handleInputFormatting(e);
                calculateJournal();
            });

            if (inputAdmin.value && !inputAdmin.value.includes('.')) {
                inputAdmin.value = Number(inputAdmin.value).toLocaleString('id-ID');
            }
            calculateJournal();
        }

        // Reset handler untuk form & Select2
        const formTagihan = document.getElementById('formTagihanLayanan');
        if (formTagihan) {
            formTagihan.addEventListener('reset', function() {
                setTimeout(() => {
                    updateStatusTagihan();
                    calculateJournal();
                    if (window.jQuery && $.fn.select2) {
                        $('select[name="anggota_id"]').val('').trigger('change.select2');
                        $('select[name="jenis_layanan"]').val('').trigger('change.select2');
                        $('#selectPiutangCoa').val('').trigger('change.select2');
                        $('#selectKasCoa').val('').trigger('change.select2');
                        $('#selectAdminCoa').val(defaultAdminCoaVal).trigger('change.select2');
                    }
                }, 10);
            });
        }

        // Filter Pencarian Cepat pada Tabel Riwayat
        const searchTagihanInput = document.getElementById('searchTagihanInput');
        if (searchTagihanInput) {
            searchTagihanInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableDaftarTagihan tbody tr');
                rows.forEach(function(row) {
                    if (row.cells.length <= 1) return;
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(keyword) ? '' : 'none';
                });
            });
        }

        // Script untuk mengisi data ke Modal Pelunasan
        const modalPelunasan = document.getElementById('modalPelunasan');
        if (modalPelunasan) {
            modalPelunasan.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;

                let id = button.getAttribute('data-id');
                let kode = button.getAttribute('data-kode');
                let total = button.getAttribute('data-total');

                document.getElementById('lunasIdTransaksi').value = id;
                document.getElementById('lunasKodeTransaksi').value = kode;
                document.getElementById('lunasTotalTagihan').value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(total);

                if (window.jQuery && $.fn.select2) {
                    $('#selectPelunasanCoa').val('').trigger('change.select2');
                } else {
                    document.getElementById('selectPelunasanCoa').value = '';
                }
            });
        }
    });
</script>
@endsection
