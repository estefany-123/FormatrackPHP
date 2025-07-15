<?php
require __DIR__ . "/tables/sedes.php";

use App\Http\Controllers\AreasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElementoController;
use App\Http\Controllers\FichasController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\ProgramaFormacionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\SedesController;
use App\Http\Controllers\SitiosController;
use App\Http\Controllers\UsuarioFichaController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::apiResource('roles', RolesController::class);
Route::apiResource('areas', AreasController::class);
Route::apiResource('sedes', SedesController::class);
Route::apiResource('sitios', SitiosController::class);
Route::apiResource('programaF', ProgramaFormacionController::class);
Route::apiResource('fichas', FichasController::class);
Route::apiResource('UsuarioFichas', UsuarioFichaController::class);
Route::apiResource('permisos', PermisosController::class);
Route::apiResource('rol_permisos', RolPermisoController::class);
Route::apiResource('elementos', ElementoController::class);

//priveate route
Route::middleware(IsAdmin::class)->group(function () {
    Route::get('user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    //Acciones que puede realizar


});


//rutas privadas Usuario
Route::middleware(IsUserAuth::class)->group(function () {
    Route::get('user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    //Acciones que puede realizar
});
