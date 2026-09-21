<div class="modal-header border-bottom">
    <h5 class="modal-title text-primary fw-bold" id="modalFormAksesLoginLabel">
        <i class="bi bi-key-fill me-2"></i>Buat Akses Login Pegawai
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form id="form-akses-login" method="POST">
    @csrf
    <div class="modal-body p-4">
        <!-- Alert Info Pegawai -->
        <div class="alert alert-soft-primary bg-light border-primary border-start border-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-badge-fill text-primary fs-3 me-3"></i>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">{{ $pegawai->hrm_m_pegawai_name }}</h6>
                    <small class="text-muted">Kode Pegawai: <strong>{{ $pegawai->hrm_m_pegawai_code }}</strong></small>
                </div>
            </div>
        </div>

        <input type="hidden" name="pegawai_code" value="{{ $pegawai->hrm_m_pegawai_code }}">
        <input type="hidden" name="fullname" value="{{ $pegawai->hrm_m_pegawai_name }}">

        <div class="row g-3">
            <!-- Username -->
            <div class="col-md-6">
                <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                    <input type="text" class="form-control" id="username" name="username"
                        value="{{ strtolower(str_replace(' ', '', $pegawai->hrm_m_pegawai_name)) }}"
                        placeholder="Masukkan username" required>
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ $pegawai->hrm_m_pegawai_email }}"
                        placeholder="nama@email.com" required>
                </div>
            </div>

            <!-- No HP -->
            <div class="col-md-6">
                <label for="number_handphone" class="form-label fw-semibold">No. Handphone</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input type="text" class="form-control" id="number_handphone" name="number_handphone"
                        value="{{ $pegawai->hrm_m_pegawai_hp }}"
                        placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <!-- Password -->
            <div class="col-md-6">
                <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Minimal 6 karakter" required>
                </div>
            </div>

            <!-- Akses Cabang -->
            <div class="col-md-6">
                <label for="access_cabang" class="form-label fw-semibold">Akses Cabang <span class="text-danger">*</span></label>
                <select class="form-select" id="access_cabang" name="access_cabang" required>
                    <option value="" disabled selected>-- Pilih Cabang --</option>
                    <option value="HO">Head Office (HO)</option>
                    <option value="CABANG_01">Cabang Utama</option>
                    <option value="ALL">Semua Cabang</option>
                </select>
            </div>

            <!-- Akses Code / Role -->
            <div class="col-md-6">
                <label for="access_code" class="form-label fw-semibold">Role Akses <span class="text-danger">*</span></label>
                <select class="form-select" id="access_code" name="access_code" required>
                    <option value="" disabled selected>-- Pilih Role --</option>
                    <option value="ADMIN">Administrator</option>
                    <option value="HRD">Staff HRD</option>
                    <option value="MANAGER">Manager</option>
                    <option value="STAFF">Staff Regular</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer bg-light border-top">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary rounded-pill px-4" id="btn-submit-akses-login">
            <i class="bi bi-check-circle me-1"></i> Simpan Akses
        </button>
    </div>
</form>

<script>
    $('#form-akses-login').on('submit', function(e) {
        e.preventDefault();

        var $btn = $('#btn-submit-akses-login');
        var originalText = $btn.html();

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Menyimpan...');

        $.ajax({
            url: "{{ route('master_data_pegawai_save_login') }}",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modal-pegawai-xl').modal('hide');
                        if (typeof filterPegawai === 'function') {
                            filterPegawai(); // Refresh grid data jika ada
                        } else {
                            location.reload();
                        }
                    });
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(originalText);

                var errorMsg = 'Terjadi kesalahan sistem.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMsg
                });
            }
        });
    });
</script>
