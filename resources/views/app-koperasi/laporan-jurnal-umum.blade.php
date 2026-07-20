@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    /* Tweak khusus untuk Mode Cetak / Print Printer */
    @media print {
        .no-print {
            display: none !important;
        }

        .print-card {
            border: none !important;
            shadow: none !important;
            box-shadow: none !important;
        }

        .page-break {
            page-break-before: always;
        }
    }
</style>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-success">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/koperasi.png') }}" alt="" width="60" />
                    <div>
                        <h6 class="text-success fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span class="text-success fw-medium">Management System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block " src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Akutansi <span class="text-success fw-medium">Jurnal Otomatis</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card p-3 mb-3 border-1 shadow-sm rounded-3 border border-primary">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Pusat Laporan Keuangan Koperasi</h1>
            <p class="text-muted small mb-0">Silakan pilih tab untuk melihat dan mencetak laporan keuangan</p>
        </div>
    </div>
    <div class="row g-3 align-items-center mt-1">
        <div class="col-md-3">
            <label class="form-label small fw-bold text-secondary">Tanggal Mulai</label>
            <input type="date" id="global-tgl-mulai" class="form-control" value="<?= date('Y-m-01') ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-secondary">Tanggal Selesai</label>
            <input type="date" id="global-tgl-selesai" class="form-control" value="<?= date('Y-m-t') ?>">
        </div>
        <div class="col-md-4" id="wrapper-select-coa" style="display:none;">
            <label class="form-label small fw-bold text-secondary">Pilih Akun COA (Buku Besar)</label>
            <select id="bb-coa-code" class="form-select">
                @foreach ($coa as $coas)
                <option value="{{ $coas->coa_code }}">{{ $coas->coa_code }} - {{ $coas->coa_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 mt-auto">
            <button onclick="loadLaporanAktif()" class="btn btn-primary w-100 fw-medium shadow-sm">Buka Laporan</button>
        </div>
    </div>
</div>

<ul class="nav nav-tabs nav-fill mb-3 bg-white p-2 rounded-3 shadow-sm border-0" id="laporanTab" role="tablist">
    <li class="nav-item"><button class="nav-link active fw-bold text-uppercase" onclick="switchLaporan('jurnal', event)">1. Jurnal Umum</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('bukubesar', event)">2. Buku Besar</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('labarugi', event)">3. Laba Rugi</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('modal', event)">4. Perubahan Modal</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('neraca', event)">5. Neraca</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('aruskas', event)">6. Arus Kas</button></li>
</ul>

<div class="card mb-3 border-0 shadow-sm p-4 bg-white rounded-3" id="area-print-laporan">
    <div id="konten-laporan-dinamis"></div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-penjualan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-penjualan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-penjualan"></div>
        </div>
    </div>
</div>
<!-- Modal Edit Jurnal Manual -->
<!-- Modal Edit Jurnal Transaksi Manual -->
<div class="modal fade" id="modal-edit-jurnal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditJurnalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalEditJurnalLabel">
                    <i class="fas fa-edit me-2"></i>Koreksi Jurnal Transaksi Manual
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update-jurnal" onsubmit="submitUpdateJurnal(event)">
                <div class="modal-body">
                    <!-- Data Header Induk Jurnal -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary text-uppercase small">Nomor Bukti</label>
                            <input type="text" id="edit-jurnal-no-bukti" name="no_bukti" class="form-control bg-light fw-bold" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary text-uppercase small">Tanggal Transaksi</label>
                            <input type="date" id="edit-jurnal-tgl" name="jurnal_tgl" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark text-uppercase small">Keterangan Transaksi</label>
                            <textarea id="edit-jurnal-keterangan" name="keterangan" class="form-control" rows="1" placeholder="Masukkan keterangan..." required></textarea>
                        </div>
                    </div>

                    <!-- Tabel Rincian Akun -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light text-center text-uppercase small fw-bold">
                                <tr>
                                    <th style="width: 50%;">Akun Perkiraan (COA)</th>
                                    <th style="width: 25%;">Posisi Debit (IDR)</th>
                                    <th style="width: 25%;">Posisi Kredit (IDR)</th>
                                </tr>
                            </thead>
                            <tbody id="container-form-detail-jurnal">
                                <!-- Baris form rincian di-generate via javascript -->
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td class="text-end text-uppercase">Total Keseluruhan :</td>
                                    <td>
                                        <input type="text" id="total-edit-debit-display" class="form-control form-control-sm text-end fw-bold text-success font-monospace bg-light" readonly value="0">
                                    </td>
                                    <td>
                                        <input type="text" id="total-edit-kredit-display" class="form-control form-control-sm text-end fw-bold text-danger font-monospace bg-light" readonly value="0">
                                    </td>
                                </tr>
                                <tr id="baris-peringatan-balancing" class="d-none">
                                    <td colspan="3" class="bg-danger-subtle text-danger text-center small fw-semibold">
                                        <i class="fas fa-exclamation-triangle me-2"></i> Jurnal saat ini belum balance! Selisih: <span id="nilai-selisih-balancing" class="font-monospace fw-bold">0</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn-simpan-jurnal" class="btn btn-success px-4 fw-bold">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
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

    // Dipanggil saat halaman pertama kali selesai dimuat
    document.addEventListener("DOMContentLoaded", function() {
        loadLaporanAktif();
    });

    function switchLaporan(tipe, e) {
        laporanAktif = tipe;

        // Tampilkan dropdown pilih COA hanya jika menu Buku Besar aktif
        document.getElementById('wrapper-select-coa').style.display = (tipe === 'bukubesar') ? 'block' : 'none';

        // Ubah status aktif tombol tab
        document.querySelectorAll('#laporanTab .nav-link').forEach(btn => btn.classList.remove('active'));

        if (e && e.target) {
            e.target.classList.add('active');
        }

        loadLaporanAktif();
    }

    function loadLaporanAktif() {
        const tglMulai = document.getElementById('global-tgl-mulai').value;
        const tglSelesai = document.getElementById('global-tgl-selesai').value;
        const container = document.getElementById('konten-laporan-dinamis');

        // Tampilkan placeholder loading agar user tahu data sedang diproses
        container.innerHTML = `
            <div class="text-center my-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-muted small mt-2">Memuat data laporan...</p>
            </div>`;

        const params = `?tgl_mulai=${tglMulai}&tgl_selesai=${tglSelesai}`;

        if (laporanAktif === 'jurnal') {
            fetch(`{{ route('akutansi_koperasi_report_jurnal_cabang') }}${params}`)
                .then(res => res.json())
                .then(data => {
                    if (!data || data.length === 0) {
                        container.innerHTML = `<div class="alert alert-info text-center">Tidak ada aktivitas transaksi pada periode ini.</div>`;
                        return;
                    }

                    window.rawJurnalData = data;

                    window.renderJurnalTabel = function(filterText = '') {
                        const searchKeyword = filterText.toLowerCase().trim();
                        const groupedJurnal = {};
                        let adaDataCocok = false;

                        window.rawJurnalData.forEach(item => {
                            const coaCode = (item.coa_code || '').toLowerCase();
                            const coaName = (item.coa_name || '').toLowerCase();
                            const noBukti = (item.jurnal_no_bukti || '').toLowerCase();
                            const keterangan = (item.jurnal_keterangan || '').toLowerCase();

                            if (searchKeyword === '' ||
                                coaCode.includes(searchKeyword) ||
                                coaName.includes(searchKeyword) ||
                                noBukti.includes(searchKeyword) ||
                                keterangan.includes(searchKeyword)) {

                                adaDataCocok = true;

                                if (!groupedJurnal[item.jurnal_no_bukti]) {
                                    groupedJurnal[item.jurnal_no_bukti] = {
                                        tanggal: item.jurnal_tgl,
                                        keterangan: item.jurnal_keterangan,
                                        details: []
                                    };
                                }
                                groupedJurnal[item.jurnal_no_bukti].details.push({
                                    id_jurnal_detail: item.id || item.id_jurnal_detail,
                                    coa_code: item.coa_code,
                                    coa_name: item.coa_name,
                                    debit: Number(item.jurnal_debit),
                                    kredit: Number(item.jurnal_kredit)
                                });
                            }
                        });

                        const tabelContainer = document.getElementById('jurnal-tabel-wrapper');
                        if (!tabelContainer) return;

                        if (!adaDataCocok) {
                            tabelContainer.innerHTML = `<div class="alert alert-warning text-center my-3">Tidak ada data yang cocok dengan "${filterText}".</div>`;
                            return;
                        }

                        let tableHtml = `
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0 small">
                                <thead class="table-dark text-uppercase text-center">
                                    <tr>
                                        <th style="width: 15%;">Tanggal / No. Bukti</th>
                                        <th style="width: 35%;">Rekening / Akun COA & Keterangan</th>
                                        <th style="width: 10%;">Ref COA</th>
                                        <th style="width: 20%;">Debit</th>
                                        <th style="width: 20%;">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                        Object.keys(groupedJurnal).forEach(noBukti => {
                            const jurnal = groupedJurnal[noBukti];

                            // DISINI: Inject tombol aksi Edit Manual di baris header No Bukti
                            tableHtml += `
                            <tr class="table-light fw-bold border-bottom-0">
                                <td><i class="bi bi-calendar3 me-1"></i> ${jurnal.tanggal}</td>
                                <td colspan="4" class="text-primary text-uppercase d-flex justify-content-between align-items-center">
                                    <span><span class="text-dark small fw-normal">No. Bukti:</span> ${noBukti}</span>
                                    <button class="btn btn-xs btn-outline-warning py-0 px-2 fw-bold no-print"
                                            onclick="bukaModalEditJurnal('${noBukti}')">
                                        <i class="bi bi-pencil-fill me-1"></i> Update Manual
                                    </button>
                                </td>
                            </tr>`;

                            jurnal.details.forEach((detail, index) => {
                                const indentStyle = detail.kredit > 0 ? 'ps-4 text-secondary fst-italic' : 'fw-semibold text-dark';
                                const displayDebit = detail.debit > 0 ? `Rp ${detail.debit.toLocaleString('id-ID')}` : '-';
                                const displayKredit = detail.kredit > 0 ? `Rp ${detail.kredit.toLocaleString('id-ID')}` : '-';
                                const isLastRow = index === jurnal.details.length - 1;
                                const keteranganTambahan = isLastRow ? `<div class="text-muted text-capitalize mt-1 font-monospace" style="font-size: 11px;">* Keterangan: ${jurnal.keterangan}</div>` : '';

                                // PERBAIKAN DI SINI: Deteksi variasi nama properti agar tidak memunculkan 'undefined'
                                // Jika detail.coa_name tidak ada, ia akan mencoba mencari ke properti lain yang mirip
                                const namaCoaAman = detail.coa_name || detail.nama_coa || detail.account_name || "Tanpa Nama Akun";

                                tableHtml += `
                                <tr class="border-top-0">
                                    <td class="text-center text-muted small"></td>
                                    <td class="${indentStyle}">
                                        <!-- Menggunakan namaCoaAman yang sudah divalidasi -->
                                        ${namaCoaAman}
                                        ${keteranganTambahan}
                                    </td>
                                    <td class="text-center text-secondary">${detail.coa_code}</td>
                                    <td class="text-end text-success font-monospace">${displayDebit}</td>
                                    <td class="text-end text-danger font-monospace">${displayKredit}</td>
                                </tr>`;
                            });

                            tableHtml += `<tr class="table-white"><td colspan="5" style="padding: 4px; background-color: #fcfcfc;"></td></tr>`;
                        });

                        tableHtml += '</tbody></table></div>';
                        tabelContainer.innerHTML = tableHtml;
                    };

                    container.innerHTML = `
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-3 no-print">
                        <div>
                            <h4 class="fw-bold m-0 text-dark">Jurnal Umum Koperasi</h4>
                            <p class="text-muted small m-0">Menampilkan mutasi berpasangan (Double-Entry)</p>
                        </div>
                        <div class="position-relative" style="width: 100%; max-width: 350px;">
                            <input type="text" id="search-jurnal-coa" class="form-control form-control-sm ps-4" placeholder="Cari Kode COA / Nama Akun..." onkeyup="window.renderJurnalTabel(this.value)">
                        </div>
                    </div>
                    <div id="jurnal-tabel-wrapper"></div>`;

                    window.renderJurnalTabel('');
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = `<div class="alert alert-danger">Gagal memuat struktur data Jurnal Umum.</div>`;
                });
        } else if (laporanAktif === 'bukubesar') {
            const coa = document.getElementById('bb-coa-code').value;

            fetch(`{{ route('akutansi_koperasi_report_buku_besar_cabang') }}${params}&coa_code=${coa}`)
                .then(res => res.json())
                .then(data => {
                    const jenisSaldoNormal = data.normal_balance || (data.coa?.normal_balance) || 'debit';

                    // 1. Simpan data mentah ke properti window agar aman diakses oleh fungsi render pencarian
                    window.rawMutasiData = data.mutasi || [];

                    // Hitung Saldo Awal Awal
                    let saldoAwal = 0;
                    const totalDebitAwal = Number(data.saldo_awal?.total_debit || 0);
                    const totalKreditAwal = Number(data.saldo_awal?.total_kredit || 0);

                    if (jenisSaldoNormal.toLowerCase() === 'kredit') {
                        saldoAwal = totalKreditAwal - totalDebitAwal;
                    } else {
                        saldoAwal = totalDebitAwal - totalKreditAwal;
                    }
                    window.saldoAwalBukuBesar = saldoAwal;

                    // 2. DEFINISIKAN FUNGSI RENDER DENGAN FILTER FILTERING
                    window.renderTabelBukuBesar = function(keyword = '') {
                        const searchKeyword = keyword.toLowerCase().trim();
                        let runningSaldo = window.saldoAwalBukuBesar;

                        let html = `
                        <table class="table table-striped table-bordered small">
                            <thead>
                                <tr class="table-light text-center">
                                    <th>Tanggal</th>
                                    <th>No Bukti</th>
                                    <th>Cabang</th>
                                    <th>Nama Anggota</th>
                                    <th>Keterangan</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th style="width: 15%;">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>`;

                        // Baris Saldo Awal (Selalu Tampil)
                        html += `
                        <tr class="table-warning fw-bold">
                            <td colspan="5">SALDO AWAL MUTASI</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-end font-monospace">Rp ${window.saldoAwalBukuBesar.toLocaleString('id-ID')}</td>
                        </tr>`;

                        let adaDataCocok = false;

                        window.rawMutasiData.forEach(r => {
                            const debit = Number(r.jurnal_debit || 0);
                            const kredit = Number(r.jurnal_kredit || 0);

                            // Hitung running balance terlebih dahulu agar urutan matematis saldo berjalan tetap valid
                            if (jenisSaldoNormal.toLowerCase() === 'kredit') {
                                runningSaldo += (kredit - debit);
                            } else {
                                runningSaldo += (debit - kredit);
                            }

                            // Ambil string data dari response untuk dicocokkan
                            const noBukti = String(r.jurnal_no_bukti || '').toLowerCase();
                            const namaAnggota = String(r.nama_anggota || '').toLowerCase();
                            const cabangKode = String(r.jurnal_cabang || '').toLowerCase();
                            const cabangNama = String(r.kop_master_cabang_name || '').toLowerCase();

                            // COCOKKAN KATA KUNCI PENCARIAN
                            if (searchKeyword === '' ||
                                noBukti.includes(searchKeyword) ||
                                namaAnggota.includes(searchKeyword) ||
                                cabangKode.includes(searchKeyword) ||
                                cabangNama.includes(searchKeyword)) {

                                adaDataCocok = true;

                                const formatSaldo = runningSaldo < 0 ?
                                    `-Rp ${Math.abs(runningSaldo).toLocaleString('id-ID')}` :
                                    `Rp ${runningSaldo.toLocaleString('id-ID')}`;

                                const namaCabang = r.kop_master_cabang_name ? `[${r.jurnal_cabang}] ${r.kop_master_cabang_name}` : (r.jurnal_cabang || '-');
                                const namaAnggotaText = r.nama_anggota || '-';

                                html += `
                                <tr>
                                    <td class="text-center">${r.jurnal_tgl}</td>
                                    <td class="fw-semibold text-primary">${r.jurnal_no_bukti}</td>
                                    <td>${namaCabang}</td>
                                    <td>${namaAnggotaText}</td>
                                    <td>${r.jurnal_keterangan || '-'}</td>
                                    <td class="text-end text-success font-monospace">Rp ${debit.toLocaleString('id-ID')}</td>
                                    <td class="text-end text-danger font-monospace">Rp ${kredit.toLocaleString('id-ID')}</td>
                                    <td class="text-end fw-bold font-monospace ${runningSaldo < 0 ? 'text-danger' : 'text-dark'}">${formatSaldo}</td>
                                </tr>`;
                            }
                        });

                        if (!adaDataCocok && searchKeyword !== '') {
                            html += `<tr><td colspan="8" class="text-center text-muted fst-italic">Tidak ada data mutasi yang cocok dengan pencarian "${keyword}".</td></tr>`;
                        } else if (window.rawMutasiData.length === 0) {
                            html += `<tr><td colspan="8" class="text-center text-muted fst-italic">Tidak ada transaksi mutasi untuk COA ini.</td></tr>`;
                        }

                        html += '</tbody></table>';

                        // Masukkan tabel ke dalam wrapper khusus tabel
                        document.getElementById('bb-tabel-wrapper').innerHTML = html;
                    };

                    // 3. INJECT STRUKTUR LAYOUT & KOLOM PENCARIAN KE WADAH UTAMA
                    container.innerHTML = `
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-3">
                            <div>
                                <h4 class="fw-bold mb-0">Buku Besar Akun: ${coa}</h4>
                            </div>
                            <!-- Input Element Pencarian -->
                            <div style="width: 100%; max-width: 350px;">
                                <input type="text"
                                    id="search-buku-besar"
                                    class="form-control form-control-sm"
                                    placeholder="Cari No Bukti / Anggota / Cabang..."
                                    onkeyup="window.renderTabelBukuBesar(this.value)">
                            </div>
                        </div>
                        <!-- Tempat tabel akan diperbarui secara real-time -->
                        <div id="bb-tabel-wrapper"></div>
                    `;

                    // Panggil fungsi render pertama kali (tanpa filter/keyword kosong)
                    window.renderTabelBukuBesar('');
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = `<div class="alert alert-danger">Gagal memuat Buku Besar.</div>`;
                });
        } else if (laporanAktif === 'labarugi') {
            fetch(`{{ route('akutansi_koperasi_report_rugi_laba_cabang') }}${params}`)
                .then(res => res.json())
                .then(data => {
                    // 1. Simpan data response backend ke objek window agar aman diakses fungsi filtering
                    window.rawLabaRugiData = {
                        pendapatan: data.pendapatan || [],
                        beban: data.beban || [],
                        total_pendapatan: Number(data.total_pendapatan || 0),
                        total_beban: Number(data.total_beban || 0),
                        laba_bersih: Number(data.laba_bersih || 0)
                    };

                    // 2. DEFINISIKAN FUNGSI RENDER DENGAN FILTER FILTERING
                    window.renderLabaRugi = function(keyword = '') {
                        const searchKeyword = keyword.toLowerCase().trim();

                        let html = `
            <div class="table-responsive">
                <table class="table table-hover align-middle small">
                    <tbody>
                        <!-- ================= PENDAPATAN ================= -->
                        <tr class="table-light fw-bold">
                            <td colspan="2" class="text-primary text-uppercase"><i class="bi bi-graph-up-arrow me-2"></i> 1. PENDAPATAN OPERASIONAL</td>
                            <td></td>
                        </tr>`;

                        // Filter data pendapatan
                        const filteredPendapatan = window.rawLabaRugiData.pendapatan.filter(p => {
                            return searchKeyword === '' ||
                                String(p.coa_code).toLowerCase().includes(searchKeyword) ||
                                String(p.coa_name).toLowerCase().includes(searchKeyword);
                        });

                        if (filteredPendapatan.length === 0) {
                            html += `<tr><td class="text-muted ps-4 fst-italic" colspan="3">Tidak ada aktivitas pendapatan yang cocok</td></tr>`;
                        } else {
                            filteredPendapatan.forEach(p => {
                                html += `
                    <tr>
                        <td class="ps-4" style="width: 20%;">${p.coa_code}</td>
                        <td style="width: 50%;">${p.coa_name}</td>
                        <td class="text-end font-monospace" style="width: 30%;">Rp ${Number(p.total).toLocaleString('id-ID')}</td>
                    </tr>`;
                            });
                        }

                        // Total Pendapatan (Nilai total asli A tetap dikunci agar akuntansi konsisten)
                        html += `
                        <tr class="fw-bold bg-success-subtle text-success">
                            <td colspan="2" class="ps-3 text-uppercase">TOTAL PENDAPATAN (A)</td>
                            <td class="text-end font-monospace">Rp ${window.rawLabaRugiData.total_pendapatan.toLocaleString('id-ID')}</td>
                        </tr>
                        <tr><td colspan="3" style="height: 20px; border: none;"></td></tr>

                        <!-- ================= BEBAN ================= -->
                        <tr class="table-light fw-bold">
                            <td colspan="2" class="text-danger text-uppercase"><i class="bi bi-graph-down-arrow me-2"></i> 2. BEBAN OPERASIONAL</td>
                            <td></td>
                        </tr>`;

                        // Filter data beban
                        const filteredBeban = window.rawLabaRugiData.beban.filter(b => {
                            return searchKeyword === '' ||
                                String(b.coa_code).toLowerCase().includes(searchKeyword) ||
                                String(b.coa_name).toLowerCase().includes(searchKeyword);
                        });

                        if (filteredBeban.length === 0) {
                            html += `<tr><td class="text-muted ps-4 fst-italic" colspan="3">Tidak ada aktivitas beban operasional yang cocok</td></tr>`;
                        } else {
                            filteredBeban.forEach(b => {
                                html += `
                    <tr>
                        <td class="ps-4">${b.coa_code}</td>
                        <td>${b.coa_name}</td>
                        <td class="text-end font-monospace text-danger">Rp ${Number(b.total).toLocaleString('id-ID')}</td>
                    </tr>`;
                            });
                        }

                        // Total Beban & Kalkulasi Alert Box
                        const isUntung = window.rawLabaRugiData.laba_bersih >= 0;
                        const badgeSHUColor = isUntung ? 'alert-success border-success text-success' : 'alert-danger border-danger text-danger';
                        const statusTeks = isUntung ? 'SISA HASIL USAHA (LABA BERSIH)' : 'KERUGIAN OPERASIONAL (RUGI BERSIH)';

                        html += `
                        <tr class="fw-bold bg-danger-subtle text-danger">
                            <td colspan="2" class="ps-3 text-uppercase">TOTAL BEBAN OPERASIONAL (B)</td>
                            <td class="text-end font-monospace">Rp ${window.rawLabaRugiData.total_beban.toLocaleString('id-ID')}</td>
                        </tr>
                        <tr><td colspan="3" style="height: 30px; border: none;"></td></tr>
                    </tbody>
                </table>
            </div>

            <div class="alert ${badgeSHUColor} d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border">
                <span class="fw-bold fs-5 text-uppercase"><i class="bi bi-calculator me-2"></i> ${statusTeks} (A - B)</span>
                <span class="fw-bold fs-4 font-monospace">Rp ${window.rawLabaRugiData.laba_bersih.toLocaleString('id-ID')}</span>
            </div>`;

                        // Masukkan komponen ke wrapper penampung tabel
                        document.getElementById('lr-tabel-wrapper').innerHTML = html;
                    };

                    // 3. INJECT STRUKTUR UTAMA KEPALA LAPORAN & KOTAK INPUT SEARCH
                    container.innerHTML = `
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
                <div class="text-center text-sm-start">
                    <h4 class="fw-bold m-0 text-dark">LAPORAN LABA RUGI OPERASIONAL</h4>
                    <p class="text-muted small mb-0">Periode: ${tglMulai} s/d ${tglSelesai}</p>
                </div>
                <!-- Kolom Pencarian Akun -->
                <div style="width: 100%; max-width: 320px;">
                    <input type="text"
                           id="search-laba-rugi"
                           class="form-control form-control-sm"
                           placeholder="Cari Kode COA / Nama Akun..."
                           onkeyup="window.renderLabaRugi(this.value)">
                </div>
            </div>
            <!-- Tempat Laporan Laba Rugi akan di-update -->
            <div id="lr-tabel-wrapper"></div>
        `;

                    // Panggil render data pertama kali tanpa keyword
                    window.renderLabaRugi('');
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
                    <div class="text-center mb-4 border-bottom pb-3">
                        <h4 class="fw-bold m-0 text-dark">LAPORAN PERUBAHAN MODAL / EKUITAS</h4>
                        <p class="text-muted small m-0">Periode: ${tglMulai} s/d ${tglSelesai}</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle small">
                            <thead>
                                <tr class="table-dark text-uppercase">
                                    <th style="width: 20%;">Kode Akun</th>
                                    <th style="width: 50%;">Komponen Ekuitas Koperasi</th>
                                    <th style="width: 30%;" class="text-end">Saldo Sebelum SHU</th>
                                </tr>
                            </thead>
                            <tbody>`;

                    if (!data.detail_modal || data.detail_modal.length === 0) {
                        html += `<tr><td colspan="3" class="text-muted text-center fst-italic py-3">Tidak ditemukan data akun ekuitas</td></tr>`;
                    } else {
                        data.detail_modal.forEach(m => {
                            html += `
                            <tr>
                                <td class="font-monospace fw-bold">${m.coa_code}</td>
                                <td>${m.coa_name}</td>
                                <td class="text-end font-monospace">Rp ${Number(m.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `
                                <tr class="fw-bold table-light border-top-2">
                                    <td colspan="2" class="text-uppercase">Sub-Total Modal Ekuitas (A)</td>
                                    <td class="text-end font-monospace border-double">Rp ${Number(data.total_modal_awal || 0).toLocaleString('id-ID')}</td>
                                </tr>
                                <tr class="text-success bg-success-subtle fw-bold">
                                    <td><i class="bi bi-plus-circle-fill me-1"></i> SHU</td>
                                    <td>Sisa Hasil Usaha (Laba Bersih) Periode Berjalan (B)</td>
                                    <td class="text-end font-monospace">+ Rp ${Number(data.laba_bersih_shu || 0).toLocaleString('id-ID')}</td>
                                </tr>
                                <tr><td colspan="3" style="height: 15px; border: none;"></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-primary d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border border-primary m-0">
                        <span class="fw-bold text-uppercase"><i class="bi bi-bank me-2"></i> TOTAL MODAL AKHIR KOPERASI (A + B)</span>
                        <span class="fw-bold fs-4 font-monospace">Rp ${Number(data.total_modal_akhir || 0).toLocaleString('id-ID')}</span>
                    </div>`;

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
                    <div class="text-center mb-4 border-bottom pb-3">
                        <h4 class="fw-bold m-0 text-dark">LAPORAN POSISI KEUANGAN (NERACA)</h4>
                        <p class="text-muted small m-0">Kondisi Kumulatif Finansial Koperasi per Tanggal: ${tglSelesai}</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="table-responsive border rounded shadow-sm bg-white">
                                <table class="table table-hover align-middle mb-0 small">
                                    <thead class="table-dark text-uppercase">
                                        <tr>
                                            <th style="width: 25%;">Kode</th>
                                            <th style="width: 45%;">AKTIVA (ASET / KEKAYAAN)</th>
                                            <th style="width: 30%;" class="text-end">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                    if (!data.aset || data.aset.length === 0) {
                        html += `<tr><td colspan="3" class="text-muted text-center fst-italic">Tidak ada saldo aset lancar/tetap</td></tr>`;
                    } else {
                        data.aset.forEach(a => {
                            html += `
                            <tr>
                                <td class="font-monospace text-secondary">${a.coa_code}</td>
                                <td class="fw-semibold text-dark">${a.coa_name}</td>
                                <td class="text-end font-monospace text-success">Rp ${Number(a.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    let totalKewajibanModalLen = (data.kewajiban?.length || 0) + (data.modal?.length || 0) + 2;
                    let asetLen = data.aset?.length || 0;
                    let selisihBaris = Math.max(0, totalKewajibanModalLen - asetLen);
                    for (let i = 0; i < selisihBaris; i++) {
                        html += `<tr class="border-0" style="visibility:hidden;"><td colspan="3">&nbsp;</td></tr>`;
                    }

                    html += `
                                    </tbody>
                                    <tfoot class="table-primary fw-bold fs--2">
                                        <tr>
                                            <td colspan="2" class="text-uppercase"><i class="bi bi-box-seam me-2"></i> TOTAL AKTIVA (A)</td>
                                            <td class="text-end font-monospace">Rp ${Number(data.total_aset || 0).toLocaleString('id-ID')}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="table-responsive border rounded shadow-sm bg-white">
                                <table class="table table-hover align-middle mb-0 small">
                                    <thead class="table-success text-uppercase text-white">
                                        <tr>
                                            <th style="width: 25%;" class="bg-success text-white">Kode</th>
                                            <th style="width: 45%;" class="bg-success text-white">PASIVA (KEWAJIBAN & EKUITAS)</th>
                                            <th style="width: 30%;" class="text-end bg-success text-white">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-light fw-bold text-muted small"><td colspan="3">1. LIABILITAS / KEWAJIBAN HUTANG</td></tr>`;

                    if (!data.kewajiban || data.kewajiban.length === 0) {
                        html += `<tr><td colspan="3" class="text-muted text-center fst-italic">Tidak ada liabilitas/titipan</td></tr>`;
                    } else {
                        data.kewajiban.forEach(k => {
                            html += `
                            <tr>
                                <td class="font-monospace text-secondary">${k.coa_code}</td>
                                <td>${k.coa_name}</td>
                                <td class="text-end font-monospace">Rp ${Number(k.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `<tr class="table-light fw-bold text-muted small"><td colspan="3">2. EKUITAS / MODAL BERJALAN</td></tr>`;

                    if (data.modal) {
                        data.modal.forEach(m => {
                            html += `
                            <tr>
                                <td class="font-monospace text-secondary">${m.coa_code}</td>
                                <td>${m.coa_name}</td>
                                <td class="text-end font-monospace">Rp ${Number(m.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `
                                        <tr class="table-warning-subtle text-dark border-top fw-bold">
                                            <td class="font-monospace text-secondary">-</td>
                                            <td class="fst-italic text-primary"><i class="bi bi-arrow-right-short"></i> SHU Tahun Berjalan (Laba Bersih)</td>
                                            <td class="text-end font-monospace text-primary">+ Rp ${Number(data.laba_bersih_berjalan || 0).toLocaleString('id-ID')}</td>
                                        </tr>`;

                    let selisihBarisPasiva = Math.max(0, asetLen - totalKewajibanModalLen);
                    for (let i = 0; i < selisihBarisPasiva; i++) {
                        html += `<tr class="border-0" style="visibility:hidden;"><td colspan="3">&nbsp;</td></tr>`;
                    }

                    const isBalance = Math.abs((data.total_aset || 0) - (data.total_pasiva || 0)) < 0.01;
                    const statusAlertClass = isBalance ? 'alert-success border-success text-success' : 'alert-danger border-danger text-danger';
                    const statusText = isBalance ? 'DEBIT & KREDIT SEIMBANG (BALANCE)' : '⚠️ NERACA TIDAK SEIMBANG (UNBALANCED)';

                    html += `
                                    </tbody>
                                    <tfoot class="table-success fw-bold fs--2">
                                        <tr>
                                            <td colspan="2" class="text-uppercase"><i class="bi bi-wallet2 me-2"></i> TOTAL PASIVA (B)</td>
                                            <td class="text-end font-monospace">Rp ${Number(data.total_pasiva || 0).toLocaleString('id-ID')}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="alert ${statusAlertClass} text-center fw-bold mt-4 shadow-sm mb-0 py-2 small">
                        <i class="bi bi-check-circle-fill me-1"></i> STATUS VALIDASI DATA : ${statusText}
                    </div>`;

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
                    <div class="text-center mb-4 border-bottom pb-3">
                        <h4 class="fw-bold m-0 text-dark">LAPORAN ARUS KAS (DIRECT METHOD)</h4>
                        <p class="text-muted small m-0">Rincian Aliran Masuk & Keluar Kas / Bank Koperasi</p>
                    </div>
                    <p class="text-center text-muted small">Data arus kas berhasil dimuat.</p>`;
                    container.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = `<div class="alert alert-danger">Gagal memuat Laporan Arus Kas.</div>`;
                });
        }
    }
</script>
<script>
    // Variabel global untuk menyimpan daftar master COA dari koperasi
    window.masterCoaList = [];


    function loadMasterCoaOptions() {
        // Sesuaikan url route ini dengan route master COA yang ada di aplikasi Anda
        fetch(`{{ route('laporan_koperasi_jurnal_umum_get_coa') }}`)
            .then(res => res.json())
            .then(data => {
                window.masterCoaList = data; // Ekspektasi return data: [{ id: 1, coa_code: '1101', coa_name: 'Kas Utama' }, ...]
            })
            .catch(err => console.error('Gagal memuat master akun COA:', err));
    }

    // Jalankan penarikan data COA sesaat setelah halaman siap
    loadMasterCoaOptions();
    // Variabel Memori Utama (Pastikan di-load saat halaman pertama kali dibuka)
    window.rawJurnalData = window.rawJurnalData || []; // Data baris laporan awal dari server
    window.masterCoaList = window.masterCoaList || []; // Data pilihan master perkiraan COA

    /**
     * Membuka Modal & Memetakan Data Detail Berdasarkan Nomor Bukti
     * @param {string} noBukti
     */
    function bukaModalEditJurnal(noBukti) {
        // 1. Ambil semua baris mentah yang memiliki nomor bukti ini
        const barisMentah = window.rawJurnalData.filter(item => item.jurnal_no_bukti === noBukti);
        if (barisMentah.length === 0) {
            Swal.fire('Kesalahan', 'Data rincian jurnal gagal dibaca.', 'warning');
            return;
        }

        // 2. Set Data Utama Induk Jurnal di Modal
        document.getElementById('edit-jurnal-no-bukti').value = noBukti;
        document.getElementById('edit-jurnal-tgl').value = barisMentah[0].jurnal_tgl;
        document.getElementById('edit-jurnal-keterangan').value = barisMentah[0].jurnal_keterangan || '';

        let formRowsHtml = '';

        // 3. Loop baris data untuk dirender ke dalam tabel modal
        barisMentah.forEach((item, index) => {
            let coaOptionsHtml = '<option value="">-- Pilih Kode COA --</option>';
            window.masterCoaList.forEach(coa => {
                const isSelected = coa.coa_code === item.coa_code ? 'selected' : '';
                coaOptionsHtml += `<option value="${coa.coa_code}" ${isSelected}>[${coa.coa_code}] - ${coa.coa_name}</option>`;
            });

            // TUGAS UTAMA: Jika backend Anda menggunakan nama primary key lain pada join query,
            // periksa F12 Console Network Anda. Di bawah ini adalah fallback mendeteksi nama primary key yang umum.
            const idDetailJurnal = item.id_jurnal_detail || item.id_detail || item.id || "";

            formRowsHtml += `
            <tr>
                <td>
                    <!-- Input hidden ID detail -->
                    <input type="hidden" name="jurnal[${index}][id_jurnal_detail]" class="id-jurnal-detail" value="${idDetailJurnal}">

                    <select name="jurnal[${index}][coa_code]" class="form-select form-select-sm select-coa-jurnal fw-semibold coa-code" required style="font-size: 13px;">
                        ${coaOptionsHtml}
                    </select>
                </td>
                <td>
                    <input type="number" step="1" min="0" name="jurnal[${index}][jurnal_debit]"
                        class="form-control form-control-sm text-end font-monospace input-hitung-debit text-success fw-bold jurnal-debit"
                        value="${Math.round(Number(item.jurnal_debit || 0))}" oninput="hitungKeseimbanganEdit()">
                </td>
                <td>
                    <input type="number" step="1" min="0" name="jurnal[${index}][jurnal_kredit]"
                        class="form-control form-control-sm text-end font-monospace input-hitung-kredit text-danger fw-bold jurnal-kredit"
                        value="${Math.round(Number(item.jurnal_kredit || 0))}" oninput="hitungKeseimbanganEdit()">
                </td>
            </tr>`;
        });

        document.getElementById('container-form-detail-jurnal').innerHTML = formRowsHtml;

        // Jalankan kalkulator penyeimbang kas di modal
        if (typeof hitungKeseimbanganEdit === "function") {
            hitungKeseimbanganEdit();
        }

        const modalElement = document.getElementById('modal-edit-jurnal');
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    }

    /**
     * Menghitung Secara Real-time Keseimbangan Neraca Debit dan Kredit
     */
    function hitungKeseimbanganEdit() {
        let totalDebit = 0;
        let totalKredit = 0;

        document.querySelectorAll('.input-hitung-debit').forEach(input => {
            totalDebit += Math.round(Number(input.value || 0));
        });

        document.querySelectorAll('.input-hitung-kredit').forEach(input => {
            totalKredit += Math.round(Number(input.value || 0));
        });

        document.getElementById('total-edit-debit-display').value = totalDebit.toLocaleString('id-ID');
        document.getElementById('total-edit-kredit-display').value = totalKredit.toLocaleString('id-ID');

        const warningBox = document.getElementById('baris-peringatan-balancing');
        const selisihBox = document.getElementById('nilai-selisih-balancing');
        const btnSimpan = document.getElementById('btn-simpan-jurnal');

        if (totalDebit !== totalKredit) {
            const selisih = Math.abs(totalDebit - totalKredit);
            selisihBox.innerText = 'Rp ' + selisih.toLocaleString('id-ID');
            warningBox.classList.remove('d-none');
            btnSimpan.disabled = true;
            btnSimpan.classList.replace('btn-success', 'btn-secondary');
        } else {
            warningBox.classList.add('d-none');
            btnSimpan.disabled = false;
            btnSimpan.classList.replace('btn-secondary', 'btn-success');
        }
    }

    /**
     * Mengirimkan data pembukuan yang valid ke Server lewat Fetch API
     */
    function submitUpdateJurnal(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Penyimpanan',
            text: "Anda akan mengubah pencatatan keuangan jurnal ini. Lanjutkan?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan Perubahan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const formElement = document.getElementById('form-update-jurnal');
                const formData = new FormData(formElement);

                const payload = {
                    no_bukti: formData.get('no_bukti'),
                    jurnal_tgl: formData.get('jurnal_tgl'),
                    keterangan: formData.get('keterangan'),
                    jurnal: []
                };

                // SELEKSI BERBASIS CLASS (Jauh lebih aman dan responsif)
                // SELEKSI BERBASIS CLASS (Anti-NaN untuk format Rupiah/Titik)
                const rows = document.querySelectorAll('#container-form-detail-jurnal tr');
                rows.forEach((row, i) => {
                    const idJurnalDetail = row.querySelector('.id-jurnal-detail')?.value;
                    const coaCode = row.querySelector('.coa-code')?.value;
                    const debitRaw = row.querySelector('.jurnal-debit')?.value || "0";
                    const kreditRaw = row.querySelector('.jurnal-kredit')?.value || "0";

                    if (coaCode && coaCode.trim() !== "") {

                        // JIKA idJurnalDetail ADALAH undefined ATAU "NaN", UBAH MENJADI null
                        let idDetailCleaned = null;
                        if (idJurnalDetail !== undefined && idJurnalDetail !== "undefined" && idJurnalDetail !== "NaN" && idJurnalDetail.toString().trim() !== "") {
                            idDetailCleaned = parseInt(idJurnalDetail);
                        }

                        const debitCleaned = debitRaw.toString().replace(/\./g, '').replace(/,/g, '');
                        const kreditCleaned = kreditRaw.toString().replace(/\./g, '').replace(/,/g, '');

                        payload.jurnal.push({
                            id_jurnal_detail: idDetailCleaned, // Mengirim angka atau null (Bukan NaN / undefined)
                            coa_code: coaCode,
                            jurnal_debit: Math.round(Number(debitCleaned)) || 0,
                            jurnal_kredit: Math.round(Number(kreditCleaned)) || 0
                        });
                    }
                });

                console.log("Payload yang terkumpul (Sudah dibersihkan):", payload);

                if (payload.jurnal.length === 0) {
                    Swal.fire('Gagal', 'Sistem gagal membaca rincian baris akun. Mohon pilih minimal satu COA.', 'error');
                    return;
                }

                Swal.showLoading();

                fetch(`{{ route('laporan_koperasi_jurnal_umum_save_data') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(async res => {
                        const responseData = await res.json();
                        if (!res.ok) throw new Error(responseData.message || `Error status ${res.status}`);
                        return responseData;
                    })
                    .then(response => {
                        if (response.success) {
                            Swal.fire({
                                title: 'Sukses Terupdate!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            const modalElement = document.getElementById('modal-edit-jurnal');
                            const modalInstance = bootstrap.Modal.getInstance(modalElement);
                            if (modalInstance) modalInstance.hide();

                            setTimeout(() => {
                                if (typeof loadLaporanAktif === "function") {
                                    loadLaporanAktif();
                                } else {
                                    location.reload();
                                }
                            }, 500);
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            title: 'Gagal Mengubah Data!',
                            text: err.message,
                            icon: 'error'
                        });
                    });
            }
        });
    }
</script>
@endsection
