@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.1/jspdf.plugin.autotable.min.js"></script>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-warning">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/poli.png') }}" alt="" width="80" />
                        <div>
                            <h6 class="text-warning fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-warning fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                    class="text-warning fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-warning fs--1 mb-0">Menu : </h6>
                        <h4 class="text-warning fw-bold mb-0">Manajemen <span class="text-warning fw-medium">Obat Masuk dan
                                Keluar</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 filter-group">
            <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-journal-text"></i> Riwayat Transaksi Obat</h4>
            <div class="d-flex gap-2 flex-wrap justify-content-center">
                <input type="date" id="tglAwal" class="form-control" style="width:160px;">
                <input type="date" id="tglAkhir" class="form-control" style="width:160px;">
                <input type="text" id="filterRiwayat" class="form-control" placeholder="Cari kode/nama..."
                    style="width:200px;">
                <button class="btn btn-success btn-modern" id="btnExportExcel"><i class="bi bi-file-earmark-excel"></i>
                    Excel</button>
                <button class="btn btn-danger btn-modern" id="btnExportPDF"><i class="bi bi-file-earmark-pdf"></i>
                    PDF</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center" id="tabelRiwayat">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>No Batch</th>
                        <th>Expired</th>
                        <th>Jumlah</th>
                        <th>Harga (Rp)</th>
                        <th>Total (Rp)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="dataRiwayatTbody"></tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination mt-3" id="paginationRiwayat"></ul>
        </nav>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
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
    <div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-poliklinik"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        // ================= DATA DUMMY =================
        let dataRiwayat = [
            { tgl: '2025-10-01', jenis: 'Masuk', kode: 'OBT001', nama: 'Paracetamol 500mg', batch: 'BATCH-001', exp: '2026-01-01', jumlah: 100, harga: 500, ket: 'Pembelian dari distributor' },
            { tgl: '2025-10-03', jenis: 'Keluar', kode: 'OBT001', nama: 'Paracetamol 500mg', batch: 'BATCH-001', exp: '2026-01-01', jumlah: 25, harga: 800, ket: 'Penjualan ke pasien A' },
            { tgl: '2025-10-05', jenis: 'Masuk', kode: 'OBT002', nama: 'Amoxicillin 500mg', batch: 'BATCH-002', exp: '2025-09-01', jumlah: 200, harga: 700, ket: 'Pembelian stok baru' },
            { tgl: '2025-10-07', jenis: 'Keluar', kode: 'OBT002', nama: 'Amoxicillin 500mg', batch: 'BATCH-002', exp: '2025-09-01', jumlah: 50, harga: 1000, ket: 'Penjualan ke klinik B' },
            { tgl: '2025-10-09', jenis: 'Masuk', kode: 'OBT003', nama: 'Ranitidine 150mg', batch: 'BATCH-003', exp: '2026-04-01', jumlah: 300, harga: 450, ket: 'Restock dari supplier' },
            { tgl: '2025-10-10', jenis: 'Keluar', kode: 'OBT004', nama: 'Cetirizine 10mg', batch: 'BATCH-004', exp: '2027-02-01', jumlah: 80, harga: 1200, ket: 'Penjualan grosir' },
            { tgl: '2025-10-12', jenis: 'Masuk', kode: 'OBT005', nama: 'Ibuprofen 200mg', batch: 'BATCH-005', exp: '2027-03-01', jumlah: 150, harga: 650, ket: 'Pembelian stok baru' }
        ];

        const perPage = 5;
        let pageRiwayat = 1;

        function tampilkanRiwayat() {
            const filterText = document.getElementById('filterRiwayat').value.toLowerCase();
            const tglAwal = document.getElementById('tglAwal').value;
            const tglAkhir = document.getElementById('tglAkhir').value;

            const filtered = dataRiwayat.filter(r => {
                const matchText = r.nama.toLowerCase().includes(filterText) || r.kode.toLowerCase().includes(filterText);
                const tgl = new Date(r.tgl);
                const afterStart = !tglAwal || tgl >= new Date(tglAwal);
                const beforeEnd = !tglAkhir || tgl <= new Date(tglAkhir);
                return matchText && afterStart && beforeEnd;
            });

            const start = (pageRiwayat - 1) * perPage;
            const paged = filtered.slice(start, start + perPage);

            const tbody = document.getElementById('dataRiwayatTbody');
            tbody.innerHTML = paged.map(r => `
            <tr>
              <td>${r.tgl}</td>
              <td><span class="badge bg-${r.jenis === 'Masuk' ? 'success' : 'danger'}">${r.jenis}</span></td>
              <td>${r.kode}</td>
              <td>${r.nama}</td>
              <td>${r.batch}</td>
              <td>${r.exp}</td>
              <td>${r.jumlah}</td>
              <td class="text-end">${r.harga.toLocaleString('id-ID')}</td>
              <td class="text-end">${(r.jumlah * r.harga).toLocaleString('id-ID')}</td>
              <td>${r.ket}</td>
            </tr>
          `).join('');

            buatPagination(filtered.length, pageRiwayat, 'paginationRiwayat', p => { pageRiwayat = p; tampilkanRiwayat(); });
        }

        function buatPagination(total, pageNow, targetId, onChange) {
            const totalPage = Math.ceil(total / perPage);
            const container = document.getElementById(targetId);
            container.innerHTML = '';
            for (let i = 1; i <= totalPage; i++) {
                container.innerHTML += `<li class="page-item ${i === pageNow ? 'active' : ''}">
              <button class="page-link">${i}</button></li>`;
            }
            Array.from(container.querySelectorAll('button')).forEach((btn, i) => {
                btn.addEventListener('click', () => onChange(i + 1));
            });
        }

        // ================= EXPORT PDF =================
        document.getElementById("btnExportPDF").addEventListener("click", () => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF("l", "pt", "a4");
            doc.text("Riwayat Transaksi Obat", 40, 40);
            doc.autoTable({
                html: "#tabelRiwayat",
                startY: 60,
                styles: { fontSize: 8 },
                theme: 'grid'
            });
            doc.save("Riwayat_Transaksi_Obat.pdf");
        });

        // ================= EXPORT EXCEL =================
        document.getElementById("btnExportExcel").addEventListener("click", () => {
            const ws = XLSX.utils.table_to_sheet(document.getElementById("tabelRiwayat"));
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Riwayat Obat");
            XLSX.writeFile(wb, "Riwayat_Transaksi_Obat.xlsx");
        });

        document.getElementById('filterRiwayat').addEventListener('keyup', tampilkanRiwayat);
        document.getElementById('tglAwal').addEventListener('change', tampilkanRiwayat);
        document.getElementById('tglAkhir').addEventListener('change', tampilkanRiwayat);

        tampilkanRiwayat();
    </script>
@endsection
