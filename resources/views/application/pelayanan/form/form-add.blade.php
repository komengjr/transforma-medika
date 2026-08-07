<!-- Custom Style & Animation Effect untuk Form Pasien Baru -->
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #1A73E8 0%, #00C6FF 100%);
        --accent-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --card-glow: 0 10px 30px rgba(0, 198, 255, 0.12);
    }

    /* Card Effect & Elevasi */
    .card-pasien-wrapper {
        border: none !important;
        border-radius: 1rem !important;
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
    }

    .card-pasien-wrapper:hover {
        box-shadow: var(--card-glow);
        transform: translateY(-3px);
    }

    /* Header Banner Gradasi */
    .form-header-banner {
        background: var(--primary-gradient);
        padding: 1.25rem 1.75rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .form-header-banner::after {
        content: "";
        position: absolute;
        right: -20px;
        top: -20px;
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    /* Section Ribbon Header */
    .form-section-title-colored {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 1rem;
        border-radius: 50rem;
        background: rgba(0, 198, 255, 0.1);
        color: #0077b6;
        font-size: 0.825rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 1.25rem;
    }

    /* Upload Avatar Circular Gradient */
    .patient-avatar-container {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto;
        border-radius: 50%;
        padding: 4px;
        background: var(--primary-gradient);
        box-shadow: 0 6px 15px rgba(0, 123, 255, 0.25);
        transition: transform 0.3s ease;
    }

    .patient-avatar-container:hover {
        transform: scale(1.05) rotate(2deg);
    }

    .patient-avatar-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        background: #ffffff;
    }

    .patient-avatar-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .patient-avatar-overlay-glow {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 119, 182, 0.7);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #fff;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }

    .patient-avatar-container:hover .patient-avatar-overlay-glow {
        opacity: 1;
    }

    /* Input Custom Styling & Hover Effects */
    .input-group-colored {
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        overflow: hidden;
        border: 1px solid #e0e6ed;
    }

    .input-group-colored .input-group-text {
        background-color: #f4f8fb;
        border: none;
        color: #0077b6;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .input-group-colored .form-control,
    .input-group-colored .form-select {
        border: none;
        padding: 0.65rem 0.9rem;
        font-size: 0.925rem;
        background-color: #f4f8fb;
        transition: background-color 0.3s ease;
    }

    .input-group-colored:focus-within {
        border-color: #00c6ff;
        box-shadow: 0 0 0 0.25rem rgba(0, 198, 255, 0.15);
        background-color: #ffffff;
    }

    .input-group-colored:focus-within .form-control,
    .input-group-colored:focus-within .form-select,
    .input-group-colored:focus-within .input-group-text {
        background-color: #ffffff;
    }

    /* Modern Textarea Style */
    .textarea-colored {
        background-color: #f4f8fb;
        border: 1px solid #e0e6ed;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .textarea-colored:focus {
        background-color: #ffffff;
        border-color: #00c6ff;
        box-shadow: 0 0 0 0.25rem rgba(0, 198, 255, 0.15);
    }

    /* Choices JS Customization */
    .choices__inner {
        min-height: 46px !important;
        border-radius: 0.5rem !important;
        border: 1px solid #e0e6ed !important;
        background-color: #f4f8fb !important;
        padding: 0.4rem 0.75rem !important;
    }

    .choices[data-type*="select-one"]:focus-within .choices__inner {
        border-color: #00c6ff !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(0, 198, 255, 0.15);
    }

    /* Glowing Save Button */
    .btn-gradient-save {
        background: var(--primary-gradient);
        border: none;
        color: #ffffff;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 50rem;
        box-shadow: 0 4px 15px rgba(0, 198, 255, 0.35);
        transition: all 0.3s ease;
    }

    .btn-gradient-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(0, 198, 255, 0.5);
        color: #ffffff;
    }

    .btn-gradient-save:active {
        transform: translateY(0);
    }
</style>

<!-- Baris Progress Bar Upload Foto -->
<div class="progress rounded-pill mb-3 shadow-sm" style="height: 10px; display: none;">
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info loading" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
</div>

<form class="p-2" id="form-create-pasien-baru" method="POST">
    @csrf

    <div class="card card-pasien-wrapper">
        <!-- Header Banner Berwarna -->
        <div class="form-header-banner d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="bg-white text-primary rounded-circle p-2 me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="fas fa-user-plus fa-lg text-primary"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-white">Formulir Registrasi Pasien Baru</h5>
                    <small class="text-white-50">Silakan lengkapi biodata pasien di bawah ini secara teliti.</small>
                </div>
            </div>
            <span class="badge bg-white text-primary fw-bold px-3 py-2 rounded-pill shadow-sm d-none d-md-inline-block">
                <i class="fas fa-shield-alt me-1"></i> Data Terproteksi
            </span>
        </div>

        <div class="card-body p-4">

            <!-- SECTION 1: FOTO & IDENTITAS UTAMA -->
            <div class="row g-4 align-items-center mb-4">
                <div class="col-lg-3 text-center border-end-lg pe-lg-4">
                    <div class="patient-avatar-container mb-2">
                        <div class="patient-avatar-inner">
                            <img src="{{ asset('asset/img/team/avatar.png') }}" id="videoPreview" alt="Foto Pasien">
                            <input class="d-none" id="profile-image" type="file" accept="image/*">
                            <label class="patient-avatar-overlay-glow mb-0" for="profile-image">
                                <i class="fas fa-camera fa-2x mb-1"></i>
                                <span class="extra-small fw-semibold">Ganti Foto</span>
                            </label>
                        </div>
                    </div>
                    <small class="text-muted d-block fw-semibold" style="font-size: 0.78rem;">
                        <i class="fas fa-info-circle text-info me-1"></i>Format JPG/PNG (Max 2MB)
                    </small>
                </div>

                <div class="col-lg-9">
                    <div class="form-section-title-colored">
                        <i class="fas fa-id-card me-2"></i>1. Identitas Utama Pasien
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label fw-bold text-dark small">NAMA LENGKAP <span class="text-danger">*</span></label>
                            <div class="input-group input-group-colored">
                                <span class="input-group-text"><i class="fas fa-user text-primary"></i></span>
                                <input type="text" name="nama" class="form-control" id="nama_lengkap" placeholder="Ex. John Doe">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="nik" class="form-label fw-bold text-dark small">NOMOR NIK (KTP/KK) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-colored">
                                <span class="input-group-text"><i class="fas fa-address-card text-success"></i></span>
                                <input type="text" name="nik" class="form-control" id="nik" maxlength="16" placeholder="*16 Digit Angka NIK">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label fw-bold text-dark small">JENIS KELAMIN <span class="text-danger">*</span></label>
                            <div class="input-group input-group-colored">
                                <span class="input-group-text"><i class="fas fa-venus-mars text-warning"></i></span>
                                <select name="jk" id="jenis_kelamin" class="form-select">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="l">Laki-Laki</option>
                                    <option value="p">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="tgl_lahir" class="form-label fw-bold text-dark small">TANGGAL LAHIR <span class="text-danger">*</span></label>
                            <div class="input-group input-group-colored">
                                <span class="input-group-text"><i class="fas fa-calendar-day text-danger"></i></span>
                                <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4 text-secondary opacity-25">

            <!-- SECTION 2: BIODATA TAMBAHAN & ALAMAT -->
            <div class="form-section-title-colored">
                <i class="fas fa-map-marked-alt me-2"></i>2. Demografi & Alamat Domisili
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label fw-bold text-dark small">TEMPAT LAHIR</label>
                    <div class="input-group input-group-colored">
                        <span class="input-group-text"><i class="fas fa-building text-info"></i></span>
                        <input type="text" name="tempat_lahir" class="form-control" id="inputLastName1" placeholder="Ex. Pontianak">
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="agama" class="form-label fw-bold text-dark small">AGAMA</label>
                    <div class="input-group input-group-colored">
                        <span class="input-group-text"><i class="fas fa-pray text-purple" style="color: #6f42c1;"></i></span>
                        <select name="agama" id="agama" class="form-select">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Khonghucu">Khonghucu</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="no_hp" class="form-label fw-bold text-dark small">NO. TELEPON / WHATSAPP <span class="text-danger">*</span></label>
                    <div class="input-group input-group-colored">
                        <span class="input-group-text"><i class="fas fa-phone-alt text-success"></i></span>
                        <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Ex. 08982839xxx">
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="inputLastName2" class="form-label fw-bold text-dark small">ALAMAT EMAIL</label>
                    <div class="input-group input-group-colored">
                        <span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
                        <input type="email" name="email" class="form-control" id="inputLastName2" placeholder="Ex. contoh@gmail.com">
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="data_provinsi" class="form-label fw-bold text-dark small">PROVINSI DOMISILI</label>
                    <select name="provinsi" id="data_provinsi" class="form-control choices-single-provinsi">
                        <option value="">Pilih Provinsi</option>
                        @foreach ($provinsi as $pro)
                        <option value="{{$pro->M_ProvinceID}}">{{$pro->M_ProvinceName}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12" id="detail-prov">
                    <input type="text" name="data_city" id="data_city" hidden>
                </div>

                <div class="col-12">
                    <label for="inputAddress3" class="form-label fw-bold text-dark small">DESKRIPSI ALAMAT LENGKAP</label>
                    <textarea class="form-control textarea-colored" name="alamat" id="inputAddress3" placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, dan patokan alamat..." rows="3"></textarea>
                </div>
            </div>

            <input id="link" type="text" name="link" class="form-control d-none" hidden>

            <!-- FOOTER DENGAN TOMBOL SIMPAN GLOWING -->
            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <span class="text-muted small">
                    <i class="fas fa-asterisk text-danger me-1"></i><span class="fw-semibold">Wajib diisi</span>
                </span>
                <button type="button" id="button-save-create-pasien-baru" class="btn btn-gradient-save">
                    <i class="fas fa-check-circle me-2"></i> Simpan Data Pasien
                </button>
            </div>

        </div>
    </div>
</form>

<script>
    // Inisialisasi Choices Select
    if (document.querySelector(".choices-single-provinsi")) {
        new window.Choices(document.querySelector(".choices-single-provinsi"), {
            searchEnabled: true,
            removeItemButton: true,
            itemSelectText: '',
        });
    }

    // AJAX Pemilihan Provinsi
    $('#data_provinsi').on("change", function() {
        var dataid = $(this).val();
        if (!dataid) {
            if (typeof Lobibox !== 'undefined') {
                Lobibox.notify('warning', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-info-circle',
                    msg: 'Pastikan Kategori & Layanan Sudah dipilih'
                });
            }
        } else {
            $.ajax({
                url: "{{ route('registrasi_pasien_create_pilih_provinsi') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataid,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#detail-prov").html(data);
            }).fail(function() {
                console.log('Terjadi kesalahan memuat data kota');
            });
        }
    });
</script>

<!-- Script Upload Foto (Resumable.js) -->
<script type="text/javascript">
    var browseFile = $('#profile-image');
    var resumable = new Resumable({
        target: "{{ route('file-upload.data-profile') }}",
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

    resumable.assignBrowse(browseFile);

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
        setTimeout(function() {
            hideProgress();
        }, 800);
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
        progress.find('.loading').css('width', value + '%').html(value + '%');
    }

    function hideProgress() {
        progress.hide();
    }
</script>
