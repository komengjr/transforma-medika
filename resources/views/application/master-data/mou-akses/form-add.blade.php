<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Form Add User</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_access_mou_save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Nama Lengkap</label>
            <input class="form-control" id="inputAddress" type="text" name="nama_lengkap" placeholder="dashboard"
                required />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Email</label>
            <input class="form-control" id="inputAddress" type="text" name="email" placeholder="contoh@gmail.com"
                required />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">No Handphone</label>
            <input class="form-control" id="inputAddress" type="text" name="no_hp" placeholder="0812002920"
                required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Username</label>
            <input class="form-control" id="inputAddress" type="text" name="username" placeholder="jhondoe"
                required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Password</label>
            <input class="form-control" id="inputAddress" type="text" name="password" placeholder="dashboard"
                required />
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
        </div>
    </form>
</div>
