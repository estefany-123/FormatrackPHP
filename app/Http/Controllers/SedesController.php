<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSedeRequest;
use App\Http\Requests\UpdateSedeRequest;
use App\Models\Sedes;
use Illuminate\Http\Request;

class SedesController extends Controller
{
    public function index()
    {
        $sedes = Sedes::with('centro')->get();
        return response()->json($sedes, 200);
    }

    public function store(StoreSedeRequest $request)
    {
        $sede = Sedes::create($request->validated());
        return response()->json($sede, 201);
    }

    public function show($id)
    {
        $sede = Sedes::with('centro')->find($id);

        if (!$sede || $sede->estado === false) {
            return response()->json(['message' => 'Sede no encontrada o inactiva'], 404);
        }

        return response()->json($sede, 200);
    }

    public function update(UpdateSedeRequest $request, $id)
    {
        $sede = Sedes::find($id);

        if (!$sede || $sede->estado === false) {
            return response()->json(['message' => 'Sede no encontrada o inactiva'], 404);
        }

        $sede->update($request->validated());

        return response()->json($sede, 200);
    }

    public function destroy($id)
    {
        $sede = Sedes::find($id);

        if (!$sede || $sede->estado === false) {
            return response()->json(['message' => 'Sede no encontrada o ya inactiva'], 404);
        }

        $sede->update(['estado' => false]);

        return response()->json(['message' => 'Sede desactivada correctamente'], 200);
    }
}
