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

    /* Solid Action Buttons inside Table */
    .table-custom td .btn,
    .table-custom td .btn-sm {
        opacity: 1 !important;
    }

    /* DataTables Controls */
    #table-riwayat-igd_wrapper > .row:first-child,
    #table-riwayat-igd_wrapper .dt-layout-row:first-child {
        padding: 4px 0 14px 0;
        margin: 0 !important;
    }

    #table-riwayat-igd_wrapper > .row:last-child,
    #table-riwayat-igd_wrapper .dt-layout-row:last-child {
        padding: 14px 0 4px 0;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #table-riwayat-igd_wrapper .dataTables_filter input,
    #table-riwayat-igd_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-riwayat-igd_wrapper .dataTables_length select,
    #table-riwayat-igd_wrapper .dt-length select {
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
                                <span class="ent-badge" style="background: rgba(244, 63, 94, 0.2); border: 1px solid rgba(244, 63, 94, 0.45); color: #fda4af;">
                                    <i class="fas fa-folder-open me-1"></i> Arsip &amp; Rekam Medis
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Histori Kunjungan IGD</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">Riwayat &amp; Histori Pasien IGD</h4>
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
            <div class="col-sm-6 col-md-4">
                <label class="ent-field-label"><i class="far fa-calendar-alt text-primary me-1"></i> Dari Tanggal</label>
                <input class="form-control form-control-sm ent-input" type="date" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" />
            </div>
            <div class="col-sm-6 col-md-4">
                <label class="ent-field-label"><i class="far fa-calendar-alt text-primary me-1"></i> Sampai Tanggal</label>
                <input class="form-control form-control-sm ent-input" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-sm-12 col-md-4">
                <label class="ent-field-label"><i class="fas fa-check-circle text-success me-1"></i> Status Kunjungan</label>
                <select id="status_kunjungan" name="status_kunjungan" class="form-select ent-input select2-riwayat-igd" data-placeholder="-- Semua Status --">
                    <option value="">-- Semua Status --</option>
                    <option value="MENUNGGU">Menunggu</option>
                    <option value="PROSES">Penanganan</option>
                    <option value="SELESAI">Selesai / Pulang</option>
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

<!-- MAIN TABLE RIWAYAT IGD -->
<div class="ent-card mb-4">
    <div class="ent-card-header d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="fas fa-list-alt text-primary"></i> Data Histori Kunjungan IGD
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table id="table-riwayat-igd" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Reg &amp; Waktu</th>
                        <th>Pasien &amp; RM</th>
                        <th>Dokter Pemeriksa</th>
                        <th class="text-center">Status Akhir</th>
                        <th class="text-end">Total Tagihan</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL RIWAYAT IGD -->
<div class="modal fade" id="modalDetailRiwayatIgd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4">
                <h6 class="modal-title fw-bold text-white mb-0">
                    <i class="fas fa-notes-medical me-2 text-info"></i> Riwayat Penanganan IGD: <span id="igd_nama_pasien"></span>
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Info Ringkas -->
                <div class="ent-info-box mb-3" style="border-color: rgba(225, 29, 72, 0.35); background-color: rgba(225, 29, 72, 0.05);">
                    <span class="ent-field-label d-block mb-1">Keluhan / Catatan Medis Utama</span>
                    <p id="igd_keluhan" class="mb-0 fw-bold text-danger">-</p>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="ent-info-box h-100">
                            <span class="ent-field-label d-block mb-1">Anamnesis / Pemeriksaan Awal</span>
                            <span id="igd_anamnesis" class="fw-semibold">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ent-info-box h-100">
                            <span class="ent-field-label d-block mb-1">Diagnosis / Tindakan Utama</span>
                            <span id="igd_diagnosis" class="fw-semibold">-</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-2" style="font-size: 0.85rem;">
                    <i class="fas fa-list-ul text-primary me-1"></i> Rincian Tindakan &amp; Layanan Selama di IGD
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
                        <tbody id="tbody-igd-tindakan">
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
    let tableRiwayatIgd;

    function initSelect2RiwayatIgd(selector) {
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
        initSelect2RiwayatIgd('.select2-riwayat-igd');

        tableRiwayatIgd = $('#table-riwayat-igd').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('igd.riwayat.datatable') }}",
                type: "GET",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.status_kunjungan = $('#status_kunjungan').val();
                    d.keyword = $('#keyword').val();
                }
            },
            columns: [{
                    data: 'no',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'no_registrasi',
                    name: 'reg.no_registrasi'
                },
                {
                    data: 'nama_pasien',
                    name: 'p.nama'
                },
                {
                    data: 'dokter',
                    name: 'doc_poli.nama_lengkap'
                },
                {
                    data: 'status',
                    name: 'reg.status_kunjungan',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'tagihan',
                    name: 't.total_tagihan',
                    className: 'text-end'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari data riwayat IGD..."
            }
        });
    });

    function reloadTable() {
        tableRiwayatIgd.ajax.reload(null, false);
    }

    function resetFilter() {
        $('#start_date').val("{{ date('Y-m-01') }}");
        $('#end_date').val("{{ date('Y-m-d') }}");
        $('#status_kunjungan').val('').trigger('change');
        $('#keyword').val('');
        reloadTable();
    }

    function lihatRiwayatIgd(registrasiId, namaPasien) {
        $('#igd_nama_pasien').text(namaPasien);
        $('#igd_keluhan').text('Memuat...');
        $('#igd_anamnesis').text('Memuat...');
        $('#igd_diagnosis').text('Memuat...');
        $('#tbody-igd-tindakan').html('<tr><td colspan="3" class="text-center py-3">Memuat data...</td></tr>');

        $('#modalDetailRiwayatIgd').modal('show');

        // Sesuaikan nama route di bawah ini dengan rute detail riwayat/verifikasi yang aktif di routes/web.php
        $.ajax({
            url: "{{ route('igd.detail.verifikasi') }}",
            type: "GET",
            data: {
                registrasi_id: registrasiId
            },
            success: function(res) {
                if (res.success) {
                    let igd = res.igd;
                    $('#igd_keluhan').text(igd && igd.keluhan_utama ? igd.keluhan_utama : 'Penanganan kegawatdaruratan medis IGD unit.');
                    $('#igd_anamnesis').text(igd && igd.anamnesis ? igd.anamnesis : 'Pemeriksaan fisik awal dan stabilisasi pasien.');
                    $('#igd_diagnosis').text(igd && igd.diagnosis ? igd.diagnosis : 'Sesuai catatan pemeriksaan dokter DPJP IGD.');

                    let tindakanRows = '';
                    if (res.tindakanList && res.tindakanList.length > 0) {
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
                        tindakanRows = '<tr><td colspan="3" class="text-center opacity-75 py-3">Belum ada tindakan atau layanan IGD tercatat.</td></tr>';
                    }
                    $('#tbody-igd-tindakan').html(tindakanRows);
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat rincian histori penanganan IGD.', 'error');
            }
        });
    }
</script>
@endsection
