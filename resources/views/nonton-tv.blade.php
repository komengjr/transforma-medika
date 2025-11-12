<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live TV | {{ env('APP_LABEL') }} Movie</title>
    <meta name="google-adsense-account" content="ca-pub-XXXXXXXXXXXXXXX">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #0d1117;
            color: #fff;
            overflow-x: hidden;
        }

        /* Layout utama */
        .tv-container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .tv-player {
            flex: 2;
            background-color: #000;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
            position: relative;
        }

        iframe,
        video {
            width: 100%;
            height: 500px;
            border: none;
            border-radius: 15px;
        }

        /* Sidebar daftar channel */
        .tv-sidebar {
            flex: 1;
            background-color: #161b22;
            border-radius: 15px;
            padding: 15px;
            overflow-y: auto;
            max-height: 500px;
            box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .tv-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .tv-sidebar::-webkit-scrollbar-thumb {
            background-color: #198754;
            border-radius: 3px;
        }

        .channel {
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .channel:hover {
            background-color: #198754;
            transform: translateX(5px);
        }

        .channel img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
        }

        .channel.active {
            background-color: #198754;
        }

        /* Search box */
        .tv-search {
            margin-bottom: 10px;
        }

        /* Ad area */
        .ads-box {
            background-color: #212529;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            margin-top: 15px;
        }

        /* Responsif */
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
    </style>
</head>

<body>
    <!-- Navbar (optional, bisa pakai navbar utama kamu) -->
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">🎬 {{ env('APP_LABEL') }} Live TV</a>
            <a href="/" class="btn btn-success btn-sm">Kembali</a>
        </div>
    </nav>

    <div class="container-fluid tv-container">
        <!-- Player -->
        <div class="tv-player">
            <video id="tvPlayer" controls autoplay>
                <source id="tvSource" src="https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8"
                    type="application/x-mpegURL">
                Browser kamu tidak mendukung pemutar video HLS.
            </video>
        </div>

        <!-- Sidebar -->
        <div class="tv-sidebar">
            <input type="text" id="searchChannel" class="form-control form-control-sm tv-search"
                placeholder="Cari channel...">

            <div id="channelList">
                <div class="channel active" data-src="https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/65/Trans_TV_logo_2013.svg"
                        alt="Trans TV">
                    <span>Trans TV</span>
                </div>
                <div class="channel" data-src="https://moevideo.net/hls/stream.m3u8">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Indosiar_Logo.svg" alt="Indosiar">
                    <span>Indosiar</span>
                </div>
                <div class="channel" data-src="https://moevideo.net/live/kompastv.m3u8">
                    <img src="https://upload.wikimedia.org/wikipedia/id/8/89/Kompas_TV_logo_2017.svg" alt="Kompas TV">
                    <span>Kompas TV</span>
                </div>
                <div class="channel" data-src="https://test-streams.mux.dev/test_001/stream.m3u8">
                    <img src="https://upload.wikimedia.org/wikipedia/id/4/47/Metro_TV_logo_2010.svg" alt="Metro TV">
                    <span>Metro TV</span>
                </div>
            </div>

            <!-- Ads space -->
            <div class="ads-box mt-3">
                <p>Adsense Area</p>
                <!-- contoh slot -->
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-XXXXXXXXXXXXXXX"
                    data-ad-slot="1234567890" data-ad-format="auto"></ins>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Ganti channel saat diklik
        const channels = document.querySelectorAll('.channel');
        const player = document.getElementById('tvPlayer');
        const source = document.getElementById('tvSource');

        channels.forEach(ch => {
            ch.addEventListener('click', () => {
                channels.forEach(c => c.classList.remove('active'));
                ch.classList.add('active');
                const src = ch.getAttribute('data-src');
                source.src = src;
                player.load();
                player.play();
            });
        });

        // Pencarian channel
        document.getElementById('searchChannel').addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            channels.forEach(ch => {
                ch.style.display = ch.textContent.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    </script>

    <!-- Adsense Script -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</body>

</html>
