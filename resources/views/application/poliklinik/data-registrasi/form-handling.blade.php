<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Handling Pasien Poliklinik</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <div class="row g-3">
            <div class="col-md-2 d-flex justify-content-center">
                <div class="avatar avatar-5xl shadow-sm img-thumbnail justify-content-center">
                    <div class="h-100 w-100 overflow-hidden">
                        @if ($data->master_patient_profile == "")
                            <img src="{{ asset('img/pasien.png') }}" class="img-thumbnail " alt="" id="videoPreview"
                                data-dz-thumbnail="data-dz-thumbnail">
                        @else
                            <img src="{{ Storage::url($data->master_patient_profile) }}" class="img-thumbnail " alt=""
                                id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                        @endif
                    </div>

                </div>

            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-primary">Nama Lengkap</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-user-friends"></i></span>
                            <input type="text" name="nama" class="form-control form-control-lg border-start-0 bg-white"
                                value="{{ $data->master_patient_name }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nik" class="form-control form-control-lg border-start-0 bg-white"
                                id="nik" value="{{ $data->master_patient_nik }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="inputLastName1" class="form-label text-youtube">No Rekam
                            Medis</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nik" class="form-control form-control-lg border-start-0 bg-white"
                                id="nik" value="{{ $data->master_patient_code }}" disabled>
                            <input type="text" name="no_rm" id="no_rm" value="{{ $data->master_patient_code }}" hidden>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="inputLastName1" class="form-label text-youtube">Jenis
                            Kelamin</label>

                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-transgender"></i></span>
                            <input type="text" name="tgl_lahir"
                                class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
                                value="{{ $data->master_patient_jk }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Tanggal
                            Lahir</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <input type="date" name="tgl_lahir"
                                class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
                                value="{{ $data->master_patient_tgl_lahir }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <span>Form Lanjutan</span>
                            <span class="mx-1 mx-sm-2 text-300 d-none d-sm-inline-block">|</span>

                            <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2 d-none d-sm-inline-block"
                                type="button" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                data-bs-original-title="Print" aria-label="Print"><svg
                                    class="svg-inline--fa fa-print fa-w-16" aria-hidden="true" focusable="false"
                                    data-prefix="fas" data-icon="print" role="img" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z">
                                    </path>
                                </svg><!-- <span class="fas fa-print"></span> Font Awesome fontawesome.com --></button>
                        </div>
                        <div class="d-flex">
                            <div class="dropdown font-sans-serif">
                                <button
                                    class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none ms-2"
                                    type="button" id="email-settings" data-bs-toggle="dropdown" data-boundary="viewport"
                                    aria-haspopup="true" aria-expanded="false"><svg
                                        class="svg-inline--fa fa-cog fa-w-16" aria-hidden="true" focusable="false"
                                        data-prefix="fas" data-icon="cog" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z">
                                        </path>
                                    </svg>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border py-2"
                                    aria-labelledby="email-settings">
                                    <a class="dropdown-item" href="#!">Form Tindakan Dokter</a>
                                    <a class="dropdown-item" href="#!">Form Anamnesa</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-info" href="#!">Kirim Form Tindakan Dokter</a>
                                    <a class="dropdown-item text-info" href="#!">Kirim form Anamnesa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border">
                    <div class="card-body">
                        <div class="accordion border-x border-top rounded" id="accordionFaq">
                            <div class="card shadow-none border-bottom rounded-bottom-0">
                                <div class="card-header p-0" id="faqAccordionHeading1">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion1">
                                        <span class="far fa-dot-circle me-3"></span>
                                        <span class="fw-medium font-sans-serif text-warning">Berat dan Tinggi
                                            Badan</span></button>
                                </div>
                                <div class="bg-light collapse show" id="collapseFaqAccordion1"
                                    aria-labelledby="faqAccordionHeading1" data-parent="#accordionFaq" style="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Berat Badan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-weight"></i>
                                                    </span>
                                                    <input type="text" name="tgl_lahir"
                                                        class="form-control form-control-lg bg-white border-start-0">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Tinggi Badan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-weight"></i>
                                                    </span>
                                                    <input type="text" name="tgl_lahir"
                                                        class="form-control form-control-lg bg-white border-start-0">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Lingkar Perut</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-weight"></i>
                                                    </span>
                                                    <input type="text" name="tgl_lahir"
                                                        class="form-control form-control-lg bg-white border-start-0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="card shadow-none border-bottom rounded-0">
                                <div class="card-header p-0" id="faqAccordionHeading2">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion2">
                                        <span class="far fa-dot-circle me-3"></span>
                                        <span class="fw-medium font-sans-serif text-warning">Form
                                            Screening</span></button>
                                </div>
                                <div class="bg-light collapse show" id="collapseFaqAccordion2"
                                    aria-labelledby="faqAccordionHeading2" data-parent="#accordionFaq" style="">
                                    <div class="card-body">
                                        <p class="ps-4 mb-0">You can issue either partial or full refunds. There are no
                                            fees to refund a charge, but the fees from the original charge are not
                                            returned.
                                        </p>
                                    </div>
                                </div>
                            </div> -->
                            <div class="card shadow-none border-bottom rounded-0">
                                <div class="card-header p-0" id="faqAccordionHeading2">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion2">
                                        <span class="far fa-dot-circle me-3"></span>
                                        <span class="fw-medium font-sans-serif text-warning">Keluhan Saat
                                            Ini</span></button>
                                </div>
                                <div class="bg-light collapse show" id="collapseFaqAccordion2"
                                    aria-labelledby="faqAccordionHeading2" data-parent="#accordionFaq" style="">
                                    <div class="card-body">
                                        <textarea name="" class="form-control" id=""></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <span id="menu-handling-pasien-poliklinik">
                    <button class="btn btn-warning float-end" id="button-handling-pasien-poliklinik"
                        data-code="{{$code}}">Proses
                        Handling</button>
                </span>
            </div>
        </div>
    </div>
</div>
