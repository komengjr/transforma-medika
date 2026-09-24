<div class="modal-body p-0">
    <!-- Modal Form Body -->
    <div class="p-4">
        <form class="row g-3" id="form-input-movie">
            @csrf

            <!-- Pilihan Tipe Konten (Movie / Series) -->
            <div class="col-12">
                <label class="form-label fw-semibold text-secondary fs--1">Tipe Konten</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-layer-group"></i></span>
                    <select name="type" id="content-type-select" class="form-select form-select-lg fs--1 fw-bold text-primary">
                        <option value="movie">Movie (Film Lepas)</option>
                        <option value="series">Series (Serial TV / Ber-episode)</option>
                    </select>
                </div>
            </div>

            <!-- Nama Movie / Series -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1" id="label-title-text">Nama Movie</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-heading"></i></span>
                    <input type="text" name="title" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="Contoh: Interstellar / Stranger Things" required>
                </div>
            </div>

            <!-- Genre Movie -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Genre</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-tags"></i></span>
                    <input type="text" name="genre" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="Action, Sci-Fi, Drama">
                </div>
            </div>

            <!-- Link Poster -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Link Poster (Cover)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-image"></i></span>
                    <input type="url" name="poster" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://image-link.com/poster.jpg">
                </div>
            </div>

            <!-- Link Backdrop (Banner Hero Detail) -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Link Backdrop (Banner Besar)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-images"></i></span>
                    <input type="url" name="backdrop" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://image-link.com/backdrop.jpg">
                </div>
            </div>

            <!-- Link Trailer -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Link Trailer (YouTube)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fab fa-youtube"></i></span>
                    <input type="url" name="triler" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://youtube.com/watch?v=...">
                </div>
            </div>

            <!-- Release Date -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Release Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-calendar-alt"></i></span>
                    <input type="date" name="release_date" class="form-control form-control-lg fs--1 border-start-0 bg-white">
                </div>
            </div>

            <!-- Type Link (Hanya relevan jika Movie tunggal) -->
            <div class="col-md-4 movie-only-field">
                <label class="form-label fw-semibold text-secondary fs--1">Type Link Video</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-link"></i></span>
                    <select name="type_link" id="type-link-select" class="form-select form-select-lg fs--1">
                        <option value="online">Online</option>
                        <option value="local">Local</option>
                    </select>
                </div>
            </div>

            <!-- Link / File Movie / Video (Dinamis Berdasarkan Type Link) -->
            <div class="col-md-8 movie-only-field">
                <label class="form-label fw-semibold text-secondary fs--1" id="label-video-input">Link Movie (URL Online)</label>
                <div class="input-group" id="video-input-container">
                    <!-- Default awal berupa input URL (Online) -->
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-video"></i></span>
                    <input type="text" name="video" id="video-input-field" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://domain.com/video.mp4 atau embed link">
                </div>
            </div>

            <!-- Notif khusus series -->
            <div class="col-12 series-only-field d-none">
                <div class="alert alert-info fs--1 mb-0 py-2">
                    <i class="fas fa-info-circle me-1"></i> <strong>Catatan Series:</strong> Video per episode tidak diinput di sini, melainkan dapat ditambahkan melalui tombol <em>"Tambah Episode"</em> pada kartu series setelah data master ini disimpan.
                </div>
            </div>

            <!-- Rating -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Rate Movie</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-star text-warning"></i></span>
                    <input type="text" name="rating" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="8.5 / 10">
                </div>
            </div>

            <!-- Subtitle -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Subtitle / Kualitas Teks</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-closed-captioning"></i></span>
                    <input type="text" name="subtitle" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="Indo, Eng, Dual">
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="col-12">
                <label class="form-label fw-semibold text-secondary fs--1">Deskripsi / Sinopsis</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-align-left"></i></span>
                    <textarea name="description" class="form-control fs--1" rows="3" placeholder="Sinopsis atau ringkasan alur cerita..."></textarea>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Footer -->
<div class="modal-footer px-4 bg-light d-flex align-items-center justify-content-between">
    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Batal</button>
    <span id="menu-add-data-movie">
        <button class="btn btn-primary-gradient rounded-pill px-4 btn-sm fw-semibold" id="button-simpan-data-movie" data-code="">
            <i class="fas fa-save me-1"></i> Simpan Master Data
        </button>
    </span>
</div>

<!-- Script Toggle Interaktif Form -->
<script>
    // 1. Toggle antara Movie (Film Lepas) vs Series
    $('#content-type-select').on('change', function() {
        let val = $(this).val();
        if (val === 'series') {
            $('#label-title-text').text('Nama Series');
            $('.movie-only-field').addClass('d-none');
            $('.series-only-field').removeClass('d-none');
        } else {
            $('#label-title-text').text('Nama Movie');
            $('.movie-only-field').removeClass('d-none');
            $('.series-only-field').addClass('d-none');
        }
    });

    // 2. Toggle dinamis antara Input URL Online vs File Upload Local
    $('#type-link-select').on('change', function() {
        let linkType = $(this).val();
        let container = $('#video-input-container');
        let labelText = $('#label-video-input');

        if (linkType === 'local') {
            labelText.text('Upload File Video (Local)');
            container.html(`
                <span class="input-group-text bg-light text-muted"><i class="fas fa-file-upload"></i></span>
                <input type="file" name="video" id="video-input-field" class="form-control form-control-lg fs--1 border-start-0 bg-white" accept="video/mp4,video/mkv,video/avi" required>
            `);
        } else {
            labelText.text('Link Movie (URL Online)');
            container.html(`
                <span class="input-group-text bg-light text-muted"><i class="fas fa-video"></i></span>
                <input type="text" name="video" id="video-input-field" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://domain.com/video.mp4 atau embed link" required>
            `);
        }
    });
</script>
