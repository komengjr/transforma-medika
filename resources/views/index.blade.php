@extends('layouts.public')

@section('content')

    <section class="py-0 overflow-hidden light" id="banner">
        <div class="bg-holder overlay"
            style="background-image:url(../asset/img/generic/bg-2.jpg);background-position: center bottom;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
            <div class="row flex-center pt-8 pt-lg-10 pb-lg-9 pb-xl-0">
                <div class="col-md-11 col-lg-8 col-xl-4 pb-7 pb-xl-9 text-center text-xl-start"><a
                        class="btn btn-outline-danger mb-4 fs--1 border-2 rounded-pill" href="#!"><span class="me-2"
                            role="img" aria-label="Gift">🎁</span>Become a pro</a>
                    <h2 class="text-white fw-light"><strong>Innoventra</strong> <small> <span class="typed-text fw-bold"
                                data-typed-text='["Accounting","Logistik","Purchasing","Resourcing"]'></span></small><br />Build
                        your
                        webapp</h2>
                    <p class="lead text-white opacity-75 text-justify">Lorem ipsum dolor sit amet consectetur
                        adipisicing elit.
                        Adipisci officiis at minus non atque id iure saepe ipsum, explicabo, optio quam!.!</p><a
                        class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2" href="#!">Start
                        building with the falcon<span class="fas fa-play ms-2"
                            data-fa-transform="shrink-6 down-1"></span></a>
                </div>
                <div class="col-xl-7 offset-xl-1 align-self-end mt-4 mt-xl-0"><a class="img-landing-banner rounded"
                        href="../index.html"><img class="img-fluid" src="{{ asset('asset/img/generic/dashboard-alt.png') }}"
                            alt="" /></a></div>
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
                    <h1 class="fs-2 fs-sm-4 fs-md-5">WebApp theme of the future</h1>
                    <p class="lead">Built on top of Bootstrap 5, Lorem ipsum dolor sit amet consectetur, adipisicing
                        elit. Ab, voluptate nam. Porro ipsum architecto doloremque consequatur sit labore asperiores
                        ratione corporis, autem odit quae cumque, sed error nesciunt nihil excepturi!.</p>
                </div>
            </div>
            <div class="row flex-center mt-8">
                <div class="col-md col-lg-5 col-xl-4 ps-lg-6"><img class="img-fluid px-6 px-md-0"
                        src="{{ asset('asset/img/icons/spot-illustrations/50.png') }}" alt="" /></div>
                <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                    <h5 class="text-danger"><span class="far fa-lightbulb me-2"></span>PLAN</h5>
                    <h3>Blueprint &amp; design </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor corporis dicta nemo beatae
                        sapiente architecto enim quam laborum quis qui veniam explicabo excepturi odit repudiandae,
                        at numquam sint ullam dolorum..</p>
                </div>
            </div>
            <div class="row flex-center mt-7">
                <div class="col-md col-lg-5 col-xl-4 pe-lg-6 order-md-2"><img class="img-fluid px-6 px-md-0"
                        src="{{ asset('asset/img/icons/spot-illustrations/49.png') }}" alt="" /></div>
                <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                    <h5 class="text-info"> <span class="far fa-object-ungroup me-2"></span>BUILD</h5>
                    <h3>38 Sets of components</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta quisquam inventore rem harum
                        praesentium, maxime, ad dolore dolores assumenda id optio corrupti. Dolorem inventore soluta
                        dolore, nostrum facilis ducimus nisi!.</p>
                </div>
            </div>
            <div class="row flex-center mt-7">
                <div class="col-md col-lg-5 col-xl-4 ps-lg-6"><img class="img-fluid px-6 px-md-0"
                        src="{{ asset('asset/img/icons/spot-illustrations/48.png') }}" alt="" /></div>
                <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0">
                    <h5 class="text-success"><span class="far fa-paper-plane me-2"></span>DEPLOY</h5>
                    <h3>Review and test</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis unde numquam commodi
                        assumenda molestias itaque expedita architecto consequatur corporis distinctio cum
                        laudantium accusantium corrupti aspernatur excepturi, aliquid veritatis deserunt amet..</p>
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
                    <p class="lead">Things you will get right out of the box with Innoventra.</p>
                </div>
            </div>
            <div class="row mt-6">
                <div class="col-lg-4">
                    <div class="card card-span h-100">
                        <div class="card-span-img"><span class="fab fa-sass fs-4 text-info"></span></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">Bootstrap 5.x</h5>
                            <p>Build your webapp with the world's most popular front-end component library along
                                with Innoventra's 32 sets of carefully designed elements.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-6 mt-lg-0">
                    <div class="card card-span h-100">
                        <div class="card-span-img"><span class="fab fa-node-js fs-5 text-success"></span></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">SCSS &amp; Javascript files</h5>
                            <p>With your purchased copy of Innoventra, you will get all the uncompressed &
                                documented
                                SCSS and Javascript source code files.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-6 mt-lg-0">
                    <div class="card card-span h-100">
                        <div class="card-span-img"><span class="fab fa-gulp fs-6 text-danger"></span></div>
                        <div class="card-body pt-6 pb-4">
                            <h5 class="mb-2">Gulp based workflow</h5>
                            <p>All the painful or time-consuming tasks in your development workflow such as
                                compiling the SCSS or transpiring the JS are automated.</p>
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
    <section class="light">

        <div class="bg-holder overlay"
            style="background-image:url(../asset/img/generic/bg-2.jpg);background-position: center top;">
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
