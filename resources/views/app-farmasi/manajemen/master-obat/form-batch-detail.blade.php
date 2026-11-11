<div class="card retro-card border-0 mb-0" style="box-shadow: none !important;">
    <!-- Header Banner Panel Kanan -->
    <div class="card-header py-3 px-4" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark);">
        <h5 class="mb-1 text-dark fw-bolder" id="staticBackdropLabel">
            <i class="fas fa-boxes me-2"></i> Batch: {{ $obat->farm_data_obat_name }}
        </h5>
        <p class="fs--2 mb-0 text-dark fw-bold opacity-75">Manajemen Stok, Harga, & Tanggal Kadaluarsa</p>
    </div>

    <!-- Body Panel -->
    <div class="card-body p-3 bg-white">
        <div class="table-responsive">
            <table id="data-batch-panel" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center">GRN / Info</th>
                        <th class="text-end">Harga (Beli / Jual)</th>
                        <th>Rincian Batch, Exp & Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $datas)
                    <tr>
                        <td class="text-center">
                            <span class="retro-badge bg-white text-dark">{{ $datas->pem_grn_token_number }}</span><br>
                            <small class="text-muted fw-bold" style="font-size: 0.65rem;">{{ $datas->farm_data_obat_sale_desc ?? '-' }}</small>
                        </td>
                        <td class="text-end text-nowrap">
                            <span class="text-muted fs--2 d-block">Beli: <strong>@currency($datas->farm_data_obat_sale_buy)</strong></span>
                            <span class="text-success fs--2 d-block">Jual: <strong>@currency($datas->farm_data_obat_sale_sell)</strong></span>
                        </td>
                        <td>
                            @php
                            $exp = DB::table('farm_data_obat_exp')->where('pem_grn_token_code', $datas->pem_grn_token_code)->get();
                            @endphp
                            @forelse ($exp as $exps)
                            <div class="p-2 mb-1 border border-dark rounded bg-light shadow-sm" style="font-size: 0.75rem;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark"><i class="fas fa-calendar-alt text-danger me-1"></i> Masuk: {{ $exps->data_obat_tanggal_masuk }}</span>
                                    <span class="badge bg-dark text-warning">Stok: {{ $exps->data_obat_stok }}</span>
                                </div>
                                <div class="text-muted fw-bold">
                                    <i class="fas fa-hourglass-end text-warning me-1"></i> Exp: <span class="text-danger">{{ $exps->data_obat_tanggal_exp }}</span>
                                </div>
                            </div>
                            @empty
                            <span class="text-muted fst-italic fs--2">Belum ada batch exp terdaftar.</span>
                            @endforelse
                        </td>
                    </tr>
                    @empty
                    <!-- <tr>
                        <td colspan="3" class="text-center text-muted py-4 fw-bold">Belum ada data batch untuk obat ini.</td>
                    </tr> -->
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-light border-top border-dark py-2 px-3 text-end">
        <small class="text-muted fw-bold fs--2">Total GRN Terdaftar: {{ count($data) }}</small>
    </div>
</div>

<script>
    // Inisialisasi DataTables khusus untuk tabel batch di panel kanan
    if ($.fn.DataTable.isDataTable('#data-batch-panel')) {
        $('#data-batch-panel').DataTable().destroy();
    }
    $('#data-batch-panel').DataTable({
        responsive: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25],
        language: {
            search: "",
            searchPlaceholder: "Cari batch..."
        }
    });
</script>
