@extends('layouts.layouts')

@section('base.css')
<!-- Select2 CSS & Theme Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        font-size: 0.7rem;
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

    /* Form Controls & Labels */
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
        z-index: 1070;
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

    /* Kalender Grid Layout */
    .calendar-wrapper {
        display: grid;
        grid-template-columns: repeat(7, minmax(150px, 1fr));
        gap: 0.85rem;
        min-width: 1050px;
    }

    .day-column-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: var(--ent-subtle-surface);
        padding: 10px;
        min-height: 260px;
    }

    .day-column-header {
        background-color: rgba(79, 70, 229, 0.12);
        border: 1px solid var(--ent-grid-border);
        border-radius: 8px;
        padding: 6px 8px;
        font-size: 0.76rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        text-align: center;
        margin-bottom: 10px;
        color: var(--bs-body-color);
    }

    .schedule-card {
        transition: transform 0.16s ease, box-shadow 0.16s ease, border-color 0.16s ease;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
    }

    .schedule-card:hover {
        transform: translateY(-2px);
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.14) !important;
    }

    /* Scrollbar minimalis untuk tabel kalender */
    .custom-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: var(--ent-subtle-surface);
        border-radius: 8px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: rgba(79, 70, 229, 0.35);
        border-radius: 8px;
    }

    /* Nav Pills */
    .ent-nav-pills {
        background-color: var(--ent-subtle-surface);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 4px;
    }

    .ent-nav-pills .nav-link {
        border-radius: 9px;
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--bs-body-color);
        padding: 6px 14px;
    }

    .ent-nav-pills .nav-link.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff;
        box-shadow: 0 3px 10px rgba(79, 70, 229, 0.25);
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

    /* Modal Styling */
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
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<header class="mb-3">
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
                                <i class="fas fa-calendar-check"></i> MANAJEMEN OPERASIONAL
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Jadwal Dokter &amp; Kuota Poli</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Jadwal Praktek
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Pengaturan jadwal mingguan dokter, jam praktik, dan kuota pasien per poliklinik.</p>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                    <div class="ent-glass-pill px-3 py-2 text-start">
                        <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Jadwal Aktif</span>
                        <span class="fw-bold" id="totalScheduleCount" style="color: #7dd3fc; font-family: 'JetBrains Mono', monospace;">0</span>
                    </div>
                    <button type="button" class="btn ent-btn ent-btn-warning px-3 py-2" onclick="openAddModal()">
                        <i class="fas fa-plus me-1"></i> Tambah Jadwal
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- MAIN CONTENT -->
<main>
    <div class="row g-3">
        <!-- SIDEBAR FILTER -->
        <div class="col-lg-3">
            <div class="ent-card sticky-top" style="top: 20px; z-index: 10;">
                <div class="ent-card-header">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Filter Data</h6>
                    <small class="opacity-75">Saring jadwal berdasarkan poliklinik dan hari.</small>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="mb-3">
                        <label for="filter_poli" class="ent-label">Poliklinik</label>
                        <select id="filter_poli" class="form-select select2-filter" data-placeholder="Ketik atau pilih poliklinik...">
                            <option value="">-- Semua Poliklinik --</option>
                            @foreach($poliklinik as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="filter_hari" class="ent-label">Hari Praktek</label>
                        <select id="filter_hari" class="form-select select2-filter" data-placeholder="Ketik atau pilih hari...">
                            <option value="">-- Semua Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>

                    <button type="button" class="btn ent-btn ent-btn-light w-100 py-2" onclick="resetFilter()">
                        <i class="fas fa-rotate-left me-1"></i> Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- KONTEN UTAMA TABEL / KALENDER -->
        <div class="col-lg-9">
            <div class="ent-card h-100">
                <div class="ent-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0 fw-bold" id="viewTitle">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Kalender Mingguan
                        </h6>
                        <small class="opacity-75">Beralih antara tampilan kalender mingguan dan tabel ringkasan.</small>
                    </div>

                    <!-- Toggle Nav Pills -->
                    <ul class="nav nav-pills ent-nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-calendar-tab" data-bs-toggle="pill" data-bs-target="#pills-calendar" type="button" role="tab" onclick="changeViewTitle('Kalender Mingguan')">
                                <i class="fas fa-th-large me-1"></i> Kalender
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-table-tab" data-bs-toggle="pill" data-bs-target="#pills-table" type="button" role="tab" onclick="changeViewTitle('Tabel Daftar Jadwal')">
                                <i class="fas fa-list me-1"></i> Tabel
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-3">
                    <div class="tab-content" id="pills-tabContent">

                        <!-- TAB 1: KALENDER MINGGUAN -->
                        <div class="tab-pane fade show active" id="pills-calendar" role="tabpanel">
                            <div class="overflow-auto custom-scroll pb-2">
                                <div class="calendar-wrapper">
                                    @php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp
                                    @foreach($days as $day)
                                    <div class="day-column-box">
                                        <div class="day-column-header">{{ $day }}</div>
                                        <div id="col-day-{{ $day }}">
                                            <div class="text-center py-4 opacity-50 small fw-semibold">Memuat...</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: TABEL RINGKASAN -->
                        <div class="tab-pane fade" id="pills-table" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-custom align-middle w-100 m-0">
                                    <thead>
                                        <tr>
                                            <th>Poliklinik</th>
                                            <th>Dokter</th>
                                            <th>Hari</th>
                                            <th>Jam Praktek</th>
                                            <th>Kuota</th>
                                            <th>Status</th>
                                            <th class="text-end" style="width: 85px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleTableBody">
                                        <tr>
                                            <td colspan="7" class="text-center py-5 opacity-75 fw-semibold">Memuat data...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL TAMBAH JADWAL DOKTER -->
<div class="modal fade" id="modalJadwal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <h5 class="modal-title fw-bold mb-0" style="color: white;">
                    <i class="fas fa-user-clock me-2"></i>Tambah Jadwal Dokter
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formJadwal" onsubmit="saveSchedule(event)">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="poli_id" class="ent-label">Poliklinik <span class="text-danger">*</span></label>
                        <select id="poli_id" name="poli_id" class="form-select select2-modal" data-placeholder="Ketik atau pilih poliklinik..." required>
                            <option value="">-- Pilih Poliklinik --</option>
                            @foreach($poliklinik as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_id" class="ent-label">Dokter <span class="text-danger">*</span></label>
                        <select id="doctor_id" name="doctor_id" class="form-select select2-modal" data-placeholder="Ketik atau pilih dokter..." disabled required>
                            <option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="day_name" class="ent-label">Hari Praktek <span class="text-danger">*</span></label>
                        <select id="day_name" name="day_name" class="form-select select2-modal" data-placeholder="Ketik atau pilih hari..." required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="time_start" class="ent-label">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" id="time_start" name="time_start" class="form-control ent-input" required>
                        </div>
                        <div class="col-6">
                            <label for="time_end" class="ent-label">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" id="time_end" name="time_end" class="form-control ent-input" required>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label for="quota" class="ent-label">Kuota Pasien <span class="text-danger">*</span></label>
                        <input type="number" id="quota" name="quota" class="form-control ent-input" min="1" placeholder="Contoh: 20" required>
                    </div>
                </div>
                <div class="modal-footer ent-modal-footer px-4 py-3">
                    <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2" id="btnSave">
                        <i class="fas fa-save me-1"></i> Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let modalJadwal;
    const daysList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    $(document).ready(function() {
        $('.select2-filter').each(function() {
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: $(this).data('placeholder') || '-- Pilih --',
                allowClear: true
            });
        });

        $('.select2-modal').each(function() {
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#modalJadwal'),
                placeholder: $(this).data('placeholder') || '-- Pilih --',
                allowClear: true
            });
        });

        $('#filter_poli, #filter_hari').on('change', function() {
            loadScheduleTable();
        });

        $('#poli_id').on('change', function() {
            onModalPoliChange();
        });

        const modalElement = document.getElementById('modalJadwal');
        if (modalElement) {
            modalJadwal = new bootstrap.Modal(modalElement);
        }

        loadScheduleTable();
    });

    function changeViewTitle(title) {
        const icon = title === 'Kalender Mingguan' ? 'fa-calendar-alt' : 'fa-list';
        document.getElementById('viewTitle').innerHTML = `<i class="fas ${icon} me-2 text-primary"></i>${title}`;
    }

    function openAddModal() {
        document.getElementById('formJadwal').reset();
        $('#poli_id').val('').trigger('change.select2');
        $('#day_name').val('').trigger('change.select2');
        const docSelect = $('#doctor_id');
        docSelect.html('<option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>').prop('disabled', true).trigger('change.select2');

        if (modalJadwal) {
            modalJadwal.show();
        }
    }

    function loadScheduleTable() {
        const poliId = $('#filter_poli').val() || '';
        const day = $('#filter_hari').val() || '';

        daysList.forEach(d => {
            const col = document.getElementById(`col-day-${d}`);
            if (col) col.innerHTML = '';
        });

        const url = `{{ route('master_jadwal_doctor_poliklinik_getSchedules') }}?poli_id=${encodeURIComponent(poliId)}&day_name=${encodeURIComponent(day)}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                const tbody = document.getElementById('scheduleTableBody');
                tbody.innerHTML = '';

                if (!res.data || !Array.isArray(res.data) || res.data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-5 opacity-75 fw-semibold">Belum ada jadwal praktek terdaftar.</td></tr>`;
                    document.getElementById('totalScheduleCount').innerText = '0';

                    daysList.forEach(d => {
                        const col = document.getElementById(`col-day-${d}`);
                        if (col) col.innerHTML = `<div class="text-center py-4 opacity-50 small fw-semibold">Tidak ada jadwal</div>`;
                    });
                    return;
                }

                document.getElementById('totalScheduleCount').innerText = res.data.length;

                res.data.forEach(item => {
                    const fullName = item.nama_lengkap || item.master_doctor_name || 'Dokter';
                    const poliName = item.nama_poli || item.m_poli_name || 'Poli';
                    const statusText = (item.is_active || item.status === 'AKTIF') ? 'AKTIF' : 'NON-AKTIF';
                    const statusStyle = statusText === 'AKTIF'
                        ? 'background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.3);'
                        : 'background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.3);';
                    const scheduleId = item.id_schedule || item.id;
                    const rawStart = item.time_start || item.jam_mulai || '';
                    const rawEnd = item.time_end || item.jam_selesai || '';
                    const timeStart = rawStart ? rawStart.substring(0, 5) : '-';
                    const timeEnd = rawEnd ? rawEnd.substring(0, 5) : '-';
                    const dayName = item.day_name || item.hari_praktek;
                    const quota = item.quota || item.kuota_pasien;

                    tbody.innerHTML += `
                        <tr>
                            <td class="fw-bold">${poliName}</td>
                            <td class="fw-semibold">${fullName}</td>
                            <td><span class="code-chip">${dayName}</span></td>
                            <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">
                                <i class="far fa-clock me-1 text-primary"></i>${timeStart} - ${timeEnd}
                            </td>
                            <td>
                                <span class="ent-badge" style="background: rgba(217, 119, 6, 0.14); color: #d97706; border: 1px solid rgba(217, 119, 6, 0.3);">
                                    ${quota} Pasien
                                </span>
                            </td>
                            <td><span class="ent-badge" style="${statusStyle}">${statusText}</span></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm ent-btn ent-btn-danger px-2 py-1" onclick="deleteSchedule(${scheduleId})" title="Hapus Jadwal">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    const dayCol = document.getElementById(`col-day-${dayName}`);
                    if (dayCol) {
                        dayCol.innerHTML += `
                            <article class="schedule-card mb-2 p-2 position-relative">
                                <div class="d-flex justify-content-between align-items-start gap-1 mb-1">
                                    <span class="code-chip">${poliName}</span>
                                    <button type="button" class="btn btn-sm text-danger p-0 lh-1" onclick="deleteSchedule(${scheduleId})" title="Hapus">
                                        <i class="fas fa-times small"></i>
                                    </button>
                                </div>
                                <div class="fw-bold small mb-2" style="line-height: 1.3;">${fullName}</div>
                                <div class="d-flex align-items-center justify-content-between pt-1 border-top" style="border-color: var(--ent-grid-border) !important; font-family: 'JetBrains Mono', monospace; font-size: 0.7rem;">
                                    <span class="opacity-75"><i class="far fa-clock me-1"></i>${timeStart}-${timeEnd}</span>
                                    <span class="fw-bold text-primary">Kuota ${quota}</span>
                                </div>
                            </article>
                        `;
                    }
                });

                daysList.forEach(d => {
                    const col = document.getElementById(`col-day-${d}`);
                    if (col && col.innerHTML.trim() === '') {
                        col.innerHTML = `<div class="text-center py-4 opacity-50 small fw-semibold">Tidak ada jadwal</div>`;
                    }
                });
            })
            .catch(err => {
                console.error("Gagal memuat data jadwal:", err);
                document.getElementById('scheduleTableBody').innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger fw-bold">Gagal memuat data jadwal.</td></tr>`;
            });
    }

    function onModalPoliChange() {
        const poliId = $('#poli_id').val();
        const docSelect = $('#doctor_id');

        if (!poliId) {
            docSelect.html('<option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>').prop('disabled', true).trigger('change.select2');
            return;
        }

        docSelect.html('<option value="">Memuat data dokter...</option>').prop('disabled', true).trigger('change.select2');

        const url = `{{ route('master_jadwal_doctor_poliklinik_getDoctorsByPoli') }}?poli_id=${encodeURIComponent(poliId)}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                docSelect.html('<option value="">-- Pilih Dokter --</option>');

                if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                    res.data.forEach(doc => {
                        const fullName = doc.nama_lengkap || doc.master_doctor_name || 'Dokter';
                        const docId = doc.id || doc.doctor_id;
                        docSelect.append(new Option(fullName, docId, false, false));
                    });
                    docSelect.prop('disabled', false);
                } else {
                    docSelect.html('<option value="">Tidak ada dokter di poliklinik ini</option>');
                }
                docSelect.trigger('change.select2');
            })
            .catch(err => {
                console.error("Gagal memuat daftar dokter:", err);
                docSelect.html('<option value="">Gagal mengambil data dokter</option>').trigger('change.select2');
            });
    }

    function saveSchedule(e) {
        e.preventDefault();

        const form = document.getElementById('formJadwal');
        const formData = new FormData(form);
        const btnSave = document.getElementById('btnSave');

        ['time_start', 'time_end'].forEach(field => {
            const value = formData.get(field);
            if (value) {
                const timeParts = value.split(':');
                if (timeParts.length >= 2) {
                    const formattedTime = `${timeParts[0].padStart(2, '0')}:${timeParts[1].padStart(2, '0')}`;
                    formData.set(field, formattedTime);
                }
            }
        });

        btnSave.disabled = true;
        btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...';

        fetch("{{ route('master_jadwal_doctor_poliklinik_saveSchedule') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    let errorMessage = data.message || 'Terjadi kesalahan pada sistem.';
                    if (data.errors) {
                        const firstErrorKey = Object.keys(data.errors)[0];
                        errorMessage = data.errors[firstErrorKey][0];
                    }
                    throw new Error(errorMessage);
                }
                return data;
            })
            .then(res => {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Jadwal';

                if (res.status === 'success') {
                    if (modalJadwal) {
                        modalJadwal.hide();
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message || 'Jadwal dokter berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    form.reset();
                    $('#poli_id').val('').trigger('change.select2');
                    $('#day_name').val('').trigger('change.select2');
                    $('#doctor_id').html('<option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>').prop('disabled', true).trigger('change.select2');
                    loadScheduleTable();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Terjadi kesalahan saat menyimpan.'
                    });
                }
            })
            .catch(err => {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Jadwal';

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: err.message || 'Terjadi kesalahan sistem saat menghubungi server.'
                });
            });
    }

    function deleteSchedule(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data jadwal yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('master_jadwal_doctor_poliklinik_remove') }}", {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id_schedule: id
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: res.message || 'Jadwal berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadScheduleTable();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message || 'Gagal menghapus jadwal.'
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Server',
                            text: 'Terjadi kesalahan sistem saat menghapus data.'
                        });
                    });
            }
        });
    }

    function resetFilter() {
        $('#filter_poli').val('').trigger('change.select2');
        $('#filter_hari').val('').trigger('change.select2');
        loadScheduleTable();
    }
</script>
@endsection
