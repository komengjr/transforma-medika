<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Setup Sub Event</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">{{env('APP_NAME')}}</a>
        </p>
    </div>
    <div class="p-4">
        <form class="row" id="form-input-sub-event">
            @csrf
            <div class="row g-0">
                <div class="col-lg-3 pe-lg-2">
                    <div class="mb-3">
                        <div class="card overflow-hidden">
                            <div class="card-img-top"><img class="img-fluid" id="videoPreview" src="{{Storage::url($data->event_data_template)}}" alt="Card image cap" /></div>
                            <div class="card-body">
                                <h5 class="card-title">{{$data->event_data_tittle}}</h5>
                                <p class="card-text">Tanggal Event : {{$data->event_data_start_date}} Sampai {{$data->event_data_end_date}}</p>
                                <p class="card-text">Lokasi Event : {{ $data->event_data_venue }}, {{ $data->event_data_city }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ps-lg-2">
                    <div class="card mb-3">
                        <div class="card-header bg-300">
                            <h5 class="mb-0">Sub Event Details</h5>
                        </div>
                        <div class="card-body bg-light">
                            <table id="data_sub_event" class="table table-striped" style="width:100%">
                                <thead class="bg-200 text-700">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sub Event</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach ($sub_event as $sub_events)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $sub_events->event_data_sub_name }}</td>
                                        <td>{{ $sub_events->event_data_sub_start }}</td>
                                        <td>{{ $sub_events->event_data_sub_end }}</td>
                                        <td></td>
                                        <td><button class="btn btn-warning btn-sm" type="button">Update</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header bg-300">
                            <h5 class="mb-0">Custom Peserta</h5>
                        </div>
                        <div class="card-body bg-light">
                            <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
                                <div class="position-absolute end-0 top-0 mt-2 me-3 z-index-1">
                                    <button class="btn btn-link btn-sm p-0" type="button"><svg class="svg-inline--fa fa-times-circle fa-w-16 text-danger" data-fa-transform="shrink-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;">
                                            <g transform="translate(256 256)">
                                                <g transform="translate(0, 0)  scale(0.9375, 0.9375)  rotate(0 0 0)">
                                                    <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" transform="translate(-256 -256)"></path>
                                                </g>
                                            </g>
                                        </svg><!-- <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1"></span> Font Awesome fontawesome.com --></button>
                                </div>
                                <div class="row gx-2">
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label" for="field-name">Name</label>
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
                            </div>
                            <button class="btn btn-falcon-default btn-sm mt-2" type="submit"><svg class="svg-inline--fa fa-plus fa-w-14 fs--2 me-1" data-fa-transform="up-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.4375em;">
                                    <g transform="translate(224 256)">
                                        <g transform="translate(0, -32)  scale(1, 1)  rotate(0 0 0)">
                                            <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" transform="translate(-224 -256)"></path>
                                        </g>
                                    </g>
                                </svg><!-- <span class="fas fa-plus fs--2 me-1" data-fa-transform="up-1"></span> Font Awesome fontawesome.com -->Add Item</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
<script>
    new DataTable('#data_sub_event', {
        responsive: true
    });
</script>
