<?php

namespace App\Filament\Resources\SatminkalResource\Pages;

use App\Filament\Resources\SatminkalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSatminkals extends ListRecords
{
    protected static string $resource = SatminkalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
