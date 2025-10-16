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
                            <div class="card shadow-none border-bottom rounded-0">
                                <div class="card-header p-0" id="faqAccordionHeading2">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion2">
                                        <span class="far fa-dot-circle me-3"></span>
                                        <span class="fw-medium font-sans-serif text-warning">Suhu Badan</span></button>
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
                            </div>
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
