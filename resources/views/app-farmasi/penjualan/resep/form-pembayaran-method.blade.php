@if ($key == 'bank')
    <div class="card-header bg-300 py-1 pt-2">
        <h5>Transfer Bank <span class="badge bg-warning">Soon</span></h5>
    </div>
@elseif ($key == 'ewallet')
    <div class="card-header bg-300 py-1 pt-2">
        <h5>E - Wallet <span class="badge bg-warning">Soon</span></h5>
    </div>
@elseif ($key == 'card')
    <div class="card-header bg-300 py-1 pt-2">
        <h5>Kartu Kredit & Debit </h5>
    </div>
    <div class="card-body border">
        <div class="row">
            <div class="col-md-7 col-xl-12 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
                <div class="row gx-0 mb-0">
                    <div class="col-sm-8 px-3">
                        <div class="mb-3">
                            <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0" for="inputNumber">Card
                                Number</label>
                            <input class="form-control" id="inputNumber" type="text" placeholder="•••• •••• •••• ••••">
                        </div>
                        <div class="row align-items-center">
                            <div class="col-6">
                                <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0">Exp Date</label>
                                <input class="form-control" type="text" placeholder="mm/yyyy">
                            </div>
                            <div class="col-6">
                                <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0">CVV<a
                                        class="d-inline-block" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="" data-bs-original-title="Card verification value"
                                        aria-label="Card verification value"></a></label>
                                <input class="form-control" type="text" placeholder="123" maxlength="3" pattern="[0-9]{3}">
                            </div>
                        </div>
                    </div>
                    <div class="col-4 ps-3 text-center pt-2 d-none d-sm-block">
                        <div class="rounded-1 p-2 mt-3 bg-100">
                            <div class="text-uppercase fs--2 fw-bold">We Accept</div><img
                                src="{{ asset('asset/img/icons/icon-payment-methods-grid.png') }}" alt="" width="120">
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="col-md-5 col-xl-12 col-xxl-5 ps-lg-4 ps-xl-2 ps-xxl-5 text-center text-md-start text-xl-center text-xxl-start">
                <div class="border-dashed-bottom d-block d-md-none d-xl-block d-xxl-none my-4"></div>
                <div class="fs-2 fw-semi-bold">All Total: <span class="text-primary">@currency($total->total)</span></div>
                <span id="menu-button-confrim">
                    <button class="btn btn-success mt-3 px-5" type="submit" id="button-confirm-payment-obat">Confirm &amp;
                        Pay</button>
                </span>
                <p class="fs--1 mt-3 mb-0">By clicking <strong>Confirm &amp; Pay </strong>button you agree to the <a
                        href="#!">Terms &amp; Conditions</a></p>
            </div>
        </div>
    </div>
@elseif ($key == 'cod')
    <div class="card-header bg-300 py-1 pt-2">
        <h5>Bayar di Tempat (COD)</h5>
    </div>
    <div class="card-body border">
        <form class="row" id="form-pembayaran-obat">
            @csrf
            <input type="text" name="no_reg" id="" value="{{ $code }}" hidden>
            <input type="text" name="method_payment" id="" value="cod" hidden>
            <input type="text" name="noResep" id="" value="{{$noResep}}" hidden>
            <input type="text" name="namaPasien" id="" value="{{$namaPasien}}" hidden>
            <input type="text" name="namaDokter" id="" value="{{$namaDokter}}" hidden>
            <input type="text" name="tglResep" id="" value="{{$tglResep}}" hidden>
            <input type="text" name="keteranganResep" id="" value="{{$keteranganResep}}" hidden>
            <div class="col-md-7 col-xl-12 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
                <div class="d-flex"><img class="me-3" src="{{ asset('asset/img/icons/shield.png') }}" alt="" width="60"
                        height="60">
                    <div class="flex-1">
                        <h5 class="mb-2">Buyer Protection</h5>
                        <div class="form-check mb-0">
                            <input class="form-check-input" id="protection-option-1" type="checkbox" checked="checked">
                            <label class="form-check-label mb-0" for="protection-option-1"> <strong>Full Refund </strong>If
                                you don't <br class="d-none d-md-block d-lg-none">receive your order</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="protection-option-2" type="checkbox" checked="checked">
                            <label class="form-check-label mb-0" for="protection-option-2"> <strong>Full or Partial Refund,
                                </strong>If the product is not as described in details</label>
                        </div><a class="fs--1 ms-3 ps-2" href="#!">Learn More<svg
                                class="svg-inline--fa fa-caret-right fa-w-6 ms-1" data-fa-transform="down-2"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg=""
                                style="transform-origin: 0.1875em 0.625em;">
                                <g transform="translate(96 256)">
                                    <g transform="translate(0, 64)  scale(1, 1)  rotate(0 0 0)">
                                        <path fill="currentColor"
                                            d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z"
                                            transform="translate(-96 -256)"></path>
                                    </g>
                                </g>
                            </svg><!-- <span class="fas fa-caret-right ms-1" data-fa-transform="down-2">    </span> Font Awesome fontawesome.com --></a>
                    </div>
                </div>
            </div>
            <div
                class="col-md-5 col-xl-12 col-xxl-5 ps-lg-4 ps-xl-2 ps-xxl-5 text-center text-md-start text-xl-center text-xxl-start">
                <div class="border-dashed-bottom d-block d-md-none d-xl-block d-xxl-none my-4"></div>
                <div class="fs-2 fw-semi-bold">All Total: <span class="text-primary">@currency($total->total)</span></div>
                <span id="menu-button-confrim">
                    <button class="btn btn-success mt-3 px-5" type="submit" id="button-confirm-payment-obat">Confirm &amp;
                        Pay</button>
                </span>
                <p class="fs--1 mt-3 mb-0">By clicking <strong>Confirm &amp; Pay </strong>button you agree to the <a
                        href="#!">Terms &amp; Conditions</a></p>
            </div>
        </form>
    </div>
@endif
