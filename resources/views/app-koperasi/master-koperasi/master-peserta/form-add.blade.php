<style>
    .ent-modal-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    .ent-field-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-modal-form .form-control,
    .ent-modal-form .form-select {
        border: 1px solid rgba(99, 102, 241, 0.28) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 40px;
        transition: all 0.2s ease;
    }

    .ent-modal-form .form-control:focus,
    .ent-modal-form .form-select:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-modal-form .input-group-text {
        border: 1px solid rgba(99, 102, 241, 0.28) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
    }

    .ent-modal-form .input-group > .form-control,
    .ent-modal-form .input-group > .form-select {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .ent-avatar-box {
        position: relative;
        width: 112px;
        height: 112px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.35), rgba(2, 132, 199, 0.35));
        box-shadow: 0 8px 20px -6px rgba(15, 23, 42, 0.25);
    }

    .ent-avatar-inner {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        background-color: var(--bs-body-bg);
    }

    .ent-avatar-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .ent-avatar-upload-btn {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.52);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s ease;
        cursor: pointer;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .ent-avatar-box:hover .ent-avatar-upload-btn {
        opacity: 1;
    }

    .ent-modal-footer {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-top: 1px solid rgba(99, 102, 241, 0.28) !important;
        padding: 14px 24px;
    }
</style>

<div class="modal-body p-0 ent-modal-form">
    <div class="ent-modal-banner py-3 px-4">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div>
                <span class="badge rounded-pill mb-1" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-size: 0.65rem; letter-spacing: 0.04em;">
                    <i class="fas fa-user-plus me-1"></i> KOPERASI MEMBER REGISTRATION
                </span>
                <h4 class="mb-0 fw-bold text-white" id="staticBackdropLabel" style="letter-spacing: -0.02em;">Form Add Data Anggota</h4>
                <p class="small mb-0 mt-0.5" style="color: #cbd5e1;">
                    Support by <a class="fw-semibold text-info text-decoration-none" href="#!">Transforma</a>
                </p>
            </div>
        </div>
    </div>

    <div class="p-4 pb-2" id="menu-add-data-pr-all">
        <form class="row g-3 pb-2" id="form-peserta-baru" method="POST">
            @csrf

            <!-- Avatar & Upload Foto -->
            <div class="col-lg-2 d-flex flex-column align-items-center justify-content-start pt-1">
                <div class="ent-avatar-box">
                    <div class="ent-avatar-inner">
                        <img src="{{ asset('asset/img/team/avatar.png') }}" alt="Avatar Anggota" id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                        <input class="d-none" id="profile-image" type="file" accept="image/jpeg,image/png">
                        <label class="ent-avatar-upload-btn mb-0" for="profile-image">
                            <i class="fas fa-camera mb-1"></i>
                            <span>Upload</span>
                        </label>
                    </div>
                </div>
                <span class="mt-2 text-center opacity-75" style="font-size: 0.68rem; font-weight: 600;">JPG / PNG</span>

                <div class="progress w-100 mt-2" style="display: none; height: 14px; border-radius: 999px; overflow: hidden;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary loading" role="progressbar" style="width: 0%; font-size: 0.65rem; font-weight: 700;">0%</div>
                </div>
            </div>

            <!-- Identitas Utama -->
            <div class="col-lg-10">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_lengkap" class="form-label ent-field-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control border-start-0" id="nama_lengkap" placeholder="Ex. Jhon Doe" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="form-label ent-field-label">Jenis Kelamin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-transgender"></i></span>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select single-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="l">Laki Laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="nik" class="form-label ent-field-label">NIK</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="nik" class="form-control border-start-0" id="nik" placeholder="*12 / 16 Digit" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="nip" class="form-label ent-field-label">NIP</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                            <input type="text" name="nip" class="form-control border-start-0" id="nip" placeholder="*12 Digit" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tempat, Tanggal Lahir & Agama -->
            <div class="col-md-4">
                <label for="tgl_lahir" class="form-label ent-field-label">Tanggal Lahir</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                    <input type="date" name="tgl_lahir" class="form-control border-start-0" id="tgl_lahir" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="tempat_lahir" class="form-label ent-field-label">Tempat Lahir</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="tempat_lahir" class="form-control border-start-0" id="tempat_lahir" placeholder="Ex. Pontianak" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="agama" class="form-label ent-field-label">Agama</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-pray"></i></span>
                    <select name="agama" id="agama" class="form-select single-select" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                    </select>
                </div>
            </div>

            <!-- Kontak & Cabang -->
            <div class="col-md-4">
                <label for="no_hp" class="form-label ent-field-label">No Handphone</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
                    <input type="text" name="no_hp" class="form-control border-start-0" id="no_hp" placeholder="Ex. 08982839182xxx" style="font-family: 'JetBrains Mono', monospace;" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="email" class="form-label ent-field-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control border-start-0" id="email" placeholder="Ex. Contoh@gmail.com" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="cabang" class="form-label ent-field-label">Pilih Cabang</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                    <select name="cabang" id="cabang" class="form-select single-select" required>
                        <option value="">Pilih Cabang</option>
                        @foreach ($cabang as $cab)
                        <option value="{{ $cab->kop_master_cabang_code }}">{{ $cab->kop_master_cabang_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Divisi & Tanggal Masuk -->
            <div class="col-md-4">
                <label for="divisi" class="form-label ent-field-label">Pilih Divisi / Departemen</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                    <select name="divisi" id="divisi" class="form-select single-select" required>
                        <option value="">Pilih</option>
                        @foreach ($divisi as $div)
                        <option value="{{ $div->kop_master_div_bag_code }}">{{ $div->kop_master_divisi_name }} - {{ $div->kop_master_div_bag_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <label for="tgl_masuk" class="form-label ent-field-label">Tanggal Masuk Kerja</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                    <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control border-start-0" required>
                </div>
            </div>

            <div class="col-md-4">
                <label for="tgl_anggota" class="form-label ent-field-label">Tanggal Masuk Anggota</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                    <input type="date" name="tgl_anggota" id="tgl_anggota" class="form-control border-start-0" required>
                </div>
            </div>

            <!-- Alamat -->
            <div class="col-12">
                <label for="inputAddress3" class="form-label ent-field-label">Deskripsi Alamat</label>
                <textarea class="form-control" name="alamat" id="inputAddress3" placeholder="Masukkan alamat lengkap anggota..." rows="3" required></textarea>
            </div>

            <input id="link" type="hidden" name="link">
        </form>
    </div>
</div>

<div class="modal-footer ent-modal-footer">
    <span id="menu-add-data-peserta" class="ms-auto">
        <button type="button" class="btn fw-semibold px-4 py-2 text-white" id="button-simpan-data-peserta" data-code=""
            style="background: linear-gradient(135deg, #059669 0%, #047857 100%); border: none; border-radius: 10px; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);">
            <i class="fas fa-save me-1"></i> Simpan Data
        </button>
    </span>
</div>

<script type="text/javascript">
    (function() {
        const browseFile = $('#profile-image');
        const progress = $('.progress');

        function showProgress() {
            progress.find('.loading').css('width', '0%').text('0%').removeClass('bg-info');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.loading').css('width', `${value}%`).text(`${value}%`);
        }

        function hideProgress() {
            progress.hide();
        }

        if (typeof Resumable !== 'undefined' && browseFile.length) {
            const resumable = new Resumable({
                target: "{{ route('master_koperasi_peserta_upload_profil') }}",
                query: {
                    _token: '{{ csrf_token() }}'
                },
                fileType: ['jpg', 'png'],
                headers: {
                    'Accept': 'application/json'
                },
                testChunks: false,
                throttleProgressCallbacks: 1,
            });

            resumable.assignBrowse(browseFile[0]);

            resumable.on('fileAdded', function(file) {
                showProgress();
                resumable.upload();
            });

            resumable.on('fileProgress', function(file) {
                updateProgress(Math.floor(file.progress() * 100));
            });

            resumable.on('fileSuccess', function(file, response) {
                try {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;
                    if (res.path) {
                        $('#videoPreview').attr('src', res.path).show();
                    }
                    if (res.filename) {
                        $('#link').val(res.filename);
                    }
                } catch (e) {
                    console.error('Gagal memproses respon upload:', e);
                }
                setTimeout(hideProgress, 800);
            });

            resumable.on('fileError', function() {
                hideProgress();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Gagal',
                        text: 'Terjadi kesalahan saat mengunggah foto.'
                    });
                } else {
                    alert('file uploading error.');
                }
            });
        }
    })();
</script>
