<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Notifications\DatabaseNotification; 
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Illuminate\Support\Facades\Auth; 
use App\Filament\Resources\UserResource;
use App\Filament\Resources\KlasifikasiSuratResource;
use App\Filament\Resources\SatminkalResource;
use App\Models\KlasifikasiSurat;
use App\Models\Satminkal;
use App\Models\User;

class StatsOverviewUtility extends BaseWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 4;
    protected function getStats(): array
    {
        $user = Auth::user();
        $totalKlasifikasiSurat = KlasifikasiSurat::count();
        $totalSatminkal = Satminkal::where('kd_ktm', $user->kd_ktm)->count();
        $totalUser = User::where('kd_ktm', $user->kd_ktm)->where('kd_smk', $user->kd_smk)->count();

        return [
            Stat::make(__('Klasifikasi Surat'), $totalKlasifikasiSurat)
                ->description('Total Klasifikasi')
                ->descriptionIcon('heroicon-m-squares-2x2') // icon KlasifikasiSurat
                ->icon('heroicon-m-squares-2x2')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success')
                ->url(KlasifikasiSuratResource::getUrl()),
            Stat::make(__('Satminkal'), $totalSatminkal)
                ->description('Total Satminkal')
                ->descriptionIcon('heroicon-m-building-office-2') // icon Satminkal
                ->icon('heroicon-m-building-office-2')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('info')
                ->url(SatminkalResource::getUrl()),
            Stat::make(__('User'), $totalUser)
                ->description('Total User')
                ->descriptionIcon('heroicon-o-user-group') // icon User
                ->icon('heroicon-o-user-group')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('warning')
                ->url(UserResource::getUrl()),
        ];
    }
}
