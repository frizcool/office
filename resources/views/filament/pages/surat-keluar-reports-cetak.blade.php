<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* margin-top: 20px; */
        }
        @page { 
            margin-top: 70px; 
            margin-bottom: 50px;
        }

        /* Page number positioning */
        @page {
            @bottom-right {
                content: counter(page);
                /* font-size: 12px; */
                margin-right: 20px;
            }
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
    <!-- Kop surat -->
    <div class="text-center" style="width:48%;border-bottom: 1px solid black;">
            {!! nl2br(e($kopstuk->ur_kopstuk)) !!}
    </div>
    <br>
    <h4 class="text-center">Laporan Surat Keluar</h4>
    
@php
\Carbon\Carbon::setLocale('id');
@endphp
    <table border="1" cellpadding="3" cellspacing="0">
        <thead>
            <tr>
                <th>Nomor Agenda</th>
                <th>Nomor Surat</th>
                <th>Tanggal Surat</th>
                <th>Kepada</th>
                <th>Perihal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratKeluar as $surat)
                <tr>
                    <td>{{ $surat->nomor_agenda }}</td>
                    <td>{{ $surat->nomor_surat }}</td>
                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</td>
                    <td>{{ $surat->kepada }}</td>
                    <td>{{ $surat->perihal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Page number footer -->
    <script type="text/php">
    if (isset($pdf)) {
        $pdf->page_script('
            if ($PAGE_COUNT > 1 && $PAGE_NUM > 1) {
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $size = 12;
                $pageText = $PAGE_NUM ;
                $y = 15;
                $x = ($pdf->get_width() - $fontMetrics->getTextWidth($pageText, $font, $size)) / 2;
                $pdf->text($x, $y, $pageText, $font, $size);
            }
        ');
    }
</script>


</body>
</html>
