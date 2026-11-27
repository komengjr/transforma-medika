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
                                <i class="fas fa-clipboard-check"></i> Trans Management System
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Logistik Stock Opname</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Stok &amp; Inventori (Kartu Stok)
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">
                            Pemantauan histori mutasi masuk, keluar, dan saldo akhir persediaan per item barang secara akurat.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-flex flex-wrap gap-2 justify-content-lg-end">
                        <button type="button" class="btn btn-sm ent-btn ent-glass-pill px-3 py-2 fs--1" onclick="exportPDF()">
                            <i class="fas fa-file-pdf me-1 text-danger"></i> Export PDF
                        </button>
                        <button type="button" class="btn btn-sm ent-btn px-3 py-2 fs--1 fw-bold"
                            style="background: rgba(16, 185, 129, 0.24); border: 1px solid rgba(16, 185, 129, 0.45); color: #ffffff;"
                            onclick="exportExcel()">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Filter Barang --}}
<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <form id="filterKartuStokForm" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-box me-1 text-primary"></i> Pilih Barang
                </label>
                <select id="barangSelect" class="form-select ent-select fs-2">
                    <option value="Masker Bedah">Masker Bedah</option>
                    <option value="Hand Sanitizer">Hand Sanitizer</option>
                    <option value="Sarung Tangan">Sarung Tangan</option>
                    <option value="Infus Set">Infus Set</option>
                    <option value="Alkohol Swab">Alkohol Swab</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i> Dari Tanggal
                </label>
                <input type="date" id="startDateStok" class="form-control ent-input ent-mono fs-2">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-check me-1 text-primary"></i> Sampai Tanggal
                </label>
                <input type="date" id="endDateStok" class="form-control ent-input ent-mono fs-2">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="button" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2" onclick="filterKartuStok()">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <button type="button" class="btn ent-btn btn-light border px-3 py-2 fs-2" onclick="resetKartuStok()" title="Reset Filter">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Kartu Stok --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-book text-primary me-2"></i>Riwayat Transaksi Barang</h6>
            <span class="opacity-75 fs--1">Catatan arus keluar-masuk dan posisi saldo berjalan untuk item terpilih.</span>
        </div>
        <span id="badgeNamaBarang" class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
            <i class="fas fa-tag"></i> Masker Bedah
        </span>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table class="table table-hover table-custom align-middle mb-0 w-100 fs-2" id="tabelStok">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 48px;">No</th>
                        <th>Tanggal</th>
                        <th class="text-center">Jenis</th>
                        <th>No. Dokumen</th>
                        <th>Keterangan</th>
                        <th class="text-end">Masuk</th>
                        <th class="text-end">Keluar</th>
                        <th class="text-end">Saldo</th>
                        <th class="text-center" style="width: 90px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="stokBody" class="fs--1">
                    <!-- Data akan dimasukkan via JavaScript -->
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

<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-eye me-2 fs-1 text-warning"></i>
                    <h5 class="modal-title fs-1 fw-bold text-white mb-0">Detail Transaksi Barang</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                    <table class="table table-custom align-middle mb-0 fs-2">
                        <tbody>
                            <tr>
                                <th class="w-35 opacity-75 fs--1" style="background: rgba(79, 70, 229, 0.04);">No. Dokumen</th>
                                <td id="modalNoDok" class="ent-mono fw-bold text-primary"></td>
                            </tr>
                            <tr>
                                <th class="opacity-75 fs--1" style="background: rgba(79, 70, 229, 0.04);">Tanggal</th>
                                <td id="modalTanggal" class="ent-mono"></td>
                            </tr>
                            <tr>
                                <th class="opacity-75 fs--1" style="background: rgba(79, 70, 229, 0.04);">Jenis Transaksi</th>
                                <td id="modalJenis"></td>
                            </tr>
                            <tr>
                                <th class="opacity-75 fs--1" style="background: rgba(79, 70, 229, 0.04);">Keterangan</th>
                                <td id="modalKet" class="fw-semibold"></td>
                            </tr>
                            <tr>
                                <th class="opacity-75 fs--1" style="background: rgba(79, 70, 229, 0.04);">Jumlah Masuk</th>
                                <td id="modalMasuk" class="ent-mono fw-bold text-success"></td>
                            </tr>
                            <tr>
                                <th class="opacity-75 fs--1" style="background: rgba(79, 70, 229, 0.04);">Jumlah Keluar</th>
                                <td id="modalKeluar" class="ent-mono fw-bold text-warning"></td>
                            </tr>
                            <tr>
                                <th class="opacity-75 fs--1" style="background: rgba(79, 70, 229, 0.04);">Saldo Akhir</th>
                                <td id="modalSaldo" class="ent-mono fw-bold fs-1"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4 fs--1" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.min.js"></script>

<script>
    const dataTransaksi = [
        { no: 1, tgl: "2025-10-01", jenis: "Masuk", dok: "GRN-001/10/25", ket: "Masker dari PT Sehat Sentosa", masuk: 500, keluar: "-", saldo: 500 },
        { no: 2, tgl: "2025-10-03", jenis: "Masuk", dok: "GRN-002/10/25", ket: "Masker dari PT Medika", masuk: 300, keluar: "-", saldo: 800 },
        { no: 3, tgl: "2025-10-04", jenis: "Keluar", dok: "DO-001/10/25", ket: "Distribusi ke IGD", masuk: "-", keluar: 100, saldo: 700 },
        { no: 4, tgl: "2025-10-06", jenis: "Keluar", dok: "DO-002/10/25", ket: "Distribusi ke Poli Umum", masuk: "-", keluar: 150, saldo: 550 },
        { no: 5, tgl: "2025-10-08", jenis: "Masuk", dok: "GRN-003/10/25", ket: "Tambahan Masker dari Supplier", masuk: 400, keluar: "-", saldo: 950 },
        { no: 6, tgl: "2025-10-10", jenis: "Keluar", dok: "DO-003/10/25", ket: "Distribusi ke Bedah", masuk: "-", keluar: 200, saldo: 750 },
        { no: 7, tgl: "2025-10-12", jenis: "Masuk", dok: "GRN-004/10/25", ket: "Masker kiriman bulanan", masuk: 500, keluar: "-", saldo: 1250 },
        { no: 8, tgl: "2025-10-15", jenis: "Keluar", dok: "DO-004/10/25", ket: "Distribusi ke Gigi", masuk: "-", keluar: 100, saldo: 1150 },
        { no: 9, tgl: "2025-10-18", jenis: "Keluar", dok: "DO-005/10/25", ket: "Distribusi ke Rawat Inap", masuk: "-", keluar: 250, saldo: 900 },
        { no: 10, tgl: "2025-10-20", jenis: "Masuk", dok: "GRN-005/10/25", ket: "Masker tambahan akhir bulan", masuk: 300, keluar: "-", saldo: 1200 },
        { no: 11, tgl: "2025-10-22", jenis: "Keluar", dok: "DO-006/10/25", ket: "Distribusi ke Farmasi", masuk: "-", keluar: 200, saldo: 1000 },
    ];

    const tbody = document.getElementById("stokBody");
    dataTransaksi.forEach(row => {
        const badgeJenis = row.jenis === "Masuk"
            ? `<span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);"><i class="fas fa-arrow-down"></i> Masuk</span>`
            : `<span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);"><i class="fas fa-arrow-up"></i> Keluar</span>`;

        tbody.innerHTML += `
            <tr>
                <td class="text-center ent-mono fw-semibold">${row.no}</td>
                <td class="ent-mono">${row.tgl}</td>
                <td class="text-center">${badgeJenis}</td>
                <td class="ent-mono fw-bold text-primary">${row.dok}</td>
                <td class="fw-semibold">${row.ket}</td>
                <td class="text-end ent-mono fw-bold text-success">${row.masuk}</td>
                <td class="text-end ent-mono fw-bold text-warning">${row.keluar}</td>
                <td class="text-end ent-mono fw-bold fs-2">${row.saldo}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1 fs--2" onclick="previewTransaksi(${row.no})" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>`;
    });

    let stokTable;
    $(document).ready(function() {
        stokTable = new DataTable('#tabelStok', {
            responsive: true,
            pageLength: 15,
            language: {
                search: "Cari Cepat:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ mutasi stok",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            }
        });

        $('#barangSelect').on('change', function() {
            const namaBarang = $(this).val();
            $('#badgeNamaBarang').html(`<i class="fas fa-tag"></i> ${namaBarang}`);
        });
    });

    function filterKartuStok() {
        const startDate = document.getElementById('startDateStok').value;
        const endDate = document.getElementById('endDateStok').value;
        const namaBarang = document.getElementById('barangSelect').value;

        $('#badgeNamaBarang').html(`<i class="fas fa-tag"></i> ${namaBarang}`);

        $.fn.dataTable.ext.search.pop();
        if (startDate || endDate) {
            $.fn.dataTable.ext.search.push(function(settings, data) {
                const tglBaris = data[1] || '';
                if (startDate && tglBaris < startDate) return false;
                if (endDate && tglBaris > endDate) return false;
                return true;
            });
        }
        stokTable.draw();
    }

    function resetKartuStok() {
        document.getElementById('filterKartuStokForm').reset();
        $('#badgeNamaBarang').html(`<i class="fas fa-tag"></i> ${$('#barangSelect').val()}`);
        $.fn.dataTable.ext.search.pop();
        stokTable.search('').draw();
    }

    function previewTransaksi(no) {
        const trx = dataTransaksi.find(t => t.no === no);
        document.getElementById("modalNoDok").innerText = trx.dok;
        document.getElementById("modalTanggal").innerText = trx.tgl;
        document.getElementById("modalJenis").innerHTML = trx.jenis === "Masuk"
            ? `<span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);"><i class="fas fa-arrow-down"></i> Masuk</span>`
            : `<span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);"><i class="fas fa-arrow-up"></i> Keluar</span>`;
        document.getElementById("modalKet").innerText = trx.ket;
        document.getElementById("modalMasuk").innerText = trx.masuk;
        document.getElementById("modalKeluar").innerText = trx.keluar;
        document.getElementById("modalSaldo").innerText = trx.saldo;
        new bootstrap.Modal(document.getElementById("previewModal")).show();
    }

    // Export ke Excel
    function exportExcel() {
        const table = document.getElementById("tabelStok");
        const wb = XLSX.utils.table_to_book(table, {
            sheet: "Kartu_Stok"
        });
        XLSX.writeFile(wb, "Kartu_Stok.xlsx");
    }

    // Export ke PDF
    async function exportPDF() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF({
            orientation: "landscape"
        });
        doc.setFontSize(14);
        doc.text("Kartu Stok Barang - Logistik", 14, 15);

        let rows = [];
        document.querySelectorAll("#tabelStok tbody tr").forEach(tr => {
            const cells = Array.from(tr.querySelectorAll("td")).slice(0, 8).map(td => td.textContent.trim());
            rows.push(cells);
        });

        let headers = [];
        document.querySelectorAll("#tabelStok thead th").forEach(th => headers.push(th.textContent.trim()));
        headers.pop(); // hapus kolom aksi

        doc.autoTable({
            head: [headers],
            body: rows,
            startY: 22,
            styles: {
                fontSize: 9
            },
            headStyles: {
                fillColor: [30, 27, 75]
            }
        });
        doc.save("Kartu_Stok.pdf");
    }
</script>
@endsection
