<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LemariSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => Str::uuid(), 'nama_lemari' => 'Lemari A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'nama_lemari' => 'Lemari B', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'nama_lemari' => 'Lemari C', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('lemaris')->insert($data);
    }
}
