<?php

namespace App\Http\Controllers;

use App\Http\Requests\Modulos\StoreModuloRequest;
use App\Http\Requests\Modulos\UpdateModuloRequest;
use App\Models\Modulo;
use App\Models\Modulos;
use Illuminate\Http\Request;

class ModulosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $modulos = Modulos::all();
        return response()->json($modulos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModuloRequest $request)
    {
        $modulos = Modulos::create($request->validated());
        return response()->json($modulos, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $modulo = Modulos::find($id);

        if (!$modulo) {
            return response()->json(['message' => 'Modulo no encontrado'], 404);
        }

        return response()->json($modulo, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModuloRequest $request,$id)
    {
        $modulos = Modulos::find($id);

        if (!$modulos ) {
            return response()->json(['message' => 'Modulo no encontrado'], 404);
        }

        $modulos->update($request->validated());

        return response()->json($modulos, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateState($id)
    {
        $modulos = Modulos::find($id);

        if (!$modulos) {
            return response()->json(['message' => 'Modulo no encontrado'], 404);
        }

        $modulos->update(['estado' => !$modulos->estado]);

        return response()->json($modulos, 200);
    }
}
