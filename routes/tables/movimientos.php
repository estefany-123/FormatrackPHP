<?php

use App\Http\Controllers\MovimientosController;
use Illuminate\Support\Facades\Route;

Route::get('/movimientos', [MovimientosController::class, 'index']);
Route::get('/movimientos/{id_movimiento}', [MovimientosController::class, 'show']);
Route::post('/movimientos', [MovimientosController::class, 'store']);
Route::patch('/movimientos/{id_movimiento}', [MovimientosController::class, 'update']);
Route::patch('/movimientos/accept/{id_movimiento}', [MovimientosController::class, 'accept']);
Route::patch('/movimientos/cancel/{id_movimiento}', [MovimientosController::class, 'cancel']);