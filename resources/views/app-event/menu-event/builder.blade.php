<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Certificate Builder Complete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-3">

    <div class="container-fluid bg-white p-4 rounded shadow-sm">
        <h4 class="mb-3 text-primary">Certificate Builder & Pengaturan Tata Letak</h4>

        <form action="{{ route('admin.events.certificates.upload_template') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Sidebar Form Controls -->
                <div class="col-md-4 border-end pe-3" style="max-height: 85vh; overflow-y: auto;">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Background Template (JPG/PNG):</label>
                        <input type="file" name="template_image" class="form-control form-control-sm" accept="image/png, image/jpeg">
                    </div>

                    <div class="mb-3 bg-light p-2 border rounded">
                        <label class="form-label fw-bold text-dark mb-1">Jumlah Penandatangan / Pengesah:</label>
                        <select name="signer_mode" class="form-select form-select-sm" required>
                            <option value="1" {{ ($config['signer_mode'] ?? '1') == '1' ? 'selected' : '' }}>1 Pengesah</option>
                            <option value="2" {{ ($config['signer_mode'] ?? '1') == '2' ? 'selected' : '' }}>2 Pengesah</option>
                        </select>
                    </div>

                    <hr>

                    <!-- 1. NAMA PESERTA -->
                    <h6 class="fw-bold text-primary">1. Nama Peserta</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="small fw-bold">Top Y (mm):</label>
                            <input type="number" name="pos_name_top" class="form-control form-control-sm" value="{{ $config['pos_name_top'] ?? 75 }}">
                        </div>
                        <div class="col-4">
                            <label class="small fw-bold">Ukuran (pt):</label>
                            <input type="number" name="font_name_size" class="form-control form-control-sm" value="{{ $config['font_name_size'] ?? 26 }}">
                        </div>
                        <div class="col-4">
                            <label class="small fw-bold">Rata Teks:</label>
                            <select name="align_name" class="form-select form-select-sm">
                                <option value="center" {{ ($config['align_name'] ?? 'center') == 'center' ? 'selected' : '' }}>Tengah</option>
                                <option value="left" {{ ($config['align_name'] ?? '') == 'left' ? 'selected' : '' }}>Kiri</option>
                                <option value="right" {{ ($config['align_name'] ?? '') == 'right' ? 'selected' : '' }}>Kanan</option>
                            </select>
                        </div>
                    </div>

                    <!-- 2. NAMA EVENT UTAMA -->
                    <h6 class="fw-bold text-primary">2. Nama Event Utama</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="small fw-bold">Top Y (mm):</label>
                            <input type="number" name="pos_event_top" class="form-control form-control-sm" value="{{ $config['pos_event_top'] ?? 105 }}">
                        </div>
                        <div class="col-4">
                            <label class="small fw-bold">Ukuran (pt):</label>
                            <input type="number" name="font_event_size" class="form-control form-control-sm" value="{{ $config['font_event_size'] ?? 20 }}">
                        </div>
                        <div class="col-4">
                            <label class="small fw-bold">Rata Teks:</label>
                            <select name="align_event" class="form-select form-select-sm">
                                <option value="center" {{ ($config['align_event'] ?? 'center') == 'center' ? 'selected' : '' }}>Tengah</option>
                                <option value="left" {{ ($config['align_event'] ?? '') == 'left' ? 'selected' : '' }}>Kiri</option>
                                <option value="right" {{ ($config['align_event'] ?? '') == 'right' ? 'selected' : '' }}>Kanan</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. SUB EVENT & CLASS -->
                    <h6 class="fw-bold text-primary">3. Sub Event & Class / Sesi</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="small fw-bold">Top Y (mm):</label>
                            <input type="number" name="pos_sub_event_top" class="form-control form-control-sm" value="{{ $config['pos_sub_event_top'] ?? 125 }}">
                        </div>
                        <div class="col-4">
                            <label class="small fw-bold">Ukuran (pt):</label>
                            <input type="number" name="font_sub_event_size" class="form-control form-control-sm" value="{{ $config['font_sub_event_size'] ?? 13 }}">
                        </div>
                        <div class="col-4">
                            <label class="small fw-bold">Rata Teks:</label>
                            <select name="align_sub_event" class="form-select form-select-sm">
                                <option value="center" {{ ($config['align_sub_event'] ?? 'center') == 'center' ? 'selected' : '' }}>Tengah</option>
                                <option value="left" {{ ($config['align_sub_event'] ?? '') == 'left' ? 'selected' : '' }}>Kiri</option>
                                <option value="right" {{ ($config['align_sub_event'] ?? '') == 'right' ? 'selected' : '' }}>Kanan</option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <!-- 4. PENGESAH 1 -->
                    <h6 class="fw-bold text-secondary">4. Pengesah 1</h6>
                    <div class="mb-2">
                        <input type="text" name="signer1_name" class="form-control form-control-sm mb-1" placeholder="Nama Pengesah 1" value="{{ $config['signer1_name'] ?? 'Dr. John Doe, M.Pd' }}">
                        <input type="text" name="signer1_title" class="form-control form-control-sm" placeholder="Jabatan Pengesah 1" value="{{ $config['signer1_title'] ?? 'Ketua Panitia Pelaksana' }}">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-3">
                            <label class="small fw-bold">Left X (mm):</label>
                            <input type="number" name="pos_signer1_left" class="form-control form-control-sm" value="{{ $config['pos_signer1_left'] ?? 180 }}">
                        </div>
                        <div class="col-3">
                            <label class="small fw-bold">Top Y (mm):</label>
                            <input type="number" name="pos_signer1_top" class="form-control form-control-sm" value="{{ $config['pos_signer1_top'] ?? 160 }}">
                        </div>
                        <div class="col-3">
                            <label class="small fw-bold">Font (pt):</label>
                            <input type="number" name="font_signer1_size" class="form-control form-control-sm" value="{{ $config['font_signer1_size'] ?? 12 }}">
                        </div>
                        <div class="col-3">
                            <label class="small fw-bold">QR Size (px):</label>
                            <input type="number" name="qr_signer1_size" class="form-control form-control-sm" value="{{ $config['qr_signer1_size'] ?? 60 }}">
                        </div>
                    </div>

                    <!-- 5. PENGESAH 2 -->
                    <h6 class="fw-bold text-secondary">5. Pengesah 2</h6>
                    <div class="mb-2">
                        <input type="text" name="signer2_name" class="form-control form-control-sm mb-1" placeholder="Nama Pengesah 2" value="{{ $config['signer2_name'] ?? 'Prof. Jane Smith, Ph.D' }}">
                        <input type="text" name="signer2_title" class="form-control form-control-sm" placeholder="Jabatan Pengesah 2" value="{{ $config['signer2_title'] ?? 'Ketua Umum Organisasi' }}">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-3">
                            <label class="small fw-bold">Left X (mm):</label>
                            <input type="number" name="pos_signer2_left" class="form-control form-control-sm" value="{{ $config['pos_signer2_left'] ?? 30 }}">
                        </div>
                        <div class="col-3">
                            <label class="small fw-bold">Top Y (mm):</label>
                            <input type="number" name="pos_signer2_top" class="form-control form-control-sm" value="{{ $config['pos_signer2_top'] ?? 160 }}">
                        </div>
                        <div class="col-3">
                            <label class="small fw-bold">Font (pt):</label>
                            <input type="number" name="font_signer2_size" class="form-control form-control-sm" value="{{ $config['font_signer2_size'] ?? 12 }}">
                        </div>
                        <div class="col-3">
                            <label class="small fw-bold">QR Size (px):</label>
                            <input type="number" name="qr_signer2_size" class="form-control form-control-sm" value="{{ $config['qr_signer2_size'] ?? 60 }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 my-3">Simpan Konfigurasi</button>
                </div>

                <!-- Preview Live Canvas -->
                <div class="col-md-8 bg-secondary d-flex justify-content-center align-items-center p-3 rounded">
                    <div style="width: 297mm; height: 210mm; transform: scale(0.6); transform-origin: center center; position: relative; background-color: #fff; background-image: url('{{ asset('storage/certificate_templates/background.jpg') }}'); background-size: 100% 100%;">

                        <!-- Nama Peserta -->
                        <div style="position: absolute; top: {{ $config['pos_name_top'] ?? 75 }}mm; left: 5%; width: 90%; text-align: {{ $config['align_name'] ?? 'center' }}; font-size: {{ $config['font_name_size'] ?? 26 }}pt; font-weight: bold; color: #0284c7; font-family: serif;">
                            [ NAMA PESERTA ]
                        </div>

                        <!-- Event Utama -->
                        <div style="position: absolute; top: {{ $config['pos_event_top'] ?? 105 }}mm; left: 5%; width: 90%; text-align: {{ $config['align_event'] ?? 'center' }}; font-size: {{ $config['font_event_size'] ?? 20 }}pt; font-weight: bold; color: #0f172a;">
                            [ NAMA EVENT UTAMA ]
                        </div>

                        <!-- Sub Event & Class -->
                        <div style="position: absolute; top: {{ $config['pos_sub_event_top'] ?? 125 }}mm; left: 5%; width: 90%; text-align: {{ $config['align_sub_event'] ?? 'center' }}; font-size: {{ $config['font_sub_event_size'] ?? 13 }}pt; color: #475569;">
                            Sub Event: [ NAMA SUB EVENT ] - [ NAMA CLASS / SESI ]
                        </div>

                        <!-- Pengesah 1 -->
                        <div style="position: absolute; top: {{ $config['pos_signer1_top'] ?? 160 }}mm; left: {{ $config['pos_signer1_left'] ?? 180 }}mm; width: 90mm; text-align: center;">

                            <!-- Barcode / QR Code Pengesah 1 -->
                            @php
                            $signer1Name = !empty($config['signer1_name']) ? $config['signer1_name'] : 'Dr. John Doe, M.Pd';
                            $qrSize1 = $config['qr_signer1_size'] ?? 60;

                            // Menggunakan URL Verifikasi Resmi (Sample Code untuk Preview Builder)
                            $sampleCode = 'REG-SAMPLE-12345';
                            $verifyUrl1 = route('certificate.verify', ['code' => $sampleCode]);
                            $qrApiUrl1 = "https://api.qrserver.com/v1/create-qr-code/?size={$qrSize1}x{$qrSize1}&data=" . urlencode($verifyUrl1);
                            @endphp

                            <div style="margin-bottom: 8px;">
                                <img src="{{ $qrApiUrl1 }}"
                                    alt="QR TTE"
                                    style="width: {{ $qrSize1 }}px; height: {{ $qrSize1 }}px;">
                            </div>

                            <div style="font-size: {{ $config['font_signer1_size'] ?? 12 }}pt; font-weight: bold; color: #0f172a; text-decoration: underline;">
                                {{ $signer1Name }}
                            </div>
                            <div style="font-size: 10pt; color: #475569;">
                                {{ !empty($config['signer1_title']) ? $config['signer1_title'] : 'Ketua Panitia Pelaksana' }}
                            </div>
                        </div>

                        <!-- Pengesah 2 -->
                        @if(($config['signer_mode'] ?? '1') == '2')
                        <div style="position: absolute; top: {{ $config['pos_signer2_top'] ?? 160 }}mm; left: {{ $config['pos_signer2_left'] ?? 30 }}mm; width: 90mm; text-align: center;">

                            <!-- Barcode / QR Code Pengesah 2 -->
                            @php
                            $signer2Name = !empty($config['signer2_name']) ? $config['signer2_name'] : 'Prof. Jane Smith, Ph.D';
                            $qrSize2 = $config['qr_signer2_size'] ?? 60;

                            // Menggunakan URL Verifikasi Resmi (Sample Code untuk Preview Builder)
                            $verifyUrl2 = route('certificate.verify', ['code' => $sampleCode]);
                            $qrApiUrl2 = "https://api.qrserver.com/v1/create-qr-code/?size={$qrSize2}x{$qrSize2}&data=" . urlencode($verifyUrl2);
                            @endphp

                            <div style="margin-bottom: 8px;">
                                <img src="{{ $qrApiUrl2 }}"
                                    alt="QR TTE"
                                    style="width: {{ $qrSize2 }}px; height: {{ $qrSize2 }}px;">
                            </div>

                            <div style="font-size: {{ $config['font_signer2_size'] ?? 12 }}pt; font-weight: bold; color: #0f172a; text-decoration: underline;">
                                {{ $signer2Name }}
                            </div>
                            <div style="font-size: 10pt; color: #475569;">
                                {{ !empty($config['signer2_title']) ? $config['signer2_title'] : 'Ketua Umum Organisasi' }}
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </form>
    </div>

</body>

</html>
