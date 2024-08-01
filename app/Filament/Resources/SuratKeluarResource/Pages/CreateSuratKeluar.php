<?php

namespace App\Filament\Resources\SuratKeluarResource\Pages;

use App\Filament\Resources\SuratKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSuratKeluar extends CreateRecord
{
    protected static string $resource = SuratKeluarResource::class;
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Set the status to Draft before creating the record.
    //     $data['status'] = 'Draft';

    //     return $data;
    // }
}
