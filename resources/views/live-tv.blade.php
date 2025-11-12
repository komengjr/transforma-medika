<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live TV | {{ env('APP_LABEL') }}</title>
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
        crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #0d1117;
            color: #fff;
            overflow-x: hidden;
        }

        .tv-container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .tv-player {
            flex: 4;
            background-color: #000;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
            position: relative;
        }

        iframe,
        video {
            width: 100%;
            height: 600px;
            border: none;
            border-radius: 15px;
        }

        .tv-sidebar {
            flex: 1;
            background-color: #161b22;
            border-radius: 15px;
            padding: 15px;
            overflow-y: auto;
            max-height: 600px;
            box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.1);
        }

        .channel {
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.25s ease;
        }

        .channel:hover {
            background-color: #198754;
            transform: translateX(5px);
        }

        .channel.active {
            background-color: #198754;
        }

        .channel img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
        }

        .tv-search {
            margin-bottom: 10px;
        }

        .ads-box {
            background-color: #174878ff;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            margin-top: 15px;
            height: 200px !important;
        }

        @media (max-width: 991px) {
            .tv-container {
                flex-direction: column;
            }

            .tv-sidebar {
                order: -1;
                max-height: 220px;
            }

            iframe,
            video {
                height: 300px;
            }
        }

        .saweria-button {
            background-color: #00ffc3;
            /* Warna khas Saweria */
            color: #111;
            /* Warna teks yang kontras */
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s ease;
            /* Transisi halus untuk semua perubahan */
            box-shadow: 0 4px 15px rgba(0, 255, 195, 0.4);
        }

        .saweria-button:hover {
            transform: scale(1.05);
            /* Membesar sedikit saat dihover */
            background-color: #00e6b8;
            /* Warna sedikit lebih gelap saat dihover */
            /* Efek denyutan (pulse) */
            animation: pulse 1s infinite alternate;
        }

        /* Keyframes untuk animasi denyutan */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 10px rgba(0, 255, 195, 0.4), 0 0 0 0 rgba(0, 255, 195, 0.4);
            }

            100% {
                box-shadow: 0 0 15px rgba(0, 255, 195, 0.8), 0 0 15px 5px rgba(0, 255, 195, 0);
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">🎬 {{ env('APP_LABEL') }} Live TV</a>
            <a href="/" class="btn btn-success btn-sm">Kembali</a>
        </div>
    </nav>

    <div class="container-fluid tv-container">
        <!-- Player -->
        <div class="tv-player">
            <div id="playerContainer">
                @php $first = $channels->first(); @endphp

                @if ($first->type === 'youtube')
                    <iframe width="100%" height="500"
                        src="https://www.youtube.com/embed/{{ $first->stream_url_or_id }}?autoplay=1&mute=1"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                @else
                    <video id="tvPlayer" controls autoplay muted></video>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="tv-sidebar">
            <input type="text" id="searchChannel" class="form-control form-control-sm tv-search"
                placeholder="Cari channel...">

            <div id="channelList">
                @foreach ($channels as $ch)
                    <div class="channel {{ $loop->first ? 'active' : '' }}" data-type="{{ $ch->type }}"
                        data-src="{{ $ch->stream_url_or_id }}">
                        <img src="{{ $ch->logo_url }}" alt="{{ $ch->name }}">
                        <span>{{ $ch->name }}</span>
                    </div>
                @endforeach
            </div>

            <div class="ads-box mt-3">
                <p><a href="#" onclick="window.open('https://saweria.co/agusraharjo', '_blank').focus();" class="saweria-button">
                        Donasi di Saweria
                    </a></p>
                <ins class="adsbygoogle" data-ad-client="ca-pub-4154628728879232" data-ad-slot="1234567890"
                    data-ad-format="auto"></ins>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

    <script>
        function playHLS(videoElement, src) {
            if (Hls.isSupported()) {
                const hls = new Hls({ debug: false });
                hls.loadSource(src);
                hls.attachMedia(videoElement);
                hls.on(Hls.Events.MANIFEST_PARSED, () => videoElement.play());
                hls.on(Hls.Events.ERROR, (event, data) => {
                    console.error('HLS error:', data);
                });
            } else if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
                videoElement.src = src;
                videoElement.play();
            } else {
                alert('Browser tidak mendukung HLS');
            }
        }

        const playerContainer = document.getElementById('playerContainer');
        const channels = document.querySelectorAll('.channel');

        // Klik channel
        channels.forEach(ch => {
            ch.addEventListener('click', () => {
                channels.forEach(c => c.classList.remove('active'));
                ch.classList.add('active');

                const type = ch.dataset.type;
                const src = ch.dataset.src;
                playerContainer.innerHTML = ''; // clear

                if (type === 'youtube') {
                    playerContainer.innerHTML = `
                        <iframe width="100%" height="500"
                          src="https://www.youtube.com/embed/${src}?autoplay=1&mute=1"
                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                          allowfullscreen></iframe>`;
                } else {
                    // Buat elemen video baru untuk HLS
                    const video = document.createElement('video');
                    video.id = 'tvPlayer';
                    video.controls = true;
                    video.autoplay = true;
                    video.muted = true;
                    video.style.width = '100%';
                    video.style.borderRadius = '15px';
                    playerContainer.appendChild(video);

                    // Panggil HLS
                    playHLS(video, src);
                }
            });
        });

        // Search channel
        document.getElementById('searchChannel').addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            channels.forEach(ch => {
                ch.style.display = ch.textContent.toLowerCase().includes(term) ? '' : 'none';
            });
        });

        // Inisialisasi channel pertama kalau HLS
        document.addEventListener("DOMContentLoaded", () => {
            const firstActive = document.querySelector('.channel.active');
            if (firstActive && firstActive.dataset.type === 'hls') {
                const video = document.getElementById('tvPlayer');
                playHLS(video, firstActive.dataset.src);
            }
        });
    </script>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</body>

</html>
