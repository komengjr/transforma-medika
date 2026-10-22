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
            background: linear-gradient(135deg, rgba(106, 17, 203, 0.75), rgba(37, 117, 252, 0.75), rgba(255, 64, 129, 0.75)),
            url('{{ $bgUrl }}') center/cover no-repeat fixed;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        header {
            padding: 10px 20px;
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

        .form-group {
            margin-bottom: 12px;
        }

        .form-group label {
            display: block;
            margin-bottom: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 2px solid #ddd;
            background: #f9f9f9;
            color: #333;
            font-size: 0.9rem;
        }

        /* --- STEP 2: CAROUSEL PILIH FRAME --- */
        #step-2-frame {
            display: none;
            width: 100%;
            height: 100%;
            max-width: 1200px;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .step2-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 10px 20px;
        }

        .step2-title {
            font-size: 1.8rem;
            font-weight: 700;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .filter-select-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(0, 0, 0, 0.4);
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .filter-select-wrapper select {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 0.9rem;
            outline: none;
            cursor: pointer;
        }

        .filter-select-wrapper select option {
            background: #333;
            color: #fff;
        }

        .carousel-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            flex: 1;
            position: relative;
            gap: 15px;
            padding: 20px 0;
        }

        .nav-arrow {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            user-select: none;
        }

        .nav-arrow:hover {
            background: #ff4081;
            border-color: #ff4081;
            transform: scale(1.15);
        }

        .frame-carousel {
            display: flex;
            align-items: center;
            gap: 25px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 40px 20px;
            width: 100%;
            scrollbar-width: none;
        }

        .frame-carousel::-webkit-scrollbar {
            display: none;
        }

        .frame-card {
            flex: 0 0 230px;
            height: 310px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            opacity: 0.55;
            transform: scale(0.88);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .frame-card:hover {
            opacity: 0.85;
            transform: scale(0.95) translateY(-5px);
        }

        .frame-card.active {
            opacity: 1;
            transform: scale(1.1) translateY(-10px);
            border: 3px solid #ff4081;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 30px rgba(255, 64, 129, 0.8), inset 0 0 15px rgba(255, 64, 129, 0.4);
            animation: pulseGlow 2s infinite alternate;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 20px rgba(255, 64, 129, 0.7);
            }

            100% {
                box-shadow: 0 0 35px rgba(255, 64, 129, 1);
            }
        }

        .frame-card img {
            width: 100%;
            height: 210px;
            object-fit: contain;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .frame-card.active img {
            transform: scale(1.05);
        }

        .frame-card span {
            font-size: 1.05rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
            margin-top: 8px;
        }

        .step2-bottom-bar {
            display: flex;
            align-items: center;
            gap: 15px;
            width: 100%;
            padding: 10px 0;
        }

        .btn-bottom-back {
            flex: 0 0 160px;
            background: rgba(20, 20, 30, 0.8);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            padding: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-bottom-back:hover {
            background: rgba(40, 40, 50, 0.9);
        }

        .btn-bottom-start {
            flex: 1;
            background: linear-gradient(90deg, #ff4081, #ff6e40);
            color: white;
            border: none;
            padding: 14px 20px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(255, 64, 129, 0.5);
            transition: all 0.2s ease;
        }

        .btn-bottom-start:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(255, 64, 129, 0.7);
        }

        /* --- STEP 3: BOOTH --- */
        #step-booth {
            display: none;
            width: 100%;
            height: 100%;
            max-width: 1200px;
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
            transition: all 0.3s ease;
        }

        .camera-container.landscape {
            width: 100%;
            height: 100%;
            max-height: 80vh;
            aspect-ratio: 4 / 3;
        }

        .camera-container.portrait {
            height: 100%;
            max-height: 80vh;
            aspect-ratio: 3 / 4;
            width: auto;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
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

        .frame-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            object-fit: fill;
        }

        .countdown {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 8rem;
            font-weight: bold;
            color: #ffeb3b;
            text-shadow: 0 0 20px rgba(0, 0, 0, 0.9);
            display: none;
            z-index: 10;
        }

        .preview-section {
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 16px;
            color: #333;
            display: flex;
            flex-direction: column;
            max-height: 80vh;
        }

        .preview-gallery {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
            overflow-y: auto;
            padding-right: 5px;
        }

        .preview-item {
            background: #f0f0f0;
            border: 2px dashed #bbb;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #888;
            font-size: 0.9rem;
            font-weight: bold;
            min-height: 120px;
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
            margin-top: 10px;
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            display: none;
            max-height: 120px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            text-align: left;
        }

        th,
        td {
            padding: 4px;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            background: linear-gradient(45deg, #ff4081, #ff6e40);
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            width: 100%;
            margin-top: 5px;
            box-shadow: 0 4px 15px rgba(255, 64, 129, 0.4);
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:disabled {
            background: #bbb;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-secondary {
            background: #666;
            font-size: 0.85rem;
            padding: 8px 15px;
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

        .qrcode-swal-container canvas,
        [id^="qr-table-"] canvas {
            display: none !important;
        }

        .qrcode-swal-container img,
        [id^="qr-table-"] img {
            display: block !important;
            margin: 0 auto !important;
            max-width: 100% !important;
            height: auto !important;
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
            <div class="form-group">
                <label for="user-name">Nama Lengkap:</label>
                <input type="text" id="user-name" placeholder="Masukkan nama Anda">
            </div>
            <div class="form-group">
                <label for="user-phone">Nomor HP / WhatsApp:</label>
                <input type="tel" id="user-phone" placeholder="Contoh: 08123456789">
            </div>
            <div class="form-group">
                <label for="user-email">Email:</label>
                <input type="email" id="user-email" placeholder="Contoh: user@email.com">
            </div>
            <button class="btn" onclick="submitFormStep1()">Lanjut ke Pilih Frame</button>
        </div>

        <!-- STEP 2: CAROUSEL PILIH FRAME (KAMERA BELUM AKTIF) -->
        <div id="step-2-frame">
            <div class="step2-header">
                <div class="step2-title">Pilih Frame Photobooth</div>
                <div class="filter-select-wrapper">
                    <span>Filter:</span>
                    <select id="camera-filter" onchange="applyFilter(this.value)">
                        <option value="filter-normal">Normal</option>
                        <option value="filter-grayscale">Grayscale</option>
                        <option value="filter-sepia">Sepia</option>
                        <option value="filter-vintage">Vintage</option>
                        <option value="filter-bright">Bright & Contrast</option>
                        <option value="filter-cool">Cool Blue</option>
                    </select>
                </div>
            </div>

            <div class="carousel-wrapper">
                <button class="nav-arrow" onclick="scrollCarousel(-1)">&lt;</button>

                <div class="frame-carousel" id="frameCarousel">
                    @forelse($photobooth->frames as $key => $frame)
                    @php
                    $frameUrl = str_contains($frame->frame_path, 'photobooth/')
                    ? asset('storage/' . $frame->frame_path)
                    : asset('storage/photobooth/' . $frame->frame_path);
                    @endphp
                    <div class="frame-card {{ $key === 0 ? 'active' : '' }}"
                        data-src="{{ $frameUrl }}"
                        data-orientation="{{ $frame->orientation ?? 'portrait' }}"
                        onclick="selectFrame(this)">
                        <img src="{{ $frameUrl }}" alt="{{ $frame->frame_name }}">
                        <span>{{ $frame->frame_name }}</span>
                    </div>
                    @empty
                    <div style="color: #fff; text-align: center;">Belum ada frame yang diupload.</div>
                    @endforelse
                </div>

                <button class="nav-arrow" onclick="scrollCarousel(1)">&gt;</button>
            </div>

            <div class="step2-bottom-bar">
                <button class="btn-bottom-back" onclick="backToStep1()">Kembali</button>
                <button class="btn-bottom-start" onclick="goToStep3Booth()">Mulai Sesi Foto</button>
            </div>
        </div>

        <!-- STEP 3: PEMOTRETAN (KAMERA AKTIF DI SINI & PERLUKAN KLIK UNTUK JEPRET) -->
        <div id="step-booth">
            <div class="booth-column" style="flex: 1.2;">
                <div id="cam-container-main" class="camera-container landscape">
                    <video id="webcam" class="filter-normal" autoplay playsinline></video>
                    <img id="live-frame-overlay" class="frame-overlay" src="" alt="Frame Overlay">
                    <div id="countdown" class="countdown">5</div>
                </div>
            </div>

            <div class="booth-column" style="flex: 1;">
                <div class="preview-section">
                    <h4 id="preview-title" style="margin-bottom: 8px; color: #ff4081; text-align: center;">Hasil Jepretan</h4>
                    <div class="preview-gallery" id="preview-gallery"></div>

                    <div style="margin-top: 10px;">
                        <button id="start-btn" class="btn" onclick="startPhotobooth()">Ambil Foto / Jepret</button>
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

        const videoMain = document.getElementById('webcam');
        const camContainerMain = document.getElementById('cam-container-main');
        const liveOverlay = document.getElementById('live-frame-overlay');

        const canvas = document.getElementById('photo-strip');
        const ctx = canvas.getContext('2d');
        const countdownEl = document.getElementById('countdown');

        const startBtn = document.getElementById('start-btn');
        const mergeBtn = document.getElementById('merge-btn');
        const backBtn = document.getElementById('back-btn');

        const previewGallery = document.getElementById('preview-gallery');
        const previewTitle = document.getElementById('preview-title');
        const tableContainer = document.getElementById('table-container');
        const userTableBody = document.getElementById('user-table-body');

        let currentOrientation = 'landscape';
        let totalPhotos = 1;

        let photoWidth = 1200,
            photoHeight = 900;

        const PADDING = 20,
            BORDER_COLOR = '#ffffff',
            BORDER_WIDTH = 6;

        let mediaStream = null;
        let activeFrameCard = document.querySelector('.frame-card.active');
        let selectedFrameSrc = activeFrameCard?.getAttribute('data-src') || '';
        let currentFilterClass = 'filter-normal';
        let frameImageObj = new Image();
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
            gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.08);
            noise.connect(filter);
            filter.connect(gain);
            gain.connect(audioCtx.destination);
            noise.start();
        }

        function updateOrientation(mode) {
            currentOrientation = mode;
            camContainerMain.classList.remove('landscape', 'portrait');
            camContainerMain.classList.add(mode);

            if (mode === 'portrait') {
                photoWidth = 900;
                photoHeight = 1200;
            } else {
                photoWidth = 1200;
                photoHeight = 900;
            }
        }

        function renderPreviewSlots() {
            previewGallery.innerHTML = '';
            previewTitle.innerText = `Hasil Jepretan`;
            startBtn.innerText = `Ambil Foto / Jepret`;

            for (let i = 0; i < totalPhotos; i++) {
                const slot = document.createElement('div');
                slot.className = 'preview-item';
                slot.id = `slot-${i}`;
                slot.innerText = `Pose ${i + 1}`;
                previewGallery.appendChild(slot);
            }
        }

        function applyFilter(filterClass) {
            currentFilterClass = filterClass;
            videoMain.className = filterClass;
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

            // Pindah ke Step 2 tanpa mengaktifkan kamera
            step1Form.style.display = 'none';
            step2Frame.style.display = 'flex';

            const activeCard = document.querySelector('.frame-card.active');
            if (activeCard) {
                selectFrame(activeCard);
            } else {
                updateOrientation(currentOrientation);
                updateFrameOverlay();
            }

            renderPreviewSlots();
        }

        function backToStep1() {
            step2Frame.style.display = 'none';
            step1Form.style.display = 'block';
            stopCamera();
        }

        function selectFrame(element) {
            document.querySelectorAll('.frame-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');

            selectedFrameSrc = element.getAttribute('data-src');
            const frameOrientation = element.getAttribute('data-orientation') || 'portrait';

            element.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });

            updateOrientation(frameOrientation);
            updateFrameOverlay();
        }

        function scrollCarousel(direction) {
            const carousel = document.getElementById('frameCarousel');
            carousel.scrollBy({
                left: direction * 260,
                behavior: 'smooth'
            });
        }

        function updateFrameOverlay() {
            if (selectedFrameSrc) {
                frameImageObj.src = selectedFrameSrc;
                liveOverlay.src = selectedFrameSrc;
            }
        }

        async function goToStep3Booth() {
            if (!selectedFrameSrc) {
                Swal.fire('Perhatian', 'Silakan pilih frame terlebih dahulu!', 'warning');
                return;
            }

            Swal.fire({
                title: 'Memuat Kamera...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                // Aktifkan Kamera baru di Step 3
                await startCamera();
                videoMain.srcObject = mediaStream;
                Swal.close();

                step2Frame.style.display = 'none';
                stepBooth.style.display = 'flex';

                resetBoothState();
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Gagal',
                    text: err.message
                });
            }
        }

        function backToStep2() {
            resetBoothState();
            stepBooth.style.display = 'none';
            step2Frame.style.display = 'flex';
            stopCamera(); // Matikan kamera saat kembali ke Step 2
        }

        async function startCamera() {
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

            for (let i = 0; i < totalPhotos; i++) {
                // Hitung mundur 5 detik
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

            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = photoWidth;
            tempCanvas.height = photoHeight;
            const tempCtx = tempCanvas.getContext('2d');

            const filterStyles = getComputedStyle(videoMain).filter;
            tempCtx.filter = filterStyles !== 'none' ? filterStyles : 'none';

            const videoWidth = videoMain.videoWidth || photoWidth;
            const videoHeight = videoMain.videoHeight || photoHeight;

            const videoAspect = videoWidth / videoHeight;
            const canvasAspect = photoWidth / photoHeight;

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

            tempCtx.translate(photoWidth, 0);
            tempCtx.scale(-1, 1);

            tempCtx.drawImage(
                videoMain,
                sx, sy, sWidth, sHeight,
                0, 0, photoWidth, photoHeight
            );

            tempCtx.setTransform(1, 0, 0, 1, 0, 0);
            tempCtx.filter = 'none';

            if (selectedFrameSrc) {
                tempCtx.drawImage(frameImageObj, 0, 0, photoWidth, photoHeight);
            }

            const imgDataUrl = tempCanvas.toDataURL('image/png');
            framedPhotos.push(imgDataUrl);

            document.getElementById(`slot-${index}`).innerHTML = `<img src="${imgDataUrl}" alt="Pose ${index + 1}">`;
        }

        function mergePhotos() {
            if (framedPhotos.length < totalPhotos) return;

            canvas.width = photoWidth + (PADDING * 2);
            canvas.height = photoHeight + (PADDING * 2);

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            const img = new Image();
            img.src = framedPhotos[0];
            img.onload = () => {
                ctx.drawImage(img, PADDING, PADDING, photoWidth, photoHeight);
                ctx.strokeStyle = BORDER_COLOR;
                ctx.lineWidth = BORDER_WIDTH;
                ctx.strokeRect(PADDING, PADDING, photoWidth, photoHeight);

                saveToDatabase(canvas.toDataURL('image/png'));
            };
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
                            tableQrContainer.innerHTML = '';
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
