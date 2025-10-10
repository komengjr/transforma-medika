<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Add Menu</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_menu_save') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="col-4">
            <label class="form-label" for="inputAddress">Menu</label>
            <select name="code" class="form-control" id="">
                <option value="">Pilih Menu</option>
                @foreach ($menu as $menus)
                    <option value="{{ $menus->menu_code }}">{{ $menus->menu_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label class="form-label" for="inputAddress">Menu Option</label>
            <select name="option" class="form-control" id="">
                <option value="">Pilih</option>
                <option value="single">Single</option>
                <option value="dropdown">Dropdown</option>
            </select>
        </div>
        <div class="col-4">
            <label class="form-label" for="inputAddress">Sub Menu</label>
            <input class="form-control" id="inputAddress" type="text" name="name" placeholder="dashboard"
                required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Menu Link</label>
            <input class="form-control" id="inputAddress" type="text" name="link" placeholder="page/detail"
                required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Menu Icon</label>
            <input class="form-control" id="inputAddress" type="text" name="icon" placeholder="fa fa-book"
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
