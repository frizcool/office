<?php

namespace App\Filament\Resources\SuratMasukResource\Pages;

use App\Filament\Resources\SuratMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListSuratMasuks extends ListRecords
{
    protected static string $resource = SuratMasukResource::class;
    
    protected function getHeaderActions(): array
    {
        $currentUser = Auth::user();
        return [
            Actions\CreateAction::make()
            ->visible(fn() => $currentUser->hasRole(['super_admin', 'TU'])),
        ];
    }
}
