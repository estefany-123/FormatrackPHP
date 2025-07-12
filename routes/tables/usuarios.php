<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/usuarios',[UsersController::class,'index']);

Route::get('/usuarios/{nombre}',[UsersController::class,'show']);

Route::put('/usuarios/update/{id}',[UsersController::class,'update']);

Route::patch('/usuarios/estado/{id}',[UsersController::class,'updateState']);

