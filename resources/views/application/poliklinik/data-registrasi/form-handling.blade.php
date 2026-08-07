<div class="modal-body p-0 rounded-3 overflow-hidden shadow-lg">
    <!-- Header Gradient Modern -->
    <div class="bg-gradient-primary text-white py-3 px-4 d-flex justify-content-between align-items-center"
        style="background: linear-gradient(135deg, #2c7be5 0%, #1a4da1 100%); border-bottom: 3px solid #00d27a;">
        <div>
            <h4 class="mb-0 text-white fw-bold d-flex align-items-center" id="staticBackdropLabel">
                <i class="fas fa-notes-medical me-2"></i> Handling Pasien Poliklinik
            </h4>
            <p class="fs--2 mb-0 opacity-75">Supported by <a class="text-white fw-bold text-decoration-underline" href="#!">Transforma HIS</a></p>
        </div>
        <span class="badge bg-light text-primary fw-bold px-3 py-2 rounded-pill fs--1 shadow-sm">
            <i class="fas fa-stethoscope me-1 text-success"></i> Antrean Aktif
        </span>
    </div>

    <div class="p-4 bg-light">
        <div class="row g-3">
            <!-- Profil Foto Pasien -->
            <div class="col-md-3 col-lg-2 d-flex justify-content-center align-items-start">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden w-100 text-center bg-white p-2">
                    <div class="avatar avatar-5xl mx-auto my-2 position-relative">
                        @if ($data->master_patient_profile == "")
                        <img src="{{ asset('img/pasien.png') }}" class="rounded-circle img-thumbnail border-2 border-primary shadow-sm" alt="Foto Pasien" id="videoPreview" style="width: 110px; height: 110px; object-fit: cover;">
                        @else
                        <img src="{{ Storage::url($data->master_patient_profile) }}" class="rounded-circle img-thumbnail border-2 border-primary shadow-sm" alt="Foto Pasien" id="videoPreview" style="width: 110px; height: 110px; object-fit: cover;">
                        @endif
                    </div>
                    <span class="badge bg-soft-info text-info fw-bold mb-1">{{ $data->master_patient_code }}</span>
                </div>
            </div>

            <!-- Detail Identitas Pasien -->
            <div class="col-md-9 col-lg-10">
                <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fs--1 fw-bold text-primary mb-1">
                                <i class="fas fa-user-circle me-1"></i> Nama Lengkap
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-soft-primary text-primary border-end-0"><i class="fas fa-user"></i></span>
                                <input type="text" name="nama" class="form-control form-control-md fw-bold border-start-0 bg-light text-900" value="{{ $data->master_patient_name }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fs--1 fw-bold text-danger mb-1">
                                <i class="fas fa-id-card me-1"></i> Nomor NIK
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-soft-danger text-danger border-end-0"><i class="fas fa-fingerprint"></i></span>
                                <input type="text" name="nik" class="form-control form-control-md fw-bold border-start-0 bg-light text-900" id="nik" value="{{ $data->master_patient_nik }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fs--1 fw-bold text-info mb-1">
                                <i class="fas fa-hashtag me-1"></i> No Rekam Medis
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-soft-info text-info border-end-0"><i class="fas fa-book-medical"></i></span>
                                <input type="text" class="form-control form-control-md fw-bold border-start-0 bg-light text-900" value="{{ $data->master_patient_code }}" disabled>
                                <input type="text" name="no_rm" id="no_rm" value="{{ $data->master_patient_code }}" hidden>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fs--1 fw-bold text-success mb-1">
                                <i class="fas fa-venus-mars me-1"></i> Jenis Kelamin
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-soft-success text-success border-end-0"><i class="fas fa-transgender"></i></span>
                                <input type="text" class="form-control form-control-md fw-bold border-start-0 bg-light text-900" value="{{ $data->master_patient_jk }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fs--1 fw-bold text-warning mb-1">
                                <i class="fas fa-calendar-alt me-1"></i> Tanggal Lahir
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-soft-warning text-warning border-end-0"><i class="fas fa-birthday-cake"></i></span>
                                <input type="date" name="tgl_lahir" class="form-control form-control-md fw-bold border-start-0 bg-light text-900" id="tgl_lahir" value="{{ $data->master_patient_tgl_lahir }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Tools Action Bar -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3 bg-white">
                    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-700 fs--1">
                            <i class="fas fa-clipboard-list text-primary me-1"></i> Form Pemeriksaan Klinik
                        </span>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-falcon-default btn-sm text-secondary" type="button" data-bs-toggle="tooltip" title="Cetak Form">
                                <i class="fas fa-print me-1 text-primary"></i> Print
                            </button>

                            <div class="dropdown font-sans-serif">
                                <button class="btn btn-falcon-primary btn-sm dropdown-toggle dropdown-caret-none" type="button" id="email-settings" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog me-1"></i> Menu Opsi
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border py-2 shadow-sm" aria-labelledby="email-settings">
                                    <a class="dropdown-item fw-semi-bold" href="#!"><i class="fas fa-user-md me-2 text-primary"></i>Form Tindakan Dokter</a>
                                    <a class="dropdown-item fw-semi-bold" href="#!"><i class="fas fa-notes-medical me-2 text-info"></i>Form Anamnesa</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-primary fw-bold" href="#!"><i class="fas fa-paper-plane me-2"></i>Kirim Form Tindakan Dokter</a>
                                    <a class="dropdown-item text-info fw-bold" href="#!"><i class="fas fa-paper-plane me-2"></i>Kirim Form Anamnesa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accordion Form Input -->
            <div class="col-12">
                <form class="p-0 m-0" id="form-fisik-umum">
                    @csrf
                    <input type="text" name="no_registrasi" value="{{$code}}" id="" hidden>

                    <div class="accordion shadow-sm rounded-3 overflow-hidden" id="accordionFaq">
                        <!-- Accordion 1: Fisik Umum -->
                        <div class="accordion-item border-0 mb-2">
                            <h2 class="accordion-header" id="faqAccordionHeading1">
                                <button class="accordion-button bg-soft-primary text-primary fw-bold fs-0 rounded-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1" aria-expanded="true" aria-controls="collapseFaqAccordion1">
                                    <i class="fas fa-heartbeat me-2 text-danger"></i> Fisik Umum & Vital Sign
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show bg-white" id="collapseFaqAccordion1" aria-labelledby="faqAccordionHeading1" data-bs-parent="#accordionFaq">
                                <div class="accordion-body p-3">
                                    <div class="row g-3">
                                        @foreach ($fisik as $f)
                                        <div class="col-md-4">
                                            <label class="form-label fs--1 fw-semibold text-700 mb-1">{{$f->diag_poli_fisik_umum_name}}</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="{{$f->diag_poli_fisik_umum_code}}" class="form-control border-end-0 bg-white shadow-none">
                                                <span class="input-group-text bg-soft-secondary text-secondary fw-bold border-start-0">
                                                    {{$f->diag_poli_fisik_satuan}}
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Accordion 2: Keluhan Saat Ini -->
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="faqAccordionHeading2">
                                <button class="accordion-button bg-soft-warning text-warning-emphasis fw-bold fs-0 rounded-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2" aria-expanded="true" aria-controls="collapseFaqAccordion2">
                                    <i class="fas fa-comment-medical me-2 text-warning"></i> Keluhan Saat Ini (Anamnesa)
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show bg-white" id="collapseFaqAccordion2" aria-labelledby="faqAccordionHeading2" data-bs-parent="#accordionFaq">
                                <div class="accordion-body p-3">
                                    <div class="row g-3">
                                        @foreach ($fisik1 as $f1)
                                        <div class="col-12">
                                            <label class="form-label fs--1 fw-semibold text-700 mb-1">{{$f1->diag_poli_fisik_umum_name}}</label>
                                            <textarea name="{{$f1->diag_poli_fisik_umum_code}}" class="form-control shadow-none" rows="3" placeholder="Tuliskan keluhan pasien secara rinci..."></textarea>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer Action Button -->
            <div class="col-12 mt-3">
                <span id="menu-handling-pasien-poliklinik">
                    <button class="btn btn-success btn-lg float-end shadow-sm px-4 rounded-pill font-sans-serif fw-bold" id="button-handling-pasien-poliklinik">
                        <i class="fas fa-check-circle me-1"></i> Simpan & Proses Handling
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>
