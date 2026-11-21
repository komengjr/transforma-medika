<style>
    .ent-handling-wrap {
        --ent-h-indigo: #4f46e5;
        --ent-h-indigo-dark: #4338ca;
        --ent-h-border: rgba(99, 102, 241, 0.25);
        /* --ent-h-surface: var(--bs-body-bg, #ffffff); */
        --ent-h-subtle: rgba(79, 70, 229, 0.05);
        font-family: 'Plus Jakarta Sans', sans-serif;

    }

    /* Header Banner */
    .ent-handling-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-handling-header::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -40px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-handling-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #7dd3fc;
        flex-shrink: 0;
    }

    .ent-status-pill {
        background: rgba(16, 185, 129, 0.18);
        border: 1px solid rgba(16, 185, 129, 0.45);
        color: #6ee7b7;
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    /* Cards & Surfaces */
    .ent-panel-card {
        background-color: var(--ent-h-surface);
        border: 1px solid var(--ent-h-border);
        border-radius: 16px;
        box-shadow: 0 4px 18px -4px rgba(15, 23, 42, 0.07);
    }

    .ent-patient-photo {
        width: 96px;
        height: 96px;
        object-fit: cover;
        border-radius: 18px;
        border: 3px solid rgba(99, 102, 241, 0.35);
        box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.25);
    }

    .ent-rm-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(79, 70, 229, 0.12);
        border: 1px solid rgba(79, 70, 229, 0.3);
        color: #6366f1;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.78rem;
        border-radius: 10px;
        padding: 6px 10px;
        width: 100%;
    }

    /* Form Controls */
    .ent-field-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-handling-wrap .input-group-text {
        background-color: rgba(79, 70, 229, 0.08);
        border: 1px solid var(--ent-h-border);
        color: #6366f1;
        border-radius: 10px 0 0 10px;
        font-size: 0.82rem;
    }

    .ent-handling-wrap .form-control {
        border: 1px solid var(--ent-h-border);
        border-radius: 10px;
        font-size: 0.84rem;
        font-weight: 600;
        color: var(--bs-body-color);
        background-color: var(--ent-h-surface);
        padding: 0.55rem 0.8rem;
        height: auto !important;
        transition: border-color 0.18s ease, box-shadow 0.18s ease;
    }

    .ent-handling-wrap .input-group>.form-control:not(:first-child) {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .ent-handling-wrap .input-group>.form-control:not(:last-child) {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .ent-handling-wrap .form-control:disabled {
        background-color: rgba(100, 116, 139, 0.08) !important;
        opacity: 0.92;
    }

    .ent-handling-wrap .form-control:focus {
        border-color: var(--ent-h-indigo);
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15);
    }

    .ent-unit-addon {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.12)) !important;
        border: 1px solid var(--ent-h-border) !important;
        border-left: none !important;
        border-radius: 0 10px 10px 0 !important;
        color: #4f46e5 !important;
        font-size: 0.76rem !important;
        font-weight: 700 !important;
        min-width: 58px;
        justify-content: center;
    }

    /* Tools Action Bar */
    .ent-toolbar-card {
        background: linear-gradient(90deg, rgba(79, 70, 229, 0.08) 0%, rgba(14, 165, 233, 0.06) 100%);
        border: 1px solid var(--ent-h-border);
        border-radius: 14px;
    }

    .ent-btn-action {
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 0.45rem 0.95rem;
        transition: all 0.18s ease;
    }

    .ent-btn-action:hover {
        transform: translateY(-1px);
    }

    /* Modern Accordion */
    .ent-accordion .accordion-item {
        border: 1px solid var(--ent-h-border);
        border-radius: 14px !important;
        overflow: hidden;
        margin-bottom: 1rem;
        background-color: var(--ent-h-surface);
        box-shadow: 0 4px 14px -4px rgba(15, 23, 42, 0.05);
    }

    .ent-accordion .accordion-button {
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.02em;
        padding: 0.95rem 1.25rem;
        box-shadow: none !important;
    }

    .ent-accordion .accordion-button.ent-acc-vital {
        background: linear-gradient(90deg, rgba(79, 70, 229, 0.14) 0%, rgba(99, 102, 241, 0.06) 100%);
        color: var(--bs-body-color);
    }

    .ent-accordion .accordion-button.ent-acc-anamnesa {
        background: linear-gradient(90deg, rgba(14, 165, 233, 0.14) 0%, rgba(56, 189, 248, 0.06) 100%);
        color: var(--bs-body-color);
    }

    .ent-vital-box {
        background-color: rgba(100, 116, 139, 0.04);
        border: 1px solid rgba(99, 102, 241, 0.16);
        border-radius: 12px;
        padding: 12px;
        transition: border-color 0.18s ease, background-color 0.18s ease;
    }

    .ent-vital-box:focus-within {
        border-color: var(--ent-h-indigo);
        background-color: rgba(79, 70, 229, 0.04);
    }

    /* Submit CTA Button */
    .ent-btn-submit {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.9rem;
        border-radius: 12px;
        padding: 0.8rem 2rem;
        box-shadow: 0 8px 20px -4px rgba(5, 150, 105, 0.4);
        transition: all 0.2s ease;
    }

    .ent-btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px -4px rgba(5, 150, 105, 0.5);
        color: #ffffff;
    }
</style>

<div class="modal-body p-0 ent-handling-wrap">
    <!-- Header Modern Enterprise -->
    <div class="ent-handling-header py-3 px-4 pe-5 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 2;">
            <div class="ent-handling-icon-box">
                <i class="fas fa-notes-medical"></i>
            </div>
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge rounded-pill" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.68rem;">
                        PEMERIKSAAN POLIKLINIK
                    </span>
                    <span class="small fw-semibold" style="color: #94a3b8;">Transforma HIS</span>
                </div>
                <h5 class="mb-0 text-white fw-bold" style="letter-spacing: -0.02em;">
                    Handling Pasien: {{ $data->nama_poli ?? 'Poliklinik' }}
                </h5>
            </div>
        </div>
        <div class="position-relative" style="z-index: 2;">
            <span class="ent-status-pill d-inline-flex align-items-center gap-1">
                <i class="fas fa-stethoscope"></i> Antrean Aktif
            </span>
        </div>
    </div>

    <div class="p-3 p-md-4 bg-white">
        <div class="row g-3 g-md-4">
            <!-- Profil Foto Pasien -->
            <div class="col-md-3 col-lg-2 d-flex">
                <div class="ent-panel-card w-100 text-center p-3 d-flex flex-column align-items-center justify-content-center">
                    @php
                    $profileRaw = trim($data->master_patient_profile ?? '');
                    $profileSrc = asset('img/pasien.png');

                    if (!empty($profileRaw)) {
                    if (str_starts_with($profileRaw, 'data:image/')) {
                    $profileSrc = $profileRaw;
                    } else {
                    $profileSrc = 'data:image/png;base64,' . $profileRaw;
                    }
                    }
                    @endphp

                    <div class="mb-3 position-relative">
                        <img src="{{ $profileSrc }}" class="ent-patient-photo" alt="Foto Pasien" onerror="this.onerror=null;this.src='{{ asset('img/pasien.png') }}';">
                    </div>
                    <span class="ent-rm-chip">
                        <i class="fas fa-id-badge me-1"></i> {{ $data->master_patient_code }}
                    </span>
                </div>
            </div>

            <!-- Detail Identitas Pasien -->
            <div class="col-md-9 col-lg-10">
                <div class="ent-panel-card p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3" style="border-color: var(--ent-h-border) !important;">
                        <h6 class="fw-bold mb-0 text-uppercase" style="font-size: 0.78rem; letter-spacing: 0.04em; color: #6366f1;">
                            <i class="fas fa-id-card me-2"></i> Identitas Pasien
                        </h6>
                        <span class="badge bg-soft-primary text-primary rounded-pill px-2 py-1" style="font-size: 0.68rem;">Data Terverifikasi</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="ent-field-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="nama" class="form-control" value="{{ $data->master_patient_name }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="ent-field-label">Nomor NIK / ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                <input type="text" name="nik" class="form-control" value="{{ $data->master_patient_nik ?? '-' }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="ent-field-label">No Rekam Medis (RM)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-book-medical"></i></span>
                                <input type="text" class="form-control" value="{{ $data->master_patient_code }}" disabled>
                                <input type="hidden" name="registrasi_id" id="registrasi_id" value="{{ $data->registrasi_id }}">
                                <input type="hidden" name="no_rm" id="no_rm" value="{{ $data->master_patient_code }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="ent-field-label">Jenis Kelamin</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                <input type="text" class="form-control" value="{{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="ent-field-label">Tanggal Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" name="tgl_lahir" class="form-control" value="{{ $data->master_patient_tgl_lahir }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Tools Action Bar -->
            <div class="col-12">
                <div class="ent-toolbar-card py-2 px-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 30px; height: 30px; background: rgba(79, 70, 229, 0.15); color: #6366f1;">
                            <i class="fas fa-clipboard-list fs--1"></i>
                        </span>
                        <span class="fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.03em;">
                            Form Pemeriksaan Klinik
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-secondary ent-btn-action" type="button" title="Cetak Form">
                            <i class="fas fa-print me-1"></i> Print
                        </button>

                        <div class="dropdown">
                            <button class="btn btn-primary ent-btn-action dropdown-toggle" type="button" id="email-settings" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: linear-gradient(135deg, #4f46e5, #4338ca); border: none;">
                                <i class="fas fa-cog me-1"></i> Menu Opsi
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2 shadow-lg" aria-labelledby="email-settings" style="border: 1px solid var(--ent-h-border); border-radius: 12px;">
                                <a class="dropdown-item fw-semibold py-2" href="#!"><i class="fas fa-user-md me-2 text-primary"></i>Form Tindakan Dokter</a>
                                <a class="dropdown-item fw-semibold py-2" href="#!"><i class="fas fa-notes-medical me-2 text-info"></i>Form Anamnesa</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item fw-semibold py-2" href="#!"><i class="fas fa-paper-plane me-2 text-success"></i>Kirim Form Tindakan Dokter</a>
                                <a class="dropdown-item fw-semibold py-2" href="#!"><i class="fas fa-paper-plane me-2 text-warning"></i>Kirim Form Anamnesa</a>
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

                    <div class="accordion ent-accordion" id="accordionFaq">
                        <!-- Accordion 1: Fisik Umum -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqAccordionHeading1">
                                <button class="accordion-button ent-acc-vital" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1" aria-expanded="true" aria-controls="collapseFaqAccordion1">
                                    <span class="badge bg-primary me-2 rounded-pill">1</span>
                                    <i class="fas fa-heartbeat text-danger me-2"></i> FISIK UMUM &amp; VITAL SIGN
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show" id="collapseFaqAccordion1" aria-labelledby="faqAccordionHeading1">
                                <div class="accordion-body p-3 p-md-4">
                                    <div class="row g-3">
                                        @foreach ($fisik as $f)
                                        <div class="col-sm-6 col-md-4">
                                            <div class="ent-vital-box h-100">
                                                <label class="ent-field-label d-block text-uppercase">{{ $f->diag_poli_fisik_umum_name }}</label>
                                                <div class="input-group">
                                                    <input type="text" name="{{ $f->diag_poli_fisik_umum_code }}" class="form-control border-end-0" placeholder="0">
                                                    <span class="input-group-text ent-unit-addon">
                                                        {{ $f->diag_poli_fisik_satuan }}
                                                    </span>
                                                </div>
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
                                <button class="accordion-button ent-acc-anamnesa" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2" aria-expanded="true" aria-controls="collapseFaqAccordion2">
                                    <span class="badge bg-info me-2 rounded-pill">2</span>
                                    <i class="fas fa-comment-medical text-info me-2"></i> KELUHAN SAAT INI (ANAMNESA)
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show" id="collapseFaqAccordion2" aria-labelledby="faqAccordionHeading2">
                                <div class="accordion-body p-3 p-md-4">
                                    <div class="row g-3">
                                        @foreach ($fisik1 as $f1)
                                        <div class="col-12">
                                            <label class="ent-field-label text-uppercase">{{ $f1->diag_poli_fisik_umum_name }}</label>
                                            <textarea name="{{ $f1->diag_poli_fisik_umum_code }}" class="form-control" rows="3" placeholder="Tuliskan {{ strtolower($f1->diag_poli_fisik_umum_name) }} pasien secara rinci..."></textarea>
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
            <div class="col-12 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2" style="border-color: var(--ent-h-border) !important;">
                <button type="button" class="btn btn-dark ent-btn-action px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
                <span id="menu-handling-pasien-poliklinik">
                    <button class="btn ent-btn-submit" id="button-handling-pasien-poliklinik" type="button">
                        <i class="fas fa-check-circle me-2"></i> Simpan &amp; Proses Handling
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>
