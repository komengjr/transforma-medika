<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $series->title }} - Daftar Episode</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .series-hero {
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.95)),
            url('{{ $series->backdrop ?? $series->poster }}');
            background-size: cover;
            background-position: center;
            border-radius: 12px;
            padding: 40px;
        }

        .episode-card {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .episode-card:hover {
            background: #334155;
            border-color: #e11d48;
        }

        .episode-thumb {
            width: 120px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
            background: #0f172a;
        }
    </style>
</head>

<body class="py-4">

    <div class="container" style="max-width: 1100px;">
        <!-- Breadcrumb / Tutup Halaman -->
        <div class="mb-3">
            <a href="javascript:window.close();" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
                <i class="fas fa-arrow-left me-1"></i> Tutup Halaman
            </a>
        </div>

        <!-- Banner Series Info -->
        <div class="series-hero mb-4 shadow-lg">
            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <img src="{{ $series->poster }}" class="img-fluid rounded shadow" style="max-height: 280px;" alt="{{ $series->title }}" onerror="this.src='https://via.placeholder.com/300x450?text=No+Poster'">
                </div>
                <div class="col-md-9">
                    <span class="badge bg-primary mb-2"><i class="fas fa-tv me-1"></i> TV SERIES</span>
                    <h1 class="fw-bold text-white mb-2 fs-2">{{ $series->title }}</h1>
                    <div class="d-flex flex-wrap gap-2 text-white-50 mb-3" style="font-size: 0.85rem;">
                        <span><i class="fas fa-star text-warning me-1"></i> {{ $series->rating ?? '8.0' }}</span>
                        <span>•</span>
                        <span><i class="fas fa-calendar me-1"></i> {{ !empty($series->release_date) ? date('Y', strtotime($series->release_date)) : '-' }}</span>
                        <span>•</span>
                        <span><i class="fas fa-film me-1"></i> {{ $series->genre }}</span>
                    </div>
                    <p class="text-white-50 mb-0" style="font-size: 0.9rem; line-height: 1.6;">{{ $series->description }}</p>
                </div>
            </div>
        </div>

        <!-- Daftar Episode Header & Tombol Tambah Episode -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-bold text-white border-start border-danger border-4 ps-2 mb-0">Daftar Episode</h4>
            <button type="button" class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modal-add-episode" style="font-size: 0.85rem;">
                <i class="fas fa-plus-circle me-1"></i> Tambah Episode Baru
            </button>
        </div>

        <!-- Daftar Episode List -->
        <div class="row">
            @forelse($episodes as $ep)
            <div class="col-12 mb-2">
                <div class="episode-card p-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <!-- Thumbnail Episode (Jika ada, fallback ke Badge Season/Episode) -->
                        <div class="position-relative">
                            @if(!empty($ep->thumbnail))
                            <img src="{{ $ep->thumbnail }}" class="episode-thumb" alt="Ep Thumbnail" onerror="this.src='https://via.placeholder.com/120x70?text=Ep+{{ $ep->episode_number }}'">
                            @else
                            <div class="bg-dark text-white fw-bold rounded d-flex flex-column align-items-center justify-content-center episode-thumb" style="font-size: 0.75rem;">
                                <i class="fas fa-play-circle text-danger mb-1 fs-5"></i>
                                <span>S{{ $ep->season_number ?? 1 }} E{{ $ep->episode_number ?? 1 }}</span>
                            </div>
                            @endif
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-danger text-white fs--2 px-2 py-1">S{{ $ep->season_number ?? 1 }} - E{{ $ep->episode_number ?? 1 }}</span>
                                <h6 class="fw-bold text-white mb-0" style="font-size: 0.95rem;">{{ $ep->title }}</h6>
                            </div>
                            <p class="text-muted mb-0 text-truncate" style="max-width: 550px; font-size: 0.8rem;">{{ $ep->description ?? 'Tidak ada deskripsi episode.' }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url('/watch/stream/' . ($ep->slug ?? $ep->id)) }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3" style="font-size: 0.8rem;">
                            <i class="fas fa-play me-1"></i> Putar
                        </a>
                        <!-- Dropdown Opsi Edit/Hapus Episode -->
                        <div class="dropdown">
                            <button class="btn btn-sm btn-dark text-muted rounded-circle px-2 py-1" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v fs--1"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 bg-dark text-light">
                                <li><a class="dropdown-item text-light fs--1" href="#"><i class="fas fa-edit text-warning me-2"></i> Edit Episode</a></li>
                                <li><a class="dropdown-item text-danger fs--1" href="#"><i class="fas fa-trash me-2"></i> Hapus Episode</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-film-slash text-muted fa-3x mb-2"></i>
                <div class="fw-bold text-secondary fs-5">Belum Ada Episode</div>
                <p class="text-muted" style="font-size: 0.85rem;">Belum ada episode yang ditambahkan untuk series ini. Silakan klik tombol "Tambah Episode Baru" di atas.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Form Tambah Episode -->
    <div class="modal fade" id="modal-add-episode" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white border-0 shadow-lg rounded-3">
                <div class="modal-header border-0 py-2 px-3 bg-black">
                    <div class="modal-title fw-bold fs-5 text-white">
                        <i class="fas fa-plus-circle text-success me-2"></i>Tambah Episode: {{ $series->title }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-p p-4">
                    <form action="#" method="POST" id="form-input-episode">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $series->id }}">

                        <div class="row g-3">
                            <!-- Season & Episode Number -->
                            <div class="col-md-6">
                                <label class="form-label text-white-50 fs--1">Season Number</label>
                                <input type="number" name="season_number" class="form-control bg-secondary text-white border-0 fs--1" value="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white-50 fs--1">Episode Number</label>
                                <input type="number" name="episode_number" class="form-control bg-secondary text-white border-0 fs--1" placeholder="Contoh: 1" required>
                            </div>

                            <!-- Judul Episode -->
                            <div class="col-12">
                                <label class="form-label text-white-50 fs--1">Judul Episode</label>
                                <input type="text" name="title" class="form-control bg-secondary text-white border-0 fs--1" placeholder="Contoh: Chapter 1: The Vanishing" required>
                            </div>

                            <!-- Link Video Episode -->
                            <div class="col-12">
                                <label class="form-label text-white-50 fs--1">Link Video / Stream Source (URL .m3u8 / MP4)</label>
                                <input type="text" name="video" class="form-control bg-secondary text-white border-0 fs--1" placeholder="https://server.com/stream/episode1.m3u8" required>
                            </div>

                            <!-- Thumbnail Episode -->
                            <div class="col-12">
                                <label class="form-label text-white-50 fs--1">Thumbnail Episode (Opsional)</label>
                                <input type="url" name="thumbnail" class="form-control bg-secondary text-white border-0 fs--1" placeholder="https://image-link.com/thumbnail.jpg">
                            </div>

                            <!-- Deskripsi Episode -->
                            <div class="col-12">
                                <label class="form-label text-white-50 fs--1">Deskripsi Singkat Episode</label>
                                <textarea name="description" class="form-control bg-secondary text-white border-0 fs--1" rows="3" placeholder="Sinopsis singkat episode ini..."></textarea>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-outline-light rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-pill px-4 btn-sm fw-semibold">
                                <i class="fas fa-save me-1"></i> Simpan Episode
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
