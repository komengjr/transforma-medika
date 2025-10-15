<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ env('APP_NAME')}} | Management System</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="manifest" href="../../../asset/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    {{--
    <script src="../../../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script> --}}


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    {{--
    <link rel="preconnect" href="https://fonts.gstatic.com"> --}}

    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:400,100,900);

        body {
            font-family: 'Roboto', sans-serif
        }

        @import url("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css");

        .fade-scale {
            transform: scale(0);
            opacity: 0;
            -webkit-transition: all .25s linear;
            -o-transition: all .25s linear;
            transition: all .25s linear;
        }

        .fade-scale.in {
            opacity: 1;
            transform: scale(1);
        }

        .card-text {
            text-align: justify;
            font-size: 11px;
        }

        #menu:hover {
            cursor: pointer;
            background: linear-gradient(0deg, rgba(34, 193, 195, 1) 0%, rgba(253, 187, 45, 1) 100%) !important;
            color: black !important;
            text-decoration: dotted !important;
        }

        .kaki {
            background: rgba(7, 175, 169, 1);
            background: radial-gradient(circle, rgba(17, 215, 205, 1) 0%, rgba(4, 42, 85, 1) 100%);
            position: fixed;
            bottom: 20px;
            left: 10px;
            right: 10px;
            border-top-right-radius: 15px 15px;
            border-top-left-radius: 15px 15px;
            border-bottom-left-radius: 15px 15px;
            border-bottom-right-radius: 15px 15px;
            width: 95%;
            height: 75px;
            border-style: solid;
            border-width: thin;
            border-color: #0ae9b5;
            box-shadow: 0px 0px 5px 5px #dabebe;
            z-index: 99999;
            /* background-color: rgba(5, 5, 5, 0.9); */

        }

        .kaki a {
            /* line-height: 55px; */
            height: 55px;
            width: 55px;
        }
    </style>
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center">
                <div class="col-lg-9 col-xxl-6 py-3 position-relative"><img class="bg-auth-circle-shape"
                        src="../../../asset/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img
                        class="bg-auth-circle-shape-2" src="../../../asset/img/icons/spot-illustrations/shape-1.png"
                        alt="" width="150">
                    <div class="d-lg-block d-none card bg-100 border border-3 border-primary mb-3">
                        <div class="row gx-0 flex-between-center">
                            <div class="col-sm-auto d-flex align-items-center border-bottom">
                                <img class="ms-3 m-2" src="{{asset('img/favicon.png')}}" alt="" width="90">
                                <div>
                                    <h6 class="text-primary fs--1 mb-0">Welcome to </h6>
                                    <h4 class="text-primary fw-bold mb-0">Dashboard <span
                                            class="text-info fw-medium">Home</span></h4>
                                </div><img class="ms-n4 d-md-none d-lg-block"
                                    src="../asset/img/illustrations/crm-line-chart.png" alt="" width="150">
                            </div>
                            <div class="col-md-auto p-2">
                                <form class="row align-items-center g-3 px-2">
                                    <div class="col-md-auto position-relative" style=" height:75px;">
                                        <div class="d-flex align-items-center m-2">
                                            <div class="avatar avatar-3xl me-2">
                                                <img class="rounded-circle border border-2"
                                                    src="{{asset('img/pp.png')}}" alt="" />

                                            </div>
                                            <div class="flex-1">
                                                <div style="text-align: right;">
                                                    <h6 class="text-primary">Hi! {{Auth::user()->fullname}}</h6>
                                                </div>

                                                <div class="btn-group float-end" role="group">
                                                    <div class="theme-control-toggle fa-icon-wait pe-2 ">
                                                        <input class="form-check-input ms-0 theme-control-toggle-input"
                                                            id="themeControlToggle" type="checkbox"
                                                            data-theme-control="theme" value="dark" />
                                                        <label
                                                            class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                                                            for="themeControlToggle" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="Switch to light theme"><span
                                                                class="fas fa-sun fs-0"></span></label>
                                                        <label
                                                            class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                                                            for="themeControlToggle" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="Switch to dark theme"><span
                                                                class="fas fa-moon fs-0"></span></label>
                                                    </div>
                                                    <button
                                                        class="btn btn-sm btn-falcon-primary dropdown-toggle form-control"
                                                        id="btnGroupVerticalDrop2" type="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"><span class="fas fa-align-left me-1"
                                                            data-fa-transform="shrink-3"></span>Option</button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                                        <button class="dropdown-item text-dark" id="button-menu-utama">
                                                            <span class="fab fa-dashcube"></span>
                                                            Menu Utama</button>
                                                        <button class="dropdown-item text-warning"
                                                            data-bs-toggle="modal" data-bs-target="#modal-keuangan"
                                                            id="button-proses-transaksi" data-code=""><span
                                                                class="fab fa-keycdn"></span>
                                                            Ubah Kata Sandi</button>
                                                        @if (Auth::user()->access_code == 'master')
                                                            <button class="dropdown-item text-facebook"
                                                                id="button-master-dashboard">
                                                                <span class="fas fa-cog"></span> Master Page
                                                            </button>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <button class="dropdown-item text-danger"
                                                            id="button-logout"><span class="fas fa-sign-out-alt"></span>
                                                            Log Out</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0" style="color: white;">Menu Aplikasi</h5>
                        </div>
                        <div class="card-body p-3 border border-primary">
                            <div class="row light g-3">
                                @if (Auth::user()->access_code == 'master')
                                    @php
                                        $menu = DB::table('z_menu_super')->get();
                                    @endphp
                                @else
                                    @php
                                        $menu = DB::table('z_menu_super')
                                        ->join('z_menu_user_super','z_menu_user_super.menu_super_code','=','z_menu_super.menu_super_code')
                                        ->where('z_menu_user_super.access_code',Auth::user()->access_code)
                                        ->get();
                                    @endphp
                                @endif
                                @foreach ($menu as $menus)
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card text-white {{$menus->menu_super_bg}}" id="menu"
                                            data-code="{{$menus->menu_super_code}}">
                                            <div class="card-body">
                                                <div class="card-title fs--1">{{$menus->menu_super_name}}</div>
                                                <p class="card-text">{{$menus->menu_super_desc}}.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-success" id="menu" data-code="accounting">
                                        <div class="card-body">
                                            <div class="card-title">ACCOUNTING</div>
                                            <p class="card-text">program perangkat lunak (software) yang dirancang untuk
                                                mengotomatisasi dan menyederhanakan pengelolaan serta pencatatan
                                                transaksi keuangan suatu bisnis, seperti penjualan, pembelian,
                                                utang-piutang, dan penggajian.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-danger" id="menu" data-code="inventaris">
                                        <div class="card-body">
                                            <div class="card-title">INVENTARIS</div>
                                            <p class="card-text">perangkat lunak atau program komputer yang dirancang
                                                untuk membantu perusahaan atau individu dalam mengelola, melacak, dan
                                                mengawasi daftar aset atau barang yang dimiliki, mulai dari stok barang
                                                hingga aset bergerak lainnya.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-warning" id="menu" data-code="medical">
                                        <div class="card-body">
                                            <div class="card-title">MEDIKA HEALTH</div>
                                            <p class="card-text">sistem informasi dan perangkat lunak yang dirancang
                                                untuk mengelola dan mengintegrasikan seluruh aktivitas dan pelayanan di
                                                rumah sakit, mulai dari manajemen pasien, rekam medis, jadwal,
                                                administrasi, keuangan, hingga logistik.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-dark" id="menu" data-code="logistik">
                                        <div class="card-body">
                                            <div class="card-title">LOGISTIK</div>
                                            <p class="card-text">perangkat lunak (software) digital yang dirancang untuk
                                                mengelola, mengoptimalkan, dan mengotomatisasi proses logistik dan
                                                rantai pasok suatu perusahaan, mulai dari perencanaan hingga pengiriman
                                                akhir.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-twitter" id="menu" data-code="supplier">
                                        <div class="card-body">
                                            <div class="card-title">SUPPLIER</div>
                                            <p class="card-text">perangkat lunak (software) digital yang dirancang untuk
                                                mengelola, mengoptimalkan, dan mengotomatisasi proses logistik dan
                                                rantai pasok suatu perusahaan, mulai dari perencanaan hingga pengiriman
                                                akhir.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-google-plus" id="menu" data-code="pembelian">
                                        <div class="card-body">
                                            <div class="card-title">PURCHASING</div>
                                            <p class="card-text">perangkat lunak (software) digital yang dirancang untuk
                                                mengelola, mengoptimalkan, dan mengotomatisasi proses logistik dan
                                                rantai pasok suatu perusahaan, mulai dari perencanaan hingga pengiriman
                                                akhir.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-github" id="menu" data-code="brodcast">
                                        <div class="card-body">
                                            <div class="card-title">BRODCAST MESSAGE</div>
                                            <p class="card-text">perangkat lunak (software) digital yang dirancang untuk
                                                mengelola, mengoptimalkan, dan mengotomatisasi proses logistik dan
                                                rantai pasok suatu perusahaan, mulai dari perencanaan hingga pengiriman
                                                akhir.</p>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-sm-6 col-lg-4">
                                    <div class="card text-white bg-400">
                                        <div class="card-body">
                                            <div class="card-title">Comming Soon</div>
                                            <p class="card-text">Some quick example text to build on the card title
                                                and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <div class="d-lg-none kaki">
        <ul class="nav nav-pills nav-fill mt-0">
            <li class="nav-item m-2"><a class="btn btn-light btn-sm py-1 px-2 m-0" href="#"><i
                        class="fas fa-home"></i><br> Home</a></li>
            <li class="nav-item m-2"><a class="btn btn-falcon-danger btn-sm py-1 px-2 m-0" href="#"><i
                        class="fab fa-keycdn fs-1"></i><br> Reset</a></li>
            <li class="nav-item m-2"><a class="btn btn-light btn-sm py-1 px-2 m-0" href="#" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop"><i class="fab fa-weixin fs-1"></i>
                    @guest
                    @else
                        <div
                            style=" position: absolute; top: -8px; background: rgba(26, 196, 4, 0.83); border-radius: 50%; line-height: 25px; height: 25px; width: 25px;">
                            1
                        </div>
                    @endguest
                    <br> Chat
                </a></li>
            <li class="nav-item m-2 ">
                <div class="avatar avatar-3xl me-2">
                    <img class="rounded-circle border border-2" src="{{asset('img/my.jpg')}}" alt="" />
                </div>
            </li>
        </ul>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg mt-6" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                        <h4 class="mb-1" id="staticBackdropLabel">Add a new illustration to the landing page</h4>
                        <p class="fs--2 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p>
                    </div>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="d-flex"><span class="fa-stack ms-n1 me-3"><i
                                            class="fas fa-circle fa-stack-2x text-200"></i><i
                                            class="fa-inverse fa-stack-1x text-primary fas fa-tag"
                                            data-fa-transform="shrink-2"></i></span>
                                    <div class="flex-1">
                                        <h5 class="mb-2 fs-0">Labels</h5>
                                        <div class="d-flex"><span
                                                class="badge me-1 py-2 badge-soft-success">New</span><span
                                                class="badge me-1 py-2 badge-soft-primary">Goal</span><span
                                                class="badge me-1 py-2 badge-soft-info">Enhancement</span>
                                            <div class="dropdown dropend">
                                                <button
                                                    class="btn btn-sm btn-secondary px-2 fsp-75 bg-400 border-400 dropdown-toggle dropdown-caret-none"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"><span class="fas fa-plus"></span></button>
                                                <div class="dropdown-menu">
                                                    <h6 class="dropdown-header py-0 px-3 mb-0">Select Label</h6>
                                                    <div class="dropdown-divider"></div>
                                                    <div class="px-3">
                                                        <button class="badge-soft-danger dropdown-item rounded-1 mb-2"
                                                            type="button">New</button>
                                                        <button class="badge-soft-primary dropdown-item rounded-1 mb-2"
                                                            type="button">Goal</button>
                                                        <button class="badge-soft-info dropdown-item rounded-1 mb-2"
                                                            type="button">Enhancement</button>
                                                    </div>
                                                    <div class="dropdown-divider"></div>
                                                    <div class="px-3">
                                                        <button
                                                            class="btn btn-sm d-block w-100 btn-outline-secondary border-400">Create
                                                            Label</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-4" />
                                    </div>
                                </div>
                                <div class="d-flex"><span class="fa-stack ms-n1 me-3"><i
                                            class="fas fa-circle fa-stack-2x text-200"></i><i
                                            class="fa-inverse fa-stack-1x text-primary fas fa-align-left"
                                            data-fa-transform="shrink-2"></i></span>
                                    <div class="flex-1">
                                        <h5 class="mb-2 fs-0">Description</h5>
                                        <p class="text-word-break fs--1">The illustration must match to the contrast of
                                            the theme. The illustraion must described the concept of the design. To know
                                            more about the theme visit the page. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <h6 class="mt-5 mt-lg-0">Add To Card</h6>
                                <ul class="nav flex-lg-column fs--1">
                                    <li class="nav-item me-2 me-lg-0"><a class="nav-link nav-link-card-details"
                                            href="#!"><span class="fas fa-user me-2"></span>Members</a></li>
                                    <li class="nav-item me-2 me-lg-0"><a class="nav-link nav-link-card-details"
                                            href="#!"><span class="fas fa-tag me-2"></span>Label</a></li>
                                    <li class="nav-item me-2 me-lg-0"><a class="nav-link nav-link-card-details"
                                            href="#!"><span class="fas fa-paperclip me-2"></span>Attachments</a></li>
                                    <li class="nav-item me-2 me-lg-0"><a class="nav-link nav-link-card-details"
                                            href="#!"><span class="fa fa-align-left me-2"></span>Description </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    {{--
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script> --}}
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "warning",
                title: "Account Has been Log Out !!"
            });
        </script>
    @endif
    <script>
        $(document).on("click", "#menu", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            let timerInterval;
            Swal.fire({
                title: "Mohon Menunggu",
                html: "I will Open in <b></b> milliseconds.",
                timer: 1000,
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    $.ajax({
                        url: "{{ route('app_check_menu') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        // window.open(data, '_blank');
                        // window.open(data, '_blank', 'height=' + screen.height + ',width=' + screen.width + ',resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes');
                        window.location.replace(data);
                    }).fail(function () {
                        $('#menu-keuangan').html('eror');
                    });
                }
            });
        });
        $(document).on("click", "#button-logout", function (e) {
            e.preventDefault();
            let timerInterval;
            Swal.fire({
                title: "Mohon Menunggu",
                html: "I will Log out in <b></b> milliseconds.",
                timer: 2000,
                showCancelButton: true,
                cancelButtonText: "No, Batal Logout!",
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.replace('{{ route("logout") }}');
                }
            });
        });
        $(document).on("click", "#button-master-dashboard", function (e) {
            e.preventDefault();
            window.location.href = "{{route('master_dashboard')}}";
        });
        $(document).on("click", "#button-menu-utama", function (e) {
            e.preventDefault();
            window.location.href = "{{route('/')}}";
        });

    </script>
</body>

</html>
