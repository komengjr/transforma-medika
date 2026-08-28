<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Keikutsertaan Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h2 {
            color: #0284c7;
            margin: 0;
        }

        .content {
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0284c7;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888888;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>E-Sertifikat Penghargaan</h2>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $participant->full_name }}</strong>,</p>

            <p>Mewakili seluruh panitia pelaksana, kami mengucapkan terima kasih atas partisipasi aktif Anda dalam kegiatan:</p>
            <p style="font-size: 16px; font-weight: bold; color: #0f172a; text-align: center;">
                {{ $participant->event_data_tittle }}
            </p>

            <p>Sertifikat elektronik Anda telah terbit dan dapat diakses/diunduh secara langsung melalui tombol di bawah ini:</p>

            <div style="text-align: center;">
                <a href="{{ route('admin.events.certificates.print_single', $participant->registration_code) }}" class="btn" target="_blank">
                    Unduh Sertifikat Saya
                </a>
            </div>

            <p style="margin-top: 25px;">Kode Registrasi Anda: <code>{{ $participant->registration_code }}</code></p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem event. Silakan simpan pesan ini sebagai bukti verifikasi sertifikat Anda.</p>
        </div>
    </div>
</body>

</html>
