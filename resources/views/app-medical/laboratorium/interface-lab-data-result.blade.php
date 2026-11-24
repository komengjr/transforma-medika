@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
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

    .ent-btn-light {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color, var(--ent-solid-text));
    }

    .ent-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
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

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS
       ========================================================= */
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

    .dt-container .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
    }

    .dt-container .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    .dt-container .dt-layout-table {
        margin: 0 !important;
    }

    .dt-container .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    .dt-container .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .dt-container .dt-length select {
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

    .ent-info-box {
        background-color: var(--ent-subtle-surface);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 16px;
    }

    .pre-raw {
        background-color: #0f172a;
        color: #34d399;
        border: 1px solid rgba(99, 102, 241, 0.3);
        padding: 15px;
        border-radius: 12px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.78rem;
        max-height: 400px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
        margin-bottom: 0;
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
                            <i class="fas fa-microscope fs-4" style="color: #38bdf8;"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-plug"></i> {{ env('APP_LABEL', 'HIS') }} LIS INTERFACE
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Laboratory Information System</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                                Data Hasil Interface Laboratory Information System
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pemantauan hasil pemeriksaan dari analyzer/instrument, flag QC &amp; query, detail parameter, serta raw payload.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end d-flex flex-wrap justify-content-lg-end gap-2">
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Instrumen Terdaftar</span>
                            <span class="fw-bold" style="color: #7dd3fc; font-family: 'JetBrains Mono', monospace;">{{ $alatList->count() }} Alat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER CARD -->
<div class="ent-card mb-3">
    <div class="ent-card-header d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold"><i class="fas fa-sliders me-1 text-primary"></i> Filter Pencarian Hasil Interface</h6>
            <small class="opacity-75">Saring berdasarkan nomor laboratorium, tanggal pemeriksaan, atau alat/instrument.</small>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="ent-label">No. Laboratorium</label>
                <input type="text" id="filter_nolab" class="form-control ent-input" placeholder="Cari No Lab...">
            </div>
            <div class="col-md-3">
                <label class="ent-label">Tanggal Pemeriksaan</label>
                <input type="date" id="filter_tanggal" class="form-control ent-input">
            </div>
            <div class="col-md-4">
                <label class="ent-label">Pilih Alat / Instrument</label>
                <select id="filter_instrument" class="form-select ent-input">
                    <option value="">-- Semua Alat --</option>
                    @foreach($alatList as $alat)
                    <option value="{{ $alat->instrument_id }}">{{ $alat->nama_alat }} ({{ $alat->kode_alat }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="button" id="btn-filter" class="btn ent-btn ent-btn-primary flex-fill py-2">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <button type="button" id="btn-reset" class="btn ent-btn ent-btn-light px-3 py-2" title="Reset Filter">
                    <i class="fas fa-rotate-left"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- TABLE CARD -->
<div class="ent-card mb-4">
    <div class="ent-card-header d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold">Daftar Data Hasil Interface</h6>
            <small class="opacity-75">Data hasil komunikasi LIS secara real-time.</small>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive pb-3">
            <table id="table-medical-results" class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th style="width: 55px;">ID</th>
                        <th>No. Lab</th>
                        <th>Instrument / Alat</th>
                        <th>Tanggal</th>
                        <th class="text-center" style="width: 85px;">QC</th>
                        <th class="text-center" style="width: 85px;">Query</th>
                        <th class="text-center" style="width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Hasil -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fa-solid fa-list-check me-2" style="color: #38bdf8;"></i> Detail Hasil Pemeriksaan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Info Header -->
                <div class="row g-2 mb-3 ent-info-box">
                    <div class="col-md-6">
                        <div class="small"><strong>No. Lab:</strong> <span id="info-nolab" class="code-chip ms-1">-</span></div>
                        <div class="small mt-1"><strong>Alat:</strong> <span id="info-alat" class="fw-semibold">-</span></div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="small"><strong>Tanggal:</strong> <span id="info-tanggal" style="font-family: 'JetBrains Mono', monospace;">-</span></div>
                        <div class="small mt-1"><strong>Status:</strong> <span id="info-status">-</span></div>
                    </div>
                </div>

                <!-- Table Hasil -->
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0 w-100">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Hasil</th>
                                <th>Satuan</th>
                                <th>Nilai Rujukan</th>
                                <th class="text-center">Flag</th>
                            </tr>
                        </thead>
                        <tbody id="detail-results-body">
                            <!-- Injected via Javascript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer ent-modal-footer px-4 py-3">
                <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Raw Payload -->
<div class="modal fade" id="modalRaw" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fas fa-code me-2" style="color: #38bdf8;"></i> Raw Payload (ASTM / HL7 / Protocol Data)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-2 small">No. Lab: <strong id="raw-nolab" class="code-chip">-</strong></div>
                <pre id="raw-content" class="pre-raw">Memuat data...</pre>
            </div>
            <div class="modal-footer ent-modal-footer px-4 py-3">
                <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Tutup</button>
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

<script>
    $(document).ready(function() {

        // 1. Inisialisasi DataTables
        var table = $('#table-medical-results').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('interfave_lab_data_result_get_data') }}",
                data: function(d) {
                    d.nolab = $('#filter_nolab').val();
                    d.tanggal = $('#filter_tanggal').val();
                    d.instrument_id = $('#filter_instrument').val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'mir.id'
                },
                {
                    data: 'nolab',
                    name: 'mir.nolab'
                },
                {
                    data: 'nama_instrument',
                    name: 'mma.nama_alat'
                },
                {
                    data: 'tanggal',
                    name: 'mir.tanggal'
                },
                {
                    data: 'flag_qc',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'flag_query',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'action',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                }
            }
        });

        // 2. Event Handler Filter & Reset
        $('#btn-filter').click(function() {
            table.draw();
        });

        $('#btn-reset').click(function() {
            $('#filter_nolab').val('');
            $('#filter_tanggal').val('');
            $('#filter_instrument').val('');
            table.draw();
        });

        // 3. Event Handler Dropdown Action
        $('#table-medical-results').on('change', '.action-select', function() {
            var action = $(this).val();
            var id = $(this).data('id');

            // Reset dropdown pilihan ke default
            $(this).val('');

            if (action === 'toggle-detail') {
                loadDetail(id);
            } else if (action === 'raw-payload') {
                loadRawPayload(id);
            }
        });

        // 4. Function Ajax Detail Hasil
        function loadDetail(id) {
            var url = "{{ route('interfave_lab_data_result_show_data_detail', ':id') }}".replace(':id', id);

            $.get(url, function(res) {
                if (res.status === 'success') {
                    $('#info-nolab').text(res.info.nolab);
                    $('#info-alat').text(res.info.nama_alat + ' (' + res.info.kode_alat + ')');
                    $('#info-tanggal').text(res.info.tanggal);

                    var flags = '';
                    if (res.info.flag_qc === 'Y') flags += '<span class="ent-badge me-1" style="background: rgba(217, 119, 6, 0.15); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.35);">QC</span>';
                    if (res.info.flag_query === 'Y') flags += '<span class="ent-badge" style="background: rgba(225, 29, 72, 0.15); color: #f43f5e; border: 1px solid rgba(225, 29, 72, 0.35);">Query</span>';
                    if (flags === '') flags = '<span class="ent-badge" style="background: rgba(100, 116, 139, 0.15); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.3);">Normal</span>';
                    $('#info-status').html(flags);

                    var tbody = $('#detail-results-body');
                    tbody.empty();

                    if (!res.results || res.results.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center opacity-75 py-4">Tidak ada item hasil pemeriksaan</td></tr>');
                    } else {
                        $.each(res.results, function(index, item) {
                            var param = item.px || item.test_name || item.code || '-';
                            var hasil = item.result || item.value || '-';
                            var satuan = item.unit || '-';
                            var rujukan = item.reference_range || '-';
                            var flag = item.flag ?
                                `<span class="ent-badge" style="background: rgba(225, 29, 72, 0.15); color: #f43f5e; border: 1px solid rgba(225, 29, 72, 0.35);">${item.flag}</span>` :
                                '-';

                            tbody.append(`
                                <tr>
                                    <td><span class="code-chip me-1">PX</span><strong>${param}</strong></td>
                                    <td class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">${hasil}</td>
                                    <td>${satuan}</td>
                                    <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">${rujukan}</td>
                                    <td class="text-center">${flag}</td>
                                </tr>
                            `);
                        });
                    }

                    $('#modalDetail').modal('show');
                }
            }).fail(function() {
                alert('Gagal mengambil detail data.');
            });
        }

        // 5. Function Ajax Raw Payload
        function loadRawPayload(id) {
            var url = "{{ route('interfave_lab_data_result_show_data_raw', ':id') }}".replace(':id', id);

            $('#raw-content').text('Memuat data...');
            $('#modalRaw').modal('show');

            $.get(url, function(res) {
                if (res.status === 'success') {
                    $('#raw-nolab').text(res.nolab);

                    // Format jika berbentuk JSON String
                    try {
                        var parsed = JSON.parse(res.raw_payload);
                        $('#raw-content').text(JSON.stringify(parsed, null, 4));
                    } catch (e) {
                        $('#raw-content').text(res.raw_payload);
                    }
                }
            }).fail(function() {
                $('#raw-content').text('Gagal memuat raw payload.');
            });
        }

    });
</script>
@endsection
