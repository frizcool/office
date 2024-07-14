<?php

namespace App\Filament\Resources\SatminkalResource\Pages;

use App\Filament\Resources\SatminkalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSatminkal extends CreateRecord
{
    protected static string $resource = SatminkalResource::class; 
    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
            // Actions\CreateAction::make(),
        ];
    }
}
