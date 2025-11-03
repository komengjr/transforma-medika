<div class="modal-body p-0">
    <div class="bg-dark rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Verifikasi data Registrasi Pasien</h4>
        <p class="fs--2 mb-0 text-warning">Support by <a class="text-warning fw-semi-bold" href="#!">{{ env('APP_NAME') }}</a>
        </p>
    </div>

    <div class="row g-3 p-3" id="menu-registrasi-pasien">
        <div class="col-md-7">
            <div class="card border border-dark">
                <form class="row g-3 p-3" id="form-create-pasien-baru" method="POST">
                    @csrf
                    <input type="text" name="no_reg" id="no_reg" value="{{ $pasien->d_reg_order_code }}" hidden>
                    <div class="col-md-2 d-flex justify-content-center">
                        <div class="avatar avatar-5xl shadow-sm img-thumbnail  justify-content-center">
                            <div class="h-100 w-100 overflow-hidden">
                                @if ($pasien->master_patient_profile == "")
                                    <img src="{{ asset('img/pasien.png') }}" class="img-thumbnail " alt="" id="videoPreview"
                                        data-dz-thumbnail="data-dz-thumbnail">
                                @else
                                    <img src="{{ Storage::url($pasien->master_patient_profile) }}" class="img-thumbnail "
                                        alt="" id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                                @endif
                            </div>

                        </div>

                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label text-youtube">Nama Lengkap</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-user-friends"></i></span>
                                    <input type="text" name="nama" class="form-control form-control-lg border-start-0"
                                        value="{{ $pasien->master_patient_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-money-check"></i></span>
                                    <input type="text" name="nik" class="form-control form-control-lg border-start-0"
                                        value="{{ $pasien->master_patient_nik }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label text-youtube">Jenis Kelamin</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-transgender fs-2"></i></span>
                                    <input type="text" name="nama" class="form-control form-control-lg border-start-0"
                                        value="{{ $pasien->master_patient_jk }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName1" class="form-label text-youtube">Tanggal Lahir</label>
                                <div class="input-group"> <span class="input-group-text"><i
                                            class="fas fa-calendar-day"></i></span>
                                    <input type="date" name="tgl_lahir"
                                        class="form-control form-control-lg border-start-0"
                                        value="{{ $pasien->master_patient_tgl_lahir }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label">Tempat Lahir</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-map-marked-alt"></i></span>
                            <input type="text" name="tgl_lahir" class="form-control form-control-lg border-start-0"
                                value="{{ $pasien->master_patient_tempat_lahir }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputEmailAddress" class="form-label text-youtube">Agama</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-pray"></i></span>
                            <input type="text" name="tgl_lahir" class="form-control form-control-lg border-start-0"
                                value="{{ $pasien->master_patient_agama }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName2" class="form-label text-youtube">No Handphone</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-phone-square-alt"></i></span>
                            <input type="text" name="tgl_lahir" class="form-control form-control-lg border-start-0"
                                value="{{ $pasien->master_patient_no_hp }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="inputLastName2" class="form-label">Email</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                            <input type="text" name="tgl_lahir" class="form-control form-control-lg border-start-0"
                                value="{{ $pasien->master_patient_email }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Lokasi</label>

                        <select name="provinsi" id="data_provinsi" class="form-control choices-single-provinsi"
                            id="data_company" size="1" name="organizerSingle"
                            data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Provinsi</option>

                        </select>

                    </div>

                    <!-- <div id="detail-city"></div> -->
                    <div class="col-12">
                        <label for="inputAddress3" class="form-label text-youtube">Deskripsi Alamat</label>
                        <textarea class="form-control" name="alamat" id="inputAddress3" placeholder="Enter Address"
                            rows="3">{{ $pasien->master_patient_alamat }}</textarea>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card border border-dark p-3">
                <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                    @foreach ($data as $datas)
                        <li class="nav-item me-2">
                            <a class="nav-link border border-primary" id="button-data-verifikasi"
                                data-code="{{ $datas->d_reg_order_list_code }}" data-bs-toggle="tab" href="#pill-tab-home"
                                role="tab" aria-controls="pill-tab-home{{ $datas->id_d_reg_order_list }}"
                                aria-selected="true">{{ $datas->t_layanan_cat_name }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content border p-3 mt-3" id="pill-myTabContent">
                    <div class="tab-pane fade" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
                        <div id="menu-data-verifikasi">
                            Raw denim you probably haven't heard of them jean shorts Austin.
                            Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor,
                            williamsburg
                            carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby
                            sweater
                            eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-200">
    <span id="menu-loading-verifikasi">
        <button class="btn btn-falcon-primary" id="button-save-data-verifikasi-registrasi">Verifikasi Data</button>
    </span>
</div>
