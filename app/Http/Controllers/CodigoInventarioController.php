<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCodigoInventarioRequest;
use App\Http\Requests\UpdateCodigoInventarioRequest;
use App\Models\CodigoInventario;
use Illuminate\Http\Request;

class CodigoInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $codigo = CodigoInventario::all();
        return response()->json($codigo, 200);
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
    public function store(StoreCodigoInventarioRequest $request)
    {
        $codigo = CodigoInventario::create($request->validated());
        return response()->json($codigo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $codigo = CodigoInventario::find($id);

        if(!$codigo){
            return response()->json(['message'=>'No se encuentra registrado el codigo de ese elemento en el inventario'], 404);
        }

        return response()->json($codigo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CodigoInventario $codigoInventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCodigoInventarioRequest $request, $id)
    {
        $codigos = CodigoInventario::find($id);

        if(!$codigos){
            return response()->json(['message' => 'No existe la codigos con ese id']);
        }

        $codigos->update($request->validated());

        return response()->json($codigos, 200);
    
    }
}
