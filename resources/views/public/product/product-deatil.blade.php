@extends('layouts.public')

@section('content')

    <section class="py-0 overflow-hidden light" id="banner">
        <div class="bg-holder overlay"
            style="background-image:url(../../../asset/img/generic/bg-2.jpg);background-position: center bottom;">
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
                        <br />Our Product
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
    <section class="px-4 py-4 shadow-sm">
        <div class="card mb-3"><img class="card-img-top" src="{{ asset('asset/img/generic/13.jpg') }}" alt="" />
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <div class="d-flex">
                            <div class="calendar me-2"><span class="calendar-month">Dec</span><span class="calendar-day">0
                                </span></div>
                            <div class="flex-1 fs--1">
                                <h5 class="fs-0">{{$data->log_m_product_name}}</h5>
                                <p class="mb-0">by <a href="#!">Admin</a></p><span class="fs-0 text-warning fw-semi-bold">
                                    @currency(mt_rand(1000000, 9999999))</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto mt-4 mt-md-0">
                        <button class="btn btn-falcon-default btn-sm me-2" type="button"><span
                                class="fas fa-heart text-danger me-1"></span>{{mt_rand(1000, 9999)}}</button>
                        <button class="btn btn-falcon-default btn-sm me-2" type="button"><span
                                class="fas fa-share-alt me-1"></span>Share</button>
                        <!-- <button class="btn btn-falcon-primary btn-sm px-4 px-sm-5" type="button">Register</button> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-8 pe-lg-2">
                <div class="card-header bg-300">
                    <h5 class="mb-0">Detail</h5>
                </div>
                <div class="card mb-3 mb-lg-0">
                    <div class="card-body">
                        @if ($desc)
                            @php
                                echo $desc->log_m_product_desc_text;
                            @endphp
                        @else
                            TIdak ada Conten
                        @endif
                        <script async
                            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
                            crossorigin="anonymous"></script>
                        <ins class="adsbygoogle1" style="display:block; text-align:center;" data-ad-layout="in-article"
                            data-ad-format="fluid" data-ad-client="ca-pub-4154628728879232" data-ad-slot="8374738170"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle1 || []).push({});
                        </script>
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4154628728879232"
                            data-ad-slot="9876543210" data-ad-format="auto" data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                        <h5 class="fs-0 mt-5 mb-2">Tags</h5>
                        <a class="badge border link-secondary me-1 text-decoration-none" href="#!">Log</a>
                        <a class="badge border link-secondary me-1 text-decoration-none" href="#!">Human Resource</a>
                        <a class="badge border link-secondary me-1 text-decoration-none" href="#!">Purchase</a>
                        <a class="badge border link-secondary me-1 text-decoration-none" href="#!">Accounting</a>
                        <h5 class="fs-0 mt-5 mb-2">Share with friends</h5>
                        <div class="icon-group">
                            <a class="icon-item text-facebook" href="#!"><span class="fab fa-facebook-f"></span></a>
                            <a class="icon-item text-twitter" href="#!"><span class="fab fa-twitter"></span></a>
                            <a class="icon-item text-google-plus" href="#!"><span class="fab fa-google-plus-g"></span></a>
                            <a class="icon-item text-linkedin" href="#!"><span class="fab fa-linkedin-in"></span></a>
                            <a class="icon-item text-700" href="#!"><span class="fab fa-medium-m"></span></a>
                        </div>
                        <div class="min-vh-50 rounded-3 mt-5">
                            <iframe style="width: 100%; height: 400px;"
                                src="https://www.youtube.com/embed/1g8nl9SAG70?si=CI0jayYHphoMC6qV"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 ps-lg-2">
                <div class="sticky-sidebar">
                    <div class="card-header bg-300">
                        <h5 class="mb-0">Date And Time</h5>
                    </div>
                    <div class="card mb-3 fs--1">
                        <div class="card-body">
                            <h6></h6>
                            <p class="mb-1">Mon, Dec 31, 2018, 11:59 PM – <br />Tue, Jan 1, 2019, 12:19 AM EST</p>
                            <a href="#!">Add to Calendar</a>
                            <h6 class="mt-4">Location</h6>
                            <div class="mb-1">Boston Harborwalk<br />Christopher Columbus Park<br />Boston, MA
                                02109<br />United States</div>
                            <a href="#view-map">View Map</a>
                            <h6 class="mt-4">Refund Policy</h6>
                            <p class="fs--1 mb-0">No Refunds</p>
                        </div>
                    </div>
                    <div class="card mb-3 mb-lg-0">
                        <div class="card-header bg-300">
                            <h5 class="mb-0">Your Order may like</h5>
                        </div>
                        <div class="card-body fs--1">
                            <div class="d-flex btn-reveal-trigger">
                                <div class="calendar"><span class="calendar-month">Feb</span><span
                                        class="calendar-day">21</span></div>
                                <div class="flex-1 position-relative ps-3">
                                    <h6 class="fs-0 mb-0"><a href="../../app/events/event-detail.html">Newmarket Nights</a>
                                    </h6>
                                    <p class="mb-1">Organized by <a href="#!" class="text-700">University of Oxford</a></p>
                                    <p class="text-1000 mb-0">Time: 6:00AM</p>
                                    <p class="text-1000 mb-0">Duration: 6:00AM - 5:00PM</p>Place: Cambridge Boat Club,
                                    Cambridge
                                    <div class="border-dashed-bottom my-3"></div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-light p-0 border-top"><a class="btn btn-link d-block w-100"
                                href="../../app/events/event-list.html">All Events<span
                                    class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->

    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="light">

        <div class="bg-holder overlay"
            style="background-image:url(../../../asset/img/generic/bg-2.jpg);background-position: center top;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <p class="fs-3 fs-sm-4 text-white">Join our community of 20,000+ developers and content creators
                        on their mission to build better sites and apps.</p>
                    <button class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2" type="button">Start
                        your webapp</button>
                </div>
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->

@endsection
