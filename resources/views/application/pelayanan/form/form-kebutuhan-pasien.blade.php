<div class="card border mt-2 mb-0">
    <div class="row g-3 px-3 px-sm-4 py-3 pt-0 bg-200">
        <div class="col-md-4">
            <label for="inputLastName1" class="form-label text-primary">Nomor Registrasi</label>
            <div class="input-group"> <span class="input-group-text"><i class="fab fa-keycdn"></i></span>
                <input type="text" name="nama" class="form-control form-control-lg border-start-0 bg-white"
                    value="{{ $code }}" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <label for="inputEmailAddress" class="form-label text-primary">Pilih Kategori Pasien <small class="text-warning">Step 1</small></label>
            <div class="input-group"> <span class="input-group-text"><i class="fas fa-diagnoses"></i></span>
                <select name="kategori" id="kategori" class="form-control form-control-lg single-layanan">
                    <option value="">Pilih Kategori</option>
                    <option data-id="pribadi" value="pribadi">Pasien Pribadi</option>
                    <option data-id="asuransi" value="asuransi">Pasien Asuransi</option>
                    <option data-id="perusahaan" value="perusahaan">Pasien Perusahaan</option>

                </select>
            </div>
        </div>
        <div class="col-md-4">
            <label for="inputEmailAddress" class="form-label text-primary">Pilih Fasilitas Layanan <small class="text-warning">Step 2</small></label>
            <div class="input-group"> <span class="input-group-text"><i class="fas fa-pray"></i></span>
                <select name="layanan" id="layanan" class="form-control form-control-lg single-select">
                    <option value="">Pilih Layanan</option>
                    @foreach ($layanan as $lay)
                        <option data-id="{{ $lay->t_layanan_cat_code }}" value="{{ $lay->t_layanan_cat_code }}">{{ $lay->t_layanan_cat_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <span id="template-option-layanan"></span>
    </div>
</div>
<script>
    $('#layanan').on("change", function() {
        var dataid = $("#layanan option:selected").attr('data-id');
        var datacat = $("#kategori option:selected").attr('data-id');
        if (dataid == null || datacat == null) {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Kategori & Layanan Sudah dipilih'
            });
        } else {
            $.ajax({
                url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_layanan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataid,
                    "cat": datacat,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#template-option-layanan").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
