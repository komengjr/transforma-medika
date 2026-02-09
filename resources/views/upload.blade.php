<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel SFTP Upload</title>
    <link href="https://cdn.jsdelivr.net" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Upload File ke Server SFTP</h5>
                    </div>
                    <div class="card-body">

                        {{-- Pesan Sukses --}}
                        @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm">
                            {{ session('success') }}
                        </div>
                        @endif

                        {{-- Pesan Error --}}
                        @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('upload.sftp') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="document" class="form-label">Pilih File</label>
                                <input type="file" class="form-control" name="document" id="document" required>
                                <small class="text-muted">Maksimal ukuran file: 5MB</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Kirim ke SFTP
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
