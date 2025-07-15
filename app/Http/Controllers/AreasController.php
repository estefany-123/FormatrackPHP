<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAreaRequest; // Importa la clase que valida los datos al crear un área
use App\Http\Requests\UpdateAreaRequest; // Importa la clase que valida los datos al actualizar un área
use App\Models\Areas; // Modelo Eloquent que representa la tabla "areas"
use Illuminate\Http\Request;

class AreasController extends Controller
{
    /**
     * Mostrar todas las áreas registradas en la base de datos.
     * Método GET → /api/areas
     */
    public function index()
    {
        // Obtiene todos los registros de la tabla "areas"
        $areas = Areas::all();

        // Retorna los datos en formato JSON con código HTTP 200 (OK)
        return response()->json($areas, 200);
    }

    /**
     * Registrar una nueva área validando los datos recibidos.
     * Método POST → /api/areas
     */
    public function store(StoreAreaRequest $request)
    {
        // Crea una nueva área usando solo los datos validados por StoreAreaRequest
        $area = Areas::create($request->validated());

        // Retorna la nueva área creada y el código HTTP 201 (creado)
        return response()->json($area, 201);
    }

    /**
     * Mostrar una sola área por su ID, siempre que esté activa.
     * Método GET → /api/areas/{id}
     */
    public function show($id)
    {
        // Busca el área por ID (sin relaciones si no están definidas)
        $area = Areas::find($id);

        // Si no existe o está inactiva, retorna error 404
        if (!$area || $area->estado === false) {
            return response()->json(['message' => 'Área no encontrada o inactiva'], 404);
        }

        // Retorna el área encontrada en formato JSON
        return response()->json($area, 200);
    }

    /**
     * Actualizar un área existente con validación de datos.
     * Método PUT/PATCH → /api/areas/{id}
     */
    public function update(UpdateAreaRequest $request, $id)
    {
        // Busca el área por ID
        $area = Areas::find($id);

        // Si no existe o está inactiva, retorna error 404
        if (!$area || $area->estado === false) {
            return response()->json(['message' => 'Área no encontrada o inactiva'], 404);
        }

        // Actualiza el área con los datos validados
        $area->update($request->validated());

        // Retorna el área actualizada
        return response()->json($area, 200);
    }

    /**
     * Desactivar (cambiar el estado) de un área.
     * Método DELETE → /api/areas/{id}
     */
    public function destroy($id)
    {
        // Busca el área por ID
        $area = Areas::find($id);

        // Si no existe o ya está inactiva, retorna error 404
        if (!$area || $area->estado === false) {
            return response()->json(['message' => 'Área no encontrada o ya inactiva'], 404);
        }

        // Cambia el estado de true a false (desactiva el área)
        $area->update(['estado' => false]);

        // Retorna mensaje de confirmación
        return response()->json(['message' => 'Área desactivada correctamente'], 200);
    }
}
