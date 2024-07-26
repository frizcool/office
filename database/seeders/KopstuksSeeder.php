<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KopstuksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1, 
                'ur_kopstuk' => 'KOMANDO DAERAH MILITER III/SILIWANGI INFORMASI DAN PENGOLAHAN DATA', 
                'kd_ktm' => '03', 
                'kd_smk' => '4T0B', 
                'created_at' => '2024-07-14 00:38:53', 
                'updated_at' => '2024-07-14 01:47:14'
            ],
            // Add other rows here
        ];

        DB::table('kopstuks')->insert($data);
    }
}
