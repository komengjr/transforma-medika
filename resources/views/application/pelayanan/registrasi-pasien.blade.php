@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 my-2" src="{{ asset('img/favicon.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-info fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-info fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                    class="text-info fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-info fs--1 mb-0">Menu : </h6>
                        <h4 class="text-info fw-bold mb-0">Registrasi <span class="text-info fw-medium">Pasien</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-lg-7">
            <div class="card bg-transparent-10 overflow-hidden border border-primary">
                <div class="card-header position-relative">
                    <div class="bg-holder d-none d-md-block bg-card z-index-1"
                        style="background-image:url(../../img/pram.png);background-size:180px;background-position:right bottom;z-index:-1;">
                    </div>
                    <!--/.bg-holder-->

                    <div class="position-relative z-index-2">
                        <div>
                            <h3 class="text-primary mb-1">Selamat Datang, <strong
                                    class="text-info">{{ Auth::user()->fullname }}</strong>!</h3>
                            <p>Pasien yang akan di daftarkan di pastikan lengkap</p>
                        </div>
                        <div class="d-flex py-3">
                            <div class="pe-3">
                                <p class="text-600 fs--1 fw-medium mb-1">Order Selesai</p>
                                <h4 class="text-info mb-0 fs--1 fs-md-2">{{$total-$reject}} Order</h4>
                            </div>
                            <div class="ps-3">
                                <p class="text-600 fs--1 mb-1">Order Batal</p>
                                <h4 class="text-danger mb-0 fs--1 fs-md-2">{{$reject}} Order</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="mb-0 list-unstyled">
                        <li class="alert mb-0 rounded-0 py-3 px-card alert-primary border-x-0 border-top-0">
                            <div class="row g-2 flex-between-center">
                                <div class="col">
                                    <div class="d-flex">
                                        <span class="fas fa-hand-point-right fs-1 text-primary "></span>
                                        <p class="fs--1 ps-2 mb-0"><strong>{{$total}} Order</strong> Pasien Hari ini</p>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-items-center">
                                    <button class="btn btn-falcon-primary btn-sm" id="button-registrasi-pasien"
                                        data-bs-toggle="modal" data-bs-target="#modal-registrasi"><span
                                            class="fas fa-registered"></span> Registrasi</button>
                                </div>
                            </div>
                        </li>
                        <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top border-x-0 border-top-0">
                            <div class="row flex-between-center">
                                <div class="col">
                                    <div class="d-flex">
                                        <span class="fas fa-hand-point-right fs-1 text-warning "></span>
                                        <p class="fs--1 ps-2 mb-0"><strong>7 orders</strong> Belum Bayar</p>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-items-center">
                                    <button class="btn btn-falcon-warning btn-sm"><span class="fab fa-squarespace"></span>
                                        Pemeriksaan</button>
                                </div>
                            </div>
                        </li>
                        <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top  border-0">
                            <div class="row flex-between-center">
                                <div class="col">
                                    <div class="d-flex">
                                        <span class="fas fa-hand-point-right fs-1 text-danger "></span>
                                        <p class="fs--1 ps-2 mb-0"><strong>{{$total}} orders</strong> Semua Pasien
                                        </p>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-items-center">
                                    <button class="btn btn-falcon-danger btn-sm"><span class="fas fa-sign-out-alt"></span>
                                        Close Registrasi</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <!-- <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="card h-md-100 ecommerce-card-min-width">
                                                        <div class="card-header pb-0">
                                                            <h6 class="mb-0 mt-2 d-flex align-items-center">Weekly Sales<span class="ms-1 text-400"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                                    data-bs-original-title="Calculated according to last week's sales"
                                                                    aria-label="Calculated according to last week's sales"><svg
                                                                        class="svg-inline--fa fa-question-circle fa-w-16" data-fa-transform="shrink-1"
                                                                        aria-hidden="true" focusable="false" data-prefix="far" data-icon="question-circle"
                                                                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                                                                        style="transform-origin: 0.5em 0.5em;">
                                                                        <g transform="translate(256 256)">
                                                                            <g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)">
                                                                                <path fill="currentColor"
                                                                                    d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052-72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.659c0-35.745 27.1-50.034 47.579-61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246-21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.666 2.124l-27.824-21.098c-5.107-3.872-6.251-11.066-2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42-42 18.841-42 42-42 42 18.841 42 42z"
                                                                                    transform="translate(-256 -256)"></path>
                                                                            </g>
                                                                        </g>
                                                                    </svg></span>
                                                            </h6>
                                                        </div>
                                                        <div class="card-body d-flex flex-column justify-content-end">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <p class="font-sans-serif lh-1 mb-1 fs-2">$47K</p><span
                                                                        class="badge badge-soft-success rounded-pill fs--2">+3.5%</span>
                                                                </div>
                                                                <div class="col-auto ps-0">
                                                                    <div class="echart-bar-weekly-sales h-100 echart-bar-weekly-sales-smaller-width"
                                                                        style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative;"
                                                                        _echarts_instance_="ec_1751524197045">
                                                                        <div
                                                                            style="position: relative; width: 104px; height: 51px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
                                                                            <canvas data-zr-dom-id="zr_0" width="104" height="51"
                                                                                style="position: absolute; left: 0px; top: 0px; width: 104px; height: 51px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                                                        </div>
                                                                        <div class=""
                                                                            style="position: absolute; display: block; border-style: solid; white-space: nowrap; z-index: 9999999; box-shadow: rgba(0, 0, 0, 0.2) 1px 2px 10px; background-color: rgb(249, 250, 253); border-width: 1px; border-radius: 4px; color: rgb(11, 23, 39); font: 14px / 21px &quot;Microsoft YaHei&quot;; padding: 7px 10px; top: 0px; left: 0px; transform: translate3d(58px, -22px, 0px); border-color: rgb(216, 226, 239); pointer-events: none; visibility: hidden; opacity: 0;">
                                                                            Sat : 120</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card product-share-doughnut-width">
                                                        <div class="card-header pb-0">
                                                            <h6 class="mb-0 mt-2 d-flex align-items-center">Product Share</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="d-flex flex-column justify-content-between">
                                                                    <p class="font-sans-serif lh-1 mb-1 fs-2">34.6%</p><span
                                                                        class="badge badge-soft-warning rounded-pill fs--2"><svg
                                                                            class="svg-inline--fa fa-caret-up fa-w-10 me-1" aria-hidden="true"
                                                                            focusable="false" data-prefix="fas" data-icon="caret-up" role="img"
                                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                                            <path fill="currentColor"
                                                                                d="M288.662 352H31.338c-17.818 0-26.741-21.543-14.142-34.142l128.662-128.662c7.81-7.81 20.474-7.81 28.284 0l128.662 128.662c12.6 12.599 3.676 34.142-14.142 34.142z">
                                                                            </path>
                                                                        </svg>3.5%</span>
                                                                </div>
                                                                <div>
                                                                    <canvas class="my-n5" id="marketShareDoughnut" width="93" height="92"
                                                                        style="display: block; box-sizing: border-box; height: 110.4px; width: 111.6px;"></canvas>
                                                                    <p class="mb-0 text-center fs--2 mt-4 text-500">Target: <span class="text-800">55%
                                                                        </span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card h-md-100 h-100">
                                                        <div class="card-body">
                                                            <div class="row h-100 justify-content-between g-0">
                                                                <div class="col-5 col-sm-6 col-xxl pe-2">
                                                                    <h6 class="mt-1">Market Share</h6>
                                                                    <div class="fs--2 mt-3">
                                                                        <div class="d-flex flex-between-center mb-1">
                                                                            <div class="d-flex align-items-center"><span class="dot bg-primary"></span><span
                                                                                    class="fw-semi-bold">Falcon</span>
                                                                            </div>
                                                                            <div class="d-xxl-none">57%</div>
                                                                        </div>
                                                                        <div class="d-flex flex-between-center mb-1">
                                                                            <div class="d-flex align-items-center"><span class="dot bg-info"></span><span
                                                                                    class="fw-semi-bold">Sparrow</span></div>
                                                                            <div class="d-xxl-none">20%</div>
                                                                        </div>
                                                                        <div class="d-flex flex-between-center mb-1">
                                                                            <div class="d-flex align-items-center"><span class="dot bg-warning"></span><span
                                                                                    class="fw-semi-bold">Phoenix</span></div>
                                                                            <div class="d-xxl-none">22%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto position-relative">
                                                                    <div class="echart-product-share" _echarts_instance_="ec_1751524197047"
                                                                        style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative;">
                                                                        <div
                                                                            style="position: relative; width: 106px; height: 106px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
                                                                            <canvas data-zr-dom-id="zr_0" width="106" height="106"
                                                                                style="position: absolute; left: 0px; top: 0px; width: 106px; height: 106px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                                                        </div>
                                                                        <div class=""
                                                                            style="position: absolute; display: block; border-style: solid; white-space: nowrap; z-index: 9999999; box-shadow: rgba(0, 0, 0, 0.2) 1px 2px 10px; background-color: rgb(249, 250, 253); border-width: 1px; border-radius: 4px; color: rgb(11, 23, 39); font: 14px / 21px &quot;Microsoft YaHei&quot;; padding: 7px 10px; top: 0px; left: 0px; transform: translate3d(18px, -39px, 0px); border-color: rgb(216, 226, 239); pointer-events: none; visibility: hidden; opacity: 0;">
                                                                            <strong>Falcon:</strong> 57.61%
                                                                        </div>
                                                                    </div>
                                                                    <div class="position-absolute top-50 start-50 translate-middle text-dark fs-2">
                                                                        26M</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card h-100">
                                                        <div class="card-header pb-0">
                                                            <h6 class="mb-0 mt-2 d-flex align-items-center">Total Order</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row align-items-end">
                                                                <div class="col">
                                                                    <p class="font-sans-serif lh-1 mb-1 fs-2">58.4K</p>
                                                                    <div class="badge badge-soft-primary rounded-pill fs--2"><svg
                                                                            class="svg-inline--fa fa-caret-up fa-w-10 me-1" aria-hidden="true"
                                                                            focusable="false" data-prefix="fas" data-icon="caret-up" role="img"
                                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                                            <path fill="currentColor"
                                                                                d="M288.662 352H31.338c-17.818 0-26.741-21.543-14.142-34.142l128.662-128.662c7.81-7.81 20.474-7.81 28.284 0l128.662 128.662c12.6 12.599 3.676 34.142-14.142 34.142z">
                                                                            </path>
                                                                        </svg>13.6%
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto ps-0">
                                                                    <div class="total-order-ecommerce"
                                                                        data-echarts="{&quot;series&quot;:[{&quot;type&quot;:&quot;line&quot;,&quot;data&quot;:[110,100,250,210,530,480,320,325]}],&quot;grid&quot;:{&quot;bottom&quot;:&quot;-10px&quot;}}"
                                                                        _echarts_instance_="ec_1751524197051"
                                                                        style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative;">
                                                                        <div
                                                                            style="position: relative; width: 144px; height: 64px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
                                                                            <canvas data-zr-dom-id="zr_0" width="144" height="64"
                                                                                style="position: absolute; left: 0px; top: 0px; width: 144px; height: 64px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                                                        </div>
                                                                        <div class=""></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
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
    <div class="modal fade" id="modal-company" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-company"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/js/swetalert.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-registrasi-pasien", function (e) {
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
            }).done(function (data) {
                $('#menu-registrasi').html(data);
            }).fail(function () {
                $('#menu-registrasi').html('eror');
            });
        });
        $(document).on("click", "#button-create-data-pasien", function (e) {
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
            }).done(function (data) {
                $('#menu-registrasi-pasien').html(data);
            }).fail(function () {
                $('#menu-registrasi-pasien').html('eror');
            });
        });
        $(document).on("click", "#button-scan-data-pasien", function (e) {
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
            }).done(function (data) {
                $('#menu-registrasi-pasien').html(data);
            }).fail(function () {
                $('#menu-registrasi-pasien').html('eror');
            });
        });
        $(document).on("click", "#button-cari-data-pasien", function (e) {
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
                }).done(function (data) {
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
                }).fail(function () {
                    $('#menu-registrasi-pasien').html('eror');
                });
            }
        });
        $(document).on("click", "#button-save-create-pasien-baru", function (e) {
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
                }).done(function (data) {
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
                }).fail(function () {
                    $('#menu-registrasi-pasien').html('eror');
                });
            }
        });
        $(document).on("click", "#button-pilih-data-pasien", function (e) {
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
            }).done(function (data) {
                $('#menu-registrasi').html(data);
            }).fail(function () {
                $('#menu-registrasi').html('eror');
            });
        });
        // FASILITAS LAYANAN
        $(document).on("click", "#button-pilih-kebutuhan", function (e) {
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
                    }).done(function (data) {
                        $('#menu-kebutuhan-registrasi').html(data);
                        document.getElementById("menu-fasilitas-layanan").style.display = "block";
                        document.getElementById("button-pilih-kebutuhan").style.display = "none";
                        document.getElementById("pill-profile-tab").click();
                    }).fail(function () {
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
        $(document).on("click", "#button-pilih-dokter-poliklinik", function (e) {
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
            }).done(function (data) {
                $('#menu-pilihan-dokter-poli').html(data);
            }).fail(function () {
                $('#menu-pilihan-dokter-poli').html('eror');
            });
        });
        $(document).on("click", "#button-fix-print-registrasi-poli", function (e) {
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
            }).done(function (data) {
                // $('#menu-pilihan-dokter-poli').html(data);
                document.getElementById("menu-fasilitas-layanan").disabled = true;
                document.getElementById("menu-cetak-data-registrasi").style.display = "block";
                document.getElementById("pill-contact-tab").click();
                document.getElementById("button-pilih-end-proses").click();
            }).fail(function () {
                // $('#menu-pilihan-dokter-poli').html('eror');
            });
        });
        $(document).on("click", "#button-pilih-end-proses", function (e) {
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
            }).done(function (data) {
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
            }).fail(function () {
                $('#menu-invoice-registrasi').html('eror');
            });
        });
        $(document).on("click", "#button-preview-registrasi-pasien", function (e) {
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
            }).done(function (data) {
                setTimeout(() => {
                    $('#menu-preview-registrasi-pasien').html(
                        '<iframe src="data:application/pdf;base64, ' +
                        data +
                        '" style="width:100%; height:533px;" frameborder="0"></iframe>');
                }, 500);
            }).fail(function () {
                $('#menu-preview-registrasi-pasien').html('eror');
            });
        });
    </script>
    <script>
        $(document).on("click", "#button-fix-registrasi-lab", function (e) {
            e.preventDefault();
            // var code = $(this).data("code");
            // var date = $(this).data("date");
            var rujukan = document.getElementById("rujukan").value;
            var date = document.getElementById("tgl_pemeriksaan").value;
            var no_reg = document.getElementById("no_registrasi").value;
            var no_rm = document.getElementById("no_rm").value;
            var cat = document.getElementById("kategori").value;
            var layanan = document.getElementById("layanan").value;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be Send File!",
                icon: "question",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Send it!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire({
                        title: "Massage success!",
                        text: "Your file has been Send.",
                        icon: "success"
                    });
                    $.ajax({
                        url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_lab') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "rujukan": rujukan,
                            "date": date,
                            "layanan": layanan,
                            "no_reg": no_reg,
                            "no_rm": no_rm,
                            "cat": cat,
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        document.getElementById("menu-fasilitas-layanan").disabled = true;
                        document.getElementById("menu-cetak-data-registrasi").style.display = "block";
                        document.getElementById("pill-contact-tab").click();
                        document.getElementById("button-pilih-end-proses").click();
                    }).fail(function () {
                        $('#menu-pilihan-dokter-poli').html('eror');
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                }
            });
        });
    </script>
@endsection
