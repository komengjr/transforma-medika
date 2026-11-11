<div class="modal-body p-0 retro-modal-wrap" style="background-color: var(--retro-bg);">
    <!-- Header Retro -->
    <div class="py-3 px-4 d-flex justify-content-between align-items-center"
        style="background-color: var(--retro-cyan); border-bottom: 3px solid var(--retro-dark);">
        <div>
            <h4 class="mb-0 text-dark fw-bolder d-flex align-items-center" style="letter-spacing: -0.5px;">
                <i class="fas fa-notes-medical me-2"></i> Handling Pasien: {{ $data->nama_poli ?? 'Poliklinik' }}
            </h4>
            <p class="mb-0 fw-bold text-dark opacity-75" style="font-size: 0.8rem;">Supported by <a class="text-dark fw-bolder text-decoration-underline" href="#!">Transforma HIS</a></p>
        </div>
        <span class="badge bg-warning text-dark px-3 py-2 fw-bolder" style="border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark); font-size: 0.85rem;">
            <i class="fas fa-stethoscope me-1"></i> Antrean Aktif
        </span>
    </div>

    <div class="p-4">
        <div class="row g-4">
            <!-- Profil Foto Pasien -->
            <div class="col-md-3 col-lg-2 d-flex justify-content-center align-items-start">
                <div class="card-retro w-100 text-center p-3">
                    <div class="mx-auto mb-3">
                        @if (empty($data->master_patient_profile))
                        <img src="{{ asset('img/pasien.png') }}" class="rounded-circle" alt="Foto Pasien" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                        @else
                        <img src="{{ Storage::url($data->master_patient_profile) }}" class="rounded-circle" alt="Foto Pasien" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                        @endif
                    </div>
                    <span class="badge bg-light text-dark fw-bolder w-100 py-2" style="border: 2px solid var(--retro-dark);">{{ $data->master_patient_code }}</span>
                </div>
            </div>

            <!-- Detail Identitas Pasien -->
            <div class="col-md-9 col-lg-10">
                <div class="card-retro p-4">
                    <h6 class="fw-bolder text-dark mb-3 text-uppercase border-bottom border-dark pb-2"><i class="fas fa-id-card me-2"></i> Identitas Pasien</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fs--1 fw-bold text-dark mb-1">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="nama" class="form-control" value="{{ $data->master_patient_name }}" disabled style="background-color: #f1f1f1;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fs--1 fw-bold text-dark mb-1">Nomor NIK / ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                <input type="text" name="nik" class="form-control" value="{{ $data->master_patient_nik ?? '-' }}" disabled style="background-color: #f1f1f1;">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fs--1 fw-bold text-dark mb-1">No Rekam Medis (RM)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-book-medical"></i></span>
                                <input type="text" class="form-control" value="{{ $data->master_patient_code }}" disabled style="background-color: #f1f1f1;">
                                <input type="hidden" name="registrasi_id" id="registrasi_id" value="{{ $data->registrasi_id }}">
                                <input type="hidden" name="no_rm" id="no_rm" value="{{ $data->master_patient_code }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fs--1 fw-bold text-dark mb-1">Jenis Kelamin</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                <input type="text" class="form-control" value="{{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}" disabled style="background-color: #f1f1f1;">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fs--1 fw-bold text-dark mb-1">Tanggal Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" name="tgl_lahir" class="form-control" value="{{ $data->master_patient_tgl_lahir }}" disabled style="background-color: #f1f1f1;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Tools Action Bar -->
            <div class="col-12">
                <div class="card-retro py-2 px-3 d-flex justify-content-between align-items-center">
                    <span class="fw-bolder text-dark text-uppercase">
                        <i class="fas fa-clipboard-list me-2"></i> Form Pemeriksaan Klinik
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-light btn-retro btn-sm px-3" type="button" title="Cetak Form">
                            <i class="fas fa-print me-1"></i> Print
                        </button>

                        <div class="dropdown font-sans-serif">
                            <button class="btn btn-warning btn-retro btn-sm px-3 dropdown-toggle" type="button" id="email-settings" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: var(--retro-yellow);">
                                <i class="fas fa-cog me-1"></i> Menu Opsi
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="email-settings" style="border: 2px solid var(--retro-dark); box-shadow: 4px 4px 0px var(--retro-dark); border-radius: 8px;">
                                <a class="dropdown-item fw-bold text-dark" href="#!"><i class="fas fa-user-md me-2"></i>Form Tindakan Dokter</a>
                                <a class="dropdown-item fw-bold text-dark" href="#!"><i class="fas fa-notes-medical me-2"></i>Form Anamnesa</a>
                                <div class="dropdown-divider border-dark"></div>
                                <a class="dropdown-item fw-bold text-dark" href="#!"><i class="fas fa-paper-plane me-2"></i>Kirim Form Tindakan Dokter</a>
                                <a class="dropdown-item fw-bold text-dark" href="#!"><i class="fas fa-paper-plane me-2"></i>Kirim Form Anamnesa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accordion Form Input -->
            <div class="col-12">
                <form class="p-0 m-0" id="form-fisik-umum">
                    @csrf
                    <!-- Sembunyikan No Registrasi ke form submit -->
                    <input type="hidden" name="no_registrasi" value="{{ $code }}">

                    <div class="accordion" id="accordionFaq">
                        <!-- Accordion 1: Fisik Umum -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqAccordionHeading1">
                                <button class="accordion-button fw-bolder text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1" aria-expanded="true" aria-controls="collapseFaqAccordion1" style="background-color: var(--retro-purple);">
                                    <i class="fas fa-heartbeat me-2"></i> 1. FISIK UMUM & VITAL SIGN
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show" id="collapseFaqAccordion1" aria-labelledby="faqAccordionHeading1">
                                <div class="accordion-body p-4">
                                    <div class="row g-3">
                                        @foreach ($fisik as $f)
                                        <div class="col-md-4">
                                            <label class="form-label fs--1 fw-bold text-dark mb-1 text-uppercase">{{ $f->diag_poli_fisik_umum_name }}</label>
                                            <div class="input-group">
                                                <input type="text" name="{{ $f->diag_poli_fisik_umum_code }}" class="form-control border-end-0">
                                                <span class="input-group-text fw-bolder border-start-0" style="background-color: var(--retro-yellow);">
                                                    {{ $f->diag_poli_fisik_satuan }}
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Accordion 2: Keluhan Saat Ini -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqAccordionHeading2">
                                <button class="accordion-button fw-bolder text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2" aria-expanded="true" aria-controls="collapseFaqAccordion2" style="background-color: var(--retro-orange);">
                                    <i class="fas fa-comment-medical me-2"></i> 2. KELUHAN SAAT INI (ANAMNESA)
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show" id="collapseFaqAccordion2" aria-labelledby="faqAccordionHeading2">
                                <div class="accordion-body p-4">
                                    <div class="row g-4">
                                        @foreach ($fisik1 as $f1)
                                        <div class="col-12">
                                            <label class="form-label fs--1 fw-bold text-dark mb-2 text-uppercase">{{ $f1->diag_poli_fisik_umum_name }}</label>
                                            <textarea name="{{ $f1->diag_poli_fisik_umum_code }}" class="form-control" rows="3" placeholder="Tuliskan {{ strtolower($f1->diag_poli_fisik_umum_name) }} pasien secara rinci..." style="border-radius: 8px;"></textarea>
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
            <div class="col-12 mt-2 border-top border-dark pt-4">
                <span id="menu-handling-pasien-poliklinik">
                    <button class="btn btn-success btn-lg btn-retro float-end px-5 py-3 text-dark" id="button-handling-pasien-poliklinik" style="background-color: var(--retro-green);">
                        <i class="fas fa-check-circle me-2"></i> Simpan & Proses Handling
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>
