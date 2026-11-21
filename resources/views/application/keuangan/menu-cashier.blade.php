@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
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
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 12px 16px;
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
        background: radial-gradient(circle, rgba(16, 185, 129, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.8rem;
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

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    /* Filter Bar & Solid Inputs */
    .filter-bar-container {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06);
    }

    .ent-field-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 4px;
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
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-solid-bg) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Tabel Custom */
    .table-custom-orange {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.8rem;
    }

    .table-custom-orange thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 11px 10px;
        letter-spacing: 0.04em;
    }

    .table-custom-orange td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 9px 10px;
        vertical-align: middle;
        background-color: transparent;
    }

    .table-hover tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-hover tbody tr:hover,
    .table-hover tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .row-selected,
    .row-selected td {
        background-color: rgba(79, 70, 229, 0.14) !important;
    }

    .card-panel {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 12px;
        box-shadow: 0 4px 14px -4px rgba(15, 23, 42, 0.06);
    }

    /* Kotak Total Tagihan Modern Enterprise */
    .total-tagihan-box {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 65%, #312e81 100%);
        color: #ffffff;
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 16px;
        padding: 18px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.25);
    }

    .total-tagihan-number {
        font-size: 1.95rem;
        font-weight: 800;
        font-family: 'JetBrains Mono', monospace;
        color: #34d399;
        letter-spacing: 0.5px;
    }

    /* Kartu Metode Pembayaran */
    .payment-method-card {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 12px;
        box-shadow: 0 4px 14px -4px rgba(15, 23, 42, 0.05);
        transition: all 0.18s ease;
    }

    .payment-method-card:focus-within {
        border-color: var(--ent-indigo);
        box-shadow: 0 6px 18px -4px rgba(79, 70, 229, 0.15);
    }

    .payment-method-card.disabled-method {
        background-color: rgba(100, 116, 139, 0.08);
        opacity: 0.62;
        pointer-events: none;
        box-shadow: none;
    }

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

    .ent-modal-popup {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color) !important;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER UTAMA -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/keuangan.png') }}" alt="Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.45); color: #7dd3fc;">
                                    <i class="fas fa-shield-alt me-1"></i> v2.4 Medical Suite
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Keuangan &amp; Billing Kasir</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal" style="color: #cbd5e1;">Management System</span>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                            <h6 class="fw-bold mb-0 text-white" style="font-size: 0.9rem;">
                                <i class="fas fa-money-check me-2 text-success"></i> Cashier Accounting
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BARIS FILTER UTAMA DI ATAS -->
<div class="filter-bar-container">
    <form id="form-filter-kasir" onsubmit="event.preventDefault(); loadAntreanKasir();" class="row g-2 align-items-end">
        <!-- Tanggal Awal -->
        <div class="col-sm-6 col-md-2">
            <label class="form-label ent-field-label">Tanggal Awal</label>
            <input type="date" class="form-control form-control-sm retro-input" id="filter_tgl_awal" value="{{ date('Y-m-d') }}">
        </div>
        <!-- Tanggal Akhir -->
        <div class="col-sm-6 col-md-2">
            <label class="form-label ent-field-label">Tanggal Akhir</label>
            <input type="date" class="form-control form-control-sm retro-input" id="filter_tgl_akhir" value="{{ date('Y-m-d') }}">
        </div>
        <!-- Kel. Pelanggan -->
        <div class="col-sm-6 col-md-2">
            <label class="form-label ent-field-label">Kel. Pelanggan</label>
            <select class="form-select form-select-sm retro-input" id="filter_penjamin">
                <option value="">Semua</option>
                @foreach ($subPenjamins ?? [] as $sp)
                <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                @endforeach
            </select>
        </div>
        <!-- Cari Keyword -->
        <div class="col-sm-6 col-md-2">
            <label class="form-label ent-field-label">Cari...</label>
            <input type="text" class="form-control form-control-sm retro-input" id="filter_keyword" placeholder="Nama / No Reg">
        </div>
        <!-- Status -->
        <div class="col-sm-6 col-md-2">
            <label class="form-label ent-field-label">Status</label>
            <select class="form-select form-select-sm retro-input" id="filter_status">
                <option value="Belum Lunas" selected>Belum Lunas</option>
                <option value="Lunas">Lunas</option>
                <option value="">Semua Status</option>
            </select>
        </div>
        <!-- Tombol Cari & Tombol Buat Laporan -->
        <div class="col-sm-6 col-md-2 d-flex gap-1">
            <button type="submit" class="btn ent-btn ent-btn-warning flex-grow-1 fw-semibold" style="height: 35px;" title="Cari Data">
                <i class="fas fa-search"></i>
            </button>
            <button type="button" class="btn ent-btn ent-btn-success flex-grow-1 fw-semibold" style="height: 35px;" onclick="bukaModalBuatLaporanKeuangan()" title="Buat Laporan Keuangan">
                <i class="fas fa-file-invoice-dollar me-1"></i> Laporan
            </button>
        </div>
    </form>
</div>

<!-- LAYOUT UTAMA DUA KOLOM (KIRI: TABEL ANTREAN, KANAN: PANEL PEMBAYARAN) -->
<div class="row g-3">

    <!-- KOLOM KIRI: TABEL DAFTAR PASIEN / ANTREAN -->
    <div class="col-lg-6">
        <div class="ent-card h-100">
            <div class="ent-card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-users text-primary"></i> Daftar Kunjungan Pasien
                </h6>
            </div>
            <div class="table-responsive" style="max-height: 750px; overflow-y: auto;">
                <table class="table table-hover table-custom-orange align-middle mb-0 fs--1">
                    <thead>
                        <tr>
                            <th style="width: 25%;">TGL. TRANSAKSI</th>
                            <th style="width: 25%;">NO REG</th>
                            <th style="width: 25%;">NAMA PASIEN</th>
                            <th style="width: 25%;">KEL.PELANGGAN</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-antrean-body">
                        <tr>
                            <td colspan="4" class="text-center py-4 opacity-75">Memuat data antrean...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: DETAIL TAGIHAN & PEMBAYARAN DISESUAIKAN PENJAMIN -->
    <div class="col-lg-6">

        <!-- Tabel Rincian Tagihan Layanan & Tanggungan (Dinamis via AJAX) -->
        <div class="ent-card mb-3">
            <div class="ent-card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-primary"></i> Rincian Tagihan &amp; Tanggungan
                </h6>
                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.32);" id="lbl-nama-pasien-tagihan">-</span>
            </div>
            <div class="card-body p-0" style="max-height: 280px; overflow-y: auto;">
                <table class="table table-sm table-bordered fs--2 align-middle mb-0 table-custom-orange">
                    <thead style="position: sticky; top: 0; z-index: 1;">
                        <tr style="font-size: 7px;">
                            <th class="text-center" style="width: 25px;">Pilih</th>
                            <th>Item / Layanan</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end text-danger">Tgg. Pasien</th>
                            <th class="text-end text-success">Tgg. Prsh</th>
                            <th class="text-center" style="width: 80px;">Aksi Split</th>
                        </tr>
                    </thead>
                    <tbody id="rincian-layanan-body" class="fw-semibold">
                        <tr>
                            <td colspan="6" class="text-center py-3 opacity-75">Pilih pasien di tabel kiri untuk melihat rincian tagihan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-between py-2 px-3" style="background-color: rgba(79, 70, 229, 0.04); border-top: 1px solid var(--ent-grid-border);">
                <span class="fs--1 fw-semibold opacity-75">Porsi Pasien: <span class="text-danger fw-bold" id="lbl-total-tanggungan-pasien">Rp 0</span></span>
                <span class="fs--1 fw-semibold opacity-75">Porsi Perusahaan: <span class="text-success fw-bold" id="lbl-total-tanggungan-perusahaan">Rp 0</span></span>
            </div>
        </div>

        <!-- Box Total Tagihan Pasien -->
        <div class="total-tagihan-box mb-3">
            <div>
                <h6 class="text-white fw-bold mb-0">Total Wajib Bayar Pasien</h6>
                <small style="color: #cbd5e1;" class="fs--2">Pola: <span id="lblPolaTanggungan" class="fw-bold text-warning">-</span></small>
            </div>
            <div class="total-tagihan-number" id="lblTotalTagihanPasien">0</div>
        </div>

        <!-- Bar Kontrol Cetak & Kartu Kontrol -->
        <div class="card-panel d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 py-2">
            <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 320px;">
                <select class="form-select form-select-sm retro-input" id="tipePrint">
                    <option value="">Tipe Print</option>
                    <option value="thermal">Thermal Struk</option>
                    <option value="A4">Invoice Gabungan</option>
                </select>
                <button type="button" class="btn btn-sm ent-btn ent-btn-warning px-3" onclick="cetakNotaAktif()" title="Cetak Nota">
                    <i class="fas fa-print"></i>
                </button>
            </div>
            <button type="button" class="btn btn-sm ent-btn ent-btn-warning fw-semibold px-3" onclick="bukaKartuKontrol()">
                KARTU KONTROL
            </button>
        </div>

        <!-- Form Metode Pembayaran (Mendukung Full Pasien, Full Perusahaan, atau Split Bill) -->
        <div class="ent-card p-3 mb-3" id="panelMetodePembayaran">

            <!-- Informasi Jika Full Perusahaan -->
            <div id="alertFullPerusahaan" class="alert alert-success fw-semibold d-none text-center rounded-3">
                <i class="fas fa-building me-1"></i> Tagihan ini sepenuhnya ditanggung oleh Perusahaan/Asuransi (Masuk Piutang Perusahaan). Tidak ada pembayaran kasir dari pasien.
            </div>

            <!-- Cash / Tunai -->
            <div class="payment-method-card" id="cardCash">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleCash" onchange="toggleMetode('cash')" disabled>
                        <label class="form-check-label fw-bold" for="toggleCash"><i class="fas fa-money-bill-wave text-success me-1"></i> Cash / Tunai (Porsi Pasien)</label>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="number" class="form-control form-control-sm retro-input fw-bold fs-1 text-primary" id="inputCashJumlah" placeholder="Jumlah" value="0" disabled>
                            <label class="fw-semibold">Nominal Bayar</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm retro-input fw-bold fs-1 text-danger" id="inputCashKembali" placeholder="Kembali" value="0" readonly>
                            <label class="fw-semibold">Kembalian</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Debit / QRIS -->
            <div class="payment-method-card" id="cardDebit">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleDebit" onchange="toggleMetode('debit')" disabled>
                        <label class="form-check-label fw-bold" for="toggleDebit"><i class="fas fa-credit-card text-primary me-1"></i> Debit / QRIS / Transfer (Porsi Pasien)</label>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-4">
                        <input type="number" class="form-control form-control-sm retro-input fw-bold" id="inputDebitJumlah" placeholder="Nominal" value="0" disabled>
                    </div>
                    <div class="col-8">
                        <select class="form-select form-select-sm retro-input fw-bold" id="selectDebitEDC" disabled>
                            <option value="">Pilih Mesin EDC / Rekening Tujuan</option>
                            @foreach($edcList ?? [] as $edc)
                            <option value="{{ $edc->id }}">{{ $edc->nama_bank }} — Rek: {{ $edc->no_rekening }} ({{ $edc->nama_pemilik }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mt-2">
                        <input type="text" class="form-control form-control-sm retro-input" id="inputDebitRef" placeholder="No Referensi / EDC / Approval Code" disabled>
                    </div>
                </div>
            </div>

            <!-- TOMBOL PROSES PAYMENT OLEH KASIR -->
            <button type="button" class="btn ent-btn ent-btn-success w-100 py-3 shadow-sm d-flex align-items-center justify-content-center gap-2 mt-3" id="btnProsesPayment" onclick="prosesPaymentKasir()" disabled>
                <i class="fas fa-check-circle fs-2"></i> PROSES PEMBAYARAN &amp; PIUTANG
            </button>

        </div>

    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let selectedOrderCode = null;
    let currentDataList = [];
    let currentDetailItems = [];

    $(document).ready(function() {
        loadAntreanKasir();

        $('#inputCashJumlah').on('keyup change', function() {
            hitungKembalian();
        });
    });

    function hitungKembalian() {
        let totalTagihanText = $('#lblTotalTagihanPasien').text().replace(/\./g, '').replace(',', '.');
        let totalPasien = parseFloat(totalTagihanText) || 0;
        let bayar = parseFloat($('#inputCashJumlah').val()) || 0;

        let kembalian = bayar - totalPasien;
        if (kembalian < 0) kembalian = 0;

        $('#inputCashKembali').val(kembalian.toLocaleString('id-ID'));
    }

    function loadAntreanKasir() {
        const tglAwal = $('#filter_tgl_awal').val();
        const tglAkhir = $('#filter_tgl_akhir').val();
        const penjamin = $('#filter_penjamin').val();
        const keyword = $('#filter_keyword').val();
        const status = $('#filter_status').val();

        $('#tabel-antrean-body').html(`<tr><td colspan="4" class="text-center py-3 opacity-75"><div class="spinner-border spinner-border-sm me-2"></div>Memuat data...</td></tr>`);

        $.ajax({
            url: "{{ route('keuangan_menu_cashier_list_all_patient') }}",
            type: "GET",
            data: {
                start_date: tglAwal,
                end_date: tglAkhir,
                penjamin: penjamin,
                keyword: keyword,
                status: status
            },
            success: function(res) {
                if (res.success && res.data.length > 0) {
                    currentDataList = res.data;
                    let html = '';
                    res.data.forEach((item) => {
                        let tglFormat = item.tanggal_registrasi ? item.tanggal_registrasi : '-';
                        let regId = item.id || item.registrasi_id || item.d_reg_order_code;
                        html += `
                            <tr onclick="pilihPasienKasir('${regId}')" style="cursor: pointer;" id="row-${regId}">
                                <td class="text-nowrap">${tglFormat}</td>
                                <td>
                                    <span class="text-danger fw-bold d-block" style="font-family: 'JetBrains Mono', monospace;">${item.d_reg_order_code || item.no_registrasi}</span>
                                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.75rem; font-family: 'JetBrains Mono', monospace;">RM: ${item.rm_code || item.pid}</span>
                                </td>
                                <td class="fw-bold text-uppercase">${item.patient_name || item.nama_pasien}</td>
                                <td>
                                    <span class="fw-semibold d-block">${item.t_layanan_cat_code || item.jenis_layanan}</span>
                                </td>
                            </tr>
                        `;
                    });
                    $('#tabel-antrean-body').html(html);
                } else {
                    $('#tabel-antrean-body').html(`<tr><td colspan="4" class="text-center py-4 opacity-75">Tidak ada data kunjungan.</td></tr>`);
                }
            },
            error: function() {
                $('#tabel-antrean-body').html(`<tr><td colspan="4" class="text-center py-4 text-danger">Gagal memuat data antrean.</td></tr>`);
            }
        });
    }

    function pilihPasienKasir(regId) {
        selectedOrderCode = regId;
        $('tr').removeClass('row-selected');
        $(`#row-${regId}`).addClass('row-selected');

        $('#lbl-nama-pasien-tagihan').text('Memuat...');
        $('#rincian-layanan-body').html(`<tr><td colspan="6" class="text-center py-3 opacity-75">Memuat rincian tanggungan...</td></tr>`);

        $.ajax({
            url: "/kasir/detail-tagihan/" + regId,
            type: "GET",
            success: function(res) {
                if (res.success) {
                    $('#lbl-nama-pasien-tagihan').text(res.pasien.nama);
                    currentDetailItems = res.items || [];
                    renderRincianTabel(res);
                }
            },
            error: function() {
                $('#rincian-layanan-body').html(`<tr><td colspan="6" class="text-center py-3 text-danger">Gagal menarik rincian tagihan.</td></tr>`);
            }
        });
    }

    function renderRincianTabelokalUpdate() {
        let htmlTagihan = '';
        let totalPasienAcc = 0;
        let totalPrshAcc = 0;

        currentDetailItems.forEach((item, index) => {
            let tggPasien = parseFloat(item.tanggungan_pasien) || 0;
            let tggPrsh = parseFloat(item.tanggungan_perusahaan) || 0;
            let isLunas = item.status_pembayaran === 'LUNAS';

            if (!isLunas) {
                totalPasienAcc += tggPasien;
                totalPrshAcc += tggPrsh;
            }

            let checkboxHtml = '';
            if (isLunas) {
                checkboxHtml = '<span class="badge bg-success text-white">LUNAS</span>';
            } else if (tggPasien > 0) {
                checkboxHtml = `<input type="checkbox" class="form-check-input item-pilih-lunas" value="${item.id}" data-pasien="${tggPasien}" checked onchange="hitungTotalPilihanBayar()" style="width: 18px; height: 18px; cursor: pointer;">`;
            } else {
                checkboxHtml = '<span class="badge bg-secondary text-white" style="font-size: 0.65rem;">Ditanggung Perusahaan</span>';
            }

            let splitButtonHtml = isLunas ?
                '-' :
                `<button type="button" class="btn btn-sm ent-btn ent-btn-warning px-2 py-1 fs--2" onclick="bukaModalAturSplitItem(${index})" title="Ubah Porsi Tanggungan">
                    <i class="fas fa-sliders-h"></i> Split
                </button>`;

            htmlTagihan += `
                <tr class="${isLunas ? 'table-success bg-opacity-10' : ''}">
                    <td class="text-center">${checkboxHtml}</td>
                    <td>
                        <span class="badge bg-secondary mb-1">${item.jenis_item}</span>
                        <div class="fw-semibold">${item.nama_item} (Qty: ${item.qty})</div>
                    </td>
                    <td class="text-end">Rp ${Number(item.harga_akhir).toLocaleString('id-ID')}</td>
                    <td class="text-end text-danger">Rp ${tggPasien.toLocaleString('id-ID')}</td>
                    <td class="text-end text-success">Rp ${tggPrsh.toLocaleString('id-ID')}</td>
                    <td class="text-center">${splitButtonHtml}</td>
                </tr>
            `;
        });

        $('#rincian-layanan-body').html(htmlTagihan);
        $('#lbl-total-tanggungan-pasien').text('Rp ' + totalPasienAcc.toLocaleString('id-ID'));
        $('#lbl-total-tanggungan-perusahaan').text('Rp ' + totalPrshAcc.toLocaleString('id-ID'));
        $('#lblTotalTagihanPasien').text(totalPasienAcc.toLocaleString('id-ID'));

        if (totalPasienAcc <= 0) {
            $('#alertFullPerusahaan').removeClass('d-none');
            nonaktifkanMetodePembayaran(true);
            $('#btnProsesPayment').prop('disabled', false);
        } else {
            $('#alertFullPerusahaan').addClass('d-none');
            nonaktifkanMetodePembayaran(false);
        }
    }

    function bukaModalAturSplitItem(index) {
        let item = currentDetailItems[index];
        let subtotal = parseFloat(item.harga_akhir) || 0;

        Swal.fire({
            title: `<div class="fs-2 fw-bold"><i class="fas fa-sliders-h text-primary me-1"></i> Atur Porsi Item: ${item.nama_item}</div>`,
            html: `
                <div class="text-start fs--1">
                    <p class="mb-2 opacity-75 fw-semibold">Subtotal Item: Rp ${subtotal.toLocaleString('id-ID')}</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Opsi Tanggungan Item Ini:</label>
                        <select id="swal-opsi-pola" class="form-select retro-input mb-2" onchange="gantiOpsiPolaSwal(${subtotal})">
                            <option value="FULL_PASIEN">Ditanggung Pasien 100%</option>
                            <option value="FULL_PERUSAHAAN">Ditanggung Perusahaan 100%</option>
                            <option value="CUSTOM">Custom Nominal (Split Manual)</option>
                        </select>
                    </div>
                    <div id="wrapper-custom-nominal" style="display: none;">
                        <div class="mb-2">
                            <label class="form-label fw-bold text-danger">Nominal Tanggungan Pasien (Rp)</label>
                            <input type="number" id="swal-input-tgg-pasien" class="form-control retro-input" value="${item.tanggungan_pasien}" onkeyup="hitungSisaPerusahaan(${subtotal})">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold text-success">Nominal Tanggungan Perusahaan (Rp)</label>
                            <input type="number" id="swal-input-tgg-prsh" class="form-control retro-input" value="${item.tanggungan_perusahaan}" readonly>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan Porsi',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#059669',
            cancelButtonColor: '#64748b',
            preConfirm: () => {
                let opsi = $('#swal-opsi-pola').val();
                let tggPsn = 0;
                let tggPrsh = 0;

                if (opsi === 'FULL_PASIEN') {
                    tggPsn = subtotal;
                    tggPrsh = 0;
                } else if (opsi === 'FULL_PERUSAHAAN') {
                    tggPsn = 0;
                    tggPrsh = subtotal;
                } else {
                    tggPsn = parseFloat($('#swal-input-tgg-pasien').val()) || 0;
                    tggPrsh = parseFloat($('#swal-input-tgg-prsh').val()) || 0;

                    if (Math.round(tggPsn + tggPrsh) !== Math.round(subtotal)) {
                        Swal.showValidationMessage('Total Tanggungan Pasien + Perusahaan harus sama dengan Subtotal Item!');
                    }
                }
                return {
                    tggPsn,
                    tggPrsh
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let newTggPsn = result.value.tggPsn;
                let newTggPrsh = result.value.tggPrsh;

                $.ajax({
                    url: "{{ route('keuangan_menu_cashier_update_split') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        detail_id: item.id,
                        tanggungan_pasien: newTggPsn,
                        tanggungan_perusahaan: newTggPrsh
                    },
                    success: function(res) {
                        if (res.success) {
                            currentDetailItems[index].tanggungan_pasien = newTggPsn;
                            currentDetailItems[index].tanggungan_perusahaan = newTggPrsh;
                            renderRincianTabelokalUpdate();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                                timer: 1200,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan server saat memperbarui split.', 'error');
                    }
                });
            }
        });
    }

    function gantiOpsiPolaSwal(subtotal) {
        let val = $('#swal-opsi-pola').val();
        if (val === 'CUSTOM') {
            $('#wrapper-custom-nominal').show();
        } else {
            $('#wrapper-custom-nominal').hide();
            if (val === 'FULL_PASIEN') {
                $('#swal-input-tgg-pasien').val(subtotal);
                $('#swal-input-tgg-prsh').val(0);
            } else if (val === 'FULL_PERUSAHAAN') {
                $('#swal-input-tgg-pasien').val(0);
                $('#swal-input-tgg-prsh').val(subtotal);
            }
        }
    }

    function hitungSisaPerusahaan(subtotal) {
        let tggPsn = parseFloat($('#swal-input-tgg-pasien').val()) || 0;
        if (tggPsn > subtotal) {
            tggPsn = subtotal;
            $('#swal-input-tgg-pasien').val(subtotal);
        }
        let tggPrsh = subtotal - tggPsn;
        $('#swal-input-tgg-prsh').val(tggPrsh);
    }

    function renderRincianTabel(res) {
        let htmlTagihan = '';
        let totalPasienAcc = 0;
        let totalPrshAcc = 0;

        if (currentDetailItems && currentDetailItems.length > 0) {
            currentDetailItems.forEach((item, index) => {
                let tggPasien = parseFloat(item.tanggungan_pasien) || 0;
                let tggPrsh = parseFloat(item.tanggungan_perusahaan) || 0;
                let isLunas = item.status_pembayaran === 'LUNAS';

                if (!isLunas) {
                    totalPasienAcc += tggPasien;
                    totalPrshAcc += tggPrsh;
                }

                let checkboxHtml = '';
                if (isLunas) {
                    checkboxHtml = '<span class="badge bg-success text-white">LUNAS</span>';
                } else if (tggPasien > 0) {
                    checkboxHtml = `<input type="checkbox" class="form-check-input item-pilih-lunas" value="${item.id}" data-pasien="${tggPasien}" checked onchange="hitungTotalPilihanBayar()" style="width: 18px; height: 18px; cursor: pointer;">`;
                } else {
                    checkboxHtml = '<span class="badge bg-secondary text-white" style="font-size: 0.65rem;">Ditanggung Perusahaan</span>';
                }

                let splitButtonHtml = isLunas ?
                    '-' :
                    `<button type="button" class="btn btn-sm ent-btn ent-btn-warning px-2 py-1 fs--2" onclick="bukaModalAturSplitItem(${index})" title="Ubah Porsi Tanggungan">
                        <i class="fas fa-sliders-h"></i> Split
                    </button>`;

                htmlTagihan += `
                    <tr class="${isLunas ? 'table-success bg-opacity-10' : ''}">
                        <td class="text-center">${checkboxHtml}</td>
                        <td>
                            <span class="badge bg-secondary mb-1">${item.jenis_item}</span>
                            <div class="fw-semibold">${item.nama_item} (Qty: ${item.qty})</div>
                        </td>
                        <td class="text-end">Rp ${Number(item.harga_akhir).toLocaleString('id-ID')}</td>
                        <td class="text-end text-danger">Rp ${tggPasien.toLocaleString('id-ID')}</td>
                        <td class="text-end text-success">Rp ${tggPrsh.toLocaleString('id-ID')}</td>
                        <td class="text-center">${splitButtonHtml}</td>
                    </tr>
                `;
            });
        } else {
            htmlTagihan = `<tr><td colspan="6" class="text-center py-3 opacity-75">Tidak ada rincian item.</td></tr>`;
        }

        $('#rincian-layanan-body').html(htmlTagihan);
        hitungTotalPilihanBayar();
    }

    function nonaktifkanMetodePembayaran(isDisable) {
        if (isDisable) {
            $('#cardCash, #cardDebit').addClass('disabled-method');
            $('#toggleCash, #toggleDebit').prop('checked', false).prop('disabled', true);
            $('#inputCashJumlah, #inputDebitJumlah, #inputDebitRef').prop('disabled', true).val(0);
            $('#selectDebitEDC').prop('disabled', true).val('');
            $('#inputCashKembali').val(0);
            $('#btnProsesPayment').prop('disabled', true);
        } else {
            $('#cardCash, #cardDebit').removeClass('disabled-method');
            $('#toggleCash, #toggleDebit').prop('checked', false).prop('disabled', false);
            $('#inputCashJumlah, #inputDebitJumlah, #inputDebitRef').prop('disabled', true).val(0);
            $('#selectDebitEDC').prop('disabled', true).val('');
            $('#btnProsesPayment').prop('disabled', true);
        }
    }

    function toggleMetode(type) {
        if (type === 'cash') {
            $('#toggleDebit').prop('checked', false);
            $('#inputDebitJumlah, #inputDebitRef').prop('disabled', true).val(0);
            $('#selectDebitEDC').prop('disabled', true).val('');

            let isCashChecked = $('#toggleCash').is(':checked');
            $('#inputCashJumlah').prop('disabled', !isCashChecked);
            if (!isCashChecked) $('#inputCashJumlah').val(0);
        } else if (type === 'debit') {
            $('#toggleCash').prop('checked', false);
            $('#inputCashJumlah').prop('disabled', true).val(0);

            let isDebitChecked = $('#toggleDebit').is(':checked');
            $('#inputDebitJumlah, #selectDebitEDC, #inputDebitRef').prop('disabled', !isDebitChecked);
            if (!isDebitChecked) $('#inputDebitJumlah').val(0);
        }

        let adaYangDicentang = $('#toggleCash').is(':checked') || $('#toggleDebit').is(':checked');
        let totalPasien = parseFloat($('#lblTotalTagihanPasien').text().replace(/\./g, '')) || 0;
        $('#btnProsesPayment').prop('disabled', !(adaYangDicentang || totalPasien === 0));
    }

    function hitungTotalPilihanBayar() {
        let totalPilihan = 0;
        $('.item-pilih-lunas:checked').each(function() {
            totalPilihan += parseFloat($(this).data('pasien')) || 0;
        });

        $('#lblTotalTagihanPasien').text(totalPilihan.toLocaleString('id-ID'));

        let bayarInput = parseFloat($('#inputCashJumlah').val()) || 0;
        if (bayarInput > 0) hitungKembalian();
    }

    function prosesPaymentKasir() {
        if (!selectedOrderCode) {
            return Swal.fire('Perhatian', 'Pilih pasien dari daftar kunjungan terlebih dahulu!', 'warning');
        }

        let selectedItemIds = [];
        $('.item-pilih-lunas:checked').each(function() {
            selectedItemIds.push($(this).val());
        });

        if (selectedItemIds.length === 0) {
            return Swal.fire('Perhatian', 'Pilih/centang minimal 1 item layanan yang akan dilunaskan!', 'warning');
        }

        let metodePilih = 'CASH';
        let nominalBayar = 0;
        let edcId = null;
        let noRef = null;

        let totalPilihanPasien = parseFloat($('#lblTotalTagihanPasien').text().replace(/\./g, '')) || 0;

        if ($('#toggleCash').is(':checked')) {
            metodePilih = 'CASH';
            nominalBayar = parseFloat($('#inputCashJumlah').val()) || 0;
        } else if ($('#toggleDebit').is(':checked')) {
            metodePilih = 'DEBIT/TRANSFER';
            nominalBayar = parseFloat($('#inputDebitJumlah').val()) || 0;
            edcId = $('#selectDebitEDC').val();
            noRef = $('#inputDebitRef').val();
        }

        if (totalPilihanPasien > 0 && nominalBayar < totalPilihanPasien) {
            return Swal.fire('Pembayaran Kurang', 'Nominal bayar kurang dari total item yang dicentang!', 'warning');
        }

        Swal.fire({
            title: 'Konfirmasi Pembayaran Sebagian',
            text: `Proses pelunasan item terpilih dan terbitkan nota pembayaran baru?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Proses & Cetak Nota!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('keuangan_menu_cashier_proses_payment_parsial') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        registrasi_id: selectedOrderCode,
                        item_ids: selectedItemIds,
                        metode_bayar: metodePilih,
                        nominal_bayar: nominalBayar,
                        edc_id: edcId,
                        no_referensi: noRef
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.open(res.redirect_url, '_blank');
                                loadAntreanKasir();
                                pilihPasienKasir(selectedOrderCode);
                            });
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Terjadi kesalahan server saat memproses.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        Swal.fire('Gagal', msg, 'error');
                    }
                });
            }
        });
    }

    function cetakNotaAktif() {
        if (!selectedOrderCode) {
            return Swal.fire('Perhatian', 'Pilih pasien/transaksi terlebih dahulu!', 'warning');
        }
        window.open("{{ url('application/cashier/download-receipt-pdf') }}/" + selectedOrderCode, '_blank');
    }

    function bukaKartuKontrol() {
        if (!selectedOrderCode) {
            return Swal.fire('Perhatian', 'Pilih pasien terlebih dahulu!', 'warning');
        }
        Swal.fire('Info', 'Fitur Kartu Kontrol Pasien belum di-set', 'info');
    }
</script>
<script>
    function bukaModalBuatLaporanKeuangan() {
        Swal.fire({
            title: 'Memuat Data...',
            text: 'Mengambil daftar transaksi pelunasan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('keuangan.get_belum_dilaporkan_keuangan') }}",
                    type: "GET",
                    success: function(res) {
                        if (res.success) {
                            let rows = '';
                            if (res.data.length > 0) {
                                res.data.forEach((item) => {
                                    rows += `
                                        <tr class="align-middle">
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input select-transaksi-keu" value="${item.transaksi_id}" data-tagihan="${item.total_tagihan}" checked onchange="hitungTotalSetoranKeu()" style="width: 18px; height: 18px; cursor: pointer;">
                                            </td>
                                            <td class="text-nowrap fw-semibold">
                                                <i class="far fa-calendar-alt text-primary me-1"></i> ${item.tanggal_registrasi}
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-danger border fw-bold font-monospace fs--2 px-2 py-1">${item.no_registrasi}</span>
                                            </td>
                                            <td>
                                                <span class="text-uppercase fw-bold d-block">${item.nama_pasien}</span>
                                                <span class="badge bg-light text-dark border fw-semibold fs--2"><i class="fas fa-qrcode me-1"></i>${item.pid}</span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold d-block">${item.layanan}</span>
                                                <small class="opacity-75 fw-semibold" style="font-size: 0.65rem;">${item.poli}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-bold px-2 py-1">${item.metode_bayar}</span>
                                            </td>
                                            <td class="text-end fw-bold text-success fs-0" style="font-family: 'JetBrains Mono', monospace;">
                                                Rp ${Number(item.total_tagihan).toLocaleString('id-ID')}
                                            </td>
                                        </tr>
                                    `;
                                });
                            } else {
                                rows = `<tr><td colspan="7" class="text-center py-4 opacity-75 fw-semibold">Tidak ada transaksi lunas baru yang belum dilaporkan.</td></tr>`;
                            }

                            let htmlModal = `
                                <div class="text-start">
                                    <div class="table-responsive rounded-3 mb-3 shadow-sm" style="max-height: 400px; overflow-y: auto; border: 1px solid rgba(99, 102, 241, 0.28);">
                                        <table class="table table-hover table-custom-orange align-middle mb-0 fs--1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="5%"><input type="checkbox" class="form-check-input" id="checkAllKeu" checked onclick="toggleAllKeu(this)" style="width: 18px; height: 18px; cursor: pointer;"></th>
                                                    <th width="20%">TGL REGISTRASI</th>
                                                    <th width="18%">NO. REGISTRASI</th>
                                                    <th width="22%">NAMA PASIEN (PID)</th>
                                                    <th width="15%">JENIS LAYANAN</th>
                                                    <th width="10%" class="text-center">METODE</th>
                                                    <th width="10%" class="text-end">TOTAL TAGIHAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${rows}
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="p-3 rounded-3 d-flex flex-wrap justify-content-between align-items-center shadow-sm gap-2" style="border: 1px solid rgba(99, 102, 241, 0.28);">
                                        <div class="d-flex gap-2">
                                            <div class="p-2 border rounded-3 text-center px-3">
                                                <small class="opacity-75 fw-semibold d-block fs--2">TOTAL DIPILIH</small>
                                                <h6 class="fw-bold mb-0" id="lblTotalDipilih">0 Transaksi</h6>
                                            </div>
                                            <div class="p-2 border rounded-3 text-center px-3">
                                                <small class="opacity-75 fw-semibold d-block fs--2">TOTAL SETORAN</small>
                                                <h6 class="fw-bold mb-0 text-success" id="lblTotalSetoran" style="font-family: 'JetBrains Mono', monospace;">Rp 0</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn ent-btn btn-outline-secondary px-4 fw-semibold" onclick="Swal.close()">
                                                BATAL
                                            </button>
                                            <button type="button" class="btn ent-btn ent-btn-success px-4 fw-semibold text-white shadow-sm" id="btnBuatNotaLaporan" onclick="prosesSimpanLaporanKeuanganFinal()">
                                                <i class="fas fa-paper-plane me-1"></i> BUAT NOTA LAPORAN
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;

                            Swal.fire({
                                title: '<div class="text-start fw-bold fs-2"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i> Rekap Transaksi Belum Dilaporkan ke Accounting</div>',
                                html: htmlModal,
                                width: '1050px',
                                showConfirmButton: false,
                                showCloseButton: true,
                                customClass: {
                                    popup: 'ent-modal-popup shadow-lg p-3'
                                },
                                didRender: () => {
                                    hitungTotalSetoranKeu();
                                }
                            });
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memuat data transaksi pelunasan.', 'error');
                    }
                });
            }
        });
    }

    function toggleAllKeu(source) {
        $('.select-transaksi-keu').prop('checked', source.checked);
        hitungTotalSetoranKeu();
    }

    function hitungTotalSetoranKeu() {
        let totalCount = 0;
        let totalSum = 0;

        $('.select-transaksi-keu:checked').each(function() {
            totalCount++;
            totalSum += parseFloat($(this).data('tagihan')) || 0;
        });

        $('#lblTotalDipilih').text(totalCount + ' Transaksi');
        $('#lblTotalSetoran').text('Rp ' + totalSum.toLocaleString('id-ID'));
    }

    function prosesSimpanLaporanKeuanganFinal() {
        let selectedIds = [];
        $('.select-transaksi-keu:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            return Swal.fire('Perhatian', 'Pilih minimal 1 transaksi untuk dibuatkan laporan!', 'warning');
        }

        Swal.fire({
            title: 'Menyimpan Laporan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('keuangan.store_laporan_keuangan_keuangan') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                transaksi_ids: selectedIds
            },
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                    }).then(() => {
                        loadAntreanKasir();
                    });
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function(xhr) {
                let msg = 'Terjadi kesalahan pada server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Gagal', msg, 'error');
            }
        });
    }
</script>
@endsection
