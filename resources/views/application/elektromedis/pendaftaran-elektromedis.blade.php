@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<!-- FontAwesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-0"><i class="fas fa-heartbeat text-primary me-2"></i> Pendaftaran Elektromedis</h3>
                <p class="text-muted mb-0">Manajemen Antrean & Pemeriksaan Penunjang Elektromedik Rumah Sakit</p>
            </div>
            <!-- Tombol Trigger Modal Pendaftaran -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPendaftaran">
                <i class="fas fa-plus me-1"></i> Tambah Pendaftaran
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Tabel Data Pasien -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <table id="tableElektromedis" class="table table-striped table-bordered dt-responsive nowrap align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th>No. Reg</th>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>Unit Asal</th>
                        <th>Pemeriksaan</th>
                        <th>Jadwal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $index => $row)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><span class="fw-bold text-primary">{{ $row->registration_number }}</span></td>
                        <td>{{ $row->medical_record_number }}</td>
                        <td>{{ $row->patient_name }}</td>
                        <td>{{ $row->origin_unit }}</td>
                        <td><span class="badge bg-info text-dark">{{ $row->examination_type }}</span></td>
                        <td>{{ date('d/m/Y H:i', strtotime($row->scheduled_at)) }}</td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ $row->status }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <!-- Tombol Aksi Detail / Input Hasil Pemeriksaan (Opsional) -->
                                <a href="#" class="btn btn-outline-info" title="Detail / Hasil">
                                    <i class="fas fa-stethoscope"></i>
                                </a>
                                <!-- Tombol Hapus -->
                                <a href="#" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data pendaftaran ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Pendaftaran -->
<div class="modal fade" id="modalPendaftaran" tabindex="-1" aria-labelledby="modalPendaftaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Form Action menyertakan parameter $akses dan $code (id route) -->
            <form action="{{ route('pendaftaran_elektromedis.store', ['akses' => $akses, 'id' => $code]) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPendaftaranLabel"><i class="fas fa-user-plus me-1"></i> Form Pendaftaran Pasien Elektromedis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">No. Rekam Medis (RM) <span class="text-danger">*</span></label>
                            <input type="text" name="medical_record_number" class="form-control" placeholder="Contoh: 00-12-34-56" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                            <input type="text" name="patient_name" class="form-control" placeholder="Sesuai KTP / Kartu Berobat" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Poli / Unit Asal <span class="text-danger">*</span></label>
                            <select name="origin_unit" class="form-select" required>
                                <option value="">-- Pilih Unit Asal --</option>
                                @foreach($units as $unit)
                                <option value="{{ $unit }}">{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jenis Pemeriksaan Elektromedis <span class="text-danger">*</span></label>
                            <select name="examination_type" class="form-select" required>
                                <option value="">-- Pilih Pemeriksaan --</option>
                                @foreach($examinationTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Jadwal Tindakan <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="scheduled_at" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        $('#tableElektromedis').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>
@endsection
