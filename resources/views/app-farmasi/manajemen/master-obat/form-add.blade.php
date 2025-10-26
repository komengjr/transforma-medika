<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Add Obat</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
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
                            <select name="option" class="form-control form-control-lg" id="">
                                <option value=""></option>
                                <option value="0">Single</option>
                                <option value="1">Multi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Satuan Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="option" class="form-control form-control-lg" id="">
                                <option value=""></option>
                                <option value="0">Single</option>
                                <option value="1">Multi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Jenis Obat</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="option" class="form-control form-control-lg" id="">
                                <option value=""></option>
                                <option value="0">Single</option>
                                <option value="1">Multi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Stok Minimum</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white">
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
