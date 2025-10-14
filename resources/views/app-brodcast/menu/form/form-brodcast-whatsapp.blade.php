<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Brodcast Whatsapp</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <div class="card mb-3 border">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="" data-bs-original-title="Back to inbox" aria-label="Back to inbox"><svg
                            class="svg-inline--fa fa-arrow-left fa-w-14" aria-hidden="true" focusable="false"
                            data-prefix="fas" data-icon="arrow-left" role="img" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z">
                            </path>
                        </svg><!-- <span class="fas fa-arrow-left"></span> Font Awesome fontawesome.com --></a>
                    <span class="mx-1 mx-sm-2 text-300">|</span>
                    <button class="btn btn-falcon-default btn-sm" type="button" id="button-kirim-semua"
                        data-code="{{ $code }}"><span class="fab fa-viber"></span> Kirim Semua</button>

                </div>
                <div class="d-flex">
                    <div class="dropdown font-sans-serif">
                        <button class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none ms-2"
                            type="button" id="email-settings" data-bs-toggle="dropdown" data-boundary="viewport"
                            aria-haspopup="true" aria-expanded="false"><svg class="svg-inline--fa fa-cog fa-w-16"
                                aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cog" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z">
                                </path>
                            </svg><!-- <span class="fas fa-cog"></span> Font Awesome fontawesome.com --></button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-settings"><a
                                class="dropdown-item" href="#!">Configure inbox</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Settings</a><a
                                class="dropdown-item" href="#!">Themes</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Send feedback</a><a
                                class="dropdown-item" href="#!">Help</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="menu-table-peserta">
            <table id="data_peserta" class="table table-striped" style="width:100%">
                <thead class="bg-200 text-700">
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>No Handphone</th>
                        <th>Email</th>
                        <th>Lembaga</th>
                        <th>Kode Booking</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->b_event_peserta_name }}</td>
                            <td>{{ $datas->b_event_peserta_hp }}</td>
                            <td>{{ $datas->b_event_peserta_email }}</td>
                            <td>{{ $datas->b_event_peserta_lembaga }}</td>
                            <td>{{ $datas->b_event_peserta_booking }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
<script>
    new DataTable('#data_peserta', {
        responsive: true
    });
</script>
