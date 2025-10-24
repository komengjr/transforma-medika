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

        .btn-danger,
        .btn-info {
            border-radius: 8px;
            transition: 0.2s ease;
        }

        .btn-danger:hover {
            background-color: #dc2626;
            transform: scale(1.05);
        }

        .btn-info:hover {
            background-color: #0284c7;
            transform: scale(1.05);
        }

        .search-bar {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 10px 15px;
            width: 100%;
            outline: none;
        }

        .filter-box {
            background: #f9fafb;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
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
            border-radius: 20px;
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
        <div class="card-header">
            📜 Riwayat Transaksi Pembelian PO
        </div>
        <div class="card-body">

            <div class="filter-box mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="search-bar"
                            placeholder="🔍 Cari berdasarkan Supplier / Nomor Faktur...">
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="filterStart" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="filterEnd" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" id="btnFilter">Filter</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center" id="tableRiwayat">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor Faktur</th>
                            <th>Nomor PO</th>
                            <th>Supplier</th>
                            <th>Total (Rp)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyRiwayat">
                        <tr>
                            <td>1</td>
                            <td>2025-10-20</td>
                            <td>F-00123</td>
                            <td>PO-00991</td>
                            <td>PT Sinar Medika</td>
                            <td>5.230.000</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-preview">👁 Preview</button>
                                <button class="btn btn-danger btn-sm btn-hapus">🗑</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2025-10-18</td>
                            <td>F-00122</td>
                            <td>PO-00985</td>
                            <td>CV Trans Farma</td>
                            <td>2.450.000</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-preview">👁 Preview</button>
                                <button class="btn btn-danger btn-sm btn-hapus">🗑</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>2025-10-15</td>
                            <td>F-00120</td>
                            <td>PO-00980</td>
                            <td>PT Medisindo</td>
                            <td>3.875.000</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-preview">👁 Preview</button>
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
    <div class="modal fade" id="modalPreview" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Preview Faktur Pembelian</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody id="previewBody"></tbody>
                    </table>
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
    <script>
        const tbody = document.getElementById('tbodyRiwayat');
        const searchInput = document.getElementById('searchInput');
        const btnFilter = document.getElementById('btnFilter');
        const filterStart = document.getElementById('filterStart');
        const filterEnd = document.getElementById('filterEnd');
        const sound = document.getElementById('popSound');
        const previewBody = document.getElementById('previewBody');
        const modalPreview = new bootstrap.Modal(document.getElementById('modalPreview'));

        function playSound() {
            if (sound) {
                sound.currentTime = 0;
                sound.play().catch(() => { });
            }
        }

        // 🔍 Live Search
        searchInput.addEventListener('keyup', () => {
            const keyword = searchInput.value.toLowerCase();
            [...tbody.rows].forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });

        // 📅 Filter Tanggal
        btnFilter.addEventListener('click', () => {
            const start = new Date(filterStart.value);
            const end = new Date(filterEnd.value);
            [...tbody.rows].forEach(row => {
                const tgl = new Date(row.cells[1].innerText);
                if ((isNaN(start) || tgl >= start) && (isNaN(end) || tgl <= end)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            playSound();
        });

        // 🗑️ Hapus Data
        tbody.addEventListener('click', e => {
            if (e.target.classList.contains('btn-hapus')) {
                const row = e.target.closest('tr');
                playSound();
                row.classList.add('fade-out');
                setTimeout(() => {
                    row.remove();
                    updateNo();
                }, 400);
            }
            // 👁 Preview Faktur
            if (e.target.classList.contains('btn-preview')) {
                const tr = e.target.closest('tr');
                const data = {
                    no: tr.cells[0].innerText,
                    tanggal: tr.cells[1].innerText,
                    faktur: tr.cells[2].innerText,
                    po: tr.cells[3].innerText,
                    supplier: tr.cells[4].innerText,
                    total: tr.cells[5].innerText
                };
                previewBody.innerHTML = `
                      <tr><th width="30%">Nomor</th><td>${data.no}</td></tr>
                      <tr><th>Tanggal</th><td>${data.tanggal}</td></tr>
                      <tr><th>Nomor Faktur</th><td>${data.faktur}</td></tr>
                      <tr><th>Nomor PO</th><td>${data.po}</td></tr>
                      <tr><th>Supplier</th><td>${data.supplier}</td></tr>
                      <tr><th>Total</th><td>${data.total}</td></tr>
                    `;
                playSound();
                modalPreview.show();
            }
        });

        // Update Nomor
        function updateNo() {
            [...tbody.rows].forEach((tr, index) => {
                tr.cells[0].innerText = index + 1;
            });
        }
    </script>
@endsection
