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
       MODERN ENTERPRISE UI STYLES (PENAGIHAN ARISAN)
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

    /* KPI Summary Cards */
    .kpi-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1);
    }

    .kpi-accent {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4.5px;
    }

    .kpi-icon-box {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
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
        font-size: 0.82rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-modal-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-modal-form .form-control,
    .ent-modal-form .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
    }

    .ent-modal-form .form-control:not(textarea),
    .ent-modal-form .form-select {
        height: 40px !important;
    }

    .ent-modal-form .form-control[readonly] {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .ent-modal-form .form-control:focus,
    .ent-modal-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
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

    /* =========================================================
       MATRIX MONTH INDICATOR PILLS (JAN - DES)
       ========================================================= */
    .month-matrix-wrap {
        display: inline-flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 4px;
    }

    .badge-month {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 28px;
        padding: 0 6px;
        border-radius: 7px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        transition: all 0.16s ease;
        user-select: none;
    }

    .month-paid {
        background-color: rgba(16, 185, 129, 0.16);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.4);
    }

    .month-unpaid {
        background-color: rgba(225, 29, 72, 0.14);
        color: #e11d48;
        border: 1px solid rgba(225, 29, 72, 0.42);
        cursor: pointer;
    }

    .month-unpaid:hover {
        background-color: #e11d48;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(225, 29, 72, 0.3);
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
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
        padding-right: 16px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 10px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 16px !important;
    }

    .ent-card-body-flush {
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Modal Enterprise Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, #ffffff) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    .ent-nominal-box {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(79, 70, 229, 0.08));
        border: 1px solid rgba(16, 185, 129, 0.35);
        border-radius: 12px;
        padding: 14px;
        text-align: center;
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

    @media print {
        .no-print {
            display: none !important;
        }
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
                            <i class="fas fa-wallet fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-chart-line me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} COLLECTION
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Arisan Penagihan</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Monitoring Pembayaran &amp; Penagihan Arisan</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Klik pada kotak indikator bulan berwarna merah untuk memproses pembayaran iuran arisan anggota.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end no-print">
                        <button type="button" class="btn ent-btn px-4 py-2" onclick="window.print()"
                            style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff;">
                            <i class="fas fa-print me-1"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER PANEL -->
<div class="ent-card ent-table-surface mb-3 no-print">
    <div class="card-header py-3 px-3 px-md-4">
        <h6 class="card-title mb-0 fw-bold">
            <i class="fas fa-filter text-primary me-2"></i>Filter Program Arisan &amp; Tahun Berjalan
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <form id="formFilterPenagihan" class="row g-2 align-items-center" onsubmit="prosesCariTagihan(event)">
            <div class="col-md-6">
                <div class="form-floating-custom">
                    <label for="penagihanMaster">1. Program Arisan Aktif <span class="text-danger">*</span></label>
                    <select id="penagihanMaster" class="form-select ent-input" required></select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating-custom">
                    <label for="penagihanTahun">2. Pilih Tahun Berjalan <span class="text-danger">*</span></label>
                    <select id="penagihanTahun" class="form-select ent-input" required>
                        <option value="">-- Pilih Tahun --</option>
                        @for ($year = 2026; $year <= 2035; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn ent-btn ent-btn-success w-100" style="height: 44px;">
                    <i class="fas fa-sync-alt me-1"></i> Hitung &amp; Monitor
                </button>
            </div>
        </form>
    </div>
</div>

<!-- PLACEHOLDER AWAL -->
<div id="placeholderPenagihanArisan" class="ent-card ent-table-surface py-5 px-3 text-center mb-3">
    <div class="card-body">
        <div class="ent-empty-icon mb-3">
            <i class="fas fa-table fa-2x"></i>
        </div>
        <h6 class="fw-bold mb-1">Data Matriks Penagihan Belum Dimuat</h6>
        <p class="mb-0 opacity-75 small">Pilih <strong>Program Arisan Aktif</strong> dan <strong>Tahun Berjalan</strong> lalu klik <strong>Hitung &amp; Monitor</strong>.</p>
    </div>
</div>

<!-- KPI SUMMARY ROW -->
<div class="row g-3 mb-3 d-none" id="rowSummaryPenagihan">
    <div class="col-md-6">
        <div class="card kpi-card ent-table-surface p-3 h-100">
            <div class="kpi-accent" style="background: var(--ent-emerald);"></div>
            <div class="d-flex justify-content-between align-items-center ps-2">
                <div>
                    <div class="text-uppercase fw-bold opacity-75" style="font-size: 0.7rem; letter-spacing: 0.05em;">Proyeksi Target Kas / Bulan</div>
                    <h3 class="fw-extrabold mb-0 mt-1 text-success" id="txtTotalKasBulanIni" style="font-family: 'JetBrains Mono', monospace;">Rp 0</h3>
                </div>
                <div class="kpi-icon-box" style="background: rgba(16, 185, 129, 0.14); color: #10b981;">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card kpi-card ent-table-surface p-3 h-100">
            <div class="kpi-accent" style="background: var(--ent-indigo);"></div>
            <div class="d-flex justify-content-between align-items-center ps-2">
                <div>
                    <div class="text-uppercase fw-bold opacity-75" style="font-size: 0.7rem; letter-spacing: 0.05em;">Total Poin Terdaftar (1 Tahun)</div>
                    <h3 class="fw-extrabold mb-0 mt-1" id="txtTotalPoinBulanIni" style="font-family: 'JetBrains Mono', monospace;">0 Poin</h3>
                </div>
                <div class="kpi-icon-box" style="background: rgba(79, 70, 229, 0.14); color: #6366f1;">
                    <i class="fas fa-award"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MATRIX TABLE CARD -->
<div class="ent-card ent-table-surface d-none" id="cardTabelPenagihan">
    <div class="card-header py-3 px-3 px-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-th text-primary"></i>
            <h6 class="card-title mb-0 fw-bold">
                Matriks Status Pembayaran Anggota - Tahun <span id="titlePeriodePenagihan" class="text-primary">-</span>
            </h6>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="ent-badge" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35);">
                <i class="fas fa-check me-1"></i> Lunas
            </span>
            <span class="ent-badge" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);">
                <i class="fas fa-hand-pointer me-1"></i> Klik Bulan Untuk Bayar
            </span>
            <span class="ent-badge" id="badgeNominalPoin" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3); font-family: 'JetBrains Mono', monospace;">
                Rate: -
            </span>
        </div>
    </div>

    <div class="card-body ent-card-body-flush">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th style="width: 5%;" class="text-center">No</th>
                        <th style="width: 20%;">Anggota</th>
                        <th style="width: 11%;">Cabang</th>
                        <th class="text-center" style="width: 8%;">Poin</th>
                        <th class="text-end" style="width: 14%;">Tagihan / Bln</th>
                        <th class="text-center" style="min-width: 470px;">Status Pembayaran Bulanan (Jan - Des)</th>
                    </tr>
                </thead>
                <tbody id="tbodyPenagihan"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL BAYAR ARISAN -->
<div class="modal fade" id="modalBayarArisan" tabindex="-1" aria-labelledby="modalBayarArisanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="ent-badge mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.62rem;">
                        <i class="fas fa-cash-register me-1"></i> SETORAN IURAN ARISAN
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0" id="modalBayarArisanLabel">Konfirmasi Bayar Kas</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formBayarArisan" onsubmit="submitPembayaranKas(event)" class="ent-modal-form">
                <div class="modal-body p-4 row g-3">
                    <input type="hidden" id="modalIdPeserta">
                    <input type="hidden" id="modalTotalPoin">
                    <input type="hidden" id="modalRawNominal">
                    <input type="hidden" id="modalBulanBayar">

                    <div class="col-md-8">
                        <label class="form-label ent-modal-label">Nama Anggota</label>
                        <input type="text" id="modalNamaPeserta" class="form-control fw-bold text-uppercase" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label ent-modal-label">Bulan Tagihan</label>
                        <input type="text" id="modalTextBulan" class="form-control fw-bold text-danger text-center" style="font-family: 'JetBrains Mono', monospace;" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label ent-modal-label">Metode Pembayaran (Akun Kas / Bank) <span class="text-danger">*</span></label>
                        <select id="modalMetodeBayar" class="form-select" required>
                            <option value="">-- Pilih Akun Kas / Bank --</option>
                            @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="ent-nominal-box">
                            <span class="ent-modal-label d-block mb-1">Nominal Wajib Setor</span>
                            <h3 class="text-success fw-bold mb-0" id="modalDisplayNominal" style="font-family: 'JetBrains Mono', monospace;">Rp 0</h3>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label ent-modal-label">Keterangan Tambahan</label>
                        <textarea id="modalKeterangan" class="form-control" rows="2" placeholder="Catatan nomor referensi bank..."></textarea>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 d-flex justify-content-end gap-2" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-success px-4">
                        <i class="fas fa-check-circle me-1"></i> Validasi Lunas
                    </button>
                </div>
            </form>
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
    const namaBulanIndo = {
        1: "Jan",
        2: "Feb",
        3: "Mar",
        4: "Apr",
        5: "Mei",
        6: "Jun",
        7: "Jul",
        8: "Agu",
        9: "Sep",
        10: "Okt",
        11: "Nov",
        12: "Des"
    };
    const namaBulanLengkap = {
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

    let nominalPerPoin = 0;
    let modalBootstrapInstance;

    async function initPenagihanPage() {
        modalBootstrapInstance = new bootstrap.Modal(document.getElementById('modalBayarArisan'));
        try {
            const res = await fetch(`{{ route('menu_koperasi_penagihan_arisan_get_data') }}`);
            const data = await res.json();
            const selectMaster = document.getElementById('penagihanMaster');
            selectMaster.innerHTML = '<option value="">-- Pilih Arisan Aktif --</option>';
            (data.master_aktif || []).forEach(m => {
                let opt = document.createElement('option');
                opt.value = m.id_kop_master_arisan;
                opt.textContent = m.kop_master_arisan_name;
                selectMaster.appendChild(opt);
            });
        } catch (err) {
            console.error(err);
        }
    }

    async function prosesCariTagihan(event) {
        if (event) event.preventDefault();
        const idMaster = document.getElementById('penagihanMaster').value;
        const tahun = document.getElementById('penagihanTahun').value;

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/penagihan-arisan/get-laporan') }}?id_master=${idMaster}&tahun=${tahun}`);
            const result = await res.json();

            document.getElementById('placeholderPenagihanArisan').classList.add('d-none');
            document.getElementById('rowSummaryPenagihan').classList.remove('d-none');
            document.getElementById('cardTabelPenagihan').classList.remove('d-none');
            document.getElementById('titlePeriodePenagihan').innerText = tahun;

            nominalPerPoin = result.nominal_per_poin;
            document.getElementById('badgeNominalPoin').innerText = `Rate: Rp ` + new Intl.NumberFormat('id-ID').format(nominalPerPoin) + ' / Poin';

            const tbody = document.getElementById('tbodyPenagihan');
            tbody.innerHTML = '';

            let grandTotalKasPerBulan = 0;
            let grandTotalPoinTahunan = 0;

            if (!result.data_tagihan || result.data_tagihan.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center opacity-75 py-4">Tidak ada data jadwal arisan untuk tahun ini.</td></tr>`;
            } else {
                result.data_tagihan.forEach((item, index) => {
                    grandTotalKasPerBulan += item.tagihan_per_bulan;
                    grandTotalPoinTahunan += parseFloat(item.total_poin_setahun);

                    let statusBulanHTML = '<div class="month-matrix-wrap">';
                    const escapedNama = (item.peserta.kop_master_peserta_name || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'");

                    for (let m = 1; m <= 12; m++) {
                        const isLunas = item.bulan_lunas.includes(m);
                        if (isLunas) {
                            statusBulanHTML += `<span class="badge-month month-paid" title="${namaBulanLengkap[m]}: Lunas"><i class="fas fa-check"></i></span>`;
                        } else {
                            statusBulanHTML += `<button type="button" class="badge-month month-unpaid" title="Klik untuk bayar bulan ${namaBulanLengkap[m]}"
                                onclick="bukaModalBayar(${item.id_kop_master_peserta}, '${escapedNama}', ${item.total_poin_setahun}, ${item.tagihan_per_bulan}, ${m})">
                                ${namaBulanIndo[m]}
                            </button>`;
                        }
                    }
                    statusBulanHTML += '</div>';

                    let row = `
                        <tr>
                            <td class="text-center fw-bold opacity-75" style="font-family: 'JetBrains Mono', monospace;">${index + 1}</td>
                            <td>
                                <div class="fw-bold text-uppercase" style="font-size: 0.82rem;">${item.peserta.kop_master_peserta_name}</div>
                                <small class="opacity-75" style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">${item.peserta.kop_master_peserta_code}</small>
                            </td>
                            <td>
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.28);">
                                    ${item.peserta.kop_master_peserta_cabang}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="ent-badge" style="background: rgba(15, 23, 42, 0.12); border: 1px solid var(--ent-grid-border); font-family: 'JetBrains Mono', monospace;">
                                    ${item.total_poin_setahun} P
                                </span>
                            </td>
                            <td class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">
                                Rp ${new Intl.NumberFormat('id-ID').format(item.tagihan_per_bulan)}
                            </td>
                            <td class="text-center">${statusBulanHTML}</td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }

            document.getElementById('txtTotalKasBulanIni').innerText = `Rp ` + new Intl.NumberFormat('id-ID').format(grandTotalKasPerBulan);
            document.getElementById('txtTotalPoinBulanIni').innerText = `${grandTotalPoinTahunan} Poin`;

        } catch (err) {
            console.error(err);
        }
    }

    function bukaModalBayar(idPeserta, namaPeserta, totalPoin, nominal, bulan) {
        document.getElementById('modalIdPeserta').value = idPeserta;
        document.getElementById('modalNamaPeserta').value = namaPeserta;
        document.getElementById('modalTotalPoin').value = totalPoin;
        document.getElementById('modalRawNominal').value = nominal;
        document.getElementById('modalBulanBayar').value = bulan;
        document.getElementById('modalTextBulan').value = namaBulanLengkap[bulan].toUpperCase();
        document.getElementById('modalKeterangan').value = '';

        document.getElementById('modalDisplayNominal').innerText = `Rp ` + new Intl.NumberFormat('id-ID').format(nominal);

        modalBootstrapInstance.show();
    }

    async function submitPembayaranKas(event) {
        event.preventDefault();

        const payload = {
            id_kop_master_arisan: parseInt(document.getElementById('penagihanMaster').value),
            id_kop_master_peserta: parseInt(document.getElementById('modalIdPeserta').value),
            kop_transaksi_bulan: parseInt(document.getElementById('modalBulanBayar').value),
            kop_transaksi_tahun: parseInt(document.getElementById('penagihanTahun').value),
            kop_transaksi_total_poin: parseInt(document.getElementById('modalTotalPoin').value),
            kop_transaksi_nominal: parseFloat(document.getElementById('modalRawNominal').value),
            kop_transaksi_metode: document.getElementById('modalMetodeBayar').value,
            kop_transaksi_keterangan: document.getElementById('modalKeterangan').value.trim()
        };

        try {
            const res = await fetch(`{{ route('menu_koperasi_penagihan_arisan_payment') }}`, {
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
                modalBootstrapInstance.hide();
                prosesCariTagihan(null);
            } else {
                Swal.fire('Gagal', result.message || 'Gagal menyimpan transaksi kas.', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Terjadi eror jaringan.', 'error');
        }
    }

    window.onload = initPenagihanPage;
</script>
@endsection
