<?php


use App\Http\Controllers\TiposMovimientoController;
use Illuminate\Support\Facades\Route;

Route::get('tipos',[TiposMovimientoController::class, 'index']);
Route::get('tipos/{id_tipo}',[TiposMovimientoController::class, 'show']);
Route::post('tipos',[TiposMovimientoController::class, 'store']);
Route::patch('tipos/{id_tipo}',[TiposMovimientoController::class, 'update']);
Route::delete('tipos/state/{id_tipo}',[TiposMovimientoController::class, 'destroy']);
