<?php

namespace App\Http\Controllers;

use App\Http\Requests\TiposMovimiento\StoreTipoMovimientoRequest;
use App\Http\Requests\TiposMovimiento\UpdateTipoMovimientoRequest;
use App\Models\TiposMovimientos;

class TiposMovimientoController extends Controller
{
    public function index()
    {
        $tipos = TiposMovimientos::all();
        return response()->json($tipos, 200);
    }

    public function store(StoreTipoMovimientoRequest $request)
    {
        $tipo = TiposMovimientos::create($request->validated());
        return response()->json($tipo, 201);
    }

    public function show($id)
    {
        $tipo = TiposMovimientos::find($id);

        if (!$tipo || $tipo->estado === false) {
            return response()->json(['message' => 'Tipo de movimiento no encontrado o inactivo'], 404);
        }

        return response()->json($tipo, 200);
    }

    public function update(UpdateTipoMovimientoRequest $request, $id)
    {
        $tipo = TiposMovimientos::find($id);

        if (!$tipo || $tipo->estado === false) {
            return response()->json(['message' => 'Tipo de movimiento no encontrado o inactivo'], 404);
        }

        $tipo->update($request->validated());

        return response()->json($tipo, 200);
    }

    public function destroy($id)
    {
        $tipo = TiposMovimientos::find($id);

        if (!$tipo || $tipo->estado === false) {
            $tipo->update(['estado'=>true]);
            return response()->json(['message' => 'Tipo de movimiento Activado con exito'], 200);
        }

        $tipo->update(['estado' => false]);

        return response()->json(['message' => 'Tipo de movimiento desactivado correctamente'], 200);
    }
}
