@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* Custom Modern Theme */
    .banner-gradient {
        background: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #7c3aed 100%);
    }

    .card-modern {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card-modern-header {
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        border-radius: 14px 14px 0 0 !important;
        padding: 1rem 1.25rem;
    }

    /* Input Search */
    .search-input-box {
        font-size: 0.9rem !important;
        padding: 0.6rem 0.9rem !important;
    }

    .search-input-box::placeholder {
        font-size: 0.88rem !important;
        color: #94a3b8;
    }

    .btn-search-action {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border: none;
        font-size: 0.9rem;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }

    .btn-antrean-colorful {
        background: rgba(99, 102, 241, 0.1);
        color: #4f46e5;
        border: 1px solid rgba(99, 102, 241, 0.25);
        transition: all 0.2s ease;
    }

    .btn-antrean-colorful:hover {
        background: #4f46e5;
        color: #ffffff;
        border-color: #4f46e5;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    /* Style Kartu Profil Pasien */
    .profile-avatar-wrapper {
        position: relative;
        width: 85px;
        height: 85px;
        margin: 0 auto 10px auto;
    }

    .profile-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #3b82f6;
        padding: 2px;
        background: #fff;
    }

    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 4px;
        width: 13px;
        height: 13px;
        background-color: #22c55e;
        border: 2px solid #ffffff;
        border-radius: 50%;
    }

    .patient-rm-badge {
        background-color: #f1f5f9;
        color: #475569;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
    }

    .divider-with-text {
        display: flex;
        align-items: center;
        text-align: center;
        color: #94a3b8;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        margin: 14px 0 10px 0;
    }

    .divider-with-text::before,
    .divider-with-text::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e2e8f0;
    }

    .divider-with-text:not(:empty)::before {
        margin-right: .5em;
    }

    .divider-with-text:not(:empty)::after {
        margin-left: .5em;
    }

    /* Colorful Info Boxes Pasien */
    .info-box-colorful {
        border-radius: 8px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-box-colorful .info-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.88rem;
        flex-shrink: 0;
    }

    .info-box-colorful .info-title {
        font-size: 0.63rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 1px;
    }

    .info-box-colorful .info-value {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1e293b;
        word-break: break-all;
    }

    .bg-info-nik {
        background-color: #e0f2fe;
        border: 1px solid #bae6fd;
    }

    .bg-info-nik .info-icon {
        background-color: #0ea5e9;
    }

    .bg-info-order {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
    }

    .bg-info-order .info-icon {
        background-color: #10b981;
    }

    .bg-info-tgl {
        background-color: #ffedd5;
        border: 1px solid #fed7aa;
    }

    .bg-info-tgl .info-icon {
        background-color: #f97316;
    }

    .bg-info-gender {
        background-color: #e0e7ff;
        border: 1px solid #c7d2fe;
    }

    .bg-info-gender .info-icon {
        background-color: #6366f1;
    }

    .bg-info-tempat {
        background-color: #ffe4e6;
        border: 1px solid #fecdd3;
    }

    .bg-info-tempat .info-icon {
        background-color: #f43f5e;
    }

    /* Style Invoice & Tabel Layanan */
    .invoice-table-header {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: #ffffff;
    }

    .invoice-table-header th {
        color: #f8fafc !important;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        border: none;
        padding: 12px 14px;
    }

    .invoice-category-header {
        background-color: #eff6ff !important;
        border-left: 4px solid #2563eb;
    }

    .invoice-category-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e40af;
    }

    .subtotal-invoice-row {
        background-color: #f8fafc !important;
        border-top: 1px dashed #cbd5e1;
        border-bottom: 2px solid #e2e8f0;
    }

    .invoice-item-row:hover {
        background-color: #f1f5f9 !important;
    }

    .text-coret {
        text-decoration: line-through;
        font-size: 0.73rem;
        color: #94a3b8;
    }

    .badge-invoice-lunas {
        background-color: #dcfce7;
        color: #15803d;
        border: 1px solid #86efac;
        font-weight: 600;
        padding: 4px 8px;
    }

    .badge-invoice-unpaid {
        background-color: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
        font-weight: 600;
        padding: 4px 8px;
    }

    .total-checkout-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #fff;
        border-radius: 14px;
    }

    /* Style Payment Gateway Modal */
    .payment-option-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.25s ease;
        background: #ffffff;
    }

    .payment-option-card:hover {
        border-color: #2563eb;
        background-color: #f0f6ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
    }

    .payment-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
</style>
@endsection

@section('content')
<!-- Header Banner Gradasi -->
 <div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #1f6f92 0%, #203a43 50%, #2c5364 100%);">

            <!-- Hiasan Blur Glowing Circle -->
            <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl"
                style="width: 250px; height: 250px; top: -80px; right: 10%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle bg-info opacity-25 blur-3xl"
                style="width: 200px; height: 200px; bottom: -80px; left: -50px; filter: blur(50px);"></div>

            <div class="card-body p-4 text-white position-relative z-1">
                <div class="row align-items-center gy-3">

                    <!-- Brand & App Label -->
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 bg-opacity-10 rounded-4 shadow-sm me-3 border border-white border-opacity-10 d-flex align-items-center justify-content-center backdrop-blur"
                            style="width: 65px; height: 65px; backdrop-filter: blur(10px);">
                            <img src="{{ asset('img/keuangan.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-shield-alt me-1 text-info"></i> <span class="text-white" style="font-size: 0.75rem;">v2.4 Medical Suite</span>
                                </span>
                            </div>
                            <h3 class="text-white fw-extrabold mb-0 tracking-tight" style="font-size: 1.4rem;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="text-info fw-light">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <!-- Module Badge / Quick Nav -->
                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <!-- <span class="text-white-50 text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Module Aktif</span> -->
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <!-- <span class="p-1 bg-success rounded-circle me-2 animate-pulse" style="width: 8px; height: 8px;"></span> -->
                            <h6 class="text-success fw-bold mb-0" style="font-size: 0.95rem;">
                                <i class="fas fa-money-check me-1"></i> Cashier Accounting
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card Pencarian & Antrean -->
<div class="card card-modern mb-3">
    <div class="card-body p-3.5">
        <div class="row g-3 align-items-center">
            <div class="col-md-7">
                <label class="form-label fw-semibold text-secondary small mb-1" style="font-size: 0.78rem; letter-spacing: 0.5px;">CARI DATA PENDAFTARAN</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-primary"><i class="fas fa-qrcode"></i></span>
                    <input type="text" id="noRegInput" class="form-control bg-light border-start-0 search-input-box" placeholder="Masukkan / Scan No. Order Code Pasien..." onkeypress="if(event.key === 'Enter') cariRegistrasi()">
                    <button class="btn btn-primary btn-search-action text-white fw-semibold" onclick="cariRegistrasi()">
                        <i class="fas fa-search me-1"></i> Cari Order
                    </button>
                </div>
            </div>
            <div class="col-md-5 text-md-end d-flex align-items-end justify-content-md-end mt-3 mt-md-0">
                <button class="btn btn-antrean-colorful btn-md w-100 w-md-auto fw-bold  rounded-3 mt-3" data-bs-toggle="modal" data-bs-target="#modalDaftarPasien" onclick="loadDaftarPasienModal()">
                    <i class="fas fa-th-list me-2 fs-2"></i> CARI DATA
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Section Main Pembayaran -->
<div id="sectionPembayaran" style="display: none;">
    <div class="row mb-3 g-3">

        <!-- KIRI: Profil Pasien & Single Receipt Action -->
        <div class="col-lg-4">
            <div class="card card-modern h-100">
                <div class="card-body p-3 text-center">

                    <div class="profile-avatar-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" id="imgAvatarPasien" class="profile-avatar-img" alt="Avatar Pasien">
                        <span class="status-indicator"></span>
                    </div>

                    <h5 class="fw-bold text-dark mb-1" id="lblNama">MOHON CARI PASIEN</h5>
                    <div class="mb-2">
                        <span class="patient-rm-badge">
                            <i class="fas fa-id-card me-1"></i> RM: <span id="lblNoRM" class="font-monospace">-</span>
                        </span>
                    </div>

                    <div class="divider-with-text">INFORMASI PERSONAL</div>

                    <div class="d-flex flex-column gap-2 text-start">

                        <div class="info-box-colorful bg-info-nik">
                            <div class="info-icon"><i class="fas fa-address-card"></i></div>
                            <div>
                                <div class="info-title">Nomor Induk Kependudukan (NIK)</div>
                                <div class="info-value font-monospace" id="lblNIK">-</div>
                            </div>
                        </div>

                        <div class="info-box-colorful bg-info-order">
                            <div class="info-icon"><i class="fas fa-receipt"></i></div>
                            <div>
                                <div class="info-title">No. Order / Registrasi</div>
                                <div class="info-value font-monospace text-success" id="lblNoReg">-</div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <div class="info-box-colorful bg-info-tgl h-100">
                                    <div class="info-icon"><i class="fas fa-birthday-cake"></i></div>
                                    <div>
                                        <div class="info-title">Tgl Lahir</div>
                                        <div class="info-value" id="lblTglLahir">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box-colorful bg-info-gender h-100">
                                    <div class="info-icon"><i class="fas fa-venus-mars"></i></div>
                                    <div>
                                        <div class="info-title">Gender</div>
                                        <div class="info-value" id="lblJK">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-box-colorful bg-info-tempat">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <div class="info-title">Tempat Lahir</div>
                                <div class="info-value" id="lblTempatLahir">-</div>
                            </div>
                        </div>

                        <!-- 1 TOMBOL UTAMA BUKTI BAYAR / INVOICE -->
                        <button class="btn btn-danger w-100 fw-bold mt-2 py-2 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #e11d48; border: none;" onclick="cetakBuktiBayarUtama()">
                            <i class="fas fa-file-pdf"></i> Bukti Bayar / Invoice
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <!-- KANAN: Rincian Layanan Table -->
        <div class="col-lg-8">
            <div class="card card-modern h-100 overflow-hidden shadow-sm">
                <div class="card-modern-header d-flex justify-content-between align-items-center bg-white border-bottom p-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary text-white rounded-2 p-1.5 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fas fa-file-invoice-dollar fs-6"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Rincian Biaya & Layanan Pasien</h6>
                            <small class="text-muted" style="font-size: 0.72rem;">Faktur penagihan rincian tindakan kasir</small>
                        </div>
                    </div>
                    <span class="badge bg-indigo-subtle text-dark border border-indigo-subtle px-2.5 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                        <i class="fas fa-check-double me-1"></i> Centang Untuk Pembayaran
                    </span>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="invoice-table-header">
                            <tr>
                                <th width="6%" class="text-center">Pilih</th>
                                <th>Deskripsi Layanan / Item</th>
                                <th width="18%" class="text-center">Diskon</th>
                                <th width="22%" class="text-end">Harga Total</th>
                                <th width="22%" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tabelRincianLayanan"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Total & Eksekusi Pembayaran -->
    <div class="card total-checkout-card shadow-lg">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-7">
                    <div class="text-white-50 text-uppercase fw-semibold small">Total Yang Harus Dibayar:</div>
                    <div class="display-6 fw-bold text-success" id="totalBayar">Rp 0</div>
                </div>

                <div class="col-md-5 text-md-end" id="sectionMetodeBayar" style="display: none;">
                    <button class="btn btn-success btn-sm p-3 fw-bold shadow-sm w-md-auto rounded-3" onclick="bukaModalPembayaran()">
                        <i class="fas fa-credit-card me-2 fs-2"></i> PROSES BAYAR NOW
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Antrean Pasien -->
<div class="modal fade" id="modalDaftarPasien" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header banner-gradient text-white p-3">
                <div class="d-flex align-items-center gap-2">
                    <!-- <i class="fas fa-list-ol fs-5"></i> -->
                    <div>
                        <h5 class="modal-title fs-2 fw-bold mb-0 text-white">Antrean Billing Aktif Pasien</h5>
                        <small class="text-white-50" style="font-size: 0.72rem;">Daftar seluruh pasien yang memiliki transaksi belum lunas</small>
                    </div>
                </div>
                <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button> -->
            </div>

            <div class="modal-body p-3">
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-search"></i></span>
                            <input type="text" id="inputFilterModal" class="form-control bg-light border-start-0" placeholder="Ketik nama pasien, No. Order, atau No. RM untuk memfilter..." onkeyup="filterAntreanModal()">
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold" style="font-size: 0.8rem;">
                            Total: <span id="cntTotalAntrean">0</span> Pasien
                        </span>
                    </div>
                </div>

                <div class="table-responsive border rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th width="15%">No. Order</th>
                                <th width="15%">No. RM</th>
                                <th>Nama Pasien</th>
                                <th width="18%">Layanan</th>
                                <th width="20%" class="text-end">Total Tagihan</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabelListModalPasien"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm px-3 fw-semibold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pop-up Metode Pembayaran (Midtrans Style) -->
<div class="modal fade" id="modalPaymentGateway" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div class="modal-header bg-dark text-white p-3.5">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-shield-alt fs-5"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold mb-0 text-success">Pilih Metode Pembayaran</h6>
                        <small class="text-white-50" style="font-size: 0.72rem;">Sistem Kasir & Payment Gateway</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">

                <!-- Ringkasan Singkat Pasien & Total -->
                <div class="card border-0 shadow-sm p-3 mb-3" style="border-radius: 12px; background: #ffffff;">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <span class="text-muted small">Pasien:</span>
                        <span class="fw-bold text-dark small" id="mdlNamaPasien">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Total Pembayaran:</span>
                        <span class="fs-5 fw-bold text-success" id="mdlTotalBayar">Rp 0</span>
                    </div>
                </div>

                <div class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">METODE PEMBAYARAN TERSEDIA</div>

                <!-- Opsi-Opsi Pembayaran -->
                <div class="d-flex flex-column gap-2.5">

                    <!-- Tunai -->
                    <div class="payment-option-card d-flex align-items-center justify-content-between" onclick="eksekusiPembayaranModal('Tunai')">
                        <div class="d-flex align-items-center gap-3">
                            <div class="payment-icon-box bg-success bg-opacity-10 text-success">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.92rem;">Tunai / Cash</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">Pembayaran fisik langsung via Kasir</small>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>

                    <!-- Debit / Kredit Card -->
                    <div class="payment-option-card d-flex align-items-center justify-content-between" onclick="eksekusiPembayaranModal('Debit')">
                        <div class="d-flex align-items-center gap-3">
                            <div class="payment-icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.92rem;">Kartu Debit / Kredit (EDC)</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">Gesek / Dip via Mesin EDC Bank</small>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>

                    <!-- QRIS -->
                    <div class="payment-option-card d-flex align-items-center justify-content-between" onclick="eksekusiPembayaranModal('QRIS')">
                        <div class="d-flex align-items-center gap-3">
                            <div class="payment-icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.92rem;">QRIS / Instant E-Wallet</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">Gopay, OVO, Dana, ShopeePay, BCA, dll</small>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>

                    <!-- Transfer Bank -->
                    <div class="payment-option-card d-flex align-items-center justify-content-between" onclick="eksekusiPembayaranModal('Transfer')">
                        <div class="d-flex align-items-center gap-3">
                            <div class="payment-icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-university"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.92rem;">Bank Transfer / Virtual Account</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">Transfer Bank Resmi Rumah Sakit</small>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>

                </div>

            </div>
            <div class="modal-footer bg-light border-0 py-2 justify-content-center">
                <small class="text-muted" style="font-size: 0.72rem;"><i class="fas fa-lock text-success me-1"></i>Transaksi Kasir Aman & Terenkripsi</small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let dataAktif = null;
    let rawAntreanPasien = [];
    let currentTotalBayar = 0;

    function loadDaftarPasienModal() {
        const tbodyModal = document.getElementById("tabelListModalPasien");
        document.getElementById("inputFilterModal").value = "";
        tbodyModal.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm me-2 text-primary" role="status"></div>Sedang mengambil daftar antrean pasien...</td></tr>`;

        fetch(`{{ route('keuangan_menu_cashier_list_all_patient') }}`)
            .then(r => r.json())
            .then(res => {
                if (res.success && res.data.length > 0) {
                    rawAntreanPasien = res.data;
                    renderTabelAntreanModal(rawAntreanPasien);
                } else {
                    rawAntreanPasien = [];
                    document.getElementById("cntTotalAntrean").innerText = "0";
                    tbodyModal.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted"><i class="fas fa-inbox fs-3 d-block mb-2"></i>Tidak ada transaksi antrean menggantung.</td></tr>`;
                }
            })
            .catch(() => {
                tbodyModal.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-danger">Gagal memuat data antrean.</td></tr>`;
            });
    }

    function renderTabelAntreanModal(listData) {
        const tbodyModal = document.getElementById("tabelListModalPasien");
        document.getElementById("cntTotalAntrean").innerText = listData.length;

        if (listData.length === 0) {
            tbodyModal.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">Pasien tidak ditemukan dengan kata kunci tersebut.</td></tr>`;
            return;
        }

        tbodyModal.innerHTML = "";
        listData.forEach(order => {
            let rItem = `
                <tr>
                    <td><span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle font-monospace">${order.d_reg_order_code}</span></td>
                    <td><span class="font-monospace fw-semibold text-dark">${order.rm_code}</span></td>
                    <td class="fw-bold text-dark">${order.patient_name}</td>
                    <td><span class="badge bg-warning text-white border border-info-subtle fs-1">${order.t_layanan_cat_code}</span></td>
                    <td class="text-end fw-bold text-danger">Rp ${(order.total_tagihan).toLocaleString('id-ID')}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary fw-semibold px-3" onclick="pilihPasienDariModal('${order.d_reg_order_code}')">Pilih</button>
                    </td>
                </tr>`;
            tbodyModal.insertAdjacentHTML('beforeend', rItem);
        });
    }

    function filterAntreanModal() {
        const keyword = document.getElementById("inputFilterModal").value.toLowerCase().trim();
        if (!keyword) {
            renderTabelAntreanModal(rawAntreanPasien);
            return;
        }

        const filtered = rawAntreanPasien.filter(item => {
            const name = (item.patient_name || '').toLowerCase();
            const rm = (item.rm_code || '').toLowerCase();
            const orderCode = (item.d_reg_order_code || '').toLowerCase();
            return name.includes(keyword) || rm.includes(keyword) || orderCode.includes(keyword);
        });

        renderTabelAntreanModal(filtered);
    }

    function pilihPasienDariModal(noReg) {
        document.getElementById("noRegInput").value = noReg;
        bootstrap.Modal.getInstance(document.getElementById('modalDaftarPasien')).hide();
        cariRegistrasi();
    }

    function cariRegistrasi() {
        const noReg = document.getElementById("noRegInput").value.trim().toUpperCase();
        if (!noReg) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Masukkan kode order pendaftaran terlebih dahulu!'
            });
            return;
        }

        Swal.showLoading();
        fetch(`{{ route('keuangan_menu_cashier_find_data_v2') }}?no_reg=${noReg}`)
            .then(r => r.json())
            .then(res => {
                Swal.close();
                if (res.success) {
                    dataAktif = res.data;

                    document.getElementById("lblNoReg").innerText = dataAktif.no_reg || '-';
                    document.getElementById("lblNoRM").innerText = dataAktif.no_rm || '-';
                    document.getElementById("lblNama").innerText = dataAktif.nama || '-';
                    document.getElementById("lblJK").innerText = dataAktif.jk || '-';
                    document.getElementById("lblNIK").innerText = dataAktif.nik || '-';
                    document.getElementById("lblTglLahir").innerText = dataAktif.tgl_lahir || '-';
                    document.getElementById("lblTempatLahir").innerText = dataAktif.tempat_lahir || '-';

                    if (dataAktif.jk && (dataAktif.jk.toLowerCase().includes('p') || dataAktif.jk.toLowerCase().includes('wanita') || dataAktif.jk.toLowerCase().includes('perempuan'))) {
                        document.getElementById("imgAvatarPasien").src = "https://cdn-icons-png.flaticon.com/512/4140/4140047.png";
                    } else {
                        document.getElementById("imgAvatarPasien").src = "https://cdn-icons-png.flaticon.com/512/4140/4140048.png";
                    }

                    renderTabelKategori(dataAktif.layanan);
                    document.getElementById("sectionPembayaran").style.display = "block";
                    hitungMasingMasingSubtotal();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Ditemukan',
                        text: res.message
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Terjadi kesalahan saat memproses data pendaftaran.'
                });
            });
    }

    function renderTabelKategori(layananData) {
        const tbody = document.getElementById("tabelRincianLayanan");
        tbody.innerHTML = "";

        for (const namaLayanan in layananData) {
            if (!layananData[namaLayanan] || layananData[namaLayanan].length === 0) continue;
            let namaId = namaLayanan.replace(/\s+/g, '');

            let hRow = `
                <tr class="invoice-category-header">
                    <td class="text-center py-2">
                        <input class="form-check-input header-check" type="checkbox" id="chAll-${namaId}" onchange="toggleCheckAll('${namaId}', this)">
                    </td>
                    <td colspan="4" class="py-2">
                        <label for="chAll-${namaId}" class="invoice-category-title mb-0 d-flex align-items-center gap-2" style="cursor:pointer;">
                            <i class="fas fa-folder text-primary"></i> ${namaLayanan}
                        </label>
                    </td>
                </tr>`;
            tbody.insertAdjacentHTML('beforeend', hRow);

            layananData[namaLayanan].forEach(item => {
                let hargaAsli = parseInt(item.harga) || 0;
                let disc = parseInt(item.diskon) || 0;
                let hargaAkhir = hargaAsli - disc;

                let bHTML = disc > 0 ?
                    `<div class="text-coret">Rp ${hargaAsli.toLocaleString('id-ID')}</div><div class="fw-bold text-dark" style="font-size:0.88rem;">Rp ${hargaAkhir.toLocaleString('id-ID')}</div>` :
                    `<div class="fw-bold text-dark" style="font-size:0.88rem;">Rp ${hargaAkhir.toLocaleString('id-ID')}</div>`;

                let cbHTML = item.lunas ?
                    `<i class="fas fa-check-circle text-success fs-2"></i>` :
                    `<input class="form-check-input item-checkbox child-of-${namaId}" type="checkbox" value="${hargaAkhir}" data-id="${item.id}" data-kategori="${namaLayanan}" onchange="cekKondisiHeader('${namaId}')">`;

                let stHTML = item.lunas ?
                    `<span class="badge badge-invoice-lunas rounded-pill"><i class="fas fa-check me-1"></i>Lunas</span>` :
                    `<span class="badge badge-invoice-unpaid rounded-pill"><i class="fas fa-clock me-1"></i>Belum Lunas</span>`;

                let iRow = `
                    <tr class="invoice-item-row">
                        <td class="text-center">${cbHTML}</td>
                        <td class="fw-semibold text-dark" style="font-size: 0.85rem;">
                            ${item.nama}
                        </td>
                        <td class="text-center text-muted">
                            ${disc > 0 ? '<span class="badge bg-danger-subtle text-danger fw-bold">-Rp ' + disc.toLocaleString('id-ID') + '</span>' : '<span class="text-black-50">-</span>'}
                        </td>
                        <td class="text-end">${bHTML}</td>
                        <td class="text-center">${stHTML}</td>
                    </tr>`;
                tbody.insertAdjacentHTML('beforeend', iRow);
            });

            tbody.insertAdjacentHTML('beforeend', `
                <tr class="subtotal-invoice-row">
                    <td colspan="3" class="text-end text-uppercase fw-semibold text-secondary" style="font-size: 0.75rem; letter-spacing:0.5px;">Subtotal ${namaLayanan}:</td>
                    <td class="text-end fw-bold text-primary" id="subtotal-${namaId}" style="font-size: 0.9rem;">Rp 0</td>
                    <td></td>
                </tr>`);
        }
    }

    /* FUNGSI CETAK UTAMA BUKTI BAYAR / INVOICE (PDF) */
    function cetakBuktiBayarUtama() {
        let orderCode = $('#lblNoReg').text().trim();

        if (!orderCode || orderCode === '-') {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan cari data pendaftaran pasien terlebih dahulu!'
            });
            return;
        }

        // Buka URL pencetakan PDF faktur utama berdasarkan order code
        window.open("{{ url('application/cashier/download-receipt-pdf') }}/" + orderCode, '_blank');
    }

    function toggleCheckAll(id, master) {
        document.querySelectorAll(`.child-of-${id}`).forEach(cb => {
            if (!cb.disabled) cb.checked = master.checked;
        });
        hitungMasingMasingSubtotal();
    }

    function cekKondisiHeader(id) {
        const total = document.querySelectorAll(`.child-of-${id}`).length;
        const checked = document.querySelectorAll(`.child-of-${id}:checked`).length;
        const headerCb = document.getElementById(`chAll-${id}`);
        if (headerCb) headerCb.checked = (total > 0 && total === checked);
        hitungMasingMasingSubtotal();
    }

    function hitungMasingMasingSubtotal() {
        let grand = 0;
        for (const key in dataAktif.layanan) {
            let sub = 0;
            let namaId = key.replace(/\s+/g, '');
            if (!document.getElementById(`subtotal-${namaId}`)) continue;

            document.querySelectorAll(`.item-checkbox[data-kategori="${key}"]:checked`).forEach(cb => sub += parseInt(cb.value));
            document.getElementById(`subtotal-${namaId}`).innerText = "Rp " + sub.toLocaleString('id-ID');
            grand += sub;
        }
        currentTotalBayar = grand;
        document.getElementById("totalBayar").innerText = "Rp " + grand.toLocaleString('id-ID');
        document.getElementById("sectionMetodeBayar").style.display = grand > 0 ? "block" : "none";
    }

    /* Buka Modal Pop-up Payment Gateway */
    function bukaModalPembayaran() {
        let itemTerpilih = document.querySelectorAll('.item-checkbox:checked').length;
        if (itemTerpilih === 0) {
            return Swal.fire({
                icon: 'warning',
                title: 'Item Belum Dipilih',
                text: 'Centang minimal satu item tindakan untuk diproses!'
            });
        }

        document.getElementById("mdlNamaPasien").innerText = dataAktif.nama + " (" + dataAktif.no_rm + ")";
        document.getElementById("mdlTotalBayar").innerText = "Rp " + currentTotalBayar.toLocaleString('id-ID');

        let myModal = new bootstrap.Modal(document.getElementById('modalPaymentGateway'));
        myModal.show();
    }

    /* Eksekusi Pembayaran Ketika Salah Satu Metode Diklik di Modal */
    function eksekusiPembayaranModal(metodePilihan) {
        let modalEl = document.getElementById('modalPaymentGateway');
        let modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();

        let itemTerpilih = [];
        document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
            itemTerpilih.push({
                id: cb.getAttribute('data-id'),
                kategori: cb.getAttribute('data-kategori')
            });
        });

        Swal.fire({
            title: 'Konfirmasi Pelunasan',
            text: `Proses bayar Rp ${currentTotalBayar.toLocaleString('id-ID')} dengan metode ${metodePilihan}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lunaskan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                fetch(`{{ route('keuangan_menu_cashier_proses_payment') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            d_reg_order_code: dataAktif.no_reg,
                            metode_pembayaran: metodePilihan,
                            items: itemTerpilih
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil!',
                                html: `<p class="mb-1">${result.message}</p><h4 class="text-success fw-bold">Rp ${result.total_dibayar.toLocaleString('id-ID')}</h4>`,
                            });
                            cariRegistrasi();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memproses',
                                text: result.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Jaringan',
                            text: 'Terjadi gangguan koneksi internet/server.'
                        });
                    });
            }
        });
    }
</script>
@endsection
