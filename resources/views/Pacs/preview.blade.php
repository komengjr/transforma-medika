<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>DICOM Viewer - Auto Load File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Cornerstone libraries -->
    <script src="https://cdn.jsdelivr.net/npm/cornerstone-core@latest/dist/cornerstone.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/cornerstone-wado-image-loader@4.13.2/dist/cornerstoneWADOImageLoader.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cornerstone-tools@next"></script>
    <script src="https://unpkg.com/dicom-parser@1.8.6/dist/dicomParser.min.js"></script>

    <style>
        body {
            background: #0f172a;
            color: white;
        }

        .viewer-container {
            width: 100%;
            height: 85vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .dicom-view {
            width: 95%;
            height: 100%;
            background-color: #1e293b;
            border: 1px solid #334155;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .toolbar {
            background-color: #1e293b;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }

        .toolbar button {
            margin: 3px;
            border-radius: 8px;
        }

        .slice-label {
            position: absolute;
            bottom: 5px;
            right: 8px;
            font-size: 13px;
            color: #cbd5e1;
            background: rgba(0, 0, 0, 0.4);
            padding: 3px 6px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-3">
        <h3 class="text-center text-info fw-bold">🩻 DICOM Viewer - Auto Load</h3>

        <div class="toolbar mt-3">
            <button class="btn btn-sm btn-outline-light" onclick="setTool('Zoom')">Zoom</button>
            <button class="btn btn-sm btn-outline-light" onclick="setTool('Pan')">Pan</button>
            <button class="btn btn-sm btn-outline-light" onclick="setTool('Wwwc')">Kontras Manual</button>
            <button class="btn btn-sm btn-outline-warning" onclick="autoWindow()">Auto Kontras</button>
            <button class="btn btn-sm btn-outline-light" onclick="invertImage()">Invert</button>
            <button class="btn btn-sm btn-outline-danger" onclick="resetView()">Reset</button>
        </div>

        <div class="viewer-container">
            <div id="dicomView" class="dicom-view">
                <span class="slice-label" id="sliceLabel"></span>
            </div>
        </div>
    </div>

    <script>
        cornerstoneWADOImageLoader.external.cornerstone = cornerstone;
        cornerstoneWADOImageLoader.configure({ useWebWorkers: true });

        const element = document.getElementById("dicomView");
        cornerstone.enable(element);

        const tools = cornerstoneTools;
        tools.init();

        const mouseToolPairs = {
            Zoom: tools.ZoomTool,
            Pan: tools.PanTool,
            Wwwc: tools.WwwcTool
        };

        let activeTool = null, inverted = false;
        let stack = { imageIds: [], currentImageIdIndex: 0 };

        // ========================
        // KONFIGURASI AUTO LOAD
        // ========================
        // Ganti URL di bawah ini sesuai lokasi file DICOM kamu.
        // Bisa juga daftar array untuk multi-slice:
        const dicomFiles = [
            '/digital/1.2.392.200036.9125.9.0.3827827802.218649148.1753351843',
            // '/digital/1.3.6.1.4.1.19179.2.1124211101284520.3.9845.2312',
            // '/digital/1.3.6.1.4.1.19179.2.1124211101284520.3.15866.2316'
        ];

        // ========================

        window.onload = function () {
            loadDicomFiles(dicomFiles);
        };

        function loadDicomFiles(files) {
            stack.imageIds = files.map(f => "wadouri:" + location.origin + f);
            stack.currentImageIdIndex = 0;

            Promise.all(stack.imageIds.map(id => cornerstone.loadAndCacheImage(id))).then(() => {
                displaySlice(0);
            });

            element.addEventListener('wheel', evt => {
                evt.preventDefault();
                changeSlice(evt.deltaY > 0 ? 1 : -1);
            });

            document.addEventListener('keydown', e => {
                if (e.key === "ArrowUp") changeSlice(-1);
                if (e.key === "ArrowDown") changeSlice(1);
            });
        }

        function displaySlice(index) {
            if (stack.imageIds.length === 0) return;
            stack.currentImageIdIndex = Math.max(0, Math.min(index, stack.imageIds.length - 1));
            const imageId = stack.imageIds[stack.currentImageIdIndex];
            cornerstone.loadAndCacheImage(imageId).then(image => {
                cornerstone.displayImage(element, image);
                cornerstone.fitToWindow(element);
                updateSliceLabel();
            });
        }

        function changeSlice(delta) {
            displaySlice(stack.currentImageIdIndex + delta);
        }

        function updateSliceLabel() {
            document.getElementById('sliceLabel').textContent =
                `Slice ${stack.currentImageIdIndex + 1}/${stack.imageIds.length}`;
        }

        function setTool(name) {
            if (!stack.imageIds.length) return alert("File belum dimuat!");
            tools.addTool(mouseToolPairs[name]);
            tools.setToolActive(name, { mouseButtonMask: 1 });
            activeTool = name;
        }

        function invertImage() {
            if (!stack.imageIds.length) return;
            inverted = !inverted;
            const vp = cornerstone.getViewport(element);
            vp.invert = inverted;
            cornerstone.setViewport(element, vp);
        }

        function resetView() {
            if (!stack.imageIds.length) return;
            cornerstone.reset(element);
            inverted = false;
            displaySlice(0);
        }

        // === AUTO WINDOW LEVEL (Histogram-based) ===
        function autoWindow() {
            if (!stack.imageIds.length) return alert("File belum dimuat!");
            const imageId = stack.imageIds[stack.currentImageIdIndex];
            cornerstone.loadAndCacheImage(imageId).then(image => {
                const pixelData = image.getPixelData();
                const sorted = Array.from(pixelData).sort((a, b) => a - b);
                const n = sorted.length;
                const min = sorted[Math.floor(n * 0.02)];
                const max = sorted[Math.floor(n * 0.98)];
                const center = (min + max) / 2;
                const width = (max - min);

                const vp = cornerstone.getViewport(element);
                vp.voi.windowCenter = center;
                vp.voi.windowWidth = width;
                cornerstone.setViewport(element, vp);
            });
        }
    </script>
</body>

</html>
