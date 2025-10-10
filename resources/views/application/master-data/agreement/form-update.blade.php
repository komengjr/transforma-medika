<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Update Agrement</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('agreement_perusahaan_update_save') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="col-12">
            <label class="form-label" for="inputAddress">Nama Agreement</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="nama"
                value="{{ $data->mou_agreement_name }}" required />
            <input type="text" name="code" value="{{ $data->mou_agreement_code }}" hidden>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-danger" type="submit" id="button-remove-agreement" data-code="{{$data->mou_agreement_code}}"><span class="fas fa-trash"></span> Remove</button>
            <button class="btn btn-primary float-end" type="submit"><span class="fas fa-save"></span> Save</button>
        </div>
    </form>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-company"));
    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
