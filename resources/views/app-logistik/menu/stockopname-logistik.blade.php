@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .status-sesuai {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: 600;
            border-radius: 8px;
            padding: 3px 8px;
        }

        .status-selisih {
            background-color: #f8d7da;
            color: #842029;
            font-weight: 600;
            border-radius: 8px;
            padding: 3px 8px;
        }

        .summary-card {
            background: linear-gradient(135deg, #0d6efd, #4b8cff);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
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

    <!-- Informasi Stock Opname -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-clipboard2-data"></i> Informasi Opname</h5>
        <form class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tanggal Opname</label>
                <input type="date" class="form-control" value="2025-10-23">
            </div>
            <div class="col-md-3">
                <label class="form-label">Petugas</label>
                <input type="text" class="form-control" value="Agus Raharjo">
            </div>
            <div class="col-md-6">
                <label class="form-label">Catatan</label>
                <input type="text" class="form-control" placeholder="Keterangan tambahan...">
            </div>
        </form>
    </div>

    <!-- Input Barang -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-upc-scan"></i> Input Barang</h5>
        <form id="formBarang" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Kode / Barcode</label>
                <input type="text" class="form-control" id="kodeBarang" placeholder="Scan atau ketik kode...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="namaBarang">
            </div>
            <div class="col-md-2">
                <label class="form-label">Stok Sistem</label>
                <input type="number" class="form-control" id="stokSistem" value="0" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Stok Fisik</label>
                <input type="number" class="form-control" id="stokFisik" value="0">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" id="tambahBarang"><i class="bi bi-plus-circle"></i>
                    Tambah</button>
            </div>
        </form>
    </div>

    <!-- Tabel Stock Opname -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-list-check"></i> Daftar Barang Opname</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle" id="tabelOpname">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok Sistem</th>
                        <th>Stok Fisik</th>
                        <th>Selisih</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Summary -->
    <div class="summary-card">
        <h5 class="mb-1"><i class="bi bi-graph-up-arrow"></i> Total Barang Diperiksa</h5>
        <h2 id="totalBarang">0 Item</h2>
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
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        let daftar = [];
        const tabel = document.querySelector("#tabelOpname tbody");
        const totalBarang = document.getElementById("totalBarang");

        // Tambah Barang ke Daftar
        document.getElementById("tambahBarang").addEventListener("click", () => {
            const kode = document.getElementById("kodeBarang").value.trim();
            const nama = document.getElementById("namaBarang").value.trim();
            const stokSistem = parseInt(document.getElementById("stokSistem").value) || 0;
            const stokFisik = parseInt(document.getElementById("stokFisik").value) || 0;
            const selisih = stokFisik - stokSistem;

            if (!kode || !nama) {
                alert("Lengkapi data barang terlebih dahulu!");
                return;
            }

            daftar.push({ kode, nama, stokSistem, stokFisik, selisih });
            renderTable();
            clearForm();
        });

        function renderTable() {
            tabel.innerHTML = "";
            daftar.forEach((item, index) => {
                const status = item.selisih === 0 ?
                    `<span class='status-sesuai'>Sesuai</span>` :
                    `<span class='status-selisih'>Selisih</span>`;
                tabel.innerHTML += `
                  <tr>
                    <td>${index + 1}</td>
                    <td>${item.kode}</td>
                    <td>${item.nama}</td>
                    <td>${item.stokSistem}</td>
                    <td>${item.stokFisik}</td>
                    <td>${item.selisih}</td>
                    <td>${status}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="hapusItem(${index})"><i class="bi bi-trash"></i></button></td>
                  </tr>`;
            });
            totalBarang.innerText = `${daftar.length} Item`;
        }

        function hapusItem(i) {
            daftar.splice(i, 1);
            renderTable();
        }

        function clearForm() {
            document.getElementById("kodeBarang").value = "";
            document.getElementById("namaBarang").value = "";
            document.getElementById("stokSistem").value = 0;
            document.getElementById("stokFisik").value = 0;
        }
    </script>
@endsection
