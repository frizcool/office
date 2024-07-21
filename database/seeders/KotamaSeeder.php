<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kotama;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KotamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data array yang dihasilkan dari file Excel
        $data = [
            ['kd_ktm' => '01', 'ur_ktm' => 'KODAM I/BB'],
            ['kd_ktm' => '02', 'ur_ktm' => 'KODAM II/SWJ'],
            ['kd_ktm' => '03', 'ur_ktm' => 'KODAM III/SLW'],
            ['kd_ktm' => '04', 'ur_ktm' => 'KODAM IV/DIP'],
            ['kd_ktm' => '05', 'ur_ktm' => 'KODAM V/BRW'],
            ['kd_ktm' => '06', 'ur_ktm' => 'KODAM VI/MLW'],
            ['kd_ktm' => '07', 'ur_ktm' => 'KODAM VII/WRB'],
            ['kd_ktm' => '08', 'ur_ktm' => 'KODAM XVIII/KSR'],
            ['kd_ktm' => '09', 'ur_ktm' => 'KODAM IX/UDY'],
            ['kd_ktm' => '10', 'ur_ktm' => 'KODAM IM'],
            ['kd_ktm' => '12', 'ur_ktm' => 'KODAM XII/TPR'],
            ['kd_ktm' => '13', 'ur_ktm' => 'KODAM XIII/MDK'],
            ['kd_ktm' => '14', 'ur_ktm' => 'KODAM XIV/HSN'],
            ['kd_ktm' => '15', 'ur_ktm' => 'KODAM JAYA'],
            ['kd_ktm' => '16', 'ur_ktm' => 'KODAM XVI/PTM'],
            ['kd_ktm' => '17', 'ur_ktm' => 'KODAM XVII/CEN'],
            ['kd_ktm' => '18', 'ur_ktm' => 'KOPASSUS'],
            ['kd_ktm' => '19', 'ur_ktm' => 'KOSTRAD'],
            ['kd_ktm' => '20', 'ur_ktm' => 'KODIKLATAD'],
            ['kd_ktm' => '21', 'ur_ktm' => 'PUSZIAD'],
            ['kd_ktm' => '22', 'ur_ktm' => 'PUSBEKANGAD'],
            ['kd_ktm' => '23', 'ur_ktm' => 'PUSPALAD'],
            ['kd_ktm' => '24', 'ur_ktm' => 'PUSHUBAD'],
            ['kd_ktm' => '25', 'ur_ktm' => 'PUSKESAD'],
            ['kd_ktm' => '26', 'ur_ktm' => 'DITAJENAD'],
            ['kd_ktm' => '27', 'ur_ktm' => 'DITTOPAD'],
            ['kd_ktm' => '28', 'ur_ktm' => 'DITKUAD'],
            ['kd_ktm' => '29', 'ur_ktm' => 'DITKUMAD'],
            ['kd_ktm' => '30', 'ur_ktm' => 'RSPAD GATOT SOEBROTO'],
            ['kd_ktm' => '41', 'ur_ktm' => 'DISJASAD'],
            ['kd_ktm' => '42', 'ur_ktm' => 'DISPENAD'],
            ['kd_ktm' => '43', 'ur_ktm' => 'DISBINTALAD'],
            ['kd_ktm' => '44', 'ur_ktm' => 'DISPSIAD'],
            ['kd_ktm' => '45', 'ur_ktm' => 'DISLITBANGAD'],
            ['kd_ktm' => '46', 'ur_ktm' => 'DISINFOLAHTAD'],
            ['kd_ktm' => '47', 'ur_ktm' => 'DISJARAHAD'],
            ['kd_ktm' => '48', 'ur_ktm' => 'DISLAIKAD'],
            ['kd_ktm' => '49', 'ur_ktm' => 'DISADAAD'],
            ['kd_ktm' => '61', 'ur_ktm' => 'PUSSENIF'],
            ['kd_ktm' => '62', 'ur_ktm' => 'PUSSENKAV'],
            ['kd_ktm' => '63', 'ur_ktm' => 'PUSSENARMED'],
            ['kd_ktm' => '64', 'ur_ktm' => 'PUSSENARHANUD'],
            ['kd_ktm' => '65', 'ur_ktm' => 'PUSPOMAD'],
            ['kd_ktm' => '66', 'ur_ktm' => 'PUSTERAD'],
            ['kd_ktm' => '67', 'ur_ktm' => 'PUSPENERBAD'],
            ['kd_ktm' => '68', 'ur_ktm' => 'PUSINTELAD'],
            ['kd_ktm' => '69', 'ur_ktm' => 'PUSSANSIAD'],
            ['kd_ktm' => '71', 'ur_ktm' => 'AKMIL'],
            ['kd_ktm' => '72', 'ur_ktm' => 'SESKOAD'],
            ['kd_ktm' => '73', 'ur_ktm' => 'SECAPAAD'],
            ['kd_ktm' => '81', 'ur_ktm' => 'DENMABESAD'],
            ['kd_ktm' => '82', 'ur_ktm' => 'ITJENAD'],
            ['kd_ktm' => '83', 'ur_ktm' => 'INKOPAD'],
            ['kd_ktm' => '84', 'ur_ktm' => 'BP TWP TNI AD'],
            ['kd_ktm' => '90', 'ur_ktm' => 'MABES TNI'],
            ['kd_ktm' => '91', 'ur_ktm' => 'KEMHAN RI'],
            ['kd_ktm' => '92', 'ur_ktm' => 'WANTANNAS RI'],
            ['kd_ktm' => '93', 'ur_ktm' => 'BIN'],
            ['kd_ktm' => '94', 'ur_ktm' => 'KEMENKOPOLHUKAM RI'],
            ['kd_ktm' => '95', 'ur_ktm' => 'BNPB (BASARNAS)'],
            ['kd_ktm' => '96', 'ur_ktm' => 'KEMENSETNEG RI'],
            ['kd_ktm' => '97', 'ur_ktm' => 'LEMHANNAS RI'],
            ['kd_ktm' => '98', 'ur_ktm' => 'KEMENTRIAN & LEMBAGA LAIN'],
            ['kd_ktm' => '99', 'ur_ktm' => 'TIDAK DIKETAHUI']
        ];

        // Memasukkan data ke dalam tabel kotamas
        Kotama::insert($data);
    }
}
