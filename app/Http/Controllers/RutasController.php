<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rutas\StoreRutaRequest;
use App\Http\Requests\Rutas\UpdateRutaRequest;
use App\Models\Rutas;

class RutasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rutas = Rutas::all();
        return response()->json($rutas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRutaRequest $request)
    {
        $rutas = Rutas::create($request->validated());
        return response()->json($rutas, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($nombre)
    {
        $rutas = Rutas::where('nombre',$nombre)->first();

        if (!$rutas) {
            return response()->json(['message' => 'Ruta no encontrada'], 404);
        }

        return response()->json($rutas, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRutaRequest $request,$id)
    {
        $rutas = Rutas::find($id);

        if (!$rutas || $rutas->estado === false) {
            return response()->json(['message' => 'Ruta no encontrada o inactiva'], 404);
        }

        $rutas->update($request->validated());

        return response()->json($rutas, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateState($id)
    {
         $rutas = Rutas::find($id);

        if (!$rutas) {
            return response()->json(['message' => 'Ruta no encontrada'], 404);
        }

        $rutas->update(['estado' => !$rutas->estado]);

        return response()->json($rutas, 200);
    }
}
