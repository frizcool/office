<?php

namespace App\Filament\Resources\DisposisiListResource\Pages;

use App\Filament\Resources\DisposisiListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDisposisiList extends EditRecord
{
    protected static string $resource = DisposisiListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
