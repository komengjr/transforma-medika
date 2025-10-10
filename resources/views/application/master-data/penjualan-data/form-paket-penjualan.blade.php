  <label class="form-label" for="inputAddress">Group Penjualan</label>
  <a href="#"><span class="fas fa-plus-square"></span> add Group</a>
  <select name="group_penjualan" id="group_penjualan" class="form-control choices-single-paket">
      <option value="">Pilih Paket</option>
      @foreach ($data as $datas)
          <option value="{{ $datas->p_sales_code }}">{{ $datas->p_sales_name }}
          </option>
      @endforeach
  </select>

  <script>
      new window.Choices(document.querySelector(".choices-single-paket"));
  </script>
  <script>
      $('#group_penjualan').on("change", function() {
          var dataid = document.getElementById('group_penjualan').value;
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
                  url: "{{ route('master_penjualan_data_group') }}",
                  type: "POST",
                  cache: false,
                  data: {
                      "_token": "{{ csrf_token() }}",
                      "code": dataid,
                  },
                  dataType: 'html',
              }).done(function(data) {
                  $("#menu-group-penjualan").html(data);
              }).fail(function() {
                  console.log('eror');
              });
          }
      });
  </script>
