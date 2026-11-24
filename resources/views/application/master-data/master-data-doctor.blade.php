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

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.22);
    }

    .ent-btn-success:hover {
        color: #ffffff;
    }

    .ent-btn-light {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color, var(--ent-solid-text));
    }

    /* Labels & Form Controls */
    .ent-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
        display: block;
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

    .form-select option {
        background-color: var(--ent-solid-bg);
        color: var(--ent-solid-text);
        font-weight: 600;
        padding: 6px 10px;
    }

    .input-group-text.ent-addon {
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        background-color: var(--ent-subtle-surface) !important;
        color: var(--bs-secondary-color, #64748b) !important;
    }

    .input-group .ent-input-grouped {
        border-radius: 0 10px 10px 0 !important;
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
                            <img src="{{ asset('img/doctor.png') }}" alt="Doctor Icon" width="38" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-user-doctor"></i> {{ env('APP_LABEL', 'HIS') }} MASTER DATA
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Direktori Tenaga Medis</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                                Master Data Dokter
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pengelolaan data dokter, spesialisasi, SIP, status keaktifan, serta import data massal.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end d-flex flex-wrap justify-content-lg-end gap-2">
                        @if(isset($listSpesialis))
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Spesialisasi</span>
                            <span class="fw-bold" style="color: #7dd3fc; font-family: 'JetBrains Mono', monospace;">{{ $listSpesialis->count() }}</span>
                        </div>
                        @endif
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
            <h6 class="mb-0 fw-bold"><i class="fas fa-sliders me-1 text-primary"></i> Filter Pencarian Data Dokter</h6>
            <small class="opacity-75">Saring berdasarkan kata kunci, spesialisasi, atau status keaktifan.</small>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="ent-label">Pencarian Cepat / Keyword</label>
                <div class="input-group">
                    <span class="input-group-text ent-addon"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control ent-input ent-input-grouped" id="customSearchBox" placeholder="Cari nama, kode, atau NIK...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="ent-label">Spesialisasi</label>
                <select class="form-select ent-input" id="filterSpesialis">
                    <option value="">-- Semua Spesialisasi --</option>
                    @if(isset($listSpesialis))
                    @foreach($listSpesialis as $sp)
                    <option value="{{ $sp->kode_spesialis }}">{{ $sp->nama_spesialis }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <label class="ent-label">Status Keaktifan</label>
                <select class="form-select ent-input" id="filterStatus">
                    <option value="">-- Semua Status --</option>
                    <option value="1">Aktif</option>
                    <option value="0">Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn ent-btn ent-btn-light w-100 py-2" id="btnResetFilter">
                    <i class="fas fa-rotate-left me-1 text-danger"></i> Reset
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MAIN TABLE CARD -->
<div class="ent-card mb-4">
    <div class="ent-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h6 class="mb-0 fw-bold">Direktori Dokter</h6>
            <small class="opacity-75">Daftar lengkap dokter terdaftar pada sistem.</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-toggle="modal" data-bs-target="#modal-import-excel">
                <i class="fas fa-file-excel me-1 text-success"></i> Import Excel
            </button>
            <button type="button" class="btn ent-btn ent-btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#modal-doctor" id="button-add-doctor" data-code="0">
                <i class="fas fa-plus me-1"></i> Tambah Dokter
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive pb-3">
            <table id="tableDoctor" class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 55px;">NO</th>
                        <th>Kode Dokter</th>
                        <th>Nama Lengkap &amp; Gelar</th>
                        <th>Spesialisasi</th>
                        <th>SIP</th>
                        <th>No Handphone</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 95px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dirender via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL FORM DOKTER -->
<div class="modal fade" id="modal-doctor" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fas fa-user-md me-2" style="color: #38bdf8;"></i> Form Data Dokter
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-doctor"></div>
        </div>
    </div>
</div>

<!-- MODAL IMPORT EXCEL -->
<div class="modal fade" id="modal-import-excel" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fas fa-file-excel me-2" style="color: #34d399;"></i> Import Data Dokter dari Excel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-import-doctor" action="{{ route('master_doctor_data_doctor_import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-2">
                        <label class="ent-label">Pilih File Excel (.xlsx / .xls / .csv) <span class="text-danger">*</span></label>
                        <input class="form-control ent-input py-2" type="file" name="file_excel" accept=".xlsx, .xls, .csv" required />
                        <small class="opacity-75 mt-2 d-block">
                            Pastikan format kolom (baris pertama) sesuai: <code>nama_lengkap</code>, <code>spesialisasi</code>, <code>jenis_kelamin</code> (L/P), <code>nik</code>, <code>sip</code>, <code>email</code>, <code>no_telp</code>, <code>alamat</code>.
                        </small>
                    </div>
                </div>
                <div class="modal-footer ent-modal-footer px-4 py-3">
                    <button class="btn ent-btn ent-btn-light px-3 py-2" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn ent-btn ent-btn-success px-4 py-2" type="submit" id="btn-submit-import">
                        <i class="fas fa-upload me-1"></i> Upload &amp; Import
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // 1. SETUP DATATABLES
        var table = $('#tableDoctor').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('master_doctor_get_data') }}",
                type: 'GET',
                data: function(d) {
                    d.status = $('#filterStatus').val();
                    d.spesialis = $('#filterSpesialis').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center fw-bold'
                },
                {
                    data: 'kode_dokter',
                    name: 'kode_dokter',
                    render: function(data) {
                        return `<span class="code-chip">${data}</span>`;
                    }
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap',
                    render: function(data, type, row) {
                        let baseUrl = "{{ asset('storage/doctors') }}";
                        let defaultImg = "{{ asset('img/doctor.png') }}";
                        let fotoUrl = row.foto ? `${baseUrl}/${row.foto}` : defaultImg;

                        let isActive = (row.is_active && row.is_active.includes('bg-success'));
                        let statusDotColor = isActive ? '#10b981' : '#f43f5e';

                        return `
                          <div class="d-flex align-items-center">
                              <div class="position-relative me-3 flex-shrink-0">
                                  <div class="rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; border: 1px solid var(--ent-grid-border); background-color: var(--ent-subtle-surface);">
                                      <img class="rounded-circle" src="${fotoUrl}" alt="Foto ${data}" style="object-fit: cover; width: 36px; height: 36px;" />
                                  </div>
                                  <span class="position-absolute bottom-0 end-0 rounded-circle" style="background-color: ${statusDotColor}; width: 12px; height: 12px; border: 2px solid var(--ent-solid-bg);"></span>
                              </div>

                              <div class="flex-1">
                                  <div class="fw-bold text-nowrap">${data}</div>
                                  <small class="opacity-75 d-flex align-items-center mt-1">
                                      <i class="fas fa-stethoscope me-1 text-primary"></i> Profesional Medis
                                  </small>
                              </div>
                          </div>`;
                    }
                },
                {
                    data: 'spesialisasi',
                    name: 'spesialisasi'
                },
                {
                    data: 'sip',
                    name: 'sip'
                },
                {
                    data: 'no_telp',
                    name: 'no_telp'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            order: [],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ dokter",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                }
            }
        });

        // 2. Event Kotak Pencarian
        $('#customSearchBox').on('keyup', function() {
            table.search(this.value).draw();
        });

        // 3. Event Filter Spesialis & Status
        $('#filterStatus, #filterSpesialis').on('change', function() {
            table.draw();
        });

        // 4. Tombol Reset Filter
        $('#btnResetFilter').on('click', function() {
            $('#customSearchBox').val('');
            $('#filterStatus').val('');
            $('#filterSpesialis').val('');
            table.search('').draw();
        });
    });

    // Event handler Tambah Dokter
    $(document).on("click", "#button-add-doctor", function(e) {
        e.preventDefault();
        bukaFormModal(0);
    });

    // Event handler Edit Dokter
    $(document).on("click", "#button-edit-doctor", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        bukaFormModal(code);
    });

    function bukaFormModal(code) {
        $('#menu-doctor').html('<div class="text-center p-5"><div class="spinner-border text-primary" style="width: 2.5rem; height: 2.5rem;" role="status"></div><p class="mt-3 fw-semibold opacity-75">Memuat form...</p></div>');
        $.ajax({
            url: "{{ route('master_doctor_data_doctor_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-doctor').html(data);
        }).fail(function() {
            $('#menu-doctor').html('<div class="alert alert-danger m-3 fw-semibold">Gagal memuat form dari server.</div>');
        });
    }

    // Submit Form AJAX
    $(document).on('submit', '#form-save-doctor', function(e) {
        e.preventDefault();
        let form = $(this);
        let btnSubmit = form.find('button[type="submit"]');
        let originalBtnText = btnSubmit.html();

        btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                btnSubmit.prop('disabled', false).html(originalBtnText);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#modal-doctor').modal('hide');
                    $('#tableDoctor').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function() {
                btnSubmit.prop('disabled', false).html(originalBtnText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error Server',
                    text: 'Gagal mengirim data.'
                });
            }
        });
    });

    // Import Excel AJAX
    $(document).on('submit', '#form-import-doctor', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let formData = new FormData(this);
        let btnSubmit = $('#btn-submit-import');
        let originalBtnText = btnSubmit.html();

        btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Mengimport...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                btnSubmit.prop('disabled', false).html(originalBtnText);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Import Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    form[0].reset();
                    $('#modal-import-excel').modal('hide');
                    $('#tableDoctor').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Import Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                btnSubmit.prop('disabled', false).html(originalBtnText);

                let errorMsg = 'Gagal mengirim file ke server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error Server',
                    text: errorMsg
                });
            }
        });
    });
</script>
@endsection
