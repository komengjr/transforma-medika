@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        .modal-header {
            background: #1e293b;
            color: white;
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
                                class="text-white fw-medium" style="color: white !important;">Stock Opname</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>🏷️ Stok & Inventori (Kartu Stok)</h3>
        <div>
            <button class="btn btn-danger btn-sm" onclick="exportPDF()">📄 Export PDF</button>
            <button class="btn btn-success btn-sm" onclick="exportExcel()">📊 Export Excel</button>
        </div>
    </div>

    <!-- Filter Barang -->
    <div class="card p-3 mb-3">
        <form class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Pilih Barang</label>
                <select id="barangSelect" class="form-select">
                    <option>Masker Bedah</option>
                    <option>Hand Sanitizer</option>
                    <option>Sarung Tangan</option>
                    <option>Infus Set</option>
                    <option>Alkohol Swab</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control">
            </div>
        </form>
    </div>

    <!-- Tabel Kartu Stok -->
    <div class="card p-3">
        <h6 class="mb-3">📘 Riwayat Transaksi Barang</h6>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle" id="tabelStok">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>No. Dokumen</th>
                        <th>Keterangan</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Saldo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="stokBody">
                    <!-- Data akan dimasukkan via JavaScript -->
                </tbody>
            </table>
        </div>
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
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-warning">👁️ Detail Transaksi Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>No. Dokumen</th>
                            <td id="modalNoDok"></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td id="modalTanggal"></td>
                        </tr>
                        <tr>
                            <th>Jenis Transaksi</th>
                            <td id="modalJenis"></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td id="modalKet"></td>
                        </tr>
                        <tr>
                            <th>Jumlah Masuk</th>
                            <td id="modalMasuk"></td>
                        </tr>
                        <tr>
                            <th>Jumlah Keluar</th>
                            <td id="modalKeluar"></td>
                        </tr>
                        <tr>
                            <th>Saldo Akhir</th>
                            <td id="modalSaldo"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const dataTransaksi = [
            { no: 1, tgl: "2025-10-01", jenis: "Masuk", dok: "GRN-001/10/25", ket: "Masker dari PT Sehat Sentosa", masuk: 500, keluar: "-", saldo: 500 },
            { no: 2, tgl: "2025-10-03", jenis: "Masuk", dok: "GRN-002/10/25", ket: "Masker dari PT Medika", masuk: 300, keluar: "-", saldo: 800 },
            { no: 3, tgl: "2025-10-04", jenis: "Keluar", dok: "DO-001/10/25", ket: "Distribusi ke IGD", masuk: "-", keluar: 100, saldo: 700 },
            { no: 4, tgl: "2025-10-06", jenis: "Keluar", dok: "DO-002/10/25", ket: "Distribusi ke Poli Umum", masuk: "-", keluar: 150, saldo: 550 },
            { no: 5, tgl: "2025-10-08", jenis: "Masuk", dok: "GRN-003/10/25", ket: "Tambahan Masker dari Supplier", masuk: 400, keluar: "-", saldo: 950 },
            { no: 6, tgl: "2025-10-10", jenis: "Keluar", dok: "DO-003/10/25", ket: "Distribusi ke Bedah", masuk: "-", keluar: 200, saldo: 750 },
            { no: 7, tgl: "2025-10-12", jenis: "Masuk", dok: "GRN-004/10/25", ket: "Masker kiriman bulanan", masuk: 500, keluar: "-", saldo: 1250 },
            { no: 8, tgl: "2025-10-15", jenis: "Keluar", dok: "DO-004/10/25", ket: "Distribusi ke Gigi", masuk: "-", keluar: 100, saldo: 1150 },
            { no: 9, tgl: "2025-10-18", jenis: "Keluar", dok: "DO-005/10/25", ket: "Distribusi ke Rawat Inap", masuk: "-", keluar: 250, saldo: 900 },
            { no: 10, tgl: "2025-10-20", jenis: "Masuk", dok: "GRN-005/10/25", ket: "Masker tambahan akhir bulan", masuk: 300, keluar: "-", saldo: 1200 },
            { no: 11, tgl: "2025-10-22", jenis: "Keluar", dok: "DO-006/10/25", ket: "Distribusi ke Farmasi", masuk: "-", keluar: 200, saldo: 1000 },
        ];

        const tbody = document.getElementById("stokBody");
        dataTransaksi.forEach(row => {
            tbody.innerHTML += `
                <tr>
                  <td>${row.no}</td>
                  <td>${row.tgl}</td>
                  <td>${row.jenis}</td>
                  <td>${row.dok}</td>
                  <td>${row.ket}</td>
                  <td>${row.masuk}</td>
                  <td>${row.keluar}</td>
                  <td>${row.saldo}</td>
                  <td><button class="btn btn-primary btn-sm" onclick="previewTransaksi(${row.no})">👁️ Lihat</button></td>
                </tr>`;
        });

        function previewTransaksi(no) {
            const trx = dataTransaksi.find(t => t.no === no);
            document.getElementById("modalNoDok").innerText = trx.dok;
            document.getElementById("modalTanggal").innerText = trx.tgl;
            document.getElementById("modalJenis").innerText = trx.jenis;
            document.getElementById("modalKet").innerText = trx.ket;
            document.getElementById("modalMasuk").innerText = trx.masuk;
            document.getElementById("modalKeluar").innerText = trx.keluar;
            document.getElementById("modalSaldo").innerText = trx.saldo;
            new bootstrap.Modal(document.getElementById("previewModal")).show();
        }

        // Export ke Excel
        function exportExcel() {
            const table = document.getElementById("tabelStok");
            const wb = XLSX.utils.table_to_book(table, { sheet: "Kartu_Stok" });
            XLSX.writeFile(wb, "Kartu_Stok.xlsx");
        }

        // Export ke PDF
        async function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: "landscape" });
            doc.setFontSize(14);
            doc.text("Kartu Stok Barang - Logistik", 14, 15);

            let rows = [];
            document.querySelectorAll("#tabelStok tbody tr").forEach(tr => {
                const cells = Array.from(tr.querySelectorAll("td")).slice(0, 8).map(td => td.textContent);
                rows.push(cells);
            });

            let headers = [];
            document.querySelectorAll("#tabelStok thead th").forEach(th => headers.push(th.textContent));
            headers.pop(); // hapus kolom aksi

            doc.autoTable({
                head: [headers],
                body: rows,
                startY: 25,
                styles: { fontSize: 9 },
            });
            doc.save("Kartu_Stok.pdf");
        }
    </script>
@endsection
