<form class="row g-3 p-4" action="{{ route('master_access_mou_remove_akses_save') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="col-md-12">
        <label class="form-label" for="inputAddress">Hapus Akses ?</label>
        <input type="text" name="code" value="{{$code}}" id="" hidden>
    </div>

    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" id="gridCheck" type="checkbox" required />
            <label class="form-check-label" for="gridCheck">Check me</label>
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn-danger" type="submit"><span class="fas fa-trash"></span> Remove</button>
        <button class="btn btn-primary" type="button" data-bs-dismiss="modal"><span class="fas fa-close"></span> Close</button>
    </div>
</form>
