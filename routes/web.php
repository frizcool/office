<?php

use Illuminate\Support\Facades\Route;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use App\Http\Controllers\DispositionController; 

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/disposisi/{id}/print', [DispositionController::class, 'print'])->name('disposisi.print');
Route::get('/disposisi/{id}/print_v2', [DispositionController::class, 'print_v2'])->name('disposisi.print_v2');


 

// Route::get('test', function() {
//     $recipient = auth()->user();
 
//     $recipient->notify(
//         Notification::make()
//             ->title('Saved successfully')
//             ->toDatabase(),
//     );
// });