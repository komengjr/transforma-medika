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
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                class="text-success fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Akutansi <span class="text-success fw-medium">Jurnal Otomatis</span>
                    </h4>
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
    <div class="row g-3 align-items-center">
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
    <li class="nav-item"><button class="nav-link active fw-bold text-uppercase" onclick="switchLaporan('jurnal')">1. Jurnal Umum</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('bukubesar')">2. Buku Besar</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('labarugi')">3. Laba Rugi</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('modal')">4. Perubahan Modal</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('neraca')">5. Neraca</button></li>
    <li class="nav-item"><button class="nav-link fw-bold text-uppercase" onclick="switchLaporan('aruskas')">6. Arus Kas</button></li>
</ul>

<div class="card mb-3 border-0 shadow-sm p-4 bg-white rounded-3" id="area-print-laporan">
    <div id="konten-laporan-dinamis">
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

    function switchLaporan(tipe) {
        laporanAktif = tipe;

        // Tampilkan dropdown pilih COA hanya jika menu Buku Besar aktif
        document.getElementById('wrapper-select-coa').style.display = (tipe === 'bukubesar') ? 'block' : 'none';

        // Ubah status aktif tombol tab
        document.querySelectorAll('#laporanTab .nav-link').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');

        loadLaporanAktif();
    }

    function loadLaporanAktif() {
        const tglMulai = document.getElementById('global-tgl-mulai').value;
        const tglSelesai = document.getElementById('global-tgl-selesai').value;
        const container = document.getElementById('konten-laporan-dinamis');

        const params = `?tgl_mulai=${tglMulai}&tgl_selesai=${tglSelesai}`;

        if (laporanAktif === 'jurnal') {
            fetch(`{{ route('akutansi_koperasi_report_jurnal_cabang') }}${params}`)
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
                            coa_code: item.coa_code,
                            coa_name: item.coa_name,
                            debit: Number(item.jurnal_debit),
                            kredit: Number(item.jurnal_kredit)
                        });
                    });

                    // 2. Susun HTML Tabel dengan Grouping per No Bukti
                    let html = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold m-0 text-dark">Jurnal Umum Koperasi</h4>
                        <span class="badge bg-primary rounded-pill px-3 py-2">Metode Double-Entry</span>
                    </div>
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

                    // 3. Looping kelompok jurnal
                    Object.keys(groupedJurnal).forEach(noBukti => {
                        const jurnal = groupedJurnal[noBukti];

                        // Baris Header untuk nomor bukti, tanggal, dan keterangan utama
                        html += `
                        <tr class="table-light fw-bold border-bottom-0">
                            <td><i class="bi bi-calendar3 me-1"></i> ${jurnal.tanggal}</td>
                            <td colspan="4" class="text-primary text-uppercase">
                                <span class="text-dark small fw-normal">No. Bukti:</span> ${noBukti}
                            </td>
                        </tr>
                    `;

                        // Looping detail akun di dalam nomor bukti tersebut
                        jurnal.details.forEach((detail, index) => {
                            // Aturan visual akuntansi: Akun kredit agak menjorok ke kanan
                            const indentStyle = detail.kredit > 0 ? 'ps-4 text-secondary fst-italic' : 'fw-semibold text-dark';
                            const displayDebit = detail.debit > 0 ? `Rp ${detail.debit.toLocaleString('id-ID')}` : '-';
                            const displayKredit = detail.kredit > 0 ? `Rp ${detail.kredit.toLocaleString('id-ID')}` : '-';

                            // Tampilkan keterangan pelengkap hanya di baris terakhir detail akun agar rapi
                            const isLastRow = index === jurnal.details.length - 1;
                            const keteranganTambahan = isLastRow ? `<div class="text-muted text-capitalize mt-1 font-monospace" style="font-size: 11px;">* Keterangan: ${jurnal.keterangan}</div>` : '';

                            html += `
                            <tr class="border-top-0">
                                <td class="text-center text-muted small"></td>
                                <td class="${indentStyle}">
                                    ${detail.coa_name}
                                    ${keteranganTambahan}
                                </td>
                                <td class="text-center text-secondary">${detail.coa_code}</td>
                                <td class="text-end text-success font-monospace">${displayDebit}</td>
                                <td class="text-end text-danger font-monospace">${displayKredit}</td>
                            </tr>
                        `;
                        });

                        // Pembatas antar nomor bukti berupa baris kosong tipis pembantu estetika
                        html += `<tr class="table-white"><td colspan="5" style="padding: 4px; background-color: #fcfcfc;"></td></tr>`;
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
                    let html = `<h4 class="fw-bold mb-3">Buku Besar Akun: ${coa}</h4><table class="table table-striped table-bordered small"><thead><tr class="table-light"><th>Tanggal</th><th>No Bukti</th><th>Keterangan</th><th>Debit</th><th>Kredit</th></tr></thead><tbody>`;
                    let saldoAwal = (data.saldo_awal.total_debit || 0) - (data.saldo_awal.total_kredit || 0);
                    html += `<tr class="table-warning fw-bold"><td colspan="3">SALDO AWAL MUTASI</td><td colspan="2" class="text-end">Rp ${Number(saldoAwal).toLocaleString('id-ID')}</td></tr>`;
                    data.mutasi.forEach(r => {
                        html += `<tr><td>${r.jurnal_tgl}</td><td>${r.jurnal_no_bukti}</td><td>${r.jurnal_keterangan}</td><td class="text-end">Rp ${Number(r.jurnal_debit).toLocaleString('id-ID')}</td><td class="text-end">Rp ${Number(r.jurnal_kredit).toLocaleString('id-ID')}</td></tr>`;
                    });
                    html += '</tbody></table>';
                    container.innerHTML = html;
                });
        } else if (laporanAktif === 'labarugi') {
            fetch(`{{ route('akutansi_koperasi_report_rugi_laba') }}${params}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                    <div class="text-center mb-4">
                        <h4 class="fw-bold m-0 text-dark">LAPORAN LABA RUGI OPERASIONAL</h4>
                        <p class="text-muted small">Periode: ${document.getElementById('global-tgl-mulai').value} s/d ${document.getElementById('global-tgl-selesai').value}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle small">
                            <tbody>
                                <tr class="table-light fw-bold">
                                    <td colspan="2" class="text-primary text-uppercase"><i class="bi bi-graph-up-arrow me-2"></i> 1. PENDAPATAN OPERASIONAL</td>
                                    <td></td>
                                </tr>`;

                    if (data.pendapatan.length === 0) {
                        html += `<tr><td class="text-muted ps-4 fst-italic">Tidak ada aktivitas pendapatan pada periode ini</td><td></td><td></td></tr>`;
                    } else {
                        data.pendapatan.forEach(p => {
                            html += `
                            <tr>
                                <td class="ps-4" style="width: 20%;">${p.coa_code}</td>
                                <td style="width: 50%;">${p.coa_name}</td>
                                <td class="text-end font-monospace" style="width: 30%;">Rp ${Number(p.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `
                                <tr class="fw-bold bg-success-subtle text-success">
                                    <td colspan="2" class="ps-3 text-uppercase">TOTAL PENDAPATAN (A)</td>
                                    <td class="text-end font-monospace">Rp ${Number(data.total_pendapatan).toLocaleString('id-ID')}</td>
                                </tr>

                                <tr><td colspan="3" style="height: 20px; border: none;"></td></tr>

                                <tr class="table-light fw-bold">
                                    <td colspan="2" class="text-danger text-uppercase"><i class="bi bi-graph-down-arrow me-2"></i> 2. BEBAN OPERASIONAL</td>
                                    <td></td>
                                </tr>`;

                    if (data.beban.length === 0) {
                        html += `<tr><td class="text-muted ps-4 fst-italic">Tidak ada aktivitas beban operasional pada periode ini</td><td></td><td></td></tr>`;
                    } else {
                        data.beban.forEach(b => {
                            html += `
                            <tr>
                                <td class="ps-4">${b.coa_code}</td>
                                <td>${b.coa_name}</td>
                                <td class="text-end font-monospace text-danger">Rp ${Number(b.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    // Tentukan warna badge SHU (Hijau jika Untung/Laba, Merah jika Rugi)
                    const isUntung = data.laba_bersih >= 0;
                    const badgeSHUColor = isUntung ? 'alert-success border-success text-success' : 'alert-danger border-danger text-danger';
                    const statusTeks = isUntung ? 'SISA HASIL USAHA (LABA BERSIH)' : 'KERUGIAN OPERASIONAL (RUGI BERSIH)';

                    html += `
                                <tr class="fw-bold bg-danger-subtle text-danger">
                                    <td colspan="2" class="ps-3 text-uppercase">TOTAL BEBAN OPERASIONAL (B)</td>
                                    <td class="text-end font-monospace">Rp ${Number(data.total_beban).toLocaleString('id-ID')}</td>
                                </tr>

                                <tr><td colspan="3" style="height: 30px; border: none;"></td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert ${badgeSHUColor} d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border">
                        <span class="fw-bold fs-2 text-uppercase"><i class="bi bi-calculator me-2"></i> ${statusTeks} (A - B)</span>
                        <span class="fw-bold fs-2 font-monospace">Rp ${Number(data.laba_bersih).toLocaleString('id-ID')}</span>
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
                    <div class="text-center mb-4 border-bottom pb-3">
                        <h4 class="fw-bold m-0 text-dark">LAPORAN PERUBAHAN MODAL / EKUITAS</h4>
                        <p class="text-muted small m-0">Periode: ${document.getElementById('global-tgl-mulai').value} s/d ${document.getElementById('global-tgl-selesai').value}</p>
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

                    // 1. Looping Detail Akun Modal (Simpanan Pokok, Wajib, Cadangan, dll)
                    if (data.detail_modal.length === 0) {
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
                                <td class="text-end font-monospace border-double">Rp ${Number(data.total_modal_awal).toLocaleString('id-ID')}</td>
                            </tr>

                            <tr class="text-success bg-success-subtle fw-bold">
                                <td><i class="bi bi-plus-circle-fill me-1"></i> SHU</td>
                                <td>Sisa Hasil Usaha (Laba Bersih) Periode Berjalan (B)</td>
                                <td class="text-end font-monospace">+ Rp ${Number(data.laba_bersih_shu).toLocaleString('id-ID')}</td>
                            </tr>

                            <tr><td colspan="3" style="height: 15px; border: none;"></td></tr>
                        </tbody>
                    </table>
                    </div>

                    <div class="alert alert-primary d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border border-primary m-0">
                        <span class="fw-bold text-uppercase">
                            <i class="bi bi-bank me-2"></i> TOTAL MODAL AKHIR KOPERASI (A + B)
                        </span>
                        <span class="fw-bold fs-4 font-monospace">
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
                    // Render Struktur Tabel Dua Sisi (Aktiva vs Pasiva)
                    let html = `
                    <div class="text-center mb-4 border-bottom pb-3">
                        <h4 class="fw-bold m-0 text-dark">LAPORAN POSISI KEUANGAN (NERACA)</h4>
                        <p class="text-muted small m-0">Kondisi Kumulatif Finansial Koperasi per Tanggal: ${document.getElementById('global-tgl-selesai').value}</p>
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

                    if (data.aset.length === 0) {
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

                    // Baris Kosong Penyelaras Tinggi Kolom agar Seimbang Secara Estetika
                    let selisihBaris = Math.max(0, (data.kewajiban.length + data.modal.length + 2) - data.aset.length);
                    for (let i = 0; i < selisihBaris; i++) {
                        html += `<tr class="border-0" style="visibility:hidden;"><td colspan="3">&nbsp;</td></tr>`;
                    }

                    html += `
                                    </tbody>
                                    <tfoot class="table-primary fw-bold fs--2">
                                        <tr>
                                            <td colspan="2" class="text-uppercase"><i class="bi bi-box-seam me-2"></i> TOTAL AKTIVA (A)</td>
                                            <td class="text-end font-monospace">Rp ${data.total_aset.toLocaleString('id-ID')}</td>
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

                    if (data.kewajiban.length === 0) {
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

                    html += `
                                        <tr class="table-light fw-bold text-muted small"><td colspan="3">2. EKUITAS / MODAL BERJALAN</td></tr>`;

                    data.modal.forEach(m => {
                        html += `
                        <tr>
                            <td class="font-monospace text-secondary">${m.coa_code}</td>
                            <td>${m.coa_name}</td>
                            <td class="text-end font-monospace">Rp ${Number(m.total).toLocaleString('id-ID')}</td>
                        </tr>`;
                    });

                    // Suntikan SHU Berjalan dari Laba Rugi sebagai Penyeimbang Sisi Pasiva
                    html += `
                            <tr class="table-warning-subtle text-dark border-top fw-bold">
                                <td class="font-monospace text-secondary">-</td>
                                <td class="fst-italic text-primary"><i class="bi bi-arrow-right-short"></i> SHU Tahun Berjalan (Laba Bersih)</td>
                                <td class="text-end font-monospace text-primary">+ Rp ${data.laba_bersih_berjalan.toLocaleString('id-ID')}</td>
                            </tr>`;

                    // Penyelaras Tinggi Kolom Sisi Pasiva
                    let selisihBarisPasiva = Math.max(0, data.aset.length - (data.kewajiban.length + data.modal.length + 2));
                    for (let i = 0; i < selisihBarisPasiva; i++) {
                        html += `<tr class="border-0" style="visibility:hidden;"><td colspan="3">&nbsp;</td></tr>`;
                    }

                    // Cek Keseimbangan (Balance Check)
                    const isBalance = Math.abs(data.total_aset - data.total_pasiva) < 0.01;
                    const statusAlertClass = isBalance ? 'alert-success border-success text-success' : 'alert-danger border-danger text-danger';
                    const statusText = isBalance ? 'DEBIT & KREDIT SEIMBANG (BALANCE)' : '⚠️ NERACA TIDAK SEIMBANG (UNBALANCED)';

                    html += `
                                    </tbody>
                                    <tfoot class="table-success fw-bold fs--2">
                                        <tr>
                                            <td colspan="2" class="text-uppercase"><i class="bi bi-wallet2 me-2"></i> TOTAL PASIVA (B)</td>
                                            <td class="text-end font-monospace">Rp ${data.total_pasiva.toLocaleString('id-ID')}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="alert ${statusAlertClass} text-center fw-bold mt-4 shadow-sm mb-0 py-2 small">
                        <i class="bi bi-check-circle-fill me-1"></i> STATUS VALIDASI DATA : ${statusText}
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
                    <div class="text-center mb-4 border-bottom pb-3">
                        <h4 class="fw-bold m-0 text-dark">LAPORAN ARUS KAS (DIRECT METHOD)</h4>
                        <p class="text-muted small m-0">Rincian Aliran Masuk & Keluar Kas / Bank Koperasi</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle small mb-0">
                            <tbody>
                                <tr class="table-light fw-bold">
                                    <td colspan="2" class="text-success text-uppercase"><i class="bi bi-box-arrow-in-down-right me-2"></i> 1. ARUS KAS DARI AKTIVITAS OPERASIONAL (MASUK)</td>
                                    <td></td>
                                </tr>`;

                    if (data.arus_masuk_detail.length === 0) {
                        html += `<tr><td colspan="3" class="text-muted ps-4 fst-italic">Tidak ada aliran kas masuk</td></tr>`;
                    } else {
                        data.arus_masuk_detail.forEach(m => {
                            html += `
                            <tr>
                                <td class="ps-4 text-secondary" style="width: 20%;">${m.coa_code}</td>
                                <td style="width: 50%;">Penerimaan dari ${m.coa_name}</td>
                                <td class="text-end font-monospace text-success" style="width: 30%;">+ Rp ${Number(m.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    html += `
                                <tr class="fw-bold bg-success-subtle text-success">
                                    <td colspan="2" class="ps-3 text-uppercase">Total Penerimaan Kas (A)</td>
                                    <td class="text-end font-monospace">Rp ${Number(data.total_arus_masuk).toLocaleString('id-ID')}</td>
                                </tr>

                                <tr><td colspan="3" style="height: 25px; border: none;"></td></tr>

                                <tr class="table-light fw-bold">
                                    <td colspan="2" class="text-danger text-uppercase"><i class="bi bi-box-arrow-up-left me-2"></i> 2. PENGGUNAAN KAS UNTUK AKTIVITAS OPERASIONAL (KELUAR)</td>
                                    <td></td>
                                </tr>`;

                    if (data.arus_keluar_detail.length === 0) {
                        html += `<tr><td colspan="3" class="text-muted ps-4 fst-italic">Tidak ada aliran kas keluar</td></tr>`;
                    } else {
                        data.arus_keluar_detail.forEach(k => {
                            html += `
                            <tr>
                                <td class="ps-4 text-secondary">${k.coa_code}</td>
                                <td>Pengeluaran / Pembayaran ${k.coa_name}</td>
                                <td class="text-end font-monospace text-danger">- Rp ${Number(k.total).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    }

                    const isSurplus = data.kenaikan_bersih >= 0;
                    const statusTeks = isSurplus ? 'KENAIKAN BERSIH KAS (SURPLUS)' : 'PENURUNAN BERSIH KAS (DEFISIT)';
                    const badgeColor = isSurplus ? 'alert-primary border-primary text-primary' : 'alert-danger border-danger text-danger';

                    html += `
                                <tr class="fw-bold bg-danger-subtle text-danger">
                                    <td colspan="2" class="ps-3 text-uppercase">Total Pengeluaran Kas (B)</td>
                                    <td class="text-end font-monospace">Rp ${Number(data.total_arus_keluar).toLocaleString('id-ID')}</td>
                                </tr>

                                <tr><td colspan="3" style="height: 25px; border: none;"></td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert ${badgeColor} d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border m-0">
                        <span class="fw-bold text-uppercase">
                            <i class="bi bi-currency-dollar"></i> ${statusTeks} (A - B)
                        </span>
                        <span class="fw-bold fs-4 font-monospace">
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
