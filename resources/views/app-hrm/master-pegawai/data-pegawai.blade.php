@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.14);
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
        --ent-grid-border: rgba(148, 163, 184, 0.16);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
    }

    /* Skala Font Standar: fs-2 (default), fs-1, fs--1, fs--2 */
    .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.25) !important;
        border-radius: 14px;
        box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.2);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        transition: all 0.25s ease;
    }

    .card-pegawai {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        transition: all 0.25s ease;
        overflow: hidden;
    }

    .card-pegawai:hover {
        transform: translateY(-4px);
        border-color: rgba(79, 70, 229, 0.35) !important;
        box-shadow: 0 10px 22px -4px rgba(15, 23, 42, 0.12);
    }

    .card-img-wrapper {
        position: relative;
        height: 185px;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(56, 189, 248, 0.08));
        border-bottom: 1px solid var(--ent-grid-border);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .default-avatar-icon {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: rgba(79, 70, 229, 0.12);
        border: 1px solid rgba(79, 70, 229, 0.25);
        color: #6366f1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        letter-spacing: 0.03em;
    }

    .status-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
    }

    .ent-input {
        min-height: 42px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        padding: 8px 12px !important;
    }

    .ent-input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .search-input-wrap {
        position: relative;
    }

    .search-input-wrap .search-icon {
        position: absolute;
        top: 50%;
        left: 14px;
        transform: translateY(-50%);
        opacity: 0.65;
        z-index: 3;
        pointer-events: none;
    }

    .search-input-wrap .form-control {
        padding-left: 38px !important;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .btn-action-group .btn {
        padding: 0.4rem 0.65rem;
        border-radius: 9px;
    }

    .pagination .page-link {
        border-radius: 9px;
        margin: 0 3px;
        border: 1px solid var(--ent-grid-border);
        background-color: var(--bs-body-bg, var(--ent-surface));
        color: var(--bs-body-color, var(--ent-text));
        font-weight: 600;
    }

    .pagination .page-item.active .page-link {
        background-color: #4f46e5;
        border-color: #4f46e5;
        color: #ffffff;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
<!-- Header Banner -->
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/app.png') }}" alt="App Logo" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="bi bi-people-fill"></i> HRM Module
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Master Data Pegawai</span>
                        </div>
                        <h4 class="fw-bold mb-0 fs-1" style="letter-spacing: -0.02em; color: #ffffff;">
                            Master Data Pegawai
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Kelola informasi pegawai, status aktif, divisi, jabatan, dan hak akses akun login.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button class="btn ent-btn btn-light text-primary fw-bold px-3 py-2 fs-2"
                        id="button-add-data-pegawai"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-pegawai-xl">
                        <i class="bi bi-person-plus-fill me-1"></i> Tambah Pegawai
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Filter & Grid Section -->
<div class="pegawait fs-2">
    <div class="card ent-card mb-3">
        <div class="card-body p-3 p-md-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="search-input-wrap">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="searchInput" class="form-control ent-input fs-2" placeholder="Cari nama pegawai...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="filterJabatan" class="form-select ent-input fs-2">
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
                    <select id="filterDivisi" class="form-select ent-input fs-2">
                        <option value="">Semua Divisi</option>
                        @foreach ($divisi as $div)
                        <option value="{{ $div->hrm_departemen_code }}">{{ $div->hrm_departemen_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filterStatus" class="form-select ent-input fs-2">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Pegawai Card -->
    <div class="row g-3" id="pegawaiContainer"></div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination mt-4 justify-content-center justify-content-md-start fs--1" id="pagination"></ul>
    </nav>
</div>
@endsection

@section('base.js')
<!-- Modal Frame -->
<div class="modal fade" id="modal-pegawai-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-body p-0" id="menu-pegawai-xl"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    function escapeHtml(text) {
        return String(text || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function renderDefaultAvatarHtml() {
        return `<div class="default-avatar-icon"><i class="fas fa-user" style="font-size: 2rem;"></i></div>`;
    }

    function loadDataPegawai() {
        pegawait.innerHTML = `
            <div class='col-12 text-center py-5'>
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2 fs--1 opacity-75">Memuat data pegawai...</div>
            </div>`;

        fetch("{{ route('master_data_pegawai_data') }}")
            .then(response => response.json())
            .then(res => {
                dataPegawai = Array.isArray(res) ? res : (res.data || []);
                filteredPegawai = dataPegawai;
                filterPegawai();
            })
            .catch(error => {
                console.error("Error:", error);
                pegawait.innerHTML = `<div class='col-12 text-center text-danger py-5 fs-2'><i class="bi bi-exclamation-triangle me-1"></i> Gagal memuat data pegawai.</div>`;
            });
    }

    loadDataPegawai();

    function renderPegawai(list) {
        pegawait.innerHTML = "";
        if (list.length === 0) {
            pegawait.innerHTML = `
                <div class='col-12'>
                    <div class="card ent-card">
                        <div class="card-body text-center py-5 opacity-75">
                            <i class="bi bi-person-exclamation fs-1 d-block mb-2 text-primary"></i>
                            <div class="fs-2">Tidak ada pegawai ditemukan.</div>
                        </div>
                    </div>
                </div>`;
            pagination.innerHTML = "";
            return;
        }

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageItems = list.slice(start, end);

        pageItems.forEach(p => {
            const isAktif = (p.status === 'Aktif' || p.status === 1 || p.status === '1');
            const statusBadge = isAktif
                ? `<span class="ent-badge fs--2 status-badge" style="background: rgba(16, 185, 129, 0.9); color: #ffffff;"><i class="bi bi-check-circle"></i>Aktif</span>`
                : `<span class="ent-badge fs--2 status-badge" style="background: rgba(100, 116, 139, 0.9); color: #ffffff;"><i class="bi bi-x-circle"></i>Tidak Aktif</span>`;

            const hasFoto = Boolean(p.foto && String(p.foto).trim() !== '');
            const avatarContent = hasFoto
                ? `<img src="${escapeHtml(p.foto)}" class="card-img-top" alt="${escapeHtml(p.nama || 'Foto Pegawai')}" onerror="this.parentElement.innerHTML = renderDefaultAvatarHtml()">`
                : renderDefaultAvatarHtml();

            const card = `
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card card-pegawai text-center h-100">
                        <div class="card-img-wrapper">
                            ${avatarContent}
                            ${statusBadge}
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <div class="fw-bold fs-1 mb-1">${escapeHtml(p.nama || '-')}</div>
                            <div class="text-primary fw-semibold fs--1 mb-1">${escapeHtml(p.jabatan || '-')}</div>
                            <span class="ent-badge fs--2 mb-3 align-self-center" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                ${escapeHtml(p.divisi || '-')}
                            </span>

                            <div class="mt-auto pt-3 btn-action-group" style="border-top: 1px solid var(--ent-grid-border);">
                                <div class="row g-1 mb-2">
                                    <div class="col-6">
                                        <button class="btn btn-outline-info w-100 fs--1 btn-show-detail" data-code="${escapeHtml(p.code)}" data-bs-toggle="modal" data-bs-target="#modal-pegawai-xl">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-warning w-100 fs--1 btn-update" data-code="${escapeHtml(p.code)}" data-bs-toggle="modal" data-bs-target="#modal-pegawai-xl">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-12">
                                        <button class="btn btn-outline-danger w-100 fs--1 btn-create-login" data-code="${escapeHtml(p.code)}" data-bs-toggle="modal" data-bs-target="#modal-pegawai-xl">
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
                    <a class="page-link ent-mono" href="javascript:void(0)" onclick="changePage(${i})">${i}</a>
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

    searchInput.addEventListener("keyup", filterPegawai);
    filterJabatan.addEventListener("change", filterPegawai);
    filterDivisi.addEventListener("change", filterPegawai);
    filterStatus.addEventListener("change", filterPegawai);

    $(document).on("pegawaiDataUpdated", function() {
        loadDataPegawai();
    });

    const spinner = `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>`;

    $(document).on("click", "#button-add-data-pegawai", function(e) {
        e.preventDefault();
        $('#menu-pegawai-xl').html(spinner);
        $.ajax({
            url: "{{ route('master_data_pegawai_add') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": "{{ Auth::user()->userid ?? '' }}"
            },
            dataType: 'html'
        }).done(data => $('#menu-pegawai-xl').html(data))
          .fail(() => $('#menu-pegawai-xl').html('<div class="alert alert-danger m-3 fs--1">Gagal memuat form tambah data.</div>'));
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
          .fail(() => $('#menu-pegawai-xl').html('<div class="alert alert-danger m-3 fs--1">Gagal memuat form edit.</div>'));
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
          .fail(() => $('#menu-pegawai-xl').html('<div class="alert alert-danger m-3 fs--1">Gagal memuat detail data.</div>'));
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
          .fail(() => $('#menu-pegawai-xl').html('<div class="alert alert-danger m-3 fs--1">Gagal memuat form akses login.</div>'));
    });
</script>
@endsection
