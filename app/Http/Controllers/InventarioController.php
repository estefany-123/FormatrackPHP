<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventarioRequest;
use App\Http\Requests\UpdateInventarioRequest;
use App\Models\Inventario;
use Dotenv\Store\StoreBuilder;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventario = Inventario::all();
        return response()->json($inventario, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventarioRequest $request)
    {
        // Crea una nueva área usando solo los datos validados por StoreAreaRequest
        $inventario = Inventario::create($request->validated());

        // Retorna la nueva área creada y el código HTTP 201 (creado)
        return response()->json($inventario, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventario = Inventario::find($id);
        
        if(!$inventario){
            return response()->json(['message' => 'No se encontro el inventario con ese id'], 404);
        }

        return response()->json($inventario, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventarioRequest $request, $id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario || $inventario->estado === false) {
            return response()->json(['message' => 'inventario no encontrado o inactiva'], 404);
        }

        $inventario->update($request->validated());

        return response()->json($inventario, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario || $inventario->estado === false) {
            return response()->json(['message' => 'inventario no encontrado o ya inactiva'], 404);
        }

        $inventario->update(['estado' => false]);

        return response()->json(['message' => 'inventario desactivado correctamente'], 200);
    }
}
