@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (DISTRIBUSI SHU)
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

    .ent-table-surface {
        background-color: var(--ent-surface);
        color: var(--ent-text);
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
        font-size: 0.8rem;
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
        color: var(--ent-text) !important;
        background-color: var(--ent-surface) !important;
        font-size: 0.82rem !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
        height: 40px !important;
    }

    .ent-form .form-control:focus,
    .ent-form .form-select:focus {
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

    .badge-periode {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: #6366f1 !important;
        border: 1px solid rgba(79, 70, 229, 0.35);
        font-family: 'JetBrains Mono', monospace;
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
        padding: 11px 12px;
        letter-spacing: 0.04em;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.05) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--ent-text) !important;
        padding: 9px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }

    .row-hak-anggota td {
        background-color: rgba(16, 185, 129, 0.11) !important;
        color: #059669 !important;
        font-weight: 700 !important;
    }

    /* Modal Enterprise Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text);
        overflow: hidden;
    }

    .ent-modal-banner-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
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
                    <div class="col-lg-9 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-calculator fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-chart-pie me-1"></i> {{ Env('APP_LABEL', 'KOPERASI') }} SHU
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Alokasi &amp; Pencairan</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Perhitungan &amp; Distribusi SHU Koperasi</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Hitung alokasi Sisa Hasil Usaha (SHU), rincian hak jasa modal &amp; jasa usaha anggota, serta proses pencairannya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM FILTER -->
<div class="ent-card ent-table-surface p-3 p-md-4 mb-3">
    <h6 class="fw-bold mb-3"><i class="fas fa-sliders me-2 text-primary"></i>Parameter Periode &amp; Cabang</h6>
    <div class="row g-3 align-items-end ent-form">
        <div class="col-md-3">
            <label for="tgl_mulai" class="form-label ent-form-label">Tanggal Mulai Periode</label>
            <input type="date" id="tgl_mulai" class="form-control" value="{{ date('Y-01-01') }}" style="font-family: 'JetBrains Mono', monospace;">
        </div>
        <div class="col-md-3">
            <label for="tgl_selesai" class="form-label ent-form-label">Tanggal Selesai Periode</label>
            <input type="date" id="tgl_selesai" class="form-control" value="{{ date('Y-12-31') }}" style="font-family: 'JetBrains Mono', monospace;">
        </div>
        <div class="col-md-3">
            <label for="filter-cabang" class="form-label ent-form-label">Unit / Kantor Cabang</label>
            <select id="filter-cabang" class="form-select">
                <option value="ALL">-- Semua Cabang --</option>
                @foreach($cabangs as $cabang)
                <option value="{{ $cabang->kop_master_cabang_code }}">{{ $cabang->kop_master_cabang_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="button" id="btn-proses-shu" class="btn ent-btn ent-btn-primary w-100 py-2">
                <i class="fas fa-cogs me-2"></i> Proses SHU
            </button>
        </div>
    </div>
</div>

<!-- KONTAINER UTAMA -->
<div id="shu-report-container" class="ent-card ent-table-surface p-3 p-md-4">
    <div class="text-center opacity-75 py-5">
        <i class="fas fa-file-invoice-dollar fa-3x d-block mb-3 text-primary opacity-50"></i>
        Silakan tentukan periode tanggal dan cabang di atas, lalu klik tombol <strong>Proses SHU</strong> untuk memuat data.
    </div>
</div>

<!-- MODAL PILIH COA PENCAIRAN -->
<div class="modal fade" id="modalCairkanShu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCairkanShuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner-success py-3 px-4 d-flex align-items-center justify-content-between">
                <h6 class="modal-title fw-bold text-white mb-0" id="modalCairkanShuLabel">
                    <i class="fas fa-money-bill-wave me-2"></i> Konfirmasi Pencairan SHU
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 ent-form">
                <!-- Info Anggota (Dinamis via JS) -->
                <div class="p-3 rounded-3 mb-3" style="background-color: rgba(79, 70, 229, 0.06); border: 1px solid var(--ent-grid-border);">
                    <table class="table table-sm table-borderless m-0 small">
                        <tr>
                            <td class="opacity-75 fw-semibold" style="width: 38%;">ID / Nama Anggota</td>
                            <td class="fw-bold">: <span id="modal-info-anggota">-</span></td>
                        </tr>
                        <tr>
                            <td class="opacity-75 fw-semibold">Nominal SHU</td>
                            <td class="fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">: <span id="modal-info-nominal">-</span></td>
                        </tr>
                    </table>
                </div>

                <!-- Pilihan Akun COA -->
                <div class="mb-2">
                    <label for="modal-select-coa" class="form-label ent-form-label">Pilih Akun Sumber Dana (COA)</label>
                    <select id="modal-select-coa" class="form-select">
                        <option value="">-- Pilih Akun Kas / Bank --</option>
                        @foreach($coas as $coa)
                        <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text opacity-75 small mt-1">Akun ini akan dicatat pada jurnal pengeluaran kas pencairan SHU.</div>
                </div>
            </div>
            <div class="modal-footer px-4 py-3" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-3 py-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-submit-cairkan" class="btn ent-btn ent-btn-success px-4 py-2">
                    <i class="fas fa-check-circle me-1"></i> Proses Cairkan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rawShuAnggota = [];
        let dataPencairanAktif = {};

        const rupiahFormatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        const bsModalCairkan = new bootstrap.Modal(document.getElementById('modalCairkanShu'));

        const btnProses = document.getElementById('btn-proses-shu');
        const container = document.getElementById('shu-report-container');
        const selectCabang = document.getElementById('filter-cabang');
        const btnSubmitCairkan = document.getElementById('btn-submit-cairkan');
        const selectCoa = document.getElementById('modal-select-coa');

        if (btnProses) {
            btnProses.addEventListener('click', prosesHitungSHU);
        }

        function prosesHitungSHU() {
            const tglMulai = document.getElementById('tgl_mulai').value;
            const tglSelesai = document.getElementById('tgl_selesai').value;
            const cabangId = selectCabang.value;

            if (!tglMulai || !tglSelesai) {
                Swal.fire('Periode Belum Lengkap', 'Mohon isi tanggal mulai dan tanggal selesai terlebih dahulu.', 'warning');
                return;
            }

            btnProses.disabled = true;
            btnProses.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menghitung...`;

            container.innerHTML = `
            <div class="text-center py-5 my-3 opacity-75">
                <div class="spinner-border text-primary mb-3" style="width: 2.5rem; height: 2.5rem;" role="status"></div>
                <p class="mb-0 fw-semibold">Menghitung alokasi anggaran, partisipasi modal, dan transaksi belanja anggota...</p>
                <small>Mohon tunggu, server sedang mengkalkulasi database jurnal akuntansi.</small>
            </div>`;

            const params = new URLSearchParams({
                tgl_mulai: tglMulai,
                tgl_selesai: tglSelesai,
                cabang_id: cabangId
            }).toString();

            const url = `{{ url('koperasi/laporan-koperasi/laporan-pembagian-shu/get-data') }}?${params}`;

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Respon server bermasalah.');
                    return res.json();
                })
                .then(data => {
                    btnProses.disabled = false;
                    btnProses.innerHTML = `<i class="fas fa-cogs me-2"></i> Proses SHU`;

                    const persentase = data.persentase || {};
                    const alokasi = data.alokasi_shu || data.alokasi || {};
                    rawShuAnggota = data.detail_anggota || [];

                    const namaCabangTerpilih = selectCabang.options[selectCabang.selectedIndex].text;

                    container.innerHTML = `
                    <div class="text-center mb-4 pb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <h5 class="fw-bold m-0">LAPORAN ALOKASI &amp; DISTRIBUSI SHU ANGGOTA</h5>
                        <p class="opacity-75 fw-semibold mb-1 small">Unit/Cabang: <span class="text-primary">${escapeHtml(namaCabangTerpilih)}</span></p>
                        <p class="opacity-75 small mb-0">Periode Perhitungan: <span class="ent-badge badge-periode">${escapeHtml(tglMulai)}</span> s/d <span class="ent-badge badge-periode">${escapeHtml(tglSelesai)}</span></p>
                    </div>

                    <div class="alert alert-primary d-flex justify-content-between align-items-center p-3 mb-4 rounded-3 border border-primary shadow-sm flex-wrap gap-2">
                        <span class="fw-bold text-uppercase small"><i class="fas fa-landmark me-2"></i> Sisa Hasil Usaha (SHU) Bersih Terbuku</span>
                        <span class="fw-bold fs-5" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(data.shu_total || 0)}</span>
                    </div>

                    <!-- TABEL ALOKASI -->
                    <div class="rounded-3 mb-5 overflow-hidden" style="border: 1px solid var(--ent-grid-border);">
                        <div class="p-3 fw-bold small text-uppercase" style="background-color: rgba(79, 70, 229, 0.06); border-bottom: 1px solid var(--ent-grid-border);">
                            <i class="fas fa-chart-pie me-2 text-warning"></i> Distribusi Pagu Anggaran Pembagian SHU
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom align-middle m-0 small w-100">
                                <thead>
                                    <tr>
                                        <th>Nama Komponen / Peruntukan Alokasi</th>
                                        <th class="text-center" style="width: 20%;">Rasio AD/ART</th>
                                        <th class="text-end" style="width: 35%;">Nilai Nominal (Rupiah)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Dana Cadangan Lembaga Koperasi</td><td class="text-center" style="font-family: 'JetBrains Mono', monospace;">${persentase.dana_cadangan || 0}%</td><td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(alokasi.dana_cadangan || 0)}</td></tr>
                                    <tr class="row-hak-anggota"><td><i class="fas fa-check-circle me-2"></i> Jasa Modal / Simpanan (Hak Anggota)</td><td class="text-center" style="font-family: 'JetBrains Mono', monospace;">${persentase.jasa_modal || 0}%</td><td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(alokasi.jasa_modal || 0)}</td></tr>
                                    <tr class="row-hak-anggota"><td><i class="fas fa-check-circle me-2"></i> Jasa Usaha / Partisipasi Belanja (Hak Anggota)</td><td class="text-center" style="font-family: 'JetBrains Mono', monospace;">${persentase.jasa_anggota || persentase.jasa_usaha || 0}%</td><td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(alokasi.jasa_anggota || alokasi.jasa_usaha || 0)}</td></tr>
                                    <tr><td>Dana Insentif Pengurus &amp; Pengawas</td><td class="text-center" style="font-family: 'JetBrains Mono', monospace;">${persentase.dana_pengurus || 0}%</td><td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(alokasi.dana_pengurus || 0)}</td></tr>
                                    <tr><td>Dana Kesejahteraan Karyawan/Pengelola</td><td class="text-center" style="font-family: 'JetBrains Mono', monospace;">${persentase.dana_karyawan || 0}%</td><td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(alokasi.dana_karyawan || 0)}</td></tr>
                                    <tr><td>Dana Pendidikan Anggota &amp; Koperasi</td><td class="text-center" style="font-family: 'JetBrains Mono', monospace;">${persentase.dana_pendidikan || 0}%</td><td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(alokasi.dana_pendidikan || 0)}</td></tr>
                                    <tr><td>Dana Alokasi Sosial &amp; Pembangunan Lingkungan</td><td class="text-center" style="font-family: 'JetBrains Mono', monospace;">${persentase.dana_sosial || 0}%</td><td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(alokasi.dana_sosial || 0)}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- DATA PER ANGGOTA -->
                    <div class="row g-3 align-items-center mb-3 ent-form">
                        <div class="col">
                            <h6 class="fw-bold mb-0"><i class="fas fa-users text-primary me-2"></i> Rincian Hak Penerimaan Per Anggota</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border); border-right: none; border-radius: 10px 0 0 10px; color: var(--ent-indigo);"><i class="fas fa-search"></i></span>
                                <input type="text" id="search-shu-anggota" class="form-control" style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" placeholder="Cari Nama / ID Anggota...">
                            </div>
                        </div>
                    </div>

                    <div id="shu-anggota-wrapper" class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);"></div>
                `;

                    const inputSearch = document.getElementById('search-shu-anggota');
                    if (inputSearch) {
                        inputSearch.addEventListener('input', function() {
                            renderTabelShuAnggota(this.value, selectCabang.value);
                        });
                    }

                    renderTabelShuAnggota('', cabangId);
                })
                .catch(err => {
                    console.error(err);
                    btnProses.disabled = false;
                    btnProses.innerHTML = `<i class="fas fa-cogs me-2"></i> Proses SHU`;

                    container.innerHTML = `
                <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-0">
                    <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                    <div>
                        <strong>Proses Gagal Menerima Data!</strong><br>
                        Terjadi kendala teknis atau tidak ada rekam data pada cabang dan periode yang Anda pilih.
                    </div>
                </div>`;
                });
        }

        selectCabang.addEventListener('change', function() {
            const inputSearch = document.getElementById('search-shu-anggota');
            const keyword = inputSearch ? inputSearch.value : '';
            renderTabelShuAnggota(keyword, this.value);
        });

        function renderTabelShuAnggota(keyword, cabangFilterId) {
            const searchKeyword = keyword.toLowerCase().trim();
            const wrapper = document.getElementById('shu-anggota-wrapper');

            if (!wrapper) return;

            let htmlAnggota = `
            <table class="table table-custom align-middle small m-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">ID Anggota</th>
                        <th>Nama Lengkap</th>
                        <th class="text-end">Simpanan Rata²</th>
                        <th class="text-end">Jasa Modal</th>
                        <th class="text-end">Vol. Transaksi</th>
                        <th class="text-end">Jasa Usaha</th>
                        <th class="text-end">Total SHU</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>`;

            let no = 1;
            let grandJasaModal = 0;
            let grandJasaUsaha = 0;
            let grandTotalShu = 0;

            rawShuAnggota.forEach(item => {
                const namaAnggota = String(item.name || '').toLowerCase();
                const kodeAnggota = String(item.code || '').toLowerCase();
                const idCabangItem = String(item.cabang_id || '');

                const matchKeyword = searchKeyword === '' || namaAnggota.includes(searchKeyword) || kodeAnggota.includes(searchKeyword);
                const matchCabang = cabangFilterId === 'ALL' || idCabangItem === String(cabangFilterId);

                if (matchKeyword && matchCabang) {
                    const totalShu = Number(item.total_shu || 0);
                    grandJasaModal += Number(item.jasa_modal || 0);
                    grandJasaUsaha += Number(item.jasa_usaha || 0);
                    grandTotalShu += totalShu;

                    let btnCairkan = totalShu > 0 ?
                        `<button type="button" class="btn btn-sm ent-btn ent-btn-success py-1 px-2 btn-buka-modal-cair"
                                   data-code="${escapeHtml(item.code)}"
                                   data-name="${escapeHtml(item.name)}"
                                   data-nominal="${totalShu}">
                               <i class="fas fa-money-bill-wave me-1"></i> Cairkan
                           </button>` :
                        `<span class="ent-badge" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.3);">Nol</span>`;

                    htmlAnggota += `
                    <tr>
                        <td class="text-center fw-bold" style="font-family: 'JetBrains Mono', monospace;">${no++}</td>
                        <td class="fw-semibold text-center" style="font-family: 'JetBrains Mono', monospace;">${escapeHtml(item.code)}</td>
                        <td class="fw-bold">${escapeHtml(item.name)}</td>
                        <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(item.simpanan || 0)}</td>
                        <td class="text-end text-success fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(item.jasa_modal || 0)}</td>
                        <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(item.transaksi || 0)}</td>
                        <td class="text-end text-success fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(item.jasa_usaha || 0)}</td>
                        <td class="text-end text-primary fw-bold" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(totalShu)}</td>
                        <td class="text-center">${btnCairkan}</td>
                    </tr>`;
                }
            });

            if (no === 1) {
                htmlAnggota += `<tr><td colspan="9" class="text-center opacity-75 fst-italic py-4">Tidak ada data anggota yang sesuai dengan kriteria filter.</td></tr>`;
            } else {
                htmlAnggota += `
                <tr class="fw-bold" style="background-color: rgba(79, 70, 229, 0.1);">
                    <td colspan="4" class="text-end text-uppercase small">Total Ditanggung Anggota:</td>
                    <td class="text-end text-success" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(grandJasaModal)}</td>
                    <td></td>
                    <td class="text-end text-success" style="font-family: 'JetBrains Mono', monospace;">${rupiahFormatter.format(grandJasaUsaha)}</td>
                    <td colspan="2" class="text-end text-primary" style="font-family: 'JetBrains Mono', monospace; background-color: rgba(79, 70, 229, 0.16);">${rupiahFormatter.format(grandTotalShu)}</td>
                </tr>`;
            }

            htmlAnggota += `</tbody></table>`;
            wrapper.innerHTML = htmlAnggota;
        }

        // 1. EVENT DELEGATION: intercept klik tombol cairkan di dalam tabel
        container.addEventListener('click', function(e) {
            const targetBtn = e.target.closest('.btn-buka-modal-cair');
            if (!targetBtn) return;

            dataPencairanAktif = {
                code: targetBtn.getAttribute('data-code'),
                name: targetBtn.getAttribute('data-name'),
                nominal: targetBtn.getAttribute('data-nominal')
            };

            document.getElementById('modal-info-anggota').innerText = `${dataPencairanAktif.code} / ${dataPencairanAktif.name}`;
            document.getElementById('modal-info-nominal').innerText = rupiahFormatter.format(dataPencairanAktif.nominal);

            selectCoa.value = "";
            bsModalCairkan.show();
        });

        // 2. SUBMIT EVENT: Eksekusi tombol "Proses Cairkan" yang ada di dalam modal
        if (btnSubmitCairkan) {
            btnSubmitCairkan.addEventListener('click', function() {
                const coaSelected = selectCoa.value;

                if (!coaSelected) {
                    Swal.fire('COA Belum Dipilih', 'Silakan pilih Akun Sumber Dana (COA) terlebih dahulu.', 'warning');
                    selectCoa.focus();
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Pencairan SHU',
                    text: `Apakah Anda yakin ingin memproses pencairan SHU menggunakan akun COA: [${coaSelected}]?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Cairkan SHU',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    btnSubmitCairkan.disabled = true;
                    btnSubmitCairkan.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...`;

                    fetch(`{{ route('laporan_koperasi_pembagian_shu_cairkan_shu') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                anggota_code: dataPencairanAktif.code,
                                nominal: dataPencairanAktif.nominal,
                                coa_code: coaSelected,
                                tgl_pencairan: new Date().toISOString().slice(0, 10)
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Gagal memproses ke server.');
                            return response.json();
                        })
                        .then(res => {
                            btnSubmitCairkan.disabled = false;
                            btnSubmitCairkan.innerHTML = `<i class="fas fa-check-circle me-1"></i> Proses Cairkan`;

                            if (res.status === 'success') {
                                Swal.fire('Berhasil Dicairkan!', `SHU Anggota ${dataPencairanAktif.name} berhasil dicairkan.\nNomor Jurnal Terbentuk: ${res.jurnal}`, 'success');
                                bsModalCairkan.hide();
                                prosesHitungSHU();
                            } else {
                                Swal.fire('Gagal Mencairkan', res.message || 'Terjadi kesalahan saat mencairkan SHU.', 'error');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Kesalahan Sistem', 'Terjadi kesalahan sistem atau kendala jaringan backend.', 'error');
                            btnSubmitCairkan.disabled = false;
                            btnSubmitCairkan.innerHTML = `<i class="fas fa-check-circle me-1"></i> Proses Cairkan`;
                        });
                });
            });
        }

        function escapeHtml(str) {
            return String(str).replace(/[&<>"']/g, function(match) {
                const escapes = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#x27;'
                };
                return escapes[match];
            });
        }
    });
</script>
@endsection
