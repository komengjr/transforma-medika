@extends('layouts.public')

@section('content')
    <style>
        .about-header {
            text-align: center;
            padding: 80px 20px 40px;
        }

        .about-header h1 {
            font-weight: 700;
            color: #f9d342;
        }

        .about-content {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            line-height: 1.8;
        }

        footer {
            text-align: center;
            padding: 30px 10px;
            color: #aaa;
            font-size: 0.9rem;
            border-top: 1px solid #222;
            margin-top: 50px;
        }

        a {
            color: #f9d342;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <section class="py-0 overflow-hidden light" id="banner">
        <div class="bg-holder overlay"
            style="background-image:url(../asset/img/generic/bg-2.jpg);background-position: center bottom;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
            <div class="row pt-7 pt-lg-8 pb-lg-0 pb-xl-0">
                <div class="col-md-11 col-lg-8 col-xl-4 pb-2 pb-xl-3 text-center text-xl-start"><a
                        class="btn btn-outline-danger mb-4 fs--1 border-2 rounded-pill" href="#!"><span class="me-2"
                            role="img" aria-label="Gift">🎁</span>Become a pro</a>
                    <h2 class="text-white fw-light"><strong>Innoventra</strong>
                        <!-- <small>
                                                                                <span class="typed-text fw-bold"
                                                                                    data-typed-text='["Human","Resource","Management","System"]'></span>
                                                                            </small> -->
                        <br />About
                    </h2>

                </div>
                <div class="col-xl-7 offset-xl-1">
                    <!-- <a class="img-landing-banner rounded" href="../index.html"><img class="img-fluid"
                                                                            src="{{ asset('img/ilus.png') }}" alt="" width="500" /></a> -->
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>

    <!-- <section> begin ============================-->
    <section class="py-3 pb-0 bg-light shadow-sm">

        <div class="container">
            <div class="row flex-center">
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40"
                        src="{{ asset('asset/img/logos/b&w/6.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="45"
                        src="{{ asset('asset/img/logos/b&w/11.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="30"
                        src="{{ asset('asset/img/logos/b&w/1.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="30"
                        src="{{ asset('asset/img/logos/b&w/4.png') }}" alt="" /></div>
                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="35"
                        src="{{ asset('asset/img/logos/b&w/10.png') }}" alt="" /></div>
                <!-- <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40"
                                                                                                                        src="{{ asset('asset/img/logos/b&w/9.png') }}" alt="" /></div>
                                                                                                                <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><img class="landing-cta-img" height="40"
                                                                                                                        src="{{ asset('asset/img/logos/b&w/8.png') }}" alt="" /></div> -->
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->

    <!-- ============================================-->
    <!-- <section> begin ============================-->

    <section class="about-content">
        <p>
            <strong>Innoventra Stream</strong> adalah platform streaming dan informasi film yang dibuat untuk
            para pecinta film di seluruh dunia. Kami menyediakan daftar film terbaru, trailer, serta informasi lengkap
            tentang setiap judul agar Anda bisa menemukan tontonan yang sesuai dengan selera Anda.
        </p>

        <p>
            Didirikan oleh tim yang bersemangat dalam dunia hiburan dan teknologi, kami berkomitmen untuk memberikan
            pengalaman terbaik dalam menjelajahi film – mulai dari rekomendasi personal hingga tampilan yang cepat dan
            responsif.
        </p>

        <p>
            Kami percaya bahwa setiap film memiliki cerita, dan kami ingin membantu Anda menemukannya dengan mudah.
            Kami terus mengembangkan fitur-fitur baru agar pengguna dapat menikmati konten tanpa hambatan.
        </p>

        <p>
            <strong>Hubungi kami</strong> melalui halaman <a href="/contact">Kontak</a> untuk saran, kritik, atau kerja
            sama.
        </p>

        <div class="mt-5 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/3126/3126647.png" alt="Movie Icon" width="100">
            <h4 class="mt-3 text-warning">Terima kasih telah mengunjungi Innoventra Stream!</h4>
        </div>
    </section>


@endsection
