<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCentroRequest;
use App\Http\Requests\UpdateCentroRequest;
use App\Models\Centros;
use Illuminate\Http\Request;

class CentrosController extends Controller
{
    public function index()
    {
        $centros = Centros::with('municipio')->get();
        return response()->json($centros, 200);
    }

    public function store(StoreCentroRequest $request)
    {
        $centro = Centros::create($request->validated());
        return response()->json($centro, 201);
    }

    public function show($id)
    {
        $centro = Centros::with('municipio')->find($id);

        if (!$centro || $centro->estado === false) {
            return response()->json(['message' => 'Centro no encontrado o inactivo'], 404);
        }

        return response()->json($centro, 200);
    }

    public function update(UpdateCentroRequest $request, $id)
    {
        $centro = Centros::find($id);

        if (!$centro || $centro->estado === false) {
            return response()->json(['message' => 'Centro no encontrado o inactivo'], 404);
        }

        $centro->update($request->validated());

        return response()->json($centro, 200);
    }

    public function destroy($id)
    {
        $centro = Centros::find($id);

        if (!$centro || $centro->estado === false) {
            return response()->json(['message' => 'Centro no encontrado o ya inactivo'], 404);
        }

        $centro->update(['estado' => false]);

        return response()->json(['message' => 'Centro desactivado correctamente'], 200);
    }
}
