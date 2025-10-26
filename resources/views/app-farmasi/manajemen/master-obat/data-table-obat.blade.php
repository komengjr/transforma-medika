<table id="example" class="table table-striped border" style="width:100%">
    <thead class="bg-warning text-100">
        <tr>
            <th>Kode</th>
            <th>Nama Obat</th>
            <th>Satuan</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th>Batch & Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="dataBody">
        <tr>
            <td data-label="Kode">1</td>
            <td data-label="Nama">2</td>
            <td data-label="Satuan">3</td>
            <td data-label="Kategori">4</td>
            <td data-label="Pabrikan">5</td>
            <td data-label="Batch">6</td>
            <td data-label="Aksi">
                <button class="btn btn-sm btn-outline-warning" 1>✏️</button>
                <button class="btn btn-sm btn-outline-danger" 2>🗑️</button>
            </td>
        </tr>
    </tbody>
</table>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
