<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuarios\UpdatePerfilRequest;
use App\Http\Requests\Usuarios\UpdateUserImageRequest;
use App\Http\Requests\Usuarios\UpdateUserRequest;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;



class UsersController extends Controller
{

    public function index()
    {
        $user = User::all();
        return response()->json($user, 200);
    }

    //el store esta en auth



    public function perfil($id)
    {

        $perfil = User::select('documento', 'edad', 'nombre', 'apellido', 'telefono', 'correo', 'perfil', 'fk_rol')
            ->with(['rol' => function ($query) {
                $query->select('id_rol', 'nombre');
            }])
            ->find($id);

        if (!$perfil) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        };

        $response = [
            'documento' => $perfil->documento,
            'edad' => $perfil->edad,
            'nombre' => $perfil->nombre,
            'apellido' => $perfil->apellido,
            'telefono' => $perfil->telefono,
            'correo' => $perfil->correo,
            'perfil' => $perfil->perfil,
            'rol' => $perfil->rol ? $perfil->rol->nombre : null,
        ];

        return response()->json($response, 200);
    }


    public function updateperfil(UpdatePerfilRequest $request, $id)
    {

        $perfil = User::find($id);

        if (!$perfil) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        };

        $perfil->update($request->validated());

        return response()->json($perfil, 200);
    }


    public function up(UpdateUserImageRequest $request, $id)
    {

        try {

            $usuario = User::find($id);

            if ($request->hasFile('perfil')) {
                $imagenPath = $request->file('perfil')->store('users', 'public');

                $usuario['perfil'] = $imagenPath;

                $usuario->save($usuario);
            }

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente',
                'data'    => $usuario,
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            Log::error('Error al crear el usuario' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }




        // if (!$usuario) {
        //     return response()->json(['message' => 'Usuario no encontrado']);
        // }

        // if ($usuario->perfil) {
        //     Storage::disk('public')->delete($usuario->image);
        // }
        // $newimage = $request->file('perfil')->store('users', 'public');

        // $usuario->update([
        //     'perfil' => $newimage
        // ]);

        // return response()->json([
        //     'message' => 'Imagen actualizada correctamente',
        //     'image_path' => $newimage
        // ], 200);


    }


    public function updateImage(UpdateUserImageRequest $request, User $user): JsonResponse
    {
        try {

            if ($user->perfil) {
                Storage::disk('public')->delete($user->perfil);
            }


            $imagePath = $request->file('perfil')->store('users', 'public');

            $user->update(['perfil' => $imagePath]);
            return response()->json([
                'success' => true,
                'message' => 'Imagen actualizada exitosamente',
                'data' => [
                    'perfil' => Storage::url($imagePath),
                ],
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            Log::error('Error al actualizar la imagen del usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    { //busca uno

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->update($request->validated());

        return response()->json($user, 200);
    }

    public function updateState($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->update(['estado' => !$user->estado]);

        return response()->json(['message' => 'Estado cambiado exitosamente'], 200);
    }
}
