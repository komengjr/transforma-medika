@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (PEMBELIAN BARANG)
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

    /* Form Controls */
    .ent-form-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
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

    .ent-form .form-control,
    .ent-form .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
    }

    .ent-form .form-control:not(textarea),
    .ent-form .form-select {
        height: 40px !important;
    }

    .ent-form .form-control[readonly] {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .ent-form .form-control:focus,
    .ent-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-form .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .ent-form .input-group>.input-group-text:first-child {
        border-right: none !important;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .ent-form .input-group>.input-group-text:last-child {
        border-left: none !important;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .ent-form .input-group>.form-control:not(:first-child) {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .ent-form .input-group>.form-control:not(:last-child) {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    /* Interactive Radio Cards (Aset vs Non-Aset) */
    .card-radio {
        border: 1.5px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: var(--bs-body-bg);
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .card-radio:hover {
        background-color: rgba(79, 70, 229, 0.05);
        border-color: rgba(79, 70, 229, 0.55);
    }

    .card-radio.active-radio-card {
        border-color: var(--ent-indigo) !important;
        background-color: rgba(79, 70, 229, 0.07);
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.12);
    }

    /* Dynamic Sub-Panels */
    .ent-sub-panel {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 16px;
    }

    /* Total Summary Box */
    .ent-total-box {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(79, 70, 229, 0.08));
        border: 1px solid rgba(245, 158, 11, 0.4);
        border-radius: 12px;
        padding: 14px 18px;
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
        padding: 12px;
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
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-cart-plus fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-boxes me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} PROCUREMENT
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Pengadaan &amp; Pembelian Barang</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Pengadaan &amp; Pembelian Barang</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pencatatan transaksi pembelian barang operasional dan inventaris koperasi.</p>
                        </div>
                    </div>

                    <div class="col-lg-5 d-flex align-items-center justify-content-lg-end gap-2 flex-wrap">
                        <button type="button" class="btn ent-btn ent-btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalListBarang" id="btn-buka-list">
                            <i class="fas fa-table me-1"></i> Data List Barang
                        </button>
                        <span class="ent-badge px-3 py-2" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-family: 'JetBrains Mono', monospace; font-size: 0.74rem;">
                            <i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM PENGADAAN & PEMBELIAN BARANG -->
<form id="form-pembelian" method="POST" action="#" class="ent-form">
    @csrf
    <div class="row g-3">

        <!-- PANEL KIRI: DATA TRANSAKSI -->
        <div class="col-lg-5">
            <div class="ent-card ent-table-surface">
                <div class="card-header py-3 px-3 px-md-4">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-file-invoice text-primary me-2"></i>Informasi Utama Pembelian
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <!-- Nomor Bukti & Tanggal -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label ent-form-label">No. Transaksi / Invoice</label>
                            <input type="text" class="form-control fw-bold" value="PO-{{ date('Ymd') }}-XXXX" style="font-family: 'JetBrains Mono', monospace;" readonly>
                            <div class="form-text opacity-75" style="font-size: 0.7rem;">Otomatis dari sistem backend</div>
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_beli" class="form-label ent-form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" id="tgl_beli" name="tgl_beli" class="form-control" value="{{ date('Y-m-d') }}" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>
                    </div>

                    <!-- Vendor / Supplier -->
                    <div class="mb-3">
                        <label for="supplier" class="form-label ent-form-label">Nama Supplier / Vendor <span class="text-danger">*</span></label>
                        <input type="text" id="supplier" name="supplier" class="form-control" placeholder="Contoh: PT. Sumber Makmur atau Toko ATK Jaya" required>
                    </div>

                    <hr class="my-4" style="border-color: var(--ent-grid-border); opacity: 1;">

                    <!-- PENGATURAN KEUANGAN & AKUNTANSI -->
                    <h6 class="fw-bold mb-3 small text-uppercase">
                        <i class="fas fa-coins text-success me-2"></i>Alokasi Dana &amp; Jurnal
                    </h6>

                    <!-- Pilihan COA Pembayaran -->
                    <div class="mb-3">
                        <label for="coa_pembayaran" class="form-label ent-form-label">Sumber Dana / Metode Pembayaran <span class="text-danger">*</span></label>
                        <select id="coa_pembayaran" name="coa_pembayaran" class="form-select" required>
                            <option value="">-- Pilih Rekening Pembayaran --</option>
                            @foreach($coas as $coa)
                            <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text opacity-75" style="font-size: 0.7rem;">Akun Kredit pada pembukuan jurnal.</div>
                    </div>

                    <!-- Keterangan Jurnal -->
                    <div class="mb-0">
                        <label for="keterangan" class="form-label ent-form-label">Keterangan Tambahan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Contoh: Pembelian Laptop Inventaris Cabang Baru..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL KANAN: RINCIAN BARANG & KATEGORI ASET -->
        <div class="col-lg-7">
            <div class="ent-card ent-table-surface h-100">
                <div class="card-header py-3 px-3 px-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-box-open text-success me-2"></i>Detail Item &amp; Spesifikasi Kategori
                    </h6>
                    <span class="ent-badge" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35);">
                        Kategorisasi Barang
                    </span>
                </div>
                <div class="card-body p-3 p-md-4">

                    <!-- Pilihan Kategori Krusial (Aset vs Bukan Aset) -->
                    <div class="mb-4">
                        <label class="form-label ent-form-label d-block mb-2">
                            <i class="fas fa-question-circle text-primary me-1"></i> Bagaimana Barang Ini Diklasifikasikan?
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card-radio active-radio-card h-100 p-3">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="kategori_barang" id="kat_aset" value="ASET" checked>
                                        <label class="form-check-label fw-bold small" for="kat_aset" style="cursor: pointer;">
                                            <i class="fas fa-building text-primary me-1"></i> MASUK DALAM ASET
                                        </label>
                                        <p class="opacity-75 mb-0 small mt-1" style="font-size: 0.74rem; line-height: 1.45;">
                                            Untuk barang dengan masa manfaat panjang (&gt; 1 tahun) &amp; nilai tinggi. Sistem otomatis mengaktifkan modul depresiasi/penyusutan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-radio h-100 p-3">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="kategori_barang" id="kat_non_aset" value="NON_ASET">
                                        <label class="form-check-label fw-bold small" for="kat_non_aset" style="cursor: pointer;">
                                            <i class="fas fa-file-alt opacity-75 me-1"></i> TIDAK DIMASUKKAN ASET
                                        </label>
                                        <p class="opacity-75 mb-0 small mt-1" style="font-size: 0.74rem; line-height: 1.45;">
                                            Untuk barang habis pakai (ATK, perlengkapan, konsumsi) atau bernilai kecil yang langsung dibebankan pada bulan berjalan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NAMA & RINCIAN FISIK BARANG -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label for="nama_barang" class="form-label ent-form-label">Nama / Spesifikasi Barang <span class="text-danger">*</span></label>
                            <input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="Contoh: Asus ExpertBook Core i5 atau Kertas A4 Sinar Dunia" required>
                        </div>
                        <div class="col-md-4">
                            <label for="satuan" class="form-label ent-form-label">Satuan <span class="text-danger">*</span></label>
                            <select id="satuan" name="satuan" class="form-select text-center" required>
                                <option value="Unit">Unit / Pcs</option>
                                <option value="Rim">Rim</option>
                                <option value="Box">Box</option>
                                <option value="Paket">Paket</option>
                            </select>
                        </div>
                    </div>

                    <!-- HARGA & KUANTITAS -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="qty" class="form-label ent-form-label">Kuantitas (Qty) <span class="text-danger">*</span></label>
                            <input type="number" id="qty" name="qty" class="form-control text-center fw-bold" min="1" value="1" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>
                        <div class="col-md-8">
                            <label for="harga_satuan" class="form-label ent-form-label">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="harga_satuan" name="harga_satuan" class="form-control text-end fw-bold" min="0" placeholder="0" style="font-family: 'JetBrains Mono', monospace;" required>
                            </div>
                        </div>
                    </div>

                    <!-- SUB-PANEL DINAMIS KHUSUS JIKA KATEGORI = ASET -->
                    <div id="section-detail-aset" class="ent-sub-panel mb-4">
                        <h6 class="fw-bold text-primary mb-3 small text-uppercase">
                            <i class="fas fa-calculator me-2"></i>Konfigurasi Depresiasi Aktiva Tetap
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="coa_aset" class="form-label ent-form-label">Target Akun Aset (COA) <span class="text-danger">*</span></label>
                                <select id="coa_aset" name="coa_aset" class="form-select">
                                    <option value="">-- Pilih COA Aset Tetap --</option>
                                    @foreach($coas as $coa)
                                    <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text opacity-75" style="font-size: 0.7rem;">Akun Debit Neraca (misal: 1210 - Inventaris Kantor)</div>
                            </div>
                            <div class="col-md-6">
                                <label for="umur_ekonomis" class="form-label ent-form-label">Umur Ekonomis (Masa Manfaat)</label>
                                <div class="input-group">
                                    <input type="number" id="umur_ekonomis" name="umur_ekonomis" class="form-control fw-bold" min="1" value="4" style="font-family: 'JetBrains Mono', monospace;">
                                    <span class="input-group-text">Tahun</span>
                                </div>
                                <div class="form-text opacity-75" style="font-size: 0.7rem;">Estimasi durasi penyusutan barang</div>
                            </div>
                        </div>
                    </div>

                    <!-- SUB-PANEL DINAMIS KHUSUS JIKA KATEGORI = BUKAN ASET -->
                    <div id="section-detail-non-aset" class="ent-sub-panel mb-4 d-none">
                        <h6 class="fw-bold mb-3 small text-uppercase">
                            <i class="fas fa-file-invoice-dollar text-warning me-2"></i>Pembebanan Biaya Operasional
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="coa_beban" class="form-label ent-form-label">Target Akun Beban / Perlengkapan (COA) <span class="text-danger">*</span></label>
                                <select id="coa_beban" name="coa_beban" class="form-select">
                                    <option value="">-- Pilih COA Beban / Perlengkapan --</option>
                                    @foreach($coas as $coa)
                                    <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text opacity-75" style="font-size: 0.7rem;">Akun Debit Laba Rugi (misal: 5102 - Biaya ATK / 1140 - Perlengkapan)</div>
                            </div>
                        </div>
                    </div>

                    <!-- KOTAK RINGKASAN TOTAL -->
                    <div class="ent-total-box mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <span class="fw-bold text-uppercase small">
                            <i class="fas fa-tag me-2 text-warning"></i>Total Kewajiban Bayar
                        </span>
                        <span id="label-total-bayar" class="fw-bold fs-4 text-success" style="font-family: 'JetBrains Mono', monospace;">Rp 0</span>
                    </div>

                    <!-- TOMBOL SUBMIT -->
                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                        <button type="reset" class="btn ent-btn btn-secondary px-4 py-2" id="btn-reset-pembelian">
                            <i class="fas fa-undo me-1"></i> Reset Form
                        </button>
                        <button type="button" id="btn-simpan-pembelian" class="btn ent-btn ent-btn-success px-4 py-2">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Simpan &amp; Bukukan Jurnal
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</form>

<!-- MODAL POP-UP BOOTSTRAP 5 UNTUK LIST BARANG -->
<div class="modal fade" id="modalListBarang" tabindex="-1" aria-labelledby="modalListBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="ent-badge mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.62rem;">
                        <i class="fas fa-history me-1"></i> ARSIP PENGADAAN &amp; INVENTARIS
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0" id="modalListBarangLabel">
                        Riwayat &amp; List Pembelian Barang
                    </h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom align-middle m-0 w-100" id="tabel-list-barang">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 15%">Kode Transaksi</th>
                                <th style="width: 12%">Tanggal</th>
                                <th style="width: 16%">Supplier</th>
                                <th>Nama Barang</th>
                                <th class="text-center" style="width: 12%">Kategori</th>
                                <th class="text-center" style="width: 8%">Qty</th>
                                <th class="text-end" style="width: 15%">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody id="body-list-barang" class="text-center">
                            <tr>
                                <td colspan="8" class="opacity-75 py-4">Memuat data transaksi...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer px-4 py-3" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rupiahFormatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        const radioAset = document.getElementById('kat_aset');
        const radioNonAset = document.getElementById('kat_non_aset');

        const sectionAset = document.getElementById('section-detail-aset');
        const sectionNonAset = document.getElementById('section-detail-non-aset');

        const inputQty = document.getElementById('qty');
        const inputHarga = document.getElementById('harga_satuan');
        const labelTotal = document.getElementById('label-total-bayar');

        const selectCoaAset = document.getElementById('coa_aset');
        const selectCoaBban = document.getElementById('coa_beban');

        // 1. Toggling Sub-Panel Kategori (Aset vs Non-Aset)
        radioAset.addEventListener('change', toggleCategoryPanels);
        radioNonAset.addEventListener('change', toggleCategoryPanels);

        function updateRadioCardHighlight() {
            document.querySelectorAll('.card-radio').forEach(c => c.classList.remove('active-radio-card'));
            if (radioAset.checked) {
                radioAset.closest('.card-radio').classList.add('active-radio-card');
            } else {
                radioNonAset.closest('.card-radio').classList.add('active-radio-card');
            }
        }

        function toggleCategoryPanels() {
            updateRadioCardHighlight();
            if (radioAset.checked) {
                sectionAset.classList.remove('d-none');
                sectionNonAset.classList.add('d-none');

                selectCoaAset.required = true;
                selectCoaBban.required = false;
                selectCoaBban.value = "";
            } else {
                sectionAset.classList.add('d-none');
                sectionNonAset.classList.remove('d-none');

                selectCoaAset.required = false;
                selectCoaBban.required = true;
                selectCoaAset.value = "";
            }
        }

        toggleCategoryPanels();

        // 2. Kalkulasi Real-time Total Bayar (Qty * Harga Satuan)
        inputQty.addEventListener('input', hitungTotal);
        inputHarga.addEventListener('input', hitungTotal);

        function hitungTotal() {
            const qty = parseFloat(inputQty.value) || 0;
            const harga = parseFloat(inputHarga.value) || 0;
            const total = qty * harga;

            labelTotal.innerText = rupiahFormatter.format(total);
        }

        // 3. Efek Visual Klik pada Card Radio
        document.querySelectorAll('.card-radio').forEach(card => {
            card.addEventListener('click', function() {
                const radioInput = this.querySelector('input[type="radio"]');
                radioInput.checked = true;
                radioInput.dispatchEvent(new Event('change'));
            });
        });

        // Reset handler
        document.getElementById('form-pembelian').addEventListener('reset', function() {
            setTimeout(() => {
                labelTotal.innerText = "Rp 0";
                toggleCategoryPanels();
            }, 10);
        });

        // 4. Validasi & Submit Data Menggunakan AJAX Fetch
        const btnSimpan = document.getElementById('btn-simpan-pembelian');
        btnSimpan.addEventListener('click', function() {
            const form = document.getElementById('form-pembelian');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Simpan & Bukukan Jurnal?',
                text: 'Pastikan seluruh data pembelian barang sudah valid sebelum dibukukan ke jurnal keuangan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan & Bukukan',
                cancelButtonText: 'Batal'
            }).then((confirmResult) => {
                if (!confirmResult.isConfirmed) return;

                btnSimpan.disabled = true;
                btnSimpan.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyimpan...`;

                const payload = {
                    tgl_beli: document.getElementById('tgl_beli').value,
                    supplier: document.getElementById('supplier').value,
                    coa_pembayaran: document.getElementById('coa_pembayaran').value,
                    keterangan: document.getElementById('keterangan').value,
                    kategori: document.querySelector('input[name="kategori_barang"]:checked').value,
                    nama_barang: document.getElementById('nama_barang').value,
                    satuan: document.getElementById('satuan').value,
                    qty: inputQty.value,
                    harga_satuan: inputHarga.value,
                    coa_aset: selectCoaAset.value,
                    umur_ekonomis: document.getElementById('umur_ekonomis').value,
                    coa_beban: selectCoaBban.value
                };

                fetch(`{{ route('menu_koperasi_pembelian_barang_save') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal memproses ke server.');
                        return res.json();
                    })
                    .then(data => {
                        btnSimpan.disabled = false;
                        btnSimpan.innerHTML = `<i class="fas fa-cloud-upload-alt me-1"></i> Simpan & Bukukan Jurnal`;

                        if (data.status === 'success') {
                            Swal.fire('Berhasil!', `Pembelian barang berhasil dicatat.\nNomor Jurnal Terbentuk: ${data.jurnal_no}`, 'success');
                            form.reset();
                        } else {
                            Swal.fire('Gagal', data.message || 'Gagal menyimpan data pembelian.', 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Terjadi error jaringan atau server gagal membuat jurnal pembukuan.', 'error');
                        btnSimpan.disabled = false;
                        btnSimpan.innerHTML = `<i class="fas fa-cloud-upload-alt me-1"></i> Simpan & Bukukan Jurnal`;
                    });
            });
        });

        // 5. Load Riwayat List Barang pada Modal
        document.getElementById('btn-buka-list').addEventListener('click', function() {
            const tbody = document.getElementById('body-list-barang');
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4"><span class="spinner-border spinner-border-sm me-2"></span> Mengambil data riwayat koperasi...</td></tr>`;

            fetch(`{{ route('menu_koperasi_pembelian_barang_get_data') }}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Respon server bermasalah');
                    }
                    return res.json();
                })
                .then(data => {
                    tbody.innerHTML = '';
                    if (!data || data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="8" class="opacity-75 py-4">Belum ada data pembelian barang tercatat.</td></tr>`;
                        return;
                    }

                    const formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    });

                    data.forEach((item, index) => {
                        const badgeKat = item.kategori === 'ASET' ?
                            `<span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);"><i class="fas fa-building me-1"></i> ASET</span>` :
                            `<span class="ent-badge" style="background: rgba(100, 116, 139, 0.14); color: var(--bs-secondary-color, #64748b); border: 1px solid var(--ent-grid-border);"><i class="fas fa-file-alt me-1"></i> NON ASET</span>`;

                        const row = `
                            <tr>
                                <td class="fw-bold opacity-75" style="font-family: 'JetBrains Mono', monospace;">${index + 1}</td>
                                <td class="text-primary fw-bold" style="font-family: 'JetBrains Mono', monospace;">${item.pembelian_code}</td>
                                <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">${item.tgl_beli}</td>
                                <td class="text-start fw-semibold">${item.supplier}</td>
                                <td class="text-start fw-bold">${item.nama_barang} <span class="opacity-75 fw-normal small">(${item.satuan})</span></td>
                                <td>${badgeKat}</td>
                                <td class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">${item.qty}</td>
                                <td class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">${formatter.format(item.total_harga)}</td>
                            </tr>
                        `;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch(err => {
                    console.error(err);
                    tbody.innerHTML = `<tr><td colspan="8" class="text-danger py-4">Gagal memuat data dari server. Silakan coba lagi.</td></tr>`;
                });
        });
    });
</script>
@endsection
