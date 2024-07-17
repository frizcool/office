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
    // protected function afterCreate(): void
    // {
    //     $user = auth()->user();
 
    //     /** @var Order $order */
    //     $order = $this->record;
    //     // dd($order);
    //     Notification::make()
    //         ->title(__('notifications.new_incoming_letter'))
    //         ->icon('heroicon-c-inbox-arrow-down')
    //         ->body(
    //             "<b>" . __('notifications.number_agenda') . ":</b> {$order->ur_status} <br>" 
    //         )
    //         ->actions([
    //             Action::make(__('notifications.view'))
    //                 ->url(''),
    //         ])
    //         ->sendToDatabase($user);
    // }
}
