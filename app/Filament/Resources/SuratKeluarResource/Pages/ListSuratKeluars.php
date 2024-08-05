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
            null => Tab::make('All')
                ->icon('heroicon-o-document-text'),
            'Konsep' => Tab::make()
                ->query(fn ($query) => $query->where('status', 'Konsep'))
                ->icon('heroicon-o-pencil'),
            'Tinjau Kembali' => Tab::make()
                ->query(fn ($query) => $query->where('status', 'Tinjau Kembali'))
                ->icon('heroicon-o-eye'),
            'Perbaikan' => Tab::make()
                ->query(fn ($query) => $query->where('status', 'Perbaikan'))
                ->icon('heroicon-s-arrow-path-rounded-square'),
            'Disetujui' => Tab::make()
                ->query(fn ($query) => $query->where('status', 'Disetujui'))
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
