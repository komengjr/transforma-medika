<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Verifikasi Pasien Radiologi</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>

    <div class="p-4">
        <div class="row g-0" id="menu-verifikasi-hasil">

            <!-- LEFT SIDEBAR: INFORMASI PASIEN & SUMMARY -->
            <div class="col-lg-4 pe-lg-2">
                <div class="card mb-3 mb-lg-0">
                    <div class="card-header bg-300 py-2">
                        <h5 class="mb-0 fs--1 fw-bold">
                            <i class="fas fa-file-medical text-primary me-1"></i> Informasi Order Radiologi
                        </h5>
                    </div>
                    <div class="card-body fs--1">
                        <div class="mb-3">
                            <span class="text-secondary d-block fs--2">Kode Registrasi:</span>
                            <span class="fw-bold font-monospace text-dark fs--1">{{ $reg ?? '-' }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-secondary d-block fs--2">Kode Order Radiologi:</span>
                            <span class="fw-bold font-monospace text-primary fs--1">{{ $code ?? '-' }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-secondary d-block fs--2">Dokter Pemeriksa:</span>
                            <span class="fw-bold text-dark fs--1">{{ auth()->user()->name ?? 'Dr. Radiologi' }}</span>
                        </div>
                        <div class="border-dashed-bottom my-3"></div>

                        <!-- RINGKASAN PEMERIKSAAN -->
                        <h6 class="fs--1 fw-bold mb-2">Daftar Pemeriksaan:</h6>
                        <ul class="list-group list-group-flush fs--2">
                            @foreach($pemeriksaanList as $item)
                            @php
                            $namaExam = $item->t_pemeriksaan_list_name ?? $item->p_sales_data_name ?? 'Radiologi';

                            $isFilled = \DB::table('h_reg_rad')
                            ->where('order_rad_list_code', $item->order_rad_list_code)
                            ->whereNotNull('h_reg_rad_value')
                            ->where('h_reg_rad_value', '!=', '')
                            ->exists();
                            @endphp
                            <li class="list-group-item px-0 py-1 bg-transparent d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-check-circle me-1 {{ $isFilled ? 'text-success' : 'text-300' }}"></i>
                                    {{ $namaExam }}
                                </span>
                                @if($isFilled)
                                <span class="badge bg-soft-success text-success fs--2">Terisi</span>
                                @else
                                <span class="badge bg-soft-warning text-warning fs--2">Belum Fill</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- RIGHT CONTENT: TABEL HASIL RADIOLOGI & ORTHANC CONTAINER -->
            <div class="col-lg-8 ps-lg-2">
                <div class="card mb-3 mb-lg-0">
                    <div class="card-header bg-300 py-2 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fs-0">Hasil Ekspertise Radiologi</h5>
                        <button class="btn btn-warning btn-sm" id="button-verifikasi-preview-report" data-code="{{ $code }}" data-reg="{{ $reg }}">
                            <span class="fas fa-file-pdf me-1"></span> Preview Report
                        </button>
                    </div>

                    <div class="card-body">
                        <h5 class="fs-0 mb-3 text-secondary">Pastikan Hasil Ekspertise Sudah Benar Sebelum Diverifikasi</h5>

                        <!-- CONTAINER FOTO / CITRA DICOM ORTHANC PACS -->
                        <div class="card border mb-3">
                            <div class="card-header bg-200 py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fs--1 fw-bold text-dark">
                                    <i class="fas fa-images me-1 text-info"></i> Preview Citra Radiologi (PACS / Orthanc)
                                </h6>
                                <button type="button" class="btn btn-falcon-default btn-xs" id="btn-reload-orthanc">
                                    <i class="fas fa-sync-alt me-1"></i> Reload
                                </button>
                            </div>
                            <div class="card-body p-3 bg-light">
                                <!-- ALERT ERROR -->
                                <div id="orthanc-alert" class="alert alert-danger alert-dismissible fade show d-none mb-3 fs--1 p-2 rounded-3 shadow-sm" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle me-2 fs-0"></i>
                                        <span id="orthanc-alert-text"></span>
                                    </div>
                                    <button type="button" class="btn-close py-2" onclick="document.getElementById('orthanc-alert').classList.add('d-none')"></button>
                                </div>

                                <!-- LOADER STATE -->
                                <div id="orthanc-loader" class="text-center py-5">
                                    <div class="spinner-border text-info" role="status" style="width: 2.2rem; height: 2.2rem;">
                                        <span class="visually-hidden">Loading DICOM...</span>
                                    </div>
                                    <p class="text-muted mt-2 fs--1 mb-0">Mengambil citra dari PACS Orthanc...</p>
                                </div>

                                <!-- GALLERY CONTAINER -->
                                <div id="orthanc-gallery" class="row g-2 d-none">
                                    <!-- Image items di-inject via JS -->
                                </div>

                                <!-- EMPTY STATE -->
                                <div id="orthanc-empty" class="text-center py-4 bg-white rounded border d-none">
                                    <i class="fas fa-file-medical-alt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0 fs--1" id="orthanc-empty-text">Belum ada foto/citra radiologi yang diunggah.</p>
                                </div>
                            </div>
                        </div>

                        <!-- LOOPER HASIL PER PEMERIKSAAN -->
                        @foreach($pemeriksaanList as $index => $item)
                        @php
                        $namaExam = $item->t_pemeriksaan_list_name ?? $item->p_sales_data_name ?? 'Radiologi';

                        $hRegRadList = \DB::table('h_reg_rad as h')
                        ->leftJoin('t_pemeriksaan_list_val as v', 'h.t_pem_list_val_code', '=', 'v.t_pem_list_val_code')
                        ->select(
                        'h.*',
                        'v.t_pem_list_val_name',
                        'v.t_pem_list_val_satuan',
                        'v.t_pem_list_val_rujukan'
                        )
                        ->where('h.order_rad_list_code', $item->order_rad_list_code)
                        ->get();

                        $parameters = collect($item->parameters ?? []);
                        @endphp

                        <div class="border rounded-2 mb-3 bg-light p-3">
                            <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom flex-wrap gap-2">
                                <div>
                                    <h6 class="mb-0 fw-bold text-primary fs--1">
                                        <i class="fas fa-x-ray me-1"></i> {{ $namaExam }}
                                    </h6>
                                    <span class="badge bg-soft-primary text-primary font-monospace fs--2">
                                        {{ $item->order_rad_list_code }}
                                    </span>
                                </div>
                            </div>

                            <!-- TABEL HASIL EKSPERTISE -->
                            <div class="table-responsive scrollbar">
                                <table class="table table-bordered bg-white fs--2 mb-0">
                                    <thead class="bg-200 text-800">
                                        <tr>
                                            <th style="width: 30%;">Parameter / Deskripsi</th>
                                            <th style="width: 45%;">Hasil Ekspertise</th>
                                            <th style="width: 25%;">Detail / Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($parameters->isNotEmpty())
                                        @foreach($parameters as $valIndex => $val)
                                        @php
                                        $namaDeskripsi = $val->t_pem_list_val_name ?? 'Deskripsi';
                                        $hRegRad = $hRegRadList->firstWhere('t_pem_list_val_code', $val->t_pem_list_val_code);

                                        if (!$hRegRad && isset($hRegRadList[$valIndex])) {
                                        $hRegRad = $hRegRadList[$valIndex];
                                        }

                                        $currentValue = $hRegRad->h_reg_rad_value ?? $val->t_pem_list_val_nilai ?? null;
                                        @endphp
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $namaDeskripsi }}</td>
                                            <td>
                                                <div class="p-2 bg-light rounded text-wrap font-monospace text-dark">
                                                    @if(!empty($currentValue))
                                                    {!! nl2br(e($currentValue)) !!}
                                                    @else
                                                    <span class="text-muted fstyle-italic">- Belum ada hasil -</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if(!empty($val->t_pem_list_val_satuan))
                                                <div><strong>Satuan:</strong> {{ $val->t_pem_list_val_satuan }}</div>
                                                @endif
                                                @if(!empty($val->t_pem_list_val_rujukan))
                                                <div><strong>Rujukan:</strong> <code>{{ $val->t_pem_list_val_rujukan }}</code></div>
                                                @endif
                                                @if(!empty($hRegRad->h_reg_rad_metode ?? null))
                                                <div><strong>Metode:</strong> {{ $hRegRad->h_reg_rad_metode }}</div>
                                                @endif
                                                @if(!empty($hRegRad->h_reg_rad_flag ?? null))
                                                <div><strong>Flag:</strong> <span class="badge bg-soft-info text-info">{{ $hRegRad->h_reg_rad_flag }}</span></div>
                                                @endif
                                                @if(empty($val->t_pem_list_val_satuan) && empty($val->t_pem_list_val_rujukan) && empty($hRegRad->h_reg_rad_metode ?? null) && empty($hRegRad->h_reg_rad_flag ?? null))
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                        @elseif($hRegRadList->isNotEmpty())
                                        @foreach($hRegRadList as $hIndex => $hRegRad)
                                        @php
                                        $namaDeskripsi = $hRegRad->t_pem_list_val_name ?? 'Parameter ' . ($hIndex + 1);
                                        @endphp
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $namaDeskripsi }}</td>
                                            <td>
                                                <div class="p-2 bg-light rounded text-wrap font-monospace text-dark">
                                                    @if(!empty($hRegRad->h_reg_rad_value))
                                                    {!! nl2br(e($hRegRad->h_reg_rad_value)) !!}
                                                    @else
                                                    <span class="text-muted fstyle-italic">- Belum ada hasil -</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if(!empty($hRegRad->t_pem_list_val_satuan))
                                                <div><strong>Satuan:</strong> {{ $hRegRad->t_pem_list_val_satuan }}</div>
                                                @endif
                                                @if(!empty($hRegRad->t_pem_list_val_rujukan))
                                                <div><strong>Rujukan:</strong> <code>{{ $hRegRad->t_pem_list_val_rujukan }}</code></div>
                                                @endif
                                                @if(!empty($hRegRad->h_reg_rad_metode))
                                                <div><strong>Metode:</strong> {{ $hRegRad->h_reg_rad_metode }}</div>
                                                @endif
                                                @if(!empty($hRegRad->h_reg_rad_flag))
                                                <div><strong>Flag:</strong> <span class="badge bg-soft-info text-info">{{ $hRegRad->h_reg_rad_flag }}</span></div>
                                                @endif
                                                @if(empty($hRegRad->t_pem_list_val_satuan) && empty($hRegRad->t_pem_list_val_rujukan) && empty($hRegRad->h_reg_rad_metode) && empty($hRegRad->h_reg_rad_flag))
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                        @else
                                        <tr>
                                            <td class="fw-bold text-dark">Deskripsi Hasil</td>
                                            <td colspan="2">
                                                <div class="p-2 bg-light rounded text-wrap font-monospace text-dark">
                                                    <span class="text-muted fstyle-italic">- Belum ada hasil -</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach

                        <!-- TOOLBAR ACTION & TOMBOL VERIFIKASI -->
                        <div class="card border mt-3">
                            <div class="card-body d-flex justify-content-between align-items-center p-2">
                                <div>
                                    <button class="btn btn-falcon-default btn-sm" type="button" data-bs-dismiss="modal" data-bs-toggle="tooltip" title="Tutup Modal">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </button>
                                </div>
                                <div>
                                    <button class="btn btn-success btn-sm px-4 shadow-sm" id="button-verifikasi-hasil-rad" data-code="{{ $code }}" data-reg="{{ $reg }}">
                                        <i class="fas fa-check-double me-1"></i> Verifikasi Hasil Radiologi
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPT HANDLER UNTUK ORTHANC -->
<script>
    $(document).ready(function() {
        const orderCode = "{{ $reg }}";
        fetchOrthancImages(orderCode);

        $('#btn-reload-orthanc').on('click', function() {
            fetchOrthancImages(orderCode);
        });
    });

    function fetchOrthancImages(code) {
        const $loader = $('#orthanc-loader');
        const $gallery = $('#orthanc-gallery');
        const $empty = $('#orthanc-empty');
        const $alert = $('#orthanc-alert');
        const $alertText = $('#orthanc-alert-text');

        // Reset state UI
        $loader.removeClass('d-none');
        $gallery.addClass('d-none').html('');
        $empty.addClass('d-none');
        $alert.addClass('d-none');

        $.ajax({
            url: "{{ url('application/menu-radiologi/data-registrasi-radiologi/handling-pasien/images') }}/" + "{{ $reg }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $loader.addClass('d-none');

                // Cek ketersediaan array images dari JSON response
                if (response.success && Array.isArray(response.images) && response.images.length > 0) {
                    let htmlItems = '';

                    response.images.forEach(function(item) {
                        // Susun URL Viewer Orthanc berdasarkan study_id
                        let viewerUrl = "{{ url('application/pacs-server/studies-get') }}/" + item.study_id;
                        let captionText = item.caption || item.nama_pemeriksaan || 'Citra Radiologi';

                        htmlItems += `
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="card h-100 shadow-none border hover-actions-trigger">
                                    <div class="bg-dark rounded-top d-flex align-items-center justify-content-center overflow-hidden position-relative" style="height: 140px;">
                                        <a href="${item.preview_url}" target="_blank" class="w-100 h-100 d-flex align-items-center justify-content-center">
                                            <img src="${item.preview_url}"
                                                 class="img-fluid rounded-top"
                                                 style="max-height: 140px; width: 100%; object-fit: contain;"
                                                 alt="${captionText}"
                                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200/20232a/fff?text=Render+Error';">
                                        </a>
                                    </div>
                                    <div class="card-body p-2 text-center bg-white rounded-bottom">
                                        <p class="fs--2 text-800 fw-semi-bold mb-1 text-truncate" title="${captionText}">
                                            ${captionText}
                                        </p>
                                        <a href="${viewerUrl}" target="_blank" class="btn btn-falcon-info btn-xs w-100">
                                            <i class="fas fa-search-plus me-1"></i> Buka Viewer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $gallery.html(htmlItems).removeClass('d-none');
                } else {
                    $empty.removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                $loader.addClass('d-none');
                console.error("Orthanc Fetch Error:", xhr);

                let errorMsg = xhr.responseJSON?.message || 'Gagal mengambil citra dari PACS Server (Status: ' + xhr.status + ')';
                $alertText.text(errorMsg);
                $alert.removeClass('d-none');
                $empty.removeClass('d-none');
            }
        });
    }
</script>
