@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Modern Compact Palette */


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
        /* Ukuran Judul Lebih Ringkas */
    }

    /* Card Custom */
    .card-modern {
        border: none;
        border-radius: 12px;
        /* background: #ffffff; */
        /* box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04); */
    }

    /* Table Styling Compact */
    .table-custom {
        /* border-collapse: separate; */
        border-spacing: 10px 15px;
        /* Jarak antar baris diperkecil */
        font-size: 0.8rem;
        /* Font dasar tabel diturunkan */
    }

    .table-custom thead th {
        background: #f8fbfc;
        color: #0d0d0d;
        font-size: 0.68rem;
        /* Font Header Tabel Lebih Kecil */
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        padding: 18px 12px;
        /* Padding header diperkecil */
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
        /* Padding cell diperkecil dari 14px ke 8px */
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-custom td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-left: 1px solid #f1f5f9;
    }

    .table-custom td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        border-right: 1px solid #f1f5f9;
    }

    /* Avatar Patient Compact */
    .avatar-patient {
        width: 32px;
        /* Dikecilkan dari 42px */
        height: 32px;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: #ffffff;
        font-weight: 700;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }

    /* Badges & Pills Compact */
    .badge-reg-code {
        background: rgba(59, 130, 246, 0.08);
        color: #2563eb;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.72rem;
        /* Diperkecil dari 0.8rem */
        display: inline-block;
    }

    .layanan-pill {
        font-size: 0.68rem;
        /* Diperkecil */
        padding: 2px 8px;
        border-radius: 12px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #16a34a;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-gradient-primary {
        background: var(--primary-gradient);
        color: #fff;
        border: none;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
    }

    .custom-loader {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 0;
    }
</style>
@endsection

@section('content')
<!-- HEADER HERO BANNER VIBRANT -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #1f6f92 0%, #203a43 50%, #2c5364 100%);">

            <!-- Hiasan Blur Glowing Circle -->
            <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl"
                style="width: 250px; height: 250px; top: -80px; right: 10%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle bg-info opacity-25 blur-3xl"
                style="width: 200px; height: 200px; bottom: -80px; left: -50px; filter: blur(50px);"></div>

            <div class="card-body p-4 text-white position-relative z-1">
                <div class="row align-items-center gy-3">

                    <!-- Brand & App Label -->
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

                    <!-- Module Badge / Quick Nav -->
                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <!-- <span class="text-white-50 text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Module Aktif</span> -->
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <!-- <span class="p-1 bg-success rounded-circle me-2 animate-pulse" style="width: 8px; height: 8px;"></span> -->
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
<div class="card card-modern mb-4">
    <div class="card-header bg-400 border-bottom border-light py-3 px-4 rounded-top-4">
        <div class="row align-items-center justify-content-between g-3">
            <div class="col-auto d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-primary rounded-3 px-3 py-2 d-flex align-items-center gap-1"
                    type="button" id="button-refresh-data" data-bs-toggle="tooltip" title="Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-none d-sm-inline fw-semibold ms-1">Refresh Data</span>
                </button>

                <button class="btn btn-sm btn-light border text-secondary rounded-3 px-3 py-2 d-flex align-items-center gap-1"
                    type="button" onclick="window.print()" data-bs-toggle="tooltip" title="Cetak List Pasien">
                    <i class="fas fa-print text-danger"></i>
                    <span class="d-none d-sm-inline fw-semibold ms-1">Cetak</span>
                </button>
            </div>

            <!-- Filter Date Range -->
            <div class="col-auto">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white bg-opacity-10 border-0 text-primary fw-bold">
                        <i class="fas fa-calendar-day"></i>
                    </span>
                    <input class="form-control form-control-lg datetimepicker bg-light border-0 fw-semibold text-secondary"
                        id="timepicker3"
                        type="text"
                        placeholder="Filter Rentang Tanggal..."
                        style="min-width: 240px; border-radius: 0 8px 8px 0;"
                        data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true,"locale":"en"}' />
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="example" class="table table-custom align-middle mb-0" style="width:100%">
                <thead class="bg-primary">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="18%">No. Registrasi & Petugas</th>
                        <th width="22%">Nama Pasien</th>
                        <th width="18%">Tempat, Tgl Lahir</th>
                        <th width="12%">Kategori Pasien</th>
                        <th width="15%">Layanan</th>
                        <th width="10%">Tanggal Reg</th>
                        <th width="5%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS -->
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

<!-- SCRIPTS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>

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
                    const dateRange = $('#timepicker3').val();
                    if (dateRange && dateRange.length >= 24) {
                        d.tgl1 = dateRange.substring(0, 10);
                        d.tgl2 = dateRange.substring(14, 24);
                    }
                }
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    className: 'text-center fw-bold text-secondary'
                },
                {
                    data: 'no_reg',
                    name: 'no_reg'
                },
                {
                    data: 'pasien',
                    name: 'pasien'
                },
                {
                    data: 'ttl',
                    name: 'ttl'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'layanan',
                    name: 'layanan',
                    orderable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
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

        $('#timepicker3').on('change', function() {
            table.draw();
        });

        $('#button-refresh-data').on('click', function(e) {
            e.preventDefault();
            $('#timepicker3').val('');
            table.draw();
        });
    });

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
            .then(response => {
                if (!response.ok) throw new Error('Network response failure');
                return response.text();
            })
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
