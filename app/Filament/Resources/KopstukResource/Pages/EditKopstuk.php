<?php

namespace App\Filament\Resources\KopstukResource\Pages;

use App\Filament\Resources\KopstukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKopstuk extends EditRecord
{
    protected static string $resource = KopstukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
