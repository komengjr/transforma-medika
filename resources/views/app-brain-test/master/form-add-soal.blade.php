@extends('layouts.layouts')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.brain-test.index') }}">Master Tes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelola Soal</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark m-0">
                <i class="bi bi-journal-code text-primary me-2"></i>Bank Soal: {{ $kategori->nama_kategori }}
            </h3>
            <p class="text-muted small m-0">Klasifikasi: <strong>{{ $kategori->klasifikasi->nama_klasifikasi }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-success rounded-pill px-3 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
                <i class="bi bi-file-earmark-excel me-1"></i> Import Excel
            </button>
            <button class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSoal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Soal Manual
            </button>
        </div>
    </div>

    <!-- Notifikasi Flash Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> Terjadi kesalahan pada input Anda. Silakan cek kembali.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Daftar Soal -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold text-dark mb-3">Daftar Soal Terdaftar</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-uppercase fs-7">
                    <tr>
                        <th class="py-3" style="width: 5%;">No</th>
                        <th class="py-3" style="width: 55%;">Pertanyaan</th>
                        <th class="py-3 text-center" style="width: 20%;">Jumlah Opsi</th>
                        <th class="py-3 text-end" style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($soals as $index => $soal)
                    <tr>
                        <td class="fw-semibold">{{ $soals->firstItem() + $index }}</td>
                        <td>
                            <span class="text-dark">{{ Str::limit(strip_tags($soal->pertanyaan), 100) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $soal->opsiJawabans->count() }} Pilihan</span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <form action="{{ route('admin.brain-test.soal.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini beserta pilihan jawabannya?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted fst-italic">Belum ada soal yang diinput ke kategori ini. Silakan gunakan tombol Tambah Manual atau Import Excel.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-end">
            {{ $soals->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Soal Manual -->
<div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="fw-bold text-dark m-0">Tambah Soal Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.brain-test.soal.store', $kategori->id) }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Pertanyaan Soal</label>
                        <textarea name="pertanyaan" class="form-control rounded-3 px-3 py-2" rows="3" placeholder="Tuliskan teks pertanyaan di sini..." required></textarea>
                    </div>

                    <hr class="my-4 text-muted">
                    <h6 class="fw-bold text-dark mb-3">Pilihan Opsi Jawaban & Bobot Nilai</h6>
                    <p class="text-muted small mb-3">Masukkan beberapa opsi jawaban, lalu centang pada opsi yang merupakan **Kunci Jawaban / Poin Tertinggi**.</p>

                    <!-- Looping Dynamic Opsi (Contoh 4 Opsi Pilihan Ganda) -->
                    <div id="opsi-container">
                        @for($i = 0; $i < 4; $i++)
                            <div class="input-group mb-3 align-items-center gap-2">
                            <div class="input-group-text bg-light border rounded-pill px-3">
                                <input class="form-check-input mt-0" type="radio" name="jawaban_benar" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }} title="Tandai sebagai kunci jawaban">
                            </div>
                            <input type="text" name="opsi[{{ $i }}][teks]" class="form-control rounded-pill px-3 py-2" placeholder="Teks pilihan jawaban {{ $i + 1 }}" required>
                            <input type="number" name="opsi[{{ $i }}][bobot]" class="form-control rounded-pill px-3 py-2" style="max-width: 120px;" placeholder="Bobot/Nilai" value="{{ $i == 0 ? 5 : 0 }}" required>
                    </div>
                    @endfor
                </div>
        </div>
        <div class="modal-footer border-0 pt-0 pb-4 px-4">
            <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">Simpan Soal</button>
        </div>
        </form>
    </div>
</div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImportExcel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="fw-bold text-dark m-0">Import Soal via Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.brain-test.soal.import', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">File Excel (.xlsx, .xls, .csv)</label>
                        <input type="file" name="file_excel" class="form-control rounded-pill py-2 px-3" accept=".xlsx, .xls, .csv" required>
                    </div>
                    <div class="p-3 bg-light rounded-4 small text-muted">
                        <p class="fw-bold text-dark mb-1"><i class="bi bi-info-circle me-1"></i> Ketentuan Format Excel:</p>
                        <ul class="mb-0 ps-3">
                            <li>Kolom A: Pertanyaan</li>
                            <li>Kolom B, C, D, E: Pilihan Opsi A, B, C, D</li>
                            <li>Kolom F: Kunci Jawaban (huruf opsi, misal: A)</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
