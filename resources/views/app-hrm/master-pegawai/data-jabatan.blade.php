@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <style>
        .card-glass {
            /* background: rgba(255, 255, 255, 0.85); */
            border: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .card-glass:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        thead {
            background: #f1f7ff;
            color: #0d6efd;
        }

        .table tbody tr {
            /* background: #fff; */
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: #e8f1ff;
            transform: scale(1.01);
        }

        .btn-modern {
            border-radius: 30px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-modern:hover {
            transform: scale(1.05);
        }

        .search-bar {
            position: relative;
            margin-bottom: 20px;
        }

        .search-bar input {
            border-radius: 30px;
            padding-left: 40px;
        }

        .search-bar i {
            position: absolute;
            top: 20px;
            left: 15px;
            color: #6c757d;
        }

        .pagination .page-link {
            border-radius: 20% !important;
            margin: 0 3px;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/gl.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1" style="color: white !important;">{{ Env('APP_LABEL') }}
                                <span class="text-white fw-medium" style="color: white !important;">Management
                                    System</span>
                            </h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Master <span
                                class="text-white fw-medium" style="color: white !important;">Jabatan</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="containerx ">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-primary"><i class="bi bi-briefcase-fill"></i></h3>
            <button class="btn btn-primary btn-modern shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle"></i> Tambah Jabatan
            </button>
        </div>

        <!-- <div class="search-bar">
            <i class="fa fa-search"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Cari jabatan, divisi, atau level...">
        </div> -->
        <div class="input-group mb-3"><span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
            <input class="form-control form-control-lg" type="text" id="searchInput" class="form-control" placeholder="Cari jabatan, divisi, atau level..."/>
        </div>

        <div class="card card-glass p-4">
            <table class="table align-middle text-center border" id="tabelJabatan">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Jabatan</th>
                        <th>Divisi</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataBody"></tbody>
            </table>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
            </nav>
        </div>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle"><i class="bi bi-plus-circle"></i> Tambah Jabatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formJabatan">
                        <div class="mb-3">
                            <label class="form-label">Nama Jabatan</label>
                            <input type="text" class="form-control" id="namaJabatan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Divisi</label>
                            <select class="form-select" id="divisi" required>
                                <option value="">Pilih Divisi</option>
                                <option>SDM</option>
                                <option>Keuangan</option>
                                <option>Farmasi</option>
                                <option>Gudang</option>
                                <option>IT</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gaji Pokok</label>
                            <input type="number" class="form-control" id="gaji" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tunjangan</label>
                            <input type="number" class="form-control" id="tunjangan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Level Jabatan</label>
                            <select class="form-select" id="level" required>
                                <option value="">Pilih Level</option>
                                <option>Staff</option>
                                <option>Supervisor</option>
                                <option>Manager</option>
                                <option>Direktur</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-modern"><i class="bi bi-save"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.print.min.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let dataJabatan = JSON.parse(localStorage.getItem("dataJabatan")) || [
            { nama: "Manager HRD", divisi: "SDM", gaji: 8000000, tunjangan: 2000000, level: "Manager" },
            { nama: "Staff HRD", divisi: "SDM", gaji: 5000000, tunjangan: 1000000, level: "Staff" },
            { nama: "Apoteker", divisi: "Farmasi", gaji: 6000000, tunjangan: 1500000, level: "Supervisor" },
            { nama: "Kepala Gudang", divisi: "Gudang", gaji: 7000000, tunjangan: 1200000, level: "Supervisor" },
            { nama: "Programmer", divisi: "IT", gaji: 9000000, tunjangan: 2500000, level: "Manager" }
        ];

        const tbody = document.getElementById("dataBody");
        const searchInput = document.getElementById("searchInput");
        const pagination = document.getElementById("pagination");
        const form = document.getElementById("formJabatan");
        let editIndex = null;
        let currentPage = 1;
        const itemsPerPage = 4;

        function renderTable() {
            tbody.innerHTML = "";
            const search = searchInput.value.toLowerCase();
            const filtered = dataJabatan.filter(j =>
                j.nama.toLowerCase().includes(search) ||
                j.divisi.toLowerCase().includes(search) ||
                j.level.toLowerCase().includes(search)
            );

            const start = (currentPage - 1) * itemsPerPage;
            const pageData = filtered.slice(start, start + itemsPerPage);

            pageData.forEach((j, i) => {
                tbody.innerHTML += `
                      <tr>
                        <td>${start + i + 1}</td>
                        <td>${j.nama}</td>
                        <td>${j.divisi}</td>
                        <td>Rp ${j.gaji.toLocaleString()}</td>
                        <td>Rp ${j.tunjangan.toLocaleString()}</td>
                        <td>${j.level}</td>
                        <td>
                          <button class="btn btn-sm btn-warning" onclick="editJabatan(${start + i})"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-sm btn-danger" onclick="hapusJabatan(${start + i})"><i class="fas fa-trash"></i></button>
                        </td>
                      </tr>`;
            });

            renderPagination(filtered.length);
        }

        function renderPagination(totalItems) {
            pagination.innerHTML = "";
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                      <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <button class="page-link" onclick="goToPage(${i})">${i}</button>
                      </li>`;
            }
        }

        function goToPage(page) {
            currentPage = page;
            renderTable();
        }

        searchInput.addEventListener("input", () => {
            currentPage = 1;
            renderTable();
        });

        form.addEventListener("submit", e => {
            e.preventDefault();
            const data = {
                nama: namaJabatan.value,
                divisi: divisi.value,
                gaji: parseInt(gaji.value),
                tunjangan: parseInt(tunjangan.value),
                level: level.value
            };

            if (editIndex === null) {
                dataJabatan.push(data);
            } else {
                dataJabatan[editIndex] = data;
                editIndex = null;
            }

            localStorage.setItem("dataJabatan", JSON.stringify(dataJabatan));
            form.reset();
            bootstrap.Modal.getInstance(document.getElementById("modalTambah")).hide();
            renderTable();
        });

        function editJabatan(i) {
            const j = dataJabatan[i];
            namaJabatan.value = j.nama;
            divisi.value = j.divisi;
            gaji.value = j.gaji;
            tunjangan.value = j.tunjangan;
            level.value = j.level;
            editIndex = i;
            document.getElementById("modalTitle").innerHTML = '<i class="bi bi-pencil"></i> Edit Jabatan';
            new bootstrap.Modal(document.getElementById("modalTambah")).show();
        }

        function hapusJabatan(i) {
            if (confirm("Yakin ingin menghapus jabatan ini?")) {
                dataJabatan.splice(i, 1);
                localStorage.setItem("dataJabatan", JSON.stringify(dataJabatan));
                renderTable();
            }
        }

        renderTable();
    </script>
@endsection
