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
        gap: 6px;
        padding: 10px;
    }

    .movie-card:hover .poster-overlay {
        opacity: 1;
    }

    .btn-action-overlay {
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        transform: scale(0.9);
        transition: transform 0.2s ease, background-color 0.2s ease;
        border: none;
        width: 100%;
        justify-content: center;
        text-decoration: none;
        text-align: center;
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

    .btn-series-episodes {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 0 12px rgba(37, 99, 235, 0.5);
    }

    .btn-series-episodes:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .btn-add-episode {
        background: #059669;
        color: #fff;
        box-shadow: 0 0 12px rgba(5, 150, 105, 0.5);
    }

    .btn-add-episode:hover {
        background: #047857;
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
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #06b6d4;
        border: 1px solid rgba(6, 182, 212, 0.3);
        font-weight: 600;
        padding: 3px 8px;
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
        padding: 2px 6px;
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

    /* Category Main Tabs (Movie vs Series) */
    .category-tab {
        cursor: pointer;
        padding: 8px 20px;
        border-radius: 8px;
        background: #1e293b;
        color: #94a3b8;
        font-weight: 600;
        transition: all 0.2s ease;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .category-tab.active,
    .category-tab:hover {
        background: #e11d48;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3);
    }

    /* Genre Quick Tabs */
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
                        <i class="fas fa-fire me-1"></i> STREAMING & CATALOG MANAGEMENT
                    </span>
                    <div class="fw-bold fs-2 text-white mb-1">Studio Master Movie & Series</div>
                    <p class="text-white-50 fs-0 mb-3">Kelola koleksi film lepas (Movie) dan serial televisi (Series) secara terpusat.</p>
                    <button class="btn btn-primary btn-sm rounded-pill px-3 py-1 fs--1" id="button-add-movie" data-bs-toggle="modal" data-bs-target="#modal-pr-xl">
                        <i class="fas fa-plus-circle me-1"></i>Tambah Data Baru
                    </button>
                </div>
                <div class="col-md-4 d-none d-md-block text-end">
                    <i class="fas fa-film text-white opacity-10" style="font-size: 3.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Main Switcher Tabs (Semua / Movie / Series) -->
<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex gap-2">
            <div class="category-tab active fs--1" data-category="all">
                <i class="fas fa-layer-group me-1"></i> Semua Kategori
            </div>
            <div class="category-tab fs--1" data-category="movie">
                <i class="fas fa-video me-1"></i> Movie (Film)
            </div>
            <div class="category-tab fs--1" data-category="series">
                <i class="fas fa-tv me-1"></i> Series (Serial)
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
            <input type="text" id="search-movie" class="form-control form-control-sm fs--1" placeholder="Cari judul film / series...">
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
    @foreach ($data as$datas)
    @php
    $contentType = strtolower($datas->type ?? 'movie');
    @endphp
    <div class="col-6 col-md-4 col-lg-3 col-xl-2 movie-item"
        data-title="{{ strtolower($datas->title) }}"
        data-genre="{{ $datas->genre }}"
        data-category="{{ $contentType }}">

        <div class="movie-card">
            <!-- Badges -->
            <span class="badge-type fs--2">
                <i class="fas {{ $contentType == 'series' ? 'fa-tv' : 'fa-film' }} me-1"></i>
                {{ strtoupper($contentType) }}
            </span>
            <span class="badge-hd fs--2">{{ $datas->subtitle ?? 'SUB INDO' }}</span>

            <!-- Poster Container -->
            <div class="poster-wrapper">
                <img src="{{ $datas->poster }}" alt="{{ $datas->title }}" onerror="this.src='https://via.placeholder.com/300x450?text=No+Poster'">

                <!-- Hover Overlay dengan Tombol Aksi Dinamis -->
                <div class="poster-overlay">
                    @if($contentType == 'series')
                    {{-- Opsi untuk Series: Pilih Episode atau Tambah Episode baru --}}
                    <a href="{{ url('/watch/series/' . ($datas->slug ?? $datas->id)) }}" target="_blank" class="btn-action-overlay btn-series-episodes fs--2">
                        <i class="fas fa-list-ul"></i> Lihat Episode
                    </a>
                    <button type="button" class="btn-action-overlay btn-add-episode fs--2 button-add-episode-item" data-id="{{ $datas->id }}" data-title="{{ $datas->title }}" data-bs-toggle="modal" data-bs-target="#modal-pr-xl">
                        <i class="fas fa-plus-circle"></i> Tambah Episode
                    </button>
                    @else
                    {{-- Opsi untuk Movie biasa: Langsung tonton --}}
                    <a href="{{ url('/watch/stream/' . ($datas->slug ?? $datas->id)) }}" target="_blank" class="btn-action-overlay btn-play-video fs--2">
                        <i class="fas fa-play"></i> Tonton Film
                    </a>
                    @endif

                    @if(!empty($datas->triler))
                    <button class="btn-action-overlay btn-play-trailer btn-watch-trailer fs--2"
                        data-video="{{ $datas->triler }}"
                        data-title="Trailer: {{ $datas->title }}">
                        <i class="fas fa-film"></i> Trailer
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
                    <span class="text-muted fs--2"><i class="fas fa-calendar-alt me-1"></i>{{ !empty($datas->release_date) ? date('Y', strtotime($datas->release_date)) : '-' }}</span>

                    <div class="dropdown">
                        <button class="btn btn-sm btn-light rounded-circle px-2 py-0" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v text-muted fs--2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            @if($contentType == 'series')
                            <li>
                                <a class="dropdown-item fs--1" href="{{ url('/watch/series/' . ($datas->slug ?? $datas->id)) }}" target="_blank">
                                    <i class="fas fa-list-ul text-primary me-2"></i> Lihat Daftar Episode
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item fs--1 button-add-episode-item" data-id="{{ $datas->id }}" data-title="{{ $datas->title }}" data-bs-toggle="modal" data-bs-target="#modal-pr-xl">
                                    <i class="fas fa-plus-circle text-success me-2"></i> Tambah Episode Baru
                                </button>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item fs--1" href="{{ url('/watch/stream/' . ($datas->slug ?? $datas->id)) }}" target="_blank">
                                    <i class="fas fa-play text-danger me-2"></i> Tonton Film
                                </a>
                            </li>
                            @endif
                            <li><a class="dropdown-item fs--1" href="#"><i class="fas fa-edit text-warning me-2"></i> Edit Master Data</a></li>
                            <li><a class="dropdown-item fs--1 text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus Data</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endforeach
</div>

<!-- Empty State Searching / Filtering -->
<div id="no-results" class="text-center py-5 d-none">
    <i class="fas fa-film-slash text-muted fa-3x mb-2"></i>
    <div class="fw-bold text-secondary fs-1">Data Tidak Ditemukan</div>
    <p class="text-muted fs--1">Tidak ada data yang cocok dengan kategori atau filter pencarian Anda.</p>
</div>
@endsection

@section('base.js')
<!-- Modal Dynamic Form -->
<div class="modal fade" id="modal-pr-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-dark text-white border-0 py-2 px-3">
                <div class="modal-title text-white fw-bold fs-1" id="modal-title-dynamic">
                    <i class="fas fa-film text-danger me-2"></i>Form Master Movie & Series
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="p-0" id="menu-pr-xl"></div>
        </div>
    </div>
</div>

<!-- Modal Watch Trailer -->
<div class="modal fade" id="modal-watch-video" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-0 rounded-3 overflow-hidden shadow-lg">
            <div class="modal-header border-0 text-white py-2 px-3 bg-black">
                <div class="modal-title text-white fw-bold fs-1" id="watch-movie-title">Trailer Player</div>
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
        let selectedCategory = 'all';
        let selectedGenre = 'all';

        // Helper URL YouTube Embed
        function getEmbedUrl(url) {
            if (!url) return '';
            if (url.includes('youtube.com/watch?v=')) {
                let videoId = url.split('v=')[1].split('&')[0];
                return 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            }
            if (url.includes('youtu.be/')) {
                let videoId = url.split('youtu.be/')[1].split('?')[0];
                return 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            }
            return url;
        }

        // 1. Filter Kategori Utama
        $('.category-tab').on('click', function() {
            $('.category-tab').removeClass('active');
            $(this).addClass('active');
            selectedCategory = $(this).data('category');
            filterMovies();
        });

        // 2. Filter Genre
        $('.genre-badge-tab').on('click', function() {
            $('.genre-badge-tab').removeClass('active');
            $(this).addClass('active');
            selectedGenre = $(this).data('genre');
            filterMovies();
        });

        // 3. Search realtime
        $('#search-movie').on('keyup', function() {
            filterMovies();
        });

        function filterMovies() {
            let searchValue = $('#search-movie').val().toLowerCase().trim();
            let visibleCount = 0;

            $('.movie-item').each(function() {
                let title = $(this).data('title');
                let genre = $(this).data('genre');
                let category = $(this).data('category');

                let matchesCategory = (selectedCategory === 'all') || (category === selectedCategory);
                let matchesGenre = (selectedGenre === 'all') || (genre === selectedGenre);
                let matchesSearch = title.includes(searchValue);

                if (matchesCategory && matchesGenre && matchesSearch) {
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

        // 4. Handler khusus Trailer
        $(document).on('click', '.btn-watch-trailer', function(e) {
            e.preventDefault();
            let rawUrl = $(this).data('video');
            let modalTitle = $(this).data('title');

            if (!rawUrl) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Trailer Tidak Tersedia',
                    text: 'Tautan trailer belum diinputkan.',
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

        $('#modal-watch-video').on('hidden.bs.modal', function() {
            $('#video-iframe').attr('src', '');
        });

        // 5. AJAX Load Form Add Master Movie/Series
        $(document).on("click", "#button-add-movie", function(e) {
            e.preventDefault();
            $('#modal-title-dynamic').html('<i class="fas fa-film text-danger me-2"></i>Form Master Movie & Series');
            $('#menu-pr-xl').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-danger" style="width: 2rem; height: 2rem;" role="status"></div>
                    <p class="mt-2 text-muted fs--1 fw-bold">Memuat Form Input...</p>
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

        // 5b. AJAX Load Form Add Episode untuk Series Tertentu
        $(document).on("click", ".button-add-episode-item", function(e) {
            e.preventDefault();
            let seriesId = $(this).data('id');
            let seriesTitle = $(this).data('title');

            $('#modal-title-dynamic').html(`<i class="fas fa-plus-circle text-success me-2"></i>Tambah Episode: ${seriesTitle}`);
            $('#menu-pr-xl').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-success" style="width: 2rem; height: 2rem;" role="status"></div>
                    <p class="mt-2 text-muted fs--1 fw-bold">Memuat Form Tambah Episode...</p>
                </div>
            `);

            // Sesuaikan route add episode Anda (contoh: route('master_data_episode_add'))
            $.ajax({
                url: "{{ route('master_data_movie_add_episode') }}", // Ganti ke route add episode jika sudah dibuat terpisah
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "movie_id": seriesId,
                    "is_episode": 1
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-pr-xl').html(data);
            }).fail(function() {
                $('#menu-pr-xl').html(`
                    <div class="alert alert-danger fs--1 text-center m-3">Gagal memuat form episode. Silahkan coba lagi.</div>
                `);
            });
        });

        // 6. Save Data AJAX
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
                    text: 'Data baru berhasil disimpan!',
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
