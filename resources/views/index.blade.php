@extends('layouts.public')

@section('content')

    <section class="py-0 overflow-hidden light" id="banner">
        <div class="bg-holder overlay"
            style="background-image:url(../asset/img/generic/bg-2.jpg);background-position: center bottom;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
            <div class="row flex-center pt-8 pt-lg-8 pb-lg-9 pb-xl-0">
                <div class="col-md-11 col-lg-8 col-xl-4 pb-7 pb-xl-9 text-center text-xl-start"><a
                        class="btn btn-outline-danger mb-4 fs--1 border-2 rounded-pill" href="#!"><span class="me-2"
                            role="img" aria-label="Gift">🎁</span>Become a pro</a>
                    <h2 class="text-white fw-light"><strong>Innoventra</strong> <small> <span class="typed-text fw-bold"
                                data-typed-text='["System","Movie","Product","Blog"]'></span></small><br />

                    </h2>
                    <p class="lead text-white opacity-75 text-justify">Di Innoventra, kami percaya bahwa inovasi adalah
                        bahan bakar utama kemajuan. Kami hadir untuk menciptakan produk dan layanan digital yang tidak hanya
                        canggih, tapi juga memberi nilai nyata bagi pengguna.</p><a
                        class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2"
                        href="{{route('movies.index')}}">Watch Movie<span class="fas fa-play ms-2"
                            data-fa-transform="shrink-6 down-1"></span></a>
                </div>
                <div class="col-xl-7 offset-xl-1  mt-0 mt-xl-0"><a class="img-landing-banner rounded"
                        href="{{ route('login') }}"><img class="img-fluid"
                            src="{{ asset('asset/img/generic/dashboard-alt.png') }}" alt="" /></a>
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-3 bg-light shadow-sm">

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




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section>

        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <h1 class="fs-2 fs-sm-4 fs-md-5">Innoventra</h1>
                    <p class="lead">platform inovasi digital yang berfokus pada pengembangan solusi cerdas untuk menjawab
                        tantangan era modern. Kami menghadirkan teknologi yang efisien, terukur, dan berdampak nyata — mulai
                        dari sistem berbasis web, otomasi, hingga integrasi data.
                        Dengan semangat innovation meets venture, kami berkomitmen untuk menjadi mitra strategis dalam
                        mempercepat transformasi digital di berbagai sektor industri.</p>
                </div>
            </div>
            <div class="row flex-center mt-8">
                <div class="col-md col-lg-5 col-xl-4 ps-lg-6"><img class="img-fluid px-6 px-md-0"
                        src="{{ asset('asset/img/icons/spot-illustrations/50.png') }}" alt="" /></div>
                <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                    <h5 class="text-danger"><span class="far fa-lightbulb me-2"></span>Plan</h5>
                    <h3>1. Visi Utama</h3>
                    <p>Mewujudkan ekosistem teknologi inovatif yang mampu mempercepat transformasi digital di berbagai
                        sektor — bisnis, pemerintahan, pendidikan, dan masyarakat umum — melalui solusi yang efisien, aman,
                        dan terintegrasi.</p>
                </div>
            </div>
            <div class="row flex-center mt-7">
                <div class="col-md col-lg-5 col-xl-4 pe-lg-6 order-md-2"><img class="img-fluid px-6 px-md-0"
                        src="{{ asset('asset/img/icons/spot-illustrations/49.png') }}" alt="" /></div>
                <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                    <h5 class="text-info"> <span class="far fa-object-ungroup me-2"></span>BUILD</h5>
                    <h3>2. Misi Pengembangan</h3>
                    <p>Untuk mencapai visi tersebut, Innoventra berkomitmen menjalankan misi jangka pendek dan jangka
                        panjang yang terukur:</p>
                    <p>

                    </p>
                </div>
            </div>
            <div class="row flex-center mt-7">
                <div class="col-md col-lg-5 col-xl-4 ps-lg-6"><img class="img-fluid px-6 px-md-0"
                        src="{{ asset('asset/img/icons/spot-illustrations/48.png') }}" alt="" /></div>
                <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                    <h5 class="text-success"><span class="far fa-paper-plane me-2"></span>FOCUS</h5>
                    <h3>3. Fokus Pengembangan Produk</h3>
                    <p>
                    <ul>
                        <li>Pengembangan aplikasi dan sistem berbasis web & mobile yang efisien, scalable, dan mudah
                            diintegrasikan.</li>
                        <li>Implementasi kecerdasan buatan untuk efisiensi operasional, analitik prediktif, dan pengambilan
                            keputusan berbasis data.</li>
                        <li>Penyediaan layanan cloud yang aman, cepat, dan fleksibel dengan analisis data real-time.</li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="bg-light text-center">

        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="fs-2 fs-sm-4 fs-md-5">Here's what's in it for you</h1>
                    <p class="lead">Untuk mencapai visi tersebut, Innoventra berkomitmen menjalankan misi jangka pendek dan
                        jangka panjang yang terukur:</p>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-lg-4">
                    <div class="card card-span h-100">
                        <div class="card-span-img"><span class="fas fa-tags fs-4 text-info"></span></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">Jangka Pendek (0–1 Tahun)</h5>
                            <ul>
                                <li>Membangun fondasi platform digital dan infrastruktur teknologi internal.</li>
                                <li>Meluncurkan produk dan layanan inti (MVP / versi awal).</li>
                                <li>Meningkatkan kualitas antarmuka dan pengalaman pengguna (UI/UX).</li>
                                <li>Menjalin kerja sama strategis dengan mitra bisnis dan komunitas teknologi.</li>
                                <li>Memperkuat brand awareness dan kepercayaan pengguna.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-6 mt-lg-0">
                    <div class="card card-span h-100">
                        <div class="card-span-img"><span class="fas fa-tasks fs-5 text-success"></span></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">Jangka Menengah (1–3 Tahun)</h5>
                            <ul>
                                <li>Mengembangkan ekosistem layanan berbasis AI dan otomasi bisnis. </li>
                                <li>Menyediakan solusi customizable untuk sektor korporasi dan UMKM.</li>
                                <li>Meluncurkan dashboard analitik dan integrasi data lintas platform.</li>
                                <li>Meningkatkan kehadiran di pasar nasional dan memperluas jaringan mitra.</li>
                                <li>Menerapkan sistem keamanan data dan privasi berstandar internasional (ISO/GDPR compliant).</li>
                            </ul>
                            <p>

                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-6 mt-lg-0">
                    <div class="card card-span h-100">
                        <div class="card-span-img"><span class="fab fa-github-alt fs-6 text-danger"></span></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">Jangka Panjang (3–5 Tahun)</h5>

                            <ul>
                                <li>Menjadi leader teknologi inovatif di Asia Tenggara.</li>
                                <li>Menciptakan platform digital terpadu yang menghubungkan inovator, pengguna, dan pelaku bisnis.</li>
                                <li>Mengembangkan produk berbasis AI, cloud, dan blockchain untuk otomasi lintas industri.</li>
                                <li>Membangun pusat riset dan inovasi (Innoventra Labs).</li>
                                <li>Mendorong kolaborasi global untuk menciptakan solusi berkelanjutan dan berdampak sosial.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->


    <!-- ============================================-->
    <!-- <section> begin ============================-->

    <!-- <section> close ============================-->
    <!-- ============================================-->


@endsection
