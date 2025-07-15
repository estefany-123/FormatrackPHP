<?php

use App\Http\Controllers\SedesController;
use Illuminate\Support\Facades\Route;


Route::post('/sedes', [SedesController::class, 'store'])->name('sedes.store');
Route::get('/sedes', [SedesController::class, 'show'])->name('sedes.show');
Route::put('/sedes', [SedesController::class, 'update'])->name('sedes.update');
Route::delete('/sedes', [SedesController::class, 'destroy'])->name('sedes.destroy');
