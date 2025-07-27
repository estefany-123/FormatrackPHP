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
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;



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
