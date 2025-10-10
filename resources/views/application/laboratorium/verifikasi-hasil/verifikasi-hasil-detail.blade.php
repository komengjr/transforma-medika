<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Verifikasi Pasien Laboratorium</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <div class="row g-0" id="menu-verifikasi-hasil">
            <div class="col-lg-4 pe-lg-2">
                <div class="">
                    <div class="card mb-3 mb-lg-0">
                        <div class="card-header bg-300">
                            <h5 class="mb-0"> No Reg. {{ $reg }}</h5>
                        </div>
                        <div class="card-body fs--1">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-4 d-flex justify-content-center">
                                        <div class="avatar avatar-5lg shadow-sm justify-content-center">
                                            <div class="h-100 w-100 overflow-hidden ">
                                                <img src="{{ asset($data->master_patient_profile) }}"
                                                    class="img-thumbnail " alt="" id="videoPreview"
                                                    data-dz-thumbnail="data-dz-thumbnail">
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="inputLastName1" class="form-label text-primary">Nama
                                                    Lengkap</label>
                                                <div class="input-group"> <span class="input-group-text"><i
                                                            class="fas fa-user-friends"></i></span>
                                                    <input type="text" name="nama"
                                                        class="form-control border-start-0 bg-white"
                                                        value="{{ $data->master_patient_name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                                                <div class="input-group"> <span class="input-group-text"><i
                                                            class="fas fa-money-check"></i></span>
                                                    <input type="text" name="nik"
                                                        class="form-control border-start-0 bg-white" id="nik"
                                                        value="{{ $data->master_patient_nik }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="inputLastName1" class="form-label text-youtube">No Rekam
                                                    Medis</label>
                                                <div class="input-group"> <span class="input-group-text"><i
                                                            class="fas fa-money-check"></i></span>
                                                    <input type="text" name="nik"
                                                        class="form-control border-start-0 bg-white" id="nik"
                                                        value="{{ $data->master_patient_code }}" disabled>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputLastName1" class="form-label text-youtube">Tanggal
                                            Lahir</label>
                                        <div class="input-group"> <span class="input-group-text"><i
                                                    class="fas fa-calendar-day"></i></span>
                                            <input type="date" name="tgl_lahir"
                                                class="form-control  bg-white border-start-0" id="tgl_lahir"
                                                value="{{ $data->master_patient_tgl_lahir }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputLastName1" class="form-label text-youtube">Jenis
                                            Kelamin</label>
                                        <div class="input-group"> <span class="input-group-text"><i
                                                    class="fas fa-transgender fs-2"></i></span>
                                            <input type="text" class="form-control  bg-white border-start-0"
                                                id="tgl_lahir" value="{{ $data->master_patient_jk }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputLastName1" class="form-label">Tempat Lahir</label>
                                        <div class="input-group"> <span class="input-group-text"><i
                                                    class="fas fa-map-marked-alt"></i></span>
                                            <input type="text" name="tempat_lahir"
                                                class="form-control border-start-0 bg-white" id="inputLastName1"
                                                value="{{ $data->master_patient_tempat_lahir }}" disabled>
                                        </div>
                                    </div>


                                </div>
                            </form>

                        </div>
                        <div class="card-footer bg-light p-0 border-top"><a class="btn btn-link d-block w-100"
                                href="#">History<svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-1 fs--2"
                                    aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right"
                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                    data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z">
                                    </path>
                                </svg><!-- <span class="fas fa-chevron-right ms-1 fs--2"></span> Font Awesome fontawesome.com --></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 ps-lg-2">
                <div class="card mb-3 mb-lg-0">
                    <div class="card-header bg-300">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Events you may like</h5>
                            <button class="btn btn-warning btn-sm" id="button-verifikasi-preview-report"
                                data-code="{{ $code }}" data-reg="{{ $reg }}"><span class="fas fa-file-pdf"></span>
                                Preview Report</button>

                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="fs-0 mb-3">Pastikan Nilai Sudah Benar</h5>

                        <div class="table-responsive scrollbar">
                            <table class="table border fs--2">
                                <thead class="bg-300 text-700">
                                    <tr>
                                        <th>Jenis Pemeriksaan</th>
                                        <th>Hasil ( Unit )</th>
                                        <th>Flag</th>
                                        <th>Nilai Normal</th>
                                        <th>Metode</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pemeriksaan as $pem)
                                        <tr>
                                            <td colspan="6">{{$pem->t_pemeriksaan_list_name}}</td>
                                        </tr>
                                        @php
                                            $sub = DB::table('t_pemeriksaan_list_val')->where('t_pemeriksaan_list_code', $pem->t_pemeriksaan_list_code)->get();
                                        @endphp
                                        @foreach ($sub as $subs)
                                            <tr class="">
                                                <td>{{$subs->t_pem_list_val_name}}</td>
                                                <td>
                                                    @php
                                                        $nilai = DB::table('h_reg_lab')->where('d_reg_order_lab_code', $reg)->where('t_pem_list_val_code', $subs->t_pem_list_val_code)->first();
                                                    @endphp
                                                    @if ($nilai)
                                                        <div class="input-group has-validation">
                                                            <input type="text" class="form-control fs--2" value="{{ $nilai->h_reg_lab_value }}"
                                                                id="validationTooltipUsername"
                                                                aria-describedby="validationTooltipUsernamePrepend" required=""
                                                                disabled>
                                                            <span class="input-group-text fs--2"
                                                                id="validationTooltipUsernamePrepend">{{$subs->t_pem_list_val_satuan}}</span>
                                                            <div class="invalid-tooltip">Please choose a unique and valid username.
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="input-group has-validation">
                                                            <input type="text" class="form-control fs--2" value="1"
                                                                id="validationTooltipUsername"
                                                                aria-describedby="validationTooltipUsernamePrepend" required=""
                                                                disabled>
                                                            <span class="input-group-text fs--2"
                                                                id="validationTooltipUsernamePrepend">{{$subs->t_pem_list_val_satuan}}</span>
                                                            <div class="invalid-tooltip">Please choose a unique and valid username.
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>*</td>
                                                <td>{{$subs->t_pem_list_val_rujukan}}</td>
                                                <td>
                                                    @if ($nilai)

                                                    {{$nilai->h_reg_lab_metode}}<i class="bx bx-edit text-warning"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td><input type="text" class="form-control" name="" id=""></td>
                                            </tr>

                                        @endforeach
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="card mb-3 border">
                            <div class="card-body d-flex justify-content-between ">
                                <div><a class="btn btn-falcon-default btn-sm" href="../../app/email/inbox.html"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                        data-bs-original-title="Back to inbox" aria-label="Back to inbox"><svg
                                            class="svg-inline--fa fa-arrow-left fa-w-14" aria-hidden="true"
                                            focusable="false" data-prefix="fas" data-icon="arrow-left" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z">
                                            </path>
                                        </svg><!-- <span class="fas fa-arrow-left"></span> Font Awesome fontawesome.com --></a><span
                                        class="mx-1 mx-sm-2 text-300">|</span>
                                    <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="" data-bs-original-title="Archive"
                                        aria-label="Archive"><svg class="svg-inline--fa fa-archive fa-w-16"
                                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="archive"
                                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                            data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M32 448c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32V160H32v288zm160-212c0-6.6 5.4-12 12-12h104c6.6 0 12 5.4 12 12v8c0 6.6-5.4 12-12 12H204c-6.6 0-12-5.4-12-12v-8zM480 32H32C14.3 32 0 46.3 0 64v48c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16V64c0-17.7-14.3-32-32-32z">
                                            </path>
                                        </svg><!-- <span class="fas fa-archive"></span> Font Awesome fontawesome.com --></button>
                                    <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2" type="button"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                        data-bs-original-title="Delete" aria-label="Delete"><svg
                                            class="svg-inline--fa fa-trash-alt fa-w-14" aria-hidden="true"
                                            focusable="false" data-prefix="fas" data-icon="trash-alt" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z">
                                            </path>
                                        </svg><!-- <span class="fas fa-trash-alt"></span> Font Awesome fontawesome.com --></button>
                                    <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2" type="button"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                        data-bs-original-title="Mark as unread" aria-label="Mark as unread"><svg
                                            class="svg-inline--fa fa-envelope fa-w-16" aria-hidden="true"
                                            focusable="false" data-prefix="fas" data-icon="envelope" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z">
                                            </path>
                                        </svg><!-- <span class="fas fa-envelope"></span> Font Awesome fontawesome.com --></button>
                                    <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2" type="button"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                        data-bs-original-title="Snooze" aria-label="Snooze"><svg
                                            class="svg-inline--fa fa-clock fa-w-16" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="clock" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm92.49,313h0l-20,25a16,16,0,0,1-22.49,2.5h0l-67-49.72a40,40,0,0,1-15-31.23V112a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16V256l58,42.5A16,16,0,0,1,348.49,321Z">
                                            </path>
                                        </svg><!-- <span class="fas fa-clock"></span> Font Awesome fontawesome.com --></button>
                                    <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2 d-none d-sm-inline-block"
                                        type="button" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                        data-bs-original-title="Print" aria-label="Print"><svg
                                            class="svg-inline--fa fa-print fa-w-16" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="print" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z">
                                            </path>
                                        </svg><!-- <span class="fas fa-print"></span> Font Awesome fontawesome.com --></button>
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-falcon-primary" id="button-verifikasi-hasil-lab"
                                        data-code="{{ $code }}" data-reg="{{ $reg }}"
                                        style="display: none;">Verifikasi</button>
                                </div>
                            </div>
                        </div>
                        <div class="googlemap rounded-3" id="view-map" data-latlng="23.8383608,90.3680554"
                            data-scrollwheel="false" data-icon="../../assets/img/icons/map-marker.png" data-zoom="17"
                            data-theme="Default" style="position: relative; overflow: hidden;">
                            <!-- <iframe src="{{ asset('file/file.pdf') }}" frameborder="0" style="width: 100%; height: 450px;"></iframe> -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
