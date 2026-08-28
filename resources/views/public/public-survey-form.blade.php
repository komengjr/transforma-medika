<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Form Survey | {{ $event->event_data_tittle }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url($event->event_data_template) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-body: #0b0f19;
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            min-height: 100vh;
            color: var(--text-main);
            overflow-x: hidden;
        }

        .split-container {
            min-height: 100vh;
        }

        /* --- SISI KIRI: GAMBAR HERO GLASS --- */
        .event-sidebar-hero {
            position: relative;
            background-size: cover !important;
            background-position: center !important;
            min-height: 360px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .event-sidebar-hero {
                min-height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                width: 41.666667%;
            }

            .form-right-content {
                margin-left: 41.666667%;
            }
        }

        .event-sidebar-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(11, 15, 25, 0.4) 0%,
                    rgba(11, 15, 25, 0.75) 50%,
                    rgba(11, 15, 25, 0.95) 100%);
            z-index: 1;
        }

        .hero-glow {
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(79, 70, 229, 0.4);
            filter: blur(80px);
            border-radius: 50%;
            z-index: 1;
            top: 10%;
            left: 10%;
        }

        .hero-content-wrapper {
            position: relative;
            z-index: 2;
        }

        .hero-glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 16px;
            padding: 1rem 1.25rem;
            color: #ffffff;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .badge-event-tag {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.72rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .info-pill {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 0.6rem 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #ffffff;
        }

        .info-pill-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* --- SISI KANAN: BACKGROUND EVENT ATMOSPHERE & FORM --- */
        .form-right-content {
            background-color: #f1f5f9;
            background-image:
                radial-gradient(at 10% 20%, rgba(79, 70, 229, 0.08) 0px, transparent 40%),
                radial-gradient(at 90% 80%, rgba(14, 165, 233, 0.08) 0px, transparent 40%),
                radial-gradient(at 50% 50%, rgba(236, 72, 153, 0.05) 0px, transparent 50%),
                radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
            background-size: 100% 100%, 100% 100%, 100% 100%, 20px 20px;
            min-height: 100vh;
        }

        .form-card-container {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.08);
            padding: 1.75rem 2rem;
        }

        @media (max-width: 576px) {
            .form-card-container {
                padding: 1.25rem 1.25rem;
                border-radius: 16px;
            }
        }

        .custom-form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #475569;
            margin-bottom: 0.25rem;
        }

        .form-control-custom,
        .form-select-custom {
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            padding: 0.55rem 0.85rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            background-color: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            outline: none;
        }

        .btn-survey-submit {
            background: var(--primary-color);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
        }

        .btn-survey-submit:hover {
            background: var(--primary-hover);
            color: #ffffff;
        }

        .participant-info-box {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 14px;
            padding: 1rem 1.15rem;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="row g-0 split-container">

            <!-- ================= SISI KIRI: GAMBAR + INFORMASI EVENT MODERN ================= -->
            <div class="col-lg-5 event-sidebar-hero p-4 p-md-5"
                style='background: url("{{ Storage::url($event->event_data_template) }}") no-repeat center center / cover;'>

                <div class="hero-glow"></div>

                <!-- TOP INFORMASI: BADGE & JUDUL -->
                <div class="hero-content-wrapper mb-3">
                    <div class="d-inline-block mb-2">
                        <span class="badge-event-tag">
                            <i class="bi bi-stars text-warning me-1"></i> Official Event
                        </span>
                    </div>

                    <h2 class="fw-extrabold text-white mb-2" style="letter-spacing: -0.6px; line-height: 1.25; font-size: 1.75rem;">
                        {{ $event->event_data_tittle }}
                    </h2>

                    <p class="text-white-50 fs-7 mb-0 d-none d-sm-block" style="line-height: 1.5;">
                        {{ Str::limit(strip_tags($event->event_data_desc), 140) }}
                    </p>
                </div>

                <!-- BOTTOM INFORMASI: DETAIL WAKTU & LOKASI -->
                <div class="hero-content-wrapper mt-auto pt-2">
                    <div class="row g-2 mb-2">
                        <div class="col-12">
                            <div class="info-pill">
                                <div class="info-pill-icon text-warning">
                                    <i class="bi bi-calendar2-week"></i>
                                </div>
                                <div>
                                    <small class="d-block text-white-50 fs-8">Waktu Pelaksanaan</small>
                                    <span class="fw-bold fs-7 text-white">
                                        {{ \Carbon\Carbon::parse($event->event_data_start_date)->translatedFormat('d F Y, H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-pill">
                                <div class="info-pill-icon text-info">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <small class="d-block text-white-50 fs-8">Lokasi Acara</small>
                                    <span class="fw-bold fs-7 text-white">
                                        {{ $event->event_data_venue }}, {{ $event->event_data_city }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-glass-card">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-success fs-6"></i>
                            <span class="fs-8 text-white-50">Kuesioner Respon & Masukan Peserta</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ================= SISI KANAN: FORM SURVEY PESERTA ================= -->
            <div class="col-lg-7 form-right-content p-3 p-md-4 d-flex flex-column justify-content-center">

                <div class="mx-auto style-form-wrapper" style="max-width: 680px; width: 100%;">

                    <!-- CARD UTAMA FORM -->
                    <div class="form-card-container">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <div>
                                <h4 class="fw-bold text-dark m-0" style="letter-spacing: -0.4px;">Form Survey Peserta</h4>
                                <small class="text-muted fs-8">Mohon isi kuesioner berikut untuk evaluasi acara.</small>
                            </div>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fs-8">
                                <i class="bi bi-clipboard-check me-1"></i> Survey Event
                            </span>
                        </div>

                        <!-- INFORMASI PESERTA -->
                        <div class="participant-info-box mb-4">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-person-circle text-primary fs-6"></i>
                                <span class="custom-form-label m-0 text-secondary">Informasi Peserta:</span>
                            </div>
                            <h6 class="fw-bold text-dark m-0">{{ $registration->full_name }}</h6>
                            <div class="small text-muted mt-1">
                                <span><i class="bi bi-envelope me-1"></i>{{ $registration->email }}</span>
                                <span class="mx-2">•</span>
                                <span><i class="bi bi-qr-code me-1"></i>No. Reg: {{ $registration->registration_code }}</span>
                            </div>
                        </div>

                        <form id="surveyForm" action="{{ route('event.survey.submit_answer') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_participant" value="{{ $registration->id_participant }}">

                            @if($surveys->count() > 0)
                            @foreach($surveys as $index => $s)
                            <div class="mb-4">
                                <label class="custom-form-label d-block mb-1 text-dark fs-7 fw-bold" style="text-transform: none; letter-spacing: normal;">
                                    {{ $index + 1 }}. {{ $s->question }} <span class="text-danger">*</span>
                                </label>

                                @if($s->type == 'rating')
                                <select name="answers[{{ $s->id_event_survey }}]" class="form-select form-select-custom" required>
                                    <option value="" selected>-- Pilih Rating --</option>
                                    <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                    <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                    <option value="3">⭐⭐⭐ (Cukup)</option>
                                    <option value="2">⭐⭐ (Kurang)</option>
                                    <option value="1">⭐ (Sangat Kurang)</option>
                                </select>
                                @else
                                <textarea name="answers[{{ $s->id_event_survey }}]" class="form-control form-control-custom" rows="3" placeholder="Tuliskan jawaban Anda di sini..." required></textarea>
                                @endif
                            </div>
                            @endforeach

                            <button class="btn btn-survey-submit w-100 mt-2" type="submit" id="btnSubmit">
                                <span id="btnText">
                                    <i class="bi bi-send me-2"></i> Kirim Jawaban Survey
                                </span>
                                <span id="btnSpinner" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Mengirim Jawaban...
                                </span>
                            </button>
                            @else
                            <div class="alert alert-warning border-0 fs-8 m-0 rounded-3 py-3 px-3 text-center">
                                <i class="bi bi-exclamation-triangle me-1"></i> Belum ada pertanyaan survey yang tersedia untuk event ini.
                            </div>
                            @endif
                        </form>
                    </div>
                    <!-- END FORM CARD CONTAINER -->

                </div>

            </div>
        </div>
    </div>

    <!-- JS LOGIC NOTIFIKASI SWEETALERT & SPINNER -->
    <script>
        $(document).ready(function() {

            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonText: 'Saya Mengerti',
                confirmButtonColor: '#4f46e5'
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#ef4444'
            });
            @endif

            $('#surveyForm').on('submit', function() {
                const $btn = $('#btnSubmit');
                $btn.prop('disabled', true);
                $('#btnText').addClass('d-none');
                $('#btnSpinner').removeClass('d-none');
            });

        });
    </script>
</body>

</html>
