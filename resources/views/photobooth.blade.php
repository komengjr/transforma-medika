<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Web Photobooth Laravel</title>

    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- QRCode.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

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
                url('https://pustaka.bca.co.id/Promo/A2C31A68-BC10-4CBD-AB51-85474A36CC50/Detail/ImageListing/20250723_PRAMITA-LAB-SBY-thumb.jpeg') center/cover no-repeat fixed;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        header {
            padding: 10px 20px;
            text-align: center;
            flex-shrink: 0;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: bold;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            color: #ffffff;
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
            height: calc(100vh - 60px);
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

        .frame-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            max-height: 160px;
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
            height: 60px;
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
        }

        .preview-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            flex: 1;
            overflow-y: auto;
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
            margin-top: 10px;
        }
    </style>
</head>

<body onclick="triggerFullscreen()">

    <div class="fs-banner" id="fs-banner">
        📱 Klik di mana saja pada layar untuk mengaktifkan Mode **Full Screen** | Drag Bookmarklet: <a href="javascript:(function(){var el=document.documentElement;var rfs=el.requestFullscreen||el.webkitRequestFullScreen||el.mozRequestFullScreen||el.msRequestFullscreen;if(rfs){rfs.call(el);}})();" style="color:#ffeb3b" onclick="event.stopPropagation();">Photobooth Fullscreen</a>
    </div>

    <header>
        <h1>📸 Web Photobooth</h1>
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

        <!-- STEP 2: SPLIT SCREEN (FOTO KIRI, CONTROL KANAN) -->
        <div id="step-2-frame">
            <!-- SISI KIRI: KAMERA PREVIEW -->
            <div class="split-left">
                <div id="cam-container-preview" class="camera-container landscape">
                    <video id="webcam-preview" class="filter-normal" autoplay playsinline></video>
                    <img id="frame-preview-overlay" class="frame-overlay" src="" alt="Frame Overlay">
                </div>
            </div>

            <!-- SISI KANAN: OPTION FORM -->
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
                        @foreach($frames as $key => $frame)
                        <div class="frame-card {{ $key === 0 ? 'active' : '' }}"
                            data-src="{{ $frame['image'] }}"
                            onclick="selectFrame(this)">
                            <img src="{{ $frame['image'] }}" alt="{{ $frame['name'] }}">
                            <span>{{ $frame['name'] }}</span>
                        </div>
                        @endforeach
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
            <!-- SISI KIRI: KAMERA PEMOTRETAN -->
            <div class="booth-column" style="flex: 1.2;">
                <div id="cam-container-main" class="camera-container landscape">
                    <video id="webcam" class="filter-normal" autoplay playsinline></video>
                    <img id="live-frame-overlay" class="frame-overlay" src="" alt="Frame Overlay">
                    <div id="countdown" class="countdown">3</div>
                </div>
            </div>

            <!-- SISI KANAN: AKSI & PREVIEW HASIL -->
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

        function updateTotalPhotos(val) {
            totalPhotos = parseInt(val);
            renderPreviewSlots();
        }

        function renderPreviewSlots() {
            previewGallery.innerHTML = '';
            if (totalPhotos === 1) {
                previewGallery.style.gridTemplateColumns = '1fr';
            } else {
                previewGallery.style.gridTemplateColumns = 'repeat(2, 1fr)';
            }

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
            frameImageObj.src = selectedFrameSrc;
            framePreviewOverlay.src = selectedFrameSrc;
            liveOverlay.src = selectedFrameSrc;
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

        function captureFramedPhoto(index) {
            playShutterSound();

            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = photoWidth;
            tempCanvas.height = photoHeight;
            const tempCtx = tempCanvas.getContext('2d');

            const filterStyles = getComputedStyle(videoMain).filter;
            tempCtx.filter = filterStyles !== 'none' ? filterStyles : 'none';

            tempCtx.translate(photoWidth, 0);
            tempCtx.scale(-1, 1);
            tempCtx.drawImage(videoMain, 0, 0, photoWidth, photoHeight);
            tempCtx.restore();

            tempCtx.filter = 'none';
            tempCtx.drawImage(frameImageObj, 0, 0, photoWidth, photoHeight);

            const imgDataUrl = tempCanvas.toDataURL('image/png');
            framedPhotos.push(imgDataUrl);

            document.getElementById(`slot-${index}`).innerHTML = `<img src="${imgDataUrl}" alt="Pose ${index + 1}">`;
        }

        function mergePhotos() {
            if (framedPhotos.length < totalPhotos) return;

            canvas.width = photoWidth + (PADDING * 2);
            canvas.height = (photoHeight * totalPhotos) + (PADDING * (totalPhotos + 1));

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            let loadedCount = 0;

            framedPhotos.forEach((src, index) => {
                const img = new Image();
                img.src = src;
                img.onload = () => {
                    const yOffset = PADDING + index * (photoHeight + PADDING);
                    ctx.drawImage(img, PADDING, yOffset, photoWidth, photoHeight);
                    ctx.strokeStyle = BORDER_COLOR;
                    ctx.lineWidth = BORDER_WIDTH;
                    ctx.strokeRect(PADDING, yOffset, photoWidth, photoHeight);

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
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
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
              <div class="qrcode-swal-container"><div id="swal-qrcode"></div></div>
              <p style="margin-top:10px;"><a href="${shareUrl}" target="_blank" style="color:#2196F3;">Buka Link Direct</a></p>
            `,
                            icon: 'success',
                            confirmButtonText: 'OK / Selesai',
                            didOpen: () => {
                                new QRCode(document.getElementById("swal-qrcode"), {
                                    text: shareUrl,
                                    width: 160,
                                    height: 160
                                });
                            }
                        }).then((result) => {
                            // MERESET APLIKASI TANPA RELOAD SUPAYA FULLSCREEN TETAP AKTIF
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

                        new QRCode(document.getElementById(qrContainerId), {
                            text: shareUrl,
                            width: 50,
                            height: 50
                        });

                    } else {
                        Swal.fire('Gagal!', data.message || 'Gagal menyimpan.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Gagal menghubungkan ke server.', 'error');
                });
        }

        /* FUNGSI UNTUK RESET KE STEP 1 TANPA PUTUS FULLSCREEN */
        function resetAppToStep1() {
            // 1. Kosongkan Form Input
            document.getElementById('user-name').value = '';
            document.getElementById('user-phone').value = '';
            document.getElementById('user-email').value = '';

            // 2. Matikan Koneksi Kamera & Reset State Booth
            stopCamera();
            resetBoothState();

            // 3. Kembalikan Tampilan ke Step 1
            stepBooth.style.display = 'none';
            step2Frame.style.display = 'none';
            step1Form.style.display = 'block';

            // 4. Bersihkan Tabel QR Code Sementara
            tableContainer.style.display = 'none';
            userTableBody.innerHTML = '';
        }

        function escapeHtml(text) {
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }
    </script>
</body>

</html>
