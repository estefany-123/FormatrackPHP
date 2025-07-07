<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use App\Models\Areas;
use Illuminate\Http\Request;

class AreasController extends Controller
{
      public function index()
    {
        $areas = Areas::all();
        return response()->json($areas, 200);
    }

    public function store(StoreAreaRequest $request)
    {
        $area = Areas::create($request->validated());
        return response()->json($area, 201);
    }

    public function show($id)
    {
        $area = Areas::with(['id_area'])->find($id);

        if (!$area || $area->estado === false) {
            return response()->json(['message' => 'Área no encontrada o inactiva'], 404);
        }

        return response()->json($area, 200);
    }

    public function update(UpdateAreaRequest $request, $id)
    {
        $area = Areas::find($id);

        if (!$area || $area->estado === false) {
            return response()->json(['message' => 'Área no encontrada o inactiva'], 404);
        }

        $area->update($request->validated());

        return response()->json($area, 200);
    }

    public function destroy($id)
    {
        $area = Areas::find($id);

        if (!$area || $area->estado === false) {
            return response()->json(['message' => 'Área no encontrada o ya inactiva'], 404);
        }

        $area->update(['estado' => false]);

        return response()->json(['message' => 'Área desactivada correctamente'], 200);
    }
}
