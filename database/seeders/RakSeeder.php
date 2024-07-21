<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RakSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => Str::uuid(), 'nama_rak' => 'Rak A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'nama_rak' => 'Rak B', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'nama_rak' => 'Rak C', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('raks')->insert($data);
    }
}
