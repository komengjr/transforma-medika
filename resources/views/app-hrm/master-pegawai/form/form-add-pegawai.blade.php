<style>
    input[type="file"] {
        display: none;
    }

    .modal-header-gradient {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .upload-box {
        border: 2px dashed #0d6efd;
        border-radius: 12px;
        background-color: #f8f9fa;
        padding: 1.2rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-box:hover {
        background-color: #e9ecef;
        border-color: #0a58ca;
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
        color: #0d6efd;
        margin-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.4rem;
    }
</style>

<div class="modal-body p-0">
    <!-- Header Modal -->
    <div class="modal-header-gradient text-white py-3 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 text-white fw-bold"><i class="fas fa-user-plus me-2"></i>Tambah Data Pegawai Baru</h4>
            <p class="fs--2 mb-0 opacity-75">Sistem Manajemen SDM Transforma</p>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form method="POST" action="#" enctype="multipart/form-data" id="form-pegawai-baru">
        @csrf
        <div class="p-4" id="menu-add-data-pr-all">
            <div class="row g-4">

                <!-- Kolom 1: Upload Foto Profil -->
                <div class="col-lg-4 text-center border-end-lg">
                    <div class="section-title text-start"><i class="fas fa-camera me-1"></i> Foto Profil Pegawai</div>

                    <div class="preview-img-container mb-3 bg-light">
                        <a href="#" data-fancybox="images">
                            <img src="{{ asset('asset/img/team/avatar.png') }}" alt="Preview Foto" class="img-fluid rounded" id="videoPreview">
                        </a>
                    </div>

                    <label for="profile-image" class="upload-box w-100 d-block text-center mb-3">
                        <input type="file" id="profile-image" class="form-control" />
                        <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                        <div class="fw-bold text-dark">Klik untuk Unggah Foto</div>
                        <small class="text-muted">Format: JPG, JPEG, PNG</small>
                    </label>

                    <div class="progress shadow-sm" style="height: 16px; display: none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success loading"
                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                    </div>
                </div>

                <!-- Kolom 2: Informasi Utama & Demografi -->
                <div class="col-lg-4">
                    <div class="section-title"><i class="fas fa-user me-1"></i> Identitas & Demografi</div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="nama_lengkap" placeholder="Ex. John Doe" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control" id="nik" placeholder="16 Digit NIK" maxlength="16" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" name="nip" class="form-control" id="nip" placeholder="NIP Pegawai">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jk" id="jenis_kelamin" class="form-select choices-single-jk" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="l">Laki-Laki</option>
                            <option value="p">Perempuan</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" name="place" class="form-control" id="tempat_lahir" placeholder="Ex. Pontianak">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="dob" class="form-control" id="tgl_lahir">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Agama</label>
                        <select name="agama" id="agama" class="form-select choices-single-agama">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
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
                            @foreach ($departemen as $dep)
                            <option value="{{ $dep->hrm_departemen_code }}">{{ $dep->hrm_departemen_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">No Handphone <span class="text-danger">*</span></label>
                            <input type="text" name="hp" class="form-control" id="no_hp" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="contoh@gmail.com">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-select choices-single-prov">
                                <option value="">Pilih Provinsi</option>
                                <option value="KB">Kalimantan Barat</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kota</label>
                            <select name="kota" id="kota" class="form-select choices-single-kota">
                                <option value="">Pilih Kota</option>
                                <option value="pontianak">Pontianak</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-select choices-single-kec">
                            <option value="">Pilih Kecamatan</option>
                            <option value="sui.bangkon">Sungai Bangkong</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Masukkan jalan, no. rumah, RT/RW"></textarea>
                    </div>

                    <input id="link" type="text" name="link" hidden>
                </div>

            </div>
        </div>

        <!-- Footer Modal -->
        <div class="modal-footer bg-light px-4 py-3">
            <button type="button" class="btn btn-secondary px-4 me-2" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Batal
            </button>
            <div id="menu-add-data-pegawai">
                <button type="button" class="btn btn-primary px-4 fw-bold shadow-sm" id="button-simpan-data-pegawai">
                    <i class="fas fa-save me-1"></i> Simpan Data Pegawai
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    if (document.querySelector(".choices-single-jk")) new window.Choices(document.querySelector(".choices-single-jk"));
    if (document.querySelector(".choices-single-agama")) new window.Choices(document.querySelector(".choices-single-agama"));
    if (document.querySelector(".choices-single-dept")) new window.Choices(document.querySelector(".choices-single-dept"));
    if (document.querySelector(".choices-single-prov")) new window.Choices(document.querySelector(".choices-single-prov"));
    if (document.querySelector(".choices-single-kota")) new window.Choices(document.querySelector(".choices-single-kota"));
    if (document.querySelector(".choices-single-kec")) new window.Choices(document.querySelector(".choices-single-kec"));
</script>

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
<script>
    $(document).ready(function() {
        $('#button-simpan-data-pegawai').on('click', function(e) {
            e.preventDefault();

            var form = $('#form-pegawai-baru');

            // Validasi HTML5 bawaan browser (misal: required, maxlength)
            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return false;
            }

            var formData = new FormData(form[0]);

            $.ajax({
                url: "{{ route('master_data_pegawai_save') }}", // Ganti dengan nama route simpan Anda
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#button-simpan-data-pegawai').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
                },
                success: function(response) {
                    alert('Data berhasil disimpan!');
                    // Reset form atau tutup modal jika diperlukan
                    $('#form-pegawai-baru')[0].reset();
                    $('.modal').modal('hide');
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menyimpan data.');
                    console.log(xhr.responseText);
                },
                complete: function() {
                    $('#button-simpan-data-pegawai').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Data Pegawai');
                }
            });
        });
    });
</script>
