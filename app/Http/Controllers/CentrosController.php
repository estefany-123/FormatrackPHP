<?php

namespace App\Http\Controllers;

use App\Http\Requests\Centros\StoreCentroRequest;
use App\Http\Requests\Centros\UpdateCentroRequest;
use App\Models\Centros;
use Illuminate\Http\Request;

class CentrosController extends Controller
{
    public function index()
    {
        $centros = Centros::all();
        return response()->json($centros,200);
    }

    public function store(StoreCentroRequest $request)
    {
        $centro = Centros::create($request->validated());
        return response()->json($centro, 201);
    }

    public function show($nombre)
    {
        $centro = Centros::where('nombre',$nombre)->first();

        if (!$centro) {
            return response()->json(['message' => 'Centro no encontrado'], 404);
        }

        return response()->json($centro, 200);
    }

    public function update(UpdateCentroRequest $request, $id)
    {
        $centro = Centros::find($id);

        if (!$centro) {
            return response()->json(['message' => 'Centro no encontrado'], 404);
        }

        $centro->update($request->validated());

        return response()->json($centro, 200);
    }

    public function updateState($id)
    {
        $centro = Centros::find($id);

        if (!$centro ) {
            return response()->json(['message' => 'Centro no encontrado '], 404);
        }

        $centro->update(['estado' => !$centro->estado]);

        return response()->json(['message' => 'Estado modificado exitosamente'], 200);
    }
}
