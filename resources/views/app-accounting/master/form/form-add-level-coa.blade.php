<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Add Account</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-input-coa">
                    @csrf
                    <input type="text" name="level" id="" value="{{ $level }}" hidden>
                    <input type="text" name="code" id="" value="{{ $code }}" hidden>
                    <input type="text" name="nomor" id="" value="{{ $nomor }}" hidden>
                    <h5><span class="badge bg-primary">Nomor : {{ $nomor }}</span></h5>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Account Name</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Optional Account</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="option" class="form-control form-control-lg" id="">
                                <option value=""></option>
                                <option value="0">Single</option>
                                <option value="1">Multi</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-coa">
        <button class="btn btn-success float-end" id="button-simpan-data-level-coa" >Simpan
            Data</button>
    </span>
</div>
