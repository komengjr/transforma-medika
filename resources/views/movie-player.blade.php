<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $movie->title }} | {{ env('APP_LABEL') }} Stream XXI</title>
    <link rel="icon" type="image/png" href="{{ asset('img/box-office.png') }}">
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
        crossorigin="anonymous"></script>
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
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #000;
            opacity: 0;
            transition: opacity 1s ease-in;
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
            z-index: 20;
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

        /* 🔥 Tombol play tengah */
        .center-play {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
            font-size: 5rem;
            color: gold;
            cursor: pointer;
            z-index: 30;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
            transition: all 0.3s ease;
            opacity: 0.85;
        }

        .center-play:hover {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 1;
        }

        .center-play.hidden {
            opacity: 0;
            pointer-events: none;
            transform: translate(-50%, -50%) scale(0.7);
        }

        /* Loader sinematik */
        .loader {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .loader .ring {
            width: 90px;
            height: 90px;
            border: 6px solid rgba(255, 215, 0, 0.2);
            border-top: 6px solid gold;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            box-shadow: 0 0 25px gold;
        }

        .loader span {
            font-size: 1.2rem;
            letter-spacing: 2px;
            color: gold;
            animation: glow 2s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes glow {

            0%,
            100% {
                opacity: 0.7;
                text-shadow: 0 0 10px gold;
            }

            50% {
                opacity: 1;
                text-shadow: 0 0 20px #fff200;
            }
        }

        .loader.hidden {
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
        }

        /* Tirai bioskop */
        .curtain {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #000 0%, #111 50%, #000 100%);
            z-index: 999;
            transform-origin: top;
            animation: curtainOpen 2s ease forwards;
        }

        @keyframes curtainOpen {
            from {
                height: 100%;
            }

            to {
                height: 0%;
            }
        }

        @keyframes curtainClose {
            from {
                height: 0%;
            }

            to {
                height: 100%;
            }
        }

        .hide-controls {
            opacity: 0;
            pointer-events: none;
            transform: translateY(30px);
        }
    </style>

</head>

<body>
    <div class="player-container">
        <div class="loader" id="loader">
            <div class="ring"></div>
            <span>Mohon Menunggu..</span>
        </div>

        <video id="movie" preload="metadata">
            @if ($movie->type_link == 'local')
                <source src="{{ asset('video/' . $movie->id) }}" type="video/mp4">
            @else
                <source src="{{ $movie->video }}" type="video/mp4">
            @endif
        </video>

        <div class="center-play" id="centerPlay" style="display: none;"><i class="bi bi-play-circle-fill"></i></div>
        <!-- 🔥 tombol tengah -->

        <div class="overlay"></div>
        <div class="fullscreen" id="fullscreenBtn"><i class="bi bi-arrows-fullscreen"></i></div>

        <div class="controls" id="controls">
            <div id="button-fitur" style="display: none;">
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
    @php
        $no = mt_rand(100000000, 9999999999)
    @endphp
    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4154628728879232" data-ad-slot="{{$no}}"
        data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

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
        const loader = document.getElementById('loader');
        const centerPlay = document.getElementById('centerPlay');

        const formatTime = (t) => {
            let m = Math.floor(t / 60);
            let s = Math.floor(t % 60);
            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        };

        function updateProgress() {
            if (!isNaN(video.duration)) {
                const percent = (video.currentTime / video.duration) * 100;
                progressBar.style.width = `${percent}%`;
                timeText.textContent = `${formatTime(video.currentTime)} / ${formatTime(video.duration)}`;
            }
        }

        video.addEventListener("canplaythrough", () => {
            loader.classList.add("hidden");
            video.style.opacity = 1;
            document.getElementById('centerPlay').style.display = "block";
            document.getElementById('button-fitur').style.display = "block";
        });

        video.addEventListener('timeupdate', updateProgress);
        video.addEventListener('loadedmetadata', updateProgress);

        // Tombol tengah
        centerPlay.onclick = () => {
            video.play();
            centerPlay.classList.add("hidden");
            btnPlay.style.display = 'none';
            btnPause.style.display = 'inline';
        };

        // Play/Pause bawah
        btnPlay.onclick = () => {
            video.play();
            btnPlay.style.display = 'none';
            btnPause.style.display = 'inline';
            centerPlay.classList.add("hidden");
        };
        btnPause.onclick = () => {
            video.pause();
            btnPause.style.display = 'none';
            btnPlay.style.display = 'inline';
            centerPlay.classList.remove("hidden");
        };

        btnPrev.onclick = () => { video.currentTime = Math.max(0, video.currentTime - 10); };
        btnNext.onclick = () => { video.currentTime = Math.min(video.duration, video.currentTime + 10); };

        progressContainer.onclick = (e) => {
            const rect = progressContainer.getBoundingClientRect();
            const pos = (e.clientX - rect.left) / rect.width;
            video.currentTime = pos * video.duration;
        };

        fullscreenBtn.onclick = () => {
            if (!document.fullscreenElement) document.documentElement.requestFullscreen();
            else document.exitFullscreen();
        };

        document.addEventListener('fullscreenchange', () => {
            document.fullscreenElement ? controls.classList.add('hide-controls') : controls.classList.remove('hide-controls');
        });

        video.onended = () => {
            curtain.style.animation = 'curtainClose 2.5s forwards';
            const music = new Audio('{{ asset("sound/tingtong.mp3") }}');
            setTimeout(() => music.play(), 1500);
        };

        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') video.currentTime = Math.max(0, video.currentTime - 10);
            if (e.key === 'ArrowRight') video.currentTime = Math.min(video.duration, video.currentTime + 10);
            if (e.key === ' ') {
                e.preventDefault();
                if (video.paused) {
                    video.play();
                    centerPlay.classList.add("hidden");
                    btnPlay.style.display = 'none';
                    btnPause.style.display = 'inline';
                } else {
                    video.pause();
                    centerPlay.classList.remove("hidden");
                    btnPause.style.display = 'none';
                    btnPlay.style.display = 'inline';
                }
            }
        });
        setInterval(() => {

        }, 3000);
    </script>
</body>

</html>
