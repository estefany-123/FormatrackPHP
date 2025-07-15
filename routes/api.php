<?php
require __DIR__ ."/tables/usuarios.php";
require __DIR__ ."/tables/centros.php";
require __DIR__ ."/tables/tipoSitio.php";
require __DIR__ ."/tables/municipios.php";
require __DIR__ ."/tables/categorias.php";
require __DIR__ ."/tables/modulos.php";
require __DIR__ ."/tables/rutas.php";
require __DIR__ ."/tables/caracteristicas.php";

use App\Http\Controllers\AreasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CodigoInventarioController;
use App\Http\Controllers\ElementoController;
use App\Http\Controllers\FichasController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\ProgramaFormacionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\SedesController;
use App\Http\Controllers\SitiosController;
use App\Http\Controllers\TiposMovimientoController;
use App\Http\Controllers\UnidadesMedidaController;
use App\Http\Controllers\UsuarioFichaController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');



//priveate route
Route::middleware(IsAdmin::class)->group(function () {
    Route::get('user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::apiResource('roles', RolesController::class);
    Route::apiResource('areas', AreasController::class);
    Route::apiResource('sedes', SedesController::class);
    Route::apiResource('sitios', SitiosController::class);
    Route::apiResource('programaF', ProgramaFormacionController::class);
    Route::apiResource('fichas', FichasController::class);
    Route::apiResource('UsuarioFichas', UsuarioFichaController::class);
    Route::apiResource('permisos', PermisosController::class);
    Route::apiResource('rol_permisos', RolPermisoController::class);
    Route::apiResource('unidades', UnidadesMedidaController::class);
    Route::apiResource('tipos', TiposMovimientoController::class);
    Route::apiResource('codigos', CodigoInventarioController::class);
    Route::apiResource('elementos', ElementoController::class);
    Route::apiResource('inventarios', InventarioController::class);
    Route::apiResource('movimientos', MovimientosController::class);
});


//rutas privadas Usuario
Route::middleware(IsUserAuth::class)->group(function () {
    Route::get('user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    //Acciones que puede realizar
});
