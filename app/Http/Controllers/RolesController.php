<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Http\Requests\StoreRolRequest;
use App\Http\Requests\UpdateRolRequest;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        return response()->json($roles, 200);
    }
    public function store(StoreRolRequest $request)
    {
        $rol = Roles::create($request->validated());
        return response()->json($rol, 201);
    }

    public function show($id)
    {
        $rol = Roles::find($id);

        if (!$rol || $rol->estado === false) {
            return response()->json(['message' => 'Rol no encontrado o inactivo'], 404);
        }

        return response()->json($rol, 200);
    }

    public function update(UpdateRolRequest $request, $id)
    {
        $rol = Roles::find($id);

        if (!$rol || $rol->estado === false) {
            return response()->json(['message' => 'Rol no encontrado o inactivo'], 404);
        }

        $rol->update($request->validated());

        return response()->json($rol, 200);
    }

    public function destroy($id)
    {
        $rol = Roles::find($id);

        if (!$rol || $rol->estado === false) {
            return response()->json(['message' => 'Rol no encontrado o ya inactivo'], 404);
        }

        $rol->update(['estado' => false]);

        return response()->json(['message' => 'Rol desactivado correctamente'], 200);
    }
}
