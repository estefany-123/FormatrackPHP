<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolPermisoRequest;
use App\Http\Requests\UpdateRolPermisoRequest;
use App\Models\RolPermiso;
use Illuminate\Http\Request;

class RolPermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todos los registros de la tabla "areas"
        $rolpermiso = RolPermiso::all();

        // Retorna los datos en formato JSON con código HTTP 200 (OK)
        return response()->json($rolpermiso, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRolPermisoRequest $request)
    {
        // Crea una nueva área usando solo los datos validados por StoreAreaRequest
        $rolpermiso = RolPermiso::create($request->validated());

        // Retorna la nueva área creada y el código HTTP 201 (creado)
        return response()->json($rolpermiso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca el área por ID (sin relaciones si no están definidas)
        $rolpermiso = RolPermiso::find($id);

        // Si no existe o está inactiva, retorna error 404
        if (!$rolpermiso || $rolpermiso->estado === false) {
        }

        // Retorna el área encontrada en formato JSON
        return response()->json($rolpermiso, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(UpdateRolPermisoRequest $request, $id)
    {
        $rolpermiso = RolPermiso::find($id);

        if (!$rolpermiso || $rolpermiso->estado === false) {
            return response()->json(['message' => 'rolpermiso no encontrada o inactiva'], 404);
        }

        $rolpermiso->update($request->validated());

        return response()->json($rolpermiso, 200);
    }




    public function destroy($id)
    {
        $rolpermiso = RolPermiso::find($id);

        if (!$rolpermiso || $rolpermiso->estado === false) {
            return response()->json(['message' => 'rolpermiso no encontrada o ya inactiva'], 404);
        }

        $rolpermiso->update(['estado' => false]);

        return response()->json(['message' => 'rolpermiso desactivada correctamente'], 200);
    }
}
