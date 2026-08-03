<style>
    /* Styling khusus tabel pencarian pasien */
    .table-pasien-hover tbody tr {
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .table-pasien-hover tbody tr:hover {
        background-color: #f0f7ff !important;
        transform: translateY(-1px);
    }

    .table-pasien-hover tbody tr:hover .btn-pilih-pasien {
        background-color: #0d6efd !important;
        color: #fff !important;
    }

    /* Foto/Avatar Lingkaran Presisi */
    .avatar-pasien {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #e9ecef;
    }

    .font-monospace-rm {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        letter-spacing: 0.5px;
    }
</style>

<div class="table-responsive p-2">
    <table id="data-pasien" class="table table-hover align-middle table-pasien-hover w-100 border">
        <thead class="bg-light text-secondary">
            <tr class="text-uppercase small fw-bold" style="letter-spacing: 0.5px;">
                <th class="text-center" style="width: 70px;">Pasien</th>
                <th>No. Rekam Medik</th>
                <th>Nama Lengkap & NIK</th>
                <th class="text-center">L/P</th>
                <th>TTL</th>
                <th>No. HP</th>
                <th class="text-center" style="width: 90px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $datas)
            <tr class="btn-pilih-pasien-row" id="button-pilih-data-pasien" data-code="{{ $datas->master_patient_code }}" data-nama="{{ $datas->master_patient_name }}">
                <!-- Foto Pasien -->
                <td class="text-center py-2">
                    @if (empty($datas->master_patient_profile))
                    <img class="avatar-pasien shadow-sm" src="{{ asset('img/pasien.png') }}" alt="Foto Pasien">
                    @else
                    <img class="avatar-pasien shadow-sm" src="{{ Storage::url($datas->master_patient_profile) }}" alt="Foto Pasien">
                    @endif
                </td>

                <!-- No Rekam Medik -->
                <td>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 font-monospace-rm fw-bold">
                        <i class="far fa-address-card me-1"></i>{{ $datas->master_patient_code }}
                    </span>
                </td>

                <!-- Nama Pasien & NIK (Digabung agar ringkas & rapi) -->
                <td>
                    <div class="fw-bold text-dark mb-0">{{ $datas->master_patient_name }}</div>
                    <small class="text-muted d-block">
                        <i class="far fa-credit-card me-1"></i>NIK: {{ $datas->master_patient_nik ?? '-' }}
                    </small>
                </td>

                <!-- Jenis Kelamin dengan Badge Warna -->
                <td class="text-center">
                    @if (strtolower($datas->master_patient_jk) == 'l')
                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2 py-1" title="Laki-Laki">
                        <i class="fas fa-male me-1"></i>L
                    </span>
                    @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1" title="Perempuan">
                        <i class="fas fa-female me-1"></i>P
                    </span>
                    @endif
                </td>

                <!-- Tempat & Tanggal Lahir -->
                <td>
                    <div class="small fw-semibold text-dark">{{ $datas->master_patient_tempat_lahir ?? '-' }}</div>
                    <small class="text-muted">
                        <i class="fas fa-map-marked-alt-event me-1"></i>{{ $datas->master_patient_tgl_lahir ? date('d-m-Y', strtotime($datas->master_patient_tgl_lahir)) : '-' }}
                    </small>
                </td>

                <!-- No Handphone -->
                <td>
                    @if($datas->master_patient_no_hp)
                    <small class="text-dark fw-semibold">
                        <i class="fas fa-whatsapp text-success me-1"></i>{{ $datas->master_patient_no_hp }}
                    </small>
                    @else
                    <span class="text-muted small">-</span>
                    @endif
                </td>

                <!-- Tombol Pilih -->
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold btn-pilih-pasien">
                        Pilih <i class="bi bi-chevron-right ms-1"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable dengan konfig modern
        var tablePasien = $('#data-pasien').DataTable({
            responsive: true,
            pageLength: 5, // Tampilkan 5 data per halaman jika di dalam Modal
            lengthMenu: [
                [5, 10, 25, -1],
                [5, 10, 25, "Semua"]
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Nama / No. RM / NIK...",
                lengthMenu: "Tampil _MENU_ data",
                zeroRecords: "Pasien tidak ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ pasien",
                infoEmpty: "Tidak ada data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='bi bi-chevron-right'></i>",
                    previous: "<i class='bi bi-chevron-left'></i>"
                }
            }
        });

        // Event saat baris pasien diklik
        $('#data-pasien tbody').on('click', 'tr.btn-pilih-pasien-row', function() {
            var patientCode = $(this).data('code');
            var patientName = $(this).data('nama');

            // MASUKKAN KODE KAMU UNTUK MEMILIH PASIEN DI SINI
            // Contoh: Set nilai input form RM
            $('#no_rm').val(patientCode);
            $('#nama_pasien_display').val(patientName);

            // Tutup Modal jika tabel ini berada di dalam Modal BS5
            $('#modal-cari-pasien').modal('hide');
        });
    });
</script>
