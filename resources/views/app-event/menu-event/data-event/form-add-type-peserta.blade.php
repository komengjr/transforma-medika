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
                  <form action="#" id="form-sub-event-class" method="post">
                      @csrf
                      <div class="row gx-2">
                          <div class="col-sm-6 mb-3">
                              <label class="form-label" for="field-name">Class Name</label>
                              <input class="form-control form-control-sm" id="nama_class" name="nama_class" type="text" placeholder="Name (e.g. T-shirt)">
                              <input type="text" name="code_event" value="{{ $code }}" id="" hidden>
                          </div>
                          <div class="col-sm-6 mb-3">
                              <label class="form-label" for="field-name">Room Name</label>
                              <input class="form-control form-control-sm" id="nama_room" name="nama_room" type="text" placeholder="Name (e.g. T-shirt)">
                          </div>
                          <div class="col-sm-6 mb-3">
                              <label class="form-label" for="field-name">Price</label>
                              <input class="form-control form-control-sm" id="class_price" type="text" name="class_price" placeholder="Name (e.g. T-shirt)">
                          </div>
                          <div class="col-sm-6 mb-3">
                              <label class="form-label" for="field-type">Type Class</label>
                              <select class="form-select form-select-sm" id="field-type" name="class_type">
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
