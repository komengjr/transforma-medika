@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
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
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        overflow: hidden;
    }

    .ent-card>.card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
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

    .ent-btn-outline {
        border: 1px solid var(--ent-grid-border);
        background-color: transparent;
        color: var(--bs-body-color);
    }

    .ent-btn-outline:hover {
        background-color: rgba(79, 70, 229, 0.08);
        border-color: var(--ent-indigo);
        color: var(--bs-body-color);
    }

    /* Form Controls */
    .form-control-ent,
    .form-select-ent {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        background-color: var(--ent-solid-bg) !important;
        font-size: 0.84rem !important;
        min-height: 40px;
        transition: all 0.2s ease;
    }

    .form-control-ent:disabled {
        background-color: rgba(99, 102, 241, 0.08) !important;
        opacity: 0.9;
    }

    .form-control-ent:focus,
    .form-select-ent:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Select2 Adaptive & Solid Dropdown Styling */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .select2-container--bootstrap-5 .select2-selection {
        min-height: 40px !important;
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
        font-size: 0.84rem !important;
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
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.28) !important;
        overflow: hidden;
        opacity: 1 !important;
        z-index: 1090 !important;
        font-size: 0.84rem;
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
        font-size: 0.83rem !important;
        font-weight: 600 !important;
        padding: 8px 12px !important;
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

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS & FULL-CELL ACTION
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        background-color: transparent !important;
        --bs-table-bg: transparent;
        --bs-table-accent-bg: transparent;
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
    }

    /* Full-Cell Action Button */
    .table-custom td.action-cell-full {
        padding: 0 !important;
        height: 100%;
        vertical-align: stretch !important;
    }

    .table-custom td.action-cell-full>button {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 100% !important;
        min-height: 50px;
        border-radius: 0 !important;
        margin: 0 !important;
        border: none !important;
        background-color: rgba(79, 70, 229, 0.12);
        color: #4f46e5;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.15s ease;
    }

    .table-custom td.action-cell-full>button:hover {
        background-color: var(--ent-indigo);
        color: #ffffff;
    }

    /* DataTables Controls Padding */
    #table-template_wrapper>.row:first-child,
    #table-template_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
    }

    #table-template_wrapper>.row:last-child,
    #table-template_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #table-template_wrapper .dt-layout-table {
        margin: 0 !important;
    }

    #table-template_wrapper .dataTables_filter input,
    #table-template_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-template_wrapper .dataTables_length select,
    #table-template_wrapper .dt-length select {
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

    /* Soft Badges */
    .ent-badge {
        border-radius: 9999px;
        padding: 4px 11px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    /* Modal Adaptive Enterprise */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--ent-solid-bg);
        color: var(--ent-solid-text);
        overflow: hidden;
    }

    .modal-ent-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    .menu-box-ent {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: rgba(79, 70, 229, 0.04);
    }

    .form-check-input:checked {
        background-color: var(--ent-indigo);
        border-color: var(--ent-indigo);
    }
</style>
@endsection

@section('content')
<!-- Banner Header Enterprise -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                            <i class="fas fa-file-medical fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-database me-1"></i> MASTER DATA
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Konfigurasi Form Pemeriksaan</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em;color: white;">Setting Template Poliklinik</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Atur format lembar medis dan modul form aktif untuk masing-masing poliklinik.</p>
                        </div>
                    </div>
                    <div>
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-layer-group text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.85rem;">{{ count($data) }} Poliklinik Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="row">
    <div class="col-12">
        <div class="ent-card mb-3">
            <div class="card-header py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-list text-primary"></i> Daftar Konfigurasi Template
                </h6>
            </div>
            <div class="card-body p-0" style="background-color: var(--bs-body-bg);">
                <div class="table-responsive pb-3">
                    <table class="table table-custom align-middle mb-0 w-100" id="table-template">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="14%">Kode Poli</th>
                                <th width="25%">Nama Poliklinik</th>
                                <th width="22%">Jenis Template</th>
                                <th width="24%">Keterangan</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                            <tr>
                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.35); font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">
                                        {{ $row->kode_poli ?? '-' }}
                                    </span>
                                </td>
                                <td class="fw-bold">{{ $row->nama_poli }}</td>
                                <td>
                                    @if($row->jenis_template)
                                    @php
                                    $badgeStyle = 'background: rgba(14, 165, 233, 0.14); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.35);';
                                    if($row->jenis_template == 'GIGI') $badgeStyle = 'background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.35);';
                                    if($row->jenis_template == 'UMUM') $badgeStyle = 'background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.35);';
                                    if($row->jenis_template == 'KANDUNGAN') $badgeStyle = 'background: rgba(168, 85, 247, 0.15); color: #9333ea; border: 1px solid rgba(168, 85, 247, 0.35);';
                                    @endphp
                                    <span class="ent-badge px-3 py-1" style="{{ $badgeStyle }}">
                                        <i class="fas fa-file-alt me-1"></i> {{ $template_options[$row->jenis_template] ?? $row->jenis_template }}
                                    </span>
                                    @else
                                    <span class="ent-badge px-3 py-1" style="background: rgba(244, 63, 94, 0.14); color: #e11d48; border: 1px solid rgba(244, 63, 94, 0.35);">
                                        <i class="fas fa-exclamation-circle me-1"></i> Belum Disetting
                                    </span>
                                    @endif
                                </td>
                                <td class="opacity-75">{{ $row->keterangan ?? '-' }}</td>
                                <td class="action-cell-full text-center">
                                    <button type="button" class="btn-setting"
                                        data-id="{{ $row->poli_id }}"
                                        data-nama="{{ $row->nama_poli }}"
                                        data-template="{{ $row->jenis_template ?? '' }}"
                                        data-menu="{{ $row->menu_aktif ?? '' }}"
                                        data-keterangan="{{ $row->keterangan ?? '' }}"
                                        title="Konfigurasi Template">
                                        <i class="fas fa-cog me-1"></i> Atur
                                    </button>
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

<!-- Modal Setting Template -->
<div class="modal fade" id="modalSettingTemplate" tabindex="-1" aria-labelledby="modalSettingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header modal-ent-header px-4 py-3">
                <h6 class="modal-title fw-bold text-warning mb-0 d-flex align-items-center gap-2" id="modalSettingLabel">
                    <i class="fas fa-sliders-h text-info"></i> Konfigurasi Template Form
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSettingTemplate">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" id="poli_id" name="poli_id">

                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Nama Poliklinik</label>
                        <input type="text" id="nama_poli" class="form-control form-control-ent" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Pilih Jenis Template <span class="text-danger">*</span></label>
                        <select id="jenis_template" name="jenis_template" class="form-select form-select-ent select2-modal-template" data-placeholder="-- Pilih Format Template --" required>
                            <option value="">-- Pilih Format Template --</option>
                            @foreach($template_options as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                        <small class="fw-medium mt-1 d-block opacity-75" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle text-primary me-1"></i> Template menentukan form utama yang tampil saat dokter melayani pasien.
                        </small>
                    </div>

                    <!-- Pengaturan Menu Form Aktif -->
                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase opacity-75 mb-2" style="font-size: 0.7rem;">Pengaturan Menu / Form yang Ditampilkan</label>
                        <div class="p-3 menu-box-ent">
                            <div class="row g-2.5">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_form[]" value="anamnesa" id="menu_anamnesa" checked>
                                        <label class="form-check-label fw-semibold small" for="menu_anamnesa">Anamnesa</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_form[]" value="vital_sign" id="menu_vital_sign" checked>
                                        <label class="form-check-label fw-semibold small" for="menu_vital_sign">Fisik & Vital Sign</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_form[]" value="odontogram" id="menu_odontogram">
                                        <label class="form-check-label fw-semibold small" for="menu_odontogram">Odontogram (Gigi)</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_form[]" value="tindakan" id="menu_tindakan" checked>
                                        <label class="form-check-label fw-semibold small" for="menu_tindakan">Order Tindakan</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_form[]" value="resep" id="menu_resep" checked>
                                        <label class="form-check-label fw-semibold small" for="menu_resep">E-Resep Obat</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox" type="checkbox" name="menu_form[]" value="diagnosa" id="menu_diagnosa" checked>
                                        <label class="form-check-label fw-semibold small" for="menu_diagnosa">Diagnosa Akhir</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="fw-bold small text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Keterangan / Instruksi Khusus</label>
                        <textarea id="keterangan" name="keterangan" class="form-control form-control-ent" rows="2" placeholder="Contoh: Wajib isi form lengkap..."></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn ent-btn-outline px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Setting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function initSelect2ModalTemplate(selector) {
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
                dropdownParent: $('#modalSettingTemplate'),
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
        // Initialize Select2 inside modal
        initSelect2ModalTemplate('.select2-modal-template');

        // Initialize DataTable
        $('#table-template').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari kode atau nama poli...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ poliklinik",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            }
        });

        // Trigger Modal Setting
        $(document).on('click', '.btn-setting', function() {
            const poli_id = $(this).data('id');
            const nama_poli = $(this).data('nama');
            const template = $(this).data('template');
            const keterangan = $(this).data('keterangan');
            let menuAktif = $(this).attr('data-menu');

            $('#poli_id').val(poli_id);
            $('#nama_poli').val(nama_poli);
            $('#jenis_template').val(template).trigger('change');
            $('#keterangan').val(keterangan);

            // Reset dan centang checkbox berdasarkan data tersimpan
            $('.menu-checkbox').prop('checked', false);
            if (menuAktif) {
                try {
                    let menus = JSON.parse(menuAktif);
                    menus.forEach(function(menu) {
                        $(`#menu_${menu}`).prop('checked', true);
                    });
                } catch (e) {
                    console.error("Gagal parse JSON menu aktif");
                }
            } else {
                // Default centang semua jika belum disetting
                $('.menu-checkbox').prop('checked', true);
            }

            $('#modalSettingTemplate').modal('show');
        });

        // Handle Submit Form Setting
        $('#formSettingTemplate').submit(function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('save_template_poli') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#modalSettingTemplate').modal('hide');
                    Swal.fire({
                        title: "Tersimpan!",
                        text: "Setting template poliklinik berhasil diupdate.",
                        icon: "success",
                        confirmButtonColor: "#4f46e5"
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan sistem.",
                        icon: "error",
                        confirmButtonColor: "#e11d48"
                    });
                }
            });
        });
    });
</script>
@endsection
