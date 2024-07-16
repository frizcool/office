<?php

namespace App\Filament\Resources\SuratMasukResource\Pages;

use App\Filament\Resources\SuratMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CreateSuratMasuk extends CreateRecord
{
    protected static string $resource = SuratMasukResource::class;

    protected function afterCreate(): void
    {
        /** @var Order $order */
        $order = $this->record;
        // dd($order);

        /** @var User $user */
        $user = auth()->user();

        Notification::make()
            ->title('New order')
            ->icon('heroicon-o-shopping-bag')
            ->body("**Nomor Agenda : {$order->nomor_agenda}  Perihal : {$order->perihal}.**")
            ->actions([
                Action::make('View')
                    ->url(SuratMasukResource::getUrl('edit', ['record' => $order])),
            ])
            ->sendToDatabase($user);
    }
}
