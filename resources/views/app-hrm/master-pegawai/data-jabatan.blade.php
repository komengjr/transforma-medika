@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
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

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px 14px 0 0;
        padding: 14px 20px;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.03em;
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

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.22);
    }

    .ent-btn-primary:hover:not(:disabled) {
        color: #ffffff;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 12px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 11px 14px;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
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
<!-- HERO BANNER HEADER -->
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/gl.png') }}" alt="Jabatan Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="bi bi-briefcase-fill"></i> {{ Env('APP_LABEL', 'INNOVENTRA') }} MANAGEMENT SYSTEM
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Master Jabatan</span>
                        </div>
                        <h4 class="fw-bold mb-0 fs-1" style="letter-spacing: -0.02em; color: #ffffff;">
                            Master Data Jabatan &amp; Struktur Kompensasi
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Kelola daftar jabatan, divisi, level jabatan, serta komponen gaji pokok dan tunjangan.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button class="btn ent-btn btn-light text-primary fw-bold px-3 py-2 fs-2"
                        type="button"
                        id="btnOpenTambahJabatan"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle-fill me-1"></i> Tambah Jabatan
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- FILTER & TABLE SECTION -->
<div class="containerx fs-2">
    <div class="card ent-card mb-3">
        <div class="card-body p-3 p-md-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <div class="search-input-wrap">
                        <i class="fa fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="form-control ent-input fs-2" placeholder="Cari nama jabatan, divisi, atau level..." />
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                        <i class="bi bi-layers"></i> Total: <span id="totalJabatanCount" class="ent-mono">0</span> Jabatan
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card ent-card">
        <div class="ent-card-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h6 class="mb-0 fw-bold fs-1">
                        <i class="bi bi-table me-2 text-primary"></i>Daftar Jabatan
                    </h6>
                    <span class="opacity-75 fs--1">Informasi jabatan beserta gaji pokok, tunjangan, dan level organisasi.</span>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                <table class="table table-hover align-middle mb-0 table-custom fs-2" id="tabelJabatan" style="width:100%;">
                    <thead>
                        <tr class="fs--2">
                            <th class="text-center">#</th>
                            <th>Nama Jabatan</th>
                            <th>Divisi</th>
                            <th class="text-end">Gaji Pokok</th>
                            <th class="text-end">Tunjangan</th>
                            <th class="text-center">Level</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataBody" class="fs--1"></tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center justify-content-md-end mt-3 mb-0 fs--1" id="pagination"></ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title fw-bold fs-1 text-white" id="modalTitle">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Jabatan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formJabatan">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs--1" for="namaJabatan">Nama Jabatan</label>
                        <input type="text" class="form-control ent-input fs-2" id="namaJabatan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold fs--1" for="divisi">Divisi</label>
                        <select class="form-select ent-input fs-2" id="divisi" required>
                            <option value="">Pilih Divisi</option>
                            <option>SDM</option>
                            <option>Keuangan</option>
                            <option>Farmasi</option>
                            <option>Gudang</option>
                            <option>IT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold fs--1" for="gaji">Gaji Pokok</label>
                        <input type="number" class="form-control ent-input ent-mono fs-2" id="gaji" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold fs--1" for="tunjangan">Tunjangan</label>
                        <input type="number" class="form-control ent-input ent-mono fs-2" id="tunjangan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold fs--1" for="level">Level Jabatan</label>
                        <select class="form-select ent-input fs-2" id="level" required>
                            <option value="">Pilih Level</option>
                            <option>Staff</option>
                            <option>Supervisor</option>
                            <option>Manager</option>
                            <option>Direktur</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2">
                        <button type="button" class="btn ent-btn btn-light border px-3 fs--1" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn ent-btn ent-btn-primary px-4 fs--1">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
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
    const totalJabatanCount = document.getElementById("totalJabatanCount");
    const form = document.getElementById("formJabatan");
    let editIndex = null;
    let currentPage = 1;
    const itemsPerPage = 4;

    function escapeHtml(text) {
        return String(text || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatRupiah(num) {
        return "Rp " + Number(num || 0).toLocaleString("id-ID");
    }

    function renderTable() {
        tbody.innerHTML = "";
        const search = searchInput.value.toLowerCase();
        const filtered = dataJabatan.filter(j =>
            j.nama.toLowerCase().includes(search) ||
            j.divisi.toLowerCase().includes(search) ||
            j.level.toLowerCase().includes(search)
        );

        totalJabatanCount.textContent = filtered.length;

        if (filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4 opacity-75">
                        <i class="bi bi-inbox fs-1 d-block mb-1 text-primary"></i>
                        Tidak ada data jabatan yang cocok.
                    </td>
                </tr>`;
            pagination.innerHTML = "";
            return;
        }

        const start = (currentPage - 1) * itemsPerPage;
        const pageData = filtered.slice(start, start + itemsPerPage);

        pageData.forEach((j, i) => {
            const actualIndex = start + i;
            tbody.innerHTML += `
                <tr>
                    <td class="text-center ent-mono fw-semibold">${actualIndex + 1}</td>
                    <td class="fw-bold">${escapeHtml(j.nama)}</td>
                    <td>
                        <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                            ${escapeHtml(j.divisi)}
                        </span>
                    </td>
                    <td class="text-end ent-mono fw-semibold text-success">${formatRupiah(j.gaji)}</td>
                    <td class="text-end ent-mono fw-semibold text-primary">${formatRupiah(j.tunjangan)}</td>
                    <td class="text-center">
                        <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.22);">
                            ${escapeHtml(j.level)}
                        </span>
                    </td>
                    <td class="text-center text-nowrap">
                        <button type="button" class="btn btn-sm ent-btn btn-outline-warning me-1" onclick="editJabatan(${actualIndex})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm ent-btn btn-outline-danger" onclick="hapusJabatan(${actualIndex})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
        });

        renderPagination(filtered.length);
    }

    function renderPagination(totalItems) {
        pagination.innerHTML = "";
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (totalPages <= 1) return;

        const prevDisabled = currentPage === 1 ? "disabled" : "";
        const nextDisabled = currentPage === totalPages ? "disabled" : "";

        pagination.innerHTML += `
            <li class="page-item ${prevDisabled}">
                <button type="button" class="page-link" onclick="goToPage(${currentPage - 1})">Sebelumnya</button>
            </li>`;

        for (let i = 1; i <= totalPages; i++) {
            const active = i === currentPage ? "active" : "";
            pagination.innerHTML += `
                <li class="page-item ${active}">
                    <button type="button" class="page-link ent-mono" onclick="goToPage(${i})">${i}</button>
                </li>`;
        }

        pagination.innerHTML += `
            <li class="page-item ${nextDisabled}">
                <button type="button" class="page-link" onclick="goToPage(${currentPage + 1})">Berikutnya</button>
            </li>`;
    }

    function goToPage(page) {
        const totalPages = Math.ceil(dataJabatan.length / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTable();
    }

    document.getElementById("btnOpenTambahJabatan").addEventListener("click", () => {
        editIndex = null;
        form.reset();
        document.getElementById("modalTitle").innerHTML = '<i class="bi bi-plus-circle me-1"></i> Tambah Jabatan';
    });

    searchInput.addEventListener("input", () => {
        currentPage = 1;
        renderTable();
    });

    form.addEventListener("submit", e => {
        e.preventDefault();
        const data = {
            nama: namaJabatan.value.trim(),
            divisi: divisi.value,
            gaji: parseInt(gaji.value, 10) || 0,
            tunjangan: parseInt(tunjangan.value, 10) || 0,
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
        const modalEl = document.getElementById("modalTambah");
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
        renderTable();

        Swal.fire({
            icon: "success",
            title: "Tersimpan",
            text: "Data jabatan berhasil disimpan.",
            timer: 1400,
            showConfirmButton: false
        });
    });

    function editJabatan(i) {
        const j = dataJabatan[i];
        if (!j) return;
        namaJabatan.value = j.nama;
        divisi.value = j.divisi;
        gaji.value = j.gaji;
        tunjangan.value = j.tunjangan;
        level.value = j.level;
        editIndex = i;
        document.getElementById("modalTitle").innerHTML = '<i class="bi bi-pencil me-1"></i> Edit Jabatan';
        new bootstrap.Modal(document.getElementById("modalTambah")).show();
    }

    function hapusJabatan(i) {
        Swal.fire({
            title: "Hapus Jabatan?",
            text: "Data jabatan yang dihapus tidak dapat dikembalikan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e11d48",
            cancelButtonColor: "#64748b",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                dataJabatan.splice(i, 1);
                localStorage.setItem("dataJabatan", JSON.stringify(dataJabatan));
                renderTable();
                Swal.fire({
                    icon: "success",
                    title: "Terhapus",
                    text: "Data jabatan telah dihapus.",
                    timer: 1300,
                    showConfirmButton: false
                });
            }
        });
    }

    renderTable();
</script>
@endsection
