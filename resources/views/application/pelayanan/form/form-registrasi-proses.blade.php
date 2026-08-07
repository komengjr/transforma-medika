<div class="modal-body p-0">
    <div class="bg-dark rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Registrasi Pasien : {{ $no_reg }}</h4>
        <input type="text" name="no_registrasi" id="no_registrasi" value="{{ $no_reg }}" hidden>
        <p class="fs--2 mb-0 text-warning">Support by <a class="text-warning fw-semi-bold"
                href="#!">{{ env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="card m-3 border border-info">
        <div class="px-3 py-3 pb-3">
            <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-home" role="tab"
                        aria-controls="pill-tab-home" aria-selected="true">
                        <span class="far fa-user"></span>
                        <span class="d-none d-md-inline-block mx-2">Data Pasien</span>
                    </a>
                </li>
                <li class="nav-item" style="display: none;" id="menu-fasilitas-layanan">
                    <a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab" href="#pill-tab-profile" role="tab"
                        aria-controls="pill-tab-profile" aria-selected="false">
                        <span class="fas fa-cogs"></span>
                        <span class="d-none d-md-inline-block mx-2">Fasilitas Layanan</span>
                    </a>
                </li>
                <li class="nav-item" style="display: none;" id="menu-cetak-data-registrasi">
                    <a class="nav-link" id="pill-contact-tab" data-bs-toggle="tab" href="#pill-tab-contact" role="tab"
                        aria-controls="pill-tab-contact" aria-selected="false">
                        <span class="fas fa-file-invoice"></span>
                        <span class="d-none d-md-inline-block mx-2">Cetak No Registrasi <i id="button-pilih-end-proses"
                                data-code="{{ $no_reg }}" data-id="{{ $data->master_patient_code }}"
                                style="display: none;"></i></span>
                    </a>
                </li>
            </ul>
            <div class="tab-content border p-3 mt-3" id="pill-myTabContent">
                <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card border mt-2">
                        <div class="row g-3 pb-3 rounded-4" style="background: linear-gradient(135deg, #eef2f3 0%, #8e9eab 100%);">
                            <input type="hidden" id="patient_id" name="patient_id" value="{{ $data->id_master_patient  }}">
                            <input type="hidden" id="patient_code" value="{{ $data->master_patient_code  }}">
                            <input type="hidden" id="patient_name" value="{{ $data->master_patient_name  }}">
                            <!-- KOLOM KIRI: Profil Utama (Theme Gradient Dark/Navy) -->
                            <div class="col-md-3">
                                <div class="card border-0 shadow-lg text-center p-3 h-100 rounded-4 text-white position-relative overflow-hidden"
                                    style="background: linear-gradient(145deg, #1e3c72 0%, #2a5298 100%);">

                                    <!-- Hiasan Background Circle Decorative -->
                                    <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 150px; height: 150px; top: -50px; right: -50px;"></div>

                                    <!-- Foto Profil dengan Ring Gradient -->
                                    <div class="position-relative d-inline-block mx-auto mb-2 mt-2">
                                        <div class="p-1 rounded-circle bg-warning shadow">
                                            <div class="avatar avatar-5xl rounded-circle overflow-hidden bg-white" style="width: 95px; height: 95px;">
                                                @if ($data->master_patient_profile == "")
                                                <img src="{{ asset('img/pasien.png') }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                                                @else
                                                <img src="{{ Storage::url($data->master_patient_profile) }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nama Pasien -->
                                    <h6 class="fw-bold text-white mb-1 text-truncate" style="font-size: 1rem; letter-spacing: 0.5px;">{{ $data->master_patient_name }}</h6>

                                    <!-- Badge No. RM (Gradient Gold/Yellow) -->
                                    <div class="mb-3">
                                        <span class="badge shadow-sm px-3 py-1 rounded-pill text-dark fw-bold"
                                            style="font-size: 0.78rem; font-family: monospace; background: linear-gradient(45deg, #ffe000, #799f0c);">
                                            <i class="fas fa-id-card me-1"></i> {{ $data->master_patient_code }}
                                        </span>
                                        <input type="text" name="no_rm" id="no_rm" value="{{ $data->master_patient_code }}" hidden>
                                    </div>

                                    <!-- Ringkasan Info Cepat (Glassmorphism Effect) -->
                                    <div class="p-2 rounded-3 text-start mt-auto shadow-inner" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(5px); font-size: 0.78rem;">
                                        <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom border-white-50">
                                            <span class="text-white-50"><i class="fas fa-venus-mars me-1 text-info"></i> Gender</span>
                                            <span class="fw-bold text-warning">
                                                {{ ($data->master_patient_jk == 'L' || $data->master_patient_jk == 'l') ? 'Laki-Laki' : 'Perempuan' }}
                                            </span>
                                            <select name="jk" id="jenis_kelamin" hidden>
                                                <option value="{{ strtolower($data->master_patient_jk) }}" selected></option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-white-50"><i class="fas fa-birthday-cake me-1 text-info"></i> Tgl Lahir</span>
                                            <span class="fw-bold text-white">{{ $data->master_patient_tgl_lahir ? date('d/m/Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</span>
                                            <input type="date" name="tgl_lahir" id="tgl_lahir" value="{{ $data->master_patient_tgl_lahir }}" hidden>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- KOLOM KANAN: Detail Pasien (Clean & Colorful Accent Grid) -->
                            <div class="col-md-9">
                                <div class="card border-0 shadow-lg p-3 h-100 rounded-4 bg-white">

                                    <!-- Header Section -->
                                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom border-2">
                                        <span class="text-uppercase fw-bold text-primary d-flex align-items-center" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                            <span class="p-1 rounded-2 bg-primary-subtle me-2">
                                                <i class="fas fa-user-check text-primary"></i>
                                            </span>
                                            Detail Resume Identitas
                                        </span>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.7rem;">
                                            <i class="fas fa-check-circle me-1"></i> Data Pasien Aktif
                                        </span>
                                    </div>

                                    <div class="row g-2">
                                        <!-- NIK (Aksen Biru) -->
                                        <div class="col-md-6">
                                            <label class="form-label text-secondary mb-1" style="font-size: 0.75rem; font-weight: 700;">NIK</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-primary text-white border-0"><i class="fas fa-id-badge"></i></span>
                                                <input type="text" name="nik" id="nik" class="form-control bg-primary-subtle text-primary fw-bold border-0" value="{{ $data->master_patient_nik }}" disabled style="font-size: 0.82rem;">
                                            </div>
                                        </div>

                                        <!-- No Handphone (Aksen Hijau WhatsApp) -->
                                        <div class="col-md-6">
                                            <label class="form-label text-secondary mb-1" style="font-size: 0.75rem; font-weight: 700;">No. WhatsApp / HP</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-success text-white border-0"><i class="fab fa-whatsapp"></i></span>
                                                <input type="text" name="no_hp" id="no_hp" class="form-control bg-success-subtle text-success fw-bold border-0" value="{{ $data->master_patient_no_hp }}" disabled style="font-size: 0.82rem;">
                                            </div>
                                        </div>

                                        <!-- Tempat Lahir (Aksen Ungu) -->
                                        <div class="col-md-4">
                                            <label class="form-label text-secondary mb-1" style="font-size: 0.75rem; font-weight: 700;">Tempat Lahir</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-purple text-white border-0" style="background-color: #6f42c1;"><i class="fas fa-map-marker-alt"></i></span>
                                                <input type="text" name="tempat_lahir" class="form-control bg-light text-dark fw-semibold border-0" value="{{ $data->master_patient_tempat_lahir }}" disabled style="font-size: 0.8rem;">
                                            </div>
                                        </div>

                                        <!-- Agama (Aksen Oranye) -->
                                        <div class="col-md-4">
                                            <label class="form-label text-secondary mb-1" style="font-size: 0.75rem; font-weight: 700;">Agama</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text text-white border-0" style="background-color: #fd7e14;"><i class="fas fa-pray"></i></span>
                                                <input type="text" name="agama" class="form-control bg-light text-dark fw-semibold border-0" value="{{ $data->master_patient_agama }}" disabled style="font-size: 0.8rem;">
                                            </div>
                                        </div>

                                        <!-- Kota (Aksen Teal) -->
                                        <div class="col-md-4">
                                            <label class="form-label text-secondary mb-1" style="font-size: 0.75rem; font-weight: 700;">Kota / Kabupaten</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text text-white border-0" style="background-color: #20c997;"><i class="fas fa-city"></i></span>
                                                <input type="text" name="kota" class="form-control bg-light text-dark fw-semibold border-0" value="{{ $data->M_CityName }}" disabled style="font-size: 0.8rem;">
                                            </div>
                                        </div>

                                        <!-- Email (Editable Field - Accent Light Blue) -->
                                        <div class="col-12">
                                            <label class="form-label text-secondary mb-1" style="font-size: 0.75rem; font-weight: 700;">Alamat Email</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-info text-white border-0"><i class="fas fa-envelope"></i></span>
                                                <input type="email" name="email" class="form-control border-info-subtle text-dark fw-semibold" value="{{ $data->master_patient_email }}" placeholder="Masukkan email pasien..." style="font-size: 0.8rem;">
                                            </div>
                                        </div>

                                        <!-- Deskripsi Alamat -->
                                        <div class="col-12">
                                            <label class="form-label text-secondary mb-1" style="font-size: 0.75rem; font-weight: 700;">Alamat Lengkap</label>
                                            <textarea class="form-control form-control-sm bg-light text-dark fw-semibold border-0" name="alamat" id="inputAddress3" rows="2" disabled style="font-size: 0.8rem;">{{ $data->master_patient_alamat }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Tombol Action Utama (Gradient Green Button) -->
                                    <div class="d-flex justify-content-end align-items-center mt-3 pt-2 border-top">
                                        <button class="btn text-white btn-sm px-4 rounded-pill shadow fw-bold transition-all" id="button-pilih-kebutuhan" data-code="{{ $no_reg }}"
                                            style="font-size: 0.82rem; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none;">
                                            Lanjut Ke Fasilitas Layanan <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div id="menu-kebutuhan-registrasi"></div>
                </div>
                <div class="tab-pane fade" id="pill-tab-contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div id="menu-invoice-registrasi"></div>
                </div>
            </div>
        </div>
    </div>

</div>
