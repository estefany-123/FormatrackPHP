<?php

namespace App\Http\Controllers;

use App\Http\Requests\Municipios\StoreMunicipioRequest;
use App\Http\Requests\Municipios\UpdateMunicipioRequest;
use App\Models\Municipios;

class MunicipiosController extends Controller
{
    public function index()
    {
        $municipios = Municipios::all();
        return response()->json($municipios, 200);
    }

    public function store(StoreMunicipioRequest $request)
    {
        $municipio = Municipios::create($request->validated());
        return response()->json($municipio, 201);
    }

    public function show($id)
    {
        $municipio = Municipios::find($id);

        if (!$municipio || $municipio->estado === false) {
            return response()->json(['message' => 'Municipio no encontrado o inactivo'], 404);
        }

        return response()->json($municipio, 200);
    }

    public function update(UpdateMunicipioRequest $request, $id)
    {
        $municipio = Municipios::find($id);

        if (!$municipio || $municipio->estado === false) {
            return response()->json(['message' => 'Municipio no encontrado o inactivo'], 404);
        }

        $municipio->update($request->validated());

        return response()->json($municipio, 200);
    }

    public function updateState($id)
    {
        $municipio = Municipios::find($id);

        if (!$municipio) {
            return response()->json(['message' => 'Municipio no encontrado'], 404);
        }

        $municipio->update(['estado' => !$municipio->estado]);

        return response()->json($municipio, 200);
    }
}

