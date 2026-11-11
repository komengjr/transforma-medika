<div class="modal-body p-0 retro-modal-content" id="form-proses-transaksi" data-laporan-id="{{ $laporan->id }}">
    <div class="py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-cyan); border-bottom: 3px solid var(--retro-dark);">
        <div>
            <h4 class="mb-1 text-dark fw-bolder fs-0" id="staticBackdropLabel">
                <i class="fas fa-file-invoice-dollar me-2"></i> Proses Verifikasi Setoran & Transaksi
            </h4>
            <p class="fs--2 mb-0 text-dark fw-bold opacity-75">No. Laporan: <span class="font-monospace">{{ $laporan->no_laporan ?? '-' }}</span> | Support by <span class="fw-bolder text-dark">Transforma</span></p>
        </div>
        <span class="badge bg-white text-dark border border-dark px-3 py-2 fw-bolder shadow-sm fs--1">
            Status: {{ $laporan->status_verifikasi ?? 'PENDING' }}
        </span>
    </div>

    <div class="p-4 bg-white">
        <div class="row g-3">
            <!-- PROFIL / INFORMASI UTAMA PASIEN & LAPORAN -->
            <div class="col-12">
                <div class="p-3 rounded-3 bg-light border border-dark shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <div class="patient-avatar-wrapper flex-shrink-0" style="width: 50px; height: 50px;">
                            <img src="{{ !empty($data->foto) ? $data->foto : 'https://png.pngtree.com/png-vector/20220529/ourmid/pngtree-blue-user-icon-profile-and-account-vector-design-vector-sign-vector-png-image_46129432.jpg' }}"
                                class="rounded-circle shadow-sm"
                                alt="Foto Pasien" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                        </div>
                        <div class="flex-grow-1">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <span class="fs--2 text-dark fw-bold d-block">Nama Pelapor Utama</span>
                                    <h6 class="fw-bolder mb-0 text-dark fs-0">
                                        {{ $data->awalan ?? '' }} {{ $data->nama ?? 'Data Transaksi Gabungan' }} {{ $data->akhiran ?? '' }}
                                    </h6>
                                    <span class="badge bg-white text-dark border border-dark fw-bold fs--2 mt-1 shadow-sm">PID: {{ $data->pid ?? '-' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="fs--2 text-dark fw-bold d-block">Total Setoran</span>
                                    <h6 class="fw-bolder mb-0 text-success fs-0">Rp {{ number_format($laporan->total_setoran ?? 0, 0, ',', '.') }}</h6>
                                </div>
                                <div class="col-md-3">
                                    <span class="fs--2 text-dark fw-bold d-block">Total Transaksi</span>
                                    <span class="badge bg-white text-dark border border-dark fw-bold shadow-sm px-2 py-1">{{ $laporan->jumlah_transaksi ?? 0 }} Nota</span>
                                </div>
                                <div class="col-md-2 text-md-end">
                                    <span class="fs--2 text-dark fw-bold d-block">Petugas Kasir</span>
                                    <span class="fw-bolder text-dark fs--1"><i class="fas fa-user-shield me-1"></i> {{ $laporan->user_id ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL DAFTAR TRANSAKSI DAN RINCIAN PEMERIKSAAN -->
            <div class="col-12">
                <div class="card border-2 border-dark rounded-3 shadow-sm">
                    <div class="card-header py-2 px-3 fw-bolder text-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow); border-bottom: 2px solid var(--retro-dark);">
                        <span><i class="fas fa-list-alt me-1"></i> Rincian Seluruh Transaksi & Pemeriksaan</span>
                        <span class="badge bg-white text-dark border border-dark fs--2 fw-bold">{{ count($transaksiList) }} Transaksi</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="accordion accordion-flush" id="accordionTransaksiList">

                            @forelse($transaksiList as $index => $trx)
                            <div class="accordion-item border-bottom border-dark">
                                <h2 class="accordion-header" id="headingTrx{{ $index }}">
                                    <button class="accordion-button collapsed py-2 px-3 bg-white text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrx{{ $index }}" aria-expanded="false" aria-controls="collapseTrx{{ $index }}">

                                        <div class="d-flex justify-content-between w-100 align-items-center pe-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light px-2 py-1 border border-dark rounded-2 fw-bolder font-monospace fs--2">{{ $trx->no_registrasi }}</div>
                                                <div>
                                                    <div class="fw-bolder text-dark fs--1 mb-0">{{ $trx->awalan }} {{ $trx->nama }} {{ $trx->akhiran }}</div>
                                                    <div class="fs--2 text-dark fw-bold opacity-75">
                                                        <i class="fas fa-hospital me-1"></i>{{ str_replace('_', ' ', $trx->jenis_layanan) }}
                                                        &bull;
                                                        <i class="fas fa-hand-holding-medical me-1"></i>{{ $trx->nama_sub_penjamin ?? 'UMUM REGULER' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="fw-bolder text-success fs--1">Rp {{ number_format($trx->total_tagihan, 0, ',', '.') }}</div>
                                                <span class="badge {{ $trx->status_pembayaran == 'LUNAS' ? 'bg-success' : 'bg-danger' }} text-white border border-dark fw-bold fs--2 px-2 py-1 shadow-sm mt-1">
                                                    {{ $trx->metode_bayar }} - {{ $trx->status_pembayaran }}
                                                </span>
                                            </div>
                                        </div>

                                    </button>
                                </h2>
                                <div id="collapseTrx{{ $index }}" class="accordion-collapse collapse" aria-labelledby="headingTrx{{ $index }}" data-bs-parent="#accordionTransaksiList">
                                    <div class="accordion-body bg-light p-3" style="border-top: 2px dashed var(--retro-dark);">

                                        <!-- Info Dokter -->
                                        <div class="d-flex align-items-center gap-2 mb-3 bg-white p-2 rounded-2 border border-dark shadow-sm d-inline-flex">
                                            <div class="bg-dark text-white rounded-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;"><i class="fas fa-user-md"></i></div>
                                            <div>
                                                <span class="fs--2 d-block fw-bold text-dark lh-1">Dokter Pemeriksa:</span>
                                                <span class="fw-bolder fs--1 text-dark">{{ $trx->nama_dokter_pemeriksa ?? 'Tidak Ada Dokter / Pemeriksaan Mandiri' }}</span>
                                            </div>
                                        </div>

                                        <!-- Tabel Detail Tindakan -->
                                        <div class="table-responsive border border-dark rounded-2 overflow-hidden shadow-sm bg-white">
                                            <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.75rem;">
                                                <thead class="table-dark text-white">
                                                    <tr>
                                                        <th class="ps-2 py-2" style="width: 40%;">Layanan / Tindakan</th>
                                                        <th class="py-2 text-center">Kategori</th>
                                                        <th class="py-2 text-end">Harga Dasar</th>
                                                        <th class="py-2 text-end">Diskon / Cito</th>
                                                        <th class="pe-2 py-2 text-end">Total Akhir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($trx->items_pemeriksaan) && count($trx->items_pemeriksaan) > 0)
                                                    @foreach($trx->items_pemeriksaan as $item)
                                                    <tr>
                                                        <td class="ps-2 fw-bold text-dark">
                                                            {{ $item->nama_layanan ?? 'Biaya Komponen Tindakan / Jasa' }}
                                                            @if($item->is_cito == 1) <span class="badge bg-danger ms-1 fs--2">CITO</span> @endif
                                                        </td>
                                                        <td class="text-center fw-bold">{{ $item->kategori_biaya }}</td>
                                                        <td class="text-end fw-bold">Rp {{ number_format($item->harga_dasar, 0, ',', '.') }}</td>
                                                        <td class="text-end fw-bold">
                                                            @if($item->diskon > 0)
                                                            <span class="text-danger">-Rp {{ number_format($item->diskon, 0, ',', '.') }}</span>
                                                            @elseif($item->biaya_cito > 0)
                                                            <span class="text-danger">+Rp {{ number_format($item->biaya_cito, 0, ',', '.') }}</span>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td class="pe-2 text-end fw-bolder text-success">Rp {{ number_format($item->harga_akhir, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="5" class="text-center py-2 text-muted fw-bold">Tidak ada rincian tindakan.</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="p-4 text-center">
                                <i class="fas fa-file-invoice fa-3x text-dark opacity-25 mb-3"></i>
                                <h6 class="fw-bolder text-dark">Tidak ada transaksi ditemukan dalam laporan ini.</h6>
                            </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>

            <!-- AKORDION CATATAN & FORM TAMBAHAN -->
            <div class="col-12">
                <div class="card border border-dark rounded-3 shadow-sm">
                    <div class="card-body bg-white p-3">
                        <div class="accordion border-2 border-dark rounded overflow-hidden shadow-sm" id="accordionFaq">

                            <!-- AKORDION 1: CATATAN VERIFIKASI -->
                            <div class="card shadow-none border-bottom border-dark rounded-0">
                                <div class="card-header p-0" id="faqAccordionHeading1" style="background-color: var(--retro-purple);">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start fw-bolder text-dark shadow-none"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1"
                                        aria-expanded="true" aria-controls="collapseFaqAccordion1">
                                        <span class="far fa-dot-circle me-2"></span>
                                        <span>Catatan / Validasi Keuangan</span>
                                    </button>
                                </div>
                                <div class="bg-light collapse show" id="collapseFaqAccordion1"
                                    aria-labelledby="faqAccordionHeading1" data-parent="#accordionFaq">
                                    <div class="card-body p-3">
                                        <textarea class="form-control border-dark border-2 fw-bold bg-white" id="catatan_verifikasi" rows="3" placeholder="Ketik catatan audit atau keterangan verifikasi setoran kasir..."></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="col-12 text-end">
                <button class="btn px-4 py-2 fw-bolder shadow-sm" type="button" data-bs-dismiss="modal" style="background-color: var(--retro-pink); color: var(--retro-dark); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
                <button class="btn px-4 py-2 fw-bolder shadow-sm" id="button-simpan-proses-transaksi" style="background-color: var(--retro-green); color: var(--retro-dark); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                    <i class="fas fa-check-double me-1"></i> Setujui & Verifikasi Laporan
                </button>
            </div>
        </div>
    </div>
</div>
