@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<script src="{{ ENV('MIDTRANS_JS_LINK') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

<style>
    /* Styling Custom Elemen WhatsApp & Status Card */
    .wa-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .wa-card:hover {
        transform: translateY(-2px);
    }

    .gradient-header-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    .gradient-header-success {
        background: linear-gradient(135deg, #198754 0%, #0f5132 100%);
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    .btn-gradient-success {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        border: none;
        color: #fff;
        transition: opacity 0.2s ease, transform 0.1s ease;
    }

    .btn-gradient-success:hover:not(:disabled) {
        opacity: 0.95;
        color: #fff;
        transform: scale(1.01);
    }

    .status-badge-custom {
        font-size: 0.85rem;
        padding: 6px 14px;
        border-radius: 30px;
    }

    .form-control:focus {
        border-color: #25D366;
        box-shadow: 0 0 0 0.25rem rgba(37, 211, 102, 0.25);
    }
</style>
@endsection

@section('content')

<!-- Notifikasi Flash Message Laravel -->
@if(session('status'))
<div class="alert alert-info alert-dismissible fade show mb-3 border-0 shadow-sm rounded-3" role="alert">
    <i class="bi bi-info-circle-fill me-2"></i>{{ session('status') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm rounded-3" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- HEADER PROFIL USER -->
<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <h5 class="mb-2">{{ Auth::user()->fullname }} (<a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>)</h5>
                <a class="btn btn-falcon-default btn-sm" href="#!"><span class="fas fa-plus fs--2 me-1"></span>Add note</a>
                <button class="btn btn-falcon-default btn-sm dropdown-toggle ms-2 dropdown-caret-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" href="#">Report</a>
                    <a class="dropdown-item" href="#">Archive</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#">Delete user</a>
                </div>
            </div>
            <div class="col-auto d-none d-sm-block">
                <h6 class="text-uppercase text-600">Customer<span class="fas fa-user ms-2"></span></h6>
            </div>
        </div>
    </div>
    <div class="card-body border-top">
        <div class="d-flex"><span class="fab fa-whatsapp text-success me-2" data-fa-transform="down-5"></span>
            <div class="flex-1">
                <p class="mb-0">Number Connected</p>
                <p class="fs--1 mb-0 text-600">{{ date('d-m-Y H:i:s') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- SECTION STATUS DEVICE (QR CODE) & FORM KIRIM WHATSAPP -->
<div class="row g-3 mb-3">
    <!-- KARTU STATUS DEVICE & QR CODE -->
    <div class="col-lg-5 col-md-6">
        <div class="card wa-card shadow-lg h-100">
            <div class="card-header gradient-header-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-mobile-alt"></i> Status Device
                </h5>
                <span class="badge bg-white text-primary fw-semibold px-3 py-2 rounded-pill shadow-sm">
                    User ID: {{ Auth::id() }}
                </span>
            </div>
            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">

                <!-- Status Badge -->
                <div id="status-container" class="mb-3">
                    <span class="text-muted small fw-bold me-2">Status Server:</span>
                    <span class="badge bg-secondary status-badge-custom shadow-sm" id="status-badge">Checking...</span>
                </div>

                <!-- Loading Spinner -->
                <div id="loading-spinner" class="spinner-border text-primary my-3" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <p id="loading-text" class="text-muted small fw-semibold">Menghubungkan ke server WhatsApp...</p>

                <!-- QR Code Container -->
                <div id="qr-container" class="my-3 d-none">
                    <p class="text-dark small fw-bold mb-3">Scan QR Code ini menggunakan WhatsApp di HP Anda:</p>
                    <div class="p-3 bg-light rounded-4 border d-inline-block shadow-sm">
                        <img id="qr-image" src="" alt="QR Code" class="img-fluid rounded" style="max-width: 220px;">
                    </div>
                </div>

                <!-- Connected Alert -->
                <div id="connected-container" class="alert alert-success border-0 shadow-sm d-none w-100 mb-0 rounded-4 py-3">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-check-circle fs-4 text-success"></i>
                        <div class="text-start">
                            <strong class="d-block text-success">Terkoneksi Sempurna!</strong>
                            <small class="text-muted">Device Anda siap mengirim pesan.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- KARTU FORM KIRIM PESAN & ATTACHMENT -->
    <div class="col-lg-7 col-md-6">
        <div class="card wa-card shadow-lg h-100">
            <div class="card-header gradient-header-success text-white py-3 px-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="fab fa-whatsapp"></i> Kirim Pesan WhatsApp
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('whatsapp.send') }}" method="POST" enctype="multipart/form-data" id="wa-form">
                    @csrf

                    <!-- Input Nomor Telepon -->
                    <div class="mb-3">
                        <label for="number" class="form-label fw-bold text-dark">Nomor WhatsApp Tujuan</label>
                        <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-success text-white fw-bold border-0">+62 / 08</span>
                            <input type="text"
                                name="number"
                                id="number"
                                class="form-control wa-field py-2"
                                placeholder="Contoh: 081234567890"
                                required
                                disabled>
                        </div>
                    </div>

                    <!-- Input Isi Pesan -->
                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold text-dark">Isi Pesan / Caption</label>
                        <textarea name="message"
                            id="message"
                            rows="4"
                            class="form-control wa-field shadow-sm py-2"
                            placeholder="Tulis pesan Anda di sini..."
                            disabled></textarea>
                    </div>

                    <!-- Input File Attachment -->
                    <div class="mb-4">
                        <label for="attachment" class="form-label fw-bold text-dark">Lampiran File (Opsional)</label>
                        <input type="file"
                            name="attachment"
                            id="attachment"
                            class="form-control wa-field shadow-sm"
                            disabled>
                        <small class="text-muted mt-1 d-block" style="font-size: 0.8rem;">
                            <i class="fas fa-paperclip me-1"></i>Format: Gambar (JPG, PNG), PDF, DOCX, XLSX. Maksimal 10 MB.
                        </small>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" id="btn-submit" class="btn btn-gradient-success w-100 py-3 fw-bold rounded-3 shadow-sm fs-6" disabled>
                        <i class="fas fa-paper-plane me-2"></i> Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- KARTU STATUS AKUN & BILLING INFORMATION -->
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Status Akun</h5>
            </div>
            <div class="col-auto"><a class="btn btn-falcon-default btn-sm" href="#!"><span class="fas fa-pencil-alt fs--2 me-1"></span>Update details</a></div>
        </div>
    </div>
    <div class="card-body bg-light border-top">
        <div class="row">
            <div class="col-lg col-xxl-5">
                <h6 class="fw-semi-bold ls mb-3 text-uppercase">Account Information</h6>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">ID</p>
                    </div>
                    <div class="col">{{ Auth::user()->userid }}</div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">Created</p>
                    </div>
                    <div class="col">{{ Auth::user()->created_at }}</div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">Email</p>
                    </div>
                    <div class="col"><a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">No Handphone</p>
                    </div>
                    <div class="col">
                        <p class="fst-italic text-400 mb-1">{{ Auth::user()->number_handphone }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg col-xxl-5 mt-4 mt-lg-0 offset-xxl-1">
                <h6 class="fw-semi-bold ls mb-3 text-uppercase">Billing Information</h6>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-1">Phone number</p>
                    </div>
                    <div class="col"><a href="tel:+12025550110">Random</a></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-4">
                        <p class="fw-semi-bold mb-0">Total Kuota</p>
                    </div>
                    <div class="col">
                        <p class="fw-semi-bold mb-0">7C23435</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer border-top text-end">
        <a class="btn btn-primary btn-sm" href="#!" id="button-add-kuota-whatsapp" data-bs-toggle="modal" data-bs-target="#modal-brodcast"><span class="fas fa-dollar-sign fs--2 me-1"></span>Beli Kuota</a>
    </div>
</div>

<!-- TABEL LOGS -->
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Logs</h5>
    </div>
    <div class="card-body border-top p-0">
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>Tiket Pesan</th>
                    <th>Nama Kontak</th>
                    <th>Nomor Kontak</th>
                    <th>Gambar</th>
                    <th>PDF</th>
                    <th>Isi Pesan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->v_log_whatsapp_code }}</td>
                    <td>{{ $datas->v_log_whatsapp_name }}</td>
                    <td>{{ $datas->v_log_whatsapp_number }}</td>
                    <td>
                        @if ($datas->v_log_whatsapp_picture == '0')
                        <span class="badge bg-danger">No</span>
                        @else
                        <span class="badge bg-primary">Yes</span>
                        @endif
                    </td>
                    <td>
                        @if ($datas->v_log_whatsapp_file == 'N')
                        <span class="badge bg-danger">No</span>
                        @else
                        <span class="badge bg-primary">Yes</span>
                        @endif
                    </td>
                    <td>{{ $datas->v_log_whatsapp_text }}</td>
                    <td>
                        @if ($datas->v_log_whatsapp_status == 0)
                        <span class="badge bg-danger">Belum Terkirim</span>
                        @elseif($datas->v_log_whatsapp_status == 1)
                        <span class="badge bg-primary">Terkirim</span>
                        @elseif($datas->v_log_whatsapp_status == 2)
                        <span class="badge bg-warning">No Tidak Terdaftar</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Broadcast -->
<div class="modal fade" id="modal-brodcast" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-brodcast"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

<script>
    // Polling Fungsi Cek Status WhatsApp
    function checkWAStatus() {
        fetch("{{ route('whatsapp.status') }}")
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('status-badge');
                const qrContainer = document.getElementById('qr-container');
                const connectedContainer = document.getElementById('connected-container');
                const qrImage = document.getElementById('qr-image');
                const loadingSpinner = document.getElementById('loading-spinner');
                const loadingText = document.getElementById('loading-text');

                const waFields = document.querySelectorAll('.wa-field');
                const btnSubmit = document.getElementById('btn-submit');

                badge.innerText = data.status;

                if (data.status === 'CONNECTED') {
                    badge.className = 'badge bg-success status-badge-custom shadow-sm';
                    loadingSpinner.classList.add('d-none');
                    loadingText.classList.add('d-none');
                    qrContainer.classList.add('d-none');
                    connectedContainer.classList.remove('d-none');

                    waFields.forEach(field => field.removeAttribute('disabled'));
                    btnSubmit.removeAttribute('disabled');

                } else if (data.qr) {
                    badge.innerText = 'DISCONNECTED';
                    badge.className = 'badge bg-warning text-dark status-badge-custom shadow-sm';
                    loadingSpinner.classList.add('d-none');
                    loadingText.classList.add('d-none');
                    qrImage.src = data.qr;
                    qrContainer.classList.remove('d-none');
                    connectedContainer.classList.add('d-none');

                    waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                    btnSubmit.setAttribute('disabled', 'disabled');

                } else {
                    badge.innerText = data.status || 'INITIALIZING';
                    badge.className = 'badge bg-info text-dark status-badge-custom shadow-sm';
                    loadingSpinner.classList.remove('d-none');
                    loadingText.classList.remove('d-none');
                    loadingText.innerText = 'Menyiapkan browser Puppeteer & QR Code...';
                    qrContainer.classList.add('d-none');
                    connectedContainer.classList.add('d-none');

                    waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                    btnSubmit.setAttribute('disabled', 'disabled');
                }
            })
            .catch(err => {
                const badge = document.getElementById('status-badge');
                const loadingSpinner = document.getElementById('loading-spinner');
                const loadingText = document.getElementById('loading-text');
                const waFields = document.querySelectorAll('.wa-field');
                const btnSubmit = document.getElementById('btn-submit');

                badge.innerText = 'OFFLINE';
                badge.className = 'badge bg-danger status-badge-custom shadow-sm';
                loadingSpinner.classList.add('d-none');
                loadingText.classList.remove('d-none');
                loadingText.innerText = 'Node.js Server Offline / Tidak Merespon';

                waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                btnSubmit.setAttribute('disabled', 'disabled');
            });
    }

    // Jalankan pemeriksaan status saat halaman dimuat & polling setiap 3 detik
    checkWAStatus();
    setInterval(checkWAStatus, 3000);
</script>

<script>
    // AJAX Pembelian Kuota & Midtrans Payment
    $(document).on("click", "#button-add-kuota-whatsapp", function(e) {
        e.preventDefault();
        $('#menu-brodcast').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_brodcast_configure_whatsapp_buy_kuota') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 0
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-brodcast').html(data);
        }).fail(function() {
            $('#menu-brodcast').html('eror');
        });
    });

    $(document).on("click", "#pay-button-force", function(e) {
        e.preventDefault();
        $('#menu-payment-force').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_brodcast_configure_whatsapp_token_payment') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 0
            },
            dataType: 'html',
        }).done(function(data) {
            snap.pay(data, {
                onSuccess: function(result) {
                    alert("payment success!");
                    $.ajax({
                        url: "{{ route('master_brodcast_configure_whatsapp_confrim_payment') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                        },
                        dataType: 'html',
                    }).done(function(data) {
                        location.reload();
                    })
                },
                onPending: function(result) {
                    alert("wating your payment!");
                    console.log(result);
                    location.reload();
                },
                onError: function(result) {
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    alert('you closed the popup without finishing the payment');
                    location.reload();
                }
            });
        }).fail(function() {
            $('#menu-payment-force').html('eror');
        });
    });
</script>
@endsection
