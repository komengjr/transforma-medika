@extends('layouts.layouts')

@section('base.css')
<!-- Select2 CSS & Theme Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
        --ent-subtle-surface: #f8fafc;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-subtle-surface: #1e293b;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Header Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Cards */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 20px;
    }

    /* Badges & Code Chips */
    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .code-chip {
        font-family: 'JetBrains Mono', monospace;
        background-color: rgba(79, 70, 229, 0.1);
        color: #4338ca;
        border: 1px solid rgba(79, 70, 229, 0.25);
        padding: 2px 8px;
        border-radius: 7px;
        font-weight: 700;
        font-size: 0.72rem;
        display: inline-block;
    }

    [data-bs-theme="dark"] .code-chip,
    .dark .code-chip {
        background-color: rgba(129, 140, 248, 0.16);
        color: #a5b4fc;
        border-color: rgba(129, 140, 248, 0.32);
    }

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        font-size: 0.8rem;
        cursor: pointer;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover {
        color: #ffffff;
    }

    .ent-btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);
    }

    .ent-btn-warning:hover {
        color: #ffffff;
    }

    .ent-btn-light {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color, var(--ent-solid-text));
    }

    /* Form Controls & Labels */
    .ent-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
    }

    .ent-section-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--ent-indigo);
        border-bottom: 1px dashed var(--ent-grid-border);
        padding-bottom: 8px;
        margin-bottom: 14px;
    }

    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        font-size: 0.82rem !important;
        min-height: 40px;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .input-group > .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        background-color: var(--ent-subtle-surface) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        font-size: 0.82rem;
    }

    .input-group > .form-control {
        border-radius: 0 10px 10px 0 !important;
    }

    /* Select2 Searchable Styling */
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        min-height: 40px !important;
        display: flex !important;
        align-items: center !important;
        font-weight: 600 !important;
        font-size: 0.82rem !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        line-height: 1.4 !important;
        padding-left: 2px;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        overflow: hidden;
        z-index: 1060;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        padding: 6px 10px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        background-color: var(--ent-subtle-surface) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        padding: 8px 12px !important;
        color: var(--bs-body-color, var(--ent-solid-text));
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    /* Price Summary Box */
    .price-preview-box {
        border: 1px solid rgba(79, 70, 229, 0.3);
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.08) 0%, rgba(2, 132, 199, 0.08) 100%);
        padding: 12px 14px;
    }

    /* Table Styling */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.83rem;
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
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.83rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    /* Pagination Bar */
    .ent-pagination-bar {
        border-top: 1px solid var(--ent-grid-border);
        padding: 12px 18px;
        background-color: var(--ent-subtle-surface);
    }

    .page-item.active .page-link {
        background-color: var(--ent-indigo) !important;
        border-color: var(--ent-indigo) !important;
        color: #ffffff !important;
        border-radius: 8px;
    }

    .page-link {
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid var(--ent-grid-border);
        font-weight: 600;
        font-size: 0.78rem;
        padding: 5px 11px;
    }

    .page-item.disabled .page-link {
        opacity: 0.5;
    }

    /* Modal Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        color: #ffffff;
    }

    .ent-modal-footer {
        background-color: var(--ent-subtle-surface);
        border-top: 1px solid var(--ent-grid-border);
    }

    .pkg-item-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        transition: all 0.15s ease;
    }

    .pkg-item-card:hover {
        border-color: var(--ent-indigo);
        background-color: rgba(79, 70, 229, 0.05);
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 58px; height: 58px;">
                            <i class="fas fa-tags fs-4" style="color: #38bdf8;"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-file-invoice-dollar"></i> MANAJEMEN TARIF
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Billing &amp; Penjamin</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                                Setting Tarif &amp; Diskon Penjamin
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pengaturan tarif khusus, potongan harga, dan komposisi paket pemeriksaan per sub penjamin.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end d-flex flex-wrap justify-content-lg-end gap-2">
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Penjamin Utama</span>
                            <span class="fw-bold" style="color: #7dd3fc; font-family: 'JetBrains Mono', monospace;">{{ $penjaminList->count() }}</span>
                        </div>
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Master Layanan</span>
                            <span class="fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">{{ $pemeriksaanList->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- FORM INPUT (KIRI) -->
    <div class="col-lg-4">
        <div class="ent-card sticky-top" style="top: 20px; z-index: 10;">
            <div class="ent-card-header">
                <h6 class="mb-0 fw-bold"><i class="fas fa-sliders me-2 text-primary"></i>Form Pengaturan Tarif &amp; Diskon</h6>
                <small class="opacity-75">Pilih hierarki penjamin lalu tentukan diskon layanan.</small>
            </div>
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('penjamin-price.store') }}" method="POST" id="priceForm">
                    @csrf

                    <div class="ent-section-title">
                        <i class="fas fa-sitemap me-1"></i> 1. Hirarki Penjamin
                    </div>

                    <!-- PENJAMIN UTAMA (SEARCHABLE) -->
                    <div class="mb-3">
                        <label for="penjamin_id" class="ent-label">Penjamin Utama <span class="text-danger">*</span></label>
                        <select class="form-select select2-search" id="penjamin_id" name="penjamin_id" data-placeholder="Ketik atau pilih Penjamin Utama..." required>
                            <option value="">-- Pilih Penjamin Utama --</option>
                            @foreach($penjaminList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- SUB PENJAMIN (SEARCHABLE) -->
                    <div class="mb-4">
                        <label for="sub_penjamin_id" class="ent-label">Sub Penjamin <span class="text-danger">*</span></label>
                        <select class="form-select select2-search" id="sub_penjamin_id" name="sub_penjamin_id" data-placeholder="Ketik atau pilih Sub Penjamin..." disabled required>
                            <option value="">-- Pilih Sub Penjamin --</option>
                        </select>
                    </div>

                    <div class="ent-section-title">
                        <i class="fas fa-notes-medical me-1"></i> 2. Pemeriksaan &amp; Diskon
                    </div>

                    <!-- PILIH MASTER PEMERIKSAAN (SEARCHABLE) -->
                    <div class="mb-3">
                        <label for="master_pemeriksaan_id" class="ent-label">Pilih Pemeriksaan <span class="text-danger">*</span></label>
                        <select class="form-select select2-search" id="master_pemeriksaan_id" name="master_pemeriksaan_id" data-placeholder="Ketik kode atau nama pemeriksaan..." required>
                            <option value="" data-harga="0">-- Pilih Pemeriksaan --</option>
                            @foreach($pemeriksaanList as $item)
                            <option value="{{ $item->id }}" data-harga="{{ $item->harga }}" data-paket="{{ $item->is_paket }}">
                                {{ $item->nama_layanan }} ({{ $item->kode_layanan }}) - Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- INFO HARGA DASAR & NETT -->
                    <div class="price-preview-box mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small fw-semibold opacity-75">Harga Dasar Master:</span>
                            <span class="fw-bold" id="lblHargaDasar" style="font-family: 'JetBrains Mono', monospace;">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-1 border-top" style="border-color: var(--ent-grid-border) !important;">
                            <span class="small fw-bold text-primary">Estimasi Tarif Nett:</span>
                            <span class="fw-bold text-success fs-6" id="lblTarifNett" style="font-family: 'JetBrains Mono', monospace;">Rp 0</span>
                        </div>
                    </div>

                    <!-- DISKON -->
                    <div class="mb-4">
                        <label for="diskon" class="ent-label">Diskon / Potongan Harga (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">Rp</span>
                            <input type="text" class="form-control rupiah-input" id="diskon" name="diskon" value="0" autocomplete="off" style="font-family: 'JetBrains Mono', monospace;">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" id="btnReset" class="btn ent-btn ent-btn-light px-3 py-2">
                            <i class="fas fa-rotate-left me-1"></i> Reset
                        </button>
                        <button type="submit" id="btnSubmit" class="btn ent-btn ent-btn-primary w-100 py-2">
                            <i class="fas fa-save me-1"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TABEL DATA HARGA PENJAMIN (KANAN) -->
    <div class="col-lg-8">
        <div class="ent-card mb-4">
            <div class="ent-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h6 class="mb-0 fw-bold"><i class="fas fa-table-list me-2 text-primary"></i>Daftar Tarif &amp; Diskon Penjamin</h6>
                    <small class="opacity-75">Menampilkan maksimal 20 item per halaman beserta filter pencarian nama.</small>
                </div>
                <span class="ent-badge" style="background: rgba(5, 150, 105, 0.15); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.35);" id="totalBadge">
                    <i class="fas fa-database"></i> Total: 0 Data
                </span>
            </div>

            <!-- TOOLBAR AKSI & FILTER TIPE LAYANAN + CARI NAMA -->
            <div class="card-body p-3 border-bottom" style="border-color: var(--ent-grid-border) !important;">
                <div class="row align-items-end g-3">
                    <!-- FILTER CARI NAMA PEMERIKSAAN -->
                    <div class="col-md-4">
                        <label for="filter_cari_nama" class="ent-label">Cari Nama Pemeriksaan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-magnifying-glass opacity-75"></i></span>
                            <input type="text" id="filter_cari_nama" class="form-control ent-input" placeholder="Ketik nama atau kode..." autocomplete="off">
                        </div>
                    </div>

                    <!-- FILTER BERDASARKAN TIPE LAYANAN (SEARCHABLE) -->
                    <div class="col-md-4">
                        <label for="filter_tipe_layanan" class="ent-label">Filter Tipe Layanan</label>
                        <select id="filter_tipe_layanan" class="form-select select2-search" data-placeholder="Ketik atau pilih Tipe Layanan...">
                            <option value="">-- Semua Tipe Layanan --</option>
                            @foreach($tipeLayananList as $tl)
                            <option value="{{ $tl->id }}">{{ $tl->nama_tipe }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TOMBOL BULK ACTION -->
                    <div class="col-md-4 d-flex flex-wrap justify-content-md-end gap-2">
                        <button type="button" class="btn ent-btn ent-btn-warning px-3 py-2" id="btnOpenDefaultHarga">
                            <i class="fas fa-wand-magic-sparkles me-1"></i> Default Harga
                        </button>
                        <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" id="btnOpenSalinHarga">
                            <i class="fas fa-copy me-1 text-primary"></i> Salin Harga
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0 w-100">
                        <thead>
                            <tr>
                                <th style="width: 48px;" class="text-center">No</th>
                                <th>Kode / Nama Pemeriksaan</th>
                                <th>Tipe Layanan</th>
                                <th>Harga Dasar &amp; Diskon</th>
                                <th class="text-end">Tarif Nett</th>
                                <th style="width: 155px;" class="text-center">Aksi / Paket</th>
                            </tr>
                        </thead>
                        <tbody id="tablePenjaminBody">
                            <tr>
                                <td colspan="6" class="text-center py-5 opacity-75">
                                    <i class="fas fa-circle-info fs-3 d-block mb-2 text-primary"></i>
                                    <span class="fw-semibold">Silakan pilih Penjamin Utama dan Sub Penjamin terlebih dahulu untuk menampilkan data tarif.</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION 20 ITEM PER HALAMAN -->
                <div class="ent-pagination-bar d-flex flex-wrap justify-content-between align-items-center gap-2" id="paginationContainer" style="display: none !important;">
                    <div class="small fw-semibold opacity-75" id="paginationInfo">Menampilkan 0 - 0 dari 0 data</div>
                    <nav aria-label="Navigasi halaman tarif">
                        <ul class="pagination pagination-sm mb-0" id="paginationList"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL PILIH ITEM PEMERIKSAAN UNTUK PAKET -->
<div class="modal fade" id="modalPackageItems" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" id="modalPackageItemsLabel" style="color: white;">
                    <i class="fas fa-box-open me-2"></i>Pilih Detail Item Pemeriksaan Paket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert py-2 px-3 mb-3" style="background: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border); border-radius: 12px;">
                    <div class="fw-bold text-primary">Paket: <span id="modalPackageTitle"></span></div>
                    <small class="opacity-75">Ketik nama/kode pemeriksaan di bawah untuk mencari lalu centang item yang termasuk ke dalam paket ini.</small>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control ent-input" id="searchPackageItemInput" placeholder="Ketik nama atau kode layanan untuk memfilter daftar...">
                </div>

                <div class="row g-2" id="packageCheckboxList">
                    @foreach($pemeriksaanList as $p)
                    <div class="col-md-6 package-item-col" data-search="{{ strtolower($p->nama_layanan . ' ' . $p->kode_layanan) }}">
                        <div class="form-check pkg-item-card p-2 h-100 d-flex align-items-center ms-0">
                            <input class="form-check-input package-item-check ms-1 me-2" type="checkbox" value="{{ $p->id }}" id="check_{{ $p->id }}">
                            <label class="form-check-label w-100 cursor-pointer fw-semibold" for="check_{{ $p->id }}" style="font-size: 0.82rem;">
                                <span class="d-block">{{ $p->nama_layanan }}</span>
                                <span class="code-chip mt-1">{{ $p->kode_layanan }}</span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer ent-modal-footer px-4 py-3">
                <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn ent-btn ent-btn-primary px-4 py-2" id="btnSavePackageItems">
                    <i class="fas fa-check-circle me-1"></i> Simpan Item Paket
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL BUAT DEFAULT HARGA -->
<div class="modal fade" id="modalDefaultHarga" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fas fa-wand-magic-sparkles me-2"></i>Generate Default Harga
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert py-2 px-3 mb-3" style="background: rgba(2, 132, 199, 0.08); border: 1px solid rgba(2, 132, 199, 0.25); border-radius: 12px; font-size: 0.82rem;">
                    Fitur ini akan menyamakan tarif sub penjamin aktif ini dengan <strong>Harga Dasar (Master Pemeriksaan)</strong> tanpa diskon (Diskon = 0) untuk semua item pemeriksaan yang belum di-setting.
                </div>
                <p class="fw-semibold mb-0">Sub Penjamin Aktif: <span id="lblSubPenjaminDefault" class="fw-bold text-primary"></span></p>
            </div>
            <div class="modal-footer ent-modal-footer px-4 py-3">
                <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn ent-btn ent-btn-primary px-4 py-2" id="btnExecuteDefaultHarga">
                    <i class="fas fa-check-circle me-1"></i> Proses Generate
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SALIN HARGA DARI SUB PENJAMIN LAIN -->
<div class="modal fade" id="modalSalinHarga" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fas fa-copy me-2"></i>Salin Harga dari Sub Penjamin Lain
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label for="sumber_sub_penjamin_id" class="ent-label">Pilih Sub Penjamin Sumber <span class="text-danger">*</span></label>
                    <select class="form-select select2-modal-salin" id="sumber_sub_penjamin_id" data-placeholder="Ketik nama sub penjamin atau penjamin...">
                        <option value="">-- Pilih Sub Penjamin Sumber --</option>
                    </select>
                </div>
                <small class="opacity-75 d-block">Semua data tarif dan diskon dari sub penjamin sumber akan diduplikasi ke sub penjamin yang sedang aktif saat ini.</small>
            </div>
            <div class="modal-footer ent-modal-footer px-4 py-3">
                <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn ent-btn ent-btn-primary px-4 py-2" id="btnExecuteSalinHarga">
                    <i class="fas fa-check-circle me-1"></i> Salin Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Select2 & SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.select2-search').each(function() {
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: $(this).data('placeholder') || '-- Pilih Data --',
                allowClear: true
            });
        });

        $('#sumber_sub_penjamin_id').select2({
            theme: 'bootstrap-5',
            width: '100%',
            dropdownParent: $('#modalSalinHarga'),
            placeholder: 'Ketik nama sub penjamin sumber...',
            allowClear: true
        });

        const penjaminSelect = $('#penjamin_id');
        const subPenjaminSelect = $('#sub_penjamin_id');
        const tipeLayananFilter = $('#filter_tipe_layanan');
        const cariNamaFilter = $('#filter_cari_nama');
        const masterPemeriksaanSelect = $('#master_pemeriksaan_id');
        const lblHargaDasar = $('#lblHargaDasar');
        const lblTarifNett = $('#lblTarifNett');
        const diskonInput = $('#diskon');

        const tableBody = $('#tablePenjaminBody');
        const totalBadge = $('#totalBadge');
        const paginationContainer = $('#paginationContainer');
        const paginationInfo = $('#paginationInfo');
        const paginationList = $('#paginationList');
        const btnReset = $('#btnReset');
        const priceForm = $('#priceForm');
        const btnSubmit = $('#btnSubmit');
        const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

        const PAGE_SIZE = 20;
        let allFetchedRows = [];
        let filteredRows = [];
        let currentPage = 1;
        let selectedPackageMasterId = '';

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(number);
        }

        function formatRupiahInput(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString();
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

        function updatePricePreview() {
            const selectedOption = masterPemeriksaanSelect.find('option:selected');
            const harga = parseFloat(selectedOption.data('harga')) || 0;
            const rawDiskon = parseFloat(diskonInput.val().replace(/\./g, '')) || 0;
            const nett = Math.max(0, harga - rawDiskon);

            lblHargaDasar.text(formatRupiah(harga));
            lblTarifNett.text(formatRupiah(nett));
        }

        $(document).on('keyup change', '.rupiah-input', function() {
            let val = $(this).val();
            $(this).val(formatRupiahInput(val));
            updatePricePreview();
        });

        function applyNameFilterAndRender() {
            const keyword = (cariNamaFilter.val() || '').toLowerCase().trim();

            if (!keyword) {
                filteredRows = allFetchedRows.slice();
            } else {
                filteredRows = allFetchedRows.filter(row => {
                    const nama = String(row.nama_layanan || '').toLowerCase();
                    const kode = String(row.kode_layanan || '').toLowerCase();
                    return nama.includes(keyword) || kode.includes(keyword);
                });
            }

            const totalFiltered = filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(totalFiltered / PAGE_SIZE));
            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            totalBadge.html(`<i class="fas fa-database"></i> Total: ${totalFiltered} Data`);
            tableBody.empty();

            if (totalFiltered === 0) {
                paginationContainer.attr('style', 'display: none !important;');
                tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center py-4 opacity-75 fw-semibold">
                            Tidak ada data tarif/diskon pemeriksaan yang sesuai dengan filter.
                        </td>
                    </tr>`);
                return;
            }

            const startIdx = (currentPage - 1) * PAGE_SIZE;
            const endIdx = Math.min(startIdx + PAGE_SIZE, totalFiltered);
            const pageItems = filteredRows.slice(startIdx, endIdx);

            pageItems.forEach((row, idx) => {
                const nomorUrut = startIdx + idx + 1;
                const hargaDasar = parseFloat(row.harga_dasar) || 0;
                const diskon = parseFloat(row.diskon) || 0;
                const nett = hargaDasar - diskon;

                let packageItemsHtml = '';
                if (row.is_paket == 1) {
                    if (row.package_items && row.package_items.length > 0) {
                        packageItemsHtml = '<div class="mt-2 p-2 rounded border" style="border-color: var(--ent-grid-border) !important; background: rgba(79, 70, 229, 0.04);"><small class="fw-bold d-block mb-1 text-primary"><i class="fas fa-list-check me-1"></i>Isi Paket:</small>';
                        row.package_items.forEach(sub => {
                            packageItemsHtml += `<span class="code-chip me-1 mb-1">${sub.nama_layanan} (${sub.kode_layanan})</span>`;
                        });
                        packageItemsHtml += '</div>';
                    } else {
                        packageItemsHtml = '<div class="mt-1"><small class="text-danger fw-semibold fst-italic"><i class="fas fa-exclamation-circle me-1"></i>Belum ada item paket dipilih</small></div>';
                    }
                }

                let actionHtml = '';
                if (row.is_paket == 1) {
                    actionHtml += `<button type="button" class="btn btn-sm ent-btn ent-btn-warning btn-open-package w-100 mb-1 py-1"
                                    data-id="${row.master_pemeriksaan_id}"
                                    data-name="${row.nama_layanan}">
                                    <i class="fas fa-box-open me-1"></i> Items Paket
                                 </button>`;
                }

                actionHtml += `<button type="button" class="btn btn-sm ent-btn ent-btn-primary btn-edit-harga w-100 py-1"
                                data-id="${row.master_pemeriksaan_id}"
                                data-harga="${hargaDasar}"
                                data-diskon="${diskon}">
                                <i class="fas fa-pen-to-square me-1"></i> Edit Diskon
                             </button>`;

                const tr = `
                    <tr>
                        <td class="text-center fw-semibold">${nomorUrut}</td>
                        <td>
                            <span class="code-chip mb-1">${row.kode_layanan}</span>
                            <div class="fw-bold">${row.nama_layanan}</div>
                            ${packageItemsHtml}
                        </td>
                        <td>
                            <span class="ent-badge" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.3);">${row.nama_tipe}</span>
                        </td>
                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">
                            <div>Base: <strong>${formatRupiah(hargaDasar)}</strong></div>
                            ${diskon > 0 ? `<div class="text-danger fw-bold mt-1">Disc: -${formatRupiah(diskon)}</div>` : '<small class="opacity-50">Disc: Rp 0</small>'}
                        </td>
                        <td class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace; font-size: 0.92rem;">
                            ${formatRupiah(nett)}
                        </td>
                        <td class="text-center">${actionHtml}</td>
                    </tr>`;
                tableBody.append(tr);
            });

            renderPaginationControls(totalFiltered, totalPages, startIdx + 1, endIdx);
        }

        function renderPaginationControls(totalFiltered, totalPages, startItem, endItem) {
            paginationContainer.attr('style', 'display: flex !important;');
            paginationInfo.text(`Menampilkan ${startItem} - ${endItem} dari ${totalFiltered} data (Maks. ${PAGE_SIZE} / halaman)`);

            paginationList.empty();

            const prevDisabled = currentPage <= 1 ? 'disabled' : '';
            paginationList.append(`
                <li class="page-item ${prevDisabled}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Sebelumnya">
                        <i class="fas fa-angle-left"></i>
                    </a>
                </li>`);

            const maxVisible = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);
            if (endPage - startPage + 1 < maxVisible) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }

            if (startPage > 1) {
                paginationList.append(`<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`);
                if (startPage > 2) {
                    paginationList.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
                }
            }

            for (let p = startPage; p <= endPage; p++) {
                const activeClass = p === currentPage ? 'active' : '';
                paginationList.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`);
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    paginationList.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
                }
                paginationList.append(`<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`);
            }

            const nextDisabled = currentPage >= totalPages ? 'disabled' : '';
            paginationList.append(`
                <li class="page-item ${nextDisabled}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Berikutnya">
                        <i class="fas fa-angle-right"></i>
                    </a>
                </li>`);
        }

        $(document).on('click', '#paginationList .page-link', function(e) {
            e.preventDefault();
            const parentLi = $(this).parent();
            if (parentLi.hasClass('disabled') || parentLi.hasClass('active')) return;
            const targetPage = parseInt($(this).data('page'), 10);
            if (!isNaN(targetPage) && targetPage >= 1) {
                currentPage = targetPage;
                applyNameFilterAndRender();
                $('html, body').animate({
                    scrollTop: $('#tablePenjaminBody').closest('.ent-card').offset().top - 80
                }, 200);
            }
        });

        penjaminSelect.on('change', function() {
            const penjaminId = $(this).val();
            subPenjaminSelect.html('<option value="">-- Pilih Sub Penjamin --</option>').prop('disabled', true).trigger('change.select2');

            if (penjaminId) {
                fetch(`/master-data/get-sub-penjamin/${penjaminId}`)
                    .then(res => res.json())
                    .then(data => {
                        subPenjaminSelect.prop('disabled', false);
                        data.forEach(item => {
                            subPenjaminSelect.append(new Option(item.nama_sub_penjamin, item.id, false, false));
                        });
                        subPenjaminSelect.trigger('change.select2');
                    })
                    .catch(err => console.error('Error sub penjamin:', err));
            }
            filterTableData(true);
        });

        subPenjaminSelect.on('change', function() {
            filterTableData(true);
        });

        tipeLayananFilter.on('change', function() {
            filterTableData(true);
        });

        cariNamaFilter.on('keyup input', function() {
            currentPage = 1;
            applyNameFilterAndRender();
        });

        masterPemeriksaanSelect.on('change', function() {
            updatePricePreview();
        });

        function filterTableData(resetPage = true) {
            if (resetPage) {
                currentPage = 1;
            }

            const subPenjaminId = subPenjaminSelect.val();
            const tipeLayananId = tipeLayananFilter.val();

            if (!subPenjaminId) {
                allFetchedRows = [];
                filteredRows = [];
                paginationContainer.attr('style', 'display: none !important;');
                tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center py-5 opacity-75">
                            <i class="fas fa-circle-info fs-3 d-block mb-2 text-primary"></i>
                            <span class="fw-semibold">Silakan pilih Penjamin Utama dan Sub Penjamin terlebih dahulu untuk menampilkan data tarif.</span>
                        </td>
                    </tr>`);
                totalBadge.html(`<i class="fas fa-database"></i> Total: 0 Data`);
                return;
            }

            paginationContainer.attr('style', 'display: none !important;');
            tableBody.html(`
                <tr>
                    <td colspan="6" class="text-center py-4 opacity-75">
                        <i class="fas fa-spinner fa-spin me-1"></i> Memuat data tarif penjamin...
                    </td>
                </tr>`);

            const url = `/master-data/get-penjamin-pemeriksaan-filter?sub_penjamin_id=${subPenjaminId}&tipe_layanan_id=${tipeLayananId || ''}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    allFetchedRows = Array.isArray(data) ? data : [];
                    applyNameFilterAndRender();
                })
                .catch(err => {
                    console.error('Error fetching table:', err);
                    tableBody.html(`<tr><td colspan="6" class="text-center text-danger fw-bold py-3">Gagal memuat data dari server.</td></tr>`);
                });
        }

        priceForm.on('submit', function(e) {
            e.preventDefault();
            btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            let formData = new FormData(this);
            let rawDiskon = diskonInput.val().replace(/\./g, '');
            formData.set('diskon', rawDiskon || '0');

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Gagal menyimpan data.' });
                    } else {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1400, showConfirmButton: false });
                        masterPemeriksaanSelect.val('').trigger('change.select2');
                        diskonInput.val('0');
                        updatePricePreview();
                        filterTableData(false);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat menyimpan data.' });
                })
                .finally(() => {
                    btnSubmit.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Pengaturan');
                });
        });

        $('#searchPackageItemInput').on('keyup', function() {
            const keyword = $(this).val().toLowerCase().trim();
            $('.package-item-col').each(function() {
                const text = $(this).data('search') || '';
                $(this).toggle(text.includes(keyword));
            });
        });

        $(document).on('click', '.btn-open-package', function() {
            selectedPackageMasterId = $(this).data('id');
            const name = $(this).data('name');

            $('#modalPackageTitle').text(name);
            $('#searchPackageItemInput').val('');
            $('.package-item-col').show();
            $('.package-item-check').prop('checked', false);

            fetch(`/master-data/get-package-items/${selectedPackageMasterId}`)
                .then(res => res.json())
                .then(savedIds => {
                    savedIds.forEach(id => {
                        $(`#check_${id}`).prop('checked', true);
                    });
                    const modal = new bootstrap.Modal(document.getElementById('modalPackageItems'));
                    modal.show();
                })
                .catch(err => console.error('Error package items:', err));
        });

        $('#btnSavePackageItems').on('click', function() {
            const selectedItems = [];
            $('.package-item-check:checked').each(function() {
                selectedItems.push($(this).val());
            });

            if (selectedItems.length === 0) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih minimal 1 pemeriksaan untuk paket ini!' });
                return;
            }

            const btnSave = $(this);
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            fetch("{{ route('penjamin-price.save-package-items') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        master_pemeriksaan_id: selectedPackageMasterId,
                        items: selectedItems
                    })
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Gagal menyimpan item paket.' });
                    } else {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1400, showConfirmButton: false });
                        bootstrap.Modal.getInstance(document.getElementById('modalPackageItems')).hide();
                        filterTableData(false);
                    }
                })
                .catch(err => console.error(err))
                .finally(() => {
                    btnSave.prop('disabled', false).html('<i class="fas fa-check-circle me-1"></i> Simpan Item Paket');
                });
        });

        btnReset.on('click', function() {
            priceForm[0].reset();
            penjaminSelect.val('').trigger('change.select2');
            subPenjaminSelect.html('<option value="">-- Pilih Sub Penjamin --</option>').prop('disabled', true).trigger('change.select2');
            masterPemeriksaanSelect.val('').trigger('change.select2');
            tipeLayananFilter.val('').trigger('change.select2');
            cariNamaFilter.val('');
            updatePricePreview();
            filterTableData(true);
        });

        $(document).on('click', '.btn-edit-harga', function() {
            const masterId = $(this).data('id');
            const diskon = parseFloat($(this).data('diskon')) || 0;

            masterPemeriksaanSelect.val(masterId).trigger('change.select2');
            diskonInput.val(formatRupiahInput(diskon.toString())).focus();
            updatePricePreview();

            $('html, body').animate({
                scrollTop: $('#priceForm').offset().top - 100
            }, 300);
        });

        $('#btnOpenDefaultHarga').on('click', function() {
            const subId = subPenjaminSelect.val();
            const subName = subPenjaminSelect.find('option:selected').text();

            if (!subId) {
                Swal.fire({ icon: 'warning', title: 'Sub Penjamin Kosong', text: 'Silakan pilih Sub Penjamin terlebih dahulu!' });
                return;
            }

            $('#lblSubPenjaminDefault').text(subName);
            const modal = new bootstrap.Modal(document.getElementById('modalDefaultHarga'));
            modal.show();
        });

        $('#btnExecuteDefaultHarga').on('click', function() {
            const subId = subPenjaminSelect.val();
            const btn = $(this);
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

            fetch("{{ route('penjamin-price.generate-default') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        sub_penjamin_id: subId
                    })
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Gagal men-generate default harga.' });
                    } else {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1400, showConfirmButton: false });
                        bootstrap.Modal.getInstance(document.getElementById('modalDefaultHarga')).hide();
                        filterTableData(true);
                    }
                })
                .catch(err => console.error(err))
                .finally(() => btn.prop('disabled', false).html('<i class="fas fa-check-circle me-1"></i> Proses Generate'));
        });

        $('#btnOpenSalinHarga').on('click', function() {
            const subId = subPenjaminSelect.val();
            if (!subId) {
                Swal.fire({ icon: 'warning', title: 'Sub Penjamin Kosong', text: 'Silakan pilih Sub Penjamin target terlebih dahulu!' });
                return;
            }

            fetch(`/master-data/get-all-sub-penjamin-except/${subId}`)
                .then(res => res.json())
                .then(data => {
                    const sumberSelect = $('#sumber_sub_penjamin_id');
                    sumberSelect.html('<option value="">-- Pilih Sub Penjamin Sumber --</option>');
                    data.forEach(item => {
                        sumberSelect.append(new Option(`${item.nama_sub_penjamin} (${item.nama_penjamin})`, item.id, false, false));
                    });
                    sumberSelect.trigger('change.select2');
                    const modal = new bootstrap.Modal(document.getElementById('modalSalinHarga'));
                    modal.show();
                })
                .catch(err => console.error(err));
        });

        $('#btnExecuteSalinHarga').on('click', function() {
            const targetSubId = subPenjaminSelect.val();
            const sumberSubId = $('#sumber_sub_penjamin_id').val();

            if (!sumberSubId) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih sub penjamin sumber terlebih dahulu!' });
                return;
            }

            const btn = $(this);
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyalin...');

            fetch("{{ route('penjamin-price.copy-from-sub') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        target_sub_id: targetSubId,
                        sumber_sub_id: sumberSubId
                    })
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Gagal menyalin harga.' });
                    } else {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1400, showConfirmButton: false });
                        bootstrap.Modal.getInstance(document.getElementById('modalSalinHarga')).hide();
                        filterTableData(true);
                    }
                })
                .catch(err => console.error(err))
                .finally(() => btn.prop('disabled', false).html('<i class="fas fa-check-circle me-1"></i> Salin Sekarang'));
        });
    });
</script>
@endsection
