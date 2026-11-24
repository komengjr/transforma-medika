<style>
    .rad-handling-surface {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color);
    }

    .rad-avatar-box {
        width: 112px;
        height: 112px;
        border-radius: 14px;
        border: 1px solid var(--ent-grid-border);
        background-color: rgba(79, 70, 229, 0.05);
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08);
    }

    .rad-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rad-input-group .input-group-text {
        background-color: rgba(79, 70, 229, 0.08) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        color: var(--ent-indigo) !important;
        min-width: 40px;
        justify-content: center;
    }

    [data-bs-theme="dark"] .rad-input-group .input-group-text,
    .dark .rad-input-group .input-group-text {
        color: #a5b4fc !important;
    }

    .rad-input-group .form-control,
    .rad-input-group .ent-input {
        border-left: none !important;
        border-radius: 0 10px 10px 0 !important;
        min-height: 38px !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }

    .rad-input-group .form-control:disabled,
    .rad-input-group .form-control[readonly] {
        background-color: rgba(79, 70, 229, 0.04) !important;
        opacity: 1 !important;
    }

    .rad-accordion .accordion-item {
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color) !important;
        overflow: hidden;
    }

    .rad-accordion .accordion-item:first-child {
        border-radius: 12px 12px 0 0 !important;
    }

    .rad-accordion .accordion-item:last-child {
        border-radius: 0 0 12px 12px !important;
    }

    .rad-accordion .accordion-button {
        background-color: rgba(79, 70, 229, 0.06) !important;
        color: var(--bs-body-color) !important;
        font-weight: 700 !important;
        font-size: 0.82rem !important;
        padding: 11px 14px !important;
        box-shadow: none !important;
    }

    .rad-accordion .accordion-button:not(.collapsed) {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--ent-indigo) !important;
    }

    [data-bs-theme="dark"] .rad-accordion .accordion-button:not(.collapsed),
    .dark .rad-accordion .accordion-button:not(.collapsed) {
        color: #a5b4fc !important;
    }

    .rad-accordion .accordion-body {
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        padding: 14px !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    .rad-unpaid-box {
        border: 1px solid rgba(225, 29, 72, 0.35);
        background-color: rgba(225, 29, 72, 0.05);
        border-radius: 14px;
    }
</style>

<div class="modal-body p-0 rad-handling-surface">
    <div class="ent-card-header py-3 px-4 pe-5 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" id="staticBackdropLabel">
                <i class="fas fa-x-ray text-primary"></i>
                <span>Handling Pasien Radiologi</span>
            </h5>
            <p class="small mb-0 opacity-75 mt-0.5">
                Support by <a class="fw-semibold text-primary text-decoration-none" href="#!">Transforma</a>
            </p>
        </div>
        <span class="code-chip">Order: {{ $code }}</span>
    </div>

    @php
        $payment = DB::table('d_reg_order_payment')->where('d_reg_order_list_code', $code)->first();
        $fotoProfil = !empty($data->master_patient_profile) ? asset($data->master_patient_profile) : asset('img/lab.png');
    @endphp

    @if ($payment)
        <div class="p-3 p-md-4">
            <div class="row g-3 align-items-start">
                <div class="col-md-2 d-flex justify-content-center pt-md-2">
                    <div class="rad-avatar-box">
                        <img src="{{ $fotoProfil }}" alt="Foto {{ $data->master_patient_name ?? 'Pasien' }}"
                            id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="rad_nama_lengkap" class="ent-field-label">Nama Lengkap</label>
                            <div class="input-group rad-input-group">
                                <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                <input type="text" id="rad_nama_lengkap" name="nama"
                                    class="form-control ent-input"
                                    value="{{ $data->master_patient_name }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="nik" class="ent-field-label">NIK</label>
                            <div class="input-group rad-input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="nik"
                                    class="form-control ent-input" id="nik"
                                    value="{{ $data->master_patient_nik }}" disabled style="font-family: 'JetBrains Mono', monospace;">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <label for="rad_no_rm" class="ent-field-label">No Rekam Medis</label>
                            <div class="input-group rad-input-group">
                                <span class="input-group-text"><i class="fas fa-file-medical"></i></span>
                                <input type="text" id="rad_no_rm"
                                    class="form-control ent-input"
                                    value="{{ $data->master_patient_code }}" disabled style="font-family: 'JetBrains Mono', monospace;">
                                <input type="hidden" name="no_rm" id="no_rm"
                                    value="{{ $data->master_patient_code }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="rad_jk" class="ent-field-label">Jenis Kelamin</label>
                            <div class="input-group rad-input-group">
                                <span class="input-group-text"><i class="fas fa-transgender"></i></span>
                                <input type="text" name="jk" id="rad_jk"
                                    class="form-control ent-input"
                                    value="{{ $data->master_patient_jk }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="tgl_lahir" class="ent-field-label">Tanggal Lahir</label>
                            <div class="input-group rad-input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                <input type="date" name="tgl_lahir"
                                    class="form-control ent-input" id="tgl_lahir"
                                    value="{{ $data->master_patient_tgl_lahir }}" disabled style="font-family: 'JetBrains Mono', monospace;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="ent-card p-3">
                        <div class="accordion rad-accordion" id="accordionRadiologi">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="radHeadingAntropometri">
                                    <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseRadAntropometri"
                                        aria-expanded="true" aria-controls="collapseRadAntropometri">
                                        <i class="fas fa-weight me-2 text-warning"></i> Berat, Tinggi Badan &amp; Lingkar Perut
                                    </button>
                                </h2>
                                <div id="collapseRadAntropometri" class="accordion-collapse collapse show"
                                    aria-labelledby="radHeadingAntropometri">
                                    <div class="accordion-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="rad_berat_badan" class="ent-field-label">Berat Badan (kg)</label>
                                                <div class="input-group rad-input-group">
                                                    <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                                    <input type="text" id="rad_berat_badan" name="berat_badan"
                                                        class="form-control ent-input" placeholder="Contoh: 65">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="rad_tinggi_badan" class="ent-field-label">Tinggi Badan (cm)</label>
                                                <div class="input-group rad-input-group">
                                                    <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
                                                    <input type="text" id="rad_tinggi_badan" name="tinggi_badan"
                                                        class="form-control ent-input" placeholder="Contoh: 170">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="rad_lingkar_perut" class="ent-field-label">Lingkar Perut (cm)</label>
                                                <div class="input-group rad-input-group">
                                                    <span class="input-group-text"><i class="fas fa-ruler-horizontal"></i></span>
                                                    <input type="text" id="rad_lingkar_perut" name="lingkar_perut"
                                                        class="form-control ent-input" placeholder="Contoh: 80">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="radHeadingSuhu">
                                    <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseRadSuhu"
                                        aria-expanded="true" aria-controls="collapseRadSuhu">
                                        <i class="fas fa-thermometer-half me-2 text-warning"></i> Suhu Badan &amp; Catatan Klinis
                                    </button>
                                </h2>
                                <div id="collapseRadSuhu" class="accordion-collapse collapse show"
                                    aria-labelledby="radHeadingSuhu">
                                    <div class="accordion-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-4">
                                                <label for="rad_suhu_badan" class="ent-field-label">Suhu Badan (°C)</label>
                                                <div class="input-group rad-input-group">
                                                    <span class="input-group-text"><i class="fas fa-temperature-high"></i></span>
                                                    <input type="text" id="rad_suhu_badan" name="suhu_badan"
                                                        class="form-control ent-input" placeholder="Contoh: 36.5">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <p class="small mb-0 opacity-75">
                                                    Pastikan data antropometri dan kondisi klinis awal pasien terisi sebelum melanjutkan ke proses pemeriksaan radiologi.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="radHeadingKeluhan">
                                    <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseRadKeluhan"
                                        aria-expanded="true" aria-controls="collapseRadKeluhan">
                                        <i class="fas fa-notes-medical me-2 text-warning"></i> Keluhan Saat Ini
                                    </button>
                                </h2>
                                <div id="collapseRadKeluhan" class="accordion-collapse collapse show"
                                    aria-labelledby="radHeadingKeluhan">
                                    <div class="accordion-body">
                                        <label for="rad_keluhan" class="ent-field-label">Catatan Keluhan / Riwayat Singkat</label>
                                        <textarea id="rad_keluhan" name="keluhan_saat_ini" rows="3"
                                            class="form-control ent-input" style="min-height: 82px !important; padding-top: 10px !important;"
                                            placeholder="Tuliskan keluhan utama atau indikasi pemeriksaan radiologi..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div id="menu-handling-pasien-lab" class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn ent-btn ent-btn-warning px-4 py-2"
                            id="button-handling-pasien-lab" data-code="{{ $code }}">
                            <i class="fas fa-arrow-right me-1"></i> Proses Handling
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="p-3 p-md-4">
            <div class="rad-unpaid-box p-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="ent-badge" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);">
                        <i class="fas fa-exclamation-circle me-1"></i> Status Pembayaran
                    </span>
                </div>
                <h6 class="fw-bold text-danger mb-1">Pembayaran Belum Lunas</h6>
                <p class="small mb-0 opacity-75">Pastikan Pasien Sudah Melakukan Pembayaran Terlebih Dahulu sebelum proses handling dijalankan.</p>
            </div>
        </div>
    @endif
</div>
