<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class SuratKeluarsSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        // Loop through each month
        for ($i = 1; $i <= 12; $i++) {
            // Generate a record for each day of the month to ensure coverage
            for ($j = 1; $j <= 2; $j++) { // You can adjust the second loop for more records per month
                $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT); // To ensure a valid date
                $month = str_pad($i, 2, '0', STR_PAD_LEFT);

                $tanggal_surat = "2024-{$month}-{$day} 08:00:00"; // Assuming the surat is created at 08:00 AM

                $data[] = [
                    'id' => (string) Str::uuid(),
                    'nomor_agenda' => 'AGDK/' . $i . '/VIII/2024',
                    'tanggal_agenda' => "2024-{$month}-{$day}",
                    'nomor_surat' => 'B/' . str_pad($i, 3, '0', STR_PAD_LEFT) . '/VIII/2024',
                    'tanggal_surat' => $tanggal_surat,
                    'kepada' => $this->getDummyKepada(),
                    'perihal' => $this->getMilitarySubject(),
                    'kd_ktm' => '03',
                    'kd_smk' => '4T0B',
                    'status' => $this->getStatus(),
                    'klasifikasi_id' => 1,
                    'lokasi_fisik' => null,
                    'lampiran_surat_keluar' => '{"' . (string) Str::uuid() . '":"dummy.pdf"}',
                    'created_by' => rand(1, 10),
                    'created_at' => $tanggal_surat, // Use tanggal_surat as created_at
                    'updated_at' => Carbon::parse($tanggal_surat)->addSeconds(rand(0, 3600))->format('Y-m-d H:i:s'), // Updated within an hour after created_at
                    'lemari_id' => '6ee610ae-0899-483c-b089-2ca8960e7771' ,
                    'loker_id' => '5098f34b-7c26-4b87-b2be-610fe30fb325' ,
                    'rak_id' => '21d72f40-ac69-4c55-ad9c-eb09ba61c54b',
                ];
            }
        }

        DB::table('surat_keluars')->insert($data);
    }

    private function getDummyKepada()
    {
        $recipients = [
            'Aspers Kasdam',
            'Aspers',
            'Aslog Kasdam',
            'Kapendam',
            'Pangdam III/SLW',
        ];

        return $recipients[array_rand($recipients)];
    }

    private function getMilitarySubject()
    {
        $subjects = [
            'Permohonan penerbitan ST Bimtek Sisfo Kodam',
            'Permohonan dukungan anggaran untuk mendukung kegiatan kunker Kasad',
            'Permohonan pengadaan logistik untuk operasi militer',
            'Instruksi penegakan disiplin militer',
            'Pengajuan laporan hasil operasi militer',
        ];

        return $subjects[array_rand($subjects)];
    }

    private function getStatus()
    {
        $statuses = ['Konsep', 'Tinjau Kembali', 'Perbaikan', 'Disetujui'];

        return $statuses[array_rand($statuses)];
    }
}
