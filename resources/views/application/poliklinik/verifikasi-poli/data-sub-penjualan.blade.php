<select class="form-select mb-3" aria-label="Default select example" id="pilihan-sub-penjualan">
    <option value="">Pilih Paket Penjualan</option>
    @foreach ($data as $datas)
        <option value="{{ $datas->p_sales_code }}">{{ $datas->p_sales_name }}</option>
    @endforeach
</select>
<script>
    $('#pilihan-sub-penjualan').on("change", function () {
        var code = document.getElementById('pilihan-sub-penjualan').value;
        if (code == "") {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Pilih dulu Yang bener"
            });
        } else {
            $.ajax({
                url: "{{ route('verifikasi_poliklinik_dokter_pilih_sub_penjualan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                },
                dataType: 'html',
            }).done(function (data) {
                $("#menu-sub-penjualan").html(data);
            }).fail(function () {
                console.log('eror');
            });
        }
    });
</script>
