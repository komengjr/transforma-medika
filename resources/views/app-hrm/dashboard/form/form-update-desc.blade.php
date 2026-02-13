<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Event Brodcast</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">{{ ENV('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <form class="row" id="form-input-event">
            @csrf
            <div class="col-12">
                <label for="inputLastName1" class="form-label text-youtube">Descrpition</label>
                <div class="input-group"> <span class="input-group-text"><i
                            class="fas fa-money-check"></i></span>
                    <textarea name="desc" class="form-control" id="" rows="5"></textarea>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-event">
        <button class="btn btn-success float-end" id="button-simpan-data-event">Simpan
            Data</button>
    </span>
</div>
