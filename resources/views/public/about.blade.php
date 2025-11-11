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

            Di Innoventra, kami percaya bahwa inovasi adalah bahan bakar utama kemajuan. Kami hadir untuk menciptakan produk
            dan layanan digital yang tidak hanya canggih, tapi juga memberi nilai nyata bagi pengguna.
            Melalui kolaborasi, kreativitas, dan teknologi mutakhir, kami membangun masa depan yang lebih efisien, cerdas,
            dan berkelanjutan.
        </p>
        <p>

            Innoventra merupakan ekosistem teknologi yang menggabungkan innovation dan entrepreneurship dalam satu langkah
            maju. Kami mengembangkan solusi berbasis AI, cloud, dan otomasi untuk membantu bisnis bertransformasi secara
            digital.
            Setiap proyek kami dirancang dengan pendekatan data-driven, user-centric, dan scalable — agar setiap inovasi
            dapat tumbuh bersama kebutuhan dunia modern.
        </p>

        <p>
            Innoventra adalah ruang di mana ide berubah menjadi solusi. Kami menggabungkan teknologi, kreativitas, dan
            strategi bisnis untuk menciptakan inovasi yang berdampak dan berkelanjutan.
        </p>

        <p>
            nnoventra adalah perusahaan pengembang solusi digital yang berfokus pada inovasi, efisiensi, dan transformasi
            teknologi. Terinspirasi dari dua kata — Innovation dan Venture — kami hadir sebagai wadah bagi ide-ide kreatif
            untuk tumbuh menjadi produk dan layanan yang berdampak nyata.
        </p>

        <p>
            Kami percaya bahwa teknologi bukan hanya alat, tetapi katalisator perubahan menuju masa depan yang lebih cerdas,
            efisien, dan berkelanjutan. Dengan menggabungkan kekuatan Artificial Intelligence, cloud computing, otomasi
            sistem, dan pengalaman pengguna yang intuitif, Innoventra menghadirkan solusi digital yang membantu bisnis
            beradaptasi dan berkembang di era digital yang serba cepat ini.
        </p>
        <p>
            <strong>🚀 Visi Kami</strong>
            Menjadi pelopor dalam menghadirkan solusi teknologi inovatif yang mendorong percepatan transformasi digital di
            berbagai sektor — dari bisnis, pemerintahan, hingga pendidikan.
        </p>

        <strong>🎯 Misi Kami</strong>
        <ul>
            <li>Mengembangkan produk dan layanan digital yang berorientasi pada kebutuhan pengguna.</li>
            <li>Menghadirkan solusi teknologi yang efisien, aman, dan mudah diintegrasikan.</li>
            <li>Menjadi mitra strategis bagi organisasi yang ingin berinovasi dan meningkatkan daya saing melalui
                transformasi digital.</li>
            <li>Membangun ekosistem yang menghubungkan inovator, pengembang, dan pelaku usaha untuk menciptakan dampak
                positif yang berkelanjutan..</li>
        </ul>

        <strong>🎯 Bidang Keahlian</strong>
        <ul>
            <li>Pengembangan Sistem & Aplikasi: Web apps, mobile apps, dashboard analytics, dan solusi berbasis AI.</li>
            <li>Integrasi Teknologi: Cloud system, IoT, dan API integration untuk mendukung proses bisnis lintas platform.
            </li>
            <li>Otomasi & Data Intelligence: Meningkatkan efisiensi dengan analisis data, machine learning, dan automasi
                proses kerja.</li>
            <li>Digital Experience Design: Merancang antarmuka dan pengalaman pengguna yang intuitif, menarik, dan efektif.
            </li>
        </ul>
        <strong>🌍 Kenapa Memilih Innoventra</strong>
        <p>
            Karena bagi kami, setiap proyek bukan sekadar produk — melainkan perjalanan inovasi. Kami mendampingi klien dari
            tahap ide hingga implementasi, memastikan setiap solusi benar-benar memberi nilai tambah dan siap menghadapi
            tantangan masa depan.
        </p>
        <p>
            Dengan tim yang berpengalaman, berpikir visioner, dan berkomitmen terhadap kualitas, Innoventra menjadi mitra
            terpercaya dalam mewujudkan transformasi digital yang berkelanjutan.
        </p>
        <div class="mt-5 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/3126/3126647.png" alt="Movie Icon" width="100">
            <h4 class="mt-3 text-warning">Terima kasih telah mengunjungi Innoventra!</h4>
        </div>
    </section>


@endsection
