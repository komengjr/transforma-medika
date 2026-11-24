@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
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

    /* Buttons & Inputs */
    .ent-field-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 4px;
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
        font-size: 0.8rem !important;
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
        padding-left: 10px !important;
        padding-right: 28px !important;
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
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        padding-left: 0 !important;
        line-height: 1.35 !important;
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
        font-size: 0.8rem;
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
        font-size: 0.8rem !important;
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
        font-size: 0.8rem !important;
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

    .btn-search-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        border-radius: 10px;
        padding: 0 20px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .btn-search-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    /* Layout Panel Kiri & Kanan */
    .layout-container {
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .panel-kiri {
        flex: 0 0 48%;
        background: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        border-radius: 16px;
        padding: 14px;
        overflow: hidden;
    }

    .panel-kanan {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    @media (max-width: 991.98px) {
        .layout-container {
            flex-direction: column;
        }

        .panel-kiri {
            width: 100%;
            flex: none;
        }
    }

    /* Tabel Kiri & DataTable Styling */
    .table-pasien {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.78rem;
    }

    .table-pasien thead th {
        background-color: rgba(79, 70, 229, 0.11) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 10px 8px;
        text-align: left;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        letter-spacing: 0.04em;
    }

    .table-pasien tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-pasien tbody tr td {
        border: 1px solid var(--ent-grid-border) !important;
        padding: 9px 8px;
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        background-color: transparent;
        cursor: pointer;
        vertical-align: middle;
    }

    .table-pasien tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-pasien tbody tr.active-row td {
        background-color: rgba(79, 70, 229, 0.16) !important;
        font-weight: 700;
    }

    /* DataTables Controls di Panel Kiri */
    #table-pasien-handling_wrapper>.row:first-child,
    #table-pasien-handling_wrapper .dt-layout-row:first-child {
        padding: 0 0 10px 0;
        margin: 0 !important;
    }

    #table-pasien-handling_wrapper>.row:last-child,
    #table-pasien-handling_wrapper .dt-layout-row:last-child {
        padding: 10px 0 0 0;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #table-pasien-handling_wrapper .dataTables_filter input,
    #table-pasien-handling_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 5px 10px !important;
        font-size: 0.78rem !important;
        height: 34px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-pasien-handling_wrapper .dataTables_length select,
    #table-pasien-handling_wrapper .dt-length select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        padding: 4px 24px 4px 8px !important;
        height: 32px !important;
        font-size: 0.78rem !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-pasien-handling_wrapper .dataTables_info,
    #table-pasien-handling_wrapper .dt-info {
        font-size: 0.74rem;
        font-weight: 600;
        color: var(--bs-secondary-color, #64748b);
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
        font-size: 0.76rem;
    }

    /* Panel Kanan */
    .box-identitas {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.07) 0%, rgba(14, 165, 233, 0.06) 100%);
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        padding: 20px;
    }

    .box-pemeriksaan {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        padding: 20px;
        min-height: 190px;
    }

    .box-pemeriksaan h6 {
        color: var(--bs-body-color);
        font-weight: 700;
        font-size: 0.88rem;
        margin: 0 0 14px 0;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .input-group-ent {
        display: flex;
        flex-direction: column;
        margin-bottom: 12px;
    }

    .input-group-ent label {
        font-size: 0.68rem;
        color: var(--bs-secondary-color, #64748b);
        font-weight: 700;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .input-underline {
        border: none;
        border-bottom: 1.5px solid var(--ent-grid-border);
        background: transparent;
        color: var(--bs-body-color);
        font-size: 0.84rem;
        font-weight: 700;
        padding-bottom: 4px;
        width: 100%;
        outline: none;
    }

    .row-form {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .col-form {
        flex: 1;
        min-width: 140px;
    }
</style>
@endsection

@section('content')

<!-- HERO HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/rad.png') }}" alt="Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.25); border: 1px solid rgba(129, 140, 248, 0.45); color: #c7d2fe;">
                                    <i class="fas fa-radiation me-1"></i> v2.4 Medical Suite
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Instalasi Radiologi</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em;color: white;">
                                Welcome to {{ Env('APP_LABEL') }} <span class="fw-normal opacity-75">Management System</span>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-radiation text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">Proses Handling Radiologi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR ATAS (AJAX Form) -->
<form id="form-filter-handling" class="ent-card mb-3 p-3 p-md-4">
    <div class="row g-3 align-items-end">
        <!-- Tanggal Awal -->
        <div class="col-sm-6 col-md-4 col-xl-2">
            <label class="ent-field-label">Tanggal Awal</label>
            <input type="text" class="form-control ent-input datetimepicker" name="tgl_awal" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
        </div>

        <!-- Tanggal Akhir -->
        <div class="col-sm-6 col-md-4 col-xl-2">
            <label class="ent-field-label">Tanggal Akhir</label>
            <input type="text" class="form-control ent-input datetimepicker" name="tgl_akhir" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
        </div>

        <!-- Cari -->
        <div class="col-sm-12 col-md-4 col-xl-2">
            <label class="ent-field-label">Cari...</label>
            <input type="text" class="form-control ent-input" name="cari" placeholder="No Reg / Nama">
        </div>

        <!-- Kel. Pelanggan -->
        <div class="col-sm-6 col-md-6 col-xl-2">
            <label class="ent-field-label">Kel. Pelanggan</label>
            <select name="penjamin" class="form-select ent-input select2-handling-rad" data-placeholder="Semua">
                <option value="Semua">Semua</option>
                <option value="UMUM">UMUM</option>
                <option value="PASIEN KLINIS">PASIEN KLINIS</option>
                <option value="ASURANSI">ASURANSI</option>
            </select>
        </div>

        <!-- Pemeriksaan -->
        <div class="col-sm-6 col-md-6 col-xl-3">
            <label class="ent-field-label">Pemeriksaan</label>
            <select name="pemeriksaan" class="form-select ent-input select2-handling-rad" data-placeholder="Semua Pemeriksaan">
                <option value="Semua">Semua Pemeriksaan</option>
                <option value="X-RAY">X-RAY / Rontgen</option>
                <option value="USG">USG (Ultrasonografi)</option>
                <option value="CT-SCAN">CT-SCAN</option>
                <option value="MRI">MRI</option>
            </select>
        </div>

        <!-- Tombol Submit Form -->
        <div class="col-12 col-xl-1 d-grid">
            <button type="submit" class="btn-search-primary" title="Cari Data">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>

<!-- KONTEN UTAMA (Kiri & Kanan) -->
<div class="layout-container">
    <!-- PANEL KIRI (DataTable Pasien) -->
    <div class="panel-kiri">
        <div class="table-responsive">
            <table id="table-pasien-handling" class="table table-hover table-pasien align-middle mb-0" style="width:100%;">
                <thead>
                    <tr>
                        <th>NO REG / TGL</th>
                        <th>KEL. PELANGGAN</th>
                        <th>NAMA</th>
                        <th class="text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody id="tbody-pasien"></tbody>
            </table>
        </div>
    </div>

    <!-- PANEL KANAN (Detail / Proses Handling) -->
    <div class="panel-kanan" id="menu-detail-handling">

        <!-- DEFAULT TAMPILAN KOSONG -->
        <div class="box-identitas">
            <div class="row-form">
                <div class="col-form">
                    <div class="input-group-ent">
                        <label>PID</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
                <div class="col-form">
                    <div class="input-group-ent">
                        <label>Umur</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
                <div class="col-form">
                    <div class="input-group-ent">
                        <label>TANGGAL LAHIR</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
            </div>
            <div class="row-form">
                <div class="col-form" style="flex: 2;">
                    <div class="input-group-ent">
                        <label>Nama</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
                <div class="col-form" style="flex: 1.5;">
                    <div class="input-group-ent">
                        <label>Pengirim</label>
                        <input type="text" class="input-underline" value="-" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-pemeriksaan">
            <h6><i class="fas fa-x-ray text-primary me-1"></i> Daftar Pemeriksaan</h6>
            <div class="text-center mt-4 opacity-75">
                <i class="fas fa-hand-pointer fa-2x mb-2 text-primary"></i>
                <p class="small fw-semibold mb-0">Silakan pilih data pasien pada tabel di sebelah kiri</p>
            </div>
        </div>

    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let pasienHandlingTable;
    let selectedPatientCode = null;

    function initSelect2HandlingRad(selector) {
        if (!(window.jQuery && $.fn.select2)) return;
        $(selector).each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            const hasEmptyOption = $el.find('option[value=""]').length > 0;

            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: placeholderText,
                allowClear: hasEmptyOption,
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

    function syncActivePatientRow() {
        $('#table-pasien-handling tbody tr.row-patient').removeClass('active-row');
        if (selectedPatientCode !== null && selectedPatientCode !== undefined) {
            $('#table-pasien-handling tbody tr.row-patient[data-code="' + selectedPatientCode + '"]').addClass('active-row');
        }
    }

    $(document).ready(function() {
        initSelect2HandlingRad('.select2-handling-rad');

        pasienHandlingTable = $('#table-pasien-handling').DataTable({
            data: [],
            paging: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            searching: true,
            ordering: false,
            info: true,
            responsive: true,
            autoWidth: false,
            createdRow: function(row, data) {
                $(row).addClass('row-patient').attr('data-code', data.registrasi_id);
                if (selectedPatientCode !== null && String(data.registrasi_id) === String(selectedPatientCode)) {
                    $(row).addClass('active-row');
                }
            },
            columns: [{
                    data: 'no_registrasi',
                    className: 'text-nowrap',
                    render: function(data, type, row) {
                        const noReg = data ?? '-';
                        const tgl = row.tanggal_registrasi ?? '-';
                        return `
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">${noReg}</span>
                                <small class="opacity-75" style="font-family: 'JetBrains Mono', monospace; font-size: 0.7rem;">${tgl}</small>
                            </div>
                        `;
                    }
                },
                {
                    data: 'penjamin',
                    defaultContent: '-'
                },
                {
                    data: 'master_patient_name',
                    className: 'fw-semibold',
                    defaultContent: '-'
                },
                {
                    data: 'status_pemeriksaan',
                    className: 'text-center text-nowrap',
                    render: function(data) {
                        if (data == 'MENUNGGU') {
                            return '<span class="ent-badge" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);">Antrean</span>';
                        }
                        return '<span class="ent-badge" style="background: rgba(217, 119, 6, 0.14); color: #d97706; border: 1px solid rgba(217, 119, 6, 0.35);">' + (data ?? '-') + '</span>';
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "🔍 Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 - 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                emptyTable: `
                    <div class="text-center py-4 fw-semibold opacity-75">
                        <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i><br>
                        Data antrean tidak ditemukan.
                    </div>
                `,
                zeroRecords: `
                    <div class="text-center py-4 fw-semibold opacity-75">
                        <i class="fas fa-search fa-2x mb-2 opacity-50"></i><br>
                        Data tidak cocok dengan pencarian.
                    </div>
                `,
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            }
        });

        pasienHandlingTable.on('draw', function() {
            syncActivePatientRow();
        });

        // 1. Fungsi AJAX untuk mengambil list pasien dari Controller
        function loadDataPasien() {
            var formData = $('#form-filter-handling').serialize();

            $('#tbody-pasien').html(`
                <tr>
                    <td colspan="4" class="text-center py-4 fw-semibold">
                        <i class="fas fa-spinner fa-spin me-2 text-primary"></i> Mencari data...
                    </td>
                </tr>
            `);

            $.ajax({
                url: "{{ route('radiologi.get_data_handling') }}",
                type: "GET",
                data: formData,
                success: function(response) {
                    const rows = (response && Array.isArray(response.data)) ? response.data : [];
                    pasienHandlingTable.clear().rows.add(rows).draw();
                },
                error: function() {
                    pasienHandlingTable.clear().draw();
                    $('#tbody-pasien').html('<tr><td colspan="4" class="text-center text-danger fw-semibold py-4">Gagal mengambil data dari server. Periksa koneksi atau route.</td></tr>');
                }
            });
        }

        // 2. Load otomatis saat halaman pertama dibuka
        loadDataPasien();

        // 3. Trigger ajax pencarian ketika form disubmit
        $('#form-filter-handling').on('submit', function(e) {
            e.preventDefault();
            loadDataPasien();
        });

        // 4. Klik Baris Pasien di Kiri untuk buka form handling di Kanan
        $(document).on("click", "#table-pasien-handling tbody tr.row-patient", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            if (!code) return;

            selectedPatientCode = code;
            syncActivePatientRow();

            $('#menu-detail-handling').html(`
                <div class="ent-card text-center py-5" style="flex: 1;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 fw-semibold small mb-0">Memuat data pemeriksaan...</p>
                </div>
            `);

            $.ajax({
                url: "{{ route('menu_radiologi_handling_pasien') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-detail-handling').html(data);
                initSelect2HandlingRad('#menu-detail-handling select');
            }).fail(function() {
                $('#menu-detail-handling').html(`
                    <div class="alert alert-danger m-0 fw-semibold rounded-3">
                        Gagal memuat data. Periksa koneksi internet.
                    </div>
                `);
            });
        });
    });
</script>
@endsection
