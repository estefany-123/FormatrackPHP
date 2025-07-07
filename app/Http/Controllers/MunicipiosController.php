<?php

namespace App\Http\Controllers;

use App\Models\Municipios;
use App\Http\Requests\StoreMunicipioRequest;
use App\Http\Requests\UpdateMunicipioRequest;

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

    public function destroy($id)
    {
        $municipio = Municipios::find($id);

        if (!$municipio || $municipio->estado === false) {
            return response()->json(['message' => 'Municipio no encontrado o ya inactivo'], 404);
        }

        $municipio->update(['estado' => false]);

        return response()->json(['message' => 'Municipio desactivado correctamente'], 200);
    }
}
