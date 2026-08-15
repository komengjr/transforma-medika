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

        .contact-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #166534;
        }

        .contact-btn {
            display: inline-block;
            background-color: #22c55e;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 10px;
            font-size: 13px;
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
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>

<body>
    @php
    $status = strtolower($registration->payment_status ?? 'pending');

    // Handling Gelar Depan & Belakang
    $frontTitle = !empty($registration->front_title) ? trim($registration->front_title) . ' ' : '';
    $backTitle = !empty($registration->back_title) ? ', ' . trim($registration->back_title) : '';
    $fullNameFormatted = $frontTitle . ($registration->full_name ?? '-') . $backTitle;

    // Format Nomor HP WhatsApp Admin (Ganti 08xx jadi 628xx)
    $adminPhone = config('app.admin_whatsapp', '081234567890');
    $adminPhoneFormatted = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $adminPhone));
    $waMessage = rawurlencode("Halo Admin, saya ingin konfirmasi pembayaran atas nama *" . $fullNameFormatted . "*.");
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
                        <p style="font-size: 13px; color: #78350f; margin: 0 0 10px 0; text-align: center;">
                            Silakan transfer sesuai nominal biaya pendaftaran ke rekening berikut:
                        </p>

                        <!-- Detail Bank (Sesuaikan/Dinamis) -->
                        <div class="bank-card">
                            <div class="bank-name">BANK MANDIRI</div>
                            <div class="account-number">123-00-0987654-3</div>
                            <div class="account-holder">a.n. Panitia Penyelenggara Event</div>
                        </div>

                        <!-- Opsi Bank 2 / BCA (Opsional) -->
                        <div class="bank-card" style="margin-top: 8px;">
                            <div class="bank-name">BANK BCA</div>
                            <div class="account-number">883-098-1234</div>
                            <div class="account-holder">a.n. Panitia Penyelenggara Event</div>
                        </div>
                    </div>

                    <!-- Kontak Bantuan Konfirmasi -->
                    <div class="contact-box">
                        <strong>Sudah Melakukan Pembayaran?</strong><br>
                        Kirimkan bukti transfer/pembayaran Anda ke Panitia melalui WhatsApp di bawah ini untuk verifikasi:
                        <br>
                        <a href="https://wa.me/{{ $adminPhoneFormatted }}?text={{ $waMessage }}" class="contact-btn" target="_blank">
                            Hubungi via WhatsApp
                        </a>
                    </div>

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
                    @endif

                    <!-- Detail Pendaftaran -->
                    <table class="details-table">
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
                            <td class="label">Status Pembayaran</td>
                            <td class="value" style="color: {{ $status == 'pending' ? '#d97706' : '#16a34a' }}; text-transform: capitalize;">
                                {{ $status == 'pending' ? 'Belum Bayar (Pending)' : 'Lunas' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p>Pesan ini dikirim secara otomatis oleh sistem. Harap tidak membalas email ini.</p>
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
