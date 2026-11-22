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
       MODERN ENTERPRISE UI STYLES (LAPORAN KEUANGAN)
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

    .ent-btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.22);
    }

    .ent-btn-warning:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(217, 119, 6, 0.32);
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

    .ent-form .form-control[readonly] {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    /* Navigation Tabs */
    .ent-nav-tabs {
        background-color: var(--ent-surface);
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 6px;
        box-shadow: 0 4px 14px -2px rgba(15, 23, 42, 0.05);
        gap: 4px;
    }

    .ent-nav-tabs .nav-link {
        border: none !important;
        border-radius: 10px !important;
        color: var(--ent-text);
        opacity: 0.78;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 10px 12px;
        transition: all 0.2s ease;
    }

    .ent-nav-tabs .nav-link:hover {
        opacity: 1;
        background-color: rgba(79, 70, 229, 0.08);
    }

    .ent-nav-tabs .nav-link.active {
        opacity: 1;
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
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

    .jurnal-group-header td {
        background-color: rgba(79, 70, 229, 0.08) !important;
    }

    .jurnal-spacer td {
        padding: 3px !important;
        background-color: rgba(79, 70, 229, 0.02) !important;
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

    .ent-modal-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    /* Tweak khusus untuk Mode Cetak / Print Printer */
    @media print {
        .no-print {
            display: none !important;
        }

        .print-card,
        .ent-card {
            border: none !important;
            box-shadow: none !important;
        }

        .page-break {
            page-break-before: always;
        }
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<div class="row mb-3 no-print">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-book-open fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-calculator me-1"></i> {{ Env('APP_LABEL', 'KOPERASI') }} ACCOUNTING
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Jurnal Otomatis &amp; Laporan</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Pusat Laporan Keuangan Koperasi</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Jurnal Umum, Buku Besar, Laba Rugi, Perubahan Modal, Neraca, dan Arus Kas.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 d-flex align-items-center justify-content-lg-end gap-2">
                        <button type="button" onclick="window.print()" class="btn ent-btn ent-glass-pill px-3 py-2">
                            <i class="fas fa-print me-1 text-info"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER PERIODE LAPORAN -->
<div class="ent-card ent-table-surface p-3 p-md-4 mb-3 no-print">
    <div class="row g-3 align-items-end ent-form">
        <div class="col-md-3">
            <label class="form-label ent-form-label">Tanggal Mulai</label>
            <input type="date" id="global-tgl-mulai" class="form-control" value="<?= date('Y-m-01') ?>" style="font-family: 'JetBrains Mono', monospace;">
        </div>
        <div class="col-md-3">
            <label class="form-label ent-form-label">Tanggal Selesai</label>
            <input type="date" id="global-tgl-selesai" class="form-control" value="<?= date('Y-m-t') ?>" style="font-family: 'JetBrains Mono', monospace;">
        </div>
        <div class="col-md-4" id="wrapper-select-coa" style="display:none;">
            <label class="form-label ent-form-label">Pilih Akun COA (Buku Besar)</label>
            <select id="bb-coa-code" class="form-select">
                @foreach ($coa as $coas)
                <option value="{{ $coas->coa_code }}">{{ $coas->coa_code }} - {{ $coas->coa_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" onclick="loadLaporanAktif()" class="btn ent-btn ent-btn-primary w-100 py-2">
                <i class="fas fa-sync-alt me-1"></i> Buka Laporan
            </button>
        </div>
    </div>
</div>

<!-- TAB NAVIGASI 6 LAPORAN KEUANGAN -->
<ul class="nav nav-pills nav-fill mb-3 ent-nav-tabs no-print" id="laporanTab" role="tablist">
    <li class="nav-item"><button type="button" class="nav-link active text-uppercase" onclick="switchLaporan('jurnal', this)">1. Jurnal Umum</button></li>
    <li class="nav-item"><button type="button" class="nav-link text-uppercase" onclick="switchLaporan('bukubesar', this)">2. Buku Besar</button></li>
    <li class="nav-item"><button type="button" class="nav-link text-uppercase" onclick="switchLaporan('labarugi', this)">3. Laba Rugi</button></li>
    <li class="nav-item"><button type="button" class="nav-link text-uppercase" onclick="switchLaporan('modal', this)">4. Perubahan Modal</button></li>
    <li class="nav-item"><button type="button" class="nav-link text-uppercase" onclick="switchLaporan('neraca', this)">5. Neraca</button></li>
    <li class="nav-item"><button type="button" class="nav-link text-uppercase" onclick="switchLaporan('aruskas', this)">6. Arus Kas</button></li>
</ul>

<!-- AREA KONTEN LAPORAN DINAMIS -->
<div class="ent-card ent-table-surface mb-3 p-3 p-md-4 print-card" id="area-print-laporan">
    <div id="konten-laporan-dinamis">
    </div>
</div>

<!-- MODAL EDIT / KOREKSI JURNAL UMUM -->
<div class="modal fade no-print" id="modalEditJurnal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="ent-badge mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.62rem;">
                        <i class="fas fa-edit me-1"></i> KOREKSI JURNAL DOUBLE-ENTRY
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0">Edit Transaksi Jurnal Umum</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 ent-form">
                <input type="hidden" id="edit_jurnal_no_bukti_lama">

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label ent-form-label">Nomor Bukti Jurnal</label>
                        <input type="text" class="form-control fw-bold text-primary" id="edit_jurnal_no_bukti" style="font-family: 'JetBrains Mono', monospace;" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label ent-form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_jurnal_tgl" style="font-family: 'JetBrains Mono', monospace;" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label ent-form-label">Keterangan / Uraian Transaksi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_jurnal_keterangan" placeholder="Keterangan jurnal..." required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0 small text-uppercase">
                        <i class="fas fa-list-ul me-2 text-primary"></i>Rincian Baris Akun (Debit &amp; Kredit)
                    </h6>
                    <button type="button" class="btn btn-sm ent-btn ent-btn-primary px-3 py-1" onclick="tambahBarisEditJurnal()">
                        <i class="fas fa-plus me-1"></i> Tambah Baris Akun
                    </button>
                </div>

                <div class="table-responsive rounded-3 mb-3" style="border: 1px solid var(--ent-grid-border);">
                    <table class="table table-custom align-middle mb-0 w-100" id="table-edit-jurnal-rows">
                        <thead>
                            <tr>
                                <th style="width: 44%;">Akun Rekening (COA)</th>
                                <th style="width: 24%;" class="text-end">Debit (Rp)</th>
                                <th style="width: 24%;" class="text-end">Kredit (Rp)</th>
                                <th style="width: 8%;" class="text-center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-edit-jurnal">
                            <!-- Baris jurnal diisi via JS -->
                        </tbody>
                        <tfoot>
                            <tr style="background-color: rgba(79, 70, 229, 0.08);">
                                <td class="fw-bold text-uppercase text-end">Total Debit &amp; Kredit :</td>
                                <td class="text-end fw-bold text-success" id="edit-total-debit" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                <td class="text-end fw-bold text-danger" id="edit-total-kredit" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div id="edit-balance-indicator" class="alert py-2 px-3 small fw-bold mb-0 text-center rounded-3">
                    Menghitung keseimbangan jurnal...
                </div>
            </div>
            <div class="modal-footer px-4 py-3" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-3 py-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn ent-btn ent-btn-success px-4 py-2" id="btn-simpan-koreksi-jurnal" onclick="simpanKoreksiJurnal()">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan Jurnal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-penjualan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-penjualan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-penjualan"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let laporanAktif = 'jurnal';
    let cachedGroupedJurnal = {};
    let modalEditJurnalInstance = null;

    // Daftar COA dari Blade untuk opsi dropdown di modal koreksi jurnal
    const daftarCoaMaster = @json($coa);

    function buildCoaOptionsHtml(selectedCode = '') {
        let options = `<option value="">-- Pilih Akun COA --</option>`;
        daftarCoaMaster.forEach(c => {
            const isSelected = String(c.coa_code) === String(selectedCode) ? 'selected' : '';
            options += `<option value="${c.coa_code}" ${isSelected}>[${c.coa_code}] ${c.coa_name}</option>`;
        });
        return options;
    }

    function switchLaporan(tipe, btnEl) {
        laporanAktif = tipe;

        // Tampilkan dropdown pilih COA hanya jika menu Buku Besar aktif
        document.getElementById('wrapper-select-coa').style.display = (tipe === 'bukubesar') ? 'block' : 'none';

        // Ubah status aktif tombol tab
        document.querySelectorAll('#laporanTab .nav-link').forEach(btn => btn.classList.remove('active'));
        if (btnEl) {
            btnEl.classList.add('active');
        }

        loadLaporanAktif();
    }

    function openEditJurnalModal(noBukti) {
        const jurnal = cachedGroupedJurnal[noBukti];
        if (!jurnal) {
            Swal.fire('Perhatian', 'Data transaksi jurnal tidak ditemukan.', 'warning');
            return;
        }

        document.getElementById('edit_jurnal_no_bukti_lama').value = noBukti;
        document.getElementById('edit_jurnal_no_bukti').value = noBukti;
        document.getElementById('edit_jurnal_tgl').value = jurnal.tanggal;
        document.getElementById('edit_jurnal_keterangan').value = jurnal.keterangan || '';

        const tbody = document.getElementById('tbody-edit-jurnal');
        tbody.innerHTML = '';

        jurnal.details.forEach(detail => {
            tambahBarisEditJurnal(detail);
        });

        hitungTotalEditJurnal();

        if (!modalEditJurnalInstance) {
            modalEditJurnalInstance = new bootstrap.Modal(document.getElementById('modalEditJurnal'));
        }
        modalEditJurnalInstance.show();
    }

    function tambahBarisEditJurnal(detail = null) {
        const tbody = document.getElementById('tbody-edit-jurnal');
        const tr = document.createElement('tr');

        const idJurnal = detail && detail.id ? detail.id : '';
        const coaCode = detail ? detail.coa_code : '';
        const debitVal = detail ? Number(detail.debit || 0) : 0;
        const kreditVal = detail ? Number(detail.kredit || 0) : 0;

        tr.innerHTML = `
            <td>
                <input type="hidden" class="edit-row-id" value="${idJurnal}">
                <select class="form-select edit-row-coa" required>
                    ${buildCoaOptionsHtml(coaCode)}
                </select>
            </td>
            <td>
                <input type="number" step="any" min="0" class="form-control text-end edit-row-debit" value="${debitVal}" style="font-family: 'JetBrains Mono', monospace;" oninput="hitungTotalEditJurnal()">
            </td>
            <td>
                <input type="number" step="any" min="0" class="form-control text-end edit-row-kredit" value="${kreditVal}" style="font-family: 'JetBrains Mono', monospace;" oninput="hitungTotalEditJurnal()">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm ent-btn btn-outline-danger py-1 px-2" onclick="hapusBarisEditJurnal(this)" title="Hapus Baris">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        hitungTotalEditJurnal();
    }

    function hapusBarisEditJurnal(btn) {
        const tbody = document.getElementById('tbody-edit-jurnal');
        if (tbody.querySelectorAll('tr').length <= 2) {
            Swal.fire('Minimal 2 Baris', 'Transaksi double-entry minimal memiliki 2 baris akun (Debit dan Kredit).', 'warning');
            return;
        }
        btn.closest('tr').remove();
        hitungTotalEditJurnal();
    }

    function hitungTotalEditJurnal() {
        let totalDebit = 0;
        let totalKredit = 0;

        document.querySelectorAll('#tbody-edit-jurnal tr').forEach(row => {
            totalDebit += parseFloat(row.querySelector('.edit-row-debit').value) || 0;
            totalKredit += parseFloat(row.querySelector('.edit-row-kredit').value) || 0;
        });

        document.getElementById('edit-total-debit').textContent = 'Rp ' + totalDebit.toLocaleString('id-ID');
        document.getElementById('edit-total-kredit').textContent = 'Rp ' + totalKredit.toLocaleString('id-ID');

        const indicator = document.getElementById('edit-balance-indicator');
        const btnSave = document.getElementById('btn-simpan-koreksi-jurnal');
        const isBalanced = totalDebit > 0 && Math.abs(totalDebit - totalKredit) < 0.01;

        if (isBalanced) {
            indicator.className = 'alert alert-success py-2 px-3 small fw-bold mb-0 text-center rounded-3';
            indicator.innerHTML = `<i class="fas fa-check-circle me-1"></i> JURNAL SEIMBANG (BALANCE) — Rp ${totalDebit.toLocaleString('id-ID')}`;
            btnSave.disabled = false;
        } else {
            const selisih = Math.abs(totalDebit - totalKredit);
            indicator.className = 'alert alert-danger py-2 px-3 small fw-bold mb-0 text-center rounded-3';
            indicator.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i> TIDAK SEIMBANG (UNBALANCED) — Selisih: Rp ${selisih.toLocaleString('id-ID')}`;
            btnSave.disabled = true;
        }
    }

    function simpanKoreksiJurnal() {
        const noBukti = document.getElementById('edit_jurnal_no_bukti').value;
        const tanggal = document.getElementById('edit_jurnal_tgl').value;
        const keterangan = document.getElementById('edit_jurnal_keterangan').value.trim();

        if (!tanggal || !keterangan) {
            Swal.fire('Form Belum Lengkap', 'Tanggal dan keterangan transaksi wajib diisi.', 'warning');
            return;
        }

        const details = [];
        let validRows = true;

        document.querySelectorAll('#tbody-edit-jurnal tr').forEach(row => {
            const id = row.querySelector('.edit-row-id').value;
            const coaCode = row.querySelector('.edit-row-coa').value;
            const debit = parseFloat(row.querySelector('.edit-row-debit').value) || 0;
            const kredit = parseFloat(row.querySelector('.edit-row-kredit').value) || 0;

            if (!coaCode || (debit === 0 && kredit === 0)) {
                validRows = false;
            }

            details.push({
                id: id,
                coa_code: coaCode,
                jurnal_debit: debit,
                jurnal_kredit: kredit
            });
        });

        if (!validRows) {
            Swal.fire('Baris Tidak Valid', 'Pastikan setiap baris memiliki Akun COA dan nominal Debit atau Kredit lebih dari 0.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Simpan Koreksi Jurnal?',
            text: `Perubahan pada No. Bukti ${noBukti} akan memperbarui buku besar dan laporan keuangan.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan Koreksi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyimpan Perubahan...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`{{ url('koperasi/akutansi-koperasi/report/jurnal/update') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            jurnal_no_bukti: noBukti,
                            jurnal_tgl: tanggal,
                            jurnal_keterangan: keterangan,
                            details: details
                        })
                    })
                    .then(async res => {
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.message || 'Gagal menyimpan perubahan jurnal.');
                        return data;
                    })
                    .then(res => {
                        Swal.fire('Berhasil!', res.message || 'Koreksi jurnal berhasil disimpan.', 'success').then(() => {
                            if (modalEditJurnalInstance) {
                                modalEditJurnalInstance.hide();
                            }
                            loadLaporanAktif();
                        });
                    })
                    .catch(err => {
                        Swal.fire('Gagal Menyimpan', err.message || 'Terjadi kesalahan saat menyimpan koreksi jurnal.', 'error');
                    });
            }
        });
    }

    function loadLaporanAktif() {
        const tglMulai = document.getElementById('global-tgl-mulai').value;
        const tglSelesai = document.getElementById('global-tgl-selesai').value;
        const container = document.getElementById('konten-laporan-dinamis');

        const params = `?tgl_mulai=${tglMulai}&tgl_selesai=${tglSelesai}`;

        if (laporanAktif === 'jurnal') {
            fetch(`{{ route('akutansi_koperasi_report_jurnal') }}${params}`)
                .then(res => res.json())
                .then(data => {
                    // 1. Kelompokkan data berdasarkan jurnal_no_bukti
                    const groupedJurnal = {};

                    data.forEach(item => {
                        if (!groupedJurnal[item.jurnal_no_bukti]) {
                            groupedJurnal[item.jurnal_no_bukti] = {
                                tanggal: item.jurnal_tgl,
                                keterangan: item.jurnal_keterangan,
                                details: []
                            };
                        }
                        groupedJurnal[item.jurnal_no_bukti].details.push({
                            id: item.id ?? item.id_jurnal ?? '',
                            coa_code: item.coa_code,
                            coa_name: item.coa_name,
                            debit: Number(item.jurnal_debit),
                            kredit: Number(item.jurnal_kredit)
                        });
                    });

                    cachedGroupedJurnal = groupedJurnal;

                    // 2. Susun HTML Tabel dengan Grouping per No Bukti
                    let html = `
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="fw-bold m-0"><i class="fas fa-book me-2 text-primary"></i>Jurnal Umum Koperasi</h5>
                        <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.35);">
                            Metode Double-Entry
                        </span>
                    </div>
                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-custom align-middle mb-0 w-100">
                            <thead class="text-center">
                                <tr>
                                    <th style="width: 15%;">Tanggal / No. Bukti</th>
                                    <th style="width: 35%;">Rekening / Akun COA &amp; Keterangan</th>
                                    <th style="width: 10%;">Ref COA</th>
                                    <th style="width: 16%;" class="text-end">Debit</th>
                                    <th style="width: 16%;" class="text-end">Kredit</th>
                                    <th style="width: 8%;" class="text-center no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>`;

                    const keys = Object.keys(groupedJurnal);
                    if (keys.length === 0) {
                        html += `<tr><td colspan="6" class="text-center py-4 opacity-75">Tidak ada data transaksi jurnal pada periode ini.</td></tr>`;
                    }

                    // 3. Looping kelompok jurnal
                    keys.forEach(noBukti => {
                        const jurnal = groupedJurnal[noBukti];
                        const safeNoBukti = String(noBukti).replace(/'/g, "\\'");

                        // Baris Header untuk nomor bukti, tanggal, dan tombol edit transaksi
                        html += `
                        <tr class="jurnal-group-header fw-bold">
                            <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">
                                <i class="far fa-calendar-alt me-1 text-primary"></i> ${jurnal.tanggal}
                            </td>
                            <td colspan="4" class="text-primary text-uppercase" style="font-family: 'JetBrains Mono', monospace;">
                                <span class="opacity-75 small fw-normal">No. Bukti:</span> ${noBukti}
                            </td>
                            <td class="text-center no-print">
                                <button type="button" class="btn btn-sm ent-btn ent-btn-warning px-2 py-1" onclick="openEditJurnalModal('${safeNoBukti}')" title="Edit / Koreksi Jurnal Transaksi">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </button>
                            </td>
                        </tr>
                    `;

                        // Looping detail akun di dalam nomor bukti tersebut
                        jurnal.details.forEach((detail, index) => {
                            const indentStyle = detail.kredit > 0 ? 'ps-4 opacity-75 fst-italic' : 'fw-semibold';
                            const displayDebit = detail.debit > 0 ? `Rp ${detail.debit.toLocaleString('id-ID')}` : '-';
                            const displayKredit = detail.kredit > 0 ? `Rp ${detail.kredit.toLocaleString('id-ID')}` : '-';

                            const isLastRow = index === jurnal.details.length - 1;
                            const keteranganTambahan = isLastRow ? `<div class="opacity-75 text-capitalize mt-1" style="font-family: 'JetBrains Mono', monospace; font-size: 11px;">* Keterangan: ${jurnal.keterangan}</div>` : '';

                            html += `
                            <tr>
                                <td class="text-center opacity-50 small"></td>
                                <td class="${indentStyle}">
                                    ${detail.coa_name}
                                    ${keteranganTambahan}
                                </td>
                                <td class="text-center fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${detail.coa_code}</td>
                                <td class="text-end text-success fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${displayDebit}</td>
                                <td class="text-end text-danger fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${displayKredit}</td>
                                <td class="no-print"></td>
                            </tr>
                        `;
                        });

                        // Pembatas antar nomor bukti
                        html += `<tr class="jurnal-spacer"><td colspan="6"></td></tr>`;
                    });

                    html += '</tbody></table></div>';
                    container.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = `<div class="alert alert-danger">Gagal memuat struktur data Jurnal Umum.</div>`;
                });
        } else if (laporanAktif === 'bukubesar') {
            const coa = document.getElementById('bb-coa-code').value;
            fetch(`{{ route('akutansi_koperasi_report_buku_besar') }}${params}&coa_code=${coa}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold m-0"><i class="fas fa-layer-group me-2 text-primary"></i>Buku Besar Akun: <span class="text-primary" style="font-family: 'JetBrains Mono', monospace;">${coa}</span></h5>
                    </div>
                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-custom align-middle mb-0 w-100">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No Bukti</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Debit</th>
                                    <th class="text-end">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>`;
                    let saldoAwal = (data.saldo_awal.total_debit || 0) - (data.saldo_awal.total_kredit || 0);
                    html += `<tr style="background-color: rgba(245, 158, 11, 0.14);" class="fw-bold"><td colspan="3">SALDO AWAL MUTASI</td><td colspan="2" class="text-end" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(saldoAwal).toLocaleString('id-ID')}</td></tr>`;
                    data.mutasi.forEach(r => {
                        html += `<tr>
                            <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">${r.jurnal_tgl}</td>
                            <td class="fw-semibold text-primary" style="font-family: 'JetBrains Mono', monospace;">${r.jurnal_no_bukti}</td>
                            <td>${r.jurnal_keterangan}</td>
                            <td class="text-end text-success fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(r.jurnal_debit).toLocaleString('id-ID')}</td>
                            <td class="text-end text-danger fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(r.jurnal_kredit).toLocaleString('id-ID')}</td>
                        </tr>`;
                    });
                    html += '</tbody></table></div>';
                    container.innerHTML = html;
                });
        } else if (laporanAktif === 'labarugi') {
            fetch(`{{ route('akutansi_koperasi_report_rugi_laba') }}${params}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                    <div class="text-center mb-4 pb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <h5 class="fw-bold m-0">LAPORAN LABA RUGI OPERASIONAL</h5>
                        <p class="opacity-75 small mb-0" style="font-family: 'JetBrains Mono', monospace;">Periode: ${document.getElementById('global-tgl-mulai').value} s/d ${document.getElementById('global-tgl-selesai').value}</p>
                    </div>

                    <div class="table-responsive rounded-3 mb-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-custom align-middle mb-0 w-100">
                            <tbody>
                                <tr style="background-color: rgba(79, 70, 229, 0.08);" class="fw-bold">
                                    <td colspan="2" class="text-primary text-uppercase"><i class="fas fa-arrow-trend-up me-2"></i> 1. PENDAPATAN OPERASIONAL</td>
                                    <td></td>
                                </tr>`;

                    if (data.pendapatan.length === 0) {
                        html += `<tr><td colspan="3" class="opacity-75 ps-4 fst-italic">Tidak ada aktivitas pendapatan pada periode ini</td></tr>`;
                    } else {
                        data.pendapatan.forEach(p => {
                            html += `
                            <tr>
                                <td class="ps-4 fw-semibold" style="width: 20%; font-family: 'JetBrains Mono', monospace;">${p.coa_code}</td>
                                <td style="width: 50%;">${p.coa_name}</td>
                                <td class="text-end fw-semibold" style="width: 30%; font-family: 'JetBrains Mono', monospace;">Rp ${Number(p.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `
                                <tr class="fw-bold" style="background-color: rgba(16, 185, 129, 0.14);">
                                    <td colspan="2" class="ps-3 text-uppercase text-success">TOTAL PENDAPATAN (A)</td>
                                    <td class="text-end text-success" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(data.total_pendapatan).toLocaleString('id-ID')}</td>
                                </tr>

                                <tr style="background-color: rgba(79, 70, 229, 0.08);" class="fw-bold">
                                    <td colspan="2" class="text-danger text-uppercase"><i class="fas fa-arrow-trend-down me-2"></i> 2. BEBAN OPERASIONAL</td>
                                    <td></td>
                                </tr>`;

                    if (data.beban.length === 0) {
                        html += `<tr><td colspan="3" class="opacity-75 ps-4 fst-italic">Tidak ada aktivitas beban operasional pada periode ini</td></tr>`;
                    } else {
                        data.beban.forEach(b => {
                            html += `
                            <tr>
                                <td class="ps-4 fw-semibold" style="font-family: 'JetBrains Mono', monospace;">${b.coa_code}</td>
                                <td>${b.coa_name}</td>
                                <td class="text-end text-danger fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(b.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    const isUntung = data.laba_bersih >= 0;
                    const badgeSHUColor = isUntung ? 'alert-success border-success text-success' : 'alert-danger border-danger text-danger';
                    const statusTeks = isUntung ? 'SISA HASIL USAHA (LABA BERSIH)' : 'KERUGIAN OPERASIONAL (RUGI BERSIH)';

                    html += `
                                <tr class="fw-bold" style="background-color: rgba(225, 29, 72, 0.14);">
                                    <td colspan="2" class="ps-3 text-uppercase text-danger">TOTAL BEBAN OPERASIONAL (B)</td>
                                    <td class="text-end text-danger" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(data.total_beban).toLocaleString('id-ID')}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert ${badgeSHUColor} d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border mb-0">
                        <span class="fw-bold text-uppercase"><i class="fas fa-calculator me-2"></i> ${statusTeks} (A - B)</span>
                        <span class="fw-bold fs-5" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(data.laba_bersih).toLocaleString('id-ID')}</span>
                    </div>
                `;

                    container.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = `<div class="alert alert-danger">Gagal memuat rincian Laporan Laba Rugi.</div>`;
                });
        } else if (laporanAktif === 'modal') {
            fetch(`{{ route('akutansi_koperasi_report_perubahan_modal') }}${params}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                    <div class="text-center mb-4 pb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <h5 class="fw-bold m-0">LAPORAN PERUBAHAN MODAL / EKUITAS</h5>
                        <p class="opacity-75 small m-0" style="font-family: 'JetBrains Mono', monospace;">Periode: ${document.getElementById('global-tgl-mulai').value} s/d ${document.getElementById('global-tgl-selesai').value}</p>
                    </div>

                    <div class="table-responsive rounded-3 mb-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-custom align-middle mb-0 w-100">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Kode Akun</th>
                                    <th style="width: 50%;">Komponen Ekuitas Koperasi</th>
                                    <th style="width: 30%;" class="text-end">Saldo Sebelum SHU</th>
                                </tr>
                            </thead>
                            <tbody>`;

                    if (data.detail_modal.length === 0) {
                        html += `<tr><td colspan="3" class="opacity-75 text-center fst-italic py-3">Tidak ditemukan data akun ekuitas</td></tr>`;
                    } else {
                        data.detail_modal.forEach(m => {
                            html += `
                            <tr>
                                <td class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">${m.coa_code}</td>
                                <td>${m.coa_name}</td>
                                <td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(m.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `
                            <tr class="fw-bold" style="background-color: rgba(79, 70, 229, 0.08);">
                                <td colspan="2" class="text-uppercase">Sub-Total Modal Ekuitas (A)</td>
                                <td class="text-end" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(data.total_modal_awal).toLocaleString('id-ID')}</td>
                            </tr>

                            <tr class="fw-bold" style="background-color: rgba(16, 185, 129, 0.14);">
                                <td class="text-success"><i class="fas fa-plus-circle me-1"></i> SHU</td>
                                <td class="text-success">Sisa Hasil Usaha (Laba Bersih) Periode Berjalan (B)</td>
                                <td class="text-end text-success" style="font-family: 'JetBrains Mono', monospace;">+ Rp ${Number(data.laba_bersih_shu).toLocaleString('id-ID')}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>

                    <div class="alert alert-primary d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border border-primary m-0">
                        <span class="fw-bold text-uppercase">
                            <i class="fas fa-landmark me-2"></i> TOTAL MODAL AKHIR KOPERASI (A + B)
                        </span>
                        <span class="fw-bold fs-5" style="font-family: 'JetBrains Mono', monospace;">
                            Rp ${Number(data.total_modal_akhir).toLocaleString('id-ID')}
                        </span>
                    </div>
                `;

                    container.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = `<div class="alert alert-danger">Gagal memuat rincian Laporan Perubahan Modal.</div>`;
                });
        } else if (laporanAktif === 'neraca') {
            fetch(`{{ route('akutansi_koperasi_report_neraca') }}${params}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                    <div class="text-center mb-4 pb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <h5 class="fw-bold m-0">LAPORAN POSISI KEUANGAN (NERACA)</h5>
                        <p class="opacity-75 small m-0" style="font-family: 'JetBrains Mono', monospace;">Kondisi Kumulatif Finansial Koperasi per Tanggal: ${document.getElementById('global-tgl-selesai').value}</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                                <table class="table table-custom align-middle mb-0 w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">Kode</th>
                                            <th style="width: 45%;">AKTIVA (ASET / KEKAYAAN)</th>
                                            <th style="width: 30%;" class="text-end">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                    if (data.aset.length === 0) {
                        html += `<tr><td colspan="3" class="opacity-75 text-center fst-italic">Tidak ada saldo aset lancar/tetap</td></tr>`;
                    } else {
                        data.aset.forEach(a => {
                            html += `
                            <tr>
                                <td class="opacity-75" style="font-family: 'JetBrains Mono', monospace;">${a.coa_code}</td>
                                <td class="fw-semibold">${a.coa_name}</td>
                                <td class="text-end text-success fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(a.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    let selisihBaris = Math.max(0, (data.kewajiban.length + data.modal.length + 2) - data.aset.length);
                    for (let i = 0; i < selisihBaris; i++) {
                        html += `<tr style="visibility:hidden;"><td colspan="3">&nbsp;</td></tr>`;
                    }

                    html += `
                                    </tbody>
                                    <tfoot>
                                        <tr class="fw-bold" style="background-color: rgba(79, 70, 229, 0.14);">
                                            <td colspan="2" class="text-uppercase text-primary"><i class="fas fa-box-open me-2"></i> TOTAL AKTIVA (A)</td>
                                            <td class="text-end text-primary" style="font-family: 'JetBrains Mono', monospace;">Rp ${data.total_aset.toLocaleString('id-ID')}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                                <table class="table table-custom align-middle mb-0 w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">Kode</th>
                                            <th style="width: 45%;">PASIVA (KEWAJIBAN &amp; EKUITAS)</th>
                                            <th style="width: 30%;" class="text-end">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background-color: rgba(79, 70, 229, 0.07);" class="fw-bold opacity-75 small"><td colspan="3">1. LIABILITAS / KEWAJIBAN HUTANG</td></tr>`;

                    if (data.kewajiban.length === 0) {
                        html += `<tr><td colspan="3" class="opacity-75 text-center fst-italic">Tidak ada liabilitas/titipan</td></tr>`;
                    } else {
                        data.kewajiban.forEach(k => {
                            html += `
                            <tr>
                                <td class="opacity-75" style="font-family: 'JetBrains Mono', monospace;">${k.coa_code}</td>
                                <td>${k.coa_name}</td>
                                <td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(k.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `
                                        <tr style="background-color: rgba(79, 70, 229, 0.07);" class="fw-bold opacity-75 small"><td colspan="3">2. EKUITAS / MODAL BERJALAN</td></tr>`;

                    data.modal.forEach(m => {
                        html += `
                        <tr>
                            <td class="opacity-75" style="font-family: 'JetBrains Mono', monospace;">${m.coa_code}</td>
                            <td>${m.coa_name}</td>
                            <td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(m.total).toLocaleString('id-ID')}</td>
                        </tr>`;
                    });

                    html += `
                            <tr style="background-color: rgba(245, 158, 11, 0.12);" class="fw-bold">
                                <td class="opacity-75" style="font-family: 'JetBrains Mono', monospace;">-</td>
                                <td class="fst-italic text-primary"><i class="fas fa-arrow-right me-1"></i> SHU Tahun Berjalan (Laba Bersih)</td>
                                <td class="text-end text-primary" style="font-family: 'JetBrains Mono', monospace;">+ Rp ${data.laba_bersih_berjalan.toLocaleString('id-ID')}</td>
                            </tr>`;

                    let selisihBarisPasiva = Math.max(0, data.aset.length - (data.kewajiban.length + data.modal.length + 2));
                    for (let i = 0; i < selisihBarisPasiva; i++) {
                        html += `<tr style="visibility:hidden;"><td colspan="3">&nbsp;</td></tr>`;
                    }

                    const isBalance = Math.abs(data.total_aset - data.total_pasiva) < 0.01;
                    const statusAlertClass = isBalance ? 'alert-success border-success text-success' : 'alert-danger border-danger text-danger';
                    const statusText = isBalance ? 'DEBIT & KREDIT SEIMBANG (BALANCE)' : 'NERACA TIDAK SEIMBANG (UNBALANCED)';

                    html += `
                                    </tbody>
                                    <tfoot>
                                        <tr class="fw-bold" style="background-color: rgba(16, 185, 129, 0.14);">
                                            <td colspan="2" class="text-uppercase text-success"><i class="fas fa-wallet me-2"></i> TOTAL PASIVA (B)</td>
                                            <td class="text-end text-success" style="font-family: 'JetBrains Mono', monospace;">Rp ${data.total_pasiva.toLocaleString('id-ID')}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="alert ${statusAlertClass} text-center fw-bold mt-4 shadow-sm mb-0 py-2 small">
                        <i class="fas fa-check-circle me-1"></i> STATUS VALIDASI DATA : ${statusText}
                    </div>
                `;

                    container.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = `<div class="alert alert-danger">Gagal memuat rincian Laporan Neraca Koperasi.</div>`;
                });
        } else if (laporanAktif === 'aruskas') {
            fetch(`{{ route('akutansi_koperasi_report_arus_kas') }}${params}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                    <div class="text-center mb-4 pb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <h5 class="fw-bold m-0">LAPORAN ARUS KAS (DIRECT METHOD)</h5>
                        <p class="opacity-75 small m-0">Rincian Aliran Masuk &amp; Keluar Kas / Bank Koperasi</p>
                    </div>

                    <div class="table-responsive rounded-3 mb-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-custom align-middle mb-0 w-100">
                            <tbody>
                                <tr style="background-color: rgba(79, 70, 229, 0.08);" class="fw-bold">
                                    <td colspan="2" class="text-success text-uppercase"><i class="fas fa-arrow-down me-2"></i> 1. ARUS KAS DARI AKTIVITAS OPERASIONAL (MASUK)</td>
                                    <td></td>
                                </tr>`;

                    if (data.arus_masuk_detail.length === 0) {
                        html += `<tr><td colspan="3" class="opacity-75 ps-4 fst-italic">Tidak ada aliran kas masuk</td></tr>`;
                    } else {
                        data.arus_masuk_detail.forEach(m => {
                            html += `
                            <tr>
                                <td class="ps-4 opacity-75" style="width: 20%; font-family: 'JetBrains Mono', monospace;">${m.coa_code}</td>
                                <td style="width: 50%;">Penerimaan dari ${m.coa_name}</td>
                                <td class="text-end text-success fw-semibold" style="width: 30%; font-family: 'JetBrains Mono', monospace;">+ Rp ${Number(m.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `
                                <tr class="fw-bold" style="background-color: rgba(16, 185, 129, 0.14);">
                                    <td colspan="2" class="ps-3 text-uppercase text-success">Total Penerimaan Kas (A)</td>
                                    <td class="text-end text-success" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(data.total_arus_masuk).toLocaleString('id-ID')}</td>
                                </tr>

                                <tr style="background-color: rgba(79, 70, 229, 0.08);" class="fw-bold">
                                    <td colspan="2" class="text-danger text-uppercase"><i class="fas fa-arrow-up me-2"></i> 2. PENGGUNAAN KAS UNTUK AKTIVITAS OPERASIONAL (KELUAR)</td>
                                    <td></td>
                                </tr>`;

                    if (data.arus_keluar_detail.length === 0) {
                        html += `<tr><td colspan="3" class="opacity-75 ps-4 fst-italic">Tidak ada aliran kas keluar</td></tr>`;
                    } else {
                        data.arus_keluar_detail.forEach(k => {
                            html += `
                            <tr>
                                <td class="ps-4 opacity-75" style="font-family: 'JetBrains Mono', monospace;">${k.coa_code}</td>
                                <td>Pengeluaran / Pembayaran ${k.coa_name}</td>
                                <td class="text-end text-danger fw-semibold" style="font-family: 'JetBrains Mono', monospace;">- Rp ${Number(k.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    const isSurplus = data.kenaikan_bersih >= 0;
                    const statusTeks = isSurplus ? 'KENAIKAN BERSIH KAS (SURPLUS)' : 'PENURUNAN BERSIH KAS (DEFISIT)';
                    const badgeColor = isSurplus ? 'alert-primary border-primary text-primary' : 'alert-danger border-danger text-danger';

                    html += `
                                <tr class="fw-bold" style="background-color: rgba(225, 29, 72, 0.14);">
                                    <td colspan="2" class="ps-3 text-uppercase text-danger">Total Pengeluaran Kas (B)</td>
                                    <td class="text-end text-danger" style="font-family: 'JetBrains Mono', monospace;">Rp ${Number(data.total_arus_keluar).toLocaleString('id-ID')}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert ${badgeColor} d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border m-0">
                        <span class="fw-bold text-uppercase">
                            <i class="fas fa-coins me-2"></i> ${statusTeks} (A - B)
                        </span>
                        <span class="fw-bold fs-5" style="font-family: 'JetBrains Mono', monospace;">
                            Rp ${Number(data.kenaikan_bersih).toLocaleString('id-ID')}
                        </span>
                    </div>
                `;

                    container.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = `<div class="alert alert-danger">Gagal memuat rincian Laporan Arus Kas.</div>`;
                });
        }
    }

    // Jalankan otomatis load Jurnal Umum di awal pembukaan form
    document.addEventListener("DOMContentLoaded", function() {
        loadLaporanAktif();
    });
</script>
@endsection
