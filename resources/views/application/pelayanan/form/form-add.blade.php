<div class="progress" style="height: 10px; display: none;">
    <div class="progress-bar progress-bar-striped progress-bar-animated loading" role="progressbar" aria-valuenow="0"
        aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 100%">0%
    </div>
    <br>
</div>
<br>
<form class="row g-3 px-3 px-sm-4 pb-3" id="form-create-pasien-baru" method="POST">
    @csrf
    <div class="col-md-2 d-flex justify-content-center">
        <div class="avatar avatar-5xl shadow-sm img-thumbnail rounded-circle justify-content-center">
            <div class="h-100 w-100 rounded-circle overflow-hidden">
                <img src="{{ asset('asset/img/team/avatar.png') }}" width="200" alt="" id="videoPreview"
                    data-dz-thumbnail="data-dz-thumbnail">
                <input class="d-none" id="profile-image" type="file">
                <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image">
                    <span class="bg-holder overlay overlay-0"></span>
                    <span class="z-index-1 text-white dark__text-white text-center fs--1">
                        <span class="d-block">Upload</span></span></label>
            </div>

        </div>

    </div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">Nama Lengkap</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                    <input type="text" name="nama" class="form-control form-control-lg border-start-0"
                        id="nama_lengkap" placeholder="Ex. Jhon Doe">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                    <input type="text" name="nik" class="form-control form-control-lg border-start-0"
                        id="nik" placeholder="*12 Digit">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">Jenis Kelamin</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-transgender fs-2"></i></span>
                    <select name="jk" id="jenis_kelamin" class="form-control form-control-lg single-select">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="l">Laki Laki</option>
                        <option value="p">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">Tanggal Lahir</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                    <input type="date" name="tgl_lahir" class="form-control form-control-lg border-start-0"
                        id="tgl_lahir" placeholder="Nama Lengkap">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName1" class="form-label">Tempat Lahir</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
            <input type="text" name="tempat_lahir" class="form-control form-control-lg border-start-0"
                id="inputLastName1" placeholder="Ex. Pontianak">
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputEmailAddress" class="form-label text-youtube">Agama</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-pray"></i></span>
            <select name="agama" id="agama" class="form-control form-control-lg single-select">
                <option value="">Pilih Agama</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Budha">Budha</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName2" class="form-label text-youtube">No Handphone</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
            <input type="text" name="no_hp" class="form-control form-control-lg border-start-0" id="no_hp"
                placeholder="Ex. 08982839182xxx">
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName2" class="form-label">Email</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
            <input type="email" name="email" class="form-control form-control-lg border-start-0"
                id="inputLastName2" placeholder="Ex. Contoh@gmail.com">
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName1" class="form-label text-youtube">Provinsi</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
            <select name="provinsi" id="" class="form-control form-control-lg single-select">
                <option value="">Pilih Provinsi</option>
                <option value="KB">Kalimantan Barat</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName1" class="form-label">Kota</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-city"></i></span>
            <select name="kota" id="" class="form-control form-control-lg single-select">
                <option value="">Pilih Kota</option>
                <option value="pontianak">Pontianak</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName1" class="form-label">Kecamatan</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-city"></i></span>
            <select name="kecamatan" id="" class="form-control form-control-lg single-select">
                <option value="">Pilih Kecamatan</option>
                <option value="sui.bangkon">Sungai Bangkong</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName1" class="form-label">Kelurahan</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-city"></i></span>
            <select name="keluarahan" id="" class="form-control form-control-lg single-select">
                <option value="">Pilih Kelurahan</option>
            </select>
        </div>
    </div>

    <div class="col-12">
        <label for="inputAddress3" class="form-label text-youtube">Deskripsi Alamat</label>
        <textarea class="form-control" name="alamat" id="inputAddress3" placeholder="Enter Address" rows="3"></textarea>
    </div>
    <input id="link" type="text" name="link" class="form-control" hidden>

    <div class="col">
        <button style="float: right;" type="button" id="button-save-create-pasien-baru" class="btn btn-info"><i
                class="far fa-save"></i>
            Simpan Data</button>
    </div>
</form>
{{-- UPLOAD PERSENTASI --}}
<script type="text/javascript">
    var browseFile = $('#profile-image');
    var resumable = new Resumable({
        target: "{{ route('file-upload.data-profile') }}",
        query: {
            _token: '{{ csrf_token() }}'
        }, // CSRF token
        fileType: ['jpg', 'png'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });
    resumable.assignBrowse(browseFile);
    resumable.on('fileAdded', function(file) { // trigger wn file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });
    resumable.on('fileProgress', function(file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });
    resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview').show();
        $('#videoPreview').attr('src', response.path);
        $('#link').attr('value', response.filename);
        $('.card-footer').show();
        $('#browseFile').hide();
    });
    resumable.on('fileError', function(file, response) { // trigger when there is any error
        alert('file uploading error.')
    });
    var progress = $('.progress');
    function showProgress() {
        progress.find('.loading').css('width', '0%');
        progress.find('.loading').html('0%');
        progress.find('.loading').removeClass('bg-info');
        progress.show();
    }
    function updateProgress(value) {
        progress.find('.loading').css('width', ` ${value}%`)
        progress.find('.loading').html(`${value}%`)
    }
    function hideProgress() {
        progress.hide();
    }
</script>
