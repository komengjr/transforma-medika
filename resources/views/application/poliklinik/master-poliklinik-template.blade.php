@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-pink: #ff66c4;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 4px 4px 0px var(--retro-dark);
    }

    .card-retro {
        border: var(--retro-border);
        border-radius: 12px;
        background: #ffffff;
        box-shadow: var(--retro-shadow);
        overflow: hidden;
    }

    .table-retro th {
        background-color: var(--retro-dark) !important;
        color: #ffffff !important;
        border: 2px solid var(--retro-dark) !important;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-retro td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        vertical-align: middle;
    }

    .table-retro tbody tr:hover {
        background-color: var(--retro-yellow) !important;
    }

    .btn-retro {
        border: 2px solid var(--retro-dark);
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-radius: 6px;
        font-weight: 800;
        text-transform: uppercase;
        transition: all 0.1s;
    }

    .btn-retro:hover,
    .btn-retro:active {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .badge-retro {
        border: 2px solid var(--retro-dark);
        color: var(--retro-dark);
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
    }

    /* Form Inputs Retro */
    .form-control-retro,
    .form-select-retro {
        border: 2px solid var(--retro-dark) !important;
        background-color: #ffffff;
        font-weight: 700;
        color: var(--retro-dark);
    }

    .form-control-retro:focus,
    .form-select-retro:focus {
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-color: var(--retro-dark) !important;
    }
</style>
@endsection

@section('content')
<!-- Banner Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-retro" style="background-color: var(--retro-pink);">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-white border border-dark rounded-3 me-3 text-dark d-flex align-items-center justify-content-center" style="box-shadow: 3px 3px 0px var(--retro-dark); border-width: 2px !important;">
                        <i class="fas fa-file-medical fa-2x"></i>
                    </div>
                    <div>
                        <span class="badge badge-retro bg-white mb-2">Master Data</span>
                        <h2 class="fw-bolder mb-0 text-dark" style="letter-spacing: -1px;">Setting Template Poliklinik</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-retro">
            <div class="card-header border-bottom border-dark border-2 p-3" style="background-color: var(--retro-cyan);">
                <h5 class="mb-0 fw-bolder text-dark"><i class="fas fa-list me-2"></i> Daftar Konfigurasi Template</h5>
            </div>
            <div class="card-body p-4 bg-white">
                <div class="table-responsive">
                    <table class="table table-retro table-bordered w-100" id="table-template">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="15%">Kode Poli</th>
                                <th width="25%">Nama Poliklinik</th>
                                <th width="20%">Jenis Template</th>
                                <th width="25%">Keterangan</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $row->kode_poli ?? '-' }}</td>
                                <td>{{ $row->nama_poli }}</td>
                                <td>
                                    @if($row->jenis_template)
                                    @php
                                    $bgColor = 'bg-light';
                                    if($row->jenis_template == 'GIGI') $bgColor = 'var(--retro-orange)';
                                    if($row->jenis_template == 'UMUM') $bgColor = 'var(--retro-green)';
                                    if($row->jenis_template == 'KANDUNGAN') $bgColor = 'var(--retro-purple)';
                                    @endphp
                                    <span class="badge badge-retro fs--1 px-3 py-2" style="background-color: {{ $bgColor }};">
                                        {{ $template_options[$row->jenis_template] ?? $row->jenis_template }}
                                    </span>
                                    @else
                                    <span class="badge badge-retro bg-light text-danger fs--1 px-3 py-2">Belum Disetting</span>
                                    @endif
                                </td>
                                <td>{{ $row->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-retro px-3 text-dark btn-setting"
                                        data-id="{{ $row->poli_id }}"
                                        data-nama="{{ $row->nama_poli }}"
                                        data-template="{{ $row->jenis_template ?? '' }}"
                                        data-menu="{{ $row->menu_aktif ?? '' }}"
                                        data-keterangan="{{ $row->keterangan ?? '' }}"
                                        style="background-color: var(--retro-yellow);">
                                        <i class="fas fa-cog"></i> Atur
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Setting Template -->
<div class="modal fade" id="modalSettingTemplate" tabindex="-1" aria-labelledby="modalSettingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: 3px solid var(--retro-dark); border-radius: 12px; box-shadow: 6px 6px 0px var(--retro-dark);">
            <div class="modal-header border-bottom border-dark border-2" style="background-color: var(--retro-yellow);">
                <h5 class="modal-title fw-bolder text-dark" id="modalSettingLabel">
                    <i class="fas fa-sliders-h me-2"></i> Konfigurasi Template Form
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSettingTemplate">
                @csrf
                <div class="modal-body p-4" style="background-color: var(--retro-bg);">
                    <input type="hidden" id="poli_id" name="poli_id">

                    <div class="mb-3">
                        <label class="fw-bolder text-dark mb-1">Nama Poliklinik</label>
                        <input type="text" id="nama_poli" class="form-control form-control-retro bg-light" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bolder text-dark mb-1">Pilih Jenis Template <span class="text-danger">*</span></label>
                        <select id="jenis_template" name="jenis_template" class="form-select form-select-retro" required>
                            <option value="">-- Pilih Format Template --</option>
                            @foreach($template_options as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                        <small class="fw-bold mt-1 d-block opacity-75">Template menentukan form utama yang tampil saat dokter melayani pasien.</small>
                    </div>

                    <!-- TAMBAHAN: PENGATURAN MENU FORM AKTIF -->
                    <div class="mb-3">
                        <label class="fw-bolder text-dark mb-2">Pengaturan Menu / Form yang Ditampilkan:</label>
                        <div class="p-3 bg-white border border-dark rounded-3" style="box-shadow: 2px 2px 0px var(--retro-dark);">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox border-dark" type="checkbox" name="menu_form[]" value="anamnesa" id="menu_anamnesa" checked>
                                        <label class="form-check-label fw-bold text-dark" for="menu_anamnesa">Anamnesa</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox border-dark" type="checkbox" name="menu_form[]" value="vital_sign" id="menu_vital_sign" checked>
                                        <label class="form-check-label fw-bold text-dark" for="menu_vital_sign">Fisik & Vital Sign</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox border-dark" type="checkbox" name="menu_form[]" value="odontogram" id="menu_odontogram">
                                        <label class="form-check-label fw-bold text-dark" for="menu_odontogram">Odontogram (Gigi)</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox border-dark" type="checkbox" name="menu_form[]" value="tindakan" id="menu_tindakan" checked>
                                        <label class="form-check-label fw-bold text-dark" for="menu_tindakan">Order Tindakan</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox border-dark" type="checkbox" name="menu_form[]" value="resep" id="menu_resep" checked>
                                        <label class="form-check-label fw-bold text-dark" for="menu_resep">E-Resep Obat</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input menu-checkbox border-dark" type="checkbox" name="menu_form[]" value="diagnosa" id="menu_diagnosa" checked>
                                        <label class="form-check-label fw-bold text-dark" for="menu_diagnosa">Diagnosa Akhir</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="fw-bolder text-dark mb-1">Keterangan / Instruksi Khusus</label>
                        <textarea id="keterangan" name="keterangan" class="form-control form-control-retro" rows="2" placeholder="Contoh: Wajib isi form lengkap..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top border-dark border-2 bg-white">
                    <button type="button" class="btn btn-light btn-retro text-dark px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-retro text-dark px-4" style="background-color: var(--retro-green);">
                        <i class="fas fa-save me-1"></i> Simpan Setting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#table-template').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            }
        });

        // Trigger Modal Setting
        $(document).on('click', '.btn-setting', function() {
            const poli_id = $(this).data('id');
            const nama_poli = $(this).data('nama');
            const template = $(this).data('template');
            const keterangan = $(this).data('keterangan');

            // Ambil data menu aktif dalam format JSON (Passing dari attribute data-menu di tr/button)
            let menuAktif = $(this).attr('data-menu');

            $('#poli_id').val(poli_id);
            $('#nama_poli').val(nama_poli);
            $('#jenis_template').val(template);
            $('#keterangan').val(keterangan);

            // Reset dan centang checkbox berdasarkan data tersimpan
            $('.menu-checkbox').prop('checked', false);
            if (menuAktif) {
                try {
                    let menus = JSON.parse(menuAktif);
                    menus.forEach(function(menu) {
                        $(`#menu_${menu}`).prop('checked', true);
                    });
                } catch (e) {
                    console.error("Gagal parse JSON menu aktif");
                }
            } else {
                // Default centang semua jika belum disetting
                $('.menu-checkbox').prop('checked', true);
            }

            $('#modalSettingTemplate').modal('show');
        });

        // Handle Submit Form Setting
        $('#formSettingTemplate').submit(function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            // Lakukan AJAX Post ke route penyimpanan Anda (misal: route('save_template_poli'))
            $.ajax({
                url: "{{ route('save_template_poli') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#modalSettingTemplate').modal('hide');
                    Swal.fire({
                        title: "Tersimpan!",
                        text: "Setting template poliklinik berhasil diupdate.",
                        icon: "success",
                        confirmButtonClass: "btn btn-success btn-retro",
                        buttonsStyling: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan sistem.",
                        icon: "error",
                        confirmButtonClass: "btn btn-danger btn-retro",
                        buttonsStyling: false
                    });
                }
            });
        });
    });
</script>
@endsection
