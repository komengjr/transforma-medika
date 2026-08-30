<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $participant->registration_code }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        .certificate-bg {
            width: 297mm;
            height: 210mm;
            position: relative;
            background-image: url("{{ public_path('storage/certificate_templates/background.jpg') }}");
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        /* Nama Peserta */
        .participant-name {
            position: absolute;
            top: {{ $config['pos_name_top'] ?? 75 }}mm;
            left: 5%;
            width: 90%;
            text-align: {{ $config['align_name'] ?? 'center' }};
            font-size: {{ $config['font_name_size'] ?? 26 }}pt;
            font-weight: bold;
            color: #0284c7;
            font-family: 'Georgia', serif;
        }

        /* Event Utama */
        .event-title {
            position: absolute;
            top: {{ $config['pos_event_top'] ?? 105 }}mm;
            left: 5%;
            width: 90%;
            text-align: {{ $config['align_event'] ?? 'center' }};
            font-size: {{ $config['font_event_size'] ?? 20 }}pt;
            font-weight: bold;
            color: #0f172a;
        }

        /* Sub Event & Class */
        .sub-event-title {
            position: absolute;
            top: {{ $config['pos_sub_event_top'] ?? 125 }}mm;
            left: 5%;
            width: 90%;
            text-align: {{ $config['align_sub_event'] ?? 'center' }};
            font-size: {{ $config['font_sub_event_size'] ?? 13 }}pt;
            color: #475569;
        }

        /* Pengesah 1 */
        .signer1-box {
            position: absolute;
            top: {{ $config['pos_signer1_top'] ?? 160 }}mm;
            left: {{ $config['pos_signer1_left'] ?? 180 }}mm;
            width: 90mm;
            text-align: center;
        }

        /* Pengesah 2 */
        .signer2-box {
            position: absolute;
            top: {{ $config['pos_signer2_top'] ?? 160 }}mm;
            left: {{ $config['pos_signer2_left'] ?? 30 }}mm;
            width: 90mm;
            text-align: center;
        }

        .signer-name {
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #0f172a;
            display: inline-block;
            padding-bottom: 2px;
        }

        .signer-title {
            font-size: 10pt;
            color: #475569;
            margin-top: 3px;
        }

        .qr-container {
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    <div class="certificate-bg">

        <!-- Nama Peserta -->
        <div class="participant-name">
            {{ $participant->full_name }}
        </div>

        <!-- Nama Event Utama -->
        <div class="event-title">
            {{ $participant->event_data_tittle }}
        </div>

        <!-- Sub Event & Class -->
        @if(isset($participantClasses) && count($participantClasses) > 0)
        <div class="sub-event-title">
            @foreach($participantClasses as $item)
                <div>{{ $item->event_data_sub_name }} — <i>{{ $item->event_data_sub_class_name }}</i></div>
            @endforeach
        </div>
        @endif

        <!-- Pengesah 1 -->
        <div class="signer1-box">
            @php
                $signer1Name = $config['signer1_name'] ?? 'Dr. John Doe, M.Pd';
                $qrSize1     = $config['qr_signer1_size'] ?? 60;

                // Dynamic verification URL
                $verifyUrl1  = route('certificate.verify', ['code' => $participant->registration_code]);
                $qrApiUrl1   = "https://api.qrserver.com/v1/create-qr-code/?size={$qrSize1}x{$qrSize1}&data=" . urlencode($verifyUrl1);
            @endphp

            <div class="qr-container">
                <img src="{{ $qrApiUrl1 }}" alt="QR TTE" style="width: {{ $qrSize1 }}px; height: {{ $qrSize1 }}px;">
            </div>

            <div class="signer-name" style="font-size: {{ $config['font_signer1_size'] ?? 12 }}pt;">
                {{ $signer1Name }}
            </div>
            <div class="signer-title">
                {{ $config['signer1_title'] ?? 'Ketua Panitia Pelaksana' }}
            </div>
        </div>

        <!-- Pengesah 2 (Tampil HANYA jika mode signer_mode == '2') -->
        @if(($config['signer_mode'] ?? '1') == '2')
        <div class="signer2-box">
            @php
                $signer2Name = $config['signer2_name'] ?? 'Prof. Jane Smith, Ph.D';
                $qrSize2     = $config['qr_signer2_size'] ?? 60;

                // Dynamic verification URL
                $verifyUrl2  = route('certificate.verify', ['code' => $participant->registration_code]);
                $qrApiUrl2   = "https://api.qrserver.com/v1/create-qr-code/?size={$qrSize2}x{$qrSize2}&data=" . urlencode($verifyUrl2);
            @endphp

            <div class="qr-container">
                <img src="{{ $qrApiUrl2 }}" alt="QR TTE" style="width: {{ $qrSize2 }}px; height: {{ $qrSize2 }}px;">
            </div>

            <div class="signer-name" style="font-size: {{ $config['font_signer2_size'] ?? 12 }}pt;">
                {{ $signer2Name }}
            </div>
            <div class="signer-title">
                {{ $config['signer2_title'] ?? 'Ketua Umum Organisasi' }}
            </div>
        </div>
        @endif

    </div>
</body>
</html>
