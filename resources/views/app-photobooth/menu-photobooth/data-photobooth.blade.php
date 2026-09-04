@extends('layouts.layouts')

@section('content')
<!-- CDN DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


<!-- 1. HEADER INFORMASI & STATISTIK -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h3 class="fw-bold mb-1">
                            <i class="fa-solid fa-camera-retro me-2"></i>Master Data Photobooth
                        </h3>
                        <p class="mb-0 text-white-50">Kelola lokasi photobooth, konfigurasi frame, dan pantau hasil pemotretan pengguna.</p>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="bg-white bg-opacity-10 px-3 py-2 rounded text-center">
                            <div class="fs-4 fw-bold text-dark">{{ $photobooths->count() }}</div>
                            <div class="small text-dark">Total Photobooth</div>
                        </div>
                        <div class="bg-white bg-opacity-10 px-3 py-2 rounded text-center">
                            <div class="fs-4 fw-bold text-dark">{{ $photobooths->where('is_active', true)->count() }}</div>
                            <div class="small text-dark">Status Aktif</div>
                        </div>
                        <div class="bg-white bg-opacity-10 px-3 py-2 rounded text-center">
                            <div class="fs-4 fw-bold text-dark">{{ $photobooths->sum('results_count') }}</div>
                            <div class="small text-dark">Total Foto Result</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. TABEL MASTER PHOTOBOOTH (DATATABLE) -->
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table id="masterPhotoboothTable" class="table table-hover align-middle w-100">
                <thead class="table-dark">
                    <tr>
                        <th width="5%" class="ps-3">No</th>
                        <th width="15%">Kode Org</th>
                        <th width="25%">Nama Organisasi</th>
                        <th width="15%">Logo & BG</th>
                        <th width="15%">Daftar Frame</th>
                        <th width="10%">Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($photobooths as $index => $item)
                    <tr>
                        <td class="ps-3">{{ $index + 1 }}</td>
                        <td><span class="badge bg-secondary">{{ $item->org_code }}</span></td>
                        <td class="fw-bold text-primary">{{ $item->org_name }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($item->logo_path)
                                <img src="{{ route('photobooth.file', ['path' => $item->logo_path]) }}"
                                    title="Logo"
                                    class="rounded border"
                                    style="height: 35px; width: 35px; object-fit: contain;"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/35?text=Logo';">
                                @else
                                <span class="badge bg-light text-dark border">No Logo</span>
                                @endif

                                @if($item->bg_path)
                                <img src="{{ route('photobooth.file', ['path' => $item->bg_path]) }}"
                                    title="Background"
                                    class="rounded border"
                                    style="height: 35px; width: 35px; object-fit: cover;"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/35?text=BG';">
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark"><i class="fa-solid fa-layer-group me-1"></i>{{ $item->frames->count() }} Frame</span>
                        </td>
                        <td>
                            @if($item->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button"
                                class="btn btn-sm btn-primary"
                                onclick="openDetailModal('{{ $item->org_code }}')">
                                <i class="fa-solid fa-images me-1"></i> Lampiran Data ({{ $item->results_count }})
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- MODAL DETAIL LAMPIRAN HASIL PHOTOBOOTH -->
<div class="modal fade" id="modalDetailResults" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <div>
                    <h5 class="modal-title fw-bold" id="modalDetailLabel">
                        <i class="fa-solid fa-images me-2"></i>Lampiran Data Hasil Photobooth
                    </h5>
                    <small id="modalSubTitle" class="text-white-50"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="modalResultsTable" class="table table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="ps-3">No</th>
                                <th width="12%">Kode Unik</th>
                                <th width="18%">Nama User</th>
                                <th width="18%">Kontak</th>
                                <th width="15%">Foto Strip (Merged)</th>
                                <th width="12%">Foto Satuan (Single)</th>
                                <th width="10%">Waktu Ambil</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="modalTableBody">
                            <!-- Rows via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- CDN DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    let resultsDataTable = null;

    $(document).ready(function() {
        // Inisialisasi DataTables Master Table
        $('#masterPhotoboothTable').DataTable({
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    previous: "<i class='fa-solid fa-chevron-left'></i>",
                    next: "<i class='fa-solid fa-chevron-right'></i>"
                }
            },
            pageLength: 10,
            order: [
                [0, 'asc']
            ]
        });
    });

    function openDetailModal(orgCode) {
        const modalElement = document.getElementById('modalDetailResults');
        const modal = new bootstrap.Modal(modalElement);
        const subTitle = document.getElementById('modalSubTitle');

        // Destroy DataTables instance jika modal pernah dibuka sebelumnya
        if (resultsDataTable) {
            resultsDataTable.destroy();
            resultsDataTable = null;
        }

        // Set Loading State
        $('#modalTableBody').html(`
        <tr>
            <td colspan="8" class="text-center py-4 text-muted">
                <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div> Memuat data...
            </td>
        </tr>
    `);

        subTitle.innerText = 'Memuat data...';
        modal.show();

        // Fetch JSON Data
        fetch(`/photobooth/${orgCode}/results-json`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    subTitle.innerText = `Organisasi: ${data.photobooth.org_name} (Kode: ${data.photobooth.org_code})`;

                    let rowsHtml = '';
                    if (data.results.length > 0) {
                        data.results.forEach((res, index) => {
                            // Render Single Images
                            let singleImagesHtml = '-';
                            if (res.single_images && Array.isArray(res.single_images)) {
                                singleImagesHtml = '<div class="d-flex gap-1 flex-wrap" style="max-width: 180px;">';
                                res.single_images.forEach(img => {
                                    let imgFileName = img.split('/').pop();
                                    singleImagesHtml += `
                                    <a href="/photobooth-file/${imgFileName}" target="_blank">
                                        <img src="/photobooth-file/${imgFileName}" class="rounded border" style="height: 35px; width: 35px; object-fit: cover;">
                                    </a>
                                `;
                                });
                                singleImagesHtml += '</div>';
                            }

                            // Format Date
                            const dateObj = new Date(res.created_at);
                            const formattedDate = dateObj.toLocaleString('id-ID', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            // Dynamic Result URL for Copy Link
                            const resultUrl = `${window.location.origin}/photobooth/result/${res.code}`;
                            const mergedFileName = res.image_path ? res.image_path.split('/').pop() : '';

                            rowsHtml += `
                            <tr>
                                <td class="ps-3">${index + 1}</td>
                                <td><span class="badge bg-dark">${res.code}</span></td>
                                <td class="fw-bold">${escapeHtml(res.name)}</td>
                                <td>
                                    <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>${escapeHtml(res.phone)}</div>
                                    <div class="small text-muted"><i class="fa-solid fa-envelope me-1"></i>${escapeHtml(res.email)}</div>
                                </td>
                                <td>
                                    ${res.image_path ? `
                                        <a href="/photobooth-file/${mergedFileName}" target="_blank">
                                            <img src="/photobooth-file/${mergedFileName}" class="img-thumbnail" style="height: 60px; object-fit: contain;">
                                        </a>
                                    ` : '-'}
                                </td>
                                <td>${singleImagesHtml}</td>
                                <td><small class="text-muted">${formattedDate}</small></td>
                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary rounded-pill"
                                            onclick="copyToClipboard('${resultUrl}', this)"
                                            title="Copy Link Result">
                                        <i class="fa-solid fa-copy me-1"></i> Copy Link
                                    </button>
                                </td>
                            </tr>
                        `;
                        });
                    }

                    $('#modalTableBody').html(rowsHtml);

                    // Re-initialize DataTables untuk Modal Table
                    resultsDataTable = $('#modalResultsTable').DataTable({
                        language: {
                            search: "Cari Nama / Email / Kode:",
                            lengthMenu: "Tampilkan _MENU_ data",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ foto",
                            zeroRecords: "Data hasil foto tidak ditemukan",
                            paginate: {
                                previous: "<i class='fa-solid fa-chevron-left'></i>",
                                next: "<i class='fa-solid fa-chevron-right'></i>"
                            }
                        },
                        pageLength: 5,
                        destroy: true
                    });
                }
            })
            .catch(error => {
                $('#modalTableBody').html(`
                <tr>
                    <td colspan="8" class="text-center py-4 text-danger">Gagal memuat data lampiran.</td>
                </tr>
            `);
            });
    }

    function copyToClipboard(text, btnElement) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHtml = btnElement.innerHTML;

            btnElement.classList.remove('btn-outline-primary');
            btnElement.classList.add('btn-success', 'text-white');
            btnElement.innerHTML = `<i class="fa-solid fa-check me-1"></i> Tersalin!`;

            setTimeout(() => {
                btnElement.classList.remove('btn-success', 'text-white');
                btnElement.classList.add('btn-outline-primary');
                btnElement.innerHTML = originalHtml;
            }, 2000);
        }).catch(err => {
            alert('Gagal menyalin link: ' + err);
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }
</script>
@endsection
