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
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>
                          123
                      </td>
                      <td>
                          123
                      </td>
                      <td class="text-center align-middle">
                          123
                      </td>
                      <td class="text-center align-middle">
                          123
                      </td>
                  </tr>

              </tbody>
          </table>
      </div>
      <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
          <form action="#" id="form-event-class" method="post">
              @csrf
              <div class="row gx-2">
                  <div class="col-sm-6 mb-3">
                      <label class="form-label" for="field-name">Name</label>
                      <input class="form-control form-control-sm" id="field-name" name="nama_class" type="text" placeholder="Name (e.g. T-shirt)">
                  </div>
                  <div class="col-sm-6 mb-3">
                      <label class="form-label" for="field-name">Room</label>
                      <input class="form-control form-control-sm" id="field-name" name="nama_room" type="text" placeholder="Name (e.g. T-shirt)">
                  </div>
                  <div class="col-sm-6 mb-3">
                      <label class="form-label" for="field-name">Price</label>
                      <input class="form-control form-control-sm" id="field-name" type="text" placeholder="Name (e.g. T-shirt)">
                  </div>
                  <div class="col-sm-6 mb-3">
                      <label class="form-label" for="field-type">Type</label>
                      <select class="form-select form-select-sm" id="field-type">
                          <option>Select a type</option>
                          <option value="default">Default</option>
                          <option value="custom">Custom</option>
                      </select>
                  </div>
                  <div class="col-12">
                      <label class="form-label" for="field-options">Field Options</label>
                      <textarea class="form-control form-control-sm" id="field-options" rows="3"></textarea>
                      <div class="form-text fs--1 text-warning">* Separate your options with comma</div>
                  </div>
              </div>
          </form>
      </div>
      <button class="btn btn-falcon-default btn-sm mt-2" type="button" id="button-add-event-class">
          <span class="fas fa-plus"></span> Add
      </button>
  </div>
  <script>
      $(document).on("click", "#button-add-event-class", function(e) {
          e.preventDefault();
          var data = $("#form-event-class").serialize();
          console.log(data);
          $.ajax({
              url: "{{ route('menu_event_data_detail_event_save_class') }}",
              type: "POST",
              cache: false,
              data: data,
              dataType: 'html',
          }).done(function(data) {
              if (data == 0) {
                  Swal.fire({
                      icon: "error",
                      title: "Oops...",
                      text: "Tolong lah Isi dengan Bener!",
                      footer: '<a href="#">Why do I have this issue?</a>'
                  });
              } else {
                  $('#data-table-event-class').html(data);
              }
          }).fail(function() {
              $('#data-table-event-class').html('eror');
          });
      });
  </script>
