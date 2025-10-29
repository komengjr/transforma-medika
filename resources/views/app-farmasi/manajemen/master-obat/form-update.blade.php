<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Update Data Obat</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-update-obat">
                    @csrf
                    <input type="text" name="code" id="" value="{{ $data->farm_data_obat_code }}" hidden>
                    <div class="col-md-7">
                        <label for="inputLastName1" class="form-label text-youtube">Nama Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white"
                                value="{{ $data->farm_data_obat_name }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="inputLastName1" class="form-label text-youtube">Kategori Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="kategori" class="form-control form-control-lg" id="">
                                <option value="{{ $data->farm_data_obat_cat }}">{{ $data->farm_data_obat_cat }}</option>
                                <option value="tablet">Tablet / Kaplet / Kapsul</option>
                                <option value="sirup">Sirup / Suspensi</option>
                                <option value="Injeksi">Injeksi</option>
                                <option value="salep">Salep / Krim / Gel</option>
                                <option value="tetes">Tetes (mata, telinga, hidung)</option>
                                <option value="Suppositoria">Suppositoria</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Satuan Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="satuan" class="form-control form-control-lg" id="">
                                <option value="{{ $data->farm_data_obat_satuan }}">{{ $data->farm_data_obat_satuan }}
                                </option>
                                <option value="strip">Strip / Blister</option>
                                <option value="box">Box / Kotak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Jenis Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="jenis" class="form-control form-control-lg" id="">
                                <option value="{{ $data->farm_data_obat_jenis }}">{{ $data->farm_data_obat_jenis }}
                                </option>
                                <option value="Obat Analgesik">Obat Analgesik</option>
                                <option value="Obat Antipiretik">Obat Antipiretik</option>
                                <option value="Obat Antibiotik">Obat Antibiotik</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Stok Minimum</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="stok_min"
                                class="form-control form-control-lg border-start-0 bg-white"
                                value="{{ $data->farm_data_obat_stok_minimum }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-obat">
        <button class="btn btn-success float-end" id="button-save-update-data-obat">Update
            Data</button>
    </span>
</div>
