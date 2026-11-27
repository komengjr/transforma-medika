@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
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
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
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

    .ent-input,
    .ent-select {
        min-height: 40px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        padding: 7px 12px !important;
    }

    .ent-input:focus,
    .ent-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .ent-input[readonly] {
        opacity: 0.85;
        background-color: rgba(79, 70, 229, 0.04) !important;
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

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 11px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 10px 14px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
{{-- Hero Banner Header --}}
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/app.png') }}" alt="Logo" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-truck"></i> Trans Management System
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Transaksi Barang Keluar</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Barang Keluar (Delivery Order)
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">
                            Pencatatan distribusi &amp; pengeluaran barang ke unit layanan (Delivery Order) beserta petugas penanggung jawab.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button type="button" class="btn ent-btn px-4 py-2 fs--1 fw-bold"
                        style="background: rgba(56, 189, 248, 0.24); border: 1px solid rgba(56, 189, 248, 0.45); color: #ffffff;"
                        data-bs-toggle="modal" data-bs-target="#modalBarangKeluar">
                        <i class="fas fa-plus-circle me-1"></i> Tambah DO
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Filter Card --}}
<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <form id="filterDoForm" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i> Dari Tanggal
                </label>
                <input type="date" id="filterDariTanggalDo" class="form-control ent-input ent-mono fs-2">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-check me-1 text-primary"></i> Sampai Tanggal
                </label>
                <input type="date" id="filterSampaiTanggalDo" class="form-control ent-input ent-mono fs-2">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-hospital-user me-1 text-primary"></i> Unit Tujuan
                </label>
                <select id="filterUnitTujuan" class="form-select ent-select fs-2">
                    <option value="">Semua Unit</option>
                    <option value="Unit Farmasi">Unit Farmasi</option>
                    <option value="Unit IGD">Unit IGD</option>
                    <option value="Unit Radiologi">Unit Radiologi</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2">
                    <i class="fas fa-filter me-1"></i> Tampilkan
                </button>
                <button type="button" id="btnResetDo" class="btn ent-btn btn-light border px-3 py-2 fs-2" title="Reset Filter">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Data Table --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-shipping-fast text-primary me-2"></i>Riwayat Barang Keluar</h6>
            <span class="opacity-75 fs--1">Daftar transaksi pengeluaran barang (DO) berdasarkan unit tujuan dan petugas.</span>
        </div>
        <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
            <i class="fas fa-file-invoice"></i> Delivery Order
        </span>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="tabelDo" class="table table-hover table-custom align-middle mb-0 w-100 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 48px;">No</th>
                        <th>Tanggal &amp; No. DO</th>
                        <th>Unit Tujuan &amp; Petugas</th>
                        <th class="text-center">Jumlah Item</th>
                        <th class="text-end">Total Qty</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    <tr>
                        <td class="text-center ent-mono fw-semibold">1</td>
                        <td class="ent-mono">
                            <div class="fw-bold fs-2 text-primary">DO-001/10/2025</div>
                            <div class="opacity-75 fs--2"><i class="far fa-calendar me-1"></i>2025-10-24</div>
                        </td>
                        <td>
                            <div class="fw-bold fs-2">Unit IGD</div>
                            <div class="mt-1 d-flex align-items-center gap-2">
                                <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                    <i class="fas fa-user-check"></i> Agus Raharjo
                                </span>
                            </div>
                        </td>
                        <td class="text-center ent-mono">
                            <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.24);">
                                4 Item
                            </span>
                        </td>
                        <td class="text-end ent-mono fw-bold fs-2">150</td>
                        <td class="text-center text-nowrap">
                            <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1 fs--2" title="Detail DO">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm ent-btn btn-outline-warning px-2 py-1 fs--2" title="Edit DO">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm ent-btn btn-outline-danger px-2 py-1 fs--2" title="Hapus DO">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-pr" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content ent-card border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-pr"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBarangKeluar" tabindex="-1" aria-labelledby="modalBarangKeluarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shipping-fast me-2 fs-1 text-warning"></i>
                    <h5 class="modal-title fs-1 fw-bold text-white mb-0" id="modalBarangKeluarLabel">Tambah Data Barang Keluar (DO)</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 p-md-4">
                <form id="formBarangKeluar" class="row g-3">

                    <!-- Data Umum DO -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold fs--1 mb-1">Tanggal</label>
                        <input type="date" class="form-control ent-input ent-mono fs-2" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold fs--1 mb-1">No. Dokumen (DO)</label>
                        <input type="text" class="form-control ent-input ent-mono fw-bold fs-2" id="noDO" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold fs--1 mb-1">Unit Tujuan</label>
                        <select class="form-select ent-select fs-2" required>
                            <option value="">-- Pilih Unit --</option>
                            <option value="Unit Farmasi">Unit Farmasi</option>
                            <option value="Unit IGD">Unit IGD</option>
                            <option value="Unit Radiologi">Unit Radiologi</option>
                            <option value="Unit Rawat Inap">Unit Rawat Inap</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold fs--1 mb-1">Petugas</label>
                        <input type="text" class="form-control ent-input fs-2" placeholder="Nama Petugas" required>
                    </div>

                    <hr class="my-3" style="border-color: var(--ent-grid-border);">

                    <!-- Tabel Barang -->
                    <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h6 class="fw-bold fs-1 mb-0"><i class="fas fa-boxes me-2 text-primary"></i>Daftar Barang yang Dikeluarkan</h6>
                        <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-3 py-1 fs--2" onclick="tambahBaris()">
                            <i class="fas fa-plus me-1"></i> Tambah Barang
                        </button>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                            <table class="table table-hover table-custom align-middle mb-0 fs-2" id="tabelBarangKeluar">
                                <thead>
                                    <tr class="fs--2">
                                        <th style="min-width: 200px;">Nama Barang</th>
                                        <th style="min-width: 140px;">Kategori</th>
                                        <th style="width: 110px;">Qty</th>
                                        <th style="width: 120px;">Satuan</th>
                                        <th style="min-width: 180px;">Keterangan</th>
                                        <th class="text-center" style="width: 60px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="fs--1">
                                    <tr>
                                        <td><input type="text" class="form-control ent-input fs-2" placeholder="Nama Barang" required></td>
                                        <td><input type="text" class="form-control ent-input fs-2" placeholder="Kategori"></td>
                                        <td><input type="number" class="form-control ent-input ent-mono fs-2" min="1" required></td>
                                        <td><input type="text" class="form-control ent-input fs-2" placeholder="Box / Pcs"></td>
                                        <td><input type="text" class="form-control ent-input fs-2" placeholder="Keterangan (opsional)"></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm ent-btn btn-outline-danger px-2 py-1 fs--2" onclick="hapusBaris(this)" title="Hapus Baris">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer px-4 py-3 gap-2" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4 fs--1" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn ent-btn ent-btn-primary px-4 fs--1">
                    <i class="fas fa-save me-1"></i> Simpan DO
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        const table = new DataTable('#tabelDo', {
            responsive: true,
            language: {
                search: "Cari Cepat:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ transaksi DO",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            }
        });

        $('#filterDoForm').on('submit', function(e) {
            e.preventDefault();
            const dari = $('#filterDariTanggalDo').val().trim();
            const sampai = $('#filterSampaiTanggalDo').val().trim();
            const unit = $('#filterUnitTujuan').val().trim();
            const keyword = [unit, dari, sampai].filter(Boolean).join(' ');
            table.search(keyword).draw();
        });

        $('#btnResetDo').on('click', function() {
            $('#filterDoForm')[0].reset();
            table.search('').draw();
        });
    });

    // Generate Nomor DO otomatis
    function generateDO() {
        const now = new Date();
        const bulan = (now.getMonth() + 1).toString().padStart(2, '0');
        const tahun = now.getFullYear();
        const random = Math.floor(Math.random() * 900) + 100;
        document.getElementById('noDO').value = `DO-${random}/${bulan}/${tahun}`;
    }
    document.getElementById('modalBarangKeluar').addEventListener('shown.bs.modal', generateDO);

    // Tambah dan hapus baris barang
    function tambahBaris() {
        const table = document.getElementById("tabelBarangKeluar").querySelector("tbody");
        const row = document.createElement("tr");
        row.innerHTML = `
            <td><input type="text" class="form-control ent-input fs-2" placeholder="Nama Barang" required></td>
            <td><input type="text" class="form-control ent-input fs-2" placeholder="Kategori"></td>
            <td><input type="number" class="form-control ent-input ent-mono fs-2" min="1" required></td>
            <td><input type="text" class="form-control ent-input fs-2" placeholder="Box / Pcs"></td>
            <td><input type="text" class="form-control ent-input fs-2" placeholder="Keterangan (opsional)"></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm ent-btn btn-outline-danger px-2 py-1 fs--2" onclick="hapusBaris(this)" title="Hapus Baris">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;
        table.appendChild(row);
    }

    function hapusBaris(btn) {
        const tbody = btn.closest("tbody");
        if (tbody.rows.length > 1) {
            btn.closest("tr").remove();
        }
    }
</script>
@endsection
