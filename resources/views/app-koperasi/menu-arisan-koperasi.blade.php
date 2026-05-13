@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-success">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/koperasi.png') }}" alt="" width="60" />
                    <div>
                        <h6 class="text-success fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                class="text-success fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Arisan <span class="text-success fw-medium">Koperasi</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="row flex-between-center">
            <div class="col-sm-auto mb-2 mb-sm-0">
                <h6 class="mb-0">Showing 1-24 of 205 Data</h6>
            </div>
            <div class="col-sm-auto">
                <div class="row gx-2 align-items-center">
                    <div class="col-auto">
                        <form class="row gx-2">
                            <div class="col-auto"><small>Sort by: </small></div>
                            <div class="col-auto">
                                <select class="form-select form-select-sm" aria-label="Bulk actions">
                                    <option selected="">Best Match</option>
                                    <option value="Refund">Newest</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-auto pe-0">
                        <a class="text-700 px-1" href="#" data-bs-toggle="modal" data-bs-target="#modal-koperasi" aria-label="Product Grid" id="button-add-group-arisan">
                            <span class="fas fa-plus-circle text-primary"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body p-0 overflow-hidden">
        <div class="row g-0">
            @foreach ($data as $datas)
            <div class="col-12 p-card">
                <div class="row">
                    <div class="col-sm-5 col-md-4">
                        <div class="position-relative h-sm-100"><a class="d-block h-100" href="#">
                                <img class="img-fluid fit-cover w-sm-100 h-sm-100 rounded-1 absolute-sm-centered" src="{{ asset('img/arisan.jpg') }}" alt=""></a>
                            <div class="badge rounded-pill bg-success position-absolute top-0 end-0 me-2 mt-2 fs--2 z-index-2">New</div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="mt-3 mt-sm-0"><strong>{{ $datas->kop_arisan_group_name }}</strong></h5>
                                <p class="fs--1 mb-0 text-primary">List Anggota :</p>
                                <ul class="list-unstyled fs--2">
                                    @php
                                    $peserta = DB::table('kop_arisan_group_user')
                                    ->join('kop_master_peserta','kop_master_peserta.kop_master_peserta_code','=','kop_arisan_group_user.kop_master_peserta_code')
                                    ->where('kop_arisan_group_code',$datas->kop_arisan_group_code)->get();
                                    $no = 1;
                                    @endphp
                                    @foreach ($peserta as $pes)
                                    @php
                                    $elemnisai = DB::table('kop_arisan_tagihan_peserta')->where('kop_arisan_group_user_code',$pes->kop_arisan_group_user_code)->first();
                                    @endphp
                                    @if ($elemnisai)
                                    <span class="badge bg-danger fs--2 my-1">{{ $no++ }}. <del>{{ $pes->kop_master_peserta_name }}</del></span>
                                    @else
                                    <span class="badge bg-primary fs--2 my-1">{{ $no++ }}. {{ $pes->kop_master_peserta_name }}</span>
                                    @endif

                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-lg-4 d-flex justify-content-between flex-column">
                                <div>
                                    <h4 class="fs-1 fs-md-2 text-warning mb-0">@currency($datas->kop_arisan_group_nominal)</h4>
                                    <h5 class="fs--1 text-500 mb-0 mt-1">
                                        <del>Keuntungan</del><span class="ms-1">{{ $datas->kop_arisan_group_bunga }}%</span>
                                    </h5>
                                    <div class="mb-2 mt-3">

                                    </div>
                                    <div class="d-none d-lg-block">
                                        <p class="fs--1 mb-1">Total Peserta: <strong>{{ $peserta->count() }}</strong></p>
                                        <p class="fs--1 mb-1">Stock: <strong class="text-danger">Not Available</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    @if ($datas->kop_arisan_group_status == 0)
                                    <a class="btn btn-sm btn-warning d-lg-block mt-lg-2" href="#!" id="button-add-peserta-group-arisan" data-bs-toggle="modal" data-bs-target="#modal-koperasi" data-code="{{ $datas->kop_arisan_group_code }}">
                                        <span class="fas fa-user-shield"></span>
                                        <span class="ms-2 d-none d-md-inline-block">Tambah Peserta</span>
                                    </a>
                                    <a class="btn btn-sm btn-primary d-lg-block mt-lg-2" href="#!" id="button-generate-proses-arisan" data-code="{{ $datas->kop_arisan_group_code }}"><span class="fas fa-shield-virus"></span> <span class="ms-2 d-none d-md-inline-block">Simpan & Jalankan Proses</span></a>

                                    @elseif ($datas->kop_arisan_group_status == 1)
                                    <a class="btn btn-sm btn-info d-lg-block mt-lg-2" href="#!" id="button-data-periode-arisan" data-bs-toggle="modal" data-bs-target="#modal-koperasi" data-code="{{ $datas->kop_arisan_group_code }}"><span class="fas fa-project-diagram"></span> <span class="ms-2 d-none d-md-inline-block">Periode Bulanan</span></a>
                                    <a class="btn btn-sm btn-dark d-lg-block mt-lg-2" href="#!" id="button-proses-data-group-arisan" data-bs-toggle="modal" data-bs-target="#modal-koperasi-full" data-code="{{ $datas->kop_arisan_group_code }}"><span class="fas fa-spinner"></span> <span class="ms-2 d-none d-md-inline-block">Proses Spin</span></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer border-top d-flex justify-content-center">

    </div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-koperasi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-koperasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-add-group-arisan", function(e) {
        e.preventDefault();
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_arisan_add_group') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 123
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-data-arisan", function(e) {
        e.preventDefault();
        var data = $("#form-add-arisan-baru").serialize();
        $('#menu-add-data-arisan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_arisan_save_group') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-arisan').html('<button class="btn btn-success float-end" id="button-simpan-data-arisan" data-code="">Simpan Data</button>');
            } else {
                $('#menu-add-data-arisan').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-add-data-arisan').html('eror');
        });
    });
    $(document).on("click", "#button-add-peserta-group-arisan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_arisan_add_group_peserta') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-pilih-peserta-arisan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var id = $(this).data("id");
        $('#menu-loading-peserta-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_arisan_save_group_peserta') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "id": id
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-loading-peserta-koperasi').html(data);
            location.reload();
        }).fail(function() {
            $('#menu-loading-peserta-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-data-periode-arisan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_arisan_periode_group_arisan') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-proses-data-group-arisan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi-full').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_arisan_proses_group_arisan') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi-full').html(data);
        }).fail(function() {
            $('#menu-koperasi-full').html('eror');
        });
    });
</script>
<script>
    $(document).on("click", "#button-generate-proses-arisan", function(e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Apakah Kamu yakin ?",
            text: "Kamu Yakin Untuk Proses Data ini ?",
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Yes, Setuju",
            cancelButtonText: "No, Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var code = $(this).data("code");
                $('#loading-button-proses').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('menu_koperasi_arisan_generate_proses_arisan') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                }).done(function(data) {
                    if (data == 1) {
                        swalWithBootstrapButtons.fire({
                            title: "Sukses!",
                            text: "Your file has been Sukses.",
                            icon: "success"
                        });
                        Swal.fire('Berhasil!', 'Proses Arisah Berhasil di jalankan', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Gagal Menyimpan",
                            icon: "error"
                        });
                        $('#loading-button-proses').html(
                            '<button class="btn btn-primary d-block w-100" type="button" id="button-proses-pengajuan-peminjaman">Pengajuan Peminjaman</button>'
                        );
                    }
                }).fail(function() {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Gagal Menyimpan",
                        icon: "error"
                    });
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Gagal Menyimpan",
                    icon: "error"
                });
            }
        });
    });
    $(document).on("click", "#button-proses-pembuatan-token-arisan", function(e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Apakah Kamu yakin ?",
            text: "Kamu Yakin Untuk Proses Data ini ?",
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Yes, Setuju",
            cancelButtonText: "No, Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var code = $(this).data("code");
                var id = $(this).data("id");
                $('#menu-periode-arisan').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('menu_koperasi_arisan_periode_group_arisan_create_token') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                        "id": id
                    },
                    dataType: 'html',
                }).done(function(data) {
                    if (data == 1) {
                        swalWithBootstrapButtons.fire({
                            title: "Sukses!",
                            text: "Your file has been Sukses.",
                            icon: "success"
                        });
                        Swal.fire('Berhasil!', 'Proses Arisah Berhasil di jalankan', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', 'Proses Arisan Gagal di buat', 'error').then(() => {
                            location.reload();
                        });

                    }
                }).fail(function() {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Gagal Menyimpan",
                        icon: "error"
                    });
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Gagal Menyimpan",
                    icon: "error"
                });
            }
        });
    });
</script>
@endsection
