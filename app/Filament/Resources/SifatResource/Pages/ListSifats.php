<?php

namespace App\Filament\Resources\SifatResource\Pages;

use App\Filament\Resources\SifatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSifats extends ListRecords
{
    protected static string $resource = SifatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
