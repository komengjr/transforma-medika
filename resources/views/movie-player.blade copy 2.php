<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">

    <title>{{ $movie->title }} | {{env('APP_LABEL')}} Stream</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #000;
            color: #fff;
            font-family: "Poppins", sans-serif;
            overflow: hidden;
        }

        .player-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #000;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.6) 100%);
            pointer-events: none;
        }

        .controls {
            position: absolute;
            bottom: 40px;
            width: 80%;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0, 0, 0, 0.55);
            border-radius: 50px;
            padding: 10px 20px;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .control-btns {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .controls button {
            background: none;
            border: none;
            color: #d4af37;
            font-size: 1.7rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .controls button:hover {
            color: #fff;
            transform: scale(1.2);
        }

        .progress-container {
            flex: 1;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            margin: 0 1rem;
            position: relative;
            cursor: pointer;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #d4af37, #f1e1a6);
            width: 0%;
            border-radius: 4px;
        }

        .time {
            font-size: 0.9rem;
            color: #ccc;
            min-width: 75px;
            text-align: right;
        }

        .fullscreen {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1.4rem;
            color: #d4af37;
            background: rgba(0, 0, 0, 0.5);
            padding: 8px 10px;
            border-radius: 50%;
            border: 1px solid rgba(212, 175, 55, 0.3);
            cursor: pointer;
            transition: 0.3s;
            z-index: 20;
        }

        .fullscreen:hover {
            color: #fff;
            transform: scale(1.1);
        }

        .curtain {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 0%;
            background: linear-gradient(135deg, #000, #111 50%, #000);
            z-index: 999;
            animation: none;
        }

        @keyframes curtainClose {
            from {
                height: 0%;
            }

            to {
                height: 100%;
            }
        }

        /* Loading animation */
        .loader {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 6px solid rgba(255, 215, 0, 0.3);
            border-top: 6px solid gold;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            box-shadow: 0 0 25px gold;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Fade out animasi */
        .loader.hidden {
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
        }

        /* Saat fullscreen, sembunyikan semua kontrol */
        .hide-controls {
            opacity: 0;
            pointer-events: none;
            transform: translateY(30px);
        }
    </style>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
        crossorigin="anonymous"></script>
</head>

<body>

    <div class="player-container">
        <div class="loader" id="loader"></div>
        <video id="movie" preload="metadata">
            <!-- <source src="{{ asset('video/' . $movie->id) }}" type="video/mp4"> -->
            @if ($movie->type_link == 'local')
                <source src="{{ asset('video/' . $movie->id) }}" type="video/mp4">
            @else
                <source src="{{$movie->video}}" type="video/mp4">
            @endif
        </video>
        <div class="overlay"></div>

        <!-- Tombol fullscreen -->
        <div class="fullscreen" id="fullscreenBtn">
            <i class="bi bi-arrows-fullscreen"></i>
        </div>

        <!-- Kontrol -->
        <div class="controls" id="controls">
            <div class="control-btns">
                <button id="btnPrev"><i class="bi bi-skip-backward-fill"></i></button>
                <button id="btnPlay"><i class="bi bi-play-circle-fill"></i></button>
                <button id="btnPause" style="display:none;"><i class="bi bi-pause-circle-fill"></i></button>
                <button id="btnNext"><i class="bi bi-skip-forward-fill"></i></button>
            </div>

            <div class="progress-container" id="progressContainer">
                <div class="progress-bar" id="progressBar"></div>
            </div>

            <div class="time" id="timeText">00:00 / 00:00</div>
        </div>
    </div>

    <div class="curtain" id="curtain"></div>

    <script>
        const video = document.getElementById('movie');
        const btnPlay = document.getElementById('btnPlay');
        const btnPause = document.getElementById('btnPause');
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const progressBar = document.getElementById('progressBar');
        const progressContainer = document.getElementById('progressContainer');
        const timeText = document.getElementById('timeText');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const curtain = document.getElementById('curtain');
        const controls = document.getElementById('controls');
        const loader = document.getElementById("loader");

        // Format waktu
        function formatTime(t) {
            let m = Math.floor(t / 60);
            let s = Math.floor(t % 60);
            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        }

        // Update progress bar
        function updateProgress() {
            if (!isNaN(video.duration)) {
                const percent = (video.currentTime / video.duration) * 100;
                progressBar.style.width = `${percent}%`;
                timeText.textContent = `${formatTime(video.currentTime)} / ${formatTime(video.duration)}`;
            }
        }
        // Saat video sedang dimuat, tampilkan loader
        loader.classList.remove("hidden");
        video.addEventListener("canplaythrough", () => {
            setTimeout(() => loader.classList.add("hidden"), 500);
        });
        video.addEventListener('timeupdate', updateProgress);
        video.addEventListener('loadedmetadata', updateProgress);

        // Play & Pause
        btnPlay.onclick = () => {
            video.play();
            btnPlay.style.display = 'none';
            btnPause.style.display = 'inline';
        };
        btnPause.onclick = () => {
            video.pause();
            btnPause.style.display = 'none';
            btnPlay.style.display = 'inline';
        };

        // Skip mundur / maju
        btnPrev.onclick = () => {
            if (!isNaN(video.duration)) video.currentTime = Math.max(0, video.currentTime - 10);
        };
        btnNext.onclick = () => {
            if (!isNaN(video.duration)) video.currentTime = Math.min(video.duration, video.currentTime + 10);
        };

        // Klik progress bar untuk seek
        progressContainer.onclick = (e) => {
            const rect = progressContainer.getBoundingClientRect();
            const pos = (e.clientX - rect.left) / rect.width;
            if (!isNaN(video.duration)) video.currentTime = pos * video.duration;
        };

        // Fullscreen toggle
        fullscreenBtn.onclick = () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        };

        // Sembunyikan kontrol saat fullscreen
        document.addEventListener('fullscreenchange', () => {
            if (document.fullscreenElement) {
                controls.classList.add('hide-controls');
            } else {
                controls.classList.remove('hide-controls');
            }
        });

        // Tirai & musik di akhir
        video.onended = () => {
            curtain.style.animation = 'curtainClose 2.5s forwards';
            const music = new Audio('{{ asset("sound/tingtong.mp3") }}');
            setTimeout(() => music.play(), 1800);
        };

        // 🎬 Keyboard controls
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                // Tombol kiri → mundur 10 detik
                e.preventDefault();
                if (!isNaN(video.duration)) video.currentTime = Math.max(0, video.currentTime - 10);
            }
            else if (e.key === 'ArrowRight') {
                // Tombol kanan → maju 10 detik
                e.preventDefault();
                if (!isNaN(video.duration)) video.currentTime = Math.min(video.duration, video.currentTime + 10);
            }
        });
    </script>

</body>

</html>
