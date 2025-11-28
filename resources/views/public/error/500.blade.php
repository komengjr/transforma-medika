<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Erorr</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
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
</head>


<body>

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
        <div class="row flex-center min-vh-100 py-6 text-center">
          <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5"><a class="d-flex flex-center mb-4" href="https://innoventra.site">
            <img class="me-2" src="{{ asset('img/favicon.png') }}" alt="" width="58" /><span class="font-sans-serif fw-bolder fs-5 d-inline-block">Innoventra</span></a>
            <div class="card">
              <div class="card-body p-4 p-sm-5">
                <div class="fw-black lh-1 text-300 fs-error">500</div>
                <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold">Whoops, something went wrong!</p>
                <hr />
                <p>Try refreshing the page, or going back and attempting the action again. If this problem persists, <a href="mailto:info@exmaple.com">contact us</a>.</p>
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
