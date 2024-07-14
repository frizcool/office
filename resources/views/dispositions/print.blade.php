<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        hr.centered-hr {
            width: 60%;
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
                margin: 20mm;
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
        $disposisi_kepada = $disposisi->disposisi_kepada;
        $disposisi_list_id = $disposisi->disposisi_list_id ;
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
        <div class="row">
            <div class="col-md-4 text-center"></div>
            <div class="col-md-4 text-center">                
                <p style="margin-bottom:0;">LEMBAR DISPOSISI</p>
                <hr class="centered-hr">   
                <p>Nomor : {{ $disposisi->suratMasuk->nomor_agenda }}</p>
            </div>
            <div class="col-md-4 text-center"></div>
        </div>
        <table class="table table-borderless table-sm">
            <tbody>
                <tr>
                    <td width="25%" class="text-uppercase">Diterima Dari</td>
                    <td width="40%">: {{ $disposisi->suratMasuk->terima_dari }}</td>
                    <td width="15%"></td>
                    <td width="20%"> </td>
                </tr>
                <tr>
                    <td class="text-uppercase">Nomor Surat</td>
                    <td>: {{ $disposisi->suratMasuk->nomor_surat }}</td>
                    <td class="text-uppercase">Pukul</td>
                    <td>: {{ $disposisi->suratMasuk->waktu_agenda }}</td>
                </tr>
                <tr>
                    <td class="text-uppercase">Tanggal Surat</td>
                    <td>: {{ $disposisi->suratMasuk->tanggal_surat }}</td>
                    <td class="text-uppercase">Tanggal</td>
                    <td>: {{ $disposisi->suratMasuk->tanggal_agenda }}</td>
                </tr>
                <tr>
                    <td class="text-uppercase">Perihal</td>
                    <td colspan="3">: {!! nl2br(e($disposisi->suratMasuk->perihal )) !!}</td>
                </tr>
            </tbody>
        </table>
        <h6 class="text-center border-top border-bottom p-2 text-uppercase">DISPOSISI {{ $disposisi->user->jabatan }}</h6>
        <div class="row">
            <div class="col-md-2">
                <p>Kepada: Yth.</p>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6 text-uppercase">
                        @for ($i = 0; $i < count($pejabat)/2; $i++)
                            <p class="@if (in_array($pejabat[$i]->id, $disposisi_kepada)) fw-bold @endif">{{ $i + 1 }}. {{ $pejabat[$i]->jabatan }} @if (in_array($pejabat[$i]->id, $disposisi_kepada)) &#10003; @endif</p>
                        @endfor
                    </div>
                    <div class="col-md-6 text-uppercase">
                        @for ($i = $i; $i < count($pejabat); $i++)
                            <p class="@if (in_array($pejabat[$i]->id, $disposisi_kepada)) fw-bold @endif">{{ $i + 1 }}. {{ $pejabat[$i]->jabatan }} @if (in_array($pejabat[$i]->id, $disposisi_kepada)) &#10003; @endif</p>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 p-1 text-uppercase">
                    @for ($a = 0; $a < count($disposisi_list)/3; $a++)
                        <p class="@if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) fw-bold @endif"> {{ $a + 1 }}. {{ $disposisi_list[$a]->ur_disposisi_list }} @if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) &#10003; @endif</p>
                    @endfor
                </div>
                <div class="col-md-4 p-1 text-uppercase">
                    @for ($a = $a; $a < 2*count($disposisi_list)/3; $a++)
                        <p class="@if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) fw-bold @endif"> {{ $a + 1 }}. {{ $disposisi_list[$a]->ur_disposisi_list }} @if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) &#10003; @endif</p>
                    @endfor
                </div>
                <div class="col-md-4 p-1 text-uppercase">
                    @for ($a = $a; $a < count($disposisi_list); $a++)
                        <p class="@if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) fw-bold @endif"> {{ $a + 1 }}. {{ $disposisi_list[$a]->ur_disposisi_list }} @if (in_array($disposisi_list[$a]->id, $disposisi_list_id)) &#10003; @endif</p>
                    @endfor
                </div>
            </div>
            <div class="row mt-2">
                    <div class="col-md-2 p-1 text-uppercase">LAIN-LAIN :</div>
                    <div class="col-md-10 p-1 border">{{ $disposisi->isi }} <br><br></div>
            </div>
        </div>
        
        <div class="row mt-2">
                <div class="col-md-6">Paraf : <img src="{{ $disposisi->paraf }}" alt="Paraf" /></div>
                <div class="col-md-6"><div class="text-end">
            <p>Tgl Disposisi: {{ $disposisi->tanggal_disposisi }}</p>
        </div></div>
        </div>
                    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
