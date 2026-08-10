@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    /* Modern Glassmorphism & Card Styling */
    .header-card-gradient {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        border-radius: 20px !important;
        box-shadow: 0 10px 25px rgba(2, 132, 199, 0.2);
        position: relative;
        overflow: hidden;
    }

    .header-card-gradient::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .filter-card {
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        border-radius: 20px !important;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
    }

    .form-label-custom {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 6px;
    }

    .btn-search-custom {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        border: none;
        color: #ffffff;
        font-weight: 600;
        border-radius: 12px;
        padding: 10px 24px;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
        transition: all 0.3s ease;
    }

    .btn-search-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(2, 132, 199, 0.35);
        color: #ffffff;
    }

    /* Custom Loading Spinner Container */
    .loading-container {
        padding: 3rem 1.5rem;
        text-align: center;
    }

    .custom-spinner {
        width: 3rem;
        height: 3rem;
        border-width: 0.25em;
        color: #0284c7;
    }
</style>
@endsection

@section('content')
<!-- Banner Header Section -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card header-card-gradient border-0 text-white">
            <div class="card-body p-3 p-md-4">
                <div class="row align-items-center justify-content-between g-3">
                    <div class="col-auto d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-3 me-3 d-flex align-items-center justify-content-center" style="backdrop-filter: blur(8px);">
                            <img src="{{ asset('img/app.png') }}" alt="App Logo" width="45" height="45" class="object-fit-contain" />
                        </div>
                        <div>
                            <span class="badge bg-white bg-opacity-20 text-dark rounded-pill px-3 py-1 mb-1 fs--2 fw-semibold">Innoventra System</span>
                            <h4 class="text-white fw-bold mb-0">Management Dashboard</h4>
                        </div>
                    </div>
                    <div class="col-auto text-sm-end border-start-sm border-white border-opacity-20 ps-sm-4">
                        <div class="text-white-50 fs--1 fw-medium">Modul Halaman</div>
                        <h5 class="text-white fw-bold mb-0">Data Absensi Staff</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Form Section -->
<div class="card filter-card mb-3">
    <div class="card-body p-3 p-md-4">
        <form class="row g-3 align-items-end needs-validation" novalidate="">
            <!-- Choice Select Nama Staff -->
            <div class="col-md-4 position-relative">
                <label class="form-label-custom d-flex align-items-center">
                    <i class="fas fa-user-circle me-1 text-primary"></i> Nama Staff
                </label>
                <select class="form-select js-choice" id="data_nama" size="1" name="data_nama"
                    data-options='{"removeItemButton":true,"placeholder":true,"itemSelectText":""}'>
                    <option value="">Pilih Nama Staff...</option>
                    @if(isset($staffs))
                    @foreach($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                    @else
                    <option value="1">Massachusetts Institute</option>
                    <option value="2">University of Chicago</option>
                    @endif
                </select>
            </div>

            <!-- Select Bulan -->
            <div class="col-md-3 position-relative">
                <label class="form-label-custom d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-1 text-primary"></i> Bulan
                </label>
                <select class="form-select" id="data_bulan" name="data_bulan">
                    <option value="">Pilih Bulan...</option>
                    @php
                    $bulanList = [
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                    ];
                    $currentMonth = date('m');
                    @endphp
                    @foreach($bulanList as $key => $val)
                    <option value="{{ $key }}" {{ $key == $currentMonth ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Select Tahun -->
            <div class="col-md-3 position-relative">
                <label class="form-label-custom d-flex align-items-center">
                    <i class="fas fa-calendar-check me-1 text-primary"></i> Tahun
                </label>
                <select class="form-select" id="data_tahun" name="data_tahun">
                    <option value="">Pilih Tahun...</option>
                    @php
                    $currentYear = date('Y');
                    $startYear = $currentYear - 3;
                    $endYear = $currentYear + 1;
                    @endphp
                    @for($y = $endYear; $y >= $startYear; $y--)
                    <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <!-- Search Button -->
            <div class="col-md-2 text-end">
                <button class="btn btn-search-custom w-100 d-flex align-items-center justify-content-center gap-2" type="button" id="button-search-data">
                    <i class="fas fa-search"></i>
                    <span>Cari Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Result Data Section -->
<div class="card filter-card overflow-hidden" id="menu-general-ledger">
    <!-- Default State Preview / Result will be injected here -->
    <div class="text-center py-5 text-muted">
        <i class="fas fa-filter fs-3 mb-2 text-300"></i>
        <p class="mb-0 fs--1">Silakan pilih bulan dan tahun lalu klik tombol <strong>Cari Data</strong> untuk menampilkan rekap absensi.</p>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on("click", "#button-search-data", function(e) {
        e.preventDefault();
        var nama = document.getElementById("data_nama").value;
        var bulan = document.getElementById("data_bulan").value;
        var tahun = document.getElementById("data_tahun").value;

        // Validasi Bulan dan Tahun
        if (bulan == "" || bulan == null) {
            Swal.fire({
                icon: "warning",
                title: "Bulan Belum Dipilih",
                text: "Mohon pilih bulan terlebih dahulu sebelum melakukan pencarian.",
                confirmButtonColor: "#0284c7"
            });
            return;
        }

        if (tahun == "" || tahun == null) {
            Swal.fire({
                icon: "warning",
                title: "Tahun Belum Dipilih",
                text: "Mohon pilih tahun terlebih dahulu sebelum melakukan pencarian.",
                confirmButtonColor: "#0284c7"
            });
            return;
        }

        // Tampilkan Indicator Loading Modern
        $('#menu-general-ledger').html(
            '<div class="loading-container">' +
            '<div class="spinner-border custom-spinner mb-3" role="status"></div>' +
            '<h6 class="fw-bold text-secondary mb-1">Memuat Data Absensi...</h6>' +
            '<p class="fs--1 text-muted mb-0">Mohon tunggu sebentar, sistem sedang mengambil data.</p>' +
            '</div>'
        );

        // AJAX Request
        $.ajax({
            url: "{{ route('data_kehadiran_search') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "nama": nama,
                "bulan": bulan,
                "tahun": tahun
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-general-ledger').html(data);
        }).fail(function() {
            $('#menu-general-ledger').html(
                '<div class="text-center py-5 text-danger">' +
                '<i class="fas fa-exclamation-triangle fs-2 mb-2"></i>' +
                '<p class="mb-0 fw-semibold">Gagal memuat data. Silakan coba beberapa saat lagi.</p>' +
                '</div>'
            );
        });
    });
</script>
@endsection
