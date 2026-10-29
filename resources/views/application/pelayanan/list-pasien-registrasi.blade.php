@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    /* Hero Banner Header Compact */
    .hero-header {
        background: var(--primary-gradient);
        border-radius: 12px;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
        position: relative;
        overflow: hidden;
    }

    .hero-header h3 {
        font-size: 1.35rem;
    }

    /* Card Custom */
    .card-modern {
        border: none;
        border-radius: 12px;
    }

    /* Table Styling Compact */
    .table-custom {
        font-size: 0.8rem;
    }

    .table-custom thead th {
        background: #f8fbfc;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        padding: 18px 12px;
        border: none;
    }

    .table-custom tbody tr {
        background: #ffffff;
        transition: all 0.2s ease-in-out;
    }

    .table-custom tbody tr:hover {
        background-color: #7dc9e5 !important;
    }

    .table-custom td {
        padding: 8px 12px;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }

    .custom-loader {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 0;
    }

    /* Floating Field Filter Style (Persis Gambar) */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom label {
        position: absolute;
        top: 3px;
        left: 10px;
        font-size: 0.68rem;
        color: #6c757d;
        pointer-events: none;
        z-index: 2;
    }

    .form-floating-custom .form-control,
    .form-floating-custom .form-select {
        padding-top: 16px;
        padding-bottom: 4px;
        padding-left: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        height: 42px;
        border-color: #ced4da;
        border-radius: 6px;
    }

    /* MODAL CETAK BARCODE STYLE */
    .modal-barcode-content {
        border-radius: 4px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .modal-barcode-header {
        background-color: #6c6c6c;
        color: #ffffff;
        padding: 12px 20px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .modal-barcode-header .modal-title {
        font-size: 1.15rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .table-barcode-list {
        margin-bottom: 0;
        font-size: 0.82rem;
    }

    .table-barcode-list thead th {
        background-color: #e0e0e0;
        color: #424242;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        padding: 10px 15px;
    }

    .table-barcode-list tbody td {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
        color: #424242;
    }

    .btn-barcode-print-item {
        background-color: #6c6c6c;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 3px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .btn-barcode-print-item:hover {
        background-color: #555555;
        color: white;
    }

    .btn-gray-flat {
        background-color: transparent;
        color: #616161;
        font-weight: 700;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-gray-dark {
        background-color: #424242;
        color: white;
        font-weight: 700;
        border: none;
        text-transform: uppercase;
        padding: 8px 18px;
        border-radius: 3px;
        font-size: 0.8rem;
    }

    .btn-gray-medium {
        background-color: #757575;
        color: white;
        font-weight: 700;
        border: none;
        text-transform: uppercase;
        padding: 8px 18px;
        border-radius: 3px;
        font-size: 0.8rem;
    }

    /* Penyesuaian Khusus Select2 Floating Label */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: 42px !important;
        padding-top: 14px !important;
        padding-bottom: 2px !important;
        padding-left: 6px !important;
        border-radius: 6px !important;
        background-color: #fff !important;
        border: 1px solid #ced4da !important;
    }

    /* Mengatur Posisi Teks yang Dipilih / Placeholder */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: #212529 !important;
        padding-left: 4px !important;
        line-height: 1.5 !important;
    }

    /* Mengatur Arrow Icon Dropdown */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 6px !important;
    }

    /* Memastikan Label Tetap Berada di Atas dan Tidak Tertutup */
    .form-floating-custom label {
        z-index: 5 !important;
        background: transparent !important;
    }
</style>
@endsection

@section('content')
<!-- HEADER HERO BANNER VIBRANT -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #1f6f92 0%, #203a43 50%, #2c5364 100%);">

            <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl"
                style="width: 250px; height: 250px; top: -80px; right: 10%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle bg-info opacity-25 blur-3xl"
                style="width: 200px; height: 200px; bottom: -80px; left: -50px; filter: blur(50px);"></div>

            <div class="card-body p-4 text-white position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 bg-opacity-10 rounded-4 shadow-sm me-3 border border-white border-opacity-10 d-flex align-items-center justify-content-center backdrop-blur"
                            style="width: 65px; height: 65px; backdrop-filter: blur(10px);">
                            <img src="{{ asset('img/dashboard.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-bolt me-1"></i> LIVE SYSTEM
                                </span>
                                <span class="text-white-50" style="font-size: 0.75rem;">v2.4 Medical Suite</span>
                            </div>
                            <h3 class="text-white fw-extrabold mb-0 tracking-tight" style="font-size: 1.4rem;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="text-info fw-light">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <h6 class="text-warning fw-bold mb-0" style="font-size: 0.95rem;">
                                <i class="fas fa-list me-1"></i> List Pasien
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD -->
<!-- MAIN DATA TABLE CARD -->
<div class="card card-modern mb-4">
    <div class="card-header bg-white border-bottom border-light py-3 px-3 rounded-top-4">
        <div class="row align-items-center g-2">

            <!-- TOMBOL AKSI UTAMA (Refresh Data & Toggle Filter HP) -->
            <div class="col-12 col-md-auto d-flex align-items-center justify-content-between gap-2">
                <!-- Tombol Refresh Data -->
                <button class="btn btn-sm btn-primary rounded-3 px-3 py-2 d-flex align-items-center gap-1" style="height: 42px;"
                    type="button" id="button-refresh-data" data-bs-toggle="tooltip" title="Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-semibold ms-1">Refresh Data</span>
                </button>

                <!-- Tombol Filter Kecil (Hanya Muncul di Layar HP / Mobile) -->
                <button class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-2 d-md-none d-flex align-items-center gap-1" style="height: 42px;"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterMobile" aria-expanded="false" aria-controls="collapseFilterMobile">
                    <i class="fas fa-filter text-primary"></i>
                    <span class="fw-semibold">Filter</span>
                    <i class="fas fa-chevron-down ms-1 style-icon-collapse"></i>
                </button>
            </div>

            <!-- CONTAINER DERETAN FILTER (Bisa di-collapse pada mode HP) -->
            <div class="col-12 col-md collapse d-md-block" id="collapseFilterMobile">
                <div class="row g-2 align-items-center mt-2 mt-md-0 pt-2 pt-md-0 border-top border-md-0">

                    <!-- Filter Tanggal Awal -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Awal</label>
                            <input type="text" class="form-control datetimepicker" id="filter_tgl_awal" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker" id="filter_tgl_akhir" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter No Reg / Nama -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>No Reg / Nama</label>
                            <input type="text" class="form-control" id="filter_search" placeholder="Cari Reg/Nama...">
                        </div>
                    </div>

                    <!-- Filter Dokter -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Dokter</label>
                            <select class="form-select" id="filter_dokter">
                                <option value="">Semua Dokter</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Kel. Pelanggan / Penjamin -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Kel. Pelanggan</label>
                            <select class="form-select" id="filter_penjamin">
                                <option value="">Semua Kelompok</option>
                                <option value="PASIEN KLINIS">PASIEN KLINIS</option>
                                <option value="UMUM">UMUM / PRIBADI</option>
                                <option value="ASURANSI">ASURANSI</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Pemeriksaan -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Pemeriksaan</label>
                            <select class="form-select" id="filter_pemeriksaan">
                                <option value="">Semua Pemeriksaan</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="example" class="table table-custom align-middle mb-0" style="width:100%">
                <thead class="bg-primary">
                    <tr class="text-white">
                        <th width="5%" class="text-center">#</th>
                        <th width="5%" class="text-center">No</th>
                        <th width="18%">No. Registrasi & Petugas</th>
                        <th width="22%">Nama Pasien</th>
                        <th width="18%">Penjamin</th>
                        <th width="18%">Dokter</th>
                        <th width="12%">Janji Hasil</th>
                        <th width="15%">Pemeriksaan</th>
                        <th width="10%">Pengiriman</th>
                        <th width="5%" class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL HISTORY REGISTRASI PASIEN -->
<div class="modal fade" id="modal-registrasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle bg-light d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-registrasi"></div>
        </div>
    </div>
</div>

<!-- MODAL CETAK BARCODE -->
<div class="modal fade" id="modalCetakBarcode" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content modal-barcode-content">
            <div class="modal-header modal-barcode-header bg-primary">
                <h5 class="modal-title text-white">Cetak Barcode</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div class="table-responsive">
                    <table class="table table-barcode-list align-middle">
                        <thead>
                            <tr>
                                <th style="width: 10%;">
                                    <input type="checkbox" class="form-check-input" id="check-all-barcode" onchange="toggleSelectAllBarcode(this)">
                                </th>
                                <th style="width: 45%;">SPECIMEN</th>
                                <th style="width: 30%;">BARCODE</th>
                                <th style="width: 15%; text-align: center;">CETAK</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-barcode-list">
                            <!-- Data disuntik dinamis via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div id="loading-barcode-spinner" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-secondary" role="status"></div>
                    <div class="small mt-2 text-muted">Memuat daftar spesimen...</div>
                </div>
            </div>
            <div class="modal-footer bg-white border-top-0 px-4 pb-4 pt-0 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-gray-flat" data-bs-dismiss="modal">TUTUP</button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-gray-dark" onclick="cetakRoboBarcode()">CETAK ROBO</button>
                    <button type="button" class="btn btn-gray-medium" id="btn-cetak-terpilih" onclick="cetakTerpilihBarcode()">
                        CETAK TERPILIH [ <span id="count-selected-barcode">0</span> ]
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let table;

    $(document).ready(function() {
        table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_data_table') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.tgl1 = $('#filter_tgl_awal').val();
                    d.tgl2 = $('#filter_tgl_akhir').val();
                    d.search_custom = $('#filter_search').val();
                    d.dokter = $('#filter_dokter').val();
                    d.penjamin = $('#filter_penjamin').val();
                    d.pemeriksaan = $('#filter_pemeriksaan').val();
                }
            },
            columns: [{
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'p-0 text-center align-middle'
                },
                {
                    data: 'no',
                    className: 'align-middle'
                },
                {
                    data: 'no_reg',
                    className: 'align-middle'
                },
                {
                    data: 'nama',
                    className: 'align-middle'
                },
                {
                    data: 'agreement',
                    className: 'align-middle'
                },
                {
                    data: 'dokter',
                    className: 'align-middle'
                },
                {
                    data: 'janji_hasil',
                    className: 'align-middle'
                },
                {
                    data: 'pemeriksaan',
                    className: 'align-middle'
                },
                {
                    data: 'pengiriman',
                    className: 'align-middle'
                },
                {
                    data: 'total',
                    className: 'align-middle text-end'
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "🔍 Cari nama, RM, atau NIK...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ pasien",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                },
                processing: `
                    <div class="custom-loader">
                        <div class="spinner-border text-primary mb-2" style="width: 2.2rem; height: 2.2rem;" role="status"></div>
                        <span class="fw-bold text-primary small">Memuat data pasien...</span>
                    </div>
                `
            }
        });

        // Trigger pencarian ulang jika input filter diubah
        $('#filter_tgl_awal, #filter_tgl_akhir, #filter_dokter, #filter_penjamin, #filter_pemeriksaan').on('change', function() {
            table.draw();
        });

        $('#filter_search').on('keyup', function() {
            table.draw();
        });

        $('#button-refresh-data').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            $('#filter_tgl_awal').val(today);
            $('#filter_tgl_akhir').val(today);
            $('#filter_search').val('');
            $('#filter_dokter').val('');
            $('#filter_penjamin').val('');
            $('#filter_pemeriksaan').val('');
            table.draw();
        });
    });

    // LOGIKA CETAK BARCODE
    $(document).on("click", ".btn-modal-barcode", function(e) {
        e.preventDefault();
        const regId = $(this).data("regid");

        const modalBarcode = new bootstrap.Modal(document.getElementById('modalCetakBarcode'));
        modalBarcode.show();

        const tbody = document.getElementById('tbody-barcode-list');
        tbody.innerHTML = '';
        document.getElementById('loading-barcode-spinner').style.display = 'block';
        document.getElementById('check-all-barcode').checked = false;
        updateCountBarcodeSelected();

        fetch(`/pelayanan/get-specimen-barcode/${regId}`)
            .then(res => res.json())
            .then(response => {
                document.getElementById('loading-barcode-spinner').style.display = 'none';
                if (response.success && response.data.length > 0) {
                    response.data.forEach(item => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>
                                <input type="checkbox" class="form-check-input check-barcode-item" value="${item.barcode}" data-code="${item.detail_id}" onchange="updateCountBarcodeSelected()">
                            </td>
                            <td>${item.specimen}</td>
                            <td>${item.barcode}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-barcode-print-item" onclick="cetakSingleBarcode('${item.detail_id}', '${item.barcode}', '${regId}')">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data spesimen.</td></tr>`;
                }
            })
            .catch(err => {
                document.getElementById('loading-barcode-spinner').style.display = 'none';
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-danger py-3">Gagal memuat data spesimen.</td></tr>`;
            });
    });

    $(document).ready(function() {
        // Inisialisasi Select2 tanpa placeholder agar tidak bertabrakan dengan floating label
        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });

        // Load data filter pertama kali
        loadFilterOptions();

        // Trigger DataTables saat tanggal berubah
        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            loadFilterOptions();
            table.draw();
        });

        // Trigger DataTables saat opsi select2 berubah
        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').on('change', function() {
            table.draw();
        });

        $('#filter_search').on('keyup', function() {
            table.draw();
        });

        $('#button-refresh-data').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            $('#filter_tgl_awal').val(today);
            $('#filter_tgl_akhir').val(today);
            $('#filter_search').val('');

            $('#filter_dokter').val('').trigger('change.select2');
            $('#filter_penjamin').val('').trigger('change.select2');
            $('#filter_pemeriksaan').val('').trigger('change.select2');

            loadFilterOptions();
            table.draw();
        });
    });

    function loadFilterOptions() {
        const tglAwal = $('#filter_tgl_awal').val();
        const tglAkhir = $('#filter_tgl_akhir').val();

        fetch(`/pelayanan/get-filter-options?tgl1=${tglAwal}&tgl2=${tglAkhir}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // 1. Update Dropdown Dokter
                    const $dokter = $('#filter_dokter');
                    const selectedDokter = $dokter.val();
                    $dokter.empty().append('<option value="">Semua Dokter</option>');
                    data.dokter.forEach(d => {
                        $dokter.append(new Option(d, d, false, d === selectedDokter));
                    });
                    $dokter.trigger('change.select2'); // Refresh tampilan Select2

                    // 2. Update Dropdown Penjamin
                    const $penjamin = $('#filter_penjamin');
                    const selectedPenjamin = $penjamin.val();
                    $penjamin.empty().append('<option value="">Semua Kelompok</option>');
                    data.penjamin.forEach(p => {
                        $penjamin.append(new Option(p, p, false, p === selectedPenjamin));
                    });
                    $penjamin.trigger('change.select2'); // Refresh tampilan Select2

                    // 3. Update Dropdown Pemeriksaan
                    const $pemeriksaan = $('#filter_pemeriksaan');
                    const selectedPemeriksaan = $pemeriksaan.val();
                    $pemeriksaan.empty().append('<option value="">Semua Pemeriksaan</option>');
                    data.pemeriksaan.forEach(item => {
                        $pemeriksaan.append(new Option(item.nama_layanan, item.id, false, item.id == selectedPemeriksaan));
                    });
                    $pemeriksaan.trigger('change.select2'); // Refresh tampilan Select2
                }
            })
            .catch(err => console.error("Gagal memuat opsi filter:", err));
    }

    $(document).ready(function() {
        // Muat pilihan filter saat pertama kali halaman dibuka
        loadFilterOptions();

        // Panggil ulang loadFilterOptions() saat tanggal berubah
        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            loadFilterOptions();
            table.draw();
        });

        // Trigger filter lainnya tanpa meretoload dropdown
        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').on('change', function() {
            table.draw();
        });

        $('#filter_search').on('keyup', function() {
            table.draw();
        });

        $('#button-refresh-data').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            $('#filter_tgl_awal').val(today);
            $('#filter_tgl_akhir').val(today);
            $('#filter_search').val('');
            $('#filter_dokter').val('');
            $('#filter_penjamin').val('');
            $('#filter_pemeriksaan').val('');

            loadFilterOptions();
            table.draw();
        });
    });

    function toggleSelectAllBarcode(checkbox) {
        const checkboxes = document.querySelectorAll('.check-barcode-item');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
        updateCountBarcodeSelected();
    }

    function updateCountBarcodeSelected() {
        const selected = document.querySelectorAll('.check-barcode-item:checked');
        document.getElementById('count-selected-barcode').innerText = selected.length;
    }

    function cetakSingleBarcode(code, barcode, regId) {
        const url = `/pelayanan/specimen-collection/print-barcode?code=${code}&specimen=${barcode}&reg=${regId}`;
        window.open(url, '_blank', 'width=400,height=300');
    }

    function cetakTerpilihBarcode() {
        const selected = document.querySelectorAll('.check-barcode-item:checked');
        if (selected.length === 0) {
            alert("Silakan pilih minimal satu spesimen untuk dicetak!");
            return;
        }

        selected.forEach(cb => {
            const barcode = cb.value;
            const code = cb.getAttribute('data-code');
            const url = `/pelayanan/specimen-collection/print-barcode?code=${code}&specimen=${barcode}`;
            window.open(url, '_blank', 'width=400,height=300');
        });
    }

    function cetakRoboBarcode() {
        const allCheckboxes = document.querySelectorAll('.check-barcode-item');
        if (allCheckboxes.length === 0) return;

        allCheckboxes.forEach(cb => {
            const barcode = cb.value;
            const code = cb.getAttribute('data-code');
            const url = `/pelayanan/specimen-collection/print-barcode?code=${code}&specimen=${barcode}`;
            window.open(url, '_blank', 'width=400,height=300');
        });
    }

    // Modal Riwayat Pasien
    $(document).on("click", ".button-data-history-pasien", function(e) {
        e.preventDefault();
        const code = $(this).data("code");

        $('#menu-registrasi').html(`
            <div class="custom-loader py-5">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <span class="fw-bold text-secondary small">Memuat riwayat pasien...</span>
            </div>
        `);

        fetch("{{ route('data_registrasi_history') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: new URLSearchParams({
                    "code": code
                })
            })
            .then(response => response.text())
            .then(html => {
                $('#menu-registrasi').html(html);
            })
            .catch(error => {
                $('#menu-registrasi').html(`
                    <div class="alert alert-danger m-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Gagal memuat data riwayat pasien.
                    </div>
                `);
            });
    });
</script>
@endsection
