@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (SIMPANAN WAJIB)
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

    .ent-card>.card-footer {
        border-top: 1px solid var(--ent-grid-border) !important;
        background-color: rgba(79, 70, 229, 0.05) !important;
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
        font-size: 0.8rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Avatar Peserta */
    .peserta-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.18), rgba(2, 132, 199, 0.18));
        border: 1px solid rgba(99, 102, 241, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #6366f1;
        font-size: 0.72rem;
        flex-shrink: 0;
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
        padding-right: 18px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom tbody tr.row-lunas td {
        background-color: rgba(16, 185, 129, 0.06) !important;
        opacity: 0.8;
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
        padding-right: 18px !important;
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
                            <i class="fas fa-calendar-check fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-layer-group me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} COLLECTIVE
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Simpanan Wajib Bulanan</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Penagihan Kolektif Simpanan Wajib (Akhir Bulan)</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pemotongan dan pembukuan kolektif simpanan wajib anggota aktif berdasarkan cabang.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <span class="ent-badge px-3 py-2" style="background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7; font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                            <i class="fas fa-coins me-1"></i> Tarif: Rp {{ number_format($nominal_wajib, 0, ',', '.') }} / Bln
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alerts -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert" style="border: 1px solid rgba(16, 185, 129, 0.35);">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert" style="border: 1px solid rgba(225, 29, 72, 0.35);">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- 1. FILTER PANEL & SETUP COA -->
<form id="form-simpanan-wajib" action="{{ route('menu_koperasi_simpanan_wajib_bayar') }}" method="POST">
    @csrf

    <!-- Input Tersembunyi Untuk Menyimpan Cabang yang Dipilih -->
    <input type="hidden" name="cabang_terpilih" id="cabang_terpilih">
    <input type="hidden" name="nominal_wajib" id="nominal_wajib_val" value="{{ $nominal_wajib }}">

    <div class="ent-card ent-table-surface mb-3">
        <div class="card-header py-3 px-3 px-md-4">
            <h6 class="card-title mb-0 fw-bold">
                <i class="fas fa-sliders-h text-primary me-2"></i>Filter Cabang &amp; Pemetaan Akun COA
            </h6>
        </div>
        <div class="card-body p-3 p-md-4">
            <div class="row g-2">
                <!-- Dropdown Filter Cabang -->
                <div class="col-md-4">
                    <div class="form-floating-custom">
                        <label for="select-cabang">1. Pilih Cabang <span class="text-danger">*</span></label>
                        <select id="select-cabang" class="form-select ent-input">
                            <option value="">-- Pilih Cabang --</option>
                            @foreach($list_cabang as $cabang)
                            <option value="{{ $cabang }}">{{ strtoupper($cabang) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- COA Pembayaran -->
                <div class="col-md-4">
                    <div class="form-floating-custom">
                        <label for="coa_pembayaran">2. Metode Penerimaan Uang <span class="text-danger">*</span></label>
                        <select name="coa_pembayaran" id="coa_pembayaran" class="form-select ent-input" required>
                            <option value="">-- Pilih Kas / Bank --</option>
                            @foreach($coa_pembayaran as $coa)
                            <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- COA Simpanan Wajib -->
                <div class="col-md-4">
                    <div class="form-floating-custom">
                        <label for="coa_simpanan">3. Alokasi Akun Rekening <span class="text-danger">*</span></label>
                        <select name="coa_simpanan" id="coa_simpanan" class="form-select ent-input" required>
                            <option value="">-- Pilih Akun Simpanan Wajib --</option>
                            @foreach($coa_simpanan as $coa)
                            <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- INFO BOX & TABLE PANEL -->
    <div id="status-message" class="ent-card ent-table-surface py-5 px-3 text-center mb-3">
        <div class="card-body">
            <div class="ent-empty-icon mb-3">
                <i class="fas fa-users-cog fa-2x"></i>
            </div>
            <h6 class="fw-bold mb-1">Filter Cabang Belum Dipilih</h6>
            <p class="mb-0 opacity-75 small">Silakan tentukan filter <strong>Cabang Koperasi</strong> terlebih dahulu untuk memuat daftar anggota aktif.</p>
        </div>
    </div>

    <div id="card-peserta" class="ent-card ent-table-surface d-none">
        <div class="card-header py-3 px-3 px-md-4">
            <div class="row g-2 align-items-center justify-content-between">
                <div class="col-auto d-flex align-items-center gap-2 flex-wrap">
                    <i class="fas fa-users text-primary"></i>
                    <h6 class="mb-0 fw-bold">Daftar Anggota Aktif - Cabang: <strong class="text-primary" id="label-cabang">-</strong></h6>
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3); font-family: 'JetBrains Mono', monospace;">
                        Tarif Bulanan: Rp {{ number_format($nominal_wajib, 0, ',', '.') }} / Anggota
                    </span>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-floating-custom">
                        <label for="search-peserta-wajib">Cari Anggota / Kode / NIK</label>
                        <input type="text" id="search-peserta-wajib" class="form-control ent-input" placeholder="Ketik nama, kode, atau NIK...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body ent-card-body-flush">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0 w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 6%;">
                                <!-- Checkbox Master -->
                                <input type="checkbox" id="check-all" class="form-check-input ent-checkbox">
                            </th>
                            <th style="width: 16%;">Kode Anggota</th>
                            <th style="width: 30%;">Nama Lengkap</th>
                            <th style="width: 18%;">NIK / NIP</th>
                            <th style="width: 16%;">Periode Tagihan</th>
                            <th class="text-center" style="width: 14%;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-peserta-body">
                        <!-- Diisi secara dinamis oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Card untuk Trigger Aksi Massal -->
        <div class="card-footer px-3 px-md-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="fw-semibold small">
                    Total Dipilih: <span id="total-terpilih" class="text-primary fw-bold" style="font-family: 'JetBrains Mono', monospace;">0</span> Anggota
                </div>
                <span class="opacity-50 d-none d-sm-inline">|</span>
                <div class="fw-semibold small">
                    Estimasi Total: <span id="total-nominal-wajib" class="text-success fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp 0</span>
                </div>
            </div>
            <button type="submit" id="btn-submit-massal" class="btn ent-btn ent-btn-success px-4 py-2" disabled>
                <i class="fas fa-check-double me-1"></i> Proses Bayar Massal Berdasarkan Cabang
            </button>
        </div>
    </div>
</form>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const nominalWajibPerAnggota = parseFloat(document.getElementById('nominal_wajib_val').value || 0);

    function formatRupiah(angka) {
        return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    function filterPesertaWajibRows() {
        const kw = (document.getElementById('search-peserta-wajib').value || '').toString().trim().toLowerCase();
        const rows = document.querySelectorAll('#tabel-peserta-body tr[data-search]');
        rows.forEach(row => {
            const hay = (row.getAttribute('data-search') || '').toLowerCase();
            row.style.display = (!kw || hay.includes(kw)) ? '' : 'none';
        });
    }

    document.getElementById('search-peserta-wajib').addEventListener('input', filterPesertaWajibRows);

    document.getElementById('select-cabang').addEventListener('change', function() {
        const cabang = this.value;
        const statusMessage = document.getElementById('status-message');
        const cardPeserta = document.getElementById('card-peserta');
        const labelCabang = document.getElementById('label-cabang');
        const tabelBody = document.getElementById('tabel-peserta-body');
        const hiddenCabang = document.getElementById('cabang_terpilih');

        hiddenCabang.value = cabang;

        if (!cabang) {
            cardPeserta.classList.add('d-none');
            statusMessage.classList.remove('d-none');
            statusMessage.innerHTML = `
                <div class="card-body">
                    <div class="ent-empty-icon mb-3">
                        <i class="fas fa-users-cog fa-2x"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Filter Cabang Belum Dipilih</h6>
                    <p class="mb-0 opacity-75 small">Silakan tentukan filter <strong>Cabang Koperasi</strong> terlebih dahulu.</p>
                </div>
            `;
            return;
        }

        statusMessage.classList.remove('d-none');
        statusMessage.innerHTML = `
            <div class="card-body py-4">
                <div class="spinner-border text-primary me-2" role="status"></div>
                <span class="fw-semibold">Menghimpun data anggota aktif cabang...</span>
            </div>
        `;
        cardPeserta.classList.add('d-none');
        tabelBody.innerHTML = '';

        // Ambil Data dari API JSON
        fetch(`{{ route('menu_koperasi_simpanan_wajib_get_data') }}?cabang=${encodeURIComponent(cabang)}`)
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success' && res.data.length > 0) {
                    statusMessage.classList.add('d-none');
                    labelCabang.textContent = cabang.toUpperCase();

                    const options = {
                        month: 'long',
                        year: 'numeric'
                    };
                    const bulanIni = new Date().toLocaleDateString('id-ID', options);

                    res.data.forEach(item => {
                        let checkbox = `<input type="checkbox" name="ids_anggota[]" value="${item.id_kop_master_peserta}" class="form-check-input ent-checkbox check-item">`;
                        let badgeStatus = `<span class="ent-badge badge-belum">Belum Bayar</span>`;
                        let rowClass = '';

                        if (item.sudah_bayar) {
                            checkbox = `<input type="checkbox" class="form-check-input ent-checkbox" disabled checked>`;
                            badgeStatus = `<span class="ent-badge badge-lunas"><i class="fas fa-check me-1"></i> LUNAS</span>`;
                            rowClass = 'row-lunas';
                        }

                        const safeName = (item.kop_master_peserta_name || 'AG').toString();
                        const initial = safeName.substring(0, 2).toUpperCase();
                        const searchText = `${item.kop_master_peserta_code || ''} ${safeName} ${item.kop_master_peserta_nik || ''}`.toLowerCase();

                        const row = `
                            <tr class="${rowClass}" data-search="${searchText.replace(/"/g, '&quot;')}">
                                <td class="text-center">${checkbox}</td>
                                <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">${item.kop_master_peserta_code}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="peserta-avatar">${initial}</div>
                                        <div class="fw-bold text-uppercase" style="font-size: 0.82rem;">${safeName}</div>
                                    </div>
                                </td>
                                <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                                    <span class="opacity-75">NIK: ${item.kop_master_peserta_nik ?? '-'}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold opacity-75"><i class="far fa-calendar-alt text-primary me-1"></i> ${bulanIni}</span>
                                </td>
                                <td class="text-center">${badgeStatus}</td>
                            </tr>
                        `;
                        tabelBody.insertAdjacentHTML('beforeend', row);
                    });

                    cardPeserta.classList.remove('d-none');
                    filterPesertaWajibRows();
                    initCheckboxLogic();
                } else {
                    statusMessage.classList.remove('d-none');
                    statusMessage.innerHTML = `
                        <div class="card-body py-4">
                            <p class="mb-0">Tidak ada anggota di cabang <strong>${cabang}</strong>.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error(error);
                statusMessage.classList.remove('d-none');
                statusMessage.innerHTML = `
                    <div class="card-body py-4">
                        <span class="text-danger fw-semibold">Gagal memuat data dari database.</span>
                    </div>
                `;
            });
    });

    // Logika Fungsi Pilihan Checkbox Massal
    function initCheckboxLogic() {
        const checkAll = document.getElementById('check-all');
        const checkItems = document.querySelectorAll('.check-item');
        const btnSubmit = document.getElementById('btn-submit-massal');
        const textTotal = document.getElementById('total-terpilih');
        const textNominal = document.getElementById('total-nominal-wajib');

        checkAll.checked = false;
        checkAll.disabled = checkItems.length === 0;
        textTotal.textContent = '0';
        textNominal.textContent = 'Rp 0';
        btnSubmit.disabled = true;

        checkAll.onchange = function() {
            checkItems.forEach(item => {
                if (item.closest('tr').style.display !== 'none') {
                    item.checked = this.checked;
                }
            });
            updateFooterStatus();
        };

        checkItems.forEach(item => {
            item.onchange = function() {
                if (!this.checked) checkAll.checked = false;
                if (checkItems.length > 0 && document.querySelectorAll('.check-item:checked').length === checkItems.length) {
                    checkAll.checked = true;
                }
                updateFooterStatus();
            };
        });

        function updateFooterStatus() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            textTotal.textContent = checkedCount;
            textNominal.textContent = formatRupiah(checkedCount * nominalWajibPerAnggota);
            btnSubmit.disabled = checkedCount === 0;
        }
    }

    // Konfirmasi SweetAlert2 saat Submit Form
    document.getElementById('form-simpanan-wajib').addEventListener('submit', function(e) {
        const form = this;
        if (form.dataset.confirmed === 'true') {
            return true;
        }
        e.preventDefault();

        const checkedCount = document.querySelectorAll('.check-item:checked').length;
        const totalNominalStr = document.getElementById('total-nominal-wajib').textContent;

        Swal.fire({
            title: 'Konfirmasi Bayar Massal',
            text: `Proses pembayaran simpanan wajib kolektif untuk ${checkedCount} anggota terpilih dengan total ${totalNominalStr}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Proses Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.dataset.confirmed = 'true';
                form.submit();
            }
        });
    });
</script>
@endsection
