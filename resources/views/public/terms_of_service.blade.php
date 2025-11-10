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
                        <br />Terms of Service
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
        <div class="container">
            <h1 class="mb-4">Ketentuan Layanan</h1>
            <p><strong>Terakhir diperbarui:</strong> 10 November 2025</p>

            <h2>1. Penerimaan Ketentuan</h2>
            <p>
                Dengan mengakses dan menggunakan situs <strong>Innoventra Stream</strong> (“Kami”, “Situs”, atau “Layanan”),
                Anda dianggap telah membaca, memahami, dan menyetujui seluruh ketentuan dan syarat yang tercantum di halaman
                ini.
                Jika Anda tidak setuju dengan salah satu bagian dari ketentuan ini, mohon untuk tidak menggunakan situs
                kami.
            </p>

            <h2>2. Penggunaan Layanan</h2>
            <p>
                Situs ini disediakan untuk tujuan informasi dan hiburan. Kami berhak menolak atau menghentikan akses
                pengguna
                yang melanggar hukum, menggunakan konten secara tidak sah, atau mengganggu kenyamanan pengguna lain.
            </p>

            <h2>3. Hak Kekayaan Intelektual</h2>
            <p>
                Semua konten di situs ini (termasuk teks, gambar, dan desain) adalah milik Innoventra Stream atau pemilik
                sahnya.
                Anda tidak diperkenankan menyalin, mendistribusikan, atau memodifikasi konten tanpa izin tertulis.
            </p>

            <h2>4. Konten Film & Hak Cipta</h2>
            <p>
                Kami tidak menyimpan file video atau film di server kami. Semua konten video bersumber dari platform pihak
                ketiga
                yang legal dan memiliki hak distribusi. Jika ada pelanggaran hak cipta, silakan hubungi kami melalui halaman
                <a href="/contact">Kontak</a>.
            </p>

            <h2>5. Penafian (Disclaimer)</h2>
            <p>
                Innoventra Stream tidak bertanggung jawab atas kesalahan, kehilangan data, atau kerusakan akibat penggunaan
                situs.
                Kami berusaha menyediakan informasi yang akurat, tetapi tidak menjamin keakuratan dan kelengkapan seluruh
                konten.
            </p>

            <h2>6. Perubahan Ketentuan</h2>
            <p>
                Kami dapat mengubah Ketentuan Layanan ini kapan saja tanpa pemberitahuan sebelumnya.
                Versi terbaru akan selalu dipublikasikan di halaman ini dengan tanggal pembaruan.
            </p>

            <h2>7. Kontak Kami</h2>
            <p>
                Untuk pertanyaan tentang Ketentuan Layanan ini, Anda dapat menghubungi kami melalui halaman
                <a href="/contact">Kontak</a>.
            </p>
        </div>
    </section>


@endsection
