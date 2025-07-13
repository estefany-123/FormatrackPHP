<?php

use App\Http\Controllers\TiposSitioController;
use Illuminate\Support\Facades\Route;

Route::get('/tipos_sitio',[TiposSitioController::class,'index']);

Route::post('/tipos_sitio',[TiposSitioController::class,'store']);

Route::get('/tipos_sitio/{nombre}',[TiposSitioController::class,'show']);

Route::put('/tipos_sitio/update/{id}',[TiposSitioController::class,'update']);

Route::patch('/tipos_sitio/estado/{id}',[TiposSitioController::class,'updateState']);


