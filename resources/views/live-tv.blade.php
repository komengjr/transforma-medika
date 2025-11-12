<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live TV | {{ env('APP_LABEL') }}</title>
    <meta name="google-adsense-account" content="ca-pub-XXXXXXXXXXXXXX">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

        .tv-sidebar {
            flex: 1;
            background-color: #161b22;
            border-radius: 15px;
            padding: 15px;
            overflow-y: auto;
            max-height: 500px;
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
            background-color: #212529;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            margin-top: 15px;
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
                    <video id="tvPlayer" controls autoplay>
                        <source src="{{ $first->stream_url_or_id }}" type="application/x-mpegURL">
                        Browser kamu tidak mendukung pemutar video HLS.
                    </video>
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
                <p>AdSense Area</p>
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-XXXXXXXXXXXXXX"
                    data-ad-slot="1234567890" data-ad-format="auto"></ins>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const playerContainer = document.getElementById('playerContainer');
        const channels = document.querySelectorAll('.channel');

        channels.forEach(ch => {
            ch.addEventListener('click', () => {
                channels.forEach(c => c.classList.remove('active'));
                ch.classList.add('active');

                const type = ch.dataset.type;
                const src = ch.dataset.src;

                playerContainer.innerHTML = ''; // clear player

                if (type === 'youtube') {
                    playerContainer.innerHTML = `
            <iframe width="100%" height="500"
              src="https://www.youtube.com/embed/${src}?autoplay=1&mute=1"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>`;
                } else {
                    playerContainer.innerHTML = `
            <video id="tvPlayer" controls autoplay>
              <source src="${src}" type="application/x-mpegURL">
              Browser kamu tidak mendukung pemutar video HLS.
            </video>`;
                }
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

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</body>

</html>
