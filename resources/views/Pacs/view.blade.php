<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DICOM Viewer - Single View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/cornerstone-core@latest/dist/cornerstone.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/cornerstone-wado-image-loader@4.13.2/dist/cornerstoneWADOImageLoader.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cornerstone-tools@next"></script>
    <script src="https://unpkg.com/dicom-parser@1.8.6/dist/dicomParser.js"></script>
    <style>
        body {
            background-color: #111;
            color: white;
            overflow: hidden;
        }

        #dicomImage {
            width: 100%;
            height: 90vh;
            background-color: black;
            border: 2px solid #444;
            position: relative;
            cursor: default;
        }

        .toolbar {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
        }
    </style>
</head>

<body>
    <div class="toolbar btn-group">
        <button class="btn btn-sm btn-outline-light" onclick="setTool('Wwwc')">Kontras</button>
        <button class="btn btn-sm btn-outline-light" onclick="setTool('Zoom')">Zoom</button>
        <button class="btn btn-sm btn-outline-light" onclick="setTool('Pan')">Pindah (Hand)</button>
        <button class="btn btn-sm btn-outline-success" onclick="exportPNG()">Export PNG</button>
        <button class="btn btn-sm btn-outline-warning" onclick="printImage()">Print</button>
    </div>

    <div id="dicomImage"></div>

    <script>
        const element = document.getElementById('dicomImage');
        cornerstone.enable(element);
        cornerstoneTools.init();

        // REGISTER TOOLS
        cornerstoneTools.addTool(cornerstoneTools.WwwcTool);
        cornerstoneTools.addTool(cornerstoneTools.ZoomTool);
        cornerstoneTools.addTool(cornerstoneTools.PanTool);
        cornerstoneTools.setToolActive('Wwwc', { mouseButtonMask: 1 });

        // AUTO LOAD DICOM (contoh pakai URL publik)
        const imageId = "https://cornerstonejs.org/assets/dicom/cat.dcm";
        cornerstone.loadImage(imageId).then(image => {
            cornerstone.displayImage(element, image);
        });

        // FUNGSI SET TOOL
        let handMode = false;
        let isHandDown = false;
        let lastMouse = { x: 0, y: 0 };

        function setTool(name) {
            if (name === 'Pan') {
                cornerstoneTools.setToolActive('Pan', { mouseButtonMask: 1 });
                handMode = true;
                element.style.cursor = 'grab';
            } else if (name === 'Zoom') {
                cornerstoneTools.setToolActive('Zoom', { mouseButtonMask: 1 });
                handMode = false;
                element.style.cursor = 'zoom-in';
            } else {
                cornerstoneTools.setToolActive('Wwwc', { mouseButtonMask: 1 });
                handMode = false;
                element.style.cursor = 'default';
            }
        }

        // FALLBACK MANUAL PAN
        element.addEventListener('mousedown', evt => {
            if (!handMode) return;
            isHandDown = true;
            lastMouse.x = evt.clientX;
            lastMouse.y = evt.clientY;
            element.style.cursor = 'grabbing';
            evt.preventDefault();
        });
        document.addEventListener('mouseup', () => {
            isHandDown = false;
            if (handMode) element.style.cursor = 'grab';
        });
        document.addEventListener('mousemove', evt => {
            if (!isHandDown) return;
            const dx = evt.clientX - lastMouse.x;
            const dy = evt.clientY - lastMouse.y;
            lastMouse.x = evt.clientX;
            lastMouse.y = evt.clientY;
            const vp = cornerstone.getViewport(element);
            vp.translation.x += dx / vp.scale;
            vp.translation.y += dy / vp.scale;
            cornerstone.setViewport(element, vp);
        });
        // FITUR PRINT GAMBAR
        function printImage() {
            const canvas = element.querySelector('canvas');
            const imgData = canvas.toDataURL('image/png');
            const printWindow = window.open('', '_blank');

            printWindow.document.write(`
    <html>
      <head><title>Print DICOM Image</title></head>
      <body style="margin:0;display:flex;justify-content:center;align-items:center;background:black;">
        <img id="dicomPrintImg" src="${imgData}" style="max-width:100%;max-height:100vh;"/>
        <script>
          const img = document.getElementById('dicomPrintImg');
          img.onload = function() {
            setTimeout(() => {
              window.print();
              window.onfocus = () => window.close();
            }, 300);
          };
        <\/script>
      </body>
    </html>
  `);
            printWindow.document.close();
        }
        // FITUR EXPORT PNG
        function exportPNG() {
            const canvas = element.querySelector('canvas');
            const link = document.createElement('a');
            link.download = 'dicom-view.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }



    </script>
</body>

</html>
