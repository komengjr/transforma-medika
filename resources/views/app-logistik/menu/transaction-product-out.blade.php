@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">

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
                                class="text-white fw-medium" style="color: white !important;">Barang Keluar</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📤 Barang Keluar (Delivery Order)</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBarangKeluar">+ Tambah DO</button>
    </div>

    <!-- Filter -->
    <div class="card p-3 mb-3">
        <form class="row g-2">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Unit Tujuan</label>
                <select class="form-select">
                    <option>Semua Unit</option>
                    <option>Unit Farmasi</option>
                    <option>Unit IGD</option>
                    <option>Unit Radiologi</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-success w-100">Tampilkan</button>
            </div>
        </form>
    </div>

    <!-- Data Tabel -->
    <div class="card p-3">
        <h6 class="mb-3">Riwayat Barang Keluar</h6>
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No. DO</th>
                    <th>Unit Tujuan</th>
                    <th>Petugas</th>
                    <th>Jumlah Item</th>
                    <th>Total Qty</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2025-10-24</td>
                    <td>DO-001/10/2025</td>
                    <td>Unit IGD</td>
                    <td>Agus Raharjo</td>
                    <td>4</td>
                    <td>150</td>
                    <td>
                        <button class="btn btn-sm btn-info text-white">Detail</button>
                        <button class="btn btn-sm btn-warning text-dark">Edit</button>
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
            </tbody>
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
    <div class="modal fade" id="modalBarangKeluar" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Barang Keluar (DO)</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formBarangKeluar" class="row g-3">

                        <!-- Data Umum DO -->
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">No. Dokumen (DO)</label>
                            <input type="text" class="form-control" id="noDO" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Unit Tujuan</label>
                            <select class="form-select" required>
                                <option value="">-- Pilih Unit --</option>
                                <option>Unit Farmasi</option>
                                <option>Unit IGD</option>
                                <option>Unit Radiologi</option>
                                <option>Unit Rawat Inap</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Petugas</label>
                            <input type="text" class="form-control" placeholder="Nama Petugas" required>
                        </div>

                        <hr class="mt-4">

                        <!-- Tabel Barang -->
                        <h6>📦 Daftar Barang yang Dikeluarkan</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="tabelBarangKeluar">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" placeholder="Nama Barang" required></td>
                                        <td><input type="text" class="form-control" placeholder="Kategori"></td>
                                        <td><input type="number" class="form-control" min="1" required></td>
                                        <td><input type="text" class="form-control" placeholder="Box / Pcs"></td>
                                        <td><input type="text" class="form-control" placeholder="Keterangan (opsional)">
                                        </td>
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
                    <button class="btn btn-success">Simpan DO</button>
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
        // Generate Nomor DO otomatis
        function generateDO() {
            const now = new Date();
            const bulan = (now.getMonth() + 1).toString().padStart(2, '0');
            const tahun = now.getFullYear();
            const random = Math.floor(Math.random() * 900) + 100;
            document.getElementById('noDO').value = `DO-${random}/${bulan}/${tahun}`;
        }
        document.getElementById('modalBarangKeluar').addEventListener('shown.bs.modal', generateDO);

        // Tambah dan hapus baris barang
        function tambahBaris() {
            const table = document.getElementById("tabelBarangKeluar").querySelector("tbody");
            const row = document.createElement("tr");
            row.innerHTML = `
            <td><input type="text" class="form-control" placeholder="Nama Barang" required></td>
            <td><input type="text" class="form-control" placeholder="Kategori"></td>
            <td><input type="number" class="form-control" min="1" required></td>
            <td><input type="text" class="form-control" placeholder="Box / Pcs"></td>
            <td><input type="text" class="form-control" placeholder="Keterangan"></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="hapusBaris(this)">🗑</button></td>
          `;
            table.appendChild(row);
        }

        function hapusBaris(btn) {
            btn.closest("tr").remove();
        }
    </script>
@endsection
