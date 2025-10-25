@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        #button-pick-request {
            cursor: pointer;
        }

        #button-pick-request:hover {
            background: rgb(223, 217, 25);
        }

        #button-terima-order-barang-peminjaman:hover {
            background: rgb(223, 217, 25);
            cursor: pointer;
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Transaksi <span
                                class="text-white fw-medium" style="color: white !important;">Barang Masuk</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📊 Laporan Barang Masuk & Keluar</h3>
    </div>

    <!-- Filter -->
    <div class="card p-3 mb-3">
        <form class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" id="startDate" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" id="endDate" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jenis Laporan</label>
                <select id="jenisLaporan" class="form-select">
                    <option value="semua">Semua</option>
                    <option value="masuk">Barang Masuk</option>
                    <option value="keluar">Barang Keluar</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-success w-100" onclick="tampilkanLaporan()">Tampilkan Laporan</button>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6>Hasil Laporan</h6>
            <div>
                <button class="btn btn-danger btn-sm" onclick="exportPDF()">📄 Export PDF</button>
                <button class="btn btn-success btn-sm" onclick="exportExcel()">📊 Export Excel</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle" id="tabelLaporan">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>No. Dokumen</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Unit/Supplier</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Dummy -->
                    <tr>
                        <td>1</td>
                        <td>2025-10-22</td>
                        <td>Masuk</td>
                        <td>GRN-001/10/2025</td>
                        <td>Masker Bedah</td>
                        <td>200</td>
                        <td>Box</td>
                        <td>PT Medis Sehat</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>2025-10-24</td>
                        <td>Keluar</td>
                        <td>DO-002/10/2025</td>
                        <td>Hand Sanitizer</td>
                        <td>50</td>
                        <td>Botol</td>
                        <td>Unit IGD</td>
                    </tr>
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
    <div class="modal fade" id="modal-pr-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pr-xl"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalBarangMasuk" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Barang Masuk (GRN)</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formBarangMasuk" class="row g-3">

                        <!-- Data Umum GRN -->
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">No. GRN</label>
                            <input type="text" class="form-control" id="noGRN" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gudang</label>
                            <select class="form-select" required>
                                <option>Gudang Utama</option>
                                <option>Gudang Medis</option>
                                <option>Gudang Kimia</option>
                            </select>
                        </div>

                        <hr class="mt-4">

                        <!-- Data Supplier -->
                        <h6>🧾 Data Supplier</h6>
                        <div class="col-md-4">
                            <label class="form-label">Nama Supplier</label>
                            <select id="supplierSelect" class="form-select" required onchange="isiSupplier()">
                                <option value="">-- Pilih Supplier --</option>
                                <option value="PT. Medika Utama">PT. Medika Utama</option>
                                <option value="CV. Sehat Selalu">CV. Sehat Selalu</option>
                                <option value="Apotek Sumber Rejeki">Apotek Sumber Rejeki</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Alamat</label>
                            <input type="text" id="alamatSupplier" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. Kontak</label>
                            <input type="text" id="kontakSupplier" class="form-control" readonly>
                        </div>

                        <hr class="mt-4">

                        <!-- Tabel Barang -->
                        <h6>📦 Daftar Barang</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="tabelBarang">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>No. Batch</th>
                                        <th>Expired Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" placeholder="Nama Barang" required></td>
                                        <td><input type="text" class="form-control" placeholder="Kategori"></td>
                                        <td><input type="number" class="form-control" min="1" required></td>
                                        <td><input type="text" class="form-control" placeholder="Box / Pcs"></td>
                                        <td><input type="text" class="form-control" placeholder="Batch No"></td>
                                        <td><input type="date" class="form-control"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger"
                                                onclick="hapusBaris(this)">🗑</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="btn btn-outline-primary" onclick="tambahBaris()">+ Tambah
                            Barang</button>

                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Simpan GRN</button>
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
        function tampilkanLaporan() {
            alert('Filter laporan berdasarkan periode & jenis sudah aktif. (Integrasi backend bisa ditambahkan)');
        }

        // Export ke Excel
        function exportExcel() {
            const table = document.getElementById("tabelLaporan");
            const wb = XLSX.utils.table_to_book(table, { sheet: "Laporan" });
            XLSX.writeFile(wb, "Laporan_Barang.xlsx");
        }

        // Export ke PDF
        async function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: "landscape" });
            doc.setFontSize(14);
            doc.text("Laporan Barang Masuk & Keluar", 14, 15);

            let rows = [];
            document.querySelectorAll("#tabelLaporan tbody tr").forEach(tr => {
                const cells = Array.from(tr.querySelectorAll("td")).map(td => td.textContent);
                rows.push(cells);
            });

            let headers = [];
            document.querySelectorAll("#tabelLaporan thead th").forEach(th => headers.push(th.textContent));

            doc.autoTable({
                head: [headers],
                body: rows,
                startY: 25,
                styles: { fontSize: 9 },
            });
            doc.save("Laporan_Barang.pdf");
        }
    </script>

@endsection
