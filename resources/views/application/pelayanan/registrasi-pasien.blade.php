@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<!-- BANNER HEADER ATAS -->
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
                                <i class="fas fa-user-plus me-1"></i> Registrasi Pasien
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECTION KONTEN UTAMA & QUICK METRICS -->
<div class="row g-3 mb-4 ">

    <!-- KOLOM KIRI: Stat & Quick Actions -->
    <div class="col-lg-7 ">
        <div class="card border border-primary shadow-sm rounded-4 overflow-hidden h-100 bg-body">

            <!-- Hero Greeting Card -->
            <div class="p-4 position-relative bg-body-tertiary border-bottom border-subtle overflow-hidden">
                <img class="position-absolute d-none d-md-block opacity-25"
                    src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}"
                    alt="chart" style="right: -10px; top: -10px; width: 140px; pointer-events: none;" />

                <div class="position-relative z-1">
                    <h4 class="fw-bold text-dark mb-1" style="font-size: 1.25rem;">
                        Selamat Datang, <span class="text-dark text-gradient">{{ Auth::user()->fullname }}</span>! 👋
                    </h4>
                    <p class="text-body-secondary mb-3" style="font-size: 0.82rem;">
                        Kelola antrian dan kelengkapan data pasien hari ini secara real-time.
                    </p>

                    <!-- Metrics Stat Boxes -->
                    <div class="row g-2">
                        <!-- Order Selesai -->
                        <div class="col-6">
                            <div class="p-3 rounded-4 bg-success-subtle border border-success position-relative overflow-hidden transition-all hover-lift">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-success fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Order Selesai</span>
                                        <h3 class="text-success fw-extrabold mb-0" style="font-size: 1.5rem;">
                                            {{$total - $reject}} <span class="fs-0 fw-semibold text-success opacity-75" style="font-size: 0.85rem;">Order</span>
                                        </h3>
                                    </div>
                                    <div class="p-2 bg-success text-white rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-check-circle fs-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Batal -->
                        <div class="col-6">
                            <div class="p-3 rounded-4 bg-danger-subtle border border-danger position-relative overflow-hidden transition-all hover-lift">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-danger fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Order Batal</span>
                                        <h3 class="text-danger fw-extrabold mb-0" style="font-size: 1.5rem;">
                                            {{$reject}} <span class="fs-0 fw-semibold text-danger opacity-75" style="font-size: 0.85rem;">Order</span>
                                        </h3>
                                    </div>
                                    <div class="p-2 bg-danger text-white rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-times-circle fs-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Quick Action List Group -->
            <div class="card-body p-0">
                <div class="list-group list-group-flush">

                    <!-- Item 1: Registrasi -->
                    <div class="list-group-item p-3 border-0 border-bottom border d-flex align-items-center justify-content-between bg-body transition-all hover-bg-tertiary">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-primary bg-opacity-10 p-2 me-3 d-flex align-items-center justify-content-center border border-primary border-opacity-10" style="width: 45px; height: 45px;">
                                <i class="fas fa-user-plus text-white fs-2"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-body" style="font-size: 0.88rem;">{{$total}} Order Pasien Hari Ini</h6>
                                <span class="text-body-secondary" style="font-size: 0.75rem;">Siap untuk alur pendaftaran pasien baru</span>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm fw-bold transition-all" id="button-registrasi-pasien"
                            data-bs-toggle="modal" data-bs-target="#modal-registrasi" style="font-size: 0.78rem;">
                            <i class="fas fa-registered me-1"></i> Registrasi
                        </button>
                    </div>

                    <!-- Item 2: Panggil Antrian -->
                    <div class="list-group-item p-3 border-0 border-bottom border-subtle d-flex align-items-center justify-content-between bg-body transition-all hover-bg-tertiary">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-warning bg-opacity-10 p-2 me-3 d-flex align-items-center justify-content-center border border-warning border-opacity-10" style="width: 45px; height: 45px;">
                                <i class="fas fa-bullhorn text-white fs-2"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-body" style="font-size: 0.88rem;">7 Orders Belum Bayar</h6>
                                <span class="text-body-secondary" style="font-size: 0.75rem;">Menunggu instruksi panggilan antrian kasir</span>
                            </div>
                        </div>
                        <button class="btn btn-warning btn-sm text-dark rounded-pill px-3 shadow-sm fw-bold transition-all"
                            data-bs-toggle="modal" data-bs-target="#modal-registrasi-xl" id="button-call-antrian" style="font-size: 0.78rem;">
                            <i class="fas fa-satellite-dish me-1"></i> Panggil Antrian
                        </button>
                    </div>

                    <!-- Item 3: Tutup Pendaftaran -->
                    <div class="list-group-item p-3 border-0 d-flex align-items-center justify-content-between bg-body transition-all hover-bg-tertiary">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-danger bg-opacity-10 p-2 me-3 d-flex align-items-center justify-content-center border border-danger border-opacity-10" style="width: 45px; height: 45px;">
                                <i class="fas fa-power-off text-white fs-2"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-body" style="font-size: 0.88rem;">{{$total}} Orders Semua Pasien</h6>
                                <span class="text-body-secondary" style="font-size: 0.75rem;">Kunci & selesaikan registrasi hari ini</span>
                            </div>
                        </div>
                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold transition-all" style="font-size: 0.78rem;">
                            <i class="fas fa-lock me-1"></i> Tutup Pendaftaran
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- KOLOM KANAN: Activity Log Card -->
    <div class="col-lg-5">
        <div class="card border border-primary shadow-sm rounded-4 overflow-hidden h-100 bg-body">
            <!-- Log Header -->
            <div class="card-header bg-body border-bottom border-subtle p-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-info bg-opacity-10 rounded-3 me-2 border border-info border-opacity-10">
                        <i class="fas fa-stream text-white"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-body" style="font-size: 0.92rem;">Activity Log</h6>
                </div>
                <a class="btn btn-xs btn-light border border-subtle rounded-pill text-primary fw-bold px-3" href="#" style="font-size: 0.72rem;">View All</a>
            </div>

            <!-- Log Content List -->
            <div class="card-body p-3 overflow-auto" style="max-height: 380px;">
                <div class="timeline-simple">
                    @foreach ($data as $datas)
                    <div class="d-flex align-items-start mb-3 pb-2 border-bottom border-subtle">
                        <div class="avatar-container me-3 flex-shrink-0">
                            <div class="bg-body-tertiary border border-subtle rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-size: 1.1rem;">
                                📋
                            </div>
                        </div>
                        <div class="flex-grow-1" style="font-size: 0.8rem;">
                            <p class="mb-1 text-body lh-sm">
                                <strong class="text-body fw-bold">{{$datas->master_patient_name}}</strong>
                                terdaftar pada <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2">{{ $datas->t_pasien_cat_name }}</span>
                            </p>
                            <div class="d-flex align-items-center text-body-secondary" style="font-size: 0.72rem;">
                                <i class="fas fa-hashtag me-1 opacity-75"></i><strong class="me-2 opacity-75">{{ $datas->d_reg_order_code }}</strong>
                                <i class="fas fa-clock me-1 ms-auto opacity-75"></i> {{ $datas->created_at }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Dummy Event Item -->
                    <div class="d-flex align-items-start pt-1">
                        <div class="avatar-container me-3 flex-shrink-0">
                            <div class="bg-body-tertiary border border-subtle rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-size: 1.1rem;">
                                📅
                            </div>
                        </div>
                        <div class="flex-grow-1" style="font-size: 0.8rem;">
                            <p class="mb-1 text-body lh-sm">
                                <strong>Massachusetts Institute of Technology</strong> invited <strong>Anthony Hopkin</strong> to an event
                            </p>
                            <span class="text-body-secondary d-block" style="font-size: 0.72rem;"><i class="fas fa-clock me-1 opacity-75"></i> October 28, 12:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-registrasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1" id="button-close-registrasi">
                <button class="btn-close  btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <div id="menu-registrasi"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-registrasi-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-registrasi-xl"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-registrasi-pasien", function(e) {
        e.preventDefault();
        // var code = $(this).data("code");
        $('#menu-registrasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi').html(data);
        }).fail(function() {
            $('#menu-registrasi').html('eror');
        });
    });
    $(document).on("click", "#button-create-data-pasien", function(e) {
        e.preventDefault();
        // var code = $(this).data("code");
        $('#menu-registrasi-pasien').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_create') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi-pasien').html(data);
        }).fail(function() {
            $('#menu-registrasi-pasien').html('eror');
        });
    });
    $(document).on("click", "#button-scan-data-pasien", function(e) {
        e.preventDefault();
        // var code = $(this).data("code");
        $('#menu-registrasi-pasien').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_reader_passport') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi-pasien').html(data);
        }).fail(function() {
            $('#menu-registrasi-pasien').html('eror');
        });
    });
    $(document).on("click", "#button-cari-data-pasien", function(e) {
        e.preventDefault();
        var data = $("#form-registrasi-pasien").serialize();
        var pencarian = document.getElementById('option_nama').value;
        if (pencarian == "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Pencarian Tidak Boleh Kosong",
                // footer: '<a href="#">Why do I have this issue?</a>'
            });
        } else {
            $('#menu-registrasi-pasien').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('registrasi_pasien_cari_data_pasien') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function(data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Pilih dulu Optional Pencarian",
                        // footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    $('#menu-registrasi-pasien').html(data);
                }
            }).fail(function() {
                $('#menu-registrasi-pasien').html('eror');
            });
        }
    });
    $(document).on("click", "#button-save-create-pasien-baru", function(e) {
        e.preventDefault();
        var data = $("#form-create-pasien-baru").serialize();
        var nama = document.getElementById("nama_lengkap").value;
        var nik = document.getElementById("nik").value;
        var jk = document.getElementById("jenis_kelamin").value;
        var tgl = document.getElementById("tgl_lahir").value;
        var agama = document.getElementById("agama").value;
        var no_hp = document.getElementById("no_hp").value;
        var lokasi = document.getElementById("data_city").value;
        if (nama == '' || nik == '' || jk == '' || tgl == '' || agama == '' || no_hp == '') {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Data Sudah Terisi'
            });
        } else {
            $('#menu-registrasi-pasien').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('registrasi_pasien_create_save') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function(data) {
                if (data == 1) {
                    Lobibox.notify('success', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: true,
                        position: 'top right',
                        icon: 'fas fa-info-circle',
                        msg: 'Berhasil Create Pasien'
                    });
                    $('#menu-registrasi-pasien').html(data);
                } else {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: true,
                        position: 'top right',
                        icon: 'fas fa-info-circle',
                        msg: 'Data NIK Sudah ada'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            }).fail(function() {
                $('#menu-registrasi-pasien').html('eror');
            });
        }
    });
    $(document).on("click", "#button-pilih-data-pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-registrasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien') }}",
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
            $('#menu-registrasi').html('eror');
        });
    });
    // FASILITAS LAYANAN
    $(document).on("click", "#button-pilih-kebutuhan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-falcon-success",
                cancelButton: "btn btn-falcon-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Apakah kamu Yakin ?",
            text: "Pastikan Data Pasien Sudah Benar!",
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            cancelButtonText: "No, Batal!",
            confirmButtonText: "Yes, Yakin!",
        }).then((result) => {
            if (result.isConfirmed) {
                $('#menu-kebutuhan-registrasi').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                }).done(function(data) {
                    $('#menu-kebutuhan-registrasi').html(data);
                    document.getElementById("menu-fasilitas-layanan").style.display = "block";
                    document.getElementById("button-pilih-kebutuhan").style.display = "none";
                    document.getElementById("pill-profile-tab").click();
                }).fail(function() {
                    $('#menu-kebutuhan-registrasi').html('eror');
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your imaginary file is safe :)",
                    icon: "error"
                });
            }
        });
    });
    $(document).on("click", "#button-pilih-dokter-poliklinik", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var tgl = document.getElementById("tanggal_periksa").value;
        $('#menu-pilihan-dokter-poli').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_dokter') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "tgl": tgl,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-pilihan-dokter-poli').html(data);
        }).fail(function() {
            $('#menu-pilihan-dokter-poli').html('eror');
        });
    });
    $(document).on("click", "#button-fix-print-registrasi-poli", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var date = $(this).data("date");
        var layanan = $(this).data("layanan");
        var no_reg = document.getElementById("no_registrasi").value;
        var no_rm = document.getElementById("no_rm").value;
        var cat = document.getElementById("kategori").value;
        var data_link = document.getElementById("link_penunjang").value;
        var data_penunjang = document.getElementById("data_penunjang").value;
        // $('#menu-pilihan-dokter-poli').html(
        //     '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        // );
        console.log(code);
        console.log(date);
        console.log(no_reg);
        console.log(no_rm);
        console.log(layanan);
        console.log(layanan);

        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_poli') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "date": date,
                "layanan": layanan,
                "no_reg": no_reg,
                "no_rm": no_rm,
                "cat": cat,
                "data_link": data_link,
                "data_penunjang": data_penunjang
            },
            dataType: 'html',
        }).done(function(data) {
            // $('#menu-pilihan-dokter-poli').html(data);
            document.getElementById("menu-fasilitas-layanan").disabled = true;
            document.getElementById("menu-cetak-data-registrasi").style.display = "block";
            document.getElementById("pill-contact-tab").click();
            document.getElementById("button-pilih-end-proses").click();
        }).fail(function() {
            // $('#menu-pilihan-dokter-poli').html('eror');
        });
    });
    $(document).on("click", "#button-pilih-end-proses", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var id = $(this).data("id");
        $('#menu-invoice-registrasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_end_proses') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "id": id,
            },
            dataType: 'html',
        }).done(function(data) {
            document.getElementById("menu-fasilitas-layanan").style.display = "none";
            document.getElementById("button-close-registrasi").style.display = "none";
            setTimeout(() => {
                $('#menu-invoice-registrasi').html(data);
                Lobibox.notify('success', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-info-circle',
                    msg: 'Berhasil Daftar Registrasi'
                });
            }, 3000);
        }).fail(function() {
            $('#menu-invoice-registrasi').html('eror');
        });
    });
    $(document).on("click", "#button-preview-registrasi-pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-preview-registrasi-pasien').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_preview_pdf') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
            },
            dataType: 'html',
        }).done(function(data) {
            setTimeout(() => {
                $('#menu-preview-registrasi-pasien').html(
                    '<iframe src="data:application/pdf;base64, ' +
                    data +
                    '" style="width:100%; height:533px;" frameborder="0"></iframe>');
            }, 500);
        }).fail(function() {
            $('#menu-preview-registrasi-pasien').html('eror');
        });
    });
</script>

<script>
    $(document).on("click", "#button-call-antrian", function(e) {
        e.preventDefault();
        // var code = $(this).data("code");
        $('#menu-registrasi-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_list_que') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi-xl').html(data);
        }).fail(function() {
            $('#menu-registrasi-xl').html('eror');
        });
    });
    $(document).on("click", "#button-pilih-call-antrian", function(e) {
        e.preventDefault();
        // var code = $(this).data("code");
        $('#menu-modal-antrian').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_choose_data_que') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-modal-antrian').html(data);
        }).fail(function() {
            $('#menu-modal-antrian').html('eror');
        });
    });
</script>
@endsection
