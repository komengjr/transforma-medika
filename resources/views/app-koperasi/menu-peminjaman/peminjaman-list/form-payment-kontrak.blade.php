<div class="card-header bg-300">
    <h5 class="mb-0">Payment Method</h5>
</div>
<div class="card-body">
    <form>

        <div class="row">
            <div class="col-md-7 col-xl-7 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
                <div class="d-flex"><img class="me-3" src="{{ asset('asset/img/icons/shield.png') }}" alt="" width="60" height="60">
                    <div class="flex-1">
                        <h5 class="mb-2">Akun Pembayaran</h5>
                        <!-- <label for="">Pilih Akun</label> -->
                        <select class="form-control form-control-lg" name="akun_pembayaran" id="akun_pembayaran">
                            <option value="">Pilih Akun</option>
                            @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                            @endforeach
                        </select>
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
