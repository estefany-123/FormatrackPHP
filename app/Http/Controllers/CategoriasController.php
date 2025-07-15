<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categorias\StoreCategoriaRequest;
use App\Http\Requests\Categorias\UpdateCategoriaRequest;
use App\Models\Categorias;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categorias::all();
        return response()->json($categorias, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        $categorias = Categorias::create($request->validated());
        return response()->json($categorias, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($nombre)
    {
        $categorias = Categorias::where('nombre',$nombre)->first();

        if (!$categorias) {
            return response()->json(['message' => 'Categoria no encontrada'], 404);
        }

        return response()->json($categorias, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, $id)
    {
        $categorias = Categorias::find($id);

        if (!$categorias || $categorias->estado === false) {
            return response()->json(['message' => 'Municipio no encontrado o inactivo'], 404);
        }

        $categorias->update($request->validated());

        return response()->json($categorias, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateState($id)
    {
        $categorias = Categorias::find($id);

        if (!$categorias) {
            return response()->json(['message' => 'Categoria no encontrada'], 404);
        }

        $categorias->update(['estado' => !$categorias->estado]);

        return response()->json($categorias, 200);
    }
}
