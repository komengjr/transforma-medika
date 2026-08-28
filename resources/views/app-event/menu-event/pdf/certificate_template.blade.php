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

        /* Pengesah 1 (Kanan) */
        .signer1-box {
            position: absolute;
            top: {{ $config['pos_signer1_top'] ?? 160 }}mm;
            right: 8%;
            width: 38%;
            text-align: {{ $config['align_signer1'] ?? 'right' }};
        }

        /* Pengesah 2 (Kiri) */
        .signer2-box {
            position: absolute;
            top: {{ $config['pos_signer2_top'] ?? 160 }}mm;
            left: 8%;
            width: 38%;
            text-align: {{ $config['align_signer2'] ?? 'left' }};
        }

        .signer-name {
            font-size: {{ $config['font_signer1_size'] ?? 12 }}pt;
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

        <!-- Pengesah 1 (Kanan) -->
        <div class="signer1-box">
            <div class="signer-name" style="font-size: {{ $config['font_signer1_size'] ?? 12 }}pt;">
                {{ $config['signer1_name'] ?? 'Dr. John Doe, M.Pd' }}
            </div>
            <div class="signer-title">
                {{ $config['signer1_title'] ?? 'Ketua Panitia Pelaksana' }}
            </div>
        </div>

        <!-- Pengesah 2 (Kiri) - Tampil jika mode == 2 ATAU jika variabel signer2_name terisi -->
        @if(($config['signer_mode'] ?? '1') == '2' || !empty($config['signer2_name']))
        <div class="signer2-box">
            <div class="signer-name" style="font-size: {{ $config['font_signer2_size'] ?? 12 }}pt;">
                {{ $config['signer2_name'] ?? 'Prof. Jane Smith, Ph.D' }}
            </div>
            <div class="signer-title">
                {{ $config['signer2_title'] ?? 'Ketua Umum Organisasi' }}
            </div>
        </div>
        @endif

    </div>
</body>
</html>
