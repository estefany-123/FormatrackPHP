<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unidades\StoreUnidadMedidaRequest;
use App\Http\Requests\Unidades\UpdateUnidadMedidaRequest;
use App\Models\UnidadesMedida;

class UnidadesMedidaController extends Controller
{
    public function index()
    {
        $unidades = UnidadesMedida::all();
        return response()->json($unidades, 200);
    }

    public function store(StoreUnidadMedidaRequest $request)
    {
        $unidad = UnidadesMedida::create($request->validated());
        return response()->json($unidad, 201);
    }

    public function show($id)
    {
        $unidad = UnidadesMedida::find($id);

        if (!$unidad || $unidad->estado === false) {
            return response()->json(['message' => 'Unidad no encontrada o inactiva'], 404);
        }

        return response()->json($unidad, 200);
    }

    public function update(UpdateUnidadMedidaRequest $request, $id)
    {
        $unidad = UnidadesMedida::find($id);

        if (!$unidad || $unidad->estado === false) {
            return response()->json(['message' => 'Unidad no encontrada o inactiva'], 404);
        }

        $unidad->update($request->validated());

        return response()->json($unidad, 200);
    }

    public function destroy($id)
    {
        $unidad = UnidadesMedida::find($id);

        if (!$unidad || $unidad->estado === false) {
            $unidad->update(['estado' => true]);
            return response()->json(['message' => 'Unidad Activada con Exito'], 200);
        }

        $unidad->update(['estado' => false]);

        return response()->json(['message' => 'Unidad desactivada correctamente'], 200);
    }
}
