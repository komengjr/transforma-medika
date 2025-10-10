<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Purchase Request</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0" id="menu-add-data-pr-all">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-input-pr">
                    @csrf
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Request Name</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nama" class="form-control form-control-lg border-start-0 bg-white" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Request Date</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="date" name="date" class="form-control form-control-lg border-start-0 bg-white"
                                id="dengan-rupiah">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Request Date Require</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" name="date_req" class="form-control form-control-lg border-start-0 bg-white"
                                id="nik">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Request By</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select name="req_by" class="form-control form-control-lg" id="">
                                @foreach ($user as $users)
                                    <option value="{{ $users->hrm_m_pegawai_code }}">{{ $users->hrm_m_pegawai_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Approval By</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <select name="app_by" class="form-control form-control-lg" id="">
                                <option value="">Pilih Type</option>
                                <option value="H. Imam Sumardani">H. Imam Sumardani</option>
                                <option value="Drs. Zulkarnaen">Drs. Zulkarnaen</option>
                                <option value="Commercial Invoice">Dr. Andi Sugandi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Deskripsi</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                            <input type="text" name="tgl_lahir"
                                class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir" value="">
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
    <span id="menu-add-data-pr">
        <button class="btn btn-success float-end" id="button-simpan-data-pr" data-code="">Simpan
            Data</button>
    </span>
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
</script>
<script src="{{ asset('asset/js/rupiah.js') }}"></script>
