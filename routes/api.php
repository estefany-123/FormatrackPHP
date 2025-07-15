<?php
require __DIR__ ."/tables/usuarios.php";
require __DIR__ ."/tables/centros.php";
require __DIR__ ."/tables/tipoSitio.php";
require __DIR__ ."/tables/municipios.php";
require __DIR__ ."/tables/categorias.php";
require __DIR__ ."/tables/modulos.php";
require __DIR__ ."/tables/rutas.php";
require __DIR__ ."/tables/caracteristicas.php";

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElementoController;
use App\Http\Controllers\RolesController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::apiResource('roles', RolesController::class);

//priveate route
Route::middleware(IsAdmin::class)->group(function(){
    Route::get('user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    //Acciones que puede realizar

    Route::post('/elementos', [ElementoController::class, 'store'])->name('elemento.store');
    Route::get('/elementos', [ElementoController::class, 'show'])->name('elemento.show');
    Route::put('/elementos', [ElementoController::class, 'update'])->name('elemento.update');
    Route::delete('/elementos', [ElementoController::class, 'destroy'])->name('elemento.destroy');
});


//rutas privadas Usuario
Route::middleware(IsUserAuth::class)->group(function(){
    Route::get('user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    //Acciones que puede realizar
    Route::get('/elementos', [ElementoController::class, 'show'])->name('elemento.show');
});
