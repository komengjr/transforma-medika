@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
<!-- HEADER / BANNER -->
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow-sm border border-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom border-sm-0 p-3">
                    <img class="me-3" src="{{ asset('img/doctor.png') }}" alt="Doctor Icon" width="50" />
                    <div>
                        <h6 class="text-primary fs--1 mb-0">Welcome to</h6>
                        <h4 class="text-primary fw-bold mb-0">MCU <span class="fw-normal">Management System</span></h4>
                    </div>
                    <img class="ms-4 d-none d-lg-block" src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="130" />
                </div>
                <div class="col-xl-auto px-4 py-2 text-end">
                    <h6 class="text-primary fs--1 mb-0">Menu :</h6>
                    <h4 class="text-primary fw-bold mb-0">Master <span class="fw-normal">Doctor</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CARD TABLE -->
<div class="card mb-3 shadow-sm border">
    <div class="card-header bg-primary py-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-6 col-sm-auto">
                <h5 class="mb-0 text-white d-flex align-items-center">
                    <span class="fas fa-user-md me-2"></span> Data Dokter
                </h5>
            </div>
            <div class="col-6 col-sm-auto text-end">
                <!-- Quick Action Buttons -->
                <button class="btn btn-sm btn-light text-primary me-1 fw-semi-bold" data-bs-toggle="modal" data-bs-target="#modal-doctor" id="button-add-doctor" data-code="0">
                    <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span> Tambah Dokter
                </button>
                <button class="btn btn-sm btn-success fw-semi-bold me-1" data-bs-toggle="modal" data-bs-target="#modal-import-excel">
                    <span class="fas fa-file-excel me-1" data-fa-transform="shrink-3"></span> Import Excel
                </button>

                <!-- Dropdown Menu Options -->
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-falcon-default dropdown-toggle" id="btnGroupVerticalDrop2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-ellipsis-v" data-fa-transform="shrink-3"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupVerticalDrop2">
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-doctor" id="button-add-doctor" data-code="0">
                            <span class="fas fa-user-plus me-2 text-primary"></span> Tambah Dokter
                        </button>
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-import-excel">
                            <span class="fas fa-file-excel me-2 text-success"></span> Import Data Excel
                        </button>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang" id="button-data-barang-cabang" data-code="123">
                            <span class="fas fa-history me-2 text-warning"></span> History Log
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-3">
        <table id="example" class="table table-striped table-hover align-middle nowrap fs--1" style="width:100%">
            <thead class="bg-200 text-800">
                <tr>
                    <th class="text-center" style="width: 50px;">No</th>
                    <th>ID Dokter</th>
                    <th>NIK Dokter</th>
                    <th>Nama Dokter</th>
                    <th>No Handphone</th>
                    <th>Email</th>
                    <th class="text-center" style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($data as $datas)
                <tr>
                    <td class="text-center fw-bold">{{ $no++ }}</td>
                    <td><span class="badge bg-soft-primary text-primary fs--2">{{ $datas->master_doctor_code }}</span></td>
                    <td><span class="text-600 fw-semi-bold">{{ $datas->master_doctor_nik }}</span></td>
                    <td class="fw-bold text-dark">
                        {{ trim(($datas->master_doctor_title_f ?? '') . ' ' . $datas->master_doctor_name . ' ' . ($datas->master_doctor_title_e ?? '')) }}
                    </td>
                    <td>
                        @if($datas->master_doctor_hp)
                        <span class="fas fa-phone me-1 text-primary fs--2"></span>{{ $datas->master_doctor_hp }}
                        @else
                        <span class="text-400 italic">-</span>
                        @endif
                    </td>
                    <td>
                        @if($datas->master_doctor_email)
                        <span class="fas fa-envelope me-1 text-primary fs--2"></span>{{ $datas->master_doctor_email }}
                        @else
                        <span class="text-400 italic">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fas fa-cog"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-doctor" id="button-add-doctor" data-code="{{ $datas->master_doctor_code }}">
                                    <span class="fas fa-edit me-2 text-info"></span> Edit Data Dokter
                                </button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-danger" id="button-delete-doctor" data-code="{{ $datas->master_doctor_code }}">
                                    <span class="fas fa-trash-alt me-2"></span> Hapus Dokter
                                </button>
                            </div>
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
<!-- MODAL FORM DOKTER (ADD / EDIT) -->
<div class="modal fade" id="modal-doctor" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-doctor"></div>
        </div>
    </div>
</div>

<!-- MODAL IMPORT EXCEL DOKTER -->
<div class="modal fade" id="modal-import-excel" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white" id="modalImportExcelLabel">
                    <span class="fas fa-file-excel me-2"></span> Import Data Dokter via Excel
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('master_doctor_data_doctor_import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3 text-center">
                        <p class="text-700 fs--1">Gunakan template format Excel di bawah ini untuk menghindari kesalahan format struktur kolom data saat import.</p>
                        <a href="{{ route('master_doctor_download_template') }}" class="btn btn-sm btn-outline-success">
                            <span class="fas fa-download me-1"></span> Unduh Template Format Excel
                        </a>
                    </div>
                    <hr class="my-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" for="file_excel">Pilih Berkas Excel (.xlsx / .xls)</label>
                        <input class="form-control" type="file" id="file_excel" name="file_excel" accept=".xlsx, .xls, .csv" required />
                        <div class="form-text fs--2 text-muted">Maksimal ukuran file: 5 MB</div>
                    </div>
                </div>
                <div class="modal-footer bg-100">
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-sm btn-success" type="submit">
                        <span class="fas fa-upload me-1"></span> Upload & Import Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

<script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data dokter"
            }
        });
    });

    $(document).on("click", "#button-add-doctor", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-doctor').html(
            '<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-muted">Memuat Form Data...</p></div>'
        );
        $.ajax({
            url: "{{ route('master_doctor_data_doctor_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-doctor').html(data);
        }).fail(function() {
            $('#menu-doctor').html('<div class="alert alert-danger m-3">Terjadi kesalahan saat memuat form!</div>');
        });
    });
</script>
@endsection
