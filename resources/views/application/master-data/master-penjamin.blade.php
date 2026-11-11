@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    /* Retro Cards & Banners */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        overflow: hidden;
        background-color: #ffffff;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    /* Retro Buttons */
    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-primary:hover {
        background-color: #6ce0ed;
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    /* Inputs & Form Controls */
    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
    }

    .retro-input:focus,
    .form-control:focus,
    .form-select:focus {
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Table Styling */
    .table-custom {
        font-size: 0.8rem;
        border-collapse: collapse !important;
        width: 100%;
    }

    .table-custom thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark) !important;
        padding: 12px 10px;
        letter-spacing: 0.5px;
        text-align: center;
    }

    .table-custom td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 10px;
        vertical-align: middle;
        background-color: #ffffff;
    }

    /* List Group Item Styling for Left Panel */
    .list-group-item-penjamin {
        border: 2px solid var(--retro-dark) !important;
        margin-bottom: 8px;
        border-radius: 8px !important;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 2px 2px 0px var(--retro-dark);
        background-color: #ffffff;
        color: var(--retro-dark);
    }

    .list-group-item-penjamin:hover {
        background-color: var(--retro-yellow);
        transform: translate(-1px, -1px);
        box-shadow: 3px 3px 0px var(--retro-dark);
    }

    .list-group-item-penjamin.active {
        background-color: var(--retro-cyan) !important;
        color: var(--retro-dark) !important;
        border-color: var(--retro-dark) !important;
        box-shadow: 3px 3px 0px var(--retro-dark);
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-handshake text-dark fs-2"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                    <i class="fas fa-database me-1"></i> Master Data
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem; text-shadow: 1px 1px 0px white;">
                                Manajemen <span class="fw-normal">Penjamin & Sub Penjamin</span>
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-building me-1 text-warning"></i> Kelompok Penjamin Medis
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN LAYOUT: SEBELAH KIRI (PENJAMIN UTAMA), SEBELAH KANAN (SUB PENJAMIN) -->
<div class="row g-4">

    <!-- KOLOM KIRI: LIST PENJAMIN UTAMA -->
    <div class="col-lg-4">
        <div class="retro-card h-100">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder fs-0"><i class="fas fa-building me-1"></i> Penjamin Utama</h5>
                <button class="btn btn-sm retro-btn retro-btn-success px-2 py-1 fs--1" data-bs-toggle="modal" data-bs-target="#modal-tambah-penjamin">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
            <div class="card-body p-3 bg-white">
                <!-- Input Filter Pencarian Penjamin Utama -->
                <div class="mb-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white text-dark" style="border: 2px solid var(--retro-dark); border-right: none;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="search-penjamin-utama" class="form-control retro-input form-control-sm" placeholder="Cari penjamin utama...">
                    </div>
                </div>

                <div class="list-group" id="list-penjamin-utama" style="max-height: 440px; overflow-y: auto;">
                    @forelse ($penjaminUtama as $utama)
                    <div class="list-group-item list-group-item-penjamin p-2 px-3 d-flex justify-content-between align-items-center @if($loop->first) active @endif"
                        data-id="{{ $utama->id }}"
                        data-nama="{{ $utama->nama_penjamin }}">
                        <div class="flex-grow-1 text-truncate pe-2 item-click-target">
                            <i class="fas fa-folder-open me-2"></i>
                            <span class="nama-penjamin-text">{{ $utama->nama_penjamin }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <!-- Tombol Edit Penjamin Utama -->
                            <button type="button" class="btn btn-sm retro-btn retro-btn-warning px-2 py-1 btn-edit-utama"
                                data-id="{{ $utama->id }}"
                                data-nama="{{ $utama->nama_penjamin }}"
                                title="Edit Penjamin Utama" style="font-size: 0.65rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <i class="fas fa-chevron-right fs--2 text-muted ms-1"></i>
                        </div>
                    </div>
                    @empty
                    <div id="no-penjamin-empty" class="text-center py-4 text-muted fw-bold fst-italic">Belum ada penjamin utama.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: TABEL SUB PENJAMIN BERDASARKAN PILIHAN -->
    <div class="col-lg-8">
        <div class="retro-card h-100">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark); color: white;">
                <h5 class="mb-0 text-white fw-bolder fs-0">
                    <i class="fas fa-list-alt text-info me-1"></i> Sub Penjamin untuk: <span id="selected-penjamin-title" class="text-warning text-decoration-underline">Pilih Penjamin</span>
                </h5>
                <button class="btn btn-sm retro-btn retro-btn-success px-3 py-1 fs--1" data-bs-toggle="modal" data-bs-target="#modal-tambah-sub-penjamin" id="btn-tambah-sub-trigger" disabled>
                    <i class="fas fa-plus-circle me-1"></i> Tambah Sub Penjamin
                </button>
            </div>
            <div class="card-body p-3 bg-white">
                <div class="table-responsive">
                    <table id="table-sub-penjamin" class="table table-custom align-middle w-100 mb-0 fs--1 table-bordered" style="border: 2px solid var(--retro-dark);">
                        <thead>
                            <tr>
                                <th class="py-2 px-3 text-center" style="width: 50px;">No</th>
                                <th class="py-2 px-3">Nama Sub Penjamin / Asuransi / Perusahaan</th>
                                <th class="py-2 px-3 text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sub-penjamin-tbody">
                            <!-- Data dimuat dinamis via JavaScript berdasarkan klik di sebelah kiri -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL TAMBAH PENJAMIN UTAMA -->
<div class="modal fade" id="modal-tambah-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-plus-circle me-1"></i> Tambah Penjamin Utama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 bg-white">
                <form action="{{ route('master_penjamin_utama_store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Penjamin Utama</label>
                        <input type="text" class="form-control retro-input" name="nama_penjamin" placeholder="Contoh: BPJS, Asuransi Swasta, Umum..." required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT PENJAMIN UTAMA -->
<div class="modal fade" id="modal-edit-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-edit me-1"></i> Edit Penjamin Utama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 bg-white">
                <form id="form-edit-penjamin-utama" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Penjamin Utama</label>
                        <input type="text" class="form-control retro-input" id="edit-nama-penjamin" name="nama_penjamin" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH SUB PENJAMIN -->
<div class="modal fade" id="modal-tambah-sub-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-plus-circle me-1"></i> Tambah Sub Penjamin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 bg-white">
                <form action="{{ route('sub_penjamin_store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="modal-penjamin-id" name="penjamin_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Penjamin Utama</label>
                        <input type="text" class="form-control retro-input bg-light" id="modal-penjamin-nama" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Sub Penjamin</label>
                        <input type="text" class="form-control retro-input" name="nama_sub_penjamin" placeholder="Contoh: PT Asuransi Mandiri, BPJS PBI..." required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT SUB PENJAMIN -->
<div class="modal fade" id="modal-edit-sub-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-card border-0">
            <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                <h5 class="mb-0 text-dark fw-bolder"><i class="fas fa-edit me-1"></i> Edit Sub Penjamin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 bg-white">
                <form id="form-edit-sub-penjamin" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs--1">Nama Sub Penjamin</label>
                        <input type="text" class="form-control retro-input" id="edit-nama-sub-penjamin" name="nama_sub_penjamin" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-dark">
                        <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    // Data mentah sub penjamin dari Controller
    const subPenjaminData = @json($subPenjamin);
    let subTable;

    $(document).ready(function() {
        // Inisialisasi DataTable sebelah kanan
        subTable = $('#table-sub-penjamin').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Cari sub penjamin..."
            },
            pageLength: 10,
            dom: "<'row p-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row p-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });

        // Trigger klik pada penjamin pertama yang tampil saat halaman dimuat
        triggerFirstVisiblePenjamin();

        // --- SCRIPT FILTER PENCARIAN PENJAMIN UTAMA (KIRI) ---
        $('#search-penjamin-utama').on('keyup', function() {
            let keyword = $(this).val().toLowerCase();
            let visibleCount = 0;

            $('#list-penjamin-utama .list-group-item-penjamin').each(function() {
                let namaPenjamin = $(this).data('nama').toLowerCase();
                if (namaPenjamin.includes(keyword)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            if (visibleCount === 0) {
                if ($('#no-result-msg').length === 0) {
                    $('#list-penjamin-utama').append('<div id="no-result-msg" class="text-center py-3 text-muted fw-bold fst-italic">Penjamin tidak ditemukan.</div>');
                }
            } else {
                $('#no-result-msg').remove();
            }
        });
    });

    function triggerFirstVisiblePenjamin() {
        let firstItem = $('#list-penjamin-utama .list-group-item-penjamin:visible').first();
        if (firstItem.length > 0) {
            firstItem.find('.item-click-target').trigger('click');
        } else {
            $('#selected-penjamin-title').text('Tidak ada data');
            $('#btn-tambah-sub-trigger').prop('disabled', true);
            subTable.clear().draw();
        }
    }

    // Event handler ketika area teks penjamin utama sebelah kiri diklik
    $(document).on('click', '.list-group-item-penjamin .item-click-target', function(e) {
        e.stopPropagation();
        let parentItem = $(this).closest('.list-group-item-penjamin');
        $('.list-group-item-penjamin').removeClass('active');
        parentItem.addClass('active');

        let penjaminId = parentItem.data('id');
        let penjaminNama = parentItem.data('nama');

        $('#selected-penjamin-title').text(penjaminNama);
        $('#modal-penjamin-id').val(penjaminId);
        $('#modal-penjamin-nama').val(penjaminNama);
        $('#btn-tambah-sub-trigger').prop('disabled', false);

        // Filter data sub penjamin berdasarkan penjamin utama yang dipilih
        let filteredData = subPenjaminData.filter(item => item.penjamin_id == penjaminId);

        subTable.clear();

        if (filteredData.length > 0) {
            filteredData.forEach((sub, index) => {
                let actionBtn = `<div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm retro-btn retro-btn-warning px-2 py-1 btn-edit-sub"
                                        data-id="${sub.sub_penjamin_id}"
                                        data-nama="${sub.nama_sub_penjamin}"
                                        title="Edit Sub Penjamin" style="font-size: 0.7rem;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                 </div>`;
                subTable.row.add([
                    `<div class="text-center">${index + 1}</div>`,
                    `<div class="fw-bolder text-dark">${sub.nama_sub_penjamin}</div>`,
                    actionBtn
                ]);
            });
        }

        subTable.draw();
    });

    // Event handler tombol Edit Penjamin Utama
    $(document).on('click', '.btn-edit-utama', function(e) {
        e.stopPropagation();
        let id = $(this).data('id');
        let nama = $(this).data('nama');

        $('#edit-nama-penjamin').val(nama);
        $('#form-edit-penjamin-utama').attr('action', `/master-data/master-penjamin/update-utama/${id}`);
        $('#modal-edit-penjamin').modal('show');
    });

    // Event handler tombol Edit Sub Penjamin
    $(document).on('click', '.btn-edit-sub', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');

        $('#edit-nama-sub-penjamin').val(nama);
        $('#form-edit-sub-penjamin').attr('action', `/master-data/master-penjamin/update-sub/${id}`);
        $('#modal-edit-sub-penjamin').modal('show');
    });
</script>
@endsection
