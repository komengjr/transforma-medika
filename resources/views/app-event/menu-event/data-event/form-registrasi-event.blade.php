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
            <div class="col-lg-8 pe-lg-2">
                <div class="card mb-3 mb-lg-0 border">
                    <div class="card-body">
                        <h5 class="fs-0 mb-3">New Year's Eve on the Waterfront</h5>
                        <p>Boston Harbor Now in partnership with the Friends of Christopher Columbus Park, the Wharf District Council and the City of Boston is proud to announce the New Year's Eve Midnight Harbor Fireworks! This beloved nearly 40-year old tradition is made possible by the generous support of local waterfront organizations and businesses and the support of the City of Boston and the Office of Mayor Marty Walsh.</p>
                        <p>Join us as we ring in the New Year with a dazzling display over Boston Harbor. Public viewing is free and available from the Harborwalk of these suggested viewing locations:</p>
                        <ul>
                            <li>Christopher Columbus Park, North End</li>
                            <li>Fan Pier, Seaport District</li>
                            <li>East Boston Harborwalk</li>
                        </ul>
                        <p>The show will begin promptly at midnight.</p>
                        <p>Register here for a reminder and updates about the harbor fireworks and other waterfront public programs as they become available. Be the first to be notified for popular waterfront New Year's Eve public activities.</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 ps-lg-2">
                <div class="card mb-3 mb-lg-0 border">
                    <div class="card-body fs--1">
                        <h5 class="fs-0 mb-3">Sub Event</h5>
                        <div class="d-flex btn-reveal-trigger">
                            <div class="calendar"><span class="calendar-month">Feb</span><span class="calendar-day">21</span></div>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-0 mb-0"><a href="../../app/events/event-detail.html">Newmarket Nights</a></h6>
                                <p class="mb-1">Organized by <a href="#!" class="text-700">University of Oxford</a></p>
                                <p class="text-1000 mb-0">Time: 6:00AM</p>
                                <p class="text-1000 mb-0">Duration: 6:00AM - 5:00PM</p>Place: Cambridge Boat Club, Cambridge
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex btn-reveal-trigger">
                            <div class="calendar"><span class="calendar-month">Dec</span><span class="calendar-day">31</span></div>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-0 mb-0"><a href="../../app/events/event-detail.html">31st Night Celebration</a></h6>
                                <p class="mb-1">Organized by <a href="#!" class="text-700">Chamber Music Society</a></p>
                                <p class="text-1000 mb-0">Time: 11:00PM</p>
                                <p class="text-1000 mb-0">280 people interested</p>Place: Tavern on the Greend, New York
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex btn-reveal-trigger">
                            <div class="calendar"><span class="calendar-month">Dec</span><span class="calendar-day">16</span></div>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-0 mb-0"><a href="../../app/events/event-detail.html">Folk Festival</a></h6>
                                <p class="mb-1">Organized by <a href="#!" class="text-700">Harvard University</a></p>
                                <p class="text-1000 mb-0">Time: 9:00AM</p>
                                <p class="text-1000 mb-0">Location: Cambridge Masonic Hall Association</p>Place: Porter Square, North Cambridge
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-0 border-top"><a class="btn btn-link d-block w-100" href="../../app/events/event-list.html">All Events<svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-1 fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
                            </svg><!-- <span class="fas fa-chevron-right ms-1 fs--2"></span> Font Awesome fontawesome.com --></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
