<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlasifikasiSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'ur_klasifikasi' => 'Surat Biasa', 'created_at' => '2024-07-09 12:58:51', 'updated_at' => '2024-07-09 12:58:51'],
            ['id' => 2, 'ur_klasifikasi' => 'Surat Rahasia', 'created_at' => '2024-07-09 12:59:00', 'updated_at' => '2024-07-09 12:59:00'],
            ['id' => 3, 'ur_klasifikasi' => 'Surat Edaran', 'created_at' => '2024-07-09 12:59:06', 'updated_at' => '2024-07-09 12:59:06'],
            ['id' => 4, 'ur_klasifikasi' => 'Surat Telegram', 'created_at' => '2024-07-09 12:59:15', 'updated_at' => '2024-07-09 12:59:15'],
            ['id' => 5, 'ur_klasifikasi' => 'Nota Dinas', 'created_at' => '2024-07-09 12:59:16', 'updated_at' => '2024-07-09 12:59:16'],
            // Add other rows here
        ];

        DB::table('klasifikasi_surats')->insert($data);
    }
}
