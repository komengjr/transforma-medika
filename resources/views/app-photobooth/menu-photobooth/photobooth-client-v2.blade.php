<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $photobooth->org_name }} Photobooth</title>

    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- QRCode.js Library -->
    <script src="{{asset('asset/js/qr.js')}}"></script>

    @php
    $logoUrl = $photobooth->logo_path
    ? (str_contains($photobooth->logo_path, 'photobooth/') ? asset('storage/' . $photobooth->logo_path) : asset('storage/photobooth/' . $photobooth->logo_path))
    : asset('img/pramita.png');

    $bgUrl = $photobooth->bg_path
    ? (str_contains($photobooth->bg_path, 'photobooth/') ? asset('storage/' . $photobooth->bg_path) : asset('storage/photobooth/' . $photobooth->bg_path))
    : 'https://pustaka.bca.co.id/Promo/A2C31A68-BC10-4CBD-AB51-85474A36CC50/Detail/ImageListing/20250723_PRAMITA-LAB-SBY-thumb.jpeg';
    @endphp

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            height: 100vh;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgba(106, 17, 203, 0.85), rgba(37, 117, 252, 0.85), rgba(255, 64, 129, 0.85)),
            url('{{ $bgUrl }}') center/cover no-repeat fixed;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        header {
            padding: 8px 20px;
            text-align: center;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .header-logo {
            height: 45px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        h1 {
            font-size: 1.6rem;
            font-weight: bold;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            color: #ffffff;
            margin: 0;
        }

        .fs-banner {
            background: rgba(0, 0, 0, 0.4);
            font-size: 0.8rem;
            padding: 4px;
            text-align: center;
            cursor: pointer;
        }

        .fs-banner span {
            color: #ffeb3b;
            text-decoration: underline;
            font-weight: bold;
        }

        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px 20px 20px;
            height: calc(100vh - 90px);
        }

        .step-box-small {
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 20px;
            color: #333;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        #step-2-frame {
            display: none;
            width: 100%;
            height: 100%;
            max-width: 1100px;
            background: transparent;
            border: none;
            padding: 10px;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: none;
            animation: fadeInScale 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .ps3-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 15px;
        }

        .ps3-top-bar h3 {
            color: #ffffff;
            font-size: 1.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
        }

        .ps3-carousel-wrapper {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 20px 0;
        }

        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.6);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 20;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }

        .carousel-arrow:hover {
            background: rgba(255, 64, 129, 0.8);
            border-color: #fff;
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-arrow.left {
            left: 10px;
        }

        .carousel-arrow.right {
            right: 10px;
        }

        .frame-carousel {
            display: flex;
            gap: 40px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            padding: 70px 60px;
            width: 100%;
            align-items: center;
            scrollbar-width: none;
        }

        .frame-carousel::-webkit-scrollbar {
            display: none;
        }

        .frame-card {
            scroll-snap-align: center;
            min-width: 190px;
            max-width: 190px;
            height: 310px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 16px;
            cursor: pointer;
            text-align: center;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            transform: scale(0.8);
            opacity: 0.5;
        }

        .frame-card img {
            width: 100%;
            height: 220px;
            object-fit: contain;
            border-radius: 10px;
            filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.3));
            transition: all 0.4s ease;
        }

        .frame-card span {
            display: block;
            margin-top: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }

        .frame-card.active {
            transform: scale(1.2) translateY(-5px);
            opacity: 1;
            z-index: 10;
            background: rgba(255, 255, 255, 0.35);
            border-color: #ff4081;
            box-shadow: 0 15px 35px rgba(255, 64, 129, 0.5), 0 0 20px rgba(255, 255, 255, 0.8);
        }

        .ps3-bottom-bar {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
        }

        #step-booth {
            display: none;
            width: 100%;
            height: 100%;
            max-width: 1250px;
            gap: 20px;
        }

        .booth-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .camera-container {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            background: #000;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            border: 4px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .camera-container.landscape {
            width: 100%;
            max-width: 650px;
            aspect-ratio: 4 / 3;
        }

        .camera-container.portrait {
            height: 100%;
            max-height: 80vh;
            aspect-ratio: 3 / 4;
            width: auto;
        }

        .camera-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(1);
        }

        .filter-normal {
            filter: none;
        }

        .filter-grayscale {
            filter: grayscale(100%);
        }

        .filter-sepia {
            filter: sepia(100%);
        }

        .filter-vintage {
            filter: sepia(50%) contrast(120%) brightness(90%);
        }

        .filter-bright {
            filter: brightness(125%) contrast(105%);
        }

        .filter-cool {
            filter: hue-rotate(30deg) saturate(120%);
        }

        .countdown {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 6rem;
            font-weight: bold;
            color: #ffeb3b;
            text-shadow: 0 0 20px rgba(0, 0, 0, 0.9);
            display: none;
            z-index: 20;
        }

        .preview-section {
            width: 100%;
            max-width: 300px;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            padding: 12px;
            border-radius: 16px;
            color: #333;
            display: flex;
            flex-direction: column;
            max-height: 80vh;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .preview-gallery {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            overflow-y: auto;
            padding-right: 4px;
        }

        .preview-item {
            background: #f0f0f0;
            border: 2px dashed #bbb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #888;
            font-size: 0.8rem;
            font-weight: bold;
            min-height: 75px;
            width: 100%;
            flex-shrink: 0;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        canvas {
            display: none;
        }

        .table-container {
            width: 100%;
            margin-top: 8px;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            display: none;
            max-height: 100px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.7rem;
            text-align: left;
        }

        th,
        td {
            padding: 3px;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            background: linear-gradient(45deg, #ff4081, #ff6e40);
            color: white;
            border: none;
            padding: 10px 16px;
            font-size: 0.9rem;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            width: 100%;
            margin-top: 5px;
            box-shadow: 0 4px 15px rgba(255, 64, 129, 0.4);
            transition: transform 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:disabled {
            background: #bbb;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-secondary {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            font-size: 0.8rem;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-merge {
            background: linear-gradient(45deg, #2196F3, #00BCD4);
            display: none;
        }

        .qrcode-swal-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 15px auto;
            padding: 10px;
            background: #fff;
            border-radius: 10px;
            width: 180px;
            height: 180px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body onclick="triggerFullscreen()">

    <div class="fs-banner" id="fs-banner">
        📱 Klik di mana saja pada layar untuk mengaktifkan Mode <span>Full Screen</span>
    </div>

    <header>
        <img src="{{ $logoUrl }}" alt="Logo {{ $photobooth->org_name }}" class="header-logo">
        <h1>{{ $photobooth->org_name }} Photobooth</h1>
    </header>

    <div class="main-container">

        <!-- STEP 1: FORM DATA DIRI -->
        <div id="step-1-form" class="step-box-small">
            <h3 style="margin-bottom: 15px; color: #ff4081; text-align: center;">Langkah 1: Isi Data Diri</h3>
            <div class="form-group" style="margin-bottom: 12px;">
                <label for="user-name" style="display:block; margin-bottom:4px; font-size:0.85rem; font-weight:600; color:#444;">Nama Lengkap:</label>
                <input type="text" id="user-name" placeholder="Masukkan nama Anda" style="width:100%; padding:10px 12px; border-radius:8px; border:2px solid #ddd; background:#f9f9f9; color:#333; font-size:0.9rem;">
            </div>
            <div class="form-group" style="margin-bottom: 12px;">
                <label for="user-phone" style="display:block; margin-bottom:4px; font-size:0.85rem; font-weight:600; color:#444;">Nomor HP / WhatsApp:</label>
                <input type="tel" id="user-phone" placeholder="Contoh: 08123456789" style="width:100%; padding:10px 12px; border-radius:8px; border:2px solid #ddd; background:#f9f9f9; color:#333; font-size:0.9rem;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="user-email" style="display:block; margin-bottom:4px; font-size:0.85rem; font-weight:600; color:#444;">Email:</label>
                <input type="email" id="user-email" placeholder="Contoh: user@email.com" style="width:100%; padding:10px 12px; border-radius:8px; border:2px solid #ddd; background:#f9f9f9; color:#333; font-size:0.9rem;">
            </div>
            <button class="btn" onclick="submitFormStep1()">Lanjut ke Pilih Frame</button>
        </div>

        <!-- STEP 2: PS3 CAROUSEL FRAME SELECTION -->
        <div id="step-2-frame">
            <div class="ps3-top-bar">
                <h3>Pilih Frame Photobooth</h3>
                <div style="width: 220px;">
                    <select id="camera-filter" onchange="applyFilter(this.value)" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.3); background: rgba(0,0,0,0.5); color: #fff; font-size: 0.85rem;">
                        <option value="filter-normal">Filter: Normal</option>
                        <option value="filter-grayscale">Filter: Hitam Putih</option>
                        <option value="filter-sepia">Filter: Sepia</option>
                        <option value="filter-vintage">Filter: Vintage</option>
                        <option value="filter-bright">Filter: Bright</option>
                        <option value="filter-cool">Filter: Cool Blue</option>
                    </select>
                </div>
            </div>

            <div class="ps3-carousel-wrapper">
                <div class="carousel-arrow left" onclick="scrollCarousel(-1)">&#10094;</div>
                <div class="carousel-arrow right" onclick="scrollCarousel(1)">&#10095;</div>

                <div class="frame-carousel" id="frame-carousel">
                    @forelse($photobooth->frames as $key =>$frame)
                    @php
                    $frameUrl = str_contains($frame->frame_path, 'photobooth/')
                    ? asset('storage/' . $frame->frame_path)
                    : asset('storage/photobooth/' . $frame->frame_path);
                    @endphp
                    <div class="frame-card {{ $key === 0 ? 'active' : '' }}"
                        data-src="{{ $frameUrl }}"
                        onclick="selectFrame(this)">
                        <img src="{{ $frameUrl }}" alt="{{ $frame->frame_name }}">
                        <span>{{ $frame->frame_name }}</span>
                    </div>
                    @empty
                    <div class="text-muted text-center" style="width: 100%;">Belum ada frame yang diupload.</div>
                    @endforelse
                </div>
            </div>

            <div class="ps3-bottom-bar">
                <button class="btn btn-secondary" style="max-width: 180px;" onclick="backToStep1()">Kembali</button>
                <button class="btn" onclick="goToStep3Booth()">Mulai Sesi Foto</button>
            </div>
        </div>

        <!-- STEP 3: PEMOTRETAN -->
        <div id="step-booth">
            <div class="booth-column" style="flex: 1.5;">
                <div id="dynamic-camera-wrapper" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; position: relative;">
                </div>
            </div>

            <div class="booth-column" style="flex: 0.8; align-items: flex-start;">
                <div class="preview-section">
                    <h4 id="preview-title" style="margin-bottom: 6px; color: #ff4081; text-align: center; font-size: 0.9rem;">Hasil Jepretan</h4>
                    <div class="preview-gallery" id="preview-gallery"></div>

                    <div style="margin-top: 8px;">
                        <button id="start-btn" class="btn" onclick="startPhotobooth()">Mulai Ambil Foto</button>
                        <button id="merge-btn" class="btn btn-merge" onclick="mergePhotos()">Proses & Dapatkan Barcode</button>
                        <button id="back-btn" class="btn btn-secondary" onclick="backToStep2()">Ganti Frame / Filter</button>
                    </div>

                    <div id="table-container" class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Barcode</th>
                                </tr>
                            </thead>
                            <tbody id="user-table-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <canvas id="photo-strip"></canvas>
        </div>

    </div>

    <script>
        let isFullscreenTriggered = false;

        function triggerFullscreen() {
            if (!isFullscreenTriggered) {
                let el = document.documentElement;
                let rfs = el.requestFullscreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;
                if (rfs) {
                    rfs.call(el).catch(() => {});
                }
                isFullscreenTriggered = true;
                const banner = document.getElementById('fs-banner');
                if (banner) banner.style.display = 'none';
            }
        }

        const step1Form = document.getElementById('step-1-form');
        const step2Frame = document.getElementById('step-2-frame');
        const stepBooth = document.getElementById('step-booth');

        const dynamicCameraWrapper = document.getElementById('dynamic-camera-wrapper');

        const canvas = document.getElementById('photo-strip');
        const ctx = canvas.getContext('2d');
        const countdownEl = document.createElement('div');
        countdownEl.id = 'countdown';
        countdownEl.className = 'countdown';
        countdownEl.innerText = '5';

        const startBtn = document.getElementById('start-btn');
        const mergeBtn = document.getElementById('merge-btn');
        const backBtn = document.getElementById('back-btn');

        const previewGallery = document.getElementById('preview-gallery');
        const previewTitle = document.getElementById('preview-title');
        const tableContainer = document.getElementById('table-container');
        const userTableBody = document.getElementById('user-table-body');

        let mediaStream = null;
        let activeFrameCard = document.querySelector('.frame-card.active');
        let selectedFrameSrc = activeFrameCard?.getAttribute('data-src') || '';
        let currentFilterClass = 'filter-normal';
        let frameImageObj = new Image();
        let greenSlots = [];
        let framedPhotos = [];
        let audioCtx = null;

        function initAudio() {
            if (!audioCtx) audioCtx = new(window.AudioContext || window.webkitAudioContext)();
        }

        function playBeepSound() {
            initAudio();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(600, audioCtx.currentTime);
            gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.15);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.15);
        }

        function playClickSound() {
            initAudio();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(400, audioCtx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(200, audioCtx.currentTime + 0.08);
            gain.gain.setValueAtTime(0.15, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.08);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.08);
        }

        function playShutterSound() {
            initAudio();
            const bufferSize = audioCtx.sampleRate * 0.08;
            const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
            const output = buffer.getChannelData(0);
            for (let i = 0; i < bufferSize; i++) output[i] = Math.random() * 2 - 1;
            const noise = audioCtx.createBufferSource();
            noise.buffer = buffer;
            const filter = audioCtx.createBiquadFilter();
            filter.type = 'highpass';
            filter.frequency.value = 1000;
            const gain = audioCtx.createGain();
            gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.08);
            noise.connect(filter);
            filter.connect(gain);
            gain.connect(audioCtx.destination);
            noise.start();
        }

        function scrollCarousel(direction) {
            playClickSound();
            const carousel = document.getElementById('frame-carousel');
            const scrollAmount = 220;
            carousel.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        function renderPreviewSlots() {
            previewGallery.innerHTML = '';
            previewTitle.innerText = `Hasil Jepretan (${greenSlots.length} Pose)`;
            startBtn.innerText = `Mulai Foto (${greenSlots.length} Pose)`;

            for (let i = 0; i < greenSlots.length; i++) {
                const slot = document.createElement('div');
                slot.className = 'preview-item';
                slot.id = `slot-${i}`;
                slot.innerText = `Pose ${i + 1}`;
                previewGallery.appendChild(slot);
            }
        }

        function applyFilter(filterClass) {
            currentFilterClass = filterClass;
            const v = document.getElementById('webcam');
            if (v) v.className = filterClass;
        }

        function analyzeFrameImage(imgUrl, callback) {
            const img = new Image();
            img.crossOrigin = "anonymous";
            img.onload = () => {
                frameImageObj = img;
                const c = document.createElement('canvas');
                c.width = img.naturalWidth || img.width;
                c.height = img.naturalHeight || img.height;
                const cx = c.getContext('2d');
                cx.drawImage(img, 0, 0);

                const imgData = cx.getImageData(0, 0, c.width, c.height);
                const data = imgData.data;
                const width = c.width;
                const height = c.height;

                const mask = new Uint8Array(width * height);
                for (let i = 0, p = 0; i < data.length; i += 4, p++) {
                    let r = data[i],
                        g = data[i + 1],
                        b = data[i + 2],
                        a = data[i + 3];

                    let isTargetArea = (a < 20) || (r > 245 && g > 245 && b > 245);
                    mask[p] = isTargetArea ? 1 : 0;
                }

                let visited = new Uint8Array(width * height);
                let rawBoxes = [];

                for (let y = 0; y < height; y += 8) {
                    for (let x = 0; x < width; x += 8) {
                        let p = y * width + x;
                        if (mask[p] === 1 && visited[p] === 0) {
                            let rx = x;
                            while (rx < width && mask[y * width + rx] === 1) rx++;
                            let rWidth = rx - x;

                            let ry = y;
                            while (ry < height && mask[ry * width + x] === 1) ry++;
                            let rHeight = ry - y;

                            if (rWidth > 120 && rHeight > 120) {
                                for (let fy = y; fy < y + rHeight; fy += 8) {
                                    for (let fx = x; fx < x + rWidth; fx += 8) {
                                        visited[fy * width + fx] = 1;
                                    }
                                }

                                let topEdgeX1 = -1;
                                for (let fx = x; fx < x + rWidth; fx++) {
                                    if (mask[y * width + fx] === 1) {
                                        topEdgeX1 = fx;
                                        break;
                                    }
                                }

                                let sampleY = y + Math.floor(rHeight * 0.2);
                                let midEdgeX1 = -1;
                                for (let fx = x; fx < x + rWidth; fx++) {
                                    if (mask[sampleY * width + fx] === 1) {
                                        midEdgeX1 = fx;
                                        break;
                                    }
                                }

                                let calculatedAngle = 0;
                                if (topEdgeX1 !== -1 && midEdgeX1 !== -1) {
                                    let shiftX = midEdgeX1 - topEdgeX1;
                                    let shiftY = sampleY - y;
                                    if (shiftY !== 0) {
                                        calculatedAngle = Math.atan(shiftX / shiftY) * (180 / Math.PI);
                                    }
                                }

                                if (Math.abs(calculatedAngle) > 15) calculatedAngle = 0;

                                rawBoxes.push({
                                    x: x,
                                    y: y,
                                    width: rWidth,
                                    height: rHeight,
                                    angle: calculatedAngle,
                                    orientation: rWidth > rHeight ? 'landscape' : 'portrait'
                                });
                            }
                        }
                    }
                }

                rawBoxes.sort((a, b) => a.y - b.y);
                greenSlots = rawBoxes;

                if (greenSlots.length === 0) {
                    greenSlots = [{
                        x: Math.floor(width * 0.1),
                        y: Math.floor(height * 0.05),
                        width: Math.floor(width * 0.8),
                        height: Math.floor(height * 0.4),
                        angle: 0,
                        orientation: 'portrait'
                    }];
                }

                if (callback) callback(greenSlots);
            };
            img.src = imgUrl;
        }

        function submitFormStep1() {
            const name = document.getElementById('user-name').value.trim();
            const phone = document.getElementById('user-phone').value.trim();
            const email = document.getElementById('user-email').value.trim();

            if (!name || !phone || !email) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Lengkapi semua field!'
                });
                return;
            }

            step1Form.style.display = 'none';
            step2Frame.style.display = 'flex';

            const activeCard = document.querySelector('.frame-card.active');
            if (activeCard) {
                selectFrame(activeCard);
            }
        }

        function backToStep1() {
            step2Frame.style.display = 'none';
            step1Form.style.display = 'block';
        }

        function selectFrame(element) {
            playClickSound();
            document.querySelectorAll('.frame-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');

            element.scrollIntoView({
                behavior: 'smooth',
                inline: 'center',
                block: 'nearest'
            });

            selectedFrameSrc = element.getAttribute('data-src');

            analyzeFrameImage(selectedFrameSrc, (slots) => {
                renderPreviewSlots();
            });
        }

        function renderCameraForSlot(slotIndex) {
            dynamicCameraWrapper.innerHTML = '';

            const currentSlot = greenSlots[slotIndex];
            const slotOrientation = currentSlot ? currentSlot.orientation : 'portrait';

            const singleContainer = document.createElement('div');
            singleContainer.className = `camera-container ${slotOrientation}`;
            singleContainer.id = 'cam-container-main';
            singleContainer.innerHTML = `
                <video id="webcam" class="${currentFilterClass}" autoplay playsinline></video>
            `;
            singleContainer.appendChild(countdownEl);
            dynamicCameraWrapper.appendChild(singleContainer);

            const vMain = document.getElementById('webcam');
            if (vMain && mediaStream) {
                vMain.srcObject = mediaStream;
            }
        }

        async function goToStep3Booth() {
            if (!selectedFrameSrc) {
                Swal.fire('Perhatian', 'Silakan pilih frame terlebih dahulu!', 'warning');
                return;
            }

            Swal.fire({
                title: 'Mengakses Kamera...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                if (!mediaStream) {
                    mediaStream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            width: {
                                ideal: 1920
                            },
                            height: {
                                ideal: 1080
                            }
                        },
                        audio: false
                    });
                }
                Swal.close();

                step2Frame.style.display = 'none';
                stepBooth.style.display = 'flex';

                renderCameraForSlot(0);
                resetBoothState();
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Gagal',
                    text: 'Izin kamera ditolak atau perangkat bermasalah: ' + err.message
                });
            }
        }

        function backToStep2() {
            resetBoothState();
            stopCamera();
            stepBooth.style.display = 'none';
            step2Frame.style.display = 'flex';
        }

        function stopCamera() {
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                mediaStream = null;
            }
        }

        function resetBoothState() {
            framedPhotos = [];
            renderPreviewSlots();
            mergeBtn.style.display = 'none';
            startBtn.style.display = 'block';
            startBtn.disabled = false;
            backBtn.disabled = false;
        }

        async function startPhotobooth() {
            initAudio();
            startBtn.disabled = true;
            backBtn.disabled = true;
            mergeBtn.style.display = 'none';
            framedPhotos = [];

            for (let i = 0; i < greenSlots.length; i++) {
                renderCameraForSlot(i);
                await runCountdown(5);
                captureFramedPhoto(i);
            }

            startBtn.style.display = 'none';
            mergeBtn.style.display = 'block';
            backBtn.disabled = false;
        }

        function runCountdown(seconds) {
            return new Promise((resolve) => {
                countdownEl.style.display = 'block';
                let count = seconds;
                countdownEl.innerText = count;
                playBeepSound();

                const interval = setInterval(() => {
                    count--;
                    if (count > 0) {
                        countdownEl.innerText = count;
                        playBeepSound();
                    } else {
                        clearInterval(interval);
                        countdownEl.style.display = 'none';
                        resolve();
                    }
                }, 1000);
            });
        }

        function captureFramedPhoto(index) {
            playShutterSound();

            const slot = greenSlots[index];
            const pWidth = slot.width;
            const pHeight = slot.height;

            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = pWidth;
            tempCanvas.height = pHeight;
            const tempCtx = tempCanvas.getContext('2d');

            const activeVideo = document.getElementById('webcam') || document.querySelector('video');

            const filterStyles = getComputedStyle(activeVideo).filter;
            tempCtx.filter = filterStyles !== 'none' ? filterStyles : 'none';

            const videoWidth = activeVideo.videoWidth || pWidth;
            const videoHeight = activeVideo.videoHeight || pHeight;
            const videoAspect = videoWidth / videoHeight;
            const canvasAspect = pWidth / pHeight;

            let sx, sy, sWidth, sHeight;
            if (videoAspect > canvasAspect) {
                sHeight = videoHeight;
                sWidth = videoHeight * canvasAspect;
                sx = (videoWidth - sWidth) / 2;
                sy = 0;
            } else {
                sWidth = videoWidth;
                sHeight = videoWidth / canvasAspect;
                sx = 0;
                sy = (videoHeight - sHeight) / 2;
            }

            tempCtx.translate(0, 0);
            tempCtx.scale(1, 1);

            const scaleOver = 1.02;
            const drawW = pWidth * scaleOver;
            const drawH = pHeight * scaleOver;
            const drawX = (pWidth - drawW) / 2;
            const drawY = (pHeight - drawH) / 2;

            tempCtx.drawImage(activeVideo, sx, sy, sWidth, sHeight, drawX, drawY, drawW, drawH);

            const imgDataUrl = tempCanvas.toDataURL('image/png', 1.0);
            framedPhotos.push(imgDataUrl);

            document.getElementById(`slot-${index}`).innerHTML = `<img src="${imgDataUrl}" alt="Pose ${index + 1}">`;
        }

        async function mergePhotos() {
            if (framedPhotos.length === 0) {
                Swal.fire('Perhatian', 'Belum ada foto yang diambil!', 'warning');
                return;
            }

            Swal.fire({
                title: 'Memproses AI Enhancement...',
                text: 'Sedang mempertajam detail foto secara otomatis...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let enhancedPhotos = [];
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            for (let foto of framedPhotos) {
                try {
                    let res = await fetch("{{ route('photobooth.ai') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            image_data: foto
                        })
                    });
                    let json = await res.json();
                    if (json.success && json.enhanced_image) {
                        enhancedPhotos.push(json.enhanced_image);
                    } else {
                        enhancedPhotos.push(foto);
                    }
                } catch (e) {
                    enhancedPhotos.push(foto);
                }
            }

            framedPhotos = enhancedPhotos;

            const fWidth = frameImageObj.naturalWidth || frameImageObj.width || 1200;
            const fHeight = frameImageObj.naturalHeight || frameImageObj.height || 1800;

            canvas.width = fWidth;
            canvas.height = fHeight;
            ctx.clearRect(0, 0, fWidth, fHeight);
            ctx.fillRect(0, 0, fWidth, fHeight);

            const targetSlots = greenSlots.length > 0 ? greenSlots : [{
                x: 75,
                y: 55,
                width: 1050,
                height: 780,
                angle: 0
            }];

            for (let index = 0; index < targetSlots.length; index++) {
                if (index >= framedPhotos.length) break;

                const slot = targetSlots[index];
                const photoSrc = framedPhotos[index];

                await new Promise((resolve) => {
                    const img = new Image();
                    img.crossOrigin = "anonymous";
                    img.onload = () => {
                        ctx.save();
                        const centerX = slot.x + slot.width / 2;
                        const centerY = slot.y + slot.height / 2;
                        ctx.translate(centerX, centerY);
                        if (slot.angle) ctx.rotate((slot.angle * Math.PI) / 180);

                        ctx.beginPath();
                        ctx.rect(-slot.width / 2, -slot.height / 2, slot.width, slot.height);
                        ctx.clip();

                        const imgAspect = img.width / img.height;
                        const slotAspect = slot.width / slot.height;
                        let renderW, renderH, renderX, renderY;

                        if (imgAspect > slotAspect) {
                            renderH = slot.height;
                            renderW = renderH * imgAspect;
                        } else {
                            renderW = slot.width;
                            renderH = renderW / imgAspect;
                        }

                        const coverScale = Math.max(slot.width / renderW, slot.height / renderH) * 1.04;
                        renderW *= coverScale;
                        renderH *= coverScale;
                        renderX = -slot.width / 2 + (slot.width - renderW) / 2;
                        renderY = -slot.height / 2 + (slot.height - renderH) / 2;

                        ctx.imageSmoothingEnabled = true;
                        ctx.imageSmoothingQuality = 'high';
                        ctx.drawImage(img, 0, 0, img.width, img.height, renderX, renderY, renderW, renderH);
                        ctx.restore();
                        resolve();
                    };
                    img.onerror = () => resolve();
                    img.src = photoSrc;
                });
            }

            await new Promise((resolve) => {
                const fImg = new Image();
                fImg.crossOrigin = "anonymous";
                fImg.onload = () => {
                    ctx.save();
                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';
                    ctx.drawImage(fImg, 0, 0, fWidth, fHeight);
                    ctx.restore();
                    resolve();
                };
                fImg.onerror = () => resolve();
                fImg.src = selectedFrameSrc;
            });

            saveToDatabase(canvas.toDataURL('image/png', 1.0));
        }

        function saveToDatabase(base64Image) {
            const name = document.getElementById('user-name').value;
            const phone = document.getElementById('user-phone').value;
            const email = document.getElementById('user-email').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: 'Menyimpan Foto...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch("{{ route('photobooth.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        org_code: "{{ $photobooth->org_code }}",
                        name: name,
                        phone: phone,
                        email: email,
                        image_data: base64Image,
                        single_images: framedPhotos
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const shareUrl = data.share_url;

                        Swal.fire({
                            title: 'Berhasil Disimpan!',
                            html: `
                            <p style="font-size:0.85rem; color:#555;">Scan QR Code untuk ambil foto:</p>
                            <div class="qrcode-swal-container">
                                <div id="swal-qrcode"></div>
                            </div>
                            <p style="margin-top:10px;">Pastika barcode nya sudah di scan lalu Klik Selesai</p>
                        `,
                            icon: 'success',
                            confirmButtonText: 'OK / Selesai',
                            didOpen: () => {
                                const qrContainer = document.getElementById("swal-qrcode");
                                if (qrContainer) {
                                    qrContainer.innerHTML = '';
                                    new QRCode(qrContainer, {
                                        text: shareUrl,
                                        width: 160,
                                        height: 160,
                                        correctLevel: QRCode.CorrectLevel.H
                                    });
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed || result.dismiss) {
                                resetAppToStep1();
                            }
                        });

                        const tr = document.createElement('tr');
                        const qrContainerId = `qr-table-${Date.now()}`;
                        tr.innerHTML = `
                        <td>${escapeHtml(data.data.name)}</td>
                        <td><div id="${qrContainerId}"></div></td>
                    `;

                        userTableBody.appendChild(tr);
                        tableContainer.style.display = 'block';

                        const tableQrContainer = document.getElementById(qrContainerId);
                        if (tableQrContainer) {
                            tableQrContainer.innerHTML = ``;
                            new QRCode(tableQrContainer, {
                                text: shareUrl,
                                width: 50,
                                height: 50
                            });
                        }
                    } else {
                        Swal.fire('Gagal!', data.message || 'Gagal menyimpan.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error Detail:', error);
                    Swal.fire('Error!', 'Gagal menghubungkan ke server: ' + error.message, 'error');
                });
        }

        function resetAppToStep1() {
            document.getElementById('user-name').value = '';
            document.getElementById('user-phone').value = '';
            document.getElementById('user-email').value = '';

            stopCamera();
            resetBoothState();

            stepBooth.style.display = 'none';
            step2Frame.style.display = 'none';
            step1Form.style.display = 'block';

            tableContainer.style.display = 'none';
            userTableBody.innerHTML = '';
        }

        function escapeHtml(text) {
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }
    </script>
</body>

</html>
