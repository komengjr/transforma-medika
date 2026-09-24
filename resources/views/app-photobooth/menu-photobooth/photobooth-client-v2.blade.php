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
            overflow: hidden;
        }

        .split-right>div:first-child {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
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
            flex: 1;
            min-height: 140px;
            max-height: 100%;
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
            position: relative;
        }

        .frame-card img {
            width: 100%;
            height: 55px;
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

        .frame-preview-box {
            position: relative;
            width: 100%;
            height: 100%;
            max-height: 80vh;
            background: #111;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 4px solid #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .frame-preview-box.landscape {
            aspect-ratio: 4 / 3;
        }

        .frame-preview-box.portrait {
            aspect-ratio: 3 / 4;
            width: auto;
        }

        .frame-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
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
            min-height: 100px;
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
            <button class="btn" onclick="submitFormStep1()">Lanjut ke Pengaturan Frame</button>
        </div>

        <!-- STEP 2: SPLIT SCREEN (PILIH FRAME & FILTER) -->
        <div id="step-2-frame">
            <div class="split-left">
                <div id="frame-preview-container" class="frame-preview-box portrait">
                    <img id="static-frame-preview" src="" alt="Preview Frame">
                </div>
            </div>

            <div class="split-right">
                <div>
                    <h3 style="margin-bottom: 10px; color: #ff4081; text-align: center;">Langkah 2: Pengaturan</h3>

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
                <div id="dynamic-camera-wrapper" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; position: relative;">
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

        const staticFramePreview = document.getElementById('static-frame-preview');
        const framePreviewContainer = document.getElementById('frame-preview-container');
        const dynamicCameraWrapper = document.getElementById('dynamic-camera-wrapper');

        const canvas = document.getElementById('photo-strip');
        const ctx = canvas.getContext('2d');
        const countdownEl = document.createElement('div');
        countdownEl.id = 'countdown';
        countdownEl.className = 'countdown';
        countdownEl.innerText = '3';

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

        // FUNGSI UTAMA: Otomatis mendeteksi lubang Transparan pada gambar Frame PNG
        // FUNGSI UTAMA: Otomatis mendeteksi lubang tempat foto pada frame baru Anda
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

                    // Mendeteksi area transparan ATAU area putih polos sebagai lubang foto
                    // (Karena pada gambar Anda lubangnya tampak berwarna putih bersih)
                    let isTransparent = a < 50;
                    let isWhiteArea = (r > 240 && g > 240 && b > 240 && a > 200);

                    if (isTransparent || isWhiteArea) {
                        mask[p] = 1;
                        // Jika menggunakan area putih, kita bisa membuatnya transparan di canvas utama
                        // agar foto di belakangnya terlihat dengan sempurna
                        if (isWhiteArea) {
                            data[i + 3] = 0;
                        }
                    } else {
                        mask[p] = 0;
                    }
                }

                // Perbarui data canvas jika ada area putih yang diubah jadi transparan
                cx.putImageData(imgData, 0, 0);
                transparentFrameDataUrl = c.toDataURL('image/png');

                let visited = new Uint8Array(width * height);
                let rawBoxes = [];

                // Algoritma pembacaan area lubang
                for (let y = 0; y < height; y += 4) {
                    for (let x = 0; x < width; x += 4) {
                        let p = y * width + x;
                        if (mask[p] === 1 && visited[p] === 0) {
                            let rx = x;
                            while (rx < width && mask[y * width + rx] === 1) rx++;
                            let rWidth = rx - x;

                            let ry = y;
                            while (ry < height && mask[ry * width + x] === 1) ry++;
                            let rHeight = ry - y;

                            // Batas minimum ukuran lubang foto
                            if (rWidth > 100 && rHeight > 100) {
                                for (let fy = y; fy < y + rHeight; fy += 4) {
                                    for (let fx = x; fx < x + rWidth; fx += 4) {
                                        visited[fy * width + fx] = 1;
                                    }
                                }
                                rawBoxes.push({
                                    x: x,
                                    y: y,
                                    width: rWidth,
                                    height: rHeight
                                });
                            }
                        }
                    }
                }

                // Urutkan posisi lubang dari atas ke bawah
                rawBoxes.sort((a, b) => a.y - b.y);

                greenSlots = rawBoxes.slice(0, 2).map(box => {
                    let isLandscape = box.width > box.height;
                    return {
                        ...box,
                        orientation: isLandscape ? 'landscape' : 'portrait'
                    };
                });

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
            document.querySelectorAll('.frame-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');

            selectedFrameSrc = element.getAttribute('data-src');
            staticFramePreview.src = selectedFrameSrc;

            analyzeFrameImage(selectedFrameSrc, (slots) => {
                renderPreviewSlots();
            });
        }

        function renderCameraForSlot(slotIndex) {
            dynamicCameraWrapper.innerHTML = '';

            const currentSlot = greenSlots[slotIndex];
            const slotOrientation = currentSlot ? currentSlot.orientation : 'portrait';

            framePreviewContainer.classList.remove('landscape', 'portrait');
            framePreviewContainer.classList.add(slotOrientation);

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
                        video: true,
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

            tempCtx.translate(pWidth, 0);
            tempCtx.scale(-1, 1);
            tempCtx.drawImage(activeVideo, sx, sy, sWidth, sHeight, 0, 0, pWidth, pHeight);

            const imgDataUrl = tempCanvas.toDataURL('image/png');
            framedPhotos.push(imgDataUrl);

            document.getElementById(`slot-${index}`).innerHTML = `<img src="${imgDataUrl}" alt="Pose ${index + 1}">`;
        }

        function mergePhotos() {
            if (framedPhotos.length < greenSlots.length) return;

            const fWidth = frameImageObj.naturalWidth || frameImageObj.width || 1200;
            const fHeight = frameImageObj.naturalHeight || frameImageObj.height || 1800;

            canvas.width = fWidth;
            canvas.height = fHeight;

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, fWidth, fHeight);

            let loadedImages = 0;
            const totalToLoad = Math.min(framedPhotos.length, greenSlots.length);

            // 1. Gambar foto-foto terlebih dahulu di lapisan bawah
            greenSlots.forEach((slot, index) => {
                if (index >= framedPhotos.length) return;

                const img = new Image();
                img.crossOrigin = "anonymous";
                img.src = framedPhotos[index];
                img.onload = () => {
                    ctx.save();

                    const slotAspect = slot.width / slot.height;
                    const imgAspect = img.width / img.height;
                    let sw, sh, sx, sy;

                    if (imgAspect > slotAspect) {
                        sh = img.height;
                        sw = img.height * slotAspect;
                        sx = (img.width - sw) / 2;
                        sy = 0;
                    } else {
                        sw = img.width;
                        sh = img.width / slotAspect;
                        sx = 0;
                        sy = (img.height - sh) / 2;
                    }

                    ctx.drawImage(img, sx, sy, sw, sh, slot.x, slot.y, slot.width, slot.height);
                    ctx.restore();

                    loadedImages++;
                    if (loadedImages === totalToLoad) {
                        drawFinalFrameAndSave(fWidth, fHeight);
                    }
                };
            });
        }

        // 2. Timpa frame PNG asli di atas foto (sehingga area transparan pada frame menampakkan foto di bawahnya)
        function drawFinalFrameAndSave(fWidth, fHeight) {
            ctx.drawImage(frameImageObj, 0, 0, fWidth, fHeight);
            saveToDatabase(canvas.toDataURL('image/png'));
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
