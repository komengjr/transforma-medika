<div class="card-header bg-300">
    <h5 class="mb-0">Payment Method</h5>
</div>
<div class="card-body">
    <form>

        <div class="row">
            <div class="col-md-7 col-xl-7 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
                <div class="d-flex"><img class="me-3" src="{{ asset('asset/img/icons/shield.png') }}" alt="" width="60" height="60">
                    <div class="flex-1">
                        <h5 class="mb-2">Buyer Protection</h5>
                        <div class="form-check mb-0">
                            <input class="form-check-input" id="protection-option-1" type="checkbox" checked="checked">
                            <label class="form-check-label mb-0" for="protection-option-1"> <strong>Full Refund </strong>If you don't <br class="d-none d-md-block d-lg-none">receive your order</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="protection-option-2" type="checkbox" checked="checked">
                            <label class="form-check-label mb-0" for="protection-option-2"> <strong>Full or Partial Refund, </strong>If the product is not as described in details</label>
                        </div><a class="fs--1 ms-3 ps-2" href="#!">Learn More<svg class="svg-inline--fa fa-caret-right fa-w-6 ms-1" data-fa-transform="down-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.625em;">
                                <g transform="translate(96 256)">
                                    <g transform="translate(0, 64)  scale(1, 1)  rotate(0 0 0)">
                                        <path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z" transform="translate(-96 -256)"></path>
                                    </g>
                                </g>
                            </svg><!-- <span class="fas fa-caret-right ms-1" data-fa-transform="down-2">    </span> Font Awesome fontawesome.com --></a>
                    </div>
                </div>
                <div class="vertical-line d-none d-md-block d-xl-none d-xxl-block"> </div>
            </div>
            <div class="col-md-5 col-xl-5 col-xxl-5 ps-lg-4 ps-xl-2 ps-xxl-5 text-center text-md-start text-xl-center text-xxl-start">
                <!-- <div class="border-dashed-bottom d-block d-md-none d-xl-block d-xxl-none my-4"></div> -->
                <div class="fs-2 fw-semi-bold">All Total: <span class="text-primary">@currency($data->kop_log_peminjaman_uang_nominal)</span></div>
                <button class="btn btn-success mt-3 px-5" type="button" id="button-fix-payment-kontrak-bulanan" data-code="{{ $data->kop_log_peminjaman_uang_code }}">Confirm &amp; Pay</button>
                <p class="fs--1 mt-3 mb-0">By clicking <strong>Confirm &amp; Pay </strong>button you agree to the <a href="#!">Terms &amp; Conditions</a></p>
            </div>
        </div>
    </form>
</div>
