@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        .card-pegawai {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-pegawai:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
        }

        .filter-bar {
            /* background-color: #fff; */
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 30px;
        }

        .search-input {
            border-radius: 30px;
            padding-left: 40px;
        }

        .search-icon {
            position: absolute;
            top: 9px;
            left: 15px;
            color: #6c757d;
        }

        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
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
                            <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1">Trans <span class="text-white fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0">Data <span class="text-white fw-medium">Pegawai</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pegawait">
        <div class="filter-bar mb-4 border border-primary">
            <div class="row g-3 align-items-center">
                <div class="col-md-4 position-relative">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="searchInput" class="form-control search-input"
                        placeholder="Cari nama pegawai...">
                </div>
                <div class="col-md-4">
                    <select id="filterJabatan" class="form-select">
                        <option value="">Filter Jabatan...</option>
                        <option>Manager</option>
                        <option>Staff HRD</option>
                        <option>Kasir</option>
                        <option>Apoteker</option>
                        <option>Logistik</option>
                        <option>IT Support</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="filterDivisi" class="form-select">
                        <option value="">Filter Divisi...</option>
                        <option>Keuangan</option>
                        <option>Farmasi</option>
                        <option>SDM</option>
                        <option>Gudang</option>
                        <option>IT</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Grid Pegawai -->
        <div class="row g-3" id="pegawaiContainer">
            <!-- Pegawai cards generated here -->
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination mt-4" id="pagination"></ul>
        </nav>

    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-pegawai-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pegawai-xl"></div>
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
        // Data Pegawai (contoh)
        const dataPegawai = [
            { nama: "Agus Raharjo", jabatan: "Manager", divisi: "SDM", foto: "https://randomuser.me/api/portraits/men/32.jpg", kontak: "agus@perusahaan.com" },
            { nama: "Rina Kartika", jabatan: "Apoteker", divisi: "Farmasi", foto: "https://randomuser.me/api/portraits/women/65.jpg", kontak: "rina@perusahaan.com" },
            { nama: "Dedi Santoso", jabatan: "Kasir", divisi: "Keuangan", foto: "https://randomuser.me/api/portraits/men/54.jpg", kontak: "dedi@perusahaan.com" },
            { nama: "Lina Putri", jabatan: "Staff HRD", divisi: "SDM", foto: "https://randomuser.me/api/portraits/women/60.jpg", kontak: "lina@perusahaan.com" },
            { nama: "Rahmat Hidayat", jabatan: "Logistik", divisi: "Gudang", foto: "https://randomuser.me/api/portraits/men/75.jpg", kontak: "rahmat@perusahaan.com" },
            { nama: "Ayu Nirmala", jabatan: "Staff HRD", divisi: "SDM", foto: "https://randomuser.me/api/portraits/women/71.jpg", kontak: "ayu@perusahaan.com" },
            { nama: "Bayu Prasetyo", jabatan: "IT Support", divisi: "IT", foto: "https://randomuser.me/api/portraits/men/48.jpg", kontak: "bayu@perusahaan.com" },
            { nama: "Sinta Aulia", jabatan: "Apoteker", divisi: "Farmasi", foto: "https://randomuser.me/api/portraits/women/77.jpg", kontak: "sinta@perusahaan.com" },
            { nama: "Teguh Widodo", jabatan: "Logistik", divisi: "Gudang", foto: "https://randomuser.me/api/portraits/men/79.jpg", kontak: "teguh@perusahaan.com" },
            { nama: "Robby Andika", jabatan: "Kasir", divisi: "Keuangan", foto: "https://randomuser.me/api/portraits/men/81.jpg", kontak: "robby@perusahaan.com" },
            { nama: "Nita Puspita", jabatan: "Staff HRD", divisi: "SDM", foto: "https://randomuser.me/api/portraits/women/56.jpg", kontak: "nita@perusahaan.com" },
        ];

        const pegawait = document.getElementById("pegawaiContainer");
        const pagination = document.getElementById("pagination");
        const searchInput = document.getElementById("searchInput");
        const filterJabatan = document.getElementById("filterJabatan");
        const filterDivisi = document.getElementById("filterDivisi");

        let currentPage = 1;
        const itemsPerPage = 8;
        let filteredPegawai = dataPegawai;

        function renderPegawai(list) {
            pegawait.innerHTML = "";
            if (list.length === 0) {
                pegawait.innerHTML = `<div class='text-center text-muted py-5'>Tidak ada pegawai ditemukan.</div>`;
                pagination.innerHTML = "";
                return;
            }

            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageItems = list.slice(start, end);

            pageItems.forEach(p => {
                const card = `
                          <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card card-pegawai text-center border border-primary">
                              <img src="${p.foto}" class="card-img-top" alt="${p.nama}">
                              <div class="card-body">
                                <h5 class="card-title text-primary fw-bold">${p.nama}</h5>
                                <p class="card-text mb-1">${p.jabatan}</p>
                                <small class="text-muted">${p.divisi}</small>
                                <hr>
                                <a href="mailto:${p.kontak}" class="btn btn-outline-primary btn-sm rounded-pill">
                                  <i class="bi bi-envelope"></i> Hubungi
                                </a>
                              </div>
                            </div>
                          </div>`;
                pegawait.innerHTML += card;
            });

            renderPagination(list);
        }

        function renderPagination(list) {
            const totalPages = Math.ceil(list.length / itemsPerPage);
            pagination.innerHTML = "";

            if (totalPages <= 1) return;

            const prevDisabled = currentPage === 1 ? "disabled" : "";
            const nextDisabled = currentPage === totalPages ? "disabled" : "";

            pagination.innerHTML += `
                        <li class="page-item ${prevDisabled}">
                          <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Sebelumnya</a>
                        </li>
                      `;

            for (let i = 1; i <= totalPages; i++) {
                const active = i === currentPage ? "active" : "";
                pagination.innerHTML += `
                          <li class="page-item ${active}">
                            <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                          </li>`;
            }

            pagination.innerHTML += `
                        <li class="page-item ${nextDisabled}">
                          <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Berikutnya</a>
                        </li>`;
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredPegawai.length / itemsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderPegawai(filteredPegawai);
        }

        function filterPegawai() {
            const cari = searchInput.value.toLowerCase();
            const jab = filterJabatan.value;
            const div = filterDivisi.value;

            filteredPegawai = dataPegawai.filter(p =>
                p.nama.toLowerCase().includes(cari) &&
                (jab === "" || p.jabatan === jab) &&
                (div === "" || p.divisi === div)
            );

            currentPage = 1;
            renderPegawai(filteredPegawai);
        }

        // Event Listener
        searchInput.addEventListener("keyup", filterPegawai);
        filterJabatan.addEventListener("change", filterPegawai);
        filterDivisi.addEventListener("change", filterPegawai);

        // Render awal
        renderPegawai(dataPegawai);
    </script>
@endsection
