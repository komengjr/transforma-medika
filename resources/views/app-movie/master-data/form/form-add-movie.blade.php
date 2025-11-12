<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add movie</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{env('APP_NAME')}}</a>
        </p>
    </div>
    <div class="p-4 pb-0" >
        <div class="row g-3">
            <div class="col-12">
                <form class="row" id="form-input-movie">
                    @csrf
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Nama Movie</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nama" class="form-control form-control-lg border-start-0 bg-white">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label text-youtube">Link Poster</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="poster" class="form-control form-control-lg border-start-0 bg-white" >
                        </div>
                    </div>
                     <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Type Link</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select name="type" class="form-control form-control-lg" id="">
                                <option value="online">Online</option>
                                <option value="local">Local</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="inputLastName1" class="form-label text-youtube">Link Movie</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="text" name="video"
                                class="form-control form-control-lg border-start-0 bg-white" id="nik">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Genre Movie</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="text" name="genre"
                                class="form-control form-control-lg border-start-0 bg-white" id="nik">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Release Movie</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" name="release_date"
                                class="form-control form-control-lg border-start-0 bg-white" id="nik">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Rate Movie</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="text" name="rating"
                                class="form-control form-control-lg border-start-0 bg-white" id="nik">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="inputLastName1" class="form-label text-youtube">Deskripsi</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-calendar-day"></i></span>
                           <textarea name="desc" class="form-control" rows="3" id=""></textarea>
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
    <span id="menu-add-data-movie">
        <button class="btn btn-success float-end" id="button-simpan-data-movie" data-code="">Simpan
            Data</button>
    </span>
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
</script>
<script src="{{ asset('asset/js/rupiah.js') }}"></script>
