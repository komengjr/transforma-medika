<style>
    .spec-detail-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 16px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08) !important;
        overflow: hidden;
    }

    .spec-patient-avatar {
        width: 96px;
        height: 96px;
        border-radius: 18px;
        border: 1px solid var(--ent-grid-border);
        background-color: rgba(79, 70, 229, 0.06);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .spec-info-grid {
        background-color: rgba(79, 70, 229, 0.04);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 14px;
    }

    .spec-item-chip {
        background-color: rgba(79, 70, 229, 0.04);
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px;
        padding: 8px 10px;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .ent-btn-warning {
        background-color: rgba(245, 158, 11, 0.16);
        border: 1px solid rgba(245, 158, 11, 0.45);
        color: #d97706;
    }

    .ent-btn-warning:hover {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
    }

    .ent-btn-info-solid {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    }

    .ent-btn-info-solid:hover {
        box-shadow: 0 6px 16px rgba(2, 132, 199, 0.35);
        color: #ffffff;
    }

    .ent-btn-mulai {
        background-color: rgba(225, 29, 72, 0.14);
        border: 1px solid rgba(225, 29, 72, 0.4);
        color: #e11d48;
    }

    .ent-btn-mulai:hover {
        background-color: #e11d48;
        border-color: #e11d48;
        color: #ffffff;
    }

    [data-bs-theme="dark"] .ent-btn-mulai,
    .dark .ent-btn-mulai {
        color: #fda4af;
    }

    [data-bs-theme="dark"] .ent-btn-mulai:hover,
    .dark .ent-btn-mulai:hover {
        color: #ffffff;
    }
</style>

<div class="card spec-detail-card mb-4">
    <!-- CARD HEADER -->
    <div class="ent-card-header py-3 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <i class="fas fa-user-check text-primary"></i>
            <h6 class="mb-0 fw-bold">
                Pasien Details No Reg:
            </h6>
            <span class="code-chip">{{ $code }}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm ent-btn ent-btn-success px-3 py-1.5 d-flex align-items-center gap-1" id="button-simpan-proses-specimen-collection" data-code="{{ $code }}">
                <i class="fas fa-check-circle"></i> Simpan
            </button>
        </div>
    </div>

    <!-- CARD BODY -->
    <div class="card-body p-3 p-md-4 ent-table-surface" id="menu-proses-specimen-collection">
        <div class="row g-3 g-md-4 align-items-start">

            <!-- AVATAR / PROFILE PHOTO & BADGE CODE -->
            <div class="col-12 col-sm-auto text-center">
                <div class="spec-patient-avatar mx-auto mb-2">
                    @if (empty($data->master_patient_profile))
                        <img src="{{ asset('img/pasien.png') }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                    @else
                        @php
                            $foto = $data->master_patient_profile;
                            $src = str_starts_with($foto, 'data:image') ? $foto : 'data:image/jpeg;base64,' . $foto;
                        @endphp
                        <img src="{{ $src }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                    @endif
                </div>
                <span class="code-chip">{{ $data->master_patient_code ?? '-' }}</span>
            </div>

            <!-- PATIENT DETAILS (CLEAN LAYOUT) -->
            <div class="col">
                <!-- NAMA & NIK -->
                <div class="mb-3">
                    <h5 class="fw-bold mb-1">{{ $data->master_patient_name ?? '-' }}</h5>
                    <div class="small d-flex align-items-center gap-1.5 flex-wrap">
                        <i class="fas fa-id-card text-primary"></i>
                        <span class="opacity-75 fw-semibold">NIK:</span>
                        <strong style="font-family: 'JetBrains Mono', monospace;">{{ $data->master_patient_nik ?? '-' }}</strong>
                    </div>
                </div>

                <!-- GRID INFORMASI TAMBAHAN -->
                <div class="spec-info-grid">
                    <div class="row g-3">
                        <!-- NO REKAM MEDIS -->
                        <div class="col-md-6 col-xl-3">
                            <span class="ent-field-label">No. Rekam Medis</span>
                            <div class="fw-bold small d-flex align-items-center gap-1.5" style="font-family: 'JetBrains Mono', monospace;">
                                <i class="fas fa-hashtag text-danger"></i>
                                <span>{{ $data->master_patient_code ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- JENIS KELAMIN -->
                        <div class="col-md-6 col-xl-3">
                            <span class="ent-field-label">Jenis Kelamin</span>
                            <div class="fw-bold small d-flex align-items-center gap-1.5">
                                @if(strtolower($data->master_patient_jk ?? '') == 'laki-laki' || strtolower($data->master_patient_jk ?? '') == 'l')
                                    <i class="fas fa-mars text-primary"></i> <span>Laki-laki</span>
                                @elseif(strtolower($data->master_patient_jk ?? '') == 'perempuan' || strtolower($data->master_patient_jk ?? '') == 'p')
                                    <i class="fas fa-venus text-danger"></i> <span>Perempuan</span>
                                @else
                                    <i class="fas fa-genderless opacity-75"></i> <span>{{ $data->master_patient_jk ?? '-' }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- TANGGAL LAHIR -->
                        <div class="col-md-6 col-xl-3">
                            <span class="ent-field-label">Tanggal Lahir</span>
                            <div class="fw-bold small d-flex align-items-center gap-1.5" style="font-family: 'JetBrains Mono', monospace;">
                                <i class="far fa-calendar-alt text-warning"></i>
                                <span>{{ $data->master_patient_tgl_lahir ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</span>
                            </div>
                        </div>

                        <!-- TEMPAT LAHIR -->
                        <div class="col-md-6 col-xl-3">
                            <span class="ent-field-label">Tempat Lahir</span>
                            <div class="fw-bold small d-flex align-items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <span>{{ $data->master_patient_tempat_lahir ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- TABLE: SPECIMEN LIST -->
        <div class="mt-4">
            <h6 class="fw-bold mb-2 text-uppercase small d-flex align-items-center gap-2" style="letter-spacing: 0.04em;">
                <i class="fas fa-vials text-primary"></i>
                <span>Daftar Pemeriksaan &amp; Spesimen</span>
            </h6>

            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="py-2.5 px-3 text-start">Jenis Pemeriksaan / Sampel</th>
                            <th class="py-2.5 px-3 text-end" style="width: 38%;">Aksi Spesimen</th>
                        </tr>
                    </thead>
                    <tbody class="ent-table-surface">
                        @foreach ($pemeriksaan as $pem)
                        <tr>
                            <td class="py-3 px-3">
                                <div class="fw-bold mb-1" style="font-size: 0.85rem;">{{ $pem->t_pemeriksaan_list_name }}</div>
                                <div class="d-flex flex-wrap gap-2 small opacity-75" style="font-family: 'JetBrains Mono', monospace; font-size: 0.74rem;">
                                    <span>Kode Layanan: <strong>{{ $pem->t_pemeriksaan_list_code }}</strong></span>
                                    <span>|</span>
                                    <span>No. Lab: <strong>{{ $pem->order_lab_list_code }}</strong></span>
                                </div>
                                @php
                                    $specimen = DB::table('medical_pem_specimen')
                                        ->join('medical_specimen_data', 'medical_specimen_data.id', '=', 'medical_pem_specimen.specimen_data_id')
                                        ->where('medical_pem_specimen.master_pemeriksaan_id', $pem->id_t_pemeriksaan_list)
                                        ->get();
                                @endphp
                            </td>
                            <td class="py-3 px-3 text-end">
                                @forelse ($specimen as $spec)
                                    @php
                                        $collection = DB::table('medical_specimen_collection')
                                            ->where('specimen_data_id', $spec->id)
                                            ->where('no_barcodespesimen', 'LIKE', '%' . $pem->order_lab_list_code . '%')
                                            ->first();
                                    @endphp

                                    <div id="menudata{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id }}" class="d-inline-flex align-items-center gap-1 m-1 spec-item-chip">
                                        @if ($collection)
                                            @if ($collection->status_koleksi == 'DITERIMA' || $collection->status_koleksi == 'DIPROSES')
                                                <div class="d-inline-flex flex-column align-items-center">
                                                    <button type="button" class="btn ent-btn ent-btn-success btn-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1 btn-print-barcode-satuan"
                                                        data-barcode="{{ $collection->no_barcodespesimen }}"
                                                        title="Klik untuk Cetak Barcode Sampel ke Printer Zebra">
                                                        <i class="fas fa-barcode"></i>
                                                        <span style="font-family: 'JetBrains Mono', monospace;">Print ({{ $collection->no_barcodespesimen }})</span>
                                                    </button>
                                                    <small class="opacity-75 fw-semibold mt-1" style="font-size: 0.7rem;">
                                                        {{ $spec->s_specimen_data_name }} ({{ $spec->wadah_tabung }})
                                                    </small>
                                                </div>
                                            @else
                                                <div class="d-inline-flex flex-column align-items-center">
                                                    <button type="button" class="btn ent-btn ent-btn-warning btn-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                                                        title="Proses Spesimen">
                                                        <i class="fas fa-clock me-1"></i> Proses
                                                    </button>
                                                    <small class="opacity-75 fw-semibold mt-1" style="font-size: 0.7rem;">
                                                        {{ $spec->s_specimen_data_name }}
                                                    </small>
                                                </div>
                                            @endif
                                        @else
                                            <div class="d-inline-flex flex-column align-items-center">
                                                <button type="button" class="btn ent-btn ent-btn-mulai btn-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1 btn-mulai-proses"
                                                    id="button-collection-specimen{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id }}"
                                                    data-pemeriksaan-id="{{ $pem->id_t_pemeriksaan_list }}"
                                                    data-specimen-id="{{ $spec->id }}"
                                                    data-order-lab="{{ $pem->order_lab_list_code }}"
                                                    title="Klik untuk Mulai Ambil/Proses Spesimen">
                                                    <i class="fas fa-vial me-1"></i> Mulai Proses
                                                </button>
                                                <small class="opacity-75 fw-semibold mt-1" style="font-size: 0.7rem;">
                                                    {{ $spec->s_specimen_data_name }} — <span class="text-primary fw-bold">{{ $spec->wadah_tabung ?? 'Tabung Standar' }}</span>
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <span class="opacity-75 fw-semibold small fst-italic">Tidak memerlukan spesimen khusus</span>
                                @endforelse
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ACTION FOOTER -->
        <div class="d-flex flex-wrap justify-content-end pt-3 gap-2 mt-4" style="border-top: 1px dashed var(--ent-grid-border);">
            <button type="button" class="btn ent-btn ent-btn-info-solid btn-sm px-4 py-2" id="button-print-all-barcode" data-reg="{{ $code }}">
                <i class="fas fa-print me-1"></i> Cetak Semua Barcode
            </button>
            <button type="button" class="btn ent-btn ent-btn-success btn-sm px-4 py-2" id="button-simpan-proses-specimen-collection" data-code="{{ $code }}">
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

        var printUrl = "{{ route('data_specimen_collection_lab_print_barcode') }}?type=single&barcode=" + encodeURIComponent(barcode);
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
        var reg = $(this).data("reg");

        var printUrl = "{{ route('data_specimen_collection_lab_print_barcode') }}?type=all&reg=" + encodeURIComponent(reg);
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
        if (btn.prop('disabled')) return;

        var pemeriksaan_id = btn.data("pemeriksaan-id");
        var specimen_id = btn.data("specimen-id");
        var order_lab = btn.data("order-lab");

        var targetContainer = $('#menudata' + pemeriksaan_id + specimen_id);

        Swal.fire({
            title: "Mulai Ambil Spesimen?",
            text: "Sistem akan mencatat waktu mulai (koleksi) spesimen ini.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#059669",
            cancelButtonColor: "#e11d48",
            confirmButtonText: "Ya, Mulai!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var originalHtml = btn.html();
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
                    dataType: 'html',
                    success: function(response) {
                        if (response.includes('text-danger')) {
                            Swal.fire("Gagal!", "Gagal memproses spesimen.", "error");
                            btn.html(originalHtml);
                            btn.prop('disabled', false);
                        } else {
                            targetContainer.html(response);

                            Toast.fire({
                                icon: "success",
                                title: "Spesimen berhasil diproses"
                            });
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Terjadi kesalahan pada server.", "error");
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>
