<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Event Peserta</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3">
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-input-peserta">
                    @csrf
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Nama Peserta</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="name" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                        <input type="text" name="code_event" value="{{ $code }}" hidden>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Kode Booking</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="booking" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Nomor Hp Peserta</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="hp" class="form-control form-control-lg border-start-0 bg-white" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Email Peserta</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="email" class="form-control form-control-lg border-start-0 bg-white" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Lembaga Peserta</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="lembaga" class="form-control form-control-lg border-start-0 bg-white" >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="inputLastName1" class="form-label text-youtube">Deskripsi Peserta</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <textarea name="desc"  class="form-control form-control-lg"></textarea>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-peserta">
        <button class="btn btn-success float-end" id="button-simpan-data-peserta" >Simpan
            Peserta</button>
    </span>
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
</script>
<script src="{{ asset('asset/js/rupiah.js') }}"></script>
