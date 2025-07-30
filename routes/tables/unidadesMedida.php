<?php

use App\Http\Controllers\UnidadesMedidaController;
use Illuminate\Support\Facades\Route;

Route::get('unidades',[UnidadesMedidaController::class, 'index']);
Route::get('unidades/{id_unidad}',[UnidadesMedidaController::class, 'show']);
Route::post('unidades',[UnidadesMedidaController::class, 'store']);
Route::patch('unidades/{id_unidad}',[UnidadesMedidaController::class, 'update']);
Route::delete('unidades/state/{id_unidad}',[UnidadesMedidaController::class, 'destroy']);
