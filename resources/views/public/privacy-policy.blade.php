@extends('layouts.public')

@section('content')
    <style>
        .content {
            max-width: 900px;
            margin: auto;
            padding: 40px 20px;
            line-height: 1.8;
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
                        <br />Privacy Policy
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

    <section class="content">
        <h1>Kebijakan Privasi</h1>
        <p>Terakhir diperbarui: 10 November 2025</p>

        <p>Selamat datang di <strong>Innoventra Stream</strong>. Kami menghargai privasi Anda dan berkomitmen untuk
            melindungi informasi pribadi yang Anda berikan saat menggunakan situs ini.</p>

        <h3>1. Informasi yang Kami Kumpulkan</h3>
        <p>Kami dapat mengumpulkan informasi pribadi seperti nama, alamat email, atau data penggunaan (seperti halaman yang
            dikunjungi) untuk meningkatkan pengalaman pengguna.</p>

        <h3>2. Penggunaan Informasi</h3>
        <p>Informasi digunakan untuk:
        <ul>
            <li>Meningkatkan kualitas layanan.</li>
            <li>Menampilkan iklan yang relevan melalui Google AdSense.</li>
            <li>Menganalisis statistik pengunjung.</li>
        </ul>
        </p>

        <h3>3. Cookie dan Teknologi Pelacakan</h3>
        <p>Situs kami menggunakan cookie dari Google dan mitra pihak ketiga untuk menayangkan iklan berdasarkan kunjungan
            pengguna sebelumnya. Anda dapat menonaktifkan cookie melalui pengaturan browser Anda.</p>

        <h3>4. Iklan Google AdSense</h3>
        <p>Google menggunakan cookie DART untuk menayangkan iklan kepada pengguna berdasarkan kunjungan mereka ke situs kami
            dan situs lainnya di internet. Pengguna dapat menonaktifkan penggunaan cookie DART dengan mengunjungi <a
                href="https://policies.google.com/technologies/ads" target="_blank">Kebijakan Privasi Google</a>.</p>

        <h3>5. Keamanan Data</h3>
        <p>Kami berupaya menjaga keamanan data Anda namun tidak ada metode transmisi data di internet yang 100% aman.</p>

        <h3>6. Perubahan Kebijakan</h3>
        <p>Kami dapat memperbarui kebijakan ini dari waktu ke waktu. Perubahan akan diumumkan di halaman ini dengan tanggal
            pembaruan terbaru.</p>

        <p>Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami melalui halaman <a
                href="/contact">Kontak</a>.</p>
    </section>


@endsection
