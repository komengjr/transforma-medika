<div class="modal-body p-0">
    <div class="p-4">
        <form class="row g-3" id="form-input-episode">
            @csrf
            <input type="hidden" name="movie_id" value="{{ $series->id }}">

            <!-- Info Series -->
            <div class="col-12">
                <div class="alert alert-secondary fs--1 mb-2 py-2">
                    <i class="fas fa-info-circle me-1"></i> Menambahkan episode untuk Series: <strong>{{ $series->title }}</strong>
                </div>
            </div>

            <!-- Season Number -->
            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary fs--1">Season</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-layer-group"></i></span>
                    <input type="number" name="season_number" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="1" min="1" value="1" required>
                </div>
            </div>

            <!-- Episode Number -->
            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary fs--1">Episode Ke-</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-list-ol"></i></span>
                    <input type="number" name="episode_number" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="1" min="1" required>
                </div>
            </div>

            <!-- Judul Episode -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Judul Episode</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-heading"></i></span>
                    <input type="text" name="title" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="Contoh: Chapter One" required>
                </div>
            </div>

            <!-- Tipe Link Video Episode -->
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary fs--1">Type Link Video</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-link"></i></span>
                    <select name="type_link" id="type-link-episode-select" class="form-select form-select-lg fs--1">
                        <option value="online">Online</option>
                        <option value="local">Local</option>
                    </select>
                </div>
            </div>

            <!-- Input Video Episode (Dinamis Online / Local) -->
            <div class="col-md-8">
                <label class="form-label fw-semibold text-secondary fs--1" id="label-episode-video">Link Video Episode (URL Online)</label>
                <div class="input-group" id="episode-video-container">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-video"></i></span>
                    <input type="text" name="video_url" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://domain.com/episode1.mp4" required>
                </div>
            </div>

            <!-- Progress Bar untuk Upload Chunk -->
            <div class="col-12 d-none" id="upload-progress-container">
                <label class="form-label fw-semibold text-secondary fs--1 mb-1">Progress Upload Video:</label>
                <div class="progress" style="height: 20px;">
                    <div id="upload-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success fs--1 fw-bold" role="progressbar" style="width: 0%;">0%</div>
                </div>
            </div>

            <!-- Deskripsi Episode -->
            <div class="col-12">
                <label class="form-label fw-semibold text-secondary fs--1">Deskripsi Episode</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-align-left"></i></span>
                    <textarea name="description" class="form-control fs--1" rows="3" placeholder="Sinopsis singkat episode ini..."></textarea>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Footer untuk Episode -->
<div class="modal-footer px-4 bg-light d-flex align-items-center justify-content-between">
    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Batal</button>
    <button class="btn btn-success rounded-pill px-4 btn-sm fw-semibold" id="button-simpan-episode">
        <i class="fas fa-save me-1"></i> Simpan Episode
    </button>
</div>

<!-- Script Interaktif Chunk Upload JavaScript -->
<script>
    $('#type-link-episode-select').on('change', function() {
        let linkType = $(this).val();
        let container = $('#episode-video-container');
        let labelText = $('#label-episode-video');

        if (linkType === 'local') {
            labelText.text('Upload File Video Episode (Local - Besar Didukung)');
            container.html(`
                <span class="input-group-text bg-light text-muted"><i class="fas fa-file-upload"></i></span>
                <input type="file" name="video" id="video-file-input" class="form-control form-control-lg fs--1 border-start-0 bg-white" accept="video/mp4,video/mkv,video/avi" required>
            `);
        } else {
            labelText.text('Link Video Episode (URL Online)');
            container.html(`
                <span class="input-group-text bg-light text-muted"><i class="fas fa-video"></i></span>
                <input type="text" name="video_url" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://domain.com/episode1.mp4" required>
            `);
        }
    });

    // Ganti fungsi klik simpan episode dengan kode berikut:
    $(document).off('click', '#button-simpan-episode').on('click', '#button-simpan-episode', function(e) {
        e.preventDefault();

        let typeLink = $('#type-link-episode-select').val();
        let btnSave = $(this);
        let formElement = $("#form-input-episode")[0];

        // Jika mode local dan ada file video yang diunggah, lakukan chunk upload kustom
        if (typeLink === 'local' && $('#video-file-input')[0] && $('#video-file-input')[0].files[0]) {
            let file = $('#video-file-input')[0].files[0];
            let chunkSize = 2 * 1024 * 1024; // 2 MB per chunk
            let totalChunks = Math.ceil(file.size / chunkSize);
            let currentChunk = 0;

            // Buat satu identifier unik (timestamp) di awal agar konsisten di setiap chunk
            let uploadId = Date.now();

            $('#upload-progress-container').removeClass('d-none');
            btnSave.html('<i class="fas fa-spinner fa-spin me-1"></i>Mengunggah...').prop('disabled', true);

            function uploadChunk() {
                let start = currentChunk * chunkSize;
                let end = Math.min(start + chunkSize, file.size);
                let chunk = file.slice(start, end);

                let chunkFormData = new FormData(formElement);
                chunkFormData.set('video', chunk, file.name);
                chunkFormData.append('dzchunkindex', currentChunk);
                chunkFormData.append('dztotalchunkcount', totalChunks);
                chunkFormData.append('upload_id', uploadId); // Kirim ID unik yang konsisten

                $.ajax({
                    url: "{{ route('master_data_movie_save_episode') }}",
                    type: "POST",
                    data: chunkFormData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                let percentComplete = Math.round(((currentChunk * chunkSize) + evt.loaded) / file.size * 100);
                                $('#upload-progress-bar').css('width', percentComplete + '%').text(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    }
                }).done(function(response) {
                    // Jika server merespons bahwa chunk masih dikumpulkan
                    if (response.chunk_uploaded) {
                        currentChunk++;
                        if (currentChunk < totalChunks) {
                            uploadChunk(); // Lanjut ke chunk berikutnya
                        }
                    } else {
                        // Selesai sepenuhnya (chunk terakhir & database sudah tersimpan)
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Episode berhasil ditambahkan!',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                }).fail(function(xhr) {
                    btnSave.html('<i class="fas fa-save me-1"></i>Simpan Episode').prop('disabled', false);
                    $('#upload-progress-container').addClass('d-none');
                    let errMsg = "Gagal mengunggah potongan video!";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errMsg
                    });
                });
            }

            uploadChunk(); // Mulai upload chunk pertama

        } else {
            // Mode online atau file kecil (tanpa chunk)
            btnSave.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
            let formData = new FormData(formElement);

            $.ajax({
                url: "{{ route('master_data_movie_save_episode') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }).fail(function(xhr) {
                btnSave.html('<i class="fas fa-save me-1"></i>Simpan Episode').prop('disabled', false);
                let errMsg = "Gagal menyimpan episode!";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: errMsg
                });
            });
        }
    });
</script>
