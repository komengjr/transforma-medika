@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (PEMBELIAN ANGGOTA)
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

    /* Modern Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
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
    .ent-form .form-select {
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
    .ent-form .form-select {
        height: 40px !important;
    }

    .ent-form .form-control:focus,
    .ent-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-form .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .ent-form .input-group>.form-control {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    /* =========================================================
       SELECT2 SOLID BACKGROUND FIX (ANTI TRANSPARAN)
       ========================================================= */
    .select2-container {
        z-index: 1050;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        min-height: 40px !important;
        display: flex;
        align-items: center;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-surface) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: var(--ent-text) !important;
        padding-left: 10px !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
        color: #64748b !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown,
    .select2-dropdown {
        background-color: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #6366f1 !important;
        border-radius: 10px !important;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.2) !important;
        font-size: 0.82rem !important;
        z-index: 1065 !important;
        opacity: 1 !important;
    }

    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-dropdown,
    [data-bs-theme="dark"] .select2-dropdown,
    .dark .select2-container--bootstrap-5 .select2-dropdown,
    .dark .select2-dropdown {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border-color: rgba(99, 102, 241, 0.45) !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field,
    .select2-container--open .select2-search--dropdown .select2-search__field {
        background-color: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        opacity: 1 !important;
    }

    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field,
    [data-bs-theme="dark"] .select2-container--open .select2-search--dropdown .select2-search__field,
    .dark .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field,
    .dark .select2-container--open .select2-search--dropdown .select2-search__field {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    .select2-results__options {
        background-color: #ffffff !important;
        color: #0f172a !important;
        opacity: 1 !important;
    }

    [data-bs-theme="dark"] .select2-results__options,
    .dark .select2-results__options {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option,
    .select2-results__option {
        background-color: #ffffff !important;
        color: #0f172a !important;
        padding: 8px 12px !important;
        opacity: 1 !important;
    }

    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option,
    [data-bs-theme="dark"] .select2-results__option,
    .dark .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option,
    .dark .select2-results__option {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option--highlighted,
    .select2-results__option--highlighted[aria-selected] {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
    }

    /* Simulation Summary Boxes */
    .ent-sim-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 14px 12px;
        background-color: rgba(79, 70, 229, 0.05);
        height: 100%;
    }

    .ent-sim-box-highlight {
        border: 1px solid rgba(16, 185, 129, 0.45);
        border-radius: 12px;
        padding: 14px 12px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.14), rgba(5, 150, 105, 0.08));
        height: 100%;
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

    .badge-status-belum {
        background-color: rgba(79, 70, 229, 0.15) !important;
        color: #6366f1 !important;
        border: 1px solid rgba(79, 70, 229, 0.35);
    }

    .badge-status-batal {
        background-color: rgba(225, 29, 72, 0.15) !important;
        color: #e11d48 !important;
        border: 1px solid rgba(225, 29, 72, 0.35);
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

    /* DataTables Enterprise Controls */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 5px 12px !important;
        font-size: 0.8rem !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        padding: 4px 8px !important;
        font-size: 0.8rem !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
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
                            <i class="fas fa-shopping-basket fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-credit-card me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} INSTALLMENT
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Pengadaan Anggota</span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: white;">Pembelian Barang Anggota / Peserta</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Sistem pengadaan barang inventaris/kebutuhan anggota dengan skema pembayaran tenor (cicilan).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<form id="form-pembelian-barang" class="ent-form">
    <input type="hidden" name="_token" value="{{ csrf_token() ?? '' }}">

    <div class="row g-3">
        <!-- FORM INPUT PENGADAAN BARANG -->
        <div class="col-xl-5 col-lg-6">
            <div class="ent-card ent-table-surface">
                <div class="card-header py-3 px-3 px-md-4">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-cart-plus text-success me-2"></i>Form Input Transaksi
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <!-- Pilih Peserta (Select2 Searchable) -->
                    <div class="mb-3">
                        <label class="form-label ent-form-label">Pilih Peserta Koperasi <span class="text-danger">*</span></label>
                        <select class="form-select select2-peserta" name="anggota_id" id="anggota_id" required>
                            <option value=""></option>
                            @foreach($anggota as $peserta)
                            <option value="{{ $peserta->id_kop_master_peserta }}" data-no="{{ $peserta->kop_master_peserta_code }}">
                                {{ $peserta->kop_master_peserta_code }} - {{ $peserta->kop_master_peserta_name }} (NIP: {{ $peserta->kop_master_peserta_nip }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Detail Barang & Tanggal -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label ent-form-label">Nama / Spesifikasi Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="barang_nama" id="barang_nama" placeholder="Contoh: Smartphone Samsung A55" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label ent-form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_transaksi" id="tanggal_transaksi" value="{{ date('Y-m-d') }}" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>
                    </div>

                    <!-- Parameter Keuangan -->
                    <div class="mb-3">
                        <label class="form-label ent-form-label">Harga Beli Lapangan (Modal Awal) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control fw-bold rupiah-input" name="harga_beli" id="harga_beli" placeholder="0" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>
                        <div class="form-text opacity-75" style="font-size: 0.7rem;">Harga riil barang yang dibayarkan ke supplier.</div>
                    </div>

                    <!-- Skema Keuntungan: Admin (Depan) & Bunga (Cicilan) -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label ent-form-label">Biaya Admin (Potong Awal)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-input" name="biaya_admin" id="biaya_admin" value="0" style="font-family: 'JetBrains Mono', monospace;">
                            </div>
                            <div class="form-text opacity-75" style="font-size: 0.7rem;">Dipotong langsung dari kas pencairan awal.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label ent-form-label">Total Bunga / Flat</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-input" name="bunga_koperasi" id="bunga_koperasi" value="0" style="font-family: 'JetBrains Mono', monospace;">
                            </div>
                            <div class="form-text opacity-75" style="font-size: 0.7rem;">Dibebankan ke anggota &amp; dicicil tiap bulan.</div>
                        </div>
                    </div>

                    <!-- Tenor -->
                    <div class="mb-4">
                        <label class="form-label ent-form-label">Tenor / Jangka Waktu <span class="text-danger">*</span></label>
                        <select class="form-select text-primary fw-bold" name="tenor_bulan" id="tenor_bulan" required>
                            <option value="3">3 Bulan</option>
                            <option value="6" selected>6 Bulan</option>
                            <option value="12">12 Bulan</option>
                            <option value="18">18 Bulan</option>
                            <option value="24">24 Bulan</option>
                            <option value="36">36 Bulan</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn ent-btn ent-btn-success py-2" id="btn-kalkulasi-simulasi">
                            <i class="fas fa-calculator me-2"></i>Kalkulasi &amp; Simulasikan Cicilan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- LIVE SIMULASI DAN PRATINJAU JURNAL -->
        <div class="col-xl-7 col-lg-6">
            <div class="ent-card ent-table-surface h-100">
                <div class="card-header py-3 px-3 px-md-4">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-file-invoice-dollar text-primary me-2"></i>Lembar Simulasi &amp; Proyeksi Jurnal
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <!-- Info Box Kanan -->
                    <div class="row g-3 text-center mb-4">
                        <div class="col-sm-4">
                            <div class="ent-sim-box">
                                <small class="opacity-75 fw-bold d-block text-uppercase mb-1" style="font-size: 0.68rem;">Total Piutang Anggota</small>
                                <span class="fw-bold" id="lbl-total-piutang" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">Rp 0</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="ent-sim-box">
                                <small class="opacity-75 fw-bold d-block text-uppercase mb-1" style="font-size: 0.68rem;">Tenor Terpilih</small>
                                <span class="fw-bold text-primary" id="lbl-tenor" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">6 Bln</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="ent-sim-box-highlight">
                                <small class="text-success fw-bold d-block text-uppercase mb-1" style="font-size: 0.68rem;">Tagihan / Bulan</small>
                                <span class="fw-bold text-success" id="lbl-cicilan-bulanan" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Jurnal Akuntansi Dinamis -->
                    <div class="mb-4">
                        <h6 class="fw-bold pb-2 mb-2 small text-uppercase" style="border-bottom: 1px solid var(--ent-grid-border);">
                            <i class="fas fa-balance-scale me-2 text-info"></i>1. Draft Otomatis Jurnal Pencairan Pengadaan
                        </h6>
                        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                            <table class="table table-custom align-middle mb-0 w-100">
                                <thead>
                                    <tr>
                                        <th width="50%">Pilih Akun / Rekening COA</th>
                                        <th width="25%" class="text-end">Debit</th>
                                        <th width="25%" class="text-end">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Baris Debit: Piutang -->
                                    <tr>
                                        <td>
                                            <label class="form-label mb-1 opacity-75 small fw-bold">Akun Piutang Anggota (Debet)</label>
                                            <select class="form-select form-select-sm select2-coa" name="coa_piutang" id="coa_piutang" required>
                                                <option value="">-- Pilih COA Piutang --</option>
                                                @foreach($bankCoa as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-end text-success fw-bold" id="j-debit-piutang" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                        <td class="text-end opacity-50" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    </tr>
                                    <!-- Baris Kredit 1: Kas / Bank Netto -->
                                    <tr>
                                        <td>
                                            <label class="form-label mb-1 opacity-75 small fw-bold">↳ Akun Kas/Bank Netto (Kredit)</label>
                                            <select class="form-select form-select-sm select2-coa" name="sumber_dana_coa" id="sumber_dana_coa" required>
                                                <option value="">-- Pilih COA Kas/Bank --</option>
                                                @foreach($bankCoa as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-end opacity-50" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                        <td class="text-end text-danger fw-bold" id="j-kredit-kas" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    </tr>
                                    <!-- Baris Kredit 2: Pendapatan Admin (Potong Awal) -->
                                    <tr>
                                        <td>
                                            <label class="form-label mb-1 opacity-75 small fw-bold">↳ Akun Pendapatan Biaya Admin (Kredit)</label>
                                            <select class="form-select form-select-sm select2-coa" name="coa_pendapatan_admin" id="coa_pendapatan_admin" required>
                                                <option value="">-- Pilih COA Admin --</option>
                                                @foreach($PenCoa as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-end opacity-50" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                        <td class="text-end text-danger fw-bold" id="j-kredit-admin" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    </tr>
                                    <!-- Baris Kredit 3: Pendapatan Bunga -->
                                    <tr>
                                        <td>
                                            <label class="form-label mb-1 opacity-75 small fw-bold">↳ Akun Pendapatan Bunga (Kredit)</label>
                                            <select class="form-select form-select-sm select2-coa" name="coa_pendapatan_bunga" id="coa_pendapatan_bunga" required>
                                                <option value="">-- Pilih COA Bunga --</option>
                                                @foreach($PenCoa as $coa)
                                                <option value="{{ $coa->coa_code }}">
                                                    [{{ $coa->coa_code }}] {{ $coa->coa_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-end opacity-50" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                        <td class="text-end text-danger fw-bold" id="j-kredit-margin" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Timeline Jadwal Angsuran -->
                    <div>
                        <h6 class="fw-bold pb-2 mb-2 small text-uppercase" style="border-bottom: 1px solid var(--ent-grid-border);">
                            <i class="fas fa-calendar-alt me-2 text-warning"></i>2. Proyeksi Jadwal Angsuran Bulanan
                        </h6>
                        <div class="table-responsive rounded-3" style="max-height: 210px; overflow-y: auto; border: 1px solid var(--ent-grid-border);">
                            <table class="table table-custom align-middle mb-0 w-100">
                                <thead>
                                    <tr>
                                        <th>Angsuran Ke-</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end">Pokok</th>
                                        <th class="text-end">Bunga</th>
                                        <th class="text-end">Total Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody id="simulasi-tenor-tbody">
                                    <tr>
                                        <td colspan="5" class="text-center opacity-75 py-4">
                                            <i class="fas fa-info-circle d-block mb-1 fs-5 opacity-50"></i> Harap isi form kiri dan klik kalkulasi.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="text-end mt-4">
                        <button type="button" class="btn ent-btn ent-btn-primary px-4 py-2 d-none" id="btn-submit-final-pembelian">
                            <i class="fas fa-save me-2"></i>Kunci Kontrak &amp; Terbitkan Tagihan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- DATA TABEL RIWAYAT TRANSAKSI -->
<div class="row mt-3">
    <div class="col-12">
        <div class="ent-card ent-table-surface">
            <div class="card-header py-3 px-3 px-md-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list text-primary me-2"></i>Log Kontrak Pembelian Barang &amp; Status Tenor
                    </h6>
                    <!-- Filter Status -->
                    <div class="d-flex align-items-center gap-2">
                        <label for="filter-status" class="form-label mb-0 fw-bold small text-uppercase opacity-75">Filter Status:</label>
                        <select id="filter-status" class="form-select form-select-sm" style="width: 165px; height: 36px; padding-top: 4px !important; padding-bottom: 4px !important;">
                            <option value="">Semua Status</option>
                            <option value="LUNAS">LUNAS</option>
                            <option value="BELUM LUNAS">BELUM LUNAS</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="table-log-kontrak" class="table table-custom align-middle mb-0 w-100">
                        <thead>
                            <tr>
                                <th>No. Nota</th>
                                <th>Peserta Koperasi</th>
                                <th>Nama Barang</th>
                                <th class="text-end">Harga Modal</th>
                                <th class="text-end">Biaya Admin</th>
                                <th class="text-end">Total Bunga</th>
                                <th class="text-end">Total Piutang</th>
                                <th class="text-center">Tenor</th>
                                <th class="text-end">Cicilan / Bln</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $row)
                            <tr>
                                <td class="fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">{{ $row->nota_nomor }}</td>
                                <td>
                                    <small class="opacity-75 d-block" style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">{{ $row->kop_master_peserta_code }}</small>
                                    <strong class="text-uppercase" style="font-size: 0.8rem;">{{ $row->kop_master_peserta_name }}</strong>
                                </td>
                                <td class="fw-semibold">{{ $row->barang_nama }}</td>
                                <td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->harga_beli, 0, ',', '.') }}</td>
                                <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->bunga_koperasi ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->total_piutang, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.1); border: 1px solid var(--ent-grid-border); font-family: 'JetBrains Mono', monospace;">
                                        {{ $row->tenor_bulan }} Bulan
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->cicilan_per_bulan, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if(strtoupper(trim($row->status_tagihan)) == 'DRAFT')
                                    @php
                                    $phone = preg_replace('/[^0-9]/', '', $row->kop_master_peserta_no_hp ?? '');
                                    if (str_starts_with($phone, '0')) {
                                    $phone = '62' . substr($phone, 1);
                                    }

                                    $pesanWA = "Halo Sir ada Pengajuan Pembelian Barang \nAtas Nama*" . $row->kop_master_peserta_name . "*,\n\n"
                                    . "Berikut draf pengajuan kontrak pembelian barang Anda di Koperasi:\n"
                                    . "- *No. Nota:* " . $row->nota_nomor . "\n"
                                    . "- *Barang:* " . $row->barang_nama . "\n"
                                    . "- *Total Piutang:* Rp " . number_format($row->total_piutang, 0, ',', '.') . "\n"
                                    . "- *Tenor:* " . $row->tenor_bulan . " Bulan\n"
                                    . "- *Cicilan/Bln:* Rp " . number_format($row->cicilan_per_bulan, 0, ',', '.') . "\n\n"
                                    . "Mohon konfirmasi jika data sudah sesuai. Terima kasih!";
                                    @endphp

                                    <a href="https://wa.me/{{ $phone }}?text={{ urlencode($pesanWA) }}"
                                        target="_blank"
                                        class="btn btn-sm ent-btn ent-btn-success px-2 py-1"
                                        title="Kirim Konfirmasi via WhatsApp">
                                        <i class="fab fa-whatsapp me-1"></i> WA
                                    </a>
                                    @elseif(strtoupper(trim($row->status_tagihan)) == 'BELUM_LUNAS')
                                    <span class="ent-badge badge-status-belum">DISETUJUI</span>
                                    @elseif(strtoupper(trim($row->status_tagihan)) == 'LUNAS')
                                    <span class="ent-badge badge-status-lunas">SELESAI</span>
                                    @elseif(strtoupper(trim($row->status_tagihan)) == 'BATAL')
                                    <span class="ent-badge badge-status-batal">DIBATALKAN</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        if ($.isFunction($.fn.select2)) {
            $('.select2-peserta').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Cari NIP, Code, atau Nama Peserta...',
                allowClear: true
            });

            $('.select2-coa').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // Inisialisasi DataTables
        let logTable = $('#table-log-kontrak').DataTable({
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(disaring dari total _MAX_ data)",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            },
            pageLength: 10,
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [9]
            }]
        });

        // Filter Spesifik Berdasarkan Status
        $('#filter-status').on('change', function() {
            let selectedStatus = $(this).val();
            if (selectedStatus) {
                logTable.column(9).search('^' + selectedStatus + '$', true, false).draw();
            } else {
                logTable.column(9).search('').draw();
            }
        });

        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function formatNumberThousand(value) {
            let numberString = value.replace(/[^,\d]/g, '').toString();
            let split = numberString.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        }

        function cleanNumber(value) {
            if (!value) return 0;
            return parseFloat(value.toString().replace(/\./g, '').replace(',', '.')) || 0;
        }

        $(document).on('keyup input', '.rupiah-input', function() {
            let formatted = formatNumberThousand($(this).val());
            $(this).val(formatted);
        });

        // Event Handler saat klik kalkulasi
        $('#btn-kalkulasi-simulasi').on('click', function() {
            let anggota = $('#anggota_id').val();
            let barang = $('#barang_nama').val();
            let tgl = $('#tanggal_transaksi').val();

            let hargaBeli = cleanNumber($('#harga_beli').val());
            let biayaAdmin = cleanNumber($('#biaya_admin').val());
            let bungaKoperasi = cleanNumber($('#bunga_koperasi').val());
            let tenor = parseInt($('#tenor_bulan').val()) || 1;

            let coaPiutang = $('#coa_piutang').val();
            let bankCoa = $('#sumber_dana_coa').val();
            let coaAdmin = $('#coa_pendapatan_admin').val();
            let coaBunga = $('#coa_pendapatan_bunga').val();

            if (!anggota || !barang || hargaBeli <= 0) {
                Swal.fire({
                    title: 'Form Belum Lengkap',
                    text: 'Pastikan Anda telah memilih peserta, menginput barang, dan harga real barang.',
                    icon: 'warning'
                });
                return;
            }

            if (!coaPiutang || !bankCoa || !coaAdmin || !coaBunga) {
                Swal.fire({
                    title: 'COA Jurnal Belum Dipilih',
                    text: 'Silahkan tentukan Akun Piutang, Kas/Bank, Admin, dan Bunga pada tabel Draft Jurnal Akuntansi.',
                    icon: 'warning'
                });
                return;
            }

            let kasKeluarNetto = hargaBeli;
            let piutangAwalJurnal = hargaBeli + biayaAdmin;
            let totalKewajibanAnggota = hargaBeli + biayaAdmin + bungaKoperasi;
            let cicilanPerBulan = Math.round(totalKewajibanAnggota / tenor);

            let pokokDanAdminPerBulan = Math.floor(piutangAwalJurnal / tenor);
            let sisaPokokAkhir = piutangAwalJurnal - (pokokDanAdminPerBulan * tenor);

            let bungaPerBulan = Math.floor(bungaKoperasi / tenor);
            let sisaBungaAkhir = bungaKoperasi - (bungaPerBulan * tenor);

            $('#lbl-total-piutang').text(formatRupiah(totalKewajibanAnggota));
            $('#lbl-tenor').text(tenor + ' Bln');
            $('#lbl-cicilan-bulanan').text(formatRupiah(cicilanPerBulan));

            $('#j-debit-piutang').text(formatRupiah(piutangAwalJurnal));
            $('#j-kredit-kas').text(formatRupiah(kasKeluarNetto));
            $('#j-kredit-admin').text(formatRupiah(biayaAdmin));
            $('#j-kredit-margin').text(formatRupiah(bungaKoperasi));

            let htmlTimeline = '';
            let startDate = new Date(tgl);

            for (let i = 1; i <= tenor; i++) {
                let dueDate = new Date(startDate.getTime());
                dueDate.setMonth(startDate.getMonth() + i);

                let day = dueDate.getDate().toString().padStart(2, '0');
                let month = (dueDate.getMonth() + 1).toString().padStart(2, '0');
                let year = dueDate.getFullYear();
                let formattedDate = `${day}-${month}-${year}`;

                let currentPokok = (i === tenor) ? (pokokDanAdminPerBulan + sisaPokokAkhir) : pokokDanAdminPerBulan;
                let currentBunga = (i === tenor) ? (bungaPerBulan + sisaBungaAkhir) : bungaPerBulan;
                let currentTotal = currentPokok + currentBunga;

                htmlTimeline += `
                    <tr>
                        <td class="fw-semibold opacity-75">Angsuran Ke-${i}</td>
                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;"><i class="far fa-calendar-check me-2 opacity-50"></i>${formattedDate}</td>
                        <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(currentPokok)}</td>
                        <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(currentBunga)}</td>
                        <td class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(currentTotal)}</td>
                    </tr>
                `;
            }

            $('#simulasi-tenor-tbody').html(htmlTimeline);
            $('#btn-submit-final-pembelian').removeClass('d-none');
        });

        // Simpan Data Melalui AJAX
        $('#btn-submit-final-pembelian').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Kontrak',
                text: "Dokumen pembelian barang ini akan dikonfirmasi. Jadwal tagihan bulanan peserta akan langsung diaktifkan otomatis.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Terbitkan Kontrak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Kontrak',
                        text: 'Silahkan tunggu, sistem sedang menjadwalkan piutang...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    let payloadData = {};
                    let rawArray = $('#form-pembelian-barang').serializeArray();

                    $.each(rawArray, function(_, field) {
                        if (field.name === 'harga_beli' || field.name === 'biaya_admin' || field.name === 'bunga_koperasi') {
                            payloadData[field.name] = cleanNumber(field.value);
                        } else {
                            payloadData[field.name] = field.value;
                        }
                    });

                    $.ajax({
                        url: `{{ route('menu_koperasi_pembelian_barang_anggota_save') }}`,
                        type: "POST",
                        data: payloadData,
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal Menyimpan', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let errorMsg = 'Terjadi masalah interkoneksi ke database server.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire('Error Transaksi', errorMsg, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
