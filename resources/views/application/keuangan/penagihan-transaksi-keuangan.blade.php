@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
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

    /* Modern Buttons */
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
        padding: 14px 16px;
        margin-bottom: 14px;
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

    /* Custom Table with Colored Grid Borders */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.8rem;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 11px 9px;
        letter-spacing: 0.04em;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 9px 9px;
        vertical-align: middle;
        background-color: transparent;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    /* Total Box */
    .total-prsh-box {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 65%, #312e81 100%);
        color: #ffffff;
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 8px 20px -6px rgba(15, 23, 42, 0.22);
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

    .ent-item-rincian {
        border-left: 3px solid var(--ent-indigo);
        background-color: rgba(79, 70, 229, 0.05);
        border-radius: 8px;
        padding: 6px 10px;
        margin-top: 6px;
    }

    /* Modal Adaptive Enterprise */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .modal-ent-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%);
        color: #ffffff;
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-2">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 56px; height: 56px;">
                            <i class="fas fa-file-invoice-dollar fs-3 text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.45); color: #7dd3fc;">
                                    <i class="fas fa-building me-1"></i> Corporate &amp; Insurance Billing
                                </span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                Modul Penagihan Keuangan <span class="fw-normal" style="color: #cbd5e1;">Perusahaan / Asuransi</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER & LAYOUT UTAMA (2 KOLOM: KIRI DAFTAR, KANAN FORM BUAT/PILIH PASIEN) -->
<div class="row g-3">

    <!-- KOLOM KIRI: DAFTAR / TABEL ISU PENAGIHAN -->
    <div class="col-lg-6">
        <!-- FILTER BAR KIRI -->
        <div class="filter-bar-container">
            <div class="row g-2 align-items-end">
                <div class="col-sm-4">
                    <label class="form-label ent-field-label">Kel. Pelanggan</label>
                    <select class="form-select form-select-sm retro-input" id="filter_penjamin" onchange="loadDaftarPenagihan()">
                        <option value="">Semua Perusahaan</option>
                        @foreach ($subPenjamins ?? [] as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="form-label ent-field-label">No. Isu Penagihan</label>
                    <input type="text" class="form-control form-control-sm retro-input" id="filter_no_tagihan" placeholder="Cari No Tagihan..." onkeyup="loadDaftarPenagihan()">
                </div>
                <div class="col-sm-3">
                    <label class="form-label ent-field-label">Status</label>
                    <select class="form-select form-select-sm retro-input" id="filter_status" onchange="loadDaftarPenagihan()">
                        <option value="DRAFT" selected>Draft / Belum Lunas</option>
                        <option value="LUNAS">Lunas</option>
                        <option value="">Semua Status</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <button type="button" class="btn ent-btn ent-btn-success w-100 fw-semibold d-flex align-items-center justify-content-center" style="height: 35px;" onclick="bukaPanelBuatTagihan()" title="Buat Penagihan Baru">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- TABEL DAFTAR PENAGIHAN DI KIRI -->
        <div class="ent-card">
            <div class="ent-card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-list-alt text-primary"></i> Daftar Isu Penagihan
                </h6>
            </div>
            <div class="table-responsive" style="max-height: 650px; overflow-y: auto;">
                <table class="table table-hover table-custom align-middle mb-0 fs--1">
                    <thead>
                        <tr>
                            <th>TGL. PENAGIHAN</th>
                            <th>NO. PENAGIHAN</th>
                            <th>JATUH TEMPO</th>
                            <th>KEL. PELANGGAN</th>
                            <th class="text-end">TOTAL PENAGIHAN</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-daftar-penagihan-body" class="fw-semibold">
                        <tr>
                            <td colspan="7" class="text-center py-4 opacity-75">Memuat data penagihan...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: PANEL PEMBUATAN / PEMILIHAN PASIEN & RINCIAN ITEM -->
    <div class="col-lg-6">
        <div class="ent-card p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-center pb-3 mb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="fas fa-file-circle-plus text-primary"></i> Buat / Pilih Nota Tagihan
                </h6>
                <button type="button" class="btn btn-sm ent-btn ent-btn-success px-3 py-2" onclick="simpanHeaderTagihan()">
                    <i class="fas fa-save me-1"></i> SIMPAN <i class="fas fa-download ms-1"></i>
                </button>
            </div>

            <!-- Form Pembuatan / Header Tagihan -->
            <div class="row g-2 mb-3">
                <div class="col-12">
                    <label class="form-label ent-field-label">Pilih Perusahaan / Sub Penjamin</label>
                    <select class="form-select form-select-sm retro-input" id="input_sub_penjamin" onchange="loadPasienPiutangByPenjamin()">
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($subPenjamins ?? [] as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label ent-field-label">Tanggal Tagihan</label>
                    <input type="date" class="form-control form-control-sm retro-input" id="input_tgl_tagihan" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label ent-field-label">Jatuh Tempo</label>
                    <input type="date" class="form-control form-control-sm retro-input" id="input_jatuh_tempo" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                </div>
            </div>

            <!-- Filter & Tabel Daftar Nota Pasien -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.32);" id="lblJumlahNotaPilih">Jumlah Nota : 0</span>
            </div>
            <div class="table-responsive rounded-3 mb-3" style="max-height: 450px; overflow-y: auto; border: 1px solid var(--ent-grid-border);">
                <table class="table table-sm table-bordered table-hover table-custom align-middle mb-0 fs--1">
                    <thead style="position: sticky; top: 0; z-index: 2;">
                        <tr>
                            <th class="text-center" width="7%"><input type="checkbox" class="form-check-input" id="checkAllPasienPiutang" onclick="toggleAllPasienPiutang(this)"></th>
                            <th width="20%">NO. REG / TGL</th>
                            <th width="45%">NAMA PASIEN &amp; RINCIAN ITEM (TINDAKAN / OBAT)</th>
                            <th class="text-end" width="28%">TOTAL PRSH</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-pilih-pasien-body" class="fw-semibold">
                        <tr>
                            <td colspan="4" class="text-center py-4 opacity-75">Pilih perusahaan terlebih dahulu.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total Keseluruhan -->
            <div class="total-prsh-box">
                <span class="fs--1 fw-semibold">Total Tanggungan Perusahaan:</span>
                <span class="fs-0 fw-bold" style="color: #34d399; font-family: 'JetBrains Mono', monospace; font-size: 1.15rem;" id="lblTotalNominalPrsh">Rp 0</span>
            </div>

        </div>
    </div>

</div>

<!-- MODAL DETAIL PENAGIHAN, PREVIEW PDF, DAN PEMBAYARAN -->
<div class="modal fade" id="modalDetailPenagihan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="modal-header modal-ent-header py-3">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-info"></i> Detail Penagihan &amp; Pembayaran Perusahaan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="row g-3">
                    <!-- Kolom Kiri: Preview Dokumen PDF Tagihan -->
                    <div class="col-lg-7">
                        <div class="ent-card h-100">
                            <div class="ent-card-header d-flex justify-content-between align-items-center">
                                <span class="fs--1 fw-bold"><i class="fas fa-eye text-primary me-1"></i> Preview PDF Tagihan</span>
                                <a href="#" id="btnDownloadPdfModal" class="btn btn-sm ent-btn ent-btn-primary fs--2" target="_blank"><i class="fas fa-download me-1"></i> Download PDF</a>
                            </div>
                            <div class="card-body p-0" style="height: 450px; background-color: rgba(15, 23, 42, 0.04);">
                                <iframe id="framePdfPreview" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Form Pembayaran & Aksi Kirim Pesan -->
                    <div class="col-lg-5">
                        <div class="ent-card h-100 p-3 p-md-4 d-flex flex-column">
                            <h6 class="fw-bold pb-2 mb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                                <i class="fas fa-wallet me-1 text-success"></i> Informasi &amp; Pelunasan Tagihan
                            </h6>

                            <div class="mb-2">
                                <small class="ent-field-label d-block">No. Penagihan</small>
                                <h6 class="fw-bold text-danger mb-1" style="font-family: 'JetBrains Mono', monospace;" id="modalNoTagihan">-</h6>
                            </div>
                            <div class="mb-2">
                                <small class="ent-field-label d-block">Perusahaan / Penjamin</small>
                                <h6 class="fw-bold mb-1" id="modalNamaPerusahaan">-</h6>
                            </div>
                            <div class="mb-3">
                                <small class="ent-field-label d-block">Total Nominal Tagihan</small>
                                <h4 class="fw-bold text-success mb-0" style="font-family: 'JetBrains Mono', monospace;" id="modalTotalTagihan">Rp 0</h4>
                            </div>

                            <div class="pt-3 mt-2" style="border-top: 1px solid var(--ent-grid-border);">
                                <label class="form-label ent-field-label">Metode Pembayaran Perusahaan</label>
                                <select class="form-select form-select-sm retro-input mb-2" id="modalMetodeBayar">
                                    <option value="TRANSFER_BANK">Transfer Bank / Giro</option>
                                    <option value="PIUTANG_LUNAS">Pelunasan Piutang Perusahaan</option>
                                </select>

                                <label class="form-label ent-field-label">No Referensi / Bukti Transfer</label>
                                <input type="text" class="form-control form-control-sm retro-input mb-3" id="modalNoRef" placeholder="Masukkan No Ref / Keterangan">

                                <button type="button" class="btn ent-btn ent-btn-success w-100 py-2 fw-semibold shadow-sm" onclick="prosesBayarTagihanModal()">
                                    <i class="fas fa-check-circle me-1"></i> PROSES PELUNASAN TAGIHAN
                                </button>
                            </div>

                            <!-- Opsi Kirim Pesan Cepat -->
                            <div class="mt-auto pt-3 d-flex gap-2" style="border-top: 1px solid var(--ent-grid-border);">
                                <button type="button" class="btn btn-sm ent-btn ent-btn-success flex-grow-1 fs--2" onclick="kirimPesanTagihanAktif('whatsapp')">
                                    <i class="fab fa-whatsapp me-1"></i> Kirim WA
                                </button>
                                <button type="button" class="btn btn-sm ent-btn ent-btn-primary flex-grow-1 fs--2" onclick="kirimPesanTagihanAktif('email')">
                                    <i class="fas fa-envelope me-1"></i> Kirim Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentPiutangList = [];

    $(document).ready(function() {
        loadDaftarPenagihan();
    });

    function loadDaftarPenagihan() {
        let penjamin = $('#filter_penjamin').val();
        let noTagihan = $('#filter_no_tagihan').val();
        let status = $('#filter_status').val();

        $('#tabel-daftar-penagihan-body').html(`<tr><td colspan="7" class="text-center py-3 opacity-75">Memuat data...</td></tr>`);

        $.ajax({
            url: "{{ route('api.daftar.penagihan.perusahaan') }}",
            type: "GET",
            data: {
                penjamin: penjamin,
                keyword: noTagihan,
                status: status
            },
            success: function(res) {
                if (res.success && res.data.length > 0) {
                    let html = '';

                    res.data.forEach(item => {
                        let badgeStatus = item.status_tagihan === 'LUNAS' ?
                            '<span class="badge bg-success text-white">LUNAS</span>' :
                            '<span class="badge bg-warning text-dark">DRAFT</span>';
                        let aksiBtn = `
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm ent-btn ent-btn-warning px-2 py-1 fs--2" onclick="bukaModalDetailPenagihan(${item.penagihan_id})" title="Preview PDF & Bayar"><i class="fas fa-file-pdf"></i></button>
                                <button type="button" class="btn btn-sm ent-btn ent-btn-success px-2 py-1 fs--2" onclick="konfirmasiKirimPesan(${item.penagihan_id}, 'whatsapp')" title="Kirim WhatsApp"><i class="fab fa-whatsapp"></i></button>
                                <button type="button" class="btn btn-sm ent-btn ent-btn-primary px-2 py-1 fs--2" onclick="konfirmasiKirimPesan(${item.penagihan_id}, 'email')" title="Kirim Email"><i class="fas fa-envelope"></i></button>
                            </div>
                        `;
                        html += `
                            <tr>
                                <td>${item.tanggal_tagihan}</td>
                                <td><span class="text-danger fw-bold" style="font-family: 'JetBrains Mono', monospace;">${item.no_tagihan}</span></td>
                                <td>${item.tanggal_tagihan}</td>
                                <td>${item.nama_sub_penjamin}</td>
                                <td class="text-end text-success fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(item.total_tagihan).toLocaleString('id-ID')}</td>
                                <td class="text-center">${badgeStatus}</td>
                                <td class="text-center">${aksiBtn}</td>
                            </tr>
                        `;
                    });
                    $('#tabel-daftar-penagihan-body').html(html);
                } else {
                    $('#tabel-daftar-penagihan-body').html(`<tr><td colspan="7" class="text-center py-4 opacity-75">Tidak ada data penagihan.</td></tr>`);
                }
            }
        });
    }

    function bukaPanelBuatTagihan() {
        $('#input_sub_penjamin').val('').trigger('change');
        $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-3 opacity-75">Pilih perusahaan terlebih dahulu.</td></tr>`);
        Swal.fire({
            icon: 'info',
            title: 'Mode Pembuatan Tagihan',
            text: 'Silakan pilih perusahaan di panel kanan untuk menampilkan daftar pasien piutang.',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function loadPasienPiutangByPenjamin() {
        let subPenjaminId = $('#input_sub_penjamin').val();
        if (!subPenjaminId) {
            $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-3 opacity-75">Pilih perusahaan terlebih dahulu.</td></tr>`);
            $('#lblJumlahNotaPilih').text('Jumlah Nota : 0');
            $('#lblTotalNominalPrsh').text('Rp 0');
            return;
        }

        $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-3 opacity-75">Memuat data pasien dan rincian item...</td></tr>`);

        $.ajax({
            url: "{{ route('api.pasien.by.subpenjamin') }}",
            type: "GET",
            data: {
                sub_penjamin_id: subPenjaminId
            },
            success: function(res) {
                if (res.success && res.data.length > 0) {
                    let transaksiIds = res.data.map(item => item.transaksi_id);

                    $.ajax({
                        url: "{{ route('api.rincian.item.transaksi') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            transaksi_ids: transaksiIds
                        },
                        success: function(resItem) {
                            let itemMap = {};
                            if (resItem.success && resItem.items.length > 0) {
                                resItem.items.forEach(it => {
                                    if (!itemMap[it.transaksi_id]) itemMap[it.transaksi_id] = [];
                                    itemMap[it.transaksi_id].push(it);
                                });
                            }

                            currentPiutangList = res.data.map(pasien => {
                                pasien.items = itemMap[pasien.transaksi_id] || [];
                                return pasien;
                            });

                            renderTabelPiutangPasien(currentPiutangList);
                        }
                    });

                } else {
                    currentPiutangList = [];
                    $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-4 opacity-75">Tidak ada piutang untuk perusahaan ini.</td></tr>`);
                    $('#lblJumlahNotaPilih').text('Jumlah Nota : 0');
                    $('#lblTotalNominalPrsh').text('Rp 0');
                }
            }
        });
    }

    function renderTabelPiutangPasien(data) {
        let html = '';
        let count = 0;
        data.forEach(item => {
            count++;
            let rincianHtml = `<div class="text-uppercase mb-1 fw-bold">${item.nama_lengkap}</div><small class="opacity-75 d-block mb-1" style="font-family: 'JetBrains Mono', monospace;">RM: ${item.pid}</small>`;
            if (item.items && item.items.length > 0) {
                rincianHtml += `<div class="ent-item-rincian">`;
                item.items.forEach(it => {
                    let badgeColor = it.jenis_item === 'OBAT' ? 'bg-danger' : 'bg-secondary';
                    rincianHtml += `
                        <div class="d-flex justify-content-between align-items-center fs--2 py-0.5 border-bottom border-opacity-10">
                            <span><span class="badge ${badgeColor} me-1" style="font-size: 0.55rem;">${it.jenis_item}</span> ${it.nama_item} (x${it.qty})</span>
                            <span class="text-success fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(it.tanggungan_perusahaan).toLocaleString('id-ID')}</span>
                        </div>
                    `;
                });
                rincianHtml += `</div>`;
            } else {
                rincianHtml += `<small class="opacity-75 fst-italic">Tidak ada rincian item tercatat.</small>`;
            }

            html += `
                <tr>
                    <td class="text-center align-top pt-2"><input type="checkbox" class="form-check-input pasien-piutang-checkbox" value="${item.transaksi_id}" data-total="${item.tanggungan_perusahaan}" checked onchange="hitungJumlahNotaPilih()"></td>
                    <td class="align-top pt-2">
                        <span class="text-danger fw-bold d-block" style="font-family: 'JetBrains Mono', monospace;">${item.no_registrasi}</span>
                        <small class="opacity-75">${item.tanggal_registrasi}</small>
                    </td>
                    <td class="align-top pt-2">${rincianHtml}</td>
                    <td class="text-end align-top pt-2 text-success fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(item.tanggungan_perusahaan).toLocaleString('id-ID')}</td>
                </tr>
            `;
        });
        $('#tabel-pilih-pasien-body').html(html);
        hitungJumlahNotaPilih();
    }

    function toggleAllPasienPiutang(source) {
        $('.pasien-piutang-checkbox').prop('checked', source.checked);
        hitungJumlahNotaPilih();
    }

    function hitungJumlahNotaPilih() {
        let checkedCount = 0;
        let totalSumPrsh = 0;

        $('.pasien-piutang-checkbox:checked').each(function() {
            checkedCount++;
            totalSumPrsh += parseFloat($(this).data('total')) || 0;
        });

        $('#lblJumlahNotaPilih').text('Jumlah Nota : ' + checkedCount);
        $('#lblTotalNominalPrsh').text('Rp ' + totalSumPrsh.toLocaleString('id-ID'));
    }

    function simpanHeaderTagihan() {
        let subPenjaminId = $('#input_sub_penjamin').val();
        let tglTagihan = $('#input_tgl_tagihan').val();

        if (!subPenjaminId) {
            return Swal.fire('Perhatian', 'Pilih perusahaan / sub penjamin terlebih dahulu!', 'warning');
        }

        let selectedTransaksiIds = [];
        $('.pasien-piutang-checkbox:checked').each(function() {
            selectedTransaksiIds.push($(this).val());
        });

        if (selectedTransaksiIds.length === 0) {
            return Swal.fire('Perhatian', 'Pilih minimal 1 nota/pasien yang akan ditagihkan!', 'warning');
        }

        Swal.fire({
            title: 'Menyimpan Tagihan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('api.buat.tagihan.perusahaan') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                sub_penjamin_id: subPenjaminId,
                tanggal_tagihan: tglTagihan,
                transaksi_ids: selectedTransaksiIds
            },
            success: function(res) {
                if (res.success) {
                    Swal.fire('Berhasil!', res.message, 'success');
                    loadDaftarPenagihan();
                    $('#input_sub_penjamin').val('').trigger('change');
                    $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-3 opacity-75">Pilih perusahaan terlebih dahulu.</td></tr>`);
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            }
        });
    }
</script>
<script>
    let selectedPenjaminIdModal = null;

    function bukaModalDetailPenagihan(penagihanId) {
        selectedPenjaminIdModal = penagihanId;

        $.ajax({
            url: "{{ url('application/api/penagihan/detail') }}/" + penagihanId,
            type: "GET",
            success: function(res) {
                if (res.success) {
                    $('#modalNoTagihan').text(res.data.no_tagihan);
                    $('#modalNamaPerusahaan').text(res.data.nama_sub_penjamin);
                    $('#modalTotalTagihan').text('Rp ' + Number(res.data.total_tagihan).toLocaleString('id-ID'));

                    let pdfUrl = "{{ url('/application/penagihan/download-pdf') }}/" + penagihanId;
                    $('#framePdfPreview').attr('src', pdfUrl);
                    $('#btnDownloadPdfModal').attr('href', pdfUrl);

                    $('#modalDetailPenagihan').modal('show');
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            }
        });
    }

    function prosesBayarTagihanModal() {
        if (!selectedPenjaminIdModal) return;

        let metode = $('#modalMetodeBayar').val();
        let noRef = $('#modalNoRef').val();

        Swal.fire({
            title: 'Konfirmasi Pelunasan',
            text: 'Proses pelunasan untuk seluruh tagihan dalam nomor penagihan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lunasi!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#059669',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('api.pelunasan.penagihan.perusahaan') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        penagihan_id: selectedPenjaminIdModal,
                        metode_bayar: metode,
                        no_referensi: noRef
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Berhasil!', res.message, 'success');
                            $('#modalDetailPenagihan').modal('hide');
                            loadDaftarPenagihan();
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    }
                });
            }
        });
    }

    function konfirmasiKirimPesan(penagihanId, tipe) {
        let namaTipe = tipe === 'whatsapp' ? 'WhatsApp' : 'Email';
        Swal.fire({
            title: `Kirim Tagihan via ${namaTipe}?`,
            text: `Sistem akan mengirimkan pesan notifikasi tagihan ke kontak perusahaan terkait.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim Sekarang!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                kirimPesanTagihan(penagihanId, tipe);
            }
        });
    }

    function kirimPesanTagihan(penagihanId, tipe) {
        Swal.fire({
            title: 'Mengirim Pesan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ url('application/api/penagihan/kirim-pesan') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                penagihan_id: penagihanId,
                tipe_pengiriman: tipe
            },
            success: function(res) {
                if (res.success) {
                    if (tipe === 'whatsapp' && res.whatsapp_url) {
                        Swal.close();
                        window.open(res.whatsapp_url, '_blank');
                    } else {
                        Swal.fire('Berhasil', res.message, 'success');
                    }
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan pada server saat mengirim pesan.', 'error');
            }
        });
    }

    function kirimPesanTagihanAktif(tipe) {
        if (selectedPenjaminIdModal) {
            konfirmasiKirimPesan(selectedPenjaminIdModal, tipe);
        }
    }
</script>
@endsection
