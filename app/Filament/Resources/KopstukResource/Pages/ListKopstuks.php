<?php

namespace App\Filament\Resources\KopstukResource\Pages;

use App\Filament\Resources\KopstukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKopstuks extends ListRecords
{
    protected static string $resource = KopstukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
