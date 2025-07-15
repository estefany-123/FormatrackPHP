<?php

namespace App\Http\Controllers;

use App\Http\Requests\Caracteristicas\StoreCaracteristicaRequest;
use App\Http\Requests\Caracteristicas\UpdateCaracteristicaRequest;
use App\Models\Caracteristicas;
use Illuminate\Http\Request;

class CaracteristicasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caracteristicas = Caracteristicas::all();
        return response()->json($caracteristicas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaracteristicaRequest $request)
    {
        $caracteristicas = Caracteristicas::create($request->validated());
        return response()->json($caracteristicas, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($nombre)
    {
        $caracteristicas = Caracteristicas::where('nombre',$nombre)->first();

        if (!$caracteristicas) {
            return response()->json(['message' => 'Caracteristica no encontrada'], 404);
        }

        return response()->json($caracteristicas, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCaracteristicaRequest $request, $id)
    {
        $caracteristicas = Caracteristicas::find($id);

        if (!$caracteristicas || $caracteristicas->estado === false) {
            return response()->json(['message' => 'Caracteristica no encontrado o inactivo'], 404);
        }

        $caracteristicas->update($request->validated());

        return response()->json($caracteristicas, 200);
    }

    
}
