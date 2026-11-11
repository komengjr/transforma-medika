<div class="modal-body p-0">
    <!-- Header Modal Tema Retro -->
    <div class="py-3 ps-4 pe-6" style="background-color: var(--retro-dark); border-bottom: 3px solid var(--retro-dark);">
        <h4 class="mb-1 fw-bolder" style="color: var(--retro-green);" id="staticBackdropLabel">
            <i class="fas fa-file-invoice me-2"></i> Detail Invoice / Nota Penjualan
        </h4>
        <p class="fs--2 mb-0 text-white">Support by <span class="fw-bold" style="color: var(--retro-yellow);">{{ Env('APP_LABEL') }}</span></p>
    </div>

    <div class="p-4 bg-white">
        <!-- Top Bar Action & Nomor Nota -->
        <div class="card mb-3 retro-card shadow-sm">
            <div class="card-body p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <h5 class="mb-0 fw-bold text-dark">No. Nota / Order: <span class="text-success">{{ $order->farm_order_data_code ?? $code }}</span></h5>
                    </div>
                    <div class="col-auto">
                        <button class="btn retro-btn retro-btn-primary btn-sm me-1 mb-2 mb-sm-0" type="button" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Print Nota
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Body Card -->
        <div class="card retro-card border-0">
            <div class="card-body p-4">
                <!-- Header Nota / Instansi -->
                <div class="row align-items-center text-center mb-3">
                    <div class="col-sm-6 text-sm-start">
                        <img src="{{ asset('img/favicon.png') }}" alt="logo" width="100" class="mb-2">
                        <h5 class="fw-bold mb-0 text-dark">{{ Env('APP_LABEL', 'Sistem Farmasi') }}</h5>
                        <p class="fs--1 text-muted mb-0">Layanan Kesehatan & Farmasi Terpadu</p>
                    </div>
                    <div class="col text-sm-end mt-3 mt-sm-0">
                        <h3 class="mb-1 text-uppercase fw-bolder text-dark">INVOICE</h3>
                        <p class="fs--1 mb-0 fw-bold text-success">STATUS: LUNAS / SELESAI</p>
                    </div>
                    <div class="col-12">
                        <hr class="border-dark my-3">
                    </div>
                </div>

                <!-- Informasi Pembeli / Pasien & Detail Nota -->
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted fw-bold fs--1 text-uppercase">Informasi Pembeli / Pasien:</h6>
                        @php
                        $pasien = DB::table('farm_order_data_pasien')->where('farm_order_data_code', $code)->first();
                        @endphp
                        @if ($pasien)
                        <h5 class="fw-bolder text-dark mb-1">{{ $pasien->farm_order_data_pasien_name }}</h5>
                        <p class="fs--1 text-muted mb-0">Tipe Order: <span class="badge bg-primary">RESEP DOKTER</span></p>
                        @else
                        <h5 class="fw-bolder text-dark mb-1">Umum / Non-Resep</h5>
                        <p class="fs--1 text-muted mb-0">Tipe Order: <span class="badge bg-warning text-dark">NON RESEP (BEBAS)</span></p>
                        @endif
                    </div>
                    <div class="col-md-6 ms-auto mt-3 mt-md-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs--1 mb-0">
                                <tbody>
                                    <tr>
                                        <th class="text-end text-muted">No. Order / Nota:</th>
                                        <td class="fw-bold text-dark">: {{ $code }}</td>
                                    </tr>
                                    @php
                                    $orderHeader = DB::table('farm_order_data')->where('farm_order_data_code', $code)->first();
                                    @endphp
                                    <tr>
                                        <th class="text-end text-muted">Tanggal Transaksi:</th>
                                        <td class="fw-bold text-dark">: {{ $orderHeader->farm_order_data_date ?? date('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-end text-muted">Metode Pembayaran:</th>
                                        <td class="fw-bold text-dark">: Tunai / Kasir</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tabel Item Obat -->
                <div class="table-responsive scrollbar mb-4 fs--1">
                    <table class="table table-bordered table-custom align-middle">
                        <thead class="table-dark" style="background-color: var(--retro-dark); color: var(--retro-green);">
                            <tr>
                                <th class="py-2 px-3 text-start">Nama Produk / Obat</th>
                                <th class="py-2 px-3 text-center" style="width: 80px;">Qty</th>
                                <th class="py-2 px-3 text-end" style="width: 130px;">Harga Satuan</th>
                                <th class="py-2 px-3 text-end" style="width: 140px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @php
                            $subtotalTotal = 0;
                            $listObat = DB::table('farm_order_data_list')
                            ->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_order_data_list.farm_data_obat_code')
                            ->where('farm_order_data_code', $code)
                            ->get();
                            @endphp

                            @if($listObat->count() > 0)
                            @foreach ($listObat as $item)
                            @php
                            $sub = $item->farm_order_data_list_price * $item->farm_order_data_list_qty;
                            $subtotalTotal += $sub;
                            @endphp
                            <tr>
                                <td class="align-middle py-2 px-3">
                                    <h6 class="mb-0 fw-bold text-dark">{{ $item->farm_data_obat_name }}</h6>
                                    <small class="text-muted">Kode: {{ $item->farm_data_obat_code }}</small>
                                </td>
                                <td class="align-middle text-center py-2 px-3 fw-bold">{{ $item->farm_order_data_list_qty }}</td>
                                <td class="align-middle text-end py-2 px-3">@currency($item->farm_order_data_list_price)</td>
                                <td class="align-middle text-end py-2 px-3 fw-bold text-success">@currency($sub)</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted fw-bold">Tidak ada rincian obat pada order ini.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Bagian Total Pembayaran -->
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <table class="table table-sm table-borderless fs--1 text-end">
                            <tbody>
                                <tr>
                                    <th class="text-muted">Subtotal:</th>
                                    <td class="fw-bold text-dark">@currency($subtotalTotal)</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Diskon / PPN:</th>
                                    <td class="fw-bold text-dark">Rp 0</td>
                                </tr>
                                <tr class="border-top border-dark">
                                    <th class="text-dark fw-bolder fs-2 pt-2">Total Pembayaran:</th>
                                    <td class="fw-bolder text-danger fs-2 pt-2">@currency($subtotalTotal)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Footer Catatan Nota -->
            <div class="card-footer bg-light border-top border-dark p-3">
                <p class="fs--1 mb-0 text-muted"><strong>Catatan: </strong>Terima kasih atas kunjungan dan pembelian Anda di unit farmasi kami. Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-light border-top border-dark">
    <button type="button" class="btn retro-btn btn-secondary btn-sm px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
</div>
