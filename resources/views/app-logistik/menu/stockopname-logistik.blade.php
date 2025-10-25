@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        .table th {
            background-color: #198754;
            color: white;
        }

        canvas {
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
            height: 200px;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center" style="color: white !important;">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/app.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1" style="color: white !important;">Trans <span
                                    class="text-white fw-medium" style="color: white !important;">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Logistik<span
                                class="text-white fw-medium" style="color: white !important;"> Stock Opname</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Periode & User -->
    <div class="card p-4 mb-3">
        <h5 class="text-primary mb-3">Pilih Periode & Verifikasi User</h5>
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Bulan</label>
                <select id="bulan" class="form-select">
                    <option value="">Pilih Bulan...</option>
                    <option>Januari</option>
                    <option>Februari</option>
                    <option>Maret</option>
                    <option>April</option>
                    <option>Mei</option>
                    <option>Juni</option>
                    <option>Juli</option>
                    <option>Agustus</option>
                    <option>September</option>
                    <option>Oktober</option>
                    <option>November</option>
                    <option>Desember</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <input type="number" id="tahun" class="form-control" value="2025">
            </div>
            <div class="col-md-4">
                <label class="form-label">User Verifikasi</label>
                <input type="text" id="verifikator" class="form-control" placeholder="Nama Petugas Opname">
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-success" onclick="mulaiOpname()">Mulai</button>
            </div>
        </div>
    </div>

    <!-- Bagian Opname Barang -->
    <div id="opnameSection" style="display:none;">
        <div class="card p-4 mb-3">
            <h5 class="text-success mb-3"><i class="bi bi-search"></i> Pengecekan Stok per Barang</h5>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Kode / Nama Barang</label>
                    <input type="text" id="cariBarang" class="form-control" placeholder="Contoh: BRG001">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gudang</label>
                    <select id="gudang" class="form-select">
                        <option>Gudang Utama</option>
                        <option>Gudang Farmasi</option>
                        <option>Gudang Alkes</option>
                    </select>
                </div>
                <div class="col-md-4 d-grid">
                    <button class="btn btn-primary" onclick="cekStok()">Cek Stok</button>
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3" id="hasilCek" style="display:none;">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Kode Barang</th>
                        <td id="kodeBarang"></td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td id="namaBarang"></td>
                    </tr>
                    <tr>
                        <th>Stok Sistem</th>
                        <td id="stokSistem"></td>
                    </tr>
                    <tr>
                        <th>Stok Fisik</th>
                        <td><input type="number" id="stokFisik" class="form-control w-25" oninput="hitungSelisih()"></td>
                    </tr>
                    <tr>
                        <th>Selisih</th>
                        <td id="selisih"></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-end">
                <button class="btn btn-success" onclick="simpanBarang()">Simpan Hasil Barang</button>
            </div>
        </div>

        <div class="card p-4" id="rekapCard" style="display:none;">
            <h5 class="text-primary mb-3"><i class="bi bi-clipboard-data"></i> Rekapitulasi Hasil Stock Opname</h5>
            <table class="table table-bordered" id="rekapTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok Sistem</th>
                        <th>Stok Fisik</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="text-end mt-3">
                <button class="btn btn-primary" onclick="selesaiOpname()"><i class="bi bi-check2-circle"></i> Selesai &
                    Verifikasi</button>
            </div>
        </div>
    </div>

    <!-- Riwayat Periode -->
    <div class="card p-4 mt-3">
        <h5 class="text-info mb-3"><i class="bi bi-clock-history"></i> Riwayat Hasil Stock Opname</h5>

        <!-- Filter & Search -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" id="filterPeriode" class="form-control"
                    placeholder="Cari periode... (contoh: Oktober 2025)">
            </div>
            <div class="col-md-4">
                <input type="text" id="filterVerifikator" class="form-control" placeholder="Cari verifikator...">
            </div>
            <div class="col-md-3">
                <input type="number" id="filterTahun" class="form-control" placeholder="Filter tahun... (misal: 2025)">
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-secondary" onclick="resetFilter()">Reset</button>
            </div>
        </div>

        <table class="table table-bordered" id="riwayatTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>Verifikator</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-pr" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pr"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="verifikasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tanda Tangan Elektronik Verifikasi Akhir</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Silakan tanda tangan untuk menyetujui hasil opname periode <span id="periodeVerif"></span>.</p>
                    <canvas id="signature-pad"></canvas>
                    <div class="text-end mt-3">
                        <button class="btn btn-outline-secondary" onclick="clearSignature()">Hapus</button>
                        <button class="btn btn-success" onclick="exportPDF()"><i class="bi bi-filetype-pdf"></i> Simpan &
                            Export PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const dataStok = {
            'BRG001': { nama: 'Masker Bedah', stok: 120 },
            'BRG002': { nama: 'Sarung Tangan', stok: 85 },
            'BRG003': { nama: 'Alkohol 70%', stok: 60 },
            'BRG004': { nama: 'Infus Set', stok: 150 },
            'BRG005': { nama: 'Kapas Steril', stok: 200 },
        };
        let rekapData = [];
        let currentKode = '';
        let periodeOpname = '';
        let namaVerifikator = '';
        let riwayat = JSON.parse(localStorage.getItem('riwayatOpname') || '[]');

        function renderRiwayat(filter = {}) {
            const tbody = document.querySelector('#riwayatTable tbody');
            tbody.innerHTML = '';
            let filtered = riwayat;

            // filter data
            if (filter.periode)
                filtered = filtered.filter(r => r.periode.toLowerCase().includes(filter.periode.toLowerCase()));
            if (filter.verifikator)
                filtered = filtered.filter(r => r.verifikator.toLowerCase().includes(filter.verifikator.toLowerCase()));
            if (filter.tahun)
                filtered = filtered.filter(r => r.periode.includes(filter.tahun));

            filtered.forEach((r, i) => {
                tbody.innerHTML += `
              <tr>
                <td>${i + 1}</td>
                <td>${r.periode}</td>
                <td>${r.verifikator}</td>
                <td>${r.tanggal}</td>
                <td>
                  <button class="btn btn-sm btn-info" onclick='lihatRiwayat(${riwayat.indexOf(r)})'><i class="bi bi-eye"></i> Lihat</button>
                  <button class="btn btn-sm btn-danger" onclick='hapusRiwayat(${riwayat.indexOf(r)})'><i class="bi bi-trash"></i></button>
                </td>
              </tr>`;
            });
        }
        renderRiwayat();

        // FILTER PENCARIAN
        document.getElementById('filterPeriode').addEventListener('input', applyFilter);
        document.getElementById('filterVerifikator').addEventListener('input', applyFilter);
        document.getElementById('filterTahun').addEventListener('input', applyFilter);

        function applyFilter() {
            const filter = {
                periode: document.getElementById('filterPeriode').value,
                verifikator: document.getElementById('filterVerifikator').value,
                tahun: document.getElementById('filterTahun').value,
            };
            renderRiwayat(filter);
        }

        function resetFilter() {
            document.getElementById('filterPeriode').value = '';
            document.getElementById('filterVerifikator').value = '';
            document.getElementById('filterTahun').value = '';
            renderRiwayat();
        }

        function mulaiOpname() {
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;
            const verifikator = document.getElementById('verifikator').value.trim();
            if (!bulan || !tahun || !verifikator) { alert('Lengkapi semua data!'); return; }
            periodeOpname = `${bulan} ${tahun}`;
            namaVerifikator = verifikator;
            document.getElementById('opnameSection').style.display = 'block';
            Swal.fire({
                title: `Mulai Stock Opname periode ${periodeOpname}`,
                icon: "success",
                draggable: true
            });
        }

        function cekStok() {
            const kode = document.getElementById('cariBarang').value.trim().toUpperCase();
            if (!dataStok[kode]) { alert('Barang tidak ditemukan!'); return; }
            currentKode = kode;
            const data = dataStok[kode];
            document.getElementById('kodeBarang').textContent = kode;
            document.getElementById('namaBarang').textContent = data.nama;
            document.getElementById('stokSistem').textContent = data.stok;
            document.getElementById('stokFisik').value = data.stok;
            document.getElementById('selisih').textContent = '0';
            document.getElementById('hasilCek').style.display = 'block';
        }

        function hitungSelisih() {
            const sistem = parseInt(document.getElementById('stokSistem').textContent);
            const fisik = parseInt(document.getElementById('stokFisik').value || 0);
            const selisih = fisik - sistem;
            const el = document.getElementById('selisih');
            el.textContent = selisih;
            el.style.color = selisih < 0 ? 'red' : selisih > 0 ? 'green' : 'black';
        }

        function simpanBarang() {
            const kode = currentKode;
            const nama = document.getElementById('namaBarang').textContent;
            const sistem = document.getElementById('stokSistem').textContent;
            const fisik = document.getElementById('stokFisik').value;
            const selisih = document.getElementById('selisih').textContent;
            rekapData.push({ kode, nama, sistem, fisik, selisih });
            const tbody = document.querySelector('#rekapTable tbody');
            tbody.innerHTML = '';
            rekapData.forEach((r, i) => {
                tbody.innerHTML += `<tr><td>${i + 1}</td><td>${r.kode}</td><td>${r.nama}</td><td>${r.sistem}</td><td>${r.fisik}</td><td>${r.selisih}</td></tr>`;
            });
            document.getElementById('rekapCard').style.display = 'block';
            document.getElementById('hasilCek').style.display = 'none';
            document.getElementById('cariBarang').value = '';
        }

        function selesaiOpname() {
            if (rekapData.length === 0) { alert('Belum ada data opname!'); return; }
            document.getElementById('periodeVerif').textContent = periodeOpname;
            new bootstrap.Modal(document.getElementById('verifikasiModal')).show();
        }

        // Signature
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        let drawing = false;
        canvas.addEventListener('mousedown', () => drawing = true);
        canvas.addEventListener('mouseup', () => { drawing = false; ctx.beginPath(); });
        canvas.addEventListener('mousemove', e => {
            if (!drawing) return;
            ctx.lineWidth = 2; ctx.lineCap = 'round'; ctx.strokeStyle = '#000';
            ctx.lineTo(e.offsetX, e.offsetY); ctx.stroke(); ctx.beginPath(); ctx.moveTo(e.offsetX, e.offsetY);
        });
        function clearSignature() { ctx.clearRect(0, 0, canvas.width, canvas.height); }

        function exportPDF() {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');
            pdf.setFontSize(14);
            pdf.text("Laporan Stock Opname", 70, 15);
            pdf.setFontSize(11);
            pdf.text("Periode: " + periodeOpname, 20, 25);
            pdf.text("Verifikator: " + namaVerifikator, 20, 31);
            pdf.text("Tanggal Cetak: " + new Date().toLocaleDateString(), 20, 37);

            let y = 45;
            pdf.text("No", 10, y); pdf.text("Kode", 25, y); pdf.text("Nama Barang", 50, y);
            pdf.text("Sistem", 120, y); pdf.text("Fisik", 145, y); pdf.text("Selisih", 170, y);
            y += 5;
            rekapData.forEach((r, i) => {
                pdf.text(String(i + 1), 10, y);
                pdf.text(r.kode, 25, y);
                pdf.text(r.nama, 50, y);
                pdf.text(String(r.sistem), 120, y);
                pdf.text(String(r.fisik), 145, y);
                pdf.text(String(r.selisih), 170, y);
                y += 6;
            });

            y += 10;
            pdf.text("Tanda Tangan Verifikator:", 20, y);
            const img = canvas.toDataURL('image/png');
            pdf.addImage(img, 'PNG', 20, y + 5, 80, 40);
            const pdfBlob = pdf.output('bloburl');

            const newRecord = {
                periode: periodeOpname,
                verifikator: namaVerifikator,
                tanggal: new Date().toLocaleString(),
                data: rekapData,
                signature: img,
                pdf: pdfBlob
            };
            riwayat.push(newRecord);
            localStorage.setItem('riwayatOpname', JSON.stringify(riwayat));
            renderRiwayat();
            pdf.save(`StockOpname_${periodeOpname.replace(' ', '_')}.pdf`);
            alert('Hasil Stock Opname disimpan ke riwayat & file PDF!');
            rekapData = [];
            document.getElementById('rekapCard').style.display = 'none';
        }

        function lihatRiwayat(index) {
            const r = riwayat[index];
            window.open(r.pdf, '_blank');
        }

        function hapusRiwayat(i) {
            if (confirm('Hapus riwayat ini?')) {
                riwayat.splice(i, 1);
                localStorage.setItem('riwayatOpname', JSON.stringify(riwayat));
                renderRiwayat();
            }
        }
    </script>
@endsection
