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

        .card-header {
            background: #3b82f6;
            color: white;
            font-weight: 600;
            font-size: 20px;
            padding: 20px;
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

    <div class="card card-po">
        <div class="card-header">
            🧾 Penerimaan Barang - Purchase Order
        </div>
        <div class="card-body">
            <form id="formPO" class="fade-in">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor PO</label>
                        <input type="text" class="form-control" id="noPO" placeholder="Masukkan nomor PO" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Penerimaan</label>
                        <input type="date" class="form-control" id="tglTerima" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" placeholder="Nama supplier" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Diterima Oleh</label>
                        <input type="text" class="form-control" id="diterima" placeholder="Nama penerima barang" required>
                    </div>
                </div>

                <h6 class="mt-4 mb-2">📋 Detail Barang</h6>
                <table class="table table-bordered align-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Qty PO</th>
                            <th>Qty Diterima</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyBarang">
                        <tr>
                            <td>1</td>
                            <td><input type="text" class="form-control" placeholder="Nama barang" required></td>
                            <td><input type="number" class="form-control" placeholder="Qty PO" required></td>
                            <td><input type="number" class="form-control" placeholder="Qty diterima" required></td>
                            <td><input type="text" class="form-control" placeholder="Satuan"></td>
                            <td><input type="text" class="form-control" placeholder="Keterangan"></td>
                            <td><button type="button" class="btn btn-danger btn-sm btn-hapus">🗑</button></td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary btn-sm" id="tambahBarang">+ Tambah Barang</button>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">Simpan Penerimaan</button>
                </div>
            </form>
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
    <audio id="popSound"
        src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_1e1b4f8c5f.mp3?filename=pop-94319.mp3"></audio>

    <script>
        const tbody = document.getElementById('tbodyBarang');
        const tambahBtn = document.getElementById('tambahBarang');
        const formPO = document.getElementById('formPO');
        const sound = document.getElementById('popSound');

        // Tambah baris barang
        tambahBtn.addEventListener('click', () => {
            const row = document.createElement('tr');
            row.classList.add('fade-in');
            row.innerHTML = `
                <td>${tbody.children.length + 1}</td>
                <td><input type="text" class="form-control" placeholder="Nama barang" required></td>
                <td><input type="number" class="form-control" placeholder="Qty PO" required></td>
                <td><input type="number" class="form-control" placeholder="Qty diterima" required></td>
                <td><input type="text" class="form-control" placeholder="Satuan"></td>
                <td><input type="text" class="form-control" placeholder="Keterangan"></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-hapus">🗑</button></td>
              `;
            tbody.appendChild(row);
            sound.currentTime = 0;
            sound.play();
            updateNo();
        });

        // Hapus baris barang
        tbody.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-hapus')) {
                const row = e.target.closest('tr');
                row.style.animation = 'fadeOut 0.4s ease forwards';
                sound.currentTime = 0;
                sound.play();
                setTimeout(() => {
                    row.remove();
                    updateNo();
                }, 350);
            }
        });

        // Update nomor urut otomatis
        function updateNo() {
            [...tbody.children].forEach((tr, index) => {
                tr.children[0].textContent = index + 1;
            });
        }

        // Simpan form
        formPO.addEventListener('submit', (e) => {
            e.preventDefault();
            sound.currentTime = 0;
            sound.play();
            alert('✅ Data penerimaan barang berhasil disimpan!');
            formPO.reset();
            tbody.innerHTML = '';
            tambahBtn.click(); // tambah baris kosong otomatis
        });
    </script>
@endsection
