<?php

use App\Http\Controllers\RolPermisoController;
use Illuminate\Support\Facades\Route;


Route::get('/rol-permiso/rol/${rol}/permisos', [RolPermisoController::class, 'show']);
Route::put('/rol-permiso/asign-permiso/${permiso}/${rol}', [RolPermisoController::class, 'update']);
