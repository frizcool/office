<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Notifications\DatabaseNotification; // Import model notifikasi
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Illuminate\Support\Facades\Auth; // Import Auth untuk mendapatkan pengguna yang login
use App\Filament\Resources\SuratKeluarResource;
use App\Filament\Resources\SuratMasukResource;


class StatsOverview extends BaseWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        
       // Mendapatkan pengguna yang sedang login
       $user = Auth::user();
        // Menghitung jumlah surat masuk
        $totalSuratMasuk = SuratMasuk::where('kd_ktm', $user->kd_ktm)->where('kd_smk', $user->kd_smk)->count();

        // Menghitung jumlah surat keluar
        $totalSuratKeluar = SuratKeluar::where('kd_ktm', $user->kd_ktm)->where('kd_smk', $user->kd_smk)->count();



       // Menghitung jumlah semua notifikasi untuk pengguna yang sedang login
       $totalNotifications = DatabaseNotification::where('notifiable_id', $user->id)
                                                 ->where('notifiable_type', get_class($user))
                                                 ->count();

       // Menghitung jumlah notifikasi yang belum dibaca untuk pengguna yang sedang login
       $unreadNotificationsCount = DatabaseNotification::where('notifiable_id', $user->id)
                                                       ->where('notifiable_type', get_class($user))
                                                       ->whereNull('read_at')
                                                       ->count();

        return [
            Stat::make(__('notifications.new_disposisi'), $totalNotifications)
                ->description('Total Notifikasi')
                ->descriptionIcon('heroicon-o-bell')
                ->icon('heroicon-o-bell')
                ->color('success')   
                // ->url('#') // URL tidak digunakan, namun diperlukan untuk event listener
                ->extraAttributes([
                    'x-data' => '{}',
                    'x-on:click' => "\$dispatch('open-modal', { id: 'database-notifications' })"
                ]), // Event onclick untuk membuka notifikasi,

            Stat::make('PESAN BELUM DIBACA', $unreadNotificationsCount)
                ->description('Notifikasi belum dibaca')
                ->descriptionIcon('heroicon-o-envelope-open')
                ->icon('heroicon-o-envelope-open')
                ->color('info')  
                ->extraAttributes([
                    'x-data' => '{}',
                    'x-on:click' => "\$dispatch('open-modal', { id: 'database-notifications' })"
                ]),
            Stat::make(__('global.label_incoming_letter'), $totalSuratMasuk)
                ->description('Jumlah surat masuk')
                ->descriptionIcon('heroicon-o-arrow-down-circle') // Ikon untuk surat masuk
                ->icon('heroicon-o-inbox') // Ikon untuk surat masuk
                ->color('warning')
                ->url(SuratMasukResource::getUrl()),

            Stat::make(__('global.label_outgoing_letter'), $totalSuratKeluar)
                ->description('Jumlah surat keluar')
                ->descriptionIcon('heroicon-o-arrow-up-circle') // Ikon untuk surat keluar
                ->icon('heroicon-o-paper-airplane') // Ikon untuk surat keluar
                ->color('danger'),
        ];
    }
}
