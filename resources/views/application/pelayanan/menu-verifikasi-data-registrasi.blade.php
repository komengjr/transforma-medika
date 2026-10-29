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
        background-color: #f1f5f9 !important;
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

    /* Floating Field Filter Style */
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
        z-index: 5 !important;
        background: transparent !important;
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

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: #212529 !important;
        padding-left: 4px !important;
        line-height: 1.5 !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 6px !important;
    }
</style>
@endsection

@section('content')
<!-- HEADER HERO BANNER -->
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
                                <i class="fas fa-user-shield me-1"></i> Verifikasi Data Pasien
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD -->
<div class="card card-modern mb-4">
    <div class="card-header bg-white border-bottom border-light py-3 px-3 rounded-top-4">
        <div class="row align-items-center g-2">
            <!-- TOMBOL AKSI UTAMA -->
            <div class="col-12 col-md-auto d-flex align-items-center justify-content-between gap-2">
                <button class="btn btn-sm btn-primary rounded-3 px-3 py-2 d-flex align-items-center gap-1" style="height: 42px;"
                    type="button" id="button-refresh-data" data-bs-toggle="tooltip" title="Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-semibold ms-1">Refresh Data</span>
                </button>

                <button class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-2 d-md-none d-flex align-items-center gap-1" style="height: 42px;"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterMobile">
                    <i class="fas fa-filter text-primary"></i>
                    <span class="fw-semibold">Filter</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>

            <!-- CONTAINER DERETAN FILTER -->
            <div class="col-12 col-md collapse d-md-block" id="collapseFilterMobile">
                <div class="row g-2 align-items-center mt-2 mt-md-0 pt-2 pt-md-0 border-top border-md-0">
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Awal</label>
                            <input type="text" class="form-control datetimepicker" id="filter_tgl_awal" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker" id="filter_tgl_akhir" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>No Reg / Nama</label>
                            <input type="text" class="form-control" id="filter_search" placeholder="Cari Reg/Nama...">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Dokter</label>
                            <select class="form-select" id="filter_dokter">
                                <option value="">Semua Dokter</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Kel. Pelanggan</label>
                            <select class="form-select" id="filter_penjamin">
                                <option value="">Semua Kelompok</option>
                            </select>
                        </div>
                    </div>
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

<!-- MODAL VERIFIKASI DATA -->
<div class="modal fade" id="modal-registrasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-registrasi"></div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let table;

    $(document).ready(function() {
        // Inisialisasi DataTable untuk Verifikasi Registrasi
        table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('data_verifikasi_registrasi_table') }}",
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
                searchPlaceholder: "🔍 Cari nama, RM, atau No Reg...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ pasien",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                },
                processing: `<div class="custom-loader"><div class="spinner-border text-primary mb-2" role="status"></div><span class="fw-bold text-primary small">Memuat data...</span></div>`
            }
        });

        // Inisialisasi Select2
        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true
        });
        loadFilterOptions();

        // Trigger Event Filter
        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            loadFilterOptions();
            table.draw();
        });
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

    // Mengambil Filter Opsi dinamis menggunakan route yang sama dengan list pasien
    function loadFilterOptions() {
        const tglAwal = $('#filter_tgl_awal').val();
        const tglAkhir = $('#filter_tgl_akhir').val();

        fetch(`/pelayanan/get-filter-options?tgl1=${tglAwal}&tgl2=${tglAkhir}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const $dokter = $('#filter_dokter'),
                        selectedDokter = $dokter.val();
                    $dokter.empty().append('<option value="">Semua Dokter</option>');
                    data.dokter.forEach(d => $dokter.append(new Option(d, d, false, d === selectedDokter)));
                    $dokter.trigger('change.select2');

                    const $penjamin = $('#filter_penjamin'),
                        selectedPenjamin = $penjamin.val();
                    $penjamin.empty().append('<option value="">Semua Kelompok</option>');
                    data.penjamin.forEach(p => $penjamin.append(new Option(p, p, false, p === selectedPenjamin)));
                    $penjamin.trigger('change.select2');

                    const $pemeriksaan = $('#filter_pemeriksaan'),
                        selectedPemeriksaan = $pemeriksaan.val();
                    $pemeriksaan.empty().append('<option value="">Semua Pemeriksaan</option>');
                    data.pemeriksaan.forEach(item => $pemeriksaan.append(new Option(item.nama_layanan, item.id, false, item.id == selectedPemeriksaan)));
                    $pemeriksaan.trigger('change.select2');
                }
            }).catch(err => console.error(err));
    }

    // =====================================
    // LOGIKA TOMBOL VERIFIKASI & PEMBATALAN
    // =====================================

    // Aksi Verifikasi Data
    $(document).on("click", ".button-verifikasi-data", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-registrasi').html(
            '<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-muted fs--1">Memuat data registrasi...</p></div>'
        );
        $.ajax({
            url: "{{ route('menu_pelayanan_verifikasi_registrasi_data') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi').html(data);
        }).fail(function() {
            $('#menu-registrasi').html('<div class="alert alert-danger m-3">Terjadi kesalahan saat memuat data.</div>');
        });
    });

    // Aksi Pembatalan Registrasi dengan Input Alasan
    $(document).on("click", ".button-batal-registrasi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-danger px-4 rounded-pill ms-2",
                cancelButton: "btn btn-light px-4 rounded-pill"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "Batalkan Registrasi?",
            text: "Silakan masukkan alasan pembatalan. Tindakan ini tidak dapat dikembalikan!",
            icon: "warning",
            input: 'textarea',
            inputPlaceholder: 'Ketik alasan pembatalan di sini...',
            inputAttributes: {
                'aria-label': 'Ketik alasan pembatalan di sini'
            },
            showCancelButton: true,
            confirmButtonText: "Ya, Batalkan!",
            cancelButtonText: "Tutup",
            reverseButtons: true,
            preConfirm: (alasan) => {
                if (!alasan || alasan.trim() === "") {
                    Swal.showValidationMessage('Alasan pembatalan wajib diisi!');
                }
                return alasan;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Menangkap input alasan dari user
                const alasanBatal = result.value;

                $.ajax({
                    url: "{{ route('menu_pelayanan_verifikasi_pembatalan_registrasi') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                        "alasan": alasanBatal // Mengirim alasan ke controller
                    },
                    dataType: 'html',
                }).done(function(data) {
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Registrasi telah dibatalkan.",
                        icon: "success"
                    });
                    table.draw(); // Refresh tabel setelah batal
                }).fail(function() {
                    swalWithBootstrapButtons.fire({
                        title: "Gagal",
                        text: "Terjadi kesalahan sistem saat membatalkan.",
                        icon: "error"
                    });
                });
            }
        });
    });
</script>
@endsection
