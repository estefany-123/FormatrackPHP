<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFichaRequest;
use App\Http\Requests\UpdateFichaRequest;
use App\Models\Fichas;
use Illuminate\Http\Request;

class FichasController extends Controller
{
    public function index()
    {
        $fichas = Fichas::all();
        return response()->json($fichas, 200);
    }

    public function store(StoreFichaRequest $request)
    {
        $ficha = Fichas::create($request->validated());
        return response()->json($ficha, 201);
    }

    public function show($id)
    {
        $ficha = Fichas::find($id);

        if (!$ficha || $ficha->estado === false) {
            return response()->json(['message' => 'Ficha no encontrada o inactiva'], 404);
        }

        return response()->json($ficha, 200);
    }

    public function update(UpdateFichaRequest $request, $id)
    {
        $ficha = Fichas::find($id);

        if (!$ficha || $ficha->estado === false) {
            return response()->json(['message' => 'Ficha no encontrada o inactiva'], 404);
        }

        $ficha->update($request->validated());

        return response()->json($ficha, 200);
    }

    public function destroy($id)
    {
        $ficha = Fichas::find($id);

        if (!$ficha || $ficha->estado === false) {
            return response()->json(['message' => 'Ficha no encontrada o ya inactiva'], 404);
        }

        $ficha->update(['estado' => false]);

        return response()->json(['message' => 'Ficha desactivada correctamente'], 200);
    }
}
