<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramaRequest;
use App\Http\Requests\UpdateProgramaRequest;
use App\Models\ProgramaFormacion;
use Illuminate\Http\Request;

class ProgramaFormacionController extends Controller
{
    public function index()
    {
        $programas = ProgramaFormacion::all();
        return response()->json($programas, 200);
    }

    public function store(StoreProgramaRequest $request)
    {
        $programa = ProgramaFormacion::create($request->validated());
        return response()->json($programa, 201);
    }

    public function show($id)
    {
        $programa = ProgramaFormacion::find($id);

        if (!$programa || $programa->estado === false) {
            return response()->json(['message' => 'Programa no encontrado o inactivo'], 404);
        }

        return response()->json($programa, 200);
    }

    public function update(UpdateProgramaRequest $request, $id)
    {
        $programa = ProgramaFormacion::find($id);

        if (!$programa || $programa->estado === false) {
            return response()->json(['message' => 'Programa no encontrado o inactivo'], 404);
        }

        $programa->update($request->validated());

        return response()->json($programa, 200);
    }

    public function destroy($id)
    {
        $programa = ProgramaFormacion::find($id);

        if (!$programa || $programa->estado === false) {
            return response()->json(['message' => 'Programa no encontrado o ya inactivo'], 404);
        }

        $programa->update(['estado' => false]);

        return response()->json(['message' => 'Programa desactivado correctamente'], 200);
    }
}
