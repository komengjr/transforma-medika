<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Sub Event</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">{{env('APP_NAME')}}</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-input-sub-event">
                    @csrf
                    <input type="text" name="data_code" value="{{ $code }}" id="" hidden>
                    <div class="col-md-12">
                        <label for="inputLastName1" class="form-label text-youtube">Sub Event Name</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Sub Event Start</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="date" name="start" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Sub Event End</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="date" name="end" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-sub-event">
        <button class="btn btn-success float-end" id="button-simpan-data-sub-event">Simpan
            Data</button>
    </span>
</div>

