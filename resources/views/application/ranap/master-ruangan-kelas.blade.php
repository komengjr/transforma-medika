@extends('layouts.layouts')

@section('base.css')
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-green: #c1ff72;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: white;
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        font-size: 0.8rem !important;
    }

    /* Bed Status Cards */
    .bed-card {
        border: 2px solid var(--retro-dark);
        border-radius: 8px;
        box-shadow: 3px 3px 0px var(--retro-dark);
        transition: transform 0.1s ease;
    }

    .bed-card:hover {
        transform: translateY(-2px);
    }

    .status-tersedia {
        border-left: 8px solid #28a745;
        background-color: #f8fff9;
    }

    .status-terisi {
        border-left: 8px solid #ffc107;
        background-color: #fffdf4;
    }

    .status-perbaikan {
        border-left: 8px solid #17a2b8;
        background-color: #f4f9fb;
    }

    .status-rusak {
        border-left: 8px solid #dc3545;
        background-color: #fff8f8;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 3px 6px;
        font-weight: 800;
        font-size: 0.65rem;
        box-shadow: 1px 1px 0px var(--retro-dark);
        text-transform: uppercase;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-door-open text-success fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block bg-warning text-dark">Manajemen Fasilitas</span>
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">Master Ruangan, Kelas & Bed Rawat Inap</h3>
                        </div>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        <button type="button" class="btn retro-btn retro-btn-success btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambahRuangan">
                            <i class="fas fa-plus me-1"></i> Tambah Ruangan Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATISTIK RINGKAS BED -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="retro-card p-3 bg-white">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-success text-white rounded-3 border border-dark shadow-sm me-3"><i class="fas fa-check-circle fs-4"></i></div>
                <div>
                    <span class="text-muted fw-bold fs--1 d-block">BISA DIGUNAKAN</span>
                    <h4 class="fw-bolder mb-0 text-success">{{ $statsTersedia ?? 0 }} Bed</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="retro-card p-3 bg-white">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-warning text-dark rounded-3 border border-dark shadow-sm me-3"><i class="fas fa-procedures fs-4"></i></div>
                <div>
                    <span class="text-muted fw-bold fs--1 d-block">SEDANG DIGUNAKAN</span>
                    <h4 class="fw-bolder mb-0 text-warning">{{ $statsTerisi ?? 0 }} Bed</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="retro-card p-3 bg-white">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-info text-white rounded-3 border border-dark shadow-sm me-3"><i class="fas fa-tools fs-4"></i></div>
                <div>
                    <span class="text-muted fw-bold fs--1 d-block">DALAM PERBAIKAN</span>
                    <h4 class="fw-bolder mb-0 text-info">{{ $statsPerbaikan ?? 0 }} Bed</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="retro-card p-3 bg-white">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-danger text-white rounded-3 border border-dark shadow-sm me-3"><i class="fas fa-ban fs-4"></i></div>
                <div>
                    <span class="text-muted fw-bold fs--1 d-block">RUSAK / NON-AKTIF</span>
                    <h4 class="fw-bolder mb-0 text-danger">{{ $statsRusak ?? 0 }} Bed</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR INTERAKTIF -->
<div class="retro-card mb-4 p-3 bg-light">
    <div class="row g-3 align-items-center">
        <div class="col-md-5">
            <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-filter text-success me-1"></i> Filter Berdasarkan Kelas:</label>
            <select id="filter-kelas" class="form-select retro-input">
                <option value="">-- Semua Kelas Perawatan --</option>
                <option value="Kelas 1">Kelas 1</option>
                <option value="Kelas 2">Kelas 2</option>
                <option value="Kelas 3">Kelas 3</option>
                <option value="VIP">VIP</option>
                <option value="VVIP">VVIP</option>
                <option value="ICU">ICU</option>
            </select>
        </div>
        <div class="col-md-5">
            <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-procedures text-success me-1"></i> Filter Berdasarkan Status Bed:</label>
            <select id="filter-status" class="form-select retro-input">
                <option value="">-- Semua Status Bed --</option>
                <option value="TERSEDIA">Tersedia (Bisa Digunakan)</option>
                <option value="TERISI">Sedang Digunakan (Terisi)</option>
                <option value="PERBAIKAN">Dalam Perbaikan</option>
                <option value="RUSAK">Rusak</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" id="btn-reset-filter" class="btn retro-btn btn-secondary btn-sm w-100 fw-bold" style="height: 38px;">
                <i class="fas fa-sync-alt me-1"></i> Reset Filter
            </button>
        </div>
    </div>
</div>

<!-- DAFTAR RUANGAN DAN BED -->
<div class="row g-4" id="container-ruangan">
    @forelse($ruanganList as $ruangan)
    <div class="col-xl-6 room-item" data-kelas="{{ $ruangan->kelas }}">
        <div class="retro-card h-100">
            <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3">
                <div>
                    <h5 class="fw-bolder mb-0 text-dark">
                        <i class="fas fa-hospital text-success me-2"></i> {{ $ruangan->nama_ruangan }}
                    </h5>
                    <span class="retro-badge bg-cyan text-dark mt-1 d-inline-block">Kelas: {{ $ruangan->kelas }}</span>
                </div>
                <button type="button" class="btn retro-btn retro-btn-primary btn-sm px-2 py-1" onclick="tambahBedModal('{{ $ruangan->id }}', '{{ $ruangan->nama_ruangan }}')">
                    <i class="fas fa-plus"></i> Tambah Bed
                </button>
            </div>
            <div class="card-body p-3 bg-light">
                <div class="row g-2">
                    @forelse($ruangan->beds as $bed)
                    @php
                    $statusClass = 'status-tersedia';
                    $badgeStatus = 'bg-success text-white';

                    if($bed->is_active == 0) {
                    $statusClass = 'bg-secondary bg-opacity-15 border-secondary';
                    $badgeStatus = 'bg-secondary text-white';
                    } elseif($bed->status == 'TERISI') {
                    $statusClass = 'status-terisi';
                    $badgeStatus = 'bg-warning text-dark';
                    } elseif($bed->status == 'PERBAIKAN') {
                    $statusClass = 'status-perbaikan';
                    $badgeStatus = 'bg-info text-white';
                    } elseif($bed->status == 'RUSAK') {
                    $statusClass = 'status-rusak';
                    $badgeStatus = 'bg-danger text-white';
                    }
                    @endphp
                    <div class="col-md-4 bed-item" data-status="{{ $bed->status }}">
                        <div class="bed-card p-2 {{ $statusClass }} bg-white d-flex flex-column justify-content-between h-100">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bolder text-dark fs--1">{{ $bed->nomor_bed }}</span>
                                <span class="retro-badge {{ $badgeStatus }}">
                                    {{ $bed->is_active == 0 ? 'NON-AKTIF' : $bed->status }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-end gap-1 mt-2 border-top pt-1 border-dark border-opacity-25">
                                <button type="button" class="btn btn-sm btn-outline-dark py-0 px-1 fs--2 fw-bold" onclick="editBed('{{ $bed->id }}', '{{ $bed->nomor_bed }}', '{{ $bed->status }}')" title="Edit Bed">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Tombol Non-Aktif / Aktifkan -->
                                <button type="button" class="btn btn-sm {{ $bed->is_active == 1 ? 'btn-outline-warning' : 'btn-outline-success' }} py-0 px-1 fs--2 fw-bold" onclick="toggleActiveBed('{{ $bed->id }}')" title="{{ $bed->is_active == 1 ? 'Non-aktifkan Bed' : 'Aktifkan Bed' }}">
                                    <i class="fas {{ $bed->is_active == 1 ? 'fa-ban' : 'fa-check' }}"></i> {{ $bed->is_active == 1 ? 'Non-Aktifkan' : 'Aktifkan' }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-3 fw-bold fs--1 no-bed-msg">
                        Belum ada tempat tidur (Bed) terdaftar di ruangan ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="retro-card p-5 text-center bg-white">
            <h5 class="text-muted fw-bold">Belum ada data ruangan atau bangsal rawat inap yang terdaftar.</h5>
            <button type="button" class="btn retro-btn retro-btn-success btn-sm px-4 mt-2" data-bs-toggle="modal" data-bs-target="#modalTambahRuangan">
                + Tambah Ruangan Pertama
            </button>
        </div>
    </div>
    @endforelse
</div>

<!-- MODAL TAMBAH RUANGAN -->
<div class="modal fade" id="modalTambahRuangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <form action="{{ route('master.ruangan.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white border-bottom border-dark py-3">
                    <h5 class="modal-title fw-bolder"><i class="fas fa-door-open me-2"></i> Tambah Master Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Ruangan / Bangsal</label>
                        <input type="text" class="form-control retro-input" name="nama_ruangan" placeholder="Contoh: Melati, ICU, Anggrek..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Kelas Perawatan</label>
                        <select class="form-select retro-input" name="kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="Kelas 1">Kelas 1</option>
                            <option value="Kelas 2">Kelas 2</option>
                            <option value="Kelas 3">Kelas 3</option>
                            <option value="VIP">VIP</option>
                            <option value="VVIP">VVIP</option>
                            <option value="ICU">ICU</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top border-dark py-3">
                    <button type="button" class="btn retro-btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Simpan Ruangan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH BED -->
<div class="modal fade" id="modalTambahBed" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <form action="{{ route('master.bed.store') }}" method="POST">
                @csrf
                <input type="hidden" name="ruangan_id" id="input_ruangan_id">
                <div class="modal-header bg-cyan text-dark border-bottom border-dark py-3">
                    <h5 class="modal-title fw-bolder"><i class="fas fa-bed me-2"></i> Tambah Bed ke Ruangan: <span id="label_nama_ruangan"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nomor / Kode Bed</label>
                        <input type="text" class="form-control retro-input" name="nomor_bed" placeholder="Contoh: Bed 01, Bed 02..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Status Awal Bed</label>
                        <select class="form-select retro-input" name="status" required>
                            <option value="TERSEDIA">TERSEDIA (Bisa Digunakan)</option>
                            <option value="PERBAIKAN">DALAM PERBAIKAN</option>
                            <option value="RUSAK">RUSAK</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top border-dark py-3">
                    <button type="button" class="btn retro-btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn retro-btn retro-btn-primary btn-sm px-4">Simpan Bed</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- SweetAlert2 CSS & JS -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Logika Filter Ruangan & Status Bed secara Interaktif
    function filterRuanganBed() {
        let selectedKelas = $('#filter-kelas').val();
        let selectedStatus = $('#filter-status').val();

        $('.room-item').each(function() {
            let roomCard = $(this);
            let roomKelas = roomCard.data('kelas');

            // Cek kecocokan kelas ruangan
            let matchKelas = !selectedKelas || roomKelas === selectedKelas;

            let visibleBedsInRoom = 0;

            roomCard.find('.bed-item').each(function() {
                let bedItem = $(this);
                let bedStatus = bedItem.data('status');

                // Cek kecocokan status bed
                let matchStatus = !selectedStatus || bedStatus === selectedStatus;

                if (matchStatus) {
                    bedItem.show();
                    visibleBedsInRoom++;
                } else {
                    bedItem.hide();
                }
            });

            // Tampilkan ruangan jika kelas sesuai DAN ada bed yang cocok dengan status yang difilter
            if (matchKelas && (visibleBedsInRoom > 0 || !selectedStatus)) {
                roomCard.show();
            } else {
                roomCard.hide();
            }
        });
    }

    $('#filter-kelas, #filter-status').on('change', function() {
        filterRuanganBed();
    });

    $('#btn-reset-filter').on('click', function() {
        $('#filter-kelas').val('');
        $('#filter-status').val('');
        $('.room-item').show();
        $('.bed-item').show();
    });

    function tambahBedModal(ruanganId, namaRuangan) {
        $('#input_ruangan_id').val(ruanganId);
        $('#label_nama_ruangan').text(namaRuangan);
        $('#modalTambahBed').modal('show');
    }

    function editBed(bedId, nomorBed, statusBed) {
        Swal.fire({
            title: 'Edit Status Bed',
            html: `
                <div class="text-start mb-2">
                    <label class="fw-bold">Nomor Bed:</label>
                    <input type="text" id="swal_nomor_bed" class="form-control mb-2" value="${nomorBed}">
                    <label class="fw-bold">Status Bed:</label>
                    <select id="swal_status_bed" class="form-control">
                        <option value="TERSEDIA" ${statusBed === 'TERSEDIA' ? 'selected' : ''}>TERSEDIA</option>
                        <option value="TERISI" ${statusBed === 'TERISI' ? 'selected' : ''}>TERISI</option>
                        <option value="PERBAIKAN" ${statusBed === 'PERBAIKAN' ? 'selected' : ''}>PERBAIKAN</option>
                        <option value="RUSAK" ${statusBed === 'RUSAK' ? 'selected' : ''}>RUSAK</option>
                    </select>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#38ef7d',
            preConfirm: () => {
                return {
                    nomor_bed: document.getElementById('swal_nomor_bed').value,
                    status: document.getElementById('swal_status_bed').value
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('ranap/medic/master/bed/update') }}/" + bedId,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        nomor_bed: result.value.nomor_bed,
                        status: result.value.status
                    },
                    success: function(res) {
                        Swal.fire('Berhasil!', 'Data bed berhasil diperbarui.', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memperbarui data bed.', 'error');
                    }
                });
            }
        });
    }

    function hapusBed(bedId) {
        Swal.fire({
            title: 'Hapus Bed?',
            text: "Data tempat tidur ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('ranap/medic/master/bed/delete') }}/" + bedId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire('Terhapus!', 'Bed berhasil dihapus.', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menghapus bed.', 'error');
                    }
                });
            }
        });
    }

    function toggleActiveBed(bedId) {
        Swal.fire({
            title: 'Ubah Status Aktif Bed?',
            text: "Status keaktifan bed ini akan diubah.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ubah!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('ranap/medic/master/bed/toggle-active') }}/" + bedId,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire('Berhasil!', res.message, 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal mengubah status bed.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
