<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Add Doctor</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="text-warning fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_doctor_poliklinik_save') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <label class="form-label" for="inputAddress">Nama Poliklinik</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="name"
                placeholder="contoh@gmail.com" required />
        </div>

        <div class="col-md-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
        </div>
    </form>
</div>
