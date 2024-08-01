<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Support\Facades\DB;

class LetterChart extends ChartWidget
{
    protected static ?string $heading = 'Surat Masuk dan Keluar';

    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        $currentYear = now()->year;

        // Ambil data jumlah surat masuk per bulan dengan strftime untuk SQLite
        $suratMasuk = SuratMasuk::select(
                DB::raw('strftime(\'%m\', created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Ambil data jumlah surat keluar per bulan dengan strftime untuk SQLite
        $suratKeluar = SuratKeluar::select(
                DB::raw('strftime(\'%m\', created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Label bulan
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $suratMasukData = [];
        $suratKeluarData = [];

        // Mengisi data bulanan
        for ($month = 1; $month <= 12; $month++) {
            // Mengubah month menjadi format dua digit ('01', '02', ...)
            $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);
            $suratMasukData[] = $suratMasuk[$monthFormatted] ?? 0;
            $suratKeluarData[] = $suratKeluar[$monthFormatted] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Surat Masuk',
                    'data' => $suratMasukData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
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
