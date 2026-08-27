<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Survey - {{ $event->event_data_tittle }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-5">
    <div class="container" style="max-width: 650px;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-dark text-white p-4 rounded-top-4">
                <h4 class="fw-bold mb-1">Form Survey Peserta</h4>
                <p class="mb-0 text-white-50">{{ $event->event_data_tittle }}</p>
            </div>
            <div class="card-body p-4">

                @if(session('success'))
                <div class="alert alert-success rounded-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
                @endif

                <!-- Informational Box Peserta -->
                <div class="bg-light p-3 rounded-3 border mb-4">
                    <small class="text-muted d-block">Informasi Peserta:</small>
                    <div class="fw-bold text-dark fs-5">{{ $registration->full_name }}</div>
                    <div class="small text-muted">
                        <span>Email: {{ $registration->email }}</span> |
                        <span>No. Reg: {{ $registration->registration_code }}</span>
                    </div>
                </div>

                <form action="{{ route('event.survey.submit_answer') }}" method="POST">
                    @csrf
                    <!-- Hidden ID Participant -->
                    <input type="hidden" name="id_participant" value="{{ $registration->id_participant }}">

                    @if($surveys->count() > 0)
                    @foreach($surveys as $index => $s)
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ $index + 1 }}. {{ $s->question }}</label>

                        @if($s->type == 'rating')
                        <select name="answers[{{ $s->id_event_survey }}]" class="form-select" required>
                            <option value="">-- Pilih Rating --</option>
                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                            <option value="4">⭐⭐⭐⭐ (Puas)</option>
                            <option value="3">⭐⭐⭐ (Cukup)</option>
                            <option value="2">⭐⭐ (Kurang)</option>
                            <option value="1">⭐ (Sangat Kurang)</option>
                        </select>
                        @else
                        <textarea name="answers[{{ $s->id_event_survey }}]" class="form-control" rows="3" placeholder="Tuliskan jawaban Anda di sini..." required></textarea>
                        @endif
                    </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold">Kirim Jawaban</button>
                    @else
                    <div class="alert alert-warning text-center">Belum ada pertanyaan survey yang tersedia untuk event ini.</div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</body>

</html>
