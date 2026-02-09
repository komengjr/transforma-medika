<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Registrasi Event</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">{{env('APP_NAME')}}</a>
        </p>
    </div>
    <div class="p-3">
        <div class="card mb-3 border">
            <!-- <img class="card-img-top" src="../../assets/img/generic/13.jpg" alt=""> -->
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <div class="d-flex">
                            <div class="calendar me-4">
                                <img src="{{ Storage::url($data->event_data_template) }}" alt="" width="50">
                            </div>
                            <div class="flex-1 fs--1">
                                <h5 class="fs-0">{{$data->event_data_tittle}}</h5>
                                <p class="mb-0">by <a href="#!">{{$data->event_data_venue}}</a></p><span class="fs-0 text-warning fw-semi-bold">{{$data->event_data_start_date}} – {{ $data->event_data_end_date }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto mt-4 mt-md-0">
                        <button class="btn btn-falcon-default btn-sm me-2" type="button"><svg class="svg-inline--fa fa-share-alt fa-w-14 me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="share-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M352 320c-22.608 0-43.387 7.819-59.79 20.895l-102.486-64.054a96.551 96.551 0 0 0 0-41.683l102.486-64.054C308.613 184.181 329.392 192 352 192c53.019 0 96-42.981 96-96S405.019 0 352 0s-96 42.981-96 96c0 7.158.79 14.13 2.276 20.841L155.79 180.895C139.387 167.819 118.608 160 96 160c-53.019 0-96 42.981-96 96s42.981 96 96 96c22.608 0 43.387-7.819 59.79-20.895l102.486 64.054A96.301 96.301 0 0 0 256 416c0 53.019 42.981 96 96 96s96-42.981 96-96-42.981-96-96-96z"></path>
                            </svg><!-- <span class="fas fa-share-alt me-1"></span> Font Awesome fontawesome.com -->Share</button>
                        <button class="btn btn-falcon-primary btn-sm px-4 px-sm-5" type="button" onclick='window.open("{{ route("event_registrasi",["id"=>$data->event_data_code,"code"=>123]) }}", "_blank");'>Register</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-3 pe-lg-2">
                <div class="card mb-3 mb-lg-0 border">
                    <div class="card-body fs--1">
                        <h5 class="fs-0 mb-3">Sub Event</h5>
                        @foreach ($event_sub as $event)
                        <div class="d-flex btn-reveal-trigger">
                            <div class="calendar"><img src="{{ asset('img/svg/monitor-svgrepo-com.svg') }}" alt=""></div>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-0 mb-0"><a href="#" id="button-detail-sub-event" data-code="{{ $event->event_data_sub_code }}">{{$event->event_data_sub_name}}</a></h6>
                                <p class="mb-1">Date by <a href="#!" class="text-700">{{$event->event_data_sub_start}} - {{$event->event_data_sub_end}}</a></p>
                                @php
                                $sub = DB::table('event_data_sub_class')->where('event_data_sub_code',$event->event_data_sub_code)->get();
                                @endphp
                                @foreach ($sub as $subs)
                                <p class="text-1000 mb-0">{{$subs->event_data_sub_class_name}}</p>
                                @endforeach
                                Place: Cambridge Boat Club, Cambridge
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

            </div>
            <div class="col-lg-9 ps-lg-2" id="menu-detail-seub-event">

            </div>
        </div>
        <div id="show-data-event-all"></div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
