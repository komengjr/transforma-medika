<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
    <div class="col-auto navbar-vertical-label">
        <h4><span class="badge bg-warning">POLIKLINIK</span></h4>
    </div>
    <div class="col ps-0">
        <hr class="mb-0 navbar-vertical-divider">
    </div>
</div>
<div class="row">
    @if ($cat->isEmpty())
        <div class="col-12 mb-2">
            <span class="badge bg-danger">Template Belum Ada</span>
        </div>
    @else
    @endif
    @foreach ($cat as $cats)
        <div class="col-md-4">
            <label for="inputLastName2" class="form-label text-info">{{ $cats->t_pasien_cat_data_name }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                @if ($cats->t_pasien_cat_data_type == 'text')
                    <input type="text" class="form-control form-control-lg border-start-0" id="data_penunjang">
                @elseif($cats->t_pasien_cat_data_type == 'file')
                    <input type="file" class="form-control form-control-lg border-start-0" id="upload-penunjang">
                @endif
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <div class="col-md-4">
        <label for="inputLastName2" class="form-label text-success">Tanggals</label>
        <div class="input-group"> <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            <input type="date" name="tanggal_periksa" id="tanggal_periksa"
                class="form-control form-control-lg border-start-0">
        </div>
    </div>
    <div class="col-md-4">
        <label for="inputLastName1" class="form-label text-success">Pilih Poli</label>
        <div class="input-group"> <span class="input-group-text"><i class="fas fa-city"></i></span>
            <select name="poli" id="poli" class="form-control form-control-lg single-select">
                <option value="">-</option>
                @foreach ($poli as $polis)
                    <option data-id="{{ $polis->t_layanan_data_code }}">{{ $polis->t_layanan_data_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<input id="link_penunjang" type="text" name="link_penunjang" class="form-control" hidden>

<div id="menu-pilihan-poliklinik"></div>

<script>
    $('#poli').on("change", function () {
        var dataid = $("#poli option:selected").attr('data-id');
        var tgl = document.getElementById("tanggal_periksa").value;
        if (dataid == null || tgl == '') {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Poli & Tanggal Sudah diisi'
            });
        } else {
            $.ajax({
                url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataid,
                },
                dataType: 'html',
            }).done(function (data) {
                $("#menu-pilihan-poliklinik").html(data);
            }).fail(function () {
                console.log('eror');
            });
        }
    });
    $('#tanggal_periksa').on("change", function () {
        $("#menu-pilihan-dokter-poli").html('');
    });
</script>
<script type="text/javascript">
    var browseFile = $('#upload-penunjang');
    var resumable = new Resumable({
        target: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_upload_file') }}",
        query: {
            _token: '{{ csrf_token() }}'
        }, // CSRF token
        fileType: ['jpg', 'png'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });
    resumable.assignBrowse(browseFile);
    resumable.on('fileAdded', function (file) { // trigger wn file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });
    resumable.on('fileProgress', function (file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });
    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        document.getElementById('upload-penunjang').style.display = 'none';
        $('#link_penunjang').attr('value', response.filename);
        $('.card-footer').show();
        $('#browseFile').hide();
    });
    resumable.on('fileError', function (file, response) { // trigger when there is any error
        alert('file uploading error.')
    });
    var progress = $('.progress');
    function showProgress() {
        progress.find('.loading').css('width', '0%');
        progress.find('.loading').html('0%');
        progress.find('.loading').removeClass('bg-info');
        progress.show();
    }
    function updateProgress(value) {
        progress.find('.loading').css('width', ` ${value}%`)
        progress.find('.loading').html(`${value}%`)
    }
    function hideProgress() {
        progress.hide();
    }
</script>
