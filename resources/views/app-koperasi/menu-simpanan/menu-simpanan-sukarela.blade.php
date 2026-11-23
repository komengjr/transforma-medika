@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (SIMPANAN SUKARELA)
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
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #0f172a;
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
        background-color: var(--bs-body-bg, var(--ent-surface));
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

    /* Adaptive Floating Filters & Form Controls */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom label {
        position: absolute;
        top: 5px;
        left: 11px;
        font-size: 0.64rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        pointer-events: none;
        z-index: 6;
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

    .ent-input,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding-top: 18px !important;
        padding-bottom: 5px !important;
        padding-left: 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-modal-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-modal-form .form-control,
    .ent-modal-form .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
    }

    .ent-modal-form .form-control:not(textarea),
    .ent-modal-form .form-select {
        height: 40px !important;
    }

    .ent-modal-form .form-control:focus,
    .ent-modal-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-modal-form .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
        font-size: 0.8rem;
    }

    .ent-modal-form .input-group > .form-control {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    /* Select2 Custom Enterprise Integration */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding: 18px 34px 4px 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
        min-height: 44px !important;
        display: flex !important;
        align-items: center !important;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }

    .ent-modal-form .select2-container--bootstrap-5 .select2-selection--single {
        padding: 6px 34px 6px 12px !important;
        height: 40px !important;
        min-height: 40px !important;
        font-size: 0.82rem !important;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection--single,
    .select2-container--bootstrap-5.select2-container--open .select2-selection--single {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        padding: 0 !important;
        line-height: 1.25 !important;
        color: var(--bs-body-color) !important;
        font-weight: 600 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color) !important;
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.18) !important;
        overflow: hidden;
        z-index: 1075;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
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
        color: var(--bs-body-color) !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--ent-indigo) !important;
    }

    /* Avatar Peserta */
    .peserta-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.18), rgba(2, 132, 199, 0.18));
        border: 1px solid rgba(99, 102, 241, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #6366f1;
        font-size: 0.75rem;
        flex-shrink: 0;
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

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS & SOLID ACTION BUTTON
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 13px 12px;
        letter-spacing: 0.04em;
    }

    .table-custom thead th:first-child {
        border-left: none !important;
    }

    .table-custom thead th:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
        height: 1px;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td:not(.action-cell-full) {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    /* SOLID FULL-CELL ACTION BUTTON STYLING (NON-TRANSPARENT) */
    .table-custom td.action-cell-full {
        padding: 0 !important;
        height: 100%;
        vertical-align: stretch !important;
        background-color: var(--ent-action-bg) !important;
    }

    .table-custom td.action-cell-full>.btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 100% !important;
        min-height: 52px;
        border-radius: 0 !important;
        margin: 0 !important;
        border: none !important;
        background-color: var(--ent-action-bg) !important;
        color: var(--ent-action-color) !important;
        opacity: 1 !important;
        box-shadow: inset 0 0 0 1px rgba(79, 70, 229, 0.16);
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .table-custom td.action-cell-full>.btn:hover,
    .table-custom tbody tr:hover td.action-cell-full>.btn {
        background-color: var(--ent-action-hover-bg) !important;
        color: var(--ent-action-hover-color) !important;
        opacity: 1 !important;
    }

    .ent-card-body-flush {
        padding: 0 !important;
        margin: 0 !important;
    }

    .ent-card-body-flush .table-responsive {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    /* Modal Enterprise Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, #ffffff) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    .ent-member-highlight {
        background: rgba(79, 70, 229, 0.06);
        border: 1px solid var(--ent-grid-border);
        border-left: 4px solid var(--ent-indigo) !important;
        border-radius: 10px;
        padding: 10px 14px;
    }

    .ent-empty-icon {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        background: rgba(79, 70, 229, 0.1);
        border: 1px solid var(--ent-grid-border);
        color: var(--ent-indigo);
        display: inline-flex;
        align-items: center;
        justify-content: center;
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
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-wallet fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-exchange-alt me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} WALLET
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Simpanan Sukarela Anggota</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Transaksi &amp; Pengelolaan Saldo Sukarela Anggota</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola setoran, penarikan tunai, pemotongan voucher, serta saldo berjalan simpanan sukarela anggota.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flash Alert -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert" style="border: 1px solid rgba(16, 185, 129, 0.35);">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert" style="border: 1px solid rgba(225, 29, 72, 0.35);">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- FILTER CABANG & PENCARIAN -->
<div class="ent-card ent-table-surface mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <h6 class="card-title mb-0 fw-bold">
            <i class="fas fa-filter text-primary me-2"></i>Filter Cabang &amp; Data Anggota
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="form-floating-custom">
                    <label for="select-cabang">1. Filter Cabang Koperasi</label>
                    <select id="select-cabang" class="form-select ent-input select2-search">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($list_cabang as $cabang)
                        <option value="{{ $cabang->kop_master_cabang_code }}">{{ $cabang->kop_master_cabang_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-floating-custom">
                    <label for="search-sukarela">2. Cari No. Anggota / Nama Lengkap</label>
                    <input type="text" id="search-sukarela" class="form-control ent-input" placeholder="Ketik nomor atau nama anggota...">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EMPTY / STATUS PLACEHOLDER -->
<div id="status-sukarela" class="ent-card ent-table-surface py-5 px-3 text-center mb-3">
    <div class="card-body">
        <div class="ent-empty-icon mb-3">
            <i class="fas fa-coins fa-2x"></i>
        </div>
        <h6 class="fw-bold mb-1">Filter Cabang Belum Dipilih</h6>
        <p class="mb-0 opacity-75 small">Silakan pilih <strong>Cabang Koperasi</strong> terlebih dahulu untuk menampilkan saldo sukarela anggota.</p>
    </div>
</div>

<!-- TABLE UTAMA -->
<div id="card-tabel" class="ent-card ent-table-surface d-none mb-3">
    <div class="card-header py-3 px-3 px-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-users text-primary"></i>
            <h6 class="mb-0 fw-bold">Daftar Saldo Sukarela - Cabang: <strong class="text-primary" id="label-cabang-sukarela">-</strong></h6>
        </div>
    </div>

    <div class="card-body ent-card-body-flush">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 6%;">#</th>
                        <th style="width: 20%;">No Anggota</th>
                        <th style="width: 44%;">Nama Lengkap</th>
                        <th class="text-end" style="width: 30%;">Saldo Sukarela Berjalan</th>
                    </tr>
                </thead>
                <tbody id="tabel-body"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TRANSAKSI -->
<div class="modal fade" id="modalTransaksi" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="form-mutasi-sukarela" action="{{ route('menu_koperasi_simpanan_sukarela_koperasi_bayar') }}" method="POST" class="modal-content modal-ent-content ent-modal-form">
            @csrf
            <input type="hidden" name="id_kop_master_peserta" id="modal-id-peserta">

            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="ent-badge mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.62rem;">
                        <i class="fas fa-exchange-alt me-1"></i> MUTASI SIMPANAN SUKARELA
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0">Form Mutasi Saldo</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="ent-member-highlight mb-3">
                    <small class="ent-modal-label d-block mb-0.5">Anggota Terpilih</small>
                    <div class="fw-bold text-uppercase" id="modal-nama-label" style="font-size: 0.9rem;">-</div>
                </div>

                <div class="mb-3">
                    <label class="form-label ent-modal-label">Jenis Perubahan Saldo <span class="text-danger">*</span></label>
                    <select name="jenis_transaksi" id="jenis_transaksi" class="form-select select2-modal" required>
                        <option value="SETORAN">SETORAN (Tambah Saldo / Uang Masuk)</option>
                        <option value="PENARIKAN">PENARIKAN (Tarik Tunai / Saldo Berkurang)</option>
                        <option value="POTONG_VOUCHER">POTONG VOUCHER (Bayar Belanjaan / Potong Saldo)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label ent-modal-label">Nominal Uang (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text fw-bold">Rp</span>
                        <input type="text" id="nominal-display" class="form-control fw-bold text-primary" placeholder="Contoh: 50.000" style="font-family: 'JetBrains Mono', monospace;" required>
                        <input type="number" name="nominal" id="nominal-raw" class="d-none" min="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label ent-modal-label">Metode Keuangan (Kas/Bank) <span class="text-danger">*</span></label>
                    <select name="coa_kas_bank" id="coa_kas_bank" class="form-select select2-modal" required>
                        @foreach($coa_pembayaran as $coa)
                        <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label ent-modal-label">Akun Rekening Sukarela <span class="text-danger">*</span></label>
                    <select name="coa_sukarela" id="coa_sukarela" class="form-select select2-modal" required>
                        @foreach($coa_sukarela as $coa)
                        <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-1">
                    <label class="form-label ent-modal-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan transaksi..."></textarea>
                </div>
            </div>

            <div class="modal-footer px-4 py-3 d-flex justify-content-end gap-2" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn ent-btn ent-btn-success px-4">
                    <i class="fas fa-check-circle me-1"></i> Proses Pemutakhiran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (function ensureSelect2Loaded(callback) {
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
    })(function() {
        $(function() {
            const commonOpts = {
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

            $('.select2-search').each(function() {
                const placeholderText = $(this).find('option:first').text() || '-- Pilih --';
                $(this).select2({
                    ...commonOpts,
                    placeholder: placeholderText
                });
            });

            $('.select2-modal').each(function() {
                const placeholderText = $(this).find('option:first').text() || '-- Pilih --';
                $(this).select2({
                    ...commonOpts,
                    placeholder: placeholderText,
                    dropdownParent: $('#modalTransaksi')
                });
            });

            $('#select-cabang').on('change', function() {
                handleCabangChange(this.value);
            });
        });
    });

    function resolvePesertaPhotoUrl(rawPhoto) {
        if (!rawPhoto) return '';
        let clean = rawPhoto.toString().replace(/\\/g, '/').trim().replace(/^\/+/, '');
        if (!clean) return '';
        if (clean.startsWith('http://') || clean.startsWith('https://')) {
            return clean;
        }
        if (clean.includes('koperasi/profile/')) {
            let filename = clean.split('/').pop();
            return `{{ url('/koperasi/peserta/foto') }}/${encodeURIComponent(filename)}`;
        }
        if (!clean.startsWith('storage/') && !clean.startsWith('uploads/')) {
            clean = 'storage/koperasi/profile/' + clean;
        }
        return `{{ url('/') }}/${clean}`;
    }

    function formatRibuan(value) {
        let digits = (value || '').toString().replace(/[^0-9]/g, '');
        if (!digits) return '';
        return parseInt(digits, 10).toLocaleString('id-ID');
    }

    document.getElementById('nominal-display').addEventListener('input', function() {
        let digits = this.value.replace(/[^0-9]/g, '');
        this.value = digits ? parseInt(digits, 10).toLocaleString('id-ID') : '';
        document.getElementById('nominal-raw').value = digits ? parseInt(digits, 10) : '';
    });

    document.getElementById('form-mutasi-sukarela').addEventListener('submit', function(e) {
        let digits = document.getElementById('nominal-display').value.replace(/[^0-9]/g, '');
        let num = parseInt(digits, 10) || 0;
        document.getElementById('nominal-raw').value = num > 0 ? num : '';
        if (num <= 0) {
            e.preventDefault();
            Swal.fire('Perhatian', 'Masukkan nominal uang lebih dari 0.', 'warning');
        }
    });

    function filterSukarelaRows() {
        const kw = (document.getElementById('search-sukarela').value || '').toString().trim().toLowerCase();
        const rows = document.querySelectorAll('#tabel-body tr[data-search]');
        rows.forEach(row => {
            const hay = (row.getAttribute('data-search') || '').toLowerCase();
            row.style.display = (!kw || hay.includes(kw)) ? '' : 'none';
        });
    }

    document.getElementById('search-sukarela').addEventListener('input', filterSukarelaRows);

    function handleCabangChange(cabangVal) {
        const cabang = (cabangVal || '').toString();
        const cardTabel = document.getElementById('card-tabel');
        const statusEl = document.getElementById('status-sukarela');
        const tabelBody = document.getElementById('tabel-body');
        const labelCabang = document.getElementById('label-cabang-sukarela');

        if (!cabang) {
            cardTabel.classList.add('d-none');
            statusEl.classList.remove('d-none');
            statusEl.innerHTML = `
                <div class="card-body">
                    <div class="ent-empty-icon mb-3">
                        <i class="fas fa-coins fa-2x"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Filter Cabang Belum Dipilih</h6>
                    <p class="mb-0 opacity-75 small">Silakan pilih <strong>Cabang Koperasi</strong> terlebih dahulu untuk menampilkan saldo sukarela anggota.</p>
                </div>
            `;
            return;
        }

        statusEl.classList.remove('d-none');
        statusEl.innerHTML = `
            <div class="card-body py-4">
                <div class="spinner-border text-primary me-2" role="status"></div>
                <span class="fw-semibold">Memuat data saldo sukarela anggota...</span>
            </div>
        `;
        cardTabel.classList.add('d-none');

        fetch(`{{ route('menu_koperasi_simpanan_sukarela_koperasi_get_data') }}?cabang=${encodeURIComponent(cabang)}`)
            .then(res => res.json())
            .then(res => {
                tabelBody.innerHTML = '';
                if (res.data && res.data.length > 0) {
                    statusEl.classList.add('d-none');
                    labelCabang.textContent = cabang.toUpperCase();

                    res.data.forEach(item => {
                        let formattedSaldo = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(item.saldo_sukarela || 0);

                        const safeName = (item.kop_master_peserta_name || 'AG').toString();
                        const initial = safeName.substring(0, 2).toUpperCase();
                        const photoUrl = resolvePesertaPhotoUrl(item.kop_master_peserta_photo);
                        const photoHtml = photoUrl
                            ? `<img src="${photoUrl}" alt="${safeName}" class="rounded-3 object-fit-cover flex-shrink-0" style="width: 36px; height: 36px; border: 1px solid var(--ent-grid-border);" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"><div class="peserta-avatar" style="display: none;">${initial}</div>`
                            : `<div class="peserta-avatar">${initial}</div>`;

                        const escapedName = safeName.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
                        const searchText = `${item.kop_master_peserta_code || ''} ${safeName}`.toLowerCase();

                        let row = `
                            <tr data-search="${searchText.replace(/"/g, '&quot;')}">
                                <td class="action-cell-full text-center align-middle">
                                    <button type="button" class="btn"
                                            onclick="bukaModalTransaksi(${item.id_kop_master_peserta}, '${escapedName}')"
                                            title="Mutasi Saldo">
                                        <i class="fas fa-exchange-alt me-1"></i> Mutasi
                                    </button>
                                </td>
                                <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">${item.kop_master_peserta_code}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        ${photoHtml}
                                        <div class="fw-bold text-uppercase" style="font-size: 0.82rem;">${safeName}</div>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">${formattedSaldo}</td>
                            </tr>
                        `;
                        tabelBody.insertAdjacentHTML('beforeend', row);
                    });

                    cardTabel.classList.remove('d-none');
                    filterSukarelaRows();
                } else {
                    statusEl.classList.remove('d-none');
                    statusEl.innerHTML = `
                        <div class="card-body py-4">
                            <p class="mb-0">Tidak ada anggota di cabang <strong>${cabang}</strong>.</p>
                        </div>
                    `;
                    cardTabel.classList.add('d-none');
                }
            })
            .catch(err => {
                console.error(err);
                statusEl.classList.remove('d-none');
                statusEl.innerHTML = `
                    <div class="card-body py-4">
                        <span class="text-danger fw-semibold">Gagal memuat data dari server.</span>
                    </div>
                `;
            });
    }

    function bukaModalTransaksi(id, nama) {
        document.getElementById('modal-id-peserta').value = id;
        document.getElementById('modal-nama-label').textContent = nama;
        document.getElementById('nominal-display').value = '';
        document.getElementById('nominal-raw').value = '';

        if (window.jQuery && $.fn.select2) {
            $('#jenis_transaksi').val('SETORAN').trigger('change');
            const firstKas = $('#coa_kas_bank option:first').val() || '';
            const firstSukarela = $('#coa_sukarela option:first').val() || '';
            $('#coa_kas_bank').val(firstKas).trigger('change');
            $('#coa_sukarela').val(firstSukarela).trigger('change');
        }

        let modalEl = new bootstrap.Modal(document.getElementById('modalTransaksi'));
        modalEl.show();
    }
</script>
@endsection
