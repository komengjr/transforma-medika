<div class="card retro-card mb-4 overflow-hidden" style="border: var(--retro-border); box-shadow: var(--retro-shadow);">
    <!-- CARD HEADER -->
    <div class="card-header py-3 px-3 border-bottom border-dark d-flex align-items-center justify-content-between" style="background-color: var(--retro-yellow);">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-user-check text-dark fs-0"></i>
            <h6 class="mb-0 fw-bolder text-dark fs-0">
                Pasien Details No Reg: <span class="text-primary text-decoration-underline">{{ $code }}</span>
            </h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm retro-btn retro-btn-success rounded-2 px-3 fw-bold fs--1 d-flex align-items-center gap-1" id="button-simpan-proses-specimen-collection" data-code="{{ $code }}">
                <i class="fas fa-check-circle"></i> Simpan
            </button>
        </div>
    </div>

    <!-- CARD BODY -->
    <div class="card-body p-3 p-md-4 bg-white" id="menu-proses-specimen-collection">
        <div class="row g-3 align-items-start">

            <!-- AVATAR / PROFILE PHOTO & BADGE CODE -->
            <div class="col-auto text-center pe-md-3">
                <div class="avatar rounded-circle overflow-hidden bg-light mx-auto mb-2" style="width: 100px; height: 100px; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                    @if (empty($data->master_patient_profile))
                    <img src="{{ asset('img/pasien.png') }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                    @else
                    {{-- Render Base64 Image Profile --}}
                    @php
                    $foto = $data->master_patient_profile;
                    $src = str_starts_with($foto, 'data:image') ? $foto : 'data:image/jpeg;base64,' . $foto;
                    @endphp
                    <img src="{{ $src }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                    @endif
                </div>
                <br>
                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                    {{ $data->master_patient_code ?? '-' }}
                </span>
            </div>

            <!-- PATIENT DETAILS (CLEAN LAYOUT) -->
            <div class="col">
                <!-- NAMA & NIK -->
                <div class="mb-3">
                    <h3 class="fw-bolder text-dark mb-1 fs-2">{{ $data->master_patient_name ?? '-' }}</h3>
                    <div class="text-dark fw-bold fs--1 d-flex align-items-center gap-1">
                        <i class="fas fa-id-card text-primary"></i>
                        <span>NIK:</span>
                        <strong class="text-dark">{{ $data->master_patient_nik ?? '-' }}</strong>
                    </div>
                </div>

                <hr class="border-dark my-2" style="border-width: 2px;">

                <!-- GRID INFORMASI TAMBAHAN -->
                <div class="row g-3 pt-1">
                    <!-- NO REKAM MEDIS -->
                    <div class="col-md-4 col-sm-6">
                        <div class="text-dark fw-bold fs--2 mb-1">No. Rekam Medis</div>
                        <div class="fw-bolder text-dark fs-0 d-flex align-items-center gap-1">
                            <i class="fas fa-hashtag fs--1 text-danger"></i>
                            <span>{{ $data->master_patient_code ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- JENIS KELAMIN -->
                    <div class="col-md-4 col-sm-6">
                        <div class="text-dark fw-bold fs--2 mb-1">Jenis Kelamin</div>
                        <div class="fw-bolder text-dark fs-0 d-flex align-items-center gap-1">
                            @if(strtolower($data->master_patient_jk ?? '') == 'laki-laki' || strtolower($data->master_patient_jk ?? '') == 'l')
                            <i class="fas fa-mars text-primary"></i> Laki-laki
                            @elseif(strtolower($data->master_patient_jk ?? '') == 'perempuan' || strtolower($data->master_patient_jk ?? '') == 'p')
                            <i class="fas fa-venus text-danger"></i> Perempuan
                            @else
                            <i class="fas fa-genderless"></i> {{ $data->master_patient_jk ?? '-' }}
                            @endif
                        </div>
                    </div>

                    <!-- TANGGAL LAHIR -->
                    <div class="col-md-4 col-sm-6">
                        <div class="text-dark fw-bold fs--2 mb-1">Tanggal Lahir</div>
                        <div class="fw-bolder text-dark fs-0 d-flex align-items-center gap-1">
                            <i class="far fa-calendar-alt text-warning"></i>
                            <span>{{ $data->master_patient_tgl_lahir ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</span>
                        </div>
                    </div>

                    <!-- TEMPAT LAHIR -->
                    <div class="col-md-4 col-sm-6">
                        <div class="text-dark fw-bold fs--2 mb-1">Tempat Lahir</div>
                        <div class="fw-bolder text-dark fs-0 d-flex align-items-center gap-1">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <span>{{ $data->master_patient_tempat_lahir ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- TABLE: SPECIMEN LIST -->
        <div class="mt-4">
            <h6 class="fw-bolder text-dark mb-2 fs--1 text-uppercase tracking-wider">
                <i class="fas fa-vials text-primary me-1"></i> Daftar Pemeriksaan & Spesimen
            </h6>

            <div class="table-responsive rounded-3">
                <!-- Tabel dengan garis tegas pada setiap kolom (border grid) -->
                <table class="table table-custom align-middle mb-0 fs--1 table-bordered" style="width: 100%; border: 2px solid var(--retro-dark);">
                    <thead style="background-color: var(--retro-dark); color: var(--retro-green);">
                        <tr>
                            <th class="py-2 px-3 fw-bolder" style="border: 2px solid var(--retro-dark); color: var(--retro-green);">Jenis Pemeriksaan / Sampel</th>
                            <th class="py-2 px-3 fw-bolder text-end" style="border: 2px solid var(--retro-dark); color: var(--retro-green);">Aksi Spesimen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemeriksaan as $pem)
                        <tr>
                            <td class="py-3 px-3" style="border: 2px solid var(--retro-dark);">
                                <div class="fw-bolder text-dark mb-0">{{ $pem->t_pemeriksaan_list_name }}</div>
                                <span class="fs--2 text-dark fw-bold">Kode Layanan: {{ $pem->t_pemeriksaan_list_code }} | No. Lab: {{ $pem->order_lab_list_code }}</span>
                                @php
                                // MENGAMBIL SPESIMEN BERDASARKAN TABEL BARU BER-AWALAN MEDICAL_
                                $specimen = DB::table('medical_pem_specimen')
                                ->join('medical_specimen_data', 'medical_specimen_data.id', '=', 'medical_pem_specimen.specimen_data_id')
                                ->where('medical_pem_specimen.master_pemeriksaan_id', $pem->id_t_pemeriksaan_list)
                                ->get();
                                @endphp
                            </td>
                            <td class="py-3 px-3 text-end" style="border: 2px solid var(--retro-dark);">
                                @forelse ($specimen as $spec)
                                @php
                                // Mengecek status pengambilan spesimen di tabel medical_specimen_collection
                                $collection = DB::table('medical_specimen_collection')
                                ->where('specimen_data_id', $spec->id)
                                ->where('no_barcodespesimen', 'LIKE', '%' . $pem->order_lab_list_code . '%')
                                ->first();
                                @endphp

                                <div id="menudata{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id }}" class="d-inline-flex align-items-center gap-1 m-1">

                                    <!-- TOMBOL AKSI SPESIMEN -->
                                    @if ($collection)
                                    @if ($collection->status_koleksi == 'DITERIMA' || $collection->status_koleksi == 'DIPROSES')
                                    <div class="d-inline-flex flex-column align-items-center">
                                        <!-- Tombol Print Satuan Zebra -->
                                        <button class="btn retro-btn retro-btn-success btn-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1 btn-print-barcode-satuan"
                                            data-barcode="{{ $collection->no_barcodespesimen }}"
                                            title="Klik untuk Cetak Barcode Sampel ke Printer Zebra">
                                            <i class="fas fa-barcode"></i> Print ({{ $collection->no_barcodespesimen }})
                                        </button>
                                        <small class="text-dark fw-bold mt-1 fs--2">
                                            {{ $spec->s_specimen_data_name }} ({{ $spec->wadah_tabung }})
                                        </small>
                                    </div>
                                    @else
                                    <div class="d-inline-flex flex-column align-items-center">
                                        <button class="btn retro-btn retro-btn-warning btn-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                                            title="Proses Spesimen">
                                            <i class="fas fa-clock me-1"></i> Proses
                                        </button>
                                        <small class="text-dark fw-bold mt-1 fs--2">
                                            {{ $spec->s_specimen_data_name }}
                                        </small>
                                    </div>
                                    @endif
                                    @else
                                    <!-- JIKA BELUM DIPROSES / BELUM ADA DI COLLECTION -->
                                    <div class="d-inline-flex flex-column align-items-center">
                                        <button class="btn retro-btn btn-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1 btn-mulai-proses"
                                            id="button-collection-specimen{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id }}"
                                            data-pemeriksaan-id="{{ $pem->id_t_pemeriksaan_list }}"
                                            data-specimen-id="{{ $spec->id }}"
                                            data-order-lab="{{ $pem->order_lab_list_code }}"
                                            title="Klik untuk Mulai Ambil/Proses Spesimen"
                                            style="background-color: var(--retro-pink); color: var(--retro-dark);">
                                            <i class="fas fa-vial me-1"></i> Mulai Proses
                                        </button>
                                        <small class="text-dark fw-bold mt-1 fs--2">
                                            {{ $spec->s_specimen_data_name }} — <span class="text-primary fw-bolder">{{ $spec->wadah_tabung ?? 'Tabung Standar' }}</span>
                                        </small>
                                    </div>
                                    @endif
                                </div>
                                @empty
                                <span class="text-dark fw-bold fs--2 fst-italic">Tidak memerlukan spesimen khusus</span>
                                @endforelse
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ACTION FOOTER -->
        <div class="d-flex justify-content-end pt-4 gap-2 border-top border-dark mt-3" style="border-top-width: 2px !important;">
            <button class="btn retro-btn btn-sm px-4 text-white fw-bold" id="button-print-all-barcode" data-reg="{{ $code }}" style="background-color: #0284c7; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                <i class="fas fa-print me-1"></i> Cetak Semua Barcode
            </button>
            <button class="btn retro-btn retro-btn-success btn-sm px-4 fw-bold" id="button-simpan-proses-specimen-collection" data-code="{{ $code }}">
                <i class="fas fa-save me-1"></i> Simpan Keseluruhan
            </button>
        </div>
    </div>
</div>

<!-- SCRIPT HANDLER UNTUK TOMBOL CETAK ZEBRA -->
<script>
    // --- HANDLER CETAK BARCODE ZEBRA (SATUAN) ---
    $(document).off("click", ".btn-print-barcode-satuan").on("click", ".btn-print-barcode-satuan", function(e) {
        e.preventDefault();
        var barcode = $(this).data("barcode");

        // Membuka popup cetak khusus ukuran Zebra
        var printUrl = "{{ route('data_specimen_collection_lab_print_barcode') }}?type=single&barcode=" + barcode;
        var printWindow = window.open(printUrl, '_blank', 'width=600,height=400,toolbar=no,menubar=no,scrollbars=yes');

        if (printWindow) {
            printWindow.focus();
        } else {
            Toast.fire({
                icon: "warning",
                title: "Mohon izinkan pop-up blocker untuk mencetak"
            });
        }
    });

    // --- HANDLER CETAK BARCODE ZEBRA (SEMUA) ---
    $(document).off("click", "#button-print-all-barcode").on("click", "#button-print-all-barcode", function(e) {
        e.preventDefault();
        var reg = $(this).data("reg"); // Nomor Registrasi (REG-...)

        var printUrl = "{{ route('data_specimen_collection_lab_print_barcode') }}?type=all&reg=" + reg;
        var printWindow = window.open(printUrl, '_blank', 'width=600,height=400,toolbar=no,menubar=no,scrollbars=yes');

        if (printWindow) {
            printWindow.focus();
        } else {
            Toast.fire({
                icon: "warning",
                title: "Mohon izinkan pop-up blocker untuk mencetak"
            });
        }
    });

    // --- HANDLER MULAI PROSES SPESIMEN ---
    $(document).off("click", ".btn-mulai-proses").on("click", ".btn-mulai-proses", function(e) {
        e.preventDefault();

        var btn = $(this);
        var pemeriksaan_id = btn.data("pemeriksaan-id");
        var specimen_id = btn.data("specimen-id");
        var order_lab = btn.data("order-lab");

        // Target div container pembungkus tombol berdasarkan ID unik
        var targetContainer = $('#menudata' + pemeriksaan_id + specimen_id);

        Swal.fire({
            title: "Mulai Ambil Spesimen?",
            text: "Sistem akan mencatat waktu mulai (koleksi) spesimen ini.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#c1ff72",
            cancelButtonColor: "#ffa6c9",
            confirmButtonText: "Ya, Mulai!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Ubah status tombol menjadi loading agar tidak diklik berkali-kali
                btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Memproses...');
                btn.prop('disabled', true);

                $.ajax({
                    url: "{{ route('data_specimen_collection_lab_proses') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "pemeriksaan_id": pemeriksaan_id,
                        "specimen_id": specimen_id,
                        "order_lab": order_lab
                    },
                    dataType: 'html', // UBAH KE HTML KARENA CONTROLLER MENGEMBALIKAN TAG HTML
                    success: function(response) {
                        // Cek apakah response mengandung pesan error dari catch Controller (text-danger)
                        if (response.includes('text-danger')) {
                            Swal.fire("Gagal!", "Gagal memproses spesimen.", "error");
                            btn.html('<i class="fas fa-vial me-1"></i> Mulai Proses');
                            btn.prop('disabled', false);
                        } else {
                            // Instan Swap UI: Ganti isi target div dengan tombol Print Barcode dari response
                            targetContainer.html(response);

                            Toast.fire({
                                icon: "success",
                                title: "Spesimen berhasil diproses"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire("Error!", "Terjadi kesalahan pada server.", "error");
                        btn.html('<i class="fas fa-vial me-1"></i> Mulai Proses');
                        btn.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>
