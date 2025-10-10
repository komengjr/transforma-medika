<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>TRANS | Purchase Order Management</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="manifest" href="{{ asset('asset/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=National+Park:wght@200..800&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        * {
            font-family: "Prompt", sans-serif !important;
            font-weight: 400;
            font-style: normal;
        }
    </style>
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
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>
            <div class="row justify-content-center pt-6 pb-5">
                <div class="col-sm-10 col-lg-10 col-xxl-5">
                    <!-- <a class="d-flex flex-center mb-4" href="#"><img class="me-2"
                            src="{{asset('img/logo.png')}}" alt="" width="205" /><span
                            class="font-sans-serif fw-bolder fs-5 d-inline-block">Supplier</span></a> -->

                    <div class="card theme-wizard">
                        <div class="card-header bg-300 pt-3 pb-2">
                            <ul class="nav nav-pills mb-3" role="tablist" id="pill-tab2" style="display: none;">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-wizard-step="data-wizard-step"
                                        data-bs-toggle="pill" data-bs-target="#form-wizard-progress-tab1" type="button"
                                        role="tab" aria-controls="form-wizard-progress-tab1" aria-selected="true">
                                        <span class="fas fa-lock me-2" data-fa-transform="shrink-2"></span><span
                                            class="d-none d-md-inline-block fs--1">Account</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-progress-tab2" type="button" role="tab"
                                        aria-controls="form-wizard-progress-tab2" aria-selected="false">
                                        <span class="fas fa-user me-2" data-fa-transform="shrink-2"></span><span
                                            class="d-none d-md-inline-block fs--1">Signature</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-progress-tab3" type="button" role="tab"
                                        aria-controls="form-wizard-progress-tab3" aria-selected="false">
                                        <span class="fas fa-dollar-sign me-2"
                                            data-fa-transform="down-2 shrink-2"></span><span
                                            class="d-none d-md-inline-block fs--1">Payment Method</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-wizard-step="data-wizard-step" data-bs-toggle="pill"
                                        data-bs-target="#form-wizard-progress-tab4" type="button" role="tab"
                                        aria-controls="form-wizard-progress-tab4" aria-selected="false">
                                        <span class="fas fa-thumbs-up me-2" data-fa-transform="shrink-2"></span><span
                                            class="d-none d-md-inline-block fs--1">Done</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="progress" style="height: 2px">
                            <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <div class="card-body py-4 px-0">
                            <div class="tab-content">
                                <div class="tab-pane active px-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-progress-tab1" id="form-wizard-progress-tab1">
                                    <form novalidate="novalidate">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading fw-semi-bold">Halo Suppliers !</h4>
                                            <p>Purchase Order Anda Sudah di buat , pastikan untuk mengikuti langkah
                                                sesuai dengan Step yang ada dan isi sesuai perintah.</p>
                                            <hr />
                                            <p class="mb-0">Bunga melati bunga mawar, Harum wanginya warnanya merah
                                                maron , Kami para pejuang dollar, Siap berjualan melayani pelanggan</p>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="form-wizard-progress-wizard-email">Email*</label>
                                                    <div class="input-group mb-3"><span class="input-group-text"
                                                            id="basic-addon1">@</span>
                                                        <input class="form-control form-control-lg" type="email"
                                                            name="email" placeholder="Email address"
                                                            pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$"
                                                            required="required" id="form-wizard-progress-wizard-email"
                                                            data-wizard-validate-email="true" />
                                                    </div>

                                                    <div class="invalid-feedback">You must add email</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="form-wizard-progress-wizard-confirm-password">Token*</label>
                                                    <div class="input-group mb-3"><span class="input-group-text"
                                                            id="basic-addon1"><span class="fab fa-keycdn"></span></span>
                                                        <input class="form-control form-control-lg" type="text"
                                                            name="confirmPassword" placeholder="Confirm Token"
                                                            required="required"
                                                            id="form-wizard-progress-wizard-confirm-password"
                                                            data-wizard-validate-confirm-password="true" />
                                                    </div>

                                                    <div class="invalid-feedback">
                                                        Passwords need to match
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="terms"
                                                required="required" id="form-wizard-progress-wizard-checkbox" checked />
                                            <label class="form-check-label" for="form-wizard-progress-wizard-checkbox">I
                                                accept the <a href="#!">terms </a>and
                                                <a href="#!">privacy policy</a></label>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane px-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-progress-tab2" id="form-wizard-progress-tab2">

                                </div>
                                <div class="tab-pane px-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-progress-tab3" id="form-wizard-progress-tab3">

                                </div>
                                <div class="tab-pane text-center px-3 px-md-5" role="tabpanel"
                                    aria-labelledby="form-wizard-progress-tab4" id="form-wizard-progress-tab4">

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-300">
                            <div class="px-4">
                                <ul class="pager wizard list-inline mb-0">
                                    <li class="previous">
                                        <button class="btn btn-falcon-danger" style="display: none;">Prev</button>
                                    </li>
                                    <li class="next">
                                        <button class="btn btn-primary px-5 px-sm-6" type="submit" id="button-next-jr"
                                            style="display: none;">
                                            Next<span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3">
                                            </span>
                                        </button>
                                        <span id="menu-button-next">
                                            <button class="btn btn-falcon-danger" id="button-next"
                                                data-code="{{ $info->pem_pr_order_code }}">Masuk</button>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
                        <div class="modal-content position-relative p-5">
                            <div class="d-flex align-items-center">
                                <div class="lottie me-3"
                                    data-options='{"path":"../../../../asset/img/animated-icons/warning-light.json"}'>
                                </div>
                                <div class="flex-1">
                                    <button class="btn btn-link text-danger position-absolute top-0 end-0 mt-2 me-2"
                                        data-bs-dismiss="modal"><span class="fas fa-times"></span></button>
                                    <p class="mb-0">You don't have access to the link. Please try again.</p>
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

    <div class="modal fade" id="modal-supplier" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-supplier"></div>
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
    <!-- <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script> -->
    <script src="{{ asset('vendors/lottie/lottie.min.js') }}"></script>
    <script src="{{ asset('vendors/validator/validator.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on("click", "#button-next", function (e) {
            e.preventDefault();
            const button = document.getElementById('button-next-jr');
            var code = $(this).data("code");
            const email = document.getElementById('form-wizard-progress-wizard-email').value;
            const token = document.getElementById('form-wizard-progress-wizard-confirm-password').value;

            $('#form-wizard-progress-tab2').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            if (email == "" || token == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Email dan Token Tidak Boleh Kosong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            } else {
                $.ajax({
                    url: "{{ route('app_supp_user_token') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "email": email,
                        "token": token,
                        "code": code,
                    },
                    dataType: 'html',
                }).done(function (data) {
                    $('#menu-button-next').html(
                        '<div class="spinner-border" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    if (data == 0) {
                        setTimeout(() => {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Email dan Token Tidak Sinkron!",
                                footer: '<a href="#">Why do I have this issue?</a>'
                            });
                            $('#menu-button-next').html(
                                ' <button class="btn btn-falcon-danger" id="button-next" data-code="{{ $info->pem_pr_order_code }}">Masuk</button>'
                            );
                        }, 1500);
                    } else {

                        setTimeout(() => {
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
                                icon: "success",
                                title: "Log in successfully"
                            });
                            button.click();
                            $('#form-wizard-progress-tab2').html(data);
                            $('#menu-button-next').html('<button class="btn btn-falcon-danger" id="button-next-one">Next</button>');
                        }, 2000);
                    }
                }).fail(function () {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                });
            }
        });
        $(document).on("click", "#button-next-one", function (e) {
            e.preventDefault();
            const button = document.getElementById('button-next-jr');
            const code = document.getElementById('code_po').value;
            $('#form-wizard-progress-tab3').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('app_supp_user_token_next') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Data Belum Lengkap!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
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
                        icon: "success",
                        title: "Data Has been Save successfully"
                    });
                    button.click();
                    $('#form-wizard-progress-tab3').html(data);
                    $('#menu-button-next').html('<button class="btn btn-falcon-danger" id="button-next-last">Next</button>');
                }
            }).fail(function () {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            });
        });
        $(document).on("click", "#button-next-last", function (e) {
            e.preventDefault();
            const button = document.getElementById('button-next-jr');
            const code = document.getElementById('code_po').value;
            const payment = document.getElementById('form-select-payment').value;
            const termin = document.getElementById('form-data-termin').value;
            const faktur = document.getElementById('form-data-faktur').value;
            const rek = document.getElementById('form-data-rek').value;
            $('#form-wizard-progress-tab4').html(
                '<strong>Beberapa Detik Lagi Akan disiapkan, Mohon Menunggu</strong><div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            console.log(payment);
            if (payment == "" || termin == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Pilhan Yang Wajib diisi Tidak boleh Kosong",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            } else {
                $.ajax({
                    url: "{{ route('app_supp_user_token_last') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                        "payment": payment,
                        "termin": termin,
                        "faktur": faktur,
                        "rek": rek,
                    },
                    dataType: 'html',
                }).done(function (data) {
                    if (data == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Data Belum Lengkap!",
                            footer: '<a href="#">Why do I have this issue?</a>'
                        });
                    } else {
                        button.click();
                        setTimeout(() => {
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
                                icon: "success",
                                title: "Data Has been Save successfully"
                            });
                            $('#form-wizard-progress-tab4').html(data);
                        }, 3000);
                        // $('#menu-button-next').html('');
                    }
                }).fail(function () {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                });
            }
        });
        $(document).on("click", "#button-update-order", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            var id = $(this).data("id");
            $('#menu-supplier').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('app_supp_update_order') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "id": id
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-supplier').html(data);
            }).fail(function () {
                $('#menu-supplier').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-order-supp", function (e) {
            e.preventDefault();
            var data = $("#form-order-data-supplier").serialize();

            $('#menu-supplier').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );


            $.ajax({
                url: "{{ route('app_supp_simpan_order') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                $("#modal-supplier").modal('hide');
                $('#table-barang-request-order').html(data);
            }).fail(function () {
                $('#menu-supplier').html('eror');
            });
        });
    </script>

</body>

</html>
