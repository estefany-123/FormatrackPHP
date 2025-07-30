<?php
require __DIR__ ."/tables/usuarios.php";
require __DIR__ ."/tables/centros.php";
require __DIR__ ."/tables/tipoSitio.php";
require __DIR__ ."/tables/municipios.php";
require __DIR__ ."/tables/categorias.php";
require __DIR__ ."/tables/modulos.php";
require __DIR__ ."/tables/rutas.php";
require __DIR__ ."/tables/caracteristicas.php";
require __DIR__ ."/tables/tipoMovimiento.php";
require __DIR__ ."/tables/unidadesMedida.php";
require __DIR__ ."/tables/codigos.php";
require __DIR__ ."/tables/roles.php";
require __DIR__ ."/tables/elementos.php";
require __DIR__ ."/tables/inventario.php";

use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Support\Facades\Route;


Route::post('/usuarios', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');



//priveate route
Route::middleware(IsAdmin::class)->group(function () {
    Route::get('user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');


});


//rutas privadas Usuario
Route::middleware(IsUserAuth::class)->group(function () {
    Route::get('user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    //Acciones que puede realizar
});
