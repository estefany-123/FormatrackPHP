<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);

        try {
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
                    'success' => false,
                    'message' => 'Credenciales invalidas'
                ], Response::HTTP_UNAUTHORIZED);
            }
            return response()->json([
                'success' => true,
                'message' => 'Autenticacion exitosa',
                'data'    => [
                    'access_token'  => true,
                    'token_type'    => $token,
                    'expired_in'    => JWTAuth::factory()->getTTL() * 60
                ]
            ], Response::HTTP_OK);
        } catch (JWTException $e) {
            Log::error('Error al generar el token' . $e->getMessage());
            return response()->json([
                'success' => false,
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
