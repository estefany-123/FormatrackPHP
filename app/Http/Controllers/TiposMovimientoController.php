<?php

namespace App\Http\Controllers;

use App\Models\TiposMovimiento;
use App\Http\Requests\StoreTipoMovimientoRequest;
use App\Http\Requests\UpdateTipoMovimientoRequest;

class TiposMovimientoController extends Controller
{
    public function index()
    {
        $tipos = TiposMovimiento::all();
        return response()->json($tipos, 200);
    }

    public function store(StoreTipoMovimientoRequest $request)
    {
        $tipo = TiposMovimiento::create($request->validated());
        return response()->json($tipo, 201);
    }

    public function show($id)
    {
        $tipo = TiposMovimiento::find($id);

        if (!$tipo || $tipo->estado === false) {
            return response()->json(['message' => 'Tipo de movimiento no encontrado o inactivo'], 404);
        }

        return response()->json($tipo, 200);
    }

    public function update(UpdateTipoMovimientoRequest $request, $id)
    {
        $tipo = TiposMovimiento::find($id);

        if (!$tipo || $tipo->estado === false) {
            return response()->json(['message' => 'Tipo de movimiento no encontrado o inactivo'], 404);
        }

        $tipo->update($request->validated());

        return response()->json($tipo, 200);
    }

    public function destroy($id)
    {
        $tipo = TiposMovimiento::find($id);

        if (!$tipo || $tipo->estado === false) {
            return response()->json(['message' => 'Tipo de movimiento no encontrado o ya inactivo'], 404);
        }

        $tipo->update(['estado' => false]);

        return response()->json(['message' => 'Tipo de movimiento desactivado correctamente'], 200);
    }
}
