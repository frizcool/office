<?php

namespace App\Filament\Resources\KotamaResource\Pages;

use App\Filament\Resources\KotamaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKotamas extends ListRecords
{
    protected static string $resource = KotamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
