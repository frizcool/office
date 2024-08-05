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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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


        $oneYearAgo = Carbon::now()->subYear()->startOfMonth()->toDateString();

        // Menghitung jumlah surat masuk per bulan dalam satu tahun terakhir
        $suratMasukChart = SuratMasuk::select(DB::raw('strftime("%m", created_at) as month, COUNT(*) as count'))
            ->where('kd_ktm', $user->kd_ktm)
            ->where('kd_smk', $user->kd_smk)
            ->where('created_at', '>=', $oneYearAgo)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Menghitung jumlah surat keluar per bulan dalam satu tahun terakhir
        $suratKeluarChart = SuratKeluar::select(DB::raw('strftime("%m", created_at) as month, COUNT(*) as count'))
            ->where('kd_ktm', $user->kd_ktm)
            ->where('kd_smk', $user->kd_smk)
            ->where('created_at', '>=', $oneYearAgo)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Menghitung jumlah notifikasi per bulan dalam satu tahun terakhir
        $notificationsChart = DatabaseNotification::select(DB::raw('strftime("%m", created_at) as month, COUNT(*) as count'))
            // ->where('notifiable_id', $user->id)
            // ->where('notifiable_type', get_class($user))
            ->where('created_at', '>=', $oneYearAgo)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Menyiapkan array chart dengan 12 bulan
        $chartData = array_fill(1, 12, 0);

        // Memasukkan data ke array chart sesuai bulan
        $suratMasukChartData = $chartData;
        foreach ($suratMasukChart as $month => $count) {
            $suratMasukChartData[intval($month)] = $count;
        }
                                               
        $suratKeluarChartData = $chartData;
        foreach ($suratKeluarChart as $month => $count) {
            $suratKeluarChartData[intval($month)] = $count;
        }

        $notificationsChartData = $chartData;
        foreach ($notificationsChart as $month => $count) {
            $notificationsChartData[intval($month)] = $count;
        }

        return [
            Stat::make(__('notifications.new_disposisi'), $totalNotifications)
                ->description('Total Notifikasi')
                ->descriptionIcon('heroicon-o-bell')
                ->icon('heroicon-o-bell')
                ->color('success')                   
                ->chart($notificationsChartData)
                ->extraAttributes([
                    'x-data' => '{}',
                    'x-on:click' => "\$dispatch('open-modal', { id: 'database-notifications' })"
                ]), // Event onclick untuk membuka notifikasi,

            Stat::make('Pesan Belum Dibaca', $unreadNotificationsCount)
                ->description('Notifikasi belum dibaca')
                ->descriptionIcon('heroicon-o-envelope-open')
                ->icon('heroicon-o-envelope-open')
                ->color('info')  
                ->chart($notificationsChartData)
                ->extraAttributes([
                    'x-data' => '{}',
                    'x-on:click' => "\$dispatch('open-modal', { id: 'database-notifications' })"
                ]),
            Stat::make(__('global.label_incoming_letter'), $totalSuratMasuk)
                ->description('Jumlah surat masuk')
                ->descriptionIcon('heroicon-o-arrow-down-circle') // Ikon untuk surat masuk
                ->icon('heroicon-o-inbox') // Ikon untuk surat masuk
                ->color('warning')                
                ->chart($suratMasukChartData)
                ->url(SuratMasukResource::getUrl()),

            Stat::make(__('global.label_outgoing_letter'), $totalSuratKeluar)
                ->description('Jumlah surat keluar')
                ->descriptionIcon('heroicon-o-arrow-up-circle') // Ikon untuk surat keluar
                ->icon('heroicon-o-paper-airplane') // Ikon untuk surat keluar                                
                ->chart($suratKeluarChartData)
                ->color('danger'),
        ];
    }
}
