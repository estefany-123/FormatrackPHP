<?php

use App\Http\Controllers\CentrosController;
use Illuminate\Support\Facades\Route;


Route::get('/centros',[CentrosController::class,'index']);

Route::post('/centros',[CentrosController::class,'store']);

Route::get('/centros/{nombre}',[CentrosController::class,'show']);

Route::put('/centros/update/{id}',[CentrosController::class,'update']);

Route::patch('/centros/estado/{id}',[CentrosController::class,'updateState']);

