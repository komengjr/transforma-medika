<div class="modal-body p-0">
    <div class="bg-dark rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Registrasi Pasien : {{ $no_reg }}</h4>
        <input type="text" name="no_registrasi" id="no_registrasi" value="{{ $no_reg }}" hidden>
        <p class="fs--2 mb-0 text-warning">Support by <a class="text-warning fw-semi-bold" href="#!">{{ env('APP_LABEL')}}</a>
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
                        <div class="row g-3 px-3 px-sm-4 py-3 bg-200">
                            <div class="col-md-2 d-flex justify-content-center">
                                <div class="avatar avatar-5xl shadow-sm img-thumbnail justify-content-center">
                                    <div class="h-100 w-100 overflow-hidden ">
                                        @if ($data->master_patient_profile == "")
                                            <img src="{{ asset('img/pasien.png') }}"
                                                class="img-thumbnail shadow-sm" alt="" id="videoPreview"
                                                data-dz-thumbnail="data-dz-thumbnail">
                                        @else
                                            <img src="{{ Storage::url($data->master_patient_profile) }}"
                                                class="img-thumbnail shadow-sm" alt="" id="videoPreview"
                                                data-dz-thumbnail="data-dz-thumbnail">
                                        @endif
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputLastName1" class="form-label text-primary">Nama Lengkap</label>
                                        <div class="input-group"> <span class="input-group-text"><i
                                                    class="fas fa-user-friends"></i></span>
                                            <input type="text" name="nama"
                                                class="form-control form-control-lg border-start-0 bg-white"
                                                value="{{ $data->master_patient_name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                                        <div class="input-group"> <span class="input-group-text"><i
                                                    class="fas fa-money-check"></i></span>
                                            <input type="text" name="nik"
                                                class="form-control form-control-lg border-start-0 bg-white" id="nik"
                                                value="{{ $data->master_patient_nik }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputLastName1" class="form-label text-youtube">No Rekam
                                            Medis</label>
                                        <div class="input-group"> <span class="input-group-text"><i
                                                    class="fas fa-money-check"></i></span>
                                            <input type="text" name="nik"
                                                class="form-control form-control-lg border-start-0 bg-white" id="nik"
                                                value="{{ $data->master_patient_code }}" disabled>
                                            <input type="text" name="no_rm" id="no_rm"
                                                value="{{ $data->master_patient_code }}" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputLastName1" class="form-label text-youtube">Jenis
                                            Kelamin</label>
                                        <div class="input-group"> <span class="input-group-text"><i
                                                    class="fas fa-transgender fs-2"></i></span>
                                            <select name="jk" id="jenis_kelamin"
                                                class="form-control form-control-lg single-select" disabled>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="l">Laki Laki</option>
                                                <option value="p">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputLastName1" class="form-label text-youtube">Tanggal
                                            Lahir</label>
                                        <div class="input-group"> <span class="input-group-text"><i
                                                    class="fas fa-calendar-day"></i></span>
                                            <input type="date" name="tgl_lahir"
                                                class="form-control form-control-lg bg-white border-start-0"
                                                id="tgl_lahir" value="{{ $data->master_patient_tgl_lahir }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName1" class="form-label">Tempat Lahir</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-map-marked-alt"></i></span>
                                    <input type="text" name="tempat_lahir"
                                        class="form-control form-control-lg border-start-0 bg-white" id="inputLastName1"
                                        value="{{ $data->master_patient_tempat_lahir }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmailAddress" class="form-label text-youtube">Agama</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-pray"></i></span>
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
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-phone-square-alt"></i></span>
                                    <input type="text" name="no_hp"
                                        class="form-control form-control-lg border-start-0 bg-white" id="no_hp"
                                        value="{{ $data->master_patient_no_hp }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName2" class="form-label">Email</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-mail-bulk"></i></span>
                                    <input type="email" name="email"
                                        class="form-control form-control-lg border-start-0 bg-white" id="inputLastName2"
                                        value="{{ $data->master_patient_email }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName1" class="form-label text-youtube">Provinsi</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-map-marker-alt"></i></span>
                                    <select name="provinsi" id="" class="form-control form-control-lg single-select">
                                        <option value="">Pilih Provinsi</option>
                                        <option value="KB">Kalimantan Barat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName1" class="form-label">Kota</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-city"></i></span>
                                    <select name="kota" id="" class="form-control form-control-lg single-select">
                                        <option value="">Pilih Kota</option>
                                        <option value="pontianak">Pontianak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress3" class="form-label text-youtube">Deskripsi Alamat</label>
                                <textarea class="form-control" name="alamat" id="inputAddress3"
                                    placeholder="Enter Address" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success float-end" id="button-pilih-kebutuhan"
                                    data-code="{{ $no_reg }}">Lanjut Ke Fasilitas Layanan</button>
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
