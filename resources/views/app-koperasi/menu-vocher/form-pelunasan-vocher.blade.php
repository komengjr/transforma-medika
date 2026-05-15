<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Pelunasan Data Vocher</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <div class="card">
            <div class="card-body border border-dark">
                <form class="row" id="form-pelunasan-data-vocher-baru" method="post">
                    @csrf
                    <div class="col-md-7 col-xl-7 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
                        <div class="d-flex"><img class="me-3" src="{{ asset('asset/img/icons/shield.png') }}" alt="" width="60" height="60">
                            <div class="flex-1">
                                <h5 class="mb-2">Verifikasi Pelunasan Data Vocher</h5>
                                <div class="row gx-3 mb-3">
                                    <div class="col">
                                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="cardNumber">Card Number</label>
                                        <input class="form-control" id="cardNumber" placeholder="XXXX XXXX XXXX XXXX" type="text">
                                    </div>
                                    <div class="col">
                                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="cardName">Name of Card</label>
                                        <input class="form-control" id="cardName" placeholder="John Doe" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vertical-line d-none d-md-block d-xl-block d-xxl-block"> </div>
                    </div>
                    <div class="col-md-5 col-xl-5 col-xxl-5 ps-lg-4 ps-xl-2 ps-xxl-5 text-center text-md-start text-xl-center text-xxl-start">
                        <div class="border-dashed-bottom d-block d-md-none d-xl-none d-xxl-none my-4"></div>
                        <div class="fs-2 fw-semi-bold">All Total: <span class="text-primary">@currency($data->kop_vocher_data_nominal)</span></div>
                        <span id="menu-proses-data-vocher">
                            <button class="btn btn-success mt-3 px-5" type="button" id="button-payment-pelunasan-data-vocher" data-code="">Confirm &amp; Prosess</button>
                        </span>
                        <p class="fs--1 mt-3 mb-0">By clicking <strong>Confirm &amp; Proses </strong>button you agree</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
