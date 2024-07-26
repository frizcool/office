<?php

namespace App\Filament\Resources\SuratMasukResource\Pages;

use App\Filament\Resources\SuratMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSuratMasuk extends EditRecord
{
    protected static string $resource = SuratMasukResource::class;

    protected function getHeaderActions(): array
    {
        
        $currentUser = Auth::user();
        return [
            Actions\DeleteAction::make()
            ->visible(fn() => $currentUser->hasRole(['super_admin', 'TU']))    
            ,
        ];
    }
}
