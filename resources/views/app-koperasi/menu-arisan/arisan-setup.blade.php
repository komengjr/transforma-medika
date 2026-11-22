@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (ARISAN KOPERASI)
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
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-surface: #0f172a;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card>.card-header {
        border-bottom: 1px solid var(--ent-grid-border) !important;
    }

    .ent-table-surface {
        background-color: var(--bs-body-bg, var(--ent-surface));
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

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    /* Adaptive Floating Filters & Form Controls */
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
    }

    .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input,
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
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-form-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-std-form .form-control,
    .ent-std-form .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        height: 40px !important;
        padding: 6px 12px !important;
        transition: all 0.2s ease;
    }

    .ent-std-form .form-control:focus,
    .ent-std-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-std-form .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .ent-std-form .input-group>.form-control {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    /* Soft Badges */
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

    .badge-draft {
        background-color: rgba(245, 158, 11, 0.16) !important;
        color: #d97706 !important;
        border: 1px solid rgba(245, 158, 11, 0.38);
    }

    .badge-locked {
        background-color: rgba(225, 29, 72, 0.15) !important;
        color: #e11d48 !important;
        border: 1px solid rgba(225, 29, 72, 0.38);
    }

    .badge-neutral {
        background-color: rgba(100, 116, 139, 0.15) !important;
        color: var(--bs-secondary-color, #64748b) !important;
        border: 1px solid var(--ent-grid-border);
    }

    /* Collapsible Master Header */
    .ent-collapse-trigger {
        cursor: pointer;
        transition: background-color 0.18s ease;
    }

    .ent-collapse-trigger:hover {
        background-color: rgba(79, 70, 229, 0.06);
    }

    /* Alert Locked Banner */
    .ent-alert-locked {
        background-color: rgba(225, 29, 72, 0.1);
        border: 1px solid rgba(225, 29, 72, 0.35);
        color: #e11d48;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 700;
        font-size: 0.82rem;
    }

    /* =========================================================
       MONTHLY SCHEDULE GRID CARDS (12 BULAN)
       ========================================================= */
    .month-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 4px 14px -2px rgba(15, 23, 42, 0.06);
        overflow: hidden;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .month-card:hover {
        transform: translateY(-2px);
        border-color: rgba(79, 70, 229, 0.55);
        box-shadow: 0 10px 24px -4px rgba(79, 70, 229, 0.14);
    }

    .month-header {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        color: #ffffff;
        font-weight: 700;
        text-align: center;
        padding: 10px 12px;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .month-header.header-locked {
        background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
    }

    .month-body {
        flex-grow: 1;
        padding: 10px 12px;
        min-height: 130px;
    }

    .month-footer {
        background-color: rgba(79, 70, 229, 0.06);
        padding: 9px 12px;
        font-size: 0.78rem;
        border-top: 1px solid var(--ent-grid-border);
    }

    .member-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 6px;
        padding: 7px 0;
        border-bottom: 1px dashed var(--ent-grid-border);
        font-size: 0.8rem;
    }

    .member-row:last-child {
        border-bottom: none;
    }

    .point-pill {
        background-color: rgba(79, 70, 229, 0.14);
        color: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.32);
        border-radius: 9999px;
        padding: 2px 8px;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.68rem;
    }

    .ent-empty-icon {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        background: rgba(79, 70, 229, 0.1);
        border: 1px solid var(--ent-grid-border);
        color: var(--ent-indigo);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-award fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} ARISAN
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Setup Program &amp; Jadwal Undian</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Arisan Koperasi &amp; Plotting Jadwal Anggota</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola program master arisan 1 dekade, alokasi poin peserta, dan jadwal penerimaan bulanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- COLLAPSIBLE FORM MASTER ARISAN -->
<div class="ent-card ent-table-surface mb-3 collapsed">
    <div class="card-header py-3 px-3 px-md-4 d-flex justify-content-between align-items-center ent-collapse-trigger" data-bs-toggle="collapse" data-bs-target="#collapseMasterForm">
        <h6 class="card-title mb-0 fw-bold">
            <i class="fas fa-cog text-primary me-2"></i>Buat Program Master Arisan Baru
        </h6>
        <span class="ent-badge badge-neutral">
            <i class="fas fa-chevron-down me-1"></i> Buka / Tutup Form
        </span>
    </div>
    <div id="collapseMasterForm" class="collapse card-body p-3 p-md-4 ent-std-form">
        <form id="formMasterArisan" onsubmit="submitMasterArisan(event)" class="row g-3">
            <div class="col-md-3">
                <label class="form-label ent-form-label">Kode Arisan <span class="text-danger">*</span></label>
                <input type="text" id="masterCode" class="form-control" placeholder="ARS-2026" style="font-family: 'JetBrains Mono', monospace;" required>
            </div>
            <div class="col-md-5">
                <label class="form-label ent-form-label">Nama Program Arisan <span class="text-danger">*</span></label>
                <input type="text" id="masterName" class="form-control" placeholder="Arisan Sejahtera Dekade I" required>
            </div>
            <div class="col-md-4">
                <label class="form-label ent-form-label">Nilai Rupiah per 1 Poin <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" id="masterNominal" class="form-control" placeholder="50000" min="1" style="font-family: 'JetBrains Mono', monospace;" required>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label ent-form-label">Tahun Mulai <span class="text-danger">*</span></label>
                <input type="number" id="thnMulai" class="form-control" value="2026" style="font-family: 'JetBrains Mono', monospace;" required>
            </div>
            <div class="col-md-3">
                <label class="form-label ent-form-label">Tahun Selesai (1 Dekade) <span class="text-danger">*</span></label>
                <input type="number" id="thnSelesai" class="form-control" value="2035" style="font-family: 'JetBrains Mono', monospace;" required>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2" style="height: 40px;">
                    <i class="fas fa-check-circle me-1"></i> Simpan &amp; Aktifkan Program
                </button>
            </div>
        </form>
    </div>
</div>

<!-- FILTER PRATAMA & TAHUN JADWAL -->
<div class="ent-card ent-table-surface mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <h6 class="card-title mb-0 fw-bold">
            <i class="fas fa-filter text-primary me-2"></i>Filter Program &amp; Periode Jadwal Arisan
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="form-floating-custom">
                    <label for="selectMasterArisan">1. Filter Pratama (Master Arisan)</label>
                    <select id="selectMasterArisan" class="form-select ent-input" onchange="handleMasterChange()">
                        <option value="">-- Pilih Master Arisan --</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating-custom">
                    <label for="filterTahun">2. Pilih Tahun Jadwal</label>
                    <select id="filterTahun" class="form-select ent-input" onchange="loadJadwalBulan()" disabled>
                        <option value="">-- Pilih Master Dahulu --</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <span id="badgeStatusArisan" class="ent-badge badge-neutral px-3 py-2" style="font-size: 0.74rem;">
                    <i class="fas fa-info-circle me-1"></i> Status: Belum Memilih
                </span>
            </div>
        </div>
    </div>
</div>

<!-- PLACEHOLDER AWAL -->
<div id="placeholderArisan" class="ent-card ent-table-surface py-5 px-3 text-center mb-3">
    <div class="card-body">
        <div class="ent-empty-icon mb-3">
            <i class="fas fa-calendar-week fa-2x"></i>
        </div>
        <h6 class="fw-bold mb-1">Program &amp; Tahun Arisan Belum Dipilih</h6>
        <p class="mb-0 opacity-75 small">Silakan pilih <strong>Master Arisan</strong> dan <strong>Tahun Jadwal</strong> pada filter di atas untuk mengelola jadwal bulanan.</p>
    </div>
</div>

<!-- PANEL PLOTTING ANGGOTA BARU -->
<div class="row g-3 mb-3 d-none" id="panelInputContainer">
    <div class="col-lg-12">
        <div class="ent-card ent-table-surface" id="inputCardWrapper">
            <div class="card-header py-3 px-3 px-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-user-plus text-success me-2"></i>Plotting Anggota Baru (<span id="textInfoMode">Mode Edit Terbuka</span>)
                </h6>
                <span class="ent-badge" id="displayNominal" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35); font-family: 'JetBrains Mono', monospace;">
                    Point: -
                </span>
            </div>
            <div class="card-body p-3 p-md-4 ent-std-form">
                <form id="formPenjadwalan" class="row g-2 align-items-end" onsubmit="submitFormJadwal(event)">
                    <div class="col-md-3">
                        <label class="form-label ent-form-label">Cabang <span class="text-danger">*</span></label>
                        <select id="selectCabang" class="form-select" onchange="fetchPesertaByCabang()" required>
                            <option value="">-- Pilih Cabang --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label ent-form-label">Nama Peserta <span class="text-danger">*</span></label>
                        <select id="selectPeserta" class="form-select" disabled required>
                            <option value="">-- Pilih Cabang Dahulu --</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label ent-form-label">Bulan <span class="text-danger">*</span></label>
                        <select id="selectBulan" class="form-select" required>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label ent-form-label">Poin Diikuti <span class="text-danger">*</span></label>
                        <input type="number" id="inputPoin" class="form-control" min="1" value="5" style="font-family: 'JetBrains Mono', monospace;" required>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" id="btnSubmitJadwal" class="btn ent-btn ent-btn-success w-100" style="height: 40px;">
                            <i class="fas fa-plus-circle me-1"></i> Tambah
                        </button>
                    </div>
                </form>

                <div id="alertLocked" class="ent-alert-locked d-none text-center mb-0">
                    <i class="fas fa-lock me-2"></i> JADWAL PADA PERIODE INI SUDAH BERJALAN (AKTIF). DATA DIKUNCI &amp; TIDAK BOLEH DIUBAH LAGI.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- GRID 12 BULAN -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xxl-6 g-3 mb-3" id="gridBulan"></div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-koperasi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-koperasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const namaBulan = {
        1: "Januari",
        2: "Februari",
        3: "Maret",
        4: "April",
        5: "Mei",
        6: "Juni",
        7: "Juli",
        8: "Agustus",
        9: "September",
        10: "Oktober",
        11: "November",
        12: "Desember"
    };

    let masterDataGlobal = [];
    let currentStatusMaster = 'Draft';
    let nominalPerPoin = 0;

    // 1. Ambil data Konfigurasi Master Arisan & List Cabang saat dimuat
    async function initPage() {
        try {
            const res = await fetch(`{{ route('menu_koperasi_setup_arisan_get_data') }}`);
            const data = await res.json();

            masterDataGlobal = data.master_arisan_list || [];

            const selectMaster = document.getElementById('selectMasterArisan');
            selectMaster.innerHTML = '<option value="">-- Pilih Master Arisan --</option>';
            masterDataGlobal.forEach(m => {
                let opt = document.createElement('option');
                opt.value = m.id_kop_master_arisan;
                opt.textContent = `${m.kop_master_arisan_name} (${m.kop_master_arisan_status})`;
                selectMaster.appendChild(opt);
            });

            const selectCabang = document.getElementById('selectCabang');
            selectCabang.innerHTML = '<option value="">-- Pilih Cabang --</option>';
            (data.cabang_list || []).forEach(c => {
                let opt = document.createElement('option');
                opt.value = c.kop_master_cabang_code;
                opt.textContent = `${c.kop_master_cabang_code} - ${c.kop_master_cabang_name}`;
                selectCabang.appendChild(opt);
            });
        } catch (err) {
            console.error("Gagal inisialisasi awal:", err);
        }
    }

    // 2. Aksi ketika Filter Pratama Berubah (Pilih Tahun Dekade)
    function handleMasterChange() {
        const idMaster = document.getElementById('selectMasterArisan').value;
        const selectTahun = document.getElementById('filterTahun');
        const badge = document.getElementById('badgeStatusArisan');

        document.getElementById('panelInputContainer').classList.add('d-none');
        document.getElementById('gridBulan').innerHTML = '';
        document.getElementById('placeholderArisan').classList.remove('d-none');

        badge.className = "ent-badge badge-neutral px-3 py-2";
        badge.innerHTML = `<i class="fas fa-info-circle me-1"></i> Status: Belum Memilih`;

        if (!idMaster) {
            selectTahun.disabled = true;
            selectTahun.innerHTML = '<option value="">-- Pilih Master Dahulu --</option>';
            return;
        }

        const selectedMaster = masterDataGlobal.find(m => String(m.id_kop_master_arisan) === String(idMaster));
        const startYear = selectedMaster && selectedMaster.kop_master_arisan_thn_mulai ? parseInt(selectedMaster.kop_master_arisan_thn_mulai, 10) : 2026;
        const endYear = selectedMaster && selectedMaster.kop_master_arisan_thn_selesai ? parseInt(selectedMaster.kop_master_arisan_thn_selesai, 10) : 2035;

        selectTahun.innerHTML = '<option value="">-- Pilih Tahun --</option>';
        for (let y = startYear; y <= endYear; y++) {
            let opt = document.createElement('option');
            opt.value = y;
            opt.textContent = y;
            selectTahun.appendChild(opt);
        }
        selectTahun.disabled = false;
    }

    // 3. Mengambil data peserta berdasarkan filter cabang
    async function fetchPesertaByCabang() {
        const cabang = document.getElementById('selectCabang').value;
        const selectPeserta = document.getElementById('selectPeserta');

        selectPeserta.innerHTML = '<option value="">-- Pilih Peserta --</option>';
        if (!cabang) {
            selectPeserta.disabled = true;
            return;
        }

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/setup-arisan/peserta-by-cabang') }}/${cabang}`);
            const data = await res.json();

            data.forEach(p => {
                let opt = document.createElement('option');
                opt.value = p.id_kop_master_peserta;
                opt.textContent = `${p.kop_master_peserta_name} (${p.kop_master_peserta_code})`;
                selectPeserta.appendChild(opt);
            });
            selectPeserta.disabled = false;
        } catch (err) {
            console.error("Gagal memuat peserta:", err);
        }
    }

    // 4. Ambil data jadwal bulanan & terapkan logika LOCKING STATUS
    async function loadJadwalBulan() {
        const idMaster = document.getElementById('selectMasterArisan').value;
        const tahun = document.getElementById('filterTahun').value;

        if (!idMaster || !tahun) return;

        document.getElementById('placeholderArisan').classList.add('d-none');
        document.getElementById('panelInputContainer').classList.remove('d-none');

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/setup-arisan/jadwal') }}?id_master=${idMaster}&tahun=${tahun}`);
            const data = await res.json();

            currentStatusMaster = data.status_master;
            nominalPerPoin = parseFloat(data.nominal_point);

            const badge = document.getElementById('badgeStatusArisan');
            const wrapper = document.getElementById('inputCardWrapper');
            const infoMode = document.getElementById('textInfoMode');

            if (currentStatusMaster === 'Aktif') {
                badge.className = "ent-badge badge-locked px-3 py-2";
                badge.innerHTML = `<i class="fas fa-lock me-1"></i> JADWAL JALAN (LOCKED)`;

                infoMode.textContent = "Terkunci";
                document.getElementById('formPenjadwalan').classList.add('d-none');
                document.getElementById('alertLocked').classList.remove('d-none');
                wrapper.style.borderColor = "rgba(225, 29, 72, 0.45)";
            } else {
                badge.className = "ent-badge badge-draft px-3 py-2";
                badge.innerHTML = `<i class="fas fa-edit me-1"></i> STATUS: DRAFT (EDITABLE)`;

                infoMode.textContent = "Mode Edit Terbuka";
                document.getElementById('formPenjadwalan').classList.remove('d-none');
                document.getElementById('alertLocked').classList.add('d-none');
                wrapper.style.borderColor = "var(--ent-grid-border)";
            }

            document.getElementById('displayNominal').innerText = `Nominal per Poin: Rp ` + new Intl.NumberFormat('id-ID').format(nominalPerPoin);

            renderGridJadwal(data.jadwal || []);
        } catch (err) {
            console.error("Gagal load jadwal:", err);
        }
    }

    // 5. Render Data ke grid bulanan
    function renderGridJadwal(listJadwal) {
        const gridBulan = document.getElementById('gridBulan');
        gridBulan.innerHTML = '';

        for (let b = 1; b <= 12; b++) {
            const jadwalBulanIni = listJadwal.filter(j => j.kop_jadwal_arisan_bulan == b);
            let totalPoin = 0;
            let rowsHTML = '';

            jadwalBulanIni.forEach(j => {
                totalPoin += parseInt(j.kop_jadwal_arisan_point || 0, 10);

                const tombolHapusHTML = (currentStatusMaster === 'Aktif') ?
                    '' :
                    `<button type="button" class="btn btn-sm text-danger p-0 border-0 ms-1" onclick="hapusJadwal(${j.id_kop_jadwal_arisan})" title="Hapus Peserta"><i class="far fa-trash-alt"></i></button>`;

                const namaPeserta = j.peserta ? j.peserta.kop_master_peserta_name : '-';
                const cabangPeserta = j.peserta ? j.peserta.kop_master_peserta_cabang : '-';

                rowsHTML += `
                    <div class="member-row">
                        <div class="text-truncate" style="max-width: 68%;">
                            <div class="fw-bold text-uppercase text-truncate" style="font-size: 0.76rem;" title="${namaPeserta}">${namaPeserta}</div>
                            <small class="opacity-75 d-block" style="font-size: 0.68rem;">${cabangPeserta}</small>
                        </div>
                        <div class="d-flex align-items-center flex-shrink-0">
                            <span class="point-pill">${j.kop_jadwal_arisan_point} P</span>
                            ${tombolHapusHTML}
                        </div>
                    </div>
                `;
            });

            if (jadwalBulanIni.length === 0) {
                rowsHTML = `<div class="text-center opacity-50 my-4" style="font-size: 0.76rem;"><i class="far fa-calendar-times d-block mb-1"></i>Belum ada antrean</div>`;
            }

            const totalSetoranBulan = totalPoin * nominalPerPoin;
            const headerClass = (currentStatusMaster === 'Aktif') ? 'header-locked' : '';

            gridBulan.innerHTML += `
                <div class="col">
                    <div class="month-card">
                        <div class="month-header ${headerClass}">${namaBulan[b]}</div>
                        <div class="month-body">${rowsHTML}</div>
                        <div class="month-footer">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="opacity-75">Total Poin:</span>
                                <strong style="font-family: 'JetBrains Mono', monospace;">${totalPoin} P</strong>
                            </div>
                            <div class="d-flex justify-content-between text-success">
                                <span class="opacity-75">Total Setoran:</span>
                                <strong style="font-family: 'JetBrains Mono', monospace;">Rp ${new Intl.NumberFormat('id-ID').format(totalSetoranBulan)}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // 6. Submit Plotting Jadwal Anggota
    async function submitFormJadwal(event) {
        event.preventDefault();
        const idMaster = document.getElementById('selectMasterArisan').value;

        const payload = {
            id_kop_master_arisan: parseInt(idMaster),
            id_kop_master_peserta: parseInt(document.getElementById('selectPeserta').value),
            kop_jadwal_arisan_bulan: parseInt(document.getElementById('selectBulan').value),
            kop_jadwal_arisan_tahun: parseInt(document.getElementById('filterTahun').value),
            kop_jadwal_arisan_point: parseInt(document.getElementById('inputPoin').value)
        };

        try {
            const res = await fetch(`{{ route('menu_koperasi_setup_arisan_get_jadwal_store') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify(payload)
            });
            const result = await res.json();

            if (res.ok) {
                document.getElementById('selectPeserta').value = "";
                loadJadwalBulan();
            } else {
                Swal.fire('Perhatian', result.message || 'Gagal menyimpan.', 'warning');
            }
        } catch (err) {
            Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error');
        }
    }

    // 7. Hapus Jadwal Anggota
    async function hapusJadwal(id) {
        const confirmResult = await Swal.fire({
            title: 'Hapus Jadwal Peserta?',
            text: 'Peserta ini akan dihapus dari jadwal arisan bulan tersebut.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        });

        if (!confirmResult.isConfirmed) return;

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/setup-arisan/jadwal/delete') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                }
            });
            if (res.ok) {
                loadJadwalBulan();
            } else {
                Swal.fire('Gagal', 'Gagal menghapus jadwal peserta.', 'error');
            }
        } catch (err) {
            console.error(err);
        }
    }

    // 8. Tambah Master Arisan Baru via Panel Atas
    async function submitMasterArisan(event) {
        event.preventDefault();
        const payload = {
            kop_master_arisan_code: document.getElementById('masterCode').value.trim(),
            kop_master_arisan_name: document.getElementById('masterName').value.trim(),
            kop_master_arisan_nominal_point: parseFloat(document.getElementById('masterNominal').value),
            kop_master_arisan_thn_mulai: parseInt(document.getElementById('thnMulai').value),
            kop_master_arisan_thn_selesai: parseInt(document.getElementById('thnSelesai').value),
        };

        try {
            const res = await fetch(`{{ route('menu_koperasi_setup_arisan_save_master_arisan') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify(payload)
            });
            const result = await res.json();
            if (res.ok) {
                Swal.fire('Berhasil!', result.message, 'success');
                document.getElementById('formMasterArisan').reset();
                initPage();
            } else {
                Swal.fire('Gagal', result.message || 'Gagal menyimpan.', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Terjadi kesalahan.', 'error');
        }
    }

    window.onload = initPage;
</script>
@endsection
