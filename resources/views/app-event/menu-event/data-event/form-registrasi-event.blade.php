<style>
    /* Premium Modal Event Styling */
    .modal-event-wrapper {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color: #f8fafc;
    }

    .modal-event-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 1.25rem 1.75rem;
        position: relative;
    }

    .event-main-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .event-thumb-box {
        width: 72px;
        height: 72px;
        border-radius: 16px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .event-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-event-date {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Sub Event Section */
    .sub-event-wrapper {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 1.25rem;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.03);
    }

    .sub-event-card-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        cursor: pointer;
    }

    .sub-event-card-item:hover,
    .sub-event-card-item.active {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 8px 20px -4px rgba(59, 130, 246, 0.15);
        transform: translateY(-2px);
    }

    .sub-event-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sub-event-icon-box img {
        width: 22px;
        height: 22px;
    }

    .btn-register-action {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        font-weight: 700;
        border-radius: 50px;
        padding: 0.55rem 1.75rem;
        border: none;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.25s ease;
    }

    .btn-register-action:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        color: #ffffff;
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
        transform: translateY(-1px);
    }

    .btn-share-action {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        font-weight: 600;
        border-radius: 50px;
        padding: 0.55rem 1.25rem;
        transition: all 0.2s ease;
    }

    .btn-share-action:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }

    .class-badge {
        background: #e2e8f0;
        color: #334155;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 6px;
    }
</style>

<div class="modal-body p-0 modal-event-wrapper">
    <!-- Modal Header -->
    <div class="modal-event-header d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-0 text-white fw-bold" id="staticBackdropLabel">Form Registrasi Event</h4>
            <span class="text-white-50 fs--1">
                Powered by <a class="text-info fw-semibold text-decoration-none" href="#!">{{env('APP_NAME')}}</a>
            </span>
        </div>

    </div>

    <div class="p-3 p-md-3">
        <!-- Hero Event Card -->
        <div class="event-main-card mb-3">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="event-thumb-box">
                            <img src="{{ Storage::url($data->event_data_template) }}" alt="Event Banner">
                        </div>
                        <div>
                            <div class="badge-event-date mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-calendar-range" viewBox="0 0 16 16">
                                    <path d="M9 7a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V7zM1 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v2H1V2zm0 3h14v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V5z" />
                                </svg>
                                {{ $data->event_data_start_date }} – {{ $data->event_data_end_date }}
                            </div>
                            <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.3px;">{{ $data->event_data_tittle }}</h4>
                            <p class="text-secondary mb-0 small">
                                Organized by <a href="#!" class="fw-bold text-primary text-decoration-none">{{ $data->event_data_venue }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end d-flex align-items-center justify-content-lg-end gap-2">
                    <button class="btn btn-share-action btn-sm d-inline-flex align-items-center gap-1" type="button">
                        <svg class="svg-inline--fa fa-share-alt" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="share-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="12">
                            <path fill="currentColor" d="M352 320c-22.608 0-43.387 7.819-59.79 20.895l-102.486-64.054a96.551 96.551 0 0 0 0-41.683l102.486-64.054C308.613 184.181 329.392 192 352 192c53.019 0 96-42.981 96-96S405.019 0 352 0s-96 42.981-96 96c0 7.158.79 14.13 2.276 20.841L155.79 180.895C139.387 167.819 118.608 160 96 160c-53.019 0-96 42.981-96 96s42.981 96 96 96c22.608 0 43.387-7.819 59.79-20.895l102.486 64.054A96.301 96.301 0 0 0 256 416c0 53.019 42.981 96 96 96s96-42.981 96-96-42.981-96-96-96z"></path>
                        </svg>
                        Share
                    </button>
                    <button class="btn btn-register-action btn-sm" type="button" onclick='window.open("{{ route("event_registrasi",["id"=>$data->event_data_code,"code"=>123]) }}", "_blank");'>
                        Register
                    </button>
                </div>
            </div>
        </div>

        <!-- Section Content Grid -->
        <div class="row g-3">
            <!-- Sidebar Sub Events -->
            <div class="col-lg-4 col-xl-3">
                <div class="sub-event-wrapper">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold text-dark m-0">Sub Event</h6>
                        <span class="badge bg-primary rounded-pill px-2 py-1 fs--2">{{ count($event_sub) }} Total</span>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @foreach ($event_sub as $event)
                        <div class="sub-event-card-item button-detail-sub-event"
                            data-code="{{ $event->event_data_sub_code }}"
                            data-sub-id="{{ $event->id_event_data_sub }}">
                            <div class="d-flex align-items-start gap-2">
                                <div class="sub-event-icon-box">
                                    <img src="{{ asset('img/svg/monitor-svgrepo-com.svg') }}" alt="Sub Event Icon">
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="fw-bold fs-0 mb-1">
                                        <a href="javascript:void(0)" class="text-dark text-decoration-none">
                                            {{ $event->event_data_sub_name }}
                                        </a>
                                    </h6>

                                    <p class="small text-muted mb-1">
                                        <span class="text-secondary fw-semibold">{{ $event->event_data_sub_start }} - {{ $event->event_data_sub_end }}</span>
                                    </p>

                                    @php
                                    $sub = DB::table('event_data_sub_class')->where('event_data_sub_code',$event->event_data_sub_code)->get();
                                    @endphp

                                    <div class="d-flex flex-wrap gap-1 my-1">
                                        @foreach ($sub as $subs)
                                        <span class="class-badge">{{ $subs->event_data_sub_class_name }}</span>
                                        @endforeach
                                    </div>

                                    <div class="small text-muted mt-2 pt-1 border-top border-dashed">
                                        📍 Cambridge Boat Club, Cambridge
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content Display -->
            <div class="col-lg-8 col-xl-9" id="menu-detail-seub-event">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center text-muted">
                    <i class="bi bi-hand-index-thumb fs-1 mb-2"></i>
                    <p class="mb-0">Silahkan klik salah satu Sub Event di samping untuk melihat daftar peserta.</p>
                </div>
            </div>
        </div>

        <!-- Target Container Extra Data Event -->
        <div id="show-data-event-all" class="mt-3"></div>
    </div>
</div>

<div class="modal-footer px-4 py-3 bg-white border-top">
</div>

<!-- JavaScript AJAX untuk mengambil data peserta -->
<script>
    $(document).ready(function() {
        $('.button-detail-sub-event').on('click', function(e) {
            e.preventDefault();

            // Atur class active pada card yang diklik
            $('.sub-event-card-item').removeClass('active');
            $(this).addClass('active');

            let subEventId = $(this).data('sub-id');
            let subEventCode = $(this).data('code');

            // Tampilkan indikator loading
            $('#menu-detail-seub-event').html(`
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                <div class="spinner-border text-primary mx-auto mb-2" role="status"></div>
                <p class="text-muted mb-0">Memuat data peserta...</p>
            </div>
        `);

            // Request AJAX ke route Laravel
            $.ajax({
                url: "{{ route('menu_event_data_form_registrasi_event_detail_sub_event_data_peserta') }}",
                type: "GET",
                data: {
                    sub_event_id: subEventId,
                    sub_event_code: subEventCode
                },
                success: function(response) {
                    $('#menu-detail-seub-event').html(response);
                },
                error: function(xhr) {
                    $('#menu-detail-seub-event').html(`
                    <div class="alert alert-danger rounded-3 m-0">
                        Gagal memuat data peserta. Silahkan coba lagi.
                    </div>
                `);
                }
            });
        });
    });
</script>
