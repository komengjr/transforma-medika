@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
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
        --ent-action-bg: #4f46e5;
        --ent-action-color: #ffffff;
        --ent-action-hover-bg: #4338ca;
        --ent-action-hover-color: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-action-bg: #4f46e5;
        --ent-action-color: #ffffff;
        --ent-action-hover-bg: #6366f1;
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
        background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
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

    /* Form Controls */
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

    /* Table Styling */
    .table-custom {
        font-size: 0.82rem;
        border-collapse: collapse !important;
        width: 100% !important;
        margin-bottom: 0 !important;
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
        text-align: center;
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

    /* Solid Action Button inside Table (Non-Transparent) */
    .btn-ranap-handling {
        background-color: var(--ent-action-bg) !important;
        color: var(--ent-action-color) !important;
        border: 1px solid rgba(79, 70, 229, 0.45) !important;
        border-radius: 9px !important;
        font-weight: 600 !important;
        font-size: 0.76rem !important;
        opacity: 1 !important;
        box-shadow: 0 3px 10px -2px rgba(79, 70, 229, 0.35);
        transition: all 0.18s ease;
    }

    .btn-ranap-handling:hover,
    .btn-ranap-handling:focus {
        background-color: var(--ent-action-hover-bg) !important;
        color: var(--ent-action-hover-color) !important;
        opacity: 1 !important;
        transform: translateY(-1px);
    }

    /* DataTables Controls */
    #table-registrasi-ranap_wrapper > .row:first-child,
    #table-registrasi-ranap_wrapper .dt-layout-row:first-child {
        padding: 4px 0 14px 0;
        margin: 0 !important;
    }

    #table-registrasi-ranap_wrapper > .row:last-child,
    #table-registrasi-ranap_wrapper .dt-layout-row:last-child {
        padding: 14px 0 4px 0;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #table-registrasi-ranap_wrapper .dataTables_filter input,
    #table-registrasi-ranap_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-registrasi-ranap_wrapper .dataTables_length select,
    #table-registrasi-ranap_wrapper .dt-length select {
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
                            <i class="fas fa-hospital-user text-info fs-2"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.45); color: #6ee7b7;">
                                    <i class="fas fa-procedures me-1"></i> Rawat Inap (Ranap)
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Monitoring Bangsal &amp; Penanganan Pasien</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">List Registrasi &amp; Penanganan Rawat Inap</h4>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-calendar-check text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">{{ date('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<div class="ent-card mb-3 p-3 p-md-4">
    <form id="form-filter" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-2.5 align-items-center">
            <div class="col-auto">
                <button type="button" onclick="reloadTable()" class="btn ent-btn ent-btn-primary btn-sm px-3 fw-semibold d-flex align-items-center gap-1" style="height: 38px;">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
            <div class="col-sm-6 col-md">
                <input class="form-control form-control-sm ent-input" type="date" id="start_date" name="start_date" value="{{ $startDate }}" />
            </div>
            <div class="col-sm-6 col-md">
                <input class="form-control form-control-sm ent-input" type="date" id="end_date" name="end_date" value="{{ $endDate }}" />
            </div>
            <div class="col-sm-12 col-md">
                <input class="form-control form-control-sm ent-input" type="text" id="keyword" name="keyword" placeholder="Cari Reg/Nama/RM..." />
            </div>
            <div class="col-auto">
                <button type="submit" class="btn ent-btn ent-btn-warning btn-sm px-3" style="height: 38px;" title="Cari / Filter">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE -->
<div class="ent-card mb-4">
    <div class="ent-card-header d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="fas fa-list-alt text-primary"></i> Data Kunjungan Pasien Rawat Inap
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table id="table-registrasi-ranap" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Registrasi</th>
                        <th>Pasien &amp; RM</th>
                        <th>Tanggal Masuk</th>
                        <th>Dokter DPJP</th>
                        <th>Bangsal / Ruangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL HANDLING RANAP -->
<div class="modal fade" id="modal-handling-ranap" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div id="menu-handling-ranap"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let tableRanap;
    $(document).ready(function() {
        tableRanap = $('#table-registrasi-ranap').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_ranap_table') }}",
                type: "GET",
                dataSrc: 'data',
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
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
                    data: 'no_registrasi',
                    render: function(data) {
                        return `<span class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">${data}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<div class="fw-bold">${row.nama}</div><small class="opacity-75" style="font-family: 'JetBrains Mono', monospace;">RM: ${row.pid}</small>`;
                    }
                },
                {
                    data: 'tgl_masuk',
                    render: function(data) {
                        if (!data) return '-';
                        let date = new Date(data);
                        return date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        }) + ' ' + date.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                },
                {
                    data: 'nama_lengkap',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span class="fw-bold">${row.nama_ruangan} (${row.kelas})</span><br>
                                <small class="text-success fw-semibold"><i class="fas fa-bed me-1"></i>Bed: ${row.nomor_bed}</small>`;
                    },
                    orderable: false
                },
                {
                    data: 'status_inap',
                    render: function(data) {
                        let statusText = data ? data : 'DIRAWAT';
                        let badgeStyle = (statusText === 'DIRAWAT')
                            ? 'background: rgba(16, 185, 129, 0.16); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.4);'
                            : 'background: rgba(245, 158, 11, 0.16); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.4);';
                        return `<span class="ent-badge" style="${badgeStyle}">${statusText}</span>`;
                    },
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'id',
                    render: function(data) {
                        return `<button type="button" class="btn btn-ranap-handling btn-sm px-2.5 py-1" data-code="${data}"><i class="fas fa-bed me-1"></i> Handling</button>`;
                    },
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    function reloadTable() {
        tableRanap.ajax.reload(null, false);
    }

    // Klik Tombol Handling Ranap
    $(document).on("click", "#table-registrasi-ranap .btn-ranap-handling", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $('#menu-handling-ranap').html('<div class="py-5 text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 fw-semibold small">Memuat Form Handling Rawat Inap...</p></div>');
        $('#modal-handling-ranap').modal('show');

        $.ajax({
            url: "{{ route('ranap.handling.form') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-handling-ranap').html(data);
        }).fail(function() {
            $('#menu-handling-ranap').html('<div class="alert alert-danger m-3 rounded-3">Gagal memuat form handling rawat inap.</div>');
        });
    });
</script>
@endsection
