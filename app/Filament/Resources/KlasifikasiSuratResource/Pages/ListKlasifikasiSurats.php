<?php

namespace App\Filament\Resources\KlasifikasiSuratResource\Pages;

use App\Filament\Resources\KlasifikasiSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKlasifikasiSurats extends ListRecords
{
    protected static string $resource = KlasifikasiSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
