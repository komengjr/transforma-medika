@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
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
        padding: 14px 18px;
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
        background: radial-gradient(circle, rgba(244, 63, 94, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Badges */
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

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
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
        background-color: rgba(245, 158, 11, 0.16);
        border: 1px solid rgba(245, 158, 11, 0.45);
        color: #d97706;
    }

    .ent-btn-warning:hover {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
    }

    .ent-btn-reset {
        background-color: rgba(100, 116, 139, 0.12);
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    .ent-btn-reset:hover {
        background-color: rgba(100, 116, 139, 0.22);
        color: var(--bs-body-color);
    }

    /* Form Controls */
    .ent-field-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
        display: block;
    }

    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Select2 Adaptive & Solid Dropdown Styling */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px !important;
        border-radius: 10px !important;
        background-color: var(--ent-solid-bg) !important;
        border: 1px solid var(--ent-grid-border) !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 11px !important;
        padding-right: 30px !important;
        box-shadow: none !important;
        opacity: 1 !important;
        transition: all 0.2s ease;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-solid-bg) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        padding-left: 0 !important;
        line-height: 1.4 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.24) !important;
        overflow: hidden;
        opacity: 1 !important;
        z-index: 1080 !important;
        font-size: 0.82rem;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown {
        background-color: var(--ent-solid-bg) !important;
        padding: 8px !important;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--ent-indigo) !important;
        outline: none;
        box-shadow: 0 0 0 2.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-results__options {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        max-height: 240px;
        overflow-y: auto;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        padding: 7px 12px !important;
        line-height: 1.35 !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--ent-indigo) !important;
    }

    /* Table Styling */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.82rem;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.11) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 12px 10px;
        letter-spacing: 0.04em;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 10px 12px;
        vertical-align: middle;
        background-color: transparent;
    }

    .table-custom td .btn,
    .table-custom td .btn-sm {
        opacity: 1 !important;
    }

    /* DataTables Controls */
    #table-riwayat-ranap_wrapper > .row:first-child,
    #table-riwayat-ranap_wrapper .dt-layout-row:first-child {
        padding: 4px 0 14px 0;
        margin: 0 !important;
    }

    #table-riwayat-ranap_wrapper > .row:last-child,
    #table-riwayat-ranap_wrapper .dt-layout-row:last-child {
        padding: 14px 0 4px 0;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #table-riwayat-ranap_wrapper .dataTables_filter input,
    #table-riwayat-ranap_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-riwayat-ranap_wrapper .dataTables_length select,
    #table-riwayat-ranap_wrapper .dt-length select {
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
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid var(--ent-grid-border);
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* Modal Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        color: #ffffff;
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
    }

    .ent-info-box {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 14px;
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
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-history text-info fs-2"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.25); border: 1px solid rgba(129, 140, 248, 0.45); color: #c7d2fe;">
                                    <i class="fas fa-folder-open me-1"></i> Arsip &amp; Rekam Medis
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Histori Perawatan Rawat Inap</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">Riwayat &amp; Histori Pasien Rawat Inap</h4>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">{{ date('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR KOMPREHENSIF -->
<div class="ent-card mb-3 p-3 p-md-4">
    <form id="form-filter-riwayat" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-3 align-items-end">
            <div class="col-sm-6 col-md-3">
                <label class="ent-field-label"><i class="far fa-calendar-alt text-primary me-1"></i> Dari Tanggal Masuk</label>
                <input class="form-control form-control-sm ent-input" type="date" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" />
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="ent-field-label"><i class="far fa-calendar-alt text-primary me-1"></i> Sampai Tanggal Masuk</label>
                <input class="form-control form-control-sm ent-input" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="ent-field-label"><i class="fas fa-stethoscope text-success me-1"></i> Status / Kondisi Pulang</label>
                <select id="status_pulang" name="status_pulang" class="form-select ent-input select2-riwayat-ranap" data-placeholder="-- Semua Status Pulang --">
                    <option value="">-- Semua Status Pulang --</option>
                    <option value="SEBUH">Sembuh / Membaik</option>
                    <option value="RUJUK">Dirujuk</option>
                    <option value="PULANG_PAKSA">Pulang Paksa (APS)</option>
                    <option value="MENINGGAL">Meninggal Dunia</option>
                </select>
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="ent-field-label"><i class="fas fa-hospital text-primary me-1"></i> Kelas Perawatan</label>
                <select id="kelas" name="kelas" class="form-select ent-input select2-riwayat-ranap" data-placeholder="-- Semua Kelas --">
                    <option value="">-- Semua Kelas --</option>
                    <option value="Kelas 1">Kelas 1</option>
                    <option value="Kelas 2">Kelas 2</option>
                    <option value="Kelas 3">Kelas 3</option>
                    <option value="VIP">VIP</option>
                    <option value="VVIP">VVIP</option>
                    <option value="ICU">ICU</option>
                </select>
            </div>
            <div class="col-md-9">
                <label class="ent-field-label"><i class="fas fa-search text-primary me-1"></i> Kata Kunci Pencarian</label>
                <input class="form-control form-control-sm ent-input" type="text" id="keyword" name="keyword" placeholder="Cari No. Registrasi, Nama Pasien, atau No. RM..." />
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn ent-btn ent-btn-warning btn-sm w-50 fw-semibold" style="height: 38px;" title="Cari / Filter">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <button type="button" onclick="resetFilter()" class="btn ent-btn ent-btn-reset btn-sm w-50 fw-semibold" style="height: 38px;" title="Reset Filter">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE RIWAYAT -->
<div class="ent-card mb-4">
    <div class="ent-card-header d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="fas fa-list-alt text-primary"></i> Data Histori Pasien Rawat Inap
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table id="table-riwayat-ranap" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Reg &amp; Waktu Inap</th>
                        <th>Pasien &amp; RM</th>
                        <th>Ruangan &amp; Bed</th>
                        <th>Dokter DPJP</th>
                        <th class="text-center">Status Pulang</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL MONITORING & HASIL PASIEN -->
<div class="modal fade" id="modalDetailRiwayat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4">
                <h6 class="modal-title fw-bold text-white mb-0">
                    <i class="fas fa-id-card me-2 text-info"></i> Monitor &amp; Hasil Perawatan: <span id="riwayat_nama_pasien" class="text-warning"></span>
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Info Ringkas -->
                <div class="ent-info-box mb-3">
                    <div class="row g-2" style="font-size: 0.82rem;">
                        <div class="col-md-6"><strong>No. Registrasi:</strong> <span id="riwayat_no_reg" class="text-success fw-bold" style="font-family: 'JetBrains Mono', monospace;"></span></div>
                        <div class="col-md-6"><strong>No. RM:</strong> <span id="riwayat_pid" class="fw-bold" style="font-family: 'JetBrains Mono', monospace;"></span></div>
                        <div class="col-md-6"><strong>Tgl Masuk:</strong> <span id="riwayat_tgl_masuk"></span></div>
                        <div class="col-md-6"><strong>Tgl Keluar:</strong> <span id="riwayat_tgl_keluar"></span></div>
                        <div class="col-md-12"><strong>Catatan Pulang:</strong> <span id="riwayat_catatan" class="text-danger fw-bold"></span></div>
                    </div>
                </div>

                <!-- Bagian SOAP Terakhir / Perkembangan -->
                <h6 class="fw-bold mb-2" style="font-size: 0.85rem;">
                    <i class="fas fa-stethoscope text-primary me-1"></i> Catatan Medis (SOAP) Terakhir
                </h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="ent-info-box h-100">
                            <span class="ent-field-label">Subjektif (Keluhan)</span>
                            <span id="r_subjektif" class="fw-semibold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ent-info-box h-100">
                            <span class="ent-field-label">Objektif (Pemeriksaan Fisik/TTV)</span>
                            <span id="r_objektif" class="fw-semibold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ent-info-box h-100">
                            <span class="ent-field-label">Asesmen (Diagnosis)</span>
                            <span id="r_asesmen" class="fw-semibold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ent-info-box h-100">
                            <span class="ent-field-label">Planning (Terapi/Instruksi)</span>
                            <span id="r_planning" class="fw-semibold">-</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Item Tindakan / Layanan -->
                <h6 class="fw-bold mb-2" style="font-size: 0.85rem;">
                    <i class="fas fa-list-ul text-primary me-1"></i> Rincian Tindakan &amp; Layanan Selama Inap
                </h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm fs--1 table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama Layanan / Tindakan</th>
                                <th class="text-center" style="width: 80px;">Jumlah</th>
                                <th class="text-end" style="width: 150px;">Tarif</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-riwayat-tindakan">
                            <!-- Diisi via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn ent-btn-reset btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let tableRiwayatRanap;

    function initSelect2RiwayatRanap(selector) {
        if (!(window.jQuery && $.fn.select2)) return;
        $(selector).each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: placeholderText,
                allowClear: true,
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });
        });
    }

    $(document).ready(function() {
        initSelect2RiwayatRanap('.select2-riwayat-ranap');

        tableRiwayatRanap = $('#table-riwayat-ranap').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            ajax: {
                url: "{{ route('ranap.riwayat.datatable') }}",
                type: "GET",
                dataSrc: 'data',
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.status_pulang = $('#status_pulang').val();
                    d.kelas = $('#kelas').val();
                    d.keyword = $('#keyword').val();
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let tglMasuk = row.tgl_masuk ? new Date(row.tgl_masuk).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : '-';
                        let tglKeluar = row.tgl_keluar ? new Date(row.tgl_keluar).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : '<span class="text-success">Masih Dirawat</span>';
                        return `<span class="fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">${row.no_registrasi}</span><br>
                                <small class="opacity-75"><i class="fas fa-sign-in-alt text-success me-1"></i>${tglMasuk}</small><br>
                                <small class="opacity-75"><i class="fas fa-sign-out-alt text-danger me-1"></i>${tglKeluar}</small>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-bold">${row.nama_pasien}</span><br>
                                <small class="opacity-75" style="font-family: 'JetBrains Mono', monospace;">RM: ${row.pid}</small>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-bold text-primary">${row.nama_ruangan} (${row.kelas})</span><br>
                                <small class="text-success fw-semibold"><i class="fas fa-bed me-1"></i>Bed: ${row.nomor_bed}</small>`;
                    }
                },
                {
                    data: 'nama_dokter',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'status_pulang',
                    render: function(data) {
                        if (!data) {
                            return `<span class="ent-badge" style="background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.35);">AKTIF</span>`;
                        }
                        let styleBadge = 'background: rgba(16, 185, 129, 0.14); color: #059669; border: 1px solid rgba(16, 185, 129, 0.35);';
                        if (data === 'RUJUK') {
                            styleBadge = 'background: rgba(14, 165, 233, 0.14); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.35);';
                        } else if (data === 'PULANG_PAKSA') {
                            styleBadge = 'background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.35);';
                        } else if (data === 'MENINGGAL') {
                            styleBadge = 'background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);';
                        }
                        return `<span class="ent-badge" style="${styleBadge}">${data}</span>`;
                    },
                    className: 'text-center'
                },
                {
                    data: 'total_tagihan',
                    render: function(data) {
                        let total = data ? parseFloat(data) : 0;
                        return `Rp ${total.toLocaleString('id-ID')}`;
                    },
                    className: 'text-end fw-bold text-danger'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn ent-btn ent-btn-primary btn-sm px-2 py-1" style="font-size: 0.72rem;" onclick="lihatMonitorRiwayat('${row.registrasi_id}', '${row.nama_pasien}', '${row.no_registrasi}', '${row.pid}', '${row.tgl_masuk}', '${row.tgl_keluar}', '${row.catatan_pulang}')" title="Lihat Monitor & Hasil Pasien">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </button>
                            </div>
                        `;
                    },
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    function reloadTable() {
        tableRiwayatRanap.ajax.reload(null, false);
    }

    function resetFilter() {
        $('#start_date').val("{{ date('Y-m-01') }}");
        $('#end_date').val("{{ date('Y-m-d') }}");
        $('#status_pulang').val('').trigger('change');
        $('#kelas').val('').trigger('change');
        $('#keyword').val('');
        reloadTable();
    }

    function lihatMonitorRiwayat(registrasiId, namaPasien, noReg, pid, tglMasuk, tglKeluar, catatan) {
        $('#riwayat_nama_pasien').text(namaPasien);
        $('#riwayat_no_reg').text(noReg);
        $('#riwayat_pid').text(pid);
        $('#riwayat_tgl_masuk').text(tglMasuk ? new Date(tglMasuk).toLocaleString('id-ID') : '-');
        $('#riwayat_tgl_keluar').text(tglKeluar && tglKeluar !== 'null' ? new Date(tglKeluar).toLocaleString('id-ID') : 'Masih Dirawat');
        $('#riwayat_catatan').text(catatan && catatan !== 'null' ? catatan : '-');

        $('#r_subjektif').text('Memuat...');
        $('#r_objektif').text('Memuat...');
        $('#r_asesmen').text('Memuat...');
        $('#r_planning').text('Memuat...');
        $('#tbody-riwayat-tindakan').html('<tr><td colspan="3" class="text-center py-3">Memuat data...</td></tr>');

        $('#modalDetailRiwayat').modal('show');

        $.ajax({
            url: "{{ route('ranap.detail.handling') }}",
            type: "GET",
            data: {
                registrasi_id: registrasiId
            },
            success: function(res) {
                if (res.success) {
                    let soap = res.soap;
                    $('#r_subjektif').text(soap && soap.subjektif ? soap.subjektif : '-');
                    $('#r_objektif').text(soap && soap.objektif ? soap.objektif : '-');
                    $('#r_asesmen').text(soap && soap.asesmen ? soap.asesmen : '-');
                    $('#r_planning').text(soap && soap.planning ? soap.planning : '-');

                    let tindakanRows = '';
                    if (res.tindakanList.length > 0) {
                        res.tindakanList.forEach(function(item) {
                            tindakanRows += `
                                <tr>
                                    <td class="fw-semibold">${item.nama_layanan}</td>
                                    <td class="text-center">${item.jumlah}</td>
                                    <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(item.tarif).toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                        });
                    } else {
                        tindakanRows = '<tr><td colspan="3" class="text-center opacity-75 py-3">Belum ada tindakan atau layanan tercatat.</td></tr>';
                    }
                    $('#tbody-riwayat-tindakan').html(tindakanRows);
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat monitor dan hasil perawatan pasien.', 'error');
            }
        });
    }
</script>
@endsection
