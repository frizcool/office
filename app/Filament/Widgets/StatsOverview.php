<?php
 
namespace App\Filament\Widgets;
 
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
 
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
class StatsOverview extends BaseWidget
{
    
    use HasWidgetShield;
    protected function getStats(): array
    {
        return [
            Stat::make('KONFIRMASI DISPOSISI', '12'),
            Stat::make('DISPOSISI', '1'),
            Stat::make('SURAT MASUK', '11'),
            Stat::make('SURAT KELUAR', '21'),
        ];
    }
}