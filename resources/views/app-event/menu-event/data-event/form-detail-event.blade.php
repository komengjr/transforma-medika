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
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white">Sub Event Details</h5>
                        </div>
                        <div class="card-body bg-light">
                            <table id="data_sub_event" class="table table-striped border" style="width:100%">
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
                                        <td><button class="btn btn-warning btn-sm" type="button" id="button-add-type-peserta" data-code="{{ $sub_events->event_data_sub_code }}">Add Class</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card mb-3" id="menu-type-peserta">

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
