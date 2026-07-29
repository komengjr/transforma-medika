<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview DICOM</title>
    <!-- Menggunakan Bootstrap 5 untuk layout sederhana -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            background-color: #121212;
            color: #ffffff;
        }

        .viewer-container {
            height: calc(100vh - 56px);
            width: 100%;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>

    <!-- Header / Navbar Sederhana -->
    <!-- <nav class="navbar navbar-dark bg-dark px-3">
        <span class="navbar-brand mb-0 h1">DICOM Viewer (Orthanc)</span>
        <span class="text-secondary small"></span>
    </nav> -->

    <!-- Area Embed Viewer -->
    <div class="viewer-container">
        <iframe src="{{ $viewerUrl }}" allowfullscreen></iframe>
    </div>

</body>

</html>
