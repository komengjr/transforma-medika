<div class="table-responsive scrollbar">
    <table class="table table-sm table-striped border align-middle mb-0">
        <thead class="bg-200">
            <tr>
                <th width="5%" class="text-center">#</th>
                <th>Kode</th>
                <th>Nama Pemeriksaan</th>
                <th width="25%" class="text-end">Harga</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemeriksaan as $item)
            @php
            $netPrice = $item->p_sales_data_price - ($item->p_sales_data_disc ?? 0);
            @endphp
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input check-pemeriksaan"
                        data-code="{{ $item->p_sales_data_code }}"
                        data-nama="{{ $item->p_sales_data_name }}"
                        data-harga="{{ $netPrice }}">
                </td>
                <td><code>{{ $item->p_sales_data_code }}</code></td>
                <td class="fw-semi-bold">{{ $item->p_sales_data_name }}</td>
                <td class="text-end">
                    @if(($item->p_sales_data_disc ?? 0) > 0)
                    <del class="text-400 me-1" style="font-size: 0.8em;">Rp {{ number_format($item->p_sales_data_price, 0, ',', '.') }}</del>
                    @endif
                    <span class="text-success fw-bold">Rp {{ number_format($netPrice, 0, ',', '.') }}</span>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-xs btn-success btn-tambah-pemeriksaan"
                        data-code="{{ $item->p_sales_data_code }}"
                        data-nama="{{ $item->p_sales_data_name }}"
                        data-harga="{{ $netPrice }}">
                        <i class="fas fa-plus me-1"></i> Pilih
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-3">
                    Tidak ada item pemeriksaan dalam kategori ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
