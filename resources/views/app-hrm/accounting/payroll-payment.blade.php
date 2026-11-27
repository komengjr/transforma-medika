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
                            <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.35); color: #6ee7b7;">
                                <i class="fas fa-coins"></i> Accounting &amp; Treasury
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">{{ env('APP_LABEL', 'HRM System') }} Payroll Payment</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Pembayaran Gaji Pegawai (Payroll Payment)
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Proses pencairan &amp; penandaan status <strong>PAID</strong> untuk data gaji pegawai yang sudah diverifikasi SDM per bulan dan tahun.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Periode Aktif</span>
                        <span class="fw-bold fs-1 ent-mono" style="color: #7dd3fc;" id="labelPeriodeAktif">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Top Stat Cards --}}
<div class="row g-3 mb-3 fs-2">
    <div class="col-md-3">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Pegawai Terverifikasi</div>
                    <div class="fs-1 fw-bold text-primary ent-mono" id="statTotalPegawai">0</div>
                    <small class="opacity-75 fs--2">Siap Diproses Keuangan</small>
                </div>
                <div class="icon-shape" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                    <i class="fas fa-user-check fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Belum Dibayar (UNPAID)</div>
                    <div class="fs-1 fw-bold text-warning ent-mono" id="statBelumDibayarCount">0</div>
                    <small class="opacity-75 fs--2">Menunggu Pembayaran</small>
                </div>
                <div class="icon-shape" style="background: rgba(245, 158, 11, 0.12); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2);">
                    <i class="fas fa-hourglass-half fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Siap Bayar</div>
                    <div class="fs-1 fw-bold text-danger ent-mono" id="statTotalSiapBayar">Rp 0</div>
                    <small class="opacity-75 fs--2">Akumulasi THP UNPAID</small>
                </div>
                <div class="icon-shape" style="background: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.2);">
                    <i class="fas fa-wallet fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Terbayar (PAID)</div>
                    <div class="fs-1 fw-bold text-success ent-mono" id="statTotalTerbayar">Rp 0</div>
                    <small class="opacity-75 fs--2">Sudah Dicairkan Periode Ini</small>
                </div>
                <div class="icon-shape" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="fas fa-check-double fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Card --}}
<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <form id="filterPaymentForm" class="row g-3 align-items-end">
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
                    $bulanSkrg = (int) date('m');
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
                    @php $tahunSkrg = (int) date('Y'); @endphp
                    @for($t = $tahunSkrg - 2; $t <= $tahunSkrg + 2; $t++)
                    <option value="{{ $t }}" {{ $t == $tahunSkrg ? 'selected' : '' }}>{{ $t }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-info-circle me-1 text-primary"></i> Status Bayar
                </label>
                <select name="status_bayar" id="filterStatusBayar" class="form-select ent-select fs-2">
                    <option value="">-- Semua Status --</option>
                    <option value="UNPAID">UNPAID (Belum Bayar)</option>
                    <option value="PAID">PAID (Sudah Bayar)</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-sitemap me-1 text-primary"></i> Departemen
                </label>
                <select name="dept_code" id="filterDeptCode" class="form-select ent-select fs-2">
                    <option value="">-- Semua --</option>
                    @foreach($departemens ?? [] as $d)
                    <option value="{{ $d->hrm_departemen_code }}">{{ $d->hrm_departemen_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-search me-1 text-primary"></i> Cari Pegawai
                </label>
                <input type="text" name="search" id="filterSearch" class="form-control ent-input fs-2" placeholder="Nama / NIP / NIK...">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2">
                    <i class="fas fa-filter me-1"></i> Tampilkan
                </button>
                <button type="button" id="btnResetFilter" class="btn ent-btn btn-light border px-3 py-2 fs-2" title="Reset Filter">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Main Table Card --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-money-check-alt text-primary me-2"></i>Daftar Pembayaran Gaji Pegawai</h6>
            <span class="opacity-75 fs--1">Centang pegawai berstatus <strong>UNPAID</strong> untuk memproses pembayaran massal atau klik tombol <strong>Bayar (PAID)</strong> per pegawai.</span>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" id="btnBayarTerpilih" class="btn ent-btn btn-success px-3 py-2 fs--1" disabled>
                <i class="fas fa-check-circle me-1"></i> Bayar Terpilih (<span id="countTerpilih" class="ent-mono">0</span>)
            </button>
            <button type="button" id="btnExportPayment" class="btn ent-btn btn-outline-success px-3 py-2 fs--1">
                <i class="fas fa-file-excel me-1"></i> Export CSV
            </button>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="tablePayrollPayment" class="table table-hover table-custom align-middle w-100 mb-0 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 40px;">
                            <input type="checkbox" id="checkAllUnpaid" class="form-check-input" title="Pilih semua UNPAID">
                        </th>
                        <th class="text-center" style="width: 48px;">#</th>
                        <th>Pegawai &amp; Departemen</th>
                        <th>Rekening Tujuan</th>
                        <th class="text-end">Pendapatan</th>
                        <th class="text-end">Potongan</th>
                        <th class="text-end">Take Home Pay (THP)</th>
                        <th class="text-center" style="width: 150px;">Status Bayar</th>
                        <th class="text-center" style="width: 135px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1"></tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Proses Pembayaran (Single) --}}
<div class="modal fade" id="modalProsesBayar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h6 class="modal-title fw-bold text-white fs-1 mb-0">
                    <i class="fas fa-money-check-alt text-warning me-2"></i>Konfirmasi Pembayaran Gaji (PAID)
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formProsesBayar">
                @csrf
                <input type="hidden" name="hrm_m_pegawai_code" id="payPegawaiCode">
                <input type="hidden" name="bulan" id="payBulan">
                <input type="hidden" name="tahun" id="payTahun">

                <div class="modal-body p-4">
                    <div class="p-3 ent-sub-box mb-3">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h5 class="fw-bold mb-1 fs-1" id="payNamaPegawai">-</h5>
                                <div class="opacity-75 fs--1 ent-mono">
                                    NIP: <strong id="payNipPegawai">-</strong> • Dept: <strong id="payDeptPegawai">-</strong>
                                </div>
                                <div class="opacity-75 fs--1 ent-mono mt-1">
                                    Rekening: <strong id="payRekeningInfo">-</strong>
                                </div>
                            </div>
                            <span class="ent-badge fs--2 ent-mono" id="payPeriodeBadge"
                                style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);">
                                Periode -
                            </span>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: rgba(16, 185, 129, 0.06); border: 1px solid rgba(16, 185, 129, 0.2);">
                                <div class="fs--2 opacity-75">Total Pendapatan</div>
                                <div class="fw-bold text-success ent-mono fs-2" id="payTotalPendapatan">Rp 0</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: rgba(225, 29, 72, 0.06); border: 1px solid rgba(225, 29, 72, 0.2);">
                                <div class="fs--2 opacity-75">Total Potongan</div>
                                <div class="fw-bold text-danger ent-mono fs-2" id="payTotalPotongan">Rp 0</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: rgba(79, 70, 229, 0.08); border: 1px solid rgba(79, 70, 229, 0.25);">
                                <div class="fs--2 opacity-75">Nominal THP Dibayarkan</div>
                                <div class="fw-bold text-primary ent-mono fs-1" id="payTotalThp">Rp 0</div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs--1 mb-1">Tanggal Pembayaran <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_bayar" id="payTanggalBayar" class="form-control ent-input ent-mono fs-2" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs--1 mb-1">Metode / Akun Pembayaran <span class="text-danger">*</span></label>
                            <select name="metode_bayar" id="payMetodeBayar" class="form-select ent-select fs-2" required>
                                <option value="TRANSFER_BANK">Transfer Bank</option>
                                <option value="KAS_TUNAI">Kas Tunai</option>
                                <option value="VIRTUAL_ACCOUNT">Virtual Account / Auto-Debet</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold fs--1 mb-1">Catatan Keuangan (Opsional)</label>
                            <input type="text" name="catatan" id="payCatatan" class="form-control ent-input fs-2" placeholder="Contoh: Transfer batch payroll via BNI / referensi bukti bayar...">
                        </div>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 d-flex justify-content-between align-items-center"
                    style="border-top: 1px solid var(--ent-grid-border); background-color: rgba(79, 70, 229, 0.04);">
                    <button type="button" class="btn ent-btn btn-light border px-3 fs--1" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn btn-success px-4 fs--1">
                        <i class="fas fa-check-circle me-1"></i> Tandai PAID Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Proses Pembayaran Massal (Bulk) --}}
<div class="modal fade" id="modalProsesBayarBulk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h6 class="modal-title fw-bold text-white fs-1 mb-0">
                    <i class="fas fa-layer-group text-warning me-2"></i>Pembayaran Massal (PAID)
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formProsesBayarBulk">
                @csrf
                <div class="modal-body p-4">
                    <div class="p-3 ent-sub-box mb-3">
                        <div class="fs--1">Jumlah pegawai terpilih: <strong id="bulkCountLabel" class="ent-mono text-primary">0</strong> orang</div>
                        <div class="fs--1 mt-1">Periode: <strong id="bulkPeriodeLabel" class="ent-mono">-</strong></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs--1 mb-1">Tanggal Pembayaran <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_bayar" id="bulkTanggalBayar" class="form-control ent-input ent-mono fs-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold fs--1 mb-1">Metode / Akun Pembayaran <span class="text-danger">*</span></label>
                        <select name="metode_bayar" id="bulkMetodeBayar" class="form-select ent-select fs-2" required>
                            <option value="TRANSFER_BANK">Transfer Bank</option>
                            <option value="KAS_TUNAI">Kas Tunai</option>
                            <option value="VIRTUAL_ACCOUNT">Virtual Account / Auto-Debet</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-bold fs--1 mb-1">Catatan Massal (Opsional)</label>
                        <input type="text" name="catatan" id="bulkCatatan" class="form-control ent-input fs-2" placeholder="Contoh: Pencairan gaji massal periode terpilih">
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 d-flex justify-content-between align-items-center"
                    style="border-top: 1px solid var(--ent-grid-border); background-color: rgba(79, 70, 229, 0.04);">
                    <button type="button" class="btn ent-btn btn-light border px-3 fs--1" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn btn-success px-4 fs--1">
                        <i class="fas fa-check-double me-1"></i> Proses Semua PAID
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterPaymentForm');
        const modalBayar = new bootstrap.Modal(document.getElementById('modalProsesBayar'));
        const modalBayarBulk = new bootstrap.Modal(document.getElementById('modalProsesBayarBulk'));
        const formProsesBayar = document.getElementById('formProsesBayar');
        const formProsesBayarBulk = document.getElementById('formProsesBayarBulk');

        let tablePayment = null;
        let currentRowsMap = {};

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

        function updatePeriodeLabel() {
            const bulanSel = document.getElementById('filterBulan');
            const tahunSel = document.getElementById('filterTahun');
            const namaBulan = bulanSel.options[bulanSel.selectedIndex]?.text || '';
            document.getElementById('labelPeriodeAktif').innerText = `${namaBulan} ${tahunSel.value}`;
        }

        function setDefaultTanggalBayar() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('payTanggalBayar').value = today;
            document.getElementById('bulkTanggalBayar').value = today;
        }

        setDefaultTanggalBayar();
        loadPaymentData();

        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            loadPaymentData();
        });

        document.getElementById('btnResetFilter').addEventListener('click', function() {
            filterForm.reset();
            setDefaultTanggalBayar();
            loadPaymentData();
        });

        document.getElementById('btnExportPayment').addEventListener('click', function() {
            const params = new URLSearchParams(new FormData(filterForm)).toString();
            window.location.href = `{{ route('accounting_hrm_payroll_payment_export_excel') }}?${params}`;
        });

        function loadPaymentData() {
            updatePeriodeLabel();
            const params = new URLSearchParams(new FormData(filterForm)).toString();

            fetch(`{{ route('accounting_hrm_payroll_payment_data') }}?${params}`)
                .then(res => res.json())
                .then(res => {
                    if (res.status) {
                        document.getElementById('statTotalPegawai').innerText = res.stats.totalPegawai;
                        document.getElementById('statBelumDibayarCount').innerText = res.stats.belumDibayarCount;
                        document.getElementById('statTotalSiapBayar').innerText = res.stats.totalSiapBayar;
                        document.getElementById('statTotalTerbayar').innerText = res.stats.totalTerbayar;
                        renderTable(res.data || []);
                    }
                });
        }

        function renderTable(data) {
            if (tablePayment) {
                tablePayment.destroy();
            }

            currentRowsMap = {};
            let rowsHtml = '';

            data.forEach((item, idx) => {
                currentRowsMap[item.hrm_m_pegawai_code] = item;

                const isPaid = Boolean(item.is_paid);
                const checkboxHtml = isPaid
                    ? `<input type="checkbox" class="form-check-input" disabled title="Sudah PAID">`
                    : `<input type="checkbox" class="form-check-input row-check-unpaid" value="${escapeHtml(item.hrm_m_pegawai_code)}">`;

                const statusBadge = isPaid
                    ? `<span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);"><i class="fas fa-check-circle"></i> PAID</span>
                       ${item.tanggal_bayar ? `<div class="fs--2 opacity-75 ent-mono mt-1">Tgl: ${escapeHtml(item.tanggal_bayar)}</div>` : ''}`
                    : `<span class="ent-badge fs--2" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);"><i class="fas fa-times-circle"></i> UNPAID</span>`;

                const actionBtn = isPaid
                    ? `<button type="button" class="btn btn-sm ent-btn btn-outline-secondary fs--2 btn-detail-bayar" data-id="${escapeHtml(item.hrm_m_pegawai_code)}" title="Lihat Rincian Pembayaran">
                           <i class="fas fa-receipt me-1"></i> Rincian
                       </button>`
                    : `<button type="button" class="btn btn-sm ent-btn btn-success fs--2 btn-proses-bayar" data-id="${escapeHtml(item.hrm_m_pegawai_code)}" title="Proses Pembayaran PAID">
                           <i class="fas fa-money-bill-wave me-1"></i> Bayar
                       </button>`;

                const rekText = (item.nama_bank || item.nomor_rekening)
                    ? `<div class="fw-semibold fs--1">${escapeHtml(item.nama_bank || '-')}</div>
                       <div class="ent-mono fs--2 opacity-75">${escapeHtml(item.nomor_rekening || '-')}</div>`
                    : `<span class="fs--2 opacity-50">Belum diatur</span>`;

                rowsHtml += `
                    <tr>
                        <td class="text-center">${checkboxHtml}</td>
                        <td class="text-center ent-mono fw-semibold">${idx + 1}</td>
                        <td>
                            <div class="fw-bold fs-2">${escapeHtml(item.hrm_m_pegawai_name)}</div>
                            <div class="opacity-75 fs--2 ent-mono">NIP: ${escapeHtml(item.hrm_m_pegawai_nip || '-')}</div>
                            <div class="mt-1">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    ${escapeHtml(item.hrm_departemen_name || '-')}
                                </span>
                            </div>
                        </td>
                        <td>${rekText}</td>
                        <td class="text-end ent-mono text-success fw-semibold">${formatRupiah(item.total_pendapatan)}</td>
                        <td class="text-end ent-mono text-danger">${formatRupiah(item.total_potongan)}</td>
                        <td class="text-end ent-mono text-primary fw-bold">${formatRupiah(item.thp)}</td>
                        <td class="text-center">${statusBadge}</td>
                        <td class="text-center text-nowrap">${actionBtn}</td>
                    </tr>
                `;
            });

            document.querySelector('#tablePayrollPayment tbody').innerHTML = rowsHtml;

            tablePayment = new DataTable('#tablePayrollPayment', {
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

            bindTableEvents();
            syncBulkButtonState();
        }

        function getSelectedUnpaidCodes() {
            return Array.from(document.querySelectorAll('.row-check-unpaid:checked')).map(el => el.value);
        }

        function syncBulkButtonState() {
            const selected = getSelectedUnpaidCodes();
            const btnBulk = document.getElementById('btnBayarTerpilih');
            document.getElementById('countTerpilih').innerText = selected.length;
            btnBulk.disabled = selected.length === 0;
        }

        function bindTableEvents() {
            const checkAll = document.getElementById('checkAllUnpaid');
            if (checkAll) {
                checkAll.checked = false;
                checkAll.addEventListener('change', function() {
                    document.querySelectorAll('.row-check-unpaid').forEach(cb => {
                        cb.checked = checkAll.checked;
                    });
                    syncBulkButtonState();
                });
            }

            document.querySelectorAll('.row-check-unpaid').forEach(cb => {
                cb.addEventListener('change', syncBulkButtonState);
            });

            document.querySelectorAll('.btn-proses-bayar, .btn-detail-bayar').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pegawaiCode = this.getAttribute('data-id');
                    const item = currentRowsMap[pegawaiCode] || {};
                    const bulan = document.getElementById('filterBulan').value;
                    const tahun = document.getElementById('filterTahun').value;

                    document.getElementById('payPegawaiCode').value = pegawaiCode;
                    document.getElementById('payBulan').value = bulan;
                    document.getElementById('payTahun').value = tahun;
                    document.getElementById('payNamaPegawai').innerText = item.hrm_m_pegawai_name || '-';
                    document.getElementById('payNipPegawai').innerText = item.hrm_m_pegawai_nip || '-';
                    document.getElementById('payDeptPegawai').innerText = item.hrm_departemen_name || '-';
                    document.getElementById('payRekeningInfo').innerText = `${item.nama_bank || '-'} • ${item.nomor_rekening || '-'}`;
                    document.getElementById('payPeriodeBadge').innerText = `Periode ${String(bulan).padStart(2, '0')}/${tahun}`;
                    document.getElementById('payTotalPendapatan').innerText = formatRupiah(item.total_pendapatan);
                    document.getElementById('payTotalPotongan').innerText = formatRupiah(item.total_potongan);
                    document.getElementById('payTotalThp').innerText = formatRupiah(item.thp);
                    document.getElementById('payCatatan').value = item.catatan_bayar || '';

                    if (item.tanggal_bayar) {
                        document.getElementById('payTanggalBayar').value = item.tanggal_bayar;
                    }
                    if (item.metode_bayar) {
                        document.getElementById('payMetodeBayar').value = item.metode_bayar;
                    }

                    const isReadOnly = Boolean(item.is_paid);
                    formProsesBayar.querySelector('button[type="submit"]').style.display = isReadOnly ? 'none' : 'inline-block';
                    modalBayar.show();
                });
            });
        }

        // Submit Bayar Single
        formProsesBayar.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(`{{ route('accounting_hrm_payroll_payment_pay') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: new FormData(formProsesBayar)
            })
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    modalBayar.hide();
                    loadPaymentData();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1800, showConfirmButton: false });
                    } else {
                        alert(res.message);
                    }
                } else {
                    alert(res.message || 'Gagal memproses pembayaran.');
                }
            });
        });

        // Buka Modal Bayar Massal
        document.getElementById('btnBayarTerpilih').addEventListener('click', function() {
            const selected = getSelectedUnpaidCodes();
            if (selected.length === 0) return;

            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;
            document.getElementById('bulkCountLabel').innerText = selected.length;
            document.getElementById('bulkPeriodeLabel').innerText = `${String(bulan).padStart(2, '0')}/${tahun}`;
            modalBayarBulk.show();
        });

        // Submit Bayar Massal
        formProsesBayarBulk.addEventListener('submit', function(e) {
            e.preventDefault();
            const selected = getSelectedUnpaidCodes();
            const formData = new FormData(formProsesBayarBulk);
            formData.append('bulan', document.getElementById('filterBulan').value);
            formData.append('tahun', document.getElementById('filterTahun').value);
            selected.forEach(code => formData.append('pegawai_codes[]', code));

            fetch(`{{ route('accounting_hrm_payroll_payment_pay_bulk') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    modalBayarBulk.hide();
                    loadPaymentData();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1800, showConfirmButton: false });
                    } else {
                        alert(res.message);
                    }
                } else {
                    alert(res.message || 'Gagal memproses pembayaran massal.');
                }
            });
        });
    });
</script>
@endsection
