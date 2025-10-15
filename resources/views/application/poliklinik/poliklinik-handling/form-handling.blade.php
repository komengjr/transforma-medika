<div class="card mb-3">
    <div class="card-header bg-300">
        <h5 class="mb-0">Pasien Details</h5>
    </div>
    <div class="card-body bg-light">
        <form>
            <div class="row g-3">
                <div class="col-md-2 d-flex justify-content-center">
                    <div class="avatar avatar-5lg shadow-sm justify-content-center">
                        <div class="h-100 w-100 overflow-hidden ">
                            @if ($data->master_patient_profile == "")
                                <img src="{{ asset('img/pasien.png') }}" class="img-thumbnail " alt=""
                                    id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                            @else
                                <img src="{{ Storage::url($data->master_patient_profile) }}" class="img-thumbnail " alt=""
                                    id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                            @endif
                        </div>

                    </div>

                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
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
                        <div class="col-md-6">
                            <label for="inputLastName1" class="form-label text-youtube">No Rekam
                                Medis</label>
                            <div class="input-group"> <span class="input-group-text"><i
                                        class="fas fa-money-check"></i></span>
                                <input type="text" name="nik"
                                    class="form-control form-control-lg border-start-0 bg-white" id="nik"
                                    value="{{ $data->master_patient_code }}" disabled>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label text-youtube">Tanggal
                        Lahir</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                        <input type="date" name="tgl_lahir" class="form-control form-control-lg bg-white border-start-0"
                            id="tgl_lahir" value="{{ $data->master_patient_tgl_lahir }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label text-youtube">Jenis
                        Kelamin</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-transgender fs-2"></i></span>
                        <input type="text" class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
                            value="{{ $data->master_patient_jk }}" disabled>
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
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-pray fs-2"></i></span>
                        <input type="text" class="form-control form-control-lg bg-white border-start-0"
                            value="{{ $data->master_patient_agama }}" disabled>
                    </div>

                </div>
                <div class="col-md-4">
                    <label for="inputLastName2" class="form-label text-youtube">No Handphone</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-phone-square-alt"></i></span>
                        <input type="text" name="no_hp" class="form-control form-control-lg border-start-0 bg-white"
                            id="no_hp" value="{{ $data->master_patient_no_hp }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName2" class="form-label">Email</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                        <input type="email" name="email" class="form-control form-control-lg border-start-0 bg-white"
                            id="inputLastName2" value="{{ $data->master_patient_email }}" disabled>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-300">
        <h5 class="mb-0">Custom Fields</h5>
    </div>
    <div class="card-body bg-light">
        <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
            <div class="position-absolute end-0 top-0 mt-2 me-3 z-index-1">
                <button class="btn btn-link btn-sm p-0" type="button"><span class="fas fa-times-circle text-danger"
                        data-fa-transform="shrink-1"></span></button>
            </div>
            <div class="row gx-2">
                <div class="col-sm-6 mb-3">
                    <label class="form-label" for="field-name">Name</label>
                    <input class="form-control form-control-sm" id="field-name" type="text"
                        placeholder="Name (e.g. T-shirt)" />
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="form-label" for="field-type">Type</label>
                    <select class="form-select form-select-sm" id="field-type">
                        <option>Select a type</option>
                        <option>Text</option>
                        <option>Checkboxes</option>
                        <option>Radio Buttons</option>
                        <option>Textarea</option>
                        <option>Date</option>
                        <option>Dropdowns</option>
                        <option>File</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="field-options">Field Options</label>
                    <textarea class="form-control form-control-sm" id="field-options" rows="3"></textarea>
                    <div class="form-text fs--1 text-warning">* Separate your options with comma</div>
                </div>
            </div>
        </div>
        <button class="btn btn-falcon-default btn-sm mt-2" type="submit"><span class="fas fa-plus fs--2 me-1"
                data-fa-transform="up-1"></span>Add Item</button>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-300">
        <h5 class="mb-0">Fasilitas Order</h5>
    </div>
    <div class="card-body bg-light">
        @foreach ($layanan as $lay)
            <button class="btn btn-falcon-warning btn-sm me-2" type="button" id="button-order-layanan-dokter"
                data-code="{{$lay->t_layanan_cat_code}}" data-reg="{{$code}}"><span class="fab fa-squarespace"></span>
                {{ $lay->t_layanan_cat_name }}</button>
        @endforeach
        <hr />
        <div id="menu-order-layanan-dokter">

        </div>
    </div>

</div>
