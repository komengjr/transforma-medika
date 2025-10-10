<div class="d-flex mb-4"><span class="fa-stack me-2 ms-n1"><svg
            class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-300" aria-hidden="true" focusable="false"
            data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
            data-fa-i2svg="">
            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
        </svg><!-- <i class="fas fa-circle fa-stack-2x text-300"></i> Font Awesome fontawesome.com --><svg
            class="svg-inline--fa fa-spinner fa-w-16 fa-inverse fa-stack-1x text-primary" aria-hidden="true"
            focusable="false" data-prefix="fas" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512" data-fa-i2svg="">
            <path fill="currentColor"
                d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
            </path>
        </svg><!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-spinner"></i> Font Awesome fontawesome.com --></span>
    <div class="col">
        <h5 class="mb-0 text-primary position-relative">Prosess Metode Pembayaran
            <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
        </h5>
        <p class="mb-0">You can easily show your stats content by using these cards.</p>
    </div>
</div>
<form class="form-validation">
    <input type="text" name="" value="{{ $code }}" id="code_po" hidden>
    <div class="row g-2">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label text-danger" for="form-wizard-progress-card-holder-country">Method
                    Payment</label>
                <div class="input-group mb-3"><span class="input-group-text" id="basic-addon1"><span
                            class="fas fa-wallet"></span></span>
                    <select class="form-select form-select-lg" name="customSelectCountry" id="form-select-payment">
                        <option value="">
                            Pilih Metode Paymen
                        </option>
                        @foreach ($pay as $pays)
                            <option value="{{$pays->m_pay_detail_code}}">{{$pays->m_pay_name}} -
                                {{$pays->m_pay_detail_name}}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3" id="display-rek" style="display: none;">
                <label class="form-label" for="form-wizard-progress-card-holder-zip-code">No Rekening</label>
                <div class="input-group mb-3"><span class="input-group-text" id="basic-addon1"><span
                            class="fas fa-credit-card"></span></span>
                    <input class="form-control form-control-lg" placeholder="XXXX XXXX XXXX XXXX" name="zipCode"
                        type="text" id="form-data-rek" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-0">
                <label class="form-label text-danger" for="form-wizard-progress-card-exp-date">Termin ( Batas Melakukan
                    Pembayaran
                    )</label>
                <div class="input-group mb-3"><span class="input-group-text" id="basic-addon1"><span
                            class="fas fa-business-time"></span></span>
                    <input class="form-control form-control-lg" placeholder="15/2024" name="expDate" type="date"
                        id="form-data-termin" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-0">
                <label class="form-label" for="form-wizard-progress-card-exp-date">Nomor DO Supplier <small>Jika Ada</small></label>
                <div class="input-group mb-3"><span class="input-group-text" id="basic-addon1"><span
                            class="fas fa-business-time"></span></span>
                    <input class="form-control form-control-lg" placeholder="15/2024" name="expDate" type="text"
                        id="form-data-faktur" />
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group mb-0">
                <label class="form-label" for="form-wizard-progress-card-cvv">Deskripsi <small class="text-warning">Jika
                        Supplier Memerlukan</small></label><span class="ms-1" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Card verification value"><span
                        class="fa fa-question-circle"></span></span>
                <div class="input-group mb-3"><span class="input-group-text" id="basic-addon1"><span
                            class="fas fa-envelope-open-text"></span></span>

                    <textarea name="" class="form-control" id=""></textarea>
                </div>
            </div>
        </div>
    </div>

</form>
<SCript>
    $('#form-select-payment').on("change", function () {
        var code = document.getElementById("form-select-payment").value;
        if (code == 'PAY001001') {
            document.getElementById('display-rek').style.display = 'none';
        } else {
            document.getElementById('display-rek').style.display = 'block';
        }
    });
</SCript>
