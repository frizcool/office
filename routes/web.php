<?php

use Illuminate\Support\Facades\Route;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use App\Http\Controllers\DispositionController; 

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/disposisi/{id}/print', [DispositionController::class, 'print'])->name('disposisi.print');

Route::get('test', function() {
    $recipient = auth()->user();
    
    if ($recipient) {
        Notification::make()
            ->title('Saved successfully')
            ->sendToDatabase($recipient);
        dd('Notification sent and saved to database.');
    } else {
        dd('No authenticated user found.');
    }
});