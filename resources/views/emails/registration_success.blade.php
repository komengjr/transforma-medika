<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran Event</title>
</head>

<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #333333;">

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

        <!-- HEADER SECTION -->
        <tr>
            <td style="background-color: #1e293b; padding: 30px 20px; text-align: center; color: #ffffff;">
                <div style="margin-bottom: 20px; text-align: center;">
                    <img src="{{ asset('img/pramita.png') }}" alt="Logo Pramita" style="max-width: 140px; height: auto; display: block; margin: 0 auto;">
                    <span style="display: block; font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-top: 6px; font-weight: 500;">
                        Support by Pramita
                    </span>
                </div>

                <h2 style="margin: 0; font-size: 22px; font-weight: 700; letter-spacing: 0.5px;">KONFIRMASI PENDAFTARAN</h2>
                <p style="margin: 5px 0 0 0; font-size: 14px; color: #94a3b8;">{{ $eventName }}</p>
            </td>
        </tr>

        <!-- CONTENT BODY -->
        <tr>
            <td style="padding: 30px 25px;">
                <p style="font-size: 16px; margin-top: 0;">Halo, <strong>{{ $participantName }}</strong>!</p>
                <p style="font-size: 14px; color: #475569; line-height: 1.6;">
                    Pendaftaran Anda untuk event <strong>{{ $eventName }}</strong> telah berhasil disimpan. Berikut adalah rincian tiket dan Sub Event yang Anda ikuti:
                </p>

                <!-- LIST SUB EVENTS & CLASSES CARD -->
                <div style="margin-top: 20px;">
                    @foreach($registrations as $item)
                    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #4f46e5; border-radius: 8px; padding: 15px; margin-bottom: 15px;">

                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td>
                                    <span style="font-size: 11px; font-weight: 700; color: #4f46e5; text-transform: uppercase; letter-spacing: 0.5px;">SUB EVENT</span>
                                    <h4 style="margin: 2px 0 8px 0; font-size: 16px; color: #0f172a;">{{ $item['sub_event_name'] }}</h4>
                                </td>
                            </tr>
                        </table>

                        <div style="background-color: #ffffff; border: 1px dashed #cbd5e1; border-radius: 6px; padding: 10px; margin-bottom: 10px;">
                            <table width="100%" cellspacing="0" cellpadding="2" style="font-size: 13px;">
                                <tr>
                                    <td style="color: #64748b; width: 120px;">Kode Registrasi:</td>
                                    <td style="font-weight: bold; color: #0f172a; font-family: monospace;">{{ $item['registration_code'] }}</td>
                                </tr>
                            </table>
                        </div>

                        <p style="margin: 8px 0 4px 0; font-size: 12px; font-weight: 600; color: #64748b;">Kelas / Tiket Dipilih:</p>
                        @if(!empty($item['classes']) && count($item['classes']) > 0)
                        <ul style="margin: 0; padding-left: 18px; font-size: 13px; color: #334155;">
                            @foreach($item['classes'] as $cls)
                            <li style="margin-bottom: 4px;">
                                <strong>{{ $cls['class_name'] }}</strong>
                                @if(!empty($cls['room']))
                                <span style="color: #64748b; font-size: 12px;">(Ruang: {{ $cls['room'] }})</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p style="margin: 0; font-size: 13px; color: #64748b; font-style: italic;">(Terdaftar otomatis / Tanpa pilihan kelas)</p>
                        @endif

                    </div>
                    @endforeach
                </div>

                <!-- INFO CATATAN -->
                <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px 15px; margin-top: 20px;">
                    <p style="margin: 0; font-size: 13px; color: #1e40af; line-height: 1.5;">
                        📌 <strong>Informasi Tambahan:</strong> Harap simpan email ini dan tunjukkan Kode Registrasi di lokasi acara untuk verifikasi kehadiran.
                    </p>
                </div>

                <!-- CONTACT PERSON SECTION -->
                @if(isset($contactPersons) && $contactPersons->count() > 0)
                <div style="margin-top: 25px; padding: 15px; background-color: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h4 style="margin: 0 0 10px 0; font-size: 13px; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                        📞 Contact Person Panitia
                    </h4>

                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size: 13px; color: #475569;">
                        @foreach($contactPersons as $cp)
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px dashed #e2e8f0;">
                                <strong style="color: #0f172a;">{{ $cp->contact_name }}</strong>
                                @if(!empty($cp->contact_role))
                                <span style="color: #64748b; font-size: 12px;">({{ $cp->contact_role }})</span>
                                @endif
                                @if(!empty($cp->contact_email))
                                <br><span style="color: #94a3b8; font-size: 11px;">✉️ {{ $cp->contact_email }}</span>
                                @endif
                            </td>
                            <td style="text-align: right; padding: 8px 0; border-bottom: 1px dashed #e2e8f0; vertical-align: middle;">
                                @if(!empty($cp->contact_number))
                                @php
                                // Auto-format nomor HP untuk Link WhatsApp (08xx -> 628xx)
                                $phone = preg_replace('/[^0-9]/', '', $cp->contact_number);
                                if (str_starts_with($phone, '0')) {
                                $phone = '62' . substr($phone, 1);
                                }
                                @endphp
                                <a href="https://wa.me/{{ $phone }}" target="_blank" style="color: #15803d; text-decoration: none; font-weight: 600; background-color: #dcfce7; border: 1px solid #bbf7d0; padding: 5px 10px; border-radius: 6px; display: inline-block; font-size: 12px;">
                                    💬 {{ $cp->contact_number }}
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

                <!-- CLOSING -->
                <p style="font-size: 14px; color: #0f172a; margin-top: 25px; margin-bottom: 0;">
                    Salam hangat,<br>
                    <strong>Panitia {{ $eventName }}</strong>
                </p>
            </td>
        </tr>

        <!-- FOOTER SECTION -->
        <tr>
            <td style="background-color: #f1f5f9; padding: 15px 20px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini secara langsung.
            </td>
        </tr>

    </table>

</body>

</html>
