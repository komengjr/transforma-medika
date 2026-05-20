<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Data Anggota</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-peserta-baru" method="POST">
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
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-user-friends"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control form-control-lg border-start-0"
                                id="nama_lengkap" value="{{ $data->kop_master_peserta_name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Jenis Kelamin</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-transgender fs-2"></i></span>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control form-control-lg single-select">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="l">Laki Laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nik" class="form-control form-control-lg border-start-0" id="nik" value="{{ $data->kop_master_peserta_nik }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">NIP</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nip" class="form-control form-control-lg border-start-0" id="nik"
                                value="{{ $data->kop_master_peserta_nip }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label text-youtube">Tanggal Lahir</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                    <input type="date" name="tgl_lahir" class="form-control form-control-lg border-start-0" id="tgl_lahir"
                        value="{{ $data->kop_master_peserta_tgl_lahir }}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Tempat Lahir</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="tempat_lahir" class="form-control form-control-lg border-start-0"
                        id="inputLastName1" value="{{ $data->kop_master_peserta_tempat_lahir }}">
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
                        value="{{ $data->kop_master_peserta_no_hp }}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName2" class="form-label">Email</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                    <input type="email" name="email" class="form-control form-control-lg border-start-0" id="inputLastName2" value="{{ $data->kop_master_peserta_email }}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label text-youtube">Cabang</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <select name="cabang" id="" class="form-control form-control-lg single-select">
                        <option value="">Pilih Cabang</option>

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label text-youtube">Pilih Divisi / Departemen</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <select name="divisi" id="" class="form-control form-control-lg single-select">
                        <option value="">Pilih</option>

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName2" class="form-label">Tanggal Masuk Kerja</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                    <input type="date" name="tgl_masuk" class="form-control form-control-lg border-start-0">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName2" class="form-label">Tanggal Masuk Anggota</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                    <input type="date" name="tgl_anggota" class="form-control form-control-lg border-start-0">
                </div>
            </div>
            <div class="col-12">
                <label for="inputAddress3" class="form-label text-youtube">Deskripsi Alamat</label>
                <textarea class="form-control" name="alamat" id="inputAddress3" placeholder="Enter Address"
                    rows="3">{{ $data->kop_master_peserta_alamat }}</textarea>
            </div>
            <input id="link" type="text" name="link" class="form-control" hidden>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-peserta">
        <button class="btn btn-success float-end" id="button-update-save-data-peserta" data-code="">Update
            Data</button>
    </span>
</div>
