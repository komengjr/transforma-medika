<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registrasi | Event {{ $event->event_data_tittle }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url($event->event_data_template) }}">
    <link rel="manifest" href="{{ asset('asset/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/notifications/css/lobibox.min.css') }}" />

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Saira+Stencil+One&display=swap" rel="stylesheet">
    <script async src="https://fundingchoicesmessages.google.com/i/pub-4154628728879232?ers=1"></script>
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
        .card-opacity {
            background-color: rgba(255, 255, 255, 0.95);
            border: none;
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
                <div class="col-lg-8 col-xxl-5 py-3 position-relative">
                    <img class="bg-auth-circle-shape" src="{{asset('asset/img/icons/spot-illustrations/bg-shape.png')}}" alt="" width="250">
                    <img class="bg-auth-circle-shape-2" src="{{ asset('asset/img/icons/spot-illustrations/shape-1.png') }}" alt="" width="150">
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0 ">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center position-relative light" style='background:url("{{ Storage::url($event->event_data_template) }}") no-repeat center center / cover;'>
                                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                        <!-- <div class="bg-holder bg-auth-card-shape" >
                                        </div> -->
                                        <!--/.bg-holder-->

                                        <div class="card p-2 card-opacity">
                                            <div class="z-index-1 position-relative">
                                                <strong class="link-light mb-2 font-sans-serif fs-2 d-inline-block fw-bolder text-linkedin" href="#">{{ $event->event_data_tittle }}</strong>
                                                <p class="opacity-75 text-primary">{{$event->event_data_desc}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 mb-4 mt-md-7 mb-md-2 light">
                                        <p class="pt-3 text-danger">Ada Terjadi Masalah ?<br><a class="btn btn-primary mt-2 px-4" href="#">Hubungi Panitia</a></p>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-5 flex-grow-1">
                                        <h3>Register Event</h3>
                                        <form class="row g-1">
                                            <div class="col-md-2">
                                                <label class="form-label" for="card-name"><small>Title Depan</small></label>
                                                <input class="form-control" type="text" autocomplete="on" id="card-name" />
                                            </div>
                                            <div class="col-md-7">
                                                <label class="form-label" for="card-name">Name Lengkap <small class="text-danger">Wajib diisi</small></label>
                                                <input class="form-control" type="text" autocomplete="on" id="card-name" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="card-name"><small>Title Belakang</small></label>
                                                <input class="form-control" type="text" autocomplete="on" id="card-name" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="card-email">Email address</label>
                                                <input class="form-control" type="email" autocomplete="on" id="card-email" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="card-email">No Whatsapp</label>
                                                <input class="form-control" type="email" autocomplete="on" id="card-email" />
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="card-email">Pilih Sub Event</label>
                                                <table class="table table-bordered mt-0 bg-white dark__bg-1100" border="1">
                                                    <thead>
                                                        <tr class="fs--1 bg-300">
                                                            <th>Nama Sub Event</th>
                                                            <th>Type Event</th>
                                                            <th>Pilih</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($subevent as $subevents)
                                                        <tr>
                                                            <td>
                                                                {{$subevents->event_data_sub_name}}
                                                            </td>
                                                            <td>
                                                                Free
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <div class="form-check mb-0">
                                                                    <input class="form-check-input float-none" id="customRadio1" type="checkbox" name="customRadio">
                                                                    <label class="form-check-label" for="customRadio1"></label>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="card-register-checkbox" />
                                                <label class="form-label" for="card-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                                            </div>
                                        </form>

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
    <script src="{{ asset('vendors/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('vendors/typed.js/typed.js')}}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
