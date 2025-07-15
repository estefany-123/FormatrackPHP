<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreElementoRequest;
use App\Http\Requests\UpdateElementoRequest;
use App\Models\Elementos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ElementoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // Obtiene todos los registros de la tabla "areas"
        $elemento = Elementos::all();

        // Retorna los datos en formato JSON con código HTTP 200 (OK)
        return response()->json($elemento, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreElementoRequest $request)
    {
        // Crea una nueva área usando solo los datos validados por StoreAreaRequest
        $elemento = Elementos::create($request->validated());

        // Retorna la nueva área creada y el código HTTP 201 (creado)
        return response()->json($elemento, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca el área por ID (sin relaciones si no están definidas)
        $elemento = Elementos::find($id);

        // Si no existe o está inactiva, retorna error 404
        if (!$elemento || $elemento->estado === false) {
        }

        // Retorna el área encontrada en formato JSON
        return response()->json($elemento, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateElementoRequest $request, $id)
    {
        $elemento = Elementos::find($id);

        if (!$elemento || $elemento->estado === false) {
            return response()->json(['message' => 'elemento no encontrada o inactiva'], 404);
        }

        $elemento->update($request->validated());

        return response()->json($elemento, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $elemento = Elementos::find($id);

        if (!$elemento || $elemento->estado === false) {
            return response()->json(['message' => 'elemento no encontrada o ya inactiva'], 404);
        }

        $elemento->update(['estado' => false]);

        return response()->json(['message' => 'elemento desactivada correctamente'], 200);
    }
}
