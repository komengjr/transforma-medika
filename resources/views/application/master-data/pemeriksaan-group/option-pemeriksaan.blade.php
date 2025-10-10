<div class="col">
    <label class="form-label text-warning" for="inputAddress">Pemeriksaan</label>
    <select name="pemeriksaan" id="pemeriksaan" class="form-control choices-single-pemeriksaan">
        <option value="">Pilih Pemeriksaan</option>
        @foreach ($data as $datas)
        <option value="{{ $datas->t_pemeriksaan_data_code  }}">{{ $datas->t_pemeriksaan_data_name }}</option>
        @endforeach
    </select>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-pemeriksaan"));
    $('#pemeriksaan').on("change", function() {
        var dataid = document.getElementById("pemeriksaan").value;
        if (dataid == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Sudah dipilih'
            });
        } else {
            $.ajax({
                url: "{{ route('master_pemeriksaan_group_pilih_pemeriksaan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": dataid,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#data-table-pemeriksaan").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
