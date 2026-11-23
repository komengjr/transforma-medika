@extends('layouts.layouts')

@section('base.css')
<!-- Select2 CSS & Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (PENAGIHAN PINJAMAN)
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

    .ent-btn-secondary {
        background-color: rgba(100, 116, 139, 0.14);
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    .ent-btn-secondary:hover {
        background-color: rgba(79, 70, 229, 0.12);
        border-color: var(--ent-indigo);
        color: var(--bs-body-color);
    }

    /* Form & Select2 Adaptive */
    .ent-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
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

    .ent-form .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 40px;
        transition: all 0.2s ease;
    }

    .ent-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 40px !important;
        display: flex;
        align-items: center;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
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

    .badge-lunas {
        background-color: rgba(16, 185, 129, 0.15) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .badge-belum {
        background-color: rgba(245, 158, 11, 0.16) !important;
        color: #d97706 !important;
        border: 1px solid rgba(245, 158, 11, 0.38);
    }

    /* Nota Highlight Pill */
    .ent-nota-box {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(5, 150, 105, 0.08));
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
    }

    /* Summary Box */
    .ent-summary-box {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 14px;
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
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom tbody tr.row-lunas td {
        background-color: rgba(16, 185, 129, 0.06) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
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

    /* Custom Checkbox */
    .ent-checkbox {
        width: 1.15em;
        height: 1.15em;
        border: 1.5px solid rgba(99, 102, 241, 0.55) !important;
        border-radius: 5px;
        cursor: pointer;
    }

    .ent-checkbox:checked {
        background-color: var(--ent-indigo) !important;
        border-color: var(--ent-indigo) !important;
    }

    /* Empty Placeholder Icon */
    .ent-empty-icon {
        width: 72px;
        height: 72px;
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
                            <i class="fas fa-hand-holding-usd fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-receipt me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} INSTALLMENT
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Penagihan &amp; Pelunasan Cicilan</span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: white;">Penagihan &amp; Pelunasan Cicilan Peminjaman Uang</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Penerimaan setoran angsuran pinjaman tunai dari peserta koperasi (Multi-Pembayaran).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- DROP DOWN FILTER NOTA PINJAMAN -->
    <div class="col-12">
        <div class="ent-card ent-table-surface p-3 p-md-4 ent-form">
            <div class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label class="form-label ent-label text-dark">
                        <i class="fas fa-search text-primary me-1"></i> Pilih Kontrak Nota Pinjaman Anggota Aktif
                    </label>
                    <select class="form-select select2-nota" name="peminjaman_id" id="filter_peminjaman_id" data-placeholder="-- Pilih Nota Pinjaman / Nama Anggota --">
                        <option value=""></option>
                        @foreach($listNota as $n)
                        <option value="{{ $n->id_peminjaman }}">{{ $n->nota_nomor }} - {{ $n->kop_master_peserta_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="button" class="btn ent-btn ent-btn-secondary py-2" id="btn-reset-filter" style="min-height: 40px;">
                        <i class="fas fa-undo me-1"></i> Reset Pencarian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- WRAPPER KONTEN DINAMIS (Awalnya Tersembunyi) -->
    <div class="col-12 d-none" id="section-detail-penagihan">
        <div class="row g-3">
            <!-- PANEL RESUME KONTRAK & RINGKASAN PEMBAYARAN MULTI -->
            <div class="col-lg-4">
                <!-- Detail Kontrak Pinjaman -->
                <div class="ent-card ent-table-surface mb-3">
                    <div class="card-header py-3 px-4">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="fas fa-file-contract text-primary me-2"></i>Detail Kontrak Pinjaman
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="ent-nota-box mb-3">
                            <small class="ent-label d-block mb-1">Nomor Nota</small>
                            <span class="fs-2 fw-bold text-success" id="res-nota" style="font-family: 'JetBrains Mono', monospace;">-</span>
                        </div>

                        <table class="table table-sm table-borderless mb-0 small">
                            <tr>
                                <td width="42%" class="opacity-75">Nama Peserta</td>
                                <td width="4%" class="opacity-75">:</td>
                                <td class="fw-bold text-uppercase" id="res-nama">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Kode Peserta</td>
                                <td class="opacity-75">:</td>
                                <td id="res-kode" style="font-family: 'JetBrains Mono', monospace;">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Plafon Pinjaman</td>
                                <td class="opacity-75">:</td>
                                <td class="fw-bold text-primary" id="res-plafon" style="font-family: 'JetBrains Mono', monospace;">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Jasa / Bunga</td>
                                <td class="opacity-75">:</td>
                                <td class="fw-bold" style="color: var(--ent-amber); font-family: 'JetBrains Mono', monospace;" id="res-bunga">-</td>
                            </tr>
                            <tr style="border-top: 1px solid var(--ent-grid-border);">
                                <td class="opacity-75 fw-bold pt-2">Total Piutang</td>
                                <td class="opacity-75 pt-2">:</td>
                                <td class="text-success fw-bold pt-2" id="res-total" style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem;">-</td>
                            </tr>
                            <tr>
                                <td class="opacity-75">Cicilan / Bln</td>
                                <td class="opacity-75">:</td>
                                <td class="fw-bold" id="res-cicilan" style="font-family: 'JetBrains Mono', monospace; font-size: 0.92rem;">-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Ringkasan & Pembayaran -->
                <div class="ent-card ent-table-surface ent-form">
                    <div class="card-header py-3 px-4">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="fas fa-calculator text-success me-2"></i>Ringkasan &amp; Pembayaran
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label ent-label">Simpan Uang Masuk Ke <span class="text-danger">*</span></label>
                            <select class="form-select" id="sumber_dana_coa_pembayaran">
                                <option value="">-- Pilih Akun Kas / Bank --</option>
                                @foreach($bankCoa as $coa)
                                <option value="{{ $coa->coa_code }}">[{{ $coa->coa_code }}] {{ $coa->coa_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ent-summary-box mb-3 small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="opacity-75">Bulan Dipilih:</span>
                                <span class="fw-bold" id="label-total-bulan" style="font-family: 'JetBrains Mono', monospace;">0 Bulan</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="opacity-75">Total Pokok:</span>
                                <span class="fw-bold opacity-75" id="label-total-pokok" style="font-family: 'JetBrains Mono', monospace;">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="opacity-75">Total Bunga:</span>
                                <span class="fw-bold" style="color: var(--ent-amber); font-family: 'JetBrains Mono', monospace;" id="label-total-bunga">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 extra-small opacity-75 fst-italic d-none" id="info-penambahan-bunga">
                                <span>* Kalkulasi bunga 10% x jumlah bulan</span>
                            </div>
                            <hr class="my-2" style="border-color: var(--ent-grid-border);">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="opacity-75 fw-bold">Total Tagihan:</span>
                                <span class="fs-3 fw-bold text-success" id="label-total-nominal" style="font-family: 'JetBrains Mono', monospace;">Rp 0</span>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn ent-btn ent-btn-success py-2" id="btn-proses-multi-bayar" disabled>
                                <i class="fas fa-check-double me-1"></i> Proses Pembayaran Multi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL TABEL TENOR JADWAL -->
            <div class="col-lg-8">
                <div class="ent-card ent-table-surface h-100">
                    <div class="card-header py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="fas fa-list-ol text-warning me-2"></i>Daftar Angsuran Pinjaman
                        </h6>
                        <div class="form-check d-flex align-items-center gap-2 mb-0">
                            <input class="form-check-input ent-checkbox mt-0" type="checkbox" id="select-all-checkbox">
                            <label class="form-check-label fw-semibold opacity-75 small mb-0" for="select-all-checkbox" style="cursor: pointer;">
                                Pilih Semua Belum Lunas
                            </label>
                        </div>
                    </div>

                    <div class="card-body ent-card-body-flush">
                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0 w-100" id="table-jadwal-cicilan">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 6%;">Pilih</th>
                                        <th>Angsuran</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end">Pokok</th>
                                        <th class="text-end">Bunga</th>
                                        <th class="text-end">Total Tagihan</th>
                                        <th class="text-center">Status</th>
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
        <div class="ent-card ent-table-surface py-5 px-3 text-center">
            <div class="card-body">
                <div class="ent-empty-icon mb-3">
                    <i class="fas fa-search-dollar fa-2x"></i>
                </div>
                <h5 class="fw-bold mb-1">Silahkan pilih nomor nota pembiayaan pinjaman peserta terlebih dahulu.</h5>
                <p class="mb-0 opacity-75 small">Sistem akan memuat rincian data cicilan peminjaman uang secara otomatis setelah nota dipilih.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        // Kalkulasi Total & Detail Rincian Ringkasan Sesuai Aturan Terbaru
        function hitungTotalPilihan() {
            let totalBulan = 0;
            let sumPokok = 0;
            let sampleBunga = 0;

            $('.checkbox-tenor:checked').each(function(index) {
                let p = parseFloat($(this).data('pokok') || 0);
                let b = parseFloat($(this).data('bunga') || 0);

                sumPokok += p;
                if (index === 0) {
                    sampleBunga = b;
                }
                totalBulan++;
            });

            let finalPokok = 0;
            let finalBunga = 0;
            let totalNominal = 0;

            if (totalBulan === 1) {
                let checkedEl = $('.checkbox-tenor:checked').first();
                finalPokok = parseFloat(checkedEl.data('pokok') || 0);
                finalBunga = parseFloat(checkedEl.data('bunga') || 0);
                totalNominal = finalPokok + finalBunga;

                $('#info-penambahan-bunga').addClass('d-none');
            } else if (totalBulan > 1) {
                finalPokok = sumPokok;
                finalBunga = sampleBunga * 0.10 * totalBulan;
                totalNominal = finalPokok + finalBunga;

                $('#info-penambahan-bunga').removeClass('d-none');
            } else {
                $('#info-penambahan-bunga').addClass('d-none');
            }

            $('#label-total-bulan').text(totalBulan + ' Bulan');
            $('#label-total-pokok').text(formatRupiah(finalPokok));
            $('#label-total-bunga').text(formatRupiah(finalBunga));
            $('#label-total-nominal').text(formatRupiah(totalNominal));

            if (totalBulan > 0) {
                $('#btn-proses-multi-bayar').removeAttr('disabled');
            } else {
                $('#btn-proses-multi-bayar').attr('disabled', 'disabled');
            }
        }

        // Event handler ketika dropdown nota pinjaman dipilih
        $('#filter_peminjaman_id').on('change', function() {
            let id = $(this).val();
            if (!id) {
                resetView();
                return;
            }

            Swal.fire({
                title: 'Memuat Data...',
                text: 'Sedang mengambil informasi rincian tenor angsuran pinjaman',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `{{ url('koperasi/menu-koperasi/penagihan-peminjaman/get-data') }}/${id}`,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    Swal.close();
                    if (response.status === 'success') {
                        let kontrak = response.kontrak;
                        let jadwal = response.jadwal;

                        // 1. Render Resume Data Kontrak Pinjaman
                        $('#res-nota').text(kontrak.nota_nomor ?? '-');
                        $('#res-nama').text(kontrak.kop_master_peserta_name ?? '-');
                        $('#res-kode').text(kontrak.kop_master_peserta_code ?? '-');
                        $('#res-plafon').text(formatRupiah(kontrak.jumlah_pinjaman ?? kontrak.plafon));
                        $('#res-bunga').text(formatRupiah(kontrak.bunga_koperasi ?? kontrak.bunga));
                        $('#res-total').text(formatRupiah(kontrak.total_piutang));
                        $('#res-cicilan').text(formatRupiah(kontrak.cicilan_per_bulan));

                        // 2. Render Baris Tabel Jadwal Cicilan Pinjaman dengan Checkbox
                        let html = '';
                        if (jadwal && jadwal.length > 0) {
                            jadwal.forEach(function(row) {
                                let isLunas = (row.status_bayar === 'LUNAS');
                                let rowClass = isLunas ? 'row-lunas' : '';
                                let badgeClass = isLunas ? 'badge-lunas' : 'badge-belum';

                                let bunga = parseFloat(row.bunga_tagihan ?? 0);
                                let totalTagihan = parseFloat(row.jumlah_tagihan ?? 0);
                                let pokokTagihan = totalTagihan - bunga;

                                let checkboxInput = isLunas ?
                                    `<span class="text-success"><i class="fas fa-check-double"></i></span>` :
                                    `<input class="form-check-input ent-checkbox checkbox-tenor" type="checkbox" value="${row.id}" data-nominal="${totalTagihan}" data-pokok="${pokokTagihan}" data-bunga="${bunga}">`;

                                html += `
                                    <tr class="${rowClass}">
                                        <td class="text-center">${checkboxInput}</td>
                                        <td class="fw-bold opacity-75">Bulan Ke-${row.angsuran_ke}</td>
                                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">
                                            <i class="far fa-calendar-alt text-primary me-1"></i> ${formatTanggal(row.jatuh_tempo)}
                                        </td>
                                        <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(pokokTagihan)}</td>
                                        <td class="text-end fw-bold" style="color: var(--ent-amber); font-family: 'JetBrains Mono', monospace;">${formatRupiah(bunga)}</td>
                                        <td class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(totalTagihan)}</td>
                                        <td class="text-center"><span class="ent-badge ${badgeClass}">${row.status_bayar}</span></td>
                                    </tr>
                                `;
                            });
                        } else {
                            html = `<tr><td colspan="7" class="text-center py-4 opacity-75">Belum ada rincian jadwal tenor untuk kontrak pinjaman ini.</td></tr>`;
                        }

                        $('#table-jadwal-cicilan tbody').html(html);
                        $('#select-all-checkbox').prop('checked', false);
                        hitungTotalPilihan();

                        // Switch Visibility
                        $('#section-placeholder-kosong').addClass('d-none');
                        $('#section-detail-penagihan').removeClass('d-none');
                    } else {
                        Swal.fire('Perhatian', response.message || 'Gagal memuat data pinjaman', 'warning');
                        resetView();
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memuat detail data cicilan peminjaman uang.';
                    Swal.fire('Error', msg, 'error');
                    resetView();
                }
            });
        });

        // Event Checkbox Pilih Semua
        $(document).on('change', '#select-all-checkbox', function() {
            $('.checkbox-tenor:not(:disabled)').prop('checked', this.checked);
            hitungTotalPilihan();
        });

        // Event Checkbox Satuan Berubah
        $(document).on('change', '.checkbox-tenor', function() {
            hitungTotalPilihan();
        });

        // Event Handler Eksekusi Pelunasan Multi Pembayaran
        $('#btn-proses-multi-bayar').on('click', function() {
            let coa = $('#sumber_dana_coa_pembayaran').val();
            if (!coa) {
                Swal.fire('Perhatian', 'Silahkan pilih Akun Kas/Bank Penerima terlebih dahulu!', 'warning');
                return;
            }

            let selectedIds = [];
            $('.checkbox-tenor:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire('Perhatian', 'Pilih minimal satu bulan angsuran yang ingin dilunasi!', 'warning');
                return;
            }

            let totalBulanStr = $('#label-total-bulan').text();
            let totalNominalStr = $('#label-total-nominal').text();

            Swal.fire({
                title: 'Konfirmasi Pembayaran Multi',
                text: `Proses pelunasan sebanyak ${totalBulanStr} dengan total sebesar ${totalNominalStr}? Jurnal penerimaan kas akan diterbitkan otomatis.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Proses Bayar',
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
                        url: "{{ route('menu_koperasi_approval_penagihan_peminjaman_uang_anggota_save') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_tenors: selectedIds,
                            sumber_dana_coa: coa
                        },
                        success: function(res) {
                            Swal.close();
                            if (res.status === 'success') {
                                Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                    $('#filter_peminjaman_id').trigger('change');
                                });
                            } else {
                                Swal.fire('Gagal!', res.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan sistem saat memproses pembayaran pinjaman.';
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
            $('#label-total-bulan').text('0 Bulan');
            $('#label-total-pokok').text('Rp 0');
            $('#label-total-bunga').text('Rp 0');
            $('#label-total-nominal').text('Rp 0');
            $('#info-penambahan-bunga').addClass('d-none');
            $('#btn-proses-multi-bayar').attr('disabled', 'disabled');
        }

        // Event Reset Filter
        $('#btn-reset-filter').on('click', function() {
            $('#filter_peminjaman_id').val('').trigger('change');
        });
    });
</script>
@endsection
