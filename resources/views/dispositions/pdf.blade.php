<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        @page { 
            margin-top: 0px; 
        }

        .container {
            margin: 20px;
        }
        .text-center {
            text-align: center;
        }
        .text-uppercase {
            text-transform: uppercase;
        }
        .fw-bold {
            font-weight: bold;
        }
        .border {
            border: 1px solid black;
        }
        .border-top {
            border-top: 1px solid black;
        }
        .border-bottom {
            border-bottom: 1px solid black;
        }
        .mt-2 {
            margin-top: 10px;
        }
        .text-end {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
        }
        hr {
            margin: 0;
            border-color: black !important;
        }
    </style>
</head>
<body>
    @php
        use Carbon\Carbon;

        $disposisi_kepada = $disposisi->disposisi_kepada;
        $disposisi_list_id = $disposisi->disposisi_list_id ;
        $tanggal_surat = Carbon::parse($disposisi->suratMasuk->tanggal_surat)->format('d-m-Y');
        $tanggal_agenda = Carbon::parse($disposisi->suratMasuk->tanggal_agenda)->format('d-m-Y');
        $tanggal_disposisi = Carbon::parse($disposisi->tanggal_disposisi)->format('d-m-Y');
    @endphp
    <div class="container">
        <!-- Kop surat -->
        <div class="text-center" style="width:38%;border-bottom: 1px solid black;">
            {!! nl2br(e($kopstuk->ur_kopstuk)) !!}
        </div>
        <br>

        <!-- Judul dan Nomor -->
        <div class="text-center">
            <strong style="border-bottom: 1px solid black; width: 35%;">LEMBAR DISPOSISI</strong><br>
            Nomor: {{ $disposisi->suratMasuk->nomor_agenda }}
        </div>
        <br>

        <!-- Detail Surat -->
        <table>
            <tbody>
                <tr>
                    <td width="25%" class="text-uppercase">Diterima Dari</td>
                    <td width="40%">: {{ $disposisi->suratMasuk->terima_dari }}</td>
                    <td width="15%"></td>
                    <td width="20%"></td>
                </tr>
                <tr>
                    <td class="text-uppercase">Nomor Surat</td>
                    <td>: {{ $disposisi->suratMasuk->nomor_surat }}</td>
                    <td class="text-uppercase">Pukul</td>
                    <td>: {{ substr($disposisi->suratMasuk->waktu_agenda, 0, 5) }} WIB</td>
                </tr>
                <tr>
                    <td class="text-uppercase">Tanggal Surat</td>
                    <td>: {{ $tanggal_surat }}</td>
                    <td class="text-uppercase">Tanggal</td>
                    <td>: {{ $tanggal_agenda }}</td>
                </tr>
                <tr>
                    <td class="text-uppercase">Perihal</td>
                    <td colspan="3">: {!! nl2br(e($disposisi->suratMasuk->perihal )) !!}</td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center border-top border-bottom text-uppercase">DISPOSISI {{ $disposisi->user->jabatan }}</h2>

        <!-- Disposisi Kepada -->
        <div>
            <table width="100%">
                <tr>
                    <td width="20%"><p>Kepada: Yth.</p></td>
                    <td width="80%">
                        <table width="100%" class="text-uppercase">
                            <tr>
                                <td width="50%">
                                    @for ($i = 0; $i < ceil(count($pejabat)/2); $i++)
                                        <p class="@if (in_array($pejabat[$i]->id, $disposisi_kepada)) fw-bold @endif">
                                            {{ $i + 1 }}. {{ $pejabat[$i]->jabatan }}
                                            @if (in_array($pejabat[$i]->id, $disposisi_kepada)) 
                                                <span style="font-family: DejaVu Sans, sans-serif;">✔</span> 
                                            @endif
                                        </p>
                                    @endfor
                                </td>
                                <td width="50%">
                                    @for ($i = ceil(count($pejabat)/2); $i < count($pejabat); $i++)
                                        <p class="@if (in_array($pejabat[$i]->id, $disposisi_kepada)) fw-bold @endif">
                                            {{ $i + 1 }}. {{ $pejabat[$i]->jabatan }}
                                            @if (in_array($pejabat[$i]->id, $disposisi_kepada)) 
                                                <span style="font-family: DejaVu Sans, sans-serif;">✔</span> 
                                            @endif
                                        </p>
                                    @endfor
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Disposisi List -->
        <div class="text-uppercase">
            <table width="100%">
                <tr>
                    <td width="33%">
                        @for ($a = 0; $a < ceil(count($disposisi_list)/3); $a++)
                            <p class="@if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) fw-bold @endif">
                                {{ $a + 1 }}. {{ $disposisi_list[$a]->ur_disposisi_list }}
                                @if (in_array($disposisi_list[$a]->id, $disposisi_list_id))
                                    <span style="font-family: DejaVu Sans, sans-serif;">✔</span>
                                @endif
                            </p>
                        @endfor
                    </td>
                    <td width="33%">
                        @for ($a = ceil(count($disposisi_list)/3); $a < ceil(2*count($disposisi_list)/3); $a++)
                            <p class="@if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) fw-bold @endif">
                                {{ $a + 1 }}. {{ $disposisi_list[$a]->ur_disposisi_list }}
                                @if (in_array($disposisi_list[$a]->id, $disposisi_list_id))
                                    <span style="font-family: DejaVu Sans, sans-serif;">✔</span>
                                @endif
                            </p>
                        @endfor
                    </td>
                    <td width="33%">
                        @for ($a = ceil(2*count($disposisi_list)/3); $a < count($disposisi_list); $a++)
                            <p class="@if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) fw-bold @endif">
                                {{ $a + 1 }}. {{ $disposisi_list[$a]->ur_disposisi_list }}
                                @if (in_array($disposisi_list[$a]->id, $disposisi_list_id))
                                    <span style="font-family: DejaVu Sans, sans-serif;">✔</span>
                                @endif
                            </p>
                        @endfor
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Lain-lain -->
        <div class="mt-2">
            <table width="100%" cellspacing="0" cellpadding="5">
                <tr>
                    <td class="text-uppercase" width="15%">LAIN-LAIN :</td>
                    <td width="85%" class="border">{!! nl2br(e($disposisi->isi)) !!}<br><br></td>
                </tr>
            </table>
        </div>
        
        <!-- Paraf dan Tanggal Disposisi -->
        <div class="mt-2">
            <table width="100%" cellpadding="5">
                <tr>
                    <td width="50%">Paraf: <img src="{{ $disposisi->paraf }}" style="position:absolute;" alt="Paraf" height="50"/></td>
                    <td width="50%" class="text-end">Tgl Disposisi: {{ $tanggal_disposisi }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
