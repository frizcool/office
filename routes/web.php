<?php

use Illuminate\Support\Facades\Route;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use App\Http\Controllers\DispositionController; 
use App\Filament\Pages\SuratMasukReports;
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('disposisi/keluar/{id}', [DispositionController::class, 'generateDisposisiKeluar'])->name('disposisi.keluar');
Route::get('/disposisi/export-pdf/{id}', [DispositionController::class, 'exportPdf'])->name('disposisi.exportPdf');
Route::get('/disposisi/{id}/print', [DispositionController::class, 'print'])->name('disposisi.print');
Route::get('/disposisi/{id}/print_v2', [DispositionController::class, 'print_v2'])->name('disposisi.print_v2');

Route::get('/surat-masuk-reports/cetak', [DispositionController::class, 'cetak'])->name('surat-masuk-reports.cetak');
Route::get('/surat-keluar-reports/cetak_keluar', [DispositionController::class, 'cetak_keluar'])->name('surat-keluar-reports.cetak_keluar');
// Route::get('/surat-keluar-reports/cetak_surat_masuk', [DispositionController::class, 'cetak_surat_keluar'])->name('disposisi.cetak_surat_keluar');


 

// Route::get('test', function() {
//     $recipient = auth()->user();
 
//     $recipient->notify(
//         Notification::make()
//             ->title('Saved successfully')
//             ->toDatabase(),
//     );
// });