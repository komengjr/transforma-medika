@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
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
        font-size: 0.78rem;
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

    .ent-btn-danger {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.22);
    }

    .ent-btn-danger:hover {
        color: #ffffff;
    }

    .ent-btn-light {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color, var(--ent-solid-text));
    }

    /* Inputs & Labels */
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

    /* Poliklinik Item Cards */
    .poli-item-card {
        cursor: pointer;
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        transition: all 0.18s ease;
        margin-bottom: 10px;
    }

    .poli-item-card:hover {
        border-color: var(--ent-indigo);
        background-color: rgba(79, 70, 229, 0.05);
        transform: translateY(-1px);
    }

    .poli-item-card.active {
        border-color: var(--ent-indigo);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(2, 132, 199, 0.08) 100%);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }

    /* Empty State Card */
    .ent-empty-state {
        border: 1px dashed var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--ent-subtle-surface);
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
        background-color: rgba(79, 70, 229, 0.06) !important;
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

    /* DataTables Search & Length Styling */
    .dt-container .dt-search input,
    .dt-container .dt-length select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 9px !important;
        padding: 5px 10px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
    }

    .dt-container .dt-search input:focus,
    .dt-container .dt-length select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14) !important;
        outline: none;
    }

    /* Modal & Choices.js Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: visible;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        color: #ffffff;
        border-radius: 17px 17px 0 0;
    }

    .ent-modal-footer {
        background-color: var(--ent-subtle-surface);
        border-top: 1px solid var(--ent-grid-border);
        border-radius: 0 0 17px 17px;
    }

    .choices__inner {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        min-height: 40px !important;
        padding: 4px 10px !important;
    }

    .choices__list--dropdown {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15) !important;
        z-index: 1070;
    }

    .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
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
                            <img src="{{ asset('img/doctor.png') }}" alt="Dokter Poliklinik" width="38" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-hospital-user"></i> SETTING MAPPING
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Master Doctor Poli</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                                Dokter Poliklinik
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Atur penugasan dokter praktik untuk setiap poliklinik secara terpusat.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end d-flex flex-wrap justify-content-lg-end gap-2">
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Total Poliklinik</span>
                            <span class="fw-bold" id="badge-total-poli" style="color: #7dd3fc; font-family: 'JetBrains Mono', monospace;">0</span>
                        </div>
                        <div class="ent-glass-pill px-3 py-2 text-start">
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Dokter Bertugas</span>
                            <span class="fw-bold text-success" id="badge-total-dokter" style="font-family: 'JetBrains Mono', monospace;">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTAINER ALERT AJAX -->
<div id="ajax-alert-container"></div>

<!-- MAIN LAYOUT 2 KOLOM -->
<div class="row g-3">

    <!-- KOLOM KIRI: DAFTAR POLIKLINIK -->
    <div class="col-lg-4 col-md-5">
        <div class="ent-card h-100">
            <div class="ent-card-header">
                <h6 class="mb-0 fw-bold"><i class="fas fa-clinic-medical me-2 text-primary"></i>Daftar Poliklinik</h6>
                <small class="opacity-75">Klik poliklinik untuk melihat dan mengatur dokter.</small>
            </div>
            <div class="card-body p-3" style="max-height: 650px; overflow-y: auto;">

                <div class="mb-3">
                    <label for="search-poli-input" class="ent-label">Cari Poliklinik</label>
                    <input type="text" id="search-poli-input" class="form-control ent-input" placeholder="Ketik nama atau kode poliklinik..." autocomplete="off">
                </div>

                <div id="poli-list-loading" class="text-center py-5">
                    <div class="spinner-border text-primary" style="width: 2.5rem; height: 2.5rem;" role="status"></div>
                    <p class="mb-0 mt-3 fw-semibold small opacity-75">Memuat daftar poliklinik...</p>
                </div>

                <div id="container-poli-cards" class="d-flex flex-column"></div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: TABEL DOKTER -->
    <div class="col-lg-8 col-md-7">

        <!-- EMPTY STATE JIKA BELUM PILIH POLI -->
        <div class="ent-card ent-empty-state h-100 d-flex flex-column justify-content-center align-items-center p-5 text-center" id="alert-select-poli">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                style="width: 68px; height: 68px; background: rgba(79, 70, 229, 0.12); color: var(--ent-indigo);">
                <i class="fas fa-hand-point-left fs-3"></i>
            </div>
            <h5 class="fw-bold mb-1">Silakan Pilih Poliklinik</h5>
            <p class="small opacity-75 mb-0" style="max-width: 380px;">Pilih salah satu poliklinik pada daftar di sebelah kiri untuk menampilkan dan mengelola dokter yang bertugas.</p>
        </div>

        <!-- CONTAINER TABEL DOKTER -->
        <div class="ent-card d-none" id="card-table-doctors">
            <div class="ent-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h6 class="mb-0 fw-bold" id="title-table-doctor">
                        <i class="fas fa-user-md me-2 text-primary"></i>Daftar Dokter Bertugas
                    </h6>
                    <small class="opacity-75">Kelola mapping dokter aktif pada poliklinik terpilih.</small>
                </div>
                <button type="button" class="btn btn-sm ent-btn ent-btn-primary px-3 py-2 d-none" id="btn-open-modal-add" data-bs-toggle="modal" data-bs-target="#modal-add-doctor-poli">
                    <i class="fas fa-user-plus me-1"></i> Tambah Dokter
                </button>
            </div>
            <div class="card-body p-0">
                <div id="table-loading" class="text-center py-5 d-none">
                    <div class="spinner-border text-primary" style="width: 2.5rem; height: 2.5rem;" role="status"></div>
                    <p class="mb-0 mt-3 fw-semibold small opacity-75">Memuat data dokter...</p>
                </div>

                <div class="table-responsive p-3">
                    <table id="table-doctor-poli" class="table table-custom align-middle nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 48px;">No</th>
                                <th>Kode Dokter</th>
                                <th>NIK Dokter</th>
                                <th>Nama Dokter</th>
                                <th class="text-center" style="width: 105px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-doctor-poli"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL ASSIGN DOKTER -->
<div class="modal fade" id="modal-add-doctor-poli" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fas fa-user-plus me-2"></i>Tambah Dokter ke Poli
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-add-doctor-poli">
                @csrf
                <input type="hidden" name="poli_id" id="modal_input_poli_id">

                <div class="modal-body p-4">
                    <div class="mb-2">
                        <label class="ent-label" for="select_available_doctors">Pilih Dokter <span class="text-danger">*</span></label>
                        <select class="form-select" id="select_available_doctors" name="doctor_id" required>
                            <option value="">-- Pilih Dokter --</option>
                        </select>
                        <small class="opacity-75 d-block mt-2">Ketik nama atau kode dokter untuk mencari dokter yang belum ter-mapping ke poli ini.</small>
                    </div>
                </div>
                <div class="modal-footer ent-modal-footer px-4 py-3">
                    <button class="btn ent-btn ent-btn-light px-3 py-2" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn ent-btn ent-btn-primary px-4 py-2" type="submit" id="btn-save-doctor">
                        <i class="fas fa-save me-1"></i> Simpan Mapping
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
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let dataTableInstance = null;
    let selectedPoliId = null;
    let doctorChoicesInstance = null;

    function initDoctorChoices() {
        const selectEl = document.getElementById('select_available_doctors');
        if (!selectEl || typeof Choices === 'undefined') return;

        if (doctorChoicesInstance && typeof doctorChoicesInstance.destroy === 'function') {
            doctorChoicesInstance.destroy();
            doctorChoicesInstance = null;
        }

        doctorChoicesInstance = new Choices(selectEl, {
            searchEnabled: true,
            shouldSort: false,
            itemSelectText: '',
            placeholderValue: 'Ketik atau pilih dokter...',
            searchPlaceholderValue: 'Cari nama atau kode dokter...'
        });
    }

    $(document).ready(function() {
        initDoctorChoices();
        fetchPolis();

        $('#search-poli-input').on('keyup input', function() {
            const value = $(this).val().toLowerCase();
            $('.poli-item-card').each(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Klik pada Card Poli
        $(document).on('click', '.poli-item-card', function() {
            $('.poli-item-card').removeClass('active');
            $(this).addClass('active');

            selectedPoliId = $(this).data('id');
            const poliName = $(this).data('name');

            if (selectedPoliId) {
                $('#modal_input_poli_id').val(selectedPoliId);
                $('#btn-open-modal-add').removeClass('d-none');
                $('#card-table-doctors').removeClass('d-none');
                $('#alert-select-poli').addClass('d-none');
                $('#title-table-doctor').html(`<i class="fas fa-user-md me-2 text-primary"></i>Dokter di ${poliName}`);

                fetchDoctorsByPoli(selectedPoliId);
            }
        });

        // Submit Form
        $('#form-add-doctor-poli').on('submit', function(e) {
            e.preventDefault();
            const btnSave = $('#btn-save-doctor');
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            const formData = new FormData(this);

            fetch("{{ route('master_doctor_poliklinik_save') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(res => {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Mapping');

                    if (res.status === 'success' || res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 1400,
                            showConfirmButton: false
                        });
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modal-add-doctor-poli'));
                        if (modalInstance) modalInstance.hide();
                        if (selectedPoliId) fetchDoctorsByPoli(selectedPoliId);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Gagal menyimpan mapping dokter.'
                        });
                    }
                })
                .catch(() => {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Mapping');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem server.'
                    });
                });
        });
    });

    // Fetch Daftar Poli
    function fetchPolis() {
        $('#poli-list-loading').removeClass('d-none');
        fetch("{{ route('master_doctor_poliklinik_list') }}")
            .then(response => response.json())
            .then(res => {
                $('#poli-list-loading').addClass('d-none');
                let cardsHtml = '';

                if (res.status === 'success' && res.data.length > 0) {
                    $('#badge-total-poli').text(res.data.length);
                    res.data.forEach(item => {
                        cardsHtml += `
                            <div class="poli-item-card p-3" data-id="${item.id}" data-code="${item.kode_poli}" data-name="${item.nama_poli}">
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <div class="fw-bold mb-1">${item.nama_poli}</div>
                                        <span class="code-chip"><i class="fas fa-hashtag me-1"></i>${item.kode_poli}</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                                        style="width: 36px; height: 36px; background: rgba(79, 70, 229, 0.1); color: var(--ent-indigo);">
                                        <i class="fas fa-stethoscope"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    $('#badge-total-poli').text('0');
                    cardsHtml = `<div class="text-center fw-semibold small opacity-75 py-4">Tidak ada data poliklinik aktif</div>`;
                }
                $('#container-poli-cards').html(cardsHtml);
            });
    }

    // Fetch Dokter berdasarkan Poli ID
    function fetchDoctorsByPoli(poliId) {
        $('#table-loading').removeClass('d-none');
        fetch(`{{ route('master_doctor_poliklinik_get_doctor') }}?poli_id=${poliId}`)
            .then(response => response.json())
            .then(res => {
                $('#table-loading').addClass('d-none');
                if (dataTableInstance) {
                    dataTableInstance.destroy();
                    dataTableInstance = null;
                }

                let tbodyContent = '';
                let availableDocOptions = '<option value="">-- Pilih Dokter --</option>';

                if (res.status === 'success') {
                    const mappedList = res.data.mapped_doctors || [];
                    $('#badge-total-dokter').text(mappedList.length);

                    if (mappedList.length > 0) {
                        mappedList.forEach((doc, idx) => {
                            tbodyContent += `
                                <tr>
                                    <td class="text-center fw-semibold">${idx + 1}</td>
                                    <td><span class="code-chip">${doc.kode_dokter}</span></td>
                                    <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">${doc.nik || '-'}</td>
                                    <td class="fw-bold">${doc.nama_lengkap}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm ent-btn ent-btn-danger btn-delete-doctor px-2 py-1" data-mapping-id="${doc.mapping_id}">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    (res.data.available_doctors || []).forEach(doc => {
                        availableDocOptions += `<option value="${doc.id}">${doc.kode_dokter} - ${doc.nama_lengkap}</option>`;
                    });
                }

                $('#tbody-doctor-poli').html(tbodyContent);
                $('#select_available_doctors').html(availableDocOptions);
                initDoctorChoices();

                dataTableInstance = new DataTable('#table-doctor-poli', {
                    responsive: true,
                    language: {
                        search: "Cari Dokter:",
                        lengthMenu: "Tampil _MENU_ data",
                        info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ dokter",
                        emptyTable: "Belum ada dokter yang di-mapping ke poliklinik ini.",
                        paginate: {
                            first: "Awal",
                            last: "Akhir",
                            next: "❯",
                            previous: "❮"
                        }
                    }
                });
            });
    }

    // Hapus Dokter dari Poli
    $(document).on('click', '.btn-delete-doctor', function() {
        const mappingId = $(this).data('mapping-id');
        const btn = $(this);

        Swal.fire({
            title: 'Keluarkan Dokter?',
            text: 'Dokter akan dihapus dari mapping poliklinik ini.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (!result.isConfirmed) return;

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

            fetch("{{ route('master_doctor_poliklinik_remove') }}", {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        mapping_id: mappingId
                    })
                })
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 1400,
                            showConfirmButton: false
                        });
                        if (selectedPoliId) fetchDoctorsByPoli(selectedPoliId);
                    } else {
                        btn.prop('disabled', false).html('<i class="fas fa-trash-alt me-1"></i> Hapus');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Gagal menghapus mapping dokter.'
                        });
                    }
                });
        });
    });
</script>
@endsection
