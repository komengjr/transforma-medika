<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <!-- Judul Dinamis -->
        <h4 class="mb-1 text-white" id="staticBackdropLabel">
            {{ isset($doctor) ? 'Edit Data Dokter' : 'Tambah Dokter Baru' }}
        </h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="text-warning fw-semi-bold" href="#!">Transforma</a></p>
    </div>

    <!-- Cukup ubah pada baris <form ...> ini saja dengan menambahkan ID -->
    <form id="form-save-doctor" class="row g-3 p-4" action="{{ route('master_doctor_data_doctor_save') }}" method="post" enctype="multipart/form-data">
        @csrf

        <!-- (Isi input form biarkan sama seperti sebelumnya) -->

        <!-- PENTING: Input hidden untuk menyimpan kode_dokter saat mode edit -->
        @if(isset($doctor))
        <input type="hidden" name="kode_dokter" value="{{ $doctor->kode_dokter }}">
        @endif

        <!-- BAGIAN UPLOAD & PREVIEW FOTO -->
        <div class="col-md-12 text-center mb-3">
            <div class="d-inline-block position-relative">
                <!-- Preview Image -->
                <img id="previewFoto"
                    src="{{ isset($doctor) && $doctor->foto ? asset('storage/doctors/' . $doctor->foto) : asset('img/doctor.png') }}"
                    alt="Preview Foto"
                    class="rounded-circle border border-3 border-primary shadow-sm"
                    style="width: 120px; height: 120px; object-fit: cover;">

                <!-- Label sebagai tombol ganti foto (menutupi input file asli) -->
                <label for="inputFoto" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer shadow" style="cursor: pointer;" title="Ubah Foto">
                    <span class="fas fa-camera"></span>
                </label>
            </div>

            <!-- Input File Asli (disembunyikan secara visual) -->
            <input type="file" id="inputFoto" name="profile" class="d-none" accept="image/*" onchange="previewImage(event)">
            <div class="form-text mt-2 text-muted fs--2">Format yang diizinkan: JPG, PNG, JPEG. (Maks 2MB)</div>
        </div>
        <!-- END BAGIAN UPLOAD & PREVIEW FOTO -->

        <div class="col-md-6">
            <label class="form-label fw-bold">Nama Lengkap & Gelar</label>
            <input class="form-control form-control-lg" type="text" name="nama_lengkap"
                placeholder="Contoh: Dr. Andi Wijaya, Sp.PD" value="{{ isset($doctor) ? $doctor->nama_lengkap : '' }}" required />
        </div>

        <!-- Ganti kolom Spesialisasi ini -->
        <div class="col-md-6">
            <label class="form-label fw-bold">Spesialisasi</label>
            <select name="kode_spesialis" class="form-select form-select-lg" required>
                <option value="" disabled {{ !isset($doctor) ? 'selected' : '' }}>Pilih Spesialisasi</option>

                @foreach($listSpesialis as $sp)
                <option value="{{ $sp->kode_spesialis }}"
                    {{ (isset($doctor) && $doctor->kode_spesialis == $sp->kode_spesialis) ? 'selected' : '' }}>
                    {{ $sp->nama_spesialis }}
                </option>
                @endforeach

            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">NIK Dokter</label>
            <input class="form-control form-control-lg" type="text" name="nik"
                placeholder="Nomor Induk Kependudukan" value="{{ isset($doctor) ? $doctor->nik : '' }}" />
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">No. SIP (Surat Izin Praktik)</label>
            <input class="form-control form-control-lg" type="text" name="sip"
                placeholder="Nomor SIP" value="{{ isset($doctor) ? $doctor->sip : '' }}" />
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Email</label>
            <input class="form-control form-control-lg" type="email" name="email"
                placeholder="contoh@gmail.com" value="{{ isset($doctor) ? $doctor->email : '' }}" />
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">No Handphone</label>
            <input class="form-control form-control-lg" type="text" name="no_telp"
                placeholder="08123456789" value="{{ isset($doctor) ? $doctor->no_telp : '' }}" required />
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select form-select-lg" required>
                <option value="" disabled {{ !isset($doctor) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                <option value="L" {{ (isset($doctor) && $doctor->jenis_kelamin == 'L') ? 'selected' : '' }}>Laki - Laki</option>
                <option value="P" {{ (isset($doctor) && $doctor->jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Status Keaktifan</label>
            <select name="is_active" class="form-select form-select-lg" required>
                <option value="1" {{ (isset($doctor) && $doctor->is_active == 1) ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ (isset($doctor) && $doctor->is_active == 0) ? 'selected' : '' }}>Non-Aktif</option>
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label fw-bold">Alamat Praktik / Rumah</label>
            <textarea class="form-control" name="alamat" rows="2" placeholder="Alamat lengkap...">{{ isset($doctor) ? $doctor->alamat : '' }}</textarea>
        </div>

        <div class="col-md-12 text-end mt-4">
            <button class="btn btn-secondary px-4 me-2" type="button" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary px-4" type="submit"><span class="fas fa-save me-1"></span> Simpan Perubahan</button>
        </div>
    </form>
</div>

<!-- Script untuk Preview Foto -->
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();

        reader.onload = function() {
            const preview = document.getElementById('previewFoto');
            preview.src = reader.result;
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]); // Membaca file dan menjadikannya URL base64 untuk preview di browser saja
        }
    }
</script>
