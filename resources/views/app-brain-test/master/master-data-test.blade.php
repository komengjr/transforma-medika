@extends('layouts.layouts')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0"><i class="bi bi-layers-fill text-primary me-2"></i>Manajemen Master Data Tes</h3>
            <p class="text-muted small m-0">Kelola klasifikasi ujian, struktur kategori, dan bank soal secara terpusat.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKlasifikasi">
                <i class="bi bi-folder-plus me-1"></i> Tambah Klasifikasi
            </button>
            <button class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kategori Baru
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

    <!-- Filter / Navigasi Klasifikasi Tes (Dynamic Tabs) -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills gap-2" id="klasifikasiTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 fw-semibold shadow-sm" id="all-tab" data-bs-toggle="pill" data-bs-target="#content-all" type="button" role="tab">Semua Klasifikasi</button>
                </li>
                @foreach($klasifikasiList as$klas)
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 fw-semibold shadow-sm bg-white text-dark border" id="tab-{{ $klas->id }}" data-bs-toggle="pill" data-bs-target="#content-{{ $klas->id }}" type="button" role="tab">{{ $klas->nama_klasifikasi }}</button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Konten Berdasarkan Klasifikasi -->
    <div class="tab-content" id="klasifikasiTabContent">

        <!-- Tab: Semua Klasifikasi / Ringkasan -->
        <div class="tab-pane fade show active" id="content-all" role="tabpanel">
            <div class="row g-4">
                @forelse($klasifikasiList as$klas)
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary-subtle text-primary fw-bold mb-1">KLASIFIKASI UTAMA</span>
                                <h4 class="fw-bold text-dark m-0">{{ $klas->nama_klasifikasi }}</h4>
                                <a href="{{ route('admin.brain-test.preview', $klas->id) }}" class="btn btn-sm btn-white border shadow-sm text-success" title="Preview Tryout">
                                    <i class="bi bi-play-circle"></i> Preview
                                </a>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                <ul class="dropdown-menu border-0 shadow">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit Klasifikasi</a></li>
                                    <li>
                                        <form action="{{ route('admin.brain-test.klasifikasi.destroy', $klas->id) }}" method="POST" onsubmit="return confirm('Hapus klasifikasi ini beserta seluruh kategorinya?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <p class="text-muted small mb-3">{{ $klas->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                            <h6 class="fw-bold text-dark fs-2 text-uppercase mb-2">Daftar Kategori di Dalamnya:</h6>
                            <div class="list-group list-group-flush gap-2">
                                @forelse($klas->kategoris as$kat)
                                <div class="list-group-item border rounded-3 d-flex justify-content-between align-items-center py-2 px-3 bg-light">
                                    <div>
                                        <span class="fw-semibold text-dark">{{ $kat->nama_kategori }}</span>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $kat->soals_count ?? 0 }} Soal Terdaftar</div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <!-- Tombol Kelola Soal dengan Atribut data-id dan data-nama yang akurat -->
                                        <button type="button" class="btn btn-sm btn-white border shadow-sm text-primary btn-kelola-soal"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalKelolaSoal"
                                            data-id="{{ $kat->id }}"
                                            data-nama="{{ $kat->nama_kategori }}"
                                            title="Kelola Soal">
                                            <i class="bi bi-file-earmark-text"></i> Soal
                                        </button>
                                        <form action="{{ route('admin.brain-test.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-white border shadow-sm text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                                @empty
                                <div class="text-muted small fst-italic">Belum ada kategori dalam klasifikasi ini.</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-4 px-4 pt-2">
                            <button class="btn btn-sm btn-outline-primary rounded-pill w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Kategori ke {{ $klas->nama_klasifikasi }}
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada data klasifikasi tes yang dibuat. Silakan klik tombol "Tambah Klasifikasi" di atas.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Dinamis Per Klasifikasi -->
        @foreach($klasifikasiList as$klas)
        <div class="tab-pane fade" id="content-{{ $klas->id }}" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold text-dark mb-2">Pengaturan Khusus: {{ $klas->nama_klasifikasi }}</h4>
                <p class="text-muted small mb-4">{{ $klas->deskripsi }}</p>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-2">
                            <tr>
                                <th class="py-3">No</th>
                                <th class="py-3">Nama Kategori</th>
                                <th class="py-3">Deskripsi</th>
                                <th class="py-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($klas->kategoris as $index =>$kat)
                            <tr>
                                <td class="fw-semibold">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $kat->nama_kategori }}</td>
                                <td class="text-muted">{{ $kat->deskripsi ?? '-' }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-light text-primary fw-semibold btn-kelola-soal"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalKelolaSoal"
                                        data-id="{{ $kat->id }}"
                                        data-nama="{{ $kat->nama_kategori }}">
                                        <i class="bi bi-file-earmark-text"></i> Kelola Soal
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

<!-- Modal Tambah Klasifikasi Baru -->
<div class="modal fade" id="modalTambahKlasifikasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="fw-bold text-dark m-0">Tambah Klasifikasi Tes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.brain-test.klasifikasi.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nama Klasifikasi Tes</label>
                        <input type="text" name="nama_klasifikasi" class="form-control rounded-pill py-2 px-3" placeholder="Contoh: Tes BUMN, Tes CPNS" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control rounded-3 px-3 py-2" rows="3" placeholder="Keterangan singkat klasifikasi tes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">Simpan Klasifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori Baru -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="fw-bold text-dark m-0">Tambah Kategori Tes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.brain-test.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Pilih Klasifikasi Tes</label>
                        <select name="klasifikasi_id" class="form-select rounded-pill py-2 px-3" required>
                            <option value="">-- Pilih Klasifikasi --</option>
                            @foreach($klasifikasiList as$klas)
                            <option value="{{ $klas->id }}">{{ $klas->nama_klasifikasi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control rounded-pill py-2 px-3" placeholder="Contoh: Matematika, TWK" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Deskripsi Kategori (Opsional)</label>
                        <textarea name="deskripsi" class="form-control rounded-3 px-3 py-2" rows="3" placeholder="Keterangan singkat materi kategori..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Kelola Soal (Utama) -->
<div class="modal fade" id="modalKelolaSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 px-4 pt-4 pb-2 bg-light rounded-top-4">
                <div>
                    <h5 class="fw-bold text-dark m-0" id="modalSoalTitle">Kelola Bank Soal</h5>
                    <p class="text-muted small m-0">Kelola pertanyaan dan opsi jawaban langsung dari sini.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3" id="modalSoalBody">
                <!-- Loading State -->
                <div class="text-center py-5" id="soalLoading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted small mt-2">Memuat data soal...</p>
                </div>

                <!-- Konten Soal -->
                <div id="soalContentWrapper" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark m-0">Daftar Pertanyaan</h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalImportExcelInModal">
                                <i class="bi bi-file-earmark-excel me-1"></i> Import Excel
                            </button>
                            <button class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSoalInModal">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Soal
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 border rounded-3 overflow-hidden">
                            <thead class="table-light text-uppercase fs-2">
                                <tr>
                                    <th class="py-3 px-3" style="width: 5%;">No</th>
                                    <th class="py-3" style="width: 60%;">Pertanyaan & Pilihan</th>
                                    <th class="py-3 text-center" style="width: 15%;">Opsi</th>
                                    <th class="py-3 text-end px-3" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabelSoalBody">
                                <!-- Data soal dimuat via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-2">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahSoalInModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="fw-bold text-dark m-0">Tambah Soal Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahSoalAjax">
                @csrf
                <input type="hidden" name="kategori_id" id="inputKategoriId">
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Pertanyaan Soal</label>
                        <textarea name="pertanyaan" class="form-control rounded-3 px-3 py-2" rows="3" placeholder="Tuliskan teks pertanyaan di sini..." required></textarea>
                    </div>
                    <hr class="my-3 text-muted">
                    <h6 class="fw-bold text-dark mb-2">Pilihan Opsi Jawaban</h6>
                    <div id="opsi-container">
                        @for($i = 0; $i < 4; $i++)
                            <div class="input-group mb-2 align-items-center gap-2">
                            <div class="input-group-text bg-light border rounded-pill px-3">
                                <input class="form-check-input mt-0" type="radio" name="jawaban_benar" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }} title="Kunci Jawaban">
                            </div>
                            <input type="text" name="opsi[{{ $i }}][teks]" class="form-control rounded-pill px-3 py-2" placeholder="Teks pilihan {{ $i + 1 }}" required>
                            <input type="number" name="opsi[{{ $i }}][bobot]" class="form-control rounded-pill px-3 py-2" style="max-width: 100px;" value="{{ $i == 0 ? 5 : 0 }}" required>
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

<!-- Modal Import Excel (Sub-Modal) -->
<div class="modal fade" id="modalImportExcelInModal" tabindex="-1" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="fw-bold text-dark m-0">Import Soal via Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formImportExcel" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Pilih File Excel (.xlsx / .csv)</label>
                        <input type="file" name="file_excel" class="form-control rounded-pill py-2 px-3" accept=".xlsx, .xls, .csv" required>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('admin.brain-test.soal.template') }}" class="small text-decoration-none fw-semibold text-primary">
                            <i class="bi bi-download me-1"></i> Download Contoh Format Template Excel
                        </a>
                    </div>

                    <div class="p-3 bg-light rounded-4 small text-muted">
                        <p class="fw-bold text-dark mb-1"><i class="bi bi-info-circle me-1"></i> Ketentuan Kolom Excel:</p>
                        <ul class="mb-0 ps-3">
                            <li><strong>pertanyaan</strong>: Teks soal</li>
                            <li><strong>opsi_a, opsi_b, opsi_c, opsi_d</strong>: Pilihan jawaban</li>
                            <li><strong>kunci_jawaban</strong>: Huruf kapital (A, B, C, atau D)</li>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalKelolaSoal = document.getElementById('modalKelolaSoal');

        modalKelolaSoal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const kategoriId = button.getAttribute('data-id');
            const namaKategori = button.getAttribute('data-nama');

            // Set judul modal & input hidden kategori id secara global
            document.getElementById('modalSoalTitle').innerText = 'Bank Soal: ' + namaKategori;
            document.getElementById('inputKategoriId').value = kategoriId;
            window.activeKategoriId = kategoriId;

            // Tampilkan loading, sembunyikan konten
            document.getElementById('soalLoading').style.display = 'block';
            document.getElementById('soalContentWrapper').style.display = 'none';

            // Ambil data soal via fetch AJAX ke route backend
            fetch(`/admin/brain-test/kategori/${kategoriId}/json-soal`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.getElementById('tabelSoalBody');
                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted fst-italic">Belum ada soal pada kategori ini.</td></tr>`;
                    } else {
                        data.forEach((soal, index) => {
                            let opsiHtml = soal.opsi_jawabans.map(opt => `
                                <div class="small ${opt.is_benar ? 'text-success fw-bold' : 'text-muted'}">
                                    - ${opt.teks_jawaban} ${opt.is_benar ? '(Kunci)' : ''}
                                </div>
                            `).join('');

                            tbody.innerHTML += `
                                <tr>
                                    <td class="px-3 fw-semibold">${index + 1}</td>
                                    <td>
                                        <div class="fw-semibold text-dark mb-1">${soal.pertanyaan}</div>
                                        <div>${opsiHtml}</div>
                                    </td>
                                    <td class="text-center"><span class="badge bg-light text-dark border">${soal.opsi_jawabans.length} Opsi</span></td>
                                    <td class="text-end px-3">
                                        <button class="btn btn-sm btn-light border text-danger" onclick="hapusSoal(${soal.id})"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    document.getElementById('soalLoading').style.display = 'none';
                    document.getElementById('soalContentWrapper').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('soalLoading').innerHTML = `<p class="text-danger small">Gagal memuat data soal.</p>`;
                });
        });
    });

    // Script AJAX untuk SIMPAN SOAL MANUAL
    document.getElementById('formTambahSoalAjax').addEventListener('submit', function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let kategoriId = document.getElementById('inputKategoriId').value || window.activeKategoriId;

        if (!kategoriId) {
            alert('ID Kategori tidak ditemukan. Silakan tutup dan buka ulang modal.');
            return;
        }

        let submitBtn = form.querySelector('button[type="submit"]');
        let originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...`;

        fetch(`{{ url('admin/brain-test/kategori') }}/${kategoriId}/soal`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;

                if (res.status === 200 || res.status === 201 || res.body.status === 'success') {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.body.message || 'Soal berhasil ditambahkan!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        alert('Soal berhasil ditambahkan!');
                    }

                    let modalTambahEl = document.getElementById('modalTambahSoalInModal');
                    if (modalTambahEl && typeof bootstrap !== 'undefined') {
                        let modalTambah = bootstrap.Modal.getInstance(modalTambahEl) || new bootstrap.Modal(modalTambahEl);
                        modalTambah.hide();
                    }

                    form.reset();
                    location.reload();
                } else {
                    throw new Error(res.body.message || 'Gagal menyimpan soal.');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                alert('Gagal: ' + error.message);
            });
    });

    // Script AJAX untuk IMPORT EXCEL
    document.getElementById('formImportExcel').addEventListener('submit', function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let kategoriId = document.getElementById('inputKategoriId')?.value || window.activeKategoriId;

        if (!kategoriId) {
            alert('ID Kategori tidak ditemukan. Silakan tutup dan buka ulang modal.');
            return;
        }

        let submitBtn = form.querySelector('button[type="submit"]');
        let originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengimpor...`;

        fetch(`{{ url('admin/brain-test/kategori') }}/${kategoriId}/soal/import`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;

                if (res.status === 200 && res.body.status === 'success') {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.body.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        alert(res.body.message);
                    }

                    let modalImportEl = document.getElementById('modalImportExcelInModal');
                    if (modalImportEl && typeof bootstrap !== 'undefined') {
                        let modalImport = bootstrap.Modal.getInstance(modalImportEl) || new bootstrap.Modal(modalImportEl);
                        modalImport.hide();
                    }

                    form.reset();
                    location.reload();
                } else {
                    throw new Error(res.body.message || 'Terjadi kesalahan saat mengimpor data.');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                alert('Gagal: ' + error.message);
            });
    });
</script>
@endsection
