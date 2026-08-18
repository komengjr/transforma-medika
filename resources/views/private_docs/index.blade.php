<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Private Storage PDF Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h3 class="mb-4">Private Storage PDF Upload & Preview</h3>

        <div class="row">
            <!-- Form Upload & List -->
            <div class="col-md-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Upload PDF ke Storage Private</h6>
                    </div>
                    <div class="card-body">
                        <form id="uploadForm">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode / Nama Dokumen</label>
                                <input type="text" id="code" class="form-control" placeholder="Contoh: DOC-001" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">File PDF</label>
                                <button type="button" class="btn btn-outline-secondary w-100" id="browseFile">
                                    📁 Pilih File PDF
                                </button>
                                <div id="fileInfo" class="mt-2 text-muted small"></div>
                            </div>

                            <div class="progress mb-3 d-none" id="uploadProgress" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
                            </div>

                            <button type="button" id="startUploadBtn" class="btn btn-primary w-100" disabled>Mulai Unggah</button>
                        </form>
                    </div>
                </div>

                <!-- List Files -->
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0">Daftar Dokumen Private</h6>
                    </div>
                    <div class="list-group list-group-flush" id="documentList">
                        @forelse($documents as $doc)
                        <button type="button"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            onclick="loadPdf('{{ route('private.docs.preview', $doc->code) }}', '{{ $doc->code }}')">
                            <div>
                                <strong>{{ $doc->code }}</strong>
                                <br><small class="text-muted">{{ $doc->created_at }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">Preview</span>
                        </button>
                        @empty
                        <div class="p-3 text-center text-muted">Belum ada file terunggah.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Preview PDF -->
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0" id="previewTitle">PDF Viewer</h6>
                    </div>
                    <div class="card-body p-2">
                        <div id="pdfContainer" class="text-center py-5 text-muted">
                            <p>Pilih file di sebelah kiri untuk menampilkan preview PDF.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let resumable = new Resumable({
            target: "{{ route('private.docs.upload') }}",
            query: function() {
                return {
                    _token: "{{ csrf_token() }}",
                    code: document.getElementById('code').value
                };
            },
            fileType: ['pdf'],
            chunkSize: 2 * 1024 * 1024,
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false
        });

        resumable.assignBrowse(document.getElementById('browseFile'));

        resumable.on('fileAdded', function(file) {
            document.getElementById('fileInfo').innerText = `${file.fileName} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
            document.getElementById('startUploadBtn').disabled = false;
        });

        document.getElementById('startUploadBtn').addEventListener('click', function() {
            let codeInput = document.getElementById('code').value.trim();
            if (!codeInput) {
                alert('Isi Kode Dokumen terlebih dahulu.');
                return;
            }
            document.getElementById('uploadProgress').classList.remove('d-none');
            resumable.upload();
        });

        resumable.on('fileProgress', function(file) {
            let percent = Math.floor(file.progress() * 100);
            let progressBar = document.querySelector('.progress-bar');
            progressBar.style.width = percent + '%';
            progressBar.innerText = percent + '%';
        });

        // -------------------------------------------------------------
        // KETIKA UNGGAH SELESAI (TANPA RELOAD PAGE)
        // -------------------------------------------------------------
        resumable.on('fileSuccess', function(file, message) {
            let response = JSON.parse(message);

            // 1. Sembunyikan Progress Bar & Reset Input
            document.getElementById('uploadProgress').classList.add('d-none');
            document.getElementById('startUploadBtn').disabled = true;
            document.getElementById('fileInfo').innerText = '';
            document.getElementById('uploadForm').reset();

            // 2. Langsung tampilkan preview PDF di Iframe
            loadPdf(response.preview_url, response.code);

            // 3. Tambahkan dokumen baru ke daftar list di sebelah kiri secara otomatis (DOM Injection)
            addDocumentToList(response.code, response.created_at, response.preview_url);
        });

        resumable.on('fileError', function(file, message) {
            alert('Gagal mengunggah file.');
            document.getElementById('uploadProgress').classList.add('d-none');
        });

        // Fungsi untuk load PDF ke Iframe
        function loadPdf(url, code) {
            document.getElementById('previewTitle').innerText = 'Preview: ' + code;
            document.getElementById('pdfContainer').innerHTML = `<iframe src="${url}" class="pdf-viewer"></iframe>`;
        }

        // Fungsi menyisipkan item baru ke daftar list tanpa reload
        function addDocumentToList(code, createdAt, previewUrl) {
            let documentList = document.getElementById('documentList');

            // Hapus pesan "Belum ada file" jika ada
            if (documentList.innerText.includes('Belum ada file')) {
                documentList.innerHTML = '';
            }

            let newItem = document.createElement('button');
            newItem.type = 'button';
            newItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
            newItem.onclick = function() {
                loadPdf(previewUrl, code);
            };

            newItem.innerHTML = `
            <div>
                <strong>${code}</strong>
                <br><small class="text-muted">${createdAt}</small>
            </div>
            <span class="badge bg-primary rounded-pill">Preview</span>
        `;

            // Sisipkan item paling atas
            documentList.insertBefore(newItem, documentList.firstChild);
        }
    </script>

</body>

</html>
