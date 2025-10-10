<!DOCTYPE html>
<html lang="en">

<head>
    <title>Report Vladiation</title>
</head>
<style>
    @page {
        margin-left: 25px;
        margin-top: 5px;
        /* font-family: Calibri (Body); */
    }
</style>
<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:400,100,900);

    * {
        font-family: 'Roboto', sans-serif !important;
    }
</style>
<style>
    div.header {
        position: relative;
        left: 20px;
        width: 100%;
        height: 106px;
        border: 0.2px solid #000000;
    }

    div.body {
        position: relative;
        left: 20px;
        width: 100%;
        height: 500px;
        border: 0px solid #302a2a;
        font-size: 15px;
    }

    div.absolute {
        position: absolute;
        top: 0px;
        right: 0;
        width: 101px;
        height: 104px;
        border: 1px solid #252424;
    }

    div.absolute-kiri {
        position: absolute;
        top: 0px;
        left: 0;
        width: 156px;
        height: 104px;
        border: 1px solid #252424;
    }

    table {
        border-collapse: collapse;
    }

    table tr td p {

        padding: 0px;
        margin: 0px;
        font-weight: bold;
    }

    .card {
        padding: 1%;
        width: 97.8%;
        border: 1px solid #000000;
    }

    .table thead {
        font-weight: bold;
        border: 1px solid #000000;
    }

    .table thead tr td {
        padding: 5px;
    }

    .table tbody tr td {

        border: none;
        /* border-bottom: 1px solid #000000; */
        padding: 5px;
    }

    div.footer {
        position: fixed;
        left: 0;
        bottom: 15px;
        border: 0px solid #302a2a;
        font-size: 15px;
    }

    .table-footer tr td {
        padding-top: 20%;
        text-align: center;
        border: none;
    }
</style>
</head>

<body style="padding-top: 25px; padding-left: 0px;">

    <div class="header">
        <div class="absolute-kiri">

            <img style="padding-top: 0px; margin: 2px; left: 2px; ;" src="data:image/png;base64, {{ $image }}"
                width="152">

            <hr style="padding: 0%; margin: 0%;">
            <p style="font-size: 9px; text-align: center; margin-left: 2px;margin-right: 2px;">jl Simulasi Kecamatan
                Singsingamaraja No 98Z</p>
        </div>
        <h4 style=" margin: 20px; margin-top: 2%; left: 100px; padding-left: 60px; text-align: center;">( TRNSFORMASI
            SISTEM INFORMASI MEDIKA ) <br>TRANSFORMA MEDIKA </h4>
        <h5 style=" margin: 20px; margin-top: 1%; left: 100px; padding-left: 60px; text-align: center;">RUMAH SAKIT
            TRANS MEDIKA BERJAYA</h5>
        {{-- <img style="padding-top: 11px;"
            src="data:image/png;base64, {!! base64_encode( QrCode::eyeColor(0, 255, 0, 0, 0, 0, 0)->style('round')->eye('circle')->format('svg')->size(107)->errorCorrection('H')->generate(123123),) !!}">
        --}}

        <div class="absolute">
            <img style="padding-top: 3px; padding-left: 2px;" src="data:image/png;base64, {!! base64_encode(
    QrCode::style('round')->eye('circle')->format('svg')->size(97)->errorCorrection('H')->generate($code),
) !!}">
        </div>
    </div>
    <div class="body">
        <br>
        <p style="margin-bottom: 0%; color: #0f02ffff;">HASIL PEMERIKSAAN RADIOLOGI<span style="float: right;">{{$code}}
                RAD. 33-FRM-PU-03.
                1/02</span></p>
        <hr style="margin-bottom: 0%;">

        <table style="width: 100%; border: none; margin-bottom: 5%; vertical-align: top;">
            <tr style="border: none; vertical-align: top;">
                <td style="border: none;">No Reg</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{$code}}</td>
                <td style="border: none;">Tanggal Reg</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) }}</td>
            </tr>
            <tr style="border: none; vertical-align: top;">
                <td style="border: none;">Nama</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{$data->master_patient_name}}</td>
                <td style="border: none;">Pasien ID</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{$data->master_patient_code}}</td>
            </tr>
            <tr style="border: none; vertical-align: top;">
                <td style="border: none;">Pengirim</td>
                <td style="border: none;">:</td>
                <td style="border: none;">
                    <?php
$dokter = DB::table('master_doctor')->where('master_doctor_code', $reg->d_reg_order_rad_dr_rujukan)->first();
                    ?>
                    @if ($dokter->master_doctor_name)
                        {{ $dokter->master_doctor_name }}
                    @else
                        Belum Ada Dokter
                    @endif
                </td>
                <td style="border: none;">Jenis Kelamin</td>
                <td style="border: none;">:</td>
                <td style="border: none;">
                    @if ($data->master_patient_jk == 'L')
                        Laki - Laki
                    @else
                        Perempuan
                    @endif
                </td>
            </tr>
            <tr style="border: none; vertical-align: top;">
                <td style="border: none;">Alamat</td>
                <td style="border: none; width: 2%;">:</td>
                <td style="border: none; width: 40%;"> {{$data->master_patient_alamat}}</td>
                <td style="border: none; width: 20%;">Tanggal Lahir</td>
                <td style="border: none; width: 2%;">:</td>
                <td style="border: none;">23-09-1999</td>
            </tr>
        </table>

        <div class="card">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <td style="width: 30%;">JENIS PEMERIKSAAN</td>
                        <td>DESKRIPSI</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemeriksaan as $pem)
                        <tr>
                            <td colspan="2"><strong>{{ $pem->t_pemeriksaan_list_name}}</strong></td>
                        </tr>
                        @php
                            $sub = DB::table('t_pemeriksaan_list_val')->where('t_pemeriksaan_list_code', $pem->t_pemeriksaan_list_code)->get();
                        @endphp
                        @foreach ($sub as $subs)
                            <tr>
                                <td style="vertical-align: top;">{{$subs->t_pem_list_val_name}}</td>
                                <td style="text-align: justify;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quae
                                    id, architecto eius itaque tempore quisquam dolorum placeat, deserunt blanditiis, ratione
                                    cumque officiis est voluptatem magni inventore eos earum amet consequatur!</td>
                            </tr>
                        @endforeach
                    @endforeach



                </tbody>
            </table>
        </div>
        <br>
        <div class="footer">
            <table class="table-footer"
                style="font-size: 8px; margin: 0px; padding: 0px; width: 100%; font-size: 11px; font-family: Calibri (Body);">

                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-center" style=" width: 66%;">
                        <p style="text-align: left; margin-top: 0px;">Kini hasil laboratorium bisa dibuka di Web Resmi
                            Kami
                            dan email anda.
                            Info lebih lanjut hubungi Customer Service kami
                            <br><br>
                            Printed by : agus / {{date('d-m-Y H:i:s')}} / {{$code}}
                        </p>

                    </td>

                    <td class="text-center" style="width: 33%;">
                        <p>Validasi Oleh</p><br>
                        <img style="padding-top: 1px; left: 1px;" src="data:image/png;base64, {!! base64_encode(
    QrCode::style('round')->eye('circle')->format('svg')->size(50)->errorCorrection('H')->generate(123),
) !!}"><br>
                        <p>Penanggung Jawab</p>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</body>

</html>
