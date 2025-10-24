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

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        .btn-primary,
        .btn-info,
        .btn-danger {
            border-radius: 8px;
            transition: 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }

        .btn-info:hover {
            background-color: #0284c7;
            transform: scale(1.05);
        }

        .btn-danger:hover {
            background-color: #dc2626;
            transform: scale(1.05);
        }

        .search-bar {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 10px 15px;
            width: 100%;
            outline: none;
        }

        .fade-out {
            animation: fadeOut 0.4s ease forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.8);
            }
        }

        .modal-content {
            border-radius: 15px;
            animation: zoomIn 0.4s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
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

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>👥 Master Data Pelanggan</span>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalPelanggan">+ Tambah
                Pelanggan</button>
        </div>
        <div class="card-body">

            <div class="mb-3">
                <input type="text" id="searchInput" class="search-bar" placeholder="🔍 Cari Pelanggan...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center" id="tablePelanggan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyPelanggan">
                        <tr>
                            <td>1</td>
                            <td>Budi Santoso</td>
                            <td>Jl. Melati No. 20, Lampung</td>
                            <td>0812-5566-7788</td>
                            <td>budi@gmail.com</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit">✏️ Edit</button>
                                <button class="btn btn-danger btn-sm btn-hapus">🗑</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Siti Rahma</td>
                            <td>Jl. Mawar No. 11, Bandar Lampung</td>
                            <td>0813-2233-8899</td>
                            <td>siti.rahma@yahoo.com</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit">✏️ Edit</button>
                                <button class="btn btn-danger btn-sm btn-hapus">🗑</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
    <div class="modal fade" id="modalPelanggan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formPelanggan">
                        <input type="hidden" id="editIndex">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="namaPelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamatPelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="telpPelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailPelanggan" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">💾 Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <audio id="popSound" preload="auto">
        <source src="{{asset('asset/notifications/sounds/sound1.ogg')}}" type="audio/mpeg">
    </audio>

    <script>
        const tbody = document.getElementById('tbodyPelanggan');
        const formPelanggan = document.getElementById('formPelanggan');
        const modalPelanggan = new bootstrap.Modal(document.getElementById('modalPelanggan'));
        const modalTitle = document.getElementById('modalTitle');
        const editIndex = document.getElementById('editIndex');
        const sound = document.getElementById('popSound');

        const namaInput = document.getElementById('namaPelanggan');
        const alamatInput = document.getElementById('alamatPelanggan');
        const telpInput = document.getElementById('telpPelanggan');
        const emailInput = document.getElementById('emailPelanggan');
        const searchInput = document.getElementById('searchInput');

        function playSound() {
            sound.currentTime = 0;
            sound.play().catch(() => { });
        }

        // Tambah / Edit Pelanggan
        formPelanggan.addEventListener('submit', e => {
            e.preventDefault();
            playSound();

            const data = {
                nama: namaInput.value,
                alamat: alamatInput.value,
                telp: telpInput.value,
                email: emailInput.value
            };

            if (editIndex.value) {
                const row = tbody.rows[editIndex.value - 1];
                row.cells[1].innerText = data.nama;
                row.cells[2].innerText = data.alamat;
                row.cells[3].innerText = data.telp;
                row.cells[4].innerText = data.email;
            } else {
                const newRow = tbody.insertRow();
                newRow.innerHTML = `
                      <td>${tbody.rows.length}</td>
                      <td>${data.nama}</td>
                      <td>${data.alamat}</td>
                      <td>${data.telp}</td>
                      <td>${data.email}</td>
                      <td>
                        <button class="btn btn-info btn-sm btn-edit">✏️ Edit</button>
                        <button class="btn btn-danger btn-sm btn-hapus">🗑</button>
                      </td>`;
            }

            modalPelanggan.hide();
            formPelanggan.reset();
            editIndex.value = '';
        });

        // Tombol Edit / Hapus
        tbody.addEventListener('click', e => {
            if (e.target.classList.contains('btn-edit')) {
                const row = e.target.closest('tr');
                editIndex.value = row.rowIndex;
                modalTitle.innerText = "Edit Pelanggan";
                namaInput.value = row.cells[1].innerText;
                alamatInput.value = row.cells[2].innerText;
                telpInput.value = row.cells[3].innerText;
                emailInput.value = row.cells[4].innerText;
                playSound();
                modalPelanggan.show();
            }

            if (e.target.classList.contains('btn-hapus')) {
                const row = e.target.closest('tr');
                playSound();
                row.classList.add('fade-out');
                setTimeout(() => {
                    row.remove();
                    updateNo();
                }, 400);
            }
        });

        // Update Nomor
        function updateNo() {
            [...tbody.rows].forEach((tr, index) => {
                tr.cells[0].innerText = index + 1;
            });
        }

        // Live Search
        searchInput.addEventListener('keyup', () => {
            const keyword = searchInput.value.toLowerCase();
            [...tbody.rows].forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    </script>
@endsection
