<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class SuratMasukSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $now = Carbon::now();

        for ($i = 1; $i <= 30; $i++) {
            $data[] = [
                'id' => (string) Str::uuid(),
                'nomor_agenda' => 'AGD/' . $i . '/VII/2024',
                'terima_dari' => $this->getDummyPejabat(),
                'nomor_surat' => 'SE/' . $i . '/VII/2024',
                'tanggal_agenda' => '2024-07-' . rand(1, 31),
                'waktu_agenda' => $now->format('H:i:s'),
                'tanggal_surat' => '2024-07-' . rand(1, 31),
                'kd_ktm' => '03',
                'kd_smk' => '4T0B',
                'perihal' => $this->getMilitarySubject(),
                'klasifikasi_id' => 3, // Assuming '3' as per your example
                'status_id' => 1,       // Assuming '1' as per your example
                'sifat_id' => 1,        // Assuming '1' as per your example
                'lampiran_surat_masuk' => '["dummy.pdf"]',
                'status' => null, // Assuming null as per your example
                'created_at' => $now,
                'updated_at' => $now,
                'lemari_id' => '7d79dfdf-c820-43f1-b91a-930367de1bc9', // Using provided value
                'loker_id' => '6925ddf6-7f65-4b90-a330-fba16f1162da',  // Using provided value
                'rak_id' => '21d72f40-ac69-4c55-ad9c-eb09ba61c54b',     // Using provided value
            ];

            // Add one second to $now for the next record
            $now->addSecond();
        }

        DB::table('surat_masuks')->insert($data);
    }

    private function getDummyPejabat()
    {
        $pejabat = [
            'KASDAM III/SLW',
            'ASLOG KASDAM III/SLW',
            'KAPENDAM III/SLW',
            'PANGDAM III/SLW',
            'ASINTEL KASDAM III/SLW',
        ];

        return $pejabat[array_rand($pejabat)];
    }

    private function getMilitarySubject()
    {
        $subjects = [
            'Instruksi Penegakan Disiplin Militer',
            'Perintah Penugasan Operasi Militer',
            'Surat Edaran Pelaksanaan Latihan Perang',
            'Laporan Hasil Operasi Militer',
            'Permohonan Persetujuan Penggunaan Senjata',
            'Pengamanan Wilayah Kodam III/SLW',
            'Pemberitahuan Kegiatan Latihan Tempur',
            'Pengadaan Logistik untuk Operasi Militer',
            'Persiapan Upacara HUT TNI',
            'Peningkatan Kesiapsiagaan Personel',
            'Penempatan Pasukan di Wilayah Strategis',
            'Koordinasi Kegiatan Intelijen Militer',
            'Evaluasi Keamanan dan Pertahanan Wilayah',
            'Pelaporan Kegiatan Operasi Khusus',
            'Permintaan Dukungan Alutsista',
            'Pengendalian Stok Amunisi dan Senjata',
            'Surat Perintah Pengamanan VIP',
            'Penugasan Tim Pengawasan dan Evaluasi',
            'Rencana Penambahan Personel Kodam III/SLW',
            'Laporan Keberhasilan Operasi Militer',
        ];

        return $subjects[array_rand($subjects)];
    }
}
