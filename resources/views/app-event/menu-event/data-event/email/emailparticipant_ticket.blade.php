<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pendaftaran Event</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f6f9;
            padding: 30px 0;
        }

        .main-card {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e1e8ed;
        }

        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
        }

        .header.pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
            color: #334155;
        }

        .greeting {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* Ticket Box untuk Lunas */
        .ticket-box {
            background-color: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }

        .ticket-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .booking-code {
            font-size: 24px;
            font-weight: 800;
            color: #4f46e5;
            letter-spacing: 2px;
            font-family: 'Courier New', Courier, monospace;
            margin: 5px 0 15px 0;
            word-break: break-all;
        }

        .qr-code {
            margin: 15px 0;
        }

        .qr-code img {
            border: 4px solid #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Payment Box untuk Pending */
        .payment-box {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
        }

        .payment-title {
            font-size: 14px;
            font-weight: 700;
            color: #b45309;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
        }

        /* Box Nominal Tagihan */
        .amount-box {
            background-color: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            margin-bottom: 15px;
        }

        .amount-title {
            font-size: 12px;
            color: #92400e;
            font-weight: 600;
            text-transform: uppercase;
        }

        .amount-value {
            font-size: 24px;
            font-weight: 800;
            color: #b45309;
            margin-top: 2px;
        }

        .bank-card {
            background-color: #ffffff;
            border: 1px dashed #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
            text-align: center;
        }

        .bank-name {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
        }

        .account-number {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: 1.5px;
            margin: 5px 0;
            font-family: 'Courier New', Courier, monospace;
        }

        .account-holder {
            font-size: 13px;
            color: #475569;
        }

        .bank-notes {
            font-size: 11px;
            color: #d97706;
            margin-top: 5px;
            font-style: italic;
        }

        .contact-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            font-size: 13px;
            color: #166534;
        }

        .contact-btn {
            display: inline-block;
            background-color: #22c55e;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
        }

        /* Survey Box & Button Style */
        .survey-box {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0 10px 0;
            text-align: center;
        }

        .survey-btn {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 10px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        /* Details Table */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .details-table td.label {
            color: #64748b;
            width: 40%;
            font-weight: 500;
        }

        .details-table td.value {
            color: #0f172a;
            font-weight: 600;
            text-align: right;
        }

        .footer {
            background-color: #f8fafc;
            padding: 25px 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }

        .brand-support {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed #cbd5e1;
        }

        .brand-support p {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .brand-logo {
            max-height: 40px;
            width: auto;
        }
    </style>
</head>

<body>
    @php
    $status = strtolower($registration->payment_status ?? 'pending');

    // Handling Gelar
    $frontTitle = !empty($registration->front_title) ? trim($registration->front_title) . ' ' : '';
    $backTitle = !empty($registration->back_title) ? ', ' . trim($registration->back_title) : '';
    $fullNameFormatted = $frontTitle . ($registration->full_name ?? '-') . $backTitle;

    // Handling Nominal / Biaya
    $amountToPay = $registration->event_data_sub_class_price ?? $registration->total_price ?? $registration->price ?? 0;
    $formattedAmount = 'Rp ' . number_format($amountToPay, 0, ',', '.');

    // Dynamic Survey URL & Code
    $eventCode = $registration->event_data_code ?? '';
    $registrationCode = $registration->registration_code ?? '-';
    $surveyUrl = url("event/survey/form/{$eventCode}/{$registrationCode}");

    // Query Data Rekening dan Contact Person langsung via DB Facade di Blade jika Pending
    $rekeningList = collect();
    $contactList = collect();

    if ($status == 'pending' && !empty($eventCode)) {
    $rekeningList = \Illuminate\Support\Facades\DB::table('event_data_rekening')
    ->where('event_data_code', $eventCode)
    ->where('is_active', true)
    ->get();

    $contactList = \Illuminate\Support\Facades\DB::table('event_data_contact')
    ->where('event_data_code', $eventCode)
    ->where('is_active', true)
    ->orderBy('sort_order', 'asc')
    ->get();
    }
    @endphp

    <div class="wrapper">
        <table class="main-card" role="presentation">
            <!-- Header -->
            <tr>
                <td class="header {{ $status == 'pending' ? 'pending' : '' }}">
                    @if($status == 'pending')
                    <h1>Instruksi Pembayaran</h1>
                    <p>Selesaikan pembayaran untuk mengamankan tiket Anda</p>
                    @else
                    <h1>Tiket Registrasi Event</h1>
                    <p>Konfirmasi pendaftaran resmi Anda</p>
                    @endif
                </td>
            </tr>

            <!-- Body Content -->
            <tr>
                <td class="content">
                    <p class="greeting">
                        Halo <strong>{{ $fullNameFormatted }}</strong>,<br>
                        @if($status == 'pending')
                        Pendaftaran Anda telah kami terima. Silakan lakukan pembayaran terlebih dahulu agar pendaftaran Anda terkonfirmasi dan tiket/kode booking dapat diterbitkan.
                        @else
                        Pendaftaran Anda telah berhasil terkonfirmasi dan LUNAS. Simpan email ini sebagai bukti registrasi yang sah.
                        @endif
                    </p>

                    <!-- PENDING STATE: Instruksi Pembayaran & Tujuan Transfer -->
                    @if($status == 'pending')
                    <div class="payment-box">
                        <div class="payment-title">Tujuan Transfer Pembayaran</div>

                        <!-- Highlight Nominal Pembayaran -->
                        <div class="amount-box">
                            <div class="amount-title">Total Nominal yang Harus Dibayar</div>
                            <div class="amount-value">{{ $formattedAmount }}</div>
                        </div>

                        <p style="font-size: 13px; color: #78350f; margin: 0 0 10px 0; text-align: center;">
                            Silakan transfer sesuai nominal di atas ke salah satu rekening berikut:
                        </p>

                        @forelse($rekeningList as $rek)
                        <div class="bank-card" style="margin-top: 8px;">
                            <div class="bank-name">{{ $rek->bank_name }} @if($rek->bank_branch) ({{ $rek->bank_branch }}) @endif</div>
                            <div class="account-number">{{ $rek->account_number }}</div>
                            <div class="account-holder">a.n. {{ $rek->account_holder }}</div>
                            @if(!empty($rek->notes))
                            <div class="bank-notes">*{{ $rek->notes }}</div>
                            @endif
                        </div>
                        @empty
                        <div class="bank-card">
                            <div class="bank-name">INFORMASI REKENING</div>
                            <div class="account-holder">Silakan hubungi panitia untuk detail pembayaran.</div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Kontak Bantuan Konfirmasi Pembayaran -->
                    @if($contactList->count() > 0)
                    <div class="contact-box">
                        <strong style="display: block; text-align: center; margin-bottom: 8px;">Sudah Melakukan Pembayaran?</strong>
                        <p style="font-size: 12px; margin: 0 0 12px 0; text-align: center;">
                            Kirimkan bukti transfer Anda ke salah satu Panitia melalui WhatsApp di bawah ini:
                        </p>

                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            @foreach($contactList as $cp)
                            @php
                            $phone = preg_replace('/[^0-9]/', '', $cp->contact_number);
                            if (str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                            }
                            $waMsg = rawurlencode("Halo " . $cp->contact_name . ", saya ingin konfirmasi pembayaran event atas nama *" . $fullNameFormatted . "* sebesar " . $formattedAmount . ".");
                            @endphp
                            <tr>
                                <td style="padding: 6px 0; font-size: 12px; border-bottom: 1px dashed #bbf7d0;">
                                    <strong>{{ $cp->contact_name }}</strong>
                                    @if($cp->contact_role)
                                    <span style="color: #4b5563; font-size: 11px;">({{ $cp->contact_role }})</span>
                                    @endif
                                </td>
                                <td style="padding: 6px 0; text-align: right; border-bottom: 1px dashed #bbf7d0;">
                                    <a href="https://wa.me/{{ $phone }}?text={{ $waMsg }}" class="contact-btn" target="_blank">
                                        💬 WhatsApp
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif

                    <!-- PAID / LUNAS STATE: Tampilkan Kode Booking & QR Code -->
                    @else
                    <div class="ticket-box">
                        <div class="ticket-title">Kode Booking / Token</div>
                        <div class="booking-code">{{ $registration->qr_code_token ?? '-' }}</div>

                        @if(!empty($registration->qr_code_token))
                        <div class="qr-code">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($registration->qr_code_token) }}" alt="QR Code Ticket" width="150" height="150">
                        </div>
                        @endif

                        <p style="font-size: 12px; color: #64748b; margin-top: 10px;">Tunjukkan QR Code ini saat proses check-in di lokasi event.</p>
                    </div>

                    <!-- Button Isi Survey Event (Hanya Tampil Jika Lunas) -->
                    <div class="survey-box">
                        <strong style="color: #1e40af; font-size: 14px;">Bantu Kami Meningkatkan Layanan</strong>
                        <p style="font-size: 12px; color: #475569; margin: 5px 0 10px 0;">Mohon luangkan waktu sejenak untuk mengisi survey singkat acara kami.</p>
                        <a href="{{ $surveyUrl }}" class="survey-btn" target="_blank">
                            Isi Survey Event
                        </a>
                    </div>
                    @endif

                    <!-- Detail Pendaftaran -->
                    <table class="details-table">
                        <tr>
                            <td class="label">Nama Event</td>
                            <td class="value">{{ $registration->event_name ?? $registration->event_title ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Sub Event</td>
                            <td class="value">{{ $registration->sub_event_name ?? $registration->sub_event_title ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama Peserta</td>
                            <td class="value">{{ $fullNameFormatted }}</td>
                        </tr>
                        <tr>
                            <td class="label">Instansi / Lembaga</td>
                            <td class="value">{{ $registration->institution ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Email</td>
                            <td class="value">{{ $registration->email }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nomor Telepon</td>
                            <td class="value">{{ $registration->phone_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Kategori / Kelas</td>
                            <td class="value">{{ $registration->event_data_sub_class_name ?? 'Reguler' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Total Biaya</td>
                            <td class="value" style="color: #0f172a; font-weight: 700;">{{ $formattedAmount }}</td>
                        </tr>
                        <tr>
                            <td class="label">Status Pembayaran</td>
                            <td class="value" style="color: {{ $status == 'pending' ? '#d97706' : '#16a34a' }}; text-transform: capitalize;">
                                {{ $status == 'pending' ? 'Belum Bayar (Pending)' : 'Lunas' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Footer & Support Logo -->
            <tr>
                <td class="footer">
                    <p style="margin: 0 0 5px 0;">Pesan ini dikirim secara otomatis oleh sistem. Harap tidak membalas email ini.</p>
                    <p style="margin: 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>

                    <!-- Branding Support Pramita -->
                    <div class="brand-support">
                        <p>Supported by</p>
                        <img src="{{ asset('img/pramita.png') }}" alt="Pramita Lab" class="brand-logo">
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
