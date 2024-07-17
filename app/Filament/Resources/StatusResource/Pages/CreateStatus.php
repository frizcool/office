<?php

namespace App\Filament\Resources\StatusResource\Pages;

use App\Filament\Resources\StatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CreateStatus extends CreateRecord
{
    protected static string $resource = StatusResource::class;
    protected function afterCreate(): void
    {
        Notification::make()
        ->title('Saved successfully')
        ->icon('heroicon-o-document-text')
        ->iconColor('success')
        ->send();
        $recipient = auth()->user();
 
        Notification::make()
            ->title('Saved successfully')
            ->sendToDatabase($recipient);
    }
}
