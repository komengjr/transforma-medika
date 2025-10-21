@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-primary shadow border border-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/keuangan.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1">{{env('APP_NAME')}} <span
                                    class="text-white fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0">Menu <span class="text-white fw-medium">Cashier</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card mb-3">
                <div class="card-header bg-300">
                    <div class="row flex-between-center">
                        <div class="col-sm-auto">
                            <h5 class="mb-2 mb-sm-0">Cari Data Tagihan</h5>
                        </div>
                        <div class="col-sm-auto">
                            <a class="btn btn-falcon-default btn-sm" href="#!" data-bs-toggle="modal" data-bs-target="#modal-cashier-full" id="button-find-payment"><span
                                    class="fas fa-search me-2" data-fa-transform="shrink-2"></span>Find</a></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control form-control-lg text-center" id="carinoregister"
                                placeholder="Search No Registrasi" onkeydown="search(this)" autofocus>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <span id="menu-order-cashier">
                    <div class="card-header bg-300 btn-reveal-trigger d-flex flex-between-center">
                        <h5 class="mb-0">Order</h5>
                        <a class="btn btn-falcon-warning btn-sm btn-reveal" href="#"><span
                                class="fab fa-product-hunt"></span> Payment
                        </a>
                    </div>
                </span>
            </div>
        </div>
        <div class="col-xl-4 order-xl-1">
            <div class="card">
                <div class="card-header bg-300 btn-reveal-trigger d-flex flex-between-center">
                    <h5 class="mb-0">Metode Payment</h5>
                </div>
                <div class="card-body">
                    <form>
                        <!-- <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input" type="radio" value="" id="paypal" name="payment-method" />
                                        <label class="form-check-label mb-0 ms-2 fs-1 text-primary" for="paypal">Cash
                                        </label>
                                    </div> -->
                        @foreach ($pay as $pays)
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" value="" id="cash-card" name="payment-method" />
                                <label class="form-check-label mb-2 fs-1 text-primary" for="credit-card">{{$pays->m_pay_name}}
                                </label>
                            </div>
                            <div class="row gx-0 ps-2 mb-2">
                                <div class="col-sm-12 px-3">
                                    <div class="mb-0">
                                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0"
                                            for="inputNumber">Nominal</label>
                                        <input class="form-control" id="inputNumber" type="text" placeholder="@currency(0)" />
                                    </div>
                                    @if ($pays->m_pay_name == 'CASH')

                                    @else
                                    @php
                                        $card = DB::table('m_pay_detail')->where('m_pay_code',$pays->m_pay_code)->get();
                                    @endphp
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0">Card</label>
                                                <select name="" class="form-control" id="">
                                                    <option value="">Pilih Card</option>
                                                    @foreach ($card as $cards)
                                                        <option value="{{ $cards->m_pay_detail_code }}">{{ $cards->m_pay_detail_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0">EDC<a
                                                        class="d-inline-block" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Card verification value"><span
                                                            class="fa fa-question-circle ms-2"></span></a></label>
                                                <input class="form-control" type="text" placeholder="123" maxlength="3"
                                                    pattern="[0-9]{3}" />
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <!-- <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input" type="radio" value="" id="paypal" name="payment-method" />
                                        <label class="form-check-label mb-0 ms-2" for="paypal"><img src="{{ asset('asset/img/icons/icon-paypal-full.png') }}" height="20" alt="" />
                                        </label>
                                    </div> -->
                        <!-- <div class="border-dashed-bottom my-5"></div> -->
                        <div class="row" style="display: none;" id="menu-pembayaran">
                            <!-- <div class="col-md-7 col-xl-12 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
                                            <div class="d-flex"><img class="me-3" src="{{ asset('asset/img/icons/shield.png') }}" alt="" width="60" height="60" />
                                                <div class="flex-1">
                                                    <h5 class="mb-2">Buyer Protection</h5>
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" id="protection-option-1" type="checkbox" checked="checked" />
                                                        <label class="form-check-label mb-0" for="protection-option-1"> <strong>Full Refund </strong>If you don't <br class="d-none d-md-block d-lg-none" />receive your order</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="protection-option-2" type="checkbox" checked="checked" />
                                                        <label class="form-check-label mb-0" for="protection-option-2"> <strong>Full or Partial Refund, </strong>If the product is not as described in details</label>
                                                    </div><a class="fs--1 ms-3 ps-2" href="#!">Learn More<span class="fas fa-caret-right ms-1" data-fa-transform="down-2"> </span></a>
                                                </div>
                                            </div>
                                            <div class="vertical-line d-none d-md-block d-xl-none d-xxl-block"> </div>
                                        </div> -->
                            <div
                                class="col-md-5 col-xl-12 col-xxl-5 ps-lg-4 ps-xl-2 ps-xxl-5 text-center text-md-start text-xl-center text-xxl-start">
                                <div class="border-dashed-bottom d-block d-md-none d-xl-block d-xxl-none my-4"></div>
                                <div class="fs-2 fw-semi-bold">All Total: <span class="text-primary"
                                        id="total_pembayaran_pasien">0</span></div>
                                <button class="btn btn-success mt-3 px-5" type="button"
                                    id="button-fix-pembayaran-pasien">Confirm &amp; Pay</button>
                                <p class="fs--1 mt-3 mb-0">By clicking <strong>Confirm & Pay </strong>button you agree to
                                    the <a href="#!">Terms &amp; Conditions</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-cashier-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-cashier-full"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-cashier" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-cashier"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-proses-handling", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-poliklinik').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('data_registrasi_poli_handling') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-poliklinik').html(data);
            }).fail(function () {
                $('#menu-poliklinik').html('eror');
            });
        });
        $(document).on("click", "#button-find-payment", function (e) {
            e.preventDefault();
            $('#menu-cashier-full').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('keuangan_menu_cashier_find_data') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": 123
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-cashier-full').html(data);
            }).fail(function () {
                $('#menu-cashier-full').html('eror');
            });
        });
        $(document).on("click", "#button-proses-payment", function (e) {
            e.preventDefault();
            var id = $(this).data("code");
            var code = document.getElementById("total_pembayaran").value;
            document.getElementById("menu-pembayaran").style.display = "block";
            $('#total_pembayaran_pasien').html(code);
        });
        $(document).on("click", "#button-fix-pembayaran-pasien", function (e) {
            e.preventDefault();
            var reg = document.getElementById("no_reg").value;
            var total = document.getElementById("total_pembayaran").value;
            console.log(reg);
            console.log(total);

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-falcon-success",
                    cancelButton: "btn btn-falcon-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Pay it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('keuangan_menu_cashier_find_fix_payment') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": reg,
                            "total": total
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        swalWithBootstrapButtons.fire({
                            title: "Payment success!",
                            text: "Your Payment Has been success.",
                            icon: "success"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 200);
                    }).fail(function () {
                        swalWithBootstrapButtons.fire({
                            title: "Payment Failed!",
                            text: "Your Payment Has been Field.",
                            icon: "error"
                        });
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your Payment Has bedn Cancelled",
                        icon: "error"
                    });
                }
            });
        });
    </script>
    <script>
        function search(ele) {
            if (event.key === 'Enter') {
                var id = document.getElementById('carinoregister').value;
                $.ajax({
                    url: "{{ route('keuangan_menu_cashier_find') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": id
                    },
                    dataType: 'html',
                }).done(function (data) {
                    document.getElementById('carinoregister').value = "";
                    if (data == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Data Register Tidak ditemukan",
                            footer: '<a href="#">Why do I have this issue?</a>'
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Greats..",
                            text: "Data Register ditemukan",
                            footer: '<a href="#">Why do I have this issue?</a>'
                        });
                        $('#menu-order-cashier').html(data);
                    }
                }).fail(function () {
                    $('#menu-order-cashier').html(
                        '<i class="fa fa-info-sign"></i> Something went wrong, Please try again...'
                    );
                });
            }
        }
    </script>
@endsection
