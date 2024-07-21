<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                
                'name' => 'super_admin',
                'guard_name' => 'web',
                'created_at' => '2024-07-04 13:55:12',
                'updated_at' => '2024-07-12 14:59:39'
            ],
            [
                
                'name' => 'eselon_pimpinan',
                'guard_name' => 'web',
                'created_at' => '2024-07-12 04:40:57',
                'updated_at' => '2024-07-12 14:59:56'
            ],
            [
                
                'name' => 'eselon_pembantu_pimpinan',
                'guard_name' => 'web',
                'created_at' => '2024-07-12 04:41:27',
                'updated_at' => '2024-07-12 15:00:31'
            ],
            [
                
                'name' => 'eselon_pelaksana',
                'guard_name' => 'web',
                'created_at' => '2024-07-12 04:42:00',
                'updated_at' => '2024-07-12 15:01:09'
            ],
            [
                
                'name' => 'TU',
                'guard_name' => 'web',
                'created_at' => '2024-07-12 10:42:35',
                'updated_at' => '2024-07-12 15:01:25'
            ],
        ]);
    }
}