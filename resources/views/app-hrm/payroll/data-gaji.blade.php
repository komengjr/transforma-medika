@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.14);
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
        --ent-grid-border: rgba(148, 163, 184, 0.16);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
    }

    /* Skala Font Standar: fs-2 (default), fs-1, fs--1, fs--2 */
    .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.25) !important;
        border-radius: 14px;
        box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.2);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        transition: all 0.25s ease;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        padding: 14px 20px;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        border-color: rgba(79, 70, 229, 0.35) !important;
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.1) !important;
    }

    .icon-shape {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.03em;
    }

    .ent-input,
    .ent-select {
        min-height: 42px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        padding: 8px 12px !important;
    }

    .ent-input:focus,
    .ent-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .ent-modal-group .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-right: 0 !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.06) !important;
        color: #6366f1 !important;
        font-weight: 700;
    }

    .ent-modal-group .form-control {
        min-height: 40px;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 0 10px 10px 0 !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
    }

    .ent-modal-group .form-control:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.22);
    }

    .ent-btn-primary:hover:not(:disabled) {
        color: #ffffff;
    }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 12px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 11px 14px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .ent-sub-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
{{-- Hero Banner Header --}}
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/gl.png') }}" alt="Logo" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-wallet"></i> SDM &amp; Payroll
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">{{ env('APP_LABEL', 'HRM System') }} Management</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Pendataan Gaji Pegawai
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Setting komponen pendapatan, potongan, BPJS, pajak PPh 21, dan verifikasi struktur gaji sebelum diproses pembayaran oleh Keuangan.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Payroll Dynamic Module</span>
                        <span class="fw-bold fs-1" style="color: #7dd3fc;">
                            <i class="fas fa-user-check me-1 fs--1"></i> Verifikasi SDM &amp; Slip
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Top Stat Cards --}}
<div class="row g-3 mb-3 fs-2">
    <div class="col-md-4">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Pegawai Terdata</div>
                    <div class="fs-1 fw-bold text-primary ent-mono" id="statTotalPegawai">0</div>
                    <small class="opacity-75 fs--2">Sudah Memiliki Data Struktur</small>
                </div>
                <div class="icon-shape" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                    <i class="fas fa-users-cog fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Estimasi Pengeluaran Gaji</div>
                    <div class="fs-1 fw-bold text-success ent-mono" id="statTotalGaji">Rp 0</div>
                    <small class="opacity-75 fs--2">Total Estimasi THP Bersih Periode</small>
                </div>
                <div class="icon-shape" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="fas fa-money-bill-wave fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Belum Di Verifikasi</div>
                    <div class="fs-1 fw-bold text-warning ent-mono" id="statPendingGaji">0</div>
                    <small class="opacity-75 fs--2">Perlu Disetting &amp; Diverifikasi SDM</small>
                </div>
                <div class="icon-shape" style="background: rgba(245, 158, 11, 0.12); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2);">
                    <i class="fas fa-user-clock fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter & Actions Card --}}
<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <form id="filterGajiForm" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i> Bulan
                </label>
                <select name="bulan" id="filterBulan" class="form-select ent-select fs-2">
                    @php
                    $namaBulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                    $bulanSkrg = (int)date('m');
                    @endphp
                    @foreach($namaBulan as $num => $nama)
                    <option value="{{ $num }}" {{ $num == $bulanSkrg ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-clock me-1 text-primary"></i> Tahun
                </label>
                <select name="tahun" id="filterTahun" class="form-select ent-select ent-mono fs-2">
                    @php $tahunSkrg = (int)date('Y'); @endphp
                    @for($t = $tahunSkrg - 2; $t <= $tahunSkrg + 2; $t++)
                        <option value="{{ $t }}" {{ $t == $tahunSkrg ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-sitemap me-1 text-primary"></i> Departemen
                </label>
                <select name="dept_code" id="filterDeptCode" class="form-select ent-select fs-2">
                    <option value="">-- Semua Departemen --</option>
                    @foreach($departemens as $d)
                    <option value="{{ $d->hrm_departemen_code }}">{{ $d->hrm_departemen_name }} ({{ $d->hrm_departemen_lokasi }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-search me-1 text-primary"></i> Cari Pegawai
                </label>
                <input type="text" name="search" id="filterSearch" class="form-control ent-input fs-2" placeholder="Nama/NIP/NIK...">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <button type="button" id="btnReset" class="btn ent-btn btn-light border px-3 py-2 fs-2" title="Reset Filter">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" id="btnExportExcel" class="btn ent-btn btn-success py-2 px-3 fs-2 text-nowrap">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Main Table --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-table text-primary me-2"></i>Master &amp; Status Verifikasi Gaji Pegawai</h6>
            <span class="opacity-75 fs--1">Rincian total pendapatan, potongan komponen gaji, BPJS, PPh 21, Take Home Pay (THP), serta status verifikasi SDM sebelum pembayaran Keuangan.</span>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="tableMasterGaji" class="table table-hover table-custom align-middle w-100 mb-0 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 48px;">#</th>
                        <th>Pegawai &amp; Departemen</th>
                        <th class="text-end">Total Pendapatan</th>
                        <th class="text-end">Total Potongan (Komp + BPJS/PPh)</th>
                        <th class="text-end">Take Home Pay (THP)</th>
                        <th class="text-center" style="width: 170px;">Status Verifikasi</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1"></tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Dynamic Setup Gaji --}}
<div class="modal fade" id="modalSetupGaji" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h6 class="modal-title fw-bold text-white fs-1 mb-0">
                    <i class="fas fa-file-invoice-dollar text-warning me-2"></i>Pengaturan Finansial &amp; Gaji Pegawai
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSetupGaji">
                @csrf
                <input type="hidden" name="hrm_m_pegawai_code" id="inputPegawaiCode">

                <div class="modal-body p-4">
                    {{-- Pegawai Info Banner --}}
                    <div class="p-3 ent-sub-box mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h5 class="fw-bold mb-1 fs-1" id="labelNamaPegawai">-</h5>
                                <div class="opacity-75 fs--1 d-flex flex-wrap gap-3">
                                    <span class="ent-mono"><i class="far fa-id-card me-1 text-primary"></i>NIP: <strong id="labelNipPegawai">-</strong></span>
                                    <span><i class="fas fa-building me-1 text-primary"></i>Departemen: <strong id="labelDeptPegawai">-</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Forms Container --}}
                    <div class="row g-4">
                        {{-- Container Pendapatan --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fw-bold text-success mb-0 fs-1"><i class="fas fa-plus-circle me-1"></i>Komponen Pendapatan</h6>
                                <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                    Terisi Otomatis per Dept
                                </span>
                            </div>
                            <div class="p-3 rounded-3" id="containerPendapatan"
                                style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.22);">
                                {{-- Loaded Dynamically via JS --}}
                            </div>
                        </div>

                        {{-- Container Potongan, BPJS & PPh 21, dan Bank --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fw-bold text-danger mb-0 fs-1"><i class="fas fa-minus-circle me-1"></i>Komponen Potongan</h6>
                                <span class="ent-badge fs--2" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);">
                                    Wajib / Opsional
                                </span>
                            </div>
                            <div class="p-3 rounded-3 mb-3" id="containerPotongan"
                                style="background: rgba(225, 29, 72, 0.05); border: 1px solid rgba(225, 29, 72, 0.22);">
                                {{-- Loaded Dynamically via JS --}}
                            </div>

                            {{-- Ringkasan Potongan BPJS & PPh 21 --}}
                            <div class="p-3 ent-sub-box mb-3" id="boxPotonganBpjsPajak">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
                                    <label class="fw-bold fs--1 mb-0">
                                        <i class="fas fa-shield-alt text-warning me-1"></i> Potongan BPJS &amp; PPh 21
                                    </label>
                                    <span class="ent-badge fs--2 ent-mono" id="badgeInfoPajak"
                                        style="background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.25);">
                                        PTKP: TK/0 • TER A (0%)
                                    </span>
                                </div>
                                <div class="row g-2 fs--2 ent-mono">
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span class="opacity-75">BPJS Kesehatan:</span>
                                            <strong id="valPotBpjsKes" class="text-danger">Rp 0</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span class="opacity-75">BPJS TK (JHT+JP):</span>
                                            <strong id="valPotBpjsTk" class="text-danger">Rp 0</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span class="opacity-75">PPh 21 (<span id="valMetodePajak">GROSS</span>):</span>
                                            <strong id="valPotPph21" class="text-danger">Rp 0</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between border-top pt-1">
                                            <span class="fw-bold">Subtotal BPJS &amp; PPh:</span>
                                            <strong id="valSubtotalBpjsPajak" class="text-danger">Rp 0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Transfer Info --}}
                            <div class="p-3 ent-sub-box mb-3">
                                <label class="fw-bold fs--1 d-block mb-2"><i class="fas fa-university text-primary me-1"></i> Rekening Transfer Bank</label>
                                <div class="row g-2">
                                    <div class="col-5">
                                        <input type="text" name="nama_bank" id="nama_bank" class="form-control ent-input fs-2" placeholder="Nama Bank (e.g. BCA)">
                                    </div>
                                    <div class="col-7">
                                        <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control ent-input ent-mono fs-2" placeholder="Nomor Rekening">
                                    </div>
                                </div>
                            </div>

                            {{-- Realtime THP Display --}}
                            <div class="p-3 rounded-3 text-center text-white"
                                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border: 1px solid rgba(99, 102, 241, 0.3);">
                                <span class="fs--2 text-uppercase fw-semibold" style="color: #94a3b8;">Estimasi Take Home Pay (THP)</span>
                                <h3 class="fw-bold text-white mb-0 mt-1 ent-mono" id="previewTakeHomePay" style="font-size: 1.5rem !important;">Rp 0</h3>
                                <small class="fs--2 d-block mt-1" style="color: #cbd5e1;" id="previewRincianThp">Pendapatan Rp 0 - Potongan Rp 0</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="border-top: 1px solid var(--ent-grid-border); background-color: rgba(79, 70, 229, 0.04);">
                    <button type="button" class="btn ent-btn btn-light border px-3 fs--1" data-bs-dismiss="modal">Batal</button>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn ent-btn ent-btn-primary px-4 fs--1">
                            <i class="fas fa-check-circle me-1"></i> Simpan &amp; Verifikasi
                        </button>
                        <button type="button" id="btnSimpanCetak" class="btn ent-btn btn-success px-4 fs--1">
                            <i class="fas fa-print me-1"></i> Verifikasi &amp; Cetak Slip
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Preview Slip Gaji --}}
<div class="modal fade" id="modalPreviewSlip" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 850px;">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h6 class="modal-title fw-bold text-white fs-1 mb-0">
                    <i class="fas fa-file-invoice-dollar text-warning me-2"></i>Preview Slip Gaji
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="iframePreviewSlip" src="" style="width: 100%; height: 520px; border: none;"></iframe>
            </div>
            <div class="modal-footer px-4 py-3 d-flex justify-content-between align-items-center"
                style="border-top: 1px solid var(--ent-grid-border); background-color: rgba(79, 70, 229, 0.04);">
                <button type="button" class="btn ent-btn btn-light border px-3 fs--1" data-bs-dismiss="modal">Tutup</button>
                <a id="btnCetakPdfModal" href="#" target="_blank" class="btn ent-btn ent-btn-primary px-4 fs--1">
                    <i class="fas fa-print me-1"></i> Cetak / Download PDF
                </a>
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
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterGajiForm');
        const modalElement = new bootstrap.Modal(document.getElementById('modalSetupGaji'));
        const modalPreviewElement = new bootstrap.Modal(document.getElementById('modalPreviewSlip'));
        const formSetupGaji = document.getElementById('formSetupGaji');
        let tableGaji = null;
        let cetakSetelahSimpan = false;
        let potonganBpjsPajakAktif = 0;

        function escapeHtml(text) {
            return String(text || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatRupiah(val) {
            return 'Rp ' + Math.round(parseFloat(val || 0)).toLocaleString('id-ID');
        }

        // Init load
        loadGajiData();

        // Filter events
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            loadGajiData();
        });
        document.getElementById('btnReset').addEventListener('click', function() {
            filterForm.reset();
            loadGajiData();
        });

        // Export Excel Event
        document.getElementById('btnExportExcel').addEventListener('click', function() {
            let dept = document.getElementById('filterDeptCode').value;
            let search = document.getElementById('filterSearch').value;
            let bulan = document.getElementById('filterBulan').value;
            let tahun = document.getElementById('filterTahun').value;
            window.location.href = `{{ route('payroll_data_gaji_export_excel') }}?dept_code=${dept}&search=${search}&bulan=${bulan}&tahun=${tahun}`;
        });

        // Trigger Simpan & Cetak
        document.getElementById('btnSimpanCetak').addEventListener('click', function() {
            cetakSetelahSimpan = true;
            formSetupGaji.requestSubmit();
        });

        // Load AJAX Main Table
        function loadGajiData() {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData).toString();

            fetch(`{{ route('payroll_data_gaji_get_data') }}?${params}`)
                .then(res => res.json())
                .then(res => {
                    if (res.status) {
                        document.getElementById('statTotalPegawai').innerText = res.stats.totalPegawai;
                        document.getElementById('statTotalGaji').innerText = res.stats.totalGajiEstimasi;
                        document.getElementById('statPendingGaji').innerText = res.stats.pendingGaji;
                        renderTable(res.data);
                    }
                });
        }

        // Render Datatable
        function renderTable(data) {
            if (tableGaji) tableGaji.destroy();

            let rows = '';
            data.forEach((item, index) => {
                const pbp = item.potongan_detail || {};
                const totalPendapatan = parseFloat(item.total_pendapatan || 0);
                const totalPotKomp = parseFloat(item.total_potongan_komponen ?? item.total_potongan ?? 0);
                const totalPotBpjsPajak = parseFloat(item.total_potongan_bpjs_pajak ?? pbp.total_potongan ?? 0);
                const totalPotGabungan = parseFloat(item.total_potongan ?? (totalPotKomp + totalPotBpjsPajak));
                const thp = totalPendapatan - totalPotGabungan;

                // Status Verifikasi SDM (pembayaran PAID dilakukan di menu Keuangan)
                const isVerified = item.is_verified !== undefined
                    ? Boolean(item.is_verified)
                    : Boolean(item.is_configured || item.is_paid);

                let statusVerifikasiBadge = isVerified
                    ? `<span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);"><i class="fas fa-check-circle"></i> SUDH DI VERIFIKASI</span>`
                    : `<span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.25);"><i class="fas fa-clock"></i> BELUM DI VERIFIKASI</span>`;

                rows += `
                        <tr>
                            <td class="text-center ent-mono fw-semibold">${index + 1}</td>
                            <td>
                                <div class="fw-bold fs-2">${escapeHtml(item.hrm_m_pegawai_name)}</div>
                                <div class="opacity-75 fs--2 ent-mono mt-1">
                                    <i class="far fa-id-card me-1 text-primary"></i>NIP: ${escapeHtml(item.hrm_m_pegawai_nip)}
                                </div>
                                <div class="mt-1 d-flex flex-wrap align-items-center gap-1">
                                    <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                        <i class="fas fa-building"></i> ${escapeHtml(item.hrm_departemen_name ?? '-')}
                                    </span>
                                    ${item.hrm_departemen_lokasi ? `<small class="opacity-75 fs--2">(${escapeHtml(item.hrm_departemen_lokasi)})</small>` : ''}
                                    <span class="ent-badge fs--2 ent-mono" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                                        PTKP: ${escapeHtml(pbp.ptkp ?? 'TK/0')}
                                    </span>
                                </div>
                            </td>
                            <td class="text-end ent-mono fw-semibold text-success">${formatRupiah(totalPendapatan)}</td>
                            <td class="text-end ent-mono text-danger">
                                <div class="fw-semibold">${formatRupiah(totalPotGabungan)}</div>
                                <small class="opacity-75 fs--2 d-block">Komp: ${formatRupiah(totalPotKomp)}</small>
                                <small class="opacity-75 fs--2 d-block">BPJS &amp; PPh: ${formatRupiah(totalPotBpjsPajak)}</small>
                            </td>
                            <td class="text-end ent-mono fw-bold text-primary">${formatRupiah(thp)}</td>
                            <td class="text-center">${statusVerifikasiBadge}</td>
                            <td class="text-center text-nowrap">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm ent-btn btn-outline-primary fs--2 btn-setup-gaji" data-id="${escapeHtml(item.hrm_m_pegawai_code)}" title="Setup &amp; Verifikasi Gaji">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm ent-btn btn-outline-info fs--2 btn-preview-slip" data-id="${escapeHtml(item.hrm_m_pegawai_code)}" title="Preview Slip">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ url('hrm/payroll/data-gaji/print-pdf') }}/${escapeHtml(item.hrm_m_pegawai_code)}?bulan=${encodeURIComponent(document.getElementById('filterBulan').value)}&tahun=${encodeURIComponent(document.getElementById('filterTahun').value)}" target="_blank" class="btn btn-sm ent-btn btn-outline-danger fs--2" title="Cetak Slip PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        `;
            });

            document.querySelector('#tableMasterGaji tbody').innerHTML = rows;
            tableGaji = new DataTable('#tableMasterGaji', {
                responsive: true,
                language: {
                    search: "Cari Cepat:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pegawai",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>'
                    }
                }
            });
            bindEvents();
        }

        // Bind Events (Setup & Preview)
        function bindEvents() {
            // Setup Gaji Modal Event
            document.querySelectorAll('.btn-setup-gaji').forEach(btn => {
                btn.addEventListener('click', function() {
                    let pegawaiCode = this.getAttribute('data-id');
                    let bulanAktif = document.getElementById('filterBulan').value;
                    let tahunAktif = document.getElementById('filterTahun').value;

                    fetch(`{{ url('hrm/payroll/data-gaji/get-detail') }}/${pegawaiCode}?bulan=${bulanAktif}&tahun=${tahunAktif}`)
                        .then(res => res.json())
                        .then(res => {
                            if (res.status) {
                                let p = res.pegawai;
                                let g = res.gaji || {};
                                let komponen = res.komponen;
                                let pbpDetail = res.potongan_bpjs_pajak || {};

                                document.getElementById('inputPegawaiCode').value = p.hrm_m_pegawai_code;
                                document.getElementById('labelNamaPegawai').innerText = p.hrm_m_pegawai_name;
                                document.getElementById('labelNipPegawai').innerText = p.hrm_m_pegawai_nip;
                                document.getElementById('labelDeptPegawai').innerText = `${p.hrm_departemen_name ?? '-'} (${p.hrm_departemen_lokasi ?? '-'})`;

                                document.getElementById('nama_bank').value = g.nama_bank ?? '';
                                document.getElementById('nomor_rekening').value = g.nomor_rekening ?? '';

                                // Isi rincian potongan BPJS & PPh 21
                                potonganBpjsPajakAktif = parseFloat(pbpDetail.total_potongan || 0);
                                document.getElementById('badgeInfoPajak').innerText =
                                    `PTKP: ${pbpDetail.ptkp || 'TK/0'} • TER ${pbpDetail.ter_kategori || 'A'} (${pbpDetail.tarif_ter_persen || 0}%)`;
                                document.getElementById('valMetodePajak').innerText = pbpDetail.metode_pajak || 'GROSS';
                                document.getElementById('valPotBpjsKes').innerText = formatRupiah(pbpDetail.bpjs_kes || 0);
                                document.getElementById('valPotBpjsTk').innerText = formatRupiah(pbpDetail.bpjs_tk || 0);
                                document.getElementById('valPotPph21').innerText = formatRupiah(pbpDetail.pph21 || 0);
                                document.getElementById('valSubtotalBpjsPajak').innerText = formatRupiah(potonganBpjsPajakAktif);

                                // Render Dynamic Input Komponen Gaji
                                let htmlPendapatan = '';
                                let htmlPotongan = '';

                                komponen.forEach(k => {
                                    let val = k.nominal_default;

                                    let field = `
                                        <div class="mb-3">
                                            <label class="form-label fs--1 mb-1 fw-bold">${escapeHtml(k.nama_komponen)}</label>
                                            <div class="input-group ent-modal-group">
                                                <span class="input-group-text fs--1 ent-mono">Rp</span>
                                                <input type="number"
                                                       name="komponen[${escapeHtml(k.kode_komponen)}]"
                                                       class="form-control ent-mono fs-2 hitung-gaji"
                                                       data-tipe="${escapeHtml(k.tipe)}"
                                                       value="${escapeHtml(val)}">
                                            </div>
                                        </div>
                                    `;

                                    if (k.tipe === 'pendapatan') {
                                        htmlPendapatan += field;
                                    } else {
                                        htmlPotongan += field;
                                    }
                                });

                                document.getElementById('containerPendapatan').innerHTML = htmlPendapatan || '<small class="opacity-75 fs--1">Tidak ada komponen pendapatan.</small>';
                                document.getElementById('containerPotongan').innerHTML = htmlPotongan || '<small class="opacity-75 fs--1">Tidak ada komponen potongan.</small>';

                                // Listen Input Event Live THP Calculation
                                document.querySelectorAll('.hitung-gaji').forEach(input => {
                                    input.addEventListener('input', hitungEstimasiGaji);
                                });

                                hitungEstimasiGaji();
                                modalElement.show();
                            }
                        });
                });
            });

            // Preview Slip Modal Event
            document.querySelectorAll('.btn-preview-slip').forEach(btn => {
                btn.addEventListener('click', function() {
                    let pegawaiCode = this.getAttribute('data-id');
                    let bulanAktif = document.getElementById('filterBulan').value;
                    let tahunAktif = document.getElementById('filterTahun').value;
                    let previewUrl = `{{ url('hrm/payroll/data-gaji/preview-html') }}/${pegawaiCode}?bulan=${bulanAktif}&tahun=${tahunAktif}`;
                    let pdfUrl = `{{ url('hrm/payroll/data-gaji/print-pdf') }}/${pegawaiCode}?bulan=${bulanAktif}&tahun=${tahunAktif}`;

                    document.getElementById('iframePreviewSlip').src = previewUrl;
                    document.getElementById('btnCetakPdfModal').href = pdfUrl;
                    modalPreviewElement.show();
                });
            });
        }

        // Live Realtime THP Calculation (termasuk BPJS & PPh 21)
        function hitungEstimasiGaji() {
            let totalPendapatan = 0;
            let totalPotonganKomponen = 0;

            document.querySelectorAll('.hitung-gaji').forEach(input => {
                let val = parseFloat(input.value) || 0;
                if (input.getAttribute('data-tipe') === 'pendapatan') {
                    totalPendapatan += val;
                } else {
                    totalPotonganKomponen += val;
                }
            });

            let totalPotonganSemua = totalPotonganKomponen + potonganBpjsPajakAktif;
            let thp = totalPendapatan - totalPotonganSemua;

            document.getElementById('previewTakeHomePay').innerText = formatRupiah(thp);
            document.getElementById('previewRincianThp').innerText =
                `Pendapatan ${formatRupiah(totalPendapatan)} - Potongan ${formatRupiah(totalPotonganSemua)}`;
        }

        // Submit Form Setup Gaji
        formSetupGaji.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(formSetupGaji);
            const bulanAktif = document.getElementById('filterBulan').value;
            const tahunAktif = document.getElementById('filterTahun').value;
            formData.append('bulan', bulanAktif);
            formData.append('tahun', tahunAktif);

            fetch(`{{ route('payroll_data_gaji_store') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status) {
                        let pegawaiCode = document.getElementById('inputPegawaiCode').value;
                        modalElement.hide();
                        loadGajiData();

                        if (cetakSetelahSimpan) {
                            window.open(`{{ url('hrm/payroll/data-gaji/print-pdf') }}/${pegawaiCode}?bulan=${bulanAktif}&tahun=${tahunAktif}`, '_blank');
                            cetakSetelahSimpan = false;
                        }
                    } else {
                        alert('Gagal menyimpan: ' + res.message);
                    }
                });
        });
    });
</script>
@endsection
