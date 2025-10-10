  <label class="form-label" for="inputAddress">Group Penjualan</label>
  <a href="#"><span class="fas fa-plus-square"></span> add Group</a>
  <select name="group_pemeriksaan" id="group_pemeriksaan" class="form-control choices-single-paket">
      <option value="">Pilih Paket</option>
      @foreach ($data as $datas)
          <option value="{{ $datas->p_pemeriksaan_code  }}">{{ $datas->p_pemeriksaan_name }}
          </option>
      @endforeach
  </select>

  <script>
      new window.Choices(document.querySelector(".choices-single-paket"));
  </script>
  <script>
      $('#group_pemeriksaan').on("change", function() {
          var dataid = document.getElementById('group_pemeriksaan').value;
          if (dataid == '') {
              Lobibox.notify('warning', {
                  pauseDelayOnHover: true,
                  continueDelayOnInactiveTab: true,
                  position: 'top right',
                  icon: 'fas fa-info-circle',
                  msg: 'Pastikan Master Sudah dipilih'
              });
          } else {
              $.ajax({
                  url: "{{ route('master_pemeriksaan_harga_group') }}",
                  type: "POST",
                  cache: false,
                  data: {
                      "_token": "{{ csrf_token() }}",
                      "code": dataid,
                  },
                  dataType: 'html',
              }).done(function(data) {
                  $("#menu-group-pemeriksaan").html(data);
              }).fail(function() {
                  console.log('eror');
              });
          }
      });
  </script>
