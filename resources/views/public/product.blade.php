@extends('layouts.public')

@section('content')

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
        <div class="card mb-3">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-sm-auto mb-2 mb-sm-0">
                        <h6 class="mb-0">Showing x Products</h6>
                    </div>
                    <div class="col-sm-auto">
                        <div class="row gx-2 align-items-center">
                            <div class="col-auto">
                                <form class="row gx-2">
                                    <div class="col-auto"><small>Sort by:</small></div>
                                    <div class="col-auto">
                                        <select class="form-select form-select-sm" aria-label="Bulk actions">
                                            <option selected="">Best Match</option>
                                            <option value="Refund">Newest</option>
                                            <option value="Delete">Price</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="col-auto pe-0">
                                <a class="text-600 px-1" href="../../../app/e-commerce/product/product-list.html"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Product List"><span
                                        class="fas fa-list-ul"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    @foreach ($product as $products)
                        <div class="mb-3 col-md-4 col-lg-3">
                            <div class="border rounded-1 h-100 d-flex flex-column justify-content-between pb-3">
                                <div class="overflow-hidden">
                                    <div class="position-relative rounded-top overflow-hidden">
                                        <a class="d-block" href="../../../app/e-commerce/product/product-details.html">
                                            @if ($products->log_m_product_file == "")
                                                <img class="img-fluid rounded-top" src="{{asset('img/product.png')}}" alt="" />
                                            @else
                                                <img class="img-fluid rounded-top"
                                                    src="{{ Storage::url($products->log_m_product_file)}}" alt="" />
                                            @endif
                                        </a><span
                                            class="badge rounded-pill bg-success position-absolute mt-2 me-2 z-index-2 top-0 end-0">New</span>
                                    </div>
                                    <div class="p-3">
                                        <h5 class="fs-0">
                                            <a class="text-dark"
                                                href="{{route('product_detail', ['detail' => $products->log_m_product_code])}}">
                                                {{ $products->log_m_product_name }}
                                            </a>
                                        </h5>
                                        <p class="fs--1 mb-3">
                                            <a class="text-500" href="#!">{{$products->log_m_type_code}}</a>
                                        </p>
                                        <h5 class="fs-md-2 text-warning mb-0 d-flex align-items-center mb-3">
                                            @currency(mt_rand(1000000, 9999999))
                                            <del class="ms-2 fs--1 text-500">@currency(10999999) </del>
                                        </h5>
                                        <p class="fs--1 mb-1">
                                            Stock: <strong class="text-success">Available</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex flex-between-center px-3">
                                    <div>
                                        <span class="fa fa-star text-warning"></span><span
                                            class="fa fa-star text-warning"></span><span
                                            class="fa fa-star text-warning"></span><span
                                            class="fa fa-star text-warning"></span><span
                                            class="fa fa-star text-300"></span><span class="ms-1">({{mt_rand(50, 999)}})</span>
                                    </div>
                                    <div>
                                        <a class="btn btn-sm btn-falcon-default me-2" href="#!" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Add to Wish List"><span
                                                class="far fa-heart"></span></a><a class="btn btn-sm btn-falcon-default"
                                            href="#!" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><span
                                                class="fas fa-cart-plus"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer bg-light d-flex justify-content-center">
                <div>
                    <button class="btn btn-falcon-default btn-sm me-2" type="button" disabled="disabled"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Prev">
                        <span class="fas fa-chevron-left"></span></button><a
                        class="btn btn-sm btn-falcon-default text-primary me-2" href="#!">1</a><a
                        class="btn btn-sm btn-falcon-default me-2" href="#!">2</a><a
                        class="btn btn-sm btn-falcon-default me-2" href="#!">
                        <span class="fas fa-ellipsis-h"></span></a><a class="btn btn-sm btn-falcon-default me-2"
                        href="#!">35</a>
                    <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Next">
                        <span class="fas fa-chevron-right"> </span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->







@endsection
