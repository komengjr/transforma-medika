  <div class="row g-3">
      <div class="col-md-7">
          <div class="card-header bg-warning">
              <h5 class="mb-0 text-white">Sub Event Class</h5>
          </div>
          <div class="card-body bg-light">
              <div id="data-table-event-class">
                  <table class="table table-bordered mt-0 bg-white dark__bg-1100">
                      <thead>
                          <tr class="fs--1 bg-300">
                              <th>Event Class Name</th>
                              <th>Room</th>
                              <th>Price</th>
                              <th>Kuota</th>
                              <th>#</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($data as $datas)
                          <tr>
                              <td>
                                  {{$datas->event_data_sub_class_name}}
                              </td>
                              <td>
                                  {{$datas->event_data_sub_class_room}}
                              </td>
                              <td class="text-center align-middle">
                                  {{$datas->event_data_sub_class_price}}
                              </td>
                              <td class="text-center align-middle">
                                  {{$datas->event_data_sub_class_kuota}}
                              </td>
                              <td class="text-center">
                                  <span class="fas fa-trash text-danger"></span>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
                  <form action="#" id="forms-sub-event-class" method="post">
                      @csrf
                      <div class="row gx-2">
                          <div class="col-sm-6 mb-3">
                              <label class="form-label" for="nama_class">Class Name</label>
                              <input class="form-control form-control-sm" id="nama_class" name="nama_class" type="text" placeholder="e.g. Workshop VIP">
                              <!-- Hidden Input Code Event -->
                              <input type="hidden" name="code_event" value="{{ $code }}">
                          </div>
                          <div class="col-sm-6 mb-3">
                              <label class="form-label" for="nama_room">Room Name</label>
                              <input class="form-control form-control-sm" id="nama_room" name="nama_room" type="text" placeholder="e.g. Room A">
                          </div>
                          <div class="col-sm-6 mb-3">
                              <label class="form-label" for="class_price">Price</label>
                              <input class="form-control form-control-sm" id="class_price" type="number" name="class_price" placeholder="e.g. 150000">
                          </div>
                          <div class="col-sm-6 mb-3">
                              <label class="form-label" for="field-type">Type Class</label>
                              <select class="form-select form-select-sm" id="field-type" name="class_type">
                                  <option value="">Select a type</option>
                                  <option value="default" selected>Default</option>
                                  <option value="hide">Hide</option>
                              </select>
                          </div>
                      </div>
                  </form>
              </div>
              <div id="button-save-event-detail">
                  <button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-class">
                      <span class="fas fa-plus"></span> Add
                  </button>
              </div>
          </div>
      </div>
      <div class="col-md-5">
          <div class="card-header bg-warning">
              <h5 class="mb-0 text-white">Sub Event Session</h5>
          </div>
          <div class="card-body bg-light">
              <div id="data-table-event-session">
                  <table class="table table-bordered mt-0 bg-white dark__bg-1100">
                      <thead>
                          <tr class="fs--1 bg-300">
                              <th>Sesion Name</th>
                              <th>#</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($session as $sessions)
                          <tr>
                              <td>{{ $sessions->event_data_sub_session_name }}</td>
                              <td class="text-center"><span class="fas fa-trash text-danger"></span></td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
                  <form action="#" id="form-sub-event-session" method="post">
                      @csrf
                      <div class="row gx-2">
                          <div class="col-sm-12 mb-3">
                              <label class="form-label" for="field-name">Session Name</label>
                              <input class="form-control form-control-sm" id="nama_session" name="nama_session" type="text" placeholder="Name (e.g. T-shirt)">
                              <input type="text" name="code_event" value="{{ $code }}" id="" hidden>
                          </div>
                      </div>
                  </form>
              </div>
              <div id="button-save-event-session">
                  <button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-session">
                      <span class="fas fa-plus"></span> Add
                  </button>
              </div>
          </div>
      </div>
  </div>
  <script>
      // Gunakan .off("click") untuk menghapus event listener ganda/duplicate
      $(document).off("click", "#button-add-event-class").on("click", "#button-add-event-class", function(e) {
          e.preventDefault();

          var $btn = $(this);
          var formData = $("#forms-sub-event-class").serialize();

          // Nonaktifkan tombol agar tidak bisa diklik berkali-kali saat loading
          $btn.prop('disabled', true);

          $('#button-save-event-detail').html(
              '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
          );

          $.ajax({
              url: "{{ route('menu_event_data_detail_event_save_class') }}",
              type: "POST",
              data: formData,
              dataType: 'html',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response) {
                  if ($.trim(response) === "0") {
                      Swal.fire({
                          icon: "error",
                          title: "Gagal Menambah Class",
                          text: "Mohon isi field nama kelas dengan benar!",
                      });
                  } else {
                      // Update tabel partial
                      $('#data-table-event-class').html(response);

                      // Reset isi input form
                      $('#nama_class').val('');
                      $('#nama_room').val('');
                      $('#class_price').val('');
                  }
              },
              error: function(xhr, status, error) {
                  Swal.fire({
                      icon: "error",
                      title: "Error Server",
                      text: "Terjadi kesalahan saat menyimpan data.",
                  });
              },
              complete: function() {
                  // Restore tombol add
                  $('#button-save-event-detail').html(
                      '<button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-class"><span class="fas fa-plus"></span> Add</button>'
                  );
              }
          });
      });
  </script>
