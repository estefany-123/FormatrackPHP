<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermisoRequest;
use App\Http\Requests\UpdatePermisoRequest;
use App\Models\Permisos;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todos los registros de la tabla "areas"
        $permiso = Permisos::all();

        // Retorna los datos en formato JSON con código HTTP 200 (OK)
        return response()->json($permiso, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermisoRequest $request)
    {
        // Crea una nueva área usando solo los datos validados por StoreAreaRequest
        $permiso = Permisos::create($request->validated());

        // Retorna la nueva área creada y el código HTTP 201 (creado)
        return response()->json($permiso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca el área por ID (sin relaciones si no están definidas)
        $permiso = Permisos::find($id);

        // Si no existe o está inactiva, retorna error 404
        if (!$permiso || $permiso->estado === false) {
            return response()->json(['message' => 'permiso no encontrada o inactiva'], 404);
        }

        // Retorna el área encontrada en formato JSON
        return response()->json($permiso, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(UpdatePermisoRequest $request, $id)
    {
        $permiso = Permisos::find($id);

        if (!$permiso || $permiso->estado === false) {
            return response()->json(['message' => 'permiso no encontrada o inactiva'], 404);
        }

        $permiso->update($request->validated());

        return response()->json($permiso, 200);
    }




    public function destroy($id)
    {
        $permiso = Permisos::find($id);

        if (!$permiso || $permiso->estado === false) {
            return response()->json(['message' => 'permiso no encontrada o ya inactiva'], 404);
        }

        $permiso->update(['estado' => false]);

        return response()->json(['message' => 'permiso desactivada correctamente'], 200);
    }
}
