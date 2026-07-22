@extends('layouts.layouts')
@section('base.css')
<!-- Select2 CSS & Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
@endsection
@section('content')
<!-- HEADER PAGE -->
<div class="row mb-3">
    <div class="col">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm border-start border-success border-4">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white p-3 rounded-3 me-3 shadow-sm">
                    <i class="fas fa-check-double fa-2x"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-warning">Approval Peminjaman Uang</h4>
                    <p class="text-muted small mb-0">Daftar pengajuan pinjaman anggota yang menunggu otorisasi persetujuan.</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 1. Data Tables: Approval Utama -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold m-0 text-dark"><i class="fas fa-clock text-warning me-2"></i>Daftar Menunggu Approval</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tableApproval" style="width:100%">
                <thead class="bg-light">
                    <tr class="small text-muted">
                        <th>Tanggal</th>
                        <th>No. Akad</th>
                        <th>Anggota</th>
                        <th>Plafon</th>
                        <th>Tenor</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($pengajuan as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d M Y') }}</td>
                        <td class="fw-bold text-primary">{{ $row->nota_nomor }}</td>
                        <td>
                            <div class="fw-bold">{{ $row->kop_master_peserta_name }}</div>
                            <div class="text-muted extra-small">ID: {{ $row->kop_master_peserta_code }}</div>
                        </td>
                        <td>Rp {{ number_format($row->jumlah_pinjaman, 0, ',', '.') }}</td>
                        <td>{{ $row->tenor_bulan }} Bln</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info text-white fw-bold btn-review"
                                data-id="{{ $row->id }}">
                                <i class="fas fa-search me-1"></i> Review
                            </button>
                        </td>
                    </tr>
                    @empty
                    <!-- Jangan isi baris manual saat kosong jika pakai DataTables, biarkan DataTables yang menangani atau biarkan tbody kosong -->
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 2. Data Tables: History / Riwayat Peminjaman Keseluruhan -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold m-0 text-dark"><i class="fas fa-history text-secondary me-2"></i>Riwayat Peminjaman (Disetujui / Ditolak)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tableHistoryGlobal" style="width:100%">
                <thead class="bg-light">
                    <tr class="small text-muted">
                        <th>Tanggal</th>
                        <th>No. Akad</th>
                        <th>Anggota</th>
                        <th>Plafon</th>
                        <th>Tenor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($history ?? [] as $hist)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($hist->tanggal_pinjaman)->format('d M Y') }}</td>
                        <td class="fw-bold text-secondary">{{ $hist->nota_nomor }}</td>
                        <td>
                            <div class="fw-bold">{{ $hist->kop_master_peserta_name }}</div>
                            <div class="text-muted extra-small">ID: {{ $hist->kop_master_peserta_code }}</div>
                        </td>
                        <td>Rp {{ number_format($hist->jumlah_pinjaman, 0, ',', '.') }}</td>
                        <td>{{ $hist->tenor_bulan }} Bln</td>
                        <td>
                            @if($hist->status_pinjaman === 'APPROVED')
                            <span class="badge bg-success">APPROVED</span>
                            @elseif($hist->status_pinjaman === 'REJECTED')
                            <span class="badge bg-danger">REJECTED</span>
                            @else
                            <span class="badge bg-warning text-dark">{{ $hist->status_pinjaman }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Review Pengajuan -->
<div class="modal fade" id="modalReview" tabindex="-1" aria-labelledby="modalReviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold text-white" id="modalReviewLabel"><i class="fas fa-file-contract me-2"></i> Review Pengajuan Pinjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <input type="hidden" id="review_trx_id">
                <input type="hidden" id="review_nota_nomor">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white fw-bold small">Detail Pengajuan Baru</div>
                            <div class="card-body small">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td width="40%" class="text-muted">No. Akad</td>
                                        <td class="fw-bold text-primary" id="det_nota"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tgl Pinjam</td>
                                        <td class="fw-bold" id="det_tgl"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tujuan</td>
                                        <td class="fw-bold" id="det_tujuan"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Plafon</td>
                                        <td class="fw-bold" id="det_plafon"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Admin + Bunga</td>
                                        <td class="fw-bold" id="det_biaya"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Pencairan Netto</td>
                                        <td class="fw-bold text-success" id="det_netto"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tenor & Cicilan</td>
                                        <td class="fw-bold" id="det_cicilan"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white fw-bold small">Profil Anggota</div>
                            <div class="card-body small">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td width="30%" class="text-muted">Nama</td>
                                        <td class="fw-bold text-dark" id="prof_nama"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Kode / ID</td>
                                        <td class="fw-bold" id="prof_kode"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">NIP</td>
                                        <td class="fw-bold" id="prof_nip"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">No HP (WA)</td>
                                        <td class="fw-bold" id="prof_hp"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white fw-bold small"><i class="fas fa-history me-1"></i> Riwayat Pinjaman Sebelumnya</div>
                            <div class="card-body p-0">
                                <table class="table table-sm table-striped align-middle mb-0 small">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No. Akad</th>
                                            <th>Plafon</th>
                                            <th>Tenor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableRiwayatBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white d-flex justify-content-between">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <div>
                    <button type="button" class="btn btn-danger btn-sm fw-bold me-2" id="btnRejectProcess"><i class="fas fa-times me-1"></i> Tolak Pengajuan</button>
                    <button type="button" class="btn btn-success btn-sm fw-bold" id="btnApproveProcess"><i class="fas fa-check me-1"></i> Setujui Pengajuan</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            // Inisialisasi DataTable untuk Approval Utama
            $('#tableApproval').DataTable({
                order: [
                    [0, 'asc']
                ],
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Pencarian tidak ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Inisialisasi DataTable untuk Riwayat/History Global
            $('#tableHistoryGlobal').DataTable({
                order: [
                    [0, 'desc']
                ],
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Pencarian tidak ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        }

        function formatRp(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        // 1. Event Klik Tombol Review di Tabel
        $(document).on('click', '.btn-review', function() {
            let trxId = $(this).data('id');
            let btn = $(this);

            btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            $.ajax({
                url: "{{ url('koperasi/menu-peminjaman/approval-peminjaman-uang-anggota/detail') }}/" + trxId,
                type: "GET",
                success: function(response) {
                    btn.html('<i class="fas fa-search me-1"></i> Review').prop('disabled', false);

                    let p = response.data.pinjaman;
                    let h = response.data.history;
                    let tenors = response.data.tenors || []; // Pastikan backend mengirim data tenors

                    $('#review_trx_id').val(p.id);
                    $('#review_nota_nomor').val(p.nota_nomor);

                    $('#det_nota').text(p.nota_nomor);
                    $('#det_tgl').text(p.tanggal_pinjaman);
                    $('#det_tujuan').text(p.tujuan_pinjaman || '-');
                    $('#det_plafon').text(formatRp(p.jumlah_pinjaman));
                    $('#det_biaya').text(formatRp(parseFloat(p.biaya_admin) + parseFloat(p.bunga_koperasi)));
                    $('#det_netto').text(formatRp(p.pencairan_netto));
                    $('#det_cicilan').text(p.tenor_bulan + ' Bulan @ ' + formatRp(p.cicilan_per_bulan));

                    // --- TAMBAHAN: Tampilkan Status Tagihan (jika elemen HTML-nya ada) ---
                    let statusTagihan = p.status_tagihan || 'PENDING';
                    let badgeTagihanClass = statusTagihan === 'LUNAS' ? 'bg-success' : 'bg-warning text-dark';
                    $('#det_status_tagihan').html(`<span class="badge ${badgeTagihanClass}">${statusTagihan}</span>`);

                    $('#prof_nama').text(p.kop_master_peserta_name);
                    $('#prof_kode').text(p.kop_master_peserta_code);
                    $('#prof_nip').text(p.kop_master_peserta_nip || '-');
                    $('#prof_hp').text(p.kop_master_peserta_no_hp || '-');

                    // Render Riwayat Pinjaman
                    // Render Riwayat Pinjaman Beserta Tenornya
                    let historyHtml = '';
                    if (h.length > 0) {
                        $.each(h, function(i, val) {
                            let badgeClass = val.status_pinjaman === 'APPROVED' ? 'bg-success' : (val.status_pinjaman === 'REJECTED' ? 'bg-danger' : 'bg-warning');
                            let statusTagihanRiwayat = val.status_tagihan || 'PENDING';
                            let badgeTagihanRwy = statusTagihanRiwayat === 'LUNAS' ? 'bg-success' : 'bg-warning text-dark';

                            // Buat baris utama riwayat pinjaman
                            historyHtml += `
                        <tr class="table-light fw-bold">
                            <td><i class="fas fa-history text-secondary me-1"></i> ${val.tanggal_pinjaman}</td>
                            <td>${val.nota_nomor}</td>
                            <td>${formatRp(val.jumlah_pinjaman)}</td>
                            <td>${val.tenor_bulan} Bln</td>
                            <td><span class="badge ${badgeClass}">${val.status_pinjaman}</span></td>
                            <td><span class="badge ${badgeTagihanRwy}">${statusTagihanRiwayat}</span></td>
                        </tr>
                    `;

                            // Buat sub-tabel/baris untuk rincian tenor dari riwayat tersebut
                            if (val.tenors && val.tenors.length > 0) {
                                historyHtml += `
                            <tr>
                                <td colspan="6" class="p-3 bg-white border-bottom">
                                    <div class="small fw-bold text-muted mb-1">Rincian Angsuran / Tenor (${val.nota_nomor}):</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0 align-middle font-monospace" style="font-size: 0.85rem;">
                                            <thead class="table-secondary text-center">
                                                <tr>
                                                    <th>Angsuran</th>
                                                    <th>Jatuh Tempo</th>
                                                    <th>Pokok + Bunga (Total)</th>
                                                    <th>Status Bayar</th>
                                                    <th>Tanggal Bayar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                        `;

                                $.each(val.tenors, function(idx, t) {
                                    let isLunasRwy = (t.status_bayar === 'LUNAS');
                                    let badgeTenorRwy = isLunasRwy ? 'bg-success' : 'bg-warning text-dark';
                                    let totalTagihanRwy = parseFloat(t.jumlah_tagihan ?? 0);

                                    historyHtml += `
                                <tr class="${isLunasRwy ? 'table-success bg-opacity-10' : ''}">
                                    <td class="text-center fw-bold">Bulan Ke-${t.angsuran_ke}</td>
                                    <td class="text-center">${t.jatuh_tempo ?? '-'}</td>
                                    <td class="text-end">${formatRp(totalTagihanRwy)}</td>
                                    <td class="text-center"><span class="badge ${badgeTenorRwy}">${t.status_bayar}</span></td>
                                    <td class="text-center">${t.tanggal_bayar ?? '-'}</td>
                                </tr>
                            `;
                                });

                                historyHtml += `
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        `;
                            } else {
                                historyHtml += `
                            <tr>
                                <td colspan="6" class="text-muted fst-italic ps-4 bg-white">Tidak ada rincian tenor untuk riwayat ini.</td>
                            </tr>
                        `;
                            }
                        });
                    } else {
                        historyHtml = `<tr><td colspan="6" class="text-center text-muted fst-italic">Belum ada riwayat pinjaman sebelumnya.</td></tr>`;
                    }
                    $('#tableRiwayatBody').html(historyHtml);

                    // --- TAMBAHAN: Render Detail Tenor Angsuran ---
                    let tenorHtml = '';
                    if (tenors.length > 0) {
                        $.each(tenors, function(i, t) {
                            let isLunas = (t.status_bayar === 'LUNAS');
                            let rowClass = isLunas ? 'table-success bg-opacity-25' : '';
                            let badgeTenorClass = isLunas ? 'bg-success' : 'bg-warning text-dark';
                            let totalTagihan = parseFloat(t.jumlah_tagihan ?? 0);
                            let bunga = parseFloat(t.bunga_tagihan ?? 0);
                            let pokok = totalTagihan - bunga;

                            tenorHtml += `
                        <tr class="${rowClass}">
                            <td class="text-center fw-bold">Bulan Ke-${t.angsuran_ke}</td>
                            <td>${t.jatuh_tempo ?? '-'}</td>
                            <td class="text-end font-monospace">${formatRp(pokok)}</td>
                            <td class="text-end font-monospace">${formatRp(bunga)}</td>
                            <td class="text-end font-monospace fw-bold">${formatRp(totalTagihan)}</td>
                            <td class="text-center"><span class="badge ${badgeTenorClass}">${t.status_bayar}</span></td>
                        </tr>
                    `;
                        });
                    } else {
                        tenorHtml = `<tr><td colspan="6" class="text-center text-muted fst-italic">Belum ada rincian jadwal tenor.</td></tr>`;
                    }
                    $('#tableTenorBody').html(tenorHtml); // Sesuaikan ID elemen tbody tabel tenor di modal HTML Anda

                    $('#modalReview').modal('show');
                },
                error: function() {
                    btn.html('<i class="fas fa-search me-1"></i> Review').prop('disabled', false);
                    Swal.fire('Error', 'Gagal mengambil detail data.', 'error');
                }
            });
        });

        // 2. Proses Setujui
        $('#btnApproveProcess').on('click', function() {
            let trxId = $('#review_trx_id').val();
            let nota = $('#review_nota_nomor').val();

            Swal.fire({
                title: 'Setujui Pinjaman?',
                text: "Anda akan menyetujui pengajuan akad " + nota,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#modalReview').modal('hide');
                    $.ajax({
                        url: "{{ route('menu_koperasi_approval_peminjaman_uang_anggota_approve') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: trxId
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Disetujui!',
                                    text: res.message,
                                    showCancelButton: res.wa_url ? true : false,
                                    confirmButtonText: 'Tutup',
                                    cancelButtonText: '<i class="fab fa-whatsapp me-1"></i> Kabari WA',
                                    cancelButtonColor: '#25D366'
                                }).then((r) => {
                                    if (r.dismiss === Swal.DismissReason.cancel && res.wa_url) {
                                        window.open(res.wa_url, '_blank');
                                    }
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        });

        // 3. Proses Tolak
        // 3. Proses Tolak (Langsung tanpa input alasan)
        $('#btnRejectProcess').on('click', function() {
            let trxId = $('#review_trx_id').val();
            let nota = $('#review_nota_nomor').val();

            Swal.fire({
                title: 'Tolak Pinjaman?',
                text: "Anda yakin ingin menolak pengajuan akad " + nota + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#modalReview').modal('hide');
                    $.ajax({
                        url: "{{ route('menu_koperasi_approval_peminjaman_uang_anggota_reject') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: trxId
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire('Ditolak!', res.message, 'success').then(() => location.reload());
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
