<div class="modal-body p-0">
    <!-- Modal Form Body -->
    <div class="p-4">
        <form class="row g-3" id="form-input-movie">
            @csrf

            <!-- Nama Movie -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Nama Movie</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-heading"></i></span>
                    <input type="text" name="title" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="Contoh: Interstellar" required>
                </div>
            </div>

            <!-- Genre Movie -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Genre Movie</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-tags"></i></span>
                    <input type="text" name="genre" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="Action, Sci-Fi, Drama">
                </div>
            </div>

            <!-- Link Poster -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Link Poster</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-image"></i></span>
                    <input type="url" name="poster" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://image-link.com/poster.jpg">
                </div>
            </div>

            <!-- Link Trailer -->
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary fs--1">Link Trailer</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fab fa-youtube"></i></span>
                    <input type="url" name="triler" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="https://youtube.com/watch?v=...">
                </div>
            </div>

            <!-- Type Link -->
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary fs--1">Type Link</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-link"></i></span>
                    <select name="type_link" class="form-select form-select-lg fs--1">
                        <option value="online">Online</option>
                        <option value="local">Local</option>
                    </select>
                </div>
            </div>

            <!-- Link Movie / Video -->
            <div class="col-md-8">
                <label class="form-label fw-semibold text-secondary fs--1">Link Movie (Video Source)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-video"></i></span>
                    <input type="text" name="video" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="URL HLS (.m3u8), MP4, atau Server Path">
                </div>
            </div>

            <!-- Release Date -->
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary fs--1">Release Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-calendar-alt"></i></span>
                    <input type="date" name="release_date" class="form-control form-control-lg fs--1 border-start-0 bg-white">
                </div>
            </div>

            <!-- Rating -->
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary fs--1">Rate Movie</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-star text-warning"></i></span>
                    <input type="text" name="rating" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="8.5 / 10">
                </div>
            </div>

            <!-- Subtitle -->
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary fs--1">Subtitle</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-closed-captioning"></i></span>
                    <input type="text" name="subtitle" class="form-control form-control-lg fs--1 border-start-0 bg-white" placeholder="Indo, Eng, Dual">
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="col-12">
                <label class="form-label fw-semibold text-secondary fs--1">Deskripsi Movie</label>
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
            <i class="fas fa-save me-1"></i> Simpan Data
        </button>
    </span>
</div>
