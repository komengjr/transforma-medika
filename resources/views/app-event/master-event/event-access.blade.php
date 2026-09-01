@extends('layouts.layouts')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            {{-- Alert Notifikasi --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="m-0 font-weight-bold text-primary">Daftar Hak Akses Event</h5>
                        <small class="text-muted">Kelola hak akses user untuk seluruh event</small>
                    </div>

                    <!-- Tombol Trigger Modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAkses">
                        <i class="fas fa-user-plus me-1"></i> Tambah Akses User
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Event</th>
                                    <th>Nama User</th>
                                    <th>User ID</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accesses as $key => $access)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <strong>{{ $access->event_data_tittle ?? '-' }}</strong><br>
                                        <small class="text-muted">Kode: {{ $access->event_data_code ?? '-' }}</small>
                                    </td>
                                    <td><strong>{{ $access->user_name ?? '-' }}</strong></td>
                                    <td><code>{{ $access->userid }}</code></td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ ucfirst($access->role) }}</span>
                                    </td>
                                    <td>
                                        @if($access->status == 1)
                                        <span class="badge bg-success">Aktif</span>
                                        @else
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('event.access.destroy', $access->id_event_data_access) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akses ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data akses user.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ================= MODAL TAMBAH AKSES USER ================= -->
<div class="modal fade" id="modalTambahAkses" tabindex="-1" aria-labelledby="modalTambahAksesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahAksesLabel"><i class="fas fa-user-lock me-2"></i>Tambah Akses User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('event.access.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Pilih Event --}}
                    <div class="mb-3">
                        <label for="event_data_id" class="form-label font-weight-bold">Pilih Event <span class="text-danger">*</span></label>
                        <select name="event_data_id" id="event_data_id" class="form-select @error('event_data_id') is-invalid @enderror" required>
                            <option value="" selected disabled>-- Pilih Event --</option>
                            @foreach($events as $event)
                            <option value="{{ $event->id_event_data }}">{{ $event->event_data_tittle }} ({{ $event->event_data_code }})</option>
                            @endforeach
                        </select>
                        @error('event_data_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilih User dari tabel user_mains --}}
                    <div class="mb-3">
                        <label for="userid" class="form-label font-weight-bold">Pilih User <span class="text-danger">*</span></label>
                        <select name="userid" id="userid" class="form-select @error('userid') is-invalid @enderror" required>
                            <option value="" selected disabled>-- Pilih User --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->userid }}">{{ $user->fullname }} (ID: {{ $user->userid }})</option>
                            @endforeach
                        </select>
                        @error('userid')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilih Role --}}
                    <div class="mb-3">
                        <label for="role" class="form-label font-weight-bold">Role Akses <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                            <option value="viewer">Viewer</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Akses</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
