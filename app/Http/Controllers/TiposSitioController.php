<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoSitio\StoreTipoSitioRequest;
use App\Http\Requests\TipoSitio\UpdateTipoSitioRequest;
use App\Models\TiposSitio;

class TiposSitioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo = TiposSitio::all();
        return response()->json($tipo,200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoSitioRequest $request)
    {
        $tipo = TiposSitio::create($request->validated());
        return response()->json($tipo,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($nombre)
    {
        $tipo = TiposSitio::where('nombre',$nombre)->first();

        if(!$tipo) {
            return response()->json(['message' => 'Tipo de sitio no encontrado'],404);
        }

        return response()->json($tipo,200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoSitioRequest $request, $id)
    {
        $tipo = TiposSitio::find($id);

        if (!$tipo) {
            return response()->json(['message' => 'Tipo de sitio no encontrado'], 404);
        }

        $tipo->update($request->validated());

        return response()->json($tipo, 200);
    }
    

    public function updateState($id)
    {
        $tipo = TiposSitio::find($id);

        if (!$tipo) {
            return response()->json(['message' => 'Tipo de sitio no encontrado '], 404);
        }

        $tipo->update(['estado' => !$tipo->estado]);

        return response()->json(['message' => 'Estado modificado exitosamente'], 200);
    }
}
