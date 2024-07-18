<?php

namespace App\Filament\Resources\SuratMasukResource\Pages;

use App\Filament\Resources\SuratMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Role;
use App\Models\User;

class CreateSuratMasuk extends CreateRecord
{
    protected static string $resource = SuratMasukResource::class;

    protected function afterCreate(): void
    {

         /** @var Order $data */
         $data = $this->record;

         /** @var User $user */
         $user = auth()->user();
 
         // Get all users with the 'eselon_pimpinan' role
         $pimpinanUsers = User::role('eselon_pimpinan')->get();
 

         foreach ($pimpinanUsers as $pimpinanUser) {
             Notification::make()
                 ->title(__('notifications.new_incoming_letter'))
                 ->icon('heroicon-c-inbox-arrow-down')
                 ->body(
                     "<b>" . __('notifications.letter_from') . ":</b> {$data->terima_dari} <br>" .
                     "<b>" . __('notifications.number_letter') . ":</b> {$data->nomor_surat} <br>" .
                     "<b>" . __('notifications.subject') . ":</b> {$data->perihal}"
                 )
                 ->actions([
                     Action::make(__('notifications.view'))
                         ->url(SuratMasukResource::getUrl('edit', ['record' => $data]))
                         ->markAsRead(),
                 ])
                 ->sendToDatabase($pimpinanUser);
         }
        
        Notification::make()
            ->title(__('notifications.save_success'))
            ->icon('heroicon-o-check')
            ->body(
                "<b>" . __('notifications.number_agenda') . ":</b> {$data->nomor_agenda} <br>" 
            )
            ->actions([
                Action::make(__('notifications.view'))
                    ->url(SuratMasukResource::getUrl('edit', ['record' => $data])),
            ])
            ->sendToDatabase($user);
    }
}
