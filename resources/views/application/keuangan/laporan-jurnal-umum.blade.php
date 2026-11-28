@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #3730a3;
        --ent-grid-border: rgba(99, 102, 241, 0.2);
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-grid-border: rgba(148, 163, 184, 0.2);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .mono-code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.78rem;
        font-weight: 700;
    }

    /* Hero Header */
    .ent-header-banner {
        background: linear-gradient(135deg, #090d16 0%, #1e1b4b 52%, #0369a1 100%);
        border: 1px solid rgba(129, 140, 248, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -8px rgba(15, 23, 42, 0.25);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        color: #ffffff;
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

    /* 5 Top Summary Cards (Sesuai Gambar Referensi) */
    .jrn-kpi-card {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid rgba(148, 163, 184, 0.28);
        border-radius: 14px;
        padding: 15px 18px;
        box-shadow: 0 3px 12px -4px rgba(15, 23, 42, 0.06);
        height: 100%;
        transition: transform 0.16s ease, border-color 0.16s ease;
    }

    .jrn-kpi-card:hover {
        transform: translateY(-2px);
        border-color: rgba(79, 70, 229, 0.45);
    }

    .jrn-kpi-label {
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
        display: block;
    }

    .jrn-kpi-value {
        font-size: 1.25rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    /* Filter Bar */
    .ent-filter-wrapper {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        box-shadow: 0 4px 16px -4px rgba(15, 23, 42, 0.05);
        padding: 12px 14px;
        border-radius: 14px;
    }

    .ent-input-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px;
        padding: 19px 11px 5px 11px;
        position: relative;
        background-color: rgba(79, 70, 229, 0.02);
    }

    .ent-input-box label {
        position: absolute;
        top: 4px;
        left: 11px;
        font-size: 0.62rem;
        color: var(--bs-secondary-color, #64748b);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        pointer-events: none;
    }

    .ent-input-box input,
    .ent-input-box select {
        border: none;
        outline: none;
        width: 100%;
        background: transparent;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--bs-body-color, var(--ent-solid-text));
        padding: 0;
    }

    /* Main Table Card (Sesuai Gambar Referensi) */
    .jrn-table-card {
        border: 1px solid rgba(148, 163, 184, 0.28);
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 8px 24px -6px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .table-jurnal-ref {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
    }

    .table-jurnal-ref thead th {
        background: linear-gradient(180deg, #1b2248 0%, #141936 100%);
        color: #ffffff;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.04em;
        padding: 13px 14px;
        border: none;
        white-space: nowrap;
    }

    .table-jurnal-ref thead th.th-debit {
        background: linear-gradient(180deg, #162244 0%, #111b38 100%);
        color: #86efac;
    }

    .table-jurnal-ref thead th.th-kredit {
        background: linear-gradient(180deg, #162244 0%, #111b38 100%);
        color: #fda4af;
    }

    .table-jurnal-ref tbody tr.jrn-main-row td {
        padding: 14px 14px;
        border-bottom: 1px solid rgba(148, 163, 184, 0.22);
        vertical-align: middle;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        transition: background-color 0.14s ease;
    }

    .table-jurnal-ref tbody tr.jrn-main-row:hover td {
        background-color: rgba(238, 242, 255, 0.75);
    }

    [data-bs-theme="dark"] .table-jurnal-ref tbody tr.jrn-main-row:hover td,
    .dark .table-jurnal-ref tbody tr.jrn-main-row:hover td {
        background-color: rgba(79, 70, 229, 0.12);
    }

    .td-debit-col {
        background-color: rgba(240, 253, 244, 0.65) !important;
        color: #059669;
        font-weight: 800;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.84rem;
        text-align: right;
        white-space: nowrap;
    }

    .td-kredit-col {
        background-color: rgba(255, 241, 242, 0.65) !important;
        color: #e11d48;
        font-weight: 800;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.84rem;
        text-align: right;
        white-space: nowrap;
    }

    [data-bs-theme="dark"] .td-debit-col,
    .dark .td-debit-col {
        background-color: rgba(16, 185, 129, 0.08) !important;
        color: #34d399;
    }

    [data-bs-theme="dark"] .td-kredit-col,
    .dark .td-kredit-col {
        background-color: rgba(244, 63, 94, 0.08) !important;
        color: #fb7185;
    }

    .btn-expand-jrn {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: 1px solid rgba(99, 102, 241, 0.35);
        background-color: rgba(99, 102, 241, 0.08);
        color: #4f46e5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 800;
        transition: all 0.16s ease;
        cursor: pointer;
    }

    .btn-expand-jrn:hover,
    .btn-expand-jrn[aria-expanded="true"] {
        background-color: #4f46e5;
        color: #ffffff;
    }

    .btn-expand-jrn[aria-expanded="true"] i {
        transform: rotate(90deg);
    }

    .btn-expand-jrn i {
        transition: transform 0.16s ease;
    }

    .jrn-seq-badge {
        background-color: #1e293b;
        color: #ffffff;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 3px;
    }

    .jrn-bukti-link {
        color: #2563eb;
        font-weight: 800;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.78rem;
        text-decoration: none;
        display: block;
        line-height: 1.25;
    }

    .jrn-bukti-link:hover {
        text-decoration: underline;
    }

    .pill-posted {
        background-color: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        font-weight: 700;
        font-size: 0.72rem;
        border-radius: 9999px;
        padding: 3px 10px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .pill-belum-posted {
        background-color: #fff7ed;
        color: #ea580c;
        border: 1px solid #fed7aa;
        font-weight: 700;
        font-size: 0.72rem;
        border-radius: 9999px;
        padding: 3px 10px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-lapor-pusat {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 5px 11px;
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 6px;
        cursor: pointer;
    }

    .btn-lapor-pusat:hover {
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Expandable Balanced Debit & Kredit Detail Panel */
    .jrn-detail-row td {
        background-color: rgba(248, 250, 252, 0.9) !important;
        border-bottom: 1px solid rgba(148, 163, 184, 0.28);
        padding: 12px 18px !important;
    }

    [data-bs-theme="dark"] .jrn-detail-row td,
    .dark .jrn-detail-row td {
        background-color: rgba(15, 23, 42, 0.75) !important;
    }

    .dk-split-box {
        border: 1px solid rgba(148, 163, 184, 0.25);
        border-radius: 12px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        overflow: hidden;
        height: 100%;
    }

    .dk-split-header-debit {
        background-color: rgba(16, 185, 129, 0.1);
        color: #059669;
        border-bottom: 1px solid rgba(16, 185, 129, 0.25);
        padding: 8px 12px;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dk-split-header-kredit {
        background-color: rgba(244, 63, 94, 0.1);
        color: #e11d48;
        border-bottom: 1px solid rgba(244, 63, 94, 0.25);
        padding: 8px 12px;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dk-line-item {
        padding: 8px 12px;
        border-bottom: 1px dashed rgba(148, 163, 184, 0.25);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.78rem;
    }

    .dk-line-item:last-child {
        border-bottom: none;
    }

    /* Footer Total Row (Sesuai Gambar Referensi) */
    .jrn-grand-total-row td {
        background-color: #f8fafc !important;
        border-top: 2px solid rgba(148, 163, 184, 0.35);
        padding: 15px 14px !important;
        font-weight: 800;
    }

    [data-bs-theme="dark"] .jrn-grand-total-row td,
    .dark .jrn-grand-total-row td {
        background-color: #1e293b !important;
    }

    .btn-ent-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff;
        font-weight: 700;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .btn-ent-primary:hover {
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-ent-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: #ffffff;
        font-weight: 700;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .btn-ent-success:hover {
        color: #ffffff;
        transform: translateY(-1px);
    }

    .modal-content.ent-modal {
        border: 1px solid var(--ent-grid-border);
        border-radius: 18px;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 58px; height: 58px;">
                            <img src="{{ asset('img/keuangan.png') }}" alt="Keuangan" width="38" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(251, 191, 36, 0.2); border: 1px solid rgba(251, 191, 36, 0.45); color: #fde68a;">
                                    <i class="fas fa-book-open me-1"></i> FINANCE SUITE v2.4
                                </span>
                                <span style="color: #cbd5e1; font-size: 0.74rem; font-weight: 600;">Jurnal Umum Rumah Sakit</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                {{ env('APP_LABEL') }} <span style="color: #7dd3fc;">Jurnal Umum</span>
                            </h4>
                        </div>
                    </div>
                    <div class="col-lg-5 text-lg-end d-flex flex-wrap justify-content-lg-end align-items-center gap-2">
                        <button type="button" class="btn btn-ent-success px-3 py-2" id="btn-buka-modal-jurnal">
                            <i class="fas fa-plus-circle me-1.5"></i> Input Jurnal Baru
                        </button>
                        <button type="button" class="btn btn-outline-light rounded-3 px-3 py-2 fw-semibold" onclick="loadDataJurnal();" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 5 KARTU RINGKASAN ATAS (SESUAI GAMBAR REFERENSI) -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-4 col-lg">
        <div class="jrn-kpi-card">
            <span class="jrn-kpi-label">JUMLAH BUKTI JURNAL</span>
            <div class="jrn-kpi-value text-primary" id="kpi-jumlah-bukti">0 Transaksi</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg">
        <div class="jrn-kpi-card">
            <span class="jrn-kpi-label">STATUS POSTING PUSAT</span>
            <div class="jrn-kpi-value text-info" id="kpi-status-posting">0 / 0 Posted</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg">
        <div class="jrn-kpi-card">
            <span class="jrn-kpi-label">TOTAL MUTASI DEBIT</span>
            <div class="jrn-kpi-value text-success mono-code" id="kpi-total-debit">Rp 0</div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-lg">
        <div class="jrn-kpi-card">
            <span class="jrn-kpi-label">TOTAL MUTASI KREDIT</span>
            <div class="jrn-kpi-value text-danger mono-code" id="kpi-total-kredit">Rp 0</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg">
        <div class="jrn-kpi-card">
            <span class="jrn-kpi-label">STATUS KESEIMBANGAN</span>
            <div class="jrn-kpi-value text-success d-flex align-items-center gap-2" id="kpi-keseimbangan">
                <i class="fas fa-check-circle"></i> <span>BALANCED</span>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<form id="form-filter-jurnal" class="ent-filter-wrapper mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-6 col-md-3 col-lg-2">
            <div class="ent-input-box">
                <label>Tanggal Awal</label>
                <input type="text" class="datetimepicker" name="tgl_awal" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="ent-input-box">
                <label>Tanggal Akhir</label>
                <input type="text" class="datetimepicker" name="tgl_akhir" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="ent-input-box">
                <label>No. Bukti / Jurnal</label>
                <input type="text" name="no_jurnal" placeholder="JRN-2026...">
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="ent-input-box">
                <label>Jenis / Sumber</label>
                <select name="jenis_jurnal">
                    <option value="">Semua Jenis</option>
                    <option value="UMUM">Umum</option>
                    <option value="PENERIMAAN">Penerimaan</option>
                    <option value="PIUTANG">Piutang / Penjamin</option>
                    <option value="RETUR">Retur</option>
                    <option value="PENYESUAIAN">Penyesuaian</option>
                </select>
            </div>
        </div>
        <div class="col-8 col-md-4 col-lg-2">
            <div class="ent-input-box">
                <label>Uraian / Ref</label>
                <input type="text" name="keyword" placeholder="Cari uraian / ref...">
            </div>
        </div>
        <div class="col-4 col-md-2 col-lg-2 d-grid">
            <button type="submit" class="btn-ent-primary" style="height: 44px;">
                <i class="fas fa-search me-1.5"></i> Filter
            </button>
        </div>
    </div>
</form>

<!-- TABEL JURNAL UMUM (SESUAI GAMBAR REFERENSI) -->
<div class="jrn-table-card mb-4">
    <div class="table-responsive">
        <table class="table-jurnal-ref mb-0" id="table-jurnal-umum">
            <thead>
                <tr>
                    <th style="width: 120px;">TANGGAL</th>
                    <th style="width: 210px;">NO. BUKTI / REF</th>
                    <th style="width: 175px;">STATUS POSTING</th>
                    <th>NAMA AKUN &amp; URAIAN TRANSAKSI</th>
                    <th class="text-end th-debit" style="width: 165px;">DEBIT (RP)</th>
                    <th class="text-end th-kredit" style="width: 165px;">KREDIT (RP)</th>
                </tr>
            </thead>
            <tbody id="tbody-jurnal-umum">
                <tr>
                    <td colspan="6" class="text-center py-4 fw-semibold opacity-75">
                        <i class="fas fa-spinner fa-spin me-2"></i> Memuat data jurnal umum...
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="jrn-grand-total-row">
                    <td colspan="4" class="text-end text-uppercase" style="letter-spacing: 0.03em; font-size: 0.8rem;" id="footer-total-label">
                        TOTAL KESELURUHAN (0 BUKTI JURNAL)
                    </td>
                    <td class="td-debit-col" id="footer-total-debit">Rp 0</td>
                    <td class="td-kredit-col" id="footer-total-kredit">Rp 0</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- MODAL INPUT / EDIT JURNAL UMUM -->
<div class="modal fade" id="modal-jurnal-umum" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content ent-modal">
            <div class="modal-header py-3 px-4" style="background: linear-gradient(90deg, #0f172a 0%, #1e1b4b 100%); color: #ffffff;">
                <h6 class="modal-title fw-bold mb-0" id="modal-jurnal-title">
                    <i class="fas fa-file-invoice me-2 text-info"></i> Pendataan Jurnal Umum Rumah Sakit
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-jurnal-umum">
                @csrf
                <input type="hidden" name="jurnal_id" id="jurnal_id">

                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase">No. Bukti / Jurnal</label>
                            <input type="text" name="no_jurnal" id="no_jurnal" class="form-control mono-code" placeholder="Otomatis jika kosong">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase">Tanggal Jurnal</label>
                            <input type="date" name="tanggal_jurnal" id="tanggal_jurnal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase">Jenis Jurnal</label>
                            <select name="jenis_jurnal" id="jenis_jurnal" class="form-select" required>
                                <option value="UMUM">UMUM</option>
                                <option value="PENERIMAAN">PENERIMAAN</option>
                                <option value="PIUTANG">PIUTANG / PENJAMIN</option>
                                <option value="RETUR">RETUR</option>
                                <option value="PENYESUAIAN">PENYESUAIAN</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase">No. Referensi</label>
                            <input type="text" name="no_referensi" id="no_referensi" class="form-control mono-code" placeholder="No. Reg / Kwitansi / Retur">
                        </div>

                        <div class="col-md-9">
                            <label class="form-label small fw-bold text-uppercase">Uraian Transaksi</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Uraian lengkap transaksi rumah sakit..." required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase">Status Posting</label>
                            <select name="status_jurnal" id="status_jurnal" class="form-select">
                                <option value="POSTED">Posted</option>
                                <option value="DRAFT">Belum Diposting</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold small text-uppercase text-primary">
                            <i class="fas fa-balance-scale me-1"></i> Baris Akun Debit &amp; Kredit (Wajib Seimbang)
                        </span>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold" id="btn-tambah-baris-akun">
                            <i class="fas fa-plus me-1"></i> Tambah Baris Akun
                        </button>
                    </div>

                    <div class="table-responsive border rounded-3 mb-3" style="border-color: var(--ent-grid-border) !important;">
                        <table class="table table-sm align-middle mb-0" id="table-detail-jurnal">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 35%;">Akun (Kode &amp; Nama)</th>
                                    <th style="width: 23%;">Catatan Baris</th>
                                    <th style="width: 18%;" class="text-end">Debit (Rp)</th>
                                    <th style="width: 18%;" class="text-end">Kredit (Rp)</th>
                                    <th style="width: 6%;" class="text-center">Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-detail-jurnal"></tbody>
                        </table>
                    </div>

                    <div class="row g-2 align-items-center p-3 rounded-3" style="background: rgba(79, 70, 229, 0.05); border: 1px solid var(--ent-grid-border);">
                        <div class="col-md-4">
                            <span class="small fw-bold opacity-75 d-block">Total Debit</span>
                            <span class="fw-bold mono-code text-success fs-6" id="modal-total-debit">Rp 0</span>
                        </div>
                        <div class="col-md-4">
                            <span class="small fw-bold opacity-75 d-block">Total Kredit</span>
                            <span class="fw-bold mono-code text-danger fs-6" id="modal-total-kredit">Rp 0</span>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <span class="small fw-bold opacity-75 d-block">Keseimbangan</span>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1.5 fw-bold" id="modal-balance-badge">
                                BELUM SEIMBANG
                            </span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer py-3 px-4" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-ent-primary px-4 py-2" id="btn-simpan-jurnal">
                        <i class="fas fa-save me-1.5"></i> Simpan Jurnal
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
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const MASTER_AKUN = @json($akunList ?? []);
    let jurnalCache = [];

    function formatRupiah(num) {
        const val = Number(num || 0);
        return 'Rp ' + new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        }).format(val);
    }

    function formatAngka(num) {
        const val = Number(num || 0);
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        }).format(val);
    }

    function formatTanggalIndo(tglStr) {
        if (!tglStr) return '-';
        const parts = String(tglStr).slice(0, 10).split('-');
        if (parts.length !== 3) return tglStr;
        return `${parts[2]}/${parts[1]}/${parts[0]}`;
    }

    function akunOptionsHtml(selectedKode = '') {
        let opts = '<option value="">-- Pilih Akun --</option>';
        MASTER_AKUN.forEach(a => {
            const isSel = String(a.kode) === String(selectedKode) ? 'selected' : '';
            opts += `<option value="${a.kode}" data-nama="${a.nama}" ${isSel}>${a.kode} - ${a.nama}</option>`;
        });
        return opts;
    }

    function addDetailRow(row = {}) {
        const idx = $('#tbody-detail-jurnal tr').length;
        const kode = row.kode_akun || '';
        const catatan = row.catatan_baris || '';
        const debit = row.debit ? Number(row.debit) : '';
        const kredit = row.kredit ? Number(row.kredit) : '';

        const tr = `
            <tr>
                <td>
                    <select name="details[${idx}][kode_akun]" class="form-select form-select-sm detail-akun" required>
                        ${akunOptionsHtml(kode)}
                    </select>
                    <input type="hidden" name="details[${idx}][nama_akun]" class="detail-nama-akun" value="${row.nama_akun || ''}">
                </td>
                <td>
                    <input type="text" name="details[${idx}][catatan_baris]" class="form-control form-control-sm" value="${catatan}" placeholder="Catatan baris...">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" name="details[${idx}][debit]" class="form-control form-control-sm text-end mono-code detail-debit" value="${debit}" placeholder="0">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" name="details[${idx}][kredit]" class="form-control form-control-sm text-end mono-code detail-kredit" value="${kredit}" placeholder="0">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-2 btn-hapus-baris" title="Hapus Baris">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#tbody-detail-jurnal').append(tr);
        recalculateModalTotals();
    }

    function reindexDetailRows() {
        $('#tbody-detail-jurnal tr').each(function(i, tr) {
            $(tr).find('.detail-akun').attr('name', `details[${i}][kode_akun]`);
            $(tr).find('.detail-nama-akun').attr('name', `details[${i}][nama_akun]`);
            $(tr).find('input[name*="[catatan_baris]"]').attr('name', `details[${i}][catatan_baris]`);
            $(tr).find('.detail-debit').attr('name', `details[${i}][debit]`);
            $(tr).find('.detail-kredit').attr('name', `details[${i}][kredit]`);
        });
    }

    function recalculateModalTotals() {
        let totalDebit = 0;
        let totalKredit = 0;

        $('#tbody-detail-jurnal tr').each(function() {
            totalDebit += parseFloat($(this).find('.detail-debit').val()) || 0;
            totalKredit += parseFloat($(this).find('.detail-kredit').val()) || 0;
        });

        $('#modal-total-debit').text(formatRupiah(totalDebit));
        $('#modal-total-kredit').text(formatRupiah(totalKredit));

        const balanced = totalDebit > 0 && Math.round(totalDebit * 100) === Math.round(totalKredit * 100);
        const $badge = $('#modal-balance-badge');
        if (balanced) {
            $badge.attr('class', 'badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1.5 fw-bold')
                .text('BALANCED');
        } else {
            const diff = totalDebit - totalKredit;
            $badge.attr('class', 'badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1.5 fw-bold')
                .text('SELISIH: ' + formatRupiah(diff));
        }
    }

    function buildBalancedSidePanel(details = []) {
        const debitItems = (details || []).filter(d => Number(d.debit || 0) > 0);
        const kreditItems = (details || []).filter(d => Number(d.kredit || 0) > 0);

        const sumDebit = debitItems.reduce((acc, item) => acc + Number(item.debit || 0), 0);
        const sumKredit = kreditItems.reduce((acc, item) => acc + Number(item.kredit || 0), 0);

        const renderLines = (list, type) => {
            if (!list.length) {
                return `<div class="dk-line-item opacity-50 fst-italic">Tidak ada baris ${type}</div>`;
            }
            return list.map(d => {
                const nominal = type === 'debit' ? Number(d.debit || 0) : Number(d.kredit || 0);
                const colorClass = type === 'debit' ? 'text-success' : 'text-danger';
                return `
                    <div class="dk-line-item">
                        <div>
                            <div class="fw-bold"><span class="mono-code text-primary">${d.kode_akun}</span> • ${d.nama_akun}</div>
                            ${d.catatan_baris ? `<div class="small opacity-75">${d.catatan_baris}</div>` : ''}
                        </div>
                        <div class="mono-code ${colorClass} text-nowrap">${formatAngka(nominal)}</div>
                    </div>
                `;
            }).join('');
        };

        return `
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="dk-split-box">
                        <div class="dk-split-header-debit">
                            <span><i class="fas fa-arrow-right me-1"></i> SISI DEBIT (${debitItems.length} Akun)</span>
                            <span class="mono-code">${formatAngka(sumDebit)}</span>
                        </div>
                        <div>${renderLines(debitItems, 'debit')}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dk-split-box">
                        <div class="dk-split-header-kredit">
                            <span><i class="fas fa-arrow-left me-1"></i> SISI KREDIT (${kreditItems.length} Akun)</span>
                            <span class="mono-code">${formatAngka(sumKredit)}</span>
                        </div>
                        <div>${renderLines(kreditItems, 'kredit')}</div>
                    </div>
                </div>
            </div>
        `;
    }

    function loadDataJurnal() {
        const formData = $('#form-filter-jurnal').serialize();

        $('#tbody-jurnal-umum').html(`
            <tr>
                <td colspan="6" class="text-center py-4 fw-semibold opacity-75">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <br>Memuat data jurnal umum...
                </td>
            </tr>
        `);

        $.ajax({
            url: "{{ route('laporan_keuangan_jurnal_umum_data') }}",
            type: "POST",
            data: formData + "&_token={{ csrf_token() }}",
            success: function(res) {
                jurnalCache = res.data || [];
                const sum = res.summary || {};

                const totalBukti = Number(sum.jumlah_jurnal || jurnalCache.length || 0);
                const totalDebit = Number(sum.total_debit || 0);
                const totalKredit = Number(sum.total_kredit || 0);
                const selisih = totalDebit - totalKredit;

                const postedCount = jurnalCache.filter(x => String(x.status_jurnal).toUpperCase() === 'POSTED').length;

                $('#kpi-jumlah-bukti').text(`${totalBukti} Transaksi`);
                $('#kpi-status-posting').text(`${postedCount} / ${totalBukti} Posted`);
                $('#kpi-total-debit').text(formatRupiah(totalDebit));
                $('#kpi-total-kredit').text(formatRupiah(totalKredit));

                const isBalanced = Math.round(totalDebit * 100) === Math.round(totalKredit * 100);
                if (isBalanced) {
                    $('#kpi-keseimbangan')
                        .attr('class', 'jrn-kpi-value text-success d-flex align-items-center gap-2')
                        .html('<i class="fas fa-check-circle"></i> <span>BALANCED</span>');
                } else {
                    $('#kpi-keseimbangan')
                        .attr('class', 'jrn-kpi-value text-warning d-flex align-items-center gap-2')
                        .html(`<i class="fas fa-exclamation-triangle"></i> <span>${formatRupiah(selisih)}</span>`);
                }

                $('#footer-total-label').text(`TOTAL KESELURUHAN (${totalBukti} BUKTI JURNAL)`);
                $('#footer-total-debit').text(formatRupiah(totalDebit));
                $('#footer-total-kredit').text(formatRupiah(totalKredit));

                if (!jurnalCache.length) {
                    $('#tbody-jurnal-umum').html(`
                        <tr>
                            <td colspan="6" class="text-center py-4 fw-semibold opacity-75">
                                Belum ada bukti jurnal umum pada periode ini.
                            </td>
                        </tr>
                    `);
                    return;
                }

                let html = '';
                jurnalCache.forEach((j, idx) => {
                    const details = j.details || [];
                    const collapseId = `jrn-detail-${j.id}`;
                    const isPosted = String(j.status_jurnal).toUpperCase() === 'POSTED';

                    const statusBadge = isPosted
                        ? `<span class="pill-posted"><i class="fas fa-check-circle"></i> Posted</span>`
                        : `<span class="pill-belum-posted"><i class="far fa-clock"></i> Belum Diposting</span>`;

                    const actionBtn = !isPosted
                        ? `<button type="button" class="btn-lapor-pusat btn-posting-jurnal" data-id="${j.id}" data-no="${j.no_jurnal}">
                               <i class="fas fa-paper-plane"></i> Posting Jurnal
                           </button>`
                        : `<div class="d-flex gap-1 mt-1">
                               <button type="button" class="btn btn-xs btn-outline-primary rounded-2 px-2 py-0.5 btn-edit-jurnal" data-id="${j.id}" style="font-size: 0.7rem;" title="Edit">
                                   <i class="fas fa-pen"></i> Edit
                               </button>
                               <button type="button" class="btn btn-xs btn-outline-danger rounded-2 px-2 py-0.5 btn-hapus-jurnal" data-id="${j.id}" data-no="${j.no_jurnal}" style="font-size: 0.7rem;" title="Batalkan">
                                   <i class="fas fa-trash"></i>
                               </button>
                           </div>`;

                    const refLine = [
                        (j.jenis_jurnal || 'UMUM').toLowerCase(),
                        j.no_referensi ? j.no_referensi : null,
                        details.length ? `${details.length} baris` : null
                    ].filter(Boolean).join(' • ');

                    html += `
                        <tr class="jrn-main-row">
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn-expand-jrn" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}" title="Lihat Rincian Debit & Kredit">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                    <div>
                                        <span class="jrn-seq-badge">#${idx + 1}</span>
                                        <div class="fw-bold small">${formatTanggalIndo(j.tanggal_jurnal)}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="jrn-bukti-link btn-edit-jurnal" data-id="${j.id}">${j.no_jurnal}</a>
                                <div class="small opacity-75 mt-0.5">${refLine}</div>
                            </td>
                            <td>
                                <div>${statusBadge}</div>
                                <div>${actionBtn}</div>
                            </td>
                            <td>
                                <div class="fw-bold" style="font-size: 0.84rem;">${j.keterangan}</div>
                                <div class="small opacity-75 mt-1 d-flex flex-wrap align-items-center gap-2">
                                    <span><i class="fas fa-hospital-user me-1"></i>Jenis: <strong>${j.jenis_jurnal || 'UMUM'}</strong></span>
                                    <span>•</span>
                                    <span><i class="fas fa-user me-1"></i>User: <strong>${j.user_id || '-'}</strong></span>
                                    <span>•</span>
                                    <span>${details.length} Akun</span>
                                </div>
                            </td>
                            <td class="td-debit-col">${formatAngka(j.total_debit)}</td>
                            <td class="td-kredit-col">${formatAngka(j.total_kredit)}</td>
                        </tr>
                        <tr class="collapse jrn-detail-row" id="${collapseId}">
                            <td colspan="6">
                                ${buildBalancedSidePanel(details)}
                            </td>
                        </tr>
                    `;
                });

                $('#tbody-jurnal-umum').html(html);
            },
            error: function() {
                $('#tbody-jurnal-umum').html(`
                    <tr>
                        <td colspan="6" class="text-center text-danger fw-bold py-4">
                            Gagal memuat data jurnal umum dari server.
                        </td>
                    </tr>
                `);
            }
        });
    }

    $(document).ready(function() {
        loadDataJurnal();

        $('#form-filter-jurnal').on('submit', function(e) {
            e.preventDefault();
            loadDataJurnal();
        });

        $('#btn-buka-modal-jurnal').on('click', function() {
            $('#modal-jurnal-title').html('<i class="fas fa-file-invoice me-2 text-info"></i> Pendataan Jurnal Umum Rumah Sakit');
            $('#form-jurnal-umum')[0].reset();
            $('#jurnal_id').val('');
            $('#tanggal_jurnal').val("{{ date('Y-m-d') }}");
            $('#status_jurnal').val('POSTED');
            $('#tbody-detail-jurnal').empty();
            addDetailRow();
            addDetailRow();
            $('#modal-jurnal-umum').modal('show');
        });

        $('#btn-tambah-baris-akun').on('click', function() {
            addDetailRow();
        });

        $(document).on('click', '.btn-hapus-baris', function() {
            if ($('#tbody-detail-jurnal tr').length <= 2) {
                Swal.fire('Informasi', 'Jurnal minimal memiliki 2 baris akun.', 'info');
                return;
            }
            $(this).closest('tr').remove();
            reindexDetailRows();
            recalculateModalTotals();
        });

        $(document).on('change', '.detail-akun', function() {
            const nama = $(this).find('option:selected').data('nama') || '';
            $(this).closest('tr').find('.detail-nama-akun').val(nama);
        });

        $(document).on('input', '.detail-debit, .detail-kredit', function() {
            recalculateModalTotals();
        });

        $(document).on('click', '.btn-edit-jurnal', function() {
            const id = Number($(this).data('id'));
            const item = jurnalCache.find(x => Number(x.id) === id);
            if (!item) return;

            $('#modal-jurnal-title').html('<i class="fas fa-pen me-2 text-warning"></i> Edit Jurnal Umum : ' + item.no_jurnal);
            $('#jurnal_id').val(item.id);
            $('#no_jurnal').val(item.no_jurnal);
            $('#tanggal_jurnal').val(item.tanggal_jurnal);
            $('#jenis_jurnal').val(item.jenis_jurnal);
            $('#no_referensi').val(item.no_referensi || '');
            $('#keterangan').val(item.keterangan);
            $('#status_jurnal').val(String(item.status_jurnal).toUpperCase() === 'POSTED' ? 'POSTED' : 'DRAFT');

            $('#tbody-detail-jurnal').empty();
            if (item.details && item.details.length) {
                item.details.forEach(d => addDetailRow(d));
            } else {
                addDetailRow();
                addDetailRow();
            }
            $('#modal-jurnal-umum').modal('show');
        });

        $(document).on('click', '.btn-posting-jurnal', function() {
            const id = Number($(this).data('id'));
            const no = $(this).data('no');
            const item = jurnalCache.find(x => Number(x.id) === id);
            if (!item || !item.details || !item.details.length) return;

            Swal.fire({
                title: 'Posting Jurnal?',
                text: `Jurnal ${no} akan diposting dengan status POSTED.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Ya, Posting',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: "{{ route('laporan_keuangan_jurnal_umum_store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        jurnal_id: item.id,
                        no_jurnal: item.no_jurnal,
                        tanggal_jurnal: item.tanggal_jurnal,
                        jenis_jurnal: item.jenis_jurnal,
                        no_referensi: item.no_referensi,
                        keterangan: item.keterangan,
                        status_jurnal: 'POSTED',
                        details: item.details
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Berhasil!', res.message, 'success');
                            loadDataJurnal();
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Gagal memposting jurnal.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });

        $('#form-jurnal-umum').on('submit', function(e) {
            e.preventDefault();
            reindexDetailRows();

            let totalDebit = 0;
            let totalKredit = 0;
            $('#tbody-detail-jurnal tr').each(function() {
                totalDebit += parseFloat($(this).find('.detail-debit').val()) || 0;
                totalKredit += parseFloat($(this).find('.detail-kredit').val()) || 0;
            });

            if (totalDebit <= 0 || Math.round(totalDebit * 100) !== Math.round(totalKredit * 100)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Jurnal Tidak Seimbang',
                    text: 'Pastikan Total Debit sama dengan Total Kredit dan lebih besar dari 0.'
                });
                return;
            }

            const $btn = $('#btn-simpan-jurnal');
            const origHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1.5"></i> Menyimpan...');

            $.ajax({
                url: "{{ route('laporan_keuangan_jurnal_umum_store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    $btn.prop('disabled', false).html(origHtml);
                    if (res.success) {
                        $('#modal-jurnal-umum').modal('hide');
                        Swal.fire('Berhasil!', res.message, 'success');
                        loadDataJurnal();
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).html(origHtml);
                    const msg = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message
                        : 'Terjadi kesalahan saat menyimpan jurnal.';
                    Swal.fire('Error', msg, 'error');
                }
            });
        });

        $(document).on('click', '.btn-hapus-jurnal', function() {
            const id = $(this).data('id');
            const no = $(this).data('no');

            Swal.fire({
                title: 'Batalkan Jurnal?',
                text: `Entri jurnal ${no} akan ditandai BATAL.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('laporan_keuangan_jurnal_umum_delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire('Berhasil!', res.message, 'success');
                                loadDataJurnal();
                            } else {
                                Swal.fire('Gagal', res.message, 'error');
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
