<?php

namespace App\Filament\Resources\DisposisiListResource\Pages;

use App\Filament\Resources\DisposisiListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDisposisiLists extends ListRecords
{
    protected static string $resource = DisposisiListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
