<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuarios\LoginRequest;
use App\Http\Requests\Usuarios\RegisterRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);

        try {

            if($request->hasFile('perfil')){
                $imagenPath = $request->file('perfil')->store('users','public');

                $data['perfil'] = $imagenPath;
            }
            
            $user = User::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente',
                'data'    => $user,
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            Log::error('Error al crear el usuario' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

   public function login(LoginRequest $request): JsonResponse
{
    $credentials = $request->validated();

    try {
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => 401,
                'message' => 'Credenciales inválidas'
            ], Response::HTTP_UNAUTHORIZED);
        }

         /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $idUsuario = $user->id;

        $flatData = DB::table('users as u')
            ->join('roles as r', 'u.fk_rol', '=', 'r.id_rol')
            ->join('rol_permisos as rp', 'r.id_rol', '=', 'rp.fk_rol')
            ->join('permisos as p', 'rp.fk_permiso', '=', 'p.id_permiso')
            ->join('rutas as rt', 'p.fk_ruta', '=', 'rt.id_ruta')
            ->join('modulos as m', 'rt.fk_modulo', '=', 'm.id_modulo')
            ->where('u.id', $idUsuario)
            ->where('rp.estado', true)
            ->where('rt.estado', true)
            ->where('m.estado', true)
            ->where('r.estado', true)
            ->select([
                'm.id_modulo',
                'm.nombre as modulo_nombre',
                'm.icono as modulo_icono',
                'm.href as modulo_href',
                'rt.id_ruta',
                'rt.nombre as ruta_nombre',
                'rt.href as ruta_href',
                'rt.icono as ruta_icono',
                'rt.listed as ruta_listed',
                'p.id_permiso'
            ])
            ->get();

        // Agrupar igual que en NestJS
         $grouped = [];
        foreach ($flatData as $row) {
            $moduloId = $row->id_modulo;

            if (!isset($grouped[$moduloId])) {
                $grouped[$moduloId] = [
                    'id' => $moduloId,
                    'nombre' => $row->modulo_nombre,
                    'icono' => $row->modulo_icono,
                    'href' => $row->modulo_href,
                    'rutas' => [],
                ];
            }

            $rutaId = $row->id_ruta;

            $rutaIndex = array_search($rutaId, array_column($grouped[$moduloId]['rutas'], 'id'));

            if ($rutaIndex === false) {
                $grouped[$moduloId]['rutas'][] = [
                    'id' => $rutaId,
                    'nombre' => $row->ruta_nombre,
                    'href' => $row->ruta_href,
                    'icono' => $row->ruta_icono,
                    'listed' => $row->ruta_listed,
                    'permisos' => [$row->id_permiso],
                ];
            } else {
                $grouped[$moduloId]['rutas'][$rutaIndex]['permisos'][] = $row->id_permiso;
            }
        }

        return response()->json([
            'status' => 200,
            'response' => 'Successfully logged in',
            'access_token' => $token,
            'modules' => array_values($grouped), // Igual que en NestJS
        ], Response::HTTP_OK);

    } catch (JWTException $e) {
        Log::error('Error al generar el token: ' . $e->getMessage());
        return response()->json([
            'status' => 500,
            'message' => 'Error al generar el token',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    public function getUser()
    {
        try {
            $user = auth('api')->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no registrado'
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => true,
                'message' => 'Usuario obtenido con exito',
                'data'    => $user
            ], Response::HTTP_OK);
        } catch (JWTException $e) {
            Log::error('Error obteniendo usuario' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno al obtener el usuario',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function  logout(): JsonResponse
    {
        auth('api')->logout();

        return response()->json([
            'success'  => 'logout exitoso'
        ], Response::HTTP_NO_CONTENT);
    }
}
