@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE HEALTHCARE UI STYLES
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
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        background-color: transparent;
        overflow: hidden;
    }

    .ent-card>.card-header {
        background-color: transparent !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
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

    /* Modern Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
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
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-warning {
        background-color: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.4);
        color: #d97706;
    }

    .ent-btn-warning:hover {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
    }

    /* Adaptive Floating Filters */
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
        background: transparent;
    }

    .ent-input,
    .form-control,
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
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Select2 Adaptive Styling */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: 44px !important;
        padding-top: 16px !important;
        padding-bottom: 4px !important;
        padding-left: 8px !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg) !important;
        border: 1px solid var(--ent-grid-border) !important;
        transition: all 0.2s ease;
    }

    .form-floating-custom .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .form-floating-custom .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        padding-left: 3px !important;
        line-height: 1.5 !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 10px !important;
    }

    /* =========================================================
       TRANSPARENT TABLE WITH COLORED GRID BORDERS & FULL ACTION
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        background-color: transparent !important;
        --bs-table-bg: transparent;
        --bs-table-accent-bg: transparent;
        --bs-table-striped-bg: rgba(99, 102, 241, 0.03);
        --bs-table-hover-bg: rgba(79, 70, 229, 0.08);
        --bs-table-color: var(--bs-body-color);
        --bs-table-border-color: var(--ent-grid-border);
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.09) !important;
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
        background-color: transparent !important;
        transition: background-color 0.15s ease;
        height: 1px;
        /* Trik agar elemen 100% height di dalam td merentang penuh */
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        background-color: transparent !important;
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

    /* FULL-CELL ACTION BUTTON STYLING */
    .table-custom td.action-cell-full {
        padding: 0 !important;
        height: 100%;
        vertical-align: stretch !important;
    }

    .table-custom td.action-cell-full>.btn,
    .table-custom td.action-cell-full>.btn-group,
    .table-custom td.action-cell-full>.dropdown,
    .table-custom td.action-cell-full>a,
    .table-custom td.action-cell-full>button {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 100% !important;
        min-height: 52px;
        border-radius: 0 !important;
        margin: 0 !important;
        border: none !important;
    }

    .table-custom td.action-cell-full .dropdown>.btn,
    .table-custom td.action-cell-full .btn-group>.btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 100% !important;
        min-height: 52px;
        border-radius: 0 !important;
        border: none !important;
    }

    /* DataTables Top & Bottom Controls Padding (Adaptive Transparent) */
    #example_wrapper>.row:first-child,
    #example_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
        background-color: transparent;
    }

    #example_wrapper>.row:last-child,
    #example_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
        background-color: transparent;
    }

    #example_wrapper .dt-layout-table {
        margin: 0 !important;
    }

    #example_wrapper .dataTables_filter input,
    #example_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #example_wrapper .dataTables_filter input:focus,
    #example_wrapper .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    #example_wrapper .dataTables_length select,
    #example_wrapper .dt-length select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        padding: 4px 28px 4px 10px !important;
        height: 34px !important;
        font-size: 0.82rem !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    .page-item.active .page-link {
        background-color: var(--ent-indigo) !important;
        border-color: var(--ent-indigo) !important;
        color: #ffffff !important;
        border-radius: 8px;
    }

    .page-link {
        color: var(--bs-body-color);
        background-color: transparent;
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid var(--ent-grid-border);
        font-weight: 600;
        font-size: 0.8rem;
    }

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

    /* Modal Barcode & History Adaptive */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .modal-ent-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%) !important;
        color: #ffffff !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 16px 22px;
    }

    .table-barcode-list {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        overflow: hidden;
        --bs-table-bg: transparent;
    }

    .table-barcode-list thead th {
        background-color: rgba(79, 70, 229, 0.09) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        padding: 11px 12px;
    }

    .table-barcode-list tbody td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 600;
        color: var(--bs-body-color);
        padding: 10px 12px;
    }

    .btn-barcode-print-item {
        background-color: var(--ent-indigo-soft);
        color: var(--ent-indigo);
        border: 1px solid rgba(79, 70, 229, 0.35);
        padding: 5px 11px;
        border-radius: 8px;
        font-weight: 700;
        transition: all 0.15s ease;
    }

    .btn-barcode-print-item:hover {
        background-color: var(--ent-indigo);
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<!-- HEADER HERO BANNER ENTERPRISE -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/dashboard.png') }}" alt="Logo" class="img-fluid" width="38" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-bolt me-1"></i> LIVE SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">v2.4 Medical Suite</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal" style="color: #cbd5e1;">Management System</span>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                            <h6 class="fw-bold mb-0 text-white" style="font-size: 0.9rem;">
                                <i class="fas fa-clipboard-list me-2 text-info"></i> List Pasien Terdaftar
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD (TRANSPARENT + COLORED GRID + FULL EDGE-TO-EDGE) -->
<div class="ent-card mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <div class="row align-items-center g-2">

            <!-- TOMBOL AKSI UTAMA -->
            <div class="col-12 col-md-auto d-flex align-items-center justify-content-between gap-2">
                <button class="btn btn-sm ent-btn ent-btn-primary px-3 py-2 d-flex align-items-center gap-2" style="height: 44px;"
                    type="button" id="button-refresh-data" data-bs-toggle="tooltip" title="Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-semibold">Refresh Data</span>
                </button>

                <button class="btn btn-sm ent-btn ent-btn-warning px-3 py-2 d-md-none d-flex align-items-center gap-1" style="height: 44px;"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterMobile" aria-expanded="false" aria-controls="collapseFilterMobile">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>

            <!-- CONTAINER DERETAN FILTER -->
            <div class="col-12 col-md collapse d-md-block" id="collapseFilterMobile">
                <div class="row g-2 align-items-center mt-2 mt-md-0 pt-2 pt-md-0 border-top border-md-0">

                    <!-- Filter Tanggal Awal -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Awal</label>
                            <input type="text" class="form-control datetimepicker ent-input" id="filter_tgl_awal" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker ent-input" id="filter_tgl_akhir" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter No Reg / Nama -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>No Reg / Nama</label>
                            <input type="text" class="form-control ent-input" id="filter_search" placeholder="Cari Reg / Nama...">
                        </div>
                    </div>

                    <!-- Filter Dokter -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Dokter</label>
                            <select class="form-select ent-input" id="filter_dokter">
                                <option value="">Semua Dokter</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Kel. Pelanggan / Penjamin -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Kel. Pelanggan</label>
                            <select class="form-select ent-input" id="filter_penjamin">
                                <option value="">Semua Kelompok</option>
                                <option value="PASIEN KLINIS">PASIEN KLINIS</option>
                                <option value="UMUM">UMUM / PRIBADI</option>
                                <option value="ASURANSI">ASURANSI</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Jenis Layanan -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Jenis Layanan</label>
                            <select class="form-select ent-input" id="filter_jenis_layanan">
                                <option value="">Semua Layanan</option>
                                <option value="RAWAT_JALAN">RAWAT JALAN</option>
                                <option value="IGD">IGD</option>
                                <option value="RAWAT_INAP">RAWAT INAP</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Pemeriksaan -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Pemeriksaan</label>
                            <select class="form-select ent-input" id="filter_pemeriksaan">
                                <option value="">Semua Pemeriksaan</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="card-body p-0 bg-white">
        <div class="table-responsive pb-3">
            <table id="example" class="table table-custom  pb-3">
                <thead>
                    <tr>
                        <th width="2%" class="text-center">#</th>
                        <th width="5%" class="text-center">No</th>
                        <th width="12%">No. Registrasi & Petugas</th>
                        <th width="15%">Nama Pasien</th>
                        <th width="10%">Penjamin</th>
                        <th width="16%">Dokter</th>
                        <th width="12%">Janji Hasil</th>
                        <th width="18%">Pemeriksaan</th>
                        <th width="8%">Pengiriman</th>
                        <th width="7%" class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL HISTORY REGISTRASI PASIEN -->
<div class="modal fade" id="modal-registrasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close shadow-sm rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-registrasi"></div>
        </div>
    </div>
</div>

<!-- MODAL CETAK BARCODE -->
<div class="modal fade" id="modalCetakBarcode" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content modal-ent-content">
            <div class="modal-header modal-ent-header">
                <h6 class="modal-title fw-bold text-white d-flex align-items-center mb-0">
                    <i class="fas fa-barcode text-info me-2"></i> Cetak Barcode Spesimen
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table table-barcode-list align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 10%;" class="text-center">
                                    <input type="checkbox" class="form-check-input" id="check-all-barcode" onchange="toggleSelectAllBarcode(this)" style="cursor: pointer;">
                                </th>
                                <th style="width: 45%;">SPECIMEN</th>
                                <th style="width: 30%;">BARCODE</th>
                                <th style="width: 15%; text-align: center;">CETAK</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-barcode-list">
                            <!-- Data disuntik dinamis via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div id="loading-barcode-spinner" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <div class="small mt-2 fw-semibold opacity-75">Memuat daftar spesimen...</div>
                </div>
            </div>
            <div class="modal-footer border-top px-4 py-3 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Tutup</button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn ent-btn ent-btn-warning py-2 px-3" onclick="cetakRoboBarcode()">
                        <i class="fas fa-robot me-1"></i> Cetak Robo
                    </button>
                    <button type="button" class="btn ent-btn ent-btn-primary py-2 px-3" id="btn-cetak-terpilih" onclick="cetakTerpilihBarcode()">
                        <i class="fas fa-print me-1"></i> Cetak Terpilih (<span id="count-selected-barcode">0</span>)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let table;

    $(document).ready(function() {
        // Inisialisasi Select2 Filter
        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan, #filter_jenis_layanan').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });

        // Inisialisasi DataTables
        table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_data_table') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.tgl1 = $('#filter_tgl_awal').val();
                    d.tgl2 = $('#filter_tgl_akhir').val();
                    d.search_custom = $('#filter_search').val();
                    d.dokter = $('#filter_dokter').val();
                    d.penjamin = $('#filter_penjamin').val();
                    d.pemeriksaan = $('#filter_pemeriksaan').val();
                    d.jenis_layanan = $('#filter_jenis_layanan').val();
                }
            },
            columns: [{
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'action-cell-full text-center align-middle'
                },
                {
                    data: 'no',
                    className: 'text-center align-middle fw-semibold'
                },
                {
                    data: 'no_reg',
                    className: 'align-middle'
                },
                {
                    data: 'nama',
                    className: 'align-middle fw-semibold'
                },
                {
                    data: 'agreement',
                    className: 'align-middle'
                },
                {
                    data: 'dokter',
                    className: 'align-middle'
                },
                {
                    data: 'janji_hasil',
                    className: 'align-middle'
                },
                {
                    data: 'pemeriksaan',
                    className: 'align-middle'
                },
                {
                    data: 'pengiriman',
                    className: 'align-middle'
                },
                {
                    data: 'total',
                    className: 'align-middle text-end fw-bold'
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari nama, RM, atau NIK...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ pasien",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                },
                processing: `
                    <div class="custom-loader py-4 text-center">
                        <div class="spinner-border text-primary mb-2" style="width: 2.2rem; height: 2.2rem;" role="status"></div>
                        <span class="fw-semibold small d-block">Memuat data pasien...</span>
                    </div>
                `
            }
        });

        loadFilterOptions();

        // Event Listeners Filter
        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            loadFilterOptions();
            table.draw();
        });

        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan, #filter_jenis_layanan').on('change', function() {
            table.draw();
        });

        $('#filter_search').on('keyup', function() {
            table.draw();
        });

        $('#button-refresh-data').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            $('#filter_tgl_awal').val(today);
            $('#filter_tgl_akhir').val(today);
            $('#filter_search').val('');
            $('#filter_jenis_layanan').val('').trigger('change.select2');
            $('#filter_dokter').val('').trigger('change.select2');
            $('#filter_penjamin').val('').trigger('change.select2');
            $('#filter_pemeriksaan').val('').trigger('change.select2');

            loadFilterOptions();
            table.draw();
        });
    });

    function loadFilterOptions() {
        const tglAwal = $('#filter_tgl_awal').val();
        const tglAkhir = $('#filter_tgl_akhir').val();

        fetch(`/pelayanan/get-filter-options?tgl1=${tglAwal}&tgl2=${tglAkhir}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const $dokter = $('#filter_dokter');
                    const selectedDokter = $dokter.val();
                    $dokter.empty().append('<option value="">Semua Dokter</option>');
                    data.dokter.forEach(d => {
                        $dokter.append(new Option(d, d, false, d === selectedDokter));
                    });
                    $dokter.trigger('change.select2');

                    const $penjamin = $('#filter_penjamin');
                    const selectedPenjamin = $penjamin.val();
                    $penjamin.empty().append('<option value="">Semua Kelompok</option>');
                    data.penjamin.forEach(p => {
                        $penjamin.append(new Option(p, p, false, p === selectedPenjamin));
                    });
                    $penjamin.trigger('change.select2');

                    const $pemeriksaan = $('#filter_pemeriksaan');
                    const selectedPemeriksaan = $pemeriksaan.val();
                    $pemeriksaan.empty().append('<option value="">Semua Pemeriksaan</option>');
                    data.pemeriksaan.forEach(item => {
                        $pemeriksaan.append(new Option(item.nama_layanan, item.id, false, item.id == selectedPemeriksaan));
                    });
                    $pemeriksaan.trigger('change.select2');
                }
            })
            .catch(err => console.error("Gagal memuat opsi filter:", err));
    }

    // LOGIKA CETAK BARCODE
    $(document).on("click", ".btn-modal-barcode", function(e) {
        e.preventDefault();
        const regId = $(this).data("regid");

        const modalBarcode = new bootstrap.Modal(document.getElementById('modalCetakBarcode'));
        modalBarcode.show();

        const tbody = document.getElementById('tbody-barcode-list');
        tbody.innerHTML = '';
        document.getElementById('loading-barcode-spinner').style.display = 'block';
        document.getElementById('check-all-barcode').checked = false;
        updateCountBarcodeSelected();

        fetch(`/pelayanan/get-specimen-barcode/${regId}`)
            .then(res => res.json())
            .then(response => {
                document.getElementById('loading-barcode-spinner').style.display = 'none';
                if (response.success && response.data.length > 0) {
                    response.data.forEach(item => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input check-barcode-item" value="${item.barcode}" data-code="${item.detail_id}" onchange="updateCountBarcodeSelected()" style="cursor: pointer;">
                            </td>
                            <td>${item.specimen}</td>
                            <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">${item.barcode}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-barcode-print-item" onclick="cetakSingleBarcode('${item.detail_id}', '${item.barcode}', '${regId}')" title="Cetak Barcode Ini">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center opacity-75 py-4">Tidak ada data spesimen.</td></tr>`;
                }
            })
            .catch(err => {
                document.getElementById('loading-barcode-spinner').style.display = 'none';
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-danger py-4">Gagal memuat data spesimen.</td></tr>`;
            });
    });

    function toggleSelectAllBarcode(checkbox) {
        const checkboxes = document.querySelectorAll('.check-barcode-item');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
        updateCountBarcodeSelected();
    }

    function updateCountBarcodeSelected() {
        const selected = document.querySelectorAll('.check-barcode-item:checked');
        document.getElementById('count-selected-barcode').innerText = selected.length;
    }

    function cetakSingleBarcode(code, barcode, regId) {
        const url = `/pelayanan/specimen-collection/print-barcode?code=${code}&specimen=${barcode}&reg=${regId}`;
        window.open(url, '_blank', 'width=400,height=300');
    }

    function cetakTerpilihBarcode() {
        const selected = document.querySelectorAll('.check-barcode-item:checked');
        if (selected.length === 0) {
            alert("Silakan pilih minimal satu spesimen untuk dicetak!");
            return;
        }

        selected.forEach(cb => {
            const barcode = cb.value;
            const code = cb.getAttribute('data-code');
            const url = `/pelayanan/specimen-collection/print-barcode?code=${code}&specimen=${barcode}`;
            window.open(url, '_blank', 'width=400,height=300');
        });
    }

    function cetakRoboBarcode() {
        const allCheckboxes = document.querySelectorAll('.check-barcode-item');
        if (allCheckboxes.length === 0) return;

        allCheckboxes.forEach(cb => {
            const barcode = cb.value;
            const code = cb.getAttribute('data-code');
            const url = `/pelayanan/specimen-collection/print-barcode?code=${code}&specimen=${barcode}`;
            window.open(url, '_blank', 'width=400,height=300');
        });
    }

    // Modal Riwayat Pasien
    $(document).on("click", ".button-data-history-pasien", function(e) {
        e.preventDefault();
        const code = $(this).data("code");

        $('#menu-registrasi').html(`
            <div class="custom-loader py-5 text-center">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <span class="fw-semibold small d-block">Memuat riwayat pasien...</span>
            </div>
        `);

        fetch("{{ route('data_registrasi_history') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: new URLSearchParams({
                    "code": code
                })
            })
            .then(response => response.text())
            .then(html => {
                $('#menu-registrasi').html(html);
            })
            .catch(error => {
                $('#menu-registrasi').html(`
                    <div class="alert alert-danger m-4 rounded-3" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Gagal memuat data riwayat pasien.
                    </div>
                `);
            });
    });
</script>
@endsection
