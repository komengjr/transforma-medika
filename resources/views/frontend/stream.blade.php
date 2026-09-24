<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} - Streaming Studio</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .stream-container {
            max-width: 1350px;
            margin: 0 auto;
        }

        .video-player-box {
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        /* Overlay Tombol Play Animasi */
        .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            background-image: url('{{ $movie->backdrop ?? $movie->poster }}');
            background-size: cover;
            background-position: center;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s ease;
        }

        .play-overlay::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(6px);
            z-index: 1;
        }

        .play-btn-pulse {
            position: relative;
            z-index: 2;
            width: 90px;
            height: 90px;
            background: #e11d48;
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7);
            animation: pulse-animation 2s infinite;
            transition: transform 0.2s ease, background 0.2s ease;
            padding-left: 5px;
        }

        .play-btn-pulse:hover {
            transform: scale(1.1);
            background: #be123c;
        }

        @keyframes pulse-animation {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 20px rgba(225, 29, 72, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0);
            }
        }

        .movie-meta-badge {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(4px);
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .card-recommend {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card-recommend:hover {
            transform: translateY(-4px);
        }

        /* Sidebar Daftar Episode untuk Series */
        .episode-sidebar {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            max-height: 600px;
            overflow-y: auto;
        }

        .episode-item {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .episode-item:hover,
        .episode-item.active {
            border-color: #e11d48;
            background: #1e293b;
        }

        /* Overlay Peringatan Pelanggaran F12 */
        #security-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.98);
            z-index: 9999;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>

<body class="py-4" oncontextmenu="return false;">

    <div class="container stream-container">
        <!-- Breadcrumb / Tutup Halaman -->
        <div class="mb-3">
            <a href="javascript:window.close();" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
                <i class="fas fa-arrow-left me-1"></i> Tutup Halaman
            </a>
        </div>

        @php
        $isSeries = isset($episodes) && count($episodes) > 0;
        @endphp

        <div class="row">
            <!-- Kolom Kiri: Pemutar Video & Informasi -->
            <div class="{{ $isSeries ? 'col-lg-8' : 'col-lg-12' }}">

                <!-- Video Player Box -->
                <div class="video-player-box mb-3" id="player-container">

                    <!-- Animasi Tombol Play Awal -->
                    <div id="start-play-overlay" class="play-overlay">
                        <button class="play-btn-pulse" onclick="startStreamingSession()">
                            <i class="fas fa-play"></i>
                        </button>
                        <h5 class="text-white fw-bold mt-4 z-2">Tonton Sekarang</h5>
                        <p class="text-muted small z-2 mb-0">{{ $movie->title }}</p>
                    </div>

                    <!-- Overlay Blokir jika terdeteksi Developer Tools / F12 -->
                    <div id="security-overlay">
                        <i class="fas fa-ban text-danger fa-3x mb-3"></i>
                        <h4 class="text-white fw-bold">Akses Dilarang!</h4>
                        <p class="text-muted small mb-0">Mode Developer / Inspected Element terdeteksi. Pemutaran film dihentikan demi keamanan hak cipta.</p>
                    </div>

                    <div class="ratio ratio-16x9" id="video-wrapper">
                        @php
                        $videoSrc = $movie->video ?? $movie->triler;

                        // Deteksi jenis link online
                        $isYoutube = $videoSrc && (str_contains($videoSrc, 'youtube.com') || str_contains($videoSrc, 'youtu.be'));
                        $isGdrive = $videoSrc && (str_contains($videoSrc, 'drive.google.com') || str_contains($videoSrc, 'docs.google.com'));
                        @endphp

                        @if($isYoutube)
                        @php
                        $ytId = '';
                        if(str_contains($videoSrc, 'v=')) {
                        $ytId = explode('v=', $videoSrc)[1];
                        $ytId = explode('&', $ytId)[0];
                        } elseif(str_contains($videoSrc, 'youtu.be/')) {
                        $ytId = explode('youtu.be/', $videoSrc)[1];
                        $ytId = explode('?', $ytId)[0];
                        }
                        @endphp
                        <iframe id="active-video-element" data-src="https://www.youtube.com/embed/{{ $ytId }}?autoplay=1" allowfullscreen class="border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>

                        @elseif($isGdrive)
                        @php
                        // Ubah link share Google Drive standar menjadi link preview/embed yang valid
                        $gdriveEmbedUrl = $videoSrc;
                        if (str_contains($videoSrc, '/file/d/')) {
                        preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $videoSrc, $matches);
                        if (isset($matches[1])) {
                        $gdriveEmbedUrl = "https://drive.google.com/file/d/{$matches[1]}/preview";
                        }
                        }
                        @endphp
                        <iframe id="active-video-element" data-src="{{ $gdriveEmbedUrl }}" allowfullscreen class="border-0" allow="autoplay"></iframe>

                        @elseif($videoSrc && (str_starts_with($videoSrc, 'http://') || str_starts_with($videoSrc, 'https://')))
                        <!-- Link External Direct URL (MP4 / WebM dari server lain) -->
                        <video id="active-video-element" controls preload="metadata" class="w-100 h-100">
                            <source src="{{ $videoSrc }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video HTML5.
                        </video>

                        @elseif($videoSrc)
                        <!-- File Lokal tersimpan di storage/app/video/ -->
                        <video id="active-video-element" controls preload="metadata" class="w-100 h-100">
                            <source src="{{ route('stream.file', basename($videoSrc)) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video HTML5.
                        </video>
                        @else
                        <div class="d-flex align-items-center justify-content-center text-muted h-100">
                            <p>Video tidak tersedia.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Detail Video/Film -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <span class="badge bg-danger px-2 py-1">{{ $movie->quality ?? '1080p' }}</span>
                            <span class="movie-meta-badge"><i class="fas fa-star text-warning me-1"></i> {{ $movie->rating ?? 'N/A' }}</span>
                            <span class="movie-meta-badge"><i class="fas fa-clock me-1"></i> {{ $movie->duration ?? '-' }}</span>
                            <span class="movie-meta-badge"><i class="fas fa-calendar me-1"></i> {{ !empty($movie->release_date) ? date('Y', strtotime($movie->release_date)) : '-' }}</span>
                            <span class="movie-meta-badge text-info"><i class="fas fa-eye me-1"></i> {{ number_format($movie->views_count ?? 0) }} Penonton</span>
                        </div>

                        <h1 class="fw-bold text-white mb-2 fs-2">
                            @if(isset($movie->episode_number))
                            S{{ $movie->season_number ?? 1 }} E{{ $movie->episode_number }} :
                            @endif
                            {{ $movie->title }}
                        </h1>
                        <p class="text-muted mb-3" style="font-size: 0.95rem; line-height: 1.6;">
                            {{ $movie->description ?? 'Tidak ada deskripsi tersedia untuk video ini.' }}
                        </p>

                        <div class="d-flex gap-2">
                            <span class="badge bg-secondary">Genre: {{ $movie->genre ?? 'Umum' }}</span>
                            <span class="badge bg-dark border border-secondary">Subtitle: {{ $movie->subtitle ?? 'Indonesia' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Daftar Episode (Jika Series) -->
            @if($isSeries)
            <div class="col-lg-4 mb-4">
                <div class="episode-sidebar p-3 shadow">
                    <h5 class="fw-bold text-white mb-3 border-start border-danger border-4 ps-2">Daftar Episode</h5>
                    <div class="d-flex flex-column gap-2">
                        @foreach($episodes as $ep)
                        @php
                        $isActive = ($ep->id == $movie->id);
                        @endphp
                        <a href="{{ url('/watch/stream/' . ($ep->slug ?? $ep->id)) }}" class="text-decoration-none episode-nav-link">
                            <div class="episode-item p-2 d-flex align-items-center gap-3 {{ $isActive ? 'active border-danger' : '' }}">
                                <div class="bg-danger text-white fw-bold rounded px-2 py-1 text-center" style="min-width: 60px; font-size: 0.75rem;">
                                    E{{ $ep->episode_number ?? 1 }}
                                </div>
                                <div class="overflow-hidden">
                                    <div class="text-white fw-bold text-truncate" style="font-size: 0.85rem;">{{ $ep->title }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;"><i class="fas fa-clock me-1"></i> {{ $ep->duration ?? 'Durasi N/A' }}</div>
                                </div>
                                @if($isActive)
                                <div class="ms-auto text-danger pe-2"><i class="fas fa-play-circle fa-lg"></i></div>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Rekomendasi Film Terkait -->
        @if(isset($related) && $related->count() > 0)
        <div class="row mt-3">
            <div class="col-12 mb-3">
                <h5 class="fw-bold text-white border-start border-danger border-4 ps-2">Rekomendasi Serupa</h5>
            </div>
            @foreach($related as $rel)
            <div class="col-6 col-md-4 col-lg-2 mb-3">
                <div class="card-recommend h-100 p-2">
                    <a href="{{ url('/watch/stream/' . ($rel->slug ?? $rel->id)) }}" class="text-decoration-none episode-nav-link">
                        <img src="{{ $rel->poster }}" class="rounded mb-2 w-100 object-fit-cover" style="height: 180px;" alt="{{ $rel->title }}" onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                        <div class="text-white fw-bold text-truncate" style="font-size: 0.8rem;">{{ $rel->title }}</div>
                        <div class="text-muted" style="font-size: 0.7rem;">{{ !empty($rel->release_date) ? date('Y', strtotime($rel->release_date)) : '' }}</div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Kontrol Play, Sesi, Proteksi Anti F12, & Pemutus Koneksi Streaming -->
    <script>
        let isPlayingStarted = false;

        function startStreamingSession() {
            isPlayingStarted = true;

            // 1. Hilangkan animasi tombol play
            const overlay = document.getElementById('start-play-overlay');
            if (overlay) {
                overlay.style.opacity = '0';
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 400);
            }

            // 2. Aktifkan sumber video (baik Iframe YouTube/GDrive atau HTML5 Video)
            const videoElement = document.getElementById('active-video-element');
            if (videoElement) {
                if (videoElement.tagName === 'IFRAME') {
                    const realSrc = videoElement.getAttribute('data-src');
                    if (realSrc) videoElement.setAttribute('src', realSrc);
                } else if (videoElement.tagName === 'VIDEO') {
                    videoElement.play();
                }
            }

            // 3. Mulai aktifkan pemantauan keamanan anti-developer tools
            initSecurityGuards();
        }

        // Hentikan koneksi video secara instan saat user mengklik navigasi ke video/halaman lain
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.episode-nav-link, a[href*="/watch/stream/"]');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const videoEl = document.getElementById('active-video-element');
                    if (videoEl && videoEl.tagName === 'VIDEO') {
                        videoEl.pause();
                        videoEl.src = '';
                        videoEl.load();
                    } else if (videoEl && videoEl.tagName === 'IFRAME') {
                        videoEl.src = ''; // Hentikan muatan iframe GDrive/YouTube
                    }
                });
            });
        });

        function triggerViolation() {
            if (!isPlayingStarted) return;

            const securityOverlay = document.getElementById('security-overlay');
            const videoWrapper = document.getElementById('video-wrapper');

            if (securityOverlay) securityOverlay.style.display = 'flex';

            if (videoWrapper) {
                const videoEl = document.getElementById('active-video-element');
                if (videoEl) {
                    if (videoEl.tagName === 'VIDEO') {
                        videoEl.pause();
                    }
                    videoEl.src = '';
                }
                videoWrapper.innerHTML = '<div class="d-flex align-items-center justify-content-center text-danger h-100 fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Pemutaran Dihentikan Paksa</div>';
            }
        }

        function initSecurityGuards() {
            // A. Blokir tombol pintas F12, Ctrl+Shift+I/J/C, Ctrl+U
            document.addEventListener('keydown', function(e) {
                if (
                    e.keyCode === 123 ||
                    (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) ||
                    (e.ctrlKey && e.keyCode === 85)
                ) {
                    e.preventDefault();
                    triggerViolation();
                    return false;
                }
            });

            // B. Deteksi perubahan ukuran window (Developer Tools dibuka secara docked)
            let threshold = 160;
            setInterval(function() {
                if (
                    window.outerWidth - window.innerWidth > threshold ||
                    window.outerHeight - window.innerHeight > threshold
                ) {
                    triggerViolation();
                }
            }, 1000);

            // C. Deteksi debugger aktif
            (function() {
                try {
                    let devtoolsChecker = new Image();
                    Object.defineProperty(devtoolsChecker, 'id', {
                        get: function() {
                            triggerViolation();
                        }
                    });
                    setInterval(function() {
                        console.log(devtoolsChecker);
                        console.clear();
                    }, 1000);
                } catch (err) {}
            })();
        }
    </script>
</body>

</html>
