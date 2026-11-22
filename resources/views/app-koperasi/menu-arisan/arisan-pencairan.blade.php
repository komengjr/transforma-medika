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
       MODERN ENTERPRISE UI STYLES (PENCAIRAN ARISAN)
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
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .ent-card:hover {
        border-color: rgba(79, 70, 229, 0.5);
        box-shadow: 0 10px 24px -4px rgba(15, 23, 42, 0.12);
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

    /* Tracking Status Pills */
    .badge-status {
        display: inline-flex;
        align-items: center;
        border-radius: 8px;
        padding: 4px 8px;
        margin: 2px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.68rem;
        font-weight: 700;
    }

    .status-lunas {
        background-color: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .status-belum {
        background-color: rgba(225, 29, 72, 0.14);
        color: #e11d48;
        border: 1px solid rgba(225, 29, 72, 0.35);
    }

    /* Nominal Highlight Box */
    .ent-nominal-box {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.09), rgba(79, 70, 229, 0.07));
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 14px;
        text-align: center;
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
                    <div class="col-lg-9 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-hand-holding-usd fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-money-bill-wave me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} PAYOUT
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Pencairan Paket Dana Arisan</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Pencairan Paket Dana Arisan</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pencairan dihitung mandiri berdasarkan plot kapasitas poin pada bulan klaim berjalan ($\text{Poin Bulan Ini} \times \text{Rate} \times 12$).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER PANEL -->
<div class="ent-card ent-table-surface mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <h6 class="card-title mb-0 fw-bold">
            <i class="fas fa-filter text-primary me-2"></i>Filter Periode Klaim Pencairan Arisan
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <form id="formFilterPencairan" class="row g-2 align-items-center" onsubmit="loadPemenangArisan(event)">
            <div class="col-md-4">
                <div class="form-floating-custom">
                    <label for="pencairanMaster">1. Program Arisan <span class="text-danger">*</span></label>
                    <select id="pencairanMaster" class="form-select ent-input" required></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating-custom">
                    <label for="pencairanTahun">2. Tahun <span class="text-danger">*</span></label>
                    <select id="pencairanTahun" class="form-select ent-input" required>
                        <option value="">-- Pilih Tahun --</option>
                        @for ($year = 2026; $year <= 2035; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating-custom">
                    <label for="pencairanBulan">3. Bulan Klaim <span class="text-danger">*</span></label>
                    <select id="pencairanBulan" class="form-select ent-input" required>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn ent-btn ent-btn-primary w-100" style="height: 44px;">
                    <i class="fas fa-search me-1"></i> Cek Klaim
                </button>
            </div>
        </form>
    </div>
</div>

<!-- WRAPPER KANDIDAT / PENERIMA PENCAIRAN -->
<div id="wrapperPemenang" class="row g-3">
    <div class="col-12">
        <div class="ent-card ent-table-surface py-5 px-3 text-center">
            <div class="card-body">
                <div class="ent-empty-icon mb-3">
                    <i class="fas fa-gift fa-2x"></i>
                </div>
                <h6 class="fw-bold mb-1">Data Klaim Pencairan Belum Dimuat</h6>
                <p class="mb-0 opacity-75 small">Pilih <strong>Program Arisan</strong>, <strong>Tahun</strong>, dan <strong>Bulan Klaim</strong> lalu klik <strong>Cek Klaim</strong>.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL KONFIRMASI PENCAIRAN DANA -->
<div class="modal fade" id="modalPencairan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalPencairanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="ent-badge mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.62rem;">
                        <i class="fas fa-wallet me-1"></i> EKSEKUSI PENCAIRAN DANA
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0" id="modalPencairanLabel">Konfirmasi Pencairan Dana</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEksekusiPencairan" onsubmit="submitPencairan(event)" class="ent-modal-form">
                <div class="modal-body p-4">
                    <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <span class="ent-modal-label d-block mb-1">Penerima / Anggota</span>
                        <h5 id="modalNamaPeserta" class="fw-bold text-uppercase mb-0">-</h5>
                        <small id="modalKodePeserta" class="opacity-75" style="font-family: 'JetBrains Mono', monospace;">-</small>
                    </div>

                    <div class="ent-nominal-box mb-3">
                        <span class="ent-modal-label d-block mb-1">Nominal Yang Akan Dicairkan</span>
                        <h3 id="modalNominal" class="fw-bold text-success mb-1" style="font-family: 'JetBrains Mono', monospace;">Rp 0</h3>
                        <small id="modalDetailHitungan" class="opacity-75 d-block" style="font-size: 0.74rem;">-</small>
                    </div>

                    <input type="hidden" id="submitIdPeserta">
                    <input type="hidden" id="submitNominal">
                    <input type="hidden" id="submitPoin">

                    <div class="mb-3">
                        <label for="pencairanAkun" class="form-label ent-modal-label">Pilih Akun Sumber Dana (Pencairan) <span class="text-danger">*</span></label>
                        <select id="pencairanAkun" class="form-select" required>
                            <option value="">-- Hubungkan ke Akun Kas/Bank --</option>
                            @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="pencairanKeterangan" class="form-label ent-modal-label">Keterangan Tambahan (Opsional)</label>
                        <textarea id="pencairanKeterangan" class="form-control" rows="2" placeholder="Masukkan catatan transfer atau memo..."></textarea>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 d-flex justify-content-end gap-2" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-success px-4">
                        <i class="fas fa-check-circle me-1"></i> Setujui &amp; Cairkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const namaBulanIndo = {
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
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let modalPencairanInstance;

    async function initPencairanPage() {
        modalPencairanInstance = new bootstrap.Modal(document.getElementById('modalPencairan'));
        try {
            const res = await fetch(`{{ route('menu_koperasi_pencairan_arisan_get_data') }}`);
            const data = await res.json();

            const selectMaster = document.getElementById('pencairanMaster');
            selectMaster.innerHTML = '<option value="">-- Pilih Arisan --</option>';
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

    async function loadPemenangArisan(event) {
        if (event) event.preventDefault();
        const idMaster = document.getElementById('pencairanMaster').value;
        const tahun = document.getElementById('pencairanTahun').value;
        const bulan = document.getElementById('pencairanBulan').value;

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/pencairan-arisan/cek-pemenang') }}?id_master=${idMaster}&tahun=${tahun}&bulan=${bulan}`);
            const data = await res.json();

            const wrapper = document.getElementById('wrapperPemenang');
            wrapper.innerHTML = '';

            if (!data.pemenang || data.pemenang.length === 0) {
                wrapper.innerHTML = `
                    <div class="col-12">
                        <div class="ent-card ent-table-surface py-5 px-3 text-center">
                            <div class="card-body">
                                <div class="ent-empty-icon mb-3" style="color: var(--ent-amber);">
                                    <i class="fas fa-calendar-times fa-2x"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Tidak Ada Jadwal Pencairan</h6>
                                <p class="mb-0 opacity-75 small">Tidak ada jadwal pencairan poin anggota pada periode <strong>${namaBulanIndo[bulan]} ${tahun}</strong>.</p>
                            </div>
                        </div>
                    </div>
                `;
                return;
            }

            data.pemenang.forEach(p => {
                let trackingHTML = '';
                (p.review_pembayaran || []).forEach(rev => {
                    let badgeClass = (rev.status === 'Lunas') ? 'status-lunas' : 'status-belum';
                    let iconClass = (rev.status === 'Lunas') ? 'fa-check-circle me-1' : 'fa-times-circle me-1';
                    trackingHTML += `<span class="badge-status ${badgeClass}"><i class="fas ${iconClass}"></i>${namaBulanIndo[rev.bulan]}: ${rev.status}</span>`;
                });

                let buttonHTML = '';
                if (p.is_sudah_cair) {
                    buttonHTML = `
                        <button type="button" class="btn ent-btn btn-secondary w-100 py-2" disabled style="opacity: 0.75;">
                            <i class="fas fa-check-double me-1"></i> DANA PAKET INI SUDAH CAIR
                        </button>
                    `;
                } else if (!p.is_siap_cair) {
                    buttonHTML = `
                        <button type="button" class="btn ent-btn w-100 py-2" disabled
                            style="background-color: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35); opacity: 1;">
                            <i class="fas fa-lock me-1"></i> BLOCKED: IURAN BULANAN BELUM LUNAS
                        </button>
                    `;
                } else {
                    const stringifiedData = encodeURIComponent(JSON.stringify(p));
                    buttonHTML = `
                        <button type="button" class="btn ent-btn ent-btn-success w-100 py-2"
                            onclick="tampilkanModalCair('${stringifiedData}', ${data.nominal_rate})">
                            <i class="fas fa-money-check-alt me-1"></i> CAIRKAN Rp ${new Intl.NumberFormat('id-ID').format(p.nominal_pencairan)}
                        </button>
                    `;
                }

                let card = `
                    <div class="col-lg-6">
                        <div class="ent-card ent-table-surface h-100">
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2 gap-2 flex-wrap">
                                        <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);">
                                            <i class="fas fa-calendar-check me-1"></i> Jadwal Cair Bulan ${namaBulanIndo[bulan]}
                                        </span>
                                        <span class="ent-badge" style="background: rgba(15, 23, 42, 0.12); border: 1px solid var(--ent-grid-border); font-family: 'JetBrains Mono', monospace;">
                                            ${p.poin_bulan_ini} Poin Paket
                                        </span>
                                    </div>

                                    <h5 class="fw-bold text-uppercase mb-1">${p.nama_peserta}</h5>
                                    <p class="opacity-75 small pb-3 mb-3" style="border-bottom: 1px solid var(--ent-grid-border); font-family: 'JetBrains Mono', monospace;">
                                        ${p.kode_peserta} | ${p.cabang}
                                    </p>

                                    <div class="ent-nominal-box mb-3">
                                        <span class="ent-modal-label d-block mb-1">Total Dana Hak Cair Bulan Ini</span>
                                        <h3 class="fw-bold text-success mb-1" style="font-family: 'JetBrains Mono', monospace;">
                                            Rp ${new Intl.NumberFormat('id-ID').format(p.nominal_pencairan)}
                                        </h3>
                                        <small class="opacity-75 d-block" style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">
                                            Hitungan: ${p.poin_bulan_ini} Poin x Rp ${new Intl.NumberFormat('id-ID').format(data.nominal_rate)} x 12 Bulan
                                        </small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="ent-modal-label mb-2 d-block">
                                            <i class="fas fa-clipboard-check text-primary me-1"></i> Status Iuran Wajib (Jan s/d ${namaBulanIndo[bulan]}):
                                        </label>
                                        <div class="d-flex flex-wrap">${trackingHTML}</div>
                                    </div>
                                </div>

                                <div>${buttonHTML}</div>
                            </div>
                        </div>
                    </div>
                `;
                wrapper.innerHTML += card;
            });

        } catch (err) {
            console.error(err);
        }
    }

    function tampilkanModalCair(encodedData, nominalRate) {
        const dataPeserta = JSON.parse(decodeURIComponent(encodedData));
        const bulanText = namaBulanIndo[document.getElementById('pencairanBulan').value];

        document.getElementById('modalNamaPeserta').innerText = dataPeserta.nama_peserta;
        document.getElementById('modalKodePeserta').innerText = `${dataPeserta.kode_peserta} | ${dataPeserta.cabang}`;
        document.getElementById('modalNominal').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(dataPeserta.nominal_pencairan)}`;
        document.getElementById('modalDetailHitungan').innerText = `Hitungan: ${dataPeserta.poin_bulan_ini} Poin x Rp ${new Intl.NumberFormat('id-ID').format(nominalRate)} x 12 Bulan (Bulan ${bulanText})`;

        document.getElementById('submitIdPeserta').value = dataPeserta.id_peserta;
        document.getElementById('submitNominal').value = dataPeserta.nominal_pencairan;
        document.getElementById('submitPoin').value = dataPeserta.poin_bulan_ini;

        document.getElementById('pencairanKeterangan').value = `Pencairan Klaim Paket ${dataPeserta.poin_bulan_ini} Poin Terjadwal (${bulanText})`;
        document.getElementById('pencairanAkun').value = "";

        modalPencairanInstance.show();
    }

    async function submitPencairan(event) {
        event.preventDefault();

        const idPeserta = document.getElementById('submitIdPeserta').value;
        const nominal = parseFloat(document.getElementById('submitNominal').value);
        const akunKeuangan = document.getElementById('pencairanAkun').value;
        const keterangan = document.getElementById('pencairanKeterangan').value;

        const payload = {
            id_kop_master_arisan: parseInt(document.getElementById('pencairanMaster').value),
            id_kop_master_peserta: parseInt(idPeserta),
            kop_pencairan_bulan: parseInt(document.getElementById('pencairanBulan').value),
            kop_pencairan_tahun: parseInt(document.getElementById('pencairanTahun').value),
            kop_pencairan_nominal: nominal,
            id_akun_keuangan: akunKeuangan,
            kop_pencairan_keterangan: keterangan
        };

        try {
            const res = await fetch(`{{ route('menu_koperasi_pencairan_arisan_proses') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });
            const result = await res.json();

            if (res.ok) {
                Swal.fire('Berhasil!', result.message, 'success');
                modalPencairanInstance.hide();
                loadPemenangArisan(null);
            } else {
                Swal.fire('Gagal', result.message || 'Gagal memproses pencairan kas.', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Terjadi kesalahan jaringan.', 'error');
        }
    }

    window.onload = initPencairanPage;
</script>
@endsection
