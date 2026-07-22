@extends('layouts.layouts') {{-- Sesuaikan dengan layout master Anda --}}

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Approval Pengadaan Barang Anggota</h4>
            <p class="text-muted small mb-0">Verifikasi dan setujui kontrak pengadaan barang pembiayaan anggota.</p>
        </div>
        <div>
            <span class="badge bg-warning text-dark px-3 py-2 fs-2">
                <i class="bi bi-clock-history me-1"></i> Menunggu Verifikasi: {{ count($pendingList) }}
            </span>
        </div>
    </div>

    {{-- TABEL MENUNGGU APPROVAL --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-file-earmark-check me-2"></i>Daftar Pengajuan Perlu Persetujuan</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Nota</th>
                            <th>Tanggal</th>
                            <th>Anggota</th>
                            <th>Nama Barang</th>
                            <th class="text-end">Harga Beli</th>
                            <th class="text-end">Biaya Admin</th>
                            <th class="text-end">Bunga Koperasi</th>
                            <th class="text-end">Total Piutang</th>
                            <th class="text-center">Tenor</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingList as $row)
                        <tr>
                            <td class="fw-bold text-primary">{{ $row->nota_nomor }}</td>
                            <td>{{ date('d/m/Y', strtotime($row->tanggal_transaksi)) }}</td>
                            <td>
                                <div class="fw-bold">{{ $row->kop_master_peserta_name }}</div>
                                <small class="text-muted">{{ $row->kop_master_peserta_code }}</small>
                            </td>
                            <td>{{ $row->barang_nama }}</td>
                            <td class="text-end">Rp {{ number_format($row->harga_beli, 0, ',', '.') }}</td>
                            <td class="text-end text-info">Rp {{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end text-success">Rp {{ number_format($row->bunga_koperasi ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($row->total_piutang, 0, ',', '.') }}</td>
                            <td class="text-center"><span class="badge bg-info text-dark">{{ $row->tenor_bulan }} Bln</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary px-3" onclick="openApprovalModal({{ $row->id }})">
                                    <i class="bi bi-search me-1"></i> Verifikasi
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                <i class="bi bi-check-circle fs-2 d-block mb-2 text-success"></i>
                                Tidak ada pengajuan yang menunggu persetujuan saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TABEL RIWAYAT APPROVAL TERAKHIR --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0 text-secondary"><i class="bi bi-clock-history me-2"></i>Riwayat Verifikasi Terakhir</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Nota</th>
                            <th>Anggota</th>
                            <th>Barang</th>
                            <th class="text-end">Total Piutang</th>
                            <th class="text-center">Status</th>
                            <th>Diverifikasi Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historyList as $h)
                        <tr>
                            <td>{{ $h->nota_nomor }}</td>
                            <td>{{ $h->kop_master_peserta_name }}</td>
                            <td>{{ $h->barang_nama }}</td>
                            <td class="text-end">Rp {{ number_format($h->total_piutang, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($h->status_pembelian == 'APPROVED')
                                <span class="badge bg-success"><i class="bi bi-check-lg me-1"></i>Disetujui</span>
                                @else
                                <span class="badge bg-danger"><i class="bi bi-x-lg me-1"></i>Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <small class="d-block">{{ $h->approved_by ?? '-' }}</small>
                                <small class="text-muted">{{ $h->approved_at ? date('d/m/Y H:i', strtotime($h->approved_at)) : '' }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL VERIFIKASI APPROVAL --}}
<div class="modal fade" id="modalApproval" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-shield-check me-2"></i>Verifikasi Pengajuan Pembelian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="modal_pembelian_id">

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Nomor Nota</small>
                            <span class="fw-bold fs-2 text-primary" id="v_nota">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Nama Anggota</small>
                            <span class="fw-bold fs-2" id="v_anggota">-</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Nama Barang</small>
                        <span class="fw-bold" id="v_barang">-</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Tanggal Transaksi</small>
                        <span class="fw-bold" id="v_tanggal">-</span>
                    </div>
                </div>

                {{-- RINCIAN FINANSIAL --}}
                <div class="card border-0 bg-light mb-4">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-3 border-end">
                                <small class="text-muted d-block">Harga Beli Supplier</small>
                                <h6 class="fw-bold mb-0" id="v_harga">Rp 0</h6>
                            </div>
                            <div class="col-3 border-end">
                                <small class="text-muted d-block">Biaya Admin</small>
                                <h6 class="fw-bold text-info mb-0" id="v_admin">Rp 0</h6>
                            </div>
                            <div class="col-3 border-end">
                                <small class="text-muted d-block">Bunga Koperasi</small>
                                <h6 class="fw-bold text-success mb-0" id="v_bunga">Rp 0</h6>
                            </div>
                            <div class="col-3">
                                <small class="text-muted d-block">Total Piutang</small>
                                <h6 class="fw-bold text-primary mb-0" id="v_total">Rp 0</h6>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RINCIAN JURNAL COA TERPILIH --}}
                <h6 class="fw-bold mb-2"><i class="bi bi-journal-bookmark me-2"></i>Peta Jurnal Akuntansi Terpilih</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-sm table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Pos Jurnal</th>
                                <th>Kode COA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Debet: Piutang Anggota</td>
                                <td id="v_coa_piutang" class="fw-bold">-</td>
                            </tr>
                            <tr>
                                <td>Kredit: Sumber Dana Kas/Bank</td>
                                <td id="v_coa_kas" class="fw-bold">-</td>
                            </tr>
                            <tr>
                                <td>Kredit: Pendapatan Admin</td>
                                <td id="v_coa_admin" class="fw-bold">-</td>
                            </tr>
                            <tr>
                                <td>Kredit: Pendapatan Bunga</td>
                                <td id="v_coa_bunga" class="fw-bold">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- SIMULASI SCHEDULE TENOR --}}
                <h6 class="fw-bold mb-2"><i class="bi bi-calendar-range me-2"></i>Simulasi Jadwal Angsuran (<span id="v_tenor_bln">0</span> Bulan)</h6>
                <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                    <table class="table table-sm table-striped">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="text-center">Bulan Ke</th>
                                <th>Proyeksi Jatuh Tempo</th>
                                <th class="text-end">Nominal Angsuran</th>
                            </tr>
                        </thead>
                        <tbody id="v_tenor_tbody">
                            {{-- Dynamic Row --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger px-4" onclick="processApproval('reject')">
                    <i class="bi bi-x-circle me-1"></i> Tolak Pengajuan
                </button>
                <button type="button" class="btn btn-success px-4" onclick="processApproval('approve')">
                    <i class="bi bi-check-circle me-1"></i> Setujui Pengajuan
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let currentModal;

    function openApprovalModal(id) {
        $.get("{{ url('koperasi/menu-koperasi/apporval-pembelian-barang/detail') }}/" + id, function(res) {
            if (res.status === 'success') {
                const data = res.data;

                $('#modal_pembelian_id').val(data.id);
                $('#v_nota').text(data.nota_nomor);
                $('#v_anggota').text(data.kop_master_peserta_name + ' (' + data.kop_master_peserta_code + ')');
                $('#v_barang').text(data.barang_nama);
                $('#v_tanggal').text(data.tanggal_transaksi);

                $('#v_harga').text('Rp ' + parseInt(data.harga_beli || 0).toLocaleString('id-ID'));
                $('#v_admin').text('Rp ' + parseInt(data.biaya_admin || 0).toLocaleString('id-ID'));
                $('#v_bunga').text('Rp ' + parseInt(data.bunga_koperasi || 0).toLocaleString('id-ID'));
                $('#v_total').text('Rp ' + parseInt(data.total_piutang || 0).toLocaleString('id-ID'));

                $('#v_coa_piutang').text(data.coa_piutang || '-');
                $('#v_coa_kas').text(data.sumber_dana_coa || '-');
                $('#v_coa_admin').text(data.coa_pendapatan_admin || '-');
                $('#v_coa_bunga').text(data.coa_pendapatan_bunga || '-');
                $('#v_tenor_bln').text(data.tenor_bulan);

                // Render Tenor Rows
                let htmlTenor = '';
                if (res.tenor && res.tenor.length > 0) {
                    res.tenor.forEach(function(t) {
                        htmlTenor += `
                            <tr>
                                <td class="text-center fw-bold">${t.angsuran_ke}</td>
                                <td>${t.jatuh_tempo}</td>
                                <td class="text-end fw-bold">Rp ${t.jumlah_tagihan}</td>
                            </tr>
                        `;
                    });
                } else {
                    htmlTenor = `<tr><td colspan="3" class="text-center text-muted">Jadwal tenor tidak tersedia.</td></tr>`;
                }
                $('#v_tenor_tbody').html(htmlTenor);

                currentModal = new bootstrap.Modal(document.getElementById('modalApproval'));
                currentModal.show();
            } else {
                Swal.fire('Gagal!', res.message || 'Gagal memuat data detail.', 'error');
            }
        }).fail(function() {
            Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data detail.', 'error');
        });
    }

    function processApproval(actionType) {
        const id = $('#modal_pembelian_id').val();
        const isApprove = actionType === 'approve';
        const endpoint = isApprove ? "{{ url('koperasi/menu-koperasi/apporval-pembelian-barang/approve') }}/" + id :
            "{{ url('koperasi/menu-koperasi/apporval-pembelian-barang/reject') }}/" + id;

        Swal.fire({
            title: isApprove ? 'Setujui Pengajuan?' : 'Tolak Pengajuan?',
            text: isApprove ? 'Tagihan aktif dan jadwal tenor angsuran beserta jurnal otomatis akan resmi dibukukan.' : 'Pengajuan pengadaan barang ini akan dibatalkan.',
            icon: isApprove ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: isApprove ? '#198754' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isApprove ? 'Ya, Setujui' : 'Ya, Tolak',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: endpoint,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Berhasil!', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
