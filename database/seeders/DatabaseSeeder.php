<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call individual seeders
        $this->call([
            StatusSeeder::class,
            RolesSeeder::class,
            UserSeeder::class,
            KotamaSeeder::class,
            SatminkalSeeder::class,
            SifatSeeder::class,
            UserSeeder::class,
            DisposisiListSeeder::class, 
            KlasifikasiSuratSeeder::class,
            KopstuksSeeder::class,
            LemariSeeder::class,
            LokerSeeder::class,
            RakSeeder::class,
            // RoleHasPermissionsSeeder::class,
            // Add other seeders here
        ]);
    }
}
