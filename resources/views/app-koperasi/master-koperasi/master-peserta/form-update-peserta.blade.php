<style>
    .ent-modal-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    .ent-modal-form .ent-section-title {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #4f46e5;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 6px;
        border-bottom: 1px dashed rgba(99, 102, 241, 0.3);
        margin-bottom: 12px;
    }

    .ent-modal-form .ent-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-modal-form .input-group-text {
        background-color: rgba(79, 70, 229, 0.08);
        border: 1px solid rgba(99, 102, 241, 0.28);
        border-right: none;
        border-radius: 10px 0 0 10px !important;
        color: #4f46e5;
        font-size: 0.85rem;
        min-width: 38px;
        justify-content: center;
    }

    .ent-modal-form .form-control,
    .ent-modal-form .form-select {
        border: 1px solid rgba(99, 102, 241, 0.28) !important;
        border-radius: 0 10px 10px 0 !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-modal-form textarea.form-control {
        border-radius: 10px !important;
    }

    .ent-modal-form .form-control:focus,
    .ent-modal-form .form-select:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14) !important;
    }

    .ent-avatar-box {
        width: 112px;
        height: 112px;
        border-radius: 50%;
        border: 3px solid rgba(99, 102, 241, 0.45);
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.18);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        background-color: rgba(79, 70, 229, 0.06);
    }

    .ent-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ent-avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.58);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s ease;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .ent-avatar-box:hover .ent-avatar-overlay {
        opacity: 1;
    }

    .ent-btn-update {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.82rem;
        padding: 9px 20px;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.28);
        transition: all 0.18s ease;
    }

    .ent-btn-update:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.38);
        color: #ffffff;
    }
</style>

<div class="modal-body p-0">
    <!-- HEADER BANNER -->
    <div class="ent-modal-header-banner rounded-top-lg py-3 px-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3"
                style="width: 44px; height: 44px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.18);">
                <i class="fas fa-user-edit fa-lg text-info"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold" id="staticBackdropLabel" style="letter-spacing: -0.01em; color: white;">
                    Form Update Data Anggota
                </h5>
                <p class="fs--2 mb-0" style="color: #cbd5e1;">
                    Kode Peserta: <span class="fw-bold text-info" style="font-family: 'JetBrains Mono', monospace;">{{ $data->kop_master_peserta_code ?? '-' }}</span>
                    &bull; Support by <a class="text-white fw-semi-bold text-decoration-underline" href="#!">Transforma</a>
                </p>
            </div>
        </div>
        <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>

    <!-- FORM CONTENT -->
    <div class="p-4" id="menu-add-data-pr-all">
        <form class="row g-3 ent-modal-form" id="form-peserta-baru" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_peserta" value="{{ $data->id_kop_master_peserta ?? '' }}">
            <input type="hidden" name="code_peserta" value="{{ $data->kop_master_peserta_code ?? '' }}">

            <!-- SECTION 1: IDENTITAS UTAMA & FOTO -->
            <div class="col-12">
                <div class="ent-section-title">
                    <i class="fas fa-id-card"></i> Identitas Utama Anggota
                </div>
            </div>

            <div class="col-md-3 d-flex flex-column align-items-center justify-content-center">
                <label for="profile-image" class="ent-avatar-box mb-2" title="Klik untuk mengganti foto profil">
                    <img src="{{ !empty($data->kop_master_peserta_foto) ? asset($data->kop_master_peserta_foto) : asset('asset/img/team/avatar.png') }}"
                        alt="Foto Anggota" id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                    <div class="ent-avatar-overlay">
                        <i class="fas fa-camera fa-lg mb-1"></i>
                        <span>Ganti Foto</span>
                    </div>
                </label>
                <input class="d-none" id="profile-image" name="foto" type="file" accept="image/*"
                    onchange="if(this.files && this.files[0]){ document.getElementById('videoPreview').src = URL.createObjectURL(this.files[0]); }">
                <span class="text-muted" style="font-size: 0.68rem;">Format JPG/PNG (Maks. 2MB)</span>
            </div>

            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_lengkap" class="form-label ent-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap"
                                value="{{ $data->kop_master_peserta_name }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="form-label ent-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select single-select">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="l" {{ strtolower($data->kop_master_peserta_jk ?? '') === 'l' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="p" {{ strtolower($data->kop_master_peserta_jk ?? '') === 'p' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="nik" class="form-label ent-label">NIK (KTP) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                            <input type="text" name="nik" class="form-control" id="nik"
                                style="font-family: 'JetBrains Mono', monospace;"
                                value="{{ $data->kop_master_peserta_nik }}" placeholder="16 digit NIK">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="nip" class="form-label ent-label">NIP / ID Karyawan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            <input type="text" name="nip" class="form-control" id="nip"
                                style="font-family: 'JetBrains Mono', monospace;"
                                value="{{ $data->kop_master_peserta_nip }}" placeholder="Nomor Induk Pegawai">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: DATA PRIBADI & KONTAK -->
            <div class="col-12 mt-4">
                <div class="ent-section-title">
                    <i class="fas fa-address-book"></i> Data Pribadi & Kontak
                </div>
            </div>

            <div class="col-md-4">
                <label for="tempat_lahir" class="form-label ent-label">Tempat Lahir</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                    <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                        value="{{ $data->kop_master_peserta_tempat_lahir }}" placeholder="Kota kelahiran">
                </div>
            </div>

            <div class="col-md-4">
                <label for="tgl_lahir" class="form-label ent-label">Tanggal Lahir</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                    <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir"
                        style="font-family: 'JetBrains Mono', monospace;"
                        value="{{ $data->kop_master_peserta_tgl_lahir }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="agama" class="form-label ent-label">Agama</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-pray"></i></span>
                    <select name="agama" id="agama" class="form-select single-select">
                        <option value="">-- Pilih Agama --</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'] as $agm)
                        <option value="{{ $agm }}" {{ strcasecmp($data->kop_master_peserta_agama ?? '', $agm) === 0 ? 'selected' : '' }}>
                            {{ $agm }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="no_hp" class="form-label ent-label">No. Handphone / WhatsApp <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    <input type="text" name="no_hp" class="form-control" id="no_hp"
                        style="font-family: 'JetBrains Mono', monospace;"
                        value="{{ $data->kop_master_peserta_no_hp }}" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label ent-label">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" id="email"
                        value="{{ $data->kop_master_peserta_email }}" placeholder="nama@email.com">
                </div>
            </div>

            <!-- SECTION 3: KEANGGOTAAN & PENEMPATAN -->
            <div class="col-12 mt-4">
                <div class="ent-section-title">
                    <i class="fas fa-building"></i> Keanggotaan & Penempatan Kerja
                </div>
            </div>

            <div class="col-md-6">
                <label for="cabang" class="form-label ent-label">Cabang Koperasi <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-code-branch"></i></span>
                    <select name="cabang" id="cabang" class="form-select single-select">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach(($list_cabang ?? collect()) as $cbg)
                        <option value="{{ $cbg->kop_master_cabang_code }}"
                            {{ ($data->kop_master_peserta_cabang ?? '') == $cbg->kop_master_cabang_code ? 'selected' : '' }}>
                            [{{ $cbg->kop_master_cabang_code }}] {{ $cbg->kop_master_cabang_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="divisi" class="form-label ent-label">Divisi / Departemen</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                    <select name="divisi" id="divisi" class="form-select single-select">
                        <option value="">-- Pilih Divisi / Departemen --</option>
                        @foreach(($list_divisi ?? collect()) as $div)
                        <option value="{{ $div->kop_master_divisi_code ?? $div->id ?? '' }}"
                            {{ ($data->kop_master_peserta_divisi ?? '') == ($div->kop_master_divisi_code ?? $div->id ?? '') ? 'selected' : '' }}>
                            {{ $div->kop_master_divisi_name ?? $div->nama_divisi ?? '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="tgl_masuk" class="form-label ent-label">Tanggal Masuk Kerja</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                    <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control"
                        style="font-family: 'JetBrains Mono', monospace;"
                        value="{{ $data->kop_master_peserta_tgl_masuk ?? '' }}">
                </div>
            </div>

            <div class="col-md-6">
                <label for="tgl_anggota" class="form-label ent-label">Tanggal Masuk Anggota</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                    <input type="date" name="tgl_anggota" id="tgl_anggota" class="form-control"
                        style="font-family: 'JetBrains Mono', monospace;"
                        value="{{ $data->kop_master_peserta_tgl_anggota ?? '' }}">
                </div>
            </div>

            <div class="col-12">
                <label for="alamat" class="form-label ent-label">Alamat Lengkap</label>
                <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat lengkap tempat tinggal..." rows="3">{{ $data->kop_master_peserta_alamat }}</textarea>
            </div>

            <input id="link" type="text" name="link" class="form-control" hidden>
        </form>
    </div>
</div>

<!-- MODAL FOOTER -->
<div class="modal-footer px-4 py-3 d-flex justify-content-between align-items-center"
    style="background-color: rgba(79, 70, 229, 0.04); border-top: 1px solid rgba(99, 102, 241, 0.28);">
    <button type="button" class="btn btn-secondary btn-sm px-3 py-2 fw-semibold" style="border-radius: 10px;" data-bs-dismiss="modal">
        <i class="fas fa-times me-1"></i> Batal
    </button>
    <span id="menu-add-data-peserta">
        <button type="button" class="btn ent-btn-update" id="button-update-save-data-peserta"
            data-code="{{ $data->kop_master_peserta_code ?? '' }}">
            <i class="fas fa-save me-1"></i> Update Data Anggota
        </button>
    </span>
</div>
