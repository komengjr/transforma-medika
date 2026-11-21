@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-cyan) 0%, var(--retro-green) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .filter-bar-container {
        background-color: #ffffff;
        border: var(--retro-border);
        border-radius: 12px;
        padding: 12px 15px;
        margin-bottom: 15px;
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
    }

    .table-custom thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-cyan) !important;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 10px 8px;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-3 text-dark">
                <div class="row align-items-center">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="p-2 rounded-4 shadow-sm me-3 bg-white d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-file-invoice-dollar fs-4 text-dark"></i>
                        </div>
                        <div>
                            <h4 class="fw-bolder mb-0 text-dark">
                                Modul Penagihan Keuangan <span class="fw-normal">Perusahaan / Asuransi</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER & LAYOUT UTAMA (2 KOLOM: KIRI DAFTAR, KANAN FORM BUAT/PILIH PASIEN) -->
<div class="row g-3">

    <!-- KOLOM KIRI: DAFTAR / TABEL ISU PENAGIHAN -->
    <div class="col-lg-6">
        <!-- FILTER BAR KIRI -->
        <div class="filter-bar-container">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-dark mb-1 fs--2 fw-bolder">KEL. PELANGGAN</label>
                    <select class="form-select form-select-sm retro-input" id="filter_penjamin" onchange="loadDaftarPenagihan()">
                        <option value="">Semua Perusahaan</option>
                        @foreach ($subPenjamins ?? [] as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-dark mb-1 fs--2 fw-bolder">NO. ISU PENAGIHAN</label>
                    <input type="text" class="form-control form-control-sm retro-input" id="filter_no_tagihan" placeholder="Cari No Tagihan..." onkeyup="loadDaftarPenagihan()">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-dark mb-1 fs--2 fw-bolder">STATUS</label>
                    <select class="form-select form-select-sm retro-input" id="filter_status" onchange="loadDaftarPenagihan()">
                        <option value="DRAFT" selected>Draft / Belum Lunas</option>
                        <option value="LUNAS">Lunas</option>
                        <option value="">Semua Status</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn retro-btn btn-success w-100 fw-bold" style="height: 31px;" onclick="bukaPanelBuatTagihan()" title="Buat Penagihan Baru">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- TABEL DAFTAR PENAGIHAN DI KIRI -->
        <div class="retro-card">
            <div class="table-responsive" style="max-height: 650px; overflow-y: auto;">
                <table class="table table-hover table-custom align-middle mb-0 fs--1" style="border: 2px solid var(--retro-dark);">
                    <thead>
                        <tr>
                            <th>TGL. PENAGIHAN</th>
                            <th>NO. PENAGIHAN</th>
                            <th>JATUH TEMPO</th>
                            <th>KEL. PELANGGAN</th>
                            <th class="text-end">TOTAL PENAGIHAN</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-daftar-penagihan-body" class="fw-bold text-dark">
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Memuat data penagihan...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: PANEL PEMBUATAN / PEMILIHAN PASIEN & RINCIAN ITEM -->
    <div class="col-lg-6">
        <div class="retro-card p-3 h-100" style="background-color: #fcfbfa;">
            <div class="d-flex justify-content-between align-items-center border-bottom border-dark pb-2 mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="fas fa-file-circle-plus me-1 text-primary"></i> Buat / Pilih Nota Tagihan</h6>
                <button class="btn btn-sm retro-btn btn-success px-4" onclick="simpanHeaderTagihan()">
                    <i class="fas fa-save me-1"></i> SIMPAN <i class="fas fa-download ms-1"></i>
                </button>
            </div>

            <!-- Form Pembuatan / Header Tagihan -->
            <div class="row g-2 mb-3">
                <div class="col-12">
                    <label class="form-label fs--2 fw-bold text-dark">PILIH PERUSAHAAN / SUB PENJAMIN</label>
                    <select class="form-select form-select-sm retro-input" id="input_sub_penjamin" onchange="loadPasienPiutangByPenjamin()">
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($subPenjamins ?? [] as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fs--2 fw-bold text-dark">TANGGAL TAGIHAN</label>
                    <input type="date" class="form-control form-control-sm retro-input" id="input_tgl_tagihan" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fs--2 fw-bold text-dark">JATUH TEMPO</label>
                    <input type="date" class="form-control form-control-sm retro-input" id="input_jatuh_tempo" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                </div>
            </div>

            <!-- Filter & Tabel Daftar Nota Pasien -->
            <div class="d-flex justify-content-between align-items-center mb-1">
                <small class="fw-bold text-muted" id="lblJumlahNotaPilih">Jumlah Nota : 0</small>
            </div>
            <div class="table-responsive border border-2 border-dark rounded-2 bg-white mb-3" style="max-height: 450px; overflow-y: auto;">
                <table class="table table-sm table-bordered table-hover align-middle mb-0 fs--1">
                    <thead class="table-dark" style="position: sticky; top: 0; z-index: 2;">
                        <tr>
                            <th class="text-center" width="7%"><input type="checkbox" id="checkAllPasienPiutang" onclick="toggleAllPasienPiutang(this)"></th>
                            <th width="20%">NO. REG / TGL</th>
                            <th width="45%">NAMA PASIEN & RINCIAN ITEM (TINDAKAN / OBAT)</th>
                            <th class="text-end" width="28%">TOTAL PRSH</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-pilih-pasien-body" class="fw-bold text-dark">
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">Pilih perusahaan terlebih dahulu.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total Keseluruhan -->
            <div class="p-2 bg-dark text-white rounded-2 d-flex justify-content-between align-items-center">
                <span class="fs--1 fw-bold">Total Tanggungan Perusahaan:</span>
                <span class="fs-0 text-success fw-bolder" id="lblTotalNominalPrsh">Rp 0</span>
            </div>

        </div>
    </div>

</div>

<!-- MODAL DETAIL PENAGIHAN, PREVIEW PDF, DAN PEMBAYARAN -->
<div class="modal fade" id="modalDetailPenagihan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content retro-card border-3 border-dark shadow-lg">
            <div class="modal-header bg-warning text-dark border-bottom border-dark py-3">
                <h5 class="modal-title fw-bolder"><i class="fas fa-file-invoice-dollar me-2"></i> Detail Penagihan & Pembayaran Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="row g-3">
                    <!-- Kolom Kiri: Preview Dokumen PDF Tagihan -->
                    <div class="col-lg-7">
                        <div class="card h-100 border border-2 border-dark">
                            <div class="card-header bg-dark text-white py-2 d-flex justify-content-between align-items-center">
                                <span class="fs--1 fw-bold"><i class="fas fa-eye me-1"></i> Preview PDF Tagihan</span>
                                <a href="#" id="btnDownloadPdfModal" class="btn btn-sm btn-outline-light fs--2 fw-bold" target="_blank"><i class="fas fa-download me-1"></i> Download PDF</a>
                            </div>
                            <div class="card-body p-0 bg-secondary bg-opacity-10" style="height: 450px;">
                                <iframe id="framePdfPreview" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Form Pembayaran & Aksi Kirim Pesan -->
                    <div class="col-lg-5">
                        <div class="card h-100 border border-2 border-dark p-3 bg-white">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-wallet me-1 text-success"></i> Informasi & Pelunasan Tagihan</h6>

                            <div class="mb-2">
                                <small class="text-muted fw-bold d-block">NO. PENAGIHAN</small>
                                <h6 class="fw-bolder text-danger mb-1" id="modalNoTagihan">-</h6>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted fw-bold d-block">PERUSAHAAN / PENJAMIN</small>
                                <h6 class="fw-bolder text-dark mb-1" id="modalNamaPerusahaan">-</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted fw-bold d-block">TOTAL NOMINAL TAGIHAN</small>
                                <h4 class="fw-bolder text-success mb-0" id="modalTotalTagihan">Rp 0</h4>
                            </div>

                            <div class="border-top pt-3 mt-2">
                                <label class="form-label fw-bold fs--1 text-dark">METODE PEMBAYARAN PERUSAHAAN</label>
                                <select class="form-select form-select-sm retro-input mb-2" id="modalMetodeBayar">
                                    <option value="TRANSFER_BANK">Transfer Bank / Giro</option>
                                    <option value="PIUTANG_LUNAS">Pelunasan Piutang Perusahaan</option>
                                </select>

                                <label class="form-label fw-bold fs--1 text-dark">NO REFERENSI / BUKTI TRANSFER</label>
                                <input type="text" class="form-control form-control-sm retro-input mb-3" id="modalNoRef" placeholder="Masukkan No Ref / Keterangan">

                                <button class="btn retro-btn btn-success w-100 py-2 fw-bold shadow-sm" onclick="prosesBayarTagihanModal()">
                                    <i class="fas fa-check-circle me-1"></i> PROSES PELUNASAN TAGIHAN
                                </button>
                            </div>

                            <!-- Opsi Kirim Pesan Cepat -->
                            <div class="mt-auto pt-3 border-top d-flex gap-2">
                                <button class="btn btn-sm retro-btn btn-primary flex-grow-1 fs--2" onclick="kirimPesanTagihanAktif('whatsapp')">
                                    <i class="fab fa-whatsapp me-1"></i> Kirim WA
                                </button>
                                <button class="btn btn-sm retro-btn btn-warning flex-grow-1 fs--2 text-dark" onclick="kirimPesanTagihanAktif('email')">
                                    <i class="fas fa-envelope me-1"></i> Kirim Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentPiutangList = [];

    $(document).ready(function() {
        loadDaftarPenagihan();
    });

    function loadDaftarPenagihan() {
        let penjamin = $('#filter_penjamin').val();
        let noTagihan = $('#filter_no_tagihan').val();
        let status = $('#filter_status').val();

        $('#tabel-daftar-penagihan-body').html(`<tr><td colspan="7" class="text-center py-3 text-muted">Memuat data...</td></tr>`);

        $.ajax({
            url: "{{ route('api.daftar.penagihan.perusahaan') }}",
            type: "GET",
            data: {
                penjamin: penjamin,
                keyword: noTagihan,
                status: status
            },
            success: function(res) {
                if (res.success && res.data.length > 0) {
                    let html = '';

                    res.data.forEach(item => {
                        let badgeStatus = item.status_tagihan === 'LUNAS' ?
                            '<span class="badge bg-success text-white">LUNAS</span>' :
                            '<span class="badge bg-warning text-dark">DRAFT</span>';
                        let aksiBtn = `
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-sm retro-btn btn-warning px-2 py-1 fs--2" onclick="bukaModalDetailPenagihan(${item.penagihan_id})" title="Preview PDF & Bayar"><i class="fas fa-file-pdf"></i></button>
                                <button class="btn btn-sm retro-btn btn-success px-2 py-1 fs--2" onclick="konfirmasiKirimPesan(${item.penagihan_id}, 'whatsapp')" title="Kirim WhatsApp"><i class="fab fa-whatsapp"></i></button>
                                <button class="btn btn-sm retro-btn btn-primary px-2 py-1 fs--2" onclick="konfirmasiKirimPesan(${item.penagihan_id}, 'email')" title="Kirim Email"><i class="fas fa-envelope"></i></button>
                            </div>
                        `;
                        html += `
                            <tr>
                                <td>${item.tanggal_tagihan}</td>
                                <td><span class="text-danger fw-bold">${item.no_tagihan}</span></td>
                                <td>${item.tanggal_tagihan}</td>
                                <td>${item.nama_sub_penjamin}</td>
                                <td class="text-end text-success fw-bold">Rp ${Number(item.total_tagihan).toLocaleString('id-ID')}</td>
                                <td class="text-center">${badgeStatus}</td>
                                <td class="text-center">${aksiBtn}</td>
                            </tr>
                        `;
                    });
                    $('#tabel-daftar-penagihan-body').html(html);
                } else {
                    $('#tabel-daftar-penagihan-body').html(`<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data penagihan.</td></tr>`);
                }
            }
        });
    }

    function bukaPanelBuatTagihan() {
        $('#input_sub_penjamin').val('').trigger('change');
        $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-3 text-muted">Pilih perusahaan terlebih dahulu.</td></tr>`);
        Swal.fire({
            icon: 'info',
            title: 'Mode Pembuatan Tagihan',
            text: 'Silakan pilih perusahaan di panel kanan untuk menampilkan daftar pasien piutang.',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function loadPasienPiutangByPenjamin() {
        let subPenjaminId = $('#input_sub_penjamin').val();
        if (!subPenjaminId) {
            $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-3 text-muted">Pilih perusahaan terlebih dahulu.</td></tr>`);
            $('#lblJumlahNotaPilih').text('Jumlah Nota : 0');
            $('#lblTotalNominalPrsh').text('Rp 0');
            return;
        }

        $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-3 text-muted">Memuat data pasien dan rincian item...</td></tr>`);

        $.ajax({
            url: "{{ route('api.pasien.by.subpenjamin') }}",
            type: "GET",
            data: {
                sub_penjamin_id: subPenjaminId
            },
            success: function(res) {
                if (res.success && res.data.length > 0) {
                    let transaksiIds = res.data.map(item => item.transaksi_id);

                    $.ajax({
                        url: "{{ route('api.rincian.item.transaksi') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            transaksi_ids: transaksiIds
                        },
                        success: function(resItem) {
                            let itemMap = {};
                            if (resItem.success && resItem.items.length > 0) {
                                resItem.items.forEach(it => {
                                    if (!itemMap[it.transaksi_id]) itemMap[it.transaksi_id] = [];
                                    itemMap[it.transaksi_id].push(it);
                                });
                            }

                            currentPiutangList = res.data.map(pasien => {
                                pasien.items = itemMap[pasien.transaksi_id] || [];
                                return pasien;
                            });

                            renderTabelPiutangPasien(currentPiutangList);
                        }
                    });

                } else {
                    currentPiutangList = [];
                    $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-4 text-muted">Tidak ada piutang untuk perusahaan ini.</td></tr>`);
                    $('#lblJumlahNotaPilih').text('Jumlah Nota : 0');
                    $('#lblTotalNominalPrsh').text('Rp 0');
                }
            }
        });
    }

    function renderTabelPiutangPasien(data) {
        let html = '';
        let count = 0;
        data.forEach(item => {
            count++;
            let rincianHtml = `<div class="text-uppercase mb-1 fw-bolder">${item.nama_lengkap}</div><small class="text-muted d-block mb-1">RM: ${item.pid}</small>`;
            if (item.items && item.items.length > 0) {
                rincianHtml += `<div class="ps-2 border-start border-3 border-warning mt-1 py-1 bg-light rounded-1">`;
                item.items.forEach(it => {
                    let badgeColor = it.jenis_item === 'OBAT' ? 'bg-danger' : 'bg-secondary';
                    rincianHtml += `
                        <div class="d-flex justify-content-between align-items-center fs--2 py-0.5 border-bottom border-light">
                            <span><span class="badge ${badgeColor} me-1" style="font-size: 0.55rem;">${it.jenis_item}</span> ${it.nama_item} (x${it.qty})</span>
                            <span class="text-success fw-bold">Rp ${Number(it.tanggungan_perusahaan).toLocaleString('id-ID')}</span>
                        </div>
                    `;
                });
                rincianHtml += `</div>`;
            } else {
                rincianHtml += `<small class="text-muted fst-italic">Tidak ada rincian item tercatat.</small>`;
            }

            html += `
                <tr>
                    <td class="text-center align-top pt-2"><input type="checkbox" class="form-check-input pasien-piutang-checkbox" value="${item.transaksi_id}" data-total="${item.tanggungan_perusahaan}" checked onchange="hitungJumlahNotaPilih()" style="border: 2px solid var(--retro-dark);"></td>
                    <td class="align-top pt-2">
                        <span class="text-danger fw-bold d-block">${item.no_registrasi}</span>
                        <small class="text-muted">${item.tanggal_registrasi}</small>
                    </td>
                    <td class="align-top pt-2">${rincianHtml}</td>
                    <td class="text-end align-top pt-2 text-success fw-bolder">Rp ${Number(item.tanggungan_perusahaan).toLocaleString('id-ID')}</td>
                </tr>
            `;
        });
        $('#tabel-pilih-pasien-body').html(html);
        hitungJumlahNotaPilih();
    }

    function toggleAllPasienPiutang(source) {
        $('.pasien-piutang-checkbox').prop('checked', source.checked);
        hitungJumlahNotaPilih();
    }

    function hitungJumlahNotaPilih() {
        let checkedCount = 0;
        let totalSumPrsh = 0;

        $('.pasien-piutang-checkbox:checked').each(function() {
            checkedCount++;
            totalSumPrsh += parseFloat($(this).data('total')) || 0;
        });

        $('#lblJumlahNotaPilih').text('Jumlah Nota : ' + checkedCount);
        $('#lblTotalNominalPrsh').text('Rp ' + totalSumPrsh.toLocaleString('id-ID'));
    }

    function simpanHeaderTagihan() {
        let subPenjaminId = $('#input_sub_penjamin').val();
        let tglTagihan = $('#input_tgl_tagihan').val();

        if (!subPenjaminId) {
            return Swal.fire('Perhatian', 'Pilih perusahaan / sub penjamin terlebih dahulu!', 'warning');
        }

        let selectedTransaksiIds = [];
        $('.pasien-piutang-checkbox:checked').each(function() {
            selectedTransaksiIds.push($(this).val());
        });

        if (selectedTransaksiIds.length === 0) {
            return Swal.fire('Perhatian', 'Pilih minimal 1 nota/pasien yang akan ditagihkan!', 'warning');
        }

        Swal.fire({
            title: 'Menyimpan Tagihan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('api.buat.tagihan.perusahaan') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                sub_penjamin_id: subPenjaminId,
                tanggal_tagihan: tglTagihan,
                transaksi_ids: selectedTransaksiIds
            },
            success: function(res) {
                if (res.success) {
                    Swal.fire('Berhasil!', res.message, 'success');
                    loadDaftarPenagihan();
                    $('#input_sub_penjamin').val('').trigger('change');
                    $('#tabel-pilih-pasien-body').html(`<tr><td colspan="4" class="text-center py-3 text-muted">Pilih perusahaan terlebih dahulu.</td></tr>`);
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            }
        });
    }
</script>
<script>
    let selectedPenjaminIdModal = null;

    function bukaModalDetailPenagihan(penagihanId) {
        selectedPenjaminIdModal = penagihanId;

        $.ajax({
            url: "{{ url('application/api/penagihan/detail') }}/" + penagihanId,
            type: "GET",
            success: function(res) {
                if (res.success) {
                    $('#modalNoTagihan').text(res.data.no_tagihan);
                    $('#modalNamaPerusahaan').text(res.data.nama_sub_penjamin);
                    $('#modalTotalTagihan').text('Rp ' + Number(res.data.total_tagihan).toLocaleString('id-ID'));

                    let pdfUrl = "{{ url('/application/penagihan/download-pdf') }}/" + penagihanId;
                    $('#framePdfPreview').attr('src', pdfUrl);
                    $('#btnDownloadPdfModal').attr('href', pdfUrl);

                    $('#modalDetailPenagihan').modal('show');
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            }
        });
    }

    function prosesBayarTagihanModal() {
        if (!selectedPenjaminIdModal) return;

        let metode = $('#modalMetodeBayar').val();
        let noRef = $('#modalNoRef').val();

        Swal.fire({
            title: 'Konfirmasi Pelunasan',
            text: 'Proses pelunasan untuk seluruh tagihan dalam nomor penagihan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lunasi!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#598f72',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajax({
                    url: "{{ route('api.pelunasan.penagihan.perusahaan') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        penagihan_id: selectedPenjaminIdModal,
                        metode_bayar: metode,
                        no_referensi: noRef
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Berhasil!', res.message, 'success');
                            $('#modalDetailPenagihan').modal('hide');
                            loadDaftarPenagihan();
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    }
                });
            }
        });
    }

    function konfirmasiKirimPesan(penagihanId, tipe) {
        let namaTipe = tipe === 'whatsapp' ? 'WhatsApp' : 'Email';
        Swal.fire({
            title: `Kirim Tagihan via ${namaTipe}?`,
            text: `Sistem akan mengirimkan pesan notifikasi tagihan ke kontak perusahaan terkait.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim Sekarang!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                kirimPesanTagihan(penagihanId, tipe);
            }
        });
    }

    function kirimPesanTagihan(penagihanId, tipe) {
        Swal.fire({
            title: 'Mengirim Pesan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ url('application/api/penagihan/kirim-pesan') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                penagihan_id: penagihanId,
                tipe_pengiriman: tipe
            },
            success: function(res) {
                if (res.success) {
                    if (tipe === 'whatsapp' && res.whatsapp_url) {
                        Swal.close();
                        window.open(res.whatsapp_url, '_blank');
                    } else {
                        Swal.fire('Berhasil', res.message, 'success');
                    }
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan pada server saat mengirim pesan.', 'error');
            }
        });
    }

    function kirimPesanTagihanAktif(tipe) {
        if (selectedPenjaminIdModal) {
            konfirmasiKirimPesan(selectedPenjaminIdModal, tipe);
        }
    }
</script>
@endsection
