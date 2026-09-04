<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Results - {{ $photobooth->org_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="mb-3">
            <a href="{{ route('photobooth.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Menu Master
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="fw-bold text-primary mb-1">Lampiran Data Hasil Photobooth</h4>
                <p class="text-muted mb-0">Organisasi: <strong>{{ $photobooth->org_name }}</strong> (Kode: <code>{{ $photobooth->org_code }}</code>)</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Kode Unik</th>
                                <th>Nama User</th>
                                <th>Kontak</th>
                                <th>Foto Strip (Merged)</th>
                                <th>Foto Satuan (Single)</th>
                                <th>Waktu Ambil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($results as $index => $res)
                            <tr>
                                <td class="ps-3">{{ $index + 1 }}</td>
                                <td><span class="badge bg-dark">{{ $res->code }}</span></td>
                                <td class="fw-bold">{{ $res->name }}</td>
                                <td>
                                    <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>{{ $res->phone }}</div>
                                    <div class="small text-muted"><i class="fa-solid fa-envelope me-1"></i>{{ $res->email }}</div>
                                </td>
                                <td>
                                    @if($res->image_path)
                                    <a href="{{ asset('storage/' . $res->image_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $res->image_path) }}" class="img-thumbnail" style="height: 70px; object-fit: contain;">
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap" style="max-width: 200px;">
                                        @if(is_array($res->single_images))
                                        @foreach($res->single_images as $single)
                                        <a href="{{ asset('storage/' . $single) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $single) }}" class="rounded border" style="height: 35px; width: 35px; object-fit: cover;">
                                        </a>
                                        @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td><small class="text-muted">{{ $res->created_at->format('d M Y, H:i') }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data hasil pemotretan untuk organisasi ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
