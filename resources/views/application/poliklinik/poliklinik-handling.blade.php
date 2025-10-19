@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <style>
        #button-handling-pasien-poli:hover {
            cursor: pointer;
            background: rgb(215, 106, 11);
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-warning">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/gigi.png') }}" alt="" width="60" />
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
                        <h4 class="text-warning fw-bold mb-0">Poli <span class="text-warning fw-medium">Handling</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-4 pe-lg-2 mb-3">
            <div class="sticky-sidebar">
                <div class="card mb-lg-0">
                    <div class="card-header bg-300">
                        <h5 class="mb-0">Daftar Handling</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="col-12 mb-2">
                            <div class="input-group"> <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                <input type="text" name="nik" class="form-control form-control-lg border-start-0 bg-white"
                                    id="nik" placeholder="Scan Disini">
                            </div>
                        </div>
                        @foreach ($data as $datas)
                            <div class="col-12 mb-2">
                                <div class="card border h-100 border-warning remove-class" id="button-handling-pasien-poli"
                                    data-code="{{ $datas->d_reg_order_code }}">
                                    <div class="card-body fs--2 text-dark py-2">
                                        <div class="card-title my-0">{{ $datas->master_patient_name }}</div>
                                        <p class="card-text">No. reg : <strong
                                                class="text-primary">{{ $datas->d_reg_order_code }}</strong>, Menuju Poli
                                            <strong class="text-dark">{{ $datas->t_layanan_data_name }}</strong> dengan dokter
                                            Spesialis
                                            <strong class="text-dark">{{$datas->master_doctor_name}}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 ps-lg-2">
            <span id="menu-detail-handling"></span>
        </div>
    </div>
    <div class="card mt-0">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    {{-- <h5 class="mb-2 mb-md-0">Nice Job! You're almost done</h5> --}}
                </div>
                <div class="col-auto">
                    {{-- <button class="btn btn-falcon-default btn-sm me-2">Save</button> --}}
                    {{-- <button class="btn btn-falcon-primary btn-sm">Make your event live </button> --}}
                </div>
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
    <div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-poliklinik"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-handling-pasien-poli", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $(".remove-class").removeClass("bg-warning");
            $(this).addClass("bg-warning");
            $('#menu-detail-handling').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_handling_detail') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-detail-handling').html(data);
            }).fail(function () {
                $('#menu-detail-handling').html('eror');
            });
        });
        $(document).on("click", "#button-order-layanan-dokter", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            var reg = $(this).data("reg");
            $('#menu-order-layanan-dokter').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_handling_order_layanan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "reg": reg,
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-order-layanan-dokter').html(data);
            }).fail(function () {
                $('#menu-order-layanan-dokter').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-diagnosa-umum", function (e) {
            e.preventDefault();
            var name = document.getElementById('data-name').value;
            var desc = document.getElementById('data-desc').value;
            var id = document.getElementById('code_gigi').value;
            if (name == "" || desc == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            } else {
                $('#menu-diagnosa-umum').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('data_registrasi_poliklinik_save_diagnosa') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "name": name,
                        "desc": desc,
                        "id": id,
                    },
                    dataType: 'html',
                }).done(function (data) {
                    document.getElementById('data-name').value = "";
                    document.getElementById('data-desc').value = "";
                    $('#menu-diagnosa-umum').html(data);
                }).fail(function () {
                    alert('eror');
                });
            }
        });
        $(document).on("click", "#button-save-data-diagnosa-pasien-poli", function (e) {
            e.preventDefault();
            var id = document.getElementById('code_gigi').value;
            $('#menu-pasien-poliklinik').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_save_diagnosa_pasien_poli') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-pasien-poliklinik').html(data);
                location.reload();
            }).fail(function () {
                alert('eror');
            });
        });
        $(document).on("click", "#button-penunjang-poliklinik", function (e) {
            e.preventDefault();
            var id = document.getElementById('code_gigi').value;
            $('#menu-poliklinik').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_data_penunjang') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-poliklinik').html(data);
            }).fail(function () {
                alert('eror');
            });
        });
    </script>

@endsection
