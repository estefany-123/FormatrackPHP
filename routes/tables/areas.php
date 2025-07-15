<?php

use App\Http\Controllers\AreasController;
use Illuminate\Support\Facades\Route;


Route::post('/Areas', [AreasController::class, 'store'])->name('Areas.store');
Route::get('/Areas', [AreasController::class, 'show'])->name('Areas.show');
Route::put('/Areas', [AreasController::class, 'update'])->name('Areas.update');
Route::delete('/Areas', [AreasController::class, 'destroy'])->name('Areas.destroy');
