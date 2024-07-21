<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisposisiListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'ur_disposisi_list' => 'ACC', 'created_at' => '2024-07-12 06:01:13', 'updated_at' => '2024-07-12 06:01:13'],
            ['id' => 2, 'ur_disposisi_list' => 'ACARAKAN', 'created_at' => '2024-07-12 06:01:18', 'updated_at' => '2024-07-12 06:01:18'],
            ['id' => 3, 'ur_disposisi_list' => 'BANTU', 'created_at' => '2024-07-12 06:01:24', 'updated_at' => '2024-07-12 06:01:24'],
            ['id' => 4, 'ur_disposisi_list' => 'BALAS', 'created_at' => '2024-07-12 06:01:30', 'updated_at' => '2024-07-12 06:01:30'],
            ['id' => 5, 'ur_disposisi_list' => 'CATAT', 'created_at' => '2024-07-12 06:01:34', 'updated_at' => '2024-07-12 06:01:34'],
            ['id' => 6, 'ur_disposisi_list' => 'HADIR', 'created_at' => '2024-07-12 06:01:40', 'updated_at' => '2024-07-12 06:01:40'],
            ['id' => 7, 'ur_disposisi_list' => 'TIDAK HADIR', 'created_at' => '2024-07-12 06:01:47', 'updated_at' => '2024-07-12 06:01:47'],
            ['id' => 8, 'ur_disposisi_list' => 'WAKILI', 'created_at' => '2024-07-12 06:01:54', 'updated_at' => '2024-07-12 06:01:54'],
            ['id' => 9, 'ur_disposisi_list' => 'PELAJARI DAN TELITI', 'created_at' => '2024-07-12 06:02:07', 'updated_at' => '2024-07-12 06:02:07'],
            ['id' => 10, 'ur_disposisi_list' => 'TANGGAPAN DAN SARAN', 'created_at' => '2024-07-12 06:02:25', 'updated_at' => '2024-07-12 06:02:25'],
            ['id' => 11, 'ur_disposisi_list' => 'SEBAGAI BAHAN', 'created_at' => '2024-07-12 06:02:34', 'updated_at' => '2024-07-12 06:02:34'],
            ['id' => 12, 'ur_disposisi_list' => 'TINDAK LANJUTI', 'created_at' => '2024-07-12 06:02:43', 'updated_at' => '2024-07-12 06:02:43'],
            ['id' => 13, 'ur_disposisi_list' => 'SIAPKAN', 'created_at' => '2024-07-12 06:02:48', 'updated_at' => '2024-07-12 06:02:48'],
            ['id' => 14, 'ur_disposisi_list' => 'UMP', 'created_at' => '2024-07-12 06:02:52', 'updated_at' => '2024-07-12 06:02:52'],
            ['id' => 15, 'ur_disposisi_list' => 'UDK', 'created_at' => '2024-07-12 06:02:55', 'updated_at' => '2024-07-12 06:02:55'],
            ['id' => 16, 'ur_disposisi_list' => 'UDL', 'created_at' => '2024-07-12 06:02:59', 'updated_at' => '2024-07-12 06:02:59'],
            ['id' => 17, 'ur_disposisi_list' => 'IKUTI PERKEMBANGANNYA', 'created_at' => '2024-07-12 06:03:12', 'updated_at' => '2024-07-12 06:03:12'],
            ['id' => 18, 'ur_disposisi_list' => 'LAPORKAN HASILNYA', 'created_at' => '2024-07-12 06:03:21', 'updated_at' => '2024-07-12 06:03:21'],
            ['id' => 19, 'ur_disposisi_list' => 'INFOKAN KE ANGGOTA', 'created_at' => '2024-07-12 06:03:32', 'updated_at' => '2024-07-12 06:03:32'],
            ['id' => 20, 'ur_disposisi_list' => 'KOORDINASI', 'created_at' => '2024-07-12 06:03:40', 'updated_at' => '2024-07-12 06:03:40'],
            ['id' => 21, 'ur_disposisi_list' => 'BUATKAN UCAPAN', 'created_at' => '2024-07-12 06:03:50', 'updated_at' => '2024-07-12 06:03:50'],
            ['id' => 22, 'ur_disposisi_list' => 'SELESAIKAN', 'created_at' => '2024-07-12 06:03:57', 'updated_at' => '2024-07-12 06:03:57'],
            ['id' => 23, 'ur_disposisi_list' => 'DUKUNG', 'created_at' => '2024-07-12 06:04:03', 'updated_at' => '2024-07-12 06:04:03'],
            ['id' => 24, 'ur_disposisi_list' => 'ARSIP', 'created_at' => '2024-07-12 06:04:08', 'updated_at' => '2024-07-12 06:04:08'],
        ];

        DB::table('disposisi_lists')->insert($data);
    }
}
