<?php

use App\Http\Controllers\RolPermisoController;
use Illuminate\Support\Facades\Route;


Route::post('/rol-permiso', [RolPermisoController::class, 'store']);
Route::get('/rol-permiso', [RolPermisoController::class, 'index']);
Route::get('/rol-permiso/rol/${rol}/permisos', [RolPermisoController::class, 'show']);
Route::get('/rol-permiso/rol/{idrol}', [RolPermisoController::class, 'getPermisosRol']);
Route::get('/rol-permiso/{id}', [RolPermisoController::class, 'show']);
Route::put('/rol-permiso/{id}', [RolPermisoController::class, 'update']);
Route::patch('/rol-permiso/asign-permiso/{idPermiso}/{idRol}', [RolPermisoController::class, 'changeStatus']);
