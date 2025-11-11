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
            <h1 class="mb-4">📜 Ketentuan Layanan — Innoventra</h1>
            <p><strong>Terakhir diperbarui:</strong> 10 November 2025</p>


            <p>Selamat datang di <strong>Innoventra</strong>
            </p>
            <p>
                Dengan mengakses dan menggunakan layanan kami — baik melalui situs web, aplikasi, maupun platform lain yang
                dimiliki oleh Innoventra — Anda setuju untuk terikat oleh Ketentuan Layanan ini serta semua peraturan yang
                berlaku.
                Harap membaca dengan seksama sebelum menggunakan layanan kami.
            </p>
            <h4>1. Penerimaan Ketentuan</h4>
            <p>
                Dengan menggunakan layanan Innoventra, Anda menyatakan bahwa:
            </p>
            <ul>
                <li>Anda telah membaca, memahami, dan menyetujui semua isi dalam Ketentuan Layanan ini.</li>
                <li>Anda berusia minimal 18 tahun, atau menggunakan layanan dengan izin dari orang tua/wali yang sah.</li>
                <li>Jika Anda menggunakan layanan atas nama organisasi atau perusahaan, maka Anda berwenang untuk mengikat
                    entitas tersebut dengan ketentuan ini.</li>
            </ul>
            <p>Jika Anda tidak setuju dengan bagian mana pun dari ketentuan ini, mohon untuk tidak menggunakan layanan kami.
            </p>
            <h4>2. Layanan Kami</h4>
            <p>Innoventra menyediakan berbagai solusi teknologi, termasuk namun tidak terbatas pada:</p>
            <ul>
                <li>Pengembangan aplikasi dan sistem digital</li>
                <li>Layanan berbasis web, AI, dan otomasi</li>
                <li>Platform analitik, integrasi data, dan layanan konsultasi teknologi</li>
            </ul>
            <p>Kami dapat menambah, mengubah, atau menghentikan sebagian atau seluruh layanan kapan pun, dengan atau tanpa
                pemberitahuan terlebih dahulu, sesuai kebutuhan operasional kami.</p>
            <h4>3. Penggunaan yang Diperbolehkan</h4>
            <p>
                Anda setuju untuk menggunakan layanan kami hanya untuk tujuan yang sah dan sesuai hukum yang berlaku.
                Anda dilarang untuk:
            </p>
            <ul>
                <li>Menggunakan layanan untuk aktivitas ilegal, penipuan, atau pelanggaran hak cipta dan privasi pihak lain.
                </li>
                <li>Mengunggah atau mendistribusikan konten yang mengandung virus, malware, atau program berbahaya.</li>
                <li>Mencoba mengakses sistem, server, atau data tanpa izin resmi.</li>
                <li>Menggunakan layanan dengan cara yang dapat mengganggu, merusak, atau membebani infrastruktur Innoventra.
                </li>
            </ul>
            <h4>4. Akun dan Keamanan</h4>
            <p>Beberapa layanan Innoventra mungkin memerlukan akun pengguna. Anda bertanggung jawab untuk:</p>
            <ul>
                <li>Menjaga kerahasiaan informasi login Anda.</li>
                <li>Menjamin bahwa semua data yang Anda berikan benar, akurat, dan mutakhir.</li>
                <li>Memberitahu kami segera jika terjadi akses tidak sah atau pelanggaran keamanan akun.</li>
            </ul>
            <p>Kami tidak bertanggung jawab atas kehilangan atau kerugian akibat kelalaian Anda dalam menjaga keamanan akun.
            </p>

            <h4>5. Kepemilikan dan Hak Kekayaan Intelektual</h4>

            <p>
                Seluruh konten, kode, desain, dan elemen visual dalam layanan Innoventra dilindungi oleh hak cipta dan
                peraturan kekayaan intelektual. Anda tidak diperbolehkan untuk menyalin, memodifikasi, menjual, atau
                mendistribusikan sebagian atau seluruh materi dari layanan kami tanpa izin tertulis dari Innoventra.
            </p>

            <h4>6. Konten Pengguna</h4>

            <p>Jika Anda mengunggah, mengirim, atau membagikan konten melalui layanan kami:</p>

            <ul>
                <li>Anda memberikan Innoventra hak non-eksklusif, bebas royalti, dan berlaku global untuk menggunakan,
                    menyimpan, atau menampilkan konten tersebut guna mendukung layanan.</li>
                <li>Anda bertanggung jawab penuh atas isi konten tersebut, termasuk kepemilikan hak cipta dan legalitasnya.
                </li>
                <li>Innoventra berhak menghapus konten yang dianggap melanggar hukum atau kebijakan kami.</li>
            </ul>

            <h4>7. Batasan Tanggung Jawab</h4>
            <p>Innoventra berupaya memberikan layanan dengan kualitas terbaik, namun:</p>
            <ul>
                <li>Kami tidak menjamin bahwa layanan akan selalu bebas dari gangguan, kesalahan, atau downtime.</li>
                <li>Innoventra tidak bertanggung jawab atas kehilangan data, kerugian finansial, atau kerusakan akibat
                    penggunaan layanan, kecuali diatur secara tegas oleh hukum yang berlaku.</li>
                <li>Penggunaan layanan sepenuhnya menjadi tanggung jawab pengguna.</li>
            </ul>

            <h4>8. Perubahan Ketentuan</h4>

            <p>
                Kami dapat memperbarui atau mengubah Ketentuan Layanan ini kapan pun untuk menyesuaikan dengan perkembangan
                hukum dan teknologi. Perubahan akan diberitahukan melalui halaman ini, dan versi terbaru akan menggantikan
                versi sebelumnya. Penggunaan berkelanjutan terhadap layanan setelah perubahan berarti Anda menyetujui versi
                terbaru dari ketentuan ini.
            </p>










            <h4>9. Penghentian Akses</h4>

            <p>Innoventra berhak untuk menangguhkan atau menghentikan akses pengguna ke layanan jika ditemukan:</p>

            <ul>
                <li>Pelanggaran terhadap ketentuan layanan</li>
                <li>Aktivitas ilegal, penyalahgunaan, atau pelanggaran hak pihak lain</li>
                <li>Permintaan dari pihak berwenang yang sah</li>
            </ul>
            <p>Kami juga dapat menghentikan layanan kapan pun tanpa kewajiban kompensasi, jika diperlukan untuk alasan
                keamanan atau operasional.</p>






            <h4>10. Hukum yang Berlaku</h4>

            <p>
                Ketentuan ini diatur dan ditafsirkan sesuai dengan hukum Republik Indonesia.
                Segala sengketa yang timbul akan diselesaikan melalui musyawarah, dan jika tidak tercapai kesepakatan, akan
                diselesaikan melalui jalur hukum sesuai ketentuan yang berlaku di Indonesia.
            </p>


        </div>
    </section>


@endsection
