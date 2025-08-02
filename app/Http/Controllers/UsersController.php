<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuarios\UpdateFotoRequest;
use App\Http\Requests\Usuarios\UpdatePerfilRequest;
use App\Http\Requests\Usuarios\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class UsersController extends Controller
{

    public function index()
    {
        $user = User::all();
        return response()->json($user, 200);
    }

    public function perfilInfo()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            $perfilinfo = User::find($user->id);

            return response()->json([
                'documento' => $perfilinfo->documento,
                'edad' => $perfilinfo->edad,
                'nombre' => $perfilinfo->nombre,
                'apellido' => $perfilinfo->apellido,
                'telefono' => $perfilinfo->telefono,
                'correo' => $perfilinfo->correo,
                'perfil' => $perfilinfo->perfil,
                'rol' => $perfilinfo->rol ? $perfilinfo->rol->nombre : null,

            ], 200);
        } catch (JWTException $e) {

            return response()->json(['error' => 'Token inválido o expirado'], 401);
        }
    }


    public function updateFoto(UpdateFotoRequest $request)
    {

        try {
            /** @var User $user */
            $user = Auth::user();

            if ($user->perfil && $user->perfil !== 'defaultPerfil.png') {
                Storage::disk('public')->delete($user->perfil);
            }

            $imagenPath = $request->file('perfil')->store('users', 'public');

            $user->perfil = $imagenPath;
            $user->update();

            return response()->json([
                'success' => true,
                'message' => 'Foto de perfil actualizada exitosamente',
                'data' => [
                    'perfil' => $imagenPath,
                ],
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la foto de perfil',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function updateperfil(UpdatePerfilRequest $request)
    {

        try {

            /** @var \App\Models\User $perfil */
            $perfil = Auth::user();

            if (!$perfil) {
                return response()->json(['message' => 'Usuario no autenticado'], 401);
            }

            $data = $request->validated();

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']); 
            }



            $perfil->update($data);

            return response()->json($perfil, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar perfil',
                'error' => $e->getMessage(),
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




    public function massiveUpload(Request $request)
    {

        $request->validate([
            'excel' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('excel');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            $newUsersList = [];
            $errors = [];


            foreach (array_slice($data, 1) as $index => $row) {
                $documento = trim($row['A'] ?? '');
                $nombre = trim($row['B'] ?? '');
                $apellido = trim($row['C'] ?? '');


                if (empty($documento) && empty($nombre) && empty($apellido)) {
                    continue;
                }


                if (empty($documento) || empty($nombre) || empty($apellido)) {
                    $errors["missing_data"] = "Algunos usuarios tienen datos incompletos";
                    continue;
                }


                $documento = intval($documento);


                if (User::where('documento', $documento)->exists()) {
                    $errors["duplicated"] = "Algunos de los documentos ya existen";
                    continue;
                }


                $userPass = substr($nombre, 0, 1) . substr($apellido, 0, 1) . $documento;
                $passwordHash = Hash::make($userPass);


                $createdUser = User::create([
                    'documento' => $documento,
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'password' => $passwordHash,
                    'fk_rol' => 2,
                    'estado' => true,
                ]);

                $newUsersList[] = $createdUser;
            }

            if (!empty($errors)) {
                return response()->json([
                    'msg' => $errors,
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'msg' => 'Usuarios registrados exitosamente',
                'newUsers' => $newUsersList,
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            Log::error('Error en carga masiva: ' . $e->getMessage() . ' | Datos: ' . json_encode($row ?? []));
            return response()->json([
                'msg' => 'Error al procesar el archivo Excel',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
