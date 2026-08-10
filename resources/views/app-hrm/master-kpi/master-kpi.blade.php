@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
@endsection

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-primary bg-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/gl.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1" style="color: white !important;">{{ env('APP_LABEL') }}
                            <span class="text-white fw-medium" style="color: white !important;">Management System</span>
                        </h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block"
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0" style="color: white !important;">Master <span
                            class="text-white fw-medium" style="color: white !important;">KPI</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary py-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a class="btn btn-falcon-default btn-sm" href="javascript:void(0)" onclick="location.reload();" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh">
                    <span class="fas fa-sync-alt"></span>
                </a>
                <span class="mx-1 mx-sm-2 text-300">|</span>
                <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="modal"
                    data-bs-target="#modal-kpi" aria-label="Add KPI" id="button-add-master-kpi">
                    <span class="fas fa-plus me-1"></span> Tambah Master KPI
                </button>
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3" id="hasil-pencarian-list">
        <table id="example" class="table table-striped table-hover align-middle" style="width:100%">
            <thead class="bg-200 fs--1">
                <tr>
                    <th width="5%">No</th>
                    <th>Kode KPI</th>
                    <th>Nama KPI</th>
                    <th>Departemen</th>
                    <th>Bobot</th>
                    <th>Target</th>
                    <th>Tipe Penilaian</th>
                    <th>Formula Sistem</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody class="fs--1">
                @php $no = 1; @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td><span class="badge bg-soft-primary text-primary">{{ $datas->hrm_kpi_master_code }}</span></td>
                    <td class="fw-semi-bold">{{ $datas->hrm_kpi_master_name }}</td>
                    <td>{{ $datas->hrm_departemen_name ?? '-' }}</td>
                    <td><span class="fw-bold text-success">{{ $datas->hrm_kpi_master_bobot }}%</span></td>
                    <td>{{ $datas->hrm_kpi_master_target }}</td>
                    <td>
                        @php
                        $type = $datas->hrm_kpi_master_type ?? 'manual';
                        @endphp
                        @if($type === 'manual')
                        <span class="badge bg-secondary">Manual</span>
                        @elseif($type === 'kehadiran')
                        <span class="badge bg-info">Kehadiran</span>
                        @elseif($type === 'sistem')
                        <span class="badge bg-warning text-dark">Sistem</span>
                        @endif
                    </td>
                    <td>
                        @if(($datas->hrm_kpi_master_type ?? '') === 'sistem')
                        <code class="fs--2">{{ $datas->hrm_kpi_master_formula ?? '-' }}</code>
                        @else
                        <span class="text-400 fs--2">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-link text-600 btn-edit-kpi" data-code="{{ $datas->hrm_kpi_master_code }}" data-bs-toggle="tooltip" title="Edit">
                                <span class="fas fa-edit"></span>
                            </button>
                            <button class="btn btn-link text-danger btn-delete-kpi" data-code="{{ $datas->hrm_kpi_master_code }}" data-bs-toggle="tooltip" title="Hapus">
                                <span class="fas fa-trash-alt"></span>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-kpi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-kpi-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-kpi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-kpi"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
            }
        });
    });

    // Handle Tampil Modal Tambah Data
    $(document).on("click", "#button-add-master-kpi", function(e) {
        e.preventDefault();
        $('#menu-kpi').html(
            '<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
        );
        $.ajax({
            url: "{{ route('master_data_kpi_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": "{{ Auth::user()->userid }}"
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-kpi').html(data);
        }).fail(function() {
            $('#menu-kpi').html('<div class="alert alert-danger m-3">Gagal memuat form modal. Silakan coba lagi.</div>');
        });
    });

    // Handle Simpan Data Master KPI
    $(document).on("click", "#button-simpan-data-master-kpi", function(e) {
        e.preventDefault();

        var form = $("#form-master-kpi");
        var data = form.serialize();

        var defaultBtnHtml = '<button class="btn btn-success float-end" id="button-simpan-data-master-kpi" data-code="">Simpan Data</button>';
        $('#menu-add-data-master-kpi').html(
            '<div class="spinner-border text-primary my-1 float-end" role="status"><span class="visually-hidden">Loading...</span></div>'
        );

        $.ajax({
            url: "{{ route('master_data_kpi_save') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message || 'Master KPI berhasil disimpan.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Gagal Menyimpan",
                    text: response.message || "Terjadi kesalahan saat menyimpan data."
                });
                $('#menu-add-data-master-kpi').html(defaultBtnHtml);
            }
        }).fail(function(xhr) {
            let errorMsg = "Terjadi kesalahan pada server.";

            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                let firstKey = Object.keys(errors)[0];
                errorMsg = errors[firstKey][0];
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: errorMsg
            });

            $('#menu-add-data-master-kpi').html(defaultBtnHtml);
        });
    });

    // Toggle Input Formula berdasarkan tipe penilaian
    function toggleFormulaInput(type) {
        const containerFormula = document.getElementById('container_formula');
        const inputFormula = document.getElementById('hrm_kpi_master_formula');

        if (containerFormula && inputFormula) {
            if (type === 'sistem') {
                containerFormula.style.display = 'block';
                inputFormula.setAttribute('required', 'required');
            } else {
                containerFormula.style.display = 'none';
                inputFormula.removeAttribute('required');
                inputFormula.value = '';
            }
        }
    }
</script>
@endsection
