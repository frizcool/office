<?php

namespace App\Filament\Resources\KotamaResource\Pages;

use App\Filament\Resources\KotamaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKotama extends CreateRecord
{
    protected static string $resource = KotamaResource::class;
    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
            // Actions\CreateAction::make(),
        ];
    }
}
