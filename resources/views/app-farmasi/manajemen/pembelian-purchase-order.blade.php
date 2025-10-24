@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <style>
        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .badge-status {
            border-radius: 8px;
            padding: 5px 10px;
            font-weight: 600;
        }

        .badge-selesai {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .badge-proses {
            background-color: #fff3cd;
            color: #856404;
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
                        <h4 class="text-warning fw-bold mb-0">Manajemen <span class="text-warning fw-medium">Purchase
                                Order</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary"><i class="bi bi-truck"></i> Pencatatan Pembelian Barang (PO)</h3>
        <button class="btn btn-success rounded-pill px-4"><i class="bi bi-save"></i> Simpan Transaksi</button>
    </div>

    <!-- Informasi Pembelian -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-clipboard-data"></i> Informasi PO</h5>
        <form class="row g-3">
            <div class="col-md-3">
                <label class="form-label">No. PO</label>
                <input type="text" class="form-control" placeholder="Masukkan nomor PO...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Pembelian</label>
                <input type="date" class="form-control" value="2025-10-23">
            </div>
            <div class="col-md-3">
                <label class="form-label">Supplier</label>
                <select class="form-select">
                    <option selected>Pilih Supplier...</option>
                    <option>PT Medika Farma</option>
                    <option>PT Kimia Sehat</option>
                    <option>Apotek Sentosa</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Petugas Penerima</label>
                <input type="text" class="form-control" value="Agus Raharjo">
            </div>
        </form>
    </div>

    <!-- Input Barang -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-box2"></i> Tambah Barang</h5>
        <form id="formBarang" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Kode Barang</label>
                <input type="text" class="form-control" id="kodeBarang" placeholder="Kode/Barcode">
            </div>
            <div class="col-md-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="namaBarang">
            </div>
            <div class="col-md-2">
                <label class="form-label">Qty</label>
                <input type="number" class="form-control" id="qtyBarang" min="1" value="1">
            </div>
            <div class="col-md-2">
                <label class="form-label">Harga Satuan</label>
                <input type="number" class="form-control" id="hargaBarang" min="0" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Exp</label>
                <input type="date" class="form-control" id="expBarang">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-primary w-100" id="tambahBarang"><i
                        class="bi bi-plus-circle"></i></button>
            </div>
        </form>
    </div>

    <!-- Tabel Barang -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-list-ul"></i> Daftar Barang Pembelian</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle" id="tabelPembelian">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Exp Date</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="summary-card">
        <h5><i class="bi bi-cash-coin"></i> Total Pembelian</h5>
        <h2 id="totalPembelian">Rp 0</h2>
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
        const tabel = document.querySelector("#tabelPembelian tbody");
        const totalPembelian = document.getElementById("totalPembelian");

        document.getElementById("tambahBarang").addEventListener("click", () => {
            const kode = document.getElementById("kodeBarang").value.trim();
            const nama = document.getElementById("namaBarang").value.trim();
            const qty = parseInt(document.getElementById("qtyBarang").value);
            const harga = parseInt(document.getElementById("hargaBarang").value);
            const exp = document.getElementById("expBarang").value;

            if (!kode || !nama || qty <= 0) {
                alert("Mohon lengkapi data barang!");
                return;
            }

            const total = qty * harga;
            daftar.push({ kode, nama, qty, harga, total, exp });
            renderTable();
            clearForm();
        });

        function renderTable() {
            tabel.innerHTML = "";
            let grandTotal = 0;
            daftar.forEach((item, index) => {
                grandTotal += item.total;
                tabel.innerHTML += `
          <tr>
            <td>${index + 1}</td>
            <td>${item.kode}</td>
            <td>${item.nama}</td>
            <td>${item.qty}</td>
            <td>Rp ${item.harga.toLocaleString()}</td>
            <td>Rp ${item.total.toLocaleString()}</td>
            <td>${item.exp || '-'}</td>
            <td>
              <button class="btn btn-danger btn-sm" onclick="hapusItem(${index})"><i class="bi bi-trash"></i></button>
            </td>
          </tr>`;
            });
            totalPembelian.innerText = `Rp ${grandTotal.toLocaleString()}`;
        }

        function hapusItem(i) {
            daftar.splice(i, 1);
            renderTable();
        }

        function clearForm() {
            document.getElementById("kodeBarang").value = "";
            document.getElementById("namaBarang").value = "";
            document.getElementById("qtyBarang").value = 1;
            document.getElementById("hargaBarang").value = 0;
            document.getElementById("expBarang").value = "";
        }
    </script>
@endsection
