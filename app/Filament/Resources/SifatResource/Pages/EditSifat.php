<?php

namespace App\Filament\Resources\SifatResource\Pages;

use App\Filament\Resources\SifatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSifat extends EditRecord
{
    protected static string $resource = SifatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
