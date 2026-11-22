@extends('layouts.layouts')

@section('base.css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (PENAGIHAN CICILAN)
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
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
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
        background-color: var(--ent-surface);
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
    .ent-form .form-select,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--ent-text) !important;
        background-color: var(--ent-surface) !important;
        font-size: 0.82rem !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
    }

    .form-select:not(.form-select-sm) {
        height: 40px !important;
    }

    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* =========================================================
       SELECT2 SOLID BACKGROUND FIX (ANTI TRANSPARAN)
       ========================================================= */
    .select2-container {
        z-index: 1050;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        min-height: 40px !important;
        display: flex;
        align-items: center;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-surface) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: var(--ent-text) !important;
        padding-left: 10px !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
        color: #64748b !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown,
    .select2-dropdown {
        background-color: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #6366f1 !important;
        border-radius: 10px !important;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.2) !important;
        font-size: 0.82rem !important;
        z-index: 1065 !important;
        opacity: 1 !important;
    }

    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-dropdown,
    [data-bs-theme="dark"] .select2-dropdown,
    .dark .select2-container--bootstrap-5 .select2-dropdown,
    .dark .select2-dropdown {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border-color: rgba(99, 102, 241, 0.45) !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field,
    .select2-container--open .select2-search--dropdown .select2-search__field {
        background-color: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        opacity: 1 !important;
    }

    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field,
    [data-bs-theme="dark"] .select2-container--open .select2-search--dropdown .select2-search__field,
    .dark .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field,
    .dark .select2-container--open .select2-search--dropdown .select2-search__field {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    .select2-results__options {
        background-color: #ffffff !important;
        color: #0f172a !important;
        opacity: 1 !important;
    }

    [data-bs-theme="dark"] .select2-results__options,
    .dark .select2-results__options {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option,
    .select2-results__option {
        background-color: #ffffff !important;
        color: #0f172a !important;
        padding: 8px 12px !important;
        opacity: 1 !important;
    }

    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option,
    [data-bs-theme="dark"] .select2-results__option,
    .dark .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option,
    .dark .select2-results__option {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option--highlighted,
    .select2-results__option--highlighted[aria-selected] {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
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

    .badge-status-lunas {
        background-color: rgba(16, 185, 129, 0.16) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.38);
    }

    .badge-status-partial {
        background-color: rgba(2, 132, 199, 0.16) !important;
        color: #0284c7 !important;
        border: 1px solid rgba(2, 132, 199, 0.38);
    }

    .badge-status-pending {
        background-color: rgba(217, 119, 6, 0.16) !important;
        color: #d97706 !important;
        border: 1px solid rgba(217, 119, 6, 0.38);
    }

    /* Contract Summary Box */
    .ent-nota-box {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(56, 189, 248, 0.08));
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px;
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
        color: var(--ent-text) !important;
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

    .table-custom tbody tr.row-lunas td {
        background-color: rgba(16, 185, 129, 0.06) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--ent-text) !important;
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

    .ent-detail-table td {
        padding: 7px 0;
        font-size: 0.82rem;
        border: none !important;
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
                    <div class="col-lg-9 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-hand-holding-usd fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-wallet me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} BILLING
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Penagihan &amp; Pelunasan</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Penagihan &amp; Pelunasan Cicilan</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Penerimaan setoran uang angsuran barang dari peserta koperasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- DROP DOWN FILTER NOTA -->
    <div class="col-12">
        <div class="ent-card ent-table-surface p-3 p-md-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label class="form-label ent-form-label">Pilih Kontrak Nota Anggota Aktif</label>
                    <select class="form-select select2-nota" name="pembelian_id" id="filter_pembelian_id" data-placeholder="-- Pilih Nota Pembelian / Nama Anggota --">
                        <option value=""></option>
                        @foreach($listNota as $n)
                        <option value="{{ $n->id_pembelian }}">{{ $n->nota_nomor }} - {{ $n->kop_master_peserta_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="button" class="btn ent-btn btn-secondary py-2" id="btn-reset-filter">
                        <i class="fas fa-undo me-1"></i> Reset Pencarian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- WRAPPER KONTEN DINAMIS (Awalnya Tersembunyi) -->
    <div class="col-12 d-none" id="section-detail-penagihan">
        <div class="row g-3">
            <!-- PANEL RESUME KONTRAK & PILIHAN KAS -->
            <div class="col-md-4">
                <div class="ent-card ent-table-surface mb-3">
                    <div class="card-header py-3 px-3 px-md-4">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="fas fa-file-contract text-primary me-2"></i>Detail Kontrak
                        </h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="ent-nota-box mb-3 text-center">
                            <small class="opacity-75 d-block fw-bold text-uppercase" style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem;">NOMOR NOTA</small>
                            <span class="fw-bold text-primary" id="res-nota" style="font-family: 'JetBrains Mono', monospace; font-size: 1.15rem;">-</span>
                        </div>
                        <table class="table ent-detail-table mb-0 w-100">
                            <tr>
                                <td width="42%" class="opacity-75">Nama Peserta</td>
                                <td width="4%">:</td>
                                <td class="fw-bold" id="res-nama">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Kode Peserta</td>
                                <td>:</td>
                                <td class="fw-semibold" style="font-family: 'JetBrains Mono', monospace;" id="res-kode">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Barang</td>
                                <td>:</td>
                                <td class="fw-semibold" id="res-barang">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Harga Beli</td>
                                <td>:</td>
                                <td class="fw-bold" style="font-family: 'JetBrains Mono', monospace;" id="res-harga-beli">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Biaya Admin</td>
                                <td>:</td>
                                <td class="opacity-75" style="font-family: 'JetBrains Mono', monospace;" id="res-biaya-admin">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Bunga Koperasi</td>
                                <td>:</td>
                                <td class="text-warning fw-bold" style="font-family: 'JetBrains Mono', monospace;" id="res-bunga-koperasi">-</td>
                            </tr>
                            <tr style="border-top: 1px solid var(--ent-grid-border) !important;">
                                <td class="opacity-75 fw-bold pt-2">Total Piutang</td>
                                <td class="pt-2">:</td>
                                <td class="text-primary fw-bold pt-2" style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem;" id="res-total">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Cicilan / Bln</td>
                                <td>:</td>
                                <td class="text-success fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem;" id="res-cicilan">-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="ent-card ent-table-surface">
                    <div class="card-header py-3 px-3 px-md-4">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="fas fa-university text-primary me-2"></i>Destinasi Pembayaran
                        </h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <label class="form-label ent-form-label">Simpan Uang Masuk Ke <span class="text-danger">*</span></label>
                        <select class="form-select" id="sumber_dana_coa_pembayaran">
                            <option value="">Pilih Dulu</option>
                            @foreach($bankCoa as $coa)
                            <option value="{{ $coa->coa_code }}">[{{ $coa->coa_code }}] {{ $coa->coa_name }}</option>
                            @endforeach
                        </select>
                        <small class="opacity-75 mt-2 d-block" style="font-size: 0.7rem;">Akun Kas/Bank ini digunakan sebagai posisi Debet saat jurnal diterbitkan.</small>
                    </div>
                </div>
            </div>

            <!-- PANEL TABEL TENOR JADWAL -->
            <div class="col-md-8">
                <div class="ent-card ent-table-surface h-100">
                    <div class="card-header py-3 px-3 px-md-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="fas fa-list-ol text-warning me-2"></i>Daftar Angsuran Bulanan
                        </h6>
                        <span class="ent-badge" style="background: rgba(56, 189, 248, 0.16); color: #0284c7; border: 1px solid rgba(56, 189, 248, 0.35); font-family: 'JetBrains Mono', monospace;" id="res-tenor-badge">0 Bulan</span>
                    </div>
                    <div class="card-body ent-card-body-flush">
                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0 w-100" id="table-jadwal-cicilan">
                                <thead>
                                    <tr>
                                        <th>Angsuran</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end">Pokok</th>
                                        <th class="text-end">Bunga</th>
                                        <th class="text-end">Total Tagihan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Diisi secara dinamis via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PLACEHOLDER STATE KOSONG -->
    <div class="col-12" id="section-placeholder-kosong">
        <div class="ent-card ent-table-surface py-5 text-center">
            <div class="card-body py-4">
                <i class="fas fa-search-dollar fa-3x mb-3 opacity-50 text-primary"></i>
                <h5 class="fw-bold mb-1">Silahkan pilih nomor nota pembiayaan peserta terlebih dahulu.</h5>
                <p class="mb-0 small opacity-75">Sistem akan memuat rincian data cicilan melalui API backend secara terpisah.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('.select2-nota').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });

        // Helper Format Currency Rupiah
        function formatRupiah(angka) {
            if (angka === null || angka === undefined) return 'Rp 0';
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
        }

        // Helper Format Tanggal Indonesia
        function formatTanggal(stringTanggal) {
            if (!stringTanggal) return '-';
            let date = new Date(stringTanggal);
            if (isNaN(date.getTime())) return stringTanggal;
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Event handler ketika dropdown nota dipilih
        $('#filter_pembelian_id').on('change', function() {
            let id = $(this).val();
            if (!id) {
                resetView();
                return;
            }

            Swal.fire({
                title: 'Memuat Data...',
                text: 'Sedang mengambil informasi rincian tenor angsuran',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX Call ke Controller Method Get Data
            $.ajax({
                url: `{{ url('koperasi/menu-koperasi/penagihan-barang-anggota/get-data') }}/${id}`,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        let kontrak = response.kontrak;
                        let jadwal = response.jadwal;

                        // 1. Render Resume Data Kontrak
                        $('#res-nota').text(kontrak.nota_nomor ?? '-');
                        $('#res-nama').text(kontrak.kop_master_peserta_name ?? '-');
                        $('#res-kode').text(kontrak.kop_master_peserta_code ?? '-');
                        $('#res-barang').text(kontrak.barang_nama ?? '-');
                        $('#res-harga-beli').text(formatRupiah(kontrak.harga_beli));
                        $('#res-biaya-admin').text(formatRupiah(kontrak.biaya_admin));
                        $('#res-bunga-koperasi').text(formatRupiah(kontrak.bunga_koperasi));
                        $('#res-total').text(formatRupiah(kontrak.total_piutang));
                        $('#res-cicilan').text(formatRupiah(kontrak.cicilan_per_bulan));
                        $('#res-tenor-badge').text((kontrak.tenor_bulan ?? 0) + ' Bulan');

                        // 2. Render Baris Tabel Jadwal Cicilan
                        let html = '';
                        if (jadwal && jadwal.length > 0) {
                            jadwal.forEach(function(row) {
                                let isLunas = (row.status_bayar === 'LUNAS');
                                let rowClass = isLunas ? 'row-lunas' : '';
                                let badgeClass = isLunas ? 'badge-status-lunas' : (row.status_bayar === 'PARTIAL' ? 'badge-status-partial' : 'badge-status-pending');

                                // Perhitungan Bunga dan Pokok Tagihan
                                let bunga = parseFloat(row.bunga_tagihan ?? 0);
                                let totalTagihan = parseFloat(row.jumlah_tagihan ?? 0);
                                let pokokTagihan = totalTagihan - bunga;

                                let actionBtn = isLunas ?
                                    `<span class="text-success fw-bold small"><i class="fas fa-check-double me-1"></i> Lunas</span>` :
                                    `<button class="btn btn-sm ent-btn ent-btn-success btn-proses-bayar px-3 py-1"
                                            data-id="${row.id}"
                                            data-ke="${row.angsuran_ke}"
                                            data-nominal="${formatRupiah(totalTagihan)}">
                                        <i class="fas fa-check-circle me-1"></i> Bayar
                                    </button>`;

                                html += `
                                    <tr class="${rowClass}">
                                        <td class="fw-bold">Bulan Ke-${row.angsuran_ke}</td>
                                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;"><i class="far fa-calendar-alt opacity-50 me-1"></i> ${formatTanggal(row.jatuh_tempo)}</td>
                                        <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(pokokTagihan)}</td>
                                        <td class="text-end text-warning fw-bold" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(bunga)}</td>
                                        <td class="text-end text-primary fw-bold" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(totalTagihan)}</td>
                                        <td class="text-center"><span class="ent-badge ${badgeClass}">${row.status_bayar}</span></td>
                                        <td class="text-end">${actionBtn}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            html = `<tr><td colspan="7" class="text-center py-4 opacity-75">Belum ada rincian jadwal tenor untuk kontrak ini.</td></tr>`;
                        }

                        $('#table-jadwal-cicilan tbody').html(html);

                        // Switch Visibility
                        $('#section-placeholder-kosong').addClass('d-none');
                        $('#section-detail-penagihan').removeClass('d-none');
                    } else {
                        Swal.fire('Perhatian', response.message || 'Gagal memuat data', 'warning');
                        resetView();
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memuat detail data cicilan anggota.';
                    Swal.fire('Error', msg, 'error');
                    resetView();
                }
            });
        });

        // Event Handler Eksekusi Pelunasan Pembayaran Cicilan
        $(document).on('click', '.btn-proses-bayar', function() {
            let id = $(this).data('id');
            let ke = $(this).data('ke');
            let nominal = $(this).data('nominal');
            let coa = $('#sumber_dana_coa_pembayaran').val();

            if (!coa) {
                Swal.fire('Perhatian', 'Silahkan pilih Akun Kas/Bank Penerima terlebih dahulu!', 'warning');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Terima setoran angsuran Bulan Ke-${ke} sebesar ${nominal}? Jurnal penerimaan kas akan otomatis diterbitkan.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Bayar Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Pembayaran...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('menu_koperasi_penagihan_barang_anggota_save') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_tenor: id,
                            sumber_dana_coa: coa
                        },
                        success: function(res) {
                            Swal.close();
                            if (res.status === 'success') {
                                Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                    $('#filter_pembelian_id').trigger('change');
                                });
                            } else {
                                Swal.fire('Gagal!', res.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan sistem saat memproses pembayaran.';
                            Swal.fire('Error!', msg, 'error');
                        }
                    });
                }
            });
        });

        // Function Reset Tampilan Ke Placeholder
        function resetView() {
            $('#section-detail-penagihan').addClass('d-none');
            $('#section-placeholder-kosong').removeClass('d-none');
            $('#table-jadwal-cicilan tbody').html('');
        }

        // Event Reset Filter
        $('#btn-reset-filter').on('click', function() {
            $('#filter_pembelian_id').val('').trigger('change');
        });
    });
</script>
@endsection
