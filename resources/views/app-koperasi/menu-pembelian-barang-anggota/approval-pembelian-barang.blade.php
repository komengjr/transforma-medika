@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (APPROVAL PENGADAAN)
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

    .ent-btn-danger {
        background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
    }

    .ent-btn-danger:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(225, 29, 72, 0.35);
        color: #ffffff;
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

    .badge-status-approved {
        background-color: rgba(16, 185, 129, 0.16) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.38);
    }

    .badge-status-rejected {
        background-color: rgba(225, 29, 72, 0.16) !important;
        color: #e11d48 !important;
        border: 1px solid rgba(225, 29, 72, 0.38);
    }

    .badge-tenor {
        background-color: rgba(56, 189, 248, 0.16) !important;
        color: #0284c7 !important;
        border: 1px solid rgba(56, 189, 248, 0.35);
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

    .ent-info-box {
        background-color: rgba(79, 70, 229, 0.06);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 14px;
    }

    .ent-fin-card {
        background-color: rgba(79, 70, 229, 0.05);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 14px 10px;
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
                            <i class="fas fa-shield-alt fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-check-double me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} APPROVAL
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Verifikasi Kontrak</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Approval Pengadaan Barang Anggota</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Verifikasi dan setujui kontrak pengadaan barang pembiayaan anggota.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 d-flex align-items-center justify-content-lg-end">
                        <span class="ent-badge px-3 py-2" style="background: rgba(245, 158, 11, 0.18); border: 1px solid rgba(245, 158, 11, 0.45); color: #fcd34d; font-family: 'JetBrains Mono', monospace; font-size: 0.75rem;">
                            <i class="fas fa-clock me-2"></i> Menunggu Verifikasi: {{ count($pendingList) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABEL MENUNGGU APPROVAL -->
<div class="row mb-3">
    <div class="col-12">
        <div class="ent-card ent-table-surface">
            <div class="card-header py-3 px-3 px-md-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-signature text-primary me-2"></i>Daftar Pengajuan Perlu Persetujuan
                </h6>
                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid var(--ent-grid-border);">
                    {{ count($pendingList) }} Pengajuan
                </span>
            </div>
            <div class="card-body ent-card-body-flush">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0 w-100">
                        <thead>
                            <tr>
                                <th>No. Nota</th>
                                <th>Tanggal</th>
                                <th>Anggota</th>
                                <th>Nama Barang</th>
                                <th class="text-end">Harga Beli</th>
                                <th class="text-end">Biaya Admin</th>
                                <th class="text-end">Bunga Koperasi</th>
                                <th class="text-end">Total Piutang</th>
                                <th class="text-center">Tenor</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingList as $row)
                            <tr>
                                <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">{{ $row->nota_nomor }}</td>
                                <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">{{ date('d/m/Y', strtotime($row->tanggal_transaksi)) }}</td>
                                <td>
                                    <div class="fw-bold text-uppercase" style="font-size: 0.8rem;">{{ $row->kop_master_peserta_name }}</div>
                                    <small class="opacity-75" style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">{{ $row->kop_master_peserta_code }}</small>
                                </td>
                                <td class="fw-semibold">{{ $row->barang_nama }}</td>
                                <td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->harga_beli, 0, ',', '.') }}</td>
                                <td class="text-end text-info fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end text-success fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->bunga_koperasi ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->total_piutang, 0, ',', '.') }}</td>
                                <td class="text-center"><span class="ent-badge badge-tenor">{{ $row->tenor_bulan }} Bln</span></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm ent-btn ent-btn-primary px-3 py-1" onclick="openApprovalModal({{ $row->id }})">
                                        <i class="fas fa-search me-1"></i> Verifikasi
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 opacity-75">
                                    <i class="fas fa-check-circle fs-3 d-block mb-2 text-success"></i>
                                    Tidak ada pengajuan yang menunggu persetujuan saat ini.
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

<!-- TABEL RIWAYAT APPROVAL TERAKHIR -->
<div class="row">
    <div class="col-12">
        <div class="ent-card ent-table-surface">
            <div class="card-header py-3 px-3 px-md-4">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-history text-secondary me-2"></i>Riwayat Verifikasi Terakhir
                </h6>
            </div>
            <div class="card-body ent-card-body-flush">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0 w-100">
                        <thead>
                            <tr>
                                <th>No. Nota</th>
                                <th>Anggota</th>
                                <th>Barang</th>
                                <th class="text-end">Total Piutang</th>
                                <th class="text-center">Status</th>
                                <th>Diverifikasi Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyList as $h)
                            <tr>
                                <td class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ $h->nota_nomor }}</td>
                                <td class="fw-semibold text-uppercase" style="font-size: 0.8rem;">{{ $h->kop_master_peserta_name }}</td>
                                <td>{{ $h->barang_nama }}</td>
                                <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($h->total_piutang, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($h->status_pembelian == 'APPROVED')
                                    <span class="ent-badge badge-status-approved"><i class="fas fa-check me-1"></i>Disetujui</span>
                                    @else
                                    <span class="ent-badge badge-status-rejected"><i class="fas fa-times me-1"></i>Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="d-block fw-semibold">{{ $h->approved_by ?? '-' }}</small>
                                    <small class="opacity-75" style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">{{ $h->approved_at ? date('d/m/Y H:i', strtotime($h->approved_at)) : '' }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VERIFIKASI APPROVAL -->
<div class="modal fade" id="modalApproval" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-ent-content">
            <div class="ent-modal-banner py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="ent-badge mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.62rem;">
                        <i class="fas fa-shield-alt me-1"></i> PEMERIKSAAN KONTRAK &amp; JURNAL
                    </span>
                    <h5 class="modal-title fw-bold text-white mb-0">Verifikasi Pengajuan Pembelian</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="modal_pembelian_id">

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="ent-info-box h-100">
                            <small class="opacity-75 d-block fw-bold text-uppercase" style="font-size: 0.68rem;">Nomor Nota</small>
                            <span class="fw-bold text-primary" id="v_nota" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ent-info-box h-100">
                            <small class="opacity-75 d-block fw-bold text-uppercase" style="font-size: 0.68rem;">Nama Anggota</small>
                            <span class="fw-bold text-uppercase" id="v_anggota" style="font-size: 0.85rem; white-space: pre-line;">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <small class="opacity-75 d-block fw-bold text-uppercase" style="font-size: 0.68rem;">Nama Barang</small>
                        <span class="fw-bold" id="v_barang">-</span>
                    </div>
                    <div class="col-md-6">
                        <small class="opacity-75 d-block fw-bold text-uppercase" style="font-size: 0.68rem;">Tanggal Transaksi</small>
                        <span class="fw-bold" id="v_tanggal" style="font-family: 'JetBrains Mono', monospace;">-</span>
                    </div>
                </div>

                <!-- RINCIAN FINANSIAL -->
                <div class="ent-fin-card mb-4">
                    <div class="row g-2 text-center">
                        <div class="col-6 col-md-3">
                            <small class="opacity-75 d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Harga Beli Supplier</small>
                            <span class="fw-bold" id="v_harga" style="font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">Rp 0</span>
                        </div>
                        <div class="col-6 col-md-3">
                            <small class="opacity-75 d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Biaya Admin</small>
                            <span class="fw-bold text-info" id="v_admin" style="font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">Rp 0</span>
                        </div>
                        <div class="col-6 col-md-3">
                            <small class="opacity-75 d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Bunga Koperasi</small>
                            <span class="fw-bold text-success" id="v_bunga" style="font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">Rp 0</span>
                        </div>
                        <div class="col-6 col-md-3">
                            <small class="opacity-75 d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Total Piutang</small>
                            <span class="fw-bold text-primary" id="v_total" style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem;">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- RINCIAN JURNAL COA TERPILIH -->
                <h6 class="fw-bold mb-2 small text-uppercase">
                    <i class="fas fa-book me-2 text-primary"></i>Peta Jurnal Akuntansi Terpilih
                </h6>
                <div class="table-responsive rounded-3 mb-4" style="border: 1px solid var(--ent-grid-border);">
                    <table class="table table-custom align-middle mb-0 w-100">
                        <thead>
                            <tr>
                                <th>Pos Jurnal</th>
                                <th>Kode COA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Debet: Piutang Anggota</td>
                                <td id="v_coa_piutang" class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">-</td>
                            </tr>
                            <tr>
                                <td>Kredit: Sumber Dana Kas/Bank</td>
                                <td id="v_coa_kas" class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">-</td>
                            </tr>
                            <tr>
                                <td>Kredit: Pendapatan Admin</td>
                                <td id="v_coa_admin" class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">-</td>
                            </tr>
                            <tr>
                                <td>Kredit: Pendapatan Bunga</td>
                                <td id="v_coa_bunga" class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- SIMULASI SCHEDULE TENOR -->
                <h6 class="fw-bold mb-2 small text-uppercase">
                    <i class="fas fa-calendar-alt me-2 text-warning"></i>Simulasi Jadwal Angsuran (<span id="v_tenor_bln" style="font-family: 'JetBrains Mono', monospace;">0</span> Bulan)
                </h6>
                <div class="table-responsive rounded-3" style="max-height: 200px; overflow-y: auto; border: 1px solid var(--ent-grid-border);">
                    <table class="table table-custom align-middle mb-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Bulan Ke</th>
                                <th>Proyeksi Jatuh Tempo</th>
                                <th class="text-end">Nominal Angsuran</th>
                            </tr>
                        </thead>
                        <tbody id="v_tenor_tbody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer px-4 py-3" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-3 py-2" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn ent-btn ent-btn-danger px-4 py-2" onclick="processApproval('reject')">
                    <i class="fas fa-times-circle me-1"></i> Tolak Pengajuan
                </button>
                <button type="button" class="btn ent-btn ent-btn-success px-4 py-2" onclick="processApproval('approve')">
                    <i class="fas fa-check-circle me-1"></i> Setujui Pengajuan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let currentModal;

    function openApprovalModal(id) {
        $.get("{{ url('koperasi/menu-koperasi/apporval-pembelian-barang/detail') }}/" + id, function(res) {
            if (res.status === 'success') {
                const data = res.data;

                $('#modal_pembelian_id').val(data.id);
                $('#v_nota').text(data.nota_nomor);
                $('#v_anggota').text(data.kop_master_peserta_name + '\n(' + data.kop_master_peserta_code + ')');
                $('#v_barang').text(data.barang_nama);
                $('#v_tanggal').text(data.tanggal_transaksi);

                $('#v_harga').text('Rp ' + parseInt(data.harga_beli || 0).toLocaleString('id-ID'));
                $('#v_admin').text('Rp ' + parseInt(data.biaya_admin || 0).toLocaleString('id-ID'));
                $('#v_bunga').text('Rp ' + parseInt(data.bunga_koperasi || 0).toLocaleString('id-ID'));
                $('#v_total').text('Rp ' + parseInt(data.total_piutang || 0).toLocaleString('id-ID'));

                $('#v_coa_piutang').text(data.coa_piutang || '-');
                $('#v_coa_kas').text(data.sumber_dana_coa || '-');
                $('#v_coa_admin').text(data.coa_pendapatan_admin || '-');
                $('#v_coa_bunga').text(data.coa_pendapatan_bunga || '-');
                $('#v_tenor_bln').text(data.tenor_bulan);

                let htmlTenor = '';
                if (res.tenor && res.tenor.length > 0) {
                    res.tenor.forEach(function(t) {
                        htmlTenor += `
                            <tr>
                                <td class="text-center fw-bold" style="font-family: 'JetBrains Mono', monospace;">${t.angsuran_ke}</td>
                                <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">${t.jatuh_tempo}</td>
                                <td class="text-end fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">Rp ${t.jumlah_tagihan}</td>
                            </tr>
                        `;
                    });
                } else {
                    htmlTenor = `<tr><td colspan="3" class="text-center opacity-75 py-3">Jadwal tenor tidak tersedia.</td></tr>`;
                }
                $('#v_tenor_tbody').html(htmlTenor);

                currentModal = new bootstrap.Modal(document.getElementById('modalApproval'));
                currentModal.show();
            } else {
                Swal.fire('Gagal!', res.message || 'Gagal memuat data detail.', 'error');
            }
        }).fail(function() {
            Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data detail.', 'error');
        });
    }

    function processApproval(actionType) {
        const id = $('#modal_pembelian_id').val();
        const isApprove = actionType === 'approve';
        const endpoint = isApprove ? "{{ url('koperasi/menu-koperasi/apporval-pembelian-barang/approve') }}/" + id :
            "{{ url('koperasi/menu-koperasi/apporval-pembelian-barang/reject') }}/" + id;

        Swal.fire({
            title: isApprove ? 'Setujui Pengajuan?' : 'Tolak Pengajuan?',
            text: isApprove ? 'Tagihan aktif dan jadwal tenor angsuran beserta jurnal otomatis akan resmi dibukukan.' : 'Pengajuan pengadaan barang ini akan dibatalkan.',
            icon: isApprove ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: isApprove ? '#059669' : '#e11d48',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isApprove ? 'Ya, Setujui' : 'Ya, Tolak',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: endpoint,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
