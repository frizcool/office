<?php
namespace App\Filament\Resources\SuratMasukResource\Pages;

use App\Filament\Resources\SuratMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use App\Models\KlasifikasiSurat;

class ListSuratMasuks extends ListRecords
{
    protected static string $resource = SuratMasukResource::class;
    
    protected function getHeaderActions(): array
    {
        $currentUser = Auth::user();
        return [
            Actions\CreateAction::make()
                ->visible(fn() => $currentUser->hasRole(['super_admin', 'TU'])),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return SuratMasukResource::getWidgets();
    }

    public function getTabs(): array
    {
        $tabs = [
            null => Tab::make('All')->query(fn ($query) => $query), // Default tab to show all records
        ];

        $klasifikasies = KlasifikasiSurat::all()->pluck('ur_klasifikasi');

        foreach ($klasifikasies as $klasifikasi) {
            $tabs[$klasifikasi] = Tab::make()->query(fn ($query) => $query->where('klasifikasi_id', $klasifikasi));
        }

        return $tabs;
    }
}
