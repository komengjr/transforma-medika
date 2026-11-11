@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<style>
    /* --- TEMA RETRO / NEUBRUTALISM --- */
    .retro-wrap {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-orange: #ff914d;
        --retro-bg: #f4f0ea;
    }

    .retro-wrap .card-retro {
        border: 3px solid var(--retro-dark);
        border-radius: 12px;
        box-shadow: 4px 4px 0px var(--retro-dark);
        background: #ffffff;
        margin-bottom: 1rem;
    }

    .retro-wrap .form-control,
    .retro-wrap .form-select {
        border: 2px solid var(--retro-dark) !important;
        background-color: #ffffff;
        font-weight: 700;
        color: var(--retro-dark);
    }

    .retro-wrap .form-control:focus,
    .retro-wrap .form-select:focus {
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-color: var(--retro-dark) !important;
    }

    .retro-wrap .btn-retro {
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark);
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-radius: 6px;
        transition: all 0.1s;
    }

    .retro-wrap .btn-retro:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-wrap .table-retro th {
        background-color: var(--retro-dark);
        /* color: #fff; */
        border: 2px solid var(--retro-dark);
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    .retro-wrap .table-retro td {
        border: 2px solid var(--retro-dark);
        font-weight: 700;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div class="retro-wrap">
    <!-- Header Banner -->
    <div class="row mb-3">
        <div class="col">
            <div class="card-retro p-3 d-flex flex-row align-items-center justify-content-between" style="background-color: var(--retro-yellow);">
                <div class="d-flex align-items-center">
                    <img class="mx-3" src="{{ asset('img/verif.png') }}" alt="" width="70" />
                    <div>
                        <h6 class="text-dark fs--1 mb-0 fw-bold">MANAGEMENT SYSTEM</h6>
                        <h3 class="text-dark fw-bolder mb-0">Verifikasi Dokter Poliklinik</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian Section -->
    <div class="card-retro mb-4">
        <div class="card-header border-bottom border-dark border-3 py-3" style="background-color: var(--retro-cyan);">
            <h5 class="mb-0 fw-bolder text-dark"><i class="fas fa-filter me-2"></i> Filter Data Pasien</h5>
        </div>
        <div class="card-body p-4 bg-white">
            <form method="GET" action="" class="row g-3">
                <!-- Filter Range Tanggal -->
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark">Range Tanggal Registrasi</label>
                    <div class="input-group">
                        <input type="date" name="start_date" class="form-control form-control-retro" value="{{ request('start_date', date('Y-m-d')) }}">
                        <span class="input-group-text fw-bold border-dark border-2 bg-warning">s/d</span>
                        <input type="date" name="end_date" class="form-control form-control-retro" value="{{ request('end_date', date('Y-m-d')) }}">
                    </div>
                </div>

                <!-- Filter Pilihan Poliklinik -->
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark">Pilih Poliklinik</label>
                    <select name="poli_id" class="form-select form-select-retro">
                        <option value="">-- Semua Poliklinik --</option>
                        @foreach($polis ?? [] as $p)
                        <option value="{{ $p->id }}" {{ request('poli_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_poli }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Aksi Filter -->
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-dark btn-retro w-50" style="background-color: var(--retro-dark); color: #fff;">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-light btn-retro w-50 border-dark">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Pasien -->
    <div class="card-retro">
        <div class="card-header border-bottom border-dark border-3 py-3" style="background-color: var(--retro-purple);">
            <h5 class="mb-0 fw-bolder text-dark"><i class="fas fa-list-alt me-2"></i> Daftar Pasien Menunggu Verifikasi</h5>
        </div>
        <div class="card-body p-4 bg-white">
            <table id="example" class="table table-retro w-100">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">No Registrasi</th>
                        <th width="20%">Nama Pasien</th>
                        <th width="15%">Tanggal Reg</th>
                        <th width="15%">Poliklinik</th>
                        <th width="15%">Dokter Pemeriksa</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="5%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="fw-bold"><span class="badge bg-warning text-dark border border-dark">{{ $datas->no_registrasi }}</span></td>
                        <td>
                            <div class="fw-bolder">{{ $datas->master_patient_name }}</div>
                            <div class="fs--1 text-muted">RM: {{ $datas->master_patient_code }}</div>
                        </td>
                        <td>{{ $datas->tanggal_registrasi }}</td>
                        <td><span class="badge bg-light text-dark border border-dark">{{ $datas->m_poli_name ?? '-' }}</span></td>
                        <td><i class="fas fa-user-md me-1 text-primary"></i> {{ $datas->master_doctor_name ?? 'Belum Ditentukan' }}</td>
                        <td class="text-center">
                            @if (isset($datas->status_verifikasi_dokter) && $datas->status_verifikasi_dokter == 'Verified')
                            <span class="badge bg-success border border-dark text-dark">Verified</span>
                            @else
                            <span class="badge bg-danger border border-dark text-white">Not Verified</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-retro text-dark px-3" style="background-color: var(--retro-cyan);"
                                data-bs-toggle="modal" data-bs-target="#modal-poliklinik"
                                id="button-proses-verifikasi" data-code="{{ $datas->no_registrasi }}">
                                <i class="fas fa-stethoscope me-1"></i> Verifikasi
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Handling -->
<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-3 border-dark" style="border-radius: 12px; overflow: hidden;">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle bg-danger text-white border border-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });

    // Klik Tombol Verifikasi (Membuka Form Handling Detail)
    $(document).on("click", "#button-proses-verifikasi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-poliklinik').html(
            '<div class="text-center p-5"><div class="spinner-border text-dark" role="status"></div><h5 class="mt-2 fw-bold">Memuat Form Pemeriksaan...</h5></div>'
        );
        $.ajax({
            url: "{{ route('verifikasi_poliklinik_dokter_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-poliklinik').html(data);
        }).fail(function() {
            $('#menu-poliklinik').html('<div class="alert alert-danger m-3 text-center fw-bold">Gagal memuat form verifikasi.</div>');
        });
    });

    // Simpan & Verifikasi Final oleh Dokter
    $(document).on("click", "#button-save-data-diagnosa-pasien-poli", function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Verifikasi & Simpan Pemeriksaan?",
            text: "Data anamnesa, vital sign, tindakan, resep, dan diagnosa akan diverifikasi final oleh dokter.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Verifikasi!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-success btn-retro mx-2",
                cancelButton: "btn btn-danger btn-retro mx-2"
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = $('#form-handling-medis').serialize();

                $.ajax({
                    url: "{{ route('store_handling_medis') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Menyimpan data pemeriksaan poli.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            var regCode = $('input[name="no_registrasi"]').val();

                            $.ajax({
                                url: "{{ route('verifikasi_poliklinik_dokter_save_verify') }}",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "code": regCode
                                },
                                dataType: "json",
                                success: function(res) {
                                    Swal.fire({
                                        title: "Berhasil Terverifikasi!",
                                        text: "Pemeriksaan pasien poli telah disetujui oleh dokter.",
                                        icon: "success"
                                    }).then(() => {
                                        $('.modal').modal('hide');
                                        location.reload();
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Terjadi kesalahan saat menyimpan data.'
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
