<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> DICOM Viewer - Innoventra </title>
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
            cursor: grab;
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
        <h3 class="text-center text-info fw-bold">🩻 DICOM Viewer - {{ env('APP_NAME')}}</h3>

        <div class="toolbar mt-3">
            <button class="btn btn-sm btn-outline-light d-none" onclick="setTool('Wwwc')">Kontras Manual</button>
            <button class="btn btn-sm btn-outline-light d-none" onclick="setTool('Zoom')">Zoom Tool</button>
            <button class="btn btn-sm btn-outline-light" onclick="setTool('Pan')">🖐️ Hand Move</button>
            <button class="btn btn-sm btn-outline-warning" onclick="autoWindow()">Auto Kontras</button>
            <button class="btn btn-sm btn-outline-info" onclick="zoomIn()">🔍 Zoom In</button>
            <button class="btn btn-sm btn-outline-info" onclick="zoomOut()">🔎 Zoom Out</button>
            <button class="btn btn-sm btn-outline-light" onclick="invertImage()">Invert</button>
            <button class="btn btn-sm btn-outline-danger" onclick="resetView()">Reset</button>
            <button class="btn btn-sm btn-outline-success" onclick="exportPNG()">Export PNG</button>
            <button class="btn btn-sm btn-outline-warning" onclick="printImage()">Print</button>
        </div>

        <div class="viewer-container">
            <div id="dicomView" class="dicom-view">
                <span class="slice-label" id="sliceLabel"></span>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('sliceLabel').innerHTML = '<div class="spinner-border m-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>';
        cornerstoneWADOImageLoader.external.cornerstone = cornerstone;
        cornerstoneWADOImageLoader.configure({ useWebWorkers: true });

        const element = document.getElementById("dicomView");
        cornerstone.enable(element);

        const tools = cornerstoneTools;
        tools.init();
        // REGISTER & ACTIVATE TOOLS (recommended)
        cornerstoneTools.addTool(cornerstoneTools.PanTool);
        cornerstoneTools.addTool(cornerstoneTools.ZoomTool);
        cornerstoneTools.addTool(cornerstoneTools.WwwcTool);

        // Default: set Pan tool to left mouse button when user clicks Pan button
        function setTool(name) {
            if (!stack.imageIds.length) return alert("File belum dimuat!");
            // name: 'Pan' | 'Zoom' | 'Wwwc'
            if (name === 'Pan') {
                cornerstoneTools.setToolActive('Pan', { mouseButtonMask: 1 }); // left mouse
            } else if (name === 'Zoom') {
                cornerstoneTools.setToolActive('Zoom', { mouseButtonMask: 1 });
            } else if (name === 'Wwwc') {
                cornerstoneTools.setToolActive('Wwwc', { mouseButtonMask: 1 });
            }
            // cursor visual
            element.style.cursor = (name === 'Pan') ? 'grab' : 'default';
        }

        const mouseToolPairs = {
            Wwwc: tools.WwwcTool,
            Zoom: tools.ZoomTool,
            Pan: tools.PanTool, // ini untuk hand tool (move)
        };

        let inverted = false;
        let stack = { imageIds: [], currentImageIdIndex: 0 };

        // ========================
        // KONFIGURASI AUTO LOAD
        // ========================
        // Ganti URL di bawah ini sesuai lokasi file DICOM kamu
        const dicomFiles = [
            '/digital/1.2.392.200036.9125.9.0.3827876910.17322556.1753351843',
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
            element.style.cursor = name === "Pan" ? "grab" : "default";
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

        // === ZOOM IN / OUT ===
        function zoomIn() {
            const vp = cornerstone.getViewport(element);
            vp.scale *= 1.2;
            cornerstone.setViewport(element, vp);
        }

        function zoomOut() {
            const vp = cornerstone.getViewport(element);
            vp.scale /= 1.2;
            cornerstone.setViewport(element, vp);
        }
        // FALLBACK MANUAL PAN (hand move) — reliable
        let handMode = false;
        let isHandDown = false;
        let lastMouse = { x: 0, y: 0 };

        function enableHandMode(enable) {
            handMode = !!enable;
            element.style.cursor = handMode ? 'grab' : 'default';
        }

        // update setTool to toggle handMode when Pan requested
        function setTool(name) {
            if (!stack.imageIds.length) return alert("File belum dimuat!");
            if (name === 'Pan') {
                // prefer cornerstoneTools if available
                try {
                    cornerstoneTools.setToolActive('Pan', { mouseButtonMask: 1 });
                } catch (e) {
                    // fallback to manual
                }
                enableHandMode(true);
            } else {
                enableHandMode(false);
                // set other tools
                try { cornerstoneTools.setToolActive(name, { mouseButtonMask: 1 }); } catch (e) { }
            }
        }

        // mouse handlers for manual panning
        element.addEventListener('mousedown', (evt) => {
            if (!handMode) return;
            isHandDown = true;
            lastMouse.x = evt.clientX;
            lastMouse.y = evt.clientY;
            element.style.cursor = 'grabbing';
            evt.preventDefault();
        });
        document.addEventListener('mouseup', (evt) => {
            if (!isHandDown) return;
            isHandDown = false;
            element.style.cursor = handMode ? 'grab' : 'default';
        });
        document.addEventListener('mousemove', (evt) => {
            if (!isHandDown) return;
            const dx = evt.clientX - lastMouse.x;
            const dy = evt.clientY - lastMouse.y;
            lastMouse.x = evt.clientX;
            lastMouse.y = evt.clientY;

            // update cornerstone viewport translation (in image pixels)
            const vp = cornerstone.getViewport(element);
            // translation is in canvas pixels; divide by scale to keep consistent behaviour
            vp.translation.x = (vp.translation.x || 0) + dx / (vp.scale || 1);
            vp.translation.y = (vp.translation.y || 0) + dy / (vp.scale || 1);
            cornerstone.setViewport(element, vp);
            evt.preventDefault();
        });
        // FITUR EXPORT PNG
        function exportPNG() {
            const canvas = element.querySelector('canvas');
            const link = document.createElement('a');
            link.download = 'dicom-view.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }

        // FITUR PRINT GAMBAR
        function printImage() {
            const canvas = element.querySelector('canvas');
            const imgData = canvas.toDataURL('image/png');
            const win = window.open('', '_blank');
            win.document.write(`
        <html>
          <head><title>Print DICOM Image</title></head>
          <body style="margin:0;display:flex;justify-content:center;align-items:center;background:black;">
            <img src="${imgData}" style="max-width:100%;max-height:100vh;"/>
            <script>window.print();<\/script>
          </body>
        </html>
      `);
            win.document.close();
        }
    </script>
</body>

</html>
