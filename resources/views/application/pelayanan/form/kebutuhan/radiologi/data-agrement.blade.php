 <label class="form-label" for="field-type">Pilih Paket</label>
 <select class="form-select choices-single-type" id="pilih_type_agrement">
     <option value="">Select</option>
     @foreach ($data as $datas)
     <option value="{{ $datas->p_sales_cat_code }}">{{ $datas->p_sales_cat_name }}</option>
     @endforeach
 </select>
 <script>
     new window.Choices(document.querySelector(".choices-single-type"));
     $('#pilih_type_agrement').on("change", function() {
         var dataid = document.getElementById("pilih_type_agrement").value;
         console.log(dataid);

         if (dataid == "") {
             Lobibox.notify('warning', {
                 pauseDelayOnHover: true,
                 continueDelayOnInactiveTab: true,
                 position: 'top right',
                 icon: 'fas fa-info-circle',
                 msg: 'Pastikan Layanan & Tanggal Sudah diisi'
             });
         } else {
             $.ajax({
                 url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_type_agrement') }}",
                 type: "POST",
                 cache: false,
                 data: {
                     "_token": "{{ csrf_token() }}",
                     "id": dataid,
                 },
                 dataType: 'html',
             }).done(function(data) {
                 $("#menu-pilihan-type-agrement").html(data);
             }).fail(function() {
                 console.log('eror');
             });
         }
     });
     $(document).on("click", "#button-pilih-data-pemeriksaan-pasien", function(e) {
         e.preventDefault();
         var code = $(this).data("code");
         var reg = document.getElementById("no_registrasi").value;
         $.ajax({
             url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_pemeriksaan') }}",
             type: "POST",
             cache: false,
             data: {
                 "_token": "{{ csrf_token() }}",
                 "code": code,
                 "reg": reg,
             },
             dataType: 'html',
         }).done(function(data) {
             $('#menu-harga-pemeriksaan').html(data);
         }).fail(function() {
             $('#menu-harga-pemeriksaan').html('eror');
         });
     });
     $(document).on("click", "#button-remove-data-pemeriksaan-pasien", function(e) {
         e.preventDefault();
         var code = $(this).data("code");
         var reg = $(this).data("reg");
         $.ajax({
             url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_remove_pemeriksaan_rad') }}",
             type: "POST",
             cache: false,
             data: {
                 "_token": "{{ csrf_token() }}",
                 "code": code,
                 "reg": reg,
             },
             dataType: 'html',
         }).done(function(data) {
             $('#menu-harga-pemeriksaan').html(data);
         }).fail(function() {
             $('#menu-harga-pemeriksaan').html('eror');
         });
     });
 </script>
