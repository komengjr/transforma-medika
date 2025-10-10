<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Supplier</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-input-supplier">
                    @csrf
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Supplier Name</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Supplier City</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="city" class="form-control form-control-lg border-start-0 bg-white"
                                id="dengan-rupiah">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Supplier Phone</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="text" name="phone" class="form-control form-control-lg border-start-0 bg-white"
                                id="nik">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Supplier Mail</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="mail" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Supplier Type</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <select name="type" class="form-control form-control-lg" id="">
                                <option value="">Pilih Type</option>
                                <option value="H. Imam Sumardani">H. Imam Sumardani</option>
                                <option value="Drs. Zulkarnaen">Drs. Zulkarnaen</option>
                                <option value="Commercial Invoice">Dr. Andi Sugandi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Supplier Address</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <input type="text" name="alamat"
                                class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">

            </div>
            <div class="col-12">

            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-supplier">
        <button class="btn btn-success float-end" id="button-simpan-data-supplier" data-code="">Simpan
            Data</button>
    </span>
</div>
