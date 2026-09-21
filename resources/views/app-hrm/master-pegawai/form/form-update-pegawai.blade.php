<style>
    input[type="file"] {
        display: none;
    }

    .modal-header-gradient {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .upload-box {
        border: 2px dashed #f59e0b;
        border-radius: 12px;
        background-color: #f8f9fa;
        padding: 1.2rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-box:hover {
        background-color: #e9ecef;
        border-color: #d97706;
    }

    .preview-img-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .preview-img-container img {
        object-fit: cover;
        max-height: 220px;
        width: 100%;
    }

    .section-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #d97706;
        margin-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.4rem;
    }
</style>

<div class="modal-body p-0">
    <!-- Header Modal -->
    <div class="modal-header-gradient text-white py-3 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 text-white fw-bold"><i class="fas fa-user-edit me-2"></i>Update Data Pegawai</h4>
            <p class="fs--2 mb-0 opacity-75">Sistem Manajemen SDM Transforma</p>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form method="POST" action="#" enctype="multipart/form-data" id="form-update-pegawai">
        @csrf
        <!-- Primary Code Pegawai -->
        <input type="hidden" name="code" value="{{ $data->hrm_m_pegawai_code }}">

        <div class="p-4" id="menu-add-data-pr-all">
            <div class="row g-4">

                <!-- Kolom 1: Pratinjau & Upload Foto Profil -->
                <div class="col-lg-4 text-center border-end-lg">
                    <div class="section-title text-start"><i class="fas fa-camera me-1"></i> Foto Profil Pegawai</div>

                    <div class="preview-img-container mb-3 bg-light">
                        @php
                        $defaultFoto = asset('asset/img/team/avatar.png');
                        $cabang = Auth::user()->access_cabang ?? 'PA';
                        $fotoPath = !empty($data->hrm_m_pegawai_img)
                        ? asset('storage/pegawai/profile/' . $cabang . '/' . $data->hrm_m_pegawai_img)
                        : $defaultFoto;
                        @endphp
                        <a href="{{ $fotoPath }}" data-fancybox="images">
                            <img src="{{ $fotoPath }}" alt="Preview Foto" class="img-fluid rounded" id="videoPreview" onerror="this.src='{{ $defaultFoto }}'">
                        </a>
                    </div>

                    <label for="profile-image" class="upload-box w-100 d-block text-center mb-3">
                        <input type="file" id="profile-image" class="form-control" />
                        <i class="fas fa-cloud-upload-alt fa-2x text-warning mb-2"></i>
                        <div class="fw-bold text-dark">Klik untuk Ganti Foto</div>
                        <small class="text-muted">Format: JPG, JPEG, PNG</small>
                    </label>

                    <div class="progress shadow-sm" style="height: 16px; display: none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning loading"
                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                    </div>
                </div>

                <!-- Kolom 2: Identitas & Demografi -->
                <div class="col-lg-4">
                    <div class="section-title"><i class="fas fa-user me-1"></i> Identitas & Demografi</div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="nama_lengkap" value="{{ $data->hrm_m_pegawai_name ?? '' }}" placeholder="Ex. John Doe" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control" id="nik" value="{{ $data->hrm_m_pegawai_nik ?? '' }}" placeholder="16 Digit NIK" maxlength="16" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" name="nip" class="form-control" id="nip" value="{{ $data->hrm_m_pegawai_nip ?? '' }}" placeholder="NIP Pegawai">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jk" id="jenis_kelamin" class="form-select choices-single-jk" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="l" {{ ($data->hrm_m_pegawai_gender ?? '') == 'l' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="p" {{ ($data->hrm_m_pegawai_gender ?? '') == 'p' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" name="place" class="form-control" id="tempat_lahir" value="{{ $data->hrm_m_pegawai_pob ?? '' }}" placeholder="Ex. Pontianak">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="dob" class="form-control" id="tgl_lahir" value="{{ $data->hrm_m_pegawai_dob ?? '' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Agama</label>
                        <select name="agama" id="agama" class="form-select choices-single-agama">
                            <option value="">Pilih Agama</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha'] as $ag)
                            <option value="{{ $ag }}" {{ ($data->hrm_m_pegawai_agama ?? '') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Kolom 3: Jabatan, Kontak & Alamat -->
                <div class="col-lg-4">
                    <div class="section-title"><i class="fas fa-briefcase me-1"></i> Pekerjaan & Lokasi</div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Departemen / Jabatan <span class="text-danger">*</span></label>
                        <select name="posisi" id="posisi" class="form-select choices-single-dept" required>
                            <option value="">Pilih Departemen</option>
                            @if(isset($departemen))
                            @foreach ($departemen as $dep)
                            <option value="{{ $dep->hrm_departemen_code }}" {{ ($data->hrm_m_pegawai_dept_code ?? '') == $dep->hrm_departemen_code ? 'selected' : '' }}>
                                {{ $dep->hrm_departemen_name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">No Handphone <span class="text-danger">*</span></label>
                            <input type="text" name="hp" class="form-control" id="no_hp" value="{{ $data->hrm_m_pegawai_phone ?? '' }}" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ $data->hrm_m_pegawai_email ?? '' }}" placeholder="contoh@gmail.com">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-select choices-single-prov">
                                <option value="">Pilih Provinsi</option>
                                <option value="KB" {{ ($data->hrm_m_pegawai_provinsi ?? '') == 'KB' ? 'selected' : '' }}>Kalimantan Barat</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kota</label>
                            <select name="kota" id="kota" class="form-select choices-single-kota">
                                <option value="">Pilih Kota</option>
                                <option value="pontianak" {{ ($data->hrm_m_pegawai_kota ?? '') == 'pontianak' ? 'selected' : '' }}>Pontianak</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-select choices-single-kec">
                            <option value="">Pilih Kecamatan</option>
                            <option value="sui.bangkon" {{ ($data->hrm_m_pegawai_kecamatan ?? '') == 'sui.bangkon' ? 'selected' : '' }}>Sungai Bangkong</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Masukkan jalan, no. rumah, RT/RW">{{ $data->hrm_m_pegawai_address ?? '' }}</textarea>
                    </div>

                    <input id="link" type="hidden" name="link" value="">
                </div>

            </div>
        </div>

        <!-- Footer Modal -->
        <div class="modal-footer bg-light px-4 py-3">
            <button type="button" class="btn btn-secondary px-4 me-2" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Batal
            </button>
            <div id="menu-update-data-pegawai">
                <button type="button" class="btn btn-warning px-4 fw-bold text-white shadow-sm" id="button-update-data-pegawai">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Inisialisasi Choice.js -->
<script>
    if (document.querySelector(".choices-single-jk")) new window.Choices(document.querySelector(".choices-single-jk"));
    if (document.querySelector(".choices-single-agama")) new window.Choices(document.querySelector(".choices-single-agama"));
    if (document.querySelector(".choices-single-dept")) new window.Choices(document.querySelector(".choices-single-dept"));
    if (document.querySelector(".choices-single-prov")) new window.Choices(document.querySelector(".choices-single-prov"));
    if (document.querySelector(".choices-single-kota")) new window.Choices(document.querySelector(".choices-single-kota"));
    if (document.querySelector(".choices-single-kec")) new window.Choices(document.querySelector(".choices-single-kec"));
</script>

<!-- Resumable.js Upload -->
<script type="text/javascript">
    var browseFile = $('#profile-image');
    var resumable = new Resumable({
        target: "{{ route('master_data_pegawai_upload_profile') }}",
        query: {
            _token: '{{ csrf_token() }}'
        },
        fileType: ['jpg', 'jpeg', 'png'],
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
        response = JSON.parse(response);
        $('#videoPreview').attr('src', response.path);
        $('#videoPreview').parent().attr('href', response.path);
        $('#link').val(response.filename);
        hideProgress();
    });

    resumable.on('fileError', function(file, response) {
        alert('Gagal mengunggah foto profil.');
        hideProgress();
    });

    var progress = $('.progress');

    function showProgress() {
        progress.find('.loading').css('width', '0%').html('0%');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.loading').css('width', `${value}%`).html(`${value}%`);
    }

    function hideProgress() {
        progress.hide();
    }
</script>

<!-- Process AJAX Update Submit -->
<script>
    $(document).ready(function() {
        $('#button-update-data-pegawai').off('click').on('click', function(e) {
            e.preventDefault();

            var form = $('#form-update-pegawai');

            // Validasi HTML5 bawaan browser
            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return false;
            }

            var formData = new FormData(form[0]);

            $.ajax({
                url: "{{ route('master_data_pegawai_update_store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#button-update-data-pegawai').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
                },
                success: function(response) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data pegawai berhasil diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        alert('Data pegawai berhasil diperbarui!');
                    }

                    $('.modal').modal('hide');
                    $(document).trigger("pegawaiDataUpdated");
                },
                error: function(xhr) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error!', 'Terjadi kesalahan saat memperbarui data.', 'error');
                    } else {
                        alert('Terjadi kesalahan saat memperbarui data.');
                    }
                    console.log(xhr.responseText);
                },
                complete: function() {
                    $('#button-update-data-pegawai').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
                }
            });
        });
    });
</script>
