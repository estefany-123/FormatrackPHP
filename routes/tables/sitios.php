<?php

use App\Http\Controllers\SitiosController;
use Illuminate\Support\Facades\Route;


Route::post('/sitios', [SitiosController::class, 'store']);
Route::get('/sitios', [SitiosController::class, 'index']);
Route::get('/sitios/{id_sitio}', [SitiosController::class, 'show']);
Route::patch('/sitios/{id_sitio}', [SitiosController::class, 'update']);
Route::patch('/sitios/state/{id_sitio}', [SitiosController::class, 'updateState']);
