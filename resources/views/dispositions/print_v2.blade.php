<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposition Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size:11;
        }

        .container {
            width: 90%;
            margin: auto;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        table {
            font-size:10;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 5px;
            vertical-align: top;
        }

        .no-border {
            border: none;
        }

        .no-border td {
            border: none;
        }

        hr.centered-hr {
            width: 35%;
            margin-left: auto;
            margin-right: auto;
            border-color: black;
        }

        hr {
            margin: 0;
            border: 1px solid black;
            /* border-color: black !important; */
        }

        p {
            margin: 0;
            padding: 0;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }
            body {
                margin: 0;
            }
        }
    </style>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>

@php
    use Carbon\Carbon;
    $disposisi_kepada = $disposisi->disposisi_kepada;
    $disposisi_list_id = $disposisi->disposisi_list_id ;
    $tanggal_surat = Carbon::parse($disposisi->suratMasuk->tanggal_surat)->format('d-m-Y');
    $tanggal_agenda = Carbon::parse($disposisi->suratMasuk->tanggal_agenda)->format('d-m-Y');
    $tanggal_disposisi = Carbon::parse($disposisi->tanggal_disposisi)->format('d-m-Y');
@endphp

<body>
    <div class="container">
        <div class="text-center" style="width:50%;border-bottom: 1px solid black;">
            <p>{!! nl2br(e($kopstuk->ur_kopstuk)) !!}</p>
        </div>
        <br>

        <div class="text-center">
            <p><strong style="border-bottom: 1px solid black; width: 35%;">LEMBAR DISPOSISI</strong></p>
            <!-- <hr class="centered-hr">    -->
            <p><strong>Nomor Agenda</strong>: {{ $disposisi->suratMasuk->nomor_agenda }}</p>
        </div>

        <table class="no-border">
            <tbody>
                <tr>
                    <td><strong>Asal Surat</strong></td>
                    <td>: {{ $disposisi->suratMasuk->terima_dari }}</td>
                    <td><strong>Tgl Input</strong></td>
                    <td>: {{ $tanggal_disposisi }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor Surat</strong></td>
                    <td>: {{ $disposisi->suratMasuk->nomor_surat }}</td>
                    <td><strong>Pukul</strong></td>
                    <td>: {{ substr($disposisi->suratMasuk->waktu_agenda, 0, 5) }} WIB</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Surat</strong></td>
                    <td>: {{ $tanggal_surat }}</td>
                    <td><strong>Disposisi Dari</strong></td>
                    <td>: {{ $disposisi->user->jabatan }}</td>
                </tr>
                <tr>
                    <td><strong>Perihal</strong></td>
                    <td colspan="3">: {!! nl2br(e($disposisi->suratMasuk->perihal )) !!}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th class="text-uppercase text-center">Diteruskan Kepada</th>
                    <th class="text-uppercase text-center">Tanggal</th>
                    <th class="text-uppercase text-center">Isi Disposisi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @php $no = 1; @endphp
                        @foreach($pejabat as $row)
                            <p style="margin-left: 1rem;" class="@if (in_array($row->id, $disposisi_kepada)) fw-bold @endif">
                                {{ $no }}. {{ $row->jabatan }} 
                                @if (in_array($row->id, $disposisi_kepada)) <span style="font-family: DejaVu Sans, sans-serif;">✔</span> @endif
                            </p>
                            @php $no++; @endphp
                        @endforeach
                    </td>
                    <td>{{ $tanggal_agenda }}</td>
                    <td>{!! nl2br(e($disposisi->isi)) !!}</td>
                </tr>
            </tbody>
        </table>

        <div>
            <p>Paraf: <img src="{{ $disposisi->paraf }}" style="position:absolute;" alt="Paraf" height="50"/></p>
        </div>
    </div>
</body>
</html>
