<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['ur_status' => 'Asli'],
            ['ur_status' => 'Tembusan'],
        ];
        
        // Memasukkan data ke dalam tabel users
        Status::insert($data);
    }
}
