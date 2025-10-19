<select class="form-select mb-3" aria-label="Default select example" id="pilihan-pemeriksaan">
    <option value="">Pilih Pemeriksaan</option>
    @foreach ($data as $datas)
        <option value="{{ $datas->p_sales_data_code }}">{{ $datas->t_pemeriksaan_list_name }} - @currency($datas->p_sales_data_price)</option>
    @endforeach
</select>
