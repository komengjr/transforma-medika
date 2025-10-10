<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Update Menu</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="card m-3 p-3 border border-primary">
        <form class="row g-3" action="{{ route('master_menu_update_save') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="col-6">
                <label class="form-label" for="inputAddress">Nama Menu</label>
                <input class="form-control" id="inputAddress" type="text" name="sub_menu"
                    value="{{ $menu->menu_sub_name }}" required />
            </div>
            <div class="col-6">
                <label class="form-label" for="inputAddress">Menu Link</label>
                <input class="form-control" id="inputAddress" type="text" name="link"
                    value="{{ $menu->menu_sub_link }}" required />
            </div>
            <div class="col-6">
                <label class="form-label" for="inputAddress">Menu Icon</label>
                <input class="form-control" id="inputAddress" type="text" name="icon" placeholder="fa fa-book"
                    value="{{ $menu->menu_sub_icon }}" required />
            </div>
            <div class="col-6">
                <label class="form-label" for="inputAddress">Menu Option</label>
                <select name="menu" class="form-control" id="">
                    @if ($menu->menu_sub_option == 'single')
                        <option value="single">Single</option>
                        <option value="dropdown">Dropdown</option>
                    @else
                        <option value="dropdown">Dropdown</option>
                        <option value="single">Single</option>
                    @endif
                </select>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" id="gridCheck" type="checkbox" required />
                    <label class="form-check-label" for="gridCheck">Check me</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary float-end btn-sm" type="submit"><span class="fas fa-save"></span>
                    Update</button>
            </div>
        </form>
    </div>
    @if ($menu->menu_sub_option == 'single')
    @else
        <div class="card m-3 border border-youtube">
            <div class="card-header bg-youtube d-flex flex-between-center py-2">
                <h5 class="mb-0"><span class="badge bg-youtube">Sub Menu</span></h5>
            </div>
            <form class="row g-3 p-3" action="{{ route('master_sub_menu_save') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="col-4">
                    <label class="form-label" for="inputAddress">Sub Menu</label>
                    <input class="form-control" id="inputAddress" type="text" name="name" placeholder="dashboard"
                        required />
                    <input class="form-control" id="inputAddress" type="text" name="code"
                        value="{{ $menu->menu_sub_code }}" hidden />
                </div>
                <div class="col-4">
                    <label class="form-label" for="inputAddress">Menu Link</label>
                    <input class="form-control" id="inputAddress" type="text" name="link"
                        placeholder="page/detail" required />
                </div>
                <div class="col-4">
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
                    <button class="btn btn-primary float-end btn-sm" type="submit"><span class="fas fa-save"></span>
                        Save</button>
                </div>
            </form>
        </div>
    @endif
</div>
