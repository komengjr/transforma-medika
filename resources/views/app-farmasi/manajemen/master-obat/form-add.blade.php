<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Add Obat</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    @php
        $jenis = DB::table('farm_data_jenis')->get();
        $satuan = DB::table('farm_data_satuan')->get();
    @endphp
    <div class="p-4 pb-3">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-input-obat">
                    @csrf

                    <div class="col-md-7">
                        <label for="inputLastName1" class="form-label text-youtube">Nama Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="inputLastName1" class="form-label text-youtube">Kategori Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="kategori" class="form-control form-control-lg" id="">
                                <option value=""></option>
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
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuan as $sa)
                                    <option value="{{$sa->farm_data_satuan_code}}">{{$sa->farm_data_satuan_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Jenis Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="jenis" class="form-control form-control-lg" id="">
                                <option value=""><small>Pilih Jenis</small></option>
                                @foreach ($jenis as $je)
                                    <option value="{{$je->farm_data_jenis_code}}">{{$je->farm_data_jenis_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Stok Minimum</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="number" name="stok_min"
                                class="form-control form-control-lg border-start-0 bg-white" value="0">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-obat">
        <button class="btn btn-success float-end" id="button-simpan-data-obat">Simpan
            Data</button>
    </span>
</div>
