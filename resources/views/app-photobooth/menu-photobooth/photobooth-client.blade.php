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
            padding: 10px 20px;
            text-align: center;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .header-logo {
            height: 50px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        h1 {
            font-size: 1.8rem;
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
            height: calc(100vh - 100px);
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
            max-width: 1200px;
            gap: 20px;
        }

        .split-left {
            flex: 1.2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .split-right {
            flex: 1;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 20px;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
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

        .layout-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 4px;
        }

        .layout-card {
            padding: 8px 4px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            background: #fff;
            text-align: center;
            color: #333;
            font-weight: 600;
            font-size: 0.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .layout-card:hover {
            border-color: #ff4081;
        }

        .layout-card.active {
            border-color: #ff4081;
            background: #fff0f5;
        }

        .layout-card.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            border-color: #ddd !important;
            background: #f5f5f5 !important;
        }

        .layout-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .frame-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            max-height: 120px;
            overflow-y: auto;
            padding-right: 5px;
            margin-bottom: 10px;
        }

        .frame-card {
            padding: 6px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            background: #fff;
            text-align: center;
            color: #333;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .frame-card img {
            width: 100%;
            height: 50px;
            object-fit: contain;
            border-radius: 4px;
            margin-bottom: 4px;
        }

        .frame-card.active {
            border-color: #ff4081;
            background: #fff0f5;
        }

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
            font-size: 6rem;
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

        /* --- STYLES UNTUK QR CODE DI MOBILE & CEGAH DOUBLE --- */
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
            <button class="btn" onclick="submitFormStep1()">Lanjut ke Pengaturan</button>
        </div>

        <!-- STEP 2: SPLIT SCREEN -->
        <div id="step-2-frame">
            <div class="split-left">
                <div id="cam-container-preview" class="camera-container landscape">
                    <video id="webcam-preview" class="filter-normal" autoplay playsinline></video>
                    <img id="frame-preview-overlay" class="frame-overlay" src="" alt="Frame Overlay">
                </div>
            </div>

            <div class="split-right">
                <div>
                    <h3 style="margin-bottom: 10px; color: #ff4081; text-align: center;">Langkah 2: Pengaturan</h3>

                    <div class="form-group">
                        <label for="camera-orientation">Orientasi Kamera / Foto:</label>
                        <select id="camera-orientation" onchange="updateOrientation(this.value)">
                            <option value="landscape" selected>Landscape (4:3)</option>
                            <option value="portrait">Portrait (3:4)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="photo-count">Jumlah Pose / Jepretan:</label>
                        <select id="photo-count" onchange="updateTotalPhotos(this.value)">
                            <option value="1">1 Jepretan (Single Photo)</option>
                            <option value="2">2 Jepretan</option>
                            <option value="3">3 Jepretan</option>
                            <option value="4" selected>4 Jepretan (Photo Strip)</option>
                        </select>
                    </div>

                    <div class="form-group" id="layout-group">
                        <label>Tata Letak Hasil Gabungan:</label>
                        <div class="layout-options">
                            <div class="layout-card active" data-layout="vertical" onclick="selectLayout(this)">
                                <div class="layout-icon">
                                    <svg width="30" height="38" viewBox="0 0 30 38" fill="none">
                                        <rect x="2" y="2" width="26" height="10" rx="2" fill="#ff4081" stroke="#333" stroke-width="1.5" />
                                        <rect x="2" y="14" width="26" height="10" rx="2" fill="#ff4081" stroke="#333" stroke-width="1.5" />
                                        <rect x="2" y="26" width="26" height="10" rx="2" fill="#ff4081" stroke="#333" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <span>Atas - Bawah</span>
                            </div>

                            <div class="layout-card" data-layout="horizontal" onclick="selectLayout(this)">
                                <div class="layout-icon">
                                    <svg width="40" height="28" viewBox="0 0 40 28" fill="none">
                                        <rect x="2" y="2" width="10" height="24" rx="2" fill="#2196F3" stroke="#333" stroke-width="1.5" />
                                        <rect x="15" y="2" width="10" height="24" rx="2" fill="#2196F3" stroke="#333" stroke-width="1.5" />
                                        <rect x="28" y="2" width="10" height="24" rx="2" fill="#2196F3" stroke="#333" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <span>Kiri - Kanan</span>
                            </div>

                            <div class="layout-card" data-layout="grid" id="layout-grid-card" onclick="selectLayout(this)">
                                <div class="layout-icon">
                                    <svg width="34" height="34" viewBox="0 0 34 34" fill="none">
                                        <rect x="2" y="2" width="13" height="13" rx="2" fill="#4CAF50" stroke="#333" stroke-width="1.5" />
                                        <rect x="19" y="2" width="13" height="13" rx="2" fill="#4CAF50" stroke="#333" stroke-width="1.5" />
                                        <rect x="2" y="19" width="13" height="13" rx="2" fill="#4CAF50" stroke="#333" stroke-width="1.5" />
                                        <rect x="19" y="19" width="13" height="13" rx="2" fill="#4CAF50" stroke="#333" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <span>Grid (2x2)</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="camera-filter">Pilih Filter Kamera:</label>
                        <select id="camera-filter" onchange="applyFilter(this.value)">
                            <option value="filter-normal">Normal</option>
                            <option value="filter-grayscale">Hitam Putih (Grayscale)</option>
                            <option value="filter-sepia">Sepia (Klasik)</option>
                            <option value="filter-vintage">Vintage / Retro</option>
                            <option value="filter-bright">Bright & Contrast</option>
                            <option value="filter-cool">Cool Blue</option>
                        </select>
                    </div>

                    <label style="display: block; margin-bottom: 6px; font-size: 0.85rem; font-weight: 600; color: #444;">Pilih Frame Layout:</label>
                    <div class="frame-options">
                        @forelse($photobooth->frames as $key => $frame)
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
                        <div class="text-muted small">Belum ada frame yang diupload.</div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <button class="btn" onclick="goToStep3Booth()">Mulai Sesi Foto</button>
                    <button class="btn btn-secondary" onclick="backToStep1()">Kembali ke Form</button>
                </div>
            </div>
        </div>

        <!-- STEP 3: PEMOTRETAN -->
        <div id="step-booth">
            <div class="booth-column" style="flex: 1.2;">
                <div id="cam-container-main" class="camera-container landscape">
                    <video id="webcam" class="filter-normal" autoplay playsinline></video>
                    <img id="live-frame-overlay" class="frame-overlay" src="" alt="Frame Overlay">
                    <div id="countdown" class="countdown">3</div>
                </div>
            </div>

            <div class="booth-column" style="flex: 1;">
                <div class="preview-section">
                    <h4 id="preview-title" style="margin-bottom: 8px; color: #ff4081; text-align: center;">Hasil Jepretan</h4>
                    <div class="preview-gallery" id="preview-gallery"></div>

                    <div style="margin-top: 10px;">
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

        const videoPreview = document.getElementById('webcam-preview');
        const videoMain = document.getElementById('webcam');

        const camContainerPreview = document.getElementById('cam-container-preview');
        const camContainerMain = document.getElementById('cam-container-main');

        const framePreviewOverlay = document.getElementById('frame-preview-overlay');
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
        let totalPhotos = 4;
        let selectedLayout = 'vertical';
        let photoWidth = 600,
            photoHeight = 450;
        const PADDING = 20,
            BORDER_COLOR = '#ffffff',
            BORDER_WIDTH = 6;

        let mediaStream = null;
        let selectedFrameSrc = document.querySelector('.frame-card.active')?.getAttribute('data-src') || '';
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

            camContainerPreview.classList.remove('landscape', 'portrait');
            camContainerMain.classList.remove('landscape', 'portrait');

            camContainerPreview.classList.add(mode);
            camContainerMain.classList.add(mode);

            if (mode === 'portrait') {
                photoWidth = 450;
                photoHeight = 600;
            } else {
                photoWidth = 600;
                photoHeight = 450;
            }
        }

        function selectLayout(element) {
            if (element.classList.contains('disabled')) return;

            document.querySelectorAll('.layout-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');
            selectedLayout = element.getAttribute('data-layout');
        }

        function updateTotalPhotos(val) {
            totalPhotos = parseInt(val);
            renderPreviewSlots();

            const gridCard = document.getElementById('layout-grid-card');
            const verticalCard = document.querySelector('.layout-card[data-layout="vertical"]');

            if (totalPhotos < 4) {
                gridCard.classList.add('disabled');
                if (selectedLayout === 'grid') {
                    selectLayout(verticalCard);
                }
            } else {
                gridCard.classList.remove('disabled');
            }
        }

        function renderPreviewSlots() {
            previewGallery.innerHTML = '';

            previewTitle.innerText = `Hasil Jepretan (${totalPhotos} Pose)`;
            startBtn.innerText = `Mulai Foto (${totalPhotos} Pose)`;

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
            videoPreview.className = filterClass;
            videoMain.className = filterClass;
        }

        async function submitFormStep1() {
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

            Swal.fire({
                title: 'Memuat Kamera...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                await startCamera();
                Swal.close();

                step1Form.style.display = 'none';
                step2Frame.style.display = 'flex';

                videoPreview.srcObject = mediaStream;
                updateOrientation(currentOrientation);
                updateFrameOverlay();
                renderPreviewSlots();

            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Gagal',
                    text: err.message
                });
            }
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
            updateFrameOverlay();
        }

        function updateFrameOverlay() {
            if (selectedFrameSrc) {
                frameImageObj.src = selectedFrameSrc;
                framePreviewOverlay.src = selectedFrameSrc;
                liveOverlay.src = selectedFrameSrc;
            }
        }

        function goToStep3Booth() {
            if (!selectedFrameSrc) {
                Swal.fire('Perhatian', 'Silakan pilih frame terlebih dahulu!', 'warning');
                return;
            }

            step2Frame.style.display = 'none';
            stepBooth.style.display = 'flex';

            videoMain.srcObject = mediaStream;
            resetBoothState();
        }

        function backToStep2() {
            resetBoothState();
            stepBooth.style.display = 'none';
            step2Frame.style.display = 'flex';
            videoPreview.srcObject = mediaStream;
        }

        async function startCamera() {
            if (!mediaStream) {
                mediaStream = await navigator.mediaDevices.getUserMedia({
                    video: true,
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
                await runCountdown(3);
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

        /* PERBAIKAN DI BAGIAN INI: Menghapus translate & scaleX(-1) */
        function captureFramedPhoto(index) {
            playShutterSound();

            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = photoWidth;
            tempCanvas.height = photoHeight;
            const tempCtx = tempCanvas.getContext('2d');

            const filterStyles = getComputedStyle(videoMain).filter;
            tempCtx.filter = filterStyles !== 'none' ? filterStyles : 'none';

            // Gambar video langsung dalam kondisi normal (sesuai posisi asli/aslinya)
            tempCtx.drawImage(videoMain, 0, 0, photoWidth, photoHeight);

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

            let cols = 1;
            let rows = totalPhotos;

            if (selectedLayout === 'horizontal') {
                cols = totalPhotos;
                rows = 1;
            } else if (selectedLayout === 'grid' && totalPhotos >= 4) {
                cols = 2;
                rows = Math.ceil(totalPhotos / 2);
            } else {
                cols = 1;
                rows = totalPhotos;
            }

            canvas.width = (photoWidth * cols) + (PADDING * (cols + 1));
            canvas.height = (photoHeight * rows) + (PADDING * (rows + 1));

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            let loadedCount = 0;

            framedPhotos.forEach((src, index) => {
                const img = new Image();
                img.src = src;
                img.onload = () => {
                    const colIndex = index % cols;
                    const rowIndex = Math.floor(index / cols);

                    const xOffset = PADDING + colIndex * (photoWidth + PADDING);
                    const yOffset = PADDING + rowIndex * (photoHeight + PADDING);

                    ctx.drawImage(img, xOffset, yOffset, photoWidth, photoHeight);
                    ctx.strokeStyle = BORDER_COLOR;
                    ctx.lineWidth = BORDER_WIDTH;
                    ctx.strokeRect(xOffset, yOffset, photoWidth, photoHeight);

                    loadedCount++;
                    if (loadedCount === totalPhotos) {
                        saveToDatabase(canvas.toDataURL('image/png'));
                    }
                };
            });
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
                                <p style="margin-top:10px;"><a href="${shareUrl}" target="_blank" style="color:#2196F3; font-weight:bold;">Buka Link Direct</a></p>
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

                        // Tabel Riwayat Hasil
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
