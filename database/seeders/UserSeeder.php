<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Define the users data
        $users = [
            ['name' => 'FRIS WARDANI', 'email' => 'support@frideoo.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Super Admin'],
            ['name' => 'Kainfo', 'email' => 'kainfo@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Kainfolahtadam'],
            ['name' => 'Waka Infolahta', 'email' => 'waka@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Waka Infolahtadam III/Slw'],
            ['name' => 'Kasi TUUD', 'email' => 'tuud@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Kasi Tuud'],
            ['name' => 'Kasi Matsisfo', 'email' => 'matsisfo@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Kasi Matsisfo'],
            ['name' => 'Kasi Duklahta', 'email' => 'duklahta@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Kasi Duklahta'],
            ['name' => 'Kasi Sisfomin', 'email' => 'sisfomin@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Kasi Sisfomin'],
            ['name' => 'Kasi Sisfoops', 'email' => 'sisfoops@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Kasi Sisfoops'],
            ['name' => 'Katim Multimedia', 'email' => 'multimedia@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Katim Multimedia'],
            ['name' => 'Katimbekharlap', 'email' => 'bekharlap@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Katimbekharlap'],
            ['name' => 'Tata Usaha', 'email' => 'tu@mail.com', 'password' => Hash::make('password'), 'lang' => 'id', 'kd_ktm' => '03', 'kd_smk' => '4T0B', 'jabatan' => 'Tata Usaha'],
            [
                'name' => 'Karunal Sisfomin',
                'email' => 'kaursisfomin@mail.com',
                'password' => Hash::make('password'),
                'lang' => 'id',
                'kd_ktm' => '03',
                'kd_smk' => '4T0B',
                'jabatan' => 'Karunal Sisfomin',
            ],
            [
                'name' => 'Kaurnal Sisfoops',
                'email' => 'kaurnalsisfoops@mail.com',
                'password' => Hash::make('password'),
                'lang' => 'id',
                'kd_ktm' => '03',
                'kd_smk' => '4T0B',
                'jabatan' => 'Kaurnal Sisfoops',
            ],
            [
                'name' => 'Kaur Siaplahta',
                'email' => 'kaursiaplahta@mail.com',
                'password' => Hash::make('password'),
                'lang' => 'id',
                'kd_ktm' => '03',
                'kd_smk' => '4T0B',
                'jabatan' => 'Kaur Siaplahta Siduklahta',
            ],
            [
                'name' => 'Kaurrenperslog',
                'email' => 'kaurrenperslog@mail.com',
                'password' => Hash::make('password'),
                'lang' => 'id',
                'kd_ktm' => '03',
                'kd_smk' => '4T0B',
                'jabatan' => 'Kaurrenperslog Situud',
            ],
            [
                'name' => 'Kaurdal',
                'email' => 'kaurdal@mail.com',
                'password' => Hash::make('password'),
                'lang' => 'id',
                'kd_ktm' => '03',
                'kd_smk' => '4T0B',
                'jabatan' => 'Kaurdal TUUD',
            ],
            
        ];

        // Use upsert to avoid unique constraint violation
        DB::table('users')->upsert($users, ['email'], ['name', 'password', 'lang', 'kd_ktm', 'kd_smk', 'jabatan', 'updated_at']);

        // Assign roles to users
        foreach ($users as $user) {
            $createdUser = User::where('email', $user['email'])->first();
            if ($user['jabatan'] === 'Super Admin') {
                $createdUser->assignRole('super_admin');
            }
        }
    }
}
