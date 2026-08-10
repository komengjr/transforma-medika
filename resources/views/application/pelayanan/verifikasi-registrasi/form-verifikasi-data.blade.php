<style>
    /* Header Gradient Colorful */
    .modal-compact-header {
        background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 50%, #4f46e5 100%);
        padding: 10px 18px;
    }

    /* Card Container */
    .profile-card-mini {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    /* Soft Colored Badges & Backgrounds */
    .bg-soft-primary {
        background-color: #eff6ff;
        color: #2563eb;
    }

    .bg-soft-info {
        background-color: #f0f9ff;
        color: #0284c7;
    }

    .bg-soft-purple {
        background-color: #faf5ff;
        color: #9333ea;
    }

    .bg-soft-danger {
        background-color: #fef2f2;
        color: #dc2626;
    }

    .bg-soft-success {
        background-color: #f0fdf4;
        color: #16a34a;
    }

    .bg-soft-warning {
        background-color: #fffbeb;
        color: #d97706;
    }

    /* Label Styling */
    .label-mini-color {
        font-size: 0.65rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Input Fields dengan Aksen Border Focus Warna-Warni */
    .form-control-compact {
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        font-size: 0.78rem !important;
        color: #0f172a !important;
        font-weight: 600 !important;
        padding: 4px 8px !important;
        height: 30px;
    }

    .form-control-compact:focus {
        border-color: #3b82f6 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15) !important;
    }

    /* Dynamic Colorful Nav Pills */
    .nav-pill-compact .nav-link {
        background-color: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 0.72rem;
        border-radius: 20px;
        padding: 4px 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .nav-pill-compact .nav-link.active {
        background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        color: #ffffff !important;
        border-color: transparent;
        box-shadow: 0 3px 10px rgba(37, 99, 235, 0.3);
    }
</style>

<div class="modal-body p-0 bg-light-subtle">
    <!-- Header Gradient Colorful -->
    <div class="modal-compact-header text-white d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <span class="p-1 bg-white bg-opacity-20 rounded-circle d-inline-flex">
                <i class="fas fa-user-check fs--1 text-white"></i>
            </span>
            <h6 class="mb-0 text-white fw-bold">Verifikasi Data Registrasi</h6>
        </div>
        <span class="badge bg-white text-primary rounded-pill px-3 py-1 fs--2 fw-bold shadow-sm">
            <i class="fas fa-hashtag me-1"></i>{{ $pasien->d_reg_order_code }}
        </span>
    </div>

    <!-- Content Area Compact Grid -->
    <div class="row g-3 p-3" id="menu-registrasi-pasien">

        <!-- KOLOM KIRI: Ringkasan Identitas Pasien (Colorful & Compact) -->
        <div class="col-lg-5">
            <div class="profile-card-mini p-3 h-100 border-top border-3 border-primary">
                <form id="form-create-pasien-baru" method="POST">
                    @csrf
                    <input type="hidden" name="no_reg" id="no_reg" value="{{ $pasien->d_reg_order_code }}">

                    <!-- Mini Profile Header Colorful -->
                    <div class="d-flex align-items-center gap-3 pb-2 mb-2 border-bottom">
                        <div class="position-relative flex-shrink-0">
                            @if ($pasien->master_patient_profile == "")
                            <img src="{{ asset('img/pasien.png') }}" class="rounded-circle p-1 bg-soft-primary border border-primary border-2" width="45" height="45" alt="Avatar" id="videoPreview">
                            @else
                            <img src="{{ Storage::url($pasien->master_patient_profile) }}" class="rounded-circle p-1 bg-soft-primary border border-primary border-2 object-fit-cover" width="45" height="45" alt="Avatar" id="videoPreview">
                            @endif
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="fw-bold text-dark mb-0 text-truncate">{{ $pasien->master_patient_name }}</h6>
                            <span class="badge bg-soft-info rounded-pill px-2 py-0 fs--2 fw-bold mt-1">
                                <i class="fas fa-id-card me-1"></i>NIK: {{ $pasien->master_patient_nik ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- Form Inputs dengan Ikon Berwarna -->
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="label-mini-color text-primary">
                                <i class="fas fa-user text-primary"></i> Nama Lengkap
                            </label>
                            <input type="text" name="nama" class="form-control form-control-compact fw-bold text-primary" value="{{ $pasien->master_patient_name }}" readonly>
                        </div>

                        <div class="col-6">
                            <label class="label-mini-color text-danger">
                                <i class="fas fa-venus-mars text-danger"></i> Jenis Kelamin
                            </label>
                            <input type="text" name="jk" class="form-control form-control-compact" value="{{ $pasien->master_patient_jk }}" readonly>
                        </div>

                        <div class="col-6">
                            <label class="label-mini-color text-warning">
                                <i class="fas fa-calendar-alt text-warning"></i> Tgl Lahir
                            </label>
                            <input type="text" name="tgl_lahir" class="form-control form-control-compact" value="{{ $pasien->master_patient_tgl_lahir }}" readonly>
                        </div>

                        <div class="col-6">
                            <label class="label-mini-color text-success">
                                <i class="fas fa-map-marker-alt text-success"></i> Tempat Lahir
                            </label>
                            <input type="text" name="tempat_lahir" class="form-control form-control-compact" value="{{ $pasien->master_patient_tempat_lahir }}" readonly>
                        </div>

                        <div class="col-6">
                            <label class="label-mini-color text-info">
                                <i class="fas fa-phone-alt text-info"></i> No. HP
                            </label>
                            <input type="text" name="no_hp" class="form-control form-control-compact" value="{{ $pasien->master_patient_no_hp }}" readonly>
                        </div>

                        <div class="col-6">
                            <label class="label-mini-color text-purple">
                                <i class="fas fa-pray text-purple"></i> Agama
                            </label>
                            <input type="text" name="agama" class="form-control form-control-compact" value="{{ $pasien->master_patient_agama }}" readonly>
                        </div>

                        <div class="col-6">
                            <label class="label-mini-color text-primary">
                                <i class="fas fa-city text-primary"></i> Provinsi
                            </label>
                            <select name="provinsi" id="data_provinsi" class="form-select form-control-compact py-0">
                                <option value="">Pilih...</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="label-mini-color text-secondary">
                                <i class="fas fa-envelope text-secondary"></i> Email
                            </label>
                            <input type="text" name="email" class="form-control form-control-compact" value="{{ $pasien->master_patient_email }}" readonly>
                        </div>

                        <div class="col-12">
                            <label class="label-mini-color text-dark">
                                <i class="fas fa-home text-dark"></i> Alamat Lengkap
                            </label>
                            <textarea class="form-control form-control-compact" name="alamat" id="inputAddress3" rows="2" style="height: auto;" placeholder="Alamat">{{ $pasien->master_patient_alamat }}</textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- KOLOM KANAN: Detail Layanan & Pemeriksaan (Area Utama) -->
        <div class="col-lg-7">
            <div class="profile-card-mini p-3 h-100 d-flex flex-column border-top border-3 border-info">
                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                    <span class="fw-bold text-dark fs--1">
                        <i class="fas fa-stethoscope text-info me-1"></i>Pemeriksaan & Layanan
                    </span>
                    <span class="badge bg-soft-info rounded-pill px-2 py-1 fs--2 fw-bold">
                        {{ count($data) }} Item
                    </span>
                </div>

                <!-- Nav Pills Compact Colorful -->
                <ul class="nav nav-pill-compact gap-1 mb-2" id="pill-myTab" role="tablist">
                    @foreach ($data as $datas)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="button-data-verifikasi"
                            data-code="{{ $datas->d_reg_order_list_code }}" data-bs-toggle="tab" href="#pill-tab-home"
                            role="tab" aria-controls="pill-tab-home{{ $datas->id_d_reg_order_list }}" aria-selected="true">
                            <i class="fas fa-check-circle me-1 text-success"></i>{{ $datas->t_layanan_cat_name }}
                        </button>
                    </li>
                    @endforeach
                </ul>

                <!-- Box Hasil Pemeriksaan / Detail (Area Luas) -->
                <div class="tab-content flex-grow-1" id="pill-myTabContent">
                    <div class="tab-pane fade show active h-100" id="pill-tab-home" role="tabpanel">
                        <div id="menu-data-verifikasi" class="p-3 rounded-3 bg-soft-info border border-info border-opacity-25 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3 bg-white rounded-circle shadow-sm mb-2 text-info">
                                <i class="fas fa-file-medical fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 fs--1">Rincian Pemeriksaan</h6>
                            <p class="text-muted fs--2 mb-0" style="max-width: 280px;">Klik salah satu kategori layanan di atas untuk memuat rincian data verifikasi secara lengkap.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Footer Minimalis Colorful -->
<div class="modal-footer bg-white border-top border-light px-3 py-2 d-flex justify-content-between align-items-center">
    <button type="button" class="btn btn-light text-secondary rounded-pill px-3 py-1 fw-bold fs--2 border" data-bs-dismiss="modal">
        Batal
    </button>
    <span id="menu-loading-verifikasi">
        <button class="btn btn-primary rounded-pill px-4 py-1 fw-bold fs--2 shadow-sm border-0" id="button-save-data-verifikasi-registrasi" style="background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);">
            <i class="fas fa-check-circle me-1"></i> Verifikasi Data
        </button>
    </span>
</div>
