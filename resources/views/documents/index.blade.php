<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload & Preview Private PDF</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ResumableJS untuk Chunk Upload -->
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
    <style>
        .pdf-viewer {
            width: 100%;
            height: 600px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">Manajemen Dokumen Private (PDF)</h2>

    <div class="row">
        <!-- Panel Left: Form Upload -->
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Upload PDF Baru</h5>
                </div>
                <div class="card-body">
                    <form id="uploadForm">
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Dokumen</label>
                            <input type="text" id="code" class="form-control" placeholder="Masukkan kode/no rekam medis" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih File PDF</label>
                            <button type="button" class="btn btn-outline-secondary w-100" id="browseFile">
                                📁 Pilih File PDF...
                            </button>
                            <div id="fileInfo" class="mt-2 text-muted small"></div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="progress mb-3 d-none" id="uploadProgress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
                        </div>

                        <button type="button" id="startUploadBtn" class="btn btn-primary w-100" disabled>Mulai Upload</button>
                    </form>
                </div>
            </div>

            <!-- List Dokumen -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">Daftar Dokumen Anda</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" id="documentList">
                        @forelse($documents as $doc)
                            <button type="button"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                    onclick="loadPdf('{{ route('documents.preview', $doc->monitoring_hasil_pasien_code) }}', '{{ $doc->monitoring_hasil_pasien_code }}')">
                                <div>
                                    <strong>{{ $doc->monitoring_hasil_pasien_code }}</strong>
                                    <br><small class="text-muted">{{ $doc->created_at }}</small>
                                </div>
                                <span class="badge bg-success rounded-pill">Lihat PDF</span>
                            </button>
                        @empty
                            <div class="p-3 text-center text-muted">Belum ada dokumen yang diunggah.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Right: PDF Viewer Frame -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0" id="previewTitle">Preview PDF</h5>
                </div>
                <div class="card-body p-2">
                    <div id="pdfContainer" class="text-center py-5 text-muted">
                        <p>Pilih dokumen dari daftar di samping atau unggah file baru untuk melihat PDF.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Inisialisasi Resumable.js untuk Chunk Upload
    let resumable = new Resumable({
        target: "{{ route('documents.upload') }}",
        query: function() {
            return {
                _token: "{{ csrf_token() }}",
                code: document.getElementById('code').value
            };
        },
        fileType: ['pdf'],
        chunkSize: 2 * 1024 * 1024, // 2MB per chunk
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false
    });

    resumable.assignBrowse(document.getElementById('browseFile'));

    // Ketika file dipilih
    resumable.on('fileAdded', function(file) {
        document.getElementById('fileInfo').innerText = `File terpilih: ${file.fileName} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        document.getElementById('startUploadBtn').disabled = false;
    });

    // Jalankan upload saat tombol diklik
    document.getElementById('startUploadBtn').addEventListener('click', function() {
        let codeInput = document.getElementById('code').value.trim();
        if(!codeInput) {
            alert('Silakan isi Kode Dokumen terlebih dahulu.');
            return;
        }

        document.getElementById('uploadProgress').classList.remove('d-none');
        resumable.upload();
    });

    // Update Progress Bar
    resumable.on('fileProgress', function(file) {
        let percent = Math.floor(file.progress() * 100);
        let progressBar = document.querySelector('.progress-bar');
        progressBar.style.width = percent + '%';
        progressBar.innerText = percent + '%';
    });

    // Ketika Upload Selesai
    resumable.on('fileSuccess', function(file, message) {
        let response = JSON.parse(message);
        alert('File berhasil diunggah!');

        // Reset Form & UI
        document.getElementById('uploadProgress').classList.add('d-none');
        document.getElementById('startUploadBtn').disabled = true;
        document.getElementById('fileInfo').innerText = '';

        // Render PDF ke viewer
        loadPdf(response.preview_url, document.getElementById('code').value);
        setTimeout(() => location.reload(), 1500);
    });

    // Jika terjadi Error Upload
    resumable.on('fileError', function(file, message) {
        alert('Gagal mengunggah file: ' + message);
        document.getElementById('uploadProgress').classList.add('d-none');
    });

    // 2. Fungsi untuk Menampilkan PDF di IFRAME
    function loadPdf(url, code) {
        document.getElementById('previewTitle').innerText = 'Preview: ' + code;
        let container = document.getElementById('pdfContainer');
        container.innerHTML = `<iframe src="${url}" class="pdf-viewer"></iframe>`;
    }
</script>

</body>
</html>
