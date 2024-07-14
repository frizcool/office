<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\DispositionController;

Route::get('/disposisi/{id}/print', [DispositionController::class, 'print'])->name('disposisi.print');
