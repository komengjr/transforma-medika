@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    #button-dokumentasi-hasil-rad:hover {
        cursor: pointer;
        background: rgba(11, 133, 215, 1);
    }
</style>
@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/verif.png') }}" alt="" width="80" />
                    <div>
                        <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-primary fw-bold mb-1">Trans <span class="text-primary fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                    <h4 class="text-primary fw-bold mb-0">Radiologi <span
                            class="text-primary fw-medium">PACS Server</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="ps-4">No</th>
                        <th scope="col">ID Pasien</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Tanggal Pemeriksaan</th>
                        <th scope="col">Orthanc Study ID</th>
                        <th scope="col" class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studiesList as $index => $study)
                    <tr>
                        <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $study['patient_id'] }}
                            </span>
                        </td>
                        <td class="fw-semibold text-dark">
                            {{ $study['patient_name'] }}
                        </td>
                        <td>
                            <i class="fa-regular fa-calendar-days text-muted me-1"></i>
                            @if($study['study_date'] !== 'N/A' && strlen($study['study_date']) === 8)
                            {{ \Carbon\Carbon::createFromFormat('Ymd', $study['study_date'])->format('d M Y') }}
                            @else
                            {{ $study['study_date'] }}
                            @endif
                        </td>
                        <td>
                            <code class="text-muted small">{{ $study['orthanc_study_id'] }}</code>
                        </td>
                        <td class="text-center pe-4">
                            <!-- Tombol untuk membuka viewer di tab baru -->
                            <a href="{{ route('pacs_server_studies_show', $study['orthanc_study_id']) }}"
                                class="btn btn-sm btn-primary px-3 rounded-pill"
                                target="_blank"
                                title="Buka Preview DICOM">
                                <i class="fa-solid fa-eye me-1"></i> Preview
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary"></i>
                                <h5>Tidak ada data pemeriksaan ditemukan</h5>
                                <p class="small mb-0">Pastikan server Orthanc aktif atau gambar DICOM sudah dikirim dari konsol Fujifilm.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-8 ps-lg-2">
    <span id="menu-detail-handling"></span>
</div>
</div>
<div class="card mt-0">
    <div class="card-body">
        <div class="row justify-content-between align-items-center">
            <div class="col-md">
                {{-- <h5 class="mb-2 mb-md-0">Nice Job! You're almost done</h5> --}}
            </div>
            <div class="col-auto">
                {{-- <button class="btn btn-falcon-default btn-sm me-2">Save</button> --}}
                {{-- <button class="btn btn-falcon-primary btn-sm">Make your event live </button> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>

</script>
@endsection
