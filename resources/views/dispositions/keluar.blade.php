<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Disposisi Surat Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .container {
            /* margin-top: 10px; */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .signature {
            margin-top: 20px;
        }
        .text-center {
            text-align: center;
        }

    </style>
</head>
@php

use Carbon\Carbon;
    $tanggal_surat = Carbon::parse($suratKeluar->tanggal_surat)->format('d-m-Y');
    $tanggal_agenda = Carbon::parse($suratKeluar->tanggal_agenda)->format('d-m-Y');
@endphp
<body>
    <!-- <h1>Disposisi Surat Keluar</h1> -->
    <div class="container">
    <div class="text-center" style="width:50%;border-bottom: 1px solid black;">
            {!! nl2br(e($kopstuk->ur_kopstuk)) !!}
        </div>
        <br>
        <br>

        <div class="text-center">
            <strong style="border-bottom: 1px solid black; width: 35%;">LEMBAR DISPOSISI</strong><br>
            <!-- <hr class="centered-hr">    -->
            <strong>Nomor Agenda</strong>: {{ $suratKeluar->nomor_agenda }}
        </div>
        <br><br>
        <table>
            <tr>
                <th>Nomor Surat</th>
                <td>{{ $suratKeluar->nomor_surat }}</td>
            </tr>
            <tr>
                <th>Perihal</th>
                <td>{{ $suratKeluar->perihal }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ $tanggal_surat }}</td>
            </tr>
            <tr>
                <th>Pengirim</th>
                <td>{{ $disposisi->user->name }}</td>
            </tr>
            <tr>
                <th>Tujuan</th>
                <td>{{ $disposisi->to->name }}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>{{ $disposisi->keterangan }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $disposisi->status }}</td>
            </tr>
        </table>
        <div class="signature">
            <label>Paraf:</label>
            @if($disposisi->paraf)
                <img src="{{ $disposisi->paraf }}" alt="Paraf" style="max-width: 100px;" />
            @else
                <p>Belum ada paraf.</p>
            @endif
        </div>
    </div>
</body>
</html>
