@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- Choices.css -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<style>
    .card-pegawai {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
    }

    .card-pegawai:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }

    .card-img-wrapper {
        position: relative;
        height: 190px;
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .status-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 0.75rem;
        padding: 0.35em 0.75em;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .filter-bar {
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        padding: 20px;
        margin-bottom: 25px;
    }

    .search-input {
        border-radius: 30px;
        padding-left: 42px;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 4;
    }

    .btn-action-group .btn {
        padding: 0.35rem 0.6rem;
        font-size: 0.8rem;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 2px;
        border: none;
        color: #495057;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        color: #fff;
    }
</style>
@endsection

@section('content')
<!-- Header Banner -->
<div class="row mb-4">
    <div class="col">
        <div class="card bg-primary text-white border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8 d-flex align-items-center mb-3 mb-md-0">
                        <img src="{{ asset('img/app.png') }}" class="me-3" alt="App Logo" width="55" />
                        <div>
                            <span class="badge bg-white text-primary mb-1">HRM Module</span>
                            <h3 class="text-white fw-bold mb-0">Master Data Pegawai</h3>
                            <small class="text-white-50">Kelola informasi pegawai, status aktif, dan akun login</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <button class="btn btn-light text-primary fw-bold shadow-sm rounded-pill px-4"
                            id="button-add-data-pegawai"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-pegawai-xl">
                            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pegawai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="pegawait">
    <div class="filter-bar border">
        <div class="row g-3 align-items-center">
            <div class="col-md-4 position-relative">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari nama pegawai...">
            </div>
            <div class="col-md-3">
                <select id="filterJabatan" class="form-select rounded-pill">
                    <option value="">Semua Jabatan</option>
                    <option value="Manager">Manager</option>
                    <option value="Staff HRD">Staff HRD</option>
                    <option value="Kasir">Kasir</option>
                    <option value="Apoteker">Apoteker</option>
                    <option value="Logistik">Logistik</option>
                    <option value="IT Support">IT Support</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterDivisi" class="form-select rounded-pill">
                    <option value="">Semua Divisi</option>
                    @foreach ($divisi as $div)
                    <option value="{{$div->hrm_departemen_code}}">{{$div->hrm_departemen_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select id="filterStatus" class="form-select rounded-pill">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Grid Pegawai Card -->
    <div class="row g-3" id="pegawaiContainer"></div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination mt-4" id="pagination"></ul>
    </nav>
</div>
@endsection

@section('base.js')
<!-- Modal Frame -->
<div class="modal fade" id="modal-pegawai-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-body p-0" id="menu-pegawai-xl"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Choices.js -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    let dataPegawai = [];
    let filteredPegawai = [];
    let currentPage = 1;
    const itemsPerPage = 8;

    const pegawait = document.getElementById("pegawaiContainer");
    const pagination = document.getElementById("pagination");
    const searchInput = document.getElementById("searchInput");
    const filterJabatan = document.getElementById("filterJabatan");
    const filterDivisi = document.getElementById("filterDivisi");
    const filterStatus = document.getElementById("filterStatus");

    // Fungsi utama untuk memuat data pegawai dari server
    function loadDataPegawai() {
        pegawait.innerHTML = `<div class='text-center text-primary py-5'><div class="spinner-border" role="status"></div><div class="mt-2">Memuat data...</div></div>`;

        fetch("{{ route('master_data_pegawai_data') }}")
            .then(response => response.json())
            .then(res => {
                // Mendukung response langsung array [] atau bertingkat { data: [] }
                dataPegawai = Array.isArray(res) ? res : (res.data || []);
                filteredPegawai = dataPegawai;
                filterPegawai(); // Terapkan filter & render
            })
            .catch(error => {
                console.error("Error:", error);
                pegawait.innerHTML = `<div class='text-center text-danger py-5'>Gagal memuat data pegawai.</div>`;
            });
    }

    // Panggil saat halaman pertama kali dimuat
    loadDataPegawai();

    function renderPegawai(list) {
        pegawait.innerHTML = "";
        if (list.length === 0) {
            pegawait.innerHTML = `
                <div class='col-12 text-center text-muted py-5'>
                    <i class="bi bi-person-exclamation fs-1 d-block mb-2"></i>
                    Tidak ada pegawai ditemukan.
                </div>`;
            pagination.innerHTML = "";
            return;
        }

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageItems = list.slice(start, end);

        pageItems.forEach(p => {
            // Evaluasi Status Aktif / Tidak Aktif
            const isAktif = (p.status === 'Aktif' || p.status === 1 || p.status === '1');
            const statusBadge = isAktif ?
                `<span class="badge bg-success status-badge"><i class="bi bi-check-circle me-1"></i>Aktif</span>` :
                `<span class="badge bg-secondary status-badge"><i class="bi bi-x-circle me-1"></i>Tidak Aktif</span>`;

            const defaultFoto = "{{ asset('img/default-avatar.png') }}";
            const fotoUrl = p.foto ? p.foto : defaultFoto;

            const card = `
                <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card card-pegawai text-center h-100">
                        <div class="card-img-wrapper">
                            <img src="${fotoUrl}" class="card-img-top" alt="${p.nama || ''}" onerror="this.src='${defaultFoto}'">
                            ${statusBadge}
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <h6 class="card-title text-dark fw-bold mb-1">${p.nama || '-'}</h6>
                            <p class="card-text text-primary small fw-semibold mb-1">${p.jabatan || '-'}</p>
                            <span class="badge bg-light text-secondary mb-3 align-self-center">${p.divisi || '-'}</span>

                            <div class="mt-auto border-top pt-3 btn-action-group">
                                <div class="row g-1 mb-2">
                                    <div class="col-6">
                                        <button class="btn btn-outline-info w-100 rounded-pill btn-show-detail" data-code="${p.code}" data-bs-toggle="modal" data-bs-target="#modal-pegawai-xl">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-warning w-100 rounded-pill btn-update" data-code="${p.code}" data-bs-toggle="modal" data-bs-target="#modal-pegawai-xl">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-12">
                                        <button class="btn btn-outline-danger w-100 rounded-pill btn-create-login" data-code="${p.code}" data-bs-toggle="modal" data-bs-target="#modal-pegawai-xl">
                                            <i class="bi bi-key-fill me-1"></i> Akses Login
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                <a class="page-link" href="javascript:void(0)" onclick="changePage(${currentPage - 1})">Sebelumnya</a>
            </li>`;

        for (let i = 1; i <= totalPages; i++) {
            const active = i === currentPage ? "active" : "";
            pagination.innerHTML += `
                <li class="page-item ${active}">
                    <a class="page-link" href="javascript:void(0)" onclick="changePage(${i})">${i}</a>
                </li>`;
        }

        pagination.innerHTML += `
            <li class="page-item ${nextDisabled}">
                <a class="page-link" href="javascript:void(0)" onclick="changePage(${currentPage + 1})">Berikutnya</a>
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
        const stat = filterStatus.value;

        filteredPegawai = dataPegawai.filter(p => {
            const matchNama = (p.nama || '').toLowerCase().includes(cari);
            const matchJabatan = jab === "" || p.jabatan === jab;
            const matchDivisi = div === "" || p.divisi === div;

            let matchStatus = true;
            if (stat !== "") {
                const isAktif = (p.status === 'Aktif' || p.status === 1 || p.status === '1');
                matchStatus = (stat === 'Aktif' && isAktif) || (stat === 'Tidak Aktif' && !isAktif);
            }

            return matchNama && matchJabatan && matchDivisi && matchStatus;
        });

        currentPage = 1;
        renderPegawai(filteredPegawai);
    }

    // Event Listeners Filter
    searchInput.addEventListener("keyup", filterPegawai);
    filterJabatan.addEventListener("change", filterPegawai);
    filterDivisi.addEventListener("change", filterPegawai);
    filterStatus.addEventListener("change", filterPegawai);

    // Listener custom event untuk memuat ulang data otomatis saat form disimpan
    $(document).on("pegawaiDataUpdated", function() {
        loadDataPegawai();
    });

    // AJAX Handlers Modal
    const spinner = `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>`;

    $(document).on("click", "#button-add-data-pegawai", function(e) {
        e.preventDefault();
        $('#menu-pegawai-xl').html(spinner);
        $.ajax({
                url: "{{ route('master_data_pegawai_add') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": "{{Auth::user()->userid ?? ''}}"
                },
                dataType: 'html'
            }).done(data => $('#menu-pegawai-xl').html(data))
            .fail(() => $('#menu-pegawai-xl').html('<div class="alert alert-danger">Gagal memuat form tambah data.</div>'));
    });

    $(document).on("click", ".btn-update", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-pegawai-xl').html(spinner);
        $.ajax({
                url: "{{ route('master_data_pegawai_update') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html'
            }).done(data => $('#menu-pegawai-xl').html(data))
            .fail(() => $('#menu-pegawai-xl').html('<div class="alert alert-danger">Gagal memuat form edit.</div>'));
    });

    $(document).on("click", ".btn-show-detail", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-pegawai-xl').html(spinner);
        $.ajax({
                url: "{{ route('master_data_pegawai_detail') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html'
            }).done(data => $('#menu-pegawai-xl').html(data))
            .fail(() => $('#menu-pegawai-xl').html('<div class="alert alert-danger">Gagal memuat detail data.</div>'));
    });

    $(document).on("click", ".btn-create-login", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-pegawai-xl').html(spinner);
        $.ajax({
                url: "{{ route('master_data_pegawai_create_login') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html'
            }).done(data => $('#menu-pegawai-xl').html(data))
            .fail(() => $('#menu-pegawai-xl').html('<div class="alert alert-danger">Gagal memuat form akses login.</div>'));
    });
</script>
@endsection
