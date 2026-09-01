@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Modern Cinema Style */
    .cinema-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    /* Movie Card Design */
    .movie-card {
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    .movie-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.18);
    }

    .poster-wrapper {
        position: relative;
        padding-top: 145%;
        /* Aspect Ratio 2:3 */
        overflow: hidden;
        background: #0f172a;
    }

    .poster-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .movie-card:hover .poster-wrapper img {
        transform: scale(1.06);
    }

    /* Poster Overlay & Action Buttons */
    .poster-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.4) 60%, transparent 100%);
        opacity: 0;
        transition: opacity 0.25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .movie-card:hover .poster-overlay {
        opacity: 1;
    }

    .btn-action-overlay {
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        transform: scale(0.9);
        transition: transform 0.2s ease, background-color 0.2s ease;
        border: none;
        width: 80%;
        justify-content: center;
    }

    .movie-card:hover .btn-action-overlay {
        transform: scale(1);
    }

    .btn-play-video {
        background: #e11d48;
        color: #fff;
        box-shadow: 0 0 12px rgba(225, 29, 72, 0.5);
    }

    .btn-play-video:hover {
        background: #be123c;
        color: #fff;
    }

    .btn-play-trailer {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .btn-play-trailer:hover {
        background: #f59e0b;
        color: #fff;
        border-color: #f59e0b;
    }

    /* Badges */
    .badge-type {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(4px);
        color: #06b6d4;
        border: 1px solid rgba(6, 182, 212, 0.3);
        font-weight: 600;
        padding: 3px 6px;
        border-radius: 4px;
        z-index: 2;
    }

    .badge-hd {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #e11d48;
        color: #fff;
        font-weight: 700;
        padding: 2px 5px;
        border-radius: 3px;
        z-index: 2;
    }

    .movie-title {
        font-weight: 700;
        color: #1e293b;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Filter Tab Styles */
    .genre-badge-tab {
        cursor: pointer;
        padding: 5px 14px;
        border-radius: 20px;
        background: #f1f5f9;
        color: #64748b;
        font-weight: 600;
        transition: all 0.2s ease;
        user-select: none;
        white-space: nowrap;
    }

    .genre-badge-tab.active,
    .genre-badge-tab:hover {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
    }

    .search-box input {
        border-radius: 20px;
        padding-left: 38px;
        border: 1px solid #e2e8f0;
    }

    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
</style>
@endsection

@section('content')
<!-- Banner Header Studio Cinema -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card cinema-hero text-white p-3 border-0">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge bg-danger mb-2 px-2 py-1 fs--2 rounded-pill">
                        <i class="fas fa-fire me-1"></i> MOVIE MANAGEMENT STUDIO
                    </span>
                    <div class="fw-bold fs-2 text-white mb-1">Layar XXI Catalog</div>
                    <p class="text-white-50 fs-0 mb-3">Kelola koleksi film bioskop, tautan streaming, dan genre secara real-time.</p>
                    <button class="btn btn-primary btn-sm rounded-pill px-3 py-1 fs--1" id="button-add-movie" data-bs-toggle="modal" data-bs-target="#modal-pr-xl">
                        <i class="fas fa-plus-circle me-1"></i>Tambah Film Baru
                    </button>
                </div>
                <div class="col-md-4 d-none d-md-block text-end">
                    <i class="fas fa-film text-white opacity-10" style="font-size: 3.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar & Search Section -->
<div class="row g-2 align-items-center mb-3">
    <!-- Search Field -->
    <div class="col-lg-4 col-md-6">
        <div class="search-box position-relative">
            <i class="fas fa-search fs--1"></i>
            <input type="text" id="search-movie" class="form-control form-control-sm fs--1" placeholder="Cari judul film...">
        </div>
    </div>

    <!-- Sort Select -->
    <div class="col-lg-2 col-md-6 ms-auto">
        <select id="sort-movie" class="form-select form-select-sm fs--1 rounded-pill">
            <option value="newest">Terbaru</option>
            <option value="title-asc">Judul (A-Z)</option>
            <option value="title-desc">Judul (Z-A)</option>
        </select>
    </div>

    <!-- Genre Quick Tabs -->
    <div class="col-12">
        <div class="d-flex align-items-center gap-2 overflow-auto py-1" id="genre-tabs">
            <span class="genre-badge-tab active fs--1" data-genre="all"><i class="fas fa-border-all me-1"></i> Semua Genre</span>
            <span class="genre-badge-tab fs--1" data-genre="Action">Action</span>
            <span class="genre-badge-tab fs--1" data-genre="Comedy">Comedy</span>
            <span class="genre-badge-tab fs--1" data-genre="Drama">Drama</span>
            <span class="genre-badge-tab fs--1" data-genre="Horror">Horror</span>
            <span class="genre-badge-tab fs--1" data-genre="Sci-Fi">Sci-Fi</span>
            <span class="genre-badge-tab fs--1" data-genre="Romance">Romance</span>
            <span class="genre-badge-tab fs--1" data-genre="Animation">Animation</span>
        </div>
    </div>
</div>

<!-- Grid Film (Card Layout) -->
<div class="row g-2 g-md-3" id="movie-grid-container">
    @foreach ($data as $datas)
    <div class="col-6 col-md-4 col-lg-3 col-xl-2 movie-item"
        data-title="{{ strtolower($datas->title) }}"
        data-genre="{{ $datas->genre }}">

        <div class="movie-card">
            <!-- Badges -->
            <span class="badge-type fs--2"><i class="fas fa-link me-1"></i>{{ $datas->type_link ?? 'online' }}</span>
            <span class="badge-hd fs--2">{{ $datas->subtitle ?? 'SUB INDO' }}</span>

            <!-- Poster Container -->
            <div class="poster-wrapper">
                <img src="{{ $datas->poster }}" alt="{{ $datas->title }}" onerror="this.src='https://via.placeholder.com/300x450?text=No+Poster'">

                <!-- Hover Overlay dengan 2 Tombol (Watch & Trailer) -->
                <div class="poster-overlay">
                    @if(!empty($datas->video))
                    <button class="btn-action-overlay btn-play-video btn-watch-video fs--2"
                        data-video="{{ $datas->video }}"
                        data-title="Tonton: {{ $datas->title }}">
                        <i class="fas fa-play"></i> Tonton Film
                    </button>
                    @endif

                    @if(!empty($datas->triler))
                    <button class="btn-action-overlay btn-play-trailer btn-watch-video fs--2"
                        data-video="{{ $datas->triler }}"
                        data-title="Trailer: {{ $datas->title }}">
                        <i class="fas fa-film"></i> Lihat Trailer
                    </button>
                    @endif
                </div>
            </div>

            <!-- Card Body / Detail -->
            <div class="p-2">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-primary fw-semibold fs--2 text-truncate" style="max-width: 65%;">{{ $datas->genre ?? 'General' }}</span>
                    <span class="text-warning fs--2 fw-bold"><i class="fas fa-star me-1"></i>{{ $datas->rating ?? '0.0' }}</span>
                </div>
                <div class="movie-title fs-0 mb-1" title="{{ $datas->title }}">{{ $datas->title }}</div>

                <p class="text-muted fs--2 text-truncate mb-2">
                    {{ $datas->description ?? 'Tidak ada deskripsi.' }}
                </p>

                <!-- Action Controls Footer -->
                <div class="d-flex align-items-center justify-content-between pt-1 border-top">
                    @if(!empty($datas->triler))
                    <button class="btn btn-xs btn-outline-warning rounded-pill px-2 py-0 fs--2 btn-watch-video"
                        data-video="{{ $datas->triler }}"
                        data-title="Trailer: {{ $datas->title }}">
                        <i class="fas fa-video me-1"></i> Trailer
                    </button>
                    @else
                    <span class="text-muted fs--2"><i class="fas fa-calendar-alt me-1"></i>{{ !empty($datas->release_date) ? date('Y', strtotime($datas->release_date)) : '-' }}</span>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-sm btn-light rounded-circle px-2 py-0" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v text-muted fs--2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            @if(!empty($datas->video))
                            <li>
                                <a class="dropdown-item fs--1 btn-watch-video" href="javascript:void(0)"
                                    data-video="{{ $datas->video }}"
                                    data-title="Tonton: {{ $datas->title }}">
                                    <i class="fas fa-play text-danger me-2"></i> Tonton Film
                                </a>
                            </li>
                            @endif
                            <li><a class="dropdown-item fs--1" href="#"><i class="fas fa-edit text-warning me-2"></i> Edit Data</a></li>
                            <li><a class="dropdown-item fs--1 text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus Film</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endforeach
</div>

<!-- Empty State Searching -->
<div id="no-results" class="text-center py-4 d-none">
    <i class="fas fa-film-slash text-muted fa-2x mb-2"></i>
    <div class="fw-bold text-secondary fs-1">Film Tidak Ditemukan</div>
    <p class="text-muted fs--1">Coba ubah kata kunci pencarian atau filter genre Anda.</p>
</div>
@endsection

@section('base.js')
<!-- Modal Dynamic Form -->
<div class="modal fade" id="modal-pr-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-dark text-white border-0 py-2 px-3">
                <div class="modal-title text-white fw-bold fs-1">
                    <i class="fas fa-film text-danger me-2"></i>Form Master Movie
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="p-0" id="menu-pr-xl"></div>
        </div>
    </div>
</div>

<!-- Modal Watch Video / Trailer -->
<div class="modal fade" id="modal-watch-video" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-0 rounded-3 overflow-hidden shadow-lg">
            <div class="modal-header border-0 text-white py-2 px-3 bg-black">
                <div class="modal-title text-white fw-bold fs-1" id="watch-movie-title">Stream Player</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="video-iframe" src="" allowfullscreen class="border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts & Filters JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        let selectedGenre = 'all';

        // Helper untuk mengubah URL YouTube standar ke format Embed Iframe
        function getEmbedUrl(url) {
            if (!url) return '';

            // Format YouTube Watch (youtube.com/watch?v=XXXX)
            if (url.includes('youtube.com/watch?v=')) {
                let videoId = url.split('v=')[1].split('&')[0];
                return 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            }
            // Format YouTube Short (youtu.be/XXXX)
            if (url.includes('youtu.be/')) {
                let videoId = url.split('youtu.be/')[1].split('?')[0];
                return 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            }

            return url;
        }

        // 1. Filter dengan Quick Tab Genre
        $('.genre-badge-tab').on('click', function() {
            $('.genre-badge-tab').removeClass('active');
            $(this).addClass('active');
            selectedGenre = $(this).data('genre');
            filterMovies();
        });

        // 2. Realtime Search Input
        $('#search-movie').on('keyup', function() {
            filterMovies();
        });

        function filterMovies() {
            let searchValue = $('#search-movie').val().toLowerCase().trim();
            let visibleCount = 0;

            $('.movie-item').each(function() {
                let title = $(this).data('title');
                let genre = $(this).data('genre');

                let matchesGenre = (selectedGenre === 'all') || (genre === selectedGenre);
                let matchesSearch = title.includes(searchValue);

                if (matchesGenre && matchesSearch) {
                    $(this).fadeIn(200);
                    visibleCount++;
                } else {
                    $(this).fadeOut(200);
                }
            });

            if (visibleCount === 0) {
                $('#no-results').removeClass('d-none');
            } else {
                $('#no-results').addClass('d-none');
            }
        }

        // 3. Play Video / Trailer Handler
        $(document).on('click', '.btn-watch-video', function(e) {
            e.preventDefault();
            let rawUrl = $(this).data('video');
            let modalTitle = $(this).data('title');

            if (!rawUrl) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Link Tidak Tersedia',
                    text: 'Tautan video/trailer belum diinputkan.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            let embedUrl = getEmbedUrl(rawUrl);

            $('#watch-movie-title').text(modalTitle);
            $('#video-iframe').attr('src', embedUrl);
            $('#modal-watch-video').modal('show');
        });

        // Hentikan pemutaran video saat modal ditutup
        $('#modal-watch-video').on('hidden.bs.modal', function() {
            $('#video-iframe').attr('src', '');
        });

        // 4. AJAX Load Form Add Movie
        $(document).on("click", "#button-add-movie", function(e) {
            e.preventDefault();
            $('#menu-pr-xl').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-danger" style="width: 2rem; height: 2rem;" role="status"></div>
                    <p class="mt-2 text-muted fs--1 fw-bold">Memuat Form Movie...</p>
                </div>
            `);
            $.ajax({
                url: "{{ route('master_data_movie_add') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": 0
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-pr-xl').html(data);
            }).fail(function() {
                $('#menu-pr-xl').html(`
                    <div class="alert alert-danger fs--1 text-center m-3">Gagal memuat form. Silahkan coba lagi.</div>
                `);
            });
        });

        // 5. Save Data Movie AJAX
        $(document).on("click", "#button-simpan-data-movie", function(e) {
            e.preventDefault();
            var formData = new FormData($("#form-input-movie")[0]);

            let btnSave = $(this);
            btnSave.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);

            $.ajax({
                url: "{{ route('master_data_movie_save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Film baru berhasil ditambahkan!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }).fail(function() {
                btnSave.html('<i class="fas fa-save me-1"></i>Simpan Data').prop('disabled', false);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Gagal menyimpan, cek kembali isian form Anda!",
                });
            });
        });
    });
</script>
@endsection
