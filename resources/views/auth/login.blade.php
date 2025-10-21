<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{env('APP_LABEL')}} System Management | Login Page</title>


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
    {{--
    <script src="../../../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script> --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&display=swap');

        * {
            font-family: "Google Sans Code", monospace !important;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }
    </style>

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
    <link rel="stylesheet" href="{{ asset('asset/notifications/css/lobibox.min.css') }}" />
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
        body {
            background: linear-gradient(90deg, rgba(74, 68, 176, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);
            background-size: 300% 300%;
            animation: gradientMove 10s ease infinite;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            /* display: flex; */
            align-items: center;
            justify-content: center;
            /* overflow: hidden; */
        }

        .card {

            box-shadow: 0 30px 45px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-7 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape"
                        src="../../../asset/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img
                        class="bg-auth-circle-shape-2" src="../../../asset/img/icons/spot-illustrations/shape-1.png"
                        alt="" width="150">
                    <div class="card overflow-hidden z-index-4">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center bg-card-gradient">
                                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                        <div class="bg-holder bg-auth-card-shape"
                                            style="background-image:url(../../../asset/img/icons/spot-illustrations/half-circle.png);">
                                        </div>
                                        <!--/.bg-holder-->

                                        <div class="z-index-1 position-relative"><a
                                                class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder"
                                                href="#">{{ env('APP_NAME') }} System</a>
                                            <p class="opacity-75 text-white">With the power of Transforma, you can now
                                                focus
                                                only on functionaries for your digital products, while leaving the UI
                                                design on us!</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                                        <p class="text-white">Tidak Mempunyai Akun ?<br><a
                                                class="btn btn-outline-light mt-2 px-4"
                                                href="{{ route('register') }}"><span class="far fa-address-card">
                                                </span> Daftar Sekarang..</a>
                                        </p>
                                        <p class="mb-0 mt-4 mt-md-5 fs--1 fw-semi-bold text-white opacity-75">Read our
                                            <a class="text-decoration-underline text-white" href="#!">terms</a> and
                                            <a class="text-decoration-underline text-white" href="#!">conditions
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-5 flex-grow-1">
                                        <div class="row flex-between-center">
                                            <div class="col-auto">
                                                <h3>Account Login</h3>
                                            </div>
                                        </div>
                                        <!-- <form action="{{ route('login.post') }}" method="POST"> -->

                                        <!-- @csrf -->
                                        <div class="mb-3">
                                            <label class="form-label" for="card-email">Username</label>
                                            <input class="form-control" id="username" type="text" name="username"
                                                required autofocus />
                                            @if ($errors->has('username'))
                                                <span class="text-danger">{{ $errors->first('username') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="card-password">Password</label>
                                            </div>
                                            <input class="form-control" id="password" type="password" name="password"
                                                required />
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <span id="notifikasi-login" class="pb-0 mt-0"></span>
                                        <div class="row flex-between-center">
                                            <div class="col-auto">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="card-checkbox"
                                                        checked="checked" />
                                                    <label class="form-check-label mb-0" for="card-checkbox">Remember
                                                        me</label>
                                                </div>
                                            </div>
                                            <div class="col-auto"><a class="fs--1"
                                                    href="{{route('forget_password')}}">Forgot
                                                    Password?</a></div>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary d-block w-100 mt-3" type="button"
                                                id="button-login-system" name="submit"><span
                                                    class="fab fa-500px"></span> Log in</button>
                                        </div>
                                        <!-- </form> -->
                                        <div class="position-relative mt-4">
                                            <hr class="bg-300" />
                                            <div class="divider-content-center">or log in with</div>
                                        </div>
                                        <div class="row g-2 mt-2">
                                            <div class="col-sm-6"><a
                                                    class="btn btn-outline-google-plus btn-sm d-block w-100"
                                                    href="#"><span class="fab fa-google-plus-g me-2"
                                                        data-fa-transform="grow-8"></span> google</a></div>
                                            <div class="col-sm-6"><a
                                                    class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span
                                                        class="fab fa-facebook-square me-2"
                                                        data-fa-transform="grow-8"></span> facebook</a></div>
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
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <!-- <div class="toast hide notice shadow-none bg-transparent my-2" id="cookie-notice" role="alert"
                                        data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":20}' data-autohide="false"
                                        aria-live="assertive" aria-atomic="true" style="">
                                        <div class="toast-body my-2 ms-1 md-2">
                                            <div class="card border-2 border-secondary">
                                                <div class="card-body ">
                                                    <div class="d-flex">
                                                        <div class="pe-3"><img src="{{ asset('asset/img/icons/alert.png') }}" width="40" alt="cookie" />
                                                        </div>
                                                        <div>
                                                            <p>{{ session('success') }}</p>
                                                            <button class="btn btn-sm btn-falcon-primary me-3" type="button" data-bs-dismiss="toast"
                                                                aria-label="Close">Okay</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
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
                title: "{{ session('success') }}"
            });
        </script>
    @endif
    <script>
        $(document).on("click", "#button-login-system", function (e) {
            e.preventDefault();
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            $('#button-login-system').html(
                '<div class="spinner-border my-0" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            if (username == "" || password == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#button-login-system').html('<span class="fab fa-500px"></span> Log in');
            } else {
                $.ajax({
                    url: "{{ route('verifikasi_Login') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "username": username,
                        "password": password
                    },
                    dataType: 'html',
                }).done(function (data) {
                    $('#notifikasi-login').html(data);
                    $('#button-login-system').html('<span class="fab fa-500px"></span> Log in');
                }).fail(function () {
                    console.log('error');

                });
            }
        });
    </script>
</body>

</html>
