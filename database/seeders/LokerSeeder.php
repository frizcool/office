<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LokerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => Str::uuid(), 'nama_loker' => 'Loker 1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'nama_loker' => 'Loker 2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'nama_loker' => 'Loker 3', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('lokers')->insert($data);
    }
}
