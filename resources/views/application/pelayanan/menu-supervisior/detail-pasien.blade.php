<style>
    .modal-header-custom {
        background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        padding: 15px 20px;
        color: #fff;
    }

    .card-box {
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 12px;
        padding: 16px;
        background: inherit;
    }
</style>

<div class="modal-body p-0">
    <!-- Header Modal -->
    <div class="modal-header-custom d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-1 text-white fw-bold"><i class="fas fa-user-shield me-2"></i>Panel Supervisi & Koreksi Data</h5>
            <p class="fs--2 mb-0 text-white-50">No. Registrasi: <strong class="text-white">{{ $pasien->no_registrasi }}</strong></p>
        </div>
        <span class="badge bg-warning text-dark fw-bold px-3 py-1">
            {{ strtoupper($pasien->status_kunjungan) }}
        </span>
    </div>

    <div class="p-4">
        <div class="row g-4">

            <!-- KOLOM KIRI: Form Edit Identitas Pasien -->
            <div class="col-lg-6">
                <div class="card-box h-100">
                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-id-card me-1"></i> Identitas & Data Pasien</h6>

                    <form id="form-update-pasien-supervisior">
                        @csrf
                        <input type="hidden" name="pasien_id" value="{{ $pasien->pasien_id }}">
                        <input type="hidden" name="registrasi_id" value="{{ $pasien->registrasi_id }}">

                        <div class="mb-2">
                            <label class="form-label fs--2 fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-sm fw-bold" name="nama_pasien" value="{{ $pasien->nama_pasien }}">
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label fs--2 fw-bold">Jenis Kelamin</label>
                                <select class="form-select form-select-sm" name="jk">
                                    <option value="L" {{ $pasien->jk == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="P" {{ $pasien->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fs--2 fw-bold">No. HP / WhatsApp</label>
                                <input type="text" class="form-control form-control-sm" name="no_hp" value="{{ $pasien->no_hp }}">
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label fs--2 fw-bold">Tempat Lahir</label>
                                <input type="text" class="form-control form-control-sm" name="tempat_lahir" value="{{ $pasien->tempat_lahir }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label fs--2 fw-bold">Tanggal Lahir</label>
                                <input type="date" class="form-control form-control-sm" name="tgl_lahir" value="{{ $pasien->tgl_lahir }}">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fs--2 fw-bold">Dokter Pemeriksa</label>
                            <input type="text" class="form-control form-control-sm" name="dokter" value="{{ $pasien->dokter }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs--2 fw-bold">Alamat Lengkap</label>
                            <textarea class="form-control form-control-sm" name="alamat" rows="2">{{ $pasien->alamat }}</textarea>
                        </div>

                        <button type="button" class="btn btn-sm btn-primary w-100 fw-bold shadow-sm" id="btn-save-pasien">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan Identitas
                        </button>
                    </form>
                </div>
            </div>

            <!-- KOLOM KANAN: Manajemen Pemeriksaan (Tambah / Hapus) -->
            <div class="col-lg-6">
                <div class="card-box h-100 d-flex flex-column">
                    <h6 class="fw-bold text-info mb-3"><i class="fas fa-stethoscope me-1"></i> Koreksi Daftar Pemeriksaan</h6>

                    <!-- Form Tambah Pemeriksaan Baru -->
                    <div class="bg-light dark__bg-1000 p-2.5 rounded-3 mb-3 border">
                        <label class="form-label fs--2 fw-bold text-secondary mb-1">Tambah Pemeriksaan Baru</label>
                        <div class="input-group input-group-sm">
                            <select class="form-select" id="select_master_pemeriksaan">
                                <option value="">-- Pilih Jenis Pemeriksaan --</option>
                                @foreach($masterPemeriksaan as $mp)
                                <option value="{{ $mp->id }}">{{ $mp->nama_layanan }} (Rp {{ number_format($mp->harga ?? 0, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                            <button class="btn btn-success px-3 fw-bold" type="button" id="btn-tambah-pemeriksaan" data-transid="{{ $transaksi->id ?? 0 }}">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Tabel List Pemeriksaan Aktif -->
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-sm align-middle fs--1 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pemeriksaan</th>
                                    <th>Nama Layanan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pemeriksaanList as $pem)
                                <tr>
                                    <td><strong class="text-primary">{{ $pem->no_pemeriksaan }}</strong></td>
                                    <td>{{ $pem->nama_layanan }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-xs btn-outline-danger btn-hapus-pemeriksaan" data-id="{{ $pem->detail_id }}" title="Hapus Item">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Tidak ada item pemeriksaan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Tagihan & Informasi Keuangan -->
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fs--2 text-muted d-block">Total Tagihan Saat Ini:</span>
                            <h5 class="fw-bold text-success mb-0">Rp {{ $transaksi ? number_format($transaksi->total_tagihan, 0, ',', '.') : '0' }}</h5>
                        </div>
                        <div>
                            <span class="badge bg-secondary">{{ $transaksi->metode_bayar ?? '-' }}</span>
                            <span class="badge bg-info text-dark">{{ $transaksi->status_pembayaran ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal-footer bg-light dark__bg-1000 px-4 py-2.5 d-flex justify-content-between">
    <button type="button" class="btn btn-outline-danger btn-sm fw-bold px-3" id="btn-void-registrasi" data-code="{{ $pasien->registrasi_id }}">
        <i class="fas fa-ban me-1"></i> VOID / Batalkan Seluruh Registrasi
    </button>
    <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
</div>

<script>
    // Fungsi bantuan untuk me-reload isi modal detail secara dinamis tanpa mencari tombol asalnya
    function reloadModalDetail(regId) {
        $.ajax({
            url: "{{ route('menu_pelayanan_supervisior_detail_pasien') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": regId
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-supervisior').html(data);
        });
    }

    // Aksi Simpan Perubahan Identitas Pasien
    $('#btn-save-pasien').on('click', function() {
        var formData = $('#form-update-pasien-supervisior').serialize();

        $.ajax({
            url: "{{ route('menu_pelayanan_supervisior_update_pasien') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Identitas pasien berhasil diperbarui.",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function() {
                Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan data pasien.", "error");
            }
        });
    });

    // Aksi Tambah Pemeriksaan
    $('#btn-tambah-pemeriksaan').on('click', function() {
        var masterId = $('#select_master_pemeriksaan').val();
        var transId = $(this).data('transid');
        var regId = "{{ $pasien->registrasi_id }}"; // Tangkap ID registrasi

        if (!masterId) {
            Swal.fire("Peringatan", "Pilih jenis pemeriksaan terlebih dahulu!", "warning");
            return;
        }

        $.ajax({
            url: "{{ route('menu_pelayanan_supervisior_tambah_pemeriksaan') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "transaksi_id": transId,
                "master_pemeriksaan_id": masterId
            },
            success: function(res) {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Pemeriksaan ditambahkan.",
                    icon: "success",
                    timer: 1200,
                    showConfirmButton: false
                });
                // Reload isi modal secara langsung
                reloadModalDetail(regId);
            },
            error: function() {
                Swal.fire("Gagal", "Gagal menambahkan pemeriksaan.", "error");
            }
        });
    });

    // Aksi Hapus Item Pemeriksaan (Kurangi)
    $('.btn-hapus-pemeriksaan').on('click', function() {
        var detailId = $(this).data('id');
        var regId = "{{ $pasien->registrasi_id }}"; // Tangkap ID registrasi

        Swal.fire({
            title: "Hapus Pemeriksaan?",
            text: "Item pemeriksaan ini akan dihapus dari tagihan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('menu_pelayanan_supervisior_hapus_pemeriksaan') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "detail_id": detailId
                    },
                    success: function(res) {
                        Swal.fire({
                            title: "Terhapus!",
                            text: "Item pemeriksaan berhasil dihapus.",
                            icon: "success",
                            timer: 1200,
                            showConfirmButton: false
                        });
                        // Reload isi modal secara langsung
                        reloadModalDetail(regId);
                    },
                    error: function() {
                        Swal.fire("Gagal", "Gagal menghapus item pemeriksaan.", "error");
                    }
                });
            }
        });
    });

    // Aksi Void / Batalkan Registrasi dari Modal Detail
    $('#btn-void-registrasi').on('click', function() {
        var regId = $(this).data('code');

        Swal.fire({
            title: "Void / Batalkan Registrasi?",
            text: "Masukkan alasan pembatalan total transaksi ini:",
            icon: "warning",
            input: 'textarea',
            inputPlaceholder: 'Ketik alasan pembatalan...',
            showCancelButton: true,
            confirmButtonText: "Ya, Batalkan Semua!",
            cancelButtonText: "Batal",
            confirmButtonColor: "#dc2626",
            preConfirm: (alasan) => {
                if (!alasan) {
                    Swal.showValidationMessage('Alasan wajib diisi!');
                }
                return alasan;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('menu_pelayanan_supervisior_void_registrasi') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": regId,
                        "alasan": result.value
                    },
                    success: function(res) {
                        Swal.fire("Berhasil", "Registrasi telah di-void.", "success");
                        $('#modal-supervisior').modal('hide');
                        location.reload();
                    },
                    error: function() {
                        Swal.fire("Gagal", "Gagal memproses void registrasi.", "error");
                    }
                });
            }
        });
    });
</script>
