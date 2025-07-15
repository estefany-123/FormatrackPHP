<?php

use App\Http\Controllers\CategoriasController;
use Illuminate\Support\Facades\Route;


Route::get('/categorias',[CategoriasController::class,'index']);

Route::post('/categorias',[CategoriasController::class,'store']);

Route::get('/categorias/{nombre}',[CategoriasController::class,'show']);

Route::patch('/categorias/update/{id}',[CategoriasController::class,'update']);

Route::patch('/categorias/estado/{id}',[CategoriasController::class,'updateState']);

