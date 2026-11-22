@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (MUTASI BANK)
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

    .ent-form .form-control:not(textarea),
    .ent-form .form-select {
        height: 40px !important;
    }

    .ent-form .form-control:focus,
    .ent-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-form .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .ent-form .input-group > .form-control {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    /* Radio Pill Box */
    .ent-jenis-box {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px;
        padding: 10px 14px;
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

    /* Preview & Journal Boxes */
    .ent-journal-box {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 14px;
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

    .ent-card-body-flush {
        padding: 0 !important;
        margin: 0 !important;
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
                            <i class="fas fa-university fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-book-open me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} TREASURY
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Mutasi Rekening Bank</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Mutasi Rekening Bank</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pencatatan mutasi koran bank dan sinkronisasi jurnal umum otomatis.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <span class="ent-badge px-3 py-2" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                            <i class="far fa-calendar-alt me-1"></i> Periode: {{ date('F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="row g-3">
    <!-- FORM INPUT MUTASI -->
    <div class="col-lg-5">
        <div class="ent-card ent-table-surface h-100">
            <div class="card-header py-3 px-3 px-md-4">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-edit text-primary me-2"></i>Form Input Mutasi
                </h6>
            </div>
            <div class="card-body p-3 p-md-4 ent-form">
                <form id="form-mutasi-bank">
                    <input type="hidden" name="_token" value="{{ csrf_token() ?? '' }}">

                    <!-- Tanggal Transaksi -->
                    <div class="mb-3">
                        <label class="form-label ent-form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="mutasi_tgl" id="mutasi_tgl" value="{{ date('Y-m-d') }}" style="font-family: 'JetBrains Mono', monospace;" required>
                    </div>

                    <!-- Pilih Akun Bank (COA Asal/Tujuan) -->
                    <div class="mb-3">
                        <label class="form-label ent-form-label">Rekening Bank (Kas/Bank) <span class="text-danger">*</span></label>
                        <select class="form-select" name="bank_coa_code" id="bank_coa_code" required>
                            <option value="">-- Pilih Bank --</option>
                            @foreach($bankCoa as $coa)
                            <option value="{{ $coa->coa_code }}" data-name="{{ $coa->coa_name }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Mutasi (Masuk / Keluar) -->
                    <div class="mb-3">
                        <label class="form-label ent-form-label">Jenis Mutasi <span class="text-danger">*</span></label>
                        <div class="ent-jenis-box d-flex flex-wrap gap-3">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="mutasi_jenis" id="jenis_masuk" value="CR" checked>
                                <label class="form-check-label text-success fw-bold small" for="jenis_masuk" style="cursor: pointer;">
                                    <i class="fas fa-arrow-down me-1"></i> Uang Masuk (Debit Bank)
                                </label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="mutasi_jenis" id="jenis_keluar" value="DB">
                                <label class="form-check-label text-danger fw-bold small" for="jenis_keluar" style="cursor: pointer;">
                                    <i class="fas fa-arrow-up me-1"></i> Uang Keluar (Kredit Bank)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Nominal Transaksi -->
                    <div class="mb-3">
                        <label class="form-label ent-form-label">Nominal Transaksi (Rupiah) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control fw-bold" name="mutasi_nominal" id="mutasi_nominal" placeholder="0" min="1" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>
                    </div>

                    <!-- Lawan Transaksi / Akun Penyeimbang Jurnal -->
                    <div class="mb-3">
                        <label class="form-label ent-form-label">Akun Lawan (Jurnal Kontra) <span class="text-danger">*</span></label>
                        <select class="form-select" name="lawan_coa_code" id="lawan_coa_code" required>
                            <option value="">-- Pilih Akun Alokasi --</option>
                            @foreach($allCoa as $coa)
                            <option value="{{ $coa->coa_code }}" data-name="{{ $coa->coa_name }}">
                                {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ ucfirst($coa->coa_type) }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Keterangan Mutasi -->
                    <div class="mb-3">
                        <label class="form-label ent-form-label">Keterangan / Memo</label>
                        <textarea class="form-control" name="mutasi_keterangan" id="mutasi_keterangan" rows="3" placeholder="Contoh: Transfer bunga simpanan atau pembayaran biaya admin bank..."></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn ent-btn ent-btn-primary py-2" id="btn-preview-mutasi">
                            <i class="fas fa-sync-alt me-2"></i>Generate &amp; Validasi Jurnal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PRATINJAU BUKU REKENING & LIVE JURNAL INTERAKTIF -->
    <div class="col-lg-7">
        <div class="ent-card ent-table-surface h-100">
            <div class="card-header py-3 px-3 px-md-4">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-eye text-primary me-2"></i>Pratinjau Sinkronisasi
                </h6>
            </div>
            <div class="card-body p-3 p-md-4">
                <!-- 1. Preview Buku Mutasi Rekening -->
                <div class="mb-4">
                    <h6 class="fw-bold pb-2 mb-2 small text-uppercase" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <i class="fas fa-book me-2 text-warning"></i>1. Log Buku Rekening Bank
                    </h6>
                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-custom align-middle mb-0 w-100">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Rekening</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Debet (Masuk)</th>
                                    <th class="text-end">Kredit (Keluar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row-preview-mutasi-kosong">
                                    <td colspan="5" class="text-center opacity-75 py-3">Belum ada data dimasukkan. Tekan 'Generate &amp; Validasi Jurnal'</td>
                                </tr>
                                <tr id="row-preview-mutasi-data" class="d-none">
                                    <td id="pv-tgl" style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">-</td>
                                    <td id="pv-bank" class="fw-bold">-</td>
                                    <td id="pv-ket">-</td>
                                    <td id="pv-masuk" class="text-success text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    <td id="pv-keluar" class="text-danger text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Preview Double Entry Jurnal Akuntansi -->
                <div>
                    <h6 class="fw-bold pb-2 mb-2 small text-uppercase" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <i class="fas fa-balance-scale me-2 text-info"></i>2. Aturan Otomatis Jurnal Umum (Double Entry)
                    </h6>
                    <div class="ent-journal-box mb-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless align-middle mb-0 small">
                                <thead>
                                    <tr class="opacity-75" style="border-bottom: 1px solid var(--ent-grid-border);">
                                        <th>Kode Akun (COA)</th>
                                        <th>Nama Akun</th>
                                        <th class="text-end">Debit</th>
                                        <th class="text-end">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="jurnal-kosong">
                                        <td colspan="4" class="text-center opacity-75 py-3">Pratinjau jurnal akuntansi kosong</td>
                                    </tr>
                                    <tr id="jurnal-baris-1" class="d-none">
                                        <td id="j1-code" class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;"></td>
                                        <td id="j1-name" class="fw-semibold"></td>
                                        <td id="j1-debit" class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                        <td id="j1-kredit" class="text-end fw-bold text-danger" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    </tr>
                                    <tr id="jurnal-baris-2" class="d-none">
                                        <td id="j2-code" class="fw-bold ps-3 text-primary" style="font-family: 'JetBrains Mono', monospace;"></td>
                                        <td id="j2-name" class="ps-3 fw-semibold"></td>
                                        <td id="j2-debit" class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                        <td id="j2-kredit" class="text-end fw-bold text-danger" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Submit Akhir Post Data Ke DB -->
                    <div class="text-end">
                        <button type="button" class="btn ent-btn ent-btn-success px-4 py-2 d-none" id="btn-simpan-mutasi-final">
                            <i class="fas fa-cloud-upload-alt me-2"></i>Simpan Mutasi &amp; Posting Jurnal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABEL RIWAYAT LOG MUTASI BANK -->
<div class="row mt-3">
    <div class="col-12">
        <div class="ent-card ent-table-surface">
            <div class="card-header py-3 px-3 px-md-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-history text-primary me-2"></i>Riwayat Mutasi Terkini
                </h6>
                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.28);">
                    Menampilkan 50 data terakhir
                </span>
            </div>

            <div class="card-body ent-card-body-flush">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0 text-nowrap w-100">
                        <thead>
                            <tr>
                                <th>No. Bukti</th>
                                <th>Tanggal</th>
                                <th>Rekening Bank</th>
                                <th>Keterangan / Memo</th>
                                <th class="text-end">Debet (Masuk)</th>
                                <th class="text-end">Kredit (Keluar)</th>
                                <th class="text-center">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logMutasi as $log)
                            <tr>
                                <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">{{ $log->mutasi_no_bukti }}</td>
                                <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">{{ date('d-m-Y', strtotime($log->mutasi_tgl)) }}</td>
                                <td>
                                    <small class="opacity-75 d-block" style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">{{ $log->coa_code }}</small>
                                    <strong class="text-uppercase" style="font-size: 0.8rem;">{{ $log->coa_name }}</strong>
                                </td>
                                <td style="max-width: 300px; white-space: normal;">{{ $log->mutasi_keterangan }}</td>
                                <td class="text-end fw-bold {{ $log->mutasi_debit > 0 ? 'text-success' : 'opacity-50' }}" style="font-family: 'JetBrains Mono', monospace;">
                                    {{ $log->mutasi_debit > 0 ? 'Rp '.number_format($log->mutasi_debit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="text-end fw-bold {{ $log->mutasi_kredit > 0 ? 'text-danger' : 'opacity-50' }}" style="font-family: 'JetBrains Mono', monospace;">
                                    {{ $log->mutasi_kredit > 0 ? 'Rp '.number_format($log->mutasi_kredit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="text-center opacity-75 small">{{ $log->mutasi_user }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center opacity-75 py-4">
                                    <i class="fas fa-folder-open fa-2x d-block mb-2 opacity-50"></i>
                                    Belum ada transaksi mutasi yang tercatat bulan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        $('#btn-preview-mutasi').on('click', function() {
            let tgl = $('#mutasi_tgl').val();
            let bankCoa = $('#bank_coa_code').val();
            let bankName = $('#bank_coa_code option:selected').data('name');
            let jenis = $('input[name="mutasi_jenis"]:checked').val();
            let nominal = $('#mutasi_nominal').val();
            let lawanCoa = $('#lawan_coa_code').val();
            let lawanName = $('#lawan_coa_code option:selected').data('name');
            let keterangan = $('#mutasi_keterangan').val() || 'Mutasi Bank Tanpa Keterangan';

            if (!tgl || !bankCoa || !nominal || !lawanCoa) {
                Swal.fire('Form Belum Lengkap', 'Harap isi semua kolom berlabel bintang (*) merah terlebih dahulu.', 'warning');
                return;
            }

            $('#row-preview-mutasi-kosong').addClass('d-none');
            $('#row-preview-mutasi-data').removeClass('d-none');

            $('#pv-tgl').text(tgl);
            $('#pv-bank').text(bankName);
            $('#pv-ket').text(keterangan);

            if (jenis === 'CR') {
                $('#pv-masuk').text(formatRupiah(nominal));
                $('#pv-keluar').text('Rp 0');

                $('#j1-code').text(bankCoa);
                $('#j1-name').text(bankName);
                $('#j1-debit').text(formatRupiah(nominal));
                $('#j1-kredit').text('Rp 0');

                $('#j2-code').text(lawanCoa);
                $('#j2-name').text('↳ ' + lawanName);
                $('#j2-debit').text('Rp 0');
                $('#j2-kredit').text(formatRupiah(nominal));
            } else {
                $('#pv-masuk').text('Rp 0');
                $('#pv-keluar').text(formatRupiah(nominal));

                $('#j1-code').text(lawanCoa);
                $('#j1-name').text(lawanName);
                $('#j1-debit').text(formatRupiah(nominal));
                $('#j1-kredit').text('Rp 0');

                $('#j2-code').text(bankCoa);
                $('#j2-name').text('↳ ' + bankName);
                $('#j2-debit').text('Rp 0');
                $('#j2-kredit').text(formatRupiah(nominal));
            }

            $('#jurnal-kosong').addClass('d-none');
            $('#jurnal-baris-1, #jurnal-baris-2, #btn-simpan-mutasi-final').removeClass('d-none');

            $('html, body').animate({
                scrollTop: $("#row-preview-mutasi-data").offset().top - 120
            }, 300);
        });

        $('#btn-simpan-mutasi-final').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Kunci & Posting Jurnal?',
                text: "Data mutasi buku rekening akan disimpan dan posting jurnal umum tidak dapat dibatalkan secara sepihak.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Posting Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sinkronisasi Database',
                        text: 'Sedang menulis ke buku mutasi dan tabel jurnal fin...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    let postData = $('#form-mutasi-bank').serialize();

                    $.ajax({
                        url: `{{ route('menu_koperasi_mutasi_rekening_bank_save') }}`,
                        type: "POST",
                        data: postData,
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal Pembukuan', response.message || 'Terjadi kesalahan internal data.', 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire('Terjadi Error', 'Gagal menyambung ke server. Periksa kembali backend Anda.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
