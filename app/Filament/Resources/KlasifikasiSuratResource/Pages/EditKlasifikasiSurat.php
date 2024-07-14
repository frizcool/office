<?php

namespace App\Filament\Resources\KlasifikasiSuratResource\Pages;

use App\Filament\Resources\KlasifikasiSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKlasifikasiSurat extends EditRecord
{
    protected static string $resource = KlasifikasiSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
