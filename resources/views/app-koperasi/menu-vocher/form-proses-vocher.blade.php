<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Proses Data Vocher</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <div class="card">
            <div class="card-body border border-dark">
                <form class="row" id="form-proses-vocher-baru" method="post">
                    @csrf
                    <div class="col-md-7 col-xl-7 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
                        <div class="d-flex"><img class="me-3" src="{{ asset('asset/img/icons/shield.png') }}" alt="" width="60" height="60">
                            <div class="flex-1">
                                <h5 class="mb-2">Verifikasi Oleh Ketua</h5>
                                @if ($data->kop_vocher_data_status == '0')
                                <strong class="text-danger">Belum di Verifikasi</strong>
                                @elseif ($data->kop_vocher_data_status == '1')
                                <strong class="text-primary">Sudah di Verifikasi</strong>
                                @endif
                                <div class="form-check mb-0">
                                    <input type="text" name="data_vocher" id="data_vocher" value="{{ $data->kop_vocher_data_code }}" hidden>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="protection-option-2" type="checkbox" checked="checked">
                                    <label class="form-check-label mb-0" for="protection-option-2"> <strong>Saya Setujua, </strong>Dengan Semua prnyataan ini</label>
                                </div>
                                <span id="menu-proses-token-vocher">
                                    <button class="btn btn-info btn-sm" id="button-send-token-verifikasi-vocher"><span class="fas fa-mail-bulk"></span> Kirim Pemberitahuan</button>
                                </span>
                            </div>
                        </div>
                        <div class="vertical-line d-none d-md-block d-xl-block d-xxl-block"> </div>
                    </div>
                    <div class="col-md-5 col-xl-5 col-xxl-5 ps-lg-4 ps-xl-2 ps-xxl-5 text-center text-md-start text-xl-center text-xxl-start">
                        <div class="border-dashed-bottom d-block d-md-none d-xl-none d-xxl-none my-4"></div>
                        <div class="fs-2 fw-semi-bold">All Total: <span class="text-primary">@currency($data->kop_vocher_data_nominal)</span></div>
                        <span id="menu-proses-data-vocher">
                            <button class="btn btn-success mt-3 px-5" type="button" id="button-payment-data-vocher" data-code="">Confirm &amp; Prosess</button>
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
