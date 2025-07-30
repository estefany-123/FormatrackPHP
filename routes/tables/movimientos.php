<?php

use App\Http\Controllers\MovimientoController;
use Illuminate\Support\Facades\Route;

Route::get('/movimientos', MovimientoController::class, 'index');
Route::get('/movimientos/{id_movimiento}');
Route::post('/movimientos');
Route::patch('/movimientos/{id_movimiento}');
Route::accept('/movimientos/accept/{id_movimiento}');
Route::cancel('/movimientos/');