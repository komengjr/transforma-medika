<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Purchase Order</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0" id="menu-add-data-pr-all">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-input-pr-order">
                    @csrf
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Order Date</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="date" name="date" class="form-control form-control-lg border-start-0 bg-white" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">PPN</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select name="ppn" class="form-control form-control-lg">
                                <option value="">Pilih PPN</option>
                                <option value="1">Dengan PPN</option>
                                <option value="0">Tidak Dengan PPN</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Supplier</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select name="supplier" class="form-control form-control-lg" >
                                @foreach ($supp as $supps)
                                    <option value="{{ $supps->master_supplier_code }}">{{ $supps->master_supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Approval By</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <select name="app_by" class="form-control form-control-lg" id="">
                                <option value="">Pilih User</option>
                                @foreach ($user as $users)
                                    <option value="{{$users->hrm_m_pegawai_code }}">{{$users->hrm_m_pegawai_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">

            </div>
            <div class="col-12">

            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-pr-order">
        <button class="btn btn-success float-end" id="button-simpan-data-pr-order" data-code="">Simpan
            Data</button>
    </span>
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
</script>
<script src="{{ asset('asset/js/rupiah.js') }}"></script>
