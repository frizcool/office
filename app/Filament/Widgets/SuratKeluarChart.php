<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SuratKeluar;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth; // Import Auth untuk mendapatkan pengguna yang login
class SuratKeluarChart extends ChartWidget
{
    protected static ?string $heading = 'Surat Keluar';

    protected static ?int $sort = 3;
    // protected static ?string $maxHeight = '300px';
    // protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        $user = Auth::user();
        $currentYear = now()->year;

        // Ambil data jumlah surat Keluar per bulan dengan strftime untuk SQLite
        $suratKeluar = SuratKeluar::select(
                DB::raw('strftime(\'%m\', created_at) as month'),
                DB::raw('count(*) as count')
            )

            ->where('kd_ktm', $user->kd_ktm)
            ->where('kd_smk', $user->kd_smk)
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

  
        // Label bulan
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $suratKeluarData = [];

        // Mengisi data bulanan
        for ($month = 1; $month <= 12; $month++) {
            // Mengubah month menjadi format dua digit ('01', '02', ...)
            $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);
            $suratKeluarData[] = $suratKeluar[$monthFormatted] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Surat Keluar',
                    'data' => $suratKeluarData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';  // Menampilkan data dalam bentuk grafik garis
    }
}
