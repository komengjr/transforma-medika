<div class="modal-header border-bottom">
    <h5 class="modal-title text-primary fw-bold" id="modalDetailAksesLoginLabel">
        <i class="bi bi-shield-check me-2"></i>Detail Akses Login Pegawai
    </h5>
    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body p-4">
    <!-- Card Profil & Status Login -->
    <div class="card border-0 bg-light rounded-3 p-3 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center">
                <div class="avatar-wrapper me-3">
                    <img src="{{ $pegawai->hrm_m_pegawai_img ? asset($pegawai->hrm_m_pegawai_img) : asset('img/default-avatar.png') }}"
                        class="rounded-circle border" width="55" height="55" style="object-fit: cover;"
                        onerror="this.src='https://via.placeholder.com/150?text=User'">
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark fs-6">{{ $user->fullname }}</h6>
                    <small class="text-muted d-block">ID Pegawai: <strong>{{ $user->userid }}</strong></small>
                </div>
            </div>
            <div>
                @if($user->access_status == 1)
                <span class="badge bg-success rounded-pill px-3 py-2 fs-7">
                    <i class="bi bi-check-circle-fill me-1"></i> Akun Aktif
                </span>
                @else
                <span class="badge bg-danger rounded-pill px-3 py-2 fs-7">
                    <i class="bi bi-x-circle-fill me-1"></i> Akun Nonaktif
                </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Informasi Detail User -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="p-3 border rounded bg-white h-100">
                <small class="text-muted d-block fw-semibold text-uppercase fs-8 mb-1">Username</small>
                <span class="fw-bold text-dark fs-6"><i class="bi bi-at text-primary me-1"></i>{{ $user->username }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 border rounded bg-white h-100">
                <small class="text-muted d-block fw-semibold text-uppercase fs-8 mb-1">Email Terdaftar</small>
                <span class="fw-bold text-dark fs-6"><i class="bi bi-envelope text-primary me-1"></i>{{ $user->email }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 border rounded bg-white h-100">
                <small class="text-muted d-block fw-semibold text-uppercase fs-8 mb-1">Role Akses</small>
                <span class="badge bg-soft-primary text-primary fw-bold px-2 py-1"><i class="bi bi-person-badge me-1"></i>{{ $user->access_code }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 border rounded bg-white h-100">
                <small class="text-muted d-block fw-semibold text-uppercase fs-8 mb-1">Akses Cabang</small>
                <span class="fw-bold text-dark fs-6"><i class="bi bi-building text-primary me-1"></i>{{ $user->access_cabang }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 border rounded bg-white h-100">
                <small class="text-muted d-block fw-semibold text-uppercase fs-8 mb-1">No. Handphone</small>
                <span class="fw-bold text-dark fs-6"><i class="bi bi-telephone text-primary me-1"></i>{{ $user->number_handphone ?? '-' }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 border rounded bg-white h-100">
                <small class="text-muted d-block fw-semibold text-uppercase fs-8 mb-1">Tanggal Dibuat</small>
                <span class="fw-bold text-dark fs-6"><i class="bi bi-calendar-event text-primary me-1"></i>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Footer & Action Buttons -->
<div class="modal-footer bg-light border-top justify-content-between">
    <div>
        <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-3" id="btn-reset-password" data-userid="{{ $user->userid }}">
            <i class="bi bi-key me-1"></i> Reset Password
        </button>
    </div>
    <div>
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
    </div>
</div>

<script>
    // Handler Reset Password
    $('#btn-reset-password').on('click', function(e) {
        e.preventDefault();
        var userid = $(this).data('userid');

        Swal.fire({
            title: 'Reset Password?',
            text: "Password akan di-reset ke default system!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('master_data_pegawai_reset_password') }}", // Opsional: Route Reset Password
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "userid": userid
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire('Berhasil!', response.message, 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat mereset password.', 'error');
                    }
                });
            }
        });
    });
</script>
