<?php
namespace App\Filament\Resources\SuratKeluarResource\Pages;

use App\Filament\Resources\SuratKeluarResource;
use App\Models\SuratKeluar;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewSuratKeluar extends ViewRecord
{
    protected static string $resource = SuratKeluarResource::class;

    public function getTitle(): string | Htmlable
    {
        /** @var Post */
        $record = $this->getRecord();

        return $record->nomor_agenda;
    }

    protected function getActions(): array
    {
        return [];
    }
}