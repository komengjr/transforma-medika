@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (SIMPANAN POKOK)
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

    .ent-btn-activate {
        background: linear-gradient(135deg, #0284c7 0%, #4f46e5 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    }

    .ent-btn-activate:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(2, 132, 199, 0.38);
        color: #ffffff;
    }

    .ent-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
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
        z-index: 5;
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
        height: 40px !important;
        padding: 6px 12px !important;
        transition: all 0.2s ease;
    }

    .ent-modal-form .form-control[readonly] {
        background-color: rgba(79, 70, 229, 0.06) !important;
        opacity: 0.9;
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

    .ent-modal-form .input-group>.form-control {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
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

    .badge-lunas {
        background-color: rgba(16, 185, 129, 0.15) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .badge-pending {
        background-color: rgba(245, 158, 11, 0.16) !important;
        color: #d97706 !important;
        border: 1px solid rgba(245, 158, 11, 0.38);
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS & ACTION BUTTONS
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

    .table-custom td.action-cell-full>.action-btn-group {
        display: flex;
        width: 100%;
        height: 100%;
        min-height: 52px;
    }

    .table-custom td.action-cell-full .btn-action-cell {
        display: flex !important;
        align-items: center;
        justify-content: center;
        flex: 1 1 0;
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
        font-size: 0.78rem;
        font-weight: 600;
        padding: 6px 10px;
        white-space: nowrap;
    }

    .table-custom td.action-cell-full .btn-action-cell:hover:not(:disabled),
    .table-custom tbody tr:hover td.action-cell-full .btn-action-cell:not(:disabled) {
        background-color: var(--ent-action-hover-bg) !important;
        color: var(--ent-action-hover-color) !important;
        opacity: 1 !important;
    }

    .table-custom td.action-cell-full .btn-trigger-aktifkan-single {
        background-color: rgba(2, 132, 199, 0.14) !important;
        color: #0284c7 !important;
    }

    [data-bs-theme="dark"] .table-custom td.action-cell-full .btn-trigger-aktifkan-single,
    .dark .table-custom td.action-cell-full .btn-trigger-aktifkan-single {
        color: #38bdf8 !important;
    }

    .table-custom td.action-cell-full .btn-trigger-aktifkan-single:hover:not(:disabled) {
        background-color: #0284c7 !important;
        color: #ffffff !important;
    }

    .table-custom td.action-cell-full .btn-action-cell:disabled {
        background-color: rgba(16, 185, 129, 0.12) !important;
        color: #10b981 !important;
        opacity: 1 !important;
        cursor: default;
    }

    .peserta-checkbox {
        width: 17px;
        height: 17px;
        cursor: pointer;
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
        border-left: 4px solid var(--ent-emerald) !important;
        border-radius: 10px;
        padding: 12px 14px;
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
                            <i class="fas fa-piggy-bank fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-wallet me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} SAVING
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Simpanan Pokok Awal</span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: white;">Menu Simpanan Pokok Awal Anggota</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola setoran simpanan pokok pendaftaran anggota baru, aktivasi peserta, dan alokasi jurnal COA.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <span class="ent-badge px-3 py-2" style="background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7; font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                            <i class="fas fa-tag me-1"></i> Tarif Pokok: Rp {{ number_format($nominal_simpanan_pokok, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert" style="border: 1px solid rgba(16, 185, 129, 0.35);">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- KARTU FILTER CABANG -->
<div class="ent-card ent-table-surface mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h6 class="card-title mb-0 fw-bold">
                <i class="fas fa-filter text-primary me-2"></i>Filter Cabang Koperasi
            </h6>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-8">
                <div class="form-floating-custom">
                    <label for="select-cabang">1. Pilih Cabang Koperasi</label>
                    <select id="select-cabang" class="form-select ent-input">
                        <option value="">-- Pilih Cabang Terlebih Dahulu --</option>
                        @foreach($list_cabang as $cabang)
                        <option value="{{ $cabang->kop_master_cabang_code }}">{{ $cabang->kop_master_cabang_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating-custom">
                    <label for="search-peserta-pokok">2. Cari Nama / Kode / NIK</label>
                    <input type="text" id="search-peserta-pokok" class="form-control ent-input" placeholder="Ketik nama, kode, atau NIK...">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTAINER PESAN LOADING / PROMPT AWAL -->
<div id="status-message" class="ent-card ent-table-surface py-5 px-3 text-center mb-3">
    <div class="card-body">
        <div class="ent-empty-icon mb-3">
            <i class="fas fa-building fa-2x"></i>
        </div>
        <h6 class="fw-bold mb-1">Filter Cabang Belum Dipilih</h6>
        <p class="mb-0 opacity-75 small">Silakan tentukan filter <strong>Cabang Koperasi</strong> terlebih dahulu pada form di atas untuk menampilkan data anggota.</p>
    </div>
</div>

<!-- KARTU DATA ANGGOTA (Akan disembunyikan sampai cabang dipilih) -->
<div id="card-peserta" class="ent-card ent-table-surface d-none">
    <div class="card-header py-3 px-3 px-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-users text-primary"></i>
            <h6 class="mb-0 fw-bold">Daftar Anggota Koperasi - Cabang: <strong class="text-primary" id="label-cabang">-</strong></h6>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <button type="button" id="btn-aktifkan-peserta-massal" class="btn ent-btn ent-btn-activate px-3 py-2" disabled onclick="aktifkanPesertaTerpilih()">
                <i class="fas fa-user-check me-1"></i> Aktifkan Peserta Koperasi <span class="badge bg-white text-dark ms-1" id="selected-peserta-count">0</span>
            </button>
            <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3); font-family: 'JetBrains Mono', monospace;">
                Tarif Pokok: Rp {{ number_format($nominal_simpanan_pokok, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <div class="card-body ent-card-body-flush">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">
                            <input type="checkbox" id="check-all-peserta" class="form-check-input peserta-checkbox" title="Pilih semua peserta belum aktif yang tampil" onchange="togglePilihSemuaPeserta(this)">
                        </th>
                        <th class="text-center" style="width: 18%;">Aksi</th>
                        <th style="width: 16%;">Kode Anggota</th>
                        <th style="width: 26%;">Nama Lengkap</th>
                        <th style="width: 18%;">NIK / NIP</th>
                        <th class="text-center" style="width: 18%;">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody id="tabel-peserta-body">
                    <!-- Data peserta akan dimasukkan di sini oleh JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL PROSES PEMBAYARAN & COA -->
<div class="modal fade" id="modalBayar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalBayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="ent-badge mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.62rem;">
                        <i class="fas fa-coins me-1"></i> SETORAN SIMPANAN POKOK
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0" id="modalBayarLabel">Konfirmasi Pembayaran Simpanan Pokok</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-pembayaran-pokok" method="POST" class="ent-modal-form">
                @csrf
                <div class="modal-body p-4">
                    <!-- Informasi Anggota Ringkas -->
                    <div class="ent-member-highlight mb-3">
                        <div class="fw-bold text-uppercase" id="modal-nama-anggota" style="font-size: 0.9rem;">-</div>
                        <small class="opacity-75" id="modal-kode-anggota" style="font-family: 'JetBrains Mono', monospace;">-</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label ent-modal-label">Nominal Simpanan Pokok</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">Rp</span>
                            <input type="text" class="form-control fw-bold text-success" value="{{ number_format($nominal_simpanan_pokok, 0, ',', '.') }}" style="font-family: 'JetBrains Mono', monospace;" readonly>
                            <input type="hidden" name="nominal_pokok" value="{{ $nominal_simpanan_pokok }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label ent-modal-label">Tanggal Menjadi Anggota Koperasi</label>
                        <input type="date" name="tanggal_anggota" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Pilihan COA Pembayaran (Asset / Kas-Bank) -->
                    <div class="mb-3">
                        <label for="coa_pembayaran" class="form-label ent-modal-label">Diterima Melalui (Akun Kas / Bank) <span class="text-danger">*</span></label>
                        <select name="coa_pembayaran" id="coa_pembayaran" class="form-select" required>
                            <option value="">-- Pilih Akun Kas / Bank --</option>
                            @foreach($coa_pembayaran as $coa)
                            <option value="{{ $coa->coa_code }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }}
                            </option>
                            @endforeach
                        </select>
                        <small class="opacity-75 d-block mt-1" style="font-size: 0.7rem;">Akun debit untuk mencatat masuknya uang pendaftaran.</small>
                    </div>

                    <!-- Pilihan COA Ekuitas / Hutang Pokok -->
                    <div class="mb-1">
                        <label for="coa_simpanan" class="form-label ent-modal-label">Alokasi Akun (Ekuitas / Hutang Simpanan) <span class="text-danger">*</span></label>
                        <select name="coa_simpanan" id="coa_simpanan" class="form-select" required>
                            <option value="">-- Pilih Akun Simpanan --</option>
                            @foreach($coa_simpanan as $coa)
                            <option value="{{ $coa->coa_code }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }}
                            </option>
                            @endforeach
                        </select>
                        <small class="opacity-75 d-block mt-1" style="font-size: 0.7rem;">Akun kredit penyeimbang transaksi modal/kewajiban.</small>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 d-flex justify-content-end gap-2" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-success px-4">
                        <i class="fas fa-save me-1"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const URL_AKTIFKAN_PESERTA = "{{ Route::has('menu_koperasi_simpanan_pokok_aktifkan_peserta') ? route('menu_koperasi_simpanan_pokok_aktifkan_peserta') : url('/koperasi/menu-koperasi/simpanan-pokok/aktifkan-peserta') }}";

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

    function getCheckedPesertaIds() {
        return Array.from(document.querySelectorAll('#tabel-peserta-body tr:not([style*="display: none"]) .peserta-checkbox:checked'))
            .map(cb => cb.value);
    }

    function syncPilihSemuaCheckbox() {
        const checkAll = document.getElementById('check-all-peserta');
        if (!checkAll) return;
        const visibleCheckboxes = Array.from(document.querySelectorAll('#tabel-peserta-body tr:not([style*="display: none"]) .peserta-checkbox'));
        if (visibleCheckboxes.length === 0) {
            checkAll.checked = false;
            checkAll.indeterminate = false;
            return;
        }
        const checkedCount = visibleCheckboxes.filter(cb => cb.checked).length;
        checkAll.checked = checkedCount === visibleCheckboxes.length;
        checkAll.indeterminate = checkedCount > 0 && checkedCount < visibleCheckboxes.length;
    }

    function updateTombolAktifkanMassal() {
        const selectedIds = getCheckedPesertaIds();
        const btn = document.getElementById('btn-aktifkan-peserta-massal');
        const counter = document.getElementById('selected-peserta-count');
        if (counter) counter.textContent = selectedIds.length;
        if (btn) btn.disabled = selectedIds.length === 0;
        syncPilihSemuaCheckbox();
    }

    function togglePilihSemuaPeserta(source) {
        const visibleCheckboxes = document.querySelectorAll('#tabel-peserta-body tr:not([style*="display: none"]) .peserta-checkbox');
        visibleCheckboxes.forEach(cb => {
            cb.checked = source.checked;
        });
        updateTombolAktifkanMassal();
    }

    function filterPesertaPokokRows() {
        const kw = (document.getElementById('search-peserta-pokok').value || '').toString().trim().toLowerCase();
        const rows = document.querySelectorAll('#tabel-peserta-body tr[data-search]');
        rows.forEach(row => {
            const hay = (row.getAttribute('data-search') || '').toLowerCase();
            const isMatch = !kw || hay.includes(kw);
            row.style.display = isMatch ? '' : 'none';
            if (!isMatch) {
                const cb = row.querySelector('.peserta-checkbox');
                if (cb) cb.checked = false;
            }
        });
        updateTombolAktifkanMassal();
    }

    function notifyUser(icon, title, text) {
        if (typeof Swal !== 'undefined') {
            return Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonColor: '#4f46e5'
            });
        }
        alert(`${title}: ${text}`);
        return Promise.resolve();
    }

    function confirmActivation(title, htmlText) {
        if (typeof Swal !== 'undefined') {
            return Swal.fire({
                title: title,
                html: htmlText,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0284c7',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fas fa-user-check me-1"></i> Ya, Aktifkan',
                cancelButtonText: 'Batal'
            }).then(res => res.isConfirmed);
        }
        return Promise.resolve(confirm(title));
    }

    function kirimAktivasiPeserta(ids) {
        const cabang = document.getElementById('select-cabang').value;
        const btnMassal = document.getElementById('btn-aktifkan-peserta-massal');
        if (btnMassal) btnMassal.disabled = true;

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Mengaktifkan Peserta...',
                text: 'Memperbarui status keanggotaan koperasi tanpa jurnal.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        }

        fetch(URL_AKTIFKAN_PESERTA, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ids: ids,
                id_kop_master_peserta: ids.length === 1 ? ids[0] : null,
                cabang: cabang
            })
        })
        .then(async response => {
            const data = await response.json().catch(() => ({}));
            if (!response.ok || data.status === 'error' || data.success === false) {
                throw new Error(data.message || 'Gagal mengaktifkan peserta koperasi.');
            }
            return data;
        })
        .then(async res => {
            await notifyUser('success', 'Berhasil Diaktifkan', res.message || `${ids.length} peserta koperasi berhasil diaktifkan.`);
            document.getElementById('select-cabang').dispatchEvent(new Event('change'));
        })
        .catch(err => {
            console.error(err);
            notifyUser('error', 'Gagal Mengaktifkan', err.message || 'Terjadi kesalahan sistem saat mengaktifkan peserta.');
            updateTombolAktifkanMassal();
        });
    }

    function aktifkanPesertaSatuan(id, nama, kode) {
        if (!id) return;
        confirmActivation(
            'Aktifkan Peserta Koperasi?',
            `Aktifkan peserta <strong class="text-uppercase">${nama}</strong> (<code>${kode}</code>) menjadi <strong>AKTIF</strong> tanpa masuk jurnal?`
        ).then(confirmed => {
            if (confirmed) {
                kirimAktivasiPeserta([id]);
            }
        });
    }

    function aktifkanPesertaTerpilih() {
        const ids = getCheckedPesertaIds();
        if (ids.length === 0) {
            notifyUser('warning', 'Belum Ada Peserta Dipilih', 'Centang minimal satu peserta koperasi terlebih dahulu.');
            return;
        }
        confirmActivation(
            'Aktifkan Peserta Terpilih?',
            `Anda akan mengaktifkan <strong>${ids.length} peserta koperasi</strong> sekaligus menjadi <strong>AKTIF</strong> tanpa masuk jurnal.`
        ).then(confirmed => {
            if (confirmed) {
                kirimAktivasiPeserta(ids);
            }
        });
    }

    document.getElementById('search-peserta-pokok').addEventListener('input', filterPesertaPokokRows);

    document.getElementById('select-cabang').addEventListener('change', function() {
        const cabang = this.value;
        const statusMessage = document.getElementById('status-message');
        const cardPeserta = document.getElementById('card-peserta');
        const labelCabang = document.getElementById('label-cabang');
        const tabelBody = document.getElementById('tabel-peserta-body');
        const checkAll = document.getElementById('check-all-peserta');

        if (checkAll) {
            checkAll.checked = false;
            checkAll.indeterminate = false;
        }
        updateTombolAktifkanMassal();

        if (!cabang) {
            cardPeserta.classList.add('d-none');
            statusMessage.classList.remove('d-none');
            statusMessage.innerHTML = `
                <div class="card-body">
                    <div class="ent-empty-icon mb-3">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Filter Cabang Belum Dipilih</h6>
                    <p class="mb-0 opacity-75 small">Silakan tentukan filter <strong>Cabang Koperasi</strong> terlebih dahulu.</p>
                </div>
            `;
            return;
        }

        statusMessage.classList.remove('d-none');
        statusMessage.innerHTML = `
            <div class="card-body py-4">
                <div class="spinner-border text-primary me-2" role="status"></div>
                <span class="fw-semibold">Memuat data peserta...</span>
            </div>
        `;
        cardPeserta.classList.add('d-none');
        tabelBody.innerHTML = '';

        fetch(`{{ route('menu_koperasi_simpanan_pokok_get_data') }}?cabang=${encodeURIComponent(cabang)}`)
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success' && res.data.length > 0) {
                    statusMessage.classList.add('d-none');
                    labelCabang.textContent = cabang.toUpperCase();

                    res.data.forEach(item => {
                        const isAktif = item.kop_master_peserta_status === 'AKTIF';
                        const badgeClass = isAktif ? 'badge-lunas' : 'badge-pending';
                        const badgeText = isAktif ? 'Lunas (Aktif)' : 'Belum Bayar (Pending)';
                        const safeName = (item.kop_master_peserta_name || 'AG').toString();
                        const escapedName = safeName.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                        const escapedCode = (item.kop_master_peserta_code || '').toString().replace(/"/g, '&quot;').replace(/'/g, '&#39;');

                        let checkboxCell = '';
                        let actionButton = '';
                        if (!isAktif) {
                            checkboxCell = `
                                <input type="checkbox"
                                       class="form-check-input peserta-checkbox"
                                       value="${item.id_kop_master_peserta}"
                                       onchange="updateTombolAktifkanMassal()"
                                       title="Pilih peserta untuk diaktifkan">
                            `;
                            actionButton = `
                                <div class="action-btn-group">
                                    <button type="button"
                                            class="btn-action-cell btn-trigger-aktifkan-single"
                                            onclick="aktifkanPesertaSatuan('${item.id_kop_master_peserta}', '${escapedCode}', '${escapedName}')"
                                            title="Aktifkan Peserta Koperasi (Tanpa Jurnal)">
                                        <i class="fas fa-user-check me-1"></i> Aktifkan
                                    </button>
                                    <button type="button"
                                            class="btn-action-cell btn-trigger-bayar"
                                            data-id="${item.id_kop_master_peserta}"
                                            data-nama="${escapedName}"
                                            data-kode="${escapedCode}"
                                            title="Bayar Simpanan Pokok & Jurnal">
                                        <i class="fas fa-coins me-1"></i> Bayar Pokok
                                    </button>
                                </div>
                            `;
                        } else {
                            checkboxCell = `<span class="opacity-25">-</span>`;
                            actionButton = `
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-cell" disabled>
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </button>
                                </div>
                            `;
                        }

                        const initial = safeName.substring(0, 2).toUpperCase();
                        const photoUrl = resolvePesertaPhotoUrl(item.kop_master_peserta_photo);

                        const photoHtml = photoUrl ?
                            `<img src="${photoUrl}" alt="${escapedName}" class="rounded-3 object-fit-cover flex-shrink-0" style="width: 36px; height: 36px; border: 1px solid var(--ent-grid-border);" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"><div class="peserta-avatar" style="display: none;">${initial}</div>` :
                            `<div class="peserta-avatar">${initial}</div>`;

                        const searchText = `${item.kop_master_peserta_code || ''} ${safeName} ${item.kop_master_peserta_nik || ''} ${item.kop_master_peserta_nip || ''}`.toLowerCase();

                        const row = `
                            <tr data-search="${searchText.replace(/"/g, '&quot;')}">
                                <td class="text-center align-middle">${checkboxCell}</td>
                                <td class="action-cell-full text-center align-middle">${actionButton}</td>
                                <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">${item.kop_master_peserta_code}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        ${photoHtml}
                                        <div class="fw-bold text-uppercase" style="font-size: 0.82rem;">${safeName}</div>
                                    </div>
                                </td>
                                <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                                    <span class="opacity-75">NIK: ${item.kop_master_peserta_nik ?? '-'}</span><br>
                                    <span class="opacity-75">NIP: ${item.kop_master_peserta_nip ?? '-'}</span>
                                </td>
                                <td class="text-center">
                                    <span class="ent-badge ${badgeClass}">${badgeText}</span>
                                </td>
                            </tr>
                        `;
                        tabelBody.insertAdjacentHTML('beforeend', row);
                    });

                    cardPeserta.classList.remove('d-none');
                    filterPesertaPokokRows();
                } else {
                    statusMessage.classList.remove('d-none');
                    statusMessage.innerHTML = `
                        <div class="card-body py-4">
                            <p class="mb-0">Tidak ditemukan data anggota di cabang <strong>${cabang}</strong>.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error(error);
                statusMessage.classList.remove('d-none');
                statusMessage.innerHTML = `
                    <div class="card-body py-4">
                        <span class="text-danger fw-semibold">Terjadi kesalahan sistem saat mengambil data.</span>
                    </div>
                `;
            });
    });

    document.addEventListener('click', function(event) {
        const btn = event.target.closest('.btn-trigger-bayar');
        if (btn) {
            const id = btn.getAttribute('data-id');
            const nama = btn.getAttribute('data-nama');
            const kode = btn.getAttribute('data-kode');

            document.getElementById('modal-nama-anggota').textContent = nama;
            document.getElementById('modal-kode-anggota').textContent = kode;

            const form = document.getElementById('form-pembayaran-pokok');
            form.setAttribute('action', `/koperasi/menu-koperasi/simpanan-pokok/bayar/${id}`);

            const modalBayar = new bootstrap.Modal(document.getElementById('modalBayar'));
            modalBayar.show();
        }
    });
</script>
@endsection
