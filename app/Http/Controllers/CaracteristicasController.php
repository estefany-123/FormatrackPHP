<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaracteristicaRequest;
use App\Http\Requests\UpdateCaracteristicaRequest;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaracteristicaRequest $request)
    {
        $caracteristica = Caracteristicas::create($request->validated());
        return  response()->json($caracteristica, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $caracteristica = Caracteristicas::find($id);

        if(!$caracteristica){
            return response()->json(['message' => 'No existe la caracteristica con ese id'], 404);
        }

        return response()->json($caracteristica, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caracteristicas $caracteristicas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCaracteristicaRequest $request, $id )
    {
        $caracteristica = Caracteristicas::find($id);

        if(!$caracteristica){
            return response()->json(['message' => 'No existe la caracteristica con ese id'], 404);
        }

        $caracteristica->update($request->validated());

        return response()->json($caracteristica, 200);
    }

}
