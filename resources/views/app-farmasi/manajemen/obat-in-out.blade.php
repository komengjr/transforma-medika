@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.1/jspdf.plugin.autotable.min.js"></script>

<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-danger {
        background-color: #ff6b6b;
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    /* Input & Filter Retro Style */
    .retro-input,
    .form-control {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
        font-size: 0.8rem !important;
    }

    .table-custom {
        font-size: 0.8rem;
        border-collapse: collapse !important;
        width: 100%;
    }

    .table-custom thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark) !important;
        padding: 12px 10px;
        text-align: center;
    }

    .table-custom td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 10px;
        vertical-align: middle;
        background-color: #ffffff;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-exchange-alt text-dark fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block" style="background-color: var(--retro-cyan);">Manajemen Farmasi</span>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem;">Obat Masuk dan Keluar</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CARD & FILTER BAR -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex flex-wrap justify-content-between align-items-center py-3 px-3 gap-2">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-history text-warning me-2"></i> Riwayat Transaksi Obat</h5>

        <!-- Filter Group -->
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <input type="date" id="tglAwal" class="form-control form-control-sm retro-input" style="width:150px;" title="Tanggal Awal">
            <input type="date" id="tglAkhir" class="form-control form-control-sm retro-input" style="width:150px;" title="Tanggal Akhir">
            <input type="text" id="filterRiwayat" class="form-control form-control-sm retro-input" placeholder="Cari kode/nama obat..." style="width:180px;">
            <button class="btn btn-sm retro-btn retro-btn-success px-3 py-1" id="btnExportExcel"><i class="fas fa-file-excel me-1"></i> Excel</button>
            <button class="btn btn-sm retro-btn retro-btn-danger px-3 py-1 text-white" id="btnExportPDF"><i class="fas fa-file-pdf me-1"></i> PDF</button>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-custom align-middle text-center w-100 mb-0" id="tabelRiwayat">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>No Batch</th>
                        <th>Expired</th>
                        <th>Jumlah</th>
                        <th class="text-end">Harga (Rp)</th>
                        <th class="text-end">Total (Rp)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="dataRiwayatTbody"></tbody>
            </table>
        </div>

        <nav class="d-flex justify-content-center mt-3">
            <ul class="pagination pagination-sm" id="paginationRiwayat"></ul>
        </nav>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

<script>
    // ================= DATA DUMMY =================
    let dataRiwayat = [{
            tgl: '2026-10-01',
            jenis: 'Masuk',
            kode: 'OBT001',
            nama: 'Paracetamol 500mg',
            batch: 'BATCH-001',
            exp: '2027-01-01',
            jumlah: 100,
            harga: 500,
            ket: 'Pembelian dari distributor'
        },
        {
            tgl: '2026-10-03',
            jenis: 'Keluar',
            kode: 'OBT001',
            nama: 'Paracetamol 500mg',
            batch: 'BATCH-001',
            exp: '2027-01-01',
            jumlah: 25,
            harga: 800,
            ket: 'Penjualan ke pasien A'
        },
        {
            tgl: '2026-10-05',
            jenis: 'Masuk',
            kode: 'OBT002',
            nama: 'Amoxicillin 500mg',
            batch: 'BATCH-002',
            exp: '2026-09-01',
            jumlah: 200,
            harga: 700,
            ket: 'Pembelian stok baru'
        },
        {
            tgl: '2026-10-07',
            jenis: 'Keluar',
            kode: 'OBT002',
            nama: 'Amoxicillin 500mg',
            batch: 'BATCH-002',
            exp: '2026-09-01',
            jumlah: 50,
            harga: 1000,
            ket: 'Penjualan ke klinik B'
        },
        {
            tgl: '2026-10-09',
            jenis: 'Masuk',
            kode: 'OBT003',
            nama: 'Ranitidine 150mg',
            batch: 'BATCH-003',
            exp: '2027-04-01',
            jumlah: 300,
            harga: 450,
            ket: 'Restock dari supplier'
        },
        {
            tgl: '2026-10-10',
            jenis: 'Keluar',
            kode: 'OBT004',
            nama: 'Cetirizine 10mg',
            batch: 'BATCH-004',
            exp: '2028-02-01',
            jumlah: 80,
            harga: 1200,
            ket: 'Penjualan grosir'
        },
        {
            tgl: '2026-10-12',
            jenis: 'Masuk',
            kode: 'OBT005',
            nama: 'Ibuprofen 200mg',
            batch: 'BATCH-005',
            exp: '2028-03-01',
            jumlah: 150,
            harga: 650,
            ket: 'Pembelian stok baru'
        }
    ];

    const perPage = 5;
    let pageRiwayat = 1;

    function tampilkanRiwayat() {
        const filterText = document.getElementById('filterRiwayat').value.toLowerCase();
        const tglAwal = document.getElementById('tglAwal').value;
        const tglAkhir = document.getElementById('tglAkhir').value;

        const filtered = dataRiwayat.filter(r => {
            const matchText = r.nama.toLowerCase().includes(filterText) || r.kode.toLowerCase().includes(filterText);
            const tgl = new Date(r.tgl);
            const afterStart = !tglAwal || tgl >= new Date(tglAwal);
            const beforeEnd = !tglAkhir || tgl <= new Date(tglAkhir);
            return matchText && afterStart && beforeEnd;
        });

        const start = (pageRiwayat - 1) * perPage;
        const paged = filtered.slice(start, start + perPage);

        const tbody = document.getElementById('dataRiwayatTbody');
        tbody.innerHTML = paged.map(r => `
                <tr>
                  <td>${r.tgl}</td>
                  <td><span class="retro-badge bg-${r.jenis === 'Masuk' ? 'success' : 'danger'} text-white" style="font-size:0.65rem;">${r.jenis}</span></td>
                  <td class="fw-bold text-danger">${r.kode}</td>
                  <td class="fw-bolder text-dark">${r.nama}</td>
                  <td>${r.batch}</td>
                  <td>${r.exp}</td>
                  <td>${r.jumlah}</td>
                  <td class="text-end">Rp ${r.harga.toLocaleString('id-ID')}</td>
                  <td class="text-end fw-bold text-success">Rp ${(r.jumlah * r.harga).toLocaleString('id-ID')}</td>
                  <td class="text-muted">${r.ket}</td>
                </tr>
            `).join('');

        buatPagination(filtered.length, pageRiwayat, 'paginationRiwayat', p => {
            pageRiwayat = p;
            tampilkanRiwayat();
        });
    }

    function buatPagination(total, pageNow, targetId, onChange) {
        const totalPage = Math.ceil(total / perPage);
        const container = document.getElementById(targetId);
        container.innerHTML = '';
        for (let i = 1; i <= totalPage; i++) {
            container.innerHTML += `<li class="page-item ${i === pageNow ? 'active' : ''}">
              <button class="page-link fw-bold border-dark text-dark" style="${i === pageNow ? 'background-color: var(--retro-yellow);' : ''}">${i}</button></li>`;
        }
        Array.from(container.querySelectorAll('button')).forEach((btn, i) => {
            btn.addEventListener('click', () => onChange(i + 1));
        });
    }

    // ================= EXPORT PDF =================
    document.getElementById("btnExportPDF").addEventListener("click", () => {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF("l", "pt", "a4");
        doc.text("Riwayat Transaksi Obat Masuk dan Keluar", 40, 40);
        doc.autoTable({
            html: "#tabelRiwayat",
            startY: 60,
            styles: {
                fontSize: 8
            },
            theme: 'grid'
        });
        doc.save("Riwayat_Transaksi_Obat.pdf");
    });

    // ================= EXPORT EXCEL =================
    document.getElementById("btnExportExcel").addEventListener("click", () => {
        const ws = XLSX.utils.table_to_sheet(document.getElementById("tabelRiwayat"));
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Riwayat Obat");
        XLSX.writeFile(wb, "Riwayat_Transaksi_Obat.xlsx");
    });

    document.getElementById('filterRiwayat').addEventListener('keyup', tampilkanRiwayat);
    document.getElementById('tglAwal').addEventListener('change', tampilkanRiwayat);
    document.getElementById('tglAkhir').addEventListener('change', tampilkanRiwayat);

    tampilkanRiwayat();
</script>
@endsection
