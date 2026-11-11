@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    body {
        /* background-color: var(--retro-bg); */
    }

    /* Retro Cards */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    /* Retro Header Banner */
    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    /* Retro Buttons */
    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-primary:hover {
        background-color: #6ce0ed;
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-warning:hover {
        background-color: #e6c84c;
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-success:hover {
        background-color: #b0f55b;
        color: var(--retro-dark);
    }

    .retro-btn-danger {
        background-color: var(--retro-pink);
        color: var(--retro-dark);
    }

    /* Inputs, Selects & Container Filter */
    .filter-bar-container {
        background-color: #ffffff;
        border: var(--retro-border);
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: var(--retro-shadow-sm);
    }

    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
    }

    .retro-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--retro-dark) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Tabel Custom */
    .table-custom-orange thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border-bottom: 3px solid var(--retro-dark);
        padding: 12px 10px;
        letter-spacing: 0.5px;
    }

    .table-custom-gray thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-cyan) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark);
        padding: 10px;
    }

    .table-custom-gray td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
    }

    .table-hover tbody tr {
        border-bottom: 2px solid var(--retro-dark);
        transition: background 0.2s;
    }

    .table-hover tbody tr:hover {
        background-color: var(--retro-yellow) !important;
    }

    .card-panel {
        background: #ffffff;
        border: 2px solid var(--retro-dark);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 3px 3px 0px var(--retro-dark);
    }

    /* Kotak Total Tagihan Modern Retro */
    .total-tagihan-box {
        background: var(--retro-dark);
        color: #ffffff;
        border: 3px solid var(--retro-dark);
        border-radius: 12px;
        padding: 18px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--retro-shadow-sm);
    }

    .total-tagihan-number {
        font-size: 2rem;
        font-weight: 900;
        color: var(--retro-green);
        letter-spacing: 1px;
    }

    .row-selected {
        background-color: var(--retro-yellow) !important;
    }

    /* Kartu Metode Pembayaran Modern Retro */
    .payment-method-card {
        background: #ffffff;
        border: 2px solid var(--retro-dark);
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 12px;
        box-shadow: 3px 3px 0px var(--retro-dark);
        transition: all 0.1s ease;
    }

    .payment-method-card.disabled-method {
        background-color: #e9ecef;
        opacity: 0.65;
        pointer-events: none;
        box-shadow: none;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER UTAMA -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 shadow-sm me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/keuangan.png') }}" alt="Logo" class="img-fluid" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                    <i class="fas fa-shield-alt me-1"></i> v2.4 Medical Suite
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem; text-shadow: 1px 1px 0px white;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-money-check me-1 text-success"></i> Cashier Accounting
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BARIS FILTER UTAMA DI ATAS -->
<div class="filter-bar-container">
    <form id="form-filter-kasir" onsubmit="event.preventDefault(); loadAntreanKasir();" class="row g-2 align-items-end">
        <!-- Tanggal Awal -->
        <div class="col-md-2">
            <label class="form-label text-dark mb-1 fs--2 fw-bolder">TANGGAL AWAL</label>
            <input type="date" class="form-control form-control-sm retro-input" id="filter_tgl_awal" value="{{ date('Y-m-d') }}">
        </div>
        <!-- Tanggal Akhir -->
        <div class="col-md-2">
            <label class="form-label text-dark mb-1 fs--2 fw-bolder">TANGGAL AKHIR</label>
            <input type="date" class="form-control form-control-sm retro-input" id="filter_tgl_akhir" value="{{ date('Y-m-d') }}">
        </div>
        <!-- Kel. Pelanggan -->
        <div class="col-md-2">
            <label class="form-label text-dark mb-1 fs--2 fw-bolder">KEL. PELANGGAN</label>
            <select class="form-select form-select-sm retro-input" id="filter_penjamin">
                <option value="">Semua</option>
                @foreach ($subPenjamins ?? [] as $sp)
                <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                @endforeach
            </select>
        </div>
        <!-- Cari Keyword -->
        <div class="col-md-2">
            <label class="form-label text-dark mb-1 fs--2 fw-bolder">CARI...</label>
            <input type="text" class="form-control form-control-sm retro-input" id="filter_keyword" placeholder="Nama / No Reg">
        </div>
        <!-- Status -->
        <div class="col-md-2">
            <label class="form-label text-dark mb-1 fs--2 fw-bolder">STATUS</label>
            <select class="form-select form-select-sm retro-input" id="filter_status">
                <option value="Belum Lunas" selected>Belum Lunas</option>
                <option value="Lunas">Lunas</option>
                <option value="">Semua Status</option>
            </select>
        </div>
        <!-- Tombol Cari & Tombol Buat Laporan -->
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn retro-btn retro-btn-warning flex-grow-1 fw-bold" style="height: 33px;" title="Cari Data">
                <i class="fas fa-search"></i>
            </button>
            <button type="button" class="btn retro-btn retro-btn-success flex-grow-1 fw-bold" style="height: 33px;" onclick="bukaModalBuatLaporanKeuangan()" title="Buat Laporan Keuangan">
                <i class="fas fa-file-invoice-dollar"></i> Laporan
            </button>
        </div>
    </form>
</div>

<!-- LAYOUT UTAMA DUA KOLOM (KIRI: TABEL ANTREAN, KANAN: PANEL PEMBAYARAN) -->
<div class="row g-3">

    <!-- KOLOM KIRI: TABEL DAFTAR PASIEN / ANTREAN -->
    <div class="col-lg-7">
        <div class="retro-card">
            <div class="table-responsive" style="max-height: 650px; overflow-y: auto;">
                <table class="table table-hover table-custom-orange align-middle mb-0 fs--1" style="border: 2px solid var(--retro-dark);">
                    <thead>
                        <tr>
                            <th style="width: 25%;">TGL. TRANSAKSI</th>
                            <th style="width: 25%;">NO REG</th>
                            <th style="width: 25%;">NAMA</th>
                            <th style="width: 25%;">KEL.PELANGGAN / AGREEMENT</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-antrean-body" style="font-weight: 700; color: var(--retro-dark);">
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Memuat data antrean...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: DETAIL NOTA, TOTAL, & INPUT PEMBAYARAN -->
    <div class="col-lg-5">

        <!-- Tabel Nota / Rincian Singkat -->
        <div class="retro-card mb-3">
            <div class="table-responsive">
                <table class="table table-bordered table-custom-gray align-middle mb-0 fs--1 text-center">
                    <thead>
                        <tr>
                            <th width="20%">NOTA</th>
                            <th width="35%">TIPE PEMBAYARAN</th>
                            <th width="20%">JUMLAH</th>
                            <th width="15%">USER</th>
                            <th width="10%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-nota-body" style="color: var(--retro-dark); background-color: #fff;">
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">Tidak ada data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bar Kontrol Cetak & Kartu Kontrol -->
        <div class="card-panel d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 w-50">
                <select class="form-select form-select-sm retro-input" id="tipePrint">
                    <option value="">Tipe Print</option>
                    <option value="thermal">Thermal Struk</option>
                    <option value="A4">Invoice A4</option>
                </select>
                <button class="btn btn-sm retro-btn retro-btn-warning px-3" onclick="cetakNotaAktif()">
                    <i class="fas fa-print"></i>
                </button>
            </div>
            <button class="btn btn-sm retro-btn retro-btn-warning fw-bold px-4" onclick="bukaKartuKontrol()">
                KARTU KONTROL
            </button>
        </div>

        <!-- Box Total Tagihan Besar -->
        <div class="total-tagihan-box mb-3">
            <div>
                <h5 class="text-white fw-bold mb-0">Total Tagihan</h5>
                <small class="text-white-50 fs--2">Status: <span id="lblStatusBayar" class="fw-bold text-warning">-</span></small>
            </div>
            <div class="total-tagihan-number" id="lblTotalTagihan">0</div>
        </div>

        <!-- Form Metode Pembayaran -->
        <div class="retro-card p-3 mb-3" id="panelMetodePembayaran">

            <!-- Cash / Tunai -->
            <div class="payment-method-card" id="cardCash">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleCash" onchange="toggleMetode('cash')" disabled style="border: 2px solid var(--retro-dark);">
                        <label class="form-check-label fw-bold text-dark" for="toggleCash"><i class="fas fa-money-bill-wave text-success me-1"></i> Cash / Tunai</label>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="number" class="form-control form-control-sm retro-input" id="inputCashJumlah" placeholder="Jumlah" value="0" disabled>
                            <label class="text-dark fw-bold">Jumlah</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" class="form-control form-control-sm retro-input" id="inputCashKembali" placeholder="Kembali" value="0" readonly>
                            <label class="text-dark fw-bold">Kembali</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Debit -->
            <div class="payment-method-card" id="cardDebit">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleDebit" onchange="toggleMetode('debit')" disabled style="border: 2px solid var(--retro-dark);">
                        <label class="form-check-label fw-bold text-dark" for="toggleDebit"><i class="fas fa-credit-card text-primary me-1"></i> Debit Card</label>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-4">
                        <input type="number" class="form-control form-control-sm retro-input" id="inputDebitJumlah" placeholder="Jumlah" value="0" disabled>
                    </div>
                    <div class="col-8">
                        <select class="form-select form-select-sm retro-input" id="selectDebitEDC" disabled>
                            <option value="">Pilih Mesin EDC / Rekening</option>
                            @foreach($edcList ?? [] as $edc)
                            <option value="{{ $edc->id }}">{{ $edc->nama_bank }} — Rek: {{ $edc->no_rekening }} ({{ $edc->nama_pemilik }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Credit -->
            <div class="payment-method-card mb-2" id="cardCredit">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleCredit" onchange="toggleMetode('credit')" disabled style="border: 2px solid var(--retro-dark);">
                        <label class="form-check-label fw-bold text-dark" for="toggleCredit"><i class="fas fa-university text-warning me-1"></i> Credit Card</label>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-4">
                        <input type="number" class="form-control form-control-sm retro-input" id="inputCreditJumlah" placeholder="Jumlah" value="0" disabled>
                    </div>
                    <div class="col-4">
                        <select class="form-select form-select-sm retro-input" id="selectCreditKartu" disabled>
                            <option value="">Kartu</option>
                            <option value="Visa">Visa</option>
                            <option value="Mastercard">Mastercard</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <select class="form-select form-select-sm retro-input" id="selectCreditEDC" disabled>
                            <option value="">EDC</option>
                            <option value="EDC BCA">EDC BCA</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- TOMBOL PROSES PAYMENT OLEH KASIR -->
            <button class="btn retro-btn retro-btn-success w-100 py-3 shadow-sm d-flex align-items-center justify-content-center gap-2 mt-3" id="btnProsesPayment" onclick="prosesPaymentKasir()" disabled>
                <i class="fas fa-check-circle fs-5"></i> PROSES PEMBAYARAN SEKARANG
            </button>

        </div>

    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let selectedOrderCode = null;
    let currentDataList = [];

    $(document).ready(function() {
        loadAntreanKasir();
    });

    function loadAntreanKasir() {
        const tglAwal = $('#filter_tgl_awal').val();
        const tglAkhir = $('#filter_tgl_akhir').val();
        const penjamin = $('#filter_penjamin').val();
        const keyword = $('#filter_keyword').val();
        const status = $('#filter_status').val();

        $('#tabel-antrean-body').html(`<tr><td colspan="4" class="text-center py-3 text-muted"><div class="spinner-border spinner-border-sm me-2"></div>Memuat data...</td></tr>`);

        $.ajax({
            url: "{{ route('keuangan_menu_cashier_list_all_patient') }}",
            type: "GET",
            data: {
                start_date: tglAwal,
                end_date: tglAkhir,
                penjamin: penjamin,
                keyword: keyword,
                status: status
            },
            success: function(res) {
                if (res.success && res.data.length > 0) {
                    currentDataList = res.data;
                    let html = '';
                    res.data.forEach((item) => {
                        let tglFormat = item.tanggal_registrasi ? item.tanggal_registrasi : '-';
                        html += `
                            <tr onclick="pilihPasienKasir('${item.d_reg_order_code}')" style="cursor: pointer;" id="row-${item.d_reg_order_code}">
                                <td class="text-nowrap">${tglFormat}</td>
                                <td>
                                    <span class="text-danger fw-bold d-block">${item.d_reg_order_code}</span>
                                    <span class="text-dark fw-bold d-block" style="font-size: 0.75rem;">${item.rm_code}</span>
                                </td>
                                <td class="fw-bold text-dark text-uppercase">${item.patient_name}</td>
                                <td>
                                    <span class="text-dark fw-bold d-block">${item.t_layanan_cat_code ?? '-'}</span>
                                    <small class="text-muted" style="font-size: 0.65rem;">MCU KARYAWAN</small>
                                </td>
                            </tr>
                        `;
                    });
                    $('#tabel-antrean-body').html(html);
                } else {
                    $('#tabel-antrean-body').html(`<tr><td colspan="4" class="text-center py-4 text-muted">Tidak ada data ditemukan</td></tr>`);
                }
            },
            error: function() {
                $('#tabel-antrean-body').html(`<tr><td colspan="4" class="text-center py-4 text-danger">Gagal memuat data antrean.</td></tr>`);
            }
        });
    }

    function pilihPasienKasir(noReg) {
        selectedOrderCode = noReg;
        $('tr').removeClass('row-selected');
        $(`#row-${noReg}`).addClass('row-selected');

        let pasien = currentDataList.find(x => x.d_reg_order_code === noReg);
        if (pasien) {
            let statusBayar = (pasien.status_pembayaran || 'BELUM LUNAS').toUpperCase();
            $('#lblStatusBayar').text(statusBayar);

            if (statusBayar === 'LUNAS') {
                $('#lblTotalTagihan').text('0');
                nonaktifkanMetodePembayaran(true);

                let notaHtml = `
                    <tr>
                        <td class="fw-bold text-dark font-monospace">NOTA-${pasien.d_reg_order_code}</td>
                        <td><span class="retro-badge" style="background-color: var(--retro-cyan);">${pasien.metode_bayar || 'CASH'}</span></td>
                        <td class="fw-bold text-success">Rp ${Number(pasien.total_tagihan || 0).toLocaleString('id-ID')}</td>
                        <td><span class="retro-badge" style="background-color: var(--retro-yellow);"><i class="fas fa-user-shield me-1"></i>${pasien.user_pelunas || 'Kasir'}</span></td>
                        <td>
                            <button class="btn btn-sm retro-btn retro-btn-danger py-0 px-2 fw-bold" onclick="cetakNotaAktif()" title="Cetak Nota">
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#tabel-nota-body').html(notaHtml);
            } else {
                $('#lblTotalTagihan').text(Number(pasien.total_tagihan || 0).toLocaleString('id-ID'));
                nonaktifkanMetodePembayaran(false);
                $('#tabel-nota-body').html(`<tr><td colspan="5" class="text-center py-3 text-muted">Belum ada transaksi nota (Belum Lunas)</td></tr>`);
            }
        }
    }

    function nonaktifkanMetodePembayaran(isDisable) {
        if (isDisable) {
            $('#cardCash, #cardDebit, #cardCredit').addClass('disabled-method');
            $('#toggleCash, #toggleDebit, #toggleCredit').prop('checked', false).prop('disabled', true);
            $('#inputCashJumlah, #inputDebitJumlah, #inputCreditJumlah').prop('disabled', true).val(0);
            $('#selectDebitKartu, #selectDebitEDC, #selectCreditKartu, #selectCreditEDC').prop('disabled', true).val('');
            $('#btnProsesPayment').prop('disabled', true);
        } else {
            $('#cardCash, #cardDebit, #cardCredit').removeClass('disabled-method');
            $('#toggleCash, #toggleDebit, #toggleCredit').prop('checked', false).prop('disabled', false);
            $('#inputCashJumlah, #inputDebitJumlah, #inputCreditJumlah').prop('disabled', true).val(0);
            $('#selectDebitKartu, #selectDebitEDC, #selectCreditKartu, #selectCreditEDC').prop('disabled', true).val('');
            $('#btnProsesPayment').prop('disabled', true);
        }
    }

    function toggleMetode(type) {
        let isCashChecked = $('#toggleCash').is(':checked');
        let isDebitChecked = $('#toggleDebit').is(':checked');
        let isCreditChecked = $('#toggleCredit').is(':checked');

        if (type === 'cash') {
            $('#inputCashJumlah').prop('disabled', !isCashChecked);
            if (!isCashChecked) $('#inputCashJumlah').val(0);
        } else if (type === 'debit') {
            $('#inputDebitJumlah, #selectDebitEDC').prop('disabled', !isDebitChecked);
            if (!isDebitChecked) $('#inputDebitJumlah').val(0);
        } else if (type === 'credit') {
            $('#inputCreditJumlah, #selectCreditKartu, #selectCreditEDC').prop('disabled', !isCreditChecked);
            if (!isCreditChecked) $('#inputCreditJumlah').val(0);
        }

        let adaYangDicentang = isCashChecked || isDebitChecked || isCreditChecked;
        $('#btnProsesPayment').prop('disabled', !adaYangDicentang);
    }

    function prosesPaymentKasir() {
        if (!selectedOrderCode) {
            return Swal.fire('Perhatian', 'Pilih pasien dari daftar antrean terlebih dahulu!', 'warning');
        }

        let metodePilih = '';
        let nominalBayar = 0;
        let edcId = null;

        if ($('#toggleCash').is(':checked')) {
            metodePilih = 'CASH';
            nominalBayar = parseFloat($('#inputCashJumlah').val()) || 0;
        } else if ($('#toggleDebit').is(':checked')) {
            metodePilih = 'DEBIT';
            nominalBayar = parseFloat($('#inputDebitJumlah').val()) || 0;
            edcId = $('#selectDebitEDC').val();
        } else if ($('#toggleCredit').is(':checked')) {
            metodePilih = 'CREDIT';
            nominalBayar = parseFloat($('#inputCreditJumlah').val()) || 0;
            edcId = $('#selectCreditEDC').val();
        }

        if (!metodePilih) {
            return Swal.fire('Perhatian', 'Silakan centang salah satu metode pembayaran (Cash/Debit/Credit) terlebih dahulu!', 'warning');
        }

        let totalTagihanText = $('#lblTotalTagihan').text().replace(/\./g, '').replace(',', '.');
        let totalTagihan = parseFloat(totalTagihanText) || 0;

        if (nominalBayar <= 0) {
            return Swal.fire('Perhatian', 'Masukkan jumlah nominal pembayaran dengan benar!', 'warning');
        }

        if (nominalBayar < totalTagihan) {
            let kurang = totalTagihan - nominalBayar;
            return Swal.fire('Pembayaran Kurang', 'Nominal pembayaran kurang dari total tagihan sebesar Rp ' + kurang.toLocaleString('id-ID'), 'warning');
        }

        Swal.fire({
            title: 'Konfirmasi Pelunasan',
            text: `Proses pelunasan untuk No. Reg ${selectedOrderCode} sebesar Rp ${nominalBayar.toLocaleString('id-ID')} (Metode: ${metodePilih})?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1e1e24',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lunaskan Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('keuangan_menu_cashier_proses_payment') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        d_reg_order_code: selectedOrderCode,
                        metode_pembayaran: metodePilih,
                        jumlah_bayar: nominalBayar,
                        edc_id: edcId
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                            });
                            loadAntreanKasir();

                            let pasien = currentDataList.find(x => x.d_reg_order_code === selectedOrderCode);
                            if (pasien) {
                                pasien.status_pembayaran = 'LUNAS';
                                pasien.metode_bayar = metodePilih;
                                pasien.user_pelunas = res.user_pelunas;
                            }

                            pilihPasienKasir(selectedOrderCode);
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errMsg = 'Terjadi kesalahan pada server saat memproses pembayaran.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Gagal', errMsg, 'error');
                    }
                });
            }
        });
    }

    // Fungsi pemanggil modal buat laporan keuangan kasir oleh bagian keuangan
    function bukaModalBuatLaporanKeuangan() {
        Swal.fire({
            title: 'Memuat Data...',
            text: 'Mengambil daftar transaksi pelunasan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('keuangan.get_belum_dilaporkan_keuangan') }}",
                    type: "GET",
                    success: function(res) {
                        if (res.success) {
                            let rows = '';
                            if (res.data.length > 0) {
                                res.data.forEach((item) => {
                                    rows += `
                                        <tr class="align-middle">
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input select-transaksi-keu" value="${item.transaksi_id}" data-tagihan="${item.total_tagihan}" checked onchange="hitungTotalSetoranKeu()" style="border: 2px solid var(--retro-dark); width: 18px; height: 18px; cursor: pointer;">
                                            </td>
                                            <td class="text-nowrap fw-bold">
                                                <i class="far fa-calendar-alt text-primary me-1"></i> ${item.tanggal_registrasi}
                                            </td>
                                            <td>
                                                <span class="badge bg-white text-danger border border-dark fw-bold font-monospace fs--2 px-2 py-1">${item.no_registrasi}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark text-uppercase fw-bolder d-block">${item.nama_pasien}</span>
                                                <span class="badge bg-light text-dark border border-dark fw-bold fs--2"><i class="fas fa-qrcode me-1"></i>${item.pid}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block">${item.layanan}</span>
                                                <small class="text-muted fw-bold" style="font-size: 0.65rem;">${item.poli}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-white text-dark border border-dark fw-bold px-2 py-1">${item.metode_bayar}</span>
                                            </td>
                                            <td class="text-end fw-bolder text-success fs-0">
                                                Rp ${Number(item.total_tagihan).toLocaleString('id-ID')}
                                            </td>
                                        </tr>
                                    `;
                                });
                            } else {
                                rows = `<tr><td colspan="7" class="text-center py-4 text-muted fw-bold">Tidak ada transaksi lunas baru yang belum dilaporkan.</td></tr>`;
                            }

                            // Tampilan Modal HTML ala Front Office (Retro Theme)
                            let htmlModal = `
                                <div class="text-start">
                                    <!-- TABEL UTAMA -->
                                    <div class="table-responsive border border-3 border-dark rounded-3 mb-3 shadow-sm" style="max-height: 400px; overflow-y: auto;">
                                        <table class="table table-hover align-middle mb-0 fs--1" style="background-color: #fff;">
                                            <thead class="text-dark" style="background-color: var(--retro-dark); color: var(--retro-green) !important; font-size: 0.7rem; border-bottom: 3px solid var(--retro-dark);">
                                                <tr>
                                                    <th class="text-center" width="5%"><input type="checkbox" class="form-check-input" id="checkAllKeu" checked onclick="toggleAllKeu(this)" style="border: 2px solid var(--retro-dark); width: 18px; height: 18px; cursor: pointer;"></th>
                                                    <th width="20%">TGL REGISTRASI</th>
                                                    <th width="18%">NO. REGISTRASI</th>
                                                    <th width="22%">NAMA PASIEN (PID)</th>
                                                    <th width="15%">JENIS LAYANAN</th>
                                                    <th width="10%" class="text-center">METODE</th>
                                                    <th width="10%" class="text-end">TOTAL TAGIHAN</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-bold text-dark">
                                                ${rows}
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- FOOTER PANEL SUMMARY & TOMBOL AKSI -->
                                    <div class="p-3 rounded-3 border border-3 border-dark bg-white d-flex flex-wrap justify-content-between align-items-center shadow-sm gap-2">
                                        <div class="d-flex gap-2">
                                            <div class="p-2 border border-2 border-dark rounded-2 bg-light text-center px-3">
                                                <small class="text-muted fw-bold d-block fs--2">TOTAL DIPILIH</small>
                                                <h6 class="fw-bolder mb-0 text-dark" id="lblTotalDipilih">0 Transaksi</h6>
                                            </div>
                                            <div class="p-2 border border-2 border-dark rounded-2 bg-light text-center px-3">
                                                <small class="text-muted fw-bold d-block fs--2">TOTAL SETORAN</small>
                                                <h6 class="fw-bolder mb-0 text-success" id="lblTotalSetoran">Rp 0</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn retro-btn btn-light border-dark px-4 fw-bold" onclick="Swal.close()" style="background-color: #fff; border: 2px solid var(--retro-dark);">
                                                BATAL
                                            </button>
                                            <button type="button" class="btn retro-btn px-4 fw-bold text-white shadow-sm" id="btnBuatNotaLaporan" onclick="prosesSimpanLaporanKeuanganFinal()" style="background-color: #598f72; border: 2px solid var(--retro-dark);">
                                                <i class="fas fa-paper-plane me-1"></i> BUAT NOTA LAPORAN
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;

                            Swal.fire({
                                title: '<div class="text-start fw-bolder fs-2 text-dark"><i class="fas fa-file-invoice-dollar me-2 text-warning"></i> Rekap Transaksi Belum Dilaporkan ke Accounting</div>',
                                html: htmlModal,
                                width: '1050px',
                                showConfirmButton: false,
                                showCloseButton: true,
                                customClass: {
                                    popup: 'retro-card border-3 border-dark shadow-lg p-3'
                                },
                                didRender: () => {
                                    hitungTotalSetoranKeu();
                                }
                            });
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memuat data transaksi pelunasan.', 'error');
                    }
                });
            }
        });
    }

    function toggleAllKeu(source) {
        $('.select-transaksi-keu').prop('checked', source.checked);
        hitungTotalSetoranKeu();
    }

    function hitungTotalSetoranKeu() {
        let totalCount = 0;
        let totalSum = 0;

        $('.select-transaksi-keu:checked').each(function() {
            totalCount++;
            totalSum += parseFloat($(this).data('tagihan')) || 0;
        });

        $('#lblTotalDipilih').text(totalCount + ' Transaksi');
        $('#lblTotalSetoran').text('Rp ' + totalSum.toLocaleString('id-ID'));
    }

    function prosesSimpanLaporanKeuanganFinal() {
        let selectedIds = [];
        $('.select-transaksi-keu:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            return Swal.fire('Perhatian', 'Pilih minimal 1 transaksi untuk dibuatkan laporan!', 'warning');
        }

        Swal.fire({
            title: 'Menyimpan Laporan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('keuangan.store_laporan_keuangan_keuangan') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                transaksi_ids: selectedIds
            },
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                    }).then(() => {
                        loadAntreanKasir();
                    });
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function(xhr) {
                let msg = 'Terjadi kesalahan pada server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Gagal', msg, 'error');
            }
        });
    }

    function cetakNotaAktif() {
        if (!selectedOrderCode) {
            return Swal.fire('Perhatian', 'Pilih pasien/transaksi terlebih dahulu dari tabel sebelah kiri!', 'warning');
        }
        window.open("{{ url('application/cashier/download-receipt-pdf') }}/" + selectedOrderCode, '_blank');
    }

    function bukaKartuKontrol() {
        if (!selectedOrderCode) {
            return Swal.fire('Perhatian', 'Pilih pasien terlebih dahulu!', 'warning');
        }
        Swal.fire('Info', 'Fitur Kartu Kontrol Pasien', 'info');
    }
</script>
@endsection
