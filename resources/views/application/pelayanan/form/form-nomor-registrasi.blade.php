<div class="card mb-3 border border-info">
    <div class="card-body">
        <div class="row justify-content-between align-items-center">
            <div class="col-md">
                <h5 class="mb-2 mb-md-0">Order #{{ $code }}</h5>
            </div>
            <div class="col-auto">
                <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"
                    id="button-preview-registrasi-pasien" data-code="{{ $code }}">
                    <span class="fas fa-file-pdf"></span> Preview PDF</button>
            </div>
        </div>
    </div>
</div>
<div class="card border border-info">
    <div class="card-body" id="menu-preview-registrasi-pasien">
        <div class="row align-items-center text-center mb-3">
            <div class="col-sm-6 text-sm-start"><img src="{{ asset('img/favicon.png') }}" alt="invoice" width="100">
            </div>
            <div class="col text-sm-end mt-3 mt-sm-0">
                <h3 class="mb-1 text-warning">Innoverta Medika</h3>
                {{-- <h5>Transforma Design Studio</h5> --}}
                <p class="fs--1 mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. <br> Ipsum optio sunt
                    fugit
                    necessitatibus reprehenderit numquam dicta vero molestiae minima</p>
            </div>
            <div class="col-12">
                <hr style="color: black;">
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col">
                <h6 class="text-500">Pendaftaran</h6>
                <h5>{{$data->master_patient_name}}</h5>
                <p class="fs--1">-<br>-<br>-</p>
                <p class="fs--1"><a href="mailto:example@gmail.com">{{$data->master_patient_email}}</a><br><a
                        href="tel:444466667777">{{$data->master_patient_no_hp}}</a></p>
            </div>
            <div class="col-sm-auto ms-auto">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                        <tbody>
                            <tr>
                                <th class="text-sm-end">No Registrasi :</th>
                                <td>{{$code}}</td>
                            </tr>
                            <tr>
                                <th class="text-sm-end">No Registrasi Poli:</th>
                                <td>{{$data->d_reg_order_code}}</td>
                            </tr>
                            <tr>
                                <th class="text-sm-end">Tanggal Registrasi :</th>
                                <td>{{$data->d_reg_order_date}}</td>
                            </tr>
                            <tr>
                                <th class="text-sm-end">Payment Due:</th>
                                <td>Pending</td>
                            </tr>
                            <tr class="bg-success fw-bold">
                                @php
                                    echo DNS1D::getBarcodeHTML($code, 'C39', 1, 55, 'red');
                                @endphp
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- <div class="table-responsive scrollbar mt-4 fs--1">
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
        </div> -->
    </div>
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-between">
            <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything
                else
                we
                can do, please let us know!</p>
            <button class="btn btn-success float-end" onclick="location.reload()">Selesai</button>
        </div>
    </div>
</div>
