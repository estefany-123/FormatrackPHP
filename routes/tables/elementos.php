<?php

use App\Http\Controllers\ElementoController;
use Illuminate\Support\Facades\Route;

Route::get('elementos',[ElementoController::class, 'index']);
Route::get('elementos/{id_elemento}',[ElementoController::class, 'show']);
Route::post('elementos',[ElementoController::class, 'store']);
Route::patch('elementos/{id_elemento}',[ElementoController::class, 'update']);
Route::delete('elementos/state/{id_elemento}',[ElementoController::class, 'destroy']);
