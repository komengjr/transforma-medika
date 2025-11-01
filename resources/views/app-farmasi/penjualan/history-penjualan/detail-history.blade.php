<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Data Riwayat Penjualan</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-3 pb-3">
        <div class="card mb-3 border border-warning">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Order #AD20294</h5>
                    </div>
                    <div class="col-auto">

                        <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"><svg
                                class="svg-inline--fa fa-print fa-w-16 me-1" aria-hidden="true" focusable="false"
                                data-prefix="fas" data-icon="print" role="img" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z">
                                </path>
                            </svg>Print</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="card border border-primary">
            <div class="card-body">
                <div class="row align-items-center text-center mb-3">
                    <div class="col-sm-6 text-sm-start"><img src="{{asset('img/favicon.png')}}" alt="invoice"
                            width="150"></div>
                    <div class="col text-sm-end mt-3 mt-sm-0">
                        <h2 class="mb-3">Invoice / Nota</h2>
                        <h5>Falcon Design Studio</h5>
                        <p class="fs--1 mb-0">156 University Ave, Toronto<br>On, Canada, M5H 2H7</p>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="text-500">Invoice to</h6>
                        <h5>Antonio Banderas</h5>
                        <p class="fs--1">1954 Bloor Street West<br>Torronto ON, M6P 3K9<br>Canada</p>
                        <p class="fs--1">
                            <a href="mailto:example@gmail.com">example@gmail.com</a><br>
                            <a href="tel:444466667777">+4444-6666-7777</a>
                        </p>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs--1">
                                <tbody>
                                    <tr>
                                        <th>Invoice No</th>
                                        <td>:</td>
                                        <td>14</td>
                                    </tr>
                                    <tr>
                                        <th>Order Number:</th>
                                        <td>:</td>
                                        <td>{{$code}}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice Date:</th>
                                        <td>:</td>
                                        <td>2018-09-25</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Due:</th>
                                        <td>:</td>
                                        <td>Upon receipt</td>
                                    </tr>
                                    <!-- <tr class="alert-success fw-bold">
                                        <th class="text-sm-end">Amount Due:</th>
                                        <td>$19688.40</td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive scrollbar mt-4 fs--1">
                    <table class="table table-striped border-bottom">
                        <thead class="light">
                            <tr class="bg-primary text-white dark__bg-1000">
                                <th class="border-0">Products</th>
                                <th class="border-0 text-center">Quantity</th>
                                <th class="border-0 text-end">Rate</th>
                                <th class="border-0 text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">Platinum web hosting package</h6>
                                    <p class="mb-0">Down 35mb, Up 100mb</p>
                                </td>
                                <td class="align-middle text-center">2</td>
                                <td class="align-middle text-end">$65.00</td>
                                <td class="align-middle text-end">$130.00</td>
                            </tr>
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">2 Page website design</h6>
                                    <p class="mb-0">Includes basic wireframes and responsive templates</p>
                                </td>
                                <td class="align-middle text-center">1</td>
                                <td class="align-middle text-end">$2,100.00</td>
                                <td class="align-middle text-end">$2,100.00</td>
                            </tr>
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">Mobile App Development</h6>
                                    <p class="mb-0">Includes responsive navigation</p>
                                </td>
                                <td class="align-middle text-center">8</td>
                                <td class="align-middle text-end">$5,00.00</td>
                                <td class="align-middle text-end">$4,000.00</td>
                            </tr>
                            <tr>
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">Web App Development</h6>
                                    <p class="mb-0">Includes react spa</p>
                                </td>
                                <td class="align-middle text-center">6</td>
                                <td class="align-middle text-end">$2,000.00</td>
                                <td class="align-middle text-end">$12,000.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <table class="table table-sm table-borderless fs--1 text-end">
                            <tbody>
                                <tr>
                                    <th class="text-900">Subtotal:</th>
                                    <td class="fw-semi-bold">$18,230.00 </td>
                                </tr>
                                <tr>
                                    <th class="text-900">Tax 8%:</th>
                                    <td class="fw-semi-bold">$1458.40</td>
                                </tr>
                                <tr class="border-top">
                                    <th class="text-900">Total:</th>
                                    <td class="fw-semi-bold">$19688.40</td>
                                </tr>
                                <tr class="border-top border-top-2 fw-bolder text-900">
                                    <th>Amount Due:</th>
                                    <td>$19688.40</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div class="card-footer bg-light">
                <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything
                    else we can do, please let us know!</p>
            </div> -->
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
</div>
