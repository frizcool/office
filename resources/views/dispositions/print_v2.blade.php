<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposition Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        hr.centered-hr {
            width: 70%;
            margin-left: auto;
            margin-right: auto;
        }
        hr { 
            margin-bottom: 0;
            margin-top: 0;
            border-color: black !important;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        tr, td {
            padding: 5px;
            margin: 0px;
            vertical-align: top;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0; /* Set margin to none */
            }
            body {
                margin: 0; /* Remove margin for the body as well */
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
    <div class="container my-4">  
        <div class="row">
            <div class="col-md-6">
                <div class="text-center">
                    <p style="margin-bottom:0;">{!! nl2br(e($kopstuk->ur_kopstuk)) !!}</p>
                    <hr>                    
                </div>
            </div>
        </div>
        <br>
        <div class="mb-3">
            <div class="row">
                <div class="col-3 text-center"></div>
                <div class="col-6 text-center">
                <p style="margin-bottom:0;"><strong>LEMBAR DISPOSISI</strong></p>
                <hr class="centered-hr">   
                    <p><strong>Nomor Agenda</strong> : {{ $disposisi->suratMasuk->nomor_agenda }}</p>
                </div>
                <div class="col-3 text-center"></div>
            </div>
        </div>

        <table class="table table-borderless table-sm">
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
                    <td>: {{ $disposisi->suratMasuk->waktu_agenda }}</td>
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

        <table class="table table-bordered">
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
                    @php
                        $no = 0;
                    @endphp
                    @foreach($pejabat as $row)
                        @php
                            $no++;
                        @endphp
                        <p style="margin-left: 1rem;" class="@if (in_array($row->id, $disposisi_kepada)) fw-bold @endif">{{ $no }}. {{ $row->jabatan }} @if (in_array($row->id, $disposisi_kepada)) &#10003; @endif</p>
                    @endforeach
                </td>
                <td>{{ $tanggal_agenda  }}</td>
                <td>
                {!! nl2br(e($disposisi->isi )) !!}
                </td>
            </tr>              
            </tbody>
        </table>
    <div class="row mt-2">
                <div class="col-md-6">Paraf : <img src="{{ $disposisi->paraf }}" alt="Paraf" /></div>
                <div class="col-md-6"></div>
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>