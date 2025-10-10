<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Update Account</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-update-coa">
                    @csrf
                    <input type="text" name="code" id="" value="{{ $data->acc_coa_data_code }}" hidden>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Account Name</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white"
                                value="{{ $data->acc_coa_data_name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Optional Account</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <select name="option" class="form-control form-control-lg" id="">
                                @if ($data->acc_coa_data_opt == 0)
                                    <option value="0">Single</option>
                                    <option value="1">Multi</option>
                                @else
                                    <option value="1">Multi</option>
                                    <option value="0">Single</option>
                                @endif
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
        <button class="btn btn-success float-end" id="button-simpan-data-update-level-coa">Simpan
            Data</button>
    </span>
</div>
