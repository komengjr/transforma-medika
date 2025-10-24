@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <style>
        .table thead {
            background-color: #198754;
            color: white;
        }

        .btn-action {
            border-radius: 8px;
            padding: 6px 12px;
        }

        .summary-card {
            border-radius: 16px;
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        }

        .summary-card h2 {
            font-weight: 700;
            margin-bottom: 0;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-success">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/poli.png') }}" alt="" width="80" />
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
                        <h4 class="text-success fw-bold mb-0">Penjualan <span class="text-success fw-medium">Non
                                Resep</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold mb-0"><i class="bi bi-bag-heart-fill text-success"></i> Penjualan Non Resep</h3>
                <button class="btn btn-success rounded-pill px-4"><i class="bi bi-printer"></i> Cetak Struk</button>
            </div> -->

    <!-- Form Tambah Obat -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold mb-3 text-success"><i class="bi bi-capsule"></i> Tambah Obat</h5>
        <form id="formObat" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Nama Obat</label>
                <input type="text" class="form-control" id="namaObat" placeholder="Ketik nama obat...">
            </div>
            <div class="col-md-2">
                <label class="form-label">Harga Satuan</label>
                <input type="number" class="form-control" id="hargaObat" placeholder="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlahObat" value="1" min="1">
            </div>
            <div class="col-md-2">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control" id="subtotalObat" readonly>
            </div>
            <div class="col-md-2 text-center">
                <button type="button" class="btn btn-success btn-action w-100" id="tambahBtn"><i
                        class="bi bi-plus-circle"></i> Tambah</button>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Penjualan -->
    <div class="row g-3">
        <div class="col-md-8">
            <div class="card p-4 mb-3">
                <h5 class="fw-bold mb-3 text-success"><i class="bi bi-cart4"></i> Daftar Penjualan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" id="tabelPenjualan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- item akan ditambahkan via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Ringkasan Total -->
            <div class="summary-card">
                <h5>Total Pembayaran</h5>
                <h2 id="totalHarga">Rp 0</h2>
                <button class="btn btn-light btn-lg mt-3"><i class="bi bi-check-circle"></i> Simpan Transaksi</button>
            </div>
        </div>
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
        let daftar = [];
        const tabel = document.querySelector("#tabelPenjualan tbody");
        const totalHarga = document.getElementById("totalHarga");

        document.getElementById("tambahBtn").addEventListener("click", () => {
            const nama = document.getElementById("namaObat").value.trim();
            const harga = parseFloat(document.getElementById("hargaObat").value) || 0;
            const jumlah = parseInt(document.getElementById("jumlahObat").value) || 1;
            const subtotal = harga * jumlah;

            if (!nama || harga <= 0) {
                alert("Isi nama obat dan harga dengan benar!");
                return;
            }

            daftar.push({ nama, harga, jumlah, subtotal });
            renderTable();
            clearForm();
        });

        function renderTable() {
            tabel.innerHTML = "";
            let total = 0;
            daftar.forEach((item, index) => {
                total += item.subtotal;
                tabel.innerHTML += `
                  <tr>
                    <td>${index + 1}</td>
                    <td>${item.nama}</td>
                    <td>Rp ${item.harga.toLocaleString()}</td>
                    <td>${item.jumlah}</td>
                    <td class="fw-bold">Rp ${item.subtotal.toLocaleString()}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="hapusItem(${index})"><i class="bi bi-trash"></i></button></td>
                  </tr>
                `;
            });
            totalHarga.innerText = `Rp ${total.toLocaleString()}`;
        }

        function hapusItem(i) {
            daftar.splice(i, 1);
            renderTable();
        }

        function clearForm() {
            document.getElementById("namaObat").value = "";
            document.getElementById("hargaObat").value = "";
            document.getElementById("jumlahObat").value = 1;
            document.getElementById("subtotalObat").value = "";
        }

        // Auto hitung subtotal
        document.getElementById("hargaObat").addEventListener("input", hitungSubtotal);
        document.getElementById("jumlahObat").addEventListener("input", hitungSubtotal);
        function hitungSubtotal() {
            const harga = parseFloat(document.getElementById("hargaObat").value) || 0;
            const jumlah = parseInt(document.getElementById("jumlahObat").value) || 1;
            document.getElementById("subtotalObat").value = (harga * jumlah).toLocaleString();
        }
    </script>
@endsection
