<?php

namespace App\Filament\Resources\SuratKeluarResource\Pages;

use App\Filament\Resources\SuratKeluarResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListSuratKeluars extends ListRecords
{
    protected static string $resource = SuratKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return SuratKeluarResource::getWidgets();
    }
    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'Konsep' => Tab::make()->query(fn ($query) => $query->where('status', 'Konsep')),
            'Tinjau Kembali' => Tab::make()->query(fn ($query) => $query->where('status', 'Tinjau Kembali')),
            'Perbaikan' => Tab::make()->query(fn ($query) => $query->where('status', 'Perbaikan')),
            'Disetujui' => Tab::make()->query(fn ($query) => $query->where('status', 'Disetujui')),
        ];

    }
}
