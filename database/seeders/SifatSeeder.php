<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sifat;

class SifatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['ur_sifat' => 'Biasa'],
            ['ur_sifat' => 'Segera'],
            ['ur_sifat' => 'Kilat'],
        ];
        
        // Memasukkan data ke dalam tabel users
        Sifat::insert($data);
    }
}
