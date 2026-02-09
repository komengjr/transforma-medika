<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3 border">
            <div class="card-header bg-primary">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Data Sub Event Class</span></h3>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered mt-0 bg-white dark__bg-1100">
                    <thead>
                        <tr class="fs--1 bg-300">
                            <th>Event Class Name</th>
                            <th>Room</th>
                            <th>Price</th>
                            <th>Jumlah Peserta</th>
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
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item"
                                            id="button-add-peserta-event" data-code="{{$datas->event_data_sub_class_code}}"><span class="far fa-edit"></span>
                                            Add Peserta Event</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                            id="button-add-123" data-code="123"><span class="far fa-folder-open"></span>
                                            Add Sub Event</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 mb-lg-0 border">
            <div class="card-header bg-primary">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Data Sub Event Session</span></h3>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered mt-0 bg-white dark__bg-1100">
                    <thead>
                        <tr class="fs--1 bg-300">
                            <th>Event Session Name</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($session as $sessions)
                        <tr>
                            <td>{{ $sessions->event_data_sub_session_name }}</td>
                            <td></td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item"
                                            id="button-add-peserta-event" data-code="123"><span class="far fa-clipboard"></span>
                                            Form Session</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item"
                                            id="button-add-123" data-code="123"><span class="far fa-folder-open"></span>
                                            Data Session</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
